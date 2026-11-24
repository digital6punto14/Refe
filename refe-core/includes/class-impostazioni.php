<?php
/**
 * Pagina «Impostazioni sito».
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Un'unica opzione, salvata con la Settings API e disponibile nella REST API.
 */
final class Impostazioni {

	public const OPZIONE = 'refe_impostazioni';
	private const GRUPPO = 'refe_impostazioni_gruppo';
	private const PAGINA = 'refe-impostazioni';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ) );
		add_action( 'admin_init', array( self::class, 'sezioni' ) );
		add_action( 'admin_menu', array( self::class, 'menu' ) );
		add_action( 'update_option_' . self::OPZIONE, 'wp_clean_theme_json_cache' );
	}

	/**
	 * Valori predefiniti: i dati pubblicati su refe.net e la resa della demo.
	 */
	public static function predefinite(): array {
		return array(
			'azienda'    => array(
				'nome'      => 'Refe Srl',
				'piva'      => '05123890963',
				'anno'      => '2006',
				'indirizzo' => 'Piazza Luigi di Savoia, 22',
				'cap'       => '20124',
				'citta'     => 'Milano',
				'provincia' => 'MI',
				'mappa'     => 'https://maps.google.com/?q=Piazza+Luigi+di+Savoia+22+Milano',
				'telefono'  => '02 3656 7111',
				'email'     => 'info@refe.net',
				'instagram' => 'https://www.instagram.com/refe.impact/',
				'linkedin'  => 'https://www.linkedin.com/company/refe-rendersi-conto-per-rendere-conto/',
			),
			'colori'     => array(
				'solar-ember'   => '#f95700',
				'midnight-moon' => '#021e42',
				'bright-blue'   => '#003087',
				'white-blue'    => '#dce3ec',
			),
			'caratteri'  => array(
				'testo'  => 'dm-sans',
				'titoli' => 'dm-sans',
			),
			'animazioni' => array(
				'titoli'    => 'sfocato',
				'testi'     => 'dal-basso',
				'durata'    => 1040,
				'ritardo'   => 52,
				'ripeti'    => true,
				'copertina' => true,
				'cursore'   => true,
				'passaggio' => true,
				'filtri'    => true,
				'linea'     => true,
			),
		);
	}

	/**
	 * Tutte le impostazioni, complete dei valori predefiniti.
	 */
	public static function tutte(): array {
		$salvate = get_option( self::OPZIONE, array() );
		return array_replace_recursive( self::predefinite(), is_array( $salvate ) ? $salvate : array() );
	}

	/**
	 * Un valore.
	 *
	 * @param string $gruppo Gruppo.
	 * @param string $chiave Chiave.
	 */
	public static function valore( string $gruppo, string $chiave ): mixed {
		return self::tutte()[ $gruppo ][ $chiave ] ?? null;
	}

	/**
	 * Registra l'opzione.
	 */
	public static function registra(): void {
		$proprieta = array();
		foreach ( self::predefinite() as $gruppo => $campi ) {
			$proprieta[ $gruppo ] = array(
				'type'                 => 'object',
				'additionalProperties' => false,
				'properties'           => array_map( static fn( $v ) => array( 'type' => is_bool( $v ) ? 'boolean' : ( is_int( $v ) ? 'integer' : 'string' ) ), $campi ),
			);
		}
		register_setting(
			self::GRUPPO,
			self::OPZIONE,
			array(
				'type'              => 'object',
				'label'             => __( 'Impostazioni sito Refe', 'refe-core' ),
				'default'           => self::predefinite(),
				'sanitize_callback' => array( self::class, 'pulisci' ),
				'show_in_rest'      => array(
					'schema' => array(
						'type'                 => 'object',
						'additionalProperties' => false,
						'properties'           => $proprieta,
					),
				),
			)
		);
	}

	/**
	 * Pulisce i valori. Quelli non inviati restano come sono: un salvataggio parziale non azzera gli altri.
	 *
	 * @param mixed $inviati Valori inviati.
	 */
	public static function pulisci( mixed $inviati ): array {
		$esito = self::tutte();
		if ( ! is_array( $inviati ) ) {
			return $esito;
		}
		foreach ( self::predefinite() as $gruppo => $campi ) {
			foreach ( $campi as $chiave => $base ) {
				if ( ! isset( $inviati[ $gruppo ][ $chiave ] ) ) {
					continue;
				}
				$v = $inviati[ $gruppo ][ $chiave ];
				if ( is_bool( $base ) ) {
					$v = rest_sanitize_boolean( $v );
				} elseif ( is_int( $base ) ) {
					$v = min( 5000, absint( $v ) );
				} elseif ( 'colori' === $gruppo ) {
					$v = sanitize_hex_color( $v ) ?? $base;
				} elseif ( 'email' === $chiave ) {
					$v = sanitize_email( $v );
				} elseif ( in_array( $chiave, array( 'mappa', 'instagram', 'linkedin' ), true ) ) {
					$v = esc_url_raw( $v );
				} elseif ( 'caratteri' === $gruppo ) {
					$v = array_key_exists( $v, self::caratteri() ) ? $v : $base;
				} elseif ( 'animazioni' === $gruppo ) {
					$v = array_key_exists( $v, Animazioni::tipi() ) ? $v : $base;
				} else {
					$v = sanitize_text_field( $v );
				}
				$esito[ $gruppo ][ $chiave ] = $v;
			}
		}
		return $esito;
	}

	/**
	 * Caratteri disponibili.
	 */
	public static function caratteri(): array {
		return array(
			'dm-sans' => __( 'DM Sans', 'refe-core' ),
			'sistema' => __( 'Font di sistema', 'refe-core' ),
		);
	}

	/**
	 * Voci di menu.
	 */
	public static function menu(): void {
		add_menu_page( __( 'Impostazioni sito', 'refe-core' ), __( 'Impostazioni sito', 'refe-core' ), 'manage_options', self::PAGINA, array( self::class, 'pagina' ), 'dashicons-admin-site-alt3', 59 );
	}

	/**
	 * Sezioni e campi.
	 */
	public static function sezioni(): void {
		$sezioni = array(
			'azienda'    => array( __( 'Dati aziendali', 'refe-core' ), __( 'Compaiono nel footer, nei contatti e nei dati per i motori di ricerca.', 'refe-core' ) ),
			'colori'     => array( __( 'Colori', 'refe-core' ), __( 'I quattro colori principali. Se ne cambi uno, le sue tonalità si ricalcolano.', 'refe-core' ) ),
			'caratteri'  => array( __( 'Caratteri', 'refe-core' ), '' ),
			'animazioni' => array( __( 'Animazioni', 'refe-core' ), __( 'Valgono per tutto il sito. Si possono cambiare per singola pagina e per singolo titolo.', 'refe-core' ) ),
		);
		$nomi    = array(
			'azienda.nome'         => __( 'Ragione sociale', 'refe-core' ),
			'azienda.piva'         => __( 'Partita IVA', 'refe-core' ),
			'azienda.anno'         => __( 'Anno di fondazione', 'refe-core' ),
			'azienda.indirizzo'    => __( 'Indirizzo', 'refe-core' ),
			'azienda.cap'          => __( 'CAP', 'refe-core' ),
			'azienda.citta'        => __( 'Città', 'refe-core' ),
			'azienda.provincia'    => __( 'Provincia', 'refe-core' ),
			'azienda.mappa'        => __( 'Link alla mappa', 'refe-core' ),
			'azienda.telefono'     => __( 'Telefono', 'refe-core' ),
			'azienda.email'        => __( 'Email', 'refe-core' ),
			'azienda.instagram'    => __( 'Instagram', 'refe-core' ),
			'azienda.linkedin'     => __( 'LinkedIn', 'refe-core' ),
			'colori.solar-ember'   => 'Solar Ember',
			'colori.midnight-moon' => 'Midnight Moon',
			'colori.bright-blue'   => 'Bright Blue',
			'colori.white-blue'    => 'White Blue',
			'caratteri.testo'      => __( 'Testi', 'refe-core' ),
			'caratteri.titoli'     => __( 'Titoli', 'refe-core' ),
			'animazioni.titoli'    => __( 'Ingresso dei titoli', 'refe-core' ),
			'animazioni.testi'     => __( 'Ingresso dei testi', 'refe-core' ),
			'animazioni.durata'    => __( 'Durata (millisecondi)', 'refe-core' ),
			'animazioni.ritardo'   => __( 'Ritardo tra le parole (millisecondi)', 'refe-core' ),
			'animazioni.ripeti'    => __( 'Ripeti a ogni passaggio', 'refe-core' ),
			'animazioni.copertina' => __( 'Sfondo animato della copertina', 'refe-core' ),
			'animazioni.cursore'   => __( 'Cursore Refe (solo con il mouse)', 'refe-core' ),
			'animazioni.passaggio' => __( 'Passaggio sfumato tra le pagine', 'refe-core' ),
			'animazioni.filtri'    => __( 'Riordino animato con i filtri', 'refe-core' ),
			'animazioni.linea'     => __( 'Linea che si disegna nella Storia', 'refe-core' ),
		);
		foreach ( $sezioni as $gruppo => $dati ) {
			add_settings_section(
				'refe_' . $gruppo,
				$dati[0],
				static function () use ( $dati ): void {
					if ( $dati[1] ) {
						echo '<p>' . esc_html( $dati[1] ) . '</p>';
					}
				},
				self::PAGINA
			);
			foreach ( self::predefinite()[ $gruppo ] as $chiave => $base ) {
				$id = "refe-{$gruppo}-{$chiave}";
				add_settings_field(
					$id,
					$nomi[ "{$gruppo}.{$chiave}" ],
					array( self::class, 'campo' ),
					self::PAGINA,
					'refe_' . $gruppo,
					array(
						'label_for' => $id,
						'gruppo'    => $gruppo,
						'chiave'    => $chiave,
						'base'      => $base,
					)
				);
			}
		}
	}

	/**
	 * Un campo della pagina.
	 *
	 * @param array $arg Dati del campo.
	 */
	public static function campo( array $arg ): void {
		$valore = self::valore( $arg['gruppo'], $arg['chiave'] );
		$nome   = self::OPZIONE . '[' . $arg['gruppo'] . '][' . $arg['chiave'] . ']';
		$scelte = array();
		if ( 'caratteri' === $arg['gruppo'] ) {
			$scelte = self::caratteri();
		} elseif ( in_array( $arg['chiave'], array( 'titoli', 'testi' ), true ) ) {
			$scelte = Animazioni::tipi();
			if ( 'testi' === $arg['chiave'] ) {
				unset( $scelte['sfocato'] );
			}
		}
		if ( $scelte ) {
			printf( '<select id="%s" name="%s">', esc_attr( $arg['label_for'] ), esc_attr( $nome ) );
			foreach ( $scelte as $k => $v ) {
				printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $valore, $k, false ), esc_html( $v ) );
			}
			echo '</select>';
		} elseif ( is_bool( $arg['base'] ) ) {
			// Il campo nascosto distingue «spento» da «non inviato».
			printf( '<input type="hidden" name="%1$s" value="0"><input type="checkbox" id="%2$s" name="%1$s" value="1"%3$s>', esc_attr( $nome ), esc_attr( $arg['label_for'] ), checked( $valore, true, false ) );
		} elseif ( is_int( $arg['base'] ) ) {
			printf( '<input type="number" min="0" max="5000" step="1" id="%s" name="%s" value="%s" class="small-text">', esc_attr( $arg['label_for'] ), esc_attr( $nome ), esc_attr( (string) $valore ) );
		} elseif ( 'colori' === $arg['gruppo'] ) {
			/* translators: %s: colore. */
			printf( '<input type="color" id="%s" name="%s" value="%s"> <code>%s</code> <span class="description">%s</span>', esc_attr( $arg['label_for'] ), esc_attr( $nome ), esc_attr( $valore ), esc_html( $valore ), esc_html( sprintf( __( 'Originale: %s', 'refe-core' ), $arg['base'] ) ) );
		} else {
			$tipo = match ( $arg['chiave'] ) {
				'email'                          => 'email',
				'mappa', 'instagram', 'linkedin' => 'url',
				default                          => 'text',
			};
			printf( '<input type="%s" id="%s" name="%s" value="%s" class="regular-text">', esc_attr( $tipo ), esc_attr( $arg['label_for'] ), esc_attr( $nome ), esc_attr( $valore ) );
		}
	}

	/**
	 * La pagina.
	 */
	public static function pagina(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		echo '<div class="wrap"><h1>' . esc_html( get_admin_page_title() ) . '</h1>';
		settings_errors();
		echo '<form action="options.php" method="post">';
		settings_fields( self::GRUPPO );
		do_settings_sections( self::PAGINA );
		submit_button();
		echo '</form>';
		Segnaposto::tabella();
		echo '</div>';
	}
}
