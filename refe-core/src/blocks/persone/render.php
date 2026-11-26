<?php
/**
 * Persone.
 *
 * @package RefeCore
 *
 * @var array $attributes Attributi.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_persone = Contenuti::schede( Contenuti::PERSONA, $attributes['scelte'], (int) $attributes['quante'] );
if ( ! $refe_persone ) {
	echo Plugin::vuoto( __( 'Nessuna persona: aggiungile dal menu Persone.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
$refe_attributi = get_block_wrapper_attributes(
	array(
		'class' => 'refe-persone',
		'style' => Blocchi::spazio( $attributes ),
	)
);
?>
<ul <?php echo $refe_attributi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributi composti da WordPress. ?>>
	<?php foreach ( $refe_persone as $refe_p ) : ?>
		<?php
		$refe_nome  = get_the_title( $refe_p );
		$refe_seg   = Segnaposto::e( $refe_p->ID );
		$refe_testo = Campi::testo( 'presentazione', $refe_p->ID );
		$refe_foto  = (int) Campi::leggi( 'immagine_retro', $refe_p->ID );
		$refe_gira  = '' !== $refe_testo || $refe_foto || $refe_seg;
		/* translators: %s: nome della persona. */
		$refe_guarda = sprintf( __( 'Leggi la presentazione di %s', 'refe-core' ), $refe_nome );
		?>
		<li class="refe-persona">
			<div class="refe-persona__interno">
				<div class="refe-persona__faccia refe-persona__fronte">
					<?php
					if ( has_post_thumbnail( $refe_p ) ) {
						echo get_the_post_thumbnail(
							$refe_p,
							'large',
							array(
								'alt'   => $refe_nome,
								'sizes' => '(max-width: 800px) 100vw, 25vw',
							)
						);
					} elseif ( $refe_seg ) {
						echo '<span class="refe-persona__nota refe-persona__manca">' . esc_html__( 'Foto da inserire', 'refe-core' ) . '</span>';
					}
					?>
					<span class="refe-persona__info"><strong><?php echo esc_html( $refe_nome ); ?></strong><span><?php echo esc_html( Campi::testo( 'ruolo', $refe_p->ID ) ); ?></span><span><?php echo esc_html( $refe_p->post_excerpt ); ?></span></span>
					<?php if ( $refe_gira ) : ?>
						<span class="refe-persona__vai"><?php echo esc_html( $attributes['testoLink'] ); ?> <?php echo Plugin::freccia(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php endif; ?>
				</div>
				<?php if ( $refe_gira ) : ?>
					<div class="refe-persona__faccia refe-persona__retro" aria-hidden="true" inert>
						<?php if ( $refe_foto ) : ?>
							<figure class="refe-persona__immagine"><?php echo wp_get_attachment_image( $refe_foto, 'large', false, array( 'sizes' => '(max-width: 800px) 100vw, 25vw' ) ); ?></figure>
						<?php elseif ( $refe_seg ) : ?>
							<figure class="refe-persona__immagine"><span class="refe-persona__nota"><?php esc_html_e( 'Immagine da inserire', 'refe-core' ); ?></span></figure>
						<?php endif; ?>
						<strong><?php echo esc_html( $refe_nome ); ?></strong>
						<div class="refe-persona__testo">
							<?php if ( '' !== $refe_testo ) : ?>
								<?php echo wp_kses_post( wpautop( esc_html( $refe_testo ) ) ); ?>
							<?php elseif ( $refe_seg ) : ?>
								<p><span class="refe-persona__nota"><?php esc_html_e( 'Presentazione da inserire', 'refe-core' ); ?></span></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( $refe_gira ) : ?>
				<button type="button" class="refe-persona__gira" aria-pressed="false" aria-label="<?php echo esc_attr( $refe_guarda ); ?>" data-apri="<?php echo esc_attr( $refe_guarda ); ?>" data-chiudi="<?php esc_attr_e( 'Torna alla foto', 'refe-core' ); ?>"></button>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
