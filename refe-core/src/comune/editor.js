/* Parti comuni ai pannelli dei blocchi. */
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { decodeEntities } from '@wordpress/html-entities';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { BaseControl, Button, Disabled, FormTokenField, SelectControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';

/** Valore CSS di una spaziatura: preimpostazione o numero. */
export const spaziatura = ( v ) => ( v ? String( v ).replace( /^var:preset\|spacing\|(.+)$/, 'var(--wp--preset--spacing--$1)' ) : undefined );

/** Stile con lo spazio tra gli elementi scelto nel blocco. */
export function stileSpazio( attributes ) {
	const gap = attributes.style?.spacing?.blockGap;
	const valore = spaziatura( typeof gap === 'object' ? gap?.left || gap?.top : gap );
	return valore ? { '--refe-spazio': valore } : {};
}

/** Scelta di un file dalla Libreria media. */
export function Media( { etichetta, aiuto, valore, onChange, tipi = [ 'image' ] } ) {
	return (
		<BaseControl __nextHasNoMarginBottom label={ etichetta } help={ aiuto } id={ undefined }>
			{ valore?.url && tipi.includes( 'image' ) && (
				<img src={ valore.url } alt="" style={ { display: 'block', maxWidth: '100%', maxHeight: 120, margin: '0 0 8px', background: '#021e42', borderRadius: 4 } } />
			) }
			{ valore?.url && ! tipi.includes( 'image' ) && <p style={ { wordBreak: 'break-all', margin: '0 0 8px' } }>{ valore.url.split( '/' ).pop() }</p> }
			<MediaUploadCheck>
				<MediaUpload
					allowedTypes={ tipi }
					value={ valore?.id }
					onSelect={ ( m ) => onChange( { id: m.id, url: m.url, alt: m.alt || '' } ) }
					render={ ( { open } ) => (
						<Button __next40pxDefaultSize variant="secondary" onClick={ open }>
							{ valore?.url ? __( 'Sostituisci', 'refe-core' ) : __( 'Scegli dalla Libreria', 'refe-core' ) }
						</Button>
					) }
				/>
			</MediaUploadCheck>{ ' ' }
			{ valore?.url && (
				<Button __next40pxDefaultSize variant="tertiary" isDestructive onClick={ () => onChange( {} ) }>
					{ __( 'Togli', 'refe-core' ) }
				</Button>
			) }
		</BaseControl>
	);
}

/** Anteprima di un blocco reso dal server. */
export function Anteprima( { blocco, attributes, postId } ) {
	return (
		<Disabled>
			<ServerSideRender block={ blocco } attributes={ attributes } httpMethod="POST" urlQueryArgs={ postId ? { post_id: postId } : {} } />
		</Disabled>
	);
}

/** Scelta a mano di più contenuti, nell'ordine voluto. */
export function Scelta( { tipo, etichetta, aiuto, valore, onChange } ) {
	const elenco = useSelect( ( select ) => select( coreStore ).getEntityRecords( 'postType', tipo, { per_page: 100, _fields: 'id,title', status: 'publish' } ), [ tipo ] ) || [];
	const nome = ( r ) => `${ decodeEntities( r.title.rendered ) } (${ r.id })`;
	return (
		<>
			<FormTokenField
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				__experimentalExpandOnFocus
				label={ etichetta }
				value={ ( valore || [] ).map( ( id ) => ( elenco.find( ( r ) => r.id === id ) ? nome( elenco.find( ( r ) => r.id === id ) ) : `(${ id })` ) ) }
				suggestions={ elenco.map( nome ) }
				onChange={ ( v ) => onChange( v.map( ( t ) => Number( ( String( t ).match( /\((\d+)\)$/ ) || [] )[ 1 ] ) ).filter( Boolean ) ) }
			/>
			<p style={ { marginTop: 0, color: '#757575', fontSize: 12 } }>{ aiuto }</p>
		</>
	);
}

/** Scelta di un termine. */
export function Termine( { tassonomia, etichetta, tutti, valore, onChange } ) {
	const elenco = useSelect( ( select ) => select( coreStore ).getEntityRecords( 'taxonomy', tassonomia, { per_page: 100, _fields: 'id,name' } ), [ tassonomia ] ) || [];
	return (
		<SelectControl
			__next40pxDefaultSize
			__nextHasNoMarginBottom
			label={ etichetta }
			value={ valore }
			options={ [ { label: tutti, value: 0 }, ...elenco.map( ( t ) => ( { label: decodeEntities( t.name ), value: t.id } ) ) ] }
			onChange={ ( v ) => onChange( Number( v ) ) }
		/>
	);
}
