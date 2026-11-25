<?php
// This file is generated. Do not modify it manually.
return array(
	'card-girevole' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/card-girevole',
		'title' => 'Scheda girevole',
		'category' => 'refe',
		'icon' => 'image-flip-horizontal',
		'description' => 'Si gira al passaggio del mouse, al tocco o da tastiera. Fronte e retro sono a blocchi.',
		'textdomain' => 'refe-core',
		'allowedBlocks' => array(
			'refe/faccia'
		),
		'attributes' => array(
			'nome' => array(
				'type' => 'string',
				'default' => ''
			),
			'filigrana' => array(
				'type' => 'string',
				'default' => 'scura'
			)
		),
		'styles' => array(
			array(
				'name' => 'normale',
				'label' => 'Normale',
				'isDefault' => true
			),
			array(
				'name' => 'grande',
				'label' => 'Grande'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'contatore' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/contatore',
		'title' => 'Contatore',
		'category' => 'refe',
		'icon' => 'calculator',
		'description' => 'Numero che ruota fino al valore quando entra nello schermo.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'numero' => array(
				'type' => 'number',
				'default' => 0
			),
			'testo' => array(
				'type' => 'string',
				'default' => ''
			),
			'prefisso' => array(
				'type' => 'string',
				'default' => ''
			),
			'suffisso' => array(
				'type' => 'string',
				'default' => ''
			),
			'etichetta' => array(
				'type' => 'string',
				'default' => '',
				'role' => 'content'
			),
			'segnaposto' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => false
			),
			'typography' => array(
				'fontSize' => true,
				'__experimentalFontWeight' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'copertina' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/copertina',
		'title' => 'Copertina animata',
		'category' => 'refe',
		'icon' => 'cover-image',
		'description' => 'Sfondo animato, simbolo che diventa cursore, testi a blocchi. Solo in cima alla Home.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'align' => array(
				'type' => 'string',
				'default' => 'full'
			),
			'video' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'simbolo' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'venti' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'descrizione' => array(
				'type' => 'string',
				'default' => 'Refe, 20 anni'
			),
			'sfondo' => array(
				'type' => 'boolean',
				'default' => true
			),
			'testoPausa' => array(
				'type' => 'string',
				'default' => 'Pausa animazione'
			),
			'testoAvvia' => array(
				'type' => 'string',
				'default' => 'Riprendi animazione'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'align' => array(
				'full'
			),
			'multiple' => false
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'corso' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/corso',
		'title' => 'Videocorso',
		'category' => 'refe',
		'icon' => 'welcome-learn-more',
		'description' => 'Lettore, moduli e lezioni, con avanzamento ricordato nel browser.',
		'textdomain' => 'refe-core',
		'allowedBlocks' => array(
			'refe/modulo'
		),
		'attributes' => array(
			'immagine' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'faccia' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/faccia',
		'title' => 'Faccia',
		'category' => 'refe',
		'icon' => 'id',
		'description' => 'Fronte o retro della scheda girevole.',
		'textdomain' => 'refe-core',
		'parent' => array(
			'refe/card-girevole'
		),
		'attributes' => array(
			'lato' => array(
				'type' => 'string',
				'default' => 'fronte'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'reusable' => false,
			'inserter' => false,
			'color' => array(
				'text' => true,
				'background' => true,
				'gradients' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'indice' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/indice',
		'title' => 'Indice',
		'category' => 'refe',
		'icon' => 'list-view',
		'description' => 'Indice automatico dai titoli della pagina, con barra di lettura.',
		'textdomain' => 'refe-core',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			'titolo' => array(
				'type' => 'string',
				'default' => 'In questa pagina',
				'role' => 'content'
			),
			'barra' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'multiple' => false
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'lezione' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/lezione',
		'title' => 'Lezione',
		'category' => 'refe',
		'icon' => 'video-alt3',
		'description' => 'Titolo, durata e video di una lezione.',
		'textdomain' => 'refe-core',
		'parent' => array(
			'refe/modulo'
		),
		'attributes' => array(
			'titolo' => array(
				'type' => 'string',
				'default' => '',
				'role' => 'content'
			),
			'durata' => array(
				'type' => 'string',
				'default' => '00:00'
			),
			'link' => array(
				'type' => 'string',
				'default' => ''
			),
			'file' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'metodo-rivelato' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/metodo-rivelato',
		'title' => 'Metodo rivelato',
		'category' => 'refe',
		'icon' => 'visibility',
		'description' => 'Un’immagine parte al centro, si sposta con lo scorrimento e rivela i testi.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'immagine' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'modulo' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/modulo',
		'title' => 'Modulo del corso',
		'category' => 'refe',
		'icon' => 'category',
		'description' => 'Gruppo di lezioni.',
		'textdomain' => 'refe-core',
		'parent' => array(
			'refe/corso'
		),
		'allowedBlocks' => array(
			'refe/lezione'
		),
		'attributes' => array(
			'titolo' => array(
				'type' => 'string',
				'default' => '',
				'role' => 'content'
			),
			'aperto' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'reusable' => false
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'news' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/news',
		'title' => 'News',
		'category' => 'refe',
		'icon' => 'megaphone',
		'description' => 'Griglia con filtri o striscia a scorrimento degli articoli.',
		'textdomain' => 'refe-core',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			'formato' => array(
				'type' => 'string',
				'default' => 'griglia'
			),
			'filtri' => array(
				'type' => 'boolean',
				'default' => false
			),
			'quante' => array(
				'type' => 'number',
				'default' => 0
			),
			'categoria' => array(
				'type' => 'number',
				'default' => 0
			),
			'escludiCorrente' => array(
				'type' => 'boolean',
				'default' => false
			),
			'durata' => array(
				'type' => 'number',
				'default' => 28
			),
			'testoTutte' => array(
				'type' => 'string',
				'default' => 'Tutte'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'interactivity' => true
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'pannelli' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/pannelli',
		'title' => 'Pannelli a scorrimento',
		'category' => 'refe',
		'icon' => 'align-full-width',
		'description' => 'L’immagine resta ferma e i testi si alternano con lo scorrimento.',
		'textdomain' => 'refe-core',
		'allowedBlocks' => array(
			'refe/pannello'
		),
		'attributes' => array(
			'immagine' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'linea' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'pannello' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/pannello',
		'title' => 'Pannello',
		'category' => 'refe',
		'icon' => 'align-left',
		'description' => 'Uno dei testi dei Pannelli a scorrimento.',
		'textdomain' => 'refe-core',
		'parent' => array(
			'refe/pannelli'
		),
		'attributes' => array(
			
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'reusable' => false,
			'color' => array(
				'text' => true,
				'background' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'render' => 'file:./render.php'
	),
	'pannello-menu' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/pannello-menu',
		'title' => 'Pannello menu',
		'category' => 'refe',
		'icon' => 'menu-alt',
		'description' => 'Voce di menu che apre un pannello largo con blocchi a scelta.',
		'parent' => array(
			'core/navigation'
		),
		'textdomain' => 'refe-core',
		'attributes' => array(
			'label' => array(
				'type' => 'string',
				'default' => '',
				'role' => 'content'
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false,
			'spacing' => array(
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => true,
				'gradients' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'editorStyle' => 'file:./index.css',
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'persone' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/persone',
		'title' => 'Persone',
		'category' => 'refe',
		'icon' => 'groups',
		'description' => 'Schede delle persone; girano e mostrano il video.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'scelte' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'quante' => array(
				'type' => 'number',
				'default' => 0
			),
			'testoLink' => array(
				'type' => 'string',
				'default' => 'Guarda il video'
			),
			'video' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'progetti' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/progetti',
		'title' => 'Case studies',
		'category' => 'refe',
		'icon' => 'portfolio',
		'description' => 'Elenco o carosello dei case studies, con filtri.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'formato' => array(
				'type' => 'string',
				'default' => 'griglia'
			),
			'colonne' => array(
				'type' => 'number',
				'default' => 2
			),
			'filtri' => array(
				'type' => 'boolean',
				'default' => false
			),
			'quanti' => array(
				'type' => 'number',
				'default' => 0
			),
			'scelti' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'tipo' => array(
				'type' => 'number',
				'default' => 0
			),
			'soluzione' => array(
				'type' => 'number',
				'default' => 0
			),
			'escludiCorrente' => array(
				'type' => 'boolean',
				'default' => false
			),
			'testoTutti' => array(
				'type' => 'string',
				'default' => 'Tutti i progetti'
			),
			'testoLink' => array(
				'type' => 'string',
				'default' => 'Scopri'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'interactivity' => true
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'progetto-successivo' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/progetto-successivo',
		'title' => 'Progetto successivo',
		'category' => 'refe',
		'icon' => 'arrow-right-alt',
		'description' => 'Fascia verso il case study che segue, secondo l’ordine.',
		'textdomain' => 'refe-core',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			'align' => array(
				'type' => 'string',
				'default' => 'full'
			),
			'testo' => array(
				'type' => 'string',
				'default' => 'Progetto successivo',
				'role' => 'content'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'align' => array(
				'full'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'render' => 'file:./render.php'
	),
	'ricerca' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/ricerca',
		'title' => 'Ricerca',
		'category' => 'refe',
		'icon' => 'search',
		'description' => 'Pulsante che apre la ricerca in tutto il sito.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'titolo' => array(
				'type' => 'string',
				'default' => 'Cerca nel sito',
				'role' => 'content'
			),
			'etichetta' => array(
				'type' => 'string',
				'default' => 'Cosa stai cercando?',
				'role' => 'content'
			),
			'esempio' => array(
				'type' => 'string',
				'default' => 'Metodo, attività, piattaforme…'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'interactivity' => true,
			'multiple' => false
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'risultati' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/risultati',
		'title' => 'Risultati del progetto',
		'category' => 'refe',
		'icon' => 'chart-bar',
		'description' => 'I risultati scritti nella scheda del case study.',
		'textdomain' => 'refe-core',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'render' => 'file:./render.php'
	),
	'testimonianze' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'refe/testimonianze',
		'title' => 'Testimonianze',
		'category' => 'refe',
		'icon' => 'format-quote',
		'description' => 'Slider automatico delle testimonianze con un testo a fianco.',
		'textdomain' => 'refe-core',
		'attributes' => array(
			'scelte' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'quante' => array(
				'type' => 'number',
				'default' => 0
			),
			'intervallo' => array(
				'type' => 'number',
				'default' => 5200
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true,
				'blockGap' => true
			),
			'color' => array(
				'text' => true,
				'background' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'refe-comune',
			'file:./style-index.css'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
