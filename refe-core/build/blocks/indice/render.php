<?php
/**
 * Indice della pagina.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var \WP_Block $block      Blocco.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_voci = Indice::voci( (int) ( $block->context['postId'] ?? get_the_ID() ) );
if ( $attributes['barra'] && ! Plugin::nell_editor() ) {
	echo '<div class="refe-lettura" aria-hidden="true"><span></span></div>';
}
if ( count( $refe_voci ) < 2 ) {
	echo Plugin::vuoto( __( 'L’indice si compone da solo quando la pagina ha almeno due titoli di livello 2.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>
<nav <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-indice is-style-vetro', 'aria-label' => wp_strip_all_tags( $attributes['titolo'] ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<strong><?php echo esc_html( wp_strip_all_tags( $attributes['titolo'] ) ); ?></strong>
	<?php foreach ( $refe_voci as $refe_v ) : ?>
		<a href="#<?php echo esc_attr( $refe_v['id'] ); ?>"><?php echo esc_html( $refe_v['testo'] ); ?></a>
	<?php endforeach; ?>
</nav>
