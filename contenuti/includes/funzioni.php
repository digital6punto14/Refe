<?php
/**
 * Funzioni dell'importatore: si possono ripetere senza duplicare nulla.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Stato dell'importazione in corso.
 */
final class Refe_Contenuti_Stato {
	/**
	 * Vero se i contenuti esistenti vanno riscritti.
	 *
	 * @var bool
	 */
	public static bool $riscrivi = true;

	/**
	 * Contenuti creati o riscritti in questo giro.
	 *
	 * @var int[]
	 */
	public static array $toccati = array();

	/**
	 * Conteggi e avvisi.
	 *
	 * @var array
	 */
	public static array $esito = array();

	/**
	 * Azzera lo stato.
	 *
	 * @param bool $riscrivi Vero per riscrivere.
	 */
	public static function inizia( bool $riscrivi ): void {
		self::$riscrivi = $riscrivi;
		self::$toccati  = array();
		self::$esito    = array(
			'creati'    => 0,
			'riscritti' => 0,
			'lasciati'  => 0,
			'avvisi'    => array(),
		);
	}
}

/**
 * Cerca un contenuto importato in precedenza, anche nel cestino.
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
 * Quanti contenuti importati ci sono.
 */
function refe_contenuti_quanti(): int {
	return count(
		get_posts(
			array(
				'post_type'   => array( 'page', 'post', 'wp_block', 'refe_case', 'refe_testimonianza', 'refe_persona' ),
				'post_status' => 'any',
				'meta_key'    => '_refe_chiave', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'fields'      => 'ids',
				'numberposts' => -1,
			)
		)
	);
}

/**
 * Crea un contenuto, o lo aggiorna se si riscrive.
 *
 * @param string $chiave Chiave dell'importatore.
 * @param array  $dati   Dati per wp_insert_post.
 */
function refe_contenuti_post( string $chiave, array $dati ): int {
	$dati += array(
		'post_type'   => 'page',
		'post_status' => 'publish',
	);
	$id    = $dati['ID'] ?? refe_contenuti_trova( $chiave, $dati['post_type'] );
	$gia   = $id && get_post_meta( $id, '_refe_chiave', true );
	if ( $gia && ! Refe_Contenuti_Stato::$riscrivi ) {
		++Refe_Contenuti_Stato::$esito['lasciati'];
		return $id;
	}
	$dati['ID'] = $id;
	$nuovo      = wp_insert_post( wp_slash( $dati ), true );
	if ( is_wp_error( $nuovo ) ) {
		Refe_Contenuti_Stato::$esito['avvisi'][] = $chiave . ': ' . $nuovo->get_error_message();
		return 0;
	}
	update_post_meta( $nuovo, '_refe_chiave', $chiave );
	++Refe_Contenuti_Stato::$esito[ $gia ? 'riscritti' : 'creati' ];
	Refe_Contenuti_Stato::$toccati[] = $nuovo;
	return $nuovo;
}

/**
 * Vero se il contenuto è stato creato o riscritto in questo giro.
 *
 * @param int $id Contenuto.
 */
function refe_contenuti_toccato( int $id ): bool {
	return in_array( $id, Refe_Contenuti_Stato::$toccati, true );
}

/**
 * Salva il testo di un contenuto toccato in questo giro.
 *
 * @param int    $id    Contenuto.
 * @param string $testo Blocchi.
 */
function refe_contenuti_testo( int $id, string $testo ): void {
	if ( ! refe_contenuti_toccato( $id ) ) {
		return;
	}
	wp_update_post(
		wp_slash(
			array(
				'ID'           => $id,
				'post_content' => $testo,
			)
		)
	);
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
	if ( $id ) {
		return $id;
	}
	if ( ! is_readable( $file ) ) {
		Refe_Contenuti_Stato::$esito['avvisi'][] = 'File mancante: ' . basename( $file );
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	$tmp = wp_tempnam( basename( $file ) );
	copy( $file, $tmp );
	// I file sono nostri: SVG e WebM si accettano solo durante l'importazione.
	add_filter( 'upload_mimes', 'refe_contenuti_mime', 99 );
	add_filter( 'wp_check_filetype_and_ext', 'refe_contenuti_tipo', 99, 4 );
	$id = media_handle_sideload(
		array(
			'name'     => basename( $file ),
			'tmp_name' => $tmp,
		),
		0
	);
	remove_filter( 'upload_mimes', 'refe_contenuti_mime', 99 );
	remove_filter( 'wp_check_filetype_and_ext', 'refe_contenuti_tipo', 99 );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		Refe_Contenuti_Stato::$esito['avvisi'][] = basename( $file ) . ': ' . $id->get_error_message();
		return 0;
	}
	update_post_meta( $id, '_refe_chiave', $chiave );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	return (int) $id;
}

