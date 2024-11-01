<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpcustomlab.com/
 * @since             1.0
 * @package           Wholesale_Price
 *
 * @wordpress-plugin
 * Plugin Name:       Wholesale Price
 * Plugin URI:        https://wpcustomlab.com/
 * Description:       Wholesale Price a WooCommerce extension which helps you to set the price based on your quantity of products during add to cart.
 * Version:           1.1
 * Author:            wpcustomlab
 * Author URI:        https://profiles.wordpress.org/wpcustomlab/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wholesale-price
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
define( 'DYNAMIC_WHOLESALE_PRICE_VERSION', '1.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dynamic-wholesale-price-activator.php
 */
function activate_dynamic_wholesale_price() {
    $activator = new Dynamic_Wholesale_Price_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dynamic-wholesale-price-deactivator.php
 */
function deactivate_dynamic_wholesale_price() {
	$deactivator = new Dynamic_Wholesale_Price_Deactivator();
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_dynamic_wholesale_price' );
register_deactivation_hook( __FILE__, 'deactivate_dynamic_wholesale_price' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dynamic-wholesale-price.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dynamic_wholesale_price() {

	$plugin = new Dynamic_Wholesale_Price();
	$plugin->run();

}
run_dynamic_wholesale_price();
