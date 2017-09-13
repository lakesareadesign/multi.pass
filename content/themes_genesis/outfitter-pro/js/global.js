/**
 * This script adds the jquery effects to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

( function($) {

	// Adds .js body class.
	document.documentElement.className = "js";

	var $body          = $( 'body' ),
		$content       = $( '.off-screen-widget-area' ),
		$contentToggle = $( '.off-screen-item' ),
		sOpen          = false;

	$(document).ready(function() {

		// Toggles the off-screen content.
		$( '.toggle-off-screen-widget-area' ).click(function() {
			__toggleOffscreenContent();
		});

	});

	// Close off-screen content on mobile screens.
	$( window ).load( function() {
		$( window ).resize( function() {

			if ( __isMobile() && sOpen ) {
				__toggleOffscreenContent();
				sOpen = false;
			}

			__maybeHideOffscreenToggle();

		}).resize();
	});

	// Toggles the off-screen content.
	function __toggleOffscreenContent() {

		if ( sOpen ) {
			$content.fadeOut();
			$body.toggleClass( 'no-scroll' );
			sOpen = false;
		} else {
			$content.fadeIn();
			$body.toggleClass( 'no-scroll' );
			sOpen = true;
		}

	}

	// Maybe hide visibility of off-screen toggle button depending on off-screen content.
	function __maybeHideOffscreenToggle() {

		var hasWidgets    = $content.find( '.widget' ).length > 0,
			toggleVisible = $contentToggle.css( 'display' ) !== 'none';

		// Exit early if there are widgets.
		if ( hasWidgets ) {
			return;
		}

		if ( __isMobile() && toggleVisible ) {
			$contentToggle.css({
				display: "none",
				visibility: "hidden"
			});
		}

		if ( ! __isMobile() && ! toggleVisible ) {
			$contentToggle.attr( 'style', '' );
		}

	}

	// Determines whether we are on mobile devices or not.
	function __isMobile() {
		var mobile = $( '.menu-toggle' ).css( 'display' ) === "block";
		return mobile;
	}

	$( document ).ready(function() {
		// Determines height of site footer, add bottom margin to site container.
		var $header    = $( '.site-header' ),
			$hsToggle  = $( '.toggle-header-search' ),
			$footer    = $( '.site-footer' ),
			$container = $( '.site-container' );

		// Toggles visible class for header search.
		$hsToggle.click( function(event) {
			event.preventDefault();
			$header.toggleClass( 'search-visible' );
			$( '#header-search-container' ).find( 'input[type="search"]' ).focus();
		});

	});

})(jQuery);
