<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin
 * @author     Link Software LLC <support@linksoftwarellc.com>
 */
class Wp_Word_Count_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Check plugin version and run updates if necessary.
	 *
	 * @since    2.0.0
	 */
	 
	public function plugin_check() {
	
		$wpwc_installed_version = get_site_option('wpwc_version');
		
		if ($wpwc_installed_version != WPWC_VERSION) {
			
			wpwc_set_plugin_version( WPWC_VERSION );
			wpwc_create_plugin_tables();
			wpwc_populate_plugin_tables();
			
		}
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-word-count-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-word-count-admin.js', array( 'jquery', 'jquery-ui-tabs' ), $this->version, false );

	}
	
	/**
	 * Register the administration menu.
	 *
	 * @since    2.0.0
	 */
	 
	public function menu() {
	
		add_menu_page( 'WP Word Count', 'WP Word Count', 'delete_posts', $this->plugin_name, array( $this, 'admin_display' ), 'dashicons-chart-area', 99 );
		
	}
	 
	/**
	 * Render the admin display.
	 *
	 * @since    2.0.0
	 */
	 
	public function admin_display() {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix.'wpwc_posts';

		$sql_wpwc_posts = "
			SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count 
			FROM $table_name 
			WHERE (post_status = 'publish' OR post_status = 'draft') 
			ORDER BY post_word_count DESC";
		$wpwc_posts = $wpdb->get_results($sql_wpwc_posts);

		$arr_wpwc_posts = array();
		$arr_wpwc_post_types = array();
		$arr_wpwc_post_types_default = array('post', 'page');
		$arr_wpwc_totals = array();
		$arr_wpwc_totals['publish'] = 0;
		$arr_wpwc_totals['draft'] = 0;
		$arr_wpwc_months = array();
		$arr_wpwc_authors = array();

		foreach ($wpwc_posts as $wpwc_post) {
			
			// Load post type array
			if (!isset($arr_wpwc_post_types[$wpwc_post->post_type])) {
				
				$post_type = get_post_type_object(get_post_type($wpwc_post->post_id));
				$arr_wpwc_post_types[$wpwc_post->post_type]['plural_name'] = $post_type->labels->name;
				$arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'] = $post_type->labels->singular_name;
				
				$arr_wpwc_post_types[$wpwc_post->post_type]['posts']['publish'] = 0;
				$arr_wpwc_post_types[$wpwc_post->post_type]['posts']['draft'] = 0;
				
				$arr_wpwc_post_types[$wpwc_post->post_type]['word_counts']['publish'] = 0;
				$arr_wpwc_post_types[$wpwc_post->post_type]['word_counts']['draft'] = 0;
				
			}
			
			@$arr_wpwc_post_types[$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			@$arr_wpwc_post_types[$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
			
			asort($arr_wpwc_post_types);
			
			// Load months array
			if (!isset($arr_wpwc_months[$wpwc_post->post_date])) {
				
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts']['publish'] = 0;
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts']['draft'] = 0;
				
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts']['publish'] = 0;
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts']['draft'] = 0;
				
				$arr_wpwc_months[$wpwc_post->post_date]['total'] = 0;
				
			}
			
			@$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			@$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
			$arr_wpwc_months[$wpwc_post->post_date]['total'] += $wpwc_post->post_word_count;
			
			krsort($arr_wpwc_months);
			
			// Load authors array
			if (!isset($arr_wpwc_authors[$wpwc_post->post_author])) {
				
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts']['publish'] = 0;
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts']['draft'] = 0;
				
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts']['publish'] = 0;
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts']['draft'] = 0;
				
				$arr_wpwc_authors[$wpwc_post->post_author]['total'] = 0;
				
				$arr_wpwc_authors[$wpwc_post->post_author]['display_name'] = get_the_author_meta('display_name', $wpwc_post->post_author);
				
			}
			
			@$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			@$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
			$arr_wpwc_authors[$wpwc_post->post_author]['total'] += $wpwc_post->post_word_count;
			
			krsort($arr_wpwc_months);
			
			// Load totals array
			$arr_wpwc_totals[$wpwc_post->post_status] += $wpwc_post->post_word_count; 
			
			$arr_wpwc_post = array(
				
				'post_id' => $wpwc_post->post_id,
				'post_title' => get_the_title($wpwc_post->post_id),
				'post_status' => ucwords($wpwc_post->post_status),
				'post_type' => $arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'],
				'post_author' => $arr_wpwc_authors[$wpwc_post->post_author]['display_name'],
				'post_word_count' => $wpwc_post->post_word_count,
				'permalink' => get_permalink($wpwc_post->post_id)
				
			);
			
			$arr_wpwc_posts[] = $arr_wpwc_post;
		}

	    include_once('partials/wp-word-count-admin.php');
	    
	}
	
	/**
	 * Call public save post data function on post save.
	 *
	 * @since    2.0.0
	 */
	public function post_word_count($post_id, $post) {
		
		wpwc_save_post_data($post);

	}

}
