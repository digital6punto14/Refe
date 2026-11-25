<?php
/**
 * Yoast SEO: impostazioni, titoli e descrizioni.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Titolo, descrizione, parola chiave e tipo di pagina.
 */
function refe_contenuti_seo(): array {
	return array(
		'home'                   => array( 'Consulenza sostenibilità aziendale ed ESG — Refe', 'Da vent’anni Refe accompagna imprese, istituzioni e Terzo Settore verso uno sviluppo sostenibile: metodo, competenze e soluzioni digitali.', 'consulenza sostenibilità aziendale', '' ),
		'chi-siamo'              => array( 'Società di consulenza ESG a Milano dal 2006 — Refe', 'Fondata nel 2006 da Cristiana Rogate, Refe accompagna imprese, istituzioni e Terzo Settore con consulenza, formazione e strumenti digitali.', 'società di consulenza ESG Milano', 'AboutPage' ),
		'team'                   => array( 'Il team: competenze ESG multidisciplinari — Refe', 'Team multidisciplinari, costruiti sulle esigenze del progetto: governance, misurazione delle performance, reporting, comunicazione e partecipazione.', '', '' ),
		'storia'                 => array( 'La storia di Refe: vent’anni di sostenibilità', 'Vent’anni di futuro. Insieme. Nel 2006 la sostenibilità non era ancora una parola di uso comune: per Refe era già la direzione.', '', '' ),
		'lavora-con-noi'         => array( 'Lavora con noi — Refe', 'Ti interessano sostenibilità, misurazione degli impatti, comunicazione e partecipazione? Invia a Refe la tua candidatura spontanea.', '', '' ),
		'servizi'                => array( 'Servizi di consulenza ESG e sostenibilità — Refe', 'Il metodo, le otto attività e le piattaforme digitali con cui Refe accompagna organizzazioni e territori nella sostenibilità.', '', 'CollectionPage' ),
		'metodo'                 => array( 'Metodo di rendicontazione della sostenibilità — Refe', 'Rendersi conto per rendere conto®: il metodo proprietario che guida l’approccio di Refe dal 2006.', 'metodo rendicontazione sostenibilità', '' ),
		'attivita'               => array( 'Bilancio di sostenibilità e report ESG: attività — Refe', 'Le otto attività con cui Refe accompagna organizzazioni e territori: dalla programmazione al bilancio di sostenibilità, dalla formazione alle performance ESG.', 'bilancio di sostenibilità', '' ),
		'sostenibilita-digitale' => array( 'Software sostenibilità ESG: Perform+ e OpenReport®', 'Perform+ e OpenReport®: due piattaforme per la sostenibilità digitale, dalla gestione dei dati ESG alla comunicazione.', 'software sostenibilità ESG', '' ),
		'perform'                => array( 'Perform+: gestione degli indicatori ESG — Refe', 'Perform+ supporta la gestione di piani, indicatori ESG, raccolta dati e reporting.', 'gestione indicatori ESG', '' ),
		'openreport'             => array( 'OpenReport®: report di sostenibilità digitale — Refe', 'OpenReport® rende strategie e risultati consultabili in portali digitali aggiornabili.', 'report di sostenibilità digitale', '' ),
		'case-studies'           => array( 'Esempi di bilancio di sostenibilità: case studies — Refe', 'Progetti di strategia, misurazione e rendicontazione della sostenibilità per imprese, istituzioni e territori.', 'esempi bilancio di sostenibilità', 'CollectionPage' ),
		'clienti'                => array( 'Clienti e testimonianze — Refe', 'Relazioni che producono valore nel tempo: le voci e i progetti di chi lavora con Refe.', '', 'CollectionPage' ),
		'news'                   => array( 'News, progetti e pubblicazioni — Refe', 'News, progetti e pubblicazioni di Refe sulla sostenibilità, la governance e la rendicontazione.', '', 'CollectionPage' ),
		'contatti'               => array( 'Contatti — Refe, Milano', 'Scrivi a Refe, chiama lo 02 3656 7111 o vieni a trovarci in Piazza Luigi di Savoia 22, a Milano.', '', 'ContactPage' ),
		'privacy'                => array( 'Privacy Policy — Refe', 'Privacy Policy di Refe Srl.', '', '' ),
		'cookie'                 => array( 'Cookie Policy — Refe', 'Cookie Policy di Refe Srl.', '', '' ),
	);
}

/**
 * Pagine che descrivono un servizio.
 */
function refe_contenuti_servizi(): array {
	return array( 'metodo', 'attivita', 'sostenibilita-digitale', 'perform', 'openreport' );
}

/**
 * Metadati di una pagina, da salvare insieme alla pagina.
 *
 * @param string $chiave Pagina.
 */
