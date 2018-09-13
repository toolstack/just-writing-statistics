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
    
    <?php include_once('wpwc-statistics-menu.php'); ?>
		
	<h2><?php _e('Calculate Word Counts', $this->plugin_name); ?></h2>
	
	<p><?php _e('You can calculate the word counts of all your content by pressing the button below.<br>After your first calculation, word counts will be stored automatically every time you save a post.', $this->plugin_name); ?></p>
	
	<form method="post" class="wpwc-calculate-statistics">
		<?php wp_nonce_field('wpwc_calculate_nonce', 'wpwc_calculate_nonce'); ?>	
		
		<?php submit_button(__('Calculate Now', $this->plugin_name), 'primary', true, array( 'id' => 'recount-stats-submit' )); ?>
	</form>
	
	<span class="spinner"></span>
	
	<?php include_once('wpwc-footer.php'); ?>
</div>