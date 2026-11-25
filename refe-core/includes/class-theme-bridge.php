<?php
/**
 * Colori e caratteri globali: passano al tema tramite theme.json.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Il tema non legge opzioni: riceve i valori dal filtro di WordPress.
 */
final class Theme_Bridge {

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_filter( 'wp_theme_json_data_theme', array( self::class, 'filtra' ) );
	}

	/**
	 * Sostituisce palette e caratteri.
	 *
	 * @param \WP_Theme_JSON_Data $dati Dati del tema.
	 */
	public static function filtra( \WP_Theme_JSON_Data $dati ): \WP_Theme_JSON_Data {
		$imp   = Impostazioni::tutte();
		$base  = Impostazioni::predefinite();
		$nuovi = array( 'version' => 3 );

		if ( $imp['colori'] !== $base['colori'] ) {
			$attuali = $dati->get_data()['settings']['color']['palette'] ?? array();
			$palette = $attuali['theme'] ?? $attuali;
			if ( is_array( $palette ) && $palette ) {
				$nuovi['settings']['color']['palette'] = self::palette( $palette, $imp['colori'], $base['colori'] );
			}
		}
		if ( $imp['caratteri'] !== $base['caratteri'] ) {
			$nuovi['styles']['typography']['fontFamily']                        = 'var:preset|font-family|' . $imp['caratteri']['testo'];
			$nuovi['styles']['elements']['heading']['typography']['fontFamily'] = 'var:preset|font-family|' . $imp['caratteri']['titoli'];
		}
		return count( $nuovi ) > 1 ? $dati->update_with( $nuovi ) : $dati;
	}

	/**
	 * Palette con i colori scelti. Le tonalità seguono il loro colore principale.
	 *
	 * @param array $palette Palette del tema.
	 * @param array $scelti  Colori scelti.
	 * @param array $base    Colori originali.
	 */
	private static function palette( array $palette, array $scelti, array $base ): array {
		foreach ( $palette as &$voce ) {
			foreach ( $base as $slug => $originale ) {
				if ( $scelti[ $slug ] === $originale ) {
					continue;
				}
				if ( $voce['slug'] === $slug ) {
					$voce['color'] = $scelti[ $slug ];
				} elseif ( str_starts_with( $voce['slug'], $slug . '-' ) ) {
					$voce['color'] = self::sposta( $voce['color'], $originale, $scelti[ $slug ] );
				}
			}
		}
		return array_values( $palette );
	}

	/**
	 * Applica a un nuovo colore la stessa differenza che c'è tra una tonalità e il suo colore originale.
	 *
	 * @param string $tono      Tonalità.
	 * @param string $originale Colore originale.
	 * @param string $nuovo     Colore scelto.
	 */
	private static function sposta( string $tono, string $originale, string $nuovo ): string {
		$t = self::hsl( $tono );
		$o = self::hsl( $originale );
		$n = self::hsl( $nuovo );
		return self::hex( fmod( $n[0] + $t[0] - $o[0] + 720, 360 ), $n[1] + $t[1] - $o[1], $n[2] + $t[2] - $o[2] );
	}

	/**
	 * Da esadecimale a HSL.
	 *
	 * @param string $hex Colore.
	 * @return float[]
	 */
	private static function hsl( string $hex ): array {
		$hex = ltrim( $hex, '#' );
		if ( 3 === strlen( $hex ) ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		[ $r, $g, $b ] = array_map( static fn( $x ) => hexdec( $x ) / 255, str_split( $hex, 2 ) );
		$max           = max( $r, $g, $b );
		$min           = min( $r, $g, $b );
		$l             = ( $max + $min ) / 2;
		$d             = $max - $min;
		if ( 0.0 === (float) $d ) {
			return array( 0.0, 0.0, $l );
		}
		$s = $d / ( 1 - abs( 2 * $l - 1 ) );
		$h = match ( $max ) {
			$r      => fmod( ( $g - $b ) / $d + 6, 6 ),
			$g      => ( $b - $r ) / $d + 2,
			default => ( $r - $g ) / $d + 4,
		};
		return array( $h * 60, $s, $l );
	}

	/**
	 * Da HSL a esadecimale.
	 *
	 * @param float $h Tinta.
	 * @param float $s Saturazione.
	 * @param float $l Luminosità.
	 */
	private static function hex( float $h, float $s, float $l ): string {
		$s = max( 0, min( 1, $s ) );
		$l = max( 0, min( 1, $l ) );
		$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
		$x = $c * ( 1 - abs( fmod( $h / 60, 2 ) - 1 ) );
		$m = $l - $c / 2;

		[ $r, $g, $b ] = match ( (int) floor( $h / 60 ) % 6 ) {
			0       => array( $c, $x, 0 ),
			1       => array( $x, $c, 0 ),
			2       => array( 0, $c, $x ),
			3       => array( 0, $x, $c ),
			4       => array( $x, 0, $c ),
			default => array( $c, 0, $x ),
		};
		return sprintf( '#%02x%02x%02x', round( ( $r + $m ) * 255 ), round( ( $g + $m ) * 255 ), round( ( $b + $m ) * 255 ) );
	}
}
