/* Filtri e carosello dei case studies. */
import '../../comune/filtri';
import { fermo } from '../../comune/movimento';

document.querySelectorAll( '.refe-progetti.is-carosello' ).forEach( ( blocco ) => {
	const pista = blocco.querySelector( '[data-pista]' );
	const prima = blocco.querySelector( '.refe-progetti__prima' );
	const dopo = blocco.querySelector( '.refe-progetti__dopo' );
	function aggiorna() {
		prima.disabled = pista.scrollLeft < 2;
		dopo.disabled = pista.scrollLeft >= pista.scrollWidth - pista.clientWidth - 2;
		pista.classList.toggle( 'ha-prima', ! prima.disabled );
		pista.classList.toggle( 'ha-dopo', ! dopo.disabled );
	}
	const sposta = ( verso ) => ( e ) => {
		const voce = pista.querySelector( 'li:not([hidden])' );
		if ( voce ) {
			const passo = voce.getBoundingClientRect().width + ( parseFloat( getComputedStyle( pista ).columnGap ) || 0 );
			pista.scrollBy( { left: verso * passo, behavior: e.detail === 0 || fermo() ? 'instant' : 'smooth' } );
		}
	};
	prima.addEventListener( 'click', sposta( -1 ) );
	dopo.addEventListener( 'click', sposta( 1 ) );
	pista.addEventListener( 'scroll', aggiorna, { passive: true } );
	addEventListener( 'resize', aggiorna, { passive: true } );
	addEventListener( 'load', aggiorna );
	aggiorna();
} );
