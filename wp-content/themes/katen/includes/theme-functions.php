<?php
/* ================================================== */
/*    |              Logo Default                |    */
/* ================================================== */
if(!function_exists('katen_logo_default')){
    function katen_logo_default(){

    	$logo_default = get_theme_mod('logo_default');
		$logo_light = get_theme_mod('logo_light');
		$logo_width = get_theme_mod('logo_width');
		$logo_height = get_theme_mod('logo_height');
		$header_color = get_theme_mod('header_color', 'on');

		if ( $logo_default || $logo_light ){
			if ( $logo_default ) {
				echo '<a href="'; echo esc_url(home_url('/')); 
				echo'" class="navbar-brand logo-dark"><img src="'; 
				echo esc_url( $logo_default ); 
				echo '" alt="'. get_bloginfo( 'name' ) .'" width="' . esc_html( $logo_width ) . '" height="' . esc_html( $logo_height ) . '" /></a>';
			} 
			if ( $logo_light ) {
				echo '<a href="'; echo esc_url(home_url('/')); 
				echo'" class="navbar-brand logo-light"><img src="'; 
				echo esc_url( $logo_light ); 
				echo '" alt="'. get_bloginfo( 'name' ) .'" width="' . esc_html( $logo_width ) . '" height="' . esc_html( $logo_height ) . '" /></a>';
			}
		} else {
			echo '<a href="'; echo esc_url(home_url('/')); 
			echo '" class="text-logo mb-0">'; 
			echo get_bloginfo( 'name' );
			echo '<span class="dot">.</span>'; 
			echo '</a>'; 
		}
    }
}
/* ================================================== */
/*    |              Header Default              |    */
/* ================================================== */
if(!function_exists('katen_theme_header_default')){
  function katen_theme_header_default($menu_location, $menu_class){ ?>
	<!-- header -->
	<header class="header-default <?php if ( '1' == get_theme_mod( 'header_color', '2' ) || true == get_theme_mod('dark_mode', false) ) { echo 'dark'; } if ( false == get_theme_mod( 'sticky_header', true ) ) { echo 'non-sticky'; } ?>">
		<nav class="navbar navbar-expand-lg">
			<div class="container-xl">
				<?php katen_logo_default(); ?>

				<div class="collapse navbar-collapse">
					<?php
						if ( has_nav_menu( ''. $menu_location .'' ) ) {
							wp_nav_menu(array(
								'theme_location' => ''. $menu_location .'',
								'container' => false,
								'menu_class' => '',
								'fallback_cb' => '__return_false',
								'items_wrap' => '<ul id="%1$s" class="navbar-nav mr-auto %2$s">%3$s</ul>',
								'depth' => 3,
								'walker' => new bootstrap_5_wp_nav_menu_walker()
							));
						} else {
							if (  is_user_logged_in() ) {
								echo '<ul id="%1$s" class="navbar-nav mr-auto %2$s"><li class="nav-item"><a href="'. esc_url(admin_url( 'nav-menus.php' )) .'" class="nav-link">'; esc_attr_e('Add a menu', 'katen'); echo '</a></li></ul>';
							}
						}
					?>
				</div>

				<!-- header right section -->
				<div class="header-right">
					<?php 
						if ( true == get_theme_mod( 'social_header', false ) ) {
							katen_social();
						} 
					?>
					<!-- header buttons -->
					<div class="header-buttons">
						<?php if ( true == get_theme_mod( 'search_button', true ) ) : ?>
							<button class="search icon-button">
								<i class="icon-magnifier"></i>
							</button>
						<?php endif; ?>
						<button class="burger-menu icon-button <?php if ( '2' == get_theme_mod( 'menu_button' ) ) { echo 'd-lg-none d-xl-none d-xl-inline-flex'; } elseif ('1' == get_theme_mod( 'menu_button')) {} else { echo 'd-lg-none d-xl-none d-xl-inline-flex'; } ?>">
							<span class="burger-icon"></span>
						</button>
					</div>
				</div>
			</div>
		</nav>
	</header>
<?php } }
/* ================================================== */
/*    |             Header Personal              |    */
/* ================================================== */
if(!function_exists('katen_theme_header_personal')){
  function katen_theme_header_personal($menu_location, $menu_class){ ?>
	<!-- header -->
	<header class="header-personal <?php if ( '1' == get_theme_mod( 'header_color', '2' ) || true == get_theme_mod('dark_mode', false) ) { echo 'dark'; } if ( false == get_theme_mod( 'sticky_header', true ) ) { echo 'non-sticky'; } ?>">
        <div class="container-xl header-top">
			<div class="row align-items-center">

				<div class="col-4 d-none d-md-block d-lg-block">
					<!-- social icons -->
					<?php 
						if ( true == get_theme_mod( 'social_header', true ) ) {
							katen_social('');
						} 
					?>
				</div>

				<div class="col-md-4 col-sm-12 col-xs-12 text-center">
				<!-- site logo -->
					<?php katen_logo_default(); ?>
					<?php if ( true == get_theme_mod( 'text_logo', true ) ) : ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="d-block text-logo"><?php echo get_bloginfo( 'name' ); ?><span class="dot"><?php echo esc_attr('.', 'katen'); ?></span></a>
					<?php endif; ?>
					<?php if ( true == get_theme_mod( 'text_slogan', true ) ) : ?>
						<span class="slogan d-block"><?php echo get_bloginfo( 'description' ); ?></span>
					<?php endif; ?>
				</div>

				<div class="col-md-4 col-sm-12 col-xs-12">
					<!-- header buttons -->
					<div class="header-buttons float-md-end mt-4 mt-md-0">
						<?php if ( true == get_theme_mod( 'search_button', true ) ) : ?>
							<button class="search icon-button">
								<i class="icon-magnifier"></i>
							</button>
						<?php endif; ?>
						<button class="burger-menu icon-button ms-2 float-end float-md-none <?php if ( '2' == get_theme_mod( 'menu_button' ) ) { echo 'd-inline-flex d-lg-none'; } ?>">
							<span class="burger-icon"></span>
						</button>
					</div>
				</div>

			</div>
        </div>

		<nav class="navbar navbar-expand-lg">
			<div class="container-xl">
				
				<div class="collapse navbar-collapse justify-content-center centered-nav">
					<?php
						if ( has_nav_menu( ''. $menu_location .'' ) ) {
							wp_nav_menu(array(
								'theme_location' => ''. $menu_location .'',
								'container' => false,
								'menu_class' => '',
								'fallback_cb' => '__return_false',
								'items_wrap' => '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
								'depth' => 3,
								'walker' => new bootstrap_5_wp_nav_menu_walker()
							));
						} else {
							if ( is_user_logged_in() ) {
								echo '<ul id="%1$s" class="navbar-nav %2$s"><li class="nav-item"><a href="'. esc_url(admin_url( 'nav-menus.php' )) .'" class="nav-link">'; esc_attr_e('Add a menu', 'katen'); echo '</a></li></ul>';
							}
						}
					?>
				</div>

			</div>
		</nav>
	</header>
<?php } }
/* ================================================== */
/*    |             Header Classic               |    */
/* ================================================== */
if(!function_exists('katen_theme_header_classic')){
  function katen_theme_header_classic($menu_location, $menu_class){ ?>
	<!-- header -->
	<header class="header-classic <?php if ( '1' == get_theme_mod( 'header_color', '2' ) || true == get_theme_mod('dark_mode', false) ) { echo 'dark'; } if ( false == get_theme_mod( 'sticky_header', true ) ) { echo 'non-sticky'; } ?>">

			<div class="container-xl">
				<!-- header top -->
				<div class="header-top">
					<div class="row align-items-center">

						<div class="col-md-4 col-xs-12">
							<!-- site logo -->
							<?php katen_logo_default(); ?>
						</div>

						<div class="col-md-8 d-none d-md-block">
							<?php 
								if ( true == get_theme_mod( 'social_header', true ) ) {
									katen_social('float-end');
								} 
							?>
						</div>

					</div>
				</div>
			</div>

			<nav class="navbar navbar-expand-lg">
				<!-- header bottom -->
				<div class="header-bottom  w-100">
					
					<div class="container-xl">
						<div class="d-flex align-items-center">
							<div class="collapse navbar-collapse flex-grow-1">
								<?php
									if ( has_nav_menu( ''. $menu_location .'' ) ) {
										wp_nav_menu(array(
											'theme_location' => ''. $menu_location .'',
											'container' => false,
											'menu_class' => '',
											'fallback_cb' => '__return_false',
											'items_wrap' => '<ul id="%1$s" class="navbar-nav mr-auto %2$s">%3$s</ul>',
											'depth' => 3,
											'walker' => new bootstrap_5_wp_nav_menu_walker()
										));
									} else {
										if ( is_user_logged_in() ) {
											echo '<ul id="%1$s" class="navbar-nav mr-auto %2$s"><li class="nav-item"><a href="'. esc_url(admin_url( 'nav-menus.php' )) .'" class="nav-link">'; esc_attr_e('Add a menu', 'katen'); echo '</a></li></ul>';
										}
									}
								?>
							</div>

							<!-- header buttons -->
							<div class="header-buttons">
								<?php if ( true == get_theme_mod( 'search_button', true ) ) : ?>
									<button class="search icon-button">
										<i class="icon-magnifier"></i>
									</button>
								<?php endif; ?>
								<button class="burger-menu icon-button ms-2 float-end float-lg-none <?php if ( '2' == get_theme_mod( 'menu_button' ) ) { echo 'd-inline-flex d-lg-none'; } ?>">
									<span class="burger-icon"></span>
								</button>
							</div>
						</div>
					</div>

				</div>
			</nav>

	</header>
<?php } }
/* ================================================== */
/*    |             Header Minimal               |    */
/* ================================================== */
if(!function_exists('katen_theme_header_minimal')){
  function katen_theme_header_minimal($menu_location, $menu_class){ ?>
	<!-- header -->
	<header class="header-minimal <?php if ( '1' == get_theme_mod( 'header_color', '2' ) || true == get_theme_mod('dark_mode', false) ) { echo 'dark'; } ?>">
		<div class="container-xl">
            
            <div class="row align-items-center">

                <div class="col-4">
                    <button class="burger-menu icon-button <?php if ( '2' == get_theme_mod( 'menu_button' ) ) { echo 'd-inline-flex d-lg-none'; } ?>">
                        <span class="burger-icon"></span>
                    </button>
                </div>

                <div class="col-4 text-center">
                    <!-- site logo -->
                    <?php katen_logo_default(); ?>
                </div>

                <div class="col-4">
					<?php if ( true == get_theme_mod( 'search_button', true ) ) : ?>
						<button class="search icon-button float-end">
							<i class="icon-magnifier"></i>
						</button>
					<?php endif; ?>
                </div>

            </div>
			
		</div>
	</header>
<?php } }
/* ================================================== */
/*    |       Single Post WP Link Pages          |    */
/* ================================================== */
if(!function_exists('katen_theme_link_pages')){
  function katen_theme_link_pages(){

	/**
	 * Add prev and next links to a numbered page link list
	 */
	add_filter('wp_link_pages_args', 'wp_link_pages_args_prevnext_add');

	function wp_link_pages_args_prevnext_add($args)
	{
		global $page, $numpages, $more, $pagenow;

		if ($args['next_or_number'] !== 'next_and_number') 
			return $args; # exit early

		$args['next_or_number'] = 'number'; # keep numbering for the main part
		if (!$more)
			return $args; # exit early

		if ($page - 1) # there is a previous page
			$args['before'] .= _wp_link_page($page-1)
				. $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'
			;

		if ($page < $numpages) # there is a next page
			$args['after'] = _wp_link_page($page+1)
				. $args['link_before'] . ' ' . $args['nextpagelink'] . $args['link_after'] . '</a>'
				. $args['after']
			;

		return $args;
	}

		$args = array (
			'before'           => '<ul class="page-links">',
			'after'            => '</ul>',
			'link_before'      => '<li class="page-link">',
			'link_after'       => '</li>',
			'aria_current'     => 'page',
			'next_or_number'   => 'next_and_number',
			'separator'        => '',
			'nextpagelink'     => '&raquo;',
			'previouspagelink' => '&laquo;',
			'pagelink'         => '%',
			'echo'             => 1,
		);
		
		wp_link_pages( $args );

    } 
}
/* ================================================== */
/*    |           Single Post Gallery            |    */
/* ================================================== */
if(!function_exists('katen_theme_post_gallery')){
	function katen_theme_post_gallery($file_list_meta_key, $img_size = 'full'){
	  
		  // Get the list of files
		  $files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );
  
		  echo '<div class="post-gallery">';
		  // Loop through them and output an image
		  foreach ( (array) $files as $attachment_id => $attachment_url ) {
			  echo '<div class="item">';
			  echo wp_get_attachment_image( $attachment_id, $img_size );
			  echo '</div>';
		  }
		  echo '</div>';
  
	} 
}
/* ================================================== */
/*    |            Prev & Next Posts             |    */
/* ================================================== */
if(!function_exists('katen_theme_nextprev_posts')){
	function katen_theme_nextprev_posts(){ ?>
	  
	<div class="row nextprev-post-wrapper">
		<div class="col-md-6 col-12">
			<?php
			$prev_post = get_previous_post();
			if ( ! empty( $prev_post ) ): ?>
				<div class="nextprev-post prev">
					<span class="nextprev-text"><?php esc_attr_e('Previous Post', 'katen'); ?></span>
					<h5 class="post-title"><a href="<?php echo get_permalink( $prev_post->ID ); ?>">
						<?php echo apply_filters( 'the_title', $prev_post->post_title ); ?>
					</a></h5>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-md-6 col-12">
			<?php
			$next_post = get_next_post();
			if ( ! empty( $next_post ) ): ?>
				<div class="nextprev-post next">
					<span class="nextprev-text"><?php esc_attr_e('Next Post', 'katen'); ?></span>
					<h5 class="post-title"><a href="<?php echo get_permalink( $next_post->ID ); ?>">
						<?php echo apply_filters( 'the_title', $next_post->post_title ); ?>
					</a></h5>
				</div>
			<?php endif; ?>
		</div>
	</div>
  
	<?php } 
} 
/* ================================================== */
/*    |              Social Icons                |    */
/* ================================================== */
if(!function_exists('katen_social')) {
    function katen_social($additional_class = null, $floating = null){ 
	    $default_icons = array(
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
	    );
	    $icons = get_theme_mod( 'social_icons', $default_icons );
	?>

		<ul class="social-icons list-unstyled list-inline mb-0 <?php echo esc_attr( $additional_class ); ?>">
		    <?php foreach( $icons as $icon ) : ?>
		        <li class="list-inline-item">
		            <a href="<?php echo esc_url($icon['social_url']); ?>" target="_blank">
		                <i class="fa-brands fa-<?php echo esc_attr($icon['icon_name']); ?>"></i>
		            </a>
		        </li>
		    <?php endforeach; ?>
		</ul>

<?php } }

