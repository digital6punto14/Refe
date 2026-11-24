<?php
/**
 * Title: Testata con foto
 * Slug: refe-theme/testata-foto
 * Categories: refe-testate
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-dialogo.webp' ) ); ?>","customOverlayColor":"#021e42","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.3},"contentPosition":"bottom left","align":"full","className":"is-style-testata","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left is-style-testata"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-dialogo.webp' ) ); ?>" style="object-position:50% 30%" data-object-fit="cover" data-object-position="50% 30%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#021e42"></span><div class="wp-block-cover__inner-container"><!-- wp:yoast-seo/breadcrumbs /-->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Gli esperti della sostenibilità</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"sommario"} -->
<p class="has-sommario-font-size">Lungo tutto il percorso.</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->
