/* Testata: diventa bianca quando sta sopra una sezione arancione. */
(() => {
	const header = document.querySelector('header.wp-block-template-part');
	const fasce = [...document.querySelectorAll('.is-style-schema-solar-ember')];
	if (!header || !fasce.length) return;
	let frame = 0;
	const aggiorna = () => {
		frame = 0;
		header.classList.toggle('su-arancione', fasce.some(f => {
			const r = f.getBoundingClientRect();
			return r.top < 58 && r.bottom > 58;
		}));
	};
	const prenota = () => { if (!frame) frame = requestAnimationFrame(aggiorna); };
	addEventListener('scroll', prenota, {passive: true});
	addEventListener('resize', prenota, {passive: true});
	aggiorna();
})();
