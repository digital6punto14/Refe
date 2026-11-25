<?php
/**
 * Sorgenti Block Bindings.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Dati aziendali, campi ACF e dati del contenuto nei blocchi core.
 */
final class Collegamenti {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
		add_filter( 'render_block_core/button', array( self::class, 'pulsante' ), 10, 2 );
	}

	/**
	 * Registra le sorgenti.
	 */
	public static function registra(): void {
		register_block_bindings_source(
			'refe/azienda',
			array(
				'label'              => __( 'Dati aziendali', 'refe-core' ),
				'get_value_callback' => array( self::class, 'azienda' ),
			)
		);
		register_block_bindings_source(
			'refe/campo',
			array(
				'label'              => __( 'Campi del contenuto', 'refe-core' ),
				'get_value_callback' => array( self::class, 'campo' ),
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);
		register_block_bindings_source(
			'refe/contenuto',
			array(
				'label'              => __( 'Dati del contenuto', 'refe-core' ),
				'get_value_callback' => array( self::class, 'contenuto' ),
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);
	}

	/**
	 * Valore di un dato aziendale.
	 *
	 * @param array     $arg       Argomenti: campo.
	 * @param \WP_Block $blocco    Blocco.
	 * @param string    $attributo Attributo collegato.
	 */
	public static function azienda( array $arg, \WP_Block $blocco, string $attributo ): ?string {
		$dati = self::dati_azienda();
		$voce = $dati[ $arg['campo'] ?? '' ] ?? null;
		if ( null === $voce ) {
			return null;
		}
		if ( 'url' === $attributo ) {
			return '' !== $voce['url'] ? esc_url( $voce['url'] ) : null;
		}
		// Nei paragrafi il recapito è già un link; nei pulsanti l'indirizzo si collega a parte.
		return 'content' === $attributo && '' !== $voce['url'] && 'core/button' !== $blocco->name
			? sprintf( '<a href="%s">%s</a>', esc_url( $voce['url'] ), $voce['html'] )
			: $voce['html'];
	}

	/**
	 * Tutti i dati aziendali, con il loro indirizzo.
	 *
	 * @return array<string,array{etichetta:string,html:string,url:string}>
	 */
	public static function dati_azienda(): array {
		$a    = Impostazioni::tutte()['azienda'];
		$e    = array_map( 'esc_html', $a );
		$tel  = preg_replace( '/[^0-9+]/', '', $a['telefono'] );
		$tel  = $tel && ! str_starts_with( $tel, '+' ) ? '+39' . $tel : $tel;
		$voce = static fn( string $etichetta, string $html, string $url = '' ): array => compact( 'etichetta', 'html', 'url' );
		return array(
			'nome'               => $voce( __( 'Ragione sociale', 'refe-core' ), $e['nome'] ),
			'piva'               => $voce( __( 'Partita IVA', 'refe-core' ), $e['piva'] ),
			'indirizzo'          => $voce( __( 'Indirizzo', 'refe-core' ), "{$e['indirizzo']}<br>{$e['cap']} {$e['citta']} {$e['provincia']}", $a['mappa'] ),
			'indirizzo_compatto' => $voce( __( 'Indirizzo, a capo dopo la via', 'refe-core' ), str_replace( ', ', ',<br>', $e['indirizzo'] ) . ", {$e['cap']} {$e['citta']} {$e['provincia']}", $a['mappa'] ),
			'telefono'           => $voce( __( 'Telefono', 'refe-core' ), $e['telefono'], $tel ? 'tel:' . $tel : '' ),
			'email'              => $voce( __( 'Email', 'refe-core' ), $e['email'], $a['email'] ? 'mailto:' . $a['email'] : '' ),
			'instagram'          => $voce( __( 'Instagram', 'refe-core' ), 'Instagram', $a['instagram'] ),
			'linkedin'           => $voce( __( 'LinkedIn', 'refe-core' ), 'LinkedIn', $a['linkedin'] ),
			'mappa'              => $voce( __( 'Link alla mappa', 'refe-core' ), __( 'Apri la mappa', 'refe-core' ), $a['mappa'] ),
			/* translators: 1: ragione sociale, 2: anno, 3: partita IVA. */
			'copyright'          => $voce( __( 'Riga di copyright', 'refe-core' ), sprintf( __( '© %1$s %2$s · P. IVA %3$s', 'refe-core' ), $e['nome'], wp_date( 'Y' ), $e['piva'] ) ),
		);
	}

	/**
	 * Campi collegabili.
	 *
	 * @return array<string,string>
	 */
	public static function campi(): array {
		return array(
			'ambito'             => __( 'Ambito del progetto', 'refe-core' ),
			'link_url'           => __( 'Link esterno', 'refe-core' ),
			'link_testo'         => __( 'Testo del link esterno', 'refe-core' ),
			'risultato_1_numero' => __( 'Risultato 1: numero', 'refe-core' ),
			'risultato_1_testo'  => __( 'Risultato 1: testo', 'refe-core' ),
			'risultato_2_numero' => __( 'Risultato 2: numero', 'refe-core' ),
			'risultato_2_testo'  => __( 'Risultato 2: testo', 'refe-core' ),
			'risultato_3_numero' => __( 'Risultato 3: numero', 'refe-core' ),
			'risultato_3_testo'  => __( 'Risultato 3: testo', 'refe-core' ),
			'ruolo'              => __( 'Ruolo', 'refe-core' ),
			'citazione'          => __( 'Citazione', 'refe-core' ),
		);
	}

	/**
	 * Valore di un campo ACF del contenuto.
	 *
	 * @param array     $arg       Argomenti: campo.
	 * @param \WP_Block $blocco    Blocco.
	 * @param string    $attributo Attributo collegato.
	 */
	public static function campo( array $arg, \WP_Block $blocco, string $attributo ): ?string {
		$nome = $arg['campo'] ?? '';
		$id   = (int) ( $blocco->context['postId'] ?? get_the_ID() );
		if ( ! $id || ! isset( self::campi()[ $nome ] ) ) {
			return null;
		}
		if ( ! is_post_publicly_viewable( $id ) && ! current_user_can( 'read_post', $id ) ) {
			return null;
		}
		$valore = Campi::testo( $nome, $id );
		return 'url' === $attributo ? esc_url( $valore ) : esc_html( $valore );
	}

	/**
	 * Un pulsante legato a un campo vuoto non si mostra; un indirizzo email non apre una scheda nuova.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function pulsante( string $html, array $blocco ): string {
		if ( 'refe/campo' !== ( $blocco['attrs']['metadata']['bindings']['url']['source'] ?? '' ) ) {
			return $html;
		}
		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( ! $tag->next_tag( 'A' ) ) {
			return $html;
		}
		$url = (string) $tag->get_attribute( 'href' );
		if ( '' === trim( $url ) || '#' === $url ) {
			return '';
		}
		if ( str_starts_with( $url, 'mailto:' ) ) {
			$tag->remove_attribute( 'target' );
		}
		return $tag->get_updated_html();
	}

	/**
	 * Tipo e categoria del contenuto, per gli elenchi e la ricerca.
	 *
	 * @param array     $arg    Argomenti: campo.
	 * @param \WP_Block $blocco Blocco.
	 */
	public static function contenuto( array $arg, \WP_Block $blocco ): ?string {
		$id = (int) ( $blocco->context['postId'] ?? get_the_ID() );
		return match ( $arg['campo'] ?? '' ) {
			'tipo'      => esc_html( self::tipo( $id ) ),
			'categoria' => esc_html( Contenuti::termini( $id, 'category' )[0]->name ?? '' ),
			'soluzioni' => esc_html( implode( ', ', wp_list_pluck( Contenuti::termini( $id, Contenuti::SOLUZIONE ), 'name' ) ) ),
			default     => null,
		};
	}

	/**
	 * Nome del tipo di contenuto.
	 *
	 * @param int $id Contenuto.
	 */
	public static function tipo( int $id ): string {
		$tipo = get_post_type( $id );
		return 'post' === $tipo ? __( 'News', 'refe-core' ) : ( get_post_type_object( (string) $tipo )->labels->singular_name ?? '' );
	}
}
