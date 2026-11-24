<?php
/**
 * Plugin Name:       Refe Core
 * Plugin URI:        https://refe.net
 * Description:       Contenuti, campi, blocchi, impostazioni, SEO e funzioni per gli agenti AI del sito Refe.
 * Version:           0.3.0
 * Requires at least: 7.1
 * Requires PHP:      8.3
 * Author:            6.14
 * Author URI:        https://6punto14.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       refe-core
 * Domain Path:       /languages
 *
 * @package RefeCore
 */

defined( 'ABSPATH' ) || exit;

define( 'REFE_CORE_VERSION', '0.3.0' );
define( 'REFE_CORE_FILE', __FILE__ );
define( 'REFE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'REFE_CORE_URL', plugin_dir_url( __FILE__ ) );

spl_autoload_register(
	static function ( string $classe ): void {
		if ( ! str_starts_with( $classe, 'Refe\\Core\\' ) ) {
			return;
		}
		$nome = strtolower( str_replace( array( '\\', '_' ), '-', substr( $classe, 10 ) ) );
		$file = REFE_CORE_DIR . 'includes/class-' . $nome . '.php';
		if ( is_readable( $file ) ) {
			require $file;
		}
	}
);

Refe\Core\Plugin::avvia();

register_activation_hook( __FILE__, array( Refe\Core\Plugin::class, 'attiva' ) );
register_deactivation_hook( __FILE__, array( Refe\Core\Plugin::class, 'disattiva' ) );
