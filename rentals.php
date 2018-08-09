<?php
/*
Plugin Name:  Rentals 
Version:  0.0.3
Plugin URI:  http://MightyAgent.com/
Description:  Rentals property information
Author:  MightySites LLC
Author URI:  http://MightyAgent.com/
*/

require_once('ModelRentals.php');
define ('RENTALS_URL', plugin_dir_path( __FILE__ ));
add_action('init', 'initializeRentals');
function initializeRentals(){	
	require("acf.php");
}
			function my_load_scripts() {
				wp_register_script( 'owl-carousel', plugin_dir_url( __FILE__ ) .'js/owl.carousel.js', array( 'jquery' ),'', true );
				wp_register_script( 'owl-carousel-min', plugin_dir_url( __FILE__ ) .'js/owl.carousel.min.js', array( 'jquery' ),'', true );
				wp_register_script( 'owl-carousel2-thumbs-min', plugin_dir_url( __FILE__ ) .'js/owl.carousel2.thumbs.min.js', array( 'jquery' ),'', true );
				wp_register_script( 'owl-carousel2-thumbs', plugin_dir_url( __FILE__ ) .'js/owl.carousel2.thumbs.js', array( 'jquery' ),'', true );
				wp_register_script( 'owl-public-script', plugin_dir_url( __FILE__ ) .'js/owl-public-script.js', array( 'jquery' ),'', true );

				wp_register_style( 'owl-slider', plugin_dir_url( __FILE__ ) .'css/owl-slider.css' );
				wp_register_style( 'owl_carousel_css', plugin_dir_url( __FILE__ ) .'css/owl.carousel.css' );
				wp_register_style( 'owl_theme', plugin_dir_url( __FILE__ ) .'css/owl.theme.css' );
				wp_register_style( 'owl_transitions', plugin_dir_url( __FILE__ ) .'css/owl.transitions.css' );
				wp_register_style( 'rental-css', plugin_dir_url( __FILE__ ) .'css/rental.css' );
				
				wp_enqueue_script ( 'jquery' );
				wp_enqueue_script ( 'owl-carousel' );
				wp_enqueue_script ( 'custom_js' );
				wp_enqueue_script ( 'fancy_box_js' );
				wp_enqueue_script ( 'owl-public-script' );
				
				
				wp_enqueue_style ( 'owl-slider' );
				wp_enqueue_style ( 'owl_carousel_css' );
				wp_enqueue_style ( 'owl_theme' );
				wp_enqueue_style ( 'owl_transitions' );
				wp_enqueue_style ( 'rental-css' );
				
			}
			if(! is_admin() ){
				add_action('wp_enqueue_scripts', 'my_load_scripts');
			}
			
			add_action( 'init', 'add_image_sizes' );
			function add_image_sizes() {
				$list_arr = get_option('theme_custom_options');
				$list_width = $list_arr['listview_image_width'];
				$list_height = $list_arr['listview_image_height'];
				$detail_width = $list_arr['detailview_image_width'];
				$detail_height = $list_arr['detailview_image_height'];
				$thumbnail_width = $list_arr['thumbnail_image_width'];
				$thumbnail_height = $list_arr['thumbnail_image_height'];
				add_image_size( 'list_view', $list_width, $list_height, array( 'left', 'top' ) );
				add_image_size( 'detail_view_image_size', $detail_width, $detail_height, array( 'left', 'top' ) );
				add_image_size( 'thumbnail_image_size', $thumbnail_width, $thumbnail_height, array( 'left', 'top' ) );
			}
?>