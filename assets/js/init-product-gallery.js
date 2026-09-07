/**
 * Init Carousel for Single Product Gallery.
 */

( function( $ ) {
	"use strict";

	$( document ).ready( function() {
		$( '.flex-control-nav' ).slick( {
			slidesToShow: 4,
			slidesToScroll: 1,
			infinite: false,
			speed: 500,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 5
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 4
					}
				},
				{
					breakpoint: 430,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 321,
					settings: {
						slidesToShow: 2
					}
				}
			]
		} );
	} );
} )( jQuery );
