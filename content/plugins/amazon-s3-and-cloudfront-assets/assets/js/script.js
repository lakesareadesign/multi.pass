(function( $, wp ) {
	var $assetsTab = $( '#tab-assets' );
	var $assetsSidebar = $( '#assets-progress' );
	var $progressBarWrapper = $( '#assets-progress .progress-bar-wrapper' );
	var $progressDescription = $( '#assets-progress .block-description' );
	var $progressBar = $( '#assets-progress .progress-bar' );
	var $nextScan = $( '#assets-progress .next-scan' );
	var lastProgress = 0;
	var myInterval;

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

		if ( 'cloudfront' === $( '#tab-assets input[name="domain"]:checked' ).val() && $( '#enable-gzip' ).is( ':checked' ) ) {
			$notice.show();
		} else {
			$notice.hide();
		}
	}

	/**
	 * Display the next scan text only if the addon and cron is enabled
	 * and there is a next scan timestamp.
	 */
	function updateNextScan( nextScanText ) {
		$nextScan.html( nextScanText );

		var showTimestamp = false;
		if ( $( '#enable-cron' ).is( ':checked' ) && $( '#enable-addon' ).is( ':checked' ) && $nextScan.html() ) {
			showTimestamp = true;
		}

		$nextScan.toggleClass( 'hide', ! showTimestamp );
	}

	/**
	 * Update progress data.
	 */
	function checkProgress() {
		var data = {
			_nonce: as3cf_assets.nonces.get_progress,
			action: 'as3cf-assets-get-progress'
		};

		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			dataType: 'JSON',
			data: data,
			success: function( result ) {
				updateProgress( result );
			}
		} );
	}

	/**
	 * Update or hide progress bar and status text.
	 */
	function updateProgress( result ) {
		// We've reached the end, remove the progress bar etc.
		if ( true !== result.is_scanning && true !== result.is_purging && true !== result.is_processing ) {
			// Hide the progress bar
			$progressBarWrapper.hide();

			// Re-enable the buttons as a user can now run a different action
			updateProgressButtons( false, result );

			// Reset last progress
			lastProgress = 0;
			fillProgressBar( 0, $progressBar );
		} else {
			// Show the progress bar
			$progressBarWrapper.show();

			// Disable the buttons as a user should not run a different action
			updateProgressButtons( true, result );

			if ( lastProgress !== result.progress ) {
				fillProgressBar( result.progress, $progressBar );
			}

			// Assign our last progress value so we can check it next go-around
			lastProgress = result.progress;
		}

		// Always update our description text to reflect current status.
		$progressDescription.html( result.description );

		// Maybe show next scan date/time.
		updateNextScan( result.next_scan );
	}

	function updateProgressButtons( disable, info ) {
		if ( disable ) {
			// Disable the buttons as a user should not run a different action
			$( '.as3cf-manual-button' ).addClass( 'disabled' );
		} else {
			// Re-enable the buttons as a user can now run a different action
			$( '.as3cf-manual-button' ).removeClass( 'disabled' );
		}

		// But both scan and purge buttons could be disabled for other reasons.
		if ( true !== info.scan_allowed ) {
			$( '#as3cf-assets-manual-scan' ).addClass( 'disabled' );
		}
		if ( true !== info.purge_allowed ) {
			$( '#as3cf-assets-manual-purge' ).addClass( 'disabled' );
		}
	}

	/**
	 * Fill progress bar
	 */
	function fillProgressBar( percentage, object ) {
		$( object ).animate( {
			width: percentage + '%'
		}, 1200 );
	}

	$( document ).ready( function() {
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

		$assetsSidebar.on( 'click', '.as3cf-manual-button', function( e ) {
			e.preventDefault();

			if ( $( this ).hasClass( 'disabled' ) ) {
				return;
			}

			// Disable buttons and show progress.
			lastProgress = 0;
			$( '.as3cf-manual-button' ).addClass( 'disabled' );
			fillProgressBar( 0, $progressBar );
			$progressBarWrapper.show();

			var action = $( this ).attr( 'id' );
			var nonceName = action.replace( /-/g, '_' );
			nonceName = nonceName.replace( 'as3cf_assets_', '' );

			// Initiate the action.
			wp.ajax.send( action, {
				data: {
					_nonce: as3cf_assets.nonces[ nonceName ]
				}
			} );

			// Update the description text
			if ( 'manual_scan' === nonceName ) {
				$progressDescription.html( as3cf_assets.strings.scanning );
			} else if ( 'manual_purge' === nonceName ) {
				$progressDescription.html( as3cf_assets.strings.purging );
			}
		} );

		toggleGzipNotice();
		$assetsTab.on( 'change', 'input[name="domain"], #enable-gzip-wrap', function( e ) {
			toggleGzipNotice();
		} );

		// If we have a progress element, run our progress bar functions
		if ( 1 === $progressBarWrapper.data( 'scanning' ) ||
		     1 === $progressBarWrapper.data( 'purging' ) ||
		     1 === $progressBarWrapper.data( 'processing' )
		) {
			// Disable buttons and show progress.
			lastProgress = 0;
			$( '.as3cf-manual-button' ).addClass( 'disabled' );
			$progressBarWrapper.show();
			fillProgressBar( $progressBarWrapper.data( 'percentage' ), $progressBar );
		}

		// Set an interval count to keep checking
		myInterval = setInterval( checkProgress, 5000 );
	} );
})( jQuery, wp );
