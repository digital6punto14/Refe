import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import metadata from './block.json';

function Edit( { attributes: { lato } } ) {
	const props = useInnerBlocksProps( useBlockProps( { className: 'refe-faccia refe-faccia--' + lato } ), {
		template: lato === 'fronte' ? [ [ 'core/heading', { level: 3 } ], [ 'core/paragraph' ] ] : [ [ 'core/heading', { level: 4 } ], [ 'core/list' ] ],
		templateLock: false,
	} );
	return <div { ...props } />;
}

registerBlockType( metadata.name, { edit: Edit, save: () => <InnerBlocks.Content /> } );
