<?php
/**
 * Filtri degli elenchi, con la Interactivity API.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Stato, contesto e barra dei filtri. Senza JavaScript si vede l'elenco completo.
 */
final class Filtri {

	/**
	 * Stato derivato per la resa lato server.
	 */
	public static function stato(): void {
		wp_interactivity_state(
			'refe/filtri',
			array(
				'premuto'  => static function (): bool {
					$c = wp_interactivity_get_context();
					return ( $c['scelto'] ?? '' ) === ( $c['voce'] ?? null );
				},
				'nascosto' => static function (): bool {
					$c = wp_interactivity_get_context();
					return ! empty( $c['scelto'] ) && ! in_array( $c['scelto'], $c['categorie'] ?? array(), true );
				},
			)
		);
	}

	/**
	 * Contesto di un elenco.
	 *
	 * @param array  $voci  Categorie di ogni voce.
	 * @param string $uno   Messaggio per un risultato.
	 * @param string $molti Messaggio per più risultati.
	 */
	public static function contesto( array $voci, string $uno, string $molti ): array {
		return array(
			'scelto'    => '',
			'elenco'    => $voci,
			'uno'       => $uno,
			'molti'     => $molti,
			'messaggio' => '',
			'riordino'  => (bool) Impostazioni::valore( 'animazioni', 'filtri' ),
		);
	}

	/**
	 * Stampa la barra.
	 *
	 * @param array  $voci      Slug e nomi.
	 * @param string $etichetta Nome del gruppo.
	 */
	public static function barra( array $voci, string $etichetta ): void {
		echo '<div class="refe-filtri" role="group" aria-label="' . esc_attr( $etichetta ) . '">';
		foreach ( $voci as $slug => $nome ) {
			printf(
				'<button type="button" data-wp-on--click="actions.scegli" data-wp-bind--aria-pressed="state.premuto" %s>%s</button>',
				wp_interactivity_data_wp_context( array( 'voce' => (string) $slug ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Già pulito.
				esc_html( $nome )
			);
		}
		echo '</div><p class="refe-filtri-stato" aria-live="polite" data-wp-text="context.messaggio"></p>';
	}
}
