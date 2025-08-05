<?php
/* ================================================== */
/*    |               Include                    |    */
/* ================================================== */
require_once  get_parent_theme_file_path().'/includes/theme-css.php';
require_once  get_parent_theme_file_path().'/includes/enqueue.php';
require_once  get_parent_theme_file_path().'/includes/theme-functions.php';
require_once  get_parent_theme_file_path().'/includes/post-metabox.php';
require_once  get_parent_theme_file_path().'/includes/katen-bootstrap-navwalker.php';
require_once  get_parent_theme_file_path().'/includes/plugin-activation/class-tgm-plugin-activation.php';

// kirki
if (class_exists( 'Kirki' ) && file_exists(get_template_directory() . '/includes/customizer.php')) { 
	require_once  get_parent_theme_file_path().'/includes/customizer.php';
}

/* ================================================== */
/*    |         TGMPA Plugin Activation          |    */
/* ================================================== */
add_action( 'tgmpa_register', 'katen_theme_register_required_plugins' );

function katen_theme_register_required_plugins() {
	$plugins = array(

		array(
			'name'      => esc_attr('One Click Demo Import', 'katen'),
			'slug'      => 'one-click-demo-import',
			'required'  => true,
		),

		array(
			'name'      => esc_attr('Elementor Page Builder', 'katen'),
			'slug'      => 'elementor',
			'required'  => true,
		),

		array(
			'name'      => esc_attr('Kirki', 'katen'),
			'slug'      => 'kirki',
			'required'  => true,
		),

		array(
			'name'               => esc_attr('Katen Elementor Addons', 'katen'),
			'slug'               => 'katen-elementor-addons',
			'source'             => get_template_directory() . '/includes/plugin-activation/katen-elementor-addons.zip',
			'required'           => true,
		),

		array(
			'name'               => esc_attr('Katen Theme Post Social Share', 'katen'),
			'slug'               => 'katen-social-share',
			'source'             => get_template_directory() . '/includes/plugin-activation/katen-social-share.zip',
			'required'           => true,
		),

		array(
			'name'               => esc_attr('Katen Theme Widgets', 'katen'),
			'slug'               => 'katen-widgets',
			'source'             => get_template_directory() . '/includes/plugin-activation/katen-widgets.zip',
			'required'           => true,
		),

		array(
			'name'      => esc_attr('CMB2', 'katen'),
			'slug'      => 'cmb2',
			'required'  => true,
		),

		array(
			'name'      => esc_attr('WooCommerce', 'katen'),
			'slug'      => 'woocommerce',
			'required'  => false,
		),

		array(
			'name'      => esc_attr('Breadcrumb NavXT', 'katen'),
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
		),

		array(
			'name'      => esc_attr('Contact Form 7', 'katen'),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		array(
			'name'      => esc_attr('Smash Balloon Social Photo Feed', 'katen'),
			'slug'      => 'instagram-feed',
			'required'  => false,
		),

		array(
			'name'      => esc_attr('MC4WP: Mailchimp for WordPress', 'katen'),
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),

		array(
			'name'      => esc_attr('Widget CSS Classes', 'katen'),
			'slug'      => 'widget-css-classes',
			'required'  => false,
		),

	);

	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/* ================================================== */
/*    |         One Click Demo Importer          |    */
/* ================================================== */
function katen_import_demos() {
	return array(
			array(
					'import_file_name'           => esc_attr('01. Magazine', 'katen'),
					'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-1.xml',
					'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-1.wie',
					'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-1.dat',
					'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/magazine.png',
					'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
					'preview_url'                => 'https://themeger.shop/wordpress/katen',
			),
			array(
				'import_file_name'           => esc_attr('02. Personal', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-2.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-2.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-2.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/personal.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/personal',
			),
			array(
				'import_file_name'           => esc_attr('03. Personal Alternative', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-3.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-3.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-3.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/personal-alt.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/personal-alt',
			),
			array(
				'import_file_name'           => esc_attr('04. Classic', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-4.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-4.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-4.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/classic.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/classic',
			),
			array(
				'import_file_name'           => esc_attr('05. Minimal', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-5.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-5.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-5.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/minimal.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/minimal',
			),
			array(
				'import_file_name'           => esc_attr('06. Dark', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-6.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-6.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-6.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/dark.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/dark',
			),
			array(
				'import_file_name'           => esc_attr('07. Catalog', 'katen'),
				'import_file_url'            => 'https://themeger.shop/demo-content/katen/demo-content-7.xml',
				'import_widget_file_url'     => 'https://themeger.shop/demo-content/katen/widgets-7.wie',
				'import_customizer_file_url' => 'https://themeger.shop/demo-content/katen/customizer-7.dat',
				'import_preview_image_url'   => 'https://themeger.shop/demo-content/katen/screenshots/catalog.png',
				'import_notice'              => esc_attr( '1. Please make sure to backup your website database and files before importing demo content. 2. Successfully importing data into WordPress is not something we can guarantee for all users. There are a lot of variables that come into play, over which we have no control. For example, one of the main issues is bad shared hosting servers. If you having some issue with that, please check the importing issues here: https://ocdi.com/import-issues', 'katen' ),
				'preview_url'                => 'https://themeger.shop/wordpress/katen/catalog',
			),
	);
}
add_filter( 'pt-ocdi/import_files', 'katen_import_demos' );

/* ================================================== */
/*    |         Register Nav Menus               |    */
/* ================================================== */
add_action( 'after_setup_theme', 'katen_theme_menu_setup' );
if ( ! function_exists( 'katen_theme_menu_setup' ) ):
function katen_theme_menu_setup() {  
		register_nav_menu('primary-menu', esc_attr( 'Primary Menu', 'katen' ));
} endif;

/**
 * Add .js script if "Enable threaded comments" is activated in Admin
 * Codex: {@link https://developer.wordpress.org/reference/functions/wp_enqueue_script/}
 */
function katen_enqueue_comments_reply() {

	if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
			// Load comment-reply.js (into footer)
			wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
	}
}
add_action(  'wp_enqueue_scripts', 'katen_enqueue_comments_reply' );

/* ================================================== */
/*    |           Register Sidebar               |    */
/* ================================================== */
function katen_widgets_init() {
	global $primary_color;
	global $secondary_color;
	$primary_color = esc_attr(get_theme_mod('primary_color', '#FE4F70'));
	$secondary_color = esc_attr(get_theme_mod('secondary_color', '#FFA387'));

	register_sidebar( array(
		'name'          => esc_attr('Right Sidebar', 'katen'),
		'id'            => 'primary-sidebar',
		'description'   => esc_attr('Main Right Sidebar', 'katen'),
		'before_widget' => '<div id="%1$s" class="widget rounded %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header text-center"><h3 class="widget-title">',
		'after_title'   => '</h3>
		<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="'.$primary_color.'"></stop>
								<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
						</linearGradient>
						</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
		</svg></div>',
	) );

	register_sidebar( array(
		'name'          => esc_attr('WooCommerce Sidebar', 'katen'),
		'id'            => 'woocommerce-sidebar',
		'description'   => esc_attr('Woocommerce Right Sidebar', 'katen'),
		'before_widget' => '<div id="%1$s" class="widget rounded %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header text-center"><h3 class="widget-title">',
		'after_title'   => '</h3>
		<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
						<linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="'.$primary_color.'"></stop>
								<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
						</linearGradient>
						</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient2)" stroke-width="2" fill="none"></path>
		</svg></div>',
	) );

	register_sidebar( array(
		'name'          => esc_attr('Footer Instagram Widget Area', 'katen'),
		'id'            => 'footer-widgets',
		'description'   => esc_attr('Footer Instagram Widget Area', 'katen'),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header text-center"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_attr('Footer Widget Column One', 'katen'),
		'id'            => 'footer-widget-1',
		'description'   => esc_attr('Footer Widget One Area', 'katen'),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3>
		<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="'.$primary_color.'"></stop>
								<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
						</linearGradient>
						</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
		</svg></div>',
	) );

	register_sidebar( array(
		'name'          => esc_attr('Footer Widget Column Two', 'katen'),
		'id'            => 'footer-widget-2',
		'description'   => esc_attr('Footer Widget Two Area', 'katen'),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3>
		<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="'.$primary_color.'"></stop>
								<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
						</linearGradient>
						</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
		</svg></div>',
	) );

	register_sidebar( array(
		'name'          => esc_attr('Footer Widget Column Three', 'katen'),
		'id'            => 'footer-widget-3',
		'description'   => esc_attr('Footer Widget Three Area', 'katen'),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3>
		<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="'.$primary_color.'"></stop>
								<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
						</linearGradient>
						</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
		</svg></div>',
	) );
}
add_action( 'widgets_init', 'katen_widgets_init' );

/* ================================================== */
/*    |         Post Formats Icon Setup          |    */
/* ================================================== */
if ( ! function_exists('katen_theme_post_format_icons') ) {
	// Post Format Icons
	function katen_theme_post_format_icons( )  {
	
		if ( has_post_format('video')) {
			echo '<span class="post-format">
				<i class="icon-camrecorder"></i>
			</span>';
		} else if ( has_post_format('audio') ) {
			echo '<span class="post-format">
				<i class="icon-earphones"></i>
			</span>';
		} else if ( has_post_format('gallery') ) {
			echo '<span class="post-format">
				<i class="icon-picture"></i>
			</span>';
		};
	
	}
	add_action( 'after_setup_theme', 'katen_theme_post_format_icons' );
}

if ( ! function_exists('katen_theme_post_format_icons_sm') ) {
	// Post Format Icons
	function katen_theme_post_format_icons_sm( )  {
	
		if ( has_post_format('video')) {
			echo '<span class="post-format-sm">
				<i class="icon-camrecorder"></i>
			</span>';
		} else if ( has_post_format('audio') ) {
			echo '<span class="post-format-sm">
				<i class="icon-earphones"></i>
			</span>';
		} else if ( has_post_format('gallery') ) {
			echo '<span class="post-format-sm">
				<i class="icon-picture"></i>
			</span>';
		};
	
	}
	add_action( 'after_setup_theme', 'katen_theme_post_format_icons_sm' );
}

/* ================================================== */
/*    |       Styling Default Search Form        |    */
/* ================================================== */
function katen_theme_search_form( $form ) { 
	$form = '<form class="searchform" role="search" method="get" id="search-form" action="' . esc_url(home_url( '/' )) . '" >
 <label class="screen-reader-text" for="s"></label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'. esc_attr__('Search ...', 'katen') .'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search', 'katen') .'" />
	</form>';
	return $form;
}

add_filter( 'get_search_form', 'katen_theme_search_form' );

/* ================================================== */
/*    |               Menu Walkers               |    */
/* ================================================== */
class katen_Nav_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"submenu\">\n";
	}
}

/* ================================================== */
/*    |                Dark Mode                 |    */
/* ================================================== */
function katen_theme_dark_mode($classes) {
	if(true == get_theme_mod('dark_mode', false)){
		$classes[] = 'dark';
	}
		return $classes;
}

add_filter('body_class', 'katen_theme_dark_mode');

/* ================================================== */
/*    |         Theme Features                   |    */
/* ================================================== */
if ( ! function_exists('katen_theme_features') ) {
	// Register Theme Features
	function katen_theme_features()  {

		// Add theme support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		// Add theme support for Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );
		// Add theme support for Title Tag
		add_theme_support( "title-tag" );
		/* Post Thumbnail Sizes */
		add_image_size( 'katen-thumb-grid', 550, 367, true );
		add_image_size( 'katen-thumb-grid-alt', 580, 485, true );
		add_image_size( 'katen-thumb-wide', 875, 440, true );
		add_image_size( 'katen-thumb-classic', 750, 400, true );
		add_image_size( 'katen-thumb-list', 330, 250, true );
		add_image_size( 'katen-featured-post', 750, 540, true );
		add_image_size( 'katen-thumb-list-sm', 110, 80, true );
		add_image_size( 'katen-thumb-featured-sm', 325, 233, true );
		add_image_size( 'katen-thumb-circle', 60, 60, true );
		add_image_size( 'katen-thumb-featured-carousel', 360, 360, true );
		add_image_size( 'katen-featured-slide', 1140, 540, true );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);
		/** post formats */
		$post_formats = array('gallery','video','audio');
		add_theme_support( 'post-formats', $post_formats);
		// Add theme support for Gutenberg
		add_theme_support( 'wp-block-styles' );
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		remove_theme_support( 'widgets-block-editor' );
		
		// Enqueue for Custom Editor Styles
		add_editor_style( 'css/style-editor.css' );
		// Enqueue fonts in the editor.
		add_editor_style( katen_theme_primary_fonts_url() );
		add_editor_style( katen_theme_secondary_fonts_url() );
		// Add theme support for WooCommerce
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
	add_action( 'after_setup_theme', 'katen_theme_features' );
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

// Set content width value based on the theme's design
if ( ! isset( $content_width ) )
	$content_width = 1140;

/* ================================================== */
/*    |             Post Paginations             |    */
/* ================================================== */
function katen_theme_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'type'  => 'array',
			'prev_next' => true,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;'
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<nav><ul class="pagination justify-content-center">';
		foreach ( $page_format as $page ) {
			echo "<li class='page-item'>$page</li>";
		}
			echo '</ul></nav>';
	}
}

function katen_infinite_pagination() {
	global $post_query;
	$big = 12345678;
	$page_format = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $post_query->max_num_pages,
			'type'  => 'array',
			'prev_next' => false,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<ul class="pagination justify-content-center d-none">';
		foreach ( $page_format as $page ) {
			echo "<li class='list-inline-item'>$page</li>";
		}
			echo '</ul>';
		echo '<div class="load-more text-center">
			<a href="javascript:" class="btn btn-simple"><i class="fas fa-spinner"></i>'. esc_attr__("Load more", "katen") .'</a>
		</div>';
	}
}

function katen_static_pagination() {
	global $post_query;
	if ( is_front_page() || is_home()){
		$current_page = max( 1, get_query_var('page') );
	} else {
		$current_page = max( 1, get_query_var('paged') );
	}

	$big = 12345678;
	$page_format = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current_page,
		'total' => $post_query->max_num_pages,
		'type'  => 'array',
		'prev_next' => true,
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'end_size'           => 1,
		'mid_size'           => 1,
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<nav><ul class="pagination justify-content-center">';
		foreach ( $page_format as $page ) {
		echo "<li class='page-item'>$page</li>";
		}
		echo '</ul></nav>';
	}
}

