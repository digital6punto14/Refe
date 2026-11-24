<?php
/**
 * Plugin Name:       Refe — contenuti demo
 * Description:       Importatore dei contenuti della demo. Si lancia dal blueprint e si può ripetere senza duplicare nulla. Non serve sul sito definitivo.
 * Version:           0.1.0
 * Requires at least: 7.1
 * Requires PHP:      8.3
 * Author:            6.14
 * License:           GPL-2.0-or-later
 * Text Domain:       refe-contenuti
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Punto di ingresso dell'importatore (fase 4).
 */
function refe_contenuti_importa(): void {
	update_option( 'refe_contenuti_prova', '1', false );
}
