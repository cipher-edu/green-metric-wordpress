<?php

// Typography
Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_body',
    'label'       => esc_attr__( 'Body', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'body',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h1',
    'label'       => esc_attr__( 'Heading 1', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h1',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h2',
    'label'       => esc_attr__( 'Heading 2', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h2',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h3',
    'label'       => esc_attr__( 'Heading 3', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h3',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h4',
    'label'       => esc_attr__( 'Heading 4', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h4',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h5',
    'label'       => esc_attr__( 'Heading 5', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h5',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_h6',
    'label'       => esc_attr__( 'Heading 6', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => 'h6',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_navmenu',
    'label'       => esc_attr__( 'Navigation menu', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => '.navbar-nav, .canvas-menu .vertical-menu li a',
        ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'typography',
    'settings'    => 'typo_button',
    'label'       => esc_attr__( 'Button', 'katen' ),
    'section'     => 'typography',
    'default'     => array(
        'font-family'    => '',
        'variant'        => '',
        'font-size'      => '',
        'line-height'    => '',
        'letter-spacing' => '',
        'color'          => '',
        'text-transform' => '',
        'text-align'     => '',
    ),
    'output'      => array(
        array(
            'element' => '.btn-default, button, .wp-block-search__button button[type=submit], input[type=submit], input[type=button], .widget .searchform input[type=submit], .comment-respond input[type=submit], .comment-reply-link',
        ),
    ),
) );