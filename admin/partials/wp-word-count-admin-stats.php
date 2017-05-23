<?php

/**
 * Display main word stats at the top of the plugin's admin area.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>
<div class="wpwc-main-stats">
    <div>
	    <h3><?php _e('Published', $this->plugin_name); ?></h3>
	    
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('Type', $this->plugin_name); ?></th>
					<th><?php _e('Total', $this->plugin_name); ?></th>
					<th><?php _e('Words', $this->plugin_name); ?></th>
					<th><?php _e('Average', $this->plugin_name); ?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $wpwc_counter_post_types = 0; ?>
				
				<?php foreach ($arr_wpwc_post_types_default as $default) : ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td>
						<?php
							
							if (isset($arr_wpwc_post_types[$default]['singular_name'])) {
							
								echo $arr_wpwc_post_types[$default]['singular_name'];
							
							}
							else {
								
								echo ucwords($default);
							}
								
						?>
					</td>
					<td><?php echo @number_format(0 + $arr_wpwc_post_types[$default]['posts']['publish']); ?></td>
					<td><?php echo @number_format(0 + $arr_wpwc_post_types[$default]['word_counts']['publish']); ?></td>
					<td>
					<?php
						if (0 + @$arr_wpwc_post_types[$default]['word_counts']['publish'] != 0) {
							
							echo @number_format(round(0 + ($arr_wpwc_post_types[$default]['word_counts']['publish'] / $arr_wpwc_post_types[$default]['posts']['publish'])));
							
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				<?php endforeach; ?>
				
				<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
				
				<?php if ($index != 'post' && $index != 'page') : ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td><?php echo $post_type['singular_name']; ?></td>
					<td><?php echo @number_format(0 + $post_type['posts']['publish']); ?></td>
					<td><?php echo @number_format(0 + $post_type['word_counts']['publish']); ?></td>
					<td>
					<?php
						if (0 + @$post_type['word_counts']['publish'] != 0) {
							
							echo @number_format(round(0 + ($post_type['word_counts']['publish'] / $post_type['posts']['publish'])));
							
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				
				<?php endif; ?>
				
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<h2>
			<?php echo number_format($arr_wpwc_totals['publish']); ?><br />
			<span><?php _e('Published Words', $this->plugin_name); ?></span>
		</h2>
    </div>
    
    <div>
	    <h3><?php _e('Draft', $this->plugin_name); ?></h3>
	    
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('Type', $this->plugin_name); ?></th>
					<th><?php _e('Total', $this->plugin_name); ?></th>
					<th><?php _e('Words', $this->plugin_name); ?></th>
					<th><?php _e('Average', $this->plugin_name); ?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $wpwc_counter_post_types = 0; ?>
				
				<?php foreach ($arr_wpwc_post_types_default as $default) : ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td>
						<?php
							
							if (isset($arr_wpwc_post_types[$default]['singular_name'])) {
							
								echo $arr_wpwc_post_types[$default]['singular_name'];
							
							}
							else {
								
								echo ucwords($default);
							}
								
						?>
					</td>
					<td><?php echo @number_format(0 + $arr_wpwc_post_types[$default]['posts']['draft']); ?></td>
					<td><?php echo @number_format(0 + $arr_wpwc_post_types[$default]['word_counts']['draft']); ?></td>
					<td>
					<?php
						if (0 + @$arr_wpwc_post_types[$default]['word_counts']['draft'] != 0) {
							
							echo @number_format(round(0 + ($arr_wpwc_post_types[$default]['word_counts']['draft'] / $arr_wpwc_post_types[$default]['posts']['draft'])));
							
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				<?php endforeach; ?>
				
				<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
				
				<?php if ($index != 'post' && $index != 'page') : ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td><?php echo $post_type['singular_name']; ?></td>
					<td><?php echo @number_format(0 + $post_type['posts']['draft']); ?></td>
					<td><?php echo @number_format(0 + $post_type['word_counts']['draft']); ?></td>
					<td>
					<?php
						if (0 + @$post_type['word_counts']['draft'] != 0) {
							
							echo @number_format(round(0 + ($post_type['word_counts']['draft'] / $post_type['posts']['draft'])));
							
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				
				<?php endif; ?>
				
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<h2>
			<?php echo number_format($arr_wpwc_totals['draft']); ?><br />
			<span><?php _e('Unpublished Words', $this->plugin_name); ?></span>
		</h2>
    </div>

    <div>
	    <a href="https://linksoftwarellc.com/wp-word-count#pro"><img class="wpwc-logo" src="<?php echo plugins_url( '/images/wpwordcountpro.png', dirname( __FILE__ ) ); ?>" alt="<?php _e( 'WP Word Count Pro', $this->plugin_name ); ?>" /></a>
	</div>
</div>