/* ================================================== */
/*    |                Post Views                |    */
/* ================================================== */
function katen_set_post_views($postID) {
	$count_key = 'katen_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/* ================================================== */
/*    |        Elementor Widget Category         |    */
/* ================================================== */
function katen_elementor_widget_categories( $elements_manager ) {

	$categories = [];
	$categories['katen-elements'] =
			[
				'title' => esc_attr( 'Katen Theme Elements', 'katen' ),
					'icon'  => 'fa fa-plug'
			];

	$old_categories = $elements_manager->get_categories();
	$categories = array_merge($categories, $old_categories);

	$set_categories = function ( $categories ) {
			$this->categories = $categories;
	};

	$set_categories->call( $elements_manager, $categories );

}

add_action( 'elementor/elements/categories_registered', 'katen_elementor_widget_categories') ;

/**
 * Filter the categories archive widget to add a span around post count
 */
function katen_cat_count_span( $links ) {
	$links = str_replace( '</a> (', '</a><span class="widget-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return $links;
}
add_filter( 'wp_list_categories', 'katen_cat_count_span' );

/**
 * Filter the archives widget to add a span around post count
 */
function katen_archive_count_span( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a><span class="widget-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return $links;
}
add_filter( 'get_archives_link', 'katen_archive_count_span' );

/* ================================================== */
/*    |              Localization                |    */
/* ================================================== */
function katendomain_setup() {
	load_theme_textdomain( 'katen', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'katendomain_setup' );
/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function() {
	 while ( @ob_end_flush() );
} );
