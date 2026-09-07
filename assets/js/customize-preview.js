/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";

	var style = $( '#melina-color-scheme-css' ),
		api = wp.customize;

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="melina-color-scheme-css" />' )
												.find( '#melina-color-scheme-css' );
	}

	// Site title
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site__title > a' ).text( to );
		} );
	} );

	// Site description
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );

			if ( ! to.length ) {
				$( '.featured--site-info' ).removeClass( 'featured--has-site-description' );
			} else {
				$( '.featured--site-info' ).addClass( 'featured--has-site-description' );
			}
		} );
	} );

	// Site layout type
	api( 'layout_type', function( value ) {
		value.bind( function( to ) {
			// Update layout type
			$( 'body' )
				.removeClass( 'layout--wide layout--boxed' )
				.addClass( 'layout--' + to );
		} );
	} );

	// Sidebar position
	api( 'sidebar_position', function( value ) {
		value.bind( function( to ) {
			// Update sidebar position
			$( 'body' )
				.removeClass( 'sidebar--right sidebar--left sidebar--no' )
				.addClass( 'sidebar--' + to );
		} );
	} );

	// Sticky sidebar
	api( 'sticky_sidebar', function( value ) {
		value.bind( function( to ) {
			if ( 'enable' === to ) {
				$( '.sidebar' ).addClass( 'sidebar--sticky' );
			} else {
				$( '.sidebar' ).removeClass( 'sidebar--sticky' );
			}
		} );
	} );

	// Footer copyright text.
	api( 'copyright_text', function( value ) {
		value.bind( function( to ) {
			// Update copyright text
			$( '.copyright__text' ).text( to );
		} );
	} );

	// Color Scheme.
	api( 'color_scheme', function( value ) {
		value.bind( function( to ) {
			// Update color scheme body class
			$( 'body' )
				.removeClass( 'color-scheme--default' )
				.addClass( 'color-scheme--' + to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Collect information from customize-controls.js about which sections are opening.
	api.bind( 'preview-ready', function() {
		// Initially hide the featured content area placeholder on load.
		$( '.featured-content-area--placeholder' ).hide();

		api.preview.bind( 'featured-content-area-highlight', function( data ) {
			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'front-page' ) && ! $( 'body' ).hasClass( 'home' ) ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'highlight-featured-content-area' );
				$( '.featured-content-area--placeholder' ).slideDown( 200, function() {
					$.scrollTo( $( '#featured-content-area' ), {
						duration: 600,
						offset: { 'top': -80 }
					} );
				} );

			// If we've left the panel, hide the placeholder.
			} else {
				$( 'body' ).removeClass( 'highlight-featured-content-area' );
				// Don't change scroll when leaving - it's likely to have unintended consequences.
				$( '.featured-content-area--placeholder' ).slideUp( 200 );
			}
		} );

		// Initially hide the post navigation placeholder on load.
		$( '.post-navigation-area--placeholder' ).hide();

		api.preview.bind( 'post-navigation-area-highlight', function( data ) {
			// Only on the single post.
			if ( ! $( 'body' ).hasClass( 'single-post' ) ) {
				return;
			}

			// When the section is expanded, show the placeholder.
			if ( true === data.expanded ) {
				$( '.post-navigation-area--placeholder' ).slideDown( 200 );

			// If we've left the panel, hide the placeholder.
			} else {
				$( '.post-navigation-area--placeholder' ).slideUp( 200 );
			}
		} );

		// Initially hide the related posts placeholder on load.
		$( '.related-posts--placeholder' ).hide();

		api.preview.bind( 'related-posts-highlight', function( data ) {
			// Only on the single post.
			if ( ! $( 'body' ).hasClass( 'single-post' ) ) {
				return;
			}

			// When the section is expanded, show the placeholder.
			if ( true === data.expanded ) {
				$( '.related-posts--placeholder' ).slideDown( 200 );

			// If we've left the panel, hide the placeholder.
			} else {
				$( '.related-posts--placeholder' ).slideUp( 200 );
			}
		} );

		// Initially hide the magazine page placeholders on load.
		$( '.magazine-section--placeholder' ).hide();

		api.preview.bind( 'magazine-section-highlight', function( data ) {
			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'front-page' ) ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'highlight-magazine-sections' );
				$( '.magazine-section--placeholder' ).slideDown( 200, function() {
					$.scrollTo( $( '#magazine-section-1' ), {
						duration: 600,
						offset: { 'top': -64 }
					} );
				} );

			// If we've left the panel, hide the placeholders and scroll back to the top.
			} else {
				$( 'body' ).removeClass( 'highlight-magazine-sections' );
				// Don't change scroll when leaving - it's likely to have unintended consequences.
				$( '.magazine-section--placeholder' ).slideUp( 200 );
			}
		} );
	} );

	// Work with featured area settings
	api.bind( 'preview-ready', function() {
		// Add "header--without-border" class for header.
		api.preview.bind( 'header-without-border-activated', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				// Only on the first page of front page.
				if ( ! $( 'body' ).hasClass( 'featured--enabled' ) ) {
					return;
				}

				$( '.header' ).removeClass( 'header--without-border header--transparent' );
				$( '.header' ).addClass( 'header--without-border' );

				if ( $( 'body' ).hasClass( 'header-transparent--activated' ) ) {
					$( 'body' ).removeClass( 'header-transparent--activated' );
				}
			} );
		} );

		// Add "header--transparent" class for header.
		api.preview.bind( 'header-transparent-activated', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				// Only on the first page of front page.
				if ( ! $( 'body' ).hasClass( 'featured--enabled' ) ) {
					return;
				}

				$( '.header' ).removeClass( 'header--without-border header--transparent' );
				$( '.header' ).addClass( 'header--transparent' );

				if ( ! $( 'body' ).hasClass( 'header-transparent--activated' ) ) {
					$( 'body' ).addClass( 'header-transparent--activated' );
				}
			} );
		} );

		// Remove header classes.
		api.preview.bind( 'header-default-activated', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				// Only on the first page of front page.
				if ( ! $( 'body' ).hasClass( 'featured--enabled' ) ) {
					return;
				}

				$( '.header' ).removeClass( 'header--without-border header--transparent' );

				if ( $( 'body' ).hasClass( 'header-transparent--activated' ) ) {
					$( 'body' ).removeClass( 'header-transparent--activated' );
				}
			} );
		} );

		// Init wide featured posts carousel only if it selected.
		api.preview.bind( 'featured-carousel-v1-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#carousel-v1' ).hasClass( 'slick-initialized' ) ) {
					$( '#carousel-v1' ).slick( 'unslick' );
				}

				$( '#carousel-v1' ).slick( {
					dots: false,
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out'
				} );
			} );
		} );

		// Init boxed featured posts carousel only if it selected.
		api.preview.bind( 'featured-carousel-v2-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#carousel-v2' ).hasClass( 'slick-initialized' ) ) {
					$( '#carousel-v2' ).slick( 'unslick' );
				}

				$( '#carousel-v2' ).slick( {
					dots: false,
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out'
				} );
			} );
		} );

		// Init full width featured posts carousel only if it selected.
		api.preview.bind( 'featured-carousel-v3-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#carousel-v3' ).hasClass( 'slick-initialized' ) ) {
					$( '#carousel-v3' ).slick( 'unslick' );
				}

				$( '#carousel-v3' ).slick( {
					dots: false,
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out'
				} );
			} );
		} );

		// Init full width featured posts carousel with transparent header only if it selected.
		api.preview.bind( 'featured-carousel-v4-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#carousel-v4' ).hasClass( 'slick-initialized' ) ) {
					$( '#carousel-v4' ).slick( 'unslick' );
				}

				$( '#carousel-v4' ).slick( {
					dots: false,
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out'
				} );
			} );
		} );
	} );

	// Init magazine section carousel only if some category selected.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'magazine-category-4-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#magazine-section-carousel' ).hasClass( 'slick-initialized' ) ) {
					$( '#magazine-section-carousel' ).slick( 'unslick' );
				}

				// Magazine Section Carousel.
				$( '#magazine-section-carousel' ).slick( {
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out'
				} );
			} );
		} );
	} );

	// Init magazine section #6 only if some category selected.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'magazine-category-6-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				$( '#magazine-section-6 .magazine-section__content' ).each( function() {
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
			} );
		} );
	} );
} )( jQuery );
