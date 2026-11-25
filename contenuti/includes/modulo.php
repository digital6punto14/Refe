<?php
/**
 * Modulo di contatto in Contact Form 7.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Crea o aggiorna il modulo.
 *
 * @param string $privacy Indirizzo della Privacy Policy.
 * @return array{id:int,hash:string}
 */
function refe_contenuti_modulo( string $privacy ): array {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		Refe_Contenuti_Stato::$esito['avvisi'][] = 'Contact Form 7 non è attivo: il modulo di contatto non è stato creato.';
		return array(
			'id'   => 0,
			'hash' => '',
		);
	}
	$id     = refe_contenuti_trova( 'modulo:contatti', 'wpcf7_contact_form' );
	$modulo = $id ? wpcf7_contact_form( $id ) : null;
	if ( $modulo && ! Refe_Contenuti_Stato::$riscrivi ) {
		++Refe_Contenuti_Stato::$esito['lasciati'];
	} else {
		++Refe_Contenuti_Stato::$esito[ $modulo ? 'riscritti' : 'creati' ];
		$modulo = $modulo ? $modulo : WPCF7_ContactForm::get_template( array( 'title' => 'Contatti' ) );
		$modulo->set_title( 'Contatti' );
		$modulo->set_locale( 'it_IT' );
		$modulo->set_properties( refe_contenuti_modulo_proprieta( $privacy ) );
		$id = (int) $modulo->save();
		update_post_meta( $id, '_refe_chiave', 'modulo:contatti' );
		$modulo = wpcf7_contact_form( $id );
	}
	return array(
		'id'   => $id,
		'hash' => substr( (string) get_post_meta( $id, '_hash', true ), 0, 7 ),
	);
}

/**
 * Campi, email e messaggi.
 *
 * @param string $privacy Indirizzo della Privacy Policy.
 */
function refe_contenuti_modulo_proprieta( string $privacy ): array {
	$dominio = (string) preg_replace( '/^www\./', '', (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$da      = 'noreply@' . ( str_ends_with( $dominio, 'refe.net' ) ? 'refe.net' : $dominio );
	$leggi   = static fn( string $f ): string => trim( (string) file_get_contents( REFE_CONTENUTI_DIR . 'email/' . $f . '.html' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- File del plugin.
	$form    = '<div class="refe-campi">
<div class="refe-campo"><label for="nome">Nome e cognome</label>[text* nome id:nome autocomplete:name]</div>
<div class="refe-campo"><label for="organizzazione">Organizzazione</label>[text* organizzazione id:organizzazione autocomplete:organization]</div>
<div class="refe-campo"><label for="email">Email</label>[email* email id:email autocomplete:email]</div>
<div class="refe-campo"><label for="telefono">Telefono <span>(facoltativo)</span></label>[tel telefono id:telefono autocomplete:tel]</div>
<div class="refe-campo refe-campo--largo"><label for="argomento">Argomento</label>[select* argomento id:argomento first_as_label "Scegli un argomento" "Il metodo" "Attività" "Perform+" "OpenReport®" "Altro"]</div>
<div class="refe-campo refe-campo--largo"><label for="messaggio">Messaggio</label>[textarea* messaggio id:messaggio x5]</div>
</div>
<div class="refe-campo refe-campo--privacy">[acceptance privacy id:privacy] Ho letto l’informativa della <a href="' . esc_url( $privacy ) . '">Privacy Policy</a> [/acceptance]</div>
[submit "Invia"]';
	return array(
		'form'                => $form,
		'mail'                => array(
			'active'             => true,
			'subject'            => 'Richiesta dal sito: [argomento]',
			'sender'             => 'Sito Refe <' . $da . '>',
			'recipient'          => 'info@refe.net',
			'body'               => $leggi( 'notifica' ),
			'additional_headers' => 'Reply-To: [nome] <[email]>',
			'attachments'        => '',
			'use_html'           => true,
			'exclude_blank'      => false,
		),
		'mail_2'              => array(
			'active'             => true,
			'subject'            => 'Abbiamo ricevuto il tuo messaggio',
			'sender'             => 'Refe <' . $da . '>',
			'recipient'          => '[email]',
			'body'               => $leggi( 'conferma' ),
			'additional_headers' => 'Reply-To: info@refe.net',
			'attachments'        => '',
			'use_html'           => true,
			'exclude_blank'      => false,
		),
		'messages'            => array(
			'mail_sent_ok'        => 'Grazie, abbiamo ricevuto il tuo messaggio. Ti risponderemo al più presto.',
			'mail_sent_ng'        => 'Il messaggio non è partito. Riprova più tardi o scrivi a info@refe.net.',
			'validation_error'    => 'Controlla i campi segnalati.',
			'spam'                => 'Il messaggio non è partito. Riprova più tardi o scrivi a info@refe.net.',
			'accept_terms'        => 'Conferma di aver letto l’informativa',
			'invalid_required'    => 'Compila questo campo',
			'invalid_too_long'    => 'Il testo è troppo lungo',
			'invalid_too_short'   => 'Il testo è troppo corto',
			'invalid_email'       => 'Scrivi un indirizzo email valido, per esempio nome@azienda.it',
			'invalid_tel'         => 'Scrivi un numero di telefono valido',
			'invalid_url'         => 'Scrivi un indirizzo valido',
			'invalid_number'      => 'Scrivi un numero valido',
			'invalid_date'        => 'Scrivi una data valida',
		),
		'additional_settings' => 'acceptance_as_validation: on',
	);
}
