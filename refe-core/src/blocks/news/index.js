import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, TextControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import { Anteprima, Termine, stileSpazio } from '../../comune/editor';
import './style.scss';

const TEMPLATE = [
	[ 'core/heading', { content: __( 'Ultime news', 'refe-core' ) } ],
	[ 'core/paragraph', { className: 'is-style-freccia', content: __( 'Tutte le news', 'refe-core' ) } ],
];

function Edit( { attributes, setAttributes, context } ) {
	const { formato, filtri, quante, categoria, escludiCorrente, durata, testoTutte } = attributes;
	const striscia = formato === 'scorrimento';
	const imposta = ( k ) => ( v ) => setAttributes( { [ k ]: v } );
	const testa = useInnerBlocksProps( { className: 'refe-news__testa' }, { template: TEMPLATE, orientation: 'horizontal' } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Aspetto', 'refe-core' ) }>
					<SelectControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Formato', 'refe-core' ) } value={ formato } options={ [ { label: __( 'Griglia', 'refe-core' ), value: 'griglia' }, { label: __( 'Scorrimento', 'refe-core' ), value: 'scorrimento' } ] } onChange={ imposta( 'formato' ) } />
					{ striscia && <RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Durata di un giro (secondi)', 'refe-core' ) } min={ 10 } max={ 120 } value={ durata } onChange={ imposta( 'durata' ) } /> }
					{ ! striscia && <ToggleControl __nextHasNoMarginBottom label={ __( 'Filtri per categoria', 'refe-core' ) } checked={ filtri } onChange={ imposta( 'filtri' ) } /> }
					{ ! striscia && filtri && <TextControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Filtro iniziale', 'refe-core' ) } value={ testoTutte } onChange={ imposta( 'testoTutte' ) } /> }
				</PanelBody>
				<PanelBody title={ __( 'Quali news', 'refe-core' ) }>
					<Termine tassonomia="category" etichetta={ __( 'Categoria', 'refe-core' ) } tutti={ __( 'Tutte', 'refe-core' ) } valore={ categoria } onChange={ imposta( 'categoria' ) } />
					<RangeControl __next40pxDefaultSize __nextHasNoMarginBottom label={ __( 'Quante (0 = tutte)', 'refe-core' ) } min={ 0 } max={ 30 } value={ quante } onChange={ imposta( 'quante' ) } />
					<ToggleControl __nextHasNoMarginBottom label={ __( 'Togli l’articolo della pagina', 'refe-core' ) } checked={ escludiCorrente } onChange={ imposta( 'escludiCorrente' ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'refe-news', style: stileSpazio( attributes ) } ) }>
				{ striscia && <div { ...testa } /> }
				<Anteprima blocco={ metadata.name } attributes={ attributes } postId={ context?.postId } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
