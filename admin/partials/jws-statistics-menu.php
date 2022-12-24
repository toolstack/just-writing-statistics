<?php

/**
 * This file is used to markup the menu of the plugin admin.
 *
 * @package    Just_Writing_Statistics
 * @subpackage Just_Writing_Statistics/admin/partials
 *
 * @link  https://toolstack.com/just-writing-statistics
 * @since 2.0.0
 */

$active_tab = array( 'top-content' => '','all-content' => '', 'monthly-statistics' => '', 'yearly-statistics' => '', 'author-statistics' => '', 'settings' => '' );

if (isset($jws_tab)) {
    $active_tab[$jws_tab] = ' nav-tab-active';
}

?>
<h2 class="nav-tab-wrapper">
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'top-content' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['top-content']; ?>"><?php _e('Top Content', $this->plugin_name); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'all-content' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['all-content']; ?>"><?php _e('All Content', $this->plugin_name); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'monthly-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['monthly-statistics']; ?>"><?php _e('Monthly Statistics', $this->plugin_name); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'yearly-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['yearly-statistics']; ?>"><?php _e('Yearly Statistics', $this->plugin_name); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'author-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['author-statistics']; ?>"><?php _e('Author Statistics', $this->plugin_name); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name.'-settings', 'tab' => 'settings' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['settings']; ?>"><?php _e('Settings', $this->plugin_name); ?></a>
</h2>