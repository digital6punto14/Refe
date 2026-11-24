/* Al clic la scheda gira e parte il video. Una sola girata alla volta. */
import { ridotto } from '../../comune/movimento';
import { lettore } from '../../comune/video';

const schede = [ ...document.querySelectorAll( '.refe-persona' ) ].filter( ( s ) => s.querySelector( '.refe-persona__gira' ) );

function gira( scheda, si ) {
	const pulsante = scheda.querySelector( '.refe-persona__gira' );
	const fronte = scheda.querySelector( '.refe-persona__fronte' );
	const retro = scheda.querySelector( '.refe-persona__retro' );
	const prova = retro.querySelector( '.refe-persona__prova' );
	scheda.classList.toggle( 'is-girata', si );
	pulsante.setAttribute( 'aria-pressed', String( si ) );
	pulsante.setAttribute( 'aria-label', si ? pulsante.dataset.chiudi : pulsante.dataset.apri );
	fronte.setAttribute( 'aria-hidden', String( si ) );
	fronte.inert = si;
	retro.setAttribute( 'aria-hidden', String( ! si ) );
	retro.inert = ! si;
	if ( prova ) {
		if ( si && ! ridotto.matches ) {
			prova.play().catch( () => {} );
		} else {
			prova.pause();
		}
	}
	if ( retro.dataset.video ) {
		retro.querySelector( 'iframe, video' )?.remove();
		scheda.classList.toggle( 'con-lettore', si );
		if ( si ) {
			retro.prepend( lettore( retro.dataset.video, retro.dataset.titolo ) );
		}
	}
}

schede.forEach( ( scheda ) => {
	scheda.querySelector( '.refe-persona__gira' ).addEventListener( 'click', () => {
		const si = ! scheda.classList.contains( 'is-girata' );
		schede.forEach( ( x ) => x !== scheda && x.classList.contains( 'is-girata' ) && gira( x, false ) );
		gira( scheda, si );
	} );
	new IntersectionObserver( ( [ e ] ) => ! e.isIntersecting && scheda.classList.contains( 'is-girata' ) && gira( scheda, false ) ).observe( scheda );
} );
