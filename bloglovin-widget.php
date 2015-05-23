<?php
/*
Plugin Name: Bloglovin Widget
Plugin URI: http://wordpress.org/extend/plugins/bloglovin-widget/
Version: 1.1.1
Author: pipdig
Description: Display your Bloglovin follower count via a widget or shortcode.
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


/**
 * Add options page.
 *
 * @since 1.0
 */
add_action('admin_menu', 'pipdig_bloglovin_menu');
function pipdig_bloglovin_menu() {
	add_options_page("Bloglovin'", "Bloglovin'", 'manage_options', 'bloglovin-widget', 'pipdig_bloglovin_menu_page');
}

function pipdig_bloglovin_menu_page() {

    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $hidden_field_name = 'pipdig_submit_hidden';
    $data_field_name = 'pipdig_bloglovin_url';

    // Read in existing option value from database
    $opt_val = get_option( 'pipdig_bloglovin_plugin_url' );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = sanitize_text_field( $_POST[ $data_field_name ] );
		
        // Save the posted value in the database
        update_option( 'pipdig_bloglovin_plugin_url', $opt_val );

        // Put an settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Settings saved.'); ?></strong></p></div>
<?php
	// initial scrape on save (can we function this?)
	if ($opt_val) {
		$bloglovin = file_get_contents($opt_val);
		$bloglovin_doc = new DOMDocument();

		libxml_use_internal_errors(TRUE);

		if(!empty($bloglovin)){
			$bloglovin_doc->loadHTML($bloglovin);
			libxml_clear_errors();
			$bloglovin_xpath = new DOMXPath($bloglovin_doc);
			$bloglovin_row = $bloglovin_xpath->query('//div[@class="num"]');

			if($bloglovin_row->length > 0){
				foreach($bloglovin_row as $row){
					$followers = $row->nodeValue;
					$followers = str_replace(' ', '', $followers);
					$followers_int = intval( $followers );
					update_option('pipdig_bloglovin_follower_count', $followers_int);
					
				}
			}
		}
    }
	
	}

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( "Enter the link to your blog's feed on Bloglovin'", 'bloglovin-widget' ) . "</h2>";

    // settings form
    
    ?>
<p><?php _e("For example:", 'bloglovin-widget' ); ?> <a href="https://www.bloglovin.com/blogs/lovecats-inc-uk-fashion-beauty-blog-3890264" target="_blank">https://www.bloglovin.com/blogs/lovecats-inc-uk-fashion-beauty-blog-3890264</a></p>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p><?php _e("Bloglovin' link:", 'bloglovin-widget' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" placeholder="https://www.bloglovin.com/blogs/lovecats-inc-uk-fashion-beauty-blog-3890264" size="100">
</p>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
<p style="font-style:italic;"><?php _e("Do you speak multiple languages? We are looking for people to translate this plugin. <a href='http://www.pipdig.co/contact' target='_blank'>Contact us</a> for details.", 'bloglovin-widget'); ?></p>
<hr>
<?php $bloglovin_count = get_option('pipdig_bloglovin_follower_count'); ?>
<?php if ($bloglovin_count) { ?>
<h2><?php _e("Total count:", 'bloglovin-widget' ); ?></strong> <?php echo $bloglovin_count; ?></h2>
<p><?php $widgets_url = admin_url( 'widgets.php' ); printf(__("Success! You can now use the widget to display your count by going to the <a href='%s'>Widgets section</a> of the dashboard.", 'bloglovin-widget'), $widgets_url ); ?></p>
<p><?php _e("You can also display your count in any post/page by using the shortcode <strong>[bloglovin_count]</strong>.", 'bloglovin-widget' ); ?></p>
<?php // do_action('bloglovin_count_here'); ?>
<?php } else { ?>
<p><?php _e("Your total follower count will be displayed here after you add your link above and click save", 'bloglovin-widget' ); ?>.</p>
<?php } //end if ?>
</form>
</div>
<hr>
<div>
<h2><?php _e('Looking for a more professional WordPress theme?', 'bloglovin-widget' ); ?></h2>
<p><?php _e("Get 10&#37; off any order at <a href='http://www.pipdig.co/products/premade-wordpress-themes/?utm_source=wordpress&utm_medium=bloglovin&utm_campaign=bloglovin' target='_blank'>www.pipdig.co</a> by using coupon code 'nextlevel'.", 'bloglovin-widget'); ?></p>
<a href="http://www.pipdig.co/products/premade-wordpress-themes/?utm_source=wordpress&utm_medium=bloglovin&utm_campaign=bloglovin" target="_blank"><img src="http://pipdigz.co.uk/img/bloglovin-widget-banner1.png"/></a>
</div>
<?php
}


/**
 * The count
 *
 * @since 1.0
 */
