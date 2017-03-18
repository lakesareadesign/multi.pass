(function( $ ) {
	var $assetsTab = $( '#tab-assets' );

	/**
	 * Show the custom URL after generating a new security key
	 */
	function toggleCustomUrl( show ) {
		$( '.custom-endpoint-url-generating' ).toggle( ! show );
		$( '.custom-endpoint-url' ).toggle( show );
		$( '.refresh-url-wrap' ).toggle( show );
	}

	/**
	 * Toggle display of Gzip notice when custom domain being used
	 * and gzip option enabled.
	 */
	function toggleGzipNotice() {
		var $notice = $( '#as3cf-cdn-gzip-notice' );

		if ( 'cloudfront' === $( '#tab-assets input[name="domain"]:checked' ).val() && $( '#as3cf-assets-enable-gzip' ).is( ':checked' ) ) {
			$notice.show();
		} else {
			$notice.hide();
		}
	}

	$( document ).ready( function() {
		$( '.as3cf-setting.as3cf-assets-enable-custom-endpoint' ).on( 'click', '#refresh-url', function( e ) {
			e.preventDefault();
			toggleCustomUrl( false );

			var data = {
				_nonce: as3cf_assets.nonces.generate_key,
				action: 'as3cf-assets-generate-key'
			};

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				data: data,
				error: function( jqXHR, textStatus, errorThrown ) {
					alert( as3cf_assets.strings.generate_key_error + errorThrown );
					toggleCustomUrl( true );
				},
				success: function( data, textStatus, jqXHR ) {
					if ( 'undefined' !== typeof data[ 'success' ] ) {
						$( '#custom-endpoint-key' ).val( data[ 'key' ] );
						$( '.display-custom-endpoint-key' ).html( data[ 'key' ] );
					} else {
						alert( as3cf.strings.generate_key_error + data[ 'error' ] );
					}
					toggleCustomUrl( true );
				}
			} );
		} );

		toggleGzipNotice();
		$assetsTab.on( 'change', 'input[name="domain"], #as3cf-assets-enable-gzip-wrap', function( e ) {
			toggleGzipNotice();
		} );

		// Update sidebar tool on status change
		$( '#process_assets' ).on( 'status-change', function( event, status ) {
			var $block = $( event.target );
			var $purge = $block.find( '#as3cf-assets-manual-purge' );
			var $scan = $block.find( '#as3cf-assets-manual-scan' );

			if ( status.is_queued || ! status.purge_allowed ) {
				$purge.addClass( 'disabled' );
			} else {
				$purge.removeClass( 'disabled' );
			}

			if ( status.is_queued || ! status.scan_allowed ) {
				$scan.addClass( 'disabled' );
			} else {
				$scan.removeClass( 'disabled' );
			}

			$block.find( '.next-scan' ).html( status.next_scan );
		} );

		// Listen to scan
		$( '.as3cf-sidebar' ).on( 'click', '.background-tool .button.scan', {
			action: 'start'
		}, as3cfpro.Sidebar.handleManualAction );

		// Listen to purge
		$( '.as3cf-sidebar' ).on( 'click', '.background-tool .button.purge', {
			action: 'purge'
		}, as3cfpro.Sidebar.handleManualAction );
	} );
})( jQuery );
