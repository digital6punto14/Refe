/* Voce corrente dell'indice e barra di lettura. */
import { limita, aFotogramma } from '../../comune/movimento';

const barra = document.querySelector( '.refe-lettura' );
const voci = [ ...document.querySelectorAll( '.refe-indice a' ) ];
const testo = document.querySelector( '.refe-prosa' ) || document.querySelector( 'main .wp-block-post-content' );

function aggiorna() {
	if ( barra && testo ) {
		const r = testo.getBoundingClientRect();
		barra.style.setProperty( '--p', limita( ( innerHeight * 0.4 - r.top ) / Math.max( 1, r.height ) ).toFixed( 3 ) );
	}
	let corrente = voci[ 0 ];
	voci.forEach( ( a ) => {
		const t = document.getElementById( decodeURIComponent( a.hash.slice( 1 ) ) );
		if ( t && t.getBoundingClientRect().top < 190 ) {
			corrente = a;
		}
	} );
	voci.forEach( ( a ) => ( a === corrente ? a.setAttribute( 'aria-current', 'true' ) : a.removeAttribute( 'aria-current' ) ) );
}
if ( barra || voci.length ) {
	const prossimo = aFotogramma( aggiorna );
	addEventListener( 'scroll', prossimo, { passive: true } );
	addEventListener( 'resize', prossimo, { passive: true } );
	aggiorna();
}
