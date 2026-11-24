<?php
/**
 * Voce corrente nei pannelli del menu.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Segna il link della pagina corrente.
 */
final class Menu {

	/**
	 * Aggiunge aria-current ai link della pagina corrente.
	 *
	 * @param string $html Contenuto del pannello.
	 * @return array{0:string,1:bool} HTML e se il pannello contiene la sezione corrente.
	 */
	public static function segna_corrente( string $html ): array {
		$richiesta = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
		$qui       = self::percorso( $richiesta );
		$base      = self::percorso( home_url( '/' ) );
		$attivo    = false;
		$tag       = new \WP_HTML_Tag_Processor( $html );
		while ( $tag->next_tag( 'A' ) ) {
			$link = self::percorso( (string) $tag->get_attribute( 'href' ) );
			if ( '' === $link || $link === $base ) {
				continue;
			}
			if ( $qui === $link ) {
				$tag->set_attribute( 'aria-current', 'page' );
				$attivo = true;
			} elseif ( str_starts_with( $qui, $link . '/' ) ) {
				$attivo = true;
			}
		}
		return array( $tag->get_updated_html(), $attivo );
	}

	/**
	 * Percorso di un indirizzo, senza barra finale.
	 *
	 * @param string $url Indirizzo.
	 */
	private static function percorso( string $url ): string {
		return untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );
	}
}
