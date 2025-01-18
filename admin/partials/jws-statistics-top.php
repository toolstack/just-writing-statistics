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

            <h3><?php _e('Top Content Word Count', 'just-writing-statistics'); ?></h3>
            <canvas id="TopContentWordCountChart"></canvas>

        </div>

        <div class="half jws-chart-container">

            <h3><?php _e('Top Content Item Count', 'just-writing-statistics'); ?></h3>
            <canvas id="TopContentItemCountChart"></canvas>

        </div>

    </div>
<?php
    $labels = array();
    $count_data = array( 'Publish' => array(), 'Scheduled' => array(), 'Draft' => array() );
    $max_item = 0;

    foreach( $jws_dataset_post_types as $names ) {
        $labels[] = $names['plural_name'];
    }

    foreach( $jws_dataset_post_status as $post_type => $post_status ) {

        foreach( $post_status as $type => $count ) {
            $count_data[$type][] = $count['count'];

            if( $count['count'] > $max_item ) { $max_item = $count['count']; }
        }
    }
?>

<script>
  const ItemCountChart = document.getElementById('TopContentItemCountChart');

  new Chart(ItemCountChart, {
    type: 'bar',
    data: {
      labels: <?php echo html_entity_decode( json_encode( $labels ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $count_data['Publish'] ) );?>,
          backgroundColor: '#0056a6',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $count_data['Scheduled'] ) );?>,
          backgroundColor: '#63c5da',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $count_data['Draft'] ) ); ?>,
          backgroundColor: '#151e3d',
        },
      ],
    },
    options: {
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

<?php
    $words_data = array( 'Publish' => array(), 'Scheduled' => array(), 'Draft' => array() );
    $max_word = 0;

    foreach( $jws_dataset_post_status as $post_type => $post_status ) {

        foreach( $post_status as $type => $count ) {
            $words_data[$type][] = $count['words'];

            if( $count['words'] > $max_word ) { $max_word = $count['words']; }
       }
    }

?>

  const WordCountChart = document.getElementById('TopContentWordCountChart');

  new Chart(WordCountChart, {
    type: 'bar',
    data: {
      labels: <?php echo html_entity_decode( json_encode( $labels ) ); ?>,
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $words_data['Publish'] ) ); ?>,
          backgroundColor: '#0056a6',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $words_data['Scheduled'] ) ); ?>,
          backgroundColor: '#63c5da',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: <?php echo html_entity_decode( json_encode( $words_data['Draft'] ) ); ?>,
          backgroundColor: '#151e3d',
        },
      ],
    },
    options: {
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
        <table class="widefat jws_wrapable">
            <thead>
                <tr>
                    <th colspan="6" class="jws_totals_title"><?php _e('Top Content', 'just-writing-statistics'); ?></th>
                </tr>
                <tr>
                    <th class="jws-words"><?php _e('Words', 'just-writing-statistics'); ?></th>
                    <th class="jws-title"><?php _e('Title', 'just-writing-statistics'); ?></th>
                    <th class="jws-reading-time"><?php _e('Reading Time', 'just-writing-statistics'); ?></th>
                    <th class="jws-type"><?php _e('Type', 'just-writing-statistics'); ?></th>
                    <th class="jws-status"><?php _e('Status', 'just-writing-statistics'); ?></th>
                    <th class="jws-author"><?php _e('Author', 'just-writing-statistics'); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php $jws_counter_top_content = 0; ?>
            <?php foreach ($jws_dataset_posts as $index => $post) : ?>

                <?php echo '<tr'.($index % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                    <td><?php echo number_format($post['post_word_count']); ?></td>
                    <td>
                        <a href="<?php echo esc_attr( $post['permalink'] ); ?>"><?php echo esc_html( $post['post_title'] ? $post['post_title'] : __( '[No Title]', 'just-writing-statistics') ); ?></a>

                        <div class="row-actions">
                            <span class="edit"><?php edit_post_link(__('Edit', 'just-writing-statistics'), '', ' | ', $post['post_id']); ?></span>
                            <span class="trash"><a href="<?php echo get_delete_post_link($post['post_id']); ?>"><?php _e('Trash', 'just-writing-statistics'); ?></a> | </span>
                            <span class='view'><a href="<?php echo esc_attr( $post['permalink'] ); ?>"><?php _e('View', 'just-writing-statistics'); ?></a> | </span>
                            <span class="frequency"><a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'frequency', 'post' => $post['post_id'] ), admin_url('admin.php')); ?>"><?php _e('Frequency Stats', 'just-writing-statistics'); ?></a></span>
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
                <?php $jws_counter_top_content++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
