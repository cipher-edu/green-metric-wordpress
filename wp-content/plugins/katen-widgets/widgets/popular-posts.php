<?php
 
/**
 * Adds Katen_Popular_Posts widget.
 */
class Katen_Popular_Posts extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'katen_popular_posts', // Base ID
            'Katen Popular Posts', // Name
            array( 'description' => __( 'Show Popular Posts', 'katen' ), ) // Args
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
    
        echo $before_widget;
    
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
    
        $popular_args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $number,
            'meta_key'            => 'katen_post_views_count',
            'orderby'             => 'meta_value_num',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
        );
    
        $popular_query = new WP_Query( $popular_args );
    
        if ( $popular_query->have_posts() ) :
            while ( $popular_query->have_posts() ) :
                $popular_query->the_post();
                ?>
                <div class="post post-list-sm counter circle">
                    <div class="thumb circle">
                        <?php
                        if ( has_post_thumbnail() ) {
                            echo '<a href="' . get_permalink() . '"><div class="inner">' . get_the_post_thumbnail( null, 'katen-thumb-circle' ) . '</div></a>';
                        }
                        ?>
                    </div>
                    <div class="details clearfix">
                        <h6 class="post-title my-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                        <ul class="meta list-inline mt-1 mb-0">
                            <?php if ( $show_date ) : ?>
                                <li class="list-inline-item"><?php the_time( 'd F Y' ); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
    
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
        // Get the title from the instance or set a default value
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Popular Posts', 'katen' );
    
        // Get the number of posts to show from the instance or set a default value
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
    
        // Get the show_date flag from the instance or set a default value
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label>
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
        $instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number'] = isset( $new_instance['number'] ) ? absint( $new_instance['number'] ) : 0;
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
    
        return $instance;
    }
    
 
} // class Katen_Popular_Posts
 
?>