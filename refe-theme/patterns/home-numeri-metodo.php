<?php
/**
 * Title: Home: numeri e metodo
 * Slug: refe-theme/home-numeri-metodo
 * Categories: refe-home
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-bright-blue","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-bright-blue" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:0"><!-- wp:heading {"style":{"typography":{"fontSize":"clamp(28px, 3vw, 42px)","fontWeight":"500","lineHeight":"1.1","textAlign":"center"},"spacing":{"margin":{"bottom":"clamp(28px, 4vw, 52px)"}}}} -->
<h2 class="wp-block-heading has-text-align-center" style="margin-bottom:clamp(28px, 4vw, 52px);font-size:clamp(28px, 3vw, 42px);font-weight:500;line-height:1.1">I nostri numeri chiave</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"padding":{"bottom":"48px"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group" style="padding-bottom:48px"><!-- wp:group {"style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":null}} -->
<div class="wp-block-group"><!-- wp:refe/contatore {"numero":200,"etichetta":"clienti"} /-->

<!-- wp:refe/contatore {"numero":300,"etichetta":"report di sostenibilità"} /-->

<!-- wp:refe/contatore {"numero":12000,"etichetta":"persone formate"} /-->

<!-- wp:refe/contatore {"testo":"XX","etichetta":"XXX","segnaposto":true} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:refe/metodo-rivelato {"immagine":{"url":"<?php echo esc_url( get_theme_file_uri( 'assets/img/sticky-metodo.svg' ) ); ?>","alt":""}} -->
<!-- wp:paragraph {"className":"refe-occhiello"} -->
<p class="refe-occhiello">Metodo</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Rendersi conto per rendere conto</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rendersi conto per rendere conto® è il metodo proprietario che guida l’approccio di Refe dal 2006. Insieme rafforzano la coerenza tra ciò che un’organizzazione dichiara e ciò che realizza.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Rendersi conto</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>significa analizzare identità, priorità, responsabilità, risultati e impatti.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Per rendere conto</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>significa comunicare in modo trasparente, verificabile e accessibile.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/servizi/metodo/' ) ); ?>">Approfondisci il metodo</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:refe/metodo-rivelato --></section>
<!-- /wp:group -->
