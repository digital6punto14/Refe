<?php
/**
 * Tipi di contenuto e tassonomie.
 *
 * @package RefeCore
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Case study, Testimonianze, Persone.
 */
final class Contenuti {

	public const CASE          = 'refe_case';
	public const TESTIMONIANZA = 'refe_testimonianza';
	public const PERSONA       = 'refe_persona';
	public const TIPO_CLIENTE  = 'refe_tipo_cliente';
	public const SOLUZIONE     = 'refe_soluzione';

	/**
	 * Aggancia gli hook.
	 */
	public static function avvia(): void {
		add_action( 'init', array( self::class, 'registra' ), 5 );
		add_filter( 'wpseo_breadcrumb_links', array( self::class, 'percorso' ) );
		add_filter( 'default_template_types', array( self::class, 'nome_template' ) );
		add_filter( 'enter_title_here', array( self::class, 'segnaposto_titolo' ), 10, 2 );
	}

	/**
	 * Registra tassonomie e tipi.
	 */
	public static function registra(): void {
		self::tassonomia( self::TIPO_CLIENTE, __( 'Tipi di cliente', 'refe-core' ), __( 'Tipo di cliente', 'refe-core' ), 'tipo-cliente' );
		self::tassonomia( self::SOLUZIONE, __( 'Soluzioni', 'refe-core' ), __( 'Soluzione', 'refe-core' ), 'soluzione' );

		register_post_type(
			self::CASE,
			array(
				'labels'       => self::etichette( __( 'Case studies', 'refe-core' ), __( 'Case study', 'refe-core' ), __( 'Aggiungi case study', 'refe-core' ), __( 'Modifica case study', 'refe-core' ) ),
				'public'       => true,
				'has_archive'  => false,
				'show_in_rest' => true,
				'rest_base'    => 'case-studies',
				'menu_icon'    => 'dashicons-portfolio',
				'menu_position' => 21,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
				'taxonomies'   => array( self::TIPO_CLIENTE, self::SOLUZIONE ),
				'rewrite'      => array(
					'slug'       => 'case-studies',
					'with_front' => false,
				),
				/**
				 * Struttura iniziale di un nuovo case study.
				 *
				 * @param array $modello Blocchi.
				 */
				'template'     => apply_filters(
					'refe_core_modello_case',
					array(
						array( 'core/pattern', array( 'slug' => 'refe-theme/racconto' ) ),
						array( 'core/pattern', array( 'slug' => 'refe-theme/risultati' ) ),
						array( 'core/pattern', array( 'slug' => 'refe-theme/galleria' ) ),
					)
				),
			)
		);

		$scheda = array(
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'exclude_from_search' => true,
			'menu_position'       => 22,
		);
		register_post_type(
			self::TESTIMONIANZA,
			$scheda + array(
				'labels'    => self::etichette( __( 'Testimonianze', 'refe-core' ), __( 'Testimonianza', 'refe-core' ), __( 'Aggiungi testimonianza', 'refe-core' ), __( 'Modifica testimonianza', 'refe-core' ) ),
				'rest_base' => 'testimonianze',
				'menu_icon' => 'dashicons-format-quote',
				'supports'  => array( 'title', 'page-attributes', 'custom-fields' ),
			)
		);
		register_post_type(
			self::PERSONA,
			$scheda + array(
				'labels'    => self::etichette( __( 'Persone', 'refe-core' ), __( 'Persona', 'refe-core' ), __( 'Aggiungi persona', 'refe-core' ), __( 'Modifica persona', 'refe-core' ) ),
				'rest_base' => 'persone',
				'menu_icon' => 'dashicons-groups',
				'supports'  => array( 'title', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ),
			)
		);
	}

	/**
	 * Registra una tassonomia senza pagina pubblica.
	 *
	 * @param string $nome      Nome.
	 * @param string $plurale   Etichetta plurale.
	 * @param string $singolare Etichetta singolare.
	 * @param string $base      Base REST.
	 */
	private static function tassonomia( string $nome, string $plurale, string $singolare, string $base ): void {
		register_taxonomy(
			$nome,
			self::CASE,
			array(
				'labels'             => array(
					'name'          => $plurale,
					'singular_name' => $singolare,
					'menu_name'     => $plurale,
				),
				'public'             => false,
				'publicly_queryable' => false,
				'hierarchical'       => true,
				'show_ui'            => true,
				'show_admin_column'  => true,
				'show_in_rest'       => true,
				'rest_base'          => $base,
			)
		);
	}

