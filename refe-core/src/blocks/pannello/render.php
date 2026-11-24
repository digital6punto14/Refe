<?php
/**
 * Pannello.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-tappa', 'style' => \Refe\Core\Blocchi::spazio( $attributes ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
