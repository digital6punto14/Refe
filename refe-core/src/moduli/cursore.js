/* Cursore Refe: solo con il mouse. */
import { ridotto, mouse, alCambio, fermo } from '../comune/movimento';

const dati = JSON.parse( document.getElementById( 'wp-script-module-data-refe-core/cursore' )?.textContent || '{}' );

function avvia() {
	const punta = document.createElement( 'div' );
	punta.className = 'refe-cursore';
	punta.setAttribute( 'aria-hidden', 'true' );
	const img = document.createElement( 'img' );
	img.src = dati.immagine;
	img.alt = '';
	img.width = 53;
	img.height = 48;
	punta.append( img );
	document.body.append( punta );

	const larghezza = parseFloat( getComputedStyle( punta ).getPropertyValue( '--refe-cursore' ) ) || 32;
	const altezza = ( larghezza * 48 ) / 53;
	let fotogramma = 0;
	let x = 0;
	let y = 0;
	let presente = false;
	let premuto = false;
	let onda = null;
	const comando = ( t ) => t?.closest?.( 'a[href],button:not(:disabled),summary' );
	const nelMenu = ( t ) => {
		const c = comando( t );
		return !! c?.closest( 'header.wp-block-template-part' ) && ! c.closest( '.wp-block-site-logo' );
	};
	const attivo = ( t ) => presente && ! fermo() && mouse.matches && ! document.querySelector( 'dialog[open]' ) && ( ! document.documentElement.classList.contains( 'refe-intro' ) || nelMenu( t ) );
	function nascondi() {
		cancelAnimationFrame( fotogramma );
		fotogramma = 0;
		punta.classList.remove( 'is-visibile', 'su-link', 'is-premuto' );
		onda?.remove();
		onda = null;
	}
	function disegna() {
		fotogramma = 0;
		const t = document.elementFromPoint( x, y );
		if ( ! attivo( t ) ) {
			nascondi();
			return;
		}
		const menu = nelMenu( t );
		punta.classList.toggle( 'nel-menu', menu );
		punta.classList.toggle( 'su-link', !! comando( t ) );
		punta.classList.toggle( 'su-testata', ! menu && !! t?.closest( 'header.wp-block-template-part' ) );
		punta.classList.toggle( 'su-arancione', !! t?.closest( '.is-style-schema-solar-ember' ) );
		punta.style.transform = `translate3d(${ x - larghezza / 2 }px,${ y - altezza / 2 }px,0)`;
		punta.classList.add( 'is-visibile' );
	}
	document.addEventListener(
		'pointermove',
		( e ) => {
			if ( e.pointerType !== 'mouse' ) {
				return;
			}
			presente = true;
			x = e.clientX;
			y = e.clientY;
			if ( ! fotogramma ) {
				fotogramma = requestAnimationFrame( disegna );
			}
		},
		{ passive: true }
	);
	document.addEventListener(
		'pointerdown',
		( e ) => {
			premuto = e.pointerType === 'mouse' && e.button === 0;
			if ( premuto && attivo( e.target ) && comando( e.target ) ) {
				punta.classList.add( 'is-premuto' );
			}
		},
		{ passive: true }
	);
	document.addEventListener( 'pointerup', () => punta.classList.remove( 'is-premuto' ), { passive: true } );
	document.addEventListener( 'pointercancel', () => {
		premuto = false;
		punta.classList.remove( 'is-premuto' );
	} );
	document.addEventListener(
		'click',
		( e ) => {
			if ( ! premuto || e.detail === 0 || ! attivo( e.target ) || ! comando( e.target ) ) {
				return;
			}
			premuto = false;
			onda?.remove();
			const anello = document.createElement( 'span' );
			anello.className = 'refe-onda';
			anello.setAttribute( 'aria-hidden', 'true' );
			anello.style.left = `${ e.clientX }px`;
			anello.style.top = `${ e.clientY }px`;
			anello.addEventListener(
				'animationend',
				() => {
					anello.remove();
					if ( onda === anello ) {
						onda = null;
					}
				},
				{ once: true }
			);
			onda = anello;
			document.body.append( anello );
		},
		{ capture: true, passive: true }
	);
	document.addEventListener( 'refe:cursore', ( e ) => {
		nascondi();
		x = e.detail.x;
		y = e.detail.y;
		disegna();
	} );
	const esci = () => {
		presente = false;
		premuto = false;
		nascondi();
	};
	document.documentElement.addEventListener( 'pointerleave', esci );
	document.addEventListener( 'visibilitychange', () => document.hidden && esci() );
	alCambio( () => fermo() && nascondi() );
}

if ( mouse.matches && ! ridotto.matches && dati.immagine ) {
	avvia();
}
