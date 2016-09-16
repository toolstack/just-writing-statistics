<?php

/**
 * Display monthly stats in plugin's admin area.
 *
 * @link       http://linksoftwarellc.com/wp-word-count
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>
<table class="widefat">
	<thead>
		<tr>
			<th rowspan="2"><?php _e('Month', $this->plugin_name); ?></th>
			<th rowspan="2"><?php _e('Words', $this->plugin_name); ?></th>
			<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
			<th colspan="2" class="wpwc-post-type"><?php echo $post_type['plural_name']; ?></th>
			<?php endforeach; ?>
		</tr>
		
		<tr>
			<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
			<th><?php _e('Published', $this->plugin_name); ?></th>
			<th><?php _e('Draft', $this->plugin_name); ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	
	<tbody>
		<?php $wpwc_counter_monthly_statistics = 0; ?>
		<?php foreach ($arr_wpwc_months as $index => $month) : ?>
		
		<?php echo '<tr'.($wpwc_counter_monthly_statistics % 2 == 1 ? "" : " class='alternate'").'>'; ?>
			<td><?php echo $index; ?></td>
			<td><?php echo number_format($month['total']); ?></td>
			<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
			<td>
				<?php echo @number_format(0 + $month[$index]['posts']['publish']); ?> Total<br />
				<?php echo @number_format(0 + $month[$index]['word_counts']['publish']); ?> <?php _e('Words', $this->plugin_name); ?><br />
				<?php echo @number_format(round(0 + ($month[$index]['word_counts']['publish'] / $month[$index]['posts']['publish']))); ?> <?php _e('Avg.', $this->plugin_name); ?>
			</td>
			<td>
				<?php echo @number_format(0 + $month[$index]['posts']['draft']); ?> Total<br />
				<?php echo @number_format(0 + $month[$index]['word_counts']['draft']); ?> <?php _e('Words', $this->plugin_name); ?><br />
				<?php echo @number_format(round(0 + ($month[$index]['word_counts']['draft'] / $month[$index]['posts']['draft']))); ?> <?php _e('Avg.', $this->plugin_name); ?>
			</td>
			<?php endforeach; ?>
		</tr>
		
		<?php $wpwc_counter_monthly_statistics++; ?>
		<?php endforeach; ?>
	</tbody>
</table>