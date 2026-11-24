import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima, Media, Scelta, stileSpazio } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const { scelte, quante, testoLink, video } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Persone', 'refe-core' ) }>
					<Scelta tipo="refe_persona" etichetta={ __( 'Scelte a mano', 'refe-core' ) } aiuto={ __( 'Vuoto: tutte, nel loro ordine.', 'refe-core' ) } valore={ scelte } onChange={ ( v ) => setAttributes( { scelte: v } ) } />
					{ ! scelte.length && <RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Quante (0 = tutte)', 'refe-core' ) } min={ 0 } max={ 40 } value={ quante } onChange={ ( v ) => setAttributes( { quante: v } ) } /> }
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Testo del link', 'refe-core' ) } value={ testoLink } onChange={ ( v ) => setAttributes( { testoLink: v } ) } />
					<Media etichetta={ __( 'Video per le schede segnaposto', 'refe-core' ) } aiuto={ __( 'Si vede sul retro finché la persona non ha un video suo.', 'refe-core' ) } tipi={ [ 'video' ] } valore={ video } onChange={ ( v ) => setAttributes( { video: v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: stileSpazio( attributes ) } ) }>
				<Anteprima blocco={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