// On an early action hook, check if the hook is scheduled - if not, schedule it.
add_action( 'wp', 'pipdig_bl_plugin_setup_schedule' );
function pipdig_bl_plugin_setup_schedule() {
	if ( ! wp_next_scheduled( 'pipdig_bl_plugin_twicedaily_event' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'pipdig_bl_plugin_twicedaily_event'); //hourly, twicedaily or daily
	}
}

// On the scheduled action hook, run a function.
add_action( 'pipdig_bl_plugin_twicedaily_event', 'pipdig_bl_plugin_do_this_twicedaily' );
function pipdig_bl_plugin_do_this_twicedaily() {
	$bloglovin_url = get_option( 'pipdig_bloglovin_plugin_url' );
	$bloglovin = file_get_contents($bloglovin_url);
	$bloglovin_doc = new DOMDocument();

	libxml_use_internal_errors(TRUE);

	if(!empty($bloglovin)){
		$bloglovin_doc->loadHTML($bloglovin);
		libxml_clear_errors();
		$bloglovin_xpath = new DOMXPath($bloglovin_doc);
		$bloglovin_row = $bloglovin_xpath->query('//div[@class="num"]');
		if($bloglovin_row->length > 0){
			foreach($bloglovin_row as $row){
				$followers = $row->nodeValue;
				$followers = str_replace(' ', '', $followers);
				$followers_int = intval( $followers );
				update_option('pipdig_bloglovin_follower_count', $followers_int);
			}
		}
	}
}


/**
 * Widget
 *
 * @since 1.0
 */
class pipdig_widget_bloglovin extends WP_Widget {
 
  public function __construct() {
      $widget_ops = array('classname' => 'pipdig_widget_bloglovin', 'description' => __("Display your Bloglovin' follower count.", 'bloglovin-widget') );
      $this->WP_Widget('pipdig_widget_bloglovin', __("Bloglovin' Widget", 'bloglovin-widget'), $widget_ops);
  }
  
  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	$style_select = empty($instance['style_select']) ? '' : $instance['style_select'];


    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');
   
    // The title, if any
    if (!empty($title)) {
		echo $before_title . $title . $after_title;
	}
	
	$bloglovin_count = get_option('pipdig_bloglovin_follower_count');
	$bloglovin_url = get_option('pipdig_bloglovin_plugin_url');

    if (!empty($bloglovin_count)) {
		$icon_type = get_theme_mod('bloglovin_widget_icon');
		if (empty($icon_type)) {
			$bloglovin_icon = '<i class="fa fa-heart"></i>';
		} else {
			$bloglovin_icon = '<i class="fa fa-' . $icon_type . '"></i>';
		}
		switch ( $icon_type ) {
			case 'heart':
				 $bloglovin_icon = '<i class="fa fa-heart"></i>';
				break;
			case 'plus':
				 $bloglovin_icon = '<i class="fa fa-plus"></i>';
				break;
			case 'none':
				 $bloglovin_icon = '';
				break;

		}
		switch ( $style_select ) {
			case '1':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-1">' . $bloglovin_count . ' ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
			case '2':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-2">' . $bloglovin_icon . ' <span class="bl-widget-num">' . $bloglovin_count . '</span> ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
			case '3':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-3">' . $bloglovin_icon . ' <span class="bl-widget-num">' . $bloglovin_count . '</span> ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
			case '4':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-4">' . $bloglovin_icon . ' <span class="bl-widget-num">' . $bloglovin_count . '</span> ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
			case '5':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-5">' . $bloglovin_icon . ' <span class="bl-widget-num">' . $bloglovin_count . '</span> ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
			case '6':
				$widget_style_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="wp-bloglovin-widget bloglovin-widget-style-6">' . $bloglovin_icon . ' <span class="bl-widget-num">' . $bloglovin_count . '</span> ' . __("Followers on Bloglovin'", 'bloglovin-widget') . '</a></p>';
				break;
		}
		echo $widget_style_output;
	} else {
		_e("Widget setup not complete. Please go to Settings > Bloglovin' in the dashboard", 'bloglovin-widget');
	}
    // After widget code, if any
    echo (isset($after_widget)?$after_widget:'');
  }
 
  public function form( $instance ) {
   
     // PART 1: Extract the data from the instance variable
	$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
	$title = $instance['title'];
	$style_select = ( isset( $instance['style_select'] ) && is_numeric( $instance['style_select'] ) ) ? (int) $instance['style_select'] : 1;
    ?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title: (leave blank for no title)', 'bloglovin-widget'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
		name="<?php echo $this->get_field_name('title'); ?>" type="text" 
		value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<?php
	$options_url = admin_url( 'options-general.php?page=bloglovin-widget' );
	$cust_url = admin_url( 'customize.php' );
	?>
	<p><?php printf(__("This widget will display your total Bloglovin' follower count. Note that you will need to add your Bloglovin' link to <a href='%s'>the options page</a> for this to work.", 'bloglovin-widget'), $options_url ); ?></p>
	<p><?php printf(__("Select a style from below, or choose your own colors in the <em>Bloglovin' Widget</em> section of the <a href='%s'>Customizer</a>.", 'bloglovin-widget'), $cust_url ); ?></p>
	
	<p>
		<legend><h3><?php _e('Widget style:', 'bloglovin-widget'); ?></h3></legend><br />
		
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="1" <?php checked( $style_select == 1, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-1' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 1</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo1.png', __FILE__ ) ?>" />
		<hr>
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="2" <?php checked( $style_select == 2, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-2' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 2</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo2.png', __FILE__ ) ?>" />
		<hr>
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-3') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="3" <?php checked( $style_select == 3, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-3' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 3</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo3.png', __FILE__ ) ?>" />
		<hr>
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-4') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="4" <?php checked( $style_select == 4, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-4' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 4</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo4.png', __FILE__ ) ?>" />
		<hr>
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-5') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="5" <?php checked( $style_select == 5, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-5' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 5</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo5.png', __FILE__ ) ?>" />
		<hr>
		<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-6') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="6" <?php checked( $style_select == 6, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-6' ) ?>"><strong><?php _e('Style', 'bloglovin-widget'); ?> 6</strong></label> <br />
		<img src="<?php echo plugins_url( 'img/demo6.png', __FILE__ ) ?>" />
		<hr>
	</p>

     <?php
   
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
	$instance['style_select'] = ( isset( $new_instance['style_select'] ) && $new_instance['style_select'] > 0 && $new_instance['style_select'] < 7 ) ? (int) $new_instance['style_select'] : 0; // 7 is number above total radio options

    return $instance;
  }
  
}

