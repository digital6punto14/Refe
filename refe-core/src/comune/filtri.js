/* Filtri degli elenchi (case studies e news). */
import { store, getContext, getElement } from '@wordpress/interactivity';

const passa = ( contesto, categorie ) => ! contesto.scelto || categorie.includes( contesto.scelto );

store( 'refe/filtri', {
	state: {
		get premuto() {
			const c = getContext();
			return c.scelto === c.voce;
		},
		get nascosto() {
			const c = getContext();
			return ! passa( c, c.categorie );
		},
	},
	actions: {
		scegli() {
			const c = getContext();
			const radice = getElement().ref.closest( '[data-wp-interactive="refe/filtri"]' );
			const { voce } = c;
			const cambia = () => {
				c.scelto = voce;
				const quanti = c.elenco.filter( ( x ) => ! voce || x.includes( voce ) ).length;
				c.messaggio = ( quanti === 1 ? c.uno : c.molti ).replace( '%d', quanti );
				const pista = radice.querySelector( '[data-pista]' );
				if ( pista ) {
					pista.scrollTo( { left: 0, behavior: 'instant' } );
					setTimeout( () => pista.dispatchEvent( new Event( 'scroll' ) ), 60 );
				}
			};
			if ( ! c.riordino || ! document.startViewTransition || matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
				cambia();
				return;
			}
			// I nomi servono solo durante il riordino.
			const voci = [ ...radice.querySelectorAll( '[data-voce]' ) ];
			voci.forEach( ( li, i ) => {
				li.style.viewTransitionName = `refe-voce-${ i }`;
			} );
			document
				.startViewTransition( () => {
					cambia();
					return new Promise( ( r ) => setTimeout( r, 40 ) );
				} )
				.finished.finally( () => voci.forEach( ( li ) => li.style.removeProperty( 'view-transition-name' ) ) );
		},
	},
} );
