/* Il sigillo parte al centro, trasla al suo posto e rivela il testo. */
import { fermo, alCambio, limita, curva, aFotogramma } from '../../comune/movimento';

document.querySelectorAll( '.refe-metodo' ).forEach( ( fascia ) => {
	const sigillo = fascia.querySelector( '.refe-metodo__sigillo' );
	const scena = fascia.querySelector( '.refe-metodo__scena' );
	const testo = fascia.querySelector( '.refe-metodo__testo' );
	if ( ! sigillo ) {
		return;
	}
	let casa = { x: 0, y: 0 };
	let mostra = null;
	function aggiorna() {
		fascia.classList.toggle( 'is-fermo', fermo() );
		let m = 1;
		if ( ! fermo() && getComputedStyle( fascia.firstElementChild ).position === 'sticky' ) {
			const r = fascia.getBoundingClientRect();
			m = curva( limita( ( limita( -r.top / Math.max( 1, r.height - innerHeight ) ) - 0.12 ) / 0.55 ) );
		}
		sigillo.style.transform = `translate(${ casa.x * ( 1 - m ) }px, ${ casa.y * ( 1 - m ) }px)`;
		const t = limita( ( m - 0.55 ) / 0.45 );
		testo.style.setProperty( '--testo', t.toFixed( 3 ) );
		testo.classList.toggle( 'nascosto', t < 0.001 );
		if ( t > 0.05 !== mostra ) {
			mostra = t > 0.05;
			testo.querySelectorAll( '[data-refe-anim]' ).forEach( ( el ) => el.classList.toggle( 'is-entrato', mostra ) );
		}
	}
	function misura() {
		sigillo.style.transform = 'none';
		const s = sigillo.getBoundingClientRect();
		const c = scena.getBoundingClientRect();
		casa = { x: c.left + c.width / 2 - ( s.left + s.width / 2 ), y: c.top + c.height / 2 - ( s.top + s.height / 2 ) };
		mostra = null;
		aggiorna();
	}
	addEventListener( 'scroll', aFotogramma( aggiorna ), { passive: true } );
	addEventListener( 'resize', misura );
	new ResizeObserver( misura ).observe( scena );
	document.fonts?.ready.then( misura );
	alCambio( misura );
	addEventListener( 'load', misura );
	misura();
} );
