<?php
/**
 * Plugin Name:       Refe — contenuti demo
 * Description:       Importatore dei contenuti della demo. Si lancia dal blueprint o da Strumenti e si può ripetere senza duplicare nulla. Non serve sul sito definitivo.
 * Version:           0.3.0
 * Requires at least: 7.1
 * Requires PHP:      8.3
 * Author:            6.14
 * License:           GPL-2.0-or-later
 * Text Domain:       refe-contenuti
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

define( 'REFE_CONTENUTI_DIR', plugin_dir_path( __FILE__ ) );

require_once REFE_CONTENUTI_DIR . 'includes/funzioni.php';
require_once REFE_CONTENUTI_DIR . 'includes/anteprima-fase-2.php';
require_once REFE_CONTENUTI_DIR . 'includes/anteprima-fase-3.php';

/**
 * Punto di ingresso dell'importatore.
 */
function refe_contenuti_importa(): void {
	refe_contenuti_pulisci();
	refe_contenuti_fase_2();
	refe_contenuti_fase_3();
	flush_rewrite_rules();
}

/**
 * Voce in Strumenti.
 */
function refe_contenuti_menu(): void {
	add_management_page( 'Importa contenuti Refe', 'Importa contenuti Refe', 'manage_options', 'refe-contenuti', 'refe_contenuti_pagina' );
}
add_action( 'admin_menu', 'refe_contenuti_menu' );

/**
 * Pagina con il pulsante di importazione.
 */
function refe_contenuti_pagina(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['refe_importa'] ) ) {
		check_admin_referer( 'refe_importa' );
		refe_contenuti_importa();
		echo '<div class="notice notice-success"><p>Contenuti importati.</p></div>';
	}
	echo '<div class="wrap"><h1>Importa contenuti Refe</h1><form method="post">';
	wp_nonce_field( 'refe_importa' );
	submit_button( 'Importa', 'primary', 'refe_importa' );
	echo '</form></div>';
}
