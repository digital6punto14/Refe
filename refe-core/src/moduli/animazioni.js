/* Ingressi: titoli sfocati parola per parola, testi dal basso. Si rifanno ogni volta che entrano nello schermo. */
import { fermo, alCambio } from '../comune/movimento';

const dati = JSON.parse( document.getElementById( 'wp-script-module-data-refe-core/animazioni' )?.textContent || '{}' );
const TITOLI = 'main h1, main h2, .refe-metodo h3, footer h2, [data-refe-titolo]';
const TESTI = 'main .wp-block-group p, main .wp-block-cover p, main .wp-block-column p, .refe-copertina p, [data-refe-testo]';
const MAI = '.is-style-scheda, .is-style-nota, .is-style-freccia, .is-style-etichetta, .wp-block-accordion, .wp-block-tabs, .wp-block-post-template, .refe-girevole, .refe-prosa p, .refe-recapito, .refe-copertina__comandi, .yoast-breadcrumbs, form, dialog, nav';

const regola = ( el, base ) => {
	const r = el.dataset.refeRegola ? JSON.parse( el.dataset.refeRegola ) : {};
	if ( 'ripeti' in r ) {
		r.ripeti = r.ripeti === 'si';
	}
	return { ...base, ...r };
};

function parole( el ) {
	let i = 0;
	const giro = document.createTreeWalker( el, NodeFilter.SHOW_TEXT );
	const nodi = [];
	while ( giro.nextNode() ) {
		nodi.push( giro.currentNode );
	}
	nodi.forEach( ( nodo ) => {
		const pezzi = document.createDocumentFragment();
		nodo.textContent.split( /(\s+)/ ).forEach( ( parte ) => {
			if ( ! parte ) {
				return;
			}
			if ( /^\s+$/.test( parte ) ) {
				pezzi.append( parte );
				return;
			}
			const span = document.createElement( 'span' );
			span.className = 'refe-parola';
			span.style.setProperty( '--i', i++ );
			span.textContent = parte;
			pezzi.append( span );
		} );
		nodo.replaceWith( pezzi );
	} );
}

const ripete = new WeakMap();
const osserva = new IntersectionObserver(
	( voci ) =>
		voci.forEach( ( { target, isIntersecting } ) => {
			// Nel Metodo e nei Pannelli l'ingresso lo decide lo scorrimento del blocco.
			if ( target.closest( '[data-refe-ingresso="manuale"]' ) && ! fermo() ) {
				return;
			}
			if ( isIntersecting ) {
				target.classList.add( 'is-entrato' );
			} else if ( ripete.get( target ) ) {
				target.classList.remove( 'is-entrato' );
			}
		} ),
	{ threshold: 0.2 }
);

function prepara( el, base ) {
	const r = regola( el, base );
	if ( ! r.tipo || r.tipo === 'nessuna' || el.dataset.refeAnim ) {
		return;
	}
	if ( r.tipo === 'sfocato' ) {
		parole( el );
	}
	el.dataset.refeAnim = r.tipo;
	el.style.setProperty( '--refe-durata', `${ r.durata }ms` );
	el.style.setProperty( '--refe-ritardo', `${ r.ritardo }ms` );
	ripete.set( el, r.ripeti );
	osserva.observe( el );
}

if ( dati.titoli && 'IntersectionObserver' in window ) {
	document.querySelectorAll( TITOLI ).forEach( ( el ) => ! el.closest( MAI ) && prepara( el, dati.titoli ) );
	document.querySelectorAll( TESTI ).forEach( ( el ) => {
		// Un testo con una regolazione propria si anima ovunque; gli altri solo fuori da schede e moduli.
		if ( el.dataset.refeRegola || el.hasAttribute( 'data-refe-testo' ) || ! el.closest( MAI ) ) {
			prepara( el, dati.testi );
		}
	} );
	document.querySelectorAll( '[data-refe-regola]:not([data-refe-anim])' ).forEach( ( el ) => prepara( el, dati.testi ) );
	if ( dati.titoli.tipo !== 'nessuna' ) {
		document.querySelectorAll( '[data-refe-nitido]' ).forEach( ( el ) => {
			el.dataset.refeAnim = 'nitido';
			ripete.set( el, dati.titoli.ripeti );
			osserva.observe( el );
		} );
	}
	document.documentElement.classList.add( 'refe-anim-pronto' );
	alCambio( () => fermo() && document.querySelectorAll( '[data-refe-anim]' ).forEach( ( el ) => el.classList.add( 'is-entrato' ) ) );
}
