<?php 
/* Template Name: Page No Sidebar */
get_header(); 

?>

<section class="page-header">
	<div class="container-xl">
		<div class="text-center">
			<h1 class="mt-0 mb-0"><?php the_title(); ?></h1>
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

	<div class="container-xl">

	<?php

		if (have_posts()) : while (have_posts()) : the_post();

			echo '<div class="page-content">';

			the_content();

			echo '</div>';

			katen_theme_link_pages();

		endwhile;

		else :

			echo '<p>';
				esc_attr_e( 'No entry founds.', 'katen' );
			echo '</p>';

		endif;

		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	?>

	</div> 
	<!-- end container -->

</section>
<!-- end main content -->

<?php get_footer();
