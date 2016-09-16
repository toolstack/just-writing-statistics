<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/public
 * @author     Link Software LLC <support@linksoftwarellc.com>
 */
class Wp_Word_Count_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Display word count stats with shortcode.
	 *
	 * @since 	2.0.0
	 * @param	array	$atts	Shortcode attributes.
	 */
	 
	 public function wpwordcount_register_shortcodes() {
		 
		function shortcode($atts) {
			
			global $wpdb;
			global $post;
			
			if ($post) {
				
				extract(shortcode_atts(array(
					'before' => '',
					'after' => 'Words',
				), $atts));
		
				$table_name = $wpdb->prefix.'wpwc_posts';
				
				$sql_wpwc_words = $wpdb->prepare("SELECT post_word_count FROM $table_name WHERE post_id = %d", $post->ID);
				$wpwc_words = $wpdb->get_row($sql_wpwc_words);
				
				$words = 0 + $wpwc_words->post_word_count;
				
				return esc_attr($before).' '.number_format($words).' '.esc_attr($after);
				
			}
			
		}
			
		add_shortcode('wpwordcount', 'shortcode');
	}

}
