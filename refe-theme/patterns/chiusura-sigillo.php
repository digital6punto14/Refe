<?php
/**
 * Title: Chiusura con sigillo
 * Slug: refe-theme/chiusura-sigillo
 * Categories: refe-chiusure
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-solar-ember refe-filigrana","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-solar-ember refe-filigrana" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"clamp(24px, 4vw, 56px)"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"210px","className":"refe-sigillo"} -->
<div class="wp-block-column is-vertically-aligned-center refe-sigillo" style="flex-basis:210px"><!-- wp:image {"width":"210px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sticky-metodo.svg' ) ); ?>" alt="" style="width:210px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","className":"refe-linea"} -->
<div class="wp-block-column is-vertically-aligned-center refe-linea"><!-- wp:heading -->
<h2 class="wp-block-heading">Un percorso adatto alla <em>tua organizzazione</em></h2>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/servizi/metodo/' ) ); ?>">Approfondisci il metodo</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
