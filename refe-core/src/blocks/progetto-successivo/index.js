import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, setAttributes, context } ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Progetto successivo', 'refe-core' ) }>
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Testo sopra il nome', 'refe-core' ) } value={ attributes.testo } onChange={ ( v ) => setAttributes( { testo: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<Anteprima blocco={ metadata.name } attributes={ attributes } postId={ context?.postId } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
