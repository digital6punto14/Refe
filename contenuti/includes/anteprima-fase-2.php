<?php
/**
 * Pagine provvisorie per guardare i pattern del tema. Nella fase 4 lasciano il posto ai contenuti veri.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Crea le pagine provvisorie.
 */
function refe_contenuti_fase_2(): void {
	$logo = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/logo-refe.svg', 'Refe' );
	if ( $logo ) {
		update_option( 'site_logo', $logo );
	}
	$icona = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/simbolo-refe.svg', '' );
	if ( $icona ) {
		update_option( 'site_icon', $icona );
	}

	// Percorso «Home / Pagina», come nella demo.
	$titoli                    = (array) get_option( 'wpseo_titles', array() );
	$titoli['breadcrumbs-sep'] = '/';
	update_option( 'wpseo_titles', $titoli );

	$pagine = array(
		'home'          => array( 'Home', '', array( 'testata-filigrana', 'testo-introduttivo', 'schede-link', 'chiusura-sigillo' ) ),
		'chi-siamo'     => array( 'Chi siamo', '', array( 'testata-foto', 'immagine-testo', 'schede-link' ) ),
		'team'          => array( 'Il team', 'chi-siamo', array( 'testata-divisa', 'testo-introduttivo', 'chiusura-pulsanti' ) ),
		'storia'        => array( 'La storia di Refe', 'chi-siamo', array( 'testata-foto', 'testo-introduttivo', 'chiusura-pulsanti' ) ),
		'servizi'       => array( 'Servizi', '', array( 'testata-filigrana', 'schede-link', 'chiusura-sigillo' ) ),
		'metodo'        => array( 'Il metodo', 'servizi', array( 'testata-sigillo', 'testo-introduttivo', 'tab-fasi' ) ),
		'attivita'      => array( 'Attività', 'servizi', array( 'testata-foto', 'fisarmonica', 'fascia-foto-scura', 'chiusura-sigillo' ) ),
		'sostenibilita' => array( 'Sostenibilità digitale', 'servizi', array( 'testata-foto', 'testo-introduttivo' ), 'sostenibilita-digitale' ),
		'perform'       => array( 'Perform+', 'sostenibilita', array( 'testata-icona', 'schede-icone', 'fascia-foto-chiara', 'chiusura-pulsanti' ) ),
		'contatti'      => array( 'Contatti', '', array( 'testata-foto-larga', 'recapiti' ) ),
		'case-studies'  => array( 'Case studies', '', array( 'testata-filigrana', 'racconto', 'chiusura-sigillo' ) ),
		'news'          => array( 'News', '', array( 'testata-bassa' ) ),
		'clienti'       => array( 'Clienti', '', array( 'testata-filigrana', 'chiusura-pulsanti' ) ),
	);
	$ids    = array();
	foreach ( $pagine as $chiave => $dati ) {
		$ids[ $chiave ] = refe_contenuti_post(
			'pagina:' . $chiave,
			array(
				'post_title'   => $dati[0],
				'post_name'    => $dati[3] ?? $chiave,
				'post_parent'  => $ids[ $dati[1] ] ?? 0,
				'post_content' => refe_contenuti_pattern( ...$dati[2] ),
			)
		);
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['home'] );
}
