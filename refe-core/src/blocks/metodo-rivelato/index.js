import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Media } from '../../comune/editor';
import './style.scss';

const TEMPLATE = [ [ 'core/paragraph', { className: 'refe-occhiello' } ], [ 'core/heading' ], [ 'core/paragraph' ], [ 'core/buttons', {}, [ [ 'core/button' ] ] ] ];

function Edit( { attributes: { immagine }, setAttributes } ) {
	const props = useBlockProps( { className: 'refe-metodo is-fermo is-editor' } );
	const inner = useInnerBlocksProps( { className: 'refe-metodo__testo' }, { template: TEMPLATE } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Immagine che si sposta', 'refe-core' ) }>
					<Media etichetta={ __( 'Immagine', 'refe-core' ) } valore={ immagine } onChange={ ( v ) => setAttributes( { immagine: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...props }>
				<div className="refe-metodo__perno">
					<div className="refe-metodo__scena">
						{ immagine?.url ? <img className="refe-metodo__sigillo" src={ immagine.url } alt="" /> : <Media etichetta={ __( 'Immagine', 'refe-core' ) } valore={ immagine } onChange={ ( v ) => setAttributes( { immagine: v } ) } /> }
						<div { ...inner } />
					</div>
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
