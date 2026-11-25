<?php
/**
 * News: griglia con filtri o striscia a scorrimento.
 *
 * @package RefeCore
 *
 * @var array     $attributes Attributi.
 * @var string    $content    Blocchi interni.
 * @var \WP_Block $block      Blocco.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_articoli = get_posts(
	array_filter(
		array(
			'numberposts'  => $attributes['quante'] > 0 ? (int) $attributes['quante'] : -1,
			'cat'          => (int) $attributes['categoria'],
			'post__not_in' => $attributes['escludiCorrente'] ? array( (int) ( $block->context['postId'] ?? get_the_ID() ) ) : array(), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
		)
	)
);
if ( ! $refe_articoli ) {
	echo Plugin::vuoto( __( 'Nessun articolo da mostrare.', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$refe_striscia  = 'scorrimento' === $attributes['formato'];
$refe_voci      = array();
$refe_categorie = array();
foreach ( $refe_articoli as $refe_a ) {
	$refe_t = Contenuti::termini( $refe_a->ID, 'category' );
	foreach ( $refe_t as $refe_termine ) {
		$refe_categorie[ $refe_termine->slug ] = $refe_termine->name;
	}
	$refe_voci[] = wp_list_pluck( $refe_t, 'slug' );
}
ksort( $refe_categorie );
Filtri::stato();
/* translators: %d: quanti elementi. */
$refe_uno = __( '%d notizia visualizzata', 'refe-core' );
/* translators: %d: quanti elementi. */
$refe_molti    = __( '%d notizie visualizzate', 'refe-core' );
$refe_contesto = Filtri::contesto( $refe_voci, $refe_uno, $refe_molti );
$refe_wrapper  = get_block_wrapper_attributes(
	array(
		'class' => 'refe-news is-' . ( $refe_striscia ? 'striscia' : 'griglia' ),
		'style' => Blocchi::spazio( $attributes ) . '--giro:' . (int) $attributes['durata'] . 's',
	)
);
?>
<div <?php echo $refe_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-wp-interactive="refe/filtri" <?php echo wp_interactivity_data_wp_context( $refe_contesto ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $refe_striscia && '' !== trim( $content ) ) : ?>
		<div class="refe-news__testa"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocchi già resi. ?><?php echo Plugin::pausa( 'refe-news__pausa', __( 'Metti in pausa lo scorrimento delle news', 'refe-core' ), __( 'Riprendi lo scorrimento delle news', 'refe-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php
	endif;
	if ( ! $refe_striscia && $attributes['filtri'] && count( $refe_categorie ) > 1 ) {
		Filtri::barra( array( '' => $attributes['testoTutte'] ) + $refe_categorie, __( 'Filtra le news', 'refe-core' ) );
	}
	?>
	<div class="refe-news__finestra"><div class="refe-news__pista">
		<ul class="refe-news__elenco">
			<?php foreach ( $refe_articoli as $refe_i => $refe_a ) : ?>
				<li data-voce data-wp-bind--hidden="state.nascosto" <?php echo wp_interactivity_data_wp_context( array( 'categorie' => $refe_voci[ $refe_i ] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<a class="refe-notizia" href="<?php echo esc_url( get_permalink( $refe_a ) ); ?>">
						<span class="refe-notizia__dati"><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $refe_a ) ); ?>"><?php echo esc_html( get_the_date( 'd.m.Y', $refe_a ) ); ?></time>
							<?php foreach ( Contenuti::termini( $refe_a->ID, 'category' ) as $refe_termine ) : ?>
								<span><?php echo esc_html( $refe_termine->name ); ?></span>
							<?php endforeach; ?>
						</span>
						<strong><?php echo esc_html( get_the_title( $refe_a ) ); ?></strong>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div></div>
</div>
