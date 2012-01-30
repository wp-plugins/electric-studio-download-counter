<?php
/*
Plugin Name: Electric Studio Download Counter
Plugin URI: http://www.electricstudio.co.uk
Description: Get Statistics on your Downloads
Version: 0.7.4
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


//check is jquery is loaded, and if not, load it
if( !wp_script_is('jquery')){
    wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
}
//check if jquery ui has been loaded and if not, load it
if( !wp_script_is('jquery-ui') ) { 
    wp_enqueue_script( 'jquery-ui' , 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js' );
}  
function esdc_init(){
	if(is_admin()){
		wp_register_style( 'esdc-style', get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/css/esdc_style.css');
		wp_enqueue_style('esdc-style');
		wp_register_style( 'esdc-datepicker-style', get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/css/smoothness/jquery-ui-1.8.14.custom.css');
		wp_enqueue_style('esdc-datepicker-style');
		wp_register_script('esdc_datepicker_script_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/jquery-ui-1.8.14.custom.min.js',array('jquery'));
		wp_enqueue_script('esdc_datepicker_script_js');
		wp_register_script('esdc_option_navigation_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/electric_studio_option_navigation.js',array('jquery'));
		wp_enqueue_script('esdc_option_navigation_js');
	}
	$esdcCount_nonce = wp_create_nonce('esdcCount');
	$esdcDateSearch_nonce = wp_create_nonce('esdcDateSearch');
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
