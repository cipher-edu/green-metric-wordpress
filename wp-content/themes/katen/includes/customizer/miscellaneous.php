<?php

// Miscellaneous
Kirki::add_field( 'katen_settings', array(
    'type'        => 'switch',
    'settings'    => 'preloader',
    'label'       => esc_attr__( 'Preloader', 'katen' ),
    'section'     => 'miscellaneous',
    'default'     => '0',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'katen' ),
        'off' => esc_attr__( 'Disable', 'katen' ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'color',
    'settings'    => 'preloader_bg',
    'label'       => esc_attr__( 'Preloader background color', 'katen' ),
    'section'     => 'miscellaneous',
    'default'     => '#FFF',
) );