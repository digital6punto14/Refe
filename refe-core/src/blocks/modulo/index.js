import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, RichText, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

function Edit( { attributes: { titolo, aperto }, setAttributes } ) {
	const inner = useInnerBlocksProps( { className: 'refe-modulo__lezioni' }, { template: [ [ 'refe/lezione' ] ] } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Modulo', 'refe-core' ) }>
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Aperto all’inizio', 'refe-core' ) } checked={ aperto } onChange={ ( v ) => setAttributes( { aperto: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-modulo' } ) }>
				<RichText tagName="strong" value={ titolo } onChange={ ( v ) => setAttributes( { titolo: v } ) } placeholder={ __( 'Titolo del modulo', 'refe-core' ) } allowedFormats={ [] } style={ { display: 'block', padding: '16px 0' } } />
				<div { ...inner } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
