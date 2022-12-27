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

            <h3><?php _e('Top Content Item Count', 'just-writing-statistics'); ?></h3>
            <canvas id="TopContentItemCountChart"></canvas>

        </div>

        <div class="half jws-chart-container">

            <h3><?php _e('Top Content Word Count', 'just-writing-statistics'); ?></h3>
            <canvas id="TopContentWordCountChart"></canvas>

        </div>
    </div>
<?php
    $labels = '';
    $count_data = array();

    foreach( $arr_jws_post_types as $names ) {
        $labels .= '\'' . $names['plural_name'] . '\', ';
    }

    foreach( $arr_jws_post_status as $post_type => $post_status ) {

        foreach( $post_status as $type => $count ) {
            $count_data[$type] .= '\'' . $count['count'] . '\', ';
        }
    }

    $labels = trim( $labels, ', ' );

?>

<script>
  const ItemCountChart = document.getElementById('TopContentItemCountChart');

  new Chart(ItemCountChart, {
    type: 'bar',
    data: {
      labels: [<?php echo $labels;?>],
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: [<?php echo $count_data['Publish'];?>],
          backgroundColor: '#00ff00',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: [<?php echo $count_data['Scheduled'];?>],
          backgroundColor: '#0000ff',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: [<?php echo $count_data['Draft'];?>],
          backgroundColor: '#ff0000',
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
        },
        x: {
          stacked: true,
        }
      }
    },
  });

<?php
    $words_data = array();

    foreach( $arr_jws_post_status as $post_type => $post_status ) {

        foreach( $post_status as $type => $count ) {
            $words_data[$type] .= '\'' . $count['words'] . '\', ';
        }
    }

?>

  const WordCountChart = document.getElementById('TopContentWordCountChart');

  new Chart(WordCountChart, {
    type: 'bar',
    data: {
      labels: [<?php echo $labels;?>],
      datasets: [
        {
          label: '<?php _e('Published','just-writing-statistics');?>',
          data: [<?php echo $words_data['Publish'];?>],
          backgroundColor: '#00ff00',
        },
        {
          label: '<?php _e('Scheduled','just-writing-statistics');?>',
          data: [<?php echo $words_data['Scheduled'];?>],
          backgroundColor: '#0000ff',
        },
        {
          label: '<?php _e('Unpublished','just-writing-statistics');?>',
          data: [<?php echo $words_data['Draft'];?>],
          backgroundColor: '#ff0000',
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
        },
        x: {
          stacked: true,
        }
      }
    },
  });
</script>

    <div class="full">
        <h3><?php _e('All Content', 'just-writing-statistics'); ?></h3>

        <table class="widefat">
            <thead>
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
            <?php foreach ($arr_jws_posts as $index => $post) : ?>

                <?php echo '<tr'.($index % 2 == 1 ? '' : " class='alternate'").'>'; ?>
                    <td><?php echo number_format($post['post_word_count']); ?></td>
                    <td>
                        <a href="<?php echo $post['permalink']; ?>"><?php echo $post['post_title']; ?></a>

                        <div class="row-actions">
                            <span class="edit"><?php edit_post_link(__('Edit', 'just-writing-statistics'), '', ' | ', $post['post_id']); ?></span>
                            <span class="trash"><a href="<?php echo get_delete_post_link($post['post_id']); ?>"><?php _e('Trash', 'just-writing-statistics'); ?></a> | </span>
                            <span class='view'><a href="<?php echo $post['permalink']; ?>"><?php _e('View', 'just-writing-statistics'); ?></a></span>
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

