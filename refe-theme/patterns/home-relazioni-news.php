<?php
/**
 * Title: Home: relazioni e news
 * Slug: refe-theme/home-relazioni-news
 * Categories: refe-home
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/sfondo-relazioni.webp' ) ); ?>","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"customGradient":"linear-gradient(120deg,rgba(0,48,135,0.87) 0%,rgba(0,48,135,0.63) 100%)","tagName":"section","align":"full","className":"is-style-sezione","layout":{"type":"default"}} -->
<section class="wp-block-cover alignfull is-style-sezione"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sfondo-relazioni.webp' ) ); ?>" style="object-position:50% 50%" data-object-fit="cover" data-object-position="50% 50%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(120deg,rgba(0,48,135,0.87) 0%,rgba(0,48,135,0.63) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:refe/testimonianze -->
<!-- wp:heading -->
<h2 class="wp-block-heading"><em>Relazioni</em> che producono<br>valore nel tempo</h2>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/chi-siamo/storia/' ) ); ?>">La storia di Refe</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:refe/testimonianze -->

<!-- wp:refe/news {"formato":"scorrimento","style":{"spacing":{"margin":{"top":"40px"}}}} -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Ultime news</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-freccia"} -->
<p class="is-style-freccia"><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Tutte le news</a></p>
<!-- /wp:paragraph -->
<!-- /wp:refe/news --></div></section>
<!-- /wp:cover -->
