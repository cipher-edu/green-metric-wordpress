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
class Katen_Post_Six extends \Elementor\Widget_Base {

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
		return 'katen-post-six';
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
		return esc_html__( 'Tabbed Posts', 'katen' );
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
		return 'eicon-table-of-contents';
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
			'post_count',
			[
				'label' => esc_html__( 'Number of Posts', 'katen' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 20,
				'step' => 1,
				'default' => 4,
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
			'popular_title',
			[
				'label' => esc_html__( 'Popular Tab Title', 'katen' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Popular', 'katen' ),
				'placeholder' => esc_html__( 'Popular', 'katen' ),
			]
		);

		$this->add_control(
			'recent_title',
			[
				'label' => esc_html__( 'Recent Tab Title', 'katen' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Recent', 'katen' ),
				'placeholder' => esc_html__( 'Recent', 'katen' ),
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

		<div class="post-tabs rounded bordered">
			<!-- tab navs -->
			<ul class="nav nav-tabs nav-pills nav-fill" id="postsTab" role="tablist">
				<li class="nav-item" role="presentation"><button aria-controls="popular" aria-selected="true" class="nav-link active" data-bs-target="#popular" data-bs-toggle="tab" id="popular-tab" role="tab" type="button"><?php echo esc_html($settings['popular_title']); ?></button></li>
				<li class="nav-item" role="presentation"><button aria-controls="recent" aria-selected="false" class="nav-link" data-bs-target="#recent" data-bs-toggle="tab" id="recent-tab" role="tab" type="button"><?php echo esc_html($settings['recent_title']); ?></button></li>
			</ul>
			<!-- tab contents -->
			<div class="tab-content" id="postsTabContent">
				<!-- loader -->
				<div class="lds-dual-ring"></div>
				<!-- popular posts -->
				<div aria-labelledby="popular-tab" class="tab-pane fade active show" id="popular" role="tabpanel">
					<?php

						$popular_args = array( 
							'post_type' => 'post',
							'post_status' => array('publish'),
							'posts_per_page' => $settings['post_count'],
							'meta_key' => 'katen_post_views_count', 
							'orderby' => 'meta_value_num', 
							'order' => 'DESC',
							'ignore_sticky_posts' => 1,
						);

						$popular_query = new \WP_Query( $popular_args );
						if ($popular_query->have_posts()) : 
						while ($popular_query->have_posts()) : $popular_query->the_post();

					?>

						<!-- post -->
						<div class="post post-list-sm circle">
							<div class="thumb circle">
								<?php
									if ( has_post_thumbnail() ) {
										echo '<a href="'; the_permalink(); echo '"><div class="inner">'; the_post_thumbnail('katen-thumb-circle'); echo '</div></a>';
									} 
								?>
							</div>
							<div class="details clearfix">
								<h6 class="post-title my-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
								<ul class="meta list-inline mt-1 mb-0">
									<?php if ( 'yes' === $settings['date'] ) : ?>
										<li class="list-inline-item"><?php echo get_the_date(); ?></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>

					<?php endwhile;?>

					<?php wp_reset_postdata(); ?>

					<?php else : ?>

					<p><?php esc_attr_e('No posts found.', 'katen' ); ?></p>

					<?php endif; ?>
				</div>
				<!-- recent posts -->
				<div aria-labelledby="recent-tab" class="tab-pane fade" id="recent" role="tabpanel">
					<?php

						$recent_args = array( 
							'post_type' => 'post',
							'post_status' => array('publish'),
							'posts_per_page' => $settings['post_count'],
							'ignore_sticky_posts' => 1,
						);

						$recent_query = new \WP_Query( $recent_args );
						if ($recent_query->have_posts()) : 
						while ($recent_query->have_posts()) : $recent_query->the_post();

					?>

					<!-- post -->
					<div class="post post-list-sm circle">
						<div class="thumb circle">
							<?php
								if ( has_post_thumbnail() ) {
									echo '<a href="'; the_permalink(); echo '"><div class="inner">'; the_post_thumbnail('katen-thumb-circle'); echo '</div></a>';
								} 
							?>
						</div>
						<div class="details clearfix">
							<h6 class="post-title my-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
							<ul class="meta list-inline mt-1 mb-0">
								<?php if ( 'yes' === $settings['date'] ) : ?>
									<li class="list-inline-item"><?php echo get_the_date(); ?></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>

					<?php endwhile;?>

					<?php wp_reset_postdata(); ?>

					<?php else : ?>

					<p><?php esc_attr_e('No posts found.', 'katen' ); ?></p>

					<?php endif; ?>
				</div>
			</div>
		</div>


        <?php
	}

}