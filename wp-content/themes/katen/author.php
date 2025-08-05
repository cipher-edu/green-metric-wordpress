<?php 

get_header(); 

global $post;

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

?>

<?php if( get_theme_mod('author_page_bio_box', true) == true && get_the_author_meta( 'description' ) ) : ?>
<div class="container-xl">
	<div class="author-page about-author padding-30 rounded">
		<div class="thumb">
			<a href="<?php echo esc_url( $author_url ); ?>">
				<?php echo wp_kses( $author_avatar, $allowed_html ); ?>
			</a>
		</div>
		<div class="details">
			<h1 class="name mt-0 mb-2"><?php printf( esc_html__( '%s', 'katen' ), esc_html( $author ) ); ?></h1>
			<p><?php echo wp_kses_post( $author_description ); ?></p>
			<?php echo katen_get_author_links(); ?>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- section main content -->
<section class="main-content">

	<div class="container-xl post-container">

	<?php
	
		echo '<div class="row gy-4">';

			echo '<div class="col-lg-'; if( get_theme_mod('blog_sidebar', true) == true && is_active_sidebar( 'primary-sidebar' ) ) {echo '8';} else {echo '12';} echo '">';

				if ( '1' == get_theme_mod( 'author_layout' ) ) {
					get_template_part( 'template-parts/content-classic' );
				} elseif ( '2' == get_theme_mod( 'author_layout' ) ) {
					get_template_part( 'template-parts/content-grid' );
				} elseif ( '3' == get_theme_mod( 'author_layout' ) ) {
					get_template_part( 'template-parts/content-list' );
				} elseif ( '4' == get_theme_mod( 'author_layout' ) ) {
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
