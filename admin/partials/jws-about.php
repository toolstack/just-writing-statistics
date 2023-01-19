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

<div id="just-writing-statistics" class="wrap">

    <div style="text-align: center;">
        <br>
        <img src="<?php echo esc_attr( plugins_url( '../images/icon-256x256.png', __FILE__ ) ); ?>">

        <h2><?php printf( esc_html__( 'Just Writing Statistics V%s', 'just-writing-statistics' ), JWS_VERSION ); ?></h2>
        <p><?php esc_html_e( 'a fork of', ''); ?> <a href="https://wpwordcount.com">WP Word Count</a></p>
        <p><?php esc_html_e( 'by', ''); ?> <a href="https://toolstack.com">Greg Ross</a></p>
        <hr />
        <div style="display: inline-block; text-align: left;">
            <h2><?php esc_html_e( 'Rate and Review at WordPress.org', 'just-writing-statistics' ); ?></h2>
            <p><?php esc_html_e( 'Thanks for installing Just Writing Statistics, I encourage you to submit a ', 'just-writing-statistics' );?> <a href="http://wordpress.org/support/view/plugin-reviews/just-writing-statistics" target="_blank"><?php _e( 'rating and review', 'just-writing-statistics' ); ?></a> <?php _e( 'over at WordPress.org.  Your feedback is greatly appreciated!', 'just-writing-statistics' );?></p>
            <h2><?php esc_html_e( 'Support', 'just-writing-statistics' ); ?></h2>
            <p><?php esc_html_e( 'Here are a few things to do submitting a support request', 'just-writing-statistics' ) . ':'; ?></p>

            <ul style="list-style-type: disc; list-style-position: inside; padding-left: 25px;">
                <li><?php printf( esc_html__( 'Have you search the %s for a similar issue?', 'just-writing-statistics' ), '<a href="http://wordpress.org/support/plugin/just-writing-statistics" target="_blank">' . __( 'support forum', 'just-writing-statistics' ) . '</a>');?></li>
                <li><?php esc_html_e( 'Have you search the Internet for any error messages you are receiving?', 'just-writing-statistics' );?></li>
                <li><?php esc_html_e( 'Make sure you have access to your PHP error logs.', 'just-writing-statistics' );?></li>
            </ul>

            <p><?php esc_html_e( 'And a few things to double-check:' );?></p>

            <ul style="list-style-type: disc; list-style-position: inside; padding-left: 25px;">
                <li><?php esc_html_e( 'Have you double checked the plugin settings?', 'just-writing-statistics' );?></li>
                <li><?php esc_html_e( 'Do you have all the required PHP extensions installed?', 'just-writing-statistics' );?></li>
                <li><?php esc_html_e( 'Are you getting a blank or incomplete page displayed in your browser?  Did you view the source for the page and check for any fatal errors?', 'just-writing-statistics' );?></li>
                <li><?php esc_html_e( 'Have you checked your PHP and web server error logs?', 'just-writing-statistics' );?></li>
            </ul>

            <p><?php esc_html_e( 'Still not having any luck?', 'just-writing-statistics' );?> <?php printf( __( 'Then please open a new thread on the %s.', 'just-writing-statistics' ), '<a href="http://wordpress.org/support/plugin/just-writing-statistics" target="_blank">' . __( 'WordPress.org support forum', 'just-writing-statistics' ) . '</a>');?></p>
        </div>
    </div>

</div>