<?php
/**
 * Title: Chiusura con pulsanti
 * Slug: refe-theme/chiusura-pulsanti
 * Categories: refe-chiusure
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-solar-ember refe-filigrana","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-solar-ember refe-filigrana" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:group {"style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"constrained","contentSize":"900px","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading">Incontra <em>Refe</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contattaci</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-secondario"} -->
<div class="wp-block-button is-style-secondario"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/chi-siamo/lavora-con-noi/' ) ); ?>">Lavora con noi</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
