<?php
/**
 * Ricerca in finestra.
 *
 * @package RefeCore
 *
 * @var array $attributes Attributi.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

wp_interactivity_state(
	'refe/ricerca',
	array(
		'fonte'     => rest_url( 'wp/v2/search' ),
		'tipi'      => array(
			'page'          => __( 'Pagina', 'refe-core' ),
			'post'          => __( 'News', 'refe-core' ),
			Contenuti::CASE => __( 'Case study', 'refe-core' ),
		),
		'messaggi'  => array(
			'corto'  => __( 'Scrivi almeno due caratteri.', 'refe-core' ),
			'vuoto'  => __( 'Nessun risultato. Prova con metodo, attività o piattaforme.', 'refe-core' ),
			'attesa' => __( 'Cerco…', 'refe-core' ),
			'errore' => __( 'La ricerca non è riuscita. Riprova.', 'refe-core' ),
			/* translators: %d: numero di risultati. */
			'uno'    => __( '%d risultato', 'refe-core' ),
			/* translators: %d: numero di risultati. */
			'molti'  => __( '%d risultati', 'refe-core' ),
		),
		'messaggio' => __( 'Scrivi almeno due caratteri.', 'refe-core' ),
		'risultati' => array(),
	)
);
$refe_id = wp_unique_id( 'refe-ricerca-' );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-ricerca' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-wp-interactive="refe/ricerca">
	<button type="button" class="refe-ricerca__apri" aria-label="<?php echo esc_attr( $attributes['titolo'] ); ?>" aria-haspopup="dialog" data-wp-on--click="actions.apri"></button>
	<dialog class="refe-ricerca__finestra" aria-labelledby="<?php echo esc_attr( $refe_id ); ?>-titolo" data-wp-on--click="actions.fuori" data-wp-on--close="actions.chiuso">
		<button type="button" class="refe-ricerca__chiudi" aria-label="<?php esc_attr_e( 'Chiudi ricerca', 'refe-core' ); ?>" data-wp-on--click="actions.chiudi">✕</button>
		<h2 id="<?php echo esc_attr( $refe_id ); ?>-titolo"><?php echo esc_html( $attributes['titolo'] ); ?></h2>
		<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<label for="<?php echo esc_attr( $refe_id ); ?>-campo"><?php echo esc_html( $attributes['etichetta'] ); ?></label>
			<input id="<?php echo esc_attr( $refe_id ); ?>-campo" type="search" name="s" placeholder="<?php echo esc_attr( $attributes['esempio'] ); ?>" autocomplete="off" data-wp-on--input="actions.scrivi">
		</form>
		<p class="refe-ricerca__stato" aria-live="polite" data-wp-text="state.messaggio"><?php esc_html_e( 'Scrivi almeno due caratteri.', 'refe-core' ); ?></p>
		<ul class="refe-ricerca__elenco">
			<template data-wp-each="state.risultati" data-wp-each-key="context.item.url">
				<li><a data-wp-bind--href="context.item.url"><span data-wp-text="context.item.titolo"></span> <small data-wp-text="context.item.tipo"></small></a></li>
			</template>
		</ul>
	</dialog>
</div>
