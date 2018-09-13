<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin
 * @author     Link Software LLC <support@linksoftwarellc.com>
 * @link       https://wpwordcount.com
 */
class Wp_Word_Count_Admin {

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
	 * @since    3.0.0
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
	 * @since    3.0.0
	 */
	public function plugin_check() {
	
		$wpwc_installed_version = get_option('wpwc_version');
		
		if ($wpwc_installed_version != WPWC_VERSION) {
			
			wpwc_set_plugin_version(WPWC_VERSION);
			
		}
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpwc-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( $this->plugin_name.'-js', plugin_dir_url( __FILE__ ) . 'js/wpwc-admin.js', array( 'jquery', 'jquery-ui-tabs' ), $this->version, false );

	}
	
	/**
	 * Register the administration menu.
	 *
	 * @since    3.0.0
	 */
	public function menu() {
		
		$icon_svg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkZBMDRCQTQxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkZBMDRCQTUxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGRkEwNEJBMjE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGRkEwNEJBMzE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqUWiFsAAAHiSURBVHjahFO7qhpRFF2OI77xBYrESkREESJaqk3Ab7C59w/iB6TPH+QTImkFsbCxsEipha0g+OCihfhEjTrmrM0ISdDcBWtmOHvvtdaZmWOp1WpfAbwqWvA33hQ/mes/FT/8UzcUv+vq8gWPwYGPilfF9JOez5q67PAcN9PpGbaa6fAMxjsCBgWwXq9xPp+xXC5xOp2w2+1wPB5htVqly2Kx4Ha7SX0+n0v9XtP5kMvlMJ1Okclk5O73+3G5XDAej+FwOOSZfcViEZFIBIPBALPZDHa7HRqdSqUSkskkqtUq0uk0CoUCotEo9vu9OLPH7XajXC4jlUqhUqlIYgrr2+1W1CjAeD6fT4p0d7lcEl/TNEmwWCxENBaLybrUvF4vdF2XeBRjgng8DsMwJG4oFEIwGAT78vk8stkser0eAoEAwuEwNO7jcDiIw2QyQSKRkMHNZgOn0yniTEARj8eDer2Ofr8vwqzpVB6NRmi32xgOh2g0GrJnDjMFYbPZsFqt0Gw25Z3QnfuXr8BGurVaLXHpdruShg73Jqbk3judjgxTkEIicL1eZYH7IShC3Iflb1FJ7qLye5rDhGbyGd6rW1n0/q/hwSn9Ex6exm+KLw8a54oDxV+KfcXog4P247cAAwA4I8oZtVZOgwAAAABJRU5ErkJggg==';
		
		add_menu_page( 'WP Word Count', 'Word Count', 'delete_posts', $this->plugin_name, array( $this, 'display_statistics' ), $icon_svg, 99 );
		add_submenu_page( 'wpwc', 'WP Word Count - '.__('Calculate', $this->plugin_name), 'WP Word Count - '.__('Calculate', $this->plugin_name), 'delete_posts', $this->plugin_name . '-calculate', array($this, 'display_calculate') );
		add_submenu_page( 'wpwc', 'WP Word Count - '.__('Upgrade to Pro', $this->plugin_name), 'WP Word Count - '.__('Upgrade to Pro', $this->plugin_name), 'delete_posts', $this->plugin_name . '-upgrade', array($this, 'display_upgrade') );

	}
	
	/**
	 * Add upgrade action link to the plugins page.
	 *
	 * @since    3.0.0
	 */
	 
	public function upgrade_link($links, $file) {
		
		if (strpos($file, 'wpwordcount.php') !== false) {
			
			$new_links = array(
				
				'upgrade' => '<a href="'.add_query_arg( array( 'page' => $this->plugin_name.'-upgrade', 'tab' => 'upgrade' ), admin_url('admin.php') ).'"><strong>'.__('Upgrade to WP Word Count Pro', $this->plugin_name).'</strong></a>'
				
			);
			
			$links = array_merge( $links, $new_links );
		}
	
		return $links;
	
	}
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    3.0.0
	 */
	public function action_links($links) {
	
	   $settings_link = array('<a href="'.admin_url('admin.php?page='.$this->plugin_name.'-settings').'">'.__('Settings', $this->plugin_name).'</a>');
	   
	   return array_merge($settings_link, $links);
	
	}
	
