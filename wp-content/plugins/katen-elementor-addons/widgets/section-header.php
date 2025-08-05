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
class Katen_Section_Header extends \Elementor\Widget_Base {

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
		return 'katen-section-header';
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
		return esc_html__( 'Section Header', 'katen' );
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
		return 'eicon-heading';
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

		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__( 'Settings', 'katen' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'widget_title',
			[
				'label' => esc_html__( 'Title', 'katen' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'katen' ),
				'placeholder' => esc_html__( 'Type your title here', 'katen' ),
			]
		);

		$this->add_control(
			'seperator',
			[
				'label' => esc_html__( 'Show Seperator', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'arrows',
			[
				'label' => esc_html__( 'Show Arrows', 'katen' ),
				'description' => esc_html__( 'The Arrows work with only Posts Carousel element.', 'katen' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'katen' ),
				'label_off' => esc_html__( 'Hide', 'katen' ),
				'return_value' => 'yes',
				'default' => 'no',
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

		$primary_color = esc_attr(get_theme_mod('primary_color', '#FE4F70'));
  		$secondary_color = esc_attr(get_theme_mod('secondary_color', '#FFA387'));

		?>

			<div class="section-header">
				<h3 class="section-title"><?php echo esc_html($settings['widget_title']); ?></h3>
				<?php if ( 'yes' === $settings['seperator'] ) : ?>
					<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
						<defs>
							<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
								<stop offset="0%" stop-color="<?php echo esc_attr($primary_color); ?>"></stop>
								<stop offset="100%" stop-color="<?php echo esc_attr($secondary_color); ?>"></stop>
							</linearGradient>
							</defs>
						<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
					</svg>
				<?php endif; ?>
				<?php if ( 'yes' === $settings['arrows'] ) : ?>
				<div class="slick-arrows-top">
					<button type="button" data-role="none" class="carousel-topNav-prev slick-custom-buttons" aria-label="Previous"><i class="icon-arrow-left"></i></button>
					<button type="button" data-role="none" class="carousel-topNav-next slick-custom-buttons" aria-label="Next"><i class="icon-arrow-right"></i></button>
				</div>
				<?php endif; ?>
			</div>

        <?php
	}

}