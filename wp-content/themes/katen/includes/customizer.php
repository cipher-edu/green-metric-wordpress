<?php

// Config
Kirki::add_config( 'katen_settings', array(
  'capability'    => 'edit_theme_options',
  'option_type'   => 'theme_mod',
) );

// Sections
Kirki::add_section( 'header_logo', array(
    'title'          => esc_attr__( 'Logo', 'katen' ),
    'panel'          => 'header',
) );

Kirki::add_section( 'header_layout', array(
    'title'          => esc_attr__( 'Layout', 'katen' ),
    'panel'          => 'header',
) );

Kirki::add_section( 'header_options', array(
    'title'          => esc_attr__( 'Options', 'katen' ),
    'panel'          => 'header',
) );

Kirki::add_section( 'header_style', array(
    'title'          => esc_attr__( 'Style', 'katen' ),
    'panel'          => 'header',
) );

Kirki::add_section( 'canvas_sidebar', array(
    'title'          => esc_attr__( 'Canvas Off Sidebar', 'katen' ),
    'panel'          => 'header',
) );

Kirki::add_section( 'site_color', array(
    'title'          => esc_attr__( 'Color', 'katen' ),
    'priority'       => 150,
) );

Kirki::add_section( 'page_header', array(
    'title'          => esc_attr__( 'Page header', 'katen' ),
    'panel'          => 'page',
) );

Kirki::add_section( 'social', array(
    'title'          => esc_attr__( 'Social', 'katen' ),
    'priority'       => 130,
) );

Kirki::add_section( 'typography', array(
    'title'          => esc_attr__( 'Typography', 'katen' ),
    'priority'       => 160,
) );

Kirki::add_section( 'footer', array(
    'title'          => esc_attr__( 'Footer', 'katen' ),
    'priority'       => 175,
) );

Kirki::add_section( 'miscellaneous', array(
    'title'          => esc_attr__( 'Miscellaneous', 'katen' ),
    'priority'       => 170,
) );

Kirki::add_section( 'blog_archive', array(
    'title'          => esc_attr__( 'Blog Posts', 'katen' ),
    'panel'          => 'blog',
) );

Kirki::add_section( 'blog_single', array(
    'title'          => esc_attr__( 'Single Post', 'katen' ),
    'panel'          => 'blog',
) );

Kirki::add_section( 'blog_layouts', array(
    'title'          => esc_attr__( 'Layouts', 'katen' ),
    'panel'          => 'blog',
) );

// Panels
Kirki::add_panel( 'header', array(
    'priority'    => 130,
    'title'       => esc_attr__( 'Header', 'katen' ),
) );

Kirki::add_panel( 'blog', array(
    'priority'    => 145,
    'title'       => esc_attr__( 'Blog', 'katen' ),
) );

Kirki::add_panel( 'page', array(
    'priority'    => 150,
    'title'       => esc_attr__( 'Page', 'katen' ),
) );

// Include options
require_once  get_parent_theme_file_path().'/includes/customizer/header.php';
require_once  get_parent_theme_file_path().'/includes/customizer/color.php';
require_once  get_parent_theme_file_path().'/includes/customizer/footer.php';
require_once  get_parent_theme_file_path().'/includes/customizer/blog.php';
require_once  get_parent_theme_file_path().'/includes/customizer/page.php';
require_once  get_parent_theme_file_path().'/includes/customizer/social.php';
require_once  get_parent_theme_file_path().'/includes/customizer/typography.php';
require_once  get_parent_theme_file_path().'/includes/customizer/miscellaneous.php';