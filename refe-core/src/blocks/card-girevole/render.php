<?php
/**
 * Scheda girevole.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

defined( 'ABSPATH' ) || exit;

$refe_nome = '' !== $attributes['nome'] ? $attributes['nome'] : __( 'questa scheda', 'refe-core' );
/* translators: %s: nome della scheda. */
$refe_apri = sprintf( __( 'Mostra le attività con %s', 'refe-core' ), $refe_nome );
/* translators: %s: nome della scheda. */
$refe_chiudi    = sprintf( __( 'Torna alla scheda %s', 'refe-core' ), $refe_nome );
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class'      => 'refe-girevole filigrana-' . $attributes['filigrana'],
		'aria-label' => $refe_nome,
	)
);
?>
<article <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>>
	<div class="refe-girevole__facce"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
	<button type="button" class="refe-girevole__gira" aria-expanded="false" aria-label="<?php echo esc_attr( $refe_apri ); ?>" data-apri="<?php echo esc_attr( $refe_apri ); ?>" data-chiudi="<?php echo esc_attr( $refe_chiudi ); ?>" data-tocca="<?php esc_attr_e( 'Tocca per vedere le attività', 'refe-core' ); ?>" data-torna="<?php esc_attr_e( 'Tocca per tornare alla scheda', 'refe-core' ); ?>" data-retro="<?php esc_attr_e( 'Attività sul retro', 'refe-core' ); ?>" data-fronte="<?php esc_attr_e( 'Panoramica sul fronte', 'refe-core' ); ?>" hidden><span class="refe-girevole__nota" aria-hidden="true"></span></button>
</article>
