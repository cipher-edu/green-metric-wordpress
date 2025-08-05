<?php

// Page
new \Kirki\Field\Background(
	[
		'settings'    => 'page_header_background',
		'label'       => esc_html__( 'Background', 'katen' ),
		'section'     => 'page_header',
		'default'     => [
			'background-color'      => '#F1F8FF',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		],
		'transport'   => 'auto',
		'output'      => [
			[
				'element' => '.page-header',
			],
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'page_header_overlay',
		'label'       => __( 'Overlay Color (rgba)', 'katen' ),
		'section'     => 'page_header',
		'default'     => 'rgba(255, 255, 255, 0)',
		'choices'     => [
			'alpha' => true,
		],
		'output'      => [
			[
				'element' => '.page-header:after',
				'property' => 'background-color'
			],
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'page_header_title',
		'label'       => __( 'Title color', 'katen' ),
		'section'     => 'page_header',
		'default'     => '#203656',
		'choices'     => [
			'alpha' => true,
		],
        'output'      => [
			[
				'element' => '.page-header h1',
			],
		],
	]
);