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

Simply add the link to your Bloglovin' page and this plugin will automatically fetch your follower count.

You can then display this as a widget anywhere you like.

You can also call the number in plain text by:

2. Using the shortcode `[bloglovin_count]`.
3. Calling `do_action('bloglovin_count_here');` in any theme/plugin file.

Note: This plugin is in no way affiliated with Bloglovin' and was created by [pipdig](http://www.pipdig.co?utm_source=wordpress&utm_medium=wprepo&utm_campaign=bloglovin).

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add your Bloglovin' link to the options page under *Settings > Bloglovin*.
4. You can now add use the widget called `Bloglovin' Widget` anywhere you like. You can choose from a range of styles in this widget, or you can just display the number by itself by using the shortcode `[bloglovin_count]`.

== Frequently Asked Questions ==

= I installed the plugin ...what now? =

After installing and activating the plugin, you will need to go to *Settings > Bloglovin'* in your WP dashboard. On this page, enter the link to your Blog's Bloglovin' profile (not your personal profile). Now your follower count will be fetched twice per day. You can display this via our widget, shortcode or by calling a php function.

= Do I need to log in to Bloglovin' or enter my user details? =

Nope! This plugin won't request any details other than a link to your blog's profile on Bloglovin'.  Simple as that.

= Why hasn't my follower count updated? =

The follower count is updated twice per day via the WordPress cron. Try visitng your site in a few hours time and see if it updates then.  If it still won't work, feel free to [contact us](https://wordpress.org/support/plugin/bloglovin-widget) and we'll be happy to help :)

== Screenshots ==

1. Widget options. More styles coming soon!

== Changelog ==

= 1.0 =
* Initial release!
