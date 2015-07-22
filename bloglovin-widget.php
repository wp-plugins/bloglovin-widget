<?php
/*
Plugin Name: Bloglovin Widget
Plugin URI: http://wordpress.org/extend/plugins/bloglovin-widget/
Version: 1.1.3
Author: pipdig
Description: Display your Bloglovin' follower count in style.
Text Domain: bloglovin-widget
Author URI: http://www.pipdig.co/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2015 pipdig Ltd.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/**
 * Load plugin textdomain.
 *
 * @since 1.0
 */
function bloglovin_widget_plugin_textdomain() {
	$domain = 'bloglovin-widget';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	// wp-content/languages/plugin-name/plugin-name-en_GB.mo
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	// wp-content/plugins/plugin-name/languages/plugin-name-en_GB.mo
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'bloglovin_widget_plugin_textdomain' );


class pipdig_widget_bloglovin extends WP_Widget {
 
  public function __construct() {
      $widget_ops = array('classname' => 'pipdig_widget_bloglovin', 'description' => __("Display your Bloglovin' follower count.", 'bloglovin-widget') );
      $this->WP_Widget('pipdig_widget_bloglovin', __("Bloglovin' Widget", 'bloglovin-widget'), $widget_ops);
  }
  
  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);

    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');
   
    // The title, if any
    if (!empty($title)) {
		echo $before_title . $title . $after_title;
	}
	

		echo "This plugin has been discontinued. Please use the new <a href='https://wordpress.org/plugins/bloglovin-button/' target='_blank'>Bloglovin' Button</a> plugin instead.";

    // After widget code, if any
    echo (isset($after_widget)?$after_widget:'');
  }
 
  public function form( $instance ) {
   
    ?>

	<p>This widget has been discontinued. Please use the <a href='https://wordpress.org/plugins/bloglovin-button/' target='_blank'>Bloglovin' Button</a> plugin instead.</p>
	

     <?php
   
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    return $instance;
  }
  
}
add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_bloglovin");') );