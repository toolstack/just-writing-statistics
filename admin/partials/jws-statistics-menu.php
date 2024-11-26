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

$active_tab = $this->allowed_tabs;

if (isset($jws_tab)) {
    $active_tab[$jws_tab] = ' nav-tab-active';
}

?>
<h2 class="nav-tab-wrapper">
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'top-content' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['top-content']; ?>"><?php _e('Top Content', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'all-content' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['all-content']; ?>"><?php _e('All Content', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'monthly-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['monthly-statistics']; ?>"><?php _e('Monthly', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'yearly-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['yearly-statistics']; ?>"><?php _e('Yearly', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'author-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['author-statistics']; ?>"><?php _e('Author', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'tag-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['tag-statistics']; ?>"><?php _e('Tags', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'category-statistics' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['category-statistics']; ?>"><?php _e('Categories', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'frequency' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['frequency']; ?>"><?php _e('Frequency', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name.'-settings', 'tab' => 'settings' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['settings']; ?>"><?php _e('Settings', 'just-writing-statistics'); ?></a>
    <a href="<?php echo add_query_arg(array( 'page' => $this->plugin_name, 'tab' => 'about' ), admin_url('admin.php')); ?>" class="nav-tab<?php echo $active_tab['about']; ?>"><?php _e('About', 'just-writing-statistics'); ?></a>
</h2>