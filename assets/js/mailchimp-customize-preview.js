/**
 * File mailchimp-customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";

	var api = wp.customize;

	// Collect information from mailchimp-customize-controls.js about which sections are opening.
	api.bind( 'preview-ready', function() {
		// Initially hide the featured content area placeholder on load.
		$( '.mailchimp-content-area--placeholder' ).hide();

		api.preview.bind( 'mailchimp-content-area-highlight', function( data ) {
			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'front-page' ) && ! $( 'body' ).hasClass( 'home' ) ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'highlight-mailchimp-content-area' );
				$( '.mailchimp-content-area--placeholder' ).slideDown( 200 );

			// If we've left the panel, hide the placeholder.
			} else {
				$( 'body' ).removeClass( 'highlight-mailchimp-content-area' );
				$( '.mailchimp-content-area--placeholder' ).slideUp( 200 );
			}
		} );
	} );
} )( jQuery );
