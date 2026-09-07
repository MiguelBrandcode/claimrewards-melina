/**
 * Init Two-column grid layout (full-width).
 */

( function( $ ) {
	"use strict";

	function initGrid2() {
		$( '.loop-container' ).each( function() {
			var items = $( this ).find( '.post-card' );

			$( this ).imagesLoaded( function() {
				var left_column_height = 0;
				var right_column_height = 0;

				for ( var i = 0; i < items.length; i++ ) {
					items.eq( i ).removeClass('post-card--right post-card--left');

					if ( left_column_height > right_column_height ) {
						right_column_height += items.eq( i ).addClass( 'post-card--right' ).outerHeight( true );
					} else {
						left_column_height += items.eq( i ).addClass( 'post-card--left' ).outerHeight( true );
					}

					$( '.post-card' ).each( function( i ) {
						setTimeout( function() {
							$( '.post-card' ).eq( i ).addClass( 'post-card--is-visible' );
						}, 200 * i );
					} );
				}
			} );
		} );
	}

	$( window ).on( 'load', function() {
		initGrid2();
	} );

	$( window ).on( 'resize', function() {
		initGrid2();
	} );
} )( jQuery );
