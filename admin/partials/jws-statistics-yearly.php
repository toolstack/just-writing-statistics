<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 3.0.0
 *
 * @package    Just_Writing_Statistics_Pro
 * @subpackage Just_Writing_Statistics_Pro/admin/partials
 */

?>

    <div>
        <div class="half jws-chart-container">

            <h3><?php _e('Yearly Word Counts', 'just-writing-statistics'); ?></h3>
            <canvas id="MontlyWordCountChart"></canvas>

        </div>

        <div class="half jws-chart-container">

            <h3><?php _e('Yearly Item Counts', 'just-writing-statistics'); ?></h3>
            <canvas id="MontlyItemCountChart"></canvas>

        </div>
    </div>
<?php
    $labels = array();
    $word_data = array();
    $item_data = array();
    $max_word = 0;
    $max_item = 0;

    foreach( $jws_dataset_years as $year => $count) {
        $labels[] = $year;
        $word_data[] = $count['total'];
        $item_data[] = $count['items'];

        if( $count['total'] > $max_word ) { $max_word = $count['total']; }
        if( $count['items'] > $max_item ) { $max_item = $count['items']; }
    }

?>

<script>
  const WordCountChart = document.getElementById('MontlyWordCountChart');

  new Chart(WordCountChart, {
    type: 'line',
    data: {
      labels: <?php echo html_entity_decode( json_encode( array_reverse( $labels ) ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Words','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( array_reverse( $word_data ) ) ); ?>,
          backgroundColor: '#0056a6',
          borderColor : "#0056a6",
        },
      ],
    },
    options: {
      elements: {
        line: {
            backgroundColor: '#0056a6',
            tension: 0.4
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
          ticks: {
            stepSize: <?php echo $this->calculate_chart_step_size( $max_word ); ?>
          },
        },
        x: {
          stacked: true,
        }
      }
    },
  });

  const ItemCountChart = document.getElementById('MontlyItemCountChart');

  new Chart(ItemCountChart, {
    type: 'line',
    data: {
      labels: <?php echo html_entity_decode( json_encode( array_reverse( $labels ) ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Items','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( array_reverse( $item_data ) ) ); ?>,
          backgroundColor: '#0056a6',
          borderColor : "#0056a6",
        },
      ],
    },
    options: {
      elements: {
        line: {
            backgroundColor: '#0056a6',
            tension: 0.4
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
          ticks: {
            stepSize: <?php echo $this->calculate_chart_step_size( $max_item ); ?>
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
        <div class="jws-table">
            <table class="widefat jws-post-type-stats">
                <thead>
                    <tr>
                        <th colspan="<?php echo 2 + ( count( $jws_dataset_post_types ) * 3 );?>" class="jws_totals_title"><?php _e('Yearly Statistics', 'just-writing-statistics'); ?></th>
                    </tr>
                    <tr class="jws-table-stats-header-one">
                        <th></th>
                        <th></th>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th colspan="3" class="jws-post-type"><?php echo esc_html( $post_type['plural_name'] ); ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <tr class="jws-table-stats-header-two">
                        <th><?php _e('Month', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th><?php _e('Published', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Scheduled', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Unpublished', 'just-writing-statistics'); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $jws_counter_yearly_statistics = 0; ?>
                    <?php foreach ($jws_dataset_years as $year => $count) : ?>

                        <?php echo '<tr'.($jws_counter_yearly_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td><nobr><?php echo esc_html( $year ); ?></td>
                        <td><?php echo number_format($count['total']); ?></td>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <td>
                            <?php echo (isset($count[$index]['published']['posts']) ? number_format(0 + $count[$index]['published']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($count[$index]['published']['word_count']) ? number_format(0 + $count[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($count[$index]['published']['posts']) && $count[$index]['published']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($count[$index]['published']['word_count'] / $count[$index]['published']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($count[$index]['scheduled']['posts']) ? number_format(0 + $count[$index]['scheduled']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($count[$index]['scheduled']['word_count']) ? number_format(0 + $count[$index]['scheduled']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($count[$index]['scheduled']['posts']) && $count[$index]['scheduled']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($count[$index]['scheduled']['word_count'] / $count[$index]['scheduled']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($count[$index]['unpublished']['posts']) ? number_format(0 + $count[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($count[$index]['unpublished']['word_count']) ? number_format(0 + $count[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($count[$index]['unpublished']['posts']) && $count[$index]['unpublished']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($count[$index]['unpublished']['word_count'] / $count[$index]['unpublished']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>

                        <?php $jws_counter_yearly_statistics++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
