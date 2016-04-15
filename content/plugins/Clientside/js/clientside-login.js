/*!
 * This file is part of: Clientside
 * Author: Berend de Jong
 * Author URI: http://frique.me/
 * Version: 1.2.9 (2016-04-15 00:11)
 */

jQuery( function( $ ) {

	"use strict";

	// Add placeholders to inputs
	$( 'label' ).each( function() {

		var $this = $( this );
		var text = $this.text().trim();
		var $input = $this.children( 'input' ).not( '[type="checkbox"]' );

		// If the placeholder is not already set
		if ( ! $input.attr( 'placeholder' ) ) {
			$input.attr( 'placeholder', text );
		}

	} );

	// Login form: auto-check "Remember me"
	$( '#rememberme' ).prop( 'checked', true );

} );