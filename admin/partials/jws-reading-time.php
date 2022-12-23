<?php

/**
 * Provide a settings view for the plugin
 *
 * This file is used to markup the settings view of the plugin.
 *
 * @link       https://toolstack.com/just-writing-statistics
 * @since      3.2.0
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin/partials
 */
?>

<?php $jws_tab = 'reading-time'; ?>
<div id="just-writing-statistics" class="wrap">
    <h1><?php _e('Just Writing Statistics', $this->plugin_name); ?> - <?php _e('Reading Time', $this->plugin_name); ?></h1>
    
    <?php include_once 'jws-statistics-menu.php'; ?>

    <form method="post" action="options.php">
        <?php settings_fields("jws-section-reading-time"); ?>
        <?php do_settings_sections("jws-reading-time"); ?>
            
        <?php submit_button(__('Save Changes', $this->plugin_name), 'primary'); ?>
    </form>
</div>