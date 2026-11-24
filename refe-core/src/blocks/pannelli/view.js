/* L'immagine parte al centro e trasla di lato; i testi si alternano. Su schermi bassi i pannelli restano in colonna. */
import { fermo, alCambio, limita, curva, aFotogramma } from '../../comune/movimento';

const elenco = [ ...document.querySelectorAll( '.refe-pannelli' ) ].map( ( el ) => ( {
	el,
	scena: el.querySelector( '.refe-pannelli__scena' ),
	immagine: el.querySelector( '.refe-pannelli__immagine' ),
	pannelli: [ ...el.querySelectorAll( '.refe-tappa' ) ],
	punti: [ ...el.querySelectorAll( '.refe-pannelli__punti span' ) ],
	casa: { x: 0, y: 0 },
	attivo: -2,
} ) );

function aggiorna() {
	elenco.forEach( ( p ) => {
		const n = p.pannelli.length;
		if ( ! p.el.classList.contains( 'is-vivo' ) ) {
			p.pannelli.forEach( ( x ) => {
				x.style.opacity = '';
				x.style.transform = '';
				x.classList.add( 'is-attivo' );
				x.querySelectorAll( '[data-refe-anim]' ).forEach( ( e ) => e.classList.add( 'is-entrato' ) );
			} );
			p.el.style.removeProperty( '--linea' );
			return;
		}
		const r = p.el.getBoundingClientRect();
		const t = limita( -r.top / Math.max( 1, r.height - innerHeight ) );
		const m = curva( limita( t / 0.24 ) );
		if ( p.immagine ) {
			p.immagine.style.transform = `translate(${ p.casa.x * ( 1 - m ) }px, ${ p.casa.y * ( 1 - m ) }px)`;
		}
		p.el.style.setProperty( '--linea', limita( ( t - 0.17 ) / 0.8 ).toFixed( 3 ) );
		const q = ( ( t - 0.17 ) / 0.83 ) * n;
		const attivo = t < 0.17 ? -1 : Math.min( n - 1, Math.floor( q ) );
		p.pannelli.forEach( ( x, i ) => {
			const l = q - i;
			const entra = limita( l / 0.16 );
			const esce = i === n - 1 ? 0 : limita( ( l - 0.84 ) / 0.16 );
			x.style.opacity = ( entra * ( 1 - esce ) ).toFixed( 3 );
			x.style.transform = `translateY(${ ( ( 1 - entra ) * 26 - esce * 26 ).toFixed( 1 ) }px)`;
			x.classList.toggle( 'is-attivo', i === attivo );
		} );
		if ( attivo !== p.attivo ) {
			p.attivo = attivo;
			p.pannelli.forEach( ( x, i ) => x.querySelectorAll( '[data-refe-anim]' ).forEach( ( e ) => e.classList.toggle( 'is-entrato', i === attivo ) ) );
			p.punti.forEach( ( d, i ) => d.classList.toggle( 'is-acceso', i === attivo ) );
		}
	} );
}
function misura() {
	elenco.forEach( ( p ) => {
		p.el.classList.toggle( 'is-vivo', ! fermo() && innerHeight >= 560 );
		if ( p.immagine ) {
			p.immagine.style.transform = 'none';
			const v = p.immagine.getBoundingClientRect();
			const s = p.scena.getBoundingClientRect();
			p.casa = { x: s.left + s.width / 2 - ( v.left + v.width / 2 ), y: s.top + s.height / 2 - ( v.top + v.height / 2 ) };
		}
		p.attivo = -2;
	} );
	aggiorna();
}
if ( elenco.length ) {
	let larghezza = innerWidth;
	addEventListener( 'scroll', aFotogramma( aggiorna ), { passive: true } );
	addEventListener( 'resize', () => {
		if ( innerWidth !== larghezza || matchMedia( '(pointer: fine)' ).matches ) {
			larghezza = innerWidth;
			misura();
		}
	} );
	alCambio( misura );
	document.fonts?.ready.then( misura );
	addEventListener( 'load', misura );
	misura();
}