	/**
	 * Render the calculate display.
	 *
	 * @since    3.0.0
	 */	
	public function display_calculate () {
		
	    include_once('partials/wpwc-calculate.php');
		
	}
		
	/**
	 * Calculate statistics
	 *
	 * @since    3.0.0
	 */
	function calculate_statistics() {
	
		$step = absint($_POST['step']);
		
		$ret = $this->process_step($step);
	
		$percentage = 0;
		
		$post_types = get_post_types('', 'names');
		$posts_count = 0;
		
		foreach ($post_types as $post_type) {
			
			$type_counts = wp_count_posts($post_type);
			
			$posts_count += $type_counts->publish;
			$posts_count += $type_counts->draft;
		}
	
		if ($ret) {
	
			$step += 1;
			$percentage = (($step - 1) * 20 / $posts_count * 100);
			if ($percentage > 100) { $percentage = 100; }
			
			echo json_encode(array('step' => $step, 'percentage' => $percentage));
			
			exit;
	
		} else {
	
			$args = array_merge($_REQUEST, array(
				
				'step'       => $step,
				'nonce'      => wp_create_nonce('wpwc_calculate_nonce')
				
			));
			
			$link_message = add_query_arg(
	            array(
	                'page' => $this->plugin_name
	            ),
	            admin_url('admin.php')
	        );
	        
			$message = sprintf(wp_kses(__('Word counts calculated successfully. Visit the <a href="%s">statistics page</a> to view.', $this->plugin_name), array('a' => array('href' => array()))), esc_url($link_message));
		
			echo json_encode(array('step' => 'done', 'message' => $message));
			
			exit;
	
		}
		
		wp_die();
	}
	
	/**
	 * Process calculation step
	 *
	 * @since    3.0.0
	 * @return 	bool
	 */
	public function process_step($step) {
		
		global $wpdb;
		
		if ($step == 1) {
			
			$table_name = $wpdb->prefix.'wpwc_posts';
			$wpdb->query("DELETE FROM $table_name");
			wpwc_create_posts_table();
			
		}
		
		$post_types = get_post_types('', 'names');
	
		$args = array(
			
			'post_type' => $post_types,
			'post_status' => array('publish', 'draft', 'future'),
			'orderby'   => 'post_date',
			'order'     => 'ASC',
			'posts_per_page' => 20
			
		);
		
		if ($step > 1) {
			
			$args['offset'] = 20 * ($step - 1);
		}
		
		$wpwc_posts = new WP_Query($args);
		
		if ($wpwc_posts->have_posts()) {
			
			foreach ($wpwc_posts->posts as $post) {
	
				if ($post->post_author != 0 && $post->post_type != 'attachment' && $post->post_type != 'nav_menu_item' && $post->post_type != 'custom_css' && $post->post_type != 'revision' && $post->post_type != 'customize_changeset') {
				
					wpwc_save_post_data($post);
			
				}
				
			}
			
			return true;
			
		} else {
			
			return false;
			
		}
	}
	
	/***************************************
	 *
	 * STATISTICS
	 *
	 ***************************************/

	/**
	 * Calculate total word counts by post type.
	 *
	 * @since    3.0.0
	 */
	public function display_statistics_totals() {
		
		global $wpdb;
		
		$totals = array();
		
		$table_name_posts = $wpdb->prefix.'wpwc_posts';

		$sql_wpwc_totals = "
			SELECT post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
			FROM $table_name_posts 
			WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
			GROUP BY post_type, post_status 
			ORDER BY word_count DESC";
		$wpwc_totals = $wpdb->get_results($sql_wpwc_totals);
		
		foreach ( $wpwc_totals as $total ) {
			
			if ( !isset($totals[$total->post_type] )) {
				
				$post_type_object = get_post_type_object( $total->post_type );
			
				$totals[$total->post_type]['name'] = $post_type_object->labels->name;
				$totals[$total->post_type]['published']['posts'] = 0;
				$totals[$total->post_type]['published']['word_count'] = 0;
				$totals[$total->post_type]['unpublished']['posts'] = 0;
				$totals[$total->post_type]['unpublished']['word_count'] = 0;
			
			}
				
			if ( $total->post_status == 'publish' ) {
				
				$totals[$total->post_type]['published']['posts'] += $total->posts;
				$totals[$total->post_type]['published']['word_count'] += $total->word_count;
				
			} else {
			
				$totals[$total->post_type]['unpublished']['posts'] += $total->posts;
				$totals[$total->post_type]['unpublished']['word_count'] += $total->word_count;
				
			}
			
		}
		
		return $totals;
			
	}
		 
