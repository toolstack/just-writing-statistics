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
        <div class="full jws-chart-container">

            <h3><?php _e('Words by Tag', 'just-writing-statistics'); ?></h3>
            <canvas id="WordsByTagChart"></canvas>

        </div>

    </div>
<?php
    $labels = array();
    $label_count = 0;
    $word_data = array();
    $max_word = 0;

    foreach( $jws_dataset_categories as $category_name => $category ) {
        $labels[] = $category_name;
        $label_count++;

        $word_data['published'][] = $category['published'];
        $word_data['scheduled'][] = $category['scheduled'];
        $word_data['unpublished'][] = $category['unpublished'];

        if( $category['total'] > $max_word ) { $max_word = $category['total']; }
    }

    if( $label_count <= 10 ) { $aspectRatio = 5; } else { $aspectRatio = 5 - floor( $label_count / 10 ); }
    if( $aspectRatio == 0 ) { $aspectRatio = 0.5 ;}
    if( $aspectRatio < 0 ) { $aspectRatio = 1 / abs($aspectRatio); }
?>

<script>
  const WordCountChart = document.getElementById('WordsByTagChart');

  new Chart(WordCountChart, {
    type: 'bar',
    data: {
      labels: <?php echo html_entity_decode( json_encode( $labels ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $word_data['published'] ) ); ?>,
          backgroundColor: '#0056a6',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $word_data['scheduled'] ) ); ?>,
          backgroundColor: '#63c5da',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $word_data['unpublished'] ) ); ?>,
          backgroundColor: '#151e3d',
        },
      ],
    },
    options: {
      indexAxis: 'y',
      aspectRatio: <?php echo $aspectRatio; ?>,
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
        <div class="jws-table">
            <table class="widefat jws-post-type-stats">
                <thead>
                    <tr>
                        <th colspan="<?php echo 2 + ( count( $jws_dataset_post_types ) * 3 );?>" class="jws_totals_title"><?php _e('Category Statistics', 'just-writing-statistics'); ?></th>
                    </tr>
                    <tr class="jws-table-stats-header-one">
                        <th></th>
                        <th></th>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th colspan="3" class="jws-post-type"><?php echo esc_html( $post_type['plural_name'] ); ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <tr class="jws-table-stats-header-two">
                        <th><?php _e('Category', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Words', 'just-writing-statistics'); ?></th>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th><?php _e('Published', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Scheduled', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Unpublished', 'just-writing-statistics'); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $jws_counter_monthly_statistics = 0; ?>
                    <?php foreach ($jws_dataset_categories as $category_name => $category) : ?>

                        <?php echo '<tr'.($jws_counter_monthly_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td>
                          <nobr><?php echo esc_html( $category_name ); ?>
                          <div class="row-actions">
                              <span class='view'><a href="<?php echo add_query_arg(array( 'taxonomy' => 'category', 'tag_ID' => $category['id'], 'post_type' => 'post' ), admin_url('term.php')); ?>"><?php _e('Edit', 'just-writing-statistics'); ?></a> | </span>
                              <span class="frequency"><a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'frequency', 'cat' => $category['id'] ), admin_url('admin.php')); ?>"><?php _e('Frequency Stats', 'just-writing-statistics'); ?></a></span>
                          </div>
                        </td>
                        <td><?php echo number_format($category['total']); ?></td>
                        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <td>
                            <?php echo (isset($category[$index]['published']['posts']) ? number_format(0 + $category[$index]['published']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($category[$index]['published']['word_count']) ? number_format(0 + $category[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($category[$index]['published']['posts']) && $category[$index]['published']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($category[$index]['published']['word_count'] / $category[$index]['published']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($category[$index]['scheduled']['posts']) ? number_format(0 + $category[$index]['scheduled']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($category[$index]['scheduled']['word_count']) ? number_format(0 + $category[$index]['scheduled']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($category[$index]['scheduled']['posts']) && $category[$index]['scheduled']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($category[$index]['scheduled']['word_count'] / $category[$index]['scheduled']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo (isset($category[$index]['unpublished']['posts']) ? number_format(0 + $category[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                            <?php echo (isset($category[$index]['unpublished']['word_count']) ? number_format(0 + $category[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                            <?php if (isset($category[$index]['unpublished']['posts']) && $category[$index]['unpublished']['posts'] != 0) : ?>
                                <?php echo number_format(round(0 + ($category[$index]['unpublished']['word_count'] / $category[$index]['unpublished']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
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
