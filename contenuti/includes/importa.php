<?php
/**
 * Importazione: prima si creano i contenuti, poi i testi con gli ID di questo sito.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Elenco delle pagine: titolo, pagina madre, indirizzo, voce del percorso.
 */
function refe_contenuti_pagine(): array {
	return array(
		'home'                   => array( 'Home', '', 'home' ),
		'chi-siamo'              => array( 'Chi siamo', '', 'chi-siamo' ),
		'team'                   => array( 'Il team', 'chi-siamo', 'team' ),
		'storia'                 => array( 'La storia di Refe', 'chi-siamo', 'storia', '20 anni di Refe' ),
		'lavora-con-noi'         => array( 'Lavora con noi', 'chi-siamo', 'lavora-con-noi', 'Jobs' ),
		'servizi'                => array( 'Servizi', '', 'servizi' ),
		'metodo'                 => array( 'Il metodo', 'servizi', 'metodo' ),
		'attivita'               => array( 'Attività', 'servizi', 'attivita' ),
		'sostenibilita-digitale' => array( 'Sostenibilità digitale', 'servizi', 'sostenibilita-digitale' ),
		'perform'                => array( 'Perform+', 'sostenibilita-digitale', 'perform' ),
		'openreport'             => array( 'OpenReport®', 'sostenibilita-digitale', 'openreport' ),
		'videocorso'             => array( 'Videocorso', 'servizi', 'videocorso' ),
		'case-studies'           => array( 'Case studies', '', 'case-studies' ),
		'clienti'                => array( 'Clienti', '', 'clienti' ),
		'news'                   => array( 'News', '', 'news' ),
		'contatti'               => array( 'Contatti', '', 'contatti' ),
		'privacy'                => array( 'Privacy Policy', '', 'privacy-policy' ),
		'cookie'                 => array( 'Cookie Policy', '', 'cookie-policy' ),
	);
}

/**
 * Importa tutto.
 *
 * @param bool $riscrivi Vero per riscrivere i contenuti esistenti.
 * @return array Conteggi e avvisi.
 */
