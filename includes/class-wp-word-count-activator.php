<?php

/**
 * Fired during plugin activation
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/includes
 * @author     Link Software LLC <support@linksoftwarellc.com>
 */
class Wp_Word_Count_Activator {
	/**
	 * @since    2.0.0
	 */
	public static function activate() {
		
		wpwc_set_plugin_version(WPWC_VERSION);
		wpwc_create_plugin_tables();
		wpwc_populate_plugin_tables();
		
	}
	
}
