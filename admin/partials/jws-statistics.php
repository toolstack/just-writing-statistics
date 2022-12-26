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

<div id="just-writing-statistics" class="wrap">
    <h1><?php _e('Just Writing Statistics', $this->plugin_name); ?></h1>

<?php
    if( !isset($jws_tab)) {
        $jws_tab = '';
    }

    if ((isset($arr_jws_posts) && @count($arr_jws_posts)) ||
        (isset($arr_jws_months) && @count($arr_jws_months)) ||
        (isset($arr_jws_years) && @count($arr_jws_years)) ||
        (isset($arr_jws_authors) && @count($arr_jws_authors))) {

        include_once 'jws-statistics-menu.php';
    }

    switch( $jws_tab ) {
        case 'top-content':
            include_once 'jws-statistics-totals.php';
            include_once 'jws-statistics-top.php';

            break;
        case 'all-content':
            include_once 'jws-statistics-totals.php';
            include_once 'jws-statistics-all.php';

            break;
        case 'monthly-statistics':
            include_once 'jws-statistics-monthly.php';

            break;
        case 'yearly-statistics':
            include_once 'jws-statistics-yearly.php';

            break;
        case 'author-statistics':
            include_once 'jws-statistics-author.php';

            break;
        default:
            $link_calculate = add_query_arg(['page' => $this->plugin_name . '-calculate'], admin_url('admin.php'));

            echo '<p>';
            printf(__('You need to <a href="%s">calculate</a> your word counts before you can start using the plugin.', $this->plugin_name), esc_url($link_calculate));
            echo '</p>';

    }

    require_once 'jws-footer.php';
?>
</div>