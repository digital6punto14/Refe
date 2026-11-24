<?php
/**
 * Stili per i gruppi di schede modificabili.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Stile «Scorrimento» del Gruppo: CSS solo nelle pagine che lo usano.
 */
final class Stili {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
		add_filter( 'render_block_core/group', array( self::class, 'carica' ), 10, 2 );
	}

	/**
	 * Registra lo stile.
	 */
	public static function registra(): void {
		register_block_style(
			'core/group',
			array(
				'name'  => 'scorrimento',
				'label' => __( 'Schede a scorrimento', 'refe-core' ),
			)
		);
		wp_register_style( 'refe-scorrimento', REFE_CORE_URL . 'assets/css/scorrimento.css', array(), Blocchi::versione( 'assets/css/scorrimento.css' ) );
		wp_style_add_data( 'refe-scorrimento', 'path', REFE_CORE_DIR . 'assets/css/scorrimento.css' );
		add_editor_style( REFE_CORE_URL . 'assets/css/scorrimento.css' );
	}

	/**
	 * Carica il CSS se il gruppo usa lo stile. L'elenco che scorre si raggiunge anche da tastiera.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function carica( string $html, array $blocco ): string {
		if ( ! str_contains( $blocco['attrs']['className'] ?? '', 'is-style-scorrimento' ) ) {
			return $html;
		}
		wp_enqueue_style( 'refe-scorrimento' );
		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( $tag->next_tag() ) {
			$tag->set_attribute( 'tabindex', '0' );
			$tag->set_attribute( 'role', 'group' );
			$tag->set_attribute( 'aria-label', __( 'Schede a scorrimento', 'refe-core' ) );
		}
		return $tag->get_updated_html();
	}
}
