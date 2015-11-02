<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://am2studio.hr
 * @since             1.0.0
 * @package           AM2_Writing_Helper
 *
 * @wordpress-plugin
 * Plugin Name:       AM2 Writing Helper
 * Plugin URI:        https://github.com/isvaljek/am2_writing_helper/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            AM2 Studio
 * Author URI:        http://am2studio.hr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       am2-writing-helper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-am2-writing-helper-activator.php
 */
function activate_am2_writing_helper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-am2-writing-helper-activator.php';
	AM2_Writing_Helper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-am2-writing-helper-deactivator.php
 */
function deactivate_am2_writing_helper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-am2-writing-helper-deactivator.php';
	AM2_Writing_Helper_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_am2_writing_helper' );
register_deactivation_hook( __FILE__, 'deactivate_am2_writing_helper' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-am2-writing-helper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_am2_writing_helper() {

	$plugin = new AM2_Writing_Helper();
	$plugin->run();

}
run_am2_writing_helper();
