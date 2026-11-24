<?php
/**
 * Registrazione dei blocchi del plugin.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Blocchi e categoria.
 */
final class Blocchi {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
		add_filter( 'block_categories_all', array( self::class, 'categoria' ) );
	}

	/**
	 * Registra i blocchi della build.
	 */
	public static function registra(): void {
		$build = REFE_CORE_DIR . 'build';
		// Elementi comuni a più blocchi (freccia, pausa, stato vuoto): si carica solo con i blocchi che lo chiedono.
		wp_register_style( 'refe-comune', REFE_CORE_URL . 'assets/css/comune.css', array(), self::versione( 'assets/css/comune.css' ) );
		wp_style_add_data( 'refe-comune', 'path', REFE_CORE_DIR . 'assets/css/comune.css' );
		if ( is_readable( $build . '/blocks-manifest.php' ) ) {
			wp_register_block_types_from_metadata_collection( $build . '/blocks', $build . '/blocks-manifest.php' );
		}
	}

	/**
	 * Spazio tra gli elementi scelto nel blocco, come variabile CSS.
	 *
	 * @param array $attributi Attributi del blocco.
	 */
	public static function spazio( array $attributi ): string {
		$valore = $attributi['style']['spacing']['blockGap'] ?? '';
		$valore = is_array( $valore ) ? ( $valore['left'] ?? $valore['top'] ?? '' ) : $valore;
		$valore = preg_replace( '/^var:preset\|spacing\|([\w-]+)$/', 'var(--wp--preset--spacing--$1)', (string) $valore );
		return preg_match( '/^(var\(--wp--preset--spacing--[\w-]+\)|[\d.]+(px|rem|em|%|vw|svh)?)$/', $valore ) ? "--refe-spazio:{$valore};" : '';
	}

	/**
	 * Versione di un file: cambia quando cambia il file.
	 *
	 * @param string $file Percorso dentro il plugin.
	 */
	public static function versione( string $file ): string {
		return is_readable( REFE_CORE_DIR . $file ) ? (string) filemtime( REFE_CORE_DIR . $file ) : REFE_CORE_VERSION;
	}

	/**
	 * Registra un modulo JavaScript della build.
	 *
	 * @param string $nome Nome del file in build/moduli.
	 */
	public static function modulo( string $nome ): string {
		$id   = 'refe-core/' . $nome;
		$file = REFE_CORE_DIR . 'build/moduli/' . $nome . '.asset.php';
		$dati = is_readable( $file ) ? require $file : array();
		wp_register_script_module( $id, REFE_CORE_URL . 'build/moduli/' . $nome . '.js', $dati['dependencies'] ?? array(), $dati['version'] ?? REFE_CORE_VERSION );
		return $id;
	}

	/**
	 * Categoria «Refe» in cima all'inseritore.
	 *
	 * @param array $categorie Categorie.
	 */
	public static function categoria( array $categorie ): array {
		array_unshift(
			$categorie,
			array(
				'slug'  => 'refe',
				'title' => __( 'Refe', 'refe-core' ),
			)
		);
		return $categorie;
	}
}
