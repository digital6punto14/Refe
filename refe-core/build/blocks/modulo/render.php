<?php
/**
 * Modulo del corso.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;
?>
<details <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-modulo' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo $attributes['aperto'] ? ' open' : ''; ?>>
	<summary><?php echo esc_html( wp_strip_all_tags( $attributes['titolo'] ) ); ?></summary>
	<ul class="refe-modulo__lezioni"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></ul>
</details>
