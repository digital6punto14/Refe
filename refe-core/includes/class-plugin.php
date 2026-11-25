<?php
/**
 * Avvio del plugin.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Punto di ingresso: ogni area ha la sua classe.
 */
final class Plugin {

	/**
	 * Avvia le aree.
	 */
	public static function avvia(): void {
		foreach ( array( Contenuti::class, Campi::class, Impostazioni::class, Theme_Bridge::class, Collegamenti::class, Blocchi::class, Menu::class, Stili::class, Animazioni::class, Evidenza::class, Globali::class, Indice::class, Video::class, Editor::class, Modulo::class, Segnaposto::class ) as $area ) {
			$area::avvia();
		}
	}

	/**
	 * Attivazione: registra i tipi e aggiorna gli indirizzi.
	 */
	public static function attiva(): void {
		Contenuti::registra();
		flush_rewrite_rules();
	}

	/**
	 * Disattivazione.
	 */
	public static function disattiva(): void {
		flush_rewrite_rules();
	}

	/**
	 * Vero quando un blocco viene reso per l'editor (anteprima lato server).
	 */
	public static function nell_editor(): bool {
		return defined( 'REST_REQUEST' ) && REST_REQUEST && is_user_logged_in();
	}

	/**
	 * Stato vuoto di un blocco dinamico: nascosto sul sito, spiegato nell'editor.
	 *
	 * @param string $testo Spiegazione per chi modifica.
	 */
	public static function vuoto( string $testo ): string {
		if ( ! self::nell_editor() ) {
			return '<div class="refe-vuoto" hidden></div>';
		}
		return '<div class="refe-vuoto refe-vuoto--editor"><p>' . esc_html( $testo ) . '</p></div>';
	}

	/**
	 * Freccia decorativa.
	 *
	 * @param string $verso Classe del verso.
	 */
	public static function freccia( string $verso = '' ): string {
		return '<span class="refe-freccia ' . esc_attr( $verso ) . '" aria-hidden="true"></span>';
	}

	/**
	 * Pulsante di pausa.
	 *
	 * @param string $classe Classe.
	 * @param string $pausa  Etichetta per fermare.
	 * @param string $avvia  Etichetta per riprendere.
	 */
	public static function pausa( string $classe, string $pausa, string $avvia ): string {
		return sprintf(
			'<button type="button" class="refe-pausa %1$s" aria-pressed="false" aria-label="%2$s" data-pausa="%2$s" data-avvia="%3$s"><svg aria-hidden="true" width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path class="refe-pausa__ferma" d="M4 3h2v10H4zm6 0h2v10h-2z"/><path class="refe-pausa__avvia" d="m5 3 8 5-8 5z"/></svg></button>',
			esc_attr( $classe ),
			esc_attr( $pausa ),
			esc_attr( $avvia )
		);
	}
}
