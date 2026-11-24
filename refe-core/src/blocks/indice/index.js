import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, setAttributes, context } ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Indice', 'refe-core' ) }>
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Titolo', 'refe-core' ) } value={ attributes.titolo } onChange={ ( v ) => setAttributes( { titolo: v } ) } />
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Barra di lettura', 'refe-core' ) } checked={ attributes.barra } onChange={ ( v ) => setAttributes( { barra: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<Anteprima blocco={ metadata.name } attributes={ attributes } postId={ context?.postId } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
