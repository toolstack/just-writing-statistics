<?php

/**
 * This file is used to markup the menu of the plugin admin.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.1.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>
<?php
	$arr_wpwc_quotes = array(
	
		array( 'quote' => '99.9% of great bloggers are not awesome on day 1. Their awesomeness is the accumulation of the value they create over time.', 'author' => 'Darren Rowse' ),
		array( 'quote' => 'I made a decision to write for my readers, not to try to find more readers for my writing.', 'author' => 'Seth Godin' ),
		array( 'quote' => 'People often ask me how am I able to write several blog posts in a day? My reply is simple: I eliminate all distractions and just write.', 'author' => 'Syed Balkhi' ),
		array( 'quote' => 'Writing is thinking out loud. Blogging is thinking out loud where other folks think back.', 'author' => 'Liz Strauss' ),
		array( 'quote' => 'A blog is a great way to figure out what you want to do with yourself because writing regularly is a path to self-discovery.', 'author' => 'Penelope Trunk' ),
		array( 'quote' => 'Your writing is the instruction manual for assembling ideas in your reader’s mind.', 'author' => 'Glen Long' ),
		array( 'quote' => 'It only takes one amazing post to push your blog past the tipping point.', 'author' => 'Matt Wolfe' ),
		array( 'quote' => 'The currency of blogging is authenticity and trust.', 'author' => 'Jason Calacanis' ),
		array( 'quote' => 'Potential brilliance can easily be stillborn when a writer wrestles with worry. Don’t.', 'author' => 'Mary Jaksch' ),
		
	);
	
	$statistics_link = array('<a href="'.admin_url('admin.php?page='.$this->plugin_name.'-settings').'">'.__('Settings', $this->plugin_name).'</a>');
?>

<div class="wpwc-menu">
	<div>
		<a href="<?php echo admin_url('admin.php?page='.$this->plugin_name); ?>"><img class="wpwc-logo" src="<?php echo plugins_url( '/images/wpwordcount.png', dirname( __FILE__ ) ); ?>" alt="<?php _e( 'WP Word Count', $this->plugin_name ); ?>" /></a>
	</div>
	
	<div>
	    <ul>
		    <li><?php _e( 'Love it?', $this->plugin_name ); ?> <a href="https://wordpress.org/support/plugin/wp-word-count/reviews/"><?php _e( 'Leave a Review', $this->plugin_name ); ?></a></li>
		    <li><?php _e( 'Hate it?', $this->plugin_name ); ?> <a href="https://linksoftwarellc.com/wp-word-count/feedback"><?php _e( 'Let Us Know Why', $this->plugin_name ); ?></a></li>
		    <li><a href="https://wordpress.org/support/plugin/wp-word-count/"><?php _e( 'Support', $this->plugin_name ); ?></a></li>
		    <li><?php _e( 'Version', $this->plugin_name ); ?> <?php echo WPWC_VERSION; ?></li>
	    </ul>
	
		<div class="wpwc-quote">
			<?php $wpwc_quote = rand( 0, count( $arr_wpwc_quotes ) - 1 ); ?>
			<h2>"<?php echo $arr_wpwc_quotes[$wpwc_quote]['quote']; ?>"</h2>
			<h3><?php echo $arr_wpwc_quotes[$wpwc_quote]['author']; ?></h3>
		</div>
	</div>
</div>