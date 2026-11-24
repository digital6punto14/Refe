<?php
/**
 * Title: Modulo e recapiti
 * Slug: refe-theme/recapiti
 * Categories: refe-sezioni
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-solar-ember refe-filigrana","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-solar-ember refe-filigrana" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"clamp(28px, 5vw, 80px)"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"63%"} -->
<div class="wp-block-column" style="flex-basis:63%"><!-- wp:group {"className":"is-style-vetro","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-vetro"><!-- wp:heading -->
<h2 class="wp-block-heading">Raccontaci il <em>tuo progetto</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-nota"} -->
<p class="is-style-nota">Inserisci qui il modulo di Contact Form 7.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"37%"} -->
<div class="wp-block-column" style="flex-basis:37%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Scrivici o chiamaci</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"email"}}}},"className":"refe-recapito"} -->
<p class="refe-recapito"><a href="mailto:info@refe.net">info@refe.net</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"telefono"}}}},"className":"refe-recapito"} -->
<p class="refe-recapito"><a href="tel:+390236567111">02 3656 7111</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Vieni a trovarci</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"indirizzo"}}}},"className":"refe-recapito"} -->
<p class="refe-recapito"><a href="https://maps.google.com/?q=Piazza+Luigi+di+Savoia+22+Milano">Piazza Luigi di Savoia, 22<br>20124 Milano MI</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
