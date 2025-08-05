<?php

// Footer
Kirki::add_field( 'katen_settings', array(
    'type'     => 'text',
    'settings' => 'copyright',
    'label'    => esc_attr__( 'Copyright text', 'katen' ),
    'section'  => 'footer',
    'default'  => esc_attr__( '© 2023 Katen. Theme by ThemeGer.', 'katen' ),
	'partial_refresh'    => [
		'footer_copyright' => [
			'selector'        => 'span.copyright',
			'render_callback' => '__return_true',
		]
	],
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'footer_social',
	'label'       => esc_html__( 'Social Icons', 'katen' ),
	'section'     => 'footer',
	'default'     => '0',
	'partial_refresh'    => [
		'footer_social' => [
			'selector'        => '.footer-inner .social-icons',
			'render_callback' => '__return_true',
		]
	],
) );

Kirki::add_field( 'katen_settings', array(
	'type'        => 'toggle',
	'settings'    => 'footer_backtop',
	'label'       => esc_html__( 'Back to Top button', 'katen' ),
	'section'     => 'footer',
	'default'     => '1',
	'partial_refresh'    => [
		'footer_bt' => [
			'selector'        => '#return-to-top',
			'render_callback' => '__return_true',
		]
	],
) );