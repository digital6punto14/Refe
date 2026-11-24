import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Media } from '../../comune/editor';
import './style.scss';

const TEMPLATE = [
	[ 'core/heading', { level: 1, fontSize: 'copertina', placeholder: __( 'Titolo della pagina', 'refe-core' ) } ],
	[ 'core/paragraph', { placeholder: __( 'Testo introduttivo', 'refe-core' ) } ],
	[ 'core/buttons', {}, [ [ 'core/button' ] ] ],
];

function Edit( { attributes, setAttributes } ) {
	const props = useBlockProps( { className: 'refe-copertina is-editor' } );
	const inner = useInnerBlocksProps( { className: 'refe-copertina__testo' }, { template: TEMPLATE } );
	const { video, simbolo, venti, descrizione, sfondo, testoPausa, testoAvvia } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Simbolo e video', 'refe-core' ) }>
					<Media etichetta={ __( 'Video del loop', 'refe-core' ) } aiuto={ __( 'WebM trasparente. Si carica solo sui computer, dopo la pagina. Altrove e su Safari si alternano le due immagini.', 'refe-core' ) } tipi={ [ 'video' ] } valore={ video } onChange={ ( v ) => setAttributes( { video: v } ) } />
					<Media etichetta={ __( 'Simbolo', 'refe-core' ) } aiuto={ __( 'Vuoto: simbolo Refe.', 'refe-core' ) } valore={ simbolo } onChange={ ( v ) => setAttributes( { simbolo: v } ) } />
					<Media etichetta={ __( 'Immagine alternata', 'refe-core' ) } aiuto={ __( 'Vuoto: «20 anni».', 'refe-core' ) } valore={ venti } onChange={ ( v ) => setAttributes( { venti: v } ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Testo alternativo', 'refe-core' ) } value={ descrizione } onChange={ ( v ) => setAttributes( { descrizione: v } ) } />
				</PanelBody>
				<PanelBody title={ __( 'Animazione', 'refe-core' ) } initialOpen={ false }>
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Sfondo animato', 'refe-core' ) } help={ __( 'Si può spegnere per tutto il sito da Impostazioni sito.', 'refe-core' ) } checked={ sfondo } onChange={ ( v ) => setAttributes( { sfondo: v } ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Pulsante: ferma', 'refe-core' ) } value={ testoPausa } onChange={ ( v ) => setAttributes( { testoPausa: v } ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Pulsante: riprendi', 'refe-core' ) } value={ testoAvvia } onChange={ ( v ) => setAttributes( { testoAvvia: v } ) } />
				</PanelBody>
			</InspectorControls>
			<section { ...props }>
				<div className="refe-copertina__scena">
					<div { ...inner } />
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
