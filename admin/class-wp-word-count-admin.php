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
	
		$wpwc_installed_version = get_option('wpwc_version');
		
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
	
		$icon_svg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkZBMDRCQTQxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkZBMDRCQTUxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGRkEwNEJBMjE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGRkEwNEJBMzE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqUWiFsAAAHiSURBVHjahFO7qhpRFF2OI77xBYrESkREESJaqk3Ab7C59w/iB6TPH+QTImkFsbCxsEipha0g+OCihfhEjTrmrM0ISdDcBWtmOHvvtdaZmWOp1WpfAbwqWvA33hQ/mes/FT/8UzcUv+vq8gWPwYGPilfF9JOez5q67PAcN9PpGbaa6fAMxjsCBgWwXq9xPp+xXC5xOp2w2+1wPB5htVqly2Kx4Ha7SX0+n0v9XtP5kMvlMJ1Okclk5O73+3G5XDAej+FwOOSZfcViEZFIBIPBALPZDHa7HRqdSqUSkskkqtUq0uk0CoUCotEo9vu9OLPH7XajXC4jlUqhUqlIYgrr2+1W1CjAeD6fT4p0d7lcEl/TNEmwWCxENBaLybrUvF4vdF2XeBRjgng8DsMwJG4oFEIwGAT78vk8stkser0eAoEAwuEwNO7jcDiIw2QyQSKRkMHNZgOn0yniTEARj8eDer2Ofr8vwqzpVB6NRmi32xgOh2g0GrJnDjMFYbPZsFqt0Gw25Z3QnfuXr8BGurVaLXHpdruShg73Jqbk3judjgxTkEIicL1eZYH7IShC3Iflb1FJ7qLye5rDhGbyGd6rW1n0/q/hwSn9Ex6exm+KLw8a54oDxV+KfcXog4P247cAAwA4I8oZtVZOgwAAAABJRU5ErkJggg==';
		
		add_menu_page( 'WP Word Count', 'Word Count', 'delete_posts', $this->plugin_name, array( $this, 'admin_display' ), $icon_svg, 99 );
		
	}
	
	/**
	 * Add upgrade action link to the plugins page.
	 *
	 * @since    2.0.1
	 */
	 
	public function upgrade_link($links, $file ) {

		if (strpos($file, 'wpwordcount.php') !== false) {
			
			$new_links = array(
				'donate' => '<a href="https://linksoftwarellc.com/wp-word-count#pro" target="_blank"><strong>'.__('Upgrade to WP Word Count Pro', $this->plugin_name).'</strong></a>'
			);
			
			$links = array_merge( $links, $new_links );
		}
	
	return $links;
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
			
			$arr_wpwc_post_types[$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			$arr_wpwc_post_types[$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
			
			asort($arr_wpwc_post_types);
			
			// Load months array
			if (!isset($arr_wpwc_months[$wpwc_post->post_date])) {
				
				$arr_wpwc_months[$wpwc_post->post_date]['total'] = 0;
				
			}
			
			if (!isset($arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type])) {
				
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts']['publish'] = 0;
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts']['draft'] = 0;
				
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts']['publish'] = 0;
				$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts']['draft'] = 0;
				
			}
			
			$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			$arr_wpwc_months[$wpwc_post->post_date][$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
			$arr_wpwc_months[$wpwc_post->post_date]['total'] += $wpwc_post->post_word_count;
			
			krsort($arr_wpwc_months);
			
			// Load authors array
			if (!isset($arr_wpwc_authors[$wpwc_post->post_author]['total'])) {
			
				$arr_wpwc_authors[$wpwc_post->post_author]['total'] = 0;	
			}
			
			if (!isset($arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type])) {
				
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts']['publish'] = 0;
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts']['draft'] = 0;
				
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts']['publish'] = 0;
				$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts']['draft'] = 0;
				
				$arr_wpwc_authors[$wpwc_post->post_author]['display_name'] = get_the_author_meta('display_name', $wpwc_post->post_author);
				
			}
			
			$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['posts'][$wpwc_post->post_status] += 1;
			$arr_wpwc_authors[$wpwc_post->post_author][$wpwc_post->post_type]['word_counts'][$wpwc_post->post_status] += $wpwc_post->post_word_count;
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
