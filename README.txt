=== WP Word Count ===
Contributors: linksoftware
Tags: word count, word statistics, author statistics, words, writing, nanowrimo
Requires at least: 4.0
Tested up to: 5.2.3
Stable tag: 3.1.0

Count the words on your WordPress site instantly.

== Description ==

If you own a WordPress site and like to write then WP Word Count is for you. WP Word Count tells you exactly how many words you've written on your site and comes with extra statistics giving you details by month and author.

## FEATURES

- Quickly see how many posts and pages you've created and how many total words they add up to.
- Support for custom post types so you can monitor word counts from content created by your themes and plugins.
- View your writing output for each month broken down by post type.
- See all of your site author's word counts with breakdowns by post type.

## WP WORD COUNT PRO

Upgrade to [WP Word Count Pro](https://wpwordcount.com) and get additional features to help you understand and analyze the amount of content you are producing for your site:

- You'll get complete control over which post types and statuses you see in your statistics through custom "Settings" options.
- WP Word Count Pro comes with detailed breakdowns of your monthly writing output by day, author, post type, category, tag and more.
- Each author that contributes to your site has their own personal stats page with information beyond just word count totals.
- All of your posts have expanded statistical details with revision history, post rankings and more.
- The achievement system in WP Word Count Pro gives you extra motivation to write more and increase your site's content.
- Charts and graphs are on nearly every screen of WP Word Count Pro to offer better data visualization.

You can learn more about WP Word Count Pro at [wpwordcount.com](https://wpwordcount.com)

== Installation ==

1. Upload `wp-word-count` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. WP Word Count can be accessed via the menu of the WordPress Admin.

== Frequently Asked Questions ==

= How does the WP Word Count Shortcode work? =

You can use the Shortcode [wpwordcount] to show the number of words on any page or post. The [wpwordcount] Shortcode 
can be extended with "before" and "after" attributes to add text or HTML before and after the count.

Example: [wpwordcount before="This post has" after=" total words."]

== Screenshots ==

1. WP Word Count
2. Monthly Statistics
3. Author Statistics

== Changelog ==

= 3.1.0 =
* New calculation options for sites with extremely large amounts of content.
* Menu changes.

= 3.0.2 =
* Interface changes.

= 3.0.1 =
* Interface changes and bug fixes.

= 3.0.0 =
* You can calculate your word counts any time you wish via the "Calculate" tab. This should help alleviate problems with plugin activation/updating on servers with limited resources.
* Automatically excluding common WordPress post types: Custom CSS, Navigation Menu Items.
* Support for Scheduled Posts.
* Support for Thrive Content Builder.
* Interface changes.
* General bug fixes.

= 2.1.0 =
* Improved word counts.
* Support for non-Latin languages.
* Interface changes.
* General bug fixes.

= 2.0.2 =
* Fixed critical performance bugs for WordPress Network installations.
* General bug fixes.

= 2.0.1 =
* Improvements to Custom Post Type statistics: posts without authors are now excluded to try and cut down on plugins that are using the _posts table to store their data.
* All plugin data is deleted on deactivation.
* General bug fixes.
* Minor interface changes.

= 2.0.0 =
* Complete code rewrite.
* Support for Custom Post Types.
* New Statistics Dashboard (now found on its own menu option).
* Removed Widget.
* New, and even more shameless, Plugs.

= 1.6 =
* Compatibility updates.

= 1.5 =
* Added ability to see word count statistics for All Posts and Pages.

= 1.4 =
* Fixed Display Bug in Plugins Page of WordPress Admin.

= 1.3 =
* Added [wpwordcount] Shortcode.
* Shameless Plugs.

= 1.2 =
* Added Widget.

= 1.1 =
* Added Monthly Statistics.

= 1.0 =
* Initial version.

== Upgrade Notice ==

= 3.0.0 =
New interface and adjustments to word count calculation to improve plugin performance.

= 2.0.0 =
Support for custom post types is finally here and the statistics have been redesigned.

= 1.3 =
Added a new [wpwordcount] Shortcode to show the number of words on any page or post.