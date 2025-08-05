<?php
	if( is_single() ) { 

    if ( has_post_thumbnail() ) {
        echo '<div class="featured-image">';
            the_post_thumbnail('full');
        echo '</div>';
    }

    the_content(); 

    
} ?>