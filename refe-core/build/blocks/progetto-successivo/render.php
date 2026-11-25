<?php
/**
 * Progetto successivo.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var \WP_Block $block      Blocco.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_id     = (int) ( $block->context['postId'] ?? get_the_ID() );
$refe_tutti  = Contenuti::progetti( array() );
$refe_indice = array_search( $refe_id, wp_list_pluck( $refe_tutti, 'ID' ), true );
$refe_altro  = count( $refe_tutti ) > 1 || ( $refe_tutti && false === $refe_indice ) ? $refe_tutti[ false === $refe_indice ? 0 : ( $refe_indice + 1 ) % count( $refe_tutti ) ] : null;
if ( ! $refe_altro ) {
	echo Plugin::vuoto( __( 'Serve almeno un altro case study pubblicato.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>
<a <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-successivo' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> href="<?php echo esc_url( get_permalink( $refe_altro ) ); ?>">
	<?php echo get_the_post_thumbnail( $refe_altro, 'full', array( 'alt' => '', 'sizes' => '100vw', 'loading' => 'lazy', 'fetchpriority' => 'auto' ) ); ?>
	<span><?php echo esc_html( wp_strip_all_tags( $attributes['testo'] ) ); ?></span>
	<strong><?php echo esc_html( get_the_title( $refe_altro ) ); ?> <?php echo Plugin::freccia(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
	<span class="refe-successivo__testo"><?php echo esc_html( $refe_altro->post_excerpt ); ?></span>
</a>
