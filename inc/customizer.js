( function( $ ) {
	// Background Color
	wp.customize( 'bloglovin_widget_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '.wp-bloglovin-widget' ).css('background', newval ).css('border-color', newval );
		} );
	} );
} )( jQuery );