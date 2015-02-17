<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://fulcrumcreatives.com/
 * @since             1.0.0
 * @package           Benefactor
 *
 * @wordpress-plugin
 * Plugin Name:       Benefactor Functionality Plugin
 * Plugin URI:        http://benefactorgroup.com/
 * Description:       A custom functionality plugin for the Benefactor Group website
 * Version:           1.0.0
 * Author:            Fulcrum Creatives
 * Author URI:        http://fulcrumcreatives.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       benefactor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-benefactor-activator.php
 */
function activate_benefactor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-benefactor-activator.php';
	Benefactor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-benefactor-deactivator.php
 */
function deactivate_benefactor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-benefactor-deactivator.php';
	Benefactor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_benefactor' );
register_deactivation_hook( __FILE__, 'deactivate_benefactor' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-benefactor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_benefactor() {

	$plugin = new Benefactor();
	$plugin->run();

}
run_benefactor();
