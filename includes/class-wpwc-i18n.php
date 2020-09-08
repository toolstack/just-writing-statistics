<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    Wp_Word_Count_Pro
 * @subpackage Wp_Word_Count_Pro/includes
 * @author     RedLettuce Plugins <support@redlettuce.com>
 * @link       https://wpwordcount.com
 */
class Wp_Word_Count_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    3.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain('wp-word-count', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/');
    }
}
