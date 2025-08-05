<?php

namespace Katen_Elementor_Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Widget.
 *
 * @since 1.0.0
 */
class Katen_Post_Eight extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'katen-post-eight';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Classic Posts', 'katen' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'katen-elements' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'post', 'blog', 'featured', 'large' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$cat_options = array();

		$args = array(
			'hide_empty' => false,
		);

		$categories = get_categories($args);

		foreach ( $categories as $key => $category ) {
			$cat_options[$category->slug] = $category->name;
		}

		$tag_options = array();

		$tags = get_tags($args);

		foreach ( $tags as $key => $tag ) {
			$tag_options[$tag->slug] = $tag->name;
		}

		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__( 'Post Query', 'katen' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_categories',
			[
				'label' => __( 'Post Categories', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $cat_options,
			]
		);

		$this->add_control(
			'post_tags',
			[
				'label' => __( 'Post Tags', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $tag_options,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Number of Posts', 'katen' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 20,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'ASC'  => esc_html__( 'ASC', 'katen' ),
					'DESC'  => esc_html__( 'DESC', 'katen' ),
				],
				'default' => 'DESC',
			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => esc_html__( 'Order By', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'rand'  => esc_html__( 'Random', 'katen' ),
					'id'  => esc_html__( 'ID', 'katen' ),
					'title'  => esc_html__( 'Title', 'katen' ),
					'name'  => esc_html__( 'Slug', 'katen' ),
					'date'  => esc_html__( 'Date', 'katen' ),
					'modified'  => esc_html__( 'Modified Date', 'katen' ),
					'parent'  => esc_html__( 'Parent ID', 'katen' ),
					'menu_order'  => esc_html__( 'Menu Order', 'katen' ),
					'comment_count'  => esc_html__( 'Comment Count', 'katen' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'ignore_sticky',
			[
				'label' => esc_html__( 'Ignore Sticky Posts', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'1'  => esc_html__( 'Yes', 'katen' ),
					'0'  => esc_html__( 'No', 'katen' ),
				],
				'default' => '1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'options_section',
			[
				'label' => esc_html__( 'Post Options', 'katen' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => esc_html__( 'Category', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => esc_html__( 'Date', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'author',
			[
				'label' => esc_html__( 'Author', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'comment_count',
			[
				'label' => esc_html__( 'Comment Count', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'format_icon',
			[
				'label' => esc_html__( 'Post format icon', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt',
			[
				'label' => esc_html__( 'Excerpt length', 'katen' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 250,
				'step' => 1,
				'default' => 30,
			]
		);

		$this->add_control(
			'social_share',
			[
				'label' => esc_html__( 'Social share', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'katen' ),
				'label_off' => esc_html__( 'Disable', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'continue',
			[
				'label' => esc_html__( 'Continue reading', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'katen' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'none'  => esc_html__( 'None', 'katen' ),
					'load_more'  => esc_html__( 'Load More', 'katen' ),
					'numbered'  => esc_html__( 'Numbered', 'katen' ),
				],
				'default' => 'load_more',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

	    $settings = $this->get_settings_for_display();

		?>
		<div class="infinite-wrapper">

			<?php
			
				global $paged;

				global $post_query;
		
				if ( is_front_page() || is_home()){
					$paged = (get_query_var('page')) ? get_query_var('page') : 1;
				} else {
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				}

				$args = array( 
					'post_type' => 'post',
					'post_status' => array('publish'),
					'posts_per_page' => $settings['post_count'],
					'paged' => $paged,
					'order' => $settings['order'],
					'orderby' => $settings['order_by'],
					'ignore_sticky_posts' => $settings['ignore_sticky'],
					'tag' => $settings['post_tags'],
				);

				if ( $settings['post_categories'] ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'category',
							'field'    => 'slug',
							'terms' => $settings['post_categories'],
						]
					];
				}

				$post_query = new \WP_Query( $args );
				if ($post_query->have_posts()) : 
				while ($post_query->have_posts()) : $post_query->the_post();

			?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('post post-classic rounded bordered post-item'); ?>>

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="thumb top-rounded">

							<?php 
								if ( 'yes' === $settings['category'] ) {
									$categories = get_the_category();
								
									if ( ! empty( $categories ) ) {
										echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="category-badge lg position-absolute">' . esc_html( $categories[0]->name ) . '</a>';
									} 
								}
							?>

							<?php 
								if ( 'yes' === $settings['format_icon'] ) {
									katen_theme_post_format_icons(); 
								}
							?>

							<div class="inner">
								<?php 
									echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail('katen-thumb-classic'); echo '</a>';
								?>
							</div>

						</div>

					<?php endif; ?>

					<div class="details">
						
						<ul class="meta list-inline mb-0">
							<?php if ( 'yes' === $settings['author'] ) : ?>
								<li class="list-inline-item">
									<?php
										echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', $args = array( 'scheme' => 'https', 'class' => 'author' ) ); 
									?>
									<?php the_author_posts_link(); ?>
								</li>
							<?php endif;
							
							if ( 'yes' === $settings['date'] ) : ?>
								<li class="list-inline-item"><?php echo get_the_date(); ?></li>
							<?php endif;

							if ( 'yes' === $settings['comment_count'] ) : ?>
								<li class="list-inline-item"><i class="icon-bubble"></i> (<?php echo get_comments_number(); ?>)</li>
							<?php endif; ?>
						</ul>

						<h5 class="post-title mb-3 mt-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

						<p class="excerpt mb-0">
							<?php
								$content = get_the_content();
								$trimmed_content = wp_trim_words( $content, $settings['excerpt'] );
								echo esc_attr($trimmed_content);
							?>
						</p>

					</div>
					<div class="post-bottom clearfix d-flex align-items-center">
						<?php 
							if( function_exists('katen_social_share') && 'yes' === $settings['social_share'] ) {
								katen_social_share(); 
							}
						?>

						<?php if( 'yes' === $settings['continue'] ) : ?>
							<div class="float-end d-none d-md-block">
								<a href="<?php the_permalink(); ?>" class="more-link"><?php esc_attr_e('Continue reading', 'katen' ); ?><i class="icon-arrow-right"></i></a>
							</div>
							<div class="more-button d-block d-md-none float-end">
								<a href="<?php the_permalink(); ?>"><span class="icon-options"></span></a>
							</div>
						<?php endif; ?>
					</div>
				</div>

			<?php endwhile;?>

		</div>

		<?php 
		
			wp_reset_postdata();

			$pagination = '';

			if ( 'load_more' === $settings['pagination'] ) {
				echo '<div class="mt-5">';
					$pagination .= ''. katen_infinite_pagination(). '';
				echo '</div>';
			}

			echo $pagination;

			if ( 'numbered' === $settings['pagination'] ) {
				katen_static_pagination();
			}
		
		?>

		<?php else : ?>

		<p><?php esc_attr_e('No posts found.', 'katen' ); ?></p>

		<?php endif; ?>

        <?php
		
	}

}