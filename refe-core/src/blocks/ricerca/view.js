/* Ricerca in tutto il sito con la REST API di WordPress. */
import { store, getElement, withScope } from '@wordpress/interactivity';

let attesa = 0;
let richiesta = null;
const testo = ( html ) => new DOMParser().parseFromString( html, 'text/html' ).body.textContent;
const finestra = () => getElement().ref.closest( '.refe-ricerca' ).querySelector( 'dialog' );

const { state } = store( 'refe/ricerca', {
	actions: {
		apri() {
			const d = finestra();
			d.showModal();
			document.documentElement.style.overflow = 'hidden';
			d.querySelector( 'input' ).focus();
		},
		chiudi() {
			finestra().close();
		},
		chiuso() {
			document.documentElement.style.removeProperty( 'overflow' );
		},
		fuori( e ) {
			if ( e.target === e.currentTarget ) {
				e.currentTarget.close();
			}
		},
		scrivi( e ) {
			const q = e.target.value.trim();
			clearTimeout( attesa );
			richiesta?.abort();
			if ( q.length < 2 ) {
				state.risultati = [];
				state.messaggio = state.messaggi.corto;
				return;
			}
			state.messaggio = state.messaggi.attesa;
			attesa = setTimeout(
				withScope( async () => {
					richiesta = new AbortController();
					try {
						const url = new URL( state.fonte );
						url.searchParams.set( 'search', q );
						url.searchParams.set( 'per_page', '10' );
						url.searchParams.set( '_fields', 'title,url,subtype' );
						const r = await fetch( url, { signal: richiesta.signal } );
						if ( ! r.ok ) {
							throw new Error( r.status );
						}
						const voci = await r.json();
						state.risultati = voci.map( ( v ) => ( { titolo: testo( v.title ), url: v.url, tipo: state.tipi[ v.subtype ] || '' } ) );
						state.messaggio = voci.length ? ( voci.length === 1 ? state.messaggi.uno : state.messaggi.molti ).replace( '%d', voci.length ) : state.messaggi.vuoto;
					} catch ( err ) {
						if ( err.name !== 'AbortError' ) {
							state.risultati = [];
							state.messaggio = state.messaggi.errore;
						}
					}
				} ),
				250
			);
		},
	},
} );