add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_bloglovin");') );




/**
 * Shortcode - Unstyled integer
 *
 * @since 1.0
 */
function pipdig_bloglovin_shortcode( $atts ){
	$bloglovin_count = get_option('pipdig_bloglovin_follower_count');
	return $bloglovin_count;
}
add_shortcode( 'bloglovin_count', 'pipdig_bloglovin_shortcode' );




/**
 * Integer call.
 * 
 * @since 1.0
 */
add_action('bloglovin_count_here', 'bloglovin_count_callback');
function bloglovin_count_callback()
{
	$bloglovin_count = get_option('pipdig_bloglovin_follower_count');
	echo $bloglovin_count;
}
function the_action()
{
do_action('bloglovin_count_here');
}



/**
 * Add styles to head
 * (need to make this conditional in future release)
 * @since 1.0
 */
function bloglovin_widget_styles() {
	echo '<style>.wp-bloglovin-widget{display:block;max-width:276px;margin:0 auto;text-transform:uppercase;letter-spacing:1px;transition:all .25s ease-out;-o-transition:all .25s ease-out;-moz-transition:all .25s ease-out;-webkit-transition:all .25s ease-out}.wp-bloglovin-widget .fa{font-size:12px}.bloglovin-widget-style-1{padding:8px 15px;background:#bce7f5;border-radius:9px;color:#555!important;font:10px arial,sans-serif}.bloglovin-widget-style-1:hover{opacity:.8}.bloglovin-widget-style-2{padding:8px 15px;background:#000;color:#fff!important;font:10px arial,sans-serif}.bloglovin-widget-style-2:hover{opacity:.75}.bloglovin-widget-style-3{padding:8px 15px;background:#000;color:#fff!important;font:10px arial,sans-serif;border:1px solid #000;box-shadow:0 0 0 1px #fff inset,0 0 0 1px #000 inset}.bloglovin-widget-style-3:hover{opacity:.75}.bloglovin-widget-style-4{padding:8px 15px;background:#fff;color:#000!important;font:10px arial,sans-serif;border:1px solid #000}.bloglovin-widget-style-4:hover{opacity:.75}.bloglovin-widget-style-4 .fa{color:#000}.bloglovin-widget-style-5{padding:8px 15px;background:#fff;color:#000!important;border:1px dotted #ccc;font:10px arial,sans-serif}.bloglovin-widget-style-5:hover{opacity:.75}.bloglovin-widget-style-5 .fa{color:#000}.bloglovin-widget-style-6{padding:8px 15px;background:#fff;color:#222!important;font:10px arial,sans-serif;box-shadow:0 0 8px #bbb}.bloglovin-widget-style-6:hover{opacity:.7}.bloglovin-widget-style-6 .fa{color:#888}</style>';
}
add_filter('wp_head', 'bloglovin_widget_styles');


/**
 * Add section to customizer
 *
 * @since 1.0
 */
require_once('inc/customizer.php');