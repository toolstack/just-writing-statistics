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
        <div class="half jws-chart-container">

            <h3><?php _e('Monthly Word Counts', 'just-writing-statistics'); ?></h3>
            <canvas id="MontlyWordCountChart"></canvas>

        </div>

        <div class="half jws-chart-container">

            <h3><?php _e('Monthly Item Counts', 'just-writing-statistics'); ?></h3>
            <canvas id="MontlyItemCountChart"></canvas>

        </div>
    </div>
<?php
    $labels = '';
    $word_data = '';
    $item_data = '';
    $max_word = 0;
    $max_item = 0;

    foreach( $arr_jws_months as $month_name => $month) {
        $labels = json_encode( $month_name ). ', ' . $labels;
        $word_data = json_encode( $month['total'] ) . ', ' . $word_data;
        $item_data = json_encode( $month['items'] ) . ', ' . $item_data;

        if( $month['total'] > $max_word ) { $max_word = $month['total']; }
        if( $month['items'] > $max_item ) { $max_item = $month['items']; }
    }

    $labels = trim( $labels, ', ' );
    $word_data = trim( $word_data, ', ' );
?>

<script>
  const WordCountChart = document.getElementById('MontlyWordCountChart');

  new Chart(WordCountChart, {
    type: 'line',
    data: {
      labels: [<?php echo $labels;?>],
      datasets: [
        {
          label: '<?php _e('Words','just-writing-statistics');?>',
          data: [<?php echo $word_data;?>],
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
      labels: [<?php echo $labels;?>],
      datasets: [
        {
          label: '<?php _e('Words','just-writing-statistics');?>',
          data: [<?php echo $item_data;?>],
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
        <h3><?php _e('Monthly Statistics', 'just-writing-statistics'); ?></h3>

        <div class="jws-table">
            <table class="widefat jws-post-type-stats">
                <thead>
                    <tr class="jws-table-stats-header-one">
                        <th></th>
                        <th></th>
                        <?php foreach ($arr_jws_post_types as $index => $post_type) : ?>
                        <th colspan="3" class="jws-post-type"><?php echo esc_html( $post_type['plural_name'] ); ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <tr class="jws-table-stats-header-two">
                        <th><?php _e('Month', 'just-writing-statistics'); ?></th>
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
                    <?php foreach ($arr_jws_months as $month_name => $month) : ?>

                        <?php echo '<tr'.($jws_counter_monthly_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td><nobr><?php echo esc_html( $month_name ); ?></td>
                        <td><?php echo number_format($month['total']); ?></td>
                        <?php foreach ($arr_jws_post_types as $index => $post_type) : ?>
                        <td>
                            <?php echo (isset($month[$index]['published']['posts']) ? number_format(0 + $month[$index]['published']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($month[$index]['published']['word_count']) ? number_format(0 + $month[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($month[$index]['published']['posts']) && $month[$index]['published']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($month[$index]['published']['word_count'] / $month[$index]['published']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($month[$index]['scheduled']['posts']) ? number_format(0 + $month[$index]['scheduled']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($month[$index]['scheduled']['word_count']) ? number_format(0 + $month[$index]['scheduled']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($month[$index]['scheduled']['posts']) && $month[$index]['scheduled']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($month[$index]['scheduled']['word_count'] / $month[$index]['scheduled']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($month[$index]['unpublished']['posts']) ? number_format(0 + $month[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($month[$index]['unpublished']['word_count']) ? number_format(0 + $month[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($month[$index]['unpublished']['posts']) && $month[$index]['unpublished']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($month[$index]['unpublished']['word_count'] / $month[$index]['unpublished']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
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
