import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Media } from '../../comune/editor';

function Edit( { attributes: { titolo, durata, link, file }, setAttributes } ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Lezione', 'refe-core' ) }>
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Durata', 'refe-core' ) } value={ durata } onChange={ ( v ) => setAttributes( { durata: v } ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom type="url" label={ __( 'Video: link', 'refe-core' ) } help={ __( 'YouTube o Vimeo.', 'refe-core' ) } value={ link } onChange={ ( v ) => setAttributes( { link: v } ) } />
					<Media etichetta={ __( 'Video: file', 'refe-core' ) } tipi={ [ 'video' ] } valore={ file } onChange={ ( v ) => setAttributes( { file: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-lezione' } ) }>
				<RichText tagName="span" value={ titolo } onChange={ ( v ) => setAttributes( { titolo: v } ) } placeholder={ __( 'Titolo della lezione', 'refe-core' ) } allowedFormats={ [] } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