	/**
	 * Display Top Content, All Content, Monthly Statistics and Author Statistics
	 *
	 * @since    3.0.0
	 */
	public function display_statistics() {
		
		global $wpdb;
		
		$table_name_posts = $wpdb->prefix.'wpwc_posts';
		
		$wpwc_totals = $this->display_statistics_totals();
		
		$wpwc_tab = 'top-content';
		
		if ( isset( $_GET['tab'] ) ) {
			
			$wpwc_tab = $_GET['tab'];
			
		}

		if ( !isset( $wpwc_tab ) || $wpwc_tab == 'top-content' ) {
		
			$sql_wpwc_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				ORDER BY post_word_count DESC, post_date DESC 
				LIMIT 10";
			
		} elseif ( $wpwc_tab == 'all-content' ) {
			
			$sql_wpwc_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				ORDER BY post_word_count DESC, post_date DESC";
				
		} elseif ( $wpwc_tab == 'monthly-statistics' ) {
			
			$sql_wpwc_statistics = "
				SELECT MID(post_date, 1, 7) AS post_date, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				GROUP BY MID(post_date, 1, 7), post_type, post_status 
				ORDER BY post_date DESC";

		} elseif ( $wpwc_tab == 'author-statistics' ) {
			
			$sql_wpwc_statistics = "
				SELECT post_author, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				GROUP BY post_author, post_type, post_status 
				ORDER BY post_author ASC";

		}
		
		$wpwc_statistics = $wpdb->get_results($sql_wpwc_statistics);

		if ( !isset( $wpwc_tab ) || $wpwc_tab == 'top-content'  || $wpwc_tab == 'all-content' ) {
			
			$arr_wpwc_posts = array();
			$arr_wpwc_post_types = array();
	
			foreach ($wpwc_statistics as $wpwc_post) {
				
				// Load post type array
				if ( !isset( $arr_wpwc_post_types[$wpwc_post->post_type] ) ) {
					
					$post_type_object = get_post_type_object( $wpwc_post->post_type );
					
					$arr_wpwc_post_types[$wpwc_post->post_type]['plural_name'] = $post_type_object->labels->name;
					$arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'] = $post_type_object->labels->singular_name;
					
				}
				
				// Load authors array
				if (!isset($arr_wpwc_authors[$wpwc_post->post_author])) {
					
					$arr_wpwc_authors[$wpwc_post->post_author]['display_name'] = get_the_author_meta('display_name', $wpwc_post->post_author);
					
				}
				
				$arr_wpwc_post = array(
					
					'post_id' => $wpwc_post->post_id,
					'post_title' => get_the_title($wpwc_post->post_id),
					'post_status' => ucwords($wpwc_post->post_status),
					'post_type' => $arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'],
					'post_author' => $arr_wpwc_authors[$wpwc_post->post_author]['display_name'],
					'post_author_id' => $wpwc_post->post_author,
					'post_word_count' => $wpwc_post->post_word_count,
					'permalink' => get_permalink($wpwc_post->post_id)
					
				);
				
				$arr_wpwc_posts[] = $arr_wpwc_post;
				
			}
			
		} elseif ( $wpwc_tab == 'monthly-statistics' ) {
		
			$arr_wpwc_months = array();
	
			foreach ($wpwc_statistics as $total) {
				
				// Load post type array
				if ( !isset( $arr_wpwc_post_types[$total->post_type] ) ) {
					
					$post_type_object = get_post_type_object( $total->post_type );
				
					$arr_wpwc_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
					$arr_wpwc_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
					
				}
				
				// Load months array
				if (!isset($arr_wpwc_months[$total->post_date])) {
					
					$arr_wpwc_months[$total->post_date]['total'] = 0;
					
				}
				
				if (!isset($arr_wpwc_months[$total->post_date][$total->post_type])) {
					
					$arr_wpwc_months[$total->post_date][$total->post_type]['name'] = $arr_wpwc_post_types[$total->post_type]['plural_name'];
					$arr_wpwc_months[$total->post_date][$total->post_type]['published']['posts'] = 0;
					$arr_wpwc_months[$total->post_date][$total->post_type]['published']['word_count'] = 0;
					$arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['posts'] = 0;
					$arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['word_count'] = 0;
					
				}
				
				if ( $total->post_status == 'publish' ) {
				
					$arr_wpwc_months[$total->post_date][$total->post_type]['published']['posts'] += $total->posts;
					$arr_wpwc_months[$total->post_date][$total->post_type]['published']['word_count'] += $total->word_count;
					
				} else {
				
					$arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['posts'] += $total->posts;
					$arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['word_count'] += $total->word_count;
					
				}
			
				$arr_wpwc_months[$total->post_date]['total'] += $total->word_count;
				
			}
			
		} elseif ( $wpwc_tab == 'author-statistics' ) {
			
			$arr_wpwc_authors = array();
			$arr_wpwc_post_types = array();
	
			foreach ($wpwc_statistics as $total) {
				
				// Load post type array
				if ( !isset( $arr_wpwc_post_types[$total->post_type] ) ) {
					
					$post_type_object = get_post_type_object( $total->post_type );
				
					$arr_wpwc_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
					$arr_wpwc_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
					
				}
								
				// Load authors array
				if (!isset($arr_wpwc_authors[$total->post_author])) {
				
					$arr_wpwc_authors[$total->post_author]['display_name'] = get_the_author_meta('display_name', $total->post_author);
					$arr_wpwc_authors[$total->post_author]['total'] = 0;
					
				}
				
				if (!isset($arr_wpwc_authors[$total->post_author][$total->post_type])) {
				
					$arr_wpwc_authors[$total->post_author][$total->post_type]['published']['posts'] = 0;
					$arr_wpwc_authors[$total->post_author][$total->post_type]['published']['word_count'] = 0;
					$arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['posts'] = 0;
					$arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['word_count'] = 0;
				}
				
				if ( $total->post_status == 'publish' ) {
				
					$arr_wpwc_authors[$total->post_author][$total->post_type]['published']['posts'] += $total->posts;
					$arr_wpwc_authors[$total->post_author][$total->post_type]['published']['word_count'] += $total->word_count;
					
				} else {
				
					$arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['posts'] += $total->posts;
					$arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['word_count'] += $total->word_count;
					
				}
			
				$arr_wpwc_authors[$total->post_author]['total'] += $total->word_count;
				
			}
			
		}
		
		// Sort Post Types in a more readable way
		if ( isset( $arr_wpwc_post_types ) ) {
			
			$arr_wpwc_post_types_standard = array();
			$arr_wpwc_post_types_custom = array();
			
			if ( isset( $arr_wpwc_post_types['post'] ) ) { $arr_wpwc_post_types_standard['post'] = $arr_wpwc_post_types['post']; }
			if ( isset( $arr_wpwc_post_types['page'] ) ) { $arr_wpwc_post_types_standard['page'] = $arr_wpwc_post_types['page']; }
			
			foreach ( $arr_wpwc_post_types as $post_type_slug => $post_type ) {
				
				if ( $post_type_slug != 'post' && $post_type_slug != 'page' ) { 
					
					$arr_wpwc_post_types_custom[$post_type_slug] = $post_type; 
					
				}
				
			}
			
			usort($arr_wpwc_post_types_custom, function ($a, $b) { return strcmp($a['plural_name'], $b['plural_name']); });
			$arr_wpwc_post_types = array_merge( $arr_wpwc_post_types_standard, $arr_wpwc_post_types_custom );
		}

	    include_once('partials/wpwc-statistics.php');
	    
	}
	
	/**
	 * Render the upgrade display.
	 *
	 * @since    3.0.0
	 */	
	public function display_upgrade () {
		
		$current_user = wp_get_current_user();
		
	    include_once('partials/wpwc-upgrade.php');
		
	}
	
	/**
	 * Call public save post data function on post save.
	 *
	 * @since    3.0.0
	 * @param    int		$post_id    The ID of the post.
	 * @param    object		$post		The post object.
	 */
	public function post_word_count($post_id, $post) {
		
		wpwc_save_post_data($post);

	}
}