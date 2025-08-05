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
class Katen_Contact_Info extends \Elementor\Widget_Base {

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
		return 'katen-contact-info';
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
		return esc_html__( 'Contact Info', 'katen' );
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
		return 'eicon-mail';
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
		return [ 'contact', 'info', 'icon' ];
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
			'title',
			[
				'label' => esc_html__( 'Title', 'katen' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Phone', 'katen' ),
				'placeholder' => esc_html__( 'Type your title here', 'katen' ),
			]
		);

		$this->add_control(
			'info',
			[
				'label' => esc_html__( 'Info', 'katen' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '+1-202-555-0135', 'katen' ),
				'placeholder' => esc_html__( 'Type your info here', 'katen' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'katen' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'include' => [
					'icon-user', 
					'icon-people', 
					'icon-user-female', 
					'icon-user-follow', 
					'icon-user-following', 
					'icon-user-unfollow', 
					'icon-login', 
					'icon-logout', 
					'icon-emotsmile', 
					'icon-phone', 
					'icon-call-end', 
					'icon-call-in', 
					'icon-call-out', 
					'icon-map', 
					'icon-location-pin', 
					'icon-direction', 
					'icon-directions', 
					'icon-compass', 
					'icon-layers', 
					'icon-menu', 
					'icon-list', 
					'icon-options-vertical', 
					'icon-options', 
					'icon-arrow-down', 
					'icon-arrow-left', 
					'icon-arrow-right', 
					'icon-arrow-up', 
					'icon-arrow-up-circle', 
					'icon-arrow-left-circle', 
					'icon-arrow-right-circle', 
					'icon-arrow-down-circle', 
					'icon-check', 
					'icon-clock', 
					'icon-plus', 
					'icon-minus', 
					'icon-close', 
					'icon-event', 
					'icon-exclamation', 
					'icon-organization', 
					'icon-trophy', 
					'icon-screen-smartphone', 
					'icon-screen-desktop', 
					'icon-plane', 
					'icon-notebook', 
					'icon-mustache', 
					'icon-mouse', 
					'icon-magnet', 
					'icon-energy', 
					'icon-disc', 
					'icon-cursor', 
					'icon-cursor-move', 
					'icon-crop', 
					'icon-chemistry', 
					'icon-speedometer', 
					'icon-shield', 
					'icon-screen-tablet', 
					'icon-magic-wand', 
					'icon-hourglass', 
					'icon-graduation', 
					'icon-ghost', 
					'icon-game-controller', 
					'icon-fire', 
					'icon-eyeglass', 
					'icon-envelope-open', 
					'icon-envelope-letter', 
					'icon-bell', 
					'icon-badge', 
					'icon-anchor', 
					'icon-wallet', 
					'icon-vector', 
					'icon-speech', 
					'icon-puzzle', 
					'icon-printer', 
					'icon-present', 
					'icon-playlist', 
					'icon-pin', 
					'icon-picture', 
					'icon-handbag', 
					'icon-globe-alt', 
					'icon-globe', 
					'icon-folder-alt', 
					'icon-folder', 
					'icon-film', 
					'icon-feed', 
					'icon-drop', 
					'icon-drawer', 
					'icon-docs', 
					'icon-doc', 
					'icon-diamond', 
					'icon-cup', 
					'icon-calculator', 
					'icon-bubbles', 
					'icon-briefcase', 
					'icon-book-open', 
					'icon-basket-loaded', 
					'icon-basket', 
					'icon-bag', 
					'icon-action-undo', 
					'icon-action-redo', 
					'icon-wrench', 
					'icon-umbrella', 
					'icon-trash', 
					'icon-tag', 
					'icon-support', 
					'icon-frame', 
					'icon-size-fullscreen', 
					'icon-size-actual', 
					'icon-shuffle', 
					'icon-share-alt', 
					'icon-share', 
					'icon-rocket', 
					'icon-question', 
					'icon-pie-chart', 
					'icon-pencil', 
					'icon-note', 
					'icon-loop', 
					'icon-home', 
					'icon-grid', 
					'icon-graph', 
					'icon-microphone', 
					'icon-music-tone-alt', 
					'icon-music-tone', 
					'icon-earphones-alt', 
					'icon-earphones', 
					'icon-equalizer', 
					'icon-like', 
					'icon-dislike', 
					'icon-control-start', 
					'icon-control-rewind', 
					'icon-control-play', 
					'icon-control-pause', 
					'icon-control-forward', 
					'icon-control-end', 
					'icon-volume-1', 
					'icon-volume-2', 
					'icon-volume-off', 
					'icon-calendar', 
					'icon-bulb', 
					'icon-chart', 
					'icon-ban', 
					'icon-bubble', 
					'icon-camrecorder', 
					'icon-camera', 
					'icon-cloud-download', 
					'icon-cloud-upload', 
					'icon-envelope', 
					'icon-eye', 
					'icon-flag', 
					'icon-heart', 
					'icon-info', 
					'icon-key', 
					'icon-link', 
					'icon-lock', 
					'icon-lock-open', 
					'icon-magnifier', 
					'icon-magnifier-add', 
					'icon-magnifier-remove', 
					'icon-paper-clip', 
					'icon-paper-plane', 
					'icon-power', 
					'icon-refresh', 
					'icon-reload', 
					'icon-settings', 
					'icon-star', 
					'icon-symbol-female', 
					'icon-symbol-male', 
					'icon-target', 
					'icon-credit-card', 
					'icon-paypal', 
					'icon-social-tumblr', 
					'icon-social-twitter', 
					'icon-social-facebook', 
					'icon-social-instagram', 
					'icon-social-linkedin', 
					'icon-social-pinterest', 
					'icon-social-github', 
					'icon-social-google', 
					'icon-social-reddit', 
					'icon-social-skype', 
					'icon-social-dribbble', 
					'icon-social-behance', 
					'icon-social-foursqare', 
					'icon-social-soundcloud', 
					'icon-social-spotify', 
					'icon-social-stumbleupon', 
					'icon-social-youtube', 
					'icon-social-dropbox', 
					'icon-social-vkontakte', 
					'icon-social-steam'
				],
				'default' => 'icon-phone',
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

			<div class="contact-item bordered rounded d-flex align-items-center">
				<?php if( $settings['icon'] ) { ?>
					<span class="icon <?php echo esc_attr($settings['icon']); ?>"></span>
				<?php } ?>
				<div class="details">
					<h3 class="mb-0 mt-0"><?php echo esc_html($settings['title']); ?></h3>
					<p class="mb-0"><?php echo esc_html($settings['info']); ?></p>
				</div>
			</div>

        <?php
	}

}