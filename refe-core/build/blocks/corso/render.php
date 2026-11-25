<?php
/**
 * Videocorso.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var string    $content    Blocchi interni.
 * @var \WP_Block $block      Blocco.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_lezioni = array();
foreach ( $block->parsed_block['innerBlocks'] as $refe_modulo ) {
	foreach ( $refe_modulo['innerBlocks'] as $refe_l ) {
		$refe_lezioni[] = $refe_l['attrs'];
	}
}
if ( ! $refe_lezioni ) {
	return;
}
/* translators: 1: lezioni completate, 2: lezioni totali. */
$refe_conto     = __( '%1$d di %2$d lezioni completate', 'refe-core' );
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class' => 'refe-corso',
		'style' => Blocchi::spazio( $attributes ),
	)
);
?>
<div <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>data-corso="<?php echo esc_attr( 'refe-corso-' . get_the_ID() ); ?>" data-manca="<?php esc_attr_e( 'Video da inserire', 'refe-core' ); ?>" data-conto="<?php echo esc_attr( $refe_conto ); ?>">
	<div class="refe-corso__lettore">
		<?php if ( ! empty( $attributes['immagine']['url'] ) ) : ?>
			<img src="<?php echo esc_url( $attributes['immagine']['url'] ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<button type="button" class="refe-corso__avvia" aria-label="<?php esc_attr_e( 'Avvia il video', 'refe-core' ); ?>"></button>
		<p class="refe-corso__avviso" role="status"></p>
		<div class="refe-corso__titolo is-style-vetro-scuro"><strong><?php echo esc_html( wp_strip_all_tags( $refe_lezioni[0]['titolo'] ?? '' ) ); ?></strong><span><?php echo esc_html( $refe_lezioni[0]['durata'] ?? '00:00' ); ?></span></div>
	</div>
	<div class="refe-corso__moduli">
		<div class="refe-corso__stato"><span aria-live="polite"><?php echo esc_html( sprintf( $refe_conto, 0, count( $refe_lezioni ) ) ); ?></span><div class="refe-corso__barra"><span></span></div></div>
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?>
	</div>
</div>
