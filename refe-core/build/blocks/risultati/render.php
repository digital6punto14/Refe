<?php
/**
 * Risultati del case study.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var \WP_Block $block      Blocco.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_id        = (int) ( $block->context['postId'] ?? get_the_ID() );
$refe_risultati = Campi::risultati( $refe_id );
$refe_seg       = Segnaposto::e( $refe_id );
if ( ! $refe_risultati ) {
	echo Plugin::vuoto( __( 'I risultati si scrivono nei campi «Dati del case study», sotto il contenuto. Finché sono vuoti, la sezione non si vede sul sito.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class' => 'refe-risultati' . ( $refe_seg ? ' is-segnaposto' : '' ),
		'style' => Blocchi::spazio( $attributes ),
	)
);
?>
<div <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>>
	<?php if ( $refe_seg ) : ?>
		<p class="is-style-nota"><?php esc_html_e( 'Dati da definire con Refe', 'refe-core' ); ?></p>
	<?php endif; ?>
	<ul class="refe-risultati__elenco">
		<?php foreach ( $refe_risultati as $refe_r ) : ?>
			<li class="is-style-scheda"><strong><?php echo esc_html( $refe_r['numero'] ); ?></strong><span><?php echo esc_html( $refe_r['testo'] ); ?></span></li>
		<?php endforeach; ?>
	</ul>
</div>
