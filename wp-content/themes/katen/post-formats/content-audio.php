<?php
	if( is_single() ) {

	if (get_post_meta( get_the_ID(), 'katen_post_embed', 1)) {

		echo '<div class="videoWrapper">';
			$url = esc_url( get_post_meta( get_the_ID(), 'katen_post_embed', 1 ) ); echo wp_oembed_get( $url );
		echo '</div>';

    } 
	
	the_content();
    
} ?>