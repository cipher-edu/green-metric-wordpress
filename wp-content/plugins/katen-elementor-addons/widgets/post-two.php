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
class Katen_Post_Two extends \Elementor\Widget_Base {

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
		return 'katen-post-two';
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
		return esc_html__( 'Featured Posts', 'katen' );
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
		return 'eicon-thumbnails-right';
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

		$tax_args = array(
			'hide_empty' => false,
		);

		$categories = get_categories($tax_args);

		foreach ( $categories as $key => $category ) {
			$cat_options[$category->slug] = $category->name;
		}

		$tag_options = array();

		$tags = get_tags($tax_args);

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
				'default' => 5,
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
					'ID'  => esc_html__( 'ID', 'katen' ),
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
			'offset',
			[
				'label' => esc_html__( 'Offset', 'katen' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0,
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
				'label' => esc_html__( 'Category label', 'katen' ),
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
				'default' => 20,
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

		<div class="padding-30 rounded bordered">

			<div class="row gy-5">

			<?php
		
				global $query;

				$args = array( 
					'post_type' => 'post',
					'post_status' => array('publish'),
					'posts_per_page' => $settings['post_count'],
					'offset' => $settings['offset'],
					'orderby' => $settings['order_by'],
					'order' => $settings['order'],
					'ignore_sticky_posts' => $settings['ignore_sticky'],
					'tag' => $settings['post_tags']
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

				$counter = 1;

				$query = new \WP_Query( $args );
				if ($query->have_posts()) : 
				while ($query->have_posts()) : $query->the_post();

				if( $counter == 1 ) {
			?>
				<div class="col-sm-6">
					<!-- post -->
					<div class="post">
						<div class="thumb rounded">
							<?php
								if ( 'yes' === $settings['category'] ) {
									$categories = get_the_category();
									if ( ! empty( $categories ) ) {
										echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="category-badge position-absolute">' . esc_attr( $categories[0]->name ) . '</a>';
									}
								}
								if ( has_post_thumbnail() ) {
									if ( 'yes' === $settings['format_icon'] ) {
										katen_theme_post_format_icons();
									}
									echo '<a href="'; the_permalink(); echo '"><div class="inner">'; the_post_thumbnail('katen-thumb-featured-sm'); echo '</div></a>';
								} 
							?>
						</div>
						<ul class="meta list-inline mt-4 mb-0">
							<?php if ( 'yes' === $settings['author'] ) : ?>
								<li class="list-inline-item">
									<?php
										echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', $args = array( 'scheme' => 'https', 'class' => 'author' ) ); 
                                    ?>
									<?php the_author_posts_link(); ?>
								</li>
							<?php endif; ?>
							<?php if ( 'yes' === $settings['date'] ) : ?>
								<li class="list-inline-item"><?php echo get_the_date(); ?></li>
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
				</div>

				<div class="col-sm-6">

				<?php } else { ?>
					
					<!-- post -->
					<div class="post post-list-sm square">
						<?php
							if ( has_post_thumbnail() ) {
								echo '<div class="thumb rounded"><a href="'; the_permalink(); echo '"><div class="inner">'; the_post_thumbnail('katen-thumb-list-sm'); echo '</div></a></div>';
							} 
						?>
						<div class="details clearfix">
							<h6 class="post-title my-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
							<ul class="meta list-inline mt-1 mb-0">
								<?php if ( 'yes' === $settings['date'] ) : ?>
									<li class="list-inline-item"><?php echo get_the_date(); ?></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>

			<?php } 
				$counter++;
				endwhile; 
				echo '</div>';
			?>


		<?php wp_reset_postdata(); ?>

		<?php else : ?>

		<p><?php esc_attr_e('No posts found.', 'katen' ); ?></p>

		<?php endif; ?>
		
					</div>

		</div>

        <?php
	}

}