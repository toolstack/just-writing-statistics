<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin
 * @author     GregRoss, RedLettuce
 * @link       https://toolstack.com/just-writing-statistics
 */
class Just_Writing_Statsitics_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since  3.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  3.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    private $allowed_tabs = array(
                                    'top-content' => '',
                                    'all-content' => '',
                                    'monthly-statistics' => '',
                                    'yearly-statistics' => '',
                                    'tag-statistics' => '',
                                    'category-statistics' => '',
                                    'author-statistics' => '',
                                    'settings' => '',
                                    'about' => '',
                                );

    private $mandatory_excluded_types = array(
                                                'attachment',
                                                'nav_menu_item',
                                                'wp_navigation',
                                                'custom_css',
                                                'revision',
                                                'customize_changeset',
                                                'oembed_cache',
                                                'user_request',
                                            );


    /**
     * Initialize the class and set its properties.
     *
     * @since 3.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Check plugin version and run updates if necessary.
     *
     * @since 3.0.0
     */
    public function plugin_check()
    {
        $jws_installed_version = get_option('jws_version');

        if ($jws_installed_version != JWS_VERSION) {
            jws_set_plugin_version(JWS_VERSION);
        }
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 3.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/jws-admin.css', [], $this->version, 'all');
        wp_enqueue_style('jquery-ui-theme-smoothness', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 3.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name.'-js', plugin_dir_url(__FILE__) . 'js/jws-admin.js', ['jquery', 'jquery-ui-tabs', 'jquery-ui-datepicker'], $this->version, false);
        wp_enqueue_script('jws-chart', plugin_dir_url(__FILE__) . 'js/chart.js', [], '4.1.1', false);
    }

    /**
     * Register the administration menu.
     *
     * @since 3.0.0
     */
    public function menu()
    {
        $roles = get_option('jws_roles');
        $user = wp_get_current_user();

        // Don't check for permissions if no option has been set (=== false) or the user is an administrator
        if( $roles !== false && !in_array( 'administrator', $user->roles ) ) {
            $blocked = false;
            $allowed = false;

            // If the roles setting is empty (lose comparison), make sure it's an empty array.
            if( $roles == false ) { $roles = array(); }

            foreach( $user->roles as $slug ) {
                if( ! array_key_exists( $slug, $roles ) ) {
                    $blocked = true;
                } else {
                    $allowed = true;
                }
            }

            // Users can have multiple roles, so if some are blocked but other are allowed,
            // have the allowed override the blocked.
            if( $blocked && !$allowed ) { return; }
        }

        add_menu_page('Just Writing Statistics', __('Writing Statistics', 'just-writing-statistics'), 'delete_posts', $this->plugin_name, [$this, 'display_statistics'], 'dashicons-editor-paste-word', 99);
        add_submenu_page($this->plugin_name, 'Just Writing Statistics', __('Statistics', 'just-writing-statistics'), 'delete_posts', $this->plugin_name, [$this, 'display_statistics']);
        add_submenu_page($this->plugin_name, 'Just Writing Statistics - '.__('Settings', 'just-writing-statistics'), __('Settings', 'just-writing-statistics'), 'delete_posts', $this->plugin_name . '-settings', [$this, 'display_settings']);
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since 3.0.0
     */
    public function action_links($links)
    {
        $settings_link = ['<a href="'.admin_url('admin.php?page='.$this->plugin_name.'-settings').'">'.__('Settings', 'just-writing-statistics').'</a>'];

        return array_merge($settings_link, $links);
    }

    /**
     * Register the settings.
     *
     * @since 3.2.0
     */
    public function settings()
    {
        // Admin Options
        add_settings_section('jws-section-admin-options', __('Administrative Options', 'just-writing-statistics'), [$this, 'settings_section_admin_options'], 'jws-admin-options');
        add_settings_field('jws_disable_admin_column', __('Disable admin column for word count', 'just-writing-statistics'), [$this, 'settings_disable_admin_column'], 'jws-admin-options', 'jws-section-admin-options');
        register_setting('jws-section-admin-options', 'jws_admin_options');

        // Reading Time
        add_settings_section('jws-section-reading-time', __('Reading Time', 'just-writing-statistics'), [$this, 'settings_section_reading_time'], 'jws-reading-time');
        add_settings_field('jws_reading_time_wpm', __('Words Per Minute', 'just-writing-statistics'), [$this, 'settings_reading_time_wpm'], 'jws-reading-time', 'jws-section-reading-time');
        add_settings_field('jws_reading_time_insert', __('Add to top of post content?', 'just-writing-statistics'), [$this, 'settings_reading_time_insert'], 'jws-reading-time', 'jws-section-reading-time');
        add_settings_field('jws_reading_time_label_before', __('Before Label', 'just-writing-statistics'), [$this, 'settings_reading_time_label_before'], 'jws-reading-time', 'jws-section-reading-time');
        add_settings_field('jws_reading_time_label_after', __('After Label', 'just-writing-statistics'), [$this, 'settings_reading_time_label_after'], 'jws-reading-time', 'jws-section-reading-time');
        register_setting('jws-section-reading-time', 'jws_reading_time');

        // Excluded Types
        add_settings_section('jws-section-excluded-types', __('Excluded Post Types', 'just-writing-statistics'), [$this, 'settings_section_excluded_types'], 'jws-excluded-types');

        $post_types = get_post_types('', 'names');
        foreach( $this->mandatory_excluded_types as $type )
        {
            unset($post_types[$type]);
        }

        $excluded_types = get_option('jws_excluded_types');

        if( ! is_array( $excluded_types ) ) { $excluded_types = array(); }

        foreach( $post_types as $type )
        {
            $checked = false;
            $post_type_obj = get_post_type_object( $type );

            $checked = array_key_exists( $type, $excluded_types );

            add_settings_field('jws_excluded_type_' . $type, $post_type_obj->labels->singular_name, [$this, 'settings_excluded_type_by_name'], 'jws-excluded-types', 'jws-section-excluded-types', array( 'type' => $type, 'checked' => $checked ) );
        }

        register_setting('jws-section-excluded-types', 'jws_excluded_types');

        // Enabled Roles
        add_settings_section('jws-section-roles', __('User Roles To Enable', 'just-writing-statistics'), [$this, 'settings_section_roles'], 'jws-roles');

        $role_types = wp_roles();
        $roles = get_option('jws_roles');

        if( $roles === false ) {
            foreach( $role_types->roles as $role_slug ) {
                $roles[$role_slug] = 'on';
            }
        }

        if( $roles == false ) {
            $roles = array();
        }

        unset( $roles['administrator'] );

        foreach( $role_types->roles as $role_slug => $role_type ) {
            // Don't include any role that doesn't have the delete_posts capability.
            $min_pemissions = array_key_exists( 'delete_posts', $role_type['capabilities'] ) && $role_type['capabilities']['delete_posts'] == true;

            if( $role_slug != 'administrator' && $min_pemissions) {
                $checked = true;
                if( ! array_key_exists( $role_slug, $roles ) ) { $checked = false; }

                add_settings_field('jws_roles_' . $role_slug, $role_type['name'], [$this, 'settings_roles_by_name'], 'jws-roles', 'jws-section-roles', array( 'type' => $role_slug, 'checked' => $checked ) );
            }
        }

        register_setting('jws-section-roles', 'jws_roles');

    }

    public function display_settings()
    {
        include_once 'partials/jws-settings.php';
    }

    /**
     * Display Admin Options Settings Section.
     *
     * @since 3.2.0
     */
    public function settings_section_admin_options()
    {
        return;
    }

    /**
     * Display Reading Time Settings Section.
     *
     * @since 3.2.0
     */
    public function settings_section_reading_time()
    {
        echo '<p>'.__('Define how many words per minute to use in Reading Time statistics and set labels for displaying Reading Time statistics inside of your posts.', 'just-writing-statistics').'</p>';
    }

    /**
     * Display Excluded Types Settings Section.
     *
     * @since 3.2.0
     */
    public function settings_section_excluded_types()
    {
        echo '<p>'.__('Select which post types to be excluded from the statistics.  Note that not all of the types below may show up in your statistics if they do not have any content associated with them.', 'just-writing-statistics').'</p>';
    }

    /**
     * Display Excluded Types Settings Section.
     *
     * @since 3.2.0
     */
    public function settings_section_roles()
    {
        echo '<p>'.__('Select which user to enable the display of the statistics pages for.</p><p>Administrators are always enabled and roles that do not have the <code>delete_posts</code> capability are not shown the statistics page and excluded from the below list.', 'just-writing-statistics').'</p>';
    }

    /**
     * Display Admin Options Settings Words Disable Admin Column.
     *
     * @since 4.1.0
     */
    public function settings_disable_admin_column()
    {
        $admin_options = get_option('jws_admin_options');
        $disable_admin_column = false;

        if( is_array( $admin_options ) && array_key_exists('disable_admin_column', $admin_options ) ) {
            $disable_admin_column = true;
        }

        echo '<label class="jws-switch">' . PHP_EOL;
        echo '<input type="checkbox" name="jws_admin_options[disable_admin_column]" id="jws_disable_admin_column"' . checked( $disable_admin_column, true, false ) . '>' . PHP_EOL;
        echo '<span class="jws-slider jws-round"></span>' . PHP_EOL;
        echo '</label>' . PHP_EOL;
    }

    /**
     * Display Reading Time Settings Words Per Minute Text Box.
     *
     * @since 3.2.0
     */
    public function settings_reading_time_wpm()
    {
        $reading_time_options = get_option('jws_reading_time');

        $reading_time_wpm = 250;

        if(is_array($reading_time_options) && array_key_exists('wpm', $reading_time_options) ) {
            $reading_time_wpm = (get_option('jws_reading_time')['wpm'] ?: 250);

        }

        echo '<input id="jws_reading_time_wpm" name="jws_reading_time[wpm]" type="number" min="1" class="small-text" value="'.$reading_time_wpm.'" />';
    }

    public function settings_excluded_type_by_name( $args )
    {
        //$args['type'];

        echo '<label class="jws-switch">' . PHP_EOL;
        echo '<input type="checkbox" name="jws_excluded_types[' . esc_attr( $args['type'] ) . ']" id="jws_excluded_types[' . esc_attr( $args['type'] ) . ']"' . checked( $args['checked'], true, false ) . '>' . PHP_EOL;
        echo '<span class="jws-slider jws-round"></span>' . PHP_EOL;
        echo '</label>' . PHP_EOL;

    }

    public function settings_roles_by_name( $args )
    {
        //$args['type'];

        echo '<label class="jws-switch">' . PHP_EOL;
        echo '<input type="checkbox" name="jws_roles[' . esc_attr( $args['type'] ) . ']" id="jws_roles[' . esc_attr( $args['type'] ) . ']"' . checked( $args['checked'], true, false ) . '>' . PHP_EOL;
        echo '<span class="jws-slider jws-round"></span>' . PHP_EOL;
        echo '</label>' . PHP_EOL;

    }

    /**
     * Display Reading Time Settings Before Label.
     *
     * @since 3.2.0
     */
    public function settings_reading_time_insert()
    {
        $reading_time_options = get_option('jws_reading_time');

        $reading_time_insert = 'N';

        if(is_array($reading_time_options) && array_key_exists('insert', $reading_time_options) ) {
            $reading_time_insert = (get_option('jws_reading_time')['insert'] ?: 'N');
        }

        echo '<label class="jws-switch">' . PHP_EOL;
        echo '<input onclick="this.value=\'Y\';" type="checkbox" name="jws_reading_time[insert]" id="jws_reading_time[insert]"' . checked( $reading_time_insert, 'Y', false ) . '>' . PHP_EOL;
        echo '<span class="jws-slider jws-round"></span>' . PHP_EOL;
        echo '</label>' . PHP_EOL;
    }

    /**
     * Display Reading Time Settings Before Label.
     *
     * @since 3.2.0
     */
    public function settings_reading_time_label_before()
    {
        $reading_time_options = get_option('jws_reading_time');

        $reading_time_label_before = '';

        if(is_array($reading_time_options) && array_key_exists('labels', $reading_time_options) ) {
            if(is_array($reading_time_options['labels']) && array_key_exists('before', $reading_time_options['labels']) ) {
                $reading_time_label_before = (get_option('jws_reading_time')['labels']['before'] ?: '');
            }
        }

        echo '<input id="jws_reading_time_label_before" name="jws_reading_time[labels][before]" type="text" class="text" value="'.esc_attr($reading_time_label_before).'" />';
        echo '<p><small>'.__('This text will appear before the reading time is inserted into your posts.', 'just-writing-statistics').'</small></p>';
    }

    /**
     * Display Reading Time Settings After Label.
     *
     * @since 3.2.0
     */
    public function settings_reading_time_label_after()
    {
        $reading_time_options = get_option('jws_reading_time');

        $reading_time_label_after = '';

        if(is_array($reading_time_options) && array_key_exists('labels', $reading_time_options) ) {
            if(is_array($reading_time_options['labels']) && array_key_exists('after', $reading_time_options['labels']) ) {
                $reading_time_label_after = (get_option('jws_reading_time')['labels']['after'] ?: '');
            }
        }

        echo '<input id="jws_reading_time_label_after" name="jws_reading_time[labels][after]" type="text" class="text" value="'.esc_attr($reading_time_label_after).'" />';
        echo '<p><small>'.__('This text will appear after the reading time is inserted into your posts.', 'just-writing-statistics').'</small></p>';
    }

    /**
     * Render the calculate display.
     *
     * @since 3.0.0
     */
    public function display_calculate()
    {
        include_once 'partials/jws-calculate.php';
    }

    /**
     * Calculate statistics
     *
     * @since 3.0.0
     */
    public function calculate_statistics()
    {
        global $wpdb;

        $table_name_posts = $wpdb->prefix.'posts';
        $sql_jws_process = '';

        parse_str($_POST['form'], $parameters);
        if ($parameters['jws_calculation_type'] == 'all') {
            unset($parameters['jws_date_range_start'], $parameters['jws_date_range_end'], $parameters['jws_date_range_start_formatted'], $parameters['jws_date_range_end_formatted'], $parameters['jws_delete_data']);
        }

        $sql_post_total = "SELECT COUNT(ID) AS post_total FROM $table_name_posts WHERE 1";

        $post_types = get_post_types('', 'names');
        unset($post_types['attachment'], $post_types['nav_menu_item'], $post_types['custom_css'], $post_types['revision'], $post_types['customize_changeset']);

        // Post Types
        if (isset($post_types) && count($post_types) > 0) {
            $sql_post_total .= ' AND (';

            foreach ($post_types as $post_type) {
                $sql_post_total .= "$table_name_posts.post_type = '".$post_type."' OR ";
            }
            $sql_post_total = substr($sql_post_total, 0, -4);

            $sql_post_total .= ')';
        }

        // Date Range
        if (isset($parameters['jws_date_range_start_formatted']) && strlen($parameters['jws_date_range_start_formatted']) == 10) {
            $sql_post_total .= " AND $table_name_posts.post_date >= '".$parameters['jws_date_range_start_formatted']." 00:00:00'";
        }

        if (isset($parameters['jws_date_range_end_formatted']) && strlen($parameters['jws_date_range_end_formatted']) == 10) {
            $sql_post_total .= " AND $table_name_posts.post_date <= '".$parameters['jws_date_range_end_formatted']." 23:59:59'";
        }

        $jws_post_total = $wpdb->get_results($sql_post_total);

        $step = absint($_POST['step']);

        $ret = $this->process_step($step, $_POST);

        $percentage = 0;

        $post_types = get_post_types('', 'names');
        $post_statuses = get_post_stati('', 'names');
        $posts_count = 0 + $jws_post_total[0]->post_total;

        // Make sure we don't divide by 0 later on.
        if( $posts_count == 0 ) { $posts_count = 1; }

        if ($ret) {
            $percentage = floor($step * 50 / $posts_count * 100);
            if ($percentage > 100) {
                $percentage = 100;
            }

            $step += 1;

            echo json_encode(['step' => $step, 'percentage' => $percentage]);

            exit;
        } else {
            $args = array_merge(
                $_REQUEST, [
                'step' => $step,
                'nonce' => wp_create_nonce('jws_calculate_nonce'),
                ]
            );
            $link_message = add_query_arg(['page' => $this->plugin_name], admin_url('admin.php'));
            $message = sprintf(wp_kses(__('Word counts calculated successfully. Visit the <a href="%s">statistics page</a> to view.', 'just-writing-statistics'), ['a' => ['href' => []]]), esc_url($link_message));

            echo json_encode(['step' => 'done', 'message' => $message]);

            update_option( 'jws_stats_calculated', true );

            exit;
        }

        wp_die();
    }

    /**
     * Process calculation step
     *
     * @since  3.0.0
     * @return bool
     */
    public function process_step($step, $data)
    {
        global $wpdb;

        $table_name_jws_posts = $wpdb->prefix.'jws_posts';
        $sql_jws_process = '';

        parse_str($data['form'], $parameters);
        if ($parameters['jws_calculation_type'] == 'all') {
            unset($parameters['jws_date_range_start'], $parameters['jws_date_range_end'], $parameters['jws_date_range_start_formatted'], $parameters['jws_date_range_end_formatted'], $parameters['jws_delete_data']);
        }

        // Date Range
        if (isset($parameters['jws_date_range_start_formatted']) && strlen($parameters['jws_date_range_start_formatted']) == 10) {
            $sql_jws_process .= "AND $table_name_jws_posts.post_date >= '".$parameters['jws_date_range_start_formatted']." 00:00:00' ";
        }

        if (isset($parameters['jws_date_range_end_formatted']) && strlen($parameters['jws_date_range_end_formatted']) == 10) {
            $sql_jws_process .= "AND $table_name_jws_posts.post_date <= '".$parameters['jws_date_range_end_formatted']." 23:59:59' ";
        }

        if ($step == 1) {
            $wpdb->query("DELETE FROM $table_name_jws_posts WHERE 1 ".(!isset($parameters['jws_delete_data']) ? $sql_jws_process : ''));
            jws_create_posts_table();
        }

        $post_types = get_post_types('', 'names');
        foreach( $this->mandatory_excluded_types as $type )
        {
            unset($post_types[$type]);
        }

        $args = [
            'post_type' => $post_types,
            'orderby' => 'post_date',
            'order' => 'ASC',
            'posts_per_page' => 50,
        ];

        // Date Range
        if (isset($parameters['jws_date_range_start_formatted']) && strlen($parameters['jws_date_range_start_formatted']) == 10) {
            $args['date_query']['after'] = ['year' => substr($parameters['jws_date_range_start_formatted'], 0, 4), 'month' => substr($parameters['jws_date_range_start_formatted'], 5, 2), 'day' => substr($parameters['jws_date_range_start_formatted'], -2)];
        }

        if (isset($parameters['jws_date_range_end_formatted']) && strlen($parameters['jws_date_range_end_formatted']) == 10) {
            $args['date_query']['before'] = ['year' => substr($parameters['jws_date_range_end_formatted'], 0, 4), 'month' => substr($parameters['jws_date_range_end_formatted'], 5, 2), 'day' => substr($parameters['jws_date_range_end_formatted'], -2)];
        }

        if ($step > 1) {
            $args['offset'] = 50 * ($step - 1);
        }

        $jws_posts = new WP_Query($args);

        if ($jws_posts->have_posts()) {
            foreach ($jws_posts->posts as $post) {
                if ($post->post_author != 0) {
                    jws_save_post_data($post);
                }
            }

           return true;
        } else {
            return false;
        }
    }

    /***************************************
     * STATISTICS
     ***************************************/

    /**
     * Calculate total word counts by post type.
     *
     * @since 3.0.0
     */
    public function display_statistics_totals()
    {
        global $wpdb;

        $totals = [];

        $table_name_posts = $wpdb->prefix.'jws_posts';

        $reading_time_options = get_option('jws_reading_time');

        $reading_time_wpm = 250;

        if(is_array($reading_time_options) && array_key_exists('wpm', $reading_time_options) ) {
            $reading_time_wpm = (get_option('jws_reading_time')['wpm'] ?: 250);
        }

        $excluded_types = $this->get_excluded_post_types();

        $excluded_types_sql = '';

        if( count( $excluded_types ) > 0 ) {
            $excluded_types_sql .= 'AND post_type NOT IN (\'';

            foreach( $excluded_types as $type ) {
                $excluded_types_sql .= '%s\', \'';
            }

            $excluded_types_sql = trim( $excluded_types_sql, '\', ' );

            $excluded_types_sql .= '\')';
        }

        $sql_jws_totals = "
			SELECT post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count
			FROM $table_name_posts
			WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
			GROUP BY post_type, post_status
			ORDER BY word_count DESC";

        $sql_jws_totals = $wpdb->prepare( $sql_jws_totals, $excluded_types );

        $jws_totals = $wpdb->get_results($sql_jws_totals);

        foreach ($jws_totals as $total) {
            if (!isset($totals[$total->post_type])) {
                $post_type_object = get_post_type_object($total->post_type);

                $totals[$total->post_type]['name'] = $post_type_object->labels->name;
                $totals[$total->post_type]['published']['posts'] = 0;
                $totals[$total->post_type]['published']['word_count'] = 0;
                $totals[$total->post_type]['scheduled']['posts'] = 0;
                $totals[$total->post_type]['scheduled']['word_count'] = 0;
                $totals[$total->post_type]['unpublished']['posts'] = 0;
                $totals[$total->post_type]['unpublished']['word_count'] = 0;
            }

            if ($total->post_status == 'publish') {
                $totals[$total->post_type]['published']['posts'] += $total->posts;
                $totals[$total->post_type]['published']['word_count'] += $total->word_count;
            } else if ($total->post_status == 'future') {
                $totals[$total->post_type]['scheduled']['posts'] += $total->posts;
                $totals[$total->post_type]['scheduled']['word_count'] += $total->word_count;
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
     * @since 3.0.0
     */
    public function display_statistics()
    {
        global $wpdb;

        $table_name_posts = $wpdb->prefix.'jws_posts';

        $reading_time_options = get_option('jws_reading_time');

        $reading_time_wpm = 250;

        if(is_array($reading_time_options) && array_key_exists('wpm', $reading_time_options) ) {
            $reading_time_wpm = (get_option('jws_reading_time')['wpm'] ?: 250);
        }

        $jws_totals = $this->display_statistics_totals();

        $jws_tab = 'top-content';

        if (isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->allowed_tabs ) ) {
            $jws_tab = $_GET['tab'];
        }

        $excluded_types = $this->get_excluded_post_types();

        $excluded_types_sql = '';

        if( count( $excluded_types ) > 0 ) {
            $excluded_types_sql .= 'AND post_type NOT IN (\'';

            foreach( $excluded_types as $type ) {
                $excluded_types_sql .= '%s\', \'';
            }

            $excluded_types_sql = trim( $excluded_types_sql, '\', ' );

            $excluded_types_sql .= '\')';
        }

        $sql_jws_statistics = '';

        if (!isset($jws_tab) || $jws_tab == 'top-content') {
            $sql_jws_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count
				FROM $table_name_posts
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
				ORDER BY post_word_count DESC, post_date DESC
				LIMIT 10";
        } elseif ($jws_tab == 'all-content') {
            $sql_jws_statistics = "
				SELECT post_id, post_author, MID(post_date, 1, 7) AS post_date, post_status, MID(post_modified, 1, 7) AS post_modified, post_parent, post_type, post_word_count
				FROM $table_name_posts
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
				ORDER BY post_word_count DESC, post_date DESC";
        } elseif ($jws_tab == 'monthly-statistics') {
            $sql_jws_statistics = "
				SELECT MID(post_date, 1, 7) AS post_date, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count
				FROM $table_name_posts
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
				GROUP BY MID(post_date, 1, 7), post_type, post_status
                ORDER BY post_date DESC";
        } elseif ($jws_tab == 'yearly-statistics') {
            $sql_jws_statistics = "
                SELECT MID(post_date, 1, 4) AS post_date, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count
                FROM $table_name_posts
                WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
                GROUP BY MID(post_date, 1, 4), post_type, post_status
                ORDER BY post_date DESC";
        } elseif ($jws_tab == 'tag-statistics') {
            $sql_jws_statistics = "
				SELECT post_author, post_type, post_status, post_id, post_word_count
				FROM $table_name_posts
				WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
				ORDER BY post_id ASC";
        } elseif ($jws_tab == 'category-statistics') {
            $sql_jws_statistics = "
                SELECT post_author, post_type, post_status, post_id, post_word_count
                FROM $table_name_posts
                WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
                ORDER BY post_id ASC";
        } elseif ($jws_tab == 'author-statistics') {
            $sql_jws_statistics = "
                SELECT post_author, post_type, post_status, COUNT(post_id) AS posts, SUM(post_word_count) AS word_count
                FROM $table_name_posts
                WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'future') $excluded_types_sql
                GROUP BY post_author, post_type, post_status
                ORDER BY post_author ASC";
        }

        // If we're on a page that doesn't need statistics data, like About, just display the page and bail out now.
        if( $sql_jws_statistics == '' ) {
            include_once 'partials/jws-statistics.php';

            return;
        }

        $sql_jws_statistics = $wpdb->prepare( $sql_jws_statistics, $excluded_types );

        $jws_statistics = $wpdb->get_results($sql_jws_statistics);

        // Initialize our arrays now so that none of them are null later.
        $jws_dataset_posts = [];
        $jws_dataset_post_types = [];
        $jws_dataset_post_status = [];
        $jws_dataset_months = [];
        $jws_dataset_years = [];
        $jws_dataset_tags = [];
        $jws_dataset_categories = [];
        $jws_dataset_authors = [];

        if (!isset($jws_tab) || $jws_tab == 'top-content' || $jws_tab == 'all-content') {
            foreach ($jws_statistics as $jws_post) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$jws_post->post_type])) {
                    $post_type_object = get_post_type_object($jws_post->post_type);

                    $jws_dataset_post_types[$jws_post->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$jws_post->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                // Load authors array
                if (!isset($jws_dataset_authors[$jws_post->post_author])) {
                    $jws_dataset_authors[$jws_post->post_author]['display_name'] = get_the_author_meta('display_name', $jws_post->post_author);
                }

                $jws_dataset_post = [
                    'post_id' => $jws_post->post_id,
                    'post_title' => get_the_title($jws_post->post_id),
                    'post_status' => ucwords($jws_post->post_status),
                    'post_type' => $jws_dataset_post_types[$jws_post->post_type]['singular_name'],
                    'post_author' => $jws_dataset_authors[$jws_post->post_author]['display_name'],
                    'post_author_id' => $jws_post->post_author,
                    'post_word_count' => $jws_post->post_word_count,
                    'permalink' => get_permalink($jws_post->post_id),
                ];

                if( ! array_key_exists($jws_dataset_post['post_type'], $jws_dataset_post_status) ) { $jws_dataset_post_status[$jws_dataset_post['post_type']] = array(); }

                if( ! array_key_exists($jws_dataset_post['post_status'], $jws_dataset_post_status[$jws_dataset_post['post_type']]) ) { $jws_dataset_post_status[$jws_dataset_post['post_type']][$jws_dataset_post['post_status']] = array( 'count' => 0, 'words' => 0 ); }

                $jws_dataset_post_status[$jws_dataset_post['post_type']][$jws_dataset_post['post_status']]['count']++;
                $jws_dataset_post_status[$jws_dataset_post['post_type']][$jws_dataset_post['post_status']]['words'] += intval( $jws_dataset_post['post_word_count'] );

                $jws_dataset_posts[] = $jws_dataset_post;
            }
        } elseif ($jws_tab == 'monthly-statistics') {
            foreach ($jws_statistics as $total) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

                    $jws_dataset_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                // Load months array
                if (!isset($jws_dataset_months[$total->post_date])) {
                    $jws_dataset_months[$total->post_date]['total'] = 0;
                    $jws_dataset_months[$total->post_date]['items'] = 0;
                }

                if (!isset($jws_dataset_months[$total->post_date][$total->post_type])) {
                    $jws_dataset_months[$total->post_date][$total->post_type]['name'] = $jws_dataset_post_types[$total->post_type]['plural_name'];
                    $jws_dataset_months[$total->post_date][$total->post_type]['published']['posts'] = 0;
                    $jws_dataset_months[$total->post_date][$total->post_type]['published']['word_count'] = 0;
                    $jws_dataset_months[$total->post_date][$total->post_type]['scheduled']['posts'] = 0;
                    $jws_dataset_months[$total->post_date][$total->post_type]['scheduled']['word_count'] = 0;
                    $jws_dataset_months[$total->post_date][$total->post_type]['unpublished']['posts'] = 0;
                    $jws_dataset_months[$total->post_date][$total->post_type]['unpublished']['word_count'] = 0;
                }

                if ($total->post_status == 'publish') {
                    $jws_dataset_months[$total->post_date][$total->post_type]['published']['posts'] += $total->posts;
                    $jws_dataset_months[$total->post_date][$total->post_type]['published']['word_count'] += $total->word_count;
                } else if ($total->post_status == 'future') {
                    $jws_dataset_months[$total->post_date][$total->post_type]['scheduled']['posts'] += $total->posts;
                    $jws_dataset_months[$total->post_date][$total->post_type]['scheduled']['word_count'] += $total->word_count;
                } else {
                    $jws_dataset_months[$total->post_date][$total->post_type]['unpublished']['posts'] += $total->posts;
                    $jws_dataset_months[$total->post_date][$total->post_type]['unpublished']['word_count'] += $total->word_count;
                }

                $jws_dataset_months[$total->post_date]['items']++;
                $jws_dataset_months[$total->post_date]['total'] += $total->word_count;
            }
        } elseif ($jws_tab == 'yearly-statistics') {
            foreach ($jws_statistics as $total) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

                    $jws_dataset_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                // Load months array
                if (!isset($jws_dataset_years[$total->post_date])) {
                    $jws_dataset_years[$total->post_date]['total'] = 0;
                    $jws_dataset_years[$total->post_date]['items'] = 0;
                }

                if (!isset($jws_dataset_years[$total->post_date][$total->post_type])) {
                    $jws_dataset_years[$total->post_date][$total->post_type]['name'] = $jws_dataset_post_types[$total->post_type]['plural_name'];
                    $jws_dataset_years[$total->post_date][$total->post_type]['published']['posts'] = 0;
                    $jws_dataset_years[$total->post_date][$total->post_type]['published']['word_count'] = 0;
                    $jws_dataset_years[$total->post_date][$total->post_type]['scheduled']['posts'] = 0;
                    $jws_dataset_years[$total->post_date][$total->post_type]['scheduled']['word_count'] = 0;
                    $jws_dataset_years[$total->post_date][$total->post_type]['unpublished']['posts'] = 0;
                    $jws_dataset_years[$total->post_date][$total->post_type]['unpublished']['word_count'] = 0;
                }

                if ($total->post_status == 'publish') {
                    $jws_dataset_years[$total->post_date][$total->post_type]['published']['posts'] += $total->posts;
                    $jws_dataset_years[$total->post_date][$total->post_type]['published']['word_count'] += $total->word_count;
                } else if ($total->post_status == 'future') {
                    $jws_dataset_years[$total->post_date][$total->post_type]['scheduled']['posts'] += $total->posts;
                    $jws_dataset_years[$total->post_date][$total->post_type]['scheduled']['word_count'] += $total->word_count;
                } else {
                    $jws_dataset_years[$total->post_date][$total->post_type]['unpublished']['posts'] += $total->posts;
                    $jws_dataset_years[$total->post_date][$total->post_type]['unpublished']['word_count'] += $total->word_count;
                }

                $jws_dataset_years[$total->post_date]['items']++;
                $jws_dataset_years[$total->post_date]['total'] += $total->word_count;
            }
        } elseif ($jws_tab == 'tag-statistics') {
            foreach ($jws_statistics as $total) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

                    $jws_dataset_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }


                $tags = wp_get_post_tags( $total->post_id );

                foreach( $tags as $tag ) {
                    if (!isset($jws_dataset_tags[$tag->name][$total->post_type])) {
                        $jws_dataset_tags[$tag->name][$total->post_type]['published']['posts'] = 0;
                        $jws_dataset_tags[$tag->name][$total->post_type]['published']['word_count'] = 0;
                        $jws_dataset_tags[$tag->name][$total->post_type]['scheduled']['posts'] = 0;
                        $jws_dataset_tags[$tag->name][$total->post_type]['scheduled']['word_count'] = 0;
                        $jws_dataset_tags[$tag->name][$total->post_type]['unpublished']['posts'] = 0;
                        $jws_dataset_tags[$tag->name][$total->post_type]['unpublished']['word_count'] = 0;
                    }

                    if (!array_key_exists('published', $jws_dataset_tags[$tag->name])) {
                        $jws_dataset_tags[$tag->name]['published'] = 0;
                        $jws_dataset_tags[$tag->name]['scheduled'] = 0;
                        $jws_dataset_tags[$tag->name]['unpublished'] = 0;
                        $jws_dataset_tags[$tag->name]['items'] = 0;
                        $jws_dataset_tags[$tag->name]['total'] = 0;
                    }

                    if ($total->post_status == 'publish') {
                        $jws_dataset_tags[$tag->name][$total->post_type]['published']['posts']++;
                        $jws_dataset_tags[$tag->name][$total->post_type]['published']['word_count'] += $total->post_word_count;
                        $jws_dataset_tags[$tag->name]['published'] += $total->post_word_count;
                    } else if ($total->post_status == 'future') {
                        $jws_dataset_tags[$tag->name][$total->post_type]['scheduled']['posts']++;
                        $jws_dataset_tags[$tag->name][$total->post_type]['scheduled']['word_count'] += $total->post_word_count;
                        $jws_dataset_tags[$tag->name]['scheduled'] += $total->post_word_count;
                    } else {
                        $jws_dataset_tags[$tag->name][$total->post_type]['unpublished']['posts']+= $total->post_word_count;
                        $jws_dataset_tags[$tag->name][$total->post_type]['unpublished']['word_count'] += $total->post_word_count;
                        $jws_dataset_tags[$tag->name]['unpublished'] += $total->post_word_count;
                    }

                    $jws_dataset_tags[$tag->name]['items']++;
                    $jws_dataset_tags[$tag->name]['total'] += $total->post_word_count;
                }

                ksort( $jws_dataset_tags, SORT_FLAG_CASE | SORT_STRING);

            }
        } elseif ($jws_tab == 'category-statistics') {
            foreach ($jws_statistics as $total) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

                    $jws_dataset_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                $categories = get_the_category( $total->post_id );

                foreach( $categories as $category ) {
                    if (!isset($jws_dataset_categories[$category->name][$total->post_type])) {
                        $jws_dataset_categories[$category->name][$total->post_type]['published']['posts'] = 0;
                        $jws_dataset_categories[$category->name][$total->post_type]['published']['word_count'] = 0;
                        $jws_dataset_categories[$category->name][$total->post_type]['scheduled']['posts'] = 0;
                        $jws_dataset_categories[$category->name][$total->post_type]['scheduled']['word_count'] = 0;
                        $jws_dataset_categories[$category->name][$total->post_type]['unpublished']['posts'] = 0;
                        $jws_dataset_categories[$category->name][$total->post_type]['unpublished']['word_count'] = 0;
                    }

                    if (!array_key_exists('published', $jws_dataset_categories[$category->name])) {
                        $jws_dataset_categories[$category->name]['published'] = 0;
                        $jws_dataset_categories[$category->name]['scheduled'] = 0;
                        $jws_dataset_categories[$category->name]['unpublished'] = 0;
                        $jws_dataset_categories[$category->name]['items'] = 0;
                        $jws_dataset_categories[$category->name]['total'] = 0;
                    }

                    if ($total->post_status == 'publish') {
                        $jws_dataset_categories[$category->name][$total->post_type]['published']['posts']++;
                        $jws_dataset_categories[$category->name][$total->post_type]['published']['word_count'] += $total->post_word_count;
                        $jws_dataset_categories[$category->name]['published'] += $total->post_word_count;
                    } else if ($total->post_status == 'future') {
                        $jws_dataset_categories[$category->name][$total->post_type]['scheduled']['posts']++;
                        $jws_dataset_categories[$category->name][$total->post_type]['scheduled']['word_count'] += $total->post_word_count;
                        $jws_dataset_categories[$category->name]['scheduled'] += $total->post_word_count;
                    } else {
                        $jws_dataset_categories[$category->name][$total->post_type]['unpublished']['posts']++;
                        $jws_dataset_categories[$category->name][$total->post_type]['unpublished']['word_count'] += $total->post_word_count;
                        $jws_dataset_categories[$category->name]['unpublished'] += $total->post_word_count;
                    }

                    $jws_dataset_categories[$category->name]['items']++;
                    $jws_dataset_categories[$category->name]['total'] += $total->post_word_count;
                }

                ksort( $jws_dataset_categories, SORT_FLAG_CASE | SORT_STRING);

            }
        } elseif ($jws_tab == 'author-statistics') {
            foreach ($jws_statistics as $total) {
                // Load post type array
                if (!isset($jws_dataset_post_types[$total->post_type])) {
                    $post_type_object = get_post_type_object($total->post_type);

                    $jws_dataset_post_types[$total->post_type]['plural_name'] = $post_type_object->labels->name;
                    $jws_dataset_post_types[$total->post_type]['singular_name'] = $post_type_object->labels->singular_name;
                }

                // Load authors array
                if (!isset($jws_dataset_authors[$total->post_author])) {
                    $jws_dataset_authors[$total->post_author]['display_name'] = get_the_author_meta('display_name', $total->post_author);
                    $jws_dataset_authors[$total->post_author]['total'] = 0;
                    $jws_dataset_authors[$total->post_author]['items'] = 0;
                }

                if (!isset($jws_dataset_authors[$total->post_author][$total->post_type])) {
                    $jws_dataset_authors[$total->post_author][$total->post_type]['published']['posts'] = 0;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['published']['word_count'] = 0;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['scheduled']['posts'] = 0;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['scheduled']['word_count'] = 0;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['unpublished']['posts'] = 0;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['unpublished']['word_count'] = 0;
                }

                if ($total->post_status == 'publish') {
                    $jws_dataset_authors[$total->post_author][$total->post_type]['published']['posts'] += $total->posts;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['published']['word_count'] += $total->word_count;
                } else if ($total->post_status == 'future') {
                    $jws_dataset_authors[$total->post_author][$total->post_type]['scheduled']['posts'] += $total->posts;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['scheduled']['word_count'] += $total->word_count;
                } else {
                    $jws_dataset_authors[$total->post_author][$total->post_type]['unpublished']['posts'] += $total->posts;
                    $jws_dataset_authors[$total->post_author][$total->post_type]['unpublished']['word_count'] += $total->word_count;
                }

                $jws_dataset_authors[$total->post_author]['items']++;
                $jws_dataset_authors[$total->post_author]['total'] += $total->word_count;
            }

            // Sort authors array by total
            uasort(
                $jws_dataset_authors, function ($a, $b) {
                    return $b['total'] - $a['total'];
                }
            );
        }

        // Sort Post Types in a more readable way
        if (isset($jws_dataset_post_types) && count($jws_dataset_post_types)> 1) {
            $jws_dataset_post_types_standard = [];
            $jws_dataset_post_types_custom = [];

            if (isset($jws_dataset_post_types['post'])) {
                $jws_dataset_post_types_standard['post'] = $jws_dataset_post_types['post'];
            }
            if (isset($jws_dataset_post_types['page'])) {
                $jws_dataset_post_types_standard['page'] = $jws_dataset_post_types['page'];
            }

            foreach ($jws_dataset_post_types as $post_type_slug => $post_type) {
                if ($post_type_slug != 'post' && $post_type_slug != 'page') {
                    $jws_dataset_post_types_custom[$post_type_slug] = $post_type;
                }
            }

            uasort(
                $jws_dataset_post_types_custom, function ($a, $b) {
                    return strcmp($a['plural_name'], $b['plural_name']);
                }
            );
            $jws_dataset_post_types = array_merge($jws_dataset_post_types_standard, $jws_dataset_post_types_custom);
        }

        include_once 'partials/jws-statistics.php';
    }

    /**
     * Render the reading time display.
     *
     * @since 3.2.0
     */
    public function display_reading_time()
    {
        include_once 'partials/jws-reading-time.php';
    }

    /**
     * Call public save post data function on post save.
     *
     * @since 3.0.0
     * @param int    $post_id The ID of the post.
     * @param object $post    The post object.
     */
    public function post_word_count($post_id, $post)
    {
        jws_save_post_data($post);
    }

    public function calculate_chart_step_size( $max )
    {
        // Figure out a good stepping for the word count.
        $step = round( $max / 10, -4 );
        if( $step == 0 ) { $step = round( $max / 10, -3 ); }
        if( $step == 0 ) { $step = round( $max / 10, -2 ); }
        if( $step == 0 ) { $step = round( $max / 10, -1 ); }
        if( $step == 0 ) { $step = round( $max / 10, 0 ); }
        if( $step == 0 ) { $step = 1; }

        if( $max < 100 && $max > 0 ) {
            $step = ceil( $max / 10 );
        }

        return $step;
    }

    public function get_excluded_post_types()
    {
        $excluded_types = array();
        $excluded_types_option = get_option('jws_excluded_types');

        if( ! is_array( $excluded_types_option ) ) { $excluded_types_option = array(); }

        // Convert the setting array which has the type in the key name to have the key in the value instead.
        foreach( $excluded_types_option as $type => $setting ) {
            $excluded_types[] .= $type;
        }

        // Add in the mandatory excluded types.
        $excluded_types = array_merge( $excluded_types, $this->mandatory_excluded_types );

        return $excluded_types;
    }

    public function add_wc_column( $defaults )
    {
        $defaults['jws_words'] = __( 'Words', 'just-writing-statistics' );

        return $defaults;
    }

    public function output_wc_column( $column_name )
    {
        global $post;

        if( $column_name == 'jws_words' )
        {
            echo jws_calculate_word_count_post( $post );
        }

    }

}
