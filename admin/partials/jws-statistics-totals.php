<?php

/**
 * Display main word stats at the top of the plugin's admin area.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 2.0.0
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin/partials
 */
?>
<div class="jws-totals">

    <div class="quarter">
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="4" class="jws_totals_title"><?php _e('Totals', 'just-writing-statistics'); ?></th>
                </tr>
                <tr>
                    <th><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Total', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Average', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php $jws_counter_post_types = 0; ?>
                <?php $jws_total = 0; ?>

                <?php foreach ($jws_totals as $total) : $jws_total += ($total['published']['word_count'] + $total['unpublished']['word_count']); ?>

                    <?php echo '<tr'.($jws_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
                    <td><?php echo esc_html( $total['name'] ); ?></td>
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

                    <?php $jws_counter_post_types++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>
            <?php echo number_format($jws_total); ?><br />
            <span><?php _e('Total Words', 'just-writing-statistics'); ?></span>
        </h2>

        <h2>
            <?php echo jws_reading_time($jws_total, $reading_time_wpm); ?><br />
            <span><?php _e('Reading Time', 'just-writing-statistics'); ?></span>
        </h2>
    </div>

    <div class="quarter">
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="4" class="jws_totals_title"><?php _e('Published', 'just-writing-statistics'); ?></th>
                </tr>
                <tr>
                    <th><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Total', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Average', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php $jws_counter_post_types = 0; ?>
                <?php $published_total = 0; ?>

                <?php foreach ($jws_totals as $total) : $published_total += $total['published']['word_count']; ?>

                    <?php echo '<tr'.($jws_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
                    <td><?php echo esc_html( $total['name'] ); ?></td>
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

                    <?php $jws_counter_post_types++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>
            <?php echo number_format($published_total); ?><br />
            <span><?php _e('Published Words', 'just-writing-statistics'); ?></span>
        </h2>

        <h2>
            <?php echo jws_reading_time($published_total, $reading_time_wpm); ?><br />
            <span><?php _e('Reading Time', 'just-writing-statistics'); ?></span>
        </h2>

    </div>

    <div class="quarter">
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="4" class="jws_totals_title"><?php _e('Scheduled', 'just-writing-statistics'); ?></th>
                </tr>
                <tr>
                    <th><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Total', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Average', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php $jws_counter_post_types = 0; ?>
                <?php $scheduled_total = 0; ?>

                <?php foreach ($jws_totals as $total) : $scheduled_total += $total['scheduled']['word_count']; ?>

                    <?php echo '<tr'.($jws_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
                    <td><?php echo esc_html( $total['name'] ); ?></td>
                    <td><?php echo @number_format(0 + $total['scheduled']['posts']); ?></td>
                    <td><?php echo @number_format(0 + $total['scheduled']['word_count']); ?></td>
                    <td>
                    <?php
                    if (0 + @$total['scheduled']['word_count'] != 0) {

                        echo @number_format(round(0 + ($total['scheduled']['word_count'] / $total['scheduled']['posts'])));

                    } else {

                        echo '-';
                    }
                    ?>
                    </td>
                </tr>

                    <?php $jws_counter_post_types++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>
            <?php echo number_format($scheduled_total); ?><br />
            <span><?php _e('Scheduled Words', 'just-writing-statistics'); ?></span>
        </h2>

        <h2>
            <?php echo jws_reading_time($scheduled_total, $reading_time_wpm); ?><br />
            <span><?php _e('Reading Time', 'just-writing-statistics'); ?></span>
        </h2>

    </div>

    <div class="quarter">
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="4" class="jws_totals_title"><?php _e('Unpublished', 'just-writing-statistics'); ?></th>
                </tr>
                <tr>
                    <th><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Total', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th><?php _e('Average', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php $jws_counter_post_types = 0; ?>
                <?php $unpublished_total = 0; ?>

                <?php foreach ($jws_totals as $total) : $unpublished_total += $total['unpublished']['word_count']; ?>

                    <?php echo '<tr'.($jws_counter_post_types % 2 == 1 ? "" : " class='alternate'").'>'; ?>
                    <td><?php echo esc_html( $total['name'] ); ?></td>
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

                    <?php $jws_counter_post_types++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>
            <?php echo number_format($unpublished_total); ?><br />
            <span><?php _e('Unpublished Words', 'just-writing-statistics'); ?></span>
        </h2>

        <h2>
            <?php echo jws_reading_time($unpublished_total, $reading_time_wpm); ?><br />
            <span><?php _e('Reading Time', 'just-writing-statistics'); ?></span>
        </h2>

    </div>
</div>