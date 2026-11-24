/* Movimento ridotto e pausa: lo stesso stato per tutti i moduli del sito. */
export const ridotto = matchMedia( '(prefers-reduced-motion: reduce)' );
export const mouse = matchMedia( '(hover: hover) and (pointer: fine)' );
export const limita = ( v ) => Math.min( 1, Math.max( 0, v ) );
export const curva = ( v ) => ( v < 0.5 ? 4 * v * v * v : 1 - Math.pow( -2 * v + 2, 3 ) / 2 );
export const fermo = () => ridotto.matches || document.documentElement.classList.contains( 'refe-fermo' );

/** Chiama la funzione quando il movimento si ferma o riparte. */
export function alCambio( fn ) {
	document.addEventListener( 'refe:movimento', fn );
	ridotto.addEventListener( 'change', fn );
}

/** Una chiamata per fotogramma. */
export function aFotogramma( fn ) {
	let id = 0;
	return () => {
		if ( ! id ) {
			id = requestAnimationFrame( () => {
				id = 0;
				fn();
			} );
		}
	};
}

/** Pulsante di pausa con etichetta che cambia. */
export function pulsantePausa( pulsante, fn ) {
	pulsante?.addEventListener( 'click', () => {
		const si = pulsante.getAttribute( 'aria-pressed' ) !== 'true';
		pulsante.setAttribute( 'aria-pressed', String( si ) );
		pulsante.setAttribute( 'aria-label', si ? pulsante.dataset.avvia : pulsante.dataset.pausa );
		fn( si );
	} );
}
