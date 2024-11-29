<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/includes
 * @link       https://toolstack.com/just-writing-statistics
 * @author     GregRoss, RedLettuce
 */
class Just_Writing_Statistics_Activator
{
    /**
     * @since 3.0.0
     */
    public static function activate()
    {
        jws_set_plugin_version(JWS_VERSION);
        jws_create_posts_table();
    }
}
