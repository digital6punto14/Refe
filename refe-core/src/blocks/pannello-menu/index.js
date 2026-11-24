import { registerBlockType } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import { InnerBlocks, RichText, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

// La Navigazione core ha un elenco fisso di blocchi ammessi: si aggiunge il pannello.
addFilter( 'blocks.registerBlockType', 'refe/navigazione', ( settings, name ) => {
	if ( name !== 'core/navigation' || ! Array.isArray( settings.allowedBlocks ) ) {
		return settings;
	}
	return { ...settings, allowedBlocks: [ ...settings.allowedBlocks, metadata.name ] };
} );

const TEMPLATE = [ [ 'core/list', { className: 'is-style-voci-menu' }, [ [ 'core/list-item' ] ] ] ];

function Edit( { attributes: { label }, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'wp-block-navigation-item refe-pannello' } );
	const inner = useInnerBlocksProps( { className: 'refe-pannello__fascia' }, { template: TEMPLATE, templateLock: false } );
	return (
		<div { ...blockProps }>
			<RichText
				tagName="span"
				className="wp-block-navigation-item__content"
				value={ label }
				onChange={ ( value ) => setAttributes( { label: value } ) }
				placeholder={ __( 'Voce di menu', 'refe-core' ) }
				allowedFormats={ [] }
			/>
			<div { ...inner } />
		</div>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
