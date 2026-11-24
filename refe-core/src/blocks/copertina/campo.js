/* Sfondo WebGL: una trama in memoria per due palette (shader della demo). */
export default function campo( canvas ) {
	const gl = canvas.getContext( 'webgl', { alpha: false, antialias: false } );
	if ( ! gl ) {
		return null;
	}
	const vertice = 'attribute vec2 p;varying vec2 uv;void main(){uv=p*.5+.5;gl_Position=vec4(p,0.,1.);}';
	const rumore = `precision mediump float;varying vec2 uv;uniform float time,aspect;
float hash(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}
float n(vec2 p){vec2 i=floor(p),f=fract(p);f=f*f*(3.-2.*f);return mix(mix(hash(i),hash(i+vec2(1,0)),f.x),mix(hash(i+vec2(0,1)),hash(i+vec2(1,1)),f.x),f.y);}
void main(){vec2 p=vec2(uv.x*aspect,uv.y)*2.3;float t=time*.055;p+=vec2(sin(p.y+t),cos(p.x-t))*.55;float f=.7*n(p+vec2(t,-t*.2))+.3*n(p*2.03+3.7);gl_FragColor=vec4(vec3(smoothstep(.2,.85,f)),1.);}`;
	const insieme = `precision mediump float;varying vec2 uv;uniform sampler2D field;uniform vec2 res,mouse;uniform float radius,feather;
void main(){float f=texture2D(field,uv).r;vec3 dark=mix(vec3(.00784,.11765,.25882),vec3(.07,.25,.40),f*.48);vec3 bright=mix(vec3(.25,.55,.76),vec3(.68,.85,.94),f);float d=distance(vec2(gl_FragCoord.x,res.y-gl_FragCoord.y),mouse);float mask=radius<1.?0.:1.-smoothstep(max(0.,radius-feather),radius+feather,d);gl_FragColor=vec4(mix(dark,bright,mask),1.);}`;
	const programma = ( src ) => {
		const p = gl.createProgram();
		[
			[ gl.VERTEX_SHADER, vertice ],
			[ gl.FRAGMENT_SHADER, src ],
		].forEach( ( [ tipo, codice ] ) => {
			const s = gl.createShader( tipo );
			gl.shaderSource( s, codice );
			gl.compileShader( s );
			if ( ! gl.getShaderParameter( s, gl.COMPILE_STATUS ) ) {
				throw Error( gl.getShaderInfoLog( s ) );
			}
			gl.attachShader( p, s );
		} );
		gl.linkProgram( p );
		if ( ! gl.getProgramParameter( p, gl.LINK_STATUS ) ) {
			throw Error( gl.getProgramInfoLog( p ) );
		}
		return p;
	};
	let a;
	let b;
	try {
		a = programma( rumore );
		b = programma( insieme );
	} catch {
		return null; // Resta il fondo fisso.
	}
	const buffer = gl.createBuffer();
	gl.bindBuffer( gl.ARRAY_BUFFER, buffer );
	gl.bufferData( gl.ARRAY_BUFFER, new Float32Array( [ -1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1 ] ), gl.STATIC_DRAW );
	const usa = ( p ) => {
		gl.useProgram( p );
		const loc = gl.getAttribLocation( p, 'p' );
		gl.enableVertexAttribArray( loc );
		gl.vertexAttribPointer( loc, 2, gl.FLOAT, false, 0, 0 );
	};
	const u = ( p, n ) => gl.getUniformLocation( p, n );
	const at = u( a, 'time' ), aa = u( a, 'aspect' ), br = u( b, 'res' ), bm = u( b, 'mouse' ), bd = u( b, 'radius' ), bf = u( b, 'feather' );
	const trama = gl.createTexture();
	gl.bindTexture( gl.TEXTURE_2D, trama );
	[
		[ gl.TEXTURE_MIN_FILTER, gl.LINEAR ],
		[ gl.TEXTURE_MAG_FILTER, gl.LINEAR ],
		[ gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE ],
		[ gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE ],
	].forEach( ( [ k, v ] ) => gl.texParameteri( gl.TEXTURE_2D, k, v ) );
	const fb = gl.createFramebuffer();
	let scala = 1, tw = 1, th = 1, ultimo = -Infinity;
	return {
		misura( w, h ) {
			scala = Math.min( 0.4, 800 / w );
			canvas.width = Math.round( w * scala );
			canvas.height = Math.round( h * scala );
			tw = Math.max( 1, Math.round( canvas.width * 0.5 ) );
			th = Math.max( 1, Math.round( canvas.height * 0.5 ) );
			gl.bindTexture( gl.TEXTURE_2D, trama );
			gl.texImage2D( gl.TEXTURE_2D, 0, gl.RGBA, tw, th, 0, gl.RGBA, gl.UNSIGNED_BYTE, null );
			gl.bindFramebuffer( gl.FRAMEBUFFER, fb );
			gl.framebufferTexture2D( gl.FRAMEBUFFER, gl.COLOR_ATTACHMENT0, gl.TEXTURE_2D, trama, 0 );
			gl.bindFramebuffer( gl.FRAMEBUFFER, null );
			ultimo = -Infinity;
		},
		disegna( tempo, x, y, raggio ) {
			if ( tempo - ultimo >= 0.05 || ! Number.isFinite( ultimo ) ) {
				gl.bindFramebuffer( gl.FRAMEBUFFER, fb );
				gl.viewport( 0, 0, tw, th );
				usa( a );
				gl.uniform1f( at, tempo );
				gl.uniform1f( aa, canvas.width / canvas.height );
				gl.drawArrays( gl.TRIANGLES, 0, 6 );
				ultimo = tempo;
			}
			gl.bindFramebuffer( gl.FRAMEBUFFER, null );
			gl.viewport( 0, 0, canvas.width, canvas.height );
			usa( b );
			gl.bindTexture( gl.TEXTURE_2D, trama );
			gl.uniform2f( br, canvas.width, canvas.height );
			gl.uniform2f( bm, x * scala, y * scala );
			gl.uniform1f( bd, raggio * scala );
			gl.uniform1f( bf, 35 * scala );
			gl.drawArrays( gl.TRIANGLES, 0, 6 );
		},
	};
}
