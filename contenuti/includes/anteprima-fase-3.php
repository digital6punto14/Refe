<?php
/**
 * Contenuti provvisori per provare blocchi e campi. Nella fase 4 lasciano il posto a quelli definitivi.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Immagine del tema nella Libreria.
 *
 * @param string $file File in assets/img del tema.
 * @param string $alt  Testo alternativo.
 */
function refe_contenuti_immagine( string $file, string $alt = '' ): int {
	return refe_contenuti_media( get_theme_file_path( 'assets/img/' . $file ), $alt );
}

/**
 * Salva i campi di una scheda.
 *
 * @param int   $id    Contenuto.
 * @param array $campi Nome e valore.
 */
function refe_contenuti_campi( int $id, array $campi ): void {
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
 * Crea i contenuti provvisori.
 */
function refe_contenuti_fase_3(): void {
	if ( ! post_type_exists( 'refe_case' ) ) {
		return;
	}

	// Case studies.
	$racconto = 'https://www.csroggi.org/refe-e-la-sfida-della-twin-transition/';
	$progetti = array(
		'regione-puglia'  => array( 'Regione Puglia', 'Politiche, risultati e valore pubblico: la sostenibilità diventa accessibile ai cittadini.', 'case-puglia.webp', 'istituzioni', array( 'OpenReport®' ), 'Rendicontazione digitale' ),
		'comune-di-parma' => array( 'Comune di Parma', 'Programmazione strategica, monitoraggio degli obiettivi e valutazione delle performance.', 'case-parma.webp', 'istituzioni', array( 'Perform+PA' ), 'Programmazione' ),
		'brianzacque'     => array( 'BrianzAcque', 'Misurare e comunicare il valore sociale, ambientale ed economico prodotto per il territorio.', 'case-brianzacque.webp', 'imprese', array( 'Reporting' ), 'Sostenibilità' ),
		'fincons-group'   => array( 'Fincons Group', 'Consulenza ESG e tecnologia per collegare governance, strategia e reporting.', 'case-parma.webp', 'imprese', array( 'Perform+' ), 'Gestione della sostenibilità' ),
	);
	$clienti  = array(
		'imprese'     => refe_contenuti_termine( 'Imprese', 'refe_tipo_cliente', 'imprese' ),
		'istituzioni' => refe_contenuti_termine( 'Istituzioni e territori', 'refe_tipo_cliente', 'istituzioni' ),
	);
	$ordine   = 0;
	foreach ( $progetti as $slug => $d ) {
		$immagine = refe_contenuti_immagine( $d[2], $d[0] . ': immagine del progetto' );
		$testo    = str_replace( get_theme_file_uri( 'assets/img/case-puglia.webp' ), (string) wp_get_attachment_url( $immagine ), refe_contenuti_pattern( 'racconto', 'risultati', 'galleria' ) );
		$id       = refe_contenuti_post(
			'case:' . $slug,
			array(
				'post_type'    => 'refe_case',
				'post_title'   => $d[0],
				'post_name'    => $slug,
				'post_excerpt' => $d[1],
				'post_content' => $testo,
				'menu_order'   => ++$ordine,
			)
		);
		set_post_thumbnail( $id, $immagine );
		wp_set_object_terms( $id, $clienti[ $d[3] ], 'refe_tipo_cliente' );
		wp_set_object_terms( $id, array_map( static fn( $s ) => refe_contenuti_termine( $s, 'refe_soluzione', sanitize_title( str_replace( array( '+', '®' ), array( '-plus-', '' ), $s ) ) ), $d[4] ), 'refe_soluzione' );
		$campi = array(
			'ambito'     => $d[5],
			'link_url'   => 'brianzacque' === $slug ? '' : $racconto,
			'link_testo' => 'brianzacque' === $slug ? '' : 'Il racconto del progetto',
			'segnaposto' => 1,
		);
		for ( $n = 1; $n <= 3; $n++ ) {
			$campi[ "risultato_{$n}_numero" ] = 'XX';
			$campi[ "risultato_{$n}_testo" ]  = 'Risultato da definire';
		}
		refe_contenuti_campi( $id, $campi );
	}

	// Testimonianze.
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

	// Persone.
	foreach ( array( 'Cristiana Rogate', 'Nome Cognome', 'Nome Cognome', 'Nome Cognome' ) as $i => $nome ) {
		$id = refe_contenuti_post(
			'persona:' . $i,
			array(
				'post_type'    => 'refe_persona',
				'post_title'   => $nome,
				'post_excerpt' => 'Breve descrizione da definire',
				'menu_order'   => $i + 1,
			)
		);
		refe_contenuti_campi(
			$id,
			array(
				'ruolo'      => 0 === $i ? 'Fondatrice e presidente' : 'Ruolo',
				'segnaposto' => 1,
			)
		);
	}

	// Articoli.
	$articoli = array(
		array( 'La relazione è il vero motore del cambiamento', 'la-relazione-e-il-vero-motore-del-cambiamento', '2026-07-08', 'Media', 'Cristiana Rogate nel podcast “Che razza di umani”: sostenibilità, ecosistemi e valore condiviso.', 'foto-dialogo.webp' ),
		array( 'Quarant’anni di valore, un Impact Book', 'quarant-anni-di-valore-un-impact-book', '2026-06-03', 'Progetti', 'Il percorso con Fondazione Lombardia per l’Ambiente per dare forma al valore generato nel tempo.', 'foto-paesaggio.webp' ),
		array( 'La sostenibilità entra nelle scelte', 'la-sostenibilita-entra-nelle-scelte', '2026-01-14', 'Pubblicazioni', 'Governance, management e comunicazione: il contributo di Cristiana Rogate ai Quaderni dell’Università di Torino.', 'foto-lavagna.webp' ),
	);
	foreach ( $articoli as $d ) {
		$id = refe_contenuti_post(
			'news:' . $d[1],
			array(
				'post_type'    => 'post',
				'post_title'   => $d[0],
				'post_name'    => $d[1],
				'post_date'    => $d[2] . ' 09:00:00',
				'post_excerpt' => $d[4],
				'post_content' => '<!-- wp:heading --><h2 class="wp-block-heading">In breve</h2><!-- /wp:heading --><!-- wp:paragraph --><p>' . $d[4] . '</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Approfondimento</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Testo provvisorio: gli articoli completi arrivano nella fase dei contenuti.</p><!-- /wp:paragraph -->',
			)
		);
		set_post_thumbnail( $id, refe_contenuti_immagine( $d[5] ) );
		wp_set_post_categories( $id, array( refe_contenuti_termine( $d[3], 'category' ) ) );
	}

	// Pagine con i blocchi nuovi.
	$video   = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/refe-logo-loop.webm' );
	$inserto = $video ? wp_json_encode(
		array(
			'id'  => $video,
			'url' => wp_get_attachment_url( $video ),
		),
		JSON_UNESCAPED_SLASHES
	) : '';
	$pagine  = array(
		'home'          => array( 'home-copertina', 'home-numeri-metodo', 'home-piattaforme', 'home-progetti', 'home-relazioni-news' ),
		'chi-siamo'     => array( 'testata-foto', 'immagine-testo', 'schede-link', 'relazioni' ),
		'team'          => array( 'testata-divisa', 'testo-introduttivo', 'persone', 'chiusura-pulsanti' ),
		'storia'        => array( 'testata-foto', 'testo-introduttivo', 'pannelli-storia', 'chiusura-pulsanti' ),
		'metodo'        => array( 'testata-sigillo', 'testo-introduttivo', 'pannelli-metodo', 'tab-fasi' ),
		'sostenibilita' => array( 'testata-foto', 'testo-introduttivo', 'piattaforme', 'pannelli-piattaforme', 'progetti-collegati' ),
		'case-studies'  => array( 'testata-filigrana', 'elenco-progetti', 'chiusura-sigillo' ),
		'news'          => array( 'testata-bassa', 'elenco-news' ),
		'clienti'       => array( 'testata-filigrana', 'relazioni', 'elenco-progetti', 'chiusura-pulsanti' ),
	);
	foreach ( $pagine as $chiave => $pattern ) {
		$id = refe_contenuti_trova( 'pagina:' . $chiave, 'page' );
		if ( ! $id ) {
			continue;
		}
		$testo = refe_contenuti_pattern( ...$pattern );
		if ( $inserto ) {
			$testo = str_replace( '<!-- wp:refe/copertina -->', '<!-- wp:refe/copertina {"video":' . $inserto . '} -->', $testo );
			$testo = str_replace( '<!-- wp:refe/persone /-->', '<!-- wp:refe/persone {"video":' . $inserto . '} /-->', $testo );
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
	refe_contenuti_post(
		'pagina:videocorso',
		array(
			'post_title'   => 'Videocorso',
			'post_name'    => 'videocorso',
			'post_status'  => 'draft',
			'post_parent'  => refe_contenuti_trova( 'pagina:servizi', 'page' ),
			'post_content' => refe_contenuti_pattern( 'testata-bassa', 'corso', 'fascia-foto-scura' ),
		)
	);
}
