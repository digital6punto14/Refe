<?php
/**
 * Title: Testata con sigillo
 * Slug: refe-theme/testata-sigillo
 * Categories: refe-testate
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"is-style-testata","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull is-style-testata"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"clamp(28px, 5vw, 80px)"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"bottom","width":"51.2%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:51.2%"><!-- wp:yoast-seo/breadcrumbs /-->

<!-- wp:heading {"level":1,"fontSize":"grande"} -->
<h1 class="wp-block-heading has-grande-font-size">Rendersi conto per rendere conto®</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"sommario"} -->
<p class="has-sommario-font-size">Il metodo proprietario che guida l’approccio di Refe dal 2006.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"48.8%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48.8%"><!-- wp:image {"width":"340px","sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sticky-metodo.svg' ) ); ?>" alt="" style="width:340px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
