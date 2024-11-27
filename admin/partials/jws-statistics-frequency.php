<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 5.0.0
 *
 * @package    Just_Writing_Statsitics_Pro
 * @subpackage Just_Writing_Statsitics_Pro/admin/partials
 */

?>
    <div>
        <div class="full jws-chart-container" id="JWSWordCloud">

            <h3><?php _e('Words Frequency Cloud', 'just-writing-statistics'); ?></h3>
            <canvas id="WordsByFrequencyChart"></canvas>

        </div>

    </div>
<?php
    $word_list = '[';
    $table_rows = '';
    $i = 0;
    $top_weight = $jws_dataset_word_frequency[array_key_first($jws_dataset_word_frequency)];

    foreach ($jws_dataset_word_frequency as $word => $frequency) {
      $size = round( $frequency / $top_weight * 400 );
      if ($size >= 16) {
        $word_list .= "['" . esc_js($word) . "', " . $size . '], ';
      } else {
        $word_list .= "['" . esc_js($word) . "', 16], ";
      }

      $i++;

      if ($i % 2) { $alternate = ' class="alternate"'; } else { $alternate = ""; }
      $table_rows .= '      <tr ' . $alternate . '>' . PHP_EOL;
      $table_rows .= '      <td>' . $i . '</td>' . PHP_EOL;
      $table_rows .= '      <td><a href="' . add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'word-to-posts', 'word' => urlencode($word) ), admin_url('admin.php')) . '">' . esc_html( $word ) . '</a></td>' . PHP_EOL;
      $table_rows .= '      <td>' . number_format($frequency) . '      </td>' . PHP_EOL;
      $table_rows .= '  </tr>' . PHP_EOL;
    }

    $word_list = substr( $word_list, 0, -2);
    $word_list .= ']';
?>

<script>
  // Grab the container and chart elements.
  const WordFrequencyContainer = document.getElementById('JWSWordCloud');
  const WordFrequencyChart = document.getElementById('WordsByFrequencyChart');

  // Output the word list and calculate a weight based on the largest frequency.
  var wordlist = <?php echo $word_list;?>;

  // Monitor the container for resizing, so we can redraw the word cloud.  Note, this will also draw
  // the word cloud for the first time since we're resizing the chart right after this code.
  const OnResize = new ResizeObserver(function(entries) {
    // since we are observing only a single element, so we access the first element in entries array
    let rect = entries[0].contentRect;

    WordFrequencyChart.width = rect.width;
    WordFrequencyChart.height = rect.width * 0.5;

    WordCloud(WordFrequencyChart, { list: wordlist, clearCanvas: true, shape: "square" } );
  });

  // Start watching for resize events
  OnResize.observe(WordFrequencyContainer);
</script>

    <div class="full">
        <div class="jws-table">
            <table class="widefat jws_wrapable">
                <thead>
                <tr>
                    <th colspan="3" class="jws_totals_title"><?php printf(__('Word Frequency (%d Unique Words)', 'just-writing-statistics'), count( $jws_dataset_word_frequency)); ?></th>
                </tr>
                <tr>
                    <th class="jws-rank"><?php _e('Rank', 'just-writing-statistics'); ?></th>
                    <th class="jws-word"><?php _e('Word', 'just-writing-statistics'); ?></th>
                    <th class="jws-frequency"><?php _e('Frequency', 'just-writing-statistics'); ?></th>
                </tr>
                </thead>

                <tbody>
                    <?php
                        echo $table_rows;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
