<?php 
/**
 * Plugin Name: Katen Elementor Addons
 * Description: Katen theme Elementor addons
 * Plugin URI:  https://themeforest.net/user/themeger
 * Version:     1.0.1
 * Author:      ThemeGer
 * Author URI:  https://themeger.shop
 * Text Domain: katen
 * 
 * Elementor tested up to:     3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function katen_elementor_addons() {

	// Load plugin file
	require_once( __DIR__ . '/plugin.php' );

	// Run the plugin
	\Katen_Elementor_Addons\Plugin::instance();

}
add_action( 'plugins_loaded', 'katen_elementor_addons' );