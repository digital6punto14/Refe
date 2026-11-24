/* Filtri della griglia e striscia che scorre. */
import '../../comune/filtri';
import { ridotto, pulsantePausa } from '../../comune/movimento';

const muta = ( el ) => {
	el.setAttribute( 'aria-hidden', 'true' );
	el.querySelectorAll( 'a, button' ).forEach( ( a ) => ( a.tabIndex = -1 ) );
};

document.querySelectorAll( '.refe-news.is-striscia' ).forEach( ( blocco ) => {
	const finestra = blocco.querySelector( '.refe-news__finestra' );
	const pista = blocco.querySelector( '.refe-news__pista' );
	const elenco = pista.firstElementChild;
	const voci = [ ...elenco.children ];
	// Poche notizie: si ripetono finché riempiono lo schermo. I doppioni restano fuori dai lettori di schermo.
	for ( let i = 0; i < 12 && elenco.scrollWidth < finestra.clientWidth; i++ ) {
		voci.forEach( ( v ) => {
			const c = v.cloneNode( true );
			muta( c );
			elenco.append( c );
		} );
	}
	const copia = elenco.cloneNode( true );
	muta( copia );
	pista.append( copia );
	blocco.classList.add( 'is-pronta' );
	new IntersectionObserver( ( [ e ] ) => blocco.classList.toggle( 'is-visibile', e.isIntersecting ) ).observe( finestra );
	const pausa = blocco.querySelector( '.refe-pausa' );
	const preferenza = () => pausa && ( pausa.hidden = ridotto.matches );
	preferenza();
	ridotto.addEventListener( 'change', preferenza );
	pulsantePausa( pausa, ( si ) => blocco.classList.toggle( 'is-ferma', si ) );
} );
