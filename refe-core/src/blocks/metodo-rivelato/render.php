<?php
/**
 * Metodo rivelato.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;

$refe_immagine = $attributes['immagine'];
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-metodo' . ( empty( $refe_immagine['url'] ) ? ' is-fermo' : '' ), 'style' => \Refe\Core\Blocchi::spazio( $attributes ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="refe-metodo__perno">
		<div class="refe-metodo__scena">
			<?php if ( ! empty( $refe_immagine['url'] ) ) : ?>
				<span class="refe-metodo__sigillo"><img src="<?php echo esc_url( $refe_immagine['url'] ); ?>" alt="<?php echo esc_attr( $refe_immagine['alt'] ?? '' ); ?>" width="150" height="150" data-refe-nitido></span>
			<?php endif; ?>
			<div class="refe-metodo__testo" data-refe-ingresso="manuale"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
		</div>
	</div>
</div>
