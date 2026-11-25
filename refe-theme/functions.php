<?php
/**
 * Supporti ed enqueue del tema. Nessuna logica: sta nel plugin Refe Core.
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Supporti del tema e stili dell'editor.
 */
function refe_theme_setup(): void {
	load_theme_textdomain( 'refe-theme', get_template_directory() . '/languages' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/base.css' );
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'refe_theme_setup' );

/**
 * Un foglio di stile per blocco, caricato solo se il blocco è nella pagina.
 * Il nome del file è il nome del blocco: core-group.css, yoast-seo-breadcrumbs.css.
 */
function refe_theme_stili_blocchi(): void {
	$dir = get_theme_file_path( 'assets/css/blocks' );
	foreach ( (array) glob( $dir . '/*.css' ) as $file ) {
		$nome   = basename( $file, '.css' );
		$blocco = preg_replace( '/^(core|refe|yoast-seo|contact-form-7)-/', '$1/', $nome );
		wp_enqueue_block_style(
			$blocco,
			array(
				'handle' => 'refe-theme-' . $nome,
				'src'    => get_theme_file_uri( 'assets/css/blocks/' . $nome . '.css' ),
				'path'   => $file,
				'ver'    => (string) filemtime( $file ),
			)
		);
	}
}
add_action( 'init', 'refe_theme_stili_blocchi' );

/**
 * Stile di base e comportamento della testata.
 */
function refe_theme_enqueue(): void {
	$css = 'assets/css/base.css';
	$js  = 'assets/js/testata.js';
	wp_enqueue_style( 'refe-theme-base', get_theme_file_uri( $css ), array(), (string) filemtime( get_theme_file_path( $css ) ) );
	wp_style_add_data( 'refe-theme-base', 'path', get_theme_file_path( $css ) );
	wp_enqueue_script( 'refe-theme-testata', get_theme_file_uri( $js ), array(), (string) filemtime( get_theme_file_path( $js ) ), array( 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'refe_theme_enqueue' );

/**
 * Il font del testo si carica subito.
 *
 * @param array $risorse Risorse.
 */
function refe_theme_preload( array $risorse ): array {
	$risorse[] = array(
		'href'        => get_theme_file_uri( 'assets/fonts/dm-sans.woff2' ),
		'as'          => 'font',
		'type'        => 'font/woff2',
		'crossorigin' => 'anonymous',
	);
	return $risorse;
}
add_filter( 'wp_preload_resources', 'refe_theme_preload' );

/**
 * Senza JavaScript le schede a tab mostrano tutti i pannelli.
 */
function refe_theme_senza_js(): void {
	echo '<noscript><style>.wp-block-tab-panel[hidden]{display:block!important}.wp-block-tab-list{display:none!important}</style></noscript>' . "\n";
}
add_action( 'wp_head', 'refe_theme_senza_js' );

/**
 * Categoria dei pattern del progetto.
 */
function refe_theme_categorie_pattern(): void {
	register_block_pattern_category( 'refe-home', array( 'label' => __( 'Refe: home', 'refe-theme' ) ) );
	register_block_pattern_category( 'refe-testate', array( 'label' => __( 'Refe: testate', 'refe-theme' ) ) );
	register_block_pattern_category( 'refe-sezioni', array( 'label' => __( 'Refe: sezioni', 'refe-theme' ) ) );
	register_block_pattern_category( 'refe-chiusure', array( 'label' => __( 'Refe: chiusure', 'refe-theme' ) ) );
}
add_action( 'init', 'refe_theme_categorie_pattern' );
