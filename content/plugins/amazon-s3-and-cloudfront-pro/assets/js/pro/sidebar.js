(function( $, _ ) {

	/**
	 * The object that handles the sidebar.
	 */
	as3cfpro.Sidebar = {

		/**
		 * Poll interval.
		 *
		 * {number}
		 */
		pollInterval: 0,

		/**
		 * Busy.
		 *
		 * {object}
		 */
		busy: {},

		/**
		 * Tools.
		 *
		 * {object}
		 */
		tools: {},

		/**
		 * Set tools statuses.
		 *
		 * @param {object} tools
		 */
		setTools: function( tools ) {
			this.tools = tools;
		},

		/**
		 * Update tools statuses.
		 *
		 * @param {object} status
		 */
		updateTools: function( status ) {
			$.each( this.tools, function( tab, tools ) {
				$.each( tools, function( index ) {
					if ( null != status[ index ] ) {
						as3cfpro.Sidebar.tools[ tab ][ index ] = status[ index ];
					}
				} );
			} );

			this.refreshButtonStates();
		},

		/**
		 * Update tool status.
		 *
		 * @param {string} tool
		 * @param {object} status
		 */
		updateTool: function( tool, status ) {
			$.each( this.tools, function( tab, tools ) {
				for ( var toolKey in tools ) {
					if ( toolKey === tool ) {
						as3cfpro.Sidebar.tools[ tab ][ tool ] = status;

						return false;
					}
				}
			} );

			this.refreshButtonStates();
		},

		/**
		 * Tool is processing.
		 *
		 * @param {string} tool
		 */
		setToolAsProcessing: function( tool ) {
			this.updateTool( tool, { is_processing: true } );
		},

		/**
		 * Tool is idle.
		 *
		 * @param {string} tool
		 */
		setToolAsIdle: function( tool ) {
			this.updateTool( tool, { is_processing: false } );
		},

		/**
		 * Start poll interval.
		 */
		startPollInterval: function() {
			this.pollInterval = setInterval( this.getStatus, 5000 );
		},

		/**
		 * Refresh button states.
		 */
		refreshButtonStates: function() {
			if ( this.tools.length <= 0 ) {
				return;
			}

			$.each( this.tools, function( tab, tools ) {
				var processing = [];

				$.each( tools, function( key, tool ) {
					if ( tool.is_processing || tool.is_queued ) {
						processing.push( key );
					}
				} );

				if ( processing.length > 0 ) {
					as3cfpro.Sidebar.lockTab( tab );
				} else {
					as3cfpro.Sidebar.unlockTab( tab );
				}
			} );
		},

		/**
		 * Lock a tab's tools.
		 *
		 * @param {string} tab
		 */
		lockTab: function( tab ) {
			$( '.as3cf-sidebar [data-tab="' + tab + '"]' )
				.find( '.button.start' )
				.addClass( 'disabled' );
		},

		/**
		 * Unlock a tab's tools.
		 *
		 * @param {string} tab
		 */
		unlockTab: function( tab ) {
			$( '.as3cf-sidebar [data-tab="' + tab + '"]' )
				.find( '.button.start' )
				.removeClass( 'disabled' );
		},

		/**
		 * Is the tab locked?
		 *
		 * @param {string} tab
		 *
		 * @return {boolean}
		 */
		isTabLocked: function( tab ) {
			if ( null != this.tools[ tab ] ) {
				for ( var tool in this.tools[ tab ] ) {
					if ( this.tools[ tab ][ tool ].is_processing || this.tools[ tab ][ tool ].is_queued ) {
						return true;
					}
				}
			}

			return false;
		},

		/**
		 * Get status.
		 */
		getStatus: function() {
			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				data: {
					nonce: as3cfpro.nonces.get_status,
					action: 'as3cfpro_get_status'
				},
				success: function( result ) {
					as3cfpro.Sidebar.updateSidebar( result );
					as3cfpro.Sidebar.updateTools( result );
				}
			} );
		},

		/**
		 * Update sidebar.
		 *
		 * @param {object} result
		 */
		updateSidebar: function( result ) {
			if ( _.isEmpty( result ) ) {
				return;
			}

			_.each( result, as3cfpro.Sidebar.updateSidebarBlock );
		},

		/**
		 * Update sidebar block.
		 *
		 * @param {object} status
		 * @param {string} id
		 */
		updateSidebarBlock: function( status, id ) {
			if ( as3cfpro.Sidebar.isToolBusy( id ) ) {
				return;
			}

			var $block = $( '.as3cf-sidebar.pro' ).find( '#' + id );
			var $progressBar = $block.find( '.progress-bar' );

			$( $progressBar ).animate( {
				width: status.progress + '%'
			}, 1200 );

			as3cfpro.Sidebar.updateBlockStatusDescription( $block, status.description );
			as3cfpro.Sidebar.updateBlockProgressContainer( $block, status );
			as3cfpro.Sidebar.updateBlockButtons( $block, status );

			if ( ! status.is_paused && ! status.is_cancelled || ! status.is_processing ) {
				$block.find( '.button' ).removeClass( 'disabled' );
			}

			$block.trigger( 'status-change', status );
		},

		/**
		 * Is tool busy.
		 *
		 * @param {string } tool
		 *
		 * @returns {boolean}
		 */
		isToolBusy: function( tool ) {
			if ( null != this.busy[ tool ] && this.busy[ tool ] ) {
				return true;
			}

			return false;
		},

		/**
		 * Update block status description.
		 *
		 * @param {object} $block
		 * @param {string} description
		 */
		updateBlockStatusDescription: function( $block, description ) {
			var $description = $block.find( '.block-description' );

			if ( null != description && description.length > 0 ) {
				$description.html( description ).show();
			} else {
				$description.hide();
			}
		},

		/**
		 * Update block progress bar.
		 *
		 * @param {object} $block
		 * @param {number} percentage
		 */
		updateBlockProgressBar: function( $block, percentage ) {
			$block.find( '.progress-bar' ).css( 'width', percentage + '%' );
		},

		/**
		 * Update block progress container.
		 *
		 * @param {object} $block
		 * @param {object} status
		 */
		updateBlockProgressContainer: function( $block, status ) {
			var $progressContainer = $block.find( '.progress-bar-wrapper' );

			if ( status.is_paused && ! status.is_processing ) {
				$progressContainer.addClass( 'paused' );
			} else {
				$progressContainer.removeClass( 'paused' );
			}

			if ( status.is_queued ) {
				$progressContainer.show();
			} else {
				$progressContainer.hide();
			}
		},

		/**
		 * Update block buttons.
		 *
		 * @param {object} $block
		 * @param {object} status
		 */
		updateBlockButtons: function( $block, status ) {
			var $container = $block.find( '.button-wrapper' );
			var $pauseButton = $container.find( '.pause' );
			var $resumeButton = $container.find( '.resume' );

			if ( status.is_queued ) {
				$container.addClass( 'processing' );

				if ( status.is_paused ) {
					$pauseButton.hide();
					$resumeButton.show();
				} else {
					$pauseButton.show();
					$resumeButton.hide();
				}
			} else {
				$container.removeClass( 'processing' );
				$pauseButton.hide();
				$resumeButton.hide();
			}
		},

		/**
		 * Handle manual action.
		 *
		 * @param {object} event
		 */
		handleManualAction: function( event ) {
			event.preventDefault();

			if ( $( event.target ).hasClass( 'disabled' ) ) {
				return;
			}

			var $element = $( event.target );
			var $block = $element.closest( '.block' );
			var tool = $block.attr( 'id' );
			var busyText = as3cfpro.Sidebar.getBusyText( $element );

			as3cfpro.Sidebar.busy[ tool ] = true;

			$block.find( '.button' ).addClass( 'disabled' );

			var status = {
				is_queued: true,
				is_paused: false,
				is_processing: true
			};

			as3cfpro.Sidebar.updateBlockProgressContainer( $block, status );
			as3cfpro.Sidebar.updateBlockButtons( $block, status );

			if ( busyText ) {
				as3cfpro.Sidebar.updateBlockStatusDescription( $block, busyText );
			}

			if ( 'start' === event.data.action ) {
				as3cfpro.Sidebar.setToolAsProcessing( tool );
			}

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				data: {
					nonce: as3cfpro.nonces.tools[ tool ][ event.data.action ],
					action: 'as3cfpro_' + tool + '_' + event.data.action
				},
				complete: function() {
					setTimeout( function() {
						as3cfpro.Sidebar.busy[ tool ] = false;
					}, 1000 );
				}
			} );
		},

		/**
		 * Get busy text.
		 *
		 * @returns {string}
		 */
		getBusyText: function( $element ) {
			var text = $element.data( 'busy-description' );

			if ( null != text && text.length ) {
				return text;
			}

			return '';
		}
	};

	// Event Handlers
	$( document ).ready( function() {
		as3cfpro.Sidebar.setTools( as3cfSidebarTools );
		as3cfpro.Sidebar.startPollInterval();
		as3cfpro.Sidebar.refreshButtonStates();

		// Listen to start
		$( '.as3cf-sidebar' ).on( 'click', '.background-tool .button.start', {
			action: 'start'
		}, as3cfpro.Sidebar.handleManualAction );

		// Listen to cancel
		$( '.as3cf-sidebar' ).on( 'click', '.background-tool .button.cancel', {
			action: 'cancel'
		}, as3cfpro.Sidebar.handleManualAction );

		// Listen to pause/resume
		$( '.as3cf-sidebar' ).on( 'click', '.background-tool .button.pause-resume', {
			action: 'pause_resume'
		}, as3cfpro.Sidebar.handleManualAction );
	} );

})( jQuery, _ );
