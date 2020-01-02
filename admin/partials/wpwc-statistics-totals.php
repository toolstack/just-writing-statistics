<?php

/**
 * Display main word stats at the top of the plugin's admin area.
 *
 * @link       https://wpwordcount.com
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>
<div class="wpwc-totals">
    <div class="third">
	    <h3><?php _e('Totals', $this->plugin_name); ?></h3>
	    
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
				<?php $wpwc_total = 0; ?>
				
				<?php foreach ($wpwc_totals as $total) : $wpwc_total += ($total['published']['word_count'] + $total['unpublished']['word_count']); ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td><?php echo $total['name']; ?></td>
					<td><?php echo @number_format(0 + $total['published']['posts'] + $total['unpublished']['posts']); ?></td>
					<td><?php echo @number_format(0 + $total['published']['word_count'] + $total['unpublished']['word_count']); ?></td>
					<td>
					<?php
						if (0 + @$total['published']['word_count'] + @$total['unpublished']['word_count'] != 0) {
							
							echo @number_format(round(0 + (($total['published']['word_count'] + $total['unpublished']['word_count']) / ($total['published']['posts'] + $total['unpublished']['posts']))));
							
						} else {
							
							echo '-';
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<h2 style="float:left; width:40%;">
            <?php echo number_format($wpwc_total); ?><br />
			<span><?php _e('Total Words', $this->plugin_name); ?></span>
		</h2>
		
		<h2 style="float:left; width:60%;">
            <?php echo wpwc_reading_time($wpwc_total, $reading_time_wpm); ?><br />
			<span><?php _e('Reading Time', $this->plugin_name); ?></span>
		</h2>
    </div>

    <div class="third">
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
				<?php $published_total = 0; ?>
				
				<?php foreach ($wpwc_totals as $total) : $published_total += $total['published']['word_count']; ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td><?php echo $total['name']; ?></td>
					<td><?php echo @number_format(0 + $total['published']['posts']); ?></td>
					<td><?php echo @number_format(0 + $total['published']['word_count']); ?></td>
					<td>
					<?php
						if (0 + @$total['published']['word_count'] != 0) {
							
							echo @number_format(round(0 + ($total['published']['word_count'] / $total['published']['posts'])));
							
						} else {
							
							echo '-';
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<h2>
			<?php echo number_format($published_total); ?><br />
			<span><?php _e('Published Words', $this->plugin_name); ?></span>
		</h2>
    </div>
    
    <div class="third">
	    <h3><?php _e('Unpublished', $this->plugin_name); ?></h3>
	    
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
				<?php $unpublished_total = 0; ?>
				
				<?php foreach ($wpwc_totals as $total) : $unpublished_total += $total['unpublished']['word_count']; ?>
				
				<?php echo '<tr'.($wpwc_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
					<td><?php echo $total['name']; ?></td>
					<td><?php echo @number_format(0 + $total['unpublished']['posts']); ?></td>
					<td><?php echo @number_format(0 + $total['unpublished']['word_count']); ?></td>
					<td>
					<?php
						if (0 + @$total['unpublished']['word_count'] != 0) {
							
							echo @number_format(round(0 + ($total['unpublished']['word_count'] / $total['unpublished']['posts'])));
							
						} else {
							
							echo '-';
						}
					?>
					</td>
				</tr>
				
				<?php $wpwc_counter_post_types++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<h2>
			<?php echo number_format($unpublished_total); ?><br />
			<span><?php _e('Unpublished Words', $this->plugin_name); ?></span>
		</h2>
    </div>
</div>