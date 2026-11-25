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
		$refe_link  = Video::lettore( Campi::testo( 'video_link', $refe_p->ID ) );
		$refe_file  = (int) Campi::leggi( 'video_file', $refe_p->ID );
		$refe_file  = $refe_file ? (string) wp_get_attachment_url( $refe_file ) : '';
		$refe_video = $refe_link ? $refe_link : $refe_file;
		$refe_prova = ! $refe_video && $refe_seg ? (string) ( $attributes['video']['url'] ?? '' ) : '';
		$refe_gira  = $refe_video || $refe_seg;
		/* translators: %s: nome della persona. */
		$refe_guarda = sprintf( __( 'Guarda il video di %s', 'refe-core' ), $refe_nome );
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
					<div class="refe-persona__faccia refe-persona__retro" aria-hidden="true" inert<?php echo $refe_video ? ' data-video="' . esc_url( $refe_video ) . '"' : ''; ?> data-titolo="<?php echo esc_attr( $refe_guarda ); ?>">
						<?php if ( $refe_prova ) : ?>
							<video class="refe-persona__prova" src="<?php echo esc_url( $refe_prova ); ?>" width="1140" height="920" muted loop playsinline preload="none" tabindex="-1"></video>
						<?php endif; ?>
						<?php if ( ! $refe_video ) : ?>
							<span class="refe-persona__nota"><?php esc_html_e( 'Video da inserire', 'refe-core' ); ?></span>
						<?php endif; ?>
						<strong><?php echo esc_html( $refe_nome ); ?></strong>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( $refe_gira ) : ?>
				<button type="button" class="refe-persona__gira" aria-pressed="false" aria-label="<?php echo esc_attr( $refe_guarda ); ?>" data-apri="<?php echo esc_attr( $refe_guarda ); ?>" data-chiudi="<?php esc_attr_e( 'Torna alla foto', 'refe-core' ); ?>"></button>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
