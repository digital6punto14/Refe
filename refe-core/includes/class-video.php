<?php
/**
 * Video di terze parti: si caricano solo al clic.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Al posto del lettore c'è un pulsante; niente richieste esterne finché non si clicca.
 */
final class Video {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'render_block_core/embed', array( self::class, 'incorpora' ), 10, 2 );
	}

	/**
	 * Indirizzo del lettore senza cookie.
	 *
	 * @param string $url Indirizzo del video.
	 */
	public static function lettore( string $url ): string {
		if ( preg_match( '~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([\w-]{6,})~i', $url, $m ) ) {
			return 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?autoplay=1&rel=0';
		}
		if ( preg_match( '~vimeo\.com/(?:video/)?(\d+)~i', $url, $m ) ) {
			return 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1&dnt=1';
		}
		return '';
	}

	/**
	 * Sostituisce i video incorporati con un pulsante.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function incorpora( string $html, array $blocco ): string {
		$lettore = self::lettore( (string) ( $blocco['attrs']['url'] ?? '' ) );
		if ( '' === $lettore ) {
			return $html;
		}
		wp_enqueue_style( 'refe-comune' );
		wp_enqueue_script_module( Blocchi::modulo( 'video' ) );
		return sprintf(
			'<figure class="wp-block-embed refe-video" data-refe-video="%1$s"><button type="button" class="refe-video__avvia" aria-label="%2$s"></button><p class="refe-video__nota">%3$s</p></figure>',
			esc_url( $lettore ),
			esc_attr__( 'Avvia il video', 'refe-core' ),
			esc_html__( 'Il video si carica da un servizio esterno quando lo avvii.', 'refe-core' )
		);
	}
}
