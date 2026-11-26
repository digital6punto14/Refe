/* Al clic la scheda gira e mostra immagine e presentazione. Una sola girata alla volta. */
const schede = [ ...document.querySelectorAll( '.refe-persona' ) ].filter( ( s ) => s.querySelector( '.refe-persona__gira' ) );

function gira( scheda, si ) {
	const pulsante = scheda.querySelector( '.refe-persona__gira' );
	const fronte = scheda.querySelector( '.refe-persona__fronte' );
	const retro = scheda.querySelector( '.refe-persona__retro' );
	scheda.classList.toggle( 'is-girata', si );
	pulsante.setAttribute( 'aria-pressed', String( si ) );
	pulsante.setAttribute( 'aria-label', si ? pulsante.dataset.chiudi : pulsante.dataset.apri );
	fronte.setAttribute( 'aria-hidden', String( si ) );
	fronte.inert = si;
	retro.setAttribute( 'aria-hidden', String( ! si ) );
	retro.inert = ! si;
}

schede.forEach( ( scheda ) => {
	scheda.querySelector( '.refe-persona__gira' ).addEventListener( 'click', () => {
		const si = ! scheda.classList.contains( 'is-girata' );
		schede.forEach( ( x ) => x !== scheda && x.classList.contains( 'is-girata' ) && gira( x, false ) );
		gira( scheda, si );
	} );
	new IntersectionObserver( ( [ e ] ) => ! e.isIntersecting && scheda.classList.contains( 'is-girata' ) && gira( scheda, false ) ).observe( scheda );
} );
