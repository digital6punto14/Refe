import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

const TEMPLATE = [
	[ 'refe/faccia', { lato: 'fronte' } ],
	[ 'refe/faccia', { lato: 'retro' } ],
];

function Edit( { attributes: { nome, filigrana }, setAttributes } ) {
	const props = useBlockProps( { className: 'refe-girevole is-editor filigrana-' + filigrana } );
	const inner = useInnerBlocksProps( { className: 'refe-girevole__facce' }, { template: TEMPLATE, templateLock: 'all' } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Scheda girevole', 'refe-core' ) }>
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Nome', 'refe-core' ) } help={ __( 'Serve ai lettori di schermo: «Mostra le attività con …».', 'refe-core' ) } value={ nome } onChange={ ( v ) => setAttributes( { nome: v } ) } />
					<SelectControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Simbolo sullo sfondo', 'refe-core' ) } value={ filigrana } options={ [ { label: __( 'Scuro', 'refe-core' ), value: 'scura' }, { label: __( 'Chiaro', 'refe-core' ), value: 'chiara' }, { label: __( 'Nessuno', 'refe-core' ), value: 'nessuna' } ] } onChange={ ( v ) => setAttributes( { filigrana: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...props }>
				<div { ...inner } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
