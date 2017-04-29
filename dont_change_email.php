<?php
/* 
Plugin Name: Don't Change Email
Description: Don't change the email of certain user roles
Version: 0.1
Author: Diego Juliao
Author URI: http://about.me/dianjuar
Text Domain: dont_change_email
Domain Path: /languages/
*/
# Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists('View_Own_Posts_Media_Only_Patch') ) {
    # -------------------------------------  Define Constants ON   -------------------------------------
	define( 'DCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'DCE_PLUGIN_DIRNAME', plugin_basename(dirname(__FILE__)));
	define( 'DCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'DCE', 'dont_change_email' );
    # -------------------------------------  Define Constants OFF   ------------------------------------

    # plugin includes
	require_once(DCE_PLUGIN_DIR . '/includes/class_dont_change_email.php');
}