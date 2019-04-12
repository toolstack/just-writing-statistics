<?php

/**
 * Provide a settings view for the plugin
 *
 * This file is used to markup the upgrade view of the plugin.
 *
 * @link       https://wpwordcount.com
 * @since      3.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>

<?php $wpwc_tab = 'upgrade'; ?>

<div id="wp-word-count" class="wrap">
    <h1><?php _e('WP Word Count', $this->plugin_name); ?> - <?php _e('Upgrade to Pro', $this->plugin_name); ?></h1>
    
    <?php include_once('wpwc-statistics-menu.php'); ?>
    
    <div id="wpwc-upgrade">
	    <div class="half">
            <h1><?php _e('WP Word Count Pro', $this->plugin_name ); ?></h1>

		    <h2><?php _e('Upgrade to get the following extra features:', $this->plugin_name ); ?></h2>
			
		    <ul>
				<li><?php _e('You\'ll get complete control over which post types and statuses you see in your statistics through custom "Settings" options.', $this->plugin_name ); ?></li>
				<li><?php _e('WP Word Count Pro comes with detailed breakdowns of your monthly writing output by day, author, post type, category, tag and more.', $this->plugin_name ); ?></li>
				<li><?php _e('Each author that contributes to your site has their own personal stats page with information beyond just word count totals.', $this->plugin_name ); ?></li>
				<li><?php _e('All of your posts have expanded statistical details with revision history, post rankings and more.', $this->plugin_name ); ?></li>
				<li><?php _e('The achievement system in WP Word Count Pro gives you extra motivation to write more and increase your site\'s content.', $this->plugin_name ); ?></li>
				<li><?php _e('Charts and graphs are on nearly every screen of WP Word Count Pro to offer better data visualization.', $this->plugin_name ); ?></li>
		    </ul>
		    
		    <a class="wpwc-button" target="_blank" href="https://wpwordcount.com/upgrade-tab-button"><?php _e('View Features and Pricing', $this->plugin_name ); ?></a>
	    </div>
	    
	    <div class="half">
		    <ul class="wpwc-screenshots">
			    <li><a target="_blank" href="https://wpwordcount.com/upgrade-tab-screenshot"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-1.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
				<li><a target="_blank" href="https://wpwordcount.com/upgrade-tab-screenshot"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-2.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
				<li><a target="_blank" href="https://wpwordcount.com/upgrade-tab-screenshot"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-3.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
				<li><a target="_blank" href="https://wpwordcount.com/upgrade-tab-screenshot"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-4.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
			</ul>
	    </div>
    </div>
		
	<?php include_once('wpwc-footer.php'); ?>
</div>