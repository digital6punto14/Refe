import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import metadata from './block.json';

function Edit() {
	const props = useInnerBlocksProps( useBlockProps( { className: 'refe-tappa' } ), { template: [ [ 'core/heading' ], [ 'core/paragraph' ] ] } );
	return <div { ...props } />;
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
