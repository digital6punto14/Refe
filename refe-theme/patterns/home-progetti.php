<?php
/**
 * Title: Home: carosello dei case studies
 * Slug: refe-theme/home-progetti
 * Categories: refe-home
 *
 * @package RefeTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"is-style-schema-white-blue refe-cielo","style":{"spacing":{"padding":{"top":"var:preset|spacing|sezione","bottom":"var:preset|spacing|sezione"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-schema-white-blue refe-cielo" style="padding-top:var(--wp--preset--spacing--sezione);padding-bottom:var(--wp--preset--spacing--sezione)"><!-- wp:heading {"style":{"typography":{"fontSize":"clamp(32px, calc(24px + 1vw), 37.9px)","lineHeight":"1.13"}}} -->
<h2 class="wp-block-heading" style="font-size:clamp(32px, calc(24px + 1vw), 37.9px);line-height:1.13">Progetti che trasformano, integrando <br><strong>la <em>sostenibilità in maniera strategica.</em></strong></h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"17px","bottom":"20px"}}},"layout":{"type":"constrained","contentSize":"540px","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-top:17px;margin-bottom:20px"><!-- wp:paragraph {"style":{"color":{"text":"#4e607a"},"typography":{"fontSize":"13px","lineHeight":"1.5"}}} -->
<p class="has-text-color" style="color:#4e607a;font-size:13px;line-height:1.5">Progetti di strategia, misurazione e rendicontazione della sostenibilità.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:refe/progetti {"formato":"carosello","filtri":true} /-->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"18px"}}}} -->
<div class="wp-block-buttons" style="margin-top:18px"><!-- wp:button {"className":"is-style-secondario"} -->
<div class="wp-block-button is-style-secondario"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Tutti i case studies</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
