<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpwordcount.com
 * @since      3.0.0
 *
 * @package    Wp_Word_Count_Pro
 * @subpackage Wp_Word_Count_Pro/admin/partials
 */

?>

<div id="wp-word-count" class="wrap">
	<h1><?php _e('WP Word Count', $this->plugin_name); ?></h1>
	
	<?php if ((isset($arr_wpwc_posts) && @count($arr_wpwc_posts) != 0) || (isset($arr_wpwc_months) && @count($arr_wpwc_months)) || (isset($arr_wpwc_authors) && @count($arr_wpwc_authors))): ?>
    
	<?php include_once 'wpwc-statistics-menu.php'; ?>
	
    <?php
        if (!isset($wpwc_tab) || $wpwc_tab == 'top-content' || $wpwc_tab == 'all-content') {
            include_once 'wpwc-statistics-totals.php';
        }
    ?>
	
	<?php if (!isset($wpwc_tab) || $wpwc_tab == 'top-content' || $wpwc_tab == 'all-content') : ?>
	<div class="full">
		<?php if (!isset($wpwc_tab) || $wpwc_tab == 'top-content') : ?>
		<h3><?php _e('Top Content', $this->plugin_name); ?></h3>
		<?php elseif ($wpwc_tab == 'all-content') : ?>
		<h3><?php _e('All Content', $this->plugin_name); ?></h3>
		<?php endif; ?>
		
		<table class="widefat">
			<thead>
				<tr>
					<th class="wpwc-words"><?php _e('Words', $this->plugin_name); ?></th>
					<th class="wpwc-title"><?php _e('Title', $this->plugin_name); ?></th>
                    <th class="wpwc-reading-time"><?php _e('Reading Time', $this->plugin_name); ?></th>
					<th class="wpwc-type"><?php _e('Type', $this->plugin_name); ?></th>
					<th class="wpwc-status"><?php _e('Status', $this->plugin_name); ?></th>
					<th class="wpwc-author"><?php _e('Author', $this->plugin_name); ?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $wpwc_counter_top_content = 0; ?>
				<?php foreach ($arr_wpwc_posts as $index => $post) : ?>
				
				<?php echo '<tr'.($index % 2 == 1 ? '' : " class='alternate'").'>'; ?>
					<td><?php echo number_format($post['post_word_count']); ?></td>
					<td>
						<a href="<?php echo $post['permalink']; ?>"><?php echo $post['post_title']; ?></a>
						
						<div class="row-actions">
							<span class="edit"><?php edit_post_link(__('Edit', $this->plugin_name), '', ' | ', $post['post_id']); ?></span>
							<span class="trash"><a href="<?php echo get_delete_post_link($post['post_id']); ?>"><?php _e('Trash', $this->plugin_name); ?></a> | </span>
							<span class='view'><a href="<?php echo $post['permalink']; ?>"><?php _e('View', $this->plugin_name); ?></a></span>
						</div>
					</td>
                    <td><?php echo wpwc_reading_time($post['post_word_count'], $reading_time_wpm); ?></td>
					<td><?php echo $post['post_type']; ?></td>
					<td><?php echo $post['post_status']; ?></td>
                    <td>
                        <?php echo get_avatar($post['post_author_id'], 32, 'mysteryman', $author['display_name'], ['class' => 'avatar avatar-32 photo']); ?>
                        <?php echo $post['post_author']; ?>
                    </td>
				</tr>
				<?php $wpwc_counter_top_content++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
	<?php elseif ($wpwc_tab == 'monthly-statistics') : ?>
	
	<div class="full">
		<h3><?php _e('Monthly Statistics', $this->plugin_name); ?></h3>
		
		<div class="wpwc-table">
			<table class="widefat wpwc-post-type-stats">
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
						<th><?php _e('Unpublished', $this->plugin_name); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				
				<tbody>
					<?php $wpwc_counter_monthly_statistics = 0; ?>
					<?php foreach ($arr_wpwc_months as $month_name => $month) : ?>
					
					<?php echo '<tr'.($wpwc_counter_monthly_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
						<td><nobr><?php echo $month_name; ?></td>
						<td><?php echo number_format($month['total']); ?></td>
						<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
						<td>
							<?php echo (isset($month[$index]['published']['posts']) ? number_format(0 + $month[$index]['published']['posts']) : '0'); ?> <?php _e('Total', $this->plugin_name); ?><br />
							<?php echo (isset($month[$index]['published']['word_count']) ? number_format(0 + $month[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', $this->plugin_name); ?><br />
							<?php if (isset($month[$index]['published']['posts']) && $month[$index]['published']['posts'] != 0) : ?>
							<?php echo number_format(round(0 + ($month[$index]['published']['word_count'] / $month[$index]['published']['posts']))); ?> <?php _e('Average', $this->plugin_name); ?>
							<?php endif; ?>
						</td>
						<td>
							<?php echo (isset($month[$index]['unpublished']['posts']) ? number_format(0 + $month[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', $this->plugin_name); ?><br />
							<?php echo (isset($month[$index]['unpublished']['word_count']) ? number_format(0 + $month[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', $this->plugin_name); ?><br />
							<?php if (isset($month[$index]['unpublished']['posts']) && $month[$index]['unpublished']['posts'] != 0) : ?>
							<?php echo number_format(round(0 + ($month[$index]['unpublished']['word_count'] / $month[$index]['unpublished']['posts']))); ?> <?php _e('Average', $this->plugin_name); ?>
							<?php endif; ?>
						</td>
						<?php endforeach; ?>
					</tr>
					
					<?php $wpwc_counter_monthly_statistics++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	
    <?php elseif ($wpwc_tab == 'author-statistics') : ?>

	<div class="full">
		<h3><?php _e('Author Statistics', $this->plugin_name); ?></h3>
		
		<div class="wpwc-table">
			<table class="widefat wpwc-post-type-stats">
				<thead>
					<tr>
						<th rowspan="2"><?php _e('Author', $this->plugin_name); ?></th>
						<th rowspan="2"><?php _e('Words', $this->plugin_name); ?></th>
						<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
						<th colspan="2" class="wpwc-post-type"><?php echo $post_type['plural_name']; ?></th>
						<?php endforeach; ?>
					</tr>
					
					<tr>
						<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
						<th><?php _e('Published', $this->plugin_name); ?></th>
						<th><?php _e('Unpublished', $this->plugin_name); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				
				<tbody>
					<?php $wpwc_counter_author_statistics = 0; ?>
					<?php foreach ($arr_wpwc_authors as $index => $author) : ?>
					
                    <?php echo '<tr'.($wpwc_counter_author_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td><nobr>
                            <?php echo get_avatar($index, 32, 'mysteryman', $author['display_name'], ['class' => 'avatar avatar-32 photo']); ?>
                            <?php echo $author['display_name']; ?>
                        </td>
						<td><?php echo number_format($author['total']); ?></td>
						<?php foreach ($arr_wpwc_post_types as $index => $post_type) : ?>
						<td>
							<?php echo (isset($author[$index]['published']['posts']) ? number_format(0 + $author[$index]['published']['posts']) : '0'); ?> <?php _e('Total', $this->plugin_name); ?><br />
							<?php echo (isset($author[$index]['published']['word_count']) ? number_format(0 + $author[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', $this->plugin_name); ?><br />
							<?php if (isset($author[$index]['published']['posts']) && $author[$index]['published']['posts'] != 0) : ?>
							<?php echo number_format(round(0 + ($author[$index]['published']['word_count'] / $author[$index]['published']['posts']))); ?> <?php _e('Average', $this->plugin_name); ?>
							<?php endif; ?>
						</td>
						<td>
							<?php echo (isset($author[$index]['unpublished']['posts']) ? number_format(0 + $author[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', $this->plugin_name); ?><br />
							<?php echo (isset($author[$index]['unpublished']['word_count']) ? number_format(0 + $author[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', $this->plugin_name); ?><br />
							<?php if (isset($author[$index]['unpublished']['posts']) && $author[$index]['unpublished']['posts'] != 0) : ?>
							<?php echo number_format(round(0 + ($author[$index]['unpublished']['word_count'] / $author[$index]['unpublished']['posts']))); ?> <?php _e('Average', $this->plugin_name); ?>
							<?php endif; ?>
						</td>
						<?php endforeach; ?>
					</tr>
					
					<?php $wpwc_counter_author_statistics++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<?php endif; ?>
	
	<?php else : ?>
	
	<?php $link_calculate = add_query_arg(['page' => $this->plugin_name . '-calculate'], admin_url('admin.php')); ?>
	
	<p><?php printf(__('You need to <a href="%s">calculate</a> your word counts before you can start using the plugin.', $this->plugin_name), esc_url($link_calculate)); ?></p>
    
	<?php endif; ?>
	
	<?php include_once 'wpwc-footer.php'; ?>
</div>