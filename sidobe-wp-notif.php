<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sidobe.com
 * @since             1.0.0
 * @package           Sidobe_Wp_Notif
 *
 * @wordpress-plugin
 * Plugin Name:       Sidobe WP Notification
 * Plugin URI:        https://sidobe.com/plugin-wordpress-notification/
 * Description:       Send automatic WhatsApp notifications for WooCommerce orders. Keep your customers informed about their order status with real-time updates.
 * Version:           1.0.1
 * Author:            Sidobe
 * Author URI:        https://sidobe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sidobe-notification
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIDOBE_WP_NOTIF_VERSION', '1.0.1' );

global $sidobe_wp_notif_db_version;
global $sidobe_wp_notif_table_name;
global $wpdb;
$sidobe_wp_notif_db_version = '1.0';
$sidobe_wp_notif_table_name = $wpdb->prefix . 'sidobe_notif_contents';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sidobe-wp-notif-activator.php
 */
function sidobe_wp_notif_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidobe-wp-notif-activator.php';
	Sidobe_Wp_Notif_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sidobe-wp-notif-deactivator.php
 */
function sidobe_wp_notif_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidobe-wp-notif-deactivator.php';
	Sidobe_Wp_Notif_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'sidobe_wp_notif_activate' );
register_deactivation_hook( __FILE__, 'sidobe_wp_notif_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sidobe-wp-notif.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function sidobe_wp_notif_run() {

	$plugin = new Sidobe_Wp_Notif();
	$plugin->run();

}
sidobe_wp_notif_run();
