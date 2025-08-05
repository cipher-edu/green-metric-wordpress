<?php 
/*
Plugin Name: Katen Theme Widgets
Plugin URI: https://themeforest.net/user/themeger
Description: Katen Widgets
Author: ThemeGer
Author URI: https://themeger.shop
Version: 1.1
Text Domain: katen
*/
include_once( 'widgets/popular-posts.php' );
include_once( 'widgets/posts-carousel.php' );

add_action( 'widgets_init', 'katen_register_widgets' );
 
function katen_register_widgets() {
    register_widget( 'Katen_Popular_Posts' );
    register_widget( 'Katen_Posts_Carousel' );
}