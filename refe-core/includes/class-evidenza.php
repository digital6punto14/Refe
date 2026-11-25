<?php
/**
 * Colore in evidenza: parole chiave, virgolette, frecce e altri dettagli.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Si sceglie su una sezione, su un blocco o su un singolo titolo. Senza scelta vale quello dello schema.
 */
final class Evidenza {

	/** Blocchi core con il controllo, oltre a tutti quelli del plugin. */
	private const CORE = array( 'core/group', 'core/columns', 'core/column', 'core/cover', 'core/heading', 'core/post-title', 'core/paragraph' );

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'register_block_type_args', array( self::class, 'attributo' ), 10, 2 );
		add_filter( 'render_block', array( self::class, 'segna' ), 10, 2 );
	}

	/**
	 * Vero se il blocco ha il controllo.
	 *
	 * @param string $nome Blocco.
	 */
	public static function ammesso( string $nome ): bool {
		return in_array( $nome, self::CORE, true ) || str_starts_with( $nome, 'refe/' );
	}

	/**
	 * Aggiunge l'attributo.
	 *
	 * @param array  $arg  Argomenti.
	 * @param string $nome Blocco.
	 */
	public static function attributo( array $arg, string $nome ): array {
		if ( self::ammesso( $nome ) ) {
			$arg['attributes']['refeEvidenza'] = array( 'type' => 'string' );
		}
		return $arg;
	}

	/**
	 * Valore CSS: colore della palette o esadecimale.
	 *
	 * @param string $valore Valore dell'attributo.
	 */
	public static function css( string $valore ): string {
		if ( preg_match( '/^var:preset\|color\|([a-z0-9-]+)$/', $valore, $m ) ) {
			return 'var(--wp--preset--color--' . $m[1] . ')';
		}
		return preg_match( '/^#([0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $valore ) ? $valore : '';
	}

	/**
	 * Porta il colore nell'HTML del blocco.
	 *
	 * @param string $html   HTML.
	 * @param array  $blocco Blocco.
	 */
	public static function segna( string $html, array $blocco ): string {
		$scelta = $blocco['attrs']['refeEvidenza'] ?? '';
		if ( ! is_string( $scelta ) || '' === $scelta || ! self::ammesso( (string) $blocco['blockName'] ) ) {
			return $html;
		}
		$css = self::css( $scelta );
		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( $css && $tag->next_tag() ) {
			$stile = rtrim( (string) $tag->get_attribute( 'style' ), '; ' );
			$tag->set_attribute( 'style', ( $stile ? $stile . ';' : '' ) . '--refe-evidenza:' . $css );
		}
		return $tag->get_updated_html();
	}
}
