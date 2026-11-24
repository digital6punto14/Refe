import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima, Scelta, stileSpazio } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const { scelte, quante, intervallo } = attributes;
	const inner = useInnerBlocksProps( { className: 'refe-voci__testo' }, { template: [ [ 'core/heading' ], [ 'core/buttons', {}, [ [ 'core/button' ] ] ] ] } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Testimonianze', 'refe-core' ) }>
					<Scelta tipo="refe_testimonianza" etichetta={ __( 'Scelte a mano', 'refe-core' ) } aiuto={ __( 'Vuoto: tutte, nel loro ordine.', 'refe-core' ) } valore={ scelte } onChange={ ( v ) => setAttributes( { scelte: v } ) } />
					{ ! scelte.length && <RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Quante (0 = tutte)', 'refe-core' ) } min={ 0 } max={ 20 } value={ quante } onChange={ ( v ) => setAttributes( { quante: v } ) } /> }
					<RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Tempo tra una e l’altra (millisecondi)', 'refe-core' ) } min={ 2000 } max={ 15000 } step={ 100 } value={ intervallo } onChange={ ( v ) => setAttributes( { intervallo: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-voci', style: stileSpazio( attributes ) } ) }>
				<div { ...inner } />
				<Anteprima blocco={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
