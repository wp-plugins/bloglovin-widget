=== Plugin Name ===
Contributors: pipdig
Donate link: http://www.pipdig.co/coffee/
Tags: bloglovin, bloglovin widget, blogloving, followers, social, social counter, bloglovin follower count, bloglovin shortcode, bloglovin follow widget
Requires at least: 3.6
Tested up to: 4.2.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically displays your Bloglovin' follower count in either a widget or shortcode. Updates automatically!

== Description ==

Tired of updating your [Bloglovin'](https://www.bloglovin.com/) follower count manually? Well now you don't have to! Simply add the link to your blog's Bloglovin' page and this plugin will automatically fetch your follower count once per hour.  You can then display this via two options:

1. Using our pre-styled Bloglovin' widget.
2. Display the follower count as plain text in any shortcode enabled area with `[bloglovin_count]`.

**Notes:**

1. This plugin is in no way affiliated with Bloglovin' and has been developed by [pipdig](http://www.pipdig.co/).
2. The follower count is updated automatically once per hour via the WP Cron.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add your Bloglovin' link to the options page under *Settings > Bloglovin*.
4. Add the shortcode `[bloglovin_count]` to any post/page or shortcode enabled area. This will display your total follower count in plain text.

== Frequently Asked Questions ==

= I changed the link to a different Bloglovin' profile, but my count hasn't updated? =

In order to reduce server load, this plugin will check and update your total follower count once per hour using the WP Cron.

== Screenshots ==

1. Options screen.
2. Shortcode usage example.

== Changelog ==

= 1.0 =
* Initial release!
