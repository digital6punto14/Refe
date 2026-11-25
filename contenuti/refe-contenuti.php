<?php
/**
 * Plugin Name:       Refe — contenuti demo
 * Description:       Importatore dei contenuti della demo. Si lancia una volta da Strumenti e poi si elimina: i contenuti restano.
 * Version:           1.0.0
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

require_once REFE_CONTENUTI_DIR . 'includes/class-refe-contenuti-stato.php';
require_once REFE_CONTENUTI_DIR . 'includes/funzioni.php';
require_once REFE_CONTENUTI_DIR . 'includes/schede.php';
require_once REFE_CONTENUTI_DIR . 'includes/modulo.php';
require_once REFE_CONTENUTI_DIR . 'includes/seo.php';
require_once REFE_CONTENUTI_DIR . 'includes/importa.php';

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
	$esistono = refe_contenuti_quanti();
	if ( isset( $_POST['refe_importa'] ) ) {
		check_admin_referer( 'refe_importa' );
		$riscrivi = isset( $_POST['refe_modo'], $_POST['refe_conferma'] ) && 'tutto' === $_POST['refe_modo'];
		if ( $esistono && isset( $_POST['refe_modo'] ) && 'tutto' === $_POST['refe_modo'] && ! $riscrivi ) {
			echo '<div class="notice notice-error"><p>Per riscrivere le pagine spunta la conferma. Non è stato cambiato nulla.</p></div>';
		} else {
			$esito = refe_contenuti_importa( ! $esistono || $riscrivi );
			echo '<div class="notice ' . ( $esito['avvisi'] ? 'notice-warning' : 'notice-success' ) . '"><p>' . esc_html( sprintf( 'Contenuti creati: %d. Riscritti: %d. Lasciati come sono: %d.', $esito['creati'], $esito['riscritti'], $esito['lasciati'] ) ) . '</p>';
			foreach ( $esito['avvisi'] as $avviso ) {
				echo '<p>' . esc_html( $avviso ) . '</p>';
			}
			echo '</div>';
			$esistono = refe_contenuti_quanti();
		}
	}
	echo '<div class="wrap"><h1>Importa contenuti Refe</h1><form method="post">';
	wp_nonce_field( 'refe_importa' );
	if ( $esistono ) {
		echo '<p>' . esc_html( sprintf( 'In questo sito ci sono già %d contenuti importati.', $esistono ) ) . '</p>';
		echo '<fieldset><legend class="screen-reader-text">Che cosa importare</legend>';
		echo '<p><label><input type="radio" name="refe_modo" value="mancanti" checked> <strong>Solo quello che manca.</strong> Le pagine modificate non vengono toccate.</label></p>';
		echo '<p><label><input type="radio" name="refe_modo" value="tutto"> <strong>Riscrivi tutto.</strong> Pagine e schede tornano ai testi della demo: le modifiche fatte nell’editor si perdono.</label></p>';
		echo '<p style="padding-left:24px"><label><input type="checkbox" name="refe_conferma" value="1"> Confermo di voler riscrivere i contenuti</label></p></fieldset>';
	} else {
		echo '<p>Crea pagine, case studies, testimonianze, persone, news, modulo di contatto e immagini.</p>';
	}
	submit_button( 'Importa', 'primary', 'refe_importa' );
	echo '</form></div>';
}
