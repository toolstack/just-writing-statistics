<?php

/**
 * Provide a settings view for the plugin
 *
 * This file is used to markup the settings view of the plugin.
 *
 * @link       https://wpwordcount.com
 * @since      3.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>

<?php $wpwc_tab = 'calculate'; ?>
<div id="wp-word-count" class="wrap">
    <h1><?php _e('WP Word Count', $this->plugin_name); ?> - <?php _e('Calculate', $this->plugin_name); ?></h1>
    
    <?php include_once 'wpwc-statistics-menu.php'; ?>

    <h2><?php _e('Calculate Word Counts', $this->plugin_name); ?></h2>
    <p style="width:65%"><?php _e('You can calculate the word counts on your site at any time. Sites with thousands of posts or years of content should do multiple calculations by a date range to avoid server complications.', $this->plugin_name); ?></p>
    <p style="width:65%"><?php _e('After your first calculation, word counts will be stored automatically every time you save a post.', $this->plugin_name); ?></p>

    <form method="post" class="wpwc-calculate-statistics">
        <?php wp_nonce_field('wpwc_calculate_nonce', 'wpwc_calculate_nonce'); ?>

        <table class="form-table">
            <tr>
                <td>
                    <label>
                        <input type="radio" id="wpwc_calculation_type_all" name="wpwc_calculation_type" value="all" checked />
                        <span><?php esc_attr_e('Count all content on this site at one time', $this->plugin_name); ?></span>
                    </label><br>

                    <label>
                        <input type="radio" id="wpwc_calculation_type_dates" name="wpwc_calculation_type" value="dates" />
                        <span><?php esc_attr_e('Count content by a date range', $this->plugin_name); ?></span>
                    </label><br>
                </td>
            </tr>
        </table>

        <table id="wpwc_calculation_by_dates" class="form-table">
            <tr>
                <th scope="row"><?php _e('Date Range', $this->plugin_name); ?></th>
                <td>
                    <input type="text" class="wpwc-datepicker" id="wpwc_date_range_start" name="wpwc_date_range_start" /> <?php _e('to', $this->plugin_name); ?>
                    <input type="text" class="wpwc-datepicker" id="wpwc_date_range_end" name="wpwc_date_range_end" />
                    <input type="hidden" id="wpwc_date_range_start_formatted" name="wpwc_date_range_start_formatted" />
                    <input type="hidden" id="wpwc_date_range_end_formatted" name="wpwc_date_range_end_formatted" />
                    
                    <label for="wpwc_delete_data" style="display:block; margin-top:6px;">
                        <input type="checkbox" id="wpwc_delete_data" name="wpwc_delete_data" />
                        <span><?php esc_attr_e('Delete all existing WP Word Count data before calculation.', $this->plugin_name); ?></span>
                    </label>
                </td>
            </tr>
        </table>
        
        <?php submit_button(__('Calculate Word Counts', $this->plugin_name), 'primary', true, ['id' => 'recount-stats-submit']); ?>
    </form>
    
    <span class="spinner"></span>
</div>