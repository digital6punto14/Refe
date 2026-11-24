<?php
/**
 * Campi ACF: caricamento, salvataggio in JSON e lettura.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * I gruppi stanno in acf-json; senza ACF i valori si leggono dai metadati.
 */
final class Campi {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'acf/settings/load_json', array( self::class, 'carica' ) );
		add_filter( 'acf/settings/save_json', array( self::class, 'salva' ) );
		add_filter( 'acf/settings/show_admin', array( self::class, 'mostra_admin' ) );
	}

	/**
	 * Aggiunge la cartella dei gruppi.
	 *
	 * @param array $cartelle Cartelle.
	 */
	public static function carica( array $cartelle ): array {
		$cartelle[] = REFE_CORE_DIR . 'acf-json';
		return $cartelle;
	}

	/**
	 * Cartella in cui ACF salva i gruppi modificati.
	 */
	public static function salva(): string {
		return REFE_CORE_DIR . 'acf-json';
	}

	/**
	 * Il menu di ACF serve solo all'amministratore.
	 */
	public static function mostra_admin(): bool {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Legge un campo.
	 *
	 * @param string $nome Nome.
	 * @param int    $id   Contenuto.
	 */
	public static function leggi( string $nome, int $id ): mixed {
		return function_exists( 'get_field' ) ? get_field( $nome, $id ) : get_post_meta( $id, $nome, true );
	}

	/**
	 * Legge un campo di testo.
	 *
	 * @param string $nome Nome.
	 * @param int    $id   Contenuto.
	 */
	public static function testo( string $nome, int $id ): string {
		$valore = self::leggi( $nome, $id );
		return is_scalar( $valore ) ? trim( (string) $valore ) : '';
	}

	/**
	 * Risultati compilati di un case study.
	 *
	 * @param int $id Contenuto.
	 * @return array<int,array{numero:string,testo:string}>
	 */
	public static function risultati( int $id ): array {
		$elenco = array();
		for ( $n = 1; $n <= 3; $n++ ) {
			$numero = self::testo( "risultato_{$n}_numero", $id );
			$testo  = self::testo( "risultato_{$n}_testo", $id );
			if ( '' !== $numero || '' !== $testo ) {
				$elenco[] = compact( 'numero', 'testo' );
			}
		}
		return $elenco;
	}
}
