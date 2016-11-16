(function( $ ) {

	$( document ).ready( function() {

		$( 'body' ).on( 'click', '#as3cfpro-toggle-acl', function( e ) {
			e.preventDefault();

			var toggle = $( '#as3cfpro-toggle-acl' );
			var currentACL = toggle.attr( 'data-currentACL' );
			var currentACLText = toggle.text();
			var newACL = as3cfpro_media.settings.private_acl;

			toggle.hide();
			toggle.after( '<span id="as3cfpro-updating">' + as3cfpro_media.strings.updating_acl + '</span>' );

			if ( currentACL === as3cfpro_media.settings.private_acl ) {
				newACL = as3cfpro_media.settings.default_acl;
			}

			wp.ajax.send( 'as3cfpro_update_acl', {
				data: {
					_nonce: as3cfpro_media.nonces.update_acl,
					id: as3cfpro_media.settings.post_id,
					acl: newACL
				}
			} ).done( function( response ) {
				$( '#as3cfpro-updating' ).remove();

				toggle.text( response.acl_display );
				toggle.attr( 'title', response.title );
				toggle.attr( 'data-currentACL', response.acl );
				toggle.show();
			} ).fail( function( response ) {
				$( '#as3cfpro-updating' ).remove();

				toggle.show();

				alert( as3cfpro_media.strings.change_acl_error );
			} );
		} );

		// Ask for confirmation when trying to remove attachment from S3 when the local file is missing
		$( 'body' ).on( 'click', '.s3-actions a.local-warning', function( e ) {
			if ( confirm( as3cfpro_media.strings.local_warning ) ) {
				return true;
			}

			e.preventDefault();
			e.stopImmediatePropagation();

			return false;
		} );

	} );

})( jQuery );
