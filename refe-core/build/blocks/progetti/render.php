<?php
/**
 * Case studies: griglia o carosello.
 *
 * @package RefeCore
 *
 * @var array $attributes Attributi.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_progetti = Contenuti::progetti( $attributes + array( 'escludi' => $attributes['escludiCorrente'] ? get_the_ID() : 0 ) );
if ( ! $refe_progetti ) {
	echo Plugin::vuoto( __( 'Nessun case study da mostrare: aggiungine uno o cambia le opzioni del blocco.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$refe_carosello = 'carosello' === $attributes['formato'];
$refe_voci      = array();
$refe_tipi      = array();
foreach ( $refe_progetti as $refe_p ) {
	$refe_t = Contenuti::termini( $refe_p->ID, Contenuti::TIPO_CLIENTE );
	foreach ( $refe_t as $refe_termine ) {
		$refe_tipi[ $refe_termine->slug ] = $refe_termine->name;
	}
	$refe_voci[] = wp_list_pluck( $refe_t, 'slug' );
}
ksort( $refe_tipi );
$refe_filtri = $attributes['filtri'] && count( $refe_tipi ) > 1;
Filtri::stato();
$refe_contesto = Filtri::contesto( $refe_voci, __( '%d progetto visualizzato', 'refe-core' ), __( '%d progetti visualizzati', 'refe-core' ) );
$refe_wrapper  = get_block_wrapper_attributes(
	array(
		'class' => 'refe-progetti is-' . ( $refe_carosello ? 'carosello' : 'griglia' ),
		'style' => Blocchi::spazio( $attributes ) . '--colonne:' . (int) $attributes['colonne'],
	)
);
?>
<div <?php echo $refe_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-wp-interactive="refe/filtri" <?php echo wp_interactivity_data_wp_context( $refe_contesto ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	if ( $refe_filtri ) {
		Filtri::barra( array( '' => $attributes['testoTutti'] ) + $refe_tipi, __( 'Filtra i case studies', 'refe-core' ) );
	}
	if ( $refe_carosello ) :
		?>
		<div class="refe-progetti__comandi"><button type="button" class="refe-progetti__prima" aria-label="<?php esc_attr_e( 'Progetto precedente', 'refe-core' ); ?>"><?php echo Plugin::freccia( 'sinistra' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button><button type="button" class="refe-progetti__dopo" aria-label="<?php esc_attr_e( 'Progetto successivo', 'refe-core' ); ?>"><?php echo Plugin::freccia( 'destra' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button></div>
	<?php endif; ?>
	<ul class="refe-progetti__elenco"<?php echo $refe_carosello ? ' data-pista' : ''; ?>>
		<?php foreach ( $refe_progetti as $refe_i => $refe_p ) : ?>
			<?php
			$refe_etichetta = implode( ', ', wp_list_pluck( Contenuti::termini( $refe_p->ID, Contenuti::SOLUZIONE ), 'name' ) );
			$refe_ambito    = $refe_carosello ? Campi::testo( 'ambito', $refe_p->ID ) : '';
			$refe_etichetta = implode( ' / ', array_filter( array( $refe_etichetta, $refe_ambito ) ) );
			?>
			<li data-voce data-wp-bind--hidden="state.nascosto" <?php echo wp_interactivity_data_wp_context( array( 'categorie' => $refe_voci[ $refe_i ] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<a class="refe-progetto" href="<?php echo esc_url( get_permalink( $refe_p ) ); ?>">
					<?php echo get_the_post_thumbnail( $refe_p, 'large', array( 'alt' => '', 'sizes' => $refe_carosello ? '(max-width: 800px) 82vw, 30vw' : '(max-width: 800px) 100vw, 50vw' ) ); ?>
					<span class="refe-progetto__info">
						<?php if ( '' !== $refe_etichetta ) : ?>
							<span class="refe-progetto__etichetta"><?php echo esc_html( $refe_etichetta ); ?></span>
						<?php endif; ?>
						<strong><?php echo esc_html( get_the_title( $refe_p ) ); ?></strong>
						<span class="refe-progetto__testo"><?php echo esc_html( $refe_p->post_excerpt ); ?></span>
					</span>
					<span class="refe-progetto__vai"><?php echo esc_html( $attributes['testoLink'] ); ?> <?php echo Plugin::freccia(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
