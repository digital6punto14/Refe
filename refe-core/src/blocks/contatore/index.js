import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const { numero, testo, prefisso, suffisso, etichetta, segnaposto } = attributes;
	const props = useBlockProps( { className: 'refe-contatore' + ( segnaposto ? ' is-segnaposto' : '' ) } );
	const campo = ( k ) => ( v ) => setAttributes( { [ k ]: v } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Numero', 'refe-core' ) }>
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom type="number" label={ __( 'Valore', 'refe-core' ) } value={ numero } onChange={ ( v ) => setAttributes( { numero: Number( v ) || 0 } ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Prima del numero', 'refe-core' ) } value={ prefisso } onChange={ campo( 'prefisso' ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Dopo il numero', 'refe-core' ) } value={ suffisso } onChange={ campo( 'suffisso' ) } />
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Testo al posto del numero', 'refe-core' ) } help={ __( 'Se compilato, il numero non ruota.', 'refe-core' ) } value={ testo } onChange={ campo( 'testo' ) } />
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Segnaposto', 'refe-core' ) } checked={ segnaposto } onChange={ campo( 'segnaposto' ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...props }>
				<strong>
					{ prefisso }
					{ testo || new Intl.NumberFormat( 'it-IT', { useGrouping: 'always' } ).format( numero ) }
					{ suffisso }
				</strong>
				<RichText tagName="span" className="refe-contatore__etichetta" value={ etichetta } onChange={ campo( 'etichetta' ) } placeholder={ __( 'Etichetta', 'refe-core' ) } allowedFormats={ [] } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
