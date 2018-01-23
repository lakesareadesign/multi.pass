/**
 * This script adds the jquery effects to the Daily Dish Pro Theme.
 *
 * @package Daily Dish\JS
 * @author StudioPress
 * @license GPL-2.0+
 */
(function( $ ) {

	// Make sure JS class is added.
	$( document ).ready( function() {
		$( 'body' ).addClass( 'js' );
	});

	// Set variables for header search.
	var $header    = $( '.nav-primary' ),
		$hsToggle  = $( '.toggle-header-search' ),
		$hsWrap    = $( '#header-search-wrap' ),
		$hsInput   = $hsWrap.find( 'input[type="search"]' );


	// Handler for click a show/hide button.
	$hsToggle.on( 'click', function( event ) {

		event.preventDefault();

		if ( $( this ).hasClass( 'close' ) ) {
			hideSearch();
		} else {
			showSearch();
		}

	});

	// Handler for pressing show/hide button.
	$hsToggle.on( 'keydown', function( event ) {

		// If tabbing from toggle button, and search is hidden, exit early.
		if ( event.keyCode === 9 && ! $header.hasClass( 'search-visible' ) ) {
			return;
		}

		event.preventDefault();
		handleKeyDown( event );

	});

	// Hide search when tabbing or escaping out of the search bar.
	$hsInput.on( 'keydown', function( event ) {

		// Tab: 9, Esc: 27.
		if ( event.keyCode === 9 || event.keyCode === 27 ) {
			hideSearch( event.target );
		}

	});

	// Hide search on blur, such as when clicking outside it.
	$hsInput.on( 'blur', hideSearch );

	// Helper function to show the search form.
	function showSearch() {

		$header.addClass( 'search-visible' );
		$hsWrap.fadeIn( 'fast' ).find( 'input[type="search"]' ).focus();
		$hsToggle.attr( 'aria-expanded', true );

	}

	// Helper function to hide the search form.
	function hideSearch() {

		$hsWrap.fadeOut( 'fast' ).parents( '.nav-primary' ).removeClass( 'search-visible' );
		$hsToggle.attr( 'aria-expanded', false );

	}

	// Keydown handler function for toggling search field visibility.
	function handleKeyDown( event ) {

		// Enter/Space, respectively.
		if ( event.keyCode === 13 || event.keyCode === 32 ) {

			event.preventDefault();

			if ( $( event.target ).hasClass( 'close' ) ) {
				hideSearch();
			} else {
				showSearch();
			}

		}

	}

})( jQuery );