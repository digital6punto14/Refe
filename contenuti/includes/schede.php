<?php
/**
 * Schede: case studies, testimonianze, persone, news.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Crea i case studies.
 *
 * @return array<string,int>
 */
function refe_contenuti_case(): array {
	$racconto = 'https://www.csroggi.org/refe-e-la-sfida-della-twin-transition/';
	$dati     = array(
		'regione-puglia'  => array( 'Regione Puglia', 'Politiche, risultati e valore pubblico: la sostenibilità diventa accessibile ai cittadini.', 'case-puglia.webp', 'istituzioni', array( 'openreport' => 'OpenReport®' ), 'Rendicontazione digitale', $racconto, 'Il racconto del progetto' ),
		'comune-di-parma' => array( 'Comune di Parma', 'Programmazione strategica, monitoraggio degli obiettivi e valutazione delle performance.', 'case-parma.webp', 'istituzioni', array( 'perform-pa' => 'Perform+PA' ), 'Programmazione', $racconto, 'Il racconto del progetto' ),
		'brianzacque'     => array( 'BrianzAcque', 'Misurare e comunicare il valore sociale, ambientale ed economico prodotto per il territorio.', 'case-brianzacque.webp', 'imprese', array( 'reporting' => 'Reporting' ), 'Sostenibilità', 'mailto:info@refe.net?subject=Progetto%20BrianzAcque', 'Approfondisci con Refe' ),
		'fincons-group'   => array( 'Fincons Group', 'Consulenza ESG e tecnologia per collegare governance, strategia e reporting.', 'case-parma.webp', 'imprese', array( 'perform' => 'Perform+' ), 'Gestione della sostenibilità', $racconto, 'Il racconto del progetto' ),
	);
	$clienti  = array(
		'imprese'     => refe_contenuti_termine( 'Imprese', 'refe_tipo_cliente', 'imprese' ),
		'istituzioni' => refe_contenuti_termine( 'Istituzioni e territori', 'refe_tipo_cliente', 'istituzioni' ),
	);
	$ids      = array();
	$ordine   = 0;
	foreach ( $dati as $slug => $d ) {
		$id           = refe_contenuti_post(
			'case:' . $slug,
			array(
				'post_type'    => 'refe_case',
				'post_title'   => $d[0],
				'post_name'    => $slug,
				'post_excerpt' => $d[1],
				'menu_order'   => ++$ordine,
			)
		);
		$ids[ $slug ] = $id;
		if ( ! $id || ! refe_contenuti_toccato( $id ) ) {
			continue;
		}
		set_post_thumbnail( $id, refe_contenuti_media( get_theme_file_path( 'assets/img/' . $d[2] ), '' ) );
		wp_set_object_terms( $id, $clienti[ $d[3] ], 'refe_tipo_cliente' );
		$soluzioni = array();
		foreach ( $d[4] as $s => $nome ) {
			$soluzioni[] = refe_contenuti_termine( $nome, 'refe_soluzione', $s );
		}
		wp_set_object_terms( $id, $soluzioni, 'refe_soluzione' );
		$campi = array(
			'ambito'     => $d[5],
			'link_url'   => $d[6],
			'link_testo' => $d[7],
			'segnaposto' => 1,
		);
		for ( $n = 1; $n <= 3; $n++ ) {
			$campi[ "risultato_{$n}_numero" ] = 'XX';
			$campi[ "risultato_{$n}_testo" ]  = 'Risultato da definire';
		}
		refe_contenuti_campi( $id, $campi );
	}
	return $ids;
}

/**
 * Crea le testimonianze.
 */
function refe_contenuti_testimonianze(): void {
	$voci = array(
		array( 'Pier Attilio Superti', 'Segretario generale di ANCI Lombardia', 'Refe ha una modalità interessante di interpretare il Bilancio sociale, ha la capacità di rappresentare e comunicare in modo chiaro e immediato concetti complessi e offre strumenti innovativi di crescita gestionale.', 0 ),
		array( 'Stefano Cetti', 'Direttore generale di MM SpA', 'Questo è un ottimo servizio che ha rispecchiato le nostre aspettative a livello di comunicazione e pianificazione.', 0 ),
		array( 'Persona', 'Ruolo', 'Testo della testimonianza da definire: breve citazione di un cliente sul lavoro svolto con Refe.', 1 ),
	);
	foreach ( $voci as $i => $d ) {
		$id = refe_contenuti_post(
			'testimonianza:' . $i,
			array(
				'post_type'  => 'refe_testimonianza',
				'post_title' => $d[0],
				'menu_order' => $i + 1,
			)
		);
		refe_contenuti_campi(
			$id,
			array(
				'ruolo'      => $d[1],
				'citazione'  => $d[2],
				'segnaposto' => $d[3],
			)
		);
	}
}

/**
 * Crea le persone.
 *
 * @return int[]
 */
function refe_contenuti_persone(): array {
	$ids = array();
	foreach ( array( 'Cristiana Rogate', 'Nome Cognome', 'Nome Cognome', 'Nome Cognome' ) as $i => $nome ) {
		$id    = refe_contenuti_post(
			'persona:' . $i,
			array(
				'post_type'    => 'refe_persona',
				'post_title'   => $nome,
				'post_excerpt' => 'Breve descrizione da definire',
				'menu_order'   => $i + 1,
			)
		);
		$ids[] = $id;
		refe_contenuti_campi(
			$id,
			array(
				'ruolo'      => 0 === $i ? 'Fondatrice e presidente' : 'Ruolo',
				'segnaposto' => 1,
			)
		);
	}
	return $ids;
}

/**
 * Crea le news.
 *
 * @param array $mappa Codici e ID.
 */
function refe_contenuti_news( array $mappa ): void {
	foreach ( refe_contenuti_codici()['articoli'] as $d ) {
		$id = refe_contenuti_post(
			'news:' . $d['slug'],
			array(
				'post_type'    => 'post',
				'post_title'   => $d['titolo'],
				'post_name'    => $d['slug'],
				'post_date'    => $d['data'] . ' 09:00:00',
				'post_excerpt' => $d['riassunto'],
			)
		);
		if ( ! $id || ! refe_contenuti_toccato( $id ) ) {
			continue;
		}
		refe_contenuti_testo( $id, refe_contenuti_leggi( 'news-' . $d['slug'], $mappa ) );
		set_post_thumbnail( $id, refe_contenuti_media( get_theme_file_path( 'assets/img/' . $d['immagine'] ) ) );
		wp_set_post_categories( $id, array( refe_contenuti_termine( $d['categoria'], 'category' ) ) );
	}
}
