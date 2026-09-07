/**
 * Init Masonry Content Layout ver.1.
 */

( function( $ ) {
	"use strict";

	$( document ).ready( function() {
		// init Masonry
		var $grid = $( '#loop-masonry-v1' ).masonry( {
			itemSelector: '.js-masonry-item',
			columnWidth: '.js-masonry-item',
			percentPosition: true,
			initLayout: false,
		} );

		// layout Masonry after each image loads
		$grid.imagesLoaded().progress( function() {
			$grid.masonry( 'layout' );
		} );

		// add class to items after Masonry layout complete
		$grid.on( 'layoutComplete', function( event, laidOutItems ) {
			$( '.js-masonry-item' ).each( function( i ) {
				setTimeout( function() {
					$( '.js-masonry-item' ).eq( i ).addClass( 'masonry__item--is-visible' );
				}, 200 * i );
			} );
		} );

		$grid.masonry();
	} );
} )( jQuery );
