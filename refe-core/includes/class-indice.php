<?php
/**
 * Indice automatico dai titoli.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Dà un'ancora ai titoli di livello 2 e ne ricava l'elenco.
 */
final class Indice {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'render_block_core/heading', array( self::class, 'ancora' ), 10, 2 );
	}

	/**
	 * Aggiunge l'id ai titoli che non ce l'hanno.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function ancora( string $html, array $blocco ): string {
		if ( 2 !== (int) ( $blocco['attrs']['level'] ?? 2 ) || ! is_singular() ) {
			return $html;
		}
		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( $tag->next_tag( 'H2' ) && ! $tag->get_attribute( 'id' ) ) {
			$id = self::id( $html );
			if ( '' !== $id ) {
				$tag->set_attribute( 'id', $id );
			}
		}
		return $tag->get_updated_html();
	}

	/**
	 * Ancora ricavata dal testo.
	 *
	 * @param string $html Titolo.
	 */
	private static function id( string $html ): string {
		return sanitize_title( wp_strip_all_tags( str_replace( '<br>', ' ', $html ) ) );
	}

	/**
	 * Titoli di livello 2 di un contenuto.
	 *
	 * @param int $id Contenuto.
	 * @return array<int,array{id:string,testo:string}>
	 */
	public static function voci( int $id ): array {
		$post = get_post( $id );
		return $post ? self::scorri( parse_blocks( $post->post_content ) ) : array();
	}

	/**
	 * Cerca i titoli nei blocchi.
	 *
	 * @param array $blocchi Blocchi.
	 */
	private static function scorri( array $blocchi ): array {
		$voci = array();
		foreach ( $blocchi as $b ) {
			if ( 'core/heading' === $b['blockName'] && 2 === (int) ( $b['attrs']['level'] ?? 2 ) ) {
				$testo = trim( wp_strip_all_tags( str_replace( '<br>', ' ', $b['innerHTML'] ) ) );
				$tag   = new \WP_HTML_Tag_Processor( $b['innerHTML'] );
				$id    = $tag->next_tag( 'H2' ) ? $tag->get_attribute( 'id' ) : '';
				if ( '' !== $testo ) {
					$voci[] = array(
						'id'    => is_string( $id ) && '' !== $id ? $id : self::id( $b['innerHTML'] ),
						'testo' => $testo,
					);
				}
			}
			$voci = array_merge( $voci, self::scorri( $b['innerBlocks'] ) );
		}
		return $voci;
	}
}
