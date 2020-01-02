<?php

/**
 * This file is used to markup the menu of the plugin admin.
 *
 * @link       https://wpwordcount.com
 * @since      2.0.0
 *
 * @package    Wp_Word_Count
 * @subpackage Wp_Word_Count/admin/partials
 */
?>

<h2 class="nav-tab-wrapper">
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'top-content' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'top-content' ? ' nav-tab-active' : ''; } ?>"><?php _e('Top Content', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'all-content' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'all-content' ? ' nav-tab-active' : ''; } ?>"><?php _e('All Content', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'monthly-statistics' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'monthly-statistics' ? ' nav-tab-active' : ''; } ?>"><?php _e('Monthly Statistics', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name, 'tab' => 'author-statistics' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'author-statistics' ? ' nav-tab-active' : ''; } ?>"><?php _e('Author Statistics', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name.'-reading-time', 'tab' => 'reading-time' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'reading-time' ? ' nav-tab-active' : ''; } ?>"><?php _e('Reading Time', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name.'-calculate', 'tab' => 'calculate' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'calculate' ? ' nav-tab-active' : ''; } ?>"><?php _e('Calculate', $this->plugin_name); ?></a>
	<a href="<?php echo add_query_arg( array( 'page' => $this->plugin_name.'-upgrade', 'tab' => 'upgrade' ), admin_url('admin.php') ); ?>" class="nav-tab<?php if ( isset( $wpwc_tab ) ) { echo $wpwc_tab == 'upgrade' ? ' nav-tab-active' : ''; } ?>"><?php _e('Upgrade to Pro', $this->plugin_name); ?></a>
</h2>