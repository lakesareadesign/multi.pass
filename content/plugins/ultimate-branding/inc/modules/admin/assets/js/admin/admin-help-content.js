jQuery( document ).ready( function ( $ ) {

	/**
	 * Scroll window to top when a help menu opens
	 */
	$( document ).on( 'screen:options:open', function () {
		$( 'html, body' ).animate( {scrollTop: 0}, 'fast' );
	} );

	/**
	 * SUI: add item
	 */
	$( '.branda-admin-help-content-add' ).on( 'click', function () {
		var button = $( this );
		var parent = button.closest( '.sui-box' );
		var id = button.data( 'id' );
		var editor_id = $( 'textarea.wp-editor-area', parent ).attr( 'id' );
		var content = $.fn.branda_editor( editor_id );
		var data = {
			action: 'branda_admin_help_save',
			_wpnonce: button.data( 'nonce' ),
			id: id,
			title: $( 'input[type=text]', parent ).val(),
			content: content,
		};
		$.post( ajaxurl, data, function ( response ) {
			if ( response.success ) {
				window.location.reload();
			} else {
				window.ub_sui_notice( response.data.message, 'error' );
			}
		} );
	} );

	/**
	 * SUI: delete item
	 */
	$( '.branda-admin-help-content-delete' ).on( 'click', function () {
		var button = $( this );
		var data = {
			action: 'branda_admin_help_delete',
			_wpnonce: button.data( 'nonce' ),
			id: button.data( 'id' ),
		};
		$.post( ajaxurl, data, function ( response ) {
			if ( response.success ) {
				window.location.reload();
			} else {
				window.ub_sui_notice( response.data.message, 'error' );
			}
		} );
	} );
} );
