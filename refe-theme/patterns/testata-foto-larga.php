<?php
/**
 * Title: Testata con foto, titolo lungo
 * Slug: refe-theme/testata-foto-larga
 * Categories: refe-testate
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-sala.webp' ) ); ?>","customOverlayColor":"#021e42","isUserOverlayColor":true,"focalPoint":{"x":0.4,"y":0.6},"contentPosition":"bottom left","align":"full","className":"is-style-testata","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left is-style-testata"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-sala.webp' ) ); ?>" style="object-position:40% 60%" data-object-fit="cover" data-object-position="40% 60%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#021e42"></span><div class="wp-block-cover__inner-container"><!-- wp:yoast-seo/breadcrumbs /-->

<!-- wp:heading {"level":1,"fontSize":"grande"} -->
<h1 class="wp-block-heading has-grande-font-size">Ti aiutiamo a orientarti nel mondo della sostenibilità</h1>
<!-- /wp:heading --></div></div>
<!-- /wp:cover -->
