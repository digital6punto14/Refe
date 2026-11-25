<?php
/**
 * Contatore.
 *
 * @package RefeCore
 *
 * @var array $attributes Attributi.
 */

defined( 'ABSPATH' ) || exit;

$refe_testo     = trim( $attributes['testo'] );
$refe_dati      = '' === $refe_testo ? ' data-valore="' . esc_attr( (string) $attributes['numero'] ) . '"' : '';
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class' => 'refe-contatore' . ( $attributes['segnaposto'] ? ' is-segnaposto' : '' ),
		'style' => \Refe\Core\Blocchi::spazio( $attributes ),
	)
);
?>
<div <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>>
	<strong><?php echo esc_html( $attributes['prefisso'] ); ?><span<?php echo $refe_dati; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Già pulito. ?>><?php echo esc_html( '' !== $refe_testo ? $refe_testo : number_format_i18n( (float) $attributes['numero'] ) ); ?></span><?php echo esc_html( $attributes['suffisso'] ); ?></strong>
	<span class="refe-contatore__etichetta" data-refe-testo><?php echo esc_html( wp_strip_all_tags( $attributes['etichetta'] ) ); ?></span>
</div>