/**
 * Tipi di file ammessi durante l'importazione.
 *
 * @param array $tipi Tipi.
 */
function refe_contenuti_mime( array $tipi ): array {
	return $tipi + array(
		'svg'  => 'image/svg+xml',
		'webm' => 'video/webm',
	);
}

/**
 * Riconosce gli SVG dall'estensione durante l'importazione.
 *
 * @param array  $dati Dati del file.
 * @param string $file Percorso.
 * @param string $nome Nome.
 */
function refe_contenuti_tipo( array $dati, $file, $nome ): array {
	if ( str_ends_with( (string) $nome, '.svg' ) ) {
		$dati['ext']  = 'svg';
		$dati['type'] = 'image/svg+xml';
	}
	return $dati;
}

/**
 * Salva i campi ACF di una scheda toccata in questo giro.
 *
 * @param int   $id    Contenuto.
 * @param array $campi Nome e valore.
 */
function refe_contenuti_campi( int $id, array $campi ): void {
	if ( ! refe_contenuti_toccato( $id ) ) {
		return;
	}
	foreach ( $campi as $nome => $valore ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( 'field_' . get_post_type( $id ) . '_' . $nome, $valore, $id );
		} else {
			update_post_meta( $id, $nome, $valore );
		}
	}
}

/**
 * Crea un termine e ne restituisce l'ID.
 *
 * @param string $nome       Nome.
 * @param string $tassonomia Tassonomia.
 * @param string $slug       Slug.
 */
function refe_contenuti_termine( string $nome, string $tassonomia, string $slug = '' ): int {
	$t = term_exists( $slug ? $slug : $nome, $tassonomia );
	if ( ! $t ) {
		$t = wp_insert_term( $nome, $tassonomia, $slug ? array( 'slug' => $slug ) : array() );
	}
	return is_wp_error( $t ) ? 0 : (int) $t['term_id'];
}

/**
 * Dati preparati con le pagine: codici, titoli, articoli.
 */
function refe_contenuti_codici(): array {
	static $dati = null;
	if ( null === $dati ) {
		$dati = json_decode( (string) file_get_contents( REFE_CONTENUTI_DIR . 'pagine/codici.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- File del plugin.
	}
	return $dati;
}

/**
 * Legge un contenuto e mette indirizzi e ID di questo sito.
 *
 * @param string $nome  Nome del file in pagine.
 * @param array  $mappa Codici e ID; chiave «url» per i file della Libreria.
 */
function refe_contenuti_leggi( string $nome, array $mappa ): string {
	$testo = trim( (string) file_get_contents( REFE_CONTENUTI_DIR . 'pagine/' . $nome . '.html' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- File del plugin.
	$testo = str_replace( array( 'https://u.refe', 'refehash' ), array( untrailingslashit( home_url() ), $mappa['hash'] ?? '' ), $testo );
	$testo = (string) preg_replace_callback( '#https://img\.refe/([\w./-]+)#', static fn( $m ) => $mappa['url'][ $m[1] ] ?? $m[0], $testo );
	return (string) preg_replace_callback( '/\b9[0-4]00\d\d\b/', static fn( $m ) => (string) ( $mappa['id'][ (int) $m[0] ] ?? $m[0] ), $testo );
}

/**
 * Toglie i contenuti di esempio di WordPress e di Contact Form 7, se nessuno li ha modificati.
 */
function refe_contenuti_pulisci(): void {
	$esempi = array(
		array( 'post', array( 'hello-world', 'ciao-mondo' ) ),
		array( 'page', array( 'sample-page', 'pagina-di-esempio' ) ),
	);
	foreach ( $esempi as $e ) {
		foreach ( $e[1] as $slug ) {
			$post = get_page_by_path( $slug, OBJECT, $e[0] );
			if ( $post && ! get_post_meta( $post->ID, '_refe_chiave', true ) && $post->post_date_gmt === $post->post_modified_gmt ) {
				wp_delete_post( $post->ID, true );
			}
		}
	}
	foreach ( get_posts(
		array(
			'post_type'   => 'wpcf7_contact_form',
			'post_status' => 'any',
			'numberposts' => -1,
		)
	) as $modulo ) {
		if ( in_array( $modulo->post_title, array( 'Contact form 1', 'Modulo di contatto 1' ), true ) && ! get_post_meta( $modulo->ID, '_refe_chiave', true ) && $modulo->post_date === $modulo->post_modified ) {
			wp_delete_post( $modulo->ID, true );
		}
	}
}
