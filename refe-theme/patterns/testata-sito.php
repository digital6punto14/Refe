<?php
/**
 * Title: Testata del sito
 * Slug: refe-theme/testata-sito
 * Inserter: no
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignfull"><!-- wp:site-logo {"width":154,"shouldSyncIcon":false} /-->

<!-- wp:navigation {"icon":"menu","layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"},"ariaLabel":"Menu principale"} -->
<!-- wp:navigation-link {"label":"Home","url":"<?php echo esc_url( home_url( '/' ) ); ?>","kind":"custom"} /-->

<!-- wp:refe/pannello-menu {"label":"Chi siamo"} -->
<!-- wp:columns {"verticalAlignment":"center","isStackedOnMobile":false} -->
<div class="wp-block-columns are-vertically-aligned-center is-not-stacked-on-mobile"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:list {"className":"is-style-voci-menu"} -->
<ul class="wp-block-list is-style-voci-menu"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/chi-siamo/' ) ); ?>">Mission</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/chi-siamo/team/' ) ); ?>">Il team</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/chi-siamo/lavora-con-noi/' ) ); ?>">Jobs</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/chi-siamo/storia/' ) ); ?>">20 anni di Refe</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"35%","style":{"border":{"left":{"color":"#c8ddf652","width":"1px"}},"spacing":{"padding":{"left":"17px"}}}} -->
<div class="wp-block-column" style="border-left-color:#c8ddf652;border-left-width:1px;padding-left:17px;flex-basis:35%"><!-- wp:paragraph {"className":"refe-occhiello"} -->
<p class="refe-occhiello">Chi siamo</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px"}}} -->
<p style="font-size:14px">Un team multidisciplinare, costruito sulle esigenze del tuo progetto.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"128px"} -->
<div class="wp-block-column" style="flex-basis:128px"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"12px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/menu-team.png' ) ); ?>" alt="Il team Refe" style="border-radius:12px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:refe/pannello-menu -->

<!-- wp:refe/pannello-menu {"label":"Servizi"} -->
<!-- wp:columns {"verticalAlignment":"center","isStackedOnMobile":false} -->
<div class="wp-block-columns are-vertically-aligned-center is-not-stacked-on-mobile"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:list {"className":"is-style-voci-menu"} -->
<ul class="wp-block-list is-style-voci-menu"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/' ) ); ?>">Servizi</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/metodo/' ) ); ?>">Il metodo</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/attivita/' ) ); ?>">Attività</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/' ) ); ?>">Piattaforme</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"35%","style":{"border":{"left":{"color":"#c8ddf652","width":"1px"}},"spacing":{"padding":{"left":"17px"}}}} -->
<div class="wp-block-column" style="border-left-color:#c8ddf652;border-left-width:1px;padding-left:17px;flex-basis:35%"><!-- wp:paragraph {"className":"refe-occhiello"} -->
<p class="refe-occhiello">Digital sustainability</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/perform/' ) ); ?>">Scopri Perform+</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-secondario"} -->
<div class="wp-block-button is-style-secondario"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/openreport/' ) ); ?>">Scopri OpenReport®</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"128px"} -->
<div class="wp-block-column" style="flex-basis:128px"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sticky-metodo.svg' ) ); ?>" alt="Rendersi conto per rendere conto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:refe/pannello-menu -->

<!-- wp:refe/pannello-menu {"label":"Case studies"} -->
<!-- wp:columns {"verticalAlignment":"center","isStackedOnMobile":false} -->
<div class="wp-block-columns are-vertically-aligned-center is-not-stacked-on-mobile"><!-- wp:column {"width":"38.5%"} -->
<div class="wp-block-column" style="flex-basis:38.5%"><!-- wp:list {"className":"is-style-voci-menu"} -->
<ul class="wp-block-list is-style-voci-menu"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Best case</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"61.5%"} -->
<div class="wp-block-column" style="flex-basis:61.5%"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"is-style-anteprima"} -->
<figure class="wp-block-image size-full is-style-anteprima"><a href="<?php echo esc_url( home_url( '/case-studies/regione-puglia/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/case-puglia.webp' ) ); ?>" alt="Il portale di rendicontazione di Regione Puglia"/></a><figcaption class="wp-element-caption">Regione Puglia</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:refe/pannello-menu -->

<!-- wp:navigation-link {"label":"Clienti","url":"<?php echo esc_url( home_url( '/clienti/' ) ); ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"News","url":"<?php echo esc_url( home_url( '/news/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation -->

<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contatti</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
