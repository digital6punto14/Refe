<?php
/**
 * Stato dell'importazione.
 *
 * @package RefeContenuti
 */

defined( 'ABSPATH' ) || exit;

/**
 * Stato dell'importazione in corso.
 */
final class Refe_Contenuti_Stato {
	/**
	 * Vero se i contenuti esistenti vanno riscritti.
	 *
	 * @var bool
	 */
	public static bool $riscrivi = true;

	/**
	 * Contenuti creati o riscritti in questo giro.
	 *
	 * @var int[]
	 */
	public static array $toccati = array();

	/**
	 * Conteggi e avvisi.
	 *
	 * @var array
	 */
	public static array $esito = array();

	/**
	 * Azzera lo stato.
	 *
	 * @param bool $riscrivi Vero per riscrivere.
	 */
	public static function inizia( bool $riscrivi ): void {
		self::$riscrivi = $riscrivi;
		self::$toccati  = array();
		self::$esito    = array(
			'creati'    => 0,
			'riscritti' => 0,
			'lasciati'  => 0,
			'avvisi'    => array(),
		);
	}
}
