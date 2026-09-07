/**
 * Init Wide Featured Posts Carousel.
 */

( function( $ ) {
	"use strict";

	$( document ).ready( function() {
		$( '#carousel-v1' ).slick( {
			dots: false,
			autoplay: true,
			autoplaySpeed: 10000,
			fade: true,
			cssEase: 'ease-in-out'
		} );
	} );
} )( jQuery );
