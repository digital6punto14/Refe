<?php
/**
 * Controllo dell'editor.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Blocchi ammessi, blocco della struttura per l'Editor, pannelli aggiunti.
 */
final class Editor {

	/** Blocchi tolti a tutti. */
	private const TOLTI = array( 'core/html', 'core/shortcode', 'core/freeform', 'core/code', 'core/preformatted', 'core/verse', 'core/pullquote', 'core/rss', 'core/calendar', 'core/tag-cloud', 'core/archives', 'core/latest-comments', 'core/latest-posts', 'core/page-list', 'core/loginout', 'core/more', 'core/nextpage', 'core/legacy-widget', 'core/widget-group', 'core/math', 'core/comments', 'core/post-comments-form', 'core/post-comments-count', 'core/post-comments-link' );

	/** Blocchi riservati a chi modifica il sito. */
	private const SOLO_ADMIN = array( 'core/navigation', 'core/navigation-link', 'core/navigation-submenu', 'core/home-link', 'core/template-part', 'core/site-logo', 'core/site-title', 'core/site-tagline', 'core/query', 'core/post-template', 'core/post-content', 'core/pattern', 'refe/pannello-menu', 'refe/ricerca', 'refe/progetto-successivo', 'refe/indice' );

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'allowed_block_types_all', array( self::class, 'blocchi' ), 10, 2 );
		add_filter( 'block_editor_settings_all', array( self::class, 'opzioni' ) );
		add_filter( 'should_load_remote_block_patterns', '__return_false' );
		add_action( 'enqueue_block_editor_assets', array( self::class, 'carica' ) );
		add_action( 'admin_init', array( self::class, 'senza_elenco_blocchi' ) );
	}

	/**
	 * Elenco dei blocchi ammessi.
	 *
	 * @param bool|array               $ammessi  Blocchi ammessi.
	 * @param \WP_Block_Editor_Context $contesto Contesto.
	 */
	public static function blocchi( bool|array $ammessi, \WP_Block_Editor_Context $contesto ): bool|array {
		if ( false === $ammessi ) {
			return false;
		}
		$nomi = is_array( $ammessi ) ? $ammessi : array_keys( \WP_Block_Type_Registry::get_instance()->get_all_registered() );
		$via  = self::TOLTI;
		if ( ! current_user_can( 'edit_theme_options' ) && ! empty( $contesto->post ) ) {
			$via = array_merge( $via, self::SOLO_ADMIN );
		}
		return array_values( array_diff( $nomi, $via ) );
	}

	/**
	 * Opzioni dell'editor.
	 *
	 * @param array $opzioni Opzioni.
	 */
	public static function opzioni( array $opzioni ): array {
		$opzioni['enableOpenverseMediaCategory'] = false;
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			// L'Editor cambia testi, immagini, colori e ordine, ma non sblocca le parti bloccate e non scrive codice.
			$opzioni['canLockBlocks']      = false;
			$opzioni['codeEditingEnabled'] = false;
			$opzioni['fontLibraryEnabled'] = false;
		}
		return $opzioni;
	}

	/**
	 * Niente installazione di blocchi dall'inseritore.
	 */
	public static function senza_elenco_blocchi(): void {
		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	}

	/**
	 * Pannelli e strumenti aggiunti.
	 */
	public static function carica(): void {
		$file = REFE_CORE_DIR . 'build/editor/index.asset.php';
		if ( ! is_readable( $file ) ) {
			return;
		}
		$dati = require $file;
		wp_enqueue_script( 'refe-editor', REFE_CORE_URL . 'build/editor/index.js', $dati['dependencies'], $dati['version'], true );
		wp_set_script_translations( 'refe-editor', 'refe-core', REFE_CORE_DIR . 'languages' );
		wp_add_inline_script(
			'refe-editor',
			'window.refeEditor = ' . wp_json_encode(
				array(
					'azienda'    => Collegamenti::dati_azienda(),
					'campi'      => Collegamenti::campi(),
					'tipi'       => Animazioni::tipi(),
					'animazioni' => Impostazioni::tutte()['animazioni'],
				),
				JSON_HEX_TAG | JSON_UNESCAPED_SLASHES
			) . ';',
			'before'
		);
	}
}
