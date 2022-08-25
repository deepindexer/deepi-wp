<?php
/*
Plugin Name: Deepi
Plugin URI: https://www.deepi.ir/
Description: Upgrade your site's "lexical search" to Deepi's "Conceptual Search", Take advantage of the latest "artificial intelligence" technologies.
Plugin Header Comment 
Text Domain: deepi
Domain Path: /lang
Version: 1.5.8
Requires at least: 5.6
License: gpl-3.0
Author: Mohsen Nasr 
*/
if(!defined('ABSPATH')){
	return;
}
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'deepi', false, basename( dirname( __FILE__ ) ) . '/lang' );
});

define( 'deepi__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'deepi__PLUGIN_URL', plugin_dir_url( __FILE__ ) );


include(deepi__PLUGIN_DIR . "installation.php");
include(deepi__PLUGIN_DIR . "unistall.php");
//
include(deepi__PLUGIN_DIR . "functions.php");
//
include(deepi__PLUGIN_DIR . "/back/menu.php");
include(deepi__PLUGIN_DIR . "/back/main.php");
include(deepi__PLUGIN_DIR . "/back/settings.php");
include(deepi__PLUGIN_DIR . "/back/status.php");
//
include(deepi__PLUGIN_DIR . "searchbox.php");

register_activation_hook( __FILE__, 'deepi_install' );
register_uninstall_hook(__FILE__, 'deepi_unistall');
//

function deepi_enqueues( $hook ) {
	
	wp_register_script('jQueryNumber',deepi__PLUGIN_URL.'resources/js/jquery.number.min.js');
	wp_register_script('JSCookie',deepi__PLUGIN_URL.'resources/js/js.cookie.min.js');

	wp_register_script('select2',deepi__PLUGIN_URL.'resources/js/select2.min.js');
	wp_register_script('select2_fa',deepi__PLUGIN_URL.'resources/js/select2_fa.js');
    wp_register_script('deepi',deepi__PLUGIN_URL.'resources/js/deepi.js');

    wp_register_style('select2',deepi__PLUGIN_URL.'resources/css/select2.min.css');
    wp_register_style('select2bootstrap',deepi__PLUGIN_URL.'resources/css/select2-bootstrap-5-theme.rtl.min.css');
    wp_register_style('deepi',deepi__PLUGIN_URL.'resources/css/deepi.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('jQueryNumber');
    wp_enqueue_script('JSCookie');
	wp_enqueue_script('select2');
	wp_enqueue_script('select2_fa');
    wp_enqueue_script('deepi');

    wp_enqueue_style('select2');
    //wp_enqueue_style('select2bootstrap');
    wp_enqueue_style('deepi');
}
add_action( 'wp_enqueue_scripts', 'deepi_enqueues' );
