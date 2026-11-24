<?php
/**
 * Contenuti segnaposto.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Si vedono sul sito, ma restano fuori dalla REST pubblica. Elenco di quelli da riempire in Impostazioni sito.
 */
final class Segnaposto {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		foreach ( array( Contenuti::TESTIMONIANZA, Contenuti::PERSONA ) as $tipo ) {
			add_filter( "rest_{$tipo}_query", array( self::class, 'escludi' ) );
			add_filter( "rest_prepare_{$tipo}", array( self::class, 'nascondi' ), 10, 2 );
		}
		add_filter( 'rest_prepare_' . Contenuti::CASE, array( self::class, 'togli_risultati' ), 20, 2 );
	}

	/**
	 * Vero se la scheda è un segnaposto.
	 *
	 * @param int $id Contenuto.
	 */
	public static function e( int $id ): bool {
		return (bool) Campi::leggi( 'segnaposto', $id );
	}

	/**
	 * Toglie i segnaposto dagli elenchi REST di chi non modifica il sito.
	 *
	 * @param array $query Query.
	 */
	public static function escludi( array $query ): array {
		if ( ! current_user_can( 'edit_posts' ) ) {
			$query['meta_query'][] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'relation' => 'OR',
				array(
					'key'     => 'segnaposto',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'segnaposto',
					'value'   => '1',
					'compare' => '!=',
				),
			);
		}
		return $query;
	}

	/**
	 * Una scheda segnaposto richiesta da sola non si legge.
	 *
	 * @param \WP_REST_Response $risposta Risposta.
	 * @param \WP_Post          $post     Contenuto.
	 */
	public static function nascondi( \WP_REST_Response $risposta, \WP_Post $post ): \WP_REST_Response {
		return ! current_user_can( 'edit_posts' ) && self::e( $post->ID ) ? new \WP_REST_Response( null, 404 ) : $risposta;
	}

	/**
	 * I risultati segnaposto di un case study non escono dalla REST pubblica.
	 *
	 * @param \WP_REST_Response $risposta Risposta.
	 * @param \WP_Post          $post     Contenuto.
	 */
	public static function togli_risultati( \WP_REST_Response $risposta, \WP_Post $post ): \WP_REST_Response {
		if ( ! current_user_can( 'edit_posts' ) && self::e( $post->ID ) && is_array( $risposta->data['acf'] ?? null ) ) {
			$risposta->data['acf'] = array_filter( $risposta->data['acf'], static fn( $k ) => ! str_starts_with( (string) $k, 'risultato_' ), ARRAY_FILTER_USE_KEY );
		}
		return $risposta;
	}

	/**
	 * Segnaposto ancora da riempire.
	 *
	 * @return array<int,array{titolo:string,dove:string,link:string}>
	 */
	public static function elenco(): array {
		$voci = array();
		foreach ( get_posts(
			array(
				'post_type'   => array( Contenuti::CASE, Contenuti::TESTIMONIANZA, Contenuti::PERSONA ),
				'post_status' => 'any',
				'numberposts' => -1,
				'meta_key'    => 'segnaposto', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => '1', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		) as $post ) {
			$voci[] = array(
				'titolo' => get_the_title( $post ),
				'dove'   => Contenuti::CASE === $post->post_type ? __( 'Risultati del case study', 'refe-core' ) : Collegamenti::tipo( $post->ID ),
				'link'   => (string) get_edit_post_link( $post->ID, 'raw' ),
			);
		}
		foreach ( get_posts(
			array(
				'post_type'   => array( 'page', 'post', 'wp_block', Contenuti::CASE ),
				'post_status' => 'any',
				'numberposts' => -1,
				's'           => 'segnaposto', // Contatori e riquadri segnaposto.
			)
		) as $post ) {
			$voci[] = array(
				'titolo' => get_the_title( $post ),
				'dove'   => __( 'Blocchi nella pagina', 'refe-core' ),
				'link'   => (string) get_edit_post_link( $post->ID, 'raw' ),
			);
		}
		return $voci;
	}

	/**
	 * Tabella in Impostazioni sito.
	 */
	public static function tabella(): void {
		$voci = self::elenco();
		echo '<h2>' . esc_html__( 'Segnaposto da riempire', 'refe-core' ) . '</h2>';
		if ( ! $voci ) {
			echo '<p>' . esc_html__( 'Nessun segnaposto.', 'refe-core' ) . '</p>';
			return;
		}
		echo '<p>' . esc_html__( 'Si vedono sul sito. Vanno riempiti prima della messa online.', 'refe-core' ) . '</p><table class="widefat striped" style="max-width:760px"><thead><tr><th scope="col">' . esc_html__( 'Contenuto', 'refe-core' ) . '</th><th scope="col">' . esc_html__( 'Dove', 'refe-core' ) . '</th></tr></thead><tbody>';
		foreach ( $voci as $v ) {
			printf( '<tr><td><a href="%s">%s</a></td><td>%s</td></tr>', esc_url( $v['link'] ), esc_html( $v['titolo'] ), esc_html( $v['dove'] ) );
		}
		echo '</tbody></table>';
	}
}
