<?php

// Social
Kirki::add_field( 'katen_settings', array(
    'type'        => 'repeater',
    'label'       => esc_attr__( 'Social Icons', 'katen' ),
    'description' => esc_attr__( 'Find social names here: https://fontawesome.com/search?o=r&f=brands', 'katen' ),
    'section'     => 'social',
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Social ID', 'katen' ),
    ),
    'button_label' => esc_attr__('Add new', 'katen' ),
    'settings'     => 'social_icons',
    'default'      => array(
        array(
          'icon_name' => esc_attr__( 'facebook-f', 'katen' ),
          'social_url'  => 'http://facebook.com/username',
        ),
        array(
          'icon_name' => esc_attr__( 'twitter', 'katen' ),
          'social_url'  => 'http://twitter.com/username',
        ),
        array(
            'icon_name' => esc_attr__( 'instagram', 'katen' ),
            'social_url'  => 'http://instagram.com/username',
        ),
        array(
            'icon_name' => esc_attr__( 'pinterest', 'katen' ),
            'social_url'  => 'http://pinterest.com/username',
        ),
        array(
            'icon_name' => esc_attr__( 'tiktok', 'katen' ),
            'social_url'  => 'http://tiktok.com/username',
        ),
        array(
            'icon_name' => esc_attr__( 'youtube', 'katen' ),
            'social_url'  => 'http://youtube.com/username',
        ),
    ),
    'fields' => array(
        'icon_name' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social name', 'katen' ),
            'default'     => '',
        ),
        'social_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social link', 'katen' ),
            'default'     => '',
        ),
    ),
) );