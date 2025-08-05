<?php get_header(); ?>

<section class="page-header">
	<div class="container-xl">
		<div class="text-center">
			<h1 class="mt-0 mb-2"><?php echo esc_attr('Search result for: ', 'katen'); echo get_search_query(); ?></h1>
			<?php if(function_exists('bcn_display_list')):?>
			<nav class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/" aria-label="breadcrumb">
				<ol class="breadcrumb justify-content-center mb-0">
					<?php bcn_display_list();?>
				</ol>
			</nav>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- section main content -->
<section class="main-content">

	<div class="container-xl post-container">

	<?php

		echo '<div class="row gy-4">';

			echo '<div class="col-lg-'; if( get_theme_mod('blog_sidebar', true) == true && is_active_sidebar( 'primary-sidebar' ) ) { echo '8'; } else { echo '12'; } echo '">';

	?>

		<?php

			// variables
			$blog_meta           = get_theme_mod('blog_meta', true);
			$blog_date           = get_theme_mod('blog_date', true);
			$blog_author         = get_theme_mod('blog_author', true);
			$blog_avatar         = get_theme_mod('blog_avatar', true);
			$blog_category       = get_theme_mod('blog_category', true);
			$blog_comments_count = get_theme_mod('blog_comments_count', true);
			$blog_archive_share  = get_theme_mod('blog_archive_share', true);
			$blog_except         = get_theme_mod('except');

		?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class('post post-classic rounded bordered'); ?>>
			<div class="thumb top-rounded">
				<?php katen_theme_post_format_icons(); ?>
				<a href="<?php the_permalink(); ?>">
					<div class="inner">
						<?php if ( has_post_thumbnail() ) {
							echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail('large'); echo '</a>';
						} ?>
					</div>
				</a>
			</div>
			<div class="details">
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
						
						if ( true == $blog_date ) : ?>
							<li class="list-inline-item"><?php echo get_the_date(); ?></li>
						<?php endif;
						
						if ( true == $blog_category ) {
							$categories = get_the_category();
						
							if ( ! empty( $categories ) ) {
								echo '<li class="list-inline-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
							} 
						}

						if ( true == $blog_comments_count ) : ?>
							<li class="list-inline-item"><i class="icon-bubble"></i> (<?php echo get_comments_number(); ?>)</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
				<h5 class="post-title mb-3 mt-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				<p class="excerpt mb-0"><?php
				$content = get_the_content();
				if($blog_except) {
					$trimmed_content = wp_trim_words( $content, $blog_except );
					echo esc_attr($trimmed_content);
				} else {
					$trimmed_content_default = wp_trim_words( $content, 30 );
					echo esc_attr($trimmed_content_default);
				} ?></p>
			</div>
			<div class="post-bottom clearfix d-flex align-items-center">
				<?php 
					if( function_exists('katen_social_share') && true == $blog_archive_share ) {
						katen_social_share(); 
					}
				?>
				<div class="float-end d-none d-md-block">
					<a href="<?php the_permalink(); ?>" class="more-link"><?php esc_attr_e('Continue reading', 'katen' ); ?><i class="icon-arrow-right"></i></a>
				</div>
				<div class="more-button d-block d-md-none float-end">
					<a href="<?php the_permalink(); ?>"><span class="icon-options"></span></a>
				</div>
			</div>
		</div>

		<?php endwhile;?>

		<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<div class="no-search-result">

			<h3 class="mt-0 mb-4"><?php esc_attr_e('Nothing found', 'katen'); ?></h3>

			<p class="clearfix mb-4"><?php esc_attr_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'katen' ); ?></p>

			<form class="row g-3" role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="col-auto">
					<input class="form-control" type="text" aria-label="Search" name="s" placeholder="<?php esc_attr_e('Search...', 'katen'); ?>" value="<?php echo get_search_query(); ?>" required>
				</div>
				<div class="col-auto">
					<button type="submit" class="btn btn-default ml-1"><?php esc_attr_e('Search', 'katen'); ?></button>
				</div>
			</form>

			</div>

		<?php endif; ?>

		<?php katen_theme_pagination(); ?>

		<?php
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
