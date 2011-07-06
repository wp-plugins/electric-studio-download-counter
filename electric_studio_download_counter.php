<?php
/*
Plugin Name: Electric Studio Download Counter
Plugin URI: http://www.electricstudio.co.uk
Description: Get Statistics on your Downloads
Version: 0.5
Author: James Irving-Swift
Author URI: http://www.irving-swift.com
License: GPL2
*/

include 'lib/install.php';
include 'lib/options.php';
include 'lib/ajax.php';
include 'lib/sqlfunctions.php';

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'electric_studio_download_counter_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'electric_studio_download_counter_remove' );

function esdc_init(){
	if(is_admin()){
		wp_register_style( 'esdc-style', get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/css/esdc_style.css');
		wp_enqueue_style('esdc-style');
		wp_register_script('esdc_option_navigation_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/electric_studio_option_navigation.js',array('jquery'));
		wp_enqueue_script('esdc_option_navigation_js');
	}
	$esdcCount_nonce = wp_create_nonce('esdcCount');
	wp_register_script('esdc_main_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/electric_studio_download_counter.js',array('jquery'));
	wp_enqueue_script('esdc_main_js');
}

add_action('init','electric_studio_download_counter_install');
add_action('init','esdc_init');

function electric_studio_download_counter()
{
  //echo get_option('OPTION_NAME');
}

?>
