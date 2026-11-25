<?php
/**
 * Comportamenti di tutto il sito: cursore e passaggio tra le pagine.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Si accendono e si spengono da Impostazioni sito.
 */
final class Globali {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'carica' ) );
		add_filter( 'render_block_core/table', array( self::class, 'tabella' ) );
		add_filter( 'script_module_data_refe-core/cursore', array( self::class, 'cursore' ) );
	}

	/**
	 * Carica gli elementi accesi.
	 */
	public static function carica(): void {
		$imp = Impostazioni::tutte()['animazioni'];
		if ( $imp['cursore'] ) {
			wp_enqueue_style( 'refe-cursore', REFE_CORE_URL . 'assets/css/cursore.css', array(), Blocchi::versione( 'assets/css/cursore.css' ), '(hover: hover) and (pointer: fine)' );
			wp_enqueue_script_module( Blocchi::modulo( 'cursore' ) );
		}
		if ( $imp['passaggio'] ) {
			wp_enqueue_style( 'refe-passaggio', REFE_CORE_URL . 'assets/css/passaggio.css', array(), Blocchi::versione( 'assets/css/passaggio.css' ) );
		}
	}

	/**
	 * Una tabella larga scorre anche da tastiera.
	 *
	 * @param string $html HTML.
	 */
	public static function tabella( string $html ): string {
		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( $tag->next_tag( 'FIGURE' ) ) {
			$tag->set_attribute( 'tabindex', '0' );
			$tag->set_attribute( 'role', 'region' );
			$tag->set_attribute( 'aria-label', __( 'Tabella', 'refe-core' ) );
		}
		return $tag->get_updated_html();
	}

	/**
	 * Immagine del cursore.
	 *
	 * @param array $dati Dati.
	 */
	public static function cursore( array $dati ): array {
		$dati['immagine'] = REFE_CORE_URL . 'assets/img/simbolo.svg';
		return $dati;
	}
}
