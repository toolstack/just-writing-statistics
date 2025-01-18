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

            <h3><?php _e('Words by Author', 'just-writing-statistics'); ?></h3>
            <canvas id="AuthorWordCountChart"></canvas>

        </div>

        <div class="half jws-chart-container">

            <h3><?php _e('Items by Author', 'just-writing-statistics'); ?></h3>
            <canvas id="AuthorItemCountChart"></canvas>

        </div>
    </div>
<?php
    $labels = array();
    $word_data = array();
    $item_data = array();
    $max_word = 0;
    $max_item = 0;

    foreach( $jws_dataset_authors as $index => $author) {
        $labels[] = $author['display_name'];
        $word_data[] = $author['total'];
        $item_data[] = $author['items'];

        if( $max_word < $author['total'] ) { $max_word = $author['total']; }
        if( $max_item < $author['items'] ) { $max_item = $author['items']; }
    }

?>

<script>
  const WordCountChart = document.getElementById('AuthorWordCountChart');

  new Chart(WordCountChart, {
    type: 'polarArea',
    data: {
      labels: <?php echo html_entity_decode( json_encode( $labels ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Words','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $word_data ) ); ?>,
          backgroundColor: [<?php
            foreach( $labels as $label ) {
              echo "\n              '#" . substr( dechex( crc32( $label ) ), 0, 6) . "',";
            }
            echo "\n";
?>
            ]
          },
      ],
    },
    options: {
      aspectRatio: 1.5,
      scale: {
        ticks: {
          stepSize: <?php echo $this->calculate_chart_step_size( $max_word );?>
        }
      }
    },
  });

  const ItemCountChart = document.getElementById('AuthorItemCountChart');

  new Chart(ItemCountChart, {
    type: 'polarArea',
    data: {
      labels: <?php echo html_entity_decode( json_encode( $labels ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Words','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $item_data ) ); ?>,
          backgroundColor: [<?php
            foreach( $labels as $label ) {
              echo "\n              '#" . substr( dechex( crc32( $label ) ), 0, 6) . "',";
            }
            echo "\n";
?>
            ]
        },
      ],
    },
    options: {
      aspectRatio: 1.5,
      scale: {
        ticks: {
          stepSize: <?php echo $this->calculate_chart_step_size( $max_item );?>
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
                        <th colspan="<?php echo 2 + ( count( $jws_dataset_post_types ) * 3 );?>" class="jws_totals_title"><?php _e('Author Statistics', 'just-writing-statistics'); ?></th>
                    </tr>
                    <tr class="jws-table-stats-header-one">
                        <th></th>
                        <th></th>
        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th colspan="3" class="jws-post-type"><?php echo esc_html( $post_type['plural_name'] ); ?></th>
        <?php endforeach; ?>
                    </tr>

                    <tr class="jws-table-stats-header-two">
                        <th><?php _e('Author', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Words', 'just-writing-statistics'); ?></th>
        <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <th><?php _e('Published', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Scheduled', 'just-writing-statistics'); ?></th>
                        <th><?php _e('Unpublished', 'just-writing-statistics'); ?></th>
        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
        <?php $jws_counter_author_statistics = 0; ?>
        <?php foreach ($jws_dataset_authors as $index => $author) : ?>

                    <?php echo '<tr'.($jws_counter_author_statistics % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                        <td><nobr>
                            <?php echo get_avatar($index, 32, 'mysteryman', $author['display_name'], ['class' => 'avatar avatar-32 photo']); ?>
                            <?php echo esc_html( $author['display_name'] ); ?>
                            <div class="row-actions">
                              <span class='view'><a href="<?php echo add_query_arg(array( 'user_id' => $author['id'] ), admin_url('user-edit.php')); ?>"><?php _e('Edit', 'just-writing-statistics'); ?></a> | </span>
                              <span class="frequency"><a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'frequency', 'author' => $author['login'] ), admin_url('admin.php')); ?>"><?php _e('Frequency Stats', 'just-writing-statistics'); ?></a></span>
                            </div>
                        </td>
                        <td><?php echo number_format($author['total']); ?></td>
            <?php foreach ($jws_dataset_post_types as $index => $post_type) : ?>
                        <td>
                <?php echo (isset($author[$index]['published']['posts']) ? number_format(0 + $author[$index]['published']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                <?php echo (isset($author[$index]['published']['word_count']) ? number_format(0 + $author[$index]['published']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                <?php if (isset($author[$index]['published']['posts']) && $author[$index]['published']['posts'] != 0) : ?>
                    <?php echo number_format(round(0 + ($author[$index]['published']['word_count'] / $author[$index]['published']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                <?php endif; ?>
                        </td>
                        <td>
                <?php echo (isset($author[$index]['scheduled']['posts']) ? number_format(0 + $author[$index]['scheduled']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                <?php echo (isset($author[$index]['scheduled']['word_count']) ? number_format(0 + $author[$index]['scheduled']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                <?php if (isset($author[$index]['scheduled']['posts']) && $author[$index]['scheduled']['posts'] != 0) : ?>
                    <?php echo number_format(round(0 + ($author[$index]['scheduled']['word_count'] / $author[$index]['scheduled']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                <?php endif; ?>
                        </td>
                        <td>
                <?php echo (isset($author[$index]['unpublished']['posts']) ? number_format(0 + $author[$index]['unpublished']['posts']) : '0'); ?> <?php _e('Total', 'just-writing-statistics'); ?><br />
                <?php echo (isset($author[$index]['unpublished']['word_count']) ? number_format(0 + $author[$index]['unpublished']['word_count']) : '0'); ?> <?php _e('Words', 'just-writing-statistics'); ?><br />
                <?php if (isset($author[$index]['unpublished']['posts']) && $author[$index]['unpublished']['posts'] != 0) : ?>
                    <?php echo number_format(round(0 + ($author[$index]['unpublished']['word_count'] / $author[$index]['unpublished']['posts']))); ?> <?php _e('Average', 'just-writing-statistics'); ?>
                <?php endif; ?>
                        </td>
            <?php endforeach; ?>
                    </tr>

            <?php $jws_counter_author_statistics++; ?>
        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>