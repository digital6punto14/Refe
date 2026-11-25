<?php
/**
 * Title: Racconto del progetto
 * Slug: refe-theme/racconto
 * Categories: refe-sezioni
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-white-blue refe-filigrana","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-white-blue refe-filigrana" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:heading -->
<h2 class="wp-block-heading">Titolo del racconto</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:paragraph {"fontSize":"lettura"} -->
<p class="has-lettura-font-size">Racconta il progetto in due o tre righe: il cliente, l’obiettivo, che cosa è cambiato.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"className":"is-style-wide","style":{"color":{"background":"#00308733"},"spacing":{"margin":{"top":"clamp(40px, 5vw, 72px)","bottom":"clamp(40px, 5vw, 72px)"}}}} -->
<hr class="wp-block-separator has-text-color has-alpha-channel-opacity has-background is-style-wide" style="margin-top:clamp(40px, 5vw, 72px);margin-bottom:clamp(40px, 5vw, 72px);background-color:#00308733;color:#00308733"/>
<!-- /wp:separator -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:heading -->
<h2 class="wp-block-heading">Il <em>percorso</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:paragraph {"fontSize":"lettura"} -->
<p class="has-lettura-font-size">Descrivi il percorso: come si è lavorato, con chi e in quali fasi.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"refe/campo","args":{"campo":"link_url"}},"text":{"source":"refe/campo","args":{"campo":"link_testo"}}}},"className":"is-style-secondario"} -->
<div class="wp-block-button is-style-secondario"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noopener">Il racconto del progetto</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
