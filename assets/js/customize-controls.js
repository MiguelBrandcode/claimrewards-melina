/**
 * Scripts within the customizer controls window.
 *
 * Informs the preview when users open or close customizer settings
 * section and contextually shows the static page content control.
 */

( function() {
	"use strict";

	// Whether a header image is available.
	function hasHeaderImage() {
		var image = wp.customize( 'header_image' )();
		return '' !== image && 'remove-header' !== image;
	}

	wp.customize.bind( 'ready', function() {
		// Detect when the feature area settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'melina_featured_area', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'featured-content-area-highlight', { expanded: isExpanding } );
			} );
		} );

		// Detect when the content area settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'melina_content_area', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'post-navigation-area-highlight', { expanded: isExpanding } );
				wp.customize.previewer.send( 'related-posts-highlight', { expanded: isExpanding } );
			} );
		} );

		// Work with featured area settings.
		wp.customize( 'featured_content', function( setting ) {
			setting.bind( function( selectedOption ) {
				// Changing header classes when featured content change.
				if ( ( 'site-info' === selectedOption && hasHeaderImage() ) || 'carousel-v1' === selectedOption || 'carousel-v3' === selectedOption ) {
					wp.customize.previewer.send( 'header-without-border-activated' );
				} else if ( 'carousel-v4' === selectedOption ) {
					wp.customize.previewer.send( 'header-transparent-activated' );
				} else {
					wp.customize.previewer.send( 'header-default-activated' );
				}

				// Init featured carousel only if it selected.
				if ( 'carousel-v1' === selectedOption ) {
					wp.customize.previewer.send( 'featured-carousel-v1-selected' );
				}

				if ( 'carousel-v2' === selectedOption ) {
					wp.customize.previewer.send( 'featured-carousel-v2-selected' );
				}

				if ( 'carousel-v3' === selectedOption ) {
					wp.customize.previewer.send( 'featured-carousel-v3-selected' );
				}

				if ( 'carousel-v4' === selectedOption ) {
					wp.customize.previewer.send( 'featured-carousel-v4-selected' );
				}
			} );
		} );

		// Only show the static page content control when homepage displays is set to a static page.
		wp.customize( 'show_on_front', function( setting ) {
			wp.customize.control( 'static_page_content', function( control ) {
				var visibility = function() {
					if ( 'page' === setting.get() ) {
						control.container.show();
					} else {
						control.container.hide();
					}
				};

				visibility();
				setting.bind( visibility );
			} );
		} );

		// Detect when the magazine page settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'melina_magazine_page', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'magazine-section-highlight', { expanded: isExpanding } );
			} );
		} );

		// Init magazine section carousel only if some category selected.
		wp.customize( 'magazine_section_4', function( setting ) {
			setting.bind( function( selectedCategory ) {
				if ( 'none' !== selectedCategory ) {
					wp.customize.previewer.send( 'magazine-category-4-selected' );
				}
			} );
		} );

		// Init magazine section #6 only if some category selected.
		wp.customize( 'magazine_section_6', function( setting ) {
			setting.bind( function( selectedCategory ) {
				if ( 'none' !== selectedCategory ) {
					wp.customize.previewer.send( 'magazine-category-6-selected' );
				}
			} );
		} );
	} );
} )( jQuery );
