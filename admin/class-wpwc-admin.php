<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin
 * @author     RedLettuce Plugins <support@redlettuce.com>
 * @link       https://wpwordcount.com
 */
class Wp_Word_Count_Admin
{
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
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Check plugin version and run updates if necessary.
     *
     * @since    3.0.0
     */
    public function plugin_check()
    {
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
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpwc-admin.css', [], $this->version, 'all');
        $wp_scripts = wp_scripts();
        wp_enqueue_style(
            'jquery-ui-theme-smoothness',
            sprintf(
                '//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', // working for https as well now
                $wp_scripts->registered['jquery-ui-core']->ver
            )
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    3.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name.'-js', plugin_dir_url(__FILE__) . 'js/wpwc-admin.js', ['jquery', 'jquery-ui-tabs', 'jquery-ui-datepicker'], $this->version, false);
    }

    /**
     * Register the administration menu.
     *
     * @since    3.0.0
     */
    public function menu()
    {
        $icon_svg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkZBMDRCQTQxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkZBMDRCQTUxN0Q2MTFFNzkxNjdFRDUzNUM3OEQ5MTciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGRkEwNEJBMjE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGRkEwNEJBMzE3RDYxMUU3OTE2N0VENTM1Qzc4RDkxNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqUWiFsAAAHiSURBVHjahFO7qhpRFF2OI77xBYrESkREESJaqk3Ab7C59w/iB6TPH+QTImkFsbCxsEipha0g+OCihfhEjTrmrM0ISdDcBWtmOHvvtdaZmWOp1WpfAbwqWvA33hQ/mes/FT/8UzcUv+vq8gWPwYGPilfF9JOez5q67PAcN9PpGbaa6fAMxjsCBgWwXq9xPp+xXC5xOp2w2+1wPB5htVqly2Kx4Ha7SX0+n0v9XtP5kMvlMJ1Okclk5O73+3G5XDAej+FwOOSZfcViEZFIBIPBALPZDHa7HRqdSqUSkskkqtUq0uk0CoUCotEo9vu9OLPH7XajXC4jlUqhUqlIYgrr2+1W1CjAeD6fT4p0d7lcEl/TNEmwWCxENBaLybrUvF4vdF2XeBRjgng8DsMwJG4oFEIwGAT78vk8stkser0eAoEAwuEwNO7jcDiIw2QyQSKRkMHNZgOn0yniTEARj8eDer2Ofr8vwqzpVB6NRmi32xgOh2g0GrJnDjMFYbPZsFqt0Gw25Z3QnfuXr8BGurVaLXHpdruShg73Jqbk3judjgxTkEIicL1eZYH7IShC3Iflb1FJ7qLye5rDhGbyGd6rW1n0/q/hwSn9Ex6exm+KLw8a54oDxV+KfcXog4P247cAAwA4I8oZtVZOgwAAAABJRU5ErkJggg==';

        add_menu_page('WP Word Count', 'Word Count', 'delete_posts', $this->plugin_name, [$this, 'display_statistics'], $icon_svg, 99);
        add_submenu_page($this->plugin_name, 'WP Word Count', __('Statistics', $this->plugin_name), 'delete_posts', $this->plugin_name, [$this, 'display_statistics']);
        add_submenu_page($this->plugin_name, 'WP Word Count - '.__('Reading Time', $this->plugin_name), __('Reading Time', $this->plugin_name), 'delete_posts', $this->plugin_name . '-reading-time', [$this, 'display_reading_time']);
        add_submenu_page($this->plugin_name, 'WP Word Count - '.__('Calculate', $this->plugin_name), __('Calculate', $this->plugin_name), 'delete_posts', $this->plugin_name . '-calculate', [$this, 'display_calculate']);
        add_submenu_page($this->plugin_name, 'WP Word Count - '.__('Upgrade to Pro', $this->plugin_name), __('Upgrade to Pro', $this->plugin_name), 'delete_posts', $this->plugin_name . '-upgrade', [$this, 'display_upgrade']);
    }

