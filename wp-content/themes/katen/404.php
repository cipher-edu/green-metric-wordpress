<?php get_header(); ?>

<div class="spacer" data-height="70"></div>

<!-- Section Content -->
<section class="not-found d-flex align-items-center padding-30">

	<!-- container -->
	<div class="container text-center">

		<h1 class="mb-4 mt-0 font-black"><?php esc_attr_e( '404 Not Found', 'katen' ); ?></h1>
		<p class="mb-4"><?php esc_attr_e( 'Oops, the page you are looking for does not exist.', 'katen' ); ?></p>
		<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-default"><i class="fa-sharp fa-solid fa-house" aria-hidden="true"></i> <?php esc_attr_e( 'Return Home', 'katen' ); ?></a>

	</div>
	<!-- end container -->
	
</section>
<!-- End Section Content -->

<div class="spacer" data-height="70"></div>

<?php get_footer();
