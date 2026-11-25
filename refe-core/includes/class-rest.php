<?php
/**
 * REST in sola lettura: refe/v1.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Espone il servizio Dati. Sono gli stessi contenuti che si leggono sul sito.
 */
final class Rest {

	public const BASE = 'refe/v1';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'rest_api_init', array( self::class, 'registra' ) );
	}

	/**
	 * Registra le rotte.
	 */
	public static function registra(): void {
		$quanti = array(
			'type'    => 'integer',
			'minimum' => 1,
			'maximum' => 50,
			'default' => 20,
		);
		$slug   = array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_title',
			'validate_callback' => 'rest_validate_request_arg',
		);
		self::rotta( '/azienda', static fn() => Dati::azienda() );
		self::rotta( '/servizi', static fn() => Dati::servizi() );
		self::rotta(
			'/case-studies',
			static fn( \WP_REST_Request $r ) => Dati::progetti( $r->get_params() ),
			array(
				'tipo_cliente' => $slug,
				'soluzione'    => $slug,
				'quanti'       => $quanti,
			)
		);
		self::rotta(
			'/news',
			static fn( \WP_REST_Request $r ) => Dati::news( $r->get_params() ),
			array(
				'categoria' => $slug,
				'quanti'    => $quanti,
			)
		);
		self::rotta(
			'/ricerca',
			static fn( \WP_REST_Request $r ) => Dati::cerca( (string) $r['q'], (int) $r['quanti'] ),
			array(
				'q'      => array(
					'type'              => 'string',
					'required'          => true,
					'minLength'         => 2,
					'sanitize_callback' => 'sanitize_text_field',
					'validate_callback' => 'rest_validate_request_arg',
				),
				'quanti' => array_merge( $quanti, array( 'default' => 10 ) ),
			)
		);
	}

	/**
	 * Registra una rotta in sola lettura.
	 *
	 * @param string   $percorso  Percorso.
	 * @param callable $leggi     Lettura.
	 * @param array    $argomenti Argomenti.
	 */
	private static function rotta( string $percorso, callable $leggi, array $argomenti = array() ): void {
		register_rest_route(
			self::BASE,
			$percorso,
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => static fn( \WP_REST_Request $r ) => rest_ensure_response( $leggi( $r ) ),
				'permission_callback' => '__return_true', // Dati già pubblici sul sito.
				'args'                => $argomenti,
			)
		);
	}
}
