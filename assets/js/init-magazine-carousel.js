/**
 * Init Magazine Section Carousel.
 */

( function( $ ) {
	"use strict";

	$( document ).ready( function() {
		// Magazine Section Carousel.
		$( '#magazine-section-carousel' ).slick( {
			autoplay: true,
			autoplaySpeed: 10000,
			fade: true,
			cssEase: 'ease-in-out'
		} );
	} );
} )( jQuery );
