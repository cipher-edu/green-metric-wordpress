<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php if( true == get_theme_mod('preloader', false) ) : ?>
	<!-- Preloader -->
	<div id="preloader">
		<div class="book">
			<div class="inner">
				<div class="left"></div>
				<div class="middle"></div>
				<div class="right"></div>
			</div>
			<ul>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</div>
<?php endif;

if( true == get_theme_mod('reading_bar', true) ) : ?>
<div class="reading-bar-wrapper">
	<div class="reading-bar"></div>
</div>
<?php endif;

if( true == get_theme_mod('switcher_button', false) ) : ?>
	<div class="switcher-button <?php if( true == get_theme_mod('dark_mode', false) ) { echo 'active'; } ?>">
		<div class="switcher-button-inner-left"></div>
		<div class="switcher-button-inner"></div>
	</div>
<?php endif; ?>

<?php if ( true == get_theme_mod( 'search_button', true ) ) : ?>
<!-- search popup area -->
<div class="search-popup">
	<!-- close button -->
	<button type="button" class="btn-close <?php if( true == get_theme_mod('dark_mode', false) ) { echo 'btn-close-white'; } ?>" aria-label="Close"></button>
	<!-- content -->
	<div class="search-content">
		<div class="text-center">
			<h3 class="mb-4 mt-0"><?php echo esc_attr__('Press ESC to close','katen'); ?></h3>
		</div>
		<!-- form -->
		<form class="d-flex search-form" method="get" action="<?php echo esc_url( home_url() ); ?>/">
			<input class="form-control me-2" placeholder="<?php echo esc_attr__( 'Search and press enter ...', 'katen' ) ?>" type="text" name="s" id="search" value="<?php the_search_query(); ?>" aria-label="Search">
			<button class="btn btn-default btn-lg" type="submit"><i class="icon-magnifier"></i></button>
		</form>
	</div>
</div>
<?php endif; ?>

<!-- canvas menu -->
<div class="canvas-menu d-flex align-items-end flex-column <?php if ( 'left' == get_theme_mod( 'reveal_position' ) ) { echo 'position-left'; } ?>">
	<!-- close button -->
	<button type="button" class="btn-close <?php if( true == get_theme_mod('dark_mode', false) ) { echo 'btn-close-white'; } ?>" aria-label="Close"></button>

	<!-- logo -->
	<div class="logo <?php if ( '1' == get_theme_mod( 'header_color', '2' ) || true == get_theme_mod('dark_mode', false) ) { echo 'dark'; } ?>">
		<?php 
			if ( true == get_theme_mod( 'canvas_logo', true ) ) {
				katen_logo_default(); 
			}
		?>
	</div>

	<!-- menu -->
	<nav>
		<?php
			if ( has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array( 
					'container_class' => '',
					'menu_class' => 'vertical-menu',
					'menu_id' => 'primary-menu',
					'theme_location' => 'primary-menu',
					'depth' => 3,
				) );
			} else {
				if ( is_user_logged_in() ) {
					echo '<ul id="%1$s" class="navbar-nav mr-auto %2$s"><li class="nav-item"><a href="'. esc_url(admin_url( 'nav-menus.php' )) .'" class="nav-link">'; esc_attr_e('Add a menu', 'katen'); echo '</a></li></ul>';
				}
			}
		?>
	</nav>

	<!-- social icons -->
	<?php 
		if ( true == get_theme_mod( 'canvas_social', false ) ) {
			katen_social('mt-auto w-100');
		}
	?>
</div>

<!-- site wrapper -->
<div class="site-wrapper">

	<div class="main-overlay"></div>

	<?php
		if( get_theme_mod('header_layout') == 'header_personal') {
			katen_theme_header_personal('primary-menu', ''); 
		} elseif( get_theme_mod('header_layout') == 'header_classic') {
			katen_theme_header_classic('primary-menu', '');
		} elseif( get_theme_mod('header_layout') == 'header_minimal') {
			katen_theme_header_minimal('primary-menu', '');
		} else {
			katen_theme_header_default('primary-menu', '');
		}
	?>