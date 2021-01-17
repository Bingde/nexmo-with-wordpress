<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://beijingdumpling.ca/
 * @since             1.0.0
 * @package           Calluser
 *
 * @wordpress-plugin
 * Plugin Name:       voice call
 * Plugin URI:        https://beijingdumpling.ca/libingvoicecall
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            li bing
 * Author URI:        https://beijingdumpling.ca/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       calluser
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CALLUSER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-calluser-activator.php
 */
function activate_calluser() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calluser-activator.php';
	Calluser_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-calluser-deactivator.php
 */
function deactivate_calluser() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calluser-deactivator.php';
	Calluser_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_calluser' );
register_deactivation_hook( __FILE__, 'deactivate_calluser' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-calluser.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_calluser() {

	$plugin = new Calluser();
	$plugin->run();

}
run_calluser();
// add logging feature
if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}
//i can log data like objects
// update_option( 'blogdescription', "call user set12" );
require plugin_dir_path( __FILE__ ) . '/admin/index.php';
require plugin_dir_path( __FILE__ ) . 'index.php';

/*
function disable_shipping_once(){

$products = get_posts(array('post_type' => 'product', 'numberposts' => -1) );

foreach($products as $product) :  


    $product_ID = $product->ID;
    $meta_value = get_post_meta($product_ID, 'virtual',true);

    if($meta_value == "no") :

        update_post_meta($product_ID, 'virtual', 'yes' );

    endif;

endforeach; 
}

disable_shipping_once();
*/


