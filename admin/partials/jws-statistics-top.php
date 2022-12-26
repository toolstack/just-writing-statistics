<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 3.0.0
 *
 * @package    Just_Writing_Statsitics_Pro
 * @subpackage Just_Writing_Statsitics_Pro/admin/partials
 */

?>

    <div class="full">
        <h3><?php _e('All Content', $this->plugin_name); ?></h3>

        <table class="widefat">
            <thead>
                <tr>
                    <th class="jws-words"><?php _e('Words', $this->plugin_name); ?></th>
                    <th class="jws-title"><?php _e('Title', $this->plugin_name); ?></th>
                    <th class="jws-reading-time"><?php _e('Reading Time', $this->plugin_name); ?></th>
                    <th class="jws-type"><?php _e('Type', $this->plugin_name); ?></th>
                    <th class="jws-status"><?php _e('Status', $this->plugin_name); ?></th>
                    <th class="jws-author"><?php _e('Author', $this->plugin_name); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php $jws_counter_top_content = 0; ?>
            <?php foreach ($arr_jws_posts as $index => $post) : ?>

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
                    <td><?php echo jws_reading_time($post['post_word_count'], $reading_time_wpm); ?></td>
                    <td><?php echo $post['post_type']; ?></td>
                    <td><?php echo $post['post_status']; ?></td>
                    <td>
                        <?php echo get_avatar($post['post_author_id'], 32, 'mysteryman', $arr_jws_authors[$post['post_author_id']]['display_name'], ['class' => 'avatar avatar-32 photo']); ?>
                        <?php echo $post['post_author']; ?>
                    </td>
                </tr>
                <?php $jws_counter_top_content++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