    /**
     * Add upgrade action link to the plugins page.
     *
     * @since    3.0.0
     */
    public function upgrade_link($links, $file)
    {
        if (strpos($file, 'wpwordcount.php') !== false) {
            $new_links = [
                'upgrade' => '<a href="'.add_query_arg(['page' => $this->plugin_name.'-upgrade', 'tab' => 'upgrade'], admin_url('admin.php')).'"><strong>'.__('Upgrade to WP Word Count Pro', $this->plugin_name).'</strong></a>',
            ];

            $links = array_merge($links, $new_links);
        }

        return $links;
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    3.0.0
     */
    public function action_links($links)
    {
        $settings_link = ['<a href="'.admin_url('admin.php?page='.$this->plugin_name.'-settings').'">'.__('Settings', $this->plugin_name).'</a>'];

        return array_merge($settings_link, $links);
    }

    /**
    * Register the settings.
    *
    * @since    3.2.0
    */
    public function settings()
    {
        // Reading Time
        add_settings_section('wpwc-section-reading-time', __('Reading Time', $this->plugin_name), [$this, 'settings_section_reading_time'], 'wpwc-reading-time');
        add_settings_field('wpwc_reading_time_wpm', __('Words Per Minute', $this->plugin_name), [$this, 'settings_reading_time_wpm'], 'wpwc-reading-time', 'wpwc-section-reading-time');
        add_settings_field('wpwc_reading_time_insert', __('Insert before post content?', $this->plugin_name), [$this, 'settings_reading_time_insert'], 'wpwc-reading-time', 'wpwc-section-reading-time');
        add_settings_field('wpwc_reading_time_label_before', __('Before Label', $this->plugin_name), [$this, 'settings_reading_time_label_before'], 'wpwc-reading-time', 'wpwc-section-reading-time');
        add_settings_field('wpwc_reading_time_label_after', __('After Label', $this->plugin_name), [$this, 'settings_reading_time_label_after'], 'wpwc-reading-time', 'wpwc-section-reading-time');
        register_setting('wpwc-section-reading-time', 'wpwc_reading_time');
    }

    /**
    * Display Reading Time Settings Section.
    *
    * @since    3.2.0
    */
    public function settings_section_reading_time()
    {
        echo '<p>'.__('Define how many words per minute to use in Reading Time statistics and set labels for displaying Reading Time statistics inside of your posts.', $this->plugin_name).'</p>';
    }

    /**
    * Display Reading Time Settings Words Per Minute Text Box.
    *
    * @since    3.2.0
    */
    public function settings_reading_time_wpm()
    {
        $reading_time_wpm = (get_option('wpwc_reading_time')['wpm'] ?: 250);

        echo '<input id="wpwc_reading_time_wpm" name="wpwc_reading_time[wpm]" type="number" min="1" class="small-text" value="'.$reading_time_wpm.'" />';
    }

    /**
    * Display Reading Time Settings Before Label.
    *
    * @since    3.2.0
    */
    public function settings_reading_time_insert()
    {
        $reading_time_insert = (get_option('wpwc_reading_time')['insert'] ?: 'N');

        echo '<input onclick="this.value=\'Y\';" type="checkbox" name="wpwc_reading_time[insert]" value="'.$reading_time_insert.'" '.($reading_time_insert == 'Y' ? ' checked="checked"' : '').' />';
    }

    /**
    * Display Reading Time Settings Before Label.
    *
    * @since    3.2.0
    */
    public function settings_reading_time_label_before()
    {
        $reading_time_label_before = (get_option('wpwc_reading_time')['labels']['before'] ?: '');

        echo '<input id="wpwc_reading_time_label_before" name="wpwc_reading_time[labels][before]" type="text" class="text" value="'.$reading_time_label_before.'" />';
        echo '<p><small>'.__('This text will appear before the reading time is inserted into your posts.', $this->plugin_name).'</small></p>';
    }

    /**
    * Display Reading Time Settings After Label.
    *
    * @since    3.2.0
    */
    public function settings_reading_time_label_after()
    {
        $reading_time_label_after = (get_option('wpwc_reading_time')['labels']['after'] ?: '');

        echo '<input id="wpwc_reading_time_label_after" name="wpwc_reading_time[labels][after]" type="text" class="text" value="'.$reading_time_label_after.'" />';
        echo '<p><small>'.__('This text will appear after the reading time is inserted into your posts.', $this->plugin_name).'</small></p>';
    }

    /**
     * Render the calculate display.
     *
     * @since    3.0.0
     */
    public function display_calculate()
    {
        include_once 'partials/wpwc-calculate.php';
    }

    /**
     * Calculate statistics
     *
     * @since    3.0.0
     */
    public function calculate_statistics()
    {
        global $wpdb;

        $table_name_posts = $wpdb->prefix.'posts';
        $sql_wpwc_process = '';

        parse_str($_POST['form'], $parameters);
        if ($parameters['wpwc_calculation_type'] == 'all') {
            unset($parameters['wpwc_date_range_start'], $parameters['wpwc_date_range_end'], $parameters['wpwc_date_range_start_formatted'], $parameters['wpwc_date_range_end_formatted'], $parameters['wpwc_delete_data']);
        }

        $sql_post_total = "SELECT COUNT(ID) AS post_total FROM $table_name_posts WHERE 1 ";

        $post_types = get_post_types('', 'names');
        unset($post_types['attachment'], $post_types['nav_menu_item'], $post_types['custom_css'], $post_types['revision'], $post_types['customize_changeset']);

        // Post Types
        if (isset($post_types) && count($post_types) > 0) {
            $sql_post_total .= 'AND (';

            foreach ($post_types as $post_type) {
                $sql_post_total .= "$table_name_posts.post_type = '".$post_type."' OR ";
            }
            $sql_post_total = substr($sql_post_total, 0, -4);

            $sql_post_total .= ') ';
        }

        // Date Range
        if (isset($parameters['wpwc_date_range_start_formatted']) && strlen($parameters['wpwc_date_range_start_formatted']) == 10) {
            $sql_post_total .= "AND $table_name_posts.post_date >= '".$parameters['wpwc_date_range_start_formatted']." 00:00:00' ";
        }

        if (isset($parameters['wpwc_date_range_end_formatted']) && strlen($parameters['wpwc_date_range_end_formatted']) == 10) {
            $sql_post_total .= "AND $table_name_posts.post_date <= '".$parameters['wpwc_date_range_end_formatted']." 23:59:59' ";
        }

        $wpwc_post_total = $wpdb->get_results($sql_post_total);

        $step = absint($_POST['step']);

        $ret = $this->process_step($step, $_POST);

        $percentage = 0;

        $post_types = get_post_types('', 'names');
        $post_statuses = get_post_stati('', 'names');
        $posts_count = 0 + $wpwc_post_total[0]->post_total;

        if ($ret) {
            $step += 1;
            $percentage = (($step - 1) * 50 / $posts_count * 100);
            if ($percentage > 100) {
                $percentage = 100;
            }

            echo json_encode(['step' => $step, 'percentage' => $percentage]);

            exit;
        } else {
            $args = array_merge($_REQUEST, [
                'step' => $step,
                'nonce' => wp_create_nonce('wpwc_calculate_nonce'),
            ]);

            $link_message = add_query_arg(['page' => $this->plugin_name], admin_url('admin.php'));
            $message = sprintf(wp_kses(__('Word counts calculated successfully. Visit the <a href="%s">statistics page</a> to view.', $this->plugin_name), ['a' => ['href' => []]]), esc_url($link_message));

            echo json_encode(['step' => 'done', 'message' => $message]);

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
    public function process_step($step, $data)
    {
        global $wpdb;

        $table_name_wpwc_posts = $wpdb->prefix.'wpwc_posts';
        $sql_wpwc_process = '';

        parse_str($data['form'], $parameters);
        if ($parameters['wpwc_calculation_type'] == 'all') {
            unset($parameters['wpwc_date_range_start'], $parameters['wpwc_date_range_end'], $parameters['wpwc_date_range_start_formatted'], $parameters['wpwc_date_range_end_formatted'], $parameters['wpwc_delete_data']);
        }

        // Date Range
        if (isset($parameters['wpwc_date_range_start_formatted']) && strlen($parameters['wpwc_date_range_start_formatted']) == 10) {
            $sql_wpwc_process .= "AND $table_name_wpwc_posts.post_date >= '".$parameters['wpwc_date_range_start_formatted']." 00:00:00' ";
        }

        if (isset($parameters['wpwc_date_range_end_formatted']) && strlen($parameters['wpwc_date_range_end_formatted']) == 10) {
            $sql_wpwc_process .= "AND $table_name_wpwc_posts.post_date <= '".$parameters['wpwc_date_range_end_formatted']." 23:59:59' ";
        }

        if ($step == 1) {
            $wpdb->query("DELETE FROM $table_name_wpwc_posts WHERE 1 ".(!isset($parameters['wpwc_delete_data']) ? $sql_wpwc_process : ''));
            wpwc_create_posts_table();
        }

        $post_types = get_post_types('', 'names');
        unset($post_types['attachment'], $post_types['nav_menu_item'], $post_types['custom_css'], $post_types['revision'], $post_types['customize_changeset']);

        $args = [
            'post_type' => $post_types,
            'orderby' => 'post_date',
            'order' => 'ASC',
            'posts_per_page' => 50,
        ];

        // Date Range
        if (isset($parameters['wpwc_date_range_start_formatted']) && strlen($parameters['wpwc_date_range_start_formatted']) == 10) {
            $args['date_query']['after'] = ['year' => substr($parameters['wpwc_date_range_start_formatted'], 0, 4), 'month' => substr($parameters['wpwc_date_range_start_formatted'], 5, 2), 'day' => substr($parameters['wpwc_date_range_start_formatted'], -2)];
        }

        if (isset($parameters['wpwc_date_range_end_formatted']) && strlen($parameters['wpwc_date_range_end_formatted']) == 10) {
            $args['date_query']['before'] = ['year' => substr($parameters['wpwc_date_range_end_formatted'], 0, 4), 'month' => substr($parameters['wpwc_date_range_end_formatted'], 5, 2), 'day' => substr($parameters['wpwc_date_range_end_formatted'], -2)];
        }

        if ($step > 1) {
            $args['offset'] = 50 * ($step - 1);
        }

        $wpwc_posts = new WP_Query($args);

        if ($wpwc_posts->have_posts()) {
            foreach ($wpwc_posts->posts as $post) {
                if ($post->post_author != 0) {
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
    public function display_statistics_totals()
    {
        global $wpdb;

        $totals = [];

        $table_name_posts = $wpdb->prefix.'wpwc_posts';

        $reading_time_wpm = (get_option('wpwc_reading_time')['wpm'] ?: 250);

        $sql_wpwc_totals = "
			SELECT post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
			FROM $table_name_posts 
			WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
			GROUP BY post_type, post_status 
			ORDER BY word_count DESC";
        $wpwc_totals = $wpdb->get_results($sql_wpwc_totals);

        foreach ($wpwc_totals as $total) {
            if (!isset($totals[$total->post_type])) {
                $post_type_object = get_post_type_object($total->post_type);

                $totals[$total->post_type]['name'] = $post_type_object->labels->name;
                $totals[$total->post_type]['published']['posts'] = 0;
                $totals[$total->post_type]['published']['word_count'] = 0;
                $totals[$total->post_type]['unpublished']['posts'] = 0;
                $totals[$total->post_type]['unpublished']['word_count'] = 0;
            }

            if ($total->post_status == 'publish') {
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
    public function display_statistics()
    {
        global $wpdb;

        $table_name_posts = $wpdb->prefix.'wpwc_posts';

        $reading_time_wpm = (get_option('wpwc_reading_time')['wpm'] ?: 250);

        $wpwc_totals = $this->display_statistics_totals();

        $wpwc_tab = 'top-content';

        if (isset($_GET['tab'])) {
            $wpwc_tab = $_GET['tab'];
        }

        if (!isset($wpwc_tab) || $wpwc_tab == 'top-content') {
            $sql_wpwc_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				ORDER BY post_word_count DESC, post_date DESC 
				LIMIT 10";
        } elseif ($wpwc_tab == 'all-content') {
            $sql_wpwc_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				ORDER BY post_word_count DESC, post_date DESC";
        } elseif ($wpwc_tab == 'monthly-statistics') {
            $sql_wpwc_statistics = "
				SELECT MID(post_date, 1, 7) AS post_date, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				GROUP BY MID(post_date, 1, 7), post_type, post_status 
                ORDER BY post_date DESC";
        } elseif ($wpwc_tab == 'author-statistics') {
            $sql_wpwc_statistics = "
				SELECT post_author, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count 
				FROM $table_name_posts 
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') 
				GROUP BY post_author, post_type, post_status 
				ORDER BY post_author ASC";
        }

        $wpwc_statistics = $wpdb->get_results($sql_wpwc_statistics);

        if (!isset($wpwc_tab) || $wpwc_tab == 'top-content' || $wpwc_tab == 'all-content') {
            $arr_wpwc_posts = [];
            $arr_wpwc_post_types = [];

            foreach ($wpwc_statistics as $wpwc_post) {
                // Load post type array
                if (!isset($arr_wpwc_post_types[$wpwc_post->post_type])) {
                    $post_type_object = get_post_type_object($wpwc_post->post_type);

                    $arr_wpwc_post_types[$wpwc_post->post_type]['plural_name'] = $post_type_object->labels->name;
                    $arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                // Load authors array
                if (!isset($arr_wpwc_authors[$wpwc_post->post_author])) {
                    $arr_wpwc_authors[$wpwc_post->post_author]['display_name'] = get_the_author_meta('display_name', $wpwc_post->post_author);
                }

                $arr_wpwc_post = [
                    'post_id' => $wpwc_post->post_id,
                    'post_title' => get_the_title($wpwc_post->post_id),
                    'post_status' => ucwords($wpwc_post->post_status),
                    'post_type' => $arr_wpwc_post_types[$wpwc_post->post_type]['singular_name'],
                    'post_author' => $arr_wpwc_authors[$wpwc_post->post_author]['display_name'],
                    'post_author_id' => $wpwc_post->post_author,
                    'post_word_count' => $wpwc_post->post_word_count,
                    'permalink' => get_permalink($wpwc_post->post_id),
                ];

                $arr_wpwc_posts[] = $arr_wpwc_post;
            }
        } elseif ($wpwc_tab == 'monthly-statistics') {
            $arr_wpwc_months = [];

            foreach ($wpwc_statistics as $total) {
                // Load post type array
                if (!isset($arr_wpwc_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

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

                if ($total->post_status == 'publish') {
                    $arr_wpwc_months[$total->post_date][$total->post_type]['published']['posts'] += $total->posts;
                    $arr_wpwc_months[$total->post_date][$total->post_type]['published']['word_count'] += $total->word_count;
                } else {
                    $arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['posts'] += $total->posts;
                    $arr_wpwc_months[$total->post_date][$total->post_type]['unpublished']['word_count'] += $total->word_count;
                }

                $arr_wpwc_months[$total->post_date]['total'] += $total->word_count;
            }
        } elseif ($wpwc_tab == 'author-statistics') {
            $arr_wpwc_authors = [];
            $arr_wpwc_post_types = [];

            foreach ($wpwc_statistics as $total) {
                // Load post type array
                if (!isset($arr_wpwc_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

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

                if ($total->post_status == 'publish') {
                    $arr_wpwc_authors[$total->post_author][$total->post_type]['published']['posts'] += $total->posts;
                    $arr_wpwc_authors[$total->post_author][$total->post_type]['published']['word_count'] += $total->word_count;
                } else {
                    $arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['posts'] += $total->posts;
                    $arr_wpwc_authors[$total->post_author][$total->post_type]['unpublished']['word_count'] += $total->word_count;
                }

                $arr_wpwc_authors[$total->post_author]['total'] += $total->word_count;
            }

            // Sort authors array by total
            uasort($arr_wpwc_authors, function ($a, $b) { return $b['total'] - $a['total']; });
        }

        // Sort Post Types in a more readable way
        if (isset($arr_wpwc_post_types)) {
            $arr_wpwc_post_types_standard = [];
            $arr_wpwc_post_types_custom = [];

            if (isset($arr_wpwc_post_types['post'])) {
                $arr_wpwc_post_types_standard['post'] = $arr_wpwc_post_types['post'];
            }
            if (isset($arr_wpwc_post_types['page'])) {
                $arr_wpwc_post_types_standard['page'] = $arr_wpwc_post_types['page'];
            }

            foreach ($arr_wpwc_post_types as $post_type_slug => $post_type) {
                if ($post_type_slug != 'post' && $post_type_slug != 'page') {
                    $arr_wpwc_post_types_custom[$post_type_slug] = $post_type;
                }
            }

            uasort($arr_wpwc_post_types_custom, function ($a, $b) { return strcmp($a['plural_name'], $b['plural_name']); });
            $arr_wpwc_post_types = array_merge($arr_wpwc_post_types_standard, $arr_wpwc_post_types_custom);
        }

        include_once 'partials/wpwc-statistics.php';
    }

    /**
     * Render the upgrade display.
     *
     * @since    3.0.0
     */
    public function display_upgrade()
    {
        $current_user = wp_get_current_user();

        include_once 'partials/wpwc-upgrade.php';
    }

    /**
     * Render the reading time display.
     *
     * @since    3.2.0
     */
    public function display_reading_time()
    {
        include_once 'partials/wpwc-reading-time.php';
    }

    /**
     * Call public save post data function on post save.
     *
     * @since    3.0.0
     * @param    int		$post_id    The ID of the post.
     * @param    object		$post		The post object.
     */
    public function post_word_count($post_id, $post)
    {
        wpwc_save_post_data($post);
    }
}
