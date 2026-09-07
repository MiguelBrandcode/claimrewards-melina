/**
 * Init Full Width Posts Carousel With Transparent Header.
 */

( function( $ ) {
	"use strict";

	$( document ).ready( function() {
		$( '#carousel-v4' ).slick( {
			dots: false,
			autoplay: true,
			autoplaySpeed: 10000,
			fade: true,
			cssEase: 'ease-in-out'
		} );
	} );
} )( jQuery );
