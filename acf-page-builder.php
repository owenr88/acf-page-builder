<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/acf-page-builder/
 * @since             1.0.0
 * @package           acf_page_builder
 *
 * @wordpress-plugin
 * Plugin Name:       ACF Page Builder
 * Plugin URI:        https://wordpress.org/plugins/acf-page-builder/
 * Description:       A powerful and easy to use page builder, using the Advanced Custom Fields Flexible Content module.
 * Version:           1.1.3
 * Author:            Big Lemon Creative
 * Author URI:        http://www.biglemoncreative.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-page-builder
 * Requires at least: 3.8
 * Tested up to: 	  4.4.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_acf_page_builder() {

}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_acf_page_builder() {

}

register_activation_hook( __FILE__, 'activate_acf_page_builder' );
register_deactivation_hook( __FILE__, 'deactivate_acf_page_builder' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_acf_page_builder() {

	require_once( plugin_dir_path(__FILE__) . '/includes/class.acf_page_builder.php' );
	require_once( plugin_dir_path(__FILE__) . '/admin/functions.php' );
	require_once( plugin_dir_path(__FILE__) . '/public/functions.php' );

}
run_acf_page_builder();
