<?php
/* Template Name: Full Width Post */
/* Template Post Type: post */
get_header(); 
?>

<?php

	while ( have_posts() ) : the_post();

	// variables
	$blog_meta           = get_theme_mod('blog_meta', true);
	$blog_date           = get_theme_mod('blog_date', true);
	$blog_author         = get_theme_mod('blog_author', true);
	$blog_avatar         = get_theme_mod('blog_avatar', true);
	$blog_category       = get_theme_mod('blog_category', true);
	$blog_comments_count = get_theme_mod('blog_comments_count', true);
	$blog_except         = get_theme_mod('except');
	$blog_single_share   = get_theme_mod('blog_single_share', true);
	$blog_single_tags    = get_theme_mod('blog_single_tags', true);

	global $blog_meta;

	$featured_img_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
?>

<!-- cover header -->
<section class="single-cover data-bg-image" data-bg-image="<?php echo esc_url( $featured_img_url ); ?>">

<div class="container-xl">

	<div class="cover-content post">
		<?php if( function_exists('bcn_display_list') ) : ?>
		<nav class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<?php bcn_display_list();?>
			</ol>
		</nav>
		<?php endif; ?>

		<!-- post header -->
		<div class="post-header">
			<h1 class="title mt-0 mb-3"><?php the_title(); ?></h1>
			<?php if ( true == $blog_meta ) : ?>
				<ul class="meta list-inline mb-0">
					<?php if ( true == $blog_author ) : ?>
						<li class="list-inline-item">
							<?php
								if ( true == $blog_avatar ) {
									echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', $args = array( 'scheme' => 'https', 'class' => 'author' ) ); 
								}
							?>
							<?php the_author_posts_link(); ?>
						</li>
					<?php endif;

					if ( true == $blog_category ) :

					?>
						<li class="list-inline-item"><?php echo the_category( ', ' ); ?></li>

					<?php endif;

					if ( true == $blog_date ) : ?>
						<li class="list-inline-item"><?php echo get_the_date(); ?></li>
					<?php endif;

					if ( true == $blog_comments_count ) : ?>
						<li class="list-inline-item"><i class="icon-bubble"></i> (<?php echo get_comments_number(); ?>)</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>

</div>

</section>

<!-- section main content -->
<section class="main-content mt-6">

	<div class="container-xl post-container">

		<div class="row gy-4">

			<div class="col-lg-<?php if( get_theme_mod('blog_single_sidebar', true) == true ) { echo '8'; } else { echo '12'; } ?>">

				<div class="post post-single">

					<!-- blog item -->
					<article id="post-<?php the_ID(); ?>" <?php post_class('is-single post-content clearfix'); ?>>

						<div class="clearfix">
							<?php the_content(); 
								katen_theme_link_pages();
								katen_set_post_views(get_the_ID());
							?>
							<!-- mfunc katen_set_post_views($post_id); --><!-- /mfunc -->
						</div>

						<?php if(has_tag() || function_exists('katen_post_social_share') && true == $blog_single_share) : ?>
							<footer class="clearfix">
								<!-- post bottom section -->
								<div class="post-bottom">
									<div class="row d-flex align-items-center">
										<?php
											if( function_exists('katen_post_social_share') && true == $blog_single_share ) {
												echo '<div class="col-md-6 col-12">';
													katen_post_social_share();
												echo '</div>';
											} else {
												if ( true == $blog_single_tags ) {
													echo '<div class="col-md-12 col-12"><div class="tags">';
														the_tags('', '', '');
													echo '</div></div>';
												}
											}
											if( function_exists('katen_post_social_share') && true == $blog_single_share ) {
												if ( true == $blog_single_tags ) {
													echo '<div class="col-md-6 col-12 text-center text-md-end"><div class="tags">';
														the_tags('', '', '');
													echo '</div></div>';
												}
											} else {}
										?>
									</div>
								</div>
							</footer>
						<?php endif; ?>
					</article>

					<?php

						katen_theme_author_bio();
						if(true == get_theme_mod('blog_nextprev', true)) {
							katen_theme_nextprev_posts();
						}
					
					?>

					<?php
						if(true == get_theme_mod('blog_comment', true)) {	
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif; 
						}
					?>

				</div>

			</div>

			<?php if( get_theme_mod('blog_single_sidebar', true) == true ) { ?>
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div>
			<?php } ?>

		</div>

		<?php
			endwhile; // end of the loop.
		?>

	</div> 
	<!-- end container -->

</section>
<!-- end main content -->

<?php get_footer();
