<?php
/**
 * Testimonianze.
 *
 * @package RefeCore
 *
 * @var array  $attributes Attributi.
 * @var string $content    Blocchi interni.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_voci = array_filter( Contenuti::schede( Contenuti::TESTIMONIANZA, $attributes['scelte'], (int) $attributes['quante'] ), static fn( $v ) => '' !== Campi::testo( 'citazione', $v->ID ) );
if ( ! $refe_voci ) {
	echo Plugin::vuoto( __( 'Nessuna testimonianza: aggiungile dal menu Testimonianze.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
ob_start();
?>
<div class="refe-voci__slider" role="region" aria-roledescription="<?php esc_attr_e( 'carosello', 'refe-core' ); ?>" aria-label="<?php esc_attr_e( 'Dicono di noi', 'refe-core' ); ?>" data-intervallo="<?php echo esc_attr( (string) $attributes['intervallo'] ); ?>">
	<div class="refe-voci__finestra"><ul class="refe-voci__pista">
		<?php foreach ( $refe_voci as $refe_v ) : ?>
			<li class="refe-voce"><figure>
				<blockquote data-refe-testo><?php echo esc_html( Campi::testo( 'citazione', $refe_v->ID ) ); ?></blockquote>
				<figcaption><strong><?php echo esc_html( get_the_title( $refe_v ) ); ?></strong><span><?php echo esc_html( Campi::testo( 'ruolo', $refe_v->ID ) ); ?></span></figcaption>
			</figure></li>
		<?php endforeach; ?>
	</ul></div>
	<?php echo count( $refe_voci ) > 1 ? Plugin::pausa( 'refe-voci__pausa', __( 'Metti in pausa le testimonianze', 'refe-core' ), __( 'Riprendi le testimonianze', 'refe-core' ) ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<?php
$refe_slider = ob_get_clean();
// Nell'editor il testo a fianco è già nei blocchi: si manda solo lo slider.
if ( '' === trim( $content ) ) {
	echo $refe_slider; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Composto sopra.
	return;
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'refe-voci', 'style' => Blocchi::spazio( $attributes ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="refe-voci__testo"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?></div>
	<?php echo $refe_slider; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Composto sopra. ?>
</div>
