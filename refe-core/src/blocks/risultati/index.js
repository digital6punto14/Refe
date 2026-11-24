import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';
import { Anteprima, stileSpazio } from '../../comune/editor';
import './style.scss';

function Edit( { attributes, context } ) {
	return (
		<div { ...useBlockProps( { style: stileSpazio( attributes ) } ) }>
			<Anteprima blocco={ metadata.name } attributes={ attributes } postId={ context?.postId } />
		</div>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
