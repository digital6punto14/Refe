/* Pannelli del menu: si aprono al passaggio del mouse o con la tastiera, uno alla volta.
   Uscendo con il mouse restano aperti ancora un momento, così si raggiungono anche in diagonale. */
const ATTESA_CHIUSURA = 450;
const voci = [ ...document.querySelectorAll( '.refe-pannello > details' ) ];
const mouse = matchMedia( '(hover: hover) and (pointer: fine)' );
const largo = () => innerWidth > 800;
let apri = 0;
let chiudi = 0;
const chiudiTutti = ( salvo ) => voci.forEach( ( v ) => {
	if ( v !== salvo ) {
		v.open = false;
	}
} );

voci.forEach( ( voce ) => {
	const nav = voce.closest( 'nav' );
	voce.addEventListener( 'toggle', () => {
		if ( voce.open ) {
			chiudiTutti( voce );
		}
	} );
	voce.parentElement.addEventListener( 'pointerenter', () => {
		if ( ! mouse.matches || ! largo() ) {
			return;
		}
		clearTimeout( chiudi );
		clearTimeout( apri );
		apri = setTimeout( () => {
			chiudiTutti( voce );
			voce.open = true;
		}, 90 );
	} );
	voce.addEventListener( 'keydown', ( e ) => {
		if ( e.key === 'Escape' && voce.open ) {
			e.stopPropagation();
			voce.open = false;
			voce.querySelector( 'summary' ).focus();
		}
	} );
	nav?.addEventListener( 'pointerenter', () => clearTimeout( chiudi ) );
	voce.addEventListener( 'pointerenter', () => clearTimeout( chiudi ) );
	nav?.addEventListener( 'pointerleave', () => {
		clearTimeout( apri );
		if ( ! largo() || nav.contains( document.activeElement ) ) {
			return;
		}
		chiudi = setTimeout( () => chiudiTutti(), ATTESA_CHIUSURA );
	} );
} );
document.addEventListener( 'click', ( e ) => {
	if ( ! e.target.closest( '.refe-pannello' ) ) {
		chiudiTutti();
	}
} );
document.addEventListener( 'focusin', ( e ) => {
	if ( largo() && ! e.target.closest( '.refe-pannello' ) ) {
		chiudiTutti();
	}
} );
