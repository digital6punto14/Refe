/* Estensioni dell'editor: sfondo delle sezioni, animazioni, parola chiave, collegamenti ai dati. */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { registerBlockBindingsSource } from '@wordpress/blocks';
import { registerFormatType, toggleFormat } from '@wordpress/rich-text';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel, store as editorStore } from '@wordpress/editor';
import { useEntityProp, store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { InspectorControls, RichTextToolbarButton } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const dati = window.refeEditor || { azienda: {}, campi: {}, tipi: {}, animazioni: {} };
const scelte = ( o ) => Object.entries( o ).map( ( [ value, label ] ) => ( { value, label } ) );
const classi = ( s ) => ( s || '' ).split( /\s+/ ).filter( Boolean );

/* ---------- Sfondo sezione: grana, bagliore, filigrana ---------- */
const SFONDI = [ 'core/group', 'core/columns' ];
function PannelloSfondo( { attributes: { className }, setAttributes } ) {
	const c = classi( className );
	const schema = c.some( ( x ) => x.startsWith( 'is-style-schema-' ) );
	const testata = c.includes( 'is-style-testata' );
	if ( ! schema && ! testata ) {
		return null;
	}
	const metti = ( nome, si ) => setAttributes( { className: [ ...c.filter( ( x ) => x !== nome ), ...( si ? [ nome ] : [] ) ].join( ' ' ) || undefined } );
	const voce = ( label, nome, inverso ) => <ToggleControl __nextHasNoMarginBottom label={ label } checked={ c.includes( nome ) !== !! inverso } onChange={ ( v ) => metti( nome, inverso ? ! v : v ) } />;
	return (
		<InspectorControls>
			<PanelBody title={ __( 'Sfondo sezione', 'refe-core' ) }>
				{ schema && voce( __( 'Grana', 'refe-core' ), 'refe-senza-grana', true ) }
				{ schema && ! c.includes( 'is-style-schema-solar-ember' ) && voce( __( 'Bagliore', 'refe-core' ), 'refe-bagliore' ) }
				{ c.includes( 'is-style-schema-white-blue' ) && voce( __( 'Fondo azzurro sfumato', 'refe-core' ), 'refe-cielo' ) }
				{ voce( __( 'Filigrana del simbolo', 'refe-core' ), 'refe-filigrana' ) }
				{ testata && voce( __( 'Testata bassa', 'refe-core' ), 'refe-bassa' ) }
			</PanelBody>
		</InspectorControls>
	);
}

/* ---------- Animazione d'ingresso ---------- */
const ANIMATI = [ 'core/heading', 'core/paragraph', 'core/post-title', 'core/post-excerpt', 'core/query-title' ];
const senzaVuoti = ( o ) => {
	const r = Object.fromEntries( Object.entries( o ).filter( ( [ , v ] ) => v !== '' && v !== undefined && v !== null ) );
	return Object.keys( r ).length ? r : undefined;
};
function CampiAnimazione( { valore = {}, onChange, predefinito } ) {
	const imposta = ( k ) => ( v ) => onChange( { ...valore, [ k ]: v } );
	const numero = ( k ) => ( v ) => onChange( { ...valore, [ k ]: v === '' ? undefined : Math.min( 5000, Math.max( 0, parseInt( v, 10 ) || 0 ) ) } );
	return (
		<>
			<SelectControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Ingresso', 'refe-core' ) } value={ valore.tipo || '' } options={ [ { value: '', label: predefinito }, ...scelte( dati.tipi ) ] } onChange={ imposta( 'tipo' ) } />
			<TextControl __next40pxDefaultSize __nextHasNoMarginBottom type="number" label={ __( 'Durata (millisecondi)', 'refe-core' ) } placeholder={ String( dati.animazioni.durata ?? '' ) } value={ valore.durata ?? '' } onChange={ numero( 'durata' ) } />
			<TextControl __next40pxDefaultSize __nextHasNoMarginBottom type="number" label={ __( 'Ritardo (millisecondi)', 'refe-core' ) } placeholder={ String( dati.animazioni.ritardo ?? '' ) } value={ valore.ritardo ?? '' } onChange={ numero( 'ritardo' ) } />
			<SelectControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Ripetizione', 'refe-core' ) } value={ valore.ripeti || '' } options={ [ { value: '', label: predefinito }, { value: 'si', label: __( 'A ogni passaggio', 'refe-core' ) }, { value: 'no', label: __( 'Una volta sola', 'refe-core' ) } ] } onChange={ imposta( 'ripeti' ) } />
		</>
	);
}

addFilter( 'blocks.registerBlockType', 'refe/animazione', ( settings, name ) =>
	ANIMATI.includes( name ) ? { ...settings, attributes: { ...settings.attributes, refeAnimazione: { type: 'object' } } } : settings
);

addFilter(
	'editor.BlockEdit',
	'refe/pannelli',
	createHigherOrderComponent(
		( BlockEdit ) => ( props ) => (
			<>
				<BlockEdit { ...props } />
				{ props.isSelected && SFONDI.includes( props.name ) && <PannelloSfondo { ...props } /> }
				{ props.isSelected && ANIMATI.includes( props.name ) && (
					<InspectorControls>
						<PanelBody title={ __( 'Animazione', 'refe-core' ) } initialOpen={ false }>
							<CampiAnimazione valore={ props.attributes.refeAnimazione } predefinito={ __( 'Come la pagina', 'refe-core' ) } onChange={ ( v ) => props.setAttributes( { refeAnimazione: senzaVuoti( v ) } ) } />
						</PanelBody>
					</InspectorControls>
				) }
			</>
		),
		'conPannelliRefe'
	)
);

/* ---------- Animazioni della pagina ---------- */
function PannelloPagina() {
	const tipo = useSelect( ( select ) => select( editorStore ).getCurrentPostType(), [] );
	const supporta = useSelect( ( select ) => !! select( coreStore ).getPostType( tipo )?.supports?.[ 'custom-fields' ], [ tipo ] );
	const [ meta, setMeta ] = useEntityProp( 'postType', tipo, 'meta' );
	if ( ! [ 'page', 'post', 'refe_case' ].includes( tipo ) || ! supporta || ! meta ) {
		return null;
	}
	return (
		<PluginDocumentSettingPanel name="refe-animazioni" title={ __( 'Animazioni della pagina', 'refe-core' ) }>
			<CampiAnimazione valore={ meta.refe_animazione || {} } predefinito={ __( 'Come il sito', 'refe-core' ) } onChange={ ( v ) => setMeta( { ...meta, refe_animazione: senzaVuoti( v ) || {} } ) } />
		</PluginDocumentSettingPanel>
	);
}
registerPlugin( 'refe-pagina', { render: PannelloPagina } );

/* ---------- Parola chiave: è il corsivo, con un pulsante suo ---------- */
registerFormatType( 'refe/parola-chiave', {
	title: __( 'Parola chiave', 'refe-core' ),
	tagName: 'em',
	className: 'refe-chiave',
	edit: ( { value, onChange, isActive } ) => (
		<RichTextToolbarButton icon="art" title={ __( 'Parola chiave', 'refe-core' ) } isActive={ isActive } onClick={ () => onChange( toggleFormat( value, { type: 'refe/parola-chiave' } ) ) } />
	),
} );

/* ---------- Collegamenti ---------- */
const perAttributo = ( v, attributo ) => ( attributo === 'url' ? v.url : v.url && attributo === 'content' ? `<a href="${ v.url }">${ v.html }</a>` : v.html );
const elenco = ( voci ) => Object.entries( voci ).map( ( [ campo, label ] ) => ( { label, type: 'string', args: { campo } } ) );
const valori = ( bindings, leggi ) => Object.fromEntries( Object.entries( bindings ).map( ( [ attributo, b ] ) => [ attributo, leggi( b.args?.campo, attributo ) ] ) );

registerBlockBindingsSource( {
	name: 'refe/azienda',
	getValues: ( { bindings } ) => valori( bindings, ( campo, attributo ) => ( dati.azienda[ campo ] ? perAttributo( dati.azienda[ campo ], attributo ) : campo ) ),
	getFieldsList: () => elenco( Object.fromEntries( Object.entries( dati.azienda ).map( ( [ k, v ] ) => [ k, v.etichetta ] ) ) ),
} );
registerBlockBindingsSource( {
	name: 'refe/campo',
	usesContext: [ 'postId', 'postType' ],
	getValues: ( { bindings, select, context } ) => {
		const acf = context?.postId && select( coreStore ).getEditedEntityRecord( 'postType', context.postType, context.postId )?.acf;
		return valori( bindings, ( campo ) => acf?.[ campo ] || dati.campi[ campo ] || campo );
	},
	getFieldsList: () => elenco( dati.campi ),
} );
const CONTENUTO = { tipo: __( 'Tipo di contenuto', 'refe-core' ), categoria: __( 'Categoria', 'refe-core' ), soluzioni: __( 'Soluzioni', 'refe-core' ) };
registerBlockBindingsSource( {
	name: 'refe/contenuto',
	usesContext: [ 'postId', 'postType' ],
	getValues: ( { bindings } ) => valori( bindings, ( campo ) => CONTENUTO[ campo ] || campo ),
	getFieldsList: () => elenco( CONTENUTO ),
} );
