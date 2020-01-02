<?php

/**
 * Provide a settings view for the plugin
 *
 * This file is used to markup the settings view of the plugin.
 *
 * @link       https://wpwordcount.com
 * @since      3.2.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>

<?php $wpwc_tab = 'reading-time'; ?>
<div id="wp-word-count" class="wrap">
    <h1><?php _e('WP Word Count', $this->plugin_name); ?> - <?php _e('Reading Time', $this->plugin_name); ?></h1>
    
    <?php include_once 'wpwc-statistics-menu.php'; ?>

    <form method="post" action="options.php">
        <?php settings_fields("wpwc-section-reading-time"); ?>
        <?php do_settings_sections("wpwc-reading-time"); ?>
            
        <?php submit_button(__('Save Changes', $this->plugin_name), 'primary'); ?>
    </form>
</div>