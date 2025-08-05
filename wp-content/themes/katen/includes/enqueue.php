<?php

/* Register Styles */
function katen_theme_styles()
{
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', 'style');

	wp_enqueue_style('font-awesome-6', get_template_directory_uri() . '/css/fontawesome.min.css', 'style');

	wp_enqueue_style('font-awesome-brands', get_template_directory_uri() . '/css/brands.min.css', 'style');

	wp_enqueue_style('font-awesome-solid', get_template_directory_uri() . '/css/solid.min.css', 'style');

	wp_enqueue_style('simple-line-icons', get_template_directory_uri() . '/css/simple-line-icons.css', 'style');

	wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css', 'style');

	wp_enqueue_style('katen-default-style', get_template_directory_uri() . '/css/style.css', 'style');

	wp_enqueue_style('katen-style', get_template_directory_uri() . '/style.css', 'style');
	
}
add_action( 'wp_enqueue_scripts', 'katen_theme_styles' );




/* Register Scripts */
function katen_theme_scripts()
{
    wp_enqueue_style( 'katen-primary-font', katen_theme_primary_fonts_url(), array(), '1.0.0' );

	wp_enqueue_style( 'katen-secondary-font', katen_theme_secondary_fonts_url(), array(), '1.0.0' );

	wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'),'',true );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'),'',true );

	wp_enqueue_script( 'infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.min.js', array('jquery'),'',true );

	wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/js/slick.min.js', array('jquery'),'',true );

	wp_enqueue_script('katen-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', true);

}
add_action( 'wp_enqueue_scripts', 'katen_theme_scripts' );

function katen_theme_primary_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'katen' ) ) {
        $font_url = add_query_arg( 'family', urldecode( 'Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap' ), "//fonts.googleapis.com/css2" );
    }
    return esc_url_raw( $font_url );
}

function katen_theme_secondary_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'katen' ) ) {
        $font_url = add_query_arg( 'family', urldecode( 'Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap' ), "//fonts.googleapis.com/css2" );
    }
    return esc_url_raw( $font_url );
}

function katen_custom_wp_admin_style(){
    wp_enqueue_style('katen-admin', get_template_directory_uri() . '/css/admin.css', 'style');
    wp_enqueue_style( 'katen-primary-font', katen_theme_primary_fonts_url(), array(), '1.0.0' );
	wp_enqueue_style( 'katen-secondary-font', katen_theme_secondary_fonts_url(), array(), '1.0.0' );
    wp_enqueue_style('simple-line-icons', get_template_directory_uri() . '/css/simple-line-icons.css', 'style');
}
add_action('admin_enqueue_scripts', 'katen_custom_wp_admin_style');