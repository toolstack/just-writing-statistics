<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/public
 * @author     Link Software LLC <support@linksoftwarellc.com>
 * @link       https://wpwordcount.com
 */
class Wp_Word_Count_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 	3.0.0
	 * @param 	string    $plugin_name 	The name of the plugin.
	 * @param 	string    $version    	The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Display word count stats with shortcode.
	 *
	 * @since 	3.0.0
	 * @param	array	$atts	Shortcode attributes.
	 */
	 
	 public function wpwordcount_register_shortcodes() {
		 
		function wpwc_shortcode($atts) {
			
			global $post;
			
			if ($post) {
				
				extract(shortcode_atts(array(
					
					'before' => '',
					'after' => '',
					
				), $atts));
		
				$words = 0 + wpwc_calculate_word_count_post($post);
				
				return trim(esc_attr($before).' '.number_format($words).' '.esc_attr($after));
				
			}
			
		}
			
		add_shortcode('wpwordcount', 'wpwc_shortcode');
		add_shortcode('wp-word-count', 'wpwc_shortcode');
		 
		function wpwc_shortcode_total($atts) {
			
			extract(shortcode_atts(array(
				
				'before' => '',
				'after' => '',
				
			), $atts));
	
			$words = wpwc_calculate_word_count_total();
			
			return trim(esc_attr($before).' '.number_format($words).' '.esc_attr($after));
			
		}
		
	}

}