function refe_contenuti_importa( bool $riscrivi = true ): array {
	Refe_Contenuti_Stato::inizia( $riscrivi );
	if ( ! post_type_exists( 'refe_case' ) || 'refe-theme' !== get_template() ) {
		Refe_Contenuti_Stato::$esito['avvisi'][] = 'Attiva prima il tema Refe e il plugin Refe Core.';
		return Refe_Contenuti_Stato::$esito;
	}
	$primo = ! get_option( 'refe_contenuti_importati' );
	refe_contenuti_pulisci();
	if ( $primo || $riscrivi ) {
		refe_contenuti_opzioni();
	}

	// Libreria media.
	$codici = refe_contenuti_codici();
	$mappa  = array(
		'id'  => array(),
		'url' => array(),
	);
	$alt    = array(
		'foto-scala.webp'       => 'Scala a spirale con un giardino al centro',
		'foto-laptop.webp'      => 'Persone al lavoro davanti a un computer portatile',
		'case-puglia.webp'      => 'Regione Puglia: immagine del progetto',
		'case-parma.webp'       => 'Comune di Parma: immagine del progetto',
		'case-brianzacque.webp' => 'BrianzAcque: immagine del progetto',
		'sticky-metodo.svg'     => 'Rendersi conto per rendere conto',
	);
	foreach ( $codici['media'] as $file => $codice ) {
		$percorso = 'refe-logo-loop.webm' === $file ? REFE_CONTENUTI_DIR . 'media/' . $file : get_theme_file_path( 'assets/img/' . $file );
		$id       = refe_contenuti_media( $percorso, $alt[ $file ] ?? '' );

		$mappa['id'][ $codice ] = $id;
		$mappa['url'][ $file ]  = $id ? (string) wp_get_attachment_url( $id ) : get_theme_file_uri( 'assets/img/' . $file );
	}

	// Schede.
	foreach ( refe_contenuti_case() as $slug => $id ) {
		$mappa['id'][ $codici['case'][ $slug ] ] = $id;
	}
	refe_contenuti_testimonianze();
	foreach ( refe_contenuti_persone() as $i => $id ) {
		$mappa['id'][ $codici['persone'][ $i ] ] = $id;
	}

	// Pagine vuote, per avere indirizzi e ID.
	$pagine = array();
	foreach ( refe_contenuti_pagine() as $chiave => $d ) {
		$dati               = array(
			'post_title'     => $d[0],
			'post_name'      => $d[2],
			'post_parent'    => $pagine[ $d[1] ] ?? 0,
			'post_status'    => 'videocorso' === $chiave ? 'draft' : 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'page_template'  => in_array( $chiave, array( 'privacy', 'cookie' ), true ) ? 'pagina-indice' : 'default',
		);
		$dati['meta_input'] = refe_contenuti_seo_meta( $chiave );
		if ( isset( $d[3] ) ) {
			$dati['meta_input']['_yoast_wpseo_bctitle'] = $d[3];
		}
		if ( 'privacy' === $chiave && ! refe_contenuti_trova( 'pagina:privacy', 'page' ) ) {
			// La bozza che WordPress crea da solo.
			$bozza = get_post( (int) get_option( 'wp_page_for_privacy_policy' ) );
			if ( $bozza && 'draft' === $bozza->post_status ) {
				$dati['ID'] = $bozza->ID;
			}
		}
		$pagine[ $chiave ] = refe_contenuti_post( 'pagina:' . $chiave, $dati );
	}
	update_option( 'wp_page_for_privacy_policy', $pagine['privacy'] );
	if ( $primo || $riscrivi ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pagine['home'] );
	}

	// Modulo.
	$modulo                           = refe_contenuti_modulo( get_permalink( $pagine['privacy'] ) );
	$mappa['id'][ $codici['modulo'] ] = $modulo['id'];
	$mappa['hash']                    = $modulo['hash'];

	// Pattern sincronizzati.
	foreach ( $codici['blocchi'] as $nome => $codice ) {
		$id = refe_contenuti_post(
			'blocco:' . $nome,
			array(
				'post_type'  => 'wp_block',
				'post_title' => $codici['titoli'][ $nome ],
				'post_name'  => 'refe-' . $nome,
			)
		);
		refe_contenuti_testo( $id, refe_contenuti_leggi( 'blocco-' . $nome, $mappa ) );
		$mappa['id'][ $codice ] = $id;
	}

	// Testi.
	foreach ( $pagine as $chiave => $id ) {
		refe_contenuti_testo( $id, refe_contenuti_leggi( 'pagina-' . $chiave, $mappa ) );
	}
	foreach ( $codici['case'] as $slug => $codice ) {
		refe_contenuti_testo( $mappa['id'][ $codice ], refe_contenuti_leggi( 'case-' . $slug, $mappa ) );
	}
	refe_contenuti_news( $mappa );

	if ( $primo || $riscrivi ) {
		refe_contenuti_llms( $pagine );
	}
	update_option( 'refe_contenuti_importati', time(), false );
	flush_rewrite_rules();
	return Refe_Contenuti_Stato::$esito;
}

/**
 * Impostazioni del sito.
 */
function refe_contenuti_opzioni(): void {
	update_option( 'blogname', 'Refe' );
	update_option( 'blogdescription', 'Strategie di sviluppo sostenibile' );
	update_option( 'timezone_string', 'Europe/Rome' );
	update_option( 'date_format', 'j F Y' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	$logo = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/logo-refe.svg', 'Refe' );
	if ( $logo ) {
		update_option( 'site_logo', $logo );
	}
	$icona = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/simbolo-refe.svg' );
	if ( $icona ) {
		update_option( 'site_icon', $icona );
	}
	refe_contenuti_yoast();
}
