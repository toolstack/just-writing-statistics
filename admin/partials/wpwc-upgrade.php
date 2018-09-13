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
				<li><?php _e('You\'ll get complete control over which post types you see in your statistics through a custom "Settings" option.', $this->plugin_name ); ?></li>
				<li><?php _e('WP Word Count Pro comes with detailed breakdowns of your monthly writing output by day, author, post type, category, tag and more.', $this->plugin_name ); ?></li>
				<li><?php _e('Each author that contributes to your site has their own personal stats page with information beyond just word count totals.', $this->plugin_name ); ?></li>
				<li><?php _e('All of your posts have expanded statistical details with revision history, post rankings and more.', $this->plugin_name ); ?></li>
				<li><?php _e('The achievement system in WP Word Count Pro gives you extra motivation to write more and increase your site\'s content.', $this->plugin_name ); ?></li>
				<li><?php _e('Charts and graphs are on nearly every screen of WP Word Count Pro to offer better data visualization.', $this->plugin_name ); ?></li>
		    </ul>
		    
		    <a class="wpwc-button" target="_blank" href="https://wpwordcount.com"><?php _e('View Features and Pricing', $this->plugin_name ); ?></a>
	    </div>
	    
	    <div class="half">
		   <a target="_blank" href="https://wpwordcount.com"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro.png', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro', $this->plugin_name); ?>"></a>
		    
		    <ul class="wpwc-screenshots">
			    <li><a target="_blank" href="https://wpwordcount.com"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-1.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
				<li><a target="_blank" href="https://wpwordcount.com"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-2.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
				<li><a target="_blank" href="https://wpwordcount.com"><img class="wpwc-logo" src="<?php echo plugins_url('/images/wp-word-count-pro-screenshot-3.jpg', dirname(__FILE__)); ?>" alt="<?php _e('WP Word Count Pro Screenshot', $this->plugin_name); ?>"></a></li>
			</ul>
			
			<!-- Begin MailChimp Signup Form -->
			<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
			<div id="mc_embed_signup">
				<form action="https://linksoftwarellc.us14.list-manage.com/subscribe/post?u=dbfc5178850b02a8a1535123c&amp;id=775f0e048b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				    <div id="mc_embed_signup_scroll">
						<p>
						<?php _e('Click subscribe below to get writing tips, updates on new releases and discounts for WP Word Count Pro. Unsubscribe at any time.', $this->plugin_name ); ?>
						</p>
						
						<div class="mc-field-group">
							<input type="email" value="<?php echo @$current_user->user_email; ?>" name="EMAIL" class="required email" id="mce-EMAIL">
						</div>
						
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>
						
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_dbfc5178850b02a8a1535123c_775f0e048b" tabindex="-1" value=""></div>
						<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				    </div>
				</form>
			</div>
			<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
			<!--End mc_embed_signup-->
	    </div>
    </div>
		
	<?php include_once('wpwc-footer.php'); ?>
</div>