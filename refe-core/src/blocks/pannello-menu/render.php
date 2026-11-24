<?php
/**
 * Voce di menu con pannello.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) ( $attributes['label'] ?? '' ) ) ) {
	return;
}

[ $refe_contenuto, $refe_attivo ] = \Refe\Core\Menu::segna_corrente( $content );
?>
<li <?php echo get_block_wrapper_attributes( array( 'class' => 'wp-block-navigation-item refe-pannello' . ( $refe_attivo ? ' is-section' : '' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<details>
		<summary class="wp-block-navigation-item__content"><?php echo esc_html( wp_strip_all_tags( $attributes['label'] ) ); ?></summary>
		<div class="refe-pannello__fascia"><?php echo $refe_contenuto; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
	</details>
</li>
