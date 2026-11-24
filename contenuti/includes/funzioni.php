<?php
/**
 * Funzioni dell'importatore: si possono ripetere senza duplicare nulla.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cerca un contenuto importato in precedenza.
 *
 * @param string $chiave Chiave dell'importatore.
 * @param string $tipo   Post type.
 */
function refe_contenuti_trova( string $chiave, string $tipo ): int {
	$ids = get_posts(
		array(
			'post_type'   => $tipo,
			'post_status' => 'any',
			'meta_key'    => '_refe_chiave', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'  => $chiave, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'fields'      => 'ids',
			'numberposts' => 1,
		)
	);
	return (int) ( $ids[0] ?? 0 );
}

/**
 * Crea o aggiorna un contenuto.
 *
 * @param string $chiave Chiave dell'importatore.
 * @param array  $dati   Dati per wp_insert_post.
 */
function refe_contenuti_post( string $chiave, array $dati ): int {
	$dati      += array(
		'post_type'   => 'page',
		'post_status' => 'publish',
	);
	$dati['ID'] = refe_contenuti_trova( $chiave, $dati['post_type'] );
	$id         = wp_insert_post( wp_slash( $dati ), true );
	if ( is_wp_error( $id ) ) {
		return 0;
	}
	update_post_meta( $id, '_refe_chiave', $chiave );
	return $id;
}

/**
 * Carica un file nella Libreria media, una volta sola.
 *
 * @param string $file Percorso del file.
 * @param string $alt  Testo alternativo.
 */
function refe_contenuti_media( string $file, string $alt = '' ): int {
	$chiave = 'media:' . basename( $file );
	$id     = refe_contenuti_trova( $chiave, 'attachment' );
	if ( ! $id && is_readable( $file ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		$tmp = wp_tempnam( basename( $file ) );
		copy( $file, $tmp );
		$id = media_handle_sideload(
			array(
				'name'     => basename( $file ),
				'tmp_name' => $tmp,
			),
			0
		);
		if ( is_wp_error( $id ) ) {
			wp_delete_file( $tmp );
			return 0;
		}
		update_post_meta( $id, '_refe_chiave', $chiave );
	}
	if ( $id ) {
		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	}
	return (int) $id;
}

/**
 * Markup di un pattern del tema.
 *
 * @param string ...$slug Nomi dei pattern.
 */
function refe_contenuti_pattern( string ...$slug ): string {
	$registro = WP_Block_Patterns_Registry::get_instance();
	$html     = '';
	foreach ( $slug as $s ) {
		$html .= $registro->get_registered( 'refe-theme/' . $s )['content'] ?? '';
	}
	return $html;
}

/**
 * Toglie i contenuti di esempio di WordPress.
 */
function refe_contenuti_pulisci(): void {
	foreach ( array( 'hello-world', 'ciao-mondo' ) as $slug ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $post ) {
			wp_delete_post( $post->ID, true );
		}
	}
	foreach ( array( 'sample-page', 'pagina-di-esempio' ) as $slug ) {
		$post = get_page_by_path( $slug );
		if ( $post ) {
			wp_delete_post( $post->ID, true );
		}
	}
}
