<?php
/**
 * Title: Fascia con foto, vetro scuro
 * Slug: refe-theme/fascia-foto-scura
 * Categories: refe-sezioni
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-sopralluogo.webp' ) ); ?>","customOverlayColor":"#021e42","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.3},"align":"full","className":"is-style-fascia","layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull is-style-fascia"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-sopralluogo.webp' ) ); ?>" style="object-position:50% 30%" data-object-fit="cover" data-object-position="50% 30%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#021e42"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"is-style-vetro-scuro refe-a-destra","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-vetro-scuro refe-a-destra"><!-- wp:heading -->
<h2 class="wp-block-heading">Dal progetto al <em>territorio</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Progetti di strategia, misurazione e rendicontazione della sostenibilità.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Guarda i case studies</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
