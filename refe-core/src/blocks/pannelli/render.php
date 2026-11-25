<?php
/**
 * Pannelli a scorrimento.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var string    $content    Blocchi interni.
 * @var \WP_Block $block      Blocco.
 */

defined( 'ABSPATH' ) || exit;

$refe_quanti = count( $block->inner_blocks );
if ( ! $refe_quanti ) {
	return;
}
$refe_immagine = $attributes['immagine'];
$refe_linea    = $attributes['linea'] && \Refe\Core\Impostazioni::valore( 'animazioni', 'linea' );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-pannelli' . ( $refe_linea ? ' con-linea' : '' ), 'style' => \Refe\Core\Blocchi::spazio( $attributes ) . '--n:' . $refe_quanti ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="refe-pannelli__scena">
		<?php if ( ! empty( $refe_immagine['url'] ) ) : ?>
			<img class="refe-pannelli__immagine" src="<?php echo esc_url( $refe_immagine['url'] ); ?>" alt="<?php echo esc_attr( $refe_immagine['alt'] ?? '' ); ?>" width="300" height="300" loading="lazy">
		<?php endif; ?>
		<div class="refe-pannelli__elenco" data-refe-ingresso="manuale"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
		<div class="refe-pannelli__punti" aria-hidden="true"><?php echo str_repeat( '<span></span>', $refe_quanti ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML fisso. ?></div>
	</div>
</div>
