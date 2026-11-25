<?php
/**
 * Title: Testata con icona
 * Slug: refe-theme/testata-icona
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

<!-- wp:heading {"level":1,"fontSize":"grande"} -->
<h1 class="wp-block-heading has-grande-font-size">Perform+</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"sommario"} -->
<p class="has-sommario-font-size">Supporta la gestione di piani, indicatori, raccolta dati e reporting.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44.9%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44.9%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","align":"center","className":"is-style-mattonella"} -->
<figure class="wp-block-image aligncenter size-full is-style-mattonella"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/icona-perform-refe.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
