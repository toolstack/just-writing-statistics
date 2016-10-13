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
				<?php if (isset($month[$index]['posts']['publish'])) { echo number_format(0 + $month[$index]['posts']['publish']); } else { echo '0'; } ?> Total<br />
				<?php if (isset($month[$index]['word_counts']['publish'])) { echo number_format(0 + $month[$index]['word_counts']['publish']); } else { echo '0'; } ?> <?php _e('Words', $this->plugin_name); ?><br />
				<?php if (isset($month[$index]['posts']['publish']) && $month[$index]['posts']['publish'] != 0) : ?>
				<?php echo number_format(round(0 + ($month[$index]['word_counts']['publish'] / $month[$index]['posts']['publish']))); ?> <?php _e('Avg.', $this->plugin_name); ?>
				<?php endif; ?>
			</td>
			<td>
				<?php if (isset($month[$index]['posts']['draft'])) { echo number_format(0 + $month[$index]['posts']['draft']); } else { echo '0'; } ?> Total<br />
				<?php if (isset($month[$index]['word_counts']['draft'])) { echo number_format(0 + $month[$index]['word_counts']['draft']); } else { echo '0'; } ?> <?php _e('Words', $this->plugin_name); ?><br />
				<?php if (isset($month[$index]['posts']['draft']) && $month[$index]['posts']['draft'] != 0) : ?>
				<?php echo number_format(round(0 + ($month[$index]['word_counts']['draft'] / $month[$index]['posts']['draft']))); ?> <?php _e('Avg.', $this->plugin_name); ?>
				<?php endif; ?>
			</td>
			<?php endforeach; ?>
		</tr>
		
		<?php $wpwc_counter_monthly_statistics++; ?>
		<?php endforeach; ?>
	</tbody>
</table>