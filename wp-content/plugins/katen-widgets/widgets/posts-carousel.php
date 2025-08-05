<?php
 
/**
 * Adds Katen_Posts_Carousel widget.
 */
class Katen_Posts_Carousel extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'katen_posts_carousel', // Base ID
            'Katen Posts Carousel', // Name
            array( 'description' => __( 'Show Posts by Category', 'katen' ), ) // Args
        );
    }
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        if ( $number < 1 ) {
            $number = 3;
        }
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
        $show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : true;
        $show_author = isset( $instance['show_author'] ) ? (bool) $instance['show_author'] : true;
        $cat_name = isset( $instance['cat_name'] ) ? sanitize_text_field( $instance['cat_name'] ) : '';
    
        echo $before_widget;
    
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
    
        echo '<div class="post-carousel-widget">';
    
        $popular_args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $number,
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
        );
    
        if ( $cat_name ) {
            $popular_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'name',
                    'terms'    => $cat_name,
                ),
            );
        }
    
        $popular_query = new WP_Query( $popular_args );
    
        if ( $popular_query->have_posts() ) :
            while ( $popular_query->have_posts() ) :
                $popular_query->the_post();
                ?>
                <div class="post post-carousel">
                    <div class="thumb rounded">
                        <?php if ( $show_cat ) :
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="category-badge position-absolute">' . esc_html( $categories[0]->name ) . '</a>';
                            }
                        endif; ?>
                        <?php if ( has_post_thumbnail() ) :
                            echo '<a href="' . esc_url( get_permalink() ) . '"><div class="inner">' . get_the_post_thumbnail( null, 'katen-thumb-grid' ) . '</div></a>';
                        endif; ?>
                    </div>
                    <h5 class="post-title mb-0 mt-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <ul class="meta list-inline mt-2 mb-0">
                        <?php if ( $show_author ) : ?>
                            <li class="list-inline-item"><?php the_author_posts_link(); ?></li>
                        <?php endif; ?>
                        <?php if ( $show_date ) : ?>
                            <li class="list-inline-item"><?php the_time( 'd F Y' ); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
    
        echo '</div>';
    
        ?>
        <div class="slick-arrows-bot">
            <button type="button" data-role="none" class="carousel-botNav-prev slick-custom-buttons"
                    aria-label="Previous"><i class="icon-arrow-left"></i></button>
            <button type="button" data-role="none" class="carousel-botNav-next slick-custom-buttons"
                    aria-label="Next"><i class="icon-arrow-right"></i></button>
        </div>
        <?php
    
        echo $after_widget;
    }
    
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Category Post', 'katen' );
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
        $show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : true;
        $show_author = isset( $instance['show_author'] ) ? (bool) $instance['show_author'] : true;
        $cat_name = isset( $instance['cat_name'] ) ? $instance['cat_name'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_cat ); ?> id="<?php echo $this->get_field_id( 'show_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_cat' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_cat' ); ?>"><?php _e( 'Display category badge?' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_author ); ?> id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Display author name?' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cat_name' ); ?>"><?php _e( 'Category name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'cat_name' ); ?>" name="<?php echo $this->get_field_name( 'cat_name' ); ?>" type="text" value="<?php echo esc_attr( $cat_name ); ?>" />
        </p>
    <?php
    }    
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = isset( $new_instance['number'] ) ? absint( $new_instance['number'] ) : 3;
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_cat'] = isset( $new_instance['show_cat'] ) ? (bool) $new_instance['show_cat'] : false;
        $instance['show_author'] = isset( $new_instance['show_author'] ) ? (bool) $new_instance['show_author'] : false;
        $instance['cat_name'] = isset( $new_instance['cat_name'] ) ? sanitize_text_field( $new_instance['cat_name'] ) : '';
    
        return $instance;
    }
    
 
} // class Katen_Posts_Carousel
 
?>