/* ================================================== */
/*    |              Author Links                |    */
/* ================================================== */

add_filter( 'user_contactmethods', 'katen_user_social_profiles' );

if ( !function_exists( 'katen_user_social_profiles' ) ) {
	function katen_user_social_profiles( $contactmethods = null ) {

        $social = katen_get_user_social();

		foreach ( $social as $soc_id => $soc_name ) {
			if ( $soc_id ) {
				$contactmethods[$soc_id] = $soc_name;
			}
		}
		return $contactmethods;
	}
}


/* Get array of social options  */

if ( !function_exists( 'katen_get_user_social' ) ) {
	function katen_get_user_social() {

		$social = array(
			'apple' => 'Apple',
			'behance' => 'Behance',
			'delicious' => 'Delicious',
			'deviantart' => 'DeviantArt',
			'digg' => 'Digg',
			'dribbble' => 'Dribbble',
			'facebook' => 'Facebook',
			'flickr' => 'Flickr',
			'github' => 'Github',
			'google' => 'GooglePlus',
			'instagram' => 'Instagram',
			'linkedin' => 'Linkedin',
			'pinterest' => 'Pinterest',
			'reddit' => 'Reddit',
			'rss' => 'Rss',
			'skype' => 'Skype',
			'stumbleupon' => 'StumbleUpon',
			'soundcloud' => 'SoundCloud',
			'spotify' => 'Spotify',
			'tumblr' => 'Tumblr',
			'twitter' => 'Twitter',
			'vimeo' => 'Vimeo',
			'vine' => 'Vine',
			'wordpress' => 'WordPress',
			'xing' => 'Xing' ,
			'yahoo' => 'Yahoo',
			'youtube' => 'Youtube'
		);


        $social = apply_filters( 'katen_modify_user_social', $social );
        
		return $social;
	}
}

