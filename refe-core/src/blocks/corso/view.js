/* Lezione scelta e avanzamento, ricordati nel browser. */
import { lettore } from '../../comune/video';

document.querySelectorAll( '.refe-corso' ).forEach( ( corso ) => {
	const chiave = corso.dataset.corso;
	let fatte = {};
	try {
		fatte = JSON.parse( localStorage.getItem( chiave ) ) || {};
	} catch {
		/* Memoria del browser non disponibile. */
	}
	const spunte = [ ...corso.querySelectorAll( '.refe-lezione input' ) ];
	const lezioni = [ ...corso.querySelectorAll( '.refe-lezione button' ) ];
	const box = corso.querySelector( '.refe-corso__lettore' );
	const titolo = box.querySelector( '.refe-corso__titolo strong' );
	const durata = box.querySelector( '.refe-corso__titolo span' );
	const avviso = box.querySelector( '.refe-corso__avviso' );
	let scelta = lezioni[ 0 ];
	function disegna() {
		const n = spunte.filter( ( s ) => s.checked ).length;
		corso.querySelector( '.refe-corso__barra' ).style.setProperty( '--p', n / spunte.length );
		corso.querySelector( '.refe-corso__stato > span' ).textContent = corso.dataset.conto.replace( '%1$d', n ).replace( '%2$d', spunte.length );
	}
	spunte.forEach( ( s, i ) => {
		s.checked = !! fatte[ i ];
		s.addEventListener( 'change', () => {
			fatte[ i ] = s.checked;
			try {
				localStorage.setItem( chiave, JSON.stringify( fatte ) );
			} catch {
				/* Memoria del browser non disponibile. */
			}
			disegna();
		} );
	} );
	lezioni.forEach( ( b ) =>
		b.addEventListener( 'click', () => {
			lezioni.forEach( ( x ) => x.setAttribute( 'aria-current', String( x === b ) ) );
			scelta = b;
			titolo.textContent = b.textContent;
			durata.textContent = b.dataset.durata;
			avviso.textContent = '';
			box.querySelector( 'iframe, video' )?.remove();
		} )
	);
	box.querySelector( '.refe-corso__avvia' ).addEventListener( 'click', () => {
		if ( scelta?.dataset.video ) {
			box.append( lettore( scelta.dataset.video, scelta.textContent ) );
		} else {
			avviso.textContent = corso.dataset.manca;
		}
	} );
	disegna();
} );
