<?php
/**
 * Animazioni d'ingresso di titoli e testi.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Valore del sito, poi della pagina, poi del singolo blocco.
 */
final class Animazioni {

	public const META    = 'refe_animazione';
	public const BLOCCHI = array( 'core/heading', 'core/paragraph', 'core/post-title', 'core/post-excerpt', 'core/query-title' );

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
		add_filter( 'register_block_type_args', array( self::class, 'attributo' ), 10, 2 );
		add_filter( 'render_block', array( self::class, 'segna' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( self::class, 'carica' ) );
		add_filter( 'script_module_data_refe-core/animazioni', array( self::class, 'dati' ) );
	}

	/**
	 * Tipi di ingresso.
	 */
	public static function tipi(): array {
		return array(
			'nessuna'     => __( 'Nessuna', 'refe-core' ),
			'sfocato'     => __( 'Sfocato, parola per parola', 'refe-core' ),
			'dal-basso'   => __( 'Dal basso', 'refe-core' ),
			'dissolvenza' => __( 'Dissolvenza', 'refe-core' ),
		);
	}

	/**
	 * Schema di una regolazione.
	 */
	private static function schema(): array {
		return array(
			'type'                 => 'object',
			'additionalProperties' => false,
			'properties'           => array(
				'tipo'    => array(
					'type' => 'string',
					'enum' => array_merge( array( '' ), array_keys( self::tipi() ) ),
				),
				'durata'  => array(
					'type'    => 'integer',
					'minimum' => 0,
					'maximum' => 5000,
				),
				'ritardo' => array(
					'type'    => 'integer',
					'minimum' => 0,
					'maximum' => 5000,
				),
				'ripeti'  => array(
					'type' => 'string',
					'enum' => array( '', 'si', 'no' ),
				),
			),
		);
	}

	/**
	 * Regolazione della pagina.
	 */
	public static function registra(): void {
		foreach ( array( 'page', 'post', Contenuti::CASE ) as $tipo ) {
			register_post_meta(
				$tipo,
				self::META,
				array(
					'type'              => 'object',
					'single'            => true,
					'default'           => array(),
					'show_in_rest'      => array( 'schema' => self::schema() ),
					'sanitize_callback' => array( self::class, 'pulisci' ),
					'auth_callback'     => static fn( $ok, $chiave, $id ) => current_user_can( 'edit_post', $id ),
				)
			);
		}
	}

	/**
	 * Pulisce una regolazione.
	 *
	 * @param mixed $valore Valore.
	 */
	public static function pulisci( mixed $valore ): array {
		$v     = is_array( $valore ) ? $valore : array();
		$esito = array();
		if ( isset( $v['tipo'] ) && array_key_exists( (string) $v['tipo'], self::tipi() ) ) {
			$esito['tipo'] = (string) $v['tipo'];
		}
		foreach ( array( 'durata', 'ritardo' ) as $k ) {
			if ( isset( $v[ $k ] ) && is_numeric( $v[ $k ] ) ) {
				$esito[ $k ] = min( 5000, absint( $v[ $k ] ) );
			}
		}
		if ( isset( $v['ripeti'] ) && in_array( $v['ripeti'], array( 'si', 'no' ), true ) ) {
			$esito['ripeti'] = $v['ripeti'];
		}
		return $esito;
	}

	/**
	 * Aggiunge l'attributo ai blocchi di testo.
	 *
	 * @param array  $arg  Argomenti.
	 * @param string $nome Blocco.
	 */
	public static function attributo( array $arg, string $nome ): array {
		if ( in_array( $nome, self::BLOCCHI, true ) ) {
			$arg['attributes']['refeAnimazione'] = array( 'type' => 'object' );
		}
		return $arg;
	}

	/**
	 * Porta la regolazione del blocco nell'HTML.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function segna( string $html, array $blocco ): string {
		if ( empty( $blocco['attrs']['refeAnimazione'] ) || ! in_array( $blocco['blockName'], self::BLOCCHI, true ) ) {
			return $html;
		}
		$regola = self::pulisci( $blocco['attrs']['refeAnimazione'] );
		$tag    = new \WP_HTML_Tag_Processor( $html );
		if ( $regola && $tag->next_tag() ) {
			$tag->set_attribute( 'data-refe-regola', (string) wp_json_encode( $regola ) );
		}
		return $tag->get_updated_html();
	}

	/**
	 * Carica modulo e stile.
	 */
	public static function carica(): void {
		wp_enqueue_style( 'refe-animazioni', REFE_CORE_URL . 'assets/css/animazioni.css', array(), Blocchi::versione( 'assets/css/animazioni.css' ) );
		wp_style_add_data( 'refe-animazioni', 'path', REFE_CORE_DIR . 'assets/css/animazioni.css' );
		wp_enqueue_script_module( Blocchi::modulo( 'animazioni' ) );
	}

	/**
	 * Regole per il modulo.
	 *
	 * @param array $dati Dati.
	 */
	public static function dati( array $dati ): array {
		$sito   = Impostazioni::tutte()['animazioni'];
		$pagina = is_singular() ? self::pulisci( get_post_meta( get_queried_object_id(), self::META, true ) ) : array();
		$dati  += array(
			'titoli' => array(
				'tipo'    => $sito['titoli'],
				'durata'  => $sito['durata'],
				'ritardo' => $sito['ritardo'],
				'ripeti'  => $sito['ripeti'],
			),
			'testi'  => array(
				'tipo'    => $sito['testi'],
				'durata'  => $sito['durata'],
				'ritardo' => 200,
				'ripeti'  => $sito['ripeti'],
			),
		);
		if ( isset( $pagina['ripeti'] ) ) {
			$pagina['ripeti'] = 'si' === $pagina['ripeti'];
		}
		$dati['titoli'] = array_merge( $dati['titoli'], $pagina );
		unset( $pagina['ritardo'] );
		// «Sfocato» vale per i titoli: nei testi la pagina può solo spegnere o cambiare l'ingresso semplice.
		if ( 'sfocato' === ( $pagina['tipo'] ?? '' ) ) {
			unset( $pagina['tipo'] );
		}
		$dati['testi'] = array_merge( $dati['testi'], $pagina );
		return $dati;
	}
}