if ( !function_exists( 'katen_get_author_links' ) ) {
	function katen_get_author_links( $author_id = null ) {

		$output = '';

		?>

		<ul class="social-icons list-unstyled list-inline mb-0">

			<?php

			if ( $url = get_the_author_meta( 'url', $author_id ) ) {
				$output .= '<li class="list-inline-item"><a href="'.esc_url( $url ).'" target="_blank" rel="noopener" class="fa fa-link"></a></li>';
			}

			$social = katen_get_user_social();

			if ( !empty( $social ) ) {
				foreach ( $social as $id => $name ) {
					if ( $social_url = get_the_author_meta( $id,  $author_id ) ) {

						if ($id == 'twitter') {
							$social_url = (strpos($social_url, 'http') === false) ? 'https://twitter.com/' . $social_url : $social_url;
						}

						$output .=  '<li class="list-inline-item"><a href="'.esc_url( $social_url ).'" target="_blank" rel="noopener" class="fa-brands fa-'.$id.'"></a></li>';
					}
				}
			}

			return wp_kses_post( $output );

			?>
		</ul>
		
		<?php
	}
}

/* ================================================== */
/*    |         Single Post Author Bio           |    */
/* ================================================== */
if(!function_exists('katen_theme_author_bio')){
  function katen_theme_author_bio(){
    
        global $post;

        // Get Author Data
        $author             = get_the_author();
        $author_description = get_the_author_meta( 'description' );
        $author_url         = get_author_posts_url( get_the_author_meta( 'ID' ) );
        $author_avatar      = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'author_bio_avatar_size', 300 ) );

		$allowed_html = [
			'a'      => [
				'href'  => [],
				'title' => [],
			],
			'img'    => [
				'alt' => [],
				'src' => [],
				'srcset' => [],
				'class' => [],
				'height' => [],
				'width' => [],
				'loading' => [],
			],
		];
		
        // Only display if author has a description

        if ( $author_description ) : ?>

			<div class="about-author padding-30 rounded">
				<div class="thumb">
					<a href="<?php echo esc_url( $author_url ); ?>">
						<?php echo wp_kses( $author_avatar, $allowed_html ); ?>
					</a>
				</div>
				<div class="details">
					<h4 class="name"><a href="<?php echo esc_url( $author_url ); ?>"><?php printf( esc_html__( '%s', 'katen' ), esc_html( $author ) ); ?></a></h4>
					<p><?php echo wp_kses_post( $author_description ); ?></p>
					<?php echo katen_get_author_links(); ?>
				</div>
			</div>
		<?php endif; ?>
