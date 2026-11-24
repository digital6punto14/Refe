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
		if ( is_readable( $build . '/blocks-manifest.php' ) ) {
			wp_register_block_types_from_metadata_collection( $build . '/blocks', $build . '/blocks-manifest.php' );
		}
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
