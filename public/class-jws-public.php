<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/public
 * @author     GregRoss, RedLettuce
 * @link       https://toolstack.com/just-writing-statistics
 */
class Just_Writing_Statistics_Public
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
     * @since 	3.0.0
     * @param 	string    $plugin_name 	The name of the plugin.
     * @param 	string    $version    	The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Display word count stats with shortcode.
     *
     * @since 	3.0.0
     * @param	array	$atts	Shortcode attributes.
     */
    public function justwritingstatistics_register_shortcodes()
    {
        function jws_shortcode($atts)
        {
            global $post;

            if ($post) {
                extract(shortcode_atts([
                    'before' => '',
                    'after' => '',
                ], $atts));

                $words = 0 + jws_calculate_word_count_post($post);

                return wp_kses_post(trim(esc_attr($before).' '.number_format($words).' '.esc_attr($after)));
            }
        }

        add_shortcode('justwritingstatistics', 'jws_shortcode');
        add_shortcode('just-writing-statistics', 'jws_shortcode');

        function jws_shortcode_total($atts)
        {
            extract(shortcode_atts([
                'before' => '',
                'after' => '',
            ], $atts));

            $words = jws_calculate_word_count_total();

            return wp_kses_post(trim(esc_attr($before).' '.number_format($words).' '.esc_attr($after)));
        }

        function jws_shortcode_reading_time($atts) {

            global $post;

            if ($post) {

                $reading_time_settings_wpm = (get_option('wpwcp_reading_time')['wpm'] ?: 250);

                extract(shortcode_atts(array(

                    'before' => '',
                    'after' => '',

                ), $atts));

                $reading_time = jws_reading_time(jws_calculate_word_count_post($post), $reading_time_settings_wpm, 'shortcode');

                return wp_kses_post('<p class="jws-reading-time">'.trim(esc_attr($before).' '.$reading_time.' '.esc_attr($after)).'</p>');

            }

        }

        add_shortcode('justwritingstatistics-reading-time', 'jws_shortcode_reading_time');
        add_shortcode('just-writing-statistics-reading-time', 'jws_shortcode_reading_time');
    }

	/**
	 * Display reading time stats before content.
	 *
	 * @since 	3.2.0
	 */

    public function justwritingstatistics_reading_time_before_content($content) {

        global $post;

        $option = get_option('jws_reading_time');

        if ($post && is_array($option) && array_key_exists('insert', $option) && $option['insert'] == 'Y') {

            $reading_time_settings_wpm = (get_option('jws_reading_time')['wpm'] ?: 250);
            $reading_time_settings_before = (get_option('jws_reading_time')['labels']['before'] ?: '');
            $reading_time_settings_after = (get_option('jws_reading_time')['labels']['after'] ?: '');

            $reading_time = jws_reading_time(jws_calculate_word_count_post($post), $reading_time_settings_wpm, 'shortcode');

            return wp_kses_post('<p class="jws-reading-time">'.trim($reading_time_settings_before.' '.$reading_time.' '.$reading_time_settings_after).'</p>'.$content);

        } else {
            return $content;
        }
    }
}