function refe_contenuti_seo_meta( string $chiave ): array {
	$d    = refe_contenuti_seo()[ $chiave ] ?? null;
	$meta = array();
	if ( $d ) {
		$meta = array_filter(
			array(
				'_yoast_wpseo_title'            => $d[0],
				'_yoast_wpseo_metadesc'         => $d[1],
				'_yoast_wpseo_focuskw'          => $d[2],
				'_yoast_wpseo_schema_page_type' => $d[3],
			)
		);
	}
	if ( in_array( $chiave, array( 'home', 'servizi', 'metodo', 'case-studies' ), true ) ) {
		// Pagine che aprono con un disegno: per i social si usa l'immagine di Refe.
		$immagine = refe_contenuti_trova( 'media:refe-condivisione.png', 'attachment' );
		if ( $immagine ) {
			$meta['_yoast_wpseo_opengraph-image']    = wp_get_attachment_url( $immagine );
			$meta['_yoast_wpseo_opengraph-image-id'] = $immagine;
			$meta['_yoast_wpseo_twitter-image']      = wp_get_attachment_url( $immagine );
			$meta['_yoast_wpseo_twitter-image-id']   = $immagine;
		}
	}
	if ( in_array( $chiave, refe_contenuti_servizi(), true ) ) {
		$meta['refe_servizio'] = 1;
	}
	return $meta;
}

/**
 * Pagine scelte per llms.txt.
 *
 * @param array $pagine Pagine e ID.
 */
function refe_contenuti_llms( array $pagine ): void {
	if ( ! class_exists( 'WPSEO_Options' ) ) {
		return;
	}
	$altre = array();
	foreach ( array( 'servizi', 'metodo', 'attivita', 'sostenibilita-digitale', 'perform', 'openreport', 'case-studies', 'clienti', 'news', 'team', 'storia', 'lavora-con-noi' ) as $chiave ) {
		$altre[] = $pagine[ $chiave ];
	}
	// In un colpo solo e prima di accenderlo: Yoast riscrive il file a ogni modifica.
	$opzione = array(
		'llms_txt_selection_mode' => 'manual',
		'about_us_page'           => $pagine['chi-siamo'],
		'contact_page'            => $pagine['contatti'],
		'privacy_policy_page'     => $pagine['privacy'],
		'other_included_pages'    => $altre,
	);
	update_option( 'wpseo_llmstxt', $opzione + (array) get_option( 'wpseo_llmstxt', array() ) );
	WPSEO_Options::set( 'enable_llms_txt', true );
}

/**
 * Impostazioni di Yoast SEO.
 */
function refe_contenuti_yoast(): void {
	if ( ! class_exists( 'WPSEO_Options' ) ) {
		Refe_Contenuti_Stato::$esito['avvisi'][] = 'Yoast SEO non è attivo: le impostazioni SEO non sono state applicate.';
		return;
	}
	$logo         = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/refe-logo-quadrato.png', 'Refe' );
	$condivisione = refe_contenuti_media( REFE_CONTENUTI_DIR . 'media/refe-condivisione.png', 'Refe' );
	$azienda      = class_exists( 'Refe\Core\Impostazioni' ) ? Refe\Core\Impostazioni::tutte()['azienda'] : array();
	$opzioni      = array(
		// Aspetto nei motori di ricerca.
		'separator'                     => 'sc-mdash',
		'breadcrumbs-sep'               => '/',
		'breadcrumbs-home'              => 'Home',
		'title-home-wpseo'              => 'Refe — Strategie di sviluppo sostenibile',
		'title-page'                    => '%%title%% %%page%% %%sep%% %%sitename%%',
		'title-post'                    => '%%title%% %%page%% %%sep%% %%sitename%%',
		'metadesc-post'                 => '%%excerpt%%',
		'title-refe_case'               => '%%title%%: case study %%page%% %%sep%% %%sitename%%',
		'metadesc-refe_case'            => '%%excerpt%%',
		'schema-page-type-refe_case'    => 'WebPage',
		'schema-article-type-refe_case' => 'Article',
		'schema-article-type-post'      => 'Article',
		'title-tax-category'            => 'News: %%term_title%% %%page%% %%sep%% %%sitename%%',
		'metadesc-tax-category'         => 'Le news di Refe nella categoria %%term_title%%.',
		'title-search-wpseo'            => 'Ricerca: %%searchphrase%% %%page%% %%sep%% %%sitename%%',
		'title-404-wpseo'               => 'Pagina non trovata %%sep%% %%sitename%%',
		'disable-author'                => true,
		'disable-date'                  => true,
		'disable-post_format'           => true,
		'disable-attachment'            => true,
		'noindex-tax-post_tag'          => true,
		// Rappresentazione del sito.
		'company_or_person'             => 'company',
		'company_name'                  => 'Refe',
		'website_name'                  => 'Refe',
		'company_logo'                  => $logo ? wp_get_attachment_url( $logo ) : '',
		'company_logo_id'               => $logo,
		// Condivisione.
		'opengraph'                     => true,
		'twitter'                       => true,
		'og_default_image'              => $condivisione ? wp_get_attachment_url( $condivisione ) : '',
		'og_default_image_id'           => $condivisione,
		'open_graph_frontpage_image'    => $condivisione ? wp_get_attachment_url( $condivisione ) : '',
		'open_graph_frontpage_image_id' => $condivisione,
		'other_social_urls'             => array_values( array_filter( array( $azienda['linkedin'] ?? '', $azienda['instagram'] ?? '' ) ) ),
		'enable_xml_sitemap'            => true,
	);
	foreach ( $opzioni as $chiave => $valore ) {
		WPSEO_Options::set( $chiave, $valore );
	}
}
