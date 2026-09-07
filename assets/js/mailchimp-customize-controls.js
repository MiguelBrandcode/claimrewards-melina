/**
 * Scripts within the customizer controls window.
 *
 * Informs the preview when users open or close customizer settings
 * section.
 */

( function() {
	wp.customize.bind( 'ready', function() {
		// Detect when the content area settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'melina_content_area', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'mailchimp-content-area-highlight', { expanded: isExpanding } );
			} );
		} );
	} );
} )( jQuery );
