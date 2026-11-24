import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Media } from '../../comune/editor';
import './style.scss';

function Edit( { attributes: { immagine, linea }, setAttributes } ) {
	const props = useBlockProps( { className: 'refe-pannelli' + ( linea ? ' con-linea' : '' ) } );
	const inner = useInnerBlocksProps( { className: 'refe-pannelli__elenco' }, { template: [ [ 'refe/pannello' ], [ 'refe/pannello' ] ], orientation: 'vertical' } );
	const media = <Media etichetta={ __( 'Immagine', 'refe-core' ) } valore={ immagine } onChange={ ( v ) => setAttributes( { immagine: v } ) } />;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Pannelli', 'refe-core' ) }>
					{ media }
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Linea che si disegna', 'refe-core' ) } checked={ linea } onChange={ ( v ) => setAttributes( { linea: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...props }>
				<div className="refe-pannelli__scena">
					{ immagine?.url ? <img className="refe-pannelli__immagine" src={ immagine.url } alt="" /> : media }
					<div { ...inner } />
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
