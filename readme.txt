=== Plugin Name ===
Contributors: pipdig
Tags: bloglovin, widget, bloglovin widget, blogloving, followers, social, social counter, bloglovin follower count, bloglovin shortcode, bloglovin follow widget
Requires at least: 3.6
Tested up to: 4.2.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A Bloglovin' Widget for WordPress which automatically displays your total follower count. Also available as a shortcode.

== Description ==

After installing this plugin you will be able to display your total follower count from [Bloglovin'](https://www.bloglovin.com/) anywhere on your site.

Simply add the link to your Bloglovin' page and this plugin will automatically fetch your follower count once per hour.  You can then display this via two options:

1. Using our pre-styled Bloglovin' widget.
2. Display the follower count as plain text in any shortcode enabled area with `[bloglovin_count]`.

**Notes:**

1. This plugin is in no way affiliated with Bloglovin' and has been developed by [pipdig](http://www.pipdig.co?utm_source=wordpress&utm_medium=wprepo&utm_campaign=bloglovin).
2. The follower count is updated automatically once per hour via the WP Cron.
3. Need some help? Feel free to post any questions in the [Support Forum](https://wordpress.org/support/plugin/bloglovin-widget) and we will do our best to assist you.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add your Bloglovin' link to the options page under *Settings > Bloglovin*.
4. Add the shortcode `[bloglovin_count]` to any post/page or shortcode enabled area. This will display your total follower count in plain text.

== Frequently Asked Questions ==

= I changed the link to a different Bloglovin' profile, but my count hasn't updated? =

In order to reduce server load, this plugin will check and update your total follower count once per hour using the WP Cron.  Try visitng your home page, this usually updates the cron.

= I installed the plugin ...what now? =

After installing and activating the plugin, you will need to go to *Settings > Bloglovin'* in your WP dashboard. In this page, enter the link to your Blog's Bloglovin' profile (not your personal profile). Now your follower count will be fetched once per hour.

== Screenshots ==

1. Options screen.
2. Widget example. More styles coming soon!

== Changelog ==

= 1.0 =
* Initial release!
