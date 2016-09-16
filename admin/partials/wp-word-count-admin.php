<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>
<div id="wp-word-count" class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
	<?php include_once('wp-word-count-admin-stats.php'); ?>

	<div id="wpwc-tabs">
		<ul>
			<li><a href="#wpwc-top-content" class="nav-tab nav-tab-active"><?php _e('Top Content', $this->plugin_name); ?></a></li>
			<li><a href="#wpwc-all-content" class="nav-tab"><?php _e('All Content', $this->plugin_name); ?> (<?php echo (0 + count($arr_wpwc_posts)); ?>)</a></li>
			<li><a href="#wpwc-monthly-statistics" class="nav-tab"><?php _e('Monthly Statistics', $this->plugin_name); ?></a></li>
			<li><a href="#wpwc-author-statistics" class="nav-tab"><?php _e('Author Statistics', $this->plugin_name); ?></a></li>
		</ul>
		
		<div id="wpwc-top-content">
			<?php include_once('wp-word-count-admin-tc.php'); ?>
		</div>
		
		<div id="wpwc-all-content">
			<?php include_once('wp-word-count-admin-ac.php'); ?>
		</div>
		
		<div id="wpwc-monthly-statistics">
			<?php include_once('wp-word-count-admin-ms.php'); ?>
		</div>
		
		<div id="wpwc-author-statistics">
			<?php include_once('wp-word-count-admin-as.php'); ?>
		</div>
	</div>
	
	<div id="wpwc-link-software">
		<a href="http://linksoftwarellc.com"><?php _e('A WordPress Plugin by', $this->plugin_name); ?> <img src="<?php echo plugins_url('/images/linksoftware.png', dirname(__FILE__)); ?>" alt="Link Software LLC" /></a> <a href="http://linksoftwarellc.com">Link Software LLC</a>
	</div>
</div>