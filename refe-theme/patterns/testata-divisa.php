<?php
/**
 * Title: Testata divisa con foto
 * Slug: refe-theme/testata-divisa
 * Categories: refe-testate
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"is-style-testata","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull is-style-testata"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"clamp(28px, 5vw, 80px)","left":"clamp(28px, 5vw, 80px)"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"bottom","width":"55.1%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:55.1%"><!-- wp:yoast-seo/breadcrumbs /-->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Competenze diverse</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"sommario"} -->
<p class="has-sommario-font-size">Una direzione comune.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44.9%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44.9%"><!-- wp:image {"focalPoint":{"x":0.3,"y":0.4},"sizeSlug":"full","linkDestination":"none","className":"is-style-a-filo"} -->
<figure class="wp-block-image size-full is-style-a-filo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-dialogo.webp' ) ); ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
