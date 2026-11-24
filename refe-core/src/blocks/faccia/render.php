<?php
/**
 * Faccia della scheda girevole.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;

$refe_lato = 'retro' === $attributes['lato'] ? 'retro' : 'fronte';
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-faccia refe-faccia--' . $refe_lato, 'style' => \Refe\Core\Blocchi::spazio( $attributes ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
