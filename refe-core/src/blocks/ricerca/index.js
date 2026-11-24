import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const campo = ( k, label ) => <TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ label } value={ attributes[ k ] } onChange={ ( v ) => setAttributes( { [ k ]: v } ) } />;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Ricerca', 'refe-core' ) }>
					{ campo( 'titolo', __( 'Titolo della finestra', 'refe-core' ) ) }
					{ campo( 'etichetta', __( 'Etichetta del campo', 'refe-core' ) ) }
					{ campo( 'esempio', __( 'Esempio nel campo', 'refe-core' ) ) }
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-ricerca' } ) }>
				<span className="refe-ricerca__apri" aria-label={ attributes.titolo } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
