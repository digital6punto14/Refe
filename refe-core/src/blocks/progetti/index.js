import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima, Scelta, Termine, stileSpazio } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, setAttributes, context } ) {
	const { formato, colonne, filtri, quanti, scelti, tipo, soluzione, escludiCorrente, testoTutti, testoLink } = attributes;
	const imposta = ( k ) => ( v ) => setAttributes( { [ k ]: v } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Aspetto', 'refe-core' ) }>
					<SelectControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Formato', 'refe-core' ) } value={ formato } options={ [ { label: __( 'Griglia', 'refe-core' ), value: 'griglia' }, { label: __( 'Carosello', 'refe-core' ), value: 'carosello' } ] } onChange={ imposta( 'formato' ) } />
					{ formato === 'griglia' && <RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Colonne', 'refe-core' ) } min={ 1 } max={ 4 } value={ colonne } onChange={ imposta( 'colonne' ) } /> }
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Filtri per tipo di cliente', 'refe-core' ) } checked={ filtri } onChange={ imposta( 'filtri' ) } />
					{ filtri && <TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Filtro iniziale', 'refe-core' ) } value={ testoTutti } onChange={ imposta( 'testoTutti' ) } /> }
					<TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Testo del link', 'refe-core' ) } value={ testoLink } onChange={ imposta( 'testoLink' ) } />
				</PanelBody>
				<PanelBody title={ __( 'Quali progetti', 'refe-core' ) }>
					<Scelta tipo="refe_case" etichetta={ __( 'Scelti a mano', 'refe-core' ) } aiuto={ __( 'Vuoto: tutti, nell’ordine dei case studies.', 'refe-core' ) } valore={ scelti } onChange={ imposta( 'scelti' ) } />
					{ ! scelti.length && (
						<>
							<Termine tassonomia="refe_tipo_cliente" etichetta={ __( 'Tipo di cliente', 'refe-core' ) } tutti={ __( 'Tutti', 'refe-core' ) } valore={ tipo } onChange={ imposta( 'tipo' ) } />
							<Termine tassonomia="refe_soluzione" etichetta={ __( 'Soluzione', 'refe-core' ) } tutti={ __( 'Tutte', 'refe-core' ) } valore={ soluzione } onChange={ imposta( 'soluzione' ) } />
							<RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Quanti (0 = tutti)', 'refe-core' ) } min={ 0 } max={ 24 } value={ quanti } onChange={ imposta( 'quanti' ) } />
							<ToggleControl __nextHasNoMarginBottom label={ __( 'Togli il progetto della pagina', 'refe-core' ) } checked={ escludiCorrente } onChange={ imposta( 'escludiCorrente' ) } />
						</>
					) }
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { style: stileSpazio( attributes ) } ) }>
				<Anteprima blocco={ metadata.name } attributes={ attributes } postId={ context?.postId } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
