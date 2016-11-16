(function( $, _, as3cfModal ) {

	var adminUrl = ajaxurl.replace( '/admin-ajax.php', '' );
	var spinnerUrl = adminUrl + '/images/spinner';

	var doingLicenceRegistrationAjax = false;
	var savedSettings = null;

	if ( window.devicePixelRatio >= 2 ) {
		spinnerUrl += '-2x';
	}

	spinnerUrl += '.gif';

	as3cfpro.spinnerUrl = spinnerUrl;

	/**
	 * Convert form inputs to single level object
	 *
	 * @param {object} form
	 *
	 * @returns {object}
	 */
	function formInputsToObject( form ) {
		var formInputs = $( form ).serializeArray();
		var inputsObject = {};

		$.each( formInputs, function( index, input ) {
			inputsObject[ input.name ] = input.value;
		} );

		return inputsObject;
	}

	/**
	 * Extend the tabs toggle function to check the license
	 * if the support tab is clicked
	 *
	 * @type {as3cf.tabs.toggle}
	 */
	var orginalToggle = as3cf.tabs.toggle;
	as3cf.tabs.toggle = function( hash ) {
		orginalToggle( hash );
		if ( 'support' === hash ) {
			if ( '1' === as3cfpro.strings.has_licence ) {
				checkLicence();
			} else {
				$( '.licence-input' ).focus();
			}
		} else {
			editcheckLicenseURL( hash );
		}

		toggleSidebarTools( hash );
	};

	/**
	 * Extend the buckets set method to refresh the media upload notice
	 *
	 * @type {as3cf.buckets.set}
	 */
	var originalBucketSet = as3cf.buckets.set;
	as3cf.buckets.set = function( bucket, region, canWrite ) {
		// Store the active bucket before the selection has been made
		var activeBucket = $( '#' + as3cfModal.prefix + '-active-bucket' ).text();

		// Run the parent set bucket method
		originalBucketSet( bucket, region, canWrite );

		if ( 'as3cf' === as3cfModal.prefix && '' === activeBucket.trim() ) {
			// If we are setting the bucket for the first time,
			// trigger the render of the pro tools
			renderSidebarTools();
		}
	};

	/**
	 * Edit the hash of the check license URL so we reload to the correct tab
	 *
	 * @param hash
	 */
	function editcheckLicenseURL( hash ) {
		if ( 'support' !== hash && $( '.as3cf-pro-check-again' ).length ) {
			var checkLicenseURL = $( '.as3cf-pro-check-again' ).attr( 'href' );

			if ( as3cf.tabs.defaultTab === hash ) {
				hash = '';
			}

			if ( '' !== hash ) {
				hash = '#' + hash;
			}

			var index = checkLicenseURL.indexOf( '#' );
			if ( 0 === index ) {
				index = checkLicenseURL.length;
			}

			checkLicenseURL = checkLicenseURL.substr( 0, index ) + hash;

			$( '.as3cf-pro-check-again' ).attr( 'href', checkLicenseURL );
		}
	}

	/**
	 * Check the license and return license info from deliciousbrains.com
	 *
	 * @param string licence
	 */
	function checkLicence( licence ) {
		if ( $( '.support-content' ).hasClass( 'checking-licence' ) ) {
			return;
		}

		$( '.support-content' ).addClass( 'checking-licence' );
		$( '.support-content p:first' ).append( '<img src="' + as3cfpro.spinnerUrl + '" alt="" class="check-license-ajax-spinner general-spinner" />' );
		$( '.as3cf-pro-license-notice' ).remove();

		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				action: 'as3cfpro_check_licence',
				licence: licence,
				nonce: as3cfpro.nonces.check_licence
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				alert( as3cfpro.strings.license_check_problem );
				$( '.support-content' ).removeClass( 'checking-licence' );
			},
			success: function( data ) {
				if ( 'undefined' !== typeof data.dbrains_api_down ) {
					$( '.support-content' ).empty().html( data.dbrains_api_down + data.message );
				} else if ( 'undefined' !== typeof data.errors ) {
					var msg = '';

					for ( var key in data.errors ) {
						msg += data.errors[ key ];
					}

					$( '.support-content' ).empty().html( msg );
				} else {
					$( '.support-content' ).empty().html( data.message );
				}

				if ( 'undefined' !== typeof data.pro_error && 0 === $( '.as3cf-pro-license-notice' ).length ) {
					$( 'h2.nav-tab-wrapper' ).after( data.pro_error );
				}

				$( '.support-content' ).removeClass( 'checking-licence' );
			}
		} );
	}

	/**
	 * Render the sidebar tools
	 */
	function renderSidebarTools() {
		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				action: 'as3cfpro_render_sidebar_tools',
				nonce: as3cfpro.nonces.render_sidebar_tools
			},
			success: function( response ) {
				if ( true === response.success && 'undefined' !== typeof response.data ) {
					$( '.as3cf-sidebar.pro' ).empty();
					$( '.as3cf-sidebar.pro' ).prepend( response.data );
					var hash = getURLHash();
					toggleSidebarTools( hash );

					$( '.as3cf-sidebar.pro .block .progress-bar-wrapper .progress-bar' ).each( function() {
						$( this ).animate( {
							width: $( this ).parent().data( 'percentage' ) + '%'
						}, 1200 );
					} );
				}
			}
		} );
	}

	/**
	 * Show the correct sidebar tools for the tab
	 *
	 * @param {string} tab
	 */
	function toggleSidebarTools( tab ) {
		tab = ( '' === tab ) ? as3cf.tabs.defaultTab : tab;

		$( '.as3cf-sidebar.pro .block' ).not( '.' + tab ).hide();
		$( '.as3cf-sidebar.pro .block.' + tab ).show();
	}

	/**
	 * Get the hash of the URL
	 *
	 * @returns {string}
	 */
	function getURLHash() {
		var hash = '';
		if ( window.location.hash ) {
			hash = window.location.hash.substring( 1 );
		}

		hash = as3cf.tabs.sanitizeHash( hash );

		return hash;
	}

	$( document ).ready( function() {
		var hash = getURLHash();
		editcheckLicenseURL( hash );
		toggleSidebarTools( hash );

		var $settingsForm = $( '#tab-' + as3cf.tabs.defaultTab + ' .as3cf-main-settings form' );

		savedSettings = formInputsToObject( $settingsForm );

		/**
		 * Navigate to the support tab when the activate license link is clicked
		 */
		$( '.enter-licence' ).click( function( e ) {
			e.preventDefault();
			as3cf.tabs.toggle( 'support' );
			window.location.hash = 'support';
			$( '.licence-input' ).focus();
		} );

		/**
		 * Finish license registration
		 *
		 * @param object data
		 * @param string licenceKey
		 */
		function enableProLicence( data, licenceKey ) {
			$( '.licence-input, .register-licence' ).remove();
			$( '.licence-not-entered' ).prepend( data.masked_licence );
			$( '.support-content' ).empty().html( '<p>' + as3cfpro.strings.fetching_license + '</p>' );
			// Trigger the refresh of the pro tools
			renderSidebarTools();
			checkLicence( licenceKey );
		}

		$( '.licence-form' ).submit( function( e ) {
			e.preventDefault();

			if ( doingLicenceRegistrationAjax ) {
				return;
			}

			$( '.licence-status' ).removeClass( 'notification-message error-notice success-notice' );

			var licenceKey = $.trim( $( '.licence-input' ).val() );

			if ( '' === licenceKey ) {
				$( '.licence-status' ).addClass( 'notification-message error-notice' );
				$( '.licence-status' ).html( as3cfpro.strings.enter_license_key );
				return;
			}

			$( '.as3cf-pro-license-notice' ).remove();
			$( '.licence-status' ).empty().removeClass( 'success' );
			doingLicenceRegistrationAjax = true;
			$( '.button.register-licence' ).attr( 'disabled', true );
			$( '.button.register-licence' ).after( '<img src="' + as3cfpro.spinnerUrl + '" alt="" class="register-licence-ajax-spinner general-spinner" />' );

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				cache: false,
				data: {
					action: 'as3cfpro_activate_licence',
					licence_key: licenceKey,
					nonce: as3cfpro.nonces.activate_licence
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					doingLicenceRegistrationAjax = false;
					$( '.register-licence-ajax-spinner' ).remove();
					$( '.licence-status' ).html( as3cfpro.strings.register_license_problem );
					$( '.button.register-licence' ).attr( 'disabled', false );
				},
				success: function( data ) {
					doingLicenceRegistrationAjax = false;
					$( '.button.register-licence' ).attr( 'disabled', false );
					$( '.register-licence-ajax-spinner' ).remove();

					if ( 'undefined' !== typeof data.errors ) {
						var msg = '';
						for ( var key in data.errors ) {
							msg += data.errors[ key ];
						}

						$( '.licence-status' ).html( msg );

						if ( 'undefined' !== typeof data.masked_licence ) {
							enableProLicence( data, licenceKey );
						}
					} else if ( 'undefined' !== typeof data.wpmdb_error  && 'undefined' !== typeof data.body ) {
						$( '.licence-status' ).html( data.body );
					} else {
						$( '.licence-status' ).html( as3cfpro.strings.license_registered ).delay( 5000 ).fadeOut( 1000 );
						$( '.licence-status' ).addClass( 'success notification-message success-notice' );
						enableProLicence( data, licenceKey );
						$( '.invalid-licence' ).hide();
					}

					if ( 'undefined' !== typeof data.pro_error && 0 === $( '.as3cf-pro-license-notice' ).length ) {
						$( 'h2.nav-tab-wrapper' ).after( data.pro_error );
					}
				}
			} );

		} );

		$( 'body' ).on( 'click', '.reactivate-licence', function( e ) {
			e.preventDefault();

			var $processing = $( '<div/>', { id: 'processing-licence' } ).html( as3cfpro.strings.attempting_to_activate_licence );
			$processing.append( '<img src="' + as3cfpro.spinnerUrl + '" alt="" class="check-license-ajax-spinner general-spinner" />' );
			$( '.invalid-licence' ).hide().after( $processing );

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: 'as3cfpro_reactivate_licence',
					nonce: as3cfpro.nonces.reactivate_licence
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					$processing.remove();
					$( '.invalid-licence' ).show().html( as3cfpro.strings.activate_licence_problem );
					$( '.invalid-licence' ).append( '<br /><br />' + as3cfpro.strings.status + ': ' + jqXHR.status + ' ' + jqXHR.statusText + '<br /><br />' + as3cfpro.strings.response + '<br />' + jqXHR.responseText );
				},
				success: function( data ) {
					$processing.remove();

					if ( 'undefined' !== typeof data.as3cfpro_error && 1 === data.as3cfpro_error ) {
						$( '.invalid-licence' ).html( data.body ).show();
						return;
					}

					if ( 'undefined' !== typeof data.dbrains_api_down && 1 === data.dbrains_api_down ) {
						$( '.invalid-licence' ).html( as3cfpro.strings.temporarily_activated_licence );
						$( '.invalid-licence' ).append( data.body ).show();
						return;
					}

					$( '.invalid-licence' ).empty().html( as3cfpro.strings.licence_reactivated );
					$( '.invalid-licence' ).addClass( 'success notification-message success-notice' ).show();
					location.reload();
				}
			} );

		} );

		// Show support tab when 'support request' link clicked within compatibility notices
		$( 'body' ).on( 'click', '.support-tab-link', function( e ) {
			as3cf.tabs.toggle( 'support' );
		} );

	} );
})( jQuery, _, as3cfModal );
