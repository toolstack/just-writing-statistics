<?php

/**
 * @link              https://toolstack.com/just-writing-statistics
 * @since             3.0.0
 * @package           Just_Writing_Statistics
 *
 * @wordpress-plugin
 * Plugin Name:       Just Writing Statistics
 * Plugin URI:        https://toolstack.com/just-writing-statistics
 * Description:       Count the words on your WordPress site instantly.
 * Version:           3.2.3
 * Author:            GregRoss, RedLettuce Plugins
 * Author URI:        https://toolstack.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       just-writing-statistics
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('JWS_VERSION', '3.2.3');

function activate_just_writing_statsitics_()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-jws-activator.php';
    Just_Writing_Statsitics_Activator::activate();
}

function deactivate_just_writing_statsitics_()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-jws-deactivator.php';
    Just_Writing_Statsitics_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_just_writing_statsitics_');
register_deactivation_hook(__FILE__, 'deactivate_just_writing_statsitics_');

require plugin_dir_path(__FILE__) . 'includes/class-jws.php';
require plugin_dir_path(__FILE__) . 'includes/class-jws-functions.php';

/**
 * Begins execution of Just Writing Statistics.
 *
 * @since    3.0.0
 */
function run_just_writing_statsitics_()
{
    $plugin = new Just_Writing_Statistics();
    $plugin->run();
}

run_just_writing_statsitics_();
