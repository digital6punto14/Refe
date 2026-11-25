<?php
/**
 * Dati pubblici del sito: un solo servizio per REST, abilities e schema.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Solo contenuti pubblicati e visibili. I segnaposto restano fuori.
 */
final class Dati {

	public const META_SERVIZIO = 'refe_servizio';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
	}

	/**
	 * Segno delle pagine che descrivono un servizio.
	 */
	public static function registra(): void {
		register_post_meta(
			'page',
			self::META_SERVIZIO,
			array(
				'type'              => 'boolean',
				'single'            => true,
				'default'           => false,
				'show_in_rest'      => true,
				'sanitize_callback' => 'rest_sanitize_boolean',
				'auth_callback'     => static fn( $ok, $chiave, $id ) => current_user_can( 'edit_post', $id ),
			)
		);
	}

	/**
	 * Dati aziendali.
	 */
	public static function azienda(): array {
		$a = Impostazioni::tutte()['azienda'];
		return array(
			'nome'      => get_bloginfo( 'name' ),
			'ragione_sociale' => $a['nome'],
			'descrizione' => get_bloginfo( 'description' ),
			'partita_iva' => $a['piva'],
			'fondazione' => $a['anno'],
			'indirizzo' => array(
				'via'       => $a['indirizzo'],
				'cap'       => $a['cap'],
				'citta'     => $a['citta'],
				'provincia' => $a['provincia'],
				'paese'     => 'IT',
			),
			'telefono'  => $a['telefono'],
			'email'     => $a['email'],
			'sito'      => home_url( '/' ),
			'profili'   => array_values( array_filter( array( $a['linkedin'], $a['instagram'] ) ) ),
		);
	}

	/**
	 * Case studies.
	 *
	 * @param array $arg Filtri: tipo_cliente, soluzione (slug), quanti.
	 */
	public static function progetti( array $arg = array() ): array {
		$filtri = array();
		foreach ( array(
			'tipo_cliente' => array( 'tipo', Contenuti::TIPO_CLIENTE ),
			'soluzione'    => array( 'soluzione', Contenuti::SOLUZIONE ),
		) as $chiave => $dove ) {
			if ( ! empty( $arg[ $chiave ] ) ) {
				$t = get_term_by( 'slug', sanitize_title( (string) $arg[ $chiave ] ), $dove[1] );
				if ( ! $t ) {
					return array();
				}
				$filtri[ $dove[0] ] = $t->term_id;
			}
		}
		$filtri['quanti'] = self::quanti( $arg );
		return array_map(
			static fn( \WP_Post $p ): array => self::scheda( $p ) + array(
				'tipo_cliente' => self::nomi( $p->ID, Contenuti::TIPO_CLIENTE ),
				'soluzioni'    => self::nomi( $p->ID, Contenuti::SOLUZIONE ),
				'ambito'       => Campi::testo( 'ambito', $p->ID ),
				'risultati'    => Segnaposto::e( $p->ID ) ? array() : Campi::risultati( $p->ID ),
			),
			Contenuti::progetti( $filtri )
		);
	}

	/**
	 * News.
	 *
	 * @param array $arg Filtri: categoria (slug), quanti.
	 */
	public static function news( array $arg = array() ): array {
		$query = array(
			'numberposts' => self::quanti( $arg ),
			'post_status' => 'publish',
		);
		if ( ! empty( $arg['categoria'] ) ) {
			$query['category_name'] = sanitize_title( (string) $arg['categoria'] );
		}
		return array_map(
			static fn( \WP_Post $p ): array => self::scheda( $p ) + array(
				'data'      => get_the_date( 'Y-m-d', $p ),
				'categorie' => self::nomi( $p->ID, 'category' ),
			),
			get_posts( $query )
		);
	}

	/**
	 * Pagine che descrivono un servizio.
	 */
	public static function servizi(): array {
		return array_map(
			array( self::class, 'scheda' ),
			get_posts(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'numberposts' => -1,
					'orderby'     => array(
						'menu_order' => 'ASC',
						'ID'         => 'ASC',
					),
					'meta_key'    => self::META_SERVIZIO, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'meta_value'  => '1', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				)
			)
		);
	}

	/**
	 * Ricerca nei contenuti pubblici.
	 *
	 * @param string $testo  Testo cercato.
	 * @param int    $quanti Quanti risultati.
	 */
	public static function cerca( string $testo, int $quanti = 10 ): array {
		$testo = sanitize_text_field( $testo );
		if ( mb_strlen( $testo ) < 2 ) {
			return array();
		}
		return array_map(
			static fn( \WP_Post $p ): array => array( 'tipo' => Collegamenti::tipo( $p->ID ) ) + self::scheda( $p ),
			get_posts(
				array(
					'post_type'   => array( 'page', 'post', Contenuti::CASE ),
					'post_status' => 'publish',
					'has_password' => false,
					's'           => $testo,
					'numberposts' => max( 1, min( 50, $quanti ) ),
					'orderby'     => 'relevance',
				)
			)
		);
	}

	/**
	 * Voce comune a tutti gli elenchi.
	 *
	 * @param \WP_Post $p Contenuto.
	 */
	public static function scheda( \WP_Post $p ): array {
		return array(
			'id'          => $p->ID,
			'titolo'      => html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' ),
			'descrizione' => self::descrizione( $p ),
			'url'         => (string) get_permalink( $p ),
		);
	}

	/**
	 * Descrizione: riassunto, oppure la descrizione scritta in Yoast.
	 *
	 * @param \WP_Post $p Contenuto.
	 */
	public static function descrizione( \WP_Post $p ): string {
		$testo = trim( $p->post_excerpt );
		if ( '' === $testo ) {
			$testo = trim( (string) get_post_meta( $p->ID, '_yoast_wpseo_metadesc', true ) );
			$testo = str_contains( $testo, '%%' ) ? '' : $testo;
		}
		return html_entity_decode( wp_strip_all_tags( $testo ), ENT_QUOTES, 'UTF-8' );
	}

	/**
	 * Quanti elementi, tra 1 e 50.
	 *
	 * @param array $arg Argomenti.
	 */
	private static function quanti( array $arg ): int {
		return isset( $arg['quanti'] ) ? max( 1, min( 50, (int) $arg['quanti'] ) ) : 20;
	}

	/**
	 * Nomi dei termini.
	 *
	 * @param int    $id         Contenuto.
	 * @param string $tassonomia Tassonomia.
	 * @return string[]
	 */
	private static function nomi( int $id, string $tassonomia ): array {
		return array_map( static fn( $n ) => html_entity_decode( $n, ENT_QUOTES, 'UTF-8' ), array_values( wp_list_pluck( Contenuti::termini( $id, $tassonomia ), 'name' ) ) );
	}
}
