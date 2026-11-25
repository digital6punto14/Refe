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
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class' => 'refe-tappa',
		'style' => \Refe\Core\Blocchi::spazio( $attributes ),
	)
);
?>
<div <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