	/**
	 * Etichette di un tipo.
	 *
	 * @param string $plurale   Plurale.
	 * @param string $singolare Singolare.
	 * @param string $aggiungi  Voce «aggiungi».
	 * @param string $modifica  Voce «modifica».
	 */
	private static function etichette( string $plurale, string $singolare, string $aggiungi, string $modifica ): array {
		return array(
			'name'               => $plurale,
			'singular_name'      => $singolare,
			'menu_name'          => $plurale,
			'add_new'            => $aggiungi,
			'add_new_item'       => $aggiungi,
			'edit_item'          => $modifica,
			'all_items'          => $plurale,
			'featured_image'     => __( 'Immagine', 'refe-core' ),
			'set_featured_image' => __( 'Scegli l’immagine', 'refe-core' ),
		);
	}

	/**
	 * Nome del template dei case studies nel Site Editor.
	 *
	 * @param array $tipi Tipi di template.
	 */
	public static function nome_template( array $tipi ): array {
		$tipi[ 'single-' . self::CASE ] = array(
			'title'       => __( 'Case study', 'refe-core' ),
			'description' => __( 'Pagina di un case study.', 'refe-core' ),
		);
		return $tipi;
	}

	/**
	 * Percorso di Yoast: case studies e articoli passano dalla loro pagina elenco.
	 *
	 * @param array $voci Voci.
	 */
	public static function percorso( array $voci ): array {
		$slug = is_singular( self::CASE ) ? 'case-studies' : ( is_singular( 'post' ) || is_category() ? 'news' : '' );
		$page = $slug ? get_page_by_path( $slug ) : null;
		if ( $page && 'publish' === $page->post_status && ! in_array( get_permalink( $page ), array_column( $voci, 'url' ), true ) ) {
			array_splice(
				$voci,
				1,
				0,
				array(
					array(
						'url'  => get_permalink( $page ),
						'text' => get_the_title( $page ),
						'id'   => $page->ID,
					),
				)
			);
		}
		return $voci;
	}

	/**
	 * Suggerimento nel campo del titolo.
	 *
	 * @param string   $testo Testo.
	 * @param \WP_Post $post  Contenuto.
	 */
	public static function segnaposto_titolo( string $testo, \WP_Post $post ): string {
		return match ( $post->post_type ) {
			self::CASE                         => __( 'Nome del cliente', 'refe-core' ),
			self::TESTIMONIANZA, self::PERSONA => __( 'Nome e cognome', 'refe-core' ),
			default                            => $testo,
		};
	}

	/**
	 * Case studies da mostrare.
	 *
	 * @param array $arg Opzioni: quanti, scelti, tipo, soluzione, escludi.
	 * @return \WP_Post[]
	 */
	public static function progetti( array $arg ): array {
		$query = array(
			'post_type'   => self::CASE,
			'post_status' => 'publish',
			'numberposts' => ! empty( $arg['quanti'] ) ? (int) $arg['quanti'] : -1,
			'orderby'     => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
		);
		if ( ! empty( $arg['scelti'] ) ) {
			$query['post__in']    = array_map( 'intval', $arg['scelti'] );
			$query['orderby']     = 'post__in';
			$query['numberposts'] = -1;
		}
		foreach ( array(
			'tipo'      => self::TIPO_CLIENTE,
			'soluzione' => self::SOLUZIONE,
		) as $chiave => $tassonomia ) {
			if ( ! empty( $arg[ $chiave ] ) ) {
				$query['tax_query'][] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					'taxonomy' => $tassonomia,
					'terms'    => (int) $arg[ $chiave ],
				);
			}
		}
		if ( ! empty( $arg['escludi'] ) ) {
			$query['post__not_in'] = array( (int) $arg['escludi'] );
		}
		return get_posts( $query );
	}

	/**
	 * Schede senza pagina propria, nell'ordine scelto.
	 *
	 * @param string $tipo   Post type.
	 * @param array  $scelti ID scelti a mano.
	 * @param int    $quanti Quante, 0 per tutte.
	 * @return \WP_Post[]
	 */
	public static function schede( string $tipo, array $scelti = array(), int $quanti = 0 ): array {
		$query = array(
			'post_type'   => $tipo,
			'post_status' => 'publish',
			'numberposts' => $quanti > 0 ? $quanti : -1,
			'orderby'     => array(
				'menu_order' => 'ASC',
				'ID'         => 'ASC',
			),
		);
		if ( $scelti ) {
			$query['post__in'] = array_map( 'intval', $scelti );
			$query['orderby']  = 'post__in';
		}
		return get_posts( $query );
	}

	/**
	 * Nomi dei termini di un contenuto.
	 *
	 * @param int    $id         Contenuto.
	 * @param string $tassonomia Tassonomia.
	 * @return \WP_Term[]
	 */
	public static function termini( int $id, string $tassonomia ): array {
		$termini = get_the_terms( $id, $tassonomia );
		return is_array( $termini ) ? $termini : array();
	}
}
