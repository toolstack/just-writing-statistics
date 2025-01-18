<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 5.0.0
 *
 * @package    Just_Writing_Statistics_Pro
 * @subpackage Just_Writing_Statistics_Pro/admin/partials
 */

?>

<div class="full">
        <table class="widefat jws_wrapable">
            <thead>
                <tr>
                    <th colspan="7" class="jws_totals_title"><?php printf( __('Posts that contain the word "%s"', 'just-writing-statistics'), esc_html($word_query)); ?></th>
                </tr>
                <tr>
                    <th class="jws-frequency"><?php _e('Frequency', 'just-writing-statistics'); ?></th>
                    <th class="jws-words"><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th class="jws-title"><?php _e('Title', 'just-writing-statistics'); ?></th>
                    <th class="jws-reading-time"><?php _e('Reading Time', 'just-writing-statistics'); ?></th>
                    <th class="jws-type"><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th class="jws-status"><?php _e('Status', 'just-writing-statistics'); ?></th>
                    <th class="jws-author"><?php _e('Author', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($jws_dataset_word_to_posts as $index => $post) : ?>

                <?php echo '<tr'.($index % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                    <td><?php echo number_format($post['word_query_frequency']); ?></td>
                    <td><?php echo number_format($post['post_word_count']); ?></td>
                    <td>
                        <a href="<?php echo esc_attr( $post['permalink'] ); ?>"><?php echo esc_html( $post['post_title'] ? $post['post_title'] : __( '[No Title]', 'just-writing-statistics') ); ?></a>

                        <div class="row-actions">
                            <span class="edit"><?php edit_post_link(__('Edit', 'just-writing-statistics'), '', ' | ', $post['post_id']); ?></span>
                            <span class="trash"><a href="<?php echo get_delete_post_link($post['post_id']); ?>"><?php _e('Trash', 'just-writing-statistics'); ?></a> | </span>
                            <span class='view'><a href="<?php echo esc_attr( $post['permalink'] ); ?>"><?php _e('View', 'just-writing-statistics'); ?></a></span>
                        </div>
                    </td>
                    <td><?php echo jws_reading_time($post['post_word_count'], $reading_time_wpm); ?></td>
                    <td><?php echo esc_html( $post['post_type'] ); ?></td>
                    <td><?php echo esc_html( $post['post_status'] ); ?></td>
                    <td>
                        <?php echo get_avatar($post['post_author_id'], 32, 'mysteryman', $jws_dataset_authors[$post['post_author_id']]['display_name'], ['class' => 'avatar avatar-32 photo']); ?>
                        <?php echo esc_html( $post['post_author'] ); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
