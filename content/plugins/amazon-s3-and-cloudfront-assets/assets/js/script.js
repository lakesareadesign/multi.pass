(function( $, wp ) {

	$( document ).ready( function() {
		var $assetsTab = $( '#tab-assets' );

		$( '.as3cf-setting.enable-custom-endpoint' ).on( 'click', '#refresh-url', function( e ) {
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

		/**
		 * Show the custom URL after generating a new security key
		 */
		function toggleCustomUrl( show ) {
			$( '.custom-endpoint-url-generating' ).toggle( ! show );
			$( '.custom-endpoint-url' ).toggle( show );
			$( '.refresh-url-wrap' ).toggle( show );
		}

		$assetsTab.on( 'click', '.as3cf-manual-button', function( e ) {
			e.preventDefault();

			if ( $( this ).hasClass( 'disabled' ) ) {
				return;
			}

			$( '.as3cf-manual-button' ).addClass( 'disabled' );
			$( this ).html( as3cf_assets.strings.processing + '&hellip;' );

			var action = $( this ).attr( 'id' );
			var nonceName = action.replace( /-/g, '_' );
			nonceName = nonceName.replace( 'as3cf_assets_', '' );

			wp.ajax.send( action, {
				data: {
					_nonce: as3cf_assets.nonces[ nonceName ]
				}
			} );

			window.location.href = as3cf_assets.redirect_url;
		} );

		$assetsTab.on( 'change', '#enable-cron, #enable-addon', function( e ) {
			showNextScan();
		} );

		/**
		 * Toggle display of Gzip notice when custom domain being used
		 * and gzip option enabled.
		 */
		function toggleGzipNotice() {
			var $notice = $( '#as3cf-cdn-gzip-notice' );

			if ( 'cloudfront' === $( '#tab-assets input[name="domain"]:checked' ).val() && $( '#enable-gzip' ).is( ':checked' ) ) {
				$notice.show();
			} else {
				$notice.hide();
			}
		}

		toggleGzipNotice();
		$assetsTab.on( 'change', 'input[name="domain"], #enable-gzip-wrap', function( e ) {
			toggleGzipNotice();
		} );

		/**
		 * Display the next scan text only if the addon and cron is enabled
		 * and there is a next scan timestamp.
		 */
		function showNextScan() {
			var showTimestamp = false;
			if ( $( '#enable-cron' ).is( ':checked' ) && $( '#enable-addon' ).is( ':checked' ) && $( '.next-scan' ).html() ) {
				showTimestamp = true;
			}

			$( '.as3cf-setting.enable-cron' ).toggleClass( 'hide', ! showTimestamp );
		}

	} );
})( jQuery, wp );
