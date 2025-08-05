<?php

// Color
Kirki::add_field( 'katen_settings', [
	'type'        => 'custom',
	'settings'    => 'section_title_0',
	'section'     => 'site_color',
	'default'     => '<div class="customizer-section-title">' . esc_html__( 'Dark mode', 'katen' ) . '</div>'
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'switch',
    'settings'    => 'dark_mode',
    'label'       => esc_attr__( 'Dark mode', 'katen' ),
    'section'     => 'site_color',
    'default'     => '0',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'katen' ),
        'off' => esc_attr__( 'Disable', 'katen' ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'switcher_button',
	'label'       => esc_html__( 'Switcher button', 'katen' ),
	'section'     => 'site_color',
	'default'     => '0',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'dark_bg_color',
    'label'       => esc_attr__( 'Dark background color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#142030',
) );

Kirki::add_field( 'katen_settings', [
	'type'        => 'custom',
	'settings'    => 'section_title_1',
	'section'     => 'site_color',
	'default'     => '<div class="customizer-section-title">' . esc_html__( 'General', 'katen' ) . '</div>'
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'body_bg_color',
    'label'       => esc_attr__( 'Body background color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#FFF',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'primary_color',
    'label'       => esc_attr__( 'Primary color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#FE4F70',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'secondary_color',
    'label'       => esc_attr__( 'Secondary color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#FFA387',
) );

Kirki::add_field( 'katen_settings', [
	'type'        => 'custom',
	'settings'    => 'section_title_2',
	'section'     => 'site_color',
	'default'     => '<div class="customizer-section-title">' . esc_html__( 'Typography', 'katen' ) . '</div>'
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'body_color',
    'label'       => esc_attr__( 'Body color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#8F9BAD',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'body_secondary_color',
    'label'       => esc_attr__( 'Body secondary color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#8F9BAD',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'headings_color',
    'label'       => esc_attr__( 'Heading color', 'katen' ),
    'description' => esc_attr__('H1-H6 tags', 'katen'),
    'section'     => 'site_color',
    'default'     => '#203656',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'content_color',
    'label'       => esc_attr__( 'Post content color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#707a88',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'dark_text_color',
    'label'       => esc_attr__( 'Dark text color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#203656',
) );

Kirki::add_field( 'katen_settings', [
	'type'        => 'custom',
	'settings'    => 'section_title_4',
	'section'     => 'site_color',
	'default'     => '<div class="customizer-section-title">' . esc_html__( 'Menu', 'katen' ) . '</div>'
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'menu_color',
    'label'       => esc_attr__( 'Menu color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#79889e',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'menu_hover_color',
    'label'       => esc_attr__( 'Menu hover color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#203656',
) );

Kirki::add_field( 'katen_settings', [
	'type'        => 'custom',
	'settings'    => 'section_title_5',
	'section'     => 'site_color',
	'default'     => '<div class="customizer-section-title">' . esc_html__( 'Canvas Menu', 'katen' ) . '</div>'
] );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'canvas_menu_color',
    'label'       => esc_attr__( 'Canvas menu color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#203656',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'canvas_menu_hover_color',
    'label'       => esc_attr__( 'Hover color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#203656',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'canvas_submenu_color',
    'label'       => esc_attr__( 'Submenu color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#79889e',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'canvas_submenu_hover_color',
    'label'       => esc_attr__( 'Submenu hover color', 'katen' ),
    'section'     => 'site_color',
    'default'     => '#203656',
) );