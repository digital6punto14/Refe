<?php
// This file is generated. Do not modify it manually.
return array(
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
	)
);
