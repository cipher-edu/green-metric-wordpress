	<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
		<div class="container-xl">
			<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>
	<?php endif;

		katen_theme_footer_classic();

	?>

</div><!-- end site wrapper -->

<?php wp_footer(); ?>

</body>
</html>