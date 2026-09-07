/**
 * File functions.js.
 *
 * Contains handlers for navigation, search and scroll to top button.
 */

( function( $ ) {
  "use strict";

  var body, masthead, menuToggle, headerMenu, menuPrimary, menuSecondary, resizeTimer;

  function initMainNavigation( container ) {
    // Add dropdown toggle that displays child menu items.
    var dropdownToggle = $( '<button />', {
      'class': 'dropdown-toggle',
      'aria-expanded': false
    } ).append( $( '<span />', {
      'class': 'screen-reader-text',
      text: screenReaderText.expand
    } ) );

    container.find( '.menu-item-has-children > a' ).after( dropdownToggle );

    // Set the active submenu dropdown toggle button initial state.
    container.find( '.current-menu-ancestor > button' )
      .addClass( 'toggled-on' )
      .attr( 'aria-expanded', 'true' )
      .find( '.screen-reader-text' )
      .text( screenReaderText.collapse );
    // Set the active submenu initial state.
    container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

    container.find( '.dropdown-toggle' ).click( function( e ) {
      var _this            = $( this ),
          screenReaderSpan = _this.find( '.screen-reader-text' );

      e.preventDefault();
      _this.toggleClass( 'toggled-on' );
      _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

      _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

      screenReaderSpan.text( screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
    } );
  }

  initMainNavigation( $( '.header__menu--primary' ) );
  initMainNavigation( $( '.header__menu--secondary' ) );

  masthead      = $( '#masthead' );
  menuToggle    = masthead.find( '#menu-toggle' );
  headerMenu    = masthead.find( '#header-menu' );
  menuPrimary   = masthead.find( '#menu-primary' );
  menuSecondary = masthead.find( '#menu-secondary' );

  // Enable menuToggle.
  ( function() {
    // Return early if menuToggle is missing.
    if ( ! menuToggle.length ) {
      return;
    }

    // Add an initial values for the attribute.
    menuToggle.add( menuPrimary ).add( menuSecondary ).attr( 'aria-expanded', 'false' );

    menuToggle.on( 'click.melina', function() {
      $( this ).add( headerMenu ).toggleClass( 'toggled-on' );

      $( this ).add( menuPrimary ).add( menuSecondary ).attr( 'aria-expanded', $( this ).add( menuPrimary ).add( menuSecondary ).hasClass( 'toggled-on' ) );
    } );
  } )();

  // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
  ( function() {
    if ( ! menuPrimary.length || ! menuPrimary.children().length ) {
      return;
    }

    // Toggle `focus` class to allow submenu access on tablets.
    function toggleFocusClassTouchScreen() {
      if ( window.innerWidth >= 960 ) {

        $( document.body ).on( 'touchstart.melina', function( e ) {
          if ( ! $( e.target ).closest( '.header__menu--primary li' ).length ) {
            $( '.header__menu--primary li' ).removeClass( 'focus' );
          }
        } );

        menuPrimary.find( '.menu-item-has-children > a' ).on( 'touchstart.melina', function( e ) {
          var el = $( this ).parent( 'li' );

          if ( ! el.hasClass( 'focus' ) ) {
            e.preventDefault();
            el.toggleClass( 'focus' );
            el.siblings( '.focus' ).removeClass( 'focus' );
          }
        } );

      } else {
        menuPrimary.find( '.menu-item-has-children > a' ).unbind( 'touchstart.melina' );
      }
    }

    if ( 'ontouchstart' in window ) {
      $( window ).on( 'resize.melina', toggleFocusClassTouchScreen );
      toggleFocusClassTouchScreen();
    }

    menuPrimary.find( 'a' ).on( 'focus.melina blur.melina', function() {
      $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
    } );
  } )();

  function initShowComments( container ) {
    // Add "Show Comments" button.
    var showCommentsButton = $( '<button />', {
      'class': 'button button--show-commets',
      'aria-expanded': false
    } ).append( $( '<span />', {
      'class': 'button__text',
      text: showCommentsText.show
    } ) );

    container.find( '.comments-area__wrapper' ).before( showCommentsButton );

    container.find( '.button.button--show-commets' ).click( function( e ) {
      var _this            = $( this ),
          showCommentsSpan = _this.find( '.button__text' );

      e.preventDefault();
      _this.toggleClass( 'toggled-on' );
      _this.next( '.comments-area__wrapper' ).toggleClass( 'toggled-on' );

      _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

      showCommentsSpan.text( showCommentsSpan.text() === showCommentsText.show ? showCommentsText.close : showCommentsText.show );
    } );
  }

  initShowComments( $( '#comments' ) );

  // Shows comments area by certain anchors.
  function showCommentsByAnchor() {
    var anchor = window.location.hash.replace("#","");

    if ( ! anchor.length ) {
      return;
    }

    if ( anchor == "comments" || anchor == "respond" || anchor.includes("comment-") ) {
      $( '.comments-area__wrapper' ).slideDown( 0 );
    }
  }

  $( document ).ready( function() {
    body = $( document.body );

    $( window ).on( 'scroll.melina', function() {
      // Scroll to top button.
      if ( $( this ).scrollTop() > $( window ).height() / 2 ) {
        $( '#scroll-to-top' ).fadeIn( 1000 );
      } else {
        $( '#scroll-to-top' ).fadeOut( 1000 );
      }
    } );

    // Scroll to top button.
    $( '#scroll-to-top' ).on( 'click.melina', function() {
      $( 'html, body' ).animate( { scrollTop: 0 }, 1000 );
      return false;
    } );

    // Show/Hide Comments
    $( '.comments-area__wrapper' ).hide();

    $( '.button--show-commets' ).toggle(
      function() {
        $( '.comments-area__wrapper' ).slideDown( 200, function() {
					$.scrollTo( $( '.comments-area__wrapper' ), {
						duration: 600,
						offset: { 'top': -48 }
					} );
				} );
      },
      function() {
        $( '.comments-area__wrapper' ).slideUp( 200 );
      }
    );

    // Show comments by anchor.
    showCommentsByAnchor();

    // Search.
    $( '#menu-item-search > a' ).on( 'click.melina', function( event ) {
      event.preventDefault();
      $( '#search-overlay' ).addClass( 'search-overlay--open' );
      $( '#search-overlay > form > input[type="search"]' ).focus();
    } );

    $( '#search-overlay, #search-overlay .button--close' ).on( 'click.melina keyup.melina', function( event ) {
      if ( event.target == this || event.target.className == 'button--close' || event.keyCode == 27 ) {
        $( this ).removeClass( 'search-overlay--open' );
      }
    } );
  } );
} )( jQuery );
