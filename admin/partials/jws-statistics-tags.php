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
    <div>
        <div class="full jws-chart-container">

            <h3><?php _e('Words by Tag', 'just-writing-statistics'); ?></h3>
            <canvas id="WordsByTagChart"></canvas>

        </div>

    </div>
<?php
    $labels = '';
    $word_data = array();
    $max_word = 0;

    foreach( $arr_jws_tags as $tag_name => $tag ) {
        $labels .= '\'' . $tag_name . '\', ';

        $word_data['published'] .= '\'' . $tag['published'] . '\', ';
        $word_data['scheduled'] .= '\'' . $tag['scheduled'] . '\', ';
        $word_data['unpublished'] .= '\'' . $tag['unpublished'] . '\', ';

        if( $tag['total'] > $max_word ) { $max_word = $tag['total']; }
    }

    $labels = trim( $labels, ', ' );
?>

<script>
  const WordCountChart = document.getElementById('WordsByTagChart');

  new Chart(WordCountChart, {
    type: 'bar',
    data: {
      labels: [<?php echo $labels;?>],
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: [<?php echo $word_data['published'];?>],
          backgroundColor: '#00ff00',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: [<?php echo $word_data['scheduled'];?>],
          backgroundColor: '#0056a6',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: [<?php echo $word_data['unpublished'];?>],
          backgroundColor: '#ff0000',
        },
      ],
    },
    options: {
      aspectRatio: 4.0,
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
          ticks: {
            stepSize: <?php echo $this->calculate_chart_step_size( $max_word );?>
          },
        },
        x: {
          stacked: true,
        }
      }
    },
  });

</script>

    <div class="full">
        <h3><?php _e('Tag Statistics', 'just-writing-statistics'); ?></h3>

        <div class="jws-table">
            <table class="widefat jws-post-type-stats">
                <thead>
                    <tr class="jws-table-stats-header-one">
                        <th></th>
                        <th></th>
                        <?php foreach ($arr_jws_post_types as $index => $post_type) : ?>
                        <th colspan="3" class="jws-post-type"><?php echo $post_type['plural_name']; ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <tr class="jws-table-stats-header-two">
                        <th><?php _e('Tag', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                        <?php foreach ($arr_jws_post_types as $index => $post_type) : ?>
                        <th><?php _e('Published', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Scheduled', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Unpublished', 'just-writing-statistics'); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $jws_counter_monthly_statistics = 0; ?>
                    <?php foreach ($arr_jws_tags as $tag_name => $tag) : ?>

                        <?php echo '<tr'.($jws_counter_monthly_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td><nobr><?php echo $tag_name; ?></td>
                        <td><?php echo number_format($tag['total']); ?></td>
                        <?php foreach ($arr_jws_post_types as $index => $post_type) : ?>
                        <td>
                            <?php echo (isset($tag[$index]['published']['posts']) ? number_format(0 + $tag[$index]['published']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($tag[$index]['published']['word_count']) ? number_format(0 + $tag[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($tag[$index]['published']['posts']) && $tag[$index]['published']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($tag[$index]['published']['word_count'] / $tag[$index]['published']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($tag[$index]['scheduled']['posts']) ? number_format(0 + $tag[$index]['scheduled']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($tag[$index]['scheduled']['word_count']) ? number_format(0 + $tag[$index]['scheduled']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($tag[$index]['scheduled']['posts']) && $tag[$index]['scheduled']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($tag[$index]['scheduled']['word_count'] / $tag[$index]['scheduled']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($tag[$index]['unpublished']['posts']) ? number_format(0 + $tag[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($tag[$index]['unpublished']['word_count']) ? number_format(0 + $tag[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($tag[$index]['unpublished']['posts']) && $tag[$index]['unpublished']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($tag[$index]['unpublished']['word_count'] / $tag[$index]['unpublished']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>

                        <?php $jws_counter_monthly_statistics++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