<?php } }
/* ================================================== */
/*    |             Footer Default               |    */
/* ================================================== */
if(!function_exists('katen_theme_footer_default')){
  function katen_theme_footer_default(){ ?>
	<!-- footer -->
	<footer class="footer">
		<div class="container-xl">
			<div class="footer-inner">
				<div class="row d-flex align-items-center gy-4">
					<!-- copyright text -->
					<div class="col-md-4">
						<span class="copyright">
							<?php
								$copyright = get_theme_mod('copyright');
								if( $copyright ) {
									echo esc_attr( $copyright );
								} else {
									echo esc_attr__('© 2023 Katen. Theme by ThemeGer.','katen');
								}
							?>
						</span>
					</div>

					<!-- social icons -->
					<div class="col-md-4 text-center">
						<?php 
							if ( true == get_theme_mod( 'footer_social', false ) ) {
								katen_social();
							}
						?>
					</div>

					<!-- go to top button -->
					<div class="col-md-4">
						<?php  if( true == get_theme_mod('footer_backtop', true) ) : ?>
							<a href="#" id="return-to-top" class="float-md-end"><i class="icon-arrow-up"></i><?php echo esc_attr__('Back to Top','katen'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
<?php } } 
/* ================================================== */
/*    |             Footer Classic               |    */
/* ================================================== */
if(!function_exists('katen_theme_footer_classic')){
	function katen_theme_footer_classic(){ ?>
	  <!-- footer -->
	<footer class="footer">
		<?php if ( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) ) : ?>
			<div class="container-xl mb-5">
				<div class="row gx-5">
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer-widget-1' ) ) :
							dynamic_sidebar( 'footer-widget-1' );
						endif; ?>
					</div>
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer-widget-2' ) ) :
							dynamic_sidebar( 'footer-widget-2' );
						endif; ?>
					</div>
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer-widget-3' ) ) :
							dynamic_sidebar( 'footer-widget-3' );
						endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="container-xl">
			<div class="footer-inner">
				<div class="row d-flex align-items-center gy-4">
					<!-- copyright text -->
					<div class="col-md-4">
						<span class="copyright">
							<?php
								$copyright = get_theme_mod('copyright');
								if( $copyright ) {
									echo esc_attr( $copyright );
								} else {
									echo esc_attr__('© 2023 Katen. Theme by ThemeGer.','katen');
								}
							?>
						</span>
					</div>

					<!-- social icons -->
					<div class="col-md-4 text-center">
						<?php 
							if ( true == get_theme_mod( 'footer_social', false ) ) {
								katen_social();
							}
						?>
					</div>

					<!-- go to top button -->
					<div class="col-md-4">
						<?php  if( true == get_theme_mod('footer_backtop', true) ) : ?>
							<a href="#" id="return-to-top" class="float-md-end"><i class="icon-arrow-up"></i><?php echo esc_attr__('Back to Top','katen'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
<?php } } ?>