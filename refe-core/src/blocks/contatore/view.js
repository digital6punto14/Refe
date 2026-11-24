/* Contatori con NumberFlow: le cifre ruotano a ogni ingresso nello schermo. Senza modulo restano i numeri dell'HTML. */
import { fermo, alCambio } from '../../comune/movimento';

const voci = [ ...document.querySelectorAll( '.refe-contatore [data-valore]' ) ];
const gruppi = new Map();
voci.forEach( ( el ) => {
	const g = el.closest( '.refe-contatore' ).parentElement;
	gruppi.set( g, [ ...( gruppi.get( g ) || [] ), el ] );
} );

async function accendi( gruppo, elementi ) {
	try {
		await import( '../../vendor/number-flow.mjs' );
	} catch {
		return;
	}
	const numeri = elementi.map( ( el ) => {
		const valore = Number( el.dataset.valore );
		const flow = document.createElement( 'number-flow' );
		flow.locales = 'it-IT';
		flow.format = { useGrouping: true };
		flow.spinTiming = { duration: 1700, easing: 'cubic-bezier(.2,.7,.2,1)' };
		flow.transformTiming = { duration: 900, easing: 'cubic-bezier(.2,.7,.2,1)' };
		flow.animated = false;
		flow.update( fermo() ? valore : 0 );
		el.replaceChildren( flow );
		return { flow, valore };
	} );
	let dentro = false;
	const aggiorna = () =>
		numeri.forEach( ( { flow, valore } ) => {
			flow.animated = dentro && ! fermo();
			flow.update( dentro || fermo() ? valore : 0 );
		} );
	new IntersectionObserver(
		( [ e ] ) => {
			dentro = e.isIntersecting;
			aggiorna();
		},
		{ threshold: 0.35 }
	).observe( gruppo );
	alCambio( aggiorna );
}

// La libreria si carica poco prima che i numeri entrino nello schermo.
const vicino = new IntersectionObserver(
	( es ) =>
		es.forEach( ( e ) => {
			if ( e.isIntersecting ) {
				vicino.unobserve( e.target );
				accendi( e.target, gruppi.get( e.target ) );
			}
		} ),
	{ rootMargin: '600px 0px' }
);
gruppi.forEach( ( _, g ) => vicino.observe( g ) );
