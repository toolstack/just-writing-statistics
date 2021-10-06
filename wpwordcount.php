<?php

/**
 * @link              https://wpwordcount.com
 * @since             3.0.0
 * @package           Wp_Word_Count
 *
 * @wordpress-plugin
 * Plugin Name:       WP Word Count
 * Plugin URI:        https://wpwordcount.com
 * Description:       Count the words on your WordPress site instantly.
 * Version:           3.2.3
 * Author:            RedLettuce Plugins
 * Author URI:        http://redlettuce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * Text Domain:       wp-word-count
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WPWC_VERSION', '3.2.3');

function activate_wp_word_count()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wpwc-activator.php';
    Wp_Word_Count_Activator::activate();
}

function deactivate_wp_word_count()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wpwc-deactivator.php';
    Wp_Word_Count_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_word_count');
register_deactivation_hook(__FILE__, 'deactivate_wp_word_count');

require plugin_dir_path(__FILE__) . 'includes/class-wpwc.php';
require plugin_dir_path(__FILE__) . 'includes/class-wpwc-functions.php';

/**
 * Begins execution of WP Word Count.
 *
 * @since    3.0.0
 */
function run_wp_word_count()
{
    $plugin = new Wp_Word_Count();
    $plugin->run();
}

run_wp_word_count();
