<?php
/**
 * Estende lo schema di Yoast SEO. Non stampa JSON-LD proprio.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Solo informazioni visibili in pagina.
 */
final class Schema {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'wpseo_schema_organization', array( self::class, 'azienda' ) );
		add_filter( 'wpseo_schema_webpage', array( self::class, 'pagina' ), 11, 2 );
		add_filter( 'wpseo_schema_article', array( self::class, 'articolo' ), 11, 2 );
		add_filter( 'wpseo_schema_needs_author', '__return_false' );
		add_filter( 'wpseo_opengraph_image', array( self::class, 'condivisione' ) );
		add_filter( 'wpseo_twitter_image', array( self::class, 'condivisione' ) );
	}

	/**
	 * Refe: azienda e attività locale, con i dati di Impostazioni sito.
	 *
	 * @param array $dati Organizzazione di Yoast.
	 */
	public static function azienda( $dati ): array {
		$dati = (array) $dati;
		$a    = Dati::azienda();
		$tel  = preg_replace( '/[^0-9+]/', '', $a['telefono'] );

		$dati['@type']        = array( 'Organization', 'LocalBusiness' );
		$dati['legalName']    = $a['ragione_sociale'];
		$dati['description']  = $a['descrizione'];
		$dati['vatID']        = $a['partita_iva'] ? 'IT' . $a['partita_iva'] : '';
		$dati['foundingDate'] = $a['fondazione'];
		$dati['email']        = $a['email'];
		$dati['telephone']    = $tel && ! str_starts_with( $tel, '+' ) ? '+39' . $tel : $tel;
		$dati['address']      = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $a['indirizzo']['via'],
			'postalCode'      => $a['indirizzo']['cap'],
			'addressLocality' => $a['indirizzo']['citta'],
			'addressRegion'   => $a['indirizzo']['provincia'],
			'addressCountry'  => $a['indirizzo']['paese'],
		);
		$dati['sameAs']       = array_values( array_unique( array_merge( (array) ( $dati['sameAs'] ?? array() ), $a['profili'] ) ) );
		return array_filter( $dati );
	}

	/**
	 * I social non mostrano gli SVG: al loro posto l'immagine predefinita di Yoast.
	 *
	 * @param string $url Immagine.
	 */
	public static function condivisione( $url ): string {
		$url = (string) $url;
		return str_ends_with( strtolower( $url ), '.svg' ) && class_exists( 'WPSEO_Options' ) ? (string) \WPSEO_Options::get( 'og_default_image', '' ) : $url;
	}

	/**
	 * Pagine dei servizi ed elenchi.
	 *
	 * @param array  $dati     Pagina di Yoast.
	 * @param object $contesto Contesto di Yoast.
	 */
	public static function pagina( $dati, $contesto ): array {
		$dati = (array) $dati;
		if ( ! is_singular() ) {
			return $dati;
		}
		$post    = get_queried_object();
		$azienda = trailingslashit( home_url() ) . '#organization';
		$azienda = isset( $contesto->site_url ) ? $contesto->site_url . '#organization' : $azienda;
		if ( $post instanceof \WP_Post && get_post_meta( $post->ID, Dati::META_SERVIZIO, true ) ) {
			$s                  = Dati::scheda( $post );
			$dati['mainEntity'] = array_filter(
				array(
					'@type'       => 'Service',
					'@id'         => $s['url'] . '#servizio',
					'name'        => $s['titolo'],
					'description' => $s['descrizione'],
					'url'         => $s['url'],
					'provider'    => array( '@id' => $azienda ),
				)
			);
			return $dati;
		}
		if ( $post instanceof \WP_Post && 'page' === $post->post_type ) {
			$elenco = array();
			if ( is_page( 'case-studies' ) && has_block( 'refe/progetti', $post ) ) {
				$elenco = Dati::progetti( array( 'quanti' => 50 ) );
			} elseif ( is_page( 'news' ) && has_block( 'refe/news', $post ) ) {
				$elenco = Dati::news( array( 'quanti' => 50 ) );
			}
			if ( $elenco ) {
				$dati['mainEntity'] = array(
					'@type'           => 'ItemList',
					'numberOfItems'   => count( $elenco ),
					'itemListElement' => array_map(
						static fn( $v, $n ) => array(
							'@type'    => 'ListItem',
							'position' => $n + 1,
							'name'     => $v['titolo'],
							'url'      => $v['url'],
						),
						$elenco,
						array_keys( $elenco )
					),
				);
			}
		}
		return $dati;
	}

	/**
	 * Articoli e case studies sono pubblicati da Refe.
	 *
	 * @param array  $dati     Articolo di Yoast.
	 * @param object $contesto Contesto di Yoast.
	 */
	public static function articolo( $dati, $contesto ): array {
		$dati = (array) $dati;
		if ( isset( $contesto->site_url ) ) {
			$dati['author'] = array( '@id' => $contesto->site_url . '#organization' );
		}
		return $dati;
	}
}
