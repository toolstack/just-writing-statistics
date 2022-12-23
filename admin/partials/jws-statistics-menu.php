<?php

/**
 * This file is used to markup the menu of the plugin admin.
 *
 * @link       https://toolstack.com/just-writing-statistics
 * @since      2.0.0
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin/partials
 */
?>

<h2 class="nav-tab-wrapper">
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'top-content' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'top-content' ? ' nav-tab-active' : ''; } ?>"><?php _e('Top Content', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'all-content' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'all-content' ? ' nav-tab-active' : ''; } ?>"><?php _e('All Content', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'monthly-statistics' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'monthly-statistics' ? ' nav-tab-active' : ''; } ?>"><?php _e('Monthly Statistics', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'author-statistics' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'author-statistics' ? ' nav-tab-active' : ''; } ?>"><?php _e('Author Statistics', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name.'-reading-time', 'tab' => 'reading-time' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'reading-time' ? ' nav-tab-active' : ''; } ?>"><?php _e('Reading Time', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name.'-calculate', 'tab' => 'calculate' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $jws_tab ) ) { echo $jws_tab == 'calculate' ? ' nav-tab-active' : ''; } ?>"><?php _e('Calculate', $this->plugin_name); ?></a>
</h2>