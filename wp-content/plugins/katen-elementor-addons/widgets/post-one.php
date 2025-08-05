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
class Katen_Post_One extends \Elementor\Widget_Base {

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
		return 'katen-post-one';
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
		return esc_html__( 'Featured Post', 'katen' );
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
		return 'eicon-call-to-action';
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

		<?php

			$args = array( 
				'post_type' => 'post',
				'post_status' => array('publish'),
				'posts_per_page' => '1',
				'ignore_sticky_posts' => $settings['ignore_sticky'],
				'offset' => $settings['offset'],
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

			$query = new \WP_Query( $args );
			if ($query->have_posts()) : 
			while ($query->have_posts()) : $query->the_post();

			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'katen-featured-post');

		?>

			<!-- featured post large -->
			<div class="post featured-post-lg">
				<div class="details clearfix">
					<?php
						if ( 'yes' === $settings['category'] ) {
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="category-badge">' . esc_attr( $categories[0]->name ) . '</a>';
							}
						}
					?>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<ul class="meta list-inline mb-0">
						<?php if ( 'yes' === $settings['author'] ) : ?>
							<li class="list-inline-item"><?php the_author_posts_link(); ?></li>
						<?php endif; ?>
						<?php if ( 'yes' === $settings['date'] ) : ?>
							<li class="list-inline-item"><?php echo get_the_date(); ?></li>
						<?php endif; ?>
					</ul>
				</div>
				<a href="<?php the_permalink(); ?>">
					<div class="thumb rounded">
						<div class="inner data-bg-image" data-bg-image="<?php echo esc_url( $featured_img_url ); ?>"></div>
					</div>
				</a>
			</div>

		<?php endwhile;?>

		<?php wp_reset_postdata(); ?>

		<?php else : ?>

		<p><?php esc_attr_e('No post found.', 'katen' ); ?></p>

		<?php endif; ?>


        <?php
	}

}