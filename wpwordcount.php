<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://linksoftwarellc.com/wp-word-count
 * @since             2.0.0
 * @package           Wp_Word_Count
 *
 * @wordpress-plugin
 * Plugin Name:       WP Word Count
 * Plugin URI:        http://linksoftwarellc.com/wp-word-count
 * Description:       Word Count Statistics for your Posts, Pages and Custom Post Types.
 * Version:           2.0.0
 * Author:            Link Software LLC
 * Author URI:        http://linksoftwarellc.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-word-count
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WPWC_VERSION', '2.0.0');

function activate_wp_word_count() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-word-count-activator.php';
	Wp_Word_Count_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_wp_word_count' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-word-count.php';
require plugin_dir_path( __FILE__ ) . 'includes/functions-wp-word-count.php';

/**
 * Begins execution of WP Word Count.
 *
 * @since    2.0.0
 */
function run_wp_word_count() {

	$plugin = new Wp_Word_Count();
	$plugin->run();

}
run_wp_word_count();