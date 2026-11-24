<?php
/**
 * Title: Template single
 * Slug: refe-theme/template-single
 * Inserter: no
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"},"anchor":"contenuto"} -->
<main id="contenuto" class="wp-block-group"><!-- wp:cover {"useFeaturedImage":true,"customOverlayColor":"#021e42","isUserOverlayColor":true,"contentPosition":"bottom left","align":"full","className":"is-style-testata","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left is-style-testata"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#021e42"></span><div class="wp-block-cover__inner-container"><!-- wp:yoast-seo/breadcrumbs /-->

<!-- wp:post-title {"level":1,"fontSize":"grande"} /-->

<!-- wp:post-excerpt {"excerptLength":60,"fontSize":"sommario"} /-->

<!-- wp:post-date {"format":"d.m.Y","className":"is-style-etichetta"} /--></div></div>
<!-- /wp:cover -->

<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-white-blue","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-white-blue" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"clamp(32px, 6vw, 96px)"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"25.3%","className":"refe-segue refe-colonna-indice"} -->
<div class="wp-block-column refe-segue refe-colonna-indice" style="flex-basis:25.3%"><!-- wp:refe/indice {"titolo":"In questo articolo"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"className":"refe-prosa"} -->
<div class="wp-block-column refe-prosa"><!-- wp:post-content {"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/sfondo-relazioni.webp' ) ); ?>","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.5},"customGradient":"linear-gradient(120deg,rgba(0,48,135,0.87) 0%,rgba(0,48,135,0.63) 100%)","tagName":"section","align":"full","className":"is-style-sezione","layout":{"type":"default"}} -->
<section class="wp-block-cover alignfull is-style-sezione"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sfondo-relazioni.webp' ) ); ?>" style="object-position:50% 50%" data-object-fit="cover" data-object-position="50% 50%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(120deg,rgba(0,48,135,0.87) 0%,rgba(0,48,135,0.63) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:refe/news {"formato":"scorrimento","escludiCorrente":true,"style":{"spacing":{"margin":{"top":"0"}}}} -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Altre news</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-freccia"} -->
<p class="is-style-freccia"><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Tutte le news</a></p>
<!-- /wp:paragraph -->
<!-- /wp:refe/news --></div></section>
<!-- /wp:cover --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
