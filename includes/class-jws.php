<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      3.0.0
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/includes
 * @author     GregRoss, RedLettuce
 * @link       https://toolstack.com/just-writing-statistics
 */
class Just_Writing_Statistics
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  3.0.0
     * @access protected
     * @var    Just_Writing_Statistics_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  3.0.0
     * @access protected
     * @var    string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  3.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'just-writing-statistics';
        $this->version = JWS_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Just_Writing_Statistics_Loader. Orchestrates the hooks of the plugin.
     * - Just_Writing_Statistics_i18n. Defines internationalization functionality.
     * - Just_Writing_Statistics_Admin. Defines all hooks for the admin area.
     * - Just_Writing_Statistics_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  3.0.0
     * @access private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-jws-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-jws-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-jws-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'public/class-jws-public.php';

        $this->loader = new Just_Writing_Statistics_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Just_Writing_Statistics_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  3.0.0
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new Just_Writing_Statistics_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  3.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Just_Writing_Statistics_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_init', $plugin_admin, 'settings');
        $this->loader->add_action('plugins_loaded', $plugin_admin, 'plugin_check');

        $this->loader->add_action('wp_ajax_jws_calculate', $plugin_admin, 'calculate_statistics');

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_name . '.php');
        $this->loader->add_action('admin_menu', $plugin_admin, 'menu');
        $this->loader->add_filter('plugin_action_links_' . $plugin_basename, $plugin_admin, 'action_links', 10, 2);

        $this->loader->add_action('save_post', $plugin_admin, 'post_word_count', 10, 2);

        $admin_options = get_option('jws_admin_options');
        $disable_admin_column = false;

        if( is_array( $admin_options ) && array_key_exists('disable_admin_column', $admin_options ) ) {
            $disable_admin_column = true;
        }

        if( $disable_admin_column ) {
            return;
        }

        $post_types = get_post_types('', 'names');
        foreach( $plugin_admin->get_excluded_post_types() as $type )
        {
            unset($post_types[$type]);
        }

        foreach( $post_types as $type )
        {
            // Add columns for each post type.
            $this->loader->add_filter( 'manage_' . $type . '_posts_columns', $plugin_admin, 'add_wc_column' );

            // Output word count value for each post type.
            $this->loader->add_action( 'manage_' . $type . '_posts_custom_column', $plugin_admin, 'output_wc_column', 10, 2 );
        }

        $this->loader->add_filter( 'post_row_actions', $plugin_admin, 'add_frequency_stats_action_link', 10, 2 );
        $this->loader->add_filter( 'page_row_actions', $plugin_admin, 'add_frequency_stats_action_link', 10, 2 );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  3.0.0
     * @access private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Just_Writing_Statistics_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('init', $plugin_public, 'justwritingstatistics_register_shortcodes');
        $this->loader->add_filter('the_content', $plugin_public, 'justwritingstatistics_reading_time_before_content');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 3.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  3.0.0
     * @return string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  3.0.0
     * @return Just_Writing_Statistics_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  3.0.0
     * @return string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
