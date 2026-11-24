/* Si gira con il mouse, al tocco e da tastiera; la faccia nascosta non si raggiunge. */
const tocco = matchMedia( '(hover: none), (pointer: coarse)' );
const puoPassare = matchMedia( '(any-hover: hover)' );

document.querySelectorAll( '.refe-girevole' ).forEach( ( scheda ) => {
	const gira = scheda.querySelector( '.refe-girevole__gira' );
	const fronte = scheda.querySelector( '.refe-faccia--fronte' );
	const retro = scheda.querySelector( '.refe-faccia--retro' );
	if ( ! gira || ! fronte || ! retro ) {
		return;
	}
	let sopra = false;
	function mostra( si ) {
		scheda.classList.toggle( 'is-girata', si );
		fronte.inert = si;
		retro.inert = ! si;
		fronte.setAttribute( 'aria-hidden', String( si ) );
		retro.setAttribute( 'aria-hidden', String( ! si ) );
		gira.setAttribute( 'aria-expanded', String( si ) );
		gira.setAttribute( 'aria-label', si ? gira.dataset.chiudi : gira.dataset.apri );
		gira.firstElementChild.textContent = tocco.matches ? ( si ? gira.dataset.torna : gira.dataset.tocca ) : si ? gira.dataset.fronte : gira.dataset.retro;
	}
	mostra( false );
	scheda.classList.add( 'gira-pronta' );
	gira.hidden = false;
	scheda.addEventListener( 'pointerenter', ( e ) => {
		if ( e.pointerType === 'mouse' && puoPassare.matches ) {
			sopra = true;
			mostra( true );
		}
	} );
	scheda.addEventListener( 'pointerleave', ( e ) => {
		if ( e.pointerType === 'mouse' && sopra ) {
			sopra = false;
			mostra( false );
		}
	} );
	gira.addEventListener( 'click', ( e ) => {
		if ( ! sopra || e.detail === 0 ) {
			mostra( gira.getAttribute( 'aria-expanded' ) !== 'true' );
		}
	} );
} );
