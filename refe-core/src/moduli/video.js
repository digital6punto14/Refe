/* Video incorporati: il lettore si carica al clic. */
import { lettore } from '../comune/video';

document.querySelectorAll( '[data-refe-video]' ).forEach( ( box ) => {
	const pulsante = box.querySelector( 'button' );
	pulsante.addEventListener( 'click', () => {
		const f = lettore( box.dataset.refeVideo, pulsante.getAttribute( 'aria-label' ) );
		box.replaceChildren( f );
		f.focus();
	} );
} );
