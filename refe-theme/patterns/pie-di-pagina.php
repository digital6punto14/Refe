<?php
/**
 * Title: Piè di pagina
 * Slug: refe-theme/pie-di-pagina
 * Inserter: no
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"color":{"background":"#0b2346","text":"#dce3ec"},"spacing":{"padding":{"top":"clamp(56px, 6vw, 84px)","left":"12px","right":"12px","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull has-text-color has-background" style="color:#dce3ec;background-color:#0b2346;padding-top:clamp(56px, 6vw, 84px);padding-right:12px;padding-bottom:0;padding-left:12px"><!-- wp:group {"style":{"spacing":{"padding":{"left":"20px","right":"20px","bottom":"clamp(28px, 3vw, 40px)"},"blockGap":"20px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group" style="padding-right:20px;padding-bottom:clamp(28px, 3vw, 40px);padding-left:20px"><!-- wp:heading {"style":{"typography":{"fontSize":"clamp(28px, 2.6vw, 40px)","lineHeight":"1.13","letterSpacing":"0","textAlign":"center"}},"textColor":"white"} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:clamp(28px, 2.6vw, 40px);letter-spacing:0;line-height:1.13">Ti aiutiamo a orientarti<br>nel mondo della sostenibilità</h2>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contattaci</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"refe-footer-pannello","style":{"border":{"radius":{"topLeft":"16px","topRight":"16px"}},"spacing":{"padding":{"top":"clamp(40px, 4vw, 56px)","left":"max(24px, calc(var(\u002d\u002drefe-margine) - 12px))","right":"max(24px, calc(var(\u002d\u002drefe-margine) - 12px))","bottom":"12px"},"blockGap":"0"}},"backgroundColor":"bright-blue","layout":{"type":"default"}} -->
<div class="wp-block-group refe-footer-pannello has-bright-blue-background-color has-background" style="border-top-left-radius:16px;border-top-right-radius:16px;padding-top:clamp(40px, 4vw, 56px);padding-right:max(24px, calc(var(--refe-margine) - 12px));padding-bottom:12px;padding-left:max(24px, calc(var(--refe-margine) - 12px))"><!-- wp:group {"className":"refe-footer-colonne","style":{"border":{"bottom":{"color":"#2f6cff","width":"1px"}},"spacing":{"padding":{"bottom":"16px"},"blockGap":"16px"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null}} -->
<div class="wp-block-group refe-footer-colonne" style="border-bottom-color:#2f6cff;border-bottom-width:1px;padding-bottom:16px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"14px","fontWeight":"400","lineHeight":"21px","letterSpacing":"0","textTransform":"uppercase"},"spacing":{"padding":{"bottom":"8px"}},"border":{"bottom":{"color":"#2f6cff","width":"1px"}}},"textColor":"solar-ember"} -->
<h3 class="wp-block-heading has-solar-ember-color has-text-color" style="border-bottom-color:#2f6cff;border-bottom-width:1px;padding-bottom:8px;font-size:14px;font-weight:400;letter-spacing:0;line-height:21px;text-transform:uppercase">Menù</h3>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-elenco-footer","style":{"typography":{"fontWeight":"700"}}} -->
<ul style="font-weight:700" class="wp-block-list is-style-elenco-footer"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/chi-siamo/' ) ); ?>">Chi siamo</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/attivita/' ) ); ?>">Cosa facciamo</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Case studies</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"14px","fontWeight":"400","lineHeight":"21px","letterSpacing":"0","textTransform":"uppercase"},"spacing":{"padding":{"bottom":"8px"}},"border":{"bottom":{"color":"#2f6cff","width":"1px"}}},"textColor":"solar-ember"} -->
<h3 class="wp-block-heading has-solar-ember-color has-text-color" style="border-bottom-color:#2f6cff;border-bottom-width:1px;padding-bottom:8px;font-size:14px;font-weight:400;letter-spacing:0;line-height:21px;text-transform:uppercase">Digital sustainability</h3>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-elenco-footer"} -->
<ul class="wp-block-list is-style-elenco-footer"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/openreport/' ) ); ?>">OpenReport®</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/servizi/sostenibilita-digitale/perform/' ) ); ?>">Perform+</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:list {"className":"is-style-elenco-footer refe-footer-legali"} -->
<ul class="wp-block-list is-style-elenco-footer refe-footer-legali"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/cookie-policy/' ) ); ?>">Cookies Policy</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"refe-footer-recapiti","style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group refe-footer-recapiti"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"14px","fontWeight":"400","lineHeight":"21px","letterSpacing":"0","textTransform":"uppercase"},"spacing":{"padding":{"bottom":"8px"}},"border":{"bottom":{"color":"#2f6cff","width":"1px"}}},"textColor":"solar-ember"} -->
<h3 class="wp-block-heading has-solar-ember-color has-text-color" style="border-bottom-color:#2f6cff;border-bottom-width:1px;padding-bottom:8px;font-size:14px;font-weight:400;letter-spacing:0;line-height:21px;text-transform:uppercase">Refe</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"indirizzo_compatto"}}}}} -->
<p><a href="https://maps.google.com/?q=Piazza+Luigi+di+Savoia+22+Milano">Piazza Luigi di Savoia,<br>22, 20124 Milano MI</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"telefono"}}}}} -->
<p><a href="tel:+390236567111">02 3656 7111</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"email"}}}}} -->
<p><a href="mailto:info@refe.net">info@refe.net</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"refe-footer-contatti","textColor":"solar-ember"} -->
<p class="refe-footer-contatti has-solar-ember-color has-text-color"><a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contattaci</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"refe-footer-fine","style":{"spacing":{"padding":{"top":"18px","bottom":"10px"},"blockGap":"18px"},"typography":{"fontSize":"11px","lineHeight":"1.5"}},"textColor":"bright-blue-pale","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group refe-footer-fine has-bright-blue-pale-color has-text-color" style="padding-top:18px;padding-bottom:10px;font-size:11px;line-height:1.5"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"refe/azienda","args":{"campo":"copyright"}}}}} -->
<p>© Refe Srl 2026 · P. IVA 05123890963</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"white","iconColorValue":"#ffffff","openInNewTab":true,"className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"20px"}}}} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only"><!-- wp:social-link {"url":"https://www.instagram.com/refe.impact/","service":"instagram","label":"Refe su Instagram"} /-->

<!-- wp:social-link {"url":"https://www.linkedin.com/company/refe-rendersi-conto-per-rendere-conto/","service":"linkedin","label":"Refe su LinkedIn"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:paragraph {"className":"refe-footer-credito"} -->
<p class="refe-footer-credito"><a href="https://6punto14.com/">Made with love by 6.14</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"refe-footer-su"} -->
<p class="refe-footer-su"><a href="#">Torna all’inizio</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
