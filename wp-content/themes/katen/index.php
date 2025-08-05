<?php get_header(); ?>

<!-- section main content -->
<section class="main-content">

	<div class="container-xl post-container">

	<?php

		echo '<div class="row gy-4">';

			echo '<div class="col-lg-'; if( get_theme_mod('blog_sidebar', true) == true && is_active_sidebar( 'primary-sidebar' ) ) { echo '8'; } else { echo '12'; } echo '">';

				if ( '1' == get_theme_mod( 'index_layout' ) ) {
					get_template_part( 'template-parts/content-classic' );
				} elseif ( '2' == get_theme_mod( 'index_layout' ) ) {
					get_template_part( 'template-parts/content-grid' );
				} elseif ( '3' == get_theme_mod( 'index_layout' ) ) {
					get_template_part( 'template-parts/content-list' );
				} elseif ( '4' == get_theme_mod( 'index_layout' ) ) {
					get_template_part( 'template-parts/content-minimal' );
				} else {
					get_template_part( 'template-parts/content-classic' );
				}

			echo '</div>';

			if( get_theme_mod('blog_sidebar', true) == true && is_active_sidebar( 'primary-sidebar' ) ) {
				echo '<div class="col-lg-4">';
					get_sidebar();
				echo '</div>';

			}

		echo '</div>';

	?>

	</div> 
	<!-- end container -->

</section>
<!-- end main content -->

<?php get_footer();
