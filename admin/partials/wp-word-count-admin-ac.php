<?php

/**
 * Display all content stats in plugin's admin area.
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
			<th class="wpwc-words"><?php _e('Words', $this->plugin_name); ?></th>
			<th class="wpwc-title"><?php _e('Title', $this->plugin_name); ?></th>
			<th class="wpwc-type"><?php _e('Type', $this->plugin_name); ?></th>
			<th class="wpwc-status"><?php _e('Status', $this->plugin_name); ?></th>
			<th class="wpwc-author"><?php _e('Author', $this->plugin_name); ?></th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach ($arr_wpwc_posts as $index => $post) : ?>
		
		<?php echo '<tr'.($index % 2 == 1 ? "" : " class='alternate'").'>'; ?>
			<td><?php echo number_format($post['post_word_count']); ?></td>
			<td><a href="<?php echo $post['permalink']; ?>"><?php _e($post['post_title'], $this->plugin_name); ?></a></td>
			<td><?php echo $post['post_type']; ?></td>
			<td><?php echo $post['post_status']; ?></td>
			<td><?php echo $post['post_author']; ?></td>
		</tr>
		
		<?php endforeach; ?>
	</tbody>
</table>