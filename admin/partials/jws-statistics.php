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

<div id="just-writing-statistics" class="wrap">
    <h1><?php _e('Just Writing Statistics', 'just-writing-statistics'); ?></h1>

<?php
    if( !isset($jws_tab)) {
        $jws_tab = '';
    }

    if( get_option( 'jws_stats_calculated' ) != true ) {
        echo '<div class="notice notice-error"><p>';
        _e('You need to calculate your word counts before you can start using the plugin.', 'just-writing-statistics');
        echo '</p></div>';

        include_once( 'jws-settings-calculate.php' );

    } else {
        switch( $jws_tab ) {
            case 'all-content':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-totals.php';
                include_once 'jws-statistics-all.php';

                break;
            case 'monthly-statistics':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-monthly.php';

                break;
            case 'yearly-statistics':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-yearly.php';

                break;
            case 'author-statistics':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-author.php';

                break;
            case 'tag-statistics':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-tags.php';

                break;
            case 'category-statistics':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-category.php';

                break;
            case 'frequency':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-frequency.php';

                break;
            case 'word-to-posts':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-word-to-posts.php';

                break;
            case 'about':
                include_once 'jws-statistics-menu.php';
                include_once 'jws-about.php';

                break;
            default:
                include_once 'jws-statistics-menu.php';
                include_once 'jws-statistics-totals.php';
                include_once 'jws-statistics-top.php';

                break;

        }
    }

    require_once 'jws-footer.php';
?>
</div>