<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/includes
 * @link       https://wpwordcount.com
 * @author     RedLettuce Plugins <support@redlettuce.com>
 */
class Wp_Word_Count_Activator
{
    /**
     * @since    3.0.0
     */
    public static function activate()
    {
        wpwc_set_plugin_version(WPWC_VERSION);
        wpwc_create_posts_table();
    }
}
