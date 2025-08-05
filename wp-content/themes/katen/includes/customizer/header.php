<?php

// Header
Kirki::add_field( 'katen_settings', array(
    'type'        => 'image',
    'settings'    => 'logo_default',
    'label'       => esc_attr__( 'Logo', 'katen' ),
    'description' => esc_attr__( 'Upload your image file', 'katen' ),
    'section'     => 'header_logo',
	'partial_refresh'    => [
		'site_logo' => [
			'selector'        => '.navbar-brand',
			'render_callback' => '__return_true',
		]
	],
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'image',
    'settings'    => 'logo_light',
    'label'       => esc_attr__( 'Logo light', 'katen' ),
    'description' => esc_attr__( 'Upload your image file', 'katen' ),
    'section'     => 'header_logo',
) );

new \Kirki\Field\Text(
	[
		'settings' => 'logo_width',
		'label'    => esc_html__( 'Logo width', 'katen' ),
		'section'  => 'header_logo',
		'default'  => esc_html__( '118', 'katen' ),
	]
);

new \Kirki\Field\Text(
	[
		'settings' => 'logo_height',
		'label'    => esc_html__( 'Logo height', 'katen' ),
		'section'  => 'header_logo',
		'default'  => esc_html__( '26', 'katen' ),
	]
);

Kirki::add_field( 'katen_settings', [
	'type'        => 'radio-image',
	'settings'    => 'header_layout',
	'label'       => esc_html__( 'Header layout', 'katen' ),
	'section'     => 'header_layout',
	'default'     => 'header_default',
	'priority'    => 10,
	'choices'     => [
		'header_default'   => get_template_directory_uri() . '/images/customizer/header_default.png',
		'header_personal' => get_template_directory_uri() . '/images/customizer/header_personal.png',
		'header_classic'  => get_template_directory_uri() . '/images/customizer/header_classic.png',
		'header_minimal'  => get_template_directory_uri() . '/images/customizer/header_minimal.png',
	],
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'reading_bar',
    'label'       => esc_attr__( 'Reading Bar', 'katen' ),
    'section'     => 'header_options',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'sticky_header',
    'label'       => esc_attr__( 'Sticky Header', 'katen' ),
    'section'     => 'header_options',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'social_header',
    'label'       => esc_attr__( 'Social Icons', 'katen' ),
    'section'     => 'header_options',
    'default'     => '0',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'search_button',
    'label'       => esc_attr__( 'Search Button', 'katen' ),
    'section'     => 'header_options',
    'default'     => '1',
	'partial_refresh'    => [
		'header_right' => [
			'selector'        => '.header-right',
			'render_callback' => '__return_true',
		]
	],
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'text_logo',
	'label'       => esc_html__( 'Show Text Logo', 'katen' ),
	'tooltip' => esc_html__( 'Text logo on header personal. (header-2)', 'katen' ),
	'section'     => 'header_options',
	'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'text_slogan',
	'label'       => esc_html__( 'Show Slogan', 'katen' ),
	'tooltip' => esc_html__( 'Text slogan on header personal. (header-2)', 'katen' ),
	'section'     => 'header_options',
	'default'     => '1',
) );

new \Kirki\Field\Select(
	[
		'settings'    => 'menu_button',
		'label'       => esc_html__( 'Canvas off menu button', 'katen' ),
		'section'     => 'header_options',
		'default'     => '2',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Desktop & Mobile', 'katen' ),
			'2' => esc_html__( 'Mobile Only', 'katen' ),
		],
	]
);

Kirki::add_field( 'katen_settings', array(
    'type'        => 'switch',
    'settings'    => 'header_color',
    'label'       => esc_attr__( 'Dark Mode', 'katen' ),
    'section'     => 'header_style',
    'default'     => '2',
    'choices'     => array(
        '1'  => esc_attr__( 'Enable', 'katen' ),
        '2' => esc_attr__( 'Disable', 'katen' ),
    ),
) );

new \Kirki\Field\Background(
	[
		'settings'    => 'header_background',
		'label'       => esc_html__( 'Background Control', 'katen' ),
		'section'     => 'header_style',
		'default'     => [
			'background-color'      => '#FFF',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		],
		'transport'   => 'auto',
		'output'      => [
			[
				'element' => 'header',
			],
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'header_overlay',
		'label'       => __( 'Overlay Color (rgba)', 'katen' ),
		'section'     => 'header_style',
		'default'     => 'rgba(255, 255, 255, 0)',
		'choices'     => [
			'alpha' => true,
		],
		'output'      => [
			[
				'element' => 'header:after',
				'property' => 'background-color'
			],
		],
	]
);

new \Kirki\Field\Radio_Buttonset(
	[
		'settings'    => 'reveal_position',
		'label'       => esc_html__( 'Reveal position', 'katen' ),
		'section'     => 'canvas_sidebar',
		'default'     => 'right',
		'choices'     => [
			'left'   => esc_html__( 'Left', 'katen' ),
			'right' => esc_html__( 'Right', 'katen' ),
		],
	]
);

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'canvas_logo',
	'label'       => esc_html__( 'Logo', 'katen' ),
	'section'     => 'canvas_sidebar',
	'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'canvas_social',
	'label'       => esc_html__( 'Social Icons', 'katen' ),
	'section'     => 'canvas_sidebar',
	'default'     => '0',
	'partial_refresh'    => [
		'canvas_social' => [
			'selector'        => '.canvas-menu .social-icons',
			'render_callback' => '__return_true',
		]
	],
) );