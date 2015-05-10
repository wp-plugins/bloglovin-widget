<?php

class pipdig_bloglovin_widget_Customize {
public static function register ( $wp_customize ) {


$wp_customize->add_section( 'pipdig_bloglovin_widget', 
	array(
		'title' => __( "Bloglovin' Widget", 'bloglovin-widget' ),
		'priority' => 905,
		'description' => __( "Use these options to style your Bloglovin' Widget.", 'bloglovin-widget' ),
		'capability' => 'edit_theme_options',
	) 
);


// background color
$wp_customize->add_setting('bloglovin_widget_background_color',
	array(
		'default' => '#000000',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bloglovin_widget_background_color',
	array(
		'label' => __( 'Background color', 'bloglovin-widget' ),
		'section' => 'pipdig_bloglovin_widget',
		'settings' => 'bloglovin_widget_background_color',
	)
	)
);

// text color
$wp_customize->add_setting('bloglovin_widget_text_color',
	array(
		'default' => '#ffffff',
		//'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bloglovin_widget_text_color',
	array(
		'label' => __( 'Text color', 'bloglovin-widget' ),
		'section' => 'pipdig_bloglovin_widget',
		'settings' => 'bloglovin_widget_text_color',
	)
	)
);

$wp_customize->add_setting('bloglovin_widget_icon',
	array(
		'default' => 'heart',
		//'sanitize_callback' => 'bloglovin_widget_sanitize_icon',
	)
);
 
$wp_customize->add_control('bloglovin_widget_icon',
	array(
		'type' => 'radio',
		'label' => __( 'Widget Icon', 'bloglovin-widget' ),
		'section' => 'pipdig_bloglovin_widget',
		'choices' => array(
			'heart' => 'Heart',
			'plus' => 'Plus',
			'' => 'None',
		),
	)
);

}


/*
function bloglovin_widget_sanitize_icon( $input ) {
    $valid = array(
		'heart' => 'Heart',
		'plus' => 'Plus',
		'' => 'None',
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
*/

public static function live_preview() {
	$plugin_url = plugins_url( 'customizer.js', __FILE__ );
	wp_enqueue_script( 
		'pipdig-bloglovin-widget-customizer',
		$plugin_url ,
		array(  'jquery', 'customize-preview' ),
		'', // Define a version (optional) 
		true // Specify whether to put in footer (leave this true)
	);
	}
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'pipdig_bloglovin_widget_Customize' , 'register' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'pipdig_bloglovin_widget_Customize' , 'live_preview' ) );



function pipdig_bloglovin_widget_customizer_head_styles() {


$output_bloglovin_widget_background_color = '';
$output_bloglovin_widget_text_color = '';

	// background color
	$bloglovin_widget_background_color = get_theme_mod( 'bloglovin_widget_background_color' ); 
	if ( ($bloglovin_widget_background_color != '#000000' && $bloglovin_widget_background_color != null) ) :
		$output_bloglovin_widget_background_color = '.wp-bloglovin-widget{background:' . $bloglovin_widget_background_color . 'border-color:' . $bloglovin_widget_background_color . '}';
	endif;
	
	// text color
	$bloglovin_widget_text_color = get_theme_mod( 'bloglovin_widget_text_color' ); 
	if ( ($bloglovin_widget_text_color != '#000000' && $bloglovin_widget_text_color != null) ) :
		$output_bloglovin_widget_text_color = '.wp-bloglovin-widget{color:' . $bloglovin_widget_text_color . '!important}';
	endif;

	

echo '<!-- Bloglovin Widget --><style>'
. $output_bloglovin_widget_background_color 
. $output_bloglovin_widget_text_color 
. '</style><!-- /Bloglovin Widget -->';

}
add_action( 'wp_head', 'pipdig_bloglovin_widget_customizer_head_styles' );

