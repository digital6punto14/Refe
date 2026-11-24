import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Media } from '../../comune/editor';
import './style.scss';

function Edit( { attributes: { immagine }, setAttributes } ) {
	const inner = useInnerBlocksProps( { className: 'refe-corso__moduli' }, { template: [ [ 'refe/modulo', { aperto: true } ] ] } );
	const media = <Media etichetta={ __( 'Immagine del lettore', 'refe-core' ) } valore={ immagine } onChange={ ( v ) => setAttributes( { immagine: v } ) } />;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Videocorso', 'refe-core' ) }>{ media }</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-corso' } ) }>
				<div className="refe-corso__lettore">{ immagine?.url ? <img src={ immagine.url } alt="" /> : media }</div>
				<div { ...inner } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
