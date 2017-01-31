# WP Word Count
Contributors: linksoftware  
Tags: word count, word stats, word statistics, author stats, author statistics, words, stats, statistics
Requires at least: 2.8  
Tested up to: 4.7.2  
Stable tag: 2.0.2

WP Word Count is a WordPress plugin for word count statistics on blog posts, pages and custom post types.

## Description

WP Word Count is a WordPress plugin for word count statistics on blog posts, pages and custom post types.

###Total & Individual Word Counts for All Content###
Quickly see how many posts and pages you've created and how many total words they add up to. Track all of your content sorted from largest word count down to the smallest.

###Statistics by Month & Author###
View your writing output for each month broken down by post, page and custom post type. Each writer on your site has their total word count statistics calculated across all of your forms of content.

###Simple Download and Setup###
Start tracking your blog's word counts today with WP Word Count. You can learn more at [wpwordcount.com](http://wpwordcount.com)

## Installation

1. Upload `wpwordcount` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. WP Word Count can be accessed via the menu of the WordPress Admin.

## Frequently Asked Questions

### How does the WP Word Count Shortcode work?

You can use the Shortcode [wpwordcount] to show the number of words on any page or post. The [wpwordcount] Shortcode 
can be extended with "before" and "after" attributes to add text or HTML before and after the count.

Example: [wpwordcount before="This post has" after=" total words."]

## Screenshots

1. Main Word Count Statistics
2. Content Statistics
3. Monthly Statistics
4. Author Statistics

## Changelog

### 2.0.2
* Fixed critical performance bugs for WordPress Network installations.
* General bug fixes.

### 2.0.1
* Improvements to Custom Post Type statistics: posts without authors are now excluded to try and cut down on plugins that are using the _posts table to store their data.
* All plugin data is deleted on deactivation.
* General bug fixes.
* Minor interface changes.

### 2.0.0
* Complete code rewrite.
* Support for Custom Post Types.
* New Statistics Dashboard (now found on its own menu option).
* Removed Widget.
* New, and even more shameless, Plugs.

### 1.6
* Compatibility updates.

### 1.5
* Added ability to see word count statistics for All Posts and Pages.

### 1.4
* Fixed Display Bug in Plugins Page of WordPress Admin.

### 1.3
* Added [wpwordcount] Shortcode.
* Shameless Plugs.

### 1.2
* Added Widget.

### 1.1
* Added Monthly Statistics.

### 1.0
* Initial version.

## Upgrade Notice

### 2.0.0
Support for custom post types is finally here and the statistics have been redesigned.

### 1.3
Added a new [wpwordcount] Shortcode to show the number of words on any page or post.