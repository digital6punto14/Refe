<?php
/**
 * Copertina animata.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;

$refe_simbolo = $attributes['simbolo']['url'] ?? REFE_CORE_URL . 'assets/img/simbolo.svg';
$refe_venti   = $attributes['venti']['url'] ?? REFE_CORE_URL . 'assets/img/anniversario-20.svg';
$refe_video   = $attributes['video']['url'] ?? '';
// La copertina occupa il primo schermo: le immagini che seguono si caricano solo quando servono.
if ( function_exists( 'wp_high_priority_element_flag' ) ) {
	wp_high_priority_element_flag( false );
	wp_increase_content_media_count( 10 );
}
$refe_sfondo = $attributes['sfondo'] && \Refe\Core\Impostazioni::valore( 'animazioni', 'copertina' );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-copertina' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="refe-copertina__scena">
		<?php if ( $refe_sfondo ) : ?>
			<canvas class="refe-copertina__campo" aria-hidden="true"></canvas>
		<?php endif; ?>
		<div class="refe-copertina__alone" aria-hidden="true"></div>
		<div class="refe-copertina__simbolo" aria-hidden="true"><span class="refe-copertina__giro"><img src="<?php echo esc_url( $refe_simbolo ); ?>" width="53" height="48" alt=""></span></div>
		<div class="refe-copertina__posto" role="img" aria-label="<?php echo esc_attr( $attributes['descrizione'] ); ?>">
			<img class="refe-copertina__venti" src="<?php echo esc_url( $refe_venti ); ?>" width="86" height="59" alt="">
			<?php if ( $refe_video ) : ?>
				<video class="refe-copertina__video" data-src="<?php echo esc_url( $refe_video ); ?>" width="1140" height="920" muted loop playsinline preload="none" aria-hidden="true" tabindex="-1"></video>
			<?php endif; ?>
		</div>
		<div class="refe-copertina__testo">
			<div class="refe-copertina__comandi"><button type="button" class="refe-copertina__pausa" aria-pressed="false" data-pausa="<?php echo esc_attr( $attributes['testoPausa'] ); ?>" data-avvia="<?php echo esc_attr( $attributes['testoAvvia'] ); ?>" data-ridotto="<?php esc_attr_e( 'Movimento ridotto', 'refe-core' ); ?>"><?php echo esc_html( $attributes['testoPausa'] ); ?></button></div>
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?>
		</div>
	</div>
</section>
