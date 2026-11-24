/* Le schede scorrono una alla volta, con pausa. */
import { fermo, alCambio, pulsantePausa } from '../../comune/movimento';

document.querySelectorAll( '.refe-voci__slider' ).forEach( ( slider ) => {
	const pista = slider.querySelector( '.refe-voci__pista' );
	if ( pista.children.length < 2 ) {
		return;
	}
	let timer = 0;
	let sopra = false;
	let stop = false;
	let muove = false;
	function passo() {
		if ( muove ) {
			return;
		}
		const prima = pista.firstElementChild;
		const sposta = prima.getBoundingClientRect().width + ( parseFloat( getComputedStyle( pista ).columnGap ) || 0 );
		muove = true;
		const a = pista.animate( [ { transform: 'translateX(0)' }, { transform: `translateX(${ -sposta }px)` } ], { duration: 900, easing: 'cubic-bezier(.65,0,.25,1)' } );
		prima.animate( [ { opacity: 1 }, { opacity: 0 } ], { duration: 700, easing: 'ease-in' } );
		const fine = () => ( muove = false );
		a.finished.then( () => {
			pista.append( prima );
			fine();
		}, fine );
	}
	function pianifica() {
		clearInterval( timer );
		if ( ! ( fermo() || sopra || stop || document.hidden ) ) {
			timer = setInterval( passo, Number( slider.dataset.intervallo ) || 5200 );
		}
	}
	const segna = ( v ) => ( e ) => {
		if ( ! e.pointerType || e.pointerType === 'mouse' ) {
			sopra = v;
			pianifica();
		}
	};
	slider.addEventListener( 'pointerenter', segna( true ) );
	slider.addEventListener( 'pointerleave', segna( false ) );
	slider.addEventListener( 'focusin', segna( true ) );
	slider.addEventListener( 'focusout', segna( false ) );
	document.addEventListener( 'visibilitychange', pianifica );
	pulsantePausa( slider.querySelector( '.refe-pausa' ), ( si ) => {
		stop = si;
		pianifica();
	} );
	alCambio( pianifica );
	pianifica();
} );
