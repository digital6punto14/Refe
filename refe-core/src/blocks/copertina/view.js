/* Copertina: loop del simbolo, sfondo che si schiarisce e simbolo che diventa cursore. Stessa coreografia della demo. */
import { ridotto, mouse, limita } from '../../comune/movimento';
import campoWebgl from './campo';

const intro = document.querySelector( '.refe-copertina' );

function avvia() {
	const radice = document.documentElement;
	const trova = ( s ) => intro.querySelector( s );
	const scena = trova( '.refe-copertina__scena' );
	const simbolo = trova( '.refe-copertina__simbolo' );
	const testo = trova( '.refe-copertina__testo' );
	const posto = trova( '.refe-copertina__posto' );
	const video = trova( '.refe-copertina__video' );
	const pulsante = trova( '.refe-copertina__pausa' );
	const tela = trova( '.refe-copertina__campo' );
	const testata = document.querySelector( 'header.wp-block-template-part' );
	const campo = tela ? campoWebgl( tela ) : null;
	const curva = ( v ) => v * v * ( 3 - 2 * v );
	let utente = false;

	/* ---------- Posto del simbolo: a destra del titolo, o sopra se non c'è spazio ---------- */
	const range = document.createRange();
	const fineTesto = ( el ) => {
		range.selectNodeContents( el );
		return Math.max( 0, ...[ ...range.getClientRects() ].map( ( r ) => r.right ) );
	};
	function colloca() {
		posto.classList.remove( 'sopra' );
		posto.removeAttribute( 'style' );
		const s = scena.getBoundingClientRect();
		const fine = Math.max( 0, ...[ ...testo.querySelectorAll( 'h1, p' ) ].map( fineTesto ) );
		if ( s.right - fine >= posto.getBoundingClientRect().width + Math.max( 48, s.width * 0.06 ) * 2 ) {
			return;
		}
		posto.classList.add( 'sopra' );
		const t = testo.getBoundingClientRect();
		const alto = t.top - s.top;
		const sotto = testata ? testata.getBoundingClientRect().bottom - s.top : 0;
		const w = Math.max( 150, Math.min( posto.getBoundingClientRect().width, ( alto - sotto - 28 ) * 1.25 ) );
		posto.style.width = `${ Math.round( w ) }px`;
		posto.style.top = `${ Math.round( alto - w / 1.25 - 12 ) }px`;
		posto.style.left = `${ Math.round( t.left - s.left - w * 0.1 ) }px`;
	}

	/* ---------- Loop: video solo su computer, dopo la pagina ---------- */
	const safari = /^((?!chrome|chromium|android|crios|fxios|edg).)*safari/i.test( navigator.userAgent );
	let usaVideo = false;
	const fermo = () => utente || ridotto.matches;
	function loop() {
		scena.classList.toggle( 'loop-fermo', fermo() );
		if ( ! usaVideo ) {
			return;
		}
		if ( fermo() || scena.classList.contains( 'staccato' ) ) {
			video.pause();
			video.currentTime = 0;
		} else if ( video.paused ) {
			video.play().catch( () => {} );
		}
	}
	function caricaVideo() {
		if ( ! video ) {
			return;
		}
		if ( safari || ! mouse.matches || innerWidth <= 800 || navigator.connection?.saveData || ! video.canPlayType( 'video/webm; codecs="vp9"' ) ) {
			video.remove();
			return;
		}
		video.addEventListener(
			'canplay',
			() => {
				usaVideo = true;
				scena.classList.add( 'con-video' );
				loop();
			},
			{ once: true }
		);
		video.addEventListener( 'error', () => video.remove(), { once: true } );
		video.preload = 'auto';
		video.src = video.dataset.src;
	}

	/* ---------- Coreografia ---------- */
	const misuraCursore = parseFloat( getComputedStyle( radice ).getPropertyValue( '--refe-cursore' ) ) || 32;
	let w = innerWidth, h = innerHeight, corsa = 1, inizio = 0, daMisurare = true;
	let px, py, ps;
	let x = w / 2, y = h * 0.3, tx = x, ty = y;
	let visto = false, fotogramma = 0, prima = 0, ultimoDisegno = 0, tempo = 0;
	let visibile = true, sporco = true, vecchio = -1, inCorso = false, ultimoGesto = performance.now(), blocchi = [];
	const richiedi = () => {
		if ( ! fotogramma && ! document.hidden ) {
			fotogramma = requestAnimationFrame( disegna );
		}
	};
	function misura() {
		w = scena.clientWidth;
		h = scena.clientHeight;
		corsa = intro.offsetHeight - h || Math.min( 560, h * 0.6 );
		inizio = intro.offsetTop;
		daMisurare = true;
		colloca();
		const s = scena.getBoundingClientRect();
		const r = posto.getBoundingClientRect();
		px = r.left - s.left + r.width / 2;
		py = r.top - s.top + r.height / 2;
		ps = Math.min( ( r.width * 0.62 ) / 53, ( r.height * 0.8 ) / 48 );
		blocchi = [ ...testo.querySelectorAll( 'h1, p' ) ].map( ( el ) => {
			const q = el.getBoundingClientRect();
			return { el, left: q.left - s.left, right: q.right - s.left, top: q.top - s.top, bottom: q.bottom - s.top, acceso: false };
		} );
		sporco = true;
		richiedi();
	}
	function disegna( ora ) {
		fotogramma = 0;
		if ( document.hidden ) {
			return;
		}
		const alto = scena.getBoundingClientRect().top;
		visibile = scrollY + innerHeight > inizio && alto + h > 0;
		const dt = prima ? Math.min( ora - prima, 50 ) : 16;
		prima = ora;
		const vive = visibile && ! fermo() && ora - ultimoGesto < 4000;
		if ( vive ) {
			tempo += dt / 1000;
		}
		const muove = Math.abs( tx - x ) + Math.abs( ty - y ) > 0.25;
		if ( muove ) {
			const k = 1 - Math.exp( -dt / 32 );
			x += ( tx - x ) * k;
			y += ( ty - y ) * k;
		}
		const p = ridotto.matches ? 0 : limita( ( scrollY - inizio ) / corsa );
		const cambia = p !== vecchio;
		const rivela = ridotto.matches ? 0 : curva( limita( p / 0.72 ) );
		const conMouse = mouse.matches && visto && ! fermo();
		if ( sporco || muove || cambia ) {
			const corre = p < 1 && intro.getBoundingClientRect().bottom > 0;
			if ( corre !== inCorso ) {
				inCorso = corre;
				radice.classList.toggle( 'refe-intro', corre );
				document.dispatchEvent( new CustomEvent( 'refe:cursore', { detail: { x, y } } ) );
			}
			if ( visibile ) {
				scena.style.setProperty( '--mx', `${ x }px` );
				scena.style.setProperty( '--my', `${ y - alto }px` );
				scena.style.setProperty( '--luce', conMouse ? '1' : '0' );
				scena.style.setProperty( '--alone', 1 - rivela );
				// Il simbolo fa un'ultima rotazione, poi vola verso il puntatore e diventa il cursore.
				const giro = curva( limita( p / 0.45 ) );
				let lx = px;
				let ly = Math.max( 0, scrollY - inizio ) + py;
				let scala = ps;
				let ruota = ridotto.matches ? 0 : giro * 360;
				scena.classList.toggle( 'staccato', p > 0.012 && p < 1 );
				if ( conMouse ) {
					const vola = curva( limita( ( p - 0.4 ) / 0.55 ) );
					ruota += vola * 360;
					lx += ( x - lx ) * vola;
					ly += ( y - alto - ly ) * vola;
					scala += ( misuraCursore / 53 - scala ) * vola;
				}
				simbolo.style.transform = `translate3d(${ lx - 26.5 }px,${ ly - 24 }px,0) scale(${ scala })` + ( ruota ? ` rotate(${ ruota }deg)` : '' );
				// Senza cursore il simbolo svanisce prima di uscire dalla copertina.
				simbolo.style.opacity = p >= 1 ? '0' : conMouse ? '1' : String( 1 - curva( limita( ( p - 0.5 ) / 0.35 ) ) );
				const opaco = 1 - curva( limita( ( p - 0.65 ) / 0.35 ) );
				testo.style.opacity = opaco;
				let acceso = false;
				blocchi.forEach( ( b ) => {
					const vicino = conMouse && x > b.left - 70 && x < b.right + 70 && y - alto > b.top - 70 && y - alto < b.bottom + 70;
					acceso ||= vicino;
					if ( vicino !== b.acceso ) {
						b.el.classList.toggle( 'illuminato', vicino );
						b.acceso = vicino;
					}
				} );
				scena.style.setProperty( '--ombra', Math.max( rivela, acceso ? 0.92 : 0 ) );
				testo.inert = opaco < 0.1;
			}
			vecchio = p;
		}
		if ( visibile && ( sporco || muove || cambia || ( vive && ora - ultimoDisegno >= 50 ) ) ) {
			if ( daMisurare ) {
				campo?.misura( w, h );
				daMisurare = false;
			}
			campo?.disegna( tempo, x, y - alto, rivela * Math.hypot( w, h ) );
			ultimoDisegno = ora;
		}
		sporco = false;
		if ( vive || muove ) {
			richiedi();
		}
	}

	/* ---------- Pausa ---------- */
	function pausa() {
		const si = fermo();
		radice.classList.toggle( 'refe-fermo', si );
		pulsante.setAttribute( 'aria-pressed', String( si ) );
		pulsante.textContent = ridotto.matches ? pulsante.dataset.ridotto : si ? pulsante.dataset.avvia : pulsante.dataset.pausa;
		pulsante.disabled = ridotto.matches;
		ultimoGesto = performance.now();
		sporco = true;
		vecchio = -1;
		loop();
		richiedi();
		document.dispatchEvent( new CustomEvent( 'refe:movimento', { detail: { fermo: si } } ) );
	}
	pulsante.addEventListener( 'click', () => {
		utente = ! utente;
		pausa();
	} );

	new IntersectionObserver( ( [ e ] ) => {
		visibile = e.isIntersecting;
		prima = 0;
		if ( visibile ) {
			sporco = true;
			richiedi();
		}
	} ).observe( scena );
	new ResizeObserver( misura ).observe( testo );
	new MutationObserver( loop ).observe( scena, { attributes: true, attributeFilter: [ 'class' ] } );
	addEventListener( 'resize', misura );
	addEventListener(
		'scroll',
		() => {
			ultimoGesto = performance.now();
			richiedi();
		},
		{ passive: true }
	);
	addEventListener(
		'pointermove',
		( e ) => {
			if ( ! mouse.matches || fermo() ) {
				return;
			}
			ultimoGesto = performance.now();
			visto = true;
			tx = e.clientX;
			ty = e.clientY;
			sporco = true;
			richiedi();
		},
		{ passive: true }
	);
	radice.addEventListener( 'pointerleave', () => {
		visto = false;
		sporco = true;
		richiedi();
	} );
	document.addEventListener( 'visibilitychange', () => {
		prima = 0;
		if ( ! document.hidden ) {
			sporco = true;
			richiedi();
		}
	} );
	ridotto.addEventListener( 'change', () => {
		pausa();
		misura();
	} );
	mouse.addEventListener( 'change', misura );
	scena.classList.add( 'loop-pronto' );
	pausa();
	misura();
	document.fonts?.ready.then( misura );
	if ( document.readyState === 'complete' ) {
		caricaVideo();
	} else {
		addEventListener( 'load', () => setTimeout( caricaVideo, 200 ), { once: true } );
	}
}

if ( intro ) {
	avvia();
}
