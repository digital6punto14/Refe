<?php
/**
 * Compatibilità con i browser del 2021 (Safari 14.1, iOS 14.5, Chrome 88).
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Due aiuti, caricati prima di tutto il resto e solo dove servono:
 * - Array.prototype.at, String.prototype.at e Object.hasOwn, usati da alcuni script di WordPress
 *   (Chrome prima della 92, Safari prima della 15.4);
 * - es-module-shims (MIT) dove il browser non conosce le import map (Safari prima della 16.4):
 *   senza, i moduli di WordPress non partono (menu da telefono, fisarmonica, tab, ricerca, filtri).
 *   Nei browser recenti non si scarica nulla.
 */
final class Compatibilita {

	private const SHIMS = '2.8.4';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'wp_head', array( self::class, 'stampa' ), 0 );
	}

	/**
	 * Script in linea, prima degli altri.
	 */
	public static function stampa(): void {
		$shims = add_query_arg( 'ver', self::SHIMS, REFE_CORE_URL . 'assets/js/es-module-shims.js' );
		$js    = '(function(){'
			. 'function at(n){n=Math.trunc(n)||0;if(n<0)n+=this.length;return n<0||n>=this.length?undefined:this[n];}'
			. 'var d=function(o,k,v){if(!o[k])Object.defineProperty(o,k,{value:v,writable:true,configurable:true});};'
			. 'd(Array.prototype,"at",at);d(String.prototype,"at",at);'
			. 'd(Object,"hasOwn",function(o,k){return Object.prototype.hasOwnProperty.call(o,k);});'
			. 'if(!(window.HTMLScriptElement&&HTMLScriptElement.supports&&HTMLScriptElement.supports("importmap"))){'
			. 'var s=document.createElement("script");s.async=true;s.src=' . wp_json_encode( $shims ) . ';document.head.appendChild(s);}'
			. '})();';
		wp_print_inline_script_tag( $js, array( 'id' => 'refe-compatibilita' ) );
	}
}
