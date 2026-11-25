<?php
/**
 * Contact Form 7: file solo dove serve, messaggi ed etichette per le email.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Se Contact Form 7 non è attivo non succede nulla.
 */
final class Modulo {

	private const BLOCCO = 'contact-form-7/contact-form-selector';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'wpcf7_load_js', '__return_false' );
		add_filter( 'wpcf7_load_css', '__return_false' );
		add_filter( 'wpcf7_autop_or_not', '__return_false' );
		add_action( 'wp_enqueue_scripts', array( self::class, 'carica' ), 20 );
		add_action( 'wpcf7_swv_create_schema', array( self::class, 'regole' ), 5 );
		add_filter( 'wpcf7_special_mail_tags', array( self::class, 'etichette' ), 10, 3 );
	}

	/**
	 * Script e stile solo nelle pagine con il modulo.
	 */
	public static function carica(): void {
		if ( ! function_exists( 'wpcf7_enqueue_scripts' ) || ! is_singular() ) {
			return;
		}
		$post = get_post();
		if ( $post && self::contiene( parse_blocks( $post->post_content ) ) ) {
			wpcf7_enqueue_scripts();
			wpcf7_enqueue_styles();
			wp_enqueue_script_module( Blocchi::modulo( 'modulo' ) );
		}
	}

	/**
	 * Cerca il modulo nei blocchi, anche dentro i pattern sincronizzati.
	 *
	 * @param array $blocchi Blocchi.
	 * @param int   $livello Profondità dei pattern sincronizzati.
	 */
	private static function contiene( array $blocchi, int $livello = 0 ): bool {
		foreach ( $blocchi as $b ) {
			if ( self::BLOCCO === $b['blockName'] || self::contiene( $b['innerBlocks'], $livello ) ) {
				return true;
			}
			if ( 'core/block' === $b['blockName'] && $livello < 3 ) {
				$sincro = get_post( (int) ( $b['attrs']['ref'] ?? 0 ) );
				if ( $sincro && self::contiene( parse_blocks( $sincro->post_content ), $livello + 1 ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Messaggio proprio per il campo Argomento.
	 *
	 * @param object $schema Schema di convalida.
	 */
	public static function regole( $schema ): void {
		if ( function_exists( 'wpcf7_swv_create_rule' ) ) {
			$schema->addRule(
				wpcf7_swv_create_rule(
					'required',
					array(
						'field' => 'argomento',
						'error' => __( 'Scegli un argomento', 'refe-core' ),
					)
				)
			);
		}
	}

	/**
	 * Dati aziendali nelle email: [_refe_nome], [_refe_indirizzo], [_refe_telefono], [_refe_email], [_refe_logo], [_refe_privacy].
	 *
	 * @param string|null $valore Valore.
	 * @param string      $nome   Etichetta.
	 * @param bool        $html   Email in HTML.
	 */
	public static function etichette( $valore, $nome, $html ) {
		$nome = ltrim( (string) $nome, '_' );
		if ( ! str_starts_with( $nome, 'refe_' ) ) {
			return $valore;
		}
		$a     = Impostazioni::tutte()['azienda'];
		$esito = match ( $nome ) {
			'refe_nome'      => $a['nome'],
			'refe_indirizzo' => "{$a['indirizzo']} · {$a['cap']} {$a['citta']} {$a['provincia']}",
			'refe_telefono'  => $a['telefono'],
			'refe_email'     => $a['email'],
			'refe_logo'      => REFE_CORE_URL . 'assets/img/logo-email.png',
			'refe_privacy'   => get_privacy_policy_url(),
			default          => null,
		};
		return null === $esito ? $valore : ( $html ? esc_html( $esito ) : $esito );
	}
}
