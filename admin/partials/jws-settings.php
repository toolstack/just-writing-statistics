<?php

/**
 * Provide a settings view for the plugin
 *
 * This file is used to markup the settings view of the plugin.
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 3.2.0
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin/partials
 */
?>

<?php $jws_tab = 'settings'; ?>
<div id="just-writing-statistics" class="wrap">
    <h1><?php _e('Just Writing Statistics', 'just-writing-statistics'); ?></h1>

<?php
    if( get_option( 'jws_stats_calculated' ) != true ) {
        echo '<div class="notice notice-error"><p>';
        _e('You need to calculate your word counts before you can start using the plugin.', 'just-writing-statistics');
        echo '</p></div>';
    } else {
        require_once 'jws-statistics-menu.php';

        include_once( 'jws-settings-reading.php' );

        include_once( 'jws-settings-exclude.php' );

        include_once( 'jws-settings-roles.php');

        include_once( 'jws-settings-admin-options.php' );

        include_once( 'jws-settings-stopwords-options.php' );
    }

    include_once( 'jws-settings-calculate.php' );
?>
</div>