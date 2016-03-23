/*!
 * This file is part of: Clientside
 * Author: Berend de Jong
 * Author URI: http://frique.me/
 * Version: 1.1.12 (2015-08-09 00:16)
 */

jQuery( function( $ ) {

	/*
	 * Table of contents
	 *
	 * 1.0 Setup
	 * 2.0 Better placeholders
	 * 3.0 Widget close buttons
	 * 4.0 Open Screen Options & Help in popups
	 * 5.0 Revert Clientside Options
	 * 6.0 Admin Menu Editor Tool
	 * 7.0 Admin Widget Manager
	 * 8.0 Admin Column Manager
	 * 9.0 Custom Media Manager trigger
	 * 10.0 Main menu
	 * 11.0 Conditional highlighting of elements
	 * 12.0 Animating scroll triggers
	 * 13.0 Add global back-to-top button to left-bottom
	 * 14.0 Add warning when navigating away when theme/plugin editor is used
	 * 15.0 Add a .wrap to (plugin) pages that don't have one
	 * 16.0 Notification Center
	 */

	/* 1.0 Setup */

	"use strict";

	// Globals: L10n
	var $window = $( window );
	var $document = $( document );
	var $body = $( 'body' );
	var theme = $body.hasClass( 'clientside-theme' );

	/* 2.0 Better placeholders */

	// Add placeholder attributes in favor of fake placeholder labels
	$( '.clientside-theme #dashboard_quick_press' ).find( '#title' ).attr( 'placeholder', $.trim( $( this ).find( '#title-prompt-text' ).text() ) );
	$( '.clientside-theme #dashboard_quick_press' ).find( '#content' ).attr( 'placeholder', $.trim( $( this ).find( '#content-prompt-text' ).text() ) );
	$( '.clientside-theme .post-php' ).find( '#title' ).attr( 'placeholder', $.trim( $( this ).find( '#title-prompt-text' ).text() ) );

	/* 3.0 Widget close buttons */

	// Add close buttons to widgets
	$( '.clientside-theme .postbox' ).not( '#submitdiv' ).each( function( i ) {

		var $this = $( this );
		var $minimize = $this.children( '.handlediv' );
		var name = this.id + '-hide';
		var value = this.id;
		var html = '';

		// Output checkbox HTML
		if ( $minimize.length ) {
			html += '<label class="clientside-widget-close">';
			html += '<span class="dashicons dashicons-no-alt"></span>';
			html += '<input type="checkbox" class="hide-postbox-tog" name="' + name + '" value="' + value + '" checked="checked">';
			html += '</label>';
			$this.prepend( $( html ) );
		}

	} );

	// Event: Re-check unchecked widget hiding checkbox when enabled from other checkbox
	$document.on( 'change', '.hide-postbox-tog', function() {

		var $this = $( this );
		var name = $this.attr( 'name' );
		$( '.hide-postbox-tog' ).filter( '[name="' + name + '"]' ).prop( 'checked', $this.prop( 'checked' ) );

	} );

	/* 4.0 Open Screen Options & Help in popups */

	// Replace Screen Options / Help button events with Fancybox popup
	if ( theme ) {
		window.screenMeta = {
			init: function() {}
		};
		// Pre WP 4.3
		$( '.screen-meta-toggle a' ).each( function() {
			var $this = $( this ).addClass( 'thickbox thickbox--clientside' );
			var width = 600;
			var height = 400;
			var target = $this.attr( 'href' ).substring( 1 );
			$this.attr( 'href', '#TB_inline?width=' + width + '&height=' + height + '&inlineId=' + target );
			// Add Screen Options title
			if ( $this.is( $( '#show-settings-link' ) ) ) {
				$this.attr( 'title', L10n.screenOptions );
			}
			// Add Help title
			if ( $this.is( $( '#contextual-help-link' ) ) ) {
				$this.attr( 'title', L10n.help );
			}
		} );
		// WP 4.3+
		if ( $( '.screen-meta-toggle button' ).length ) {
			// Screen options
			$( '#show-settings-link' ).on( 'click', function() {
				tb_show( L10n.screenOptions, '#TB_inline?inlineId=screen-options-wrap' );
			} );
			// Help
			$( '#contextual-help-link' ).on( 'click', function() {
				tb_show( L10n.help, '#TB_inline?inlineId=contextual-help-wrap' );
			} );
		}
	}

	/* 5.0 Revert Clientside Options */

	// Event: General Options Revert button click
	$( '.clientside-options-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( L10n.revertConfirm ) ) {
			// Add a revert request field to the form & submit it
			$( '.clientside-options-form' ).prepend( '<input type="hidden" name="' + L10n.options_slug + '[clientside-revert-page]" value="1" />' );
			$( '.clientside-options-save-button' ).trigger( 'click' );
		}

	});

	/* 6.0 Admin Menu Editor Tool */

	// Process changes
	function clientside_process_admin_menu_editor() {

		var $menu_list = $(' .clientside-admin-menu-editor ');
		var data;

		// Also collect values of unchecked checkboxes
		$menu_list.find(':checkbox:disabled').prop( 'disabled', false ).addClass( '-disabled' );
		$menu_list.find(':checkbox:not(:checked)').attr( 'value', '0' ).prop( 'checked', true ).addClass( '-unchecked' );

		// Collect data
		data = $menu_list.find( ':input' ).serializeArray();
		data = JSON.stringify( data );

		// Put checkboxes back to normal
		$menu_list.find( '.-disabled' ).prop( 'disabled', true ).removeClass( '-disabled' );
		$menu_list.find( '.-unchecked' ).attr( 'value', '1' ).prop( 'checked', false ).removeClass( '-unchecked' );

		// Enter data into plugin option form field
		$( '#clientside-formfield-admin-menu' ).val( data );

	}

	// Activate jQuery UI Sortable
	$( '.clientside-admin-menu-editor-mainmenu' ).sortable( {
		// Elements to exclude from dragging
		cancel: '.clientside-admin-menu-editor-item-edit, .clientside-admin-menu-editor-item-settings, .clientside-admin-menu-editor-submenu',
		// CSS class to give to the drop area
		placeholder: 'sortable-placeholder',
		update: function() {

			// Browser warning when navigating away without saving changes
			window.onbeforeunload = function() {
				return L10n.saveAlert;
			};

			// Process new menu settings into hidden form field
			clientside_process_admin_menu_editor();

		}
	} );

	// Event: Edit button click
	$document.on( 'click', '.clientside-admin-menu-editor-item-edit', function( e ) {
		e.preventDefault();
		e.stopPropagation();
		$( this ).parent().toggleClass( '-open' );
	} );
	$document.on( 'click', '.clientside-admin-menu-editor-page', function( e ) {
		e.preventDefault();
		$( this ).toggleClass( '-open' );
	} );

	// Prevent closing the menu item when clicking around the settings
	$document.on( 'click', '.clientside-admin-menu-editor-item-settings', function( e ) {
		e.stopPropagation();
	} );

	// Event: Save button click
	$( '.clientside-admin-menu-save-button' ).on( 'click', function() {

		// Remove save warning message if present
		window.onbeforeunload = null;

	} );

	// Event: Admin Menu Editor Revert button click
	$( '.clientside-admin-menu-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( L10n.revertConfirm ) ) {
			// Empty the form value & submit the form
			$( '#clientside-formfield-admin-menu' ).val( '' );
			$( '.clientside-admin-menu-save-button' ).trigger( 'click' );
		}

	});

	// Event: Process any changes to the menu items
	$( '.clientside-admin-menu-editor' ).on( 'change blur', 'input', function( e ) {
		clientside_process_admin_menu_editor();
	} );

	/* 7.0 Admin Widget Manager */

	// Event: Admin Widget Manager Revert button click
	$( '.clientside-admin-widget-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( L10n.revertConfirm ) ) {
			// Add a revert request field to the form & submit it
			$( '.clientside-admin-widget-manager-form' ).prepend( '<input type="hidden" name="' + L10n.options_slug + '[clientside-revert-page]" value="1" />' );
			$( '.clientside-admin-widget-save-button' ).trigger( 'click' );
		}

	});

	/* 8.0 Admin Column Manager */

	// Event: Admin Column Manager Revert button click
	$( '.clientside-admin-column-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( L10n.revertConfirm ) ) {
			// Add a revert request field to the form & submit it
			$( '.clientside-admin-column-manager-form' ).prepend( '<input type="hidden" name="' + L10n.options_slug + '[clientside-revert-page]" value="1" />' );
			$( '.clientside-admin-column-save-button' ).trigger( 'click' );
		}

	});

	/* 9.0 Custom Media Manager trigger */
	$( '.clientside-media-select-button' ).on( 'click', function( e ) {

		e.preventDefault();
		var $this = $( this );
		var $input = $( '#' + this.id.replace( '-upload-button', '' ) );
		var $preview = $( '#' + this.id.replace( '-upload-button', '-preview' ) );
		var $preview_image = $( '#' + this.id.replace( '-upload-button', '-preview-image' ) );

		// Prepare the callback
		wp.media.editor.send.attachment = function( props, attachment ) {
			$input.val( attachment.url );
			$preview_image.attr( 'src', attachment.url );
			$preview.hide().fadeIn( 300 );
		};

		// Open the media manager
		wp.media.editor.open();

	} );

	/* 10.0 Main menu */

	// Event: Relay custom sidebar-menu collapse button click to original collapse button
	$( '#toplevel_page_clientside-menu-collapse > a, #wp-admin-bar-clientside-menu-expand' ).on( 'click', function( e ) {

		e.preventDefault();

		// Toggle sidebar menu
		$( '#collapse-menu' ).trigger( 'click' );

		// Don't stay focussed
		$( this ).blur();

	} );

	// Submenu click toggle
	function toggle_submenu( element ) {
		var $menu_a = $( element );
		var $menu_li = $menu_a.parents( 'li' );
		$menu_li.toggleClass( 'open' );
	}

	// Toggle on mouse-over / single tap
	if ( $body.hasClass( 'clientside-menu-hover-expand' ) && ! $body.hasClass( 'mobile' ) ) {
		$( '.clientside-theme .wp-has-submenu' ).on( 'mouseenter mouseleave', function( e ) {
			var $submenu = $( this ).children( '.wp-submenu' );
			if ( e.type === 'mouseenter' ) {
				$submenu.stop().slideDown();
			}
			else {
				$submenu.stop().slideUp();
			}
		} );
	}
	// Toggle on click / space/enter keys
	else {
		$( '.clientside-theme .wp-has-submenu > a' )
			// Toggle submenu on keypress
			.on( 'keydown', function( e ) {
				if ( e.keyCode === 32 || e.keyCode === 13 ) { // Space or Enter
					e.preventDefault();
					toggle_submenu( this );
				}
			} )
			// Toggle submenu on click
			.on( 'click', function( e ) {
				e.preventDefault();
				toggle_submenu( this );
				$( this ).blur();
			} );
	}

	/* 11.0 Conditional highlighting of elements */

	// Highlight the quick-draft save button when the form is edited
	$( '.clientside-theme #dashboard_quick_press' ).on( 'change keyup', ':input:not([type="submit"])', function() {

		var $button = $( '#save-post' );
		if ( $( '#title' ).val() || $( '#content' ).val() ) {
			$button.addClass( 'clientside-button-highlighted' );
		}
		else {
			$button.removeClass( 'clientside-button-highlighted' );
		}

	} );

	// Highlight the Bulk Action input & submit button when an action is selected
	$( '.clientside-theme .bulkactions' ).on( 'change', 'select', function() {

		var $select = $( this );
		var $button = $select.siblings( '.button' );
		if ( $select.val() !== '-1' ) {
			$select.addClass( 'clientside-input-changed' );
			$button.addClass( 'clientside-button-highlighted' );
		}
		else {
			$select.removeClass( 'clientside-input-changed' );
			$button.removeClass( 'clientside-button-highlighted' );
		}

	} );

	// Highlight the Post Filter submit button when filter criteria is selected
	$( '.clientside-theme .tablenav .bulkactions + .actions' ).on( 'change', 'select', function() {

		var $select = $( this );
			$select = $select.add( $select.siblings( 'select' ) );
		var $button = $select.siblings( '.button' );
		var value = '0';
		// Collect select values
		$select.each( function( i ) {
			if ( $( this ).val() !== '0' && $( this ).val() !== '' ) {
				value += '1';
			}
		} );
		// Highlight inputs & button
		if ( value !== '0' ) {
			$select.addClass( 'clientside-input-changed' );
			$button.addClass( 'clientside-button-highlighted' );
		}
		// Unhighlight inputs & button
		else {
			$select.removeClass( 'clientside-input-changed' );
			$button.removeClass( 'clientside-button-highlighted' );
		}

	} );

	// Highlight the Search Box button when a string is entered
	$( '.clientside-theme .search-box' ).on( 'change keyup blur', '[type="search"]', function() {
		var $input = $( this );
		var $button = $input.siblings( '.button' );
		if ( $input.val() ) {
			$button.addClass( 'clientside-button-highlighted' );
		}
		else {
			$button.removeClass( 'clientside-button-highlighted' );
		}
	} );

	// Highlight theme/plugin editor documentation when interacted with
	$( '.clientside-theme #documentation' ).on( 'change', 'select', function() {

		var $select = $( this );
		var $button = $select.siblings( '.button' );
		if ( $select.val() ) {
			$select.addClass( 'clientside-input-changed' );
			$button.addClass( 'clientside-button-highlighted' );
		}
		else {
			$select.removeClass( 'clientside-input-changed' );
			$button.removeClass( 'clientside-button-highlighted' );
		}

	} );

	/* 12.0 Animating scroll triggers */

	// Scroll the page with animation
	function scrollto( y_position ) {
		y_position = y_position || 0;
		y_position = y_position < 0 ? 0 : y_position;
		$( 'html, body' ).stop().animate( { scrollTop: y_position }, 600 );
	}

	// Capture clicks on on-page hash links and trigger an animated scroll
	$( '[href^="#"]' ).on( 'click', function( e ) {

		var href = $( this ).attr( 'href' );

		// Ignore if this is a Thickbox call
		if ( href.substring(0, 4) === "#TB_" ) {
			return true;
		}
		// Ignore post edit screen publish detail forms
		if ( href === '#post_status' || href === '#visibility' || href === '#edit_timestamp' ) {
			return true;
		}

		var $target = $( href );
		if ( $target.length ) {
			//e.preventDefault(); // Caused trouble for cases where there were other events attached
			scrollto( $target.offset().top );
		}

	} );

	// Relay a click to another element (generic)
	$( '[data-js-relay]' ).on( 'click', function( e ) {
		var $this = $( this );
		var $target = $( $this.data( 'js-relay' ) );
		if ( $target.length ) {
			$target.trigger( 'click' );
		}
	} );

	/* 13.0 Add global back-to-top button to left-bottom */

	// Add back-to-top arrow to left-bottom
	if ( theme ) {
		var $backtotop = $( '<div class="clientside-back-to-top" title="' + L10n.backtotop + '"><span class="dashicons dashicons-arrow-up-alt2"></span></div>' )
			.appendTo( $body )
			.on( 'click', function() {
				scrollto( 0 );
				$backtotop.fadeOut( 150 );
			} );
		var scroll_timeout;
		var is_visible = false;
		$window.on( 'scroll', function() {
			clearTimeout( scroll_timeout );
			scroll_timeout = setTimeout( function() {
				// Hide scroll-to-top button
				if ( $window.scrollTop() <= 600 ) {
					$backtotop
						.stop( true, true )
						.fadeOut( 150 );
					is_visible = false;
				}
				// Show scroll-to-top button
				else if ( is_visible === false ) {
					is_visible = true;
					$backtotop
						.stop( true, true )
						.fadeIn( 150 );
				}
			}, 100 );
		} );
	}

	/* 14.0 Add warning when navigating away when theme/plugin editor is used */

	$( '#template #newcontent' ).one( 'change', function() {
		// Browser warning when navigating away without saving changes
		window.onbeforeunload = function() {
			return L10n.saveAlert;
		};
	} );

	// Remove warning when submit button is clicked
	$( '#template #submit ').on( 'click', function() {
		window.onbeforeunload = null;
	} );

	/* 15.0 Add a .wrap to (plugin) pages that don't have one */

	if ( ! $( '.wrap' ).length ) {
		$( '#wpbody-content' ).wrapInner( '<div class="wrap" />' );
		$( '#screen-meta-links' ).insertBefore( $( '#wpbody-content > .wrap' ) );
	}

	/* 16.0 Notification Center */

	if ( $body.hasClass( 'clientside-notification-center' ) && ! $body.hasClass( 'mobile' ) ) {

		var $toolbar_item = $( '#wp-admin-bar-clientside-notification-center' );
		var $submenu = $toolbar_item.find( '.ab-submenu' );
		var notification_count = 0;
		var important_flag = false;
		var $alerts = $( '.update-nag, .notice, .notice-success, .updated, .settings-error, .error, .notice-error, .notice-warning, .notice-info' )
			.not( '.inline, .theme-update-message, .hidden, .hide-if-js' );
		var greens = [ 'updated', 'notice-success' ];
		var reds = [ 'error', 'notice-error', 'settings-error' ];
		var blues = [ 'update-nag', 'notice', 'notice-info', 'update-nag', 'notice-warning' ];

		// Itirate page alerts to analyse & copy to the toolbar
		$alerts.each( function( i ) {

			var $alert = $( this );
			var content = $alert.html();

			// Strip content whitespace
			content = content.replace( /^\s+|\s+$/g, '' );

			// Only continue if not empty
			if ( ! content ) {
				return true;
			}

			// Determine the priority
			var j;
			var priority = 'neutral';
			// Red
			for ( j = 0; j < reds.length; j += 1 ) {
				if ( $alert.hasClass( reds[ j ] ) ) {
					if ( ! $alert.hasClass( 'updated' ) ) { // Because of .settings-error.updated
						priority = 'red';
						// Color toolbar icon red if it contains important/error notifications
						if ( ! important_flag ) {
							$toolbar_item.addClass( '-important' );
							important_flag = true;
						}
					}
				}
			}

			// Add it to the notification list
			$submenu.append( '<li><div class="ab-item ab-empty-item clientside-notification-center-item--' + priority + '">' + content + '</div></li>' );
			notification_count += 1;

		} );

		// Populate the counter
		$( '.clientside-notification-count' ).text( notification_count );

		// Show the toolbar item
		if ( notification_count ) {
			$alerts.remove(); // Make sure they don't cause extra spacing by breaking "+" selectors
			$toolbar_item.fadeIn();
		}

	}

} );