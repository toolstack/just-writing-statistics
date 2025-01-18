<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      3.0.0
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/includes
 * @author     GregRoss, RedLettuce
 * @link       https://toolstack.com/just-writing-statistics
 */
class Just_Writing_Statistics_Deactivator
{
    /**
     * Remove tables, options and transients.
     *
     * Remove all data from the WordPress database that Just Writing Statistics has generated.
     *
     * @since 3.0.0
     */
    public static function deactivate()
    {
        global $wpdb;

        // Empty database tables the plugin has made
        $table_name_posts = $wpdb->prefix.'jws_posts';

        $wpdb->query("DELETE FROM $table_name_posts");
        $wpdb->query("DROP TABLE $table_name_posts");

        // Delete options the plugin has made
        delete_option('jws_version');
        delete_option('jws_reading_time');
    }
}
