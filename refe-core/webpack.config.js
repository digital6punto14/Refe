/* Oltre ai blocchi (block.json) si compilano l'estensione dell'editor e i moduli del sito. */
const path = require( 'path' );
const fs = require( 'fs' );
const base = require( '@wordpress/scripts/config/webpack.config' );

const src = path.resolve( process.cwd(), 'src' );
const moduli = Object.fromEntries(
	fs.readdirSync( path.join( src, 'moduli' ) ).map( ( f ) => [ 'moduli/' + path.parse( f ).name, path.join( src, 'moduli', f ) ] )
);
const aggiungi = ( config, voci ) => ( {
	...config,
	entry: async () => ( { ...( typeof config.entry === 'function' ? await config.entry() : config.entry ), ...voci } ),
} );
const [ script, modulo ] = Array.isArray( base ) ? base : [ base ];

module.exports = [ aggiungi( script, { 'editor/index': path.join( src, 'editor', 'index.js' ) } ), ...( modulo ? [ aggiungi( modulo, moduli ) ] : [] ) ];
