<?php get_header(); ?>

<section class="page-header">
	<div class="container-xl">
		<div class="text-center">
			<h1 class="mt-0 mb-0"><?php woocommerce_page_title(); ?></h1>
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

		<div class="row">

			<div class="col-lg-<?php if ( is_active_sidebar( 'woocommerce-sidebar' ) ) { echo '9'; } else { echo '12'; } ?>">


				<div class="page-content">

					<?php woocommerce_content(); ?>

				</div>

			</div>

			<?php
				if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {

					echo '<div class="col-lg-3"><div class="sidebar">';
						dynamic_sidebar( 'woocommerce-sidebar' );
					echo '</div></div>';

				}
			?>

		</div>

	</div>
	<!-- end container -->

</section>
<!-- end main content -->

<?php get_footer();
