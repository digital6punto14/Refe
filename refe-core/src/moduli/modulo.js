/* Modulo di contatto: dopo l'invio il focus va sul primo campo da correggere. */
document.addEventListener( 'wpcf7invalid', ( e ) => {
	setTimeout( () => e.target.querySelector( '.wpcf7-not-valid:is(input, select, textarea), .wpcf7-not-valid input' )?.focus(), 50 );
} );
