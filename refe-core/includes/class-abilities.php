<?php
/**
 * Abilities in sola lettura per gli agenti AI.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Adattatori del servizio Dati: nessuna scrive nulla.
 */
final class Abilities {

	private const CATEGORIA = 'refe';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'wp_abilities_api_categories_init', array( self::class, 'categoria' ) );
		add_action( 'wp_abilities_api_init', array( self::class, 'registra' ) );
	}

	/**
	 * Categoria.
	 */
	public static function categoria(): void {
		wp_register_ability_category(
			self::CATEGORIA,
			array(
				'label'       => __( 'Refe', 'refe-core' ),
				'description' => __( 'Informazioni pubbliche del sito Refe, in sola lettura.', 'refe-core' ),
			)
		);
	}

	/**
	 * Registra le abilities.
	 */
	public static function registra(): void {
		$testo  = array( 'type' => 'string' );
		$testi  = array(
			'type'  => 'array',
			'items' => $testo,
		);
		$scheda = array(
			'id'          => array( 'type' => 'integer' ),
			'titolo'      => $testo,
			'descrizione' => $testo,
			'url'         => array(
				'type'   => 'string',
				'format' => 'uri',
			),
		);
		$quanti = array(
			'type'        => 'integer',
			'minimum'     => 1,
			'maximum'     => 50,
			'default'     => 20,
			'description' => __( 'Quanti elementi restituire.', 'refe-core' ),
		);

		self::ability(
			'get-company',
			__( 'Dati aziendali', 'refe-core' ),
			__( 'Ragione sociale, indirizzo, recapiti e profili social di Refe.', 'refe-core' ),
			array(),
			array(
				'type'       => 'object',
				'properties' => array(
					'nome'            => $testo,
					'ragione_sociale' => $testo,
					'descrizione'     => $testo,
					'partita_iva'     => $testo,
					'fondazione'      => $testo,
					'indirizzo'       => array(
						'type'       => 'object',
						'properties' => array(
							'via'       => $testo,
							'cap'       => $testo,
							'citta'     => $testo,
							'provincia' => $testo,
							'paese'     => $testo,
						),
					),
					'telefono'        => $testo,
					'email'           => $testo,
					'sito'            => $testo,
					'profili'         => $testi,
				),
			),
			static fn() => Dati::azienda()
		);
		self::ability(
			'list-services',
			__( 'Servizi', 'refe-core' ),
			__( 'Pagine del metodo, delle attività e delle piattaforme Perform+ e OpenReport®.', 'refe-core' ),
			array(),
			self::elenco( $scheda ),
			static fn() => Dati::servizi()
		);
		self::ability(
			'list-case-studies',
			__( 'Case studies', 'refe-core' ),
			__( 'Progetti pubblicati, con tipo di cliente, soluzioni e risultati. Si possono filtrare.', 'refe-core' ),
			array(
				'tipo_cliente' => array(
					'type'        => 'string',
					'description' => __( 'Slug del tipo di cliente, per esempio «imprese».', 'refe-core' ),
				),
				'soluzione'    => array(
					'type'        => 'string',
					'description' => __( 'Slug della soluzione, per esempio «openreport».', 'refe-core' ),
				),
				'quanti'       => $quanti,
			),
			self::elenco(
				$scheda + array(
					'tipo_cliente' => $testi,
					'soluzioni'    => $testi,
					'ambito'       => $testo,
					'risultati'    => array(
						'type'  => 'array',
						'items' => array(
							'type'       => 'object',
							'properties' => array(
								'numero' => $testo,
								'testo'  => $testo,
							),
						),
					),
				)
			),
			static fn( $i ) => Dati::progetti( (array) $i )
		);
		self::ability(
			'list-news',
			__( 'News', 'refe-core' ),
			__( 'Articoli pubblicati, dal più recente. Si possono filtrare per categoria.', 'refe-core' ),
			array(
				'categoria' => array(
					'type'        => 'string',
					'description' => __( 'Slug della categoria: media, progetti o pubblicazioni.', 'refe-core' ),
				),
				'quanti'    => $quanti,
			),
			self::elenco(
				$scheda + array(
					'data'      => array(
						'type'   => 'string',
						'format' => 'date',
					),
					'categorie' => $testi,
				)
			),
			static fn( $i ) => Dati::news( (array) $i )
		);
		self::ability(
			'search-content',
			__( 'Ricerca nel sito', 'refe-core' ),
			__( 'Cerca nelle pagine, nelle news e nei case studies pubblicati.', 'refe-core' ),
			array(
				'q'      => array(
					'type'        => 'string',
					'minLength'   => 2,
					'description' => __( 'Testo da cercare.', 'refe-core' ),
				),
				'quanti' => array_merge( $quanti, array( 'default' => 10 ) ),
			),
			self::elenco( array( 'tipo' => $testo ) + $scheda ),
			static fn( $i ) => Dati::cerca( (string) ( $i['q'] ?? '' ), (int) ( $i['quanti'] ?? 10 ) ),
			array( 'q' )
		);
	}

	/**
	 * Schema di un elenco.
	 *
	 * @param array $proprieta Proprietà di ogni voce.
	 */
	private static function elenco( array $proprieta ): array {
		return array(
			'type'  => 'array',
			'items' => array(
				'type'       => 'object',
				'properties' => $proprieta,
			),
		);
	}

	/**
	 * Registra una ability in sola lettura.
	 *
	 * @param string   $nome         Nome.
	 * @param string   $etichetta    Etichetta.
	 * @param string   $descrizione  Descrizione.
	 * @param array    $ingresso     Proprietà in ingresso.
	 * @param array    $uscita       Schema in uscita.
	 * @param callable $esegui       Lettura.
	 * @param array    $obbligatorie Proprietà obbligatorie.
	 */
	private static function ability( string $nome, string $etichetta, string $descrizione, array $ingresso, array $uscita, callable $esegui, array $obbligatorie = array() ): void {
		$arg = array(
			'label'               => $etichetta,
			'description'         => $descrizione,
			'category'            => self::CATEGORIA,
			'output_schema'       => $uscita,
			'execute_callback'    => $esegui,
			'permission_callback' => array( self::class, 'permesso' ),
			'meta'                => array(
				'show_in_rest' => true,
				'mcp'          => array(
					'public' => true,
					'type'   => 'tool',
				),
				'annotations'  => array(
					'readonly'    => true,
					'destructive' => false,
					'idempotent'  => true,
				),
			),
		);
		if ( $ingresso ) {
			$arg['input_schema'] = array(
				'type'                 => 'object',
				'properties'           => $ingresso,
				'additionalProperties' => false,
				'default'              => array(),
			);
			if ( $obbligatorie ) {
				$arg['input_schema']['required'] = $obbligatorie;
				unset( $arg['input_schema']['default'] );
			}
		}
		wp_register_ability( self::CATEGORIA . '/' . $nome, $arg );
	}

	/**
	 * Permesso: i dati sono già pubblici sul sito. Si può restringere con il filtro.
	 */
	public static function permesso(): bool {
		/**
		 * Chi può usare le abilities di Refe.
		 *
		 * @param bool $permesso Vero per tutti.
		 */
		return (bool) apply_filters( 'refe_core_permesso_abilities', true );
	}
}
