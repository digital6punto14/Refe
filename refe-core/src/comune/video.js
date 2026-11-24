/* Lettore di terze parti o file: nasce solo al clic. */
export function lettore( url, titolo ) {
	if ( /^https:\/\/(www\.youtube-nocookie\.com|player\.vimeo\.com)\//.test( url ) ) {
		const f = document.createElement( 'iframe' );
		f.src = url;
		f.title = titolo;
		f.allow = 'autoplay; fullscreen; picture-in-picture';
		f.allowFullscreen = true;
		return f;
	}
	const v = document.createElement( 'video' );
	v.src = url;
	v.controls = true;
	v.autoplay = true;
	v.playsInline = true;
	return v;
}
