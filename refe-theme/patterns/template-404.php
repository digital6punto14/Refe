<?php
/**
 * Title: Template 404
 * Slug: refe-theme/template-404
 * Inserter: no
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:template-part {"slug":"header-ridotta","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"},"anchor":"contenuto"} -->
<main id="contenuto" class="wp-block-group"><!-- wp:group {"align":"full","className":"refe-errore","style":{"spacing":{"blockGap":"10px"},"dimensions":{"minHeight":"90svh"}},"gradient":"errore","layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group alignfull refe-errore has-errore-gradient-background has-background" style="min-height:90svh"><!-- wp:heading {"level":1,"style":{"color":{"text":"#dce3ef"},"typography":{"fontSize":"clamp(70px, 6.7vw, 96.5px)","fontWeight":"500","lineHeight":"1.1","letterSpacing":"-2px","textAlign":"center"}}} -->
<h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#dce3ef;font-size:clamp(70px, 6.7vw, 96.5px);font-weight:500;letter-spacing:-2px;line-height:1.1">404</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#dce3ef"},"typography":{"fontSize":"clamp(24px, 2.5vw, 36px)","lineHeight":"1.3","letterSpacing":"-2px","textAlign":"center"}}} -->
<p class="has-text-align-center has-text-color" style="color:#dce3ef;font-size:clamp(24px, 2.5vw, 36px);letter-spacing:-2px;line-height:1.3">Oops, something wen’t wrong</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"13px"}}}} -->
<div class="wp-block-buttons" style="margin-top:13px"><!-- wp:button {"backgroundColor":"bright-blue-light","textColor":"white","className":"refe-torna","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"62px","right":"62px"}},"typography":{"fontSize":"16px","fontWeight":"400","lineHeight":"24px"}}} -->
<div class="wp-block-button refe-torna"><a class="wp-block-button__link has-white-color has-bright-blue-light-background-color has-text-color has-background has-custom-font-size wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="border-radius:8px;padding-top:12px;padding-right:62px;padding-bottom:12px;padding-left:62px;font-size:16px;font-weight:400;line-height:24px">Homepage</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
