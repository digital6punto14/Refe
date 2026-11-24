<?php
/**
 * Title: Fascia con foto, vetro chiaro
 * Slug: refe-theme/fascia-foto-chiara
 * Categories: refe-sezioni
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-laptop.webp' ) ); ?>","customOverlayColor":"#021e42","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.45},"align":"full","className":"is-style-fascia","layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull is-style-fascia"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/foto-laptop.webp' ) ); ?>" style="object-position:50% 45%" data-object-fit="cover" data-object-position="50% 45%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#021e42"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"is-style-vetro-forte","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-vetro-forte"><!-- wp:heading -->
<h2 class="wp-block-heading">Insieme a <em>OpenReport®</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Perform+ e OpenReport® traducono le due fasi del metodo in strumenti complementari, dalla gestione alla comunicazione della sostenibilità.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/openreport/' ) ); ?>">Scopri OpenReport®</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
