<?php
/*
Plugin Name: Electric Studio Download Counter
Plugin URI: http://www.electricstudio.co.uk
Description: Get Statistics on your Downloads
Version: 1.1
Author: James Irving-Swift
Author URI: http://www.irving-swift.com
License: GPL2
*/

include 'lib/install.php';
include 'lib/options.php';
include 'lib/sqlfunctions.php';
include 'lib/widgets.php';

/* Runs when plugin is activated */
register_activation_hook(__FILE__,array('Esdc_setup','install'));

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__,array('Esdc_setup','remove'));

add_action('init',array('Esdc_setup','install'));

class Esdc extends Esdc_db{
    var $count_nonce = "";
    var $dateSearch_nonce = "";

    /**
     * @method __construct
     * Includes all the adding of scripts and stylesheets. Also Declares the nonces for AJAX.
     */
    function __construct(){
        add_action('init',array(&$this, 'jQueryLoad'));
    	if(is_admin()){
    		add_action('init', array(&$this, 'adminScripts'));
    	}
    	add_action('init', array(&$this, 'scripts'));
    	add_action('init',array(&$this,'nonces'));
    	add_shortcode( 'downloadcount', array(&$this,'downloadCountSc'));

    }

    function nonces(){
        $this->count_nonce = wp_create_nonce('esdcCount');
        $this->dateSearch_nonce = wp_create_nonce('esdcDateSearch');
    }

    function adminScripts(){
        wp_register_style( 'esdc-style', get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/css/esdc_style.css');
        wp_enqueue_style('esdc-style');
        wp_register_style( 'esdc-datepicker-style', get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/css/smoothness/jquery-ui-1.8.14.custom.css');
        wp_enqueue_style('esdc-datepicker-style');
        wp_register_script('esdc_datepicker_script_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/jquery-ui-1.8.14.custom.min.js',array('jquery'));
        wp_enqueue_script('esdc_datepicker_script_js');
        wp_register_script('esdc_option_navigation_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/electric_studio_option_navigation.js',array('jquery'));
        wp_enqueue_script('esdc_option_navigation_js');
    }

    function scripts(){
        wp_register_script('esdc_main_js',get_bloginfo('wpurl').'/wp-content/plugins/electric-studio-download-counter/js/electric_studio_download_counter.js',array('jquery'));
    	wp_enqueue_script('esdc_main_js');
    }

    function jQueryLoad(){
        //check is jquery is loaded, and if not, load it
        if( !wp_script_is('jquery')){
            wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
        }
        //check if jquery ui has been loaded and if not, load it
        if( !wp_script_is('jquery-ui') ) {
            wp_enqueue_script( 'jquery-ui' , 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js' );
        }
    }

    function __toString(){
        return "Electric Studio Download Counter";
    }

    function downloadCountSc($atts){
        extract( shortcode_atts( array(
			'link' => ''
	    ), $atts ) );

	    if($link!=""){
	        return $this->get_count($link);
	    }else{
	        return "Count no available";
	    }
    }

}

include 'lib/ajax.php';

$esdc = new Esdc();