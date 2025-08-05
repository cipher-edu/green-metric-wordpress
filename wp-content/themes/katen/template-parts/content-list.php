<?php

	$blog_meta = get_theme_mod('blog_meta', true);
	$blog_date = get_theme_mod('blog_date', true);
	$blog_author = get_theme_mod('blog_author', true);
    $blog_avatar = get_theme_mod('blog_avatar', true);
	$blog_category = get_theme_mod('blog_category', true);
    $blog_comments_count = get_theme_mod('blog_comments_count', true);
    $blog_archive_share = get_theme_mod('blog_archive_share', true);
	$blog_except = get_theme_mod('except');

?>
<div class="padding-30 rounded bordered">

    <div class="row">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="col-md-12 col-sm-6 post-list-col">
            <!-- post -->
            <div id="post-<?php the_ID(); ?>" <?php post_class('post post-list clearfix'); ?>>
                    
                <?php if ( has_post_thumbnail() ) {
                    echo '<div class="thumb rounded">';
                    katen_theme_post_format_icons_sm();
                    echo '<div class="inner"><a href="'; the_permalink(); echo '">'; the_post_thumbnail('katen-thumb-list'); echo '</a></div></div>';
                } ?>  

                
                <div class="details clearfix">
                    <?php if ( true == $blog_meta ) : ?>
                        <ul class="meta list-inline mb-3">
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
                            
                            if ( true == $blog_category ) {
                                $categories = get_the_category();
                            
                                if ( ! empty( $categories ) ) {
                                    echo '<li class="list-inline-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
                                } 
                            }

                            if ( true == $blog_date ) : ?>
                                <li class="list-inline-item"><?php echo get_the_date(); ?></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                    <h5 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p class="excerpt mb-0">
                        <?php
                            $content = get_the_content();
                            if($blog_except) {
                                $trimmed_content = wp_trim_words( $content, $blog_except );
                                echo esc_attr($trimmed_content);
                            } else {
                                $trimmed_content_default = wp_trim_words( $content, 30 );
                                echo esc_attr($trimmed_content_default);
                            } 
                        ?>
                    </p>
                    <div class="post-bottom clearfix d-flex align-items-center">
                        <?php 
                            if( function_exists('katen_social_share') && true == $blog_archive_share ) {
                                katen_social_share(); 
                            }
                        ?>
                        <div class="more-button float-end">
                            <a href="<?php the_permalink(); ?>"><span class="icon-options"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endwhile;?>

        <?php wp_reset_postdata(); ?>

        <?php else : ?>

        <p><?php esc_attr_e('Sorry! No result found :(', 'katen' ); ?></p>

        <?php endif; ?>

    </div>

</div>

<?php katen_theme_pagination(); ?>