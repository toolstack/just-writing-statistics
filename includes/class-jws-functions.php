<?php

/**
 * The core plugin functions.
 *
 * This is used to define functions for database issues on the admin and public side.
 *
 * @since      3.0.0
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/includes
 * @link       https://toolstack.com/just-writing-statistics
 * @author     GregRoss, RedLettuce
 */

/**
 * Maintain our post plugin table with post-related information
 *
 * @since 3.0.0
 * @param post $post The post object.
 */
function jws_save_post_data($post)
{
    global $wpdb;

    $table_name_posts = $wpdb->prefix . 'jws_posts';

    if ($post && $post->post_author != 0) {
        $post_word_count = jws_word_count($post->post_content);

        // If Thrive Content Builder data is available, add to total
        if ($tve = get_post_meta($post->ID, 'tve_updated_post', true)) {
            $post_word_count = $post_word_count + jws_word_count($tve);
        }

        $sql_post_data = "
			INSERT INTO $table_name_posts (post_id, post_author, post_date, post_status, post_modified, post_parent, post_type, post_word_count)
			VALUES (%d, %d, %s, %s, %s, %s, %s, %d)
			ON DUPLICATE KEY UPDATE
			post_author = %s,
			post_date = %s,
			post_status = %s,
			post_modified = %s,
			post_parent = %d,
			post_type = %s,
			post_word_count = %d";

        $post_data = $wpdb->prepare($sql_post_data, $post->ID, $post->post_author, $post->post_date, $post->post_status, $post->post_modified, $post->post_parent, $post->post_type, $post_word_count, $post->post_author, $post->post_date, $post->post_status, $post->post_modified, $post->post_parent, $post->post_type, $post_word_count);

        $wpdb->query($post_data);
    }
}

/**
 * Calculate word count in a given set of text.
 *
 * @since 3.0.0
 * @param string $content The post content
 */
function jws_word_count($content)
{
    // Create a space between any back to back tags ie. "</b><i>" becomes "</b> <i>".
    $content = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $content);
    // Add breaks to newlines and then strip all the tags.
    $content = strip_tags(nl2br($content));
    // Now trim the remaining string so we don't have extra line breaks at the start/end.
    $content = trim( $content );

    if (preg_match("/[\x{4e00}-\x{9fa5}]+/u", $content)) {
        // If there are non-english characters in the content, split them up and count them as words.
        $content = preg_replace('/[\x80-\xff]{1,3}/', ' ', $content, -1, $n);

        // Count any english words.
        $n += str_word_count($content);

        return $n;
    } else if( $content === '' ) {
        // If we have an empty string, return 0.  This has to be handled separately from the default
        // case as preg_split() always returns at lest 1 result, an empty string.
        return 0;
    } else {
        // Use preg_split() to break the string on whitespaces and then count the results.
        return count(preg_split('/\s+/', $content));
    }
}

/**
 * Store the plugin version as an option.
 *
 * @since 3.0.0
 * @param string $wpwcp_version The latest plugin version.
 */
function jws_set_plugin_version($jws_version)
{
    update_option('jws_version', $jws_version);
}

/**
 * Create the posts table for our plugin data.
 *
 * @since 3.0.0
 */
function jws_create_posts_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix.'jws_posts';

    // Create database table
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		post_id bigint(20) NOT NULL,
		post_author bigint(20) NOT NULL,
		post_date datetime NOT NULL,
		post_status varchar(20) NOT NULL,
		post_modified datetime NOT NULL,
		post_parent bigint(20) NOT NULL,
		post_type varchar(20) NOT NULL,
		post_word_count bigint(20) NOT NULL,
		UNIQUE KEY post_id (post_id)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
}

/**
 * Get total word count for a given post.
 *
 * @since 3.0.0
 */
function jws_calculate_word_count_post($post)
{
    global $wpdb;

    $words = 0;

    $table_name = $wpdb->prefix.'jws_posts';

    $sql_jws_words = $wpdb->prepare("SELECT post_word_count FROM $table_name WHERE post_id = %d", $post->ID);
    $jws_words = $wpdb->get_row($sql_jws_words);

    if($jws_words != null) {
        $words = $jws_words->post_word_count;
    }

    return $words;
}

/**
 * Get reading time of a piece of text.
 *
 * @since 3.2.0
 */
function jws_reading_time( $word_count, $wpm = 250, $format = 'admin' )
{
    $html = '';

    // Calculate the number of words per minute and second.
    $init_m = floor( $word_count / $wpm );

    // Hours is going to be the floor of wpm / 60.
    $hours = floor( $init_m / 60 );
    // Minutes is going to be the round of the modulus of wpm.
    $minutes = round( $init_m % 60 );

    if( $hours > 1 ) {
        $hour_format = __( '%1$d hours', 'just-writing-statistics' );
    } else {
        $hour_format = __( '%1$d hour', 'just-writing-statistics' );
    }

    if( $minutes > 1 ) {
        $minute_format = __( '%1$d minutes', 'just-writing-statistics' );
    } else {
        $minute_format = __( '%1$d minute', 'just-writing-statistics' );
    }

    if( $minutes > 1 && $hours > 1 ) {
        $combined_format = __( '%1$d hours, %2$d minutes', 'just-writing-statistics' );
    } else if( $minutes > 1 && $hours == 0 ) {
        $combined_format = __( '%1$d hour, %2$d minutes', 'just-writing-statistics' );
    } else if ( $minutes == 0 && $hours > 1 ) {
        $combined_format = __( '%1$d hours, %2$d minute', 'just-writing-statistics' );
    } else {
        $combined_format = __( '%1$d hour, %2$d minute', 'just-writing-statistics' );
    }

    if( $format == 'admin' ) {
        if( $minutes == 0 ) {
            $html = __( '<1 minute', 'just-writing-statistics' );
        } else {
            if( $hours == 0 ) {
                $html = sprintf( $minute_format, number_format( $minutes ) );
            } else if( $minutes == 0 ) {
                $html = sprintf( $hour_format, number_format( $hours ) );
            } else {
                $html = sprintf( $combined_format, number_format( $hours ), number_format( $minutes ) );
            }
        }
    } else {
        if( $minutes == 0 ) {
            $html = '<1';
        } else {
            $html = number_format( ( $hours * 60 ) + $minutes );
        }
    }

    return $html;
}
