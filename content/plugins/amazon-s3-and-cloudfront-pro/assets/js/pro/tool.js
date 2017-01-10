(function( $, _ ) {

	/**
	 * The object that handles the tool processing modal
	 */
	as3cfpro.tool = {

		/**
		 * Tool identifier used by AJAX hooks
		 *
		 * {string}
		 */
		ID: '',

		/**
		 * Timer tick
		 *
		 * {int}
		 */
		timerCount: 0,

		/**
		 * Elapsed interval
		 *
		 * {number}
		 */
		elapsedInterval: 0,

		/**
		 * HTML counter display
		 *
		 * {object}
		 */
		$counterDisplay: '',

		/**
		 * Holds the name of the next method to run and its arguments
		 *
		 * {object|bool}
		 */
		nextStepInProcess: false,

		/**
		 * Is an AJAX request happening
		 *
		 * {bool}
		 */
		doingAjax: false,

		/**
		 * Is the process paused
		 *
		 * {bool}
		 */
		processPaused: false,

		/**
		 * Have any non fatal errors occurred
		 *
		 * {bool}
		 */
		nonFatalErrors: false,

		/**
		 * Has a fatal process error happened, eg. AJAX
		 *
		 * {bool}
		 */
		processError: false,

		/**
		 * Is the process complete
		 *
		 * {bool}
		 */
		processCompleted: false,

		/**
		 * Has the process been cancelled
		 *
		 * {bool}
		 */
		processCancelled: false,

		/**
		 * Is the process happening
		 *
		 * {bool}
		 */
		currentlyProcessing: false,

		/**
		 * Have all the items been processed
		 *
		 * {bool}
		 */
		itemsProcessed: false,

		/**
		 * Is the main modal active
		 *
		 * {bool}
		 */
		progressModalActive: false,

		/**
		 * Percentage of process
		 *
		 * {number}
		 */
		progressPercent: 0,

		/**
		 * Bytes processed
		 *
		 * {number}
		 */
		progressBytes: 0,

		/**
		 * Total bytes to process
		 *
		 * {number}
		 */
		progressTotalBytes: 0,

		/**
		 * Amount of items processed
		 *
		 * {number}
		 */
		progressCount: 0,

		/**
		 * Total of items processed
		 *
		 * {number}
		 */
		progressTotalCount: 0,

		/**
		 * Height of modal in window
		 *
		 * {number}
		 */
		contentHeight: 0,

		/**
		 * HTML of open modal
		 *
		 * {object|bool}
		 */
		$progressContent: false,

		/**
		 * Copy of modal
		 *
		 * {object|bool}
		 */
		$progressContentOriginal: false,

		/**
		 * Open the tool modal
		 *
		 * @param {number} id
		 */
		open: function( id ) {
			this.ID = id;
			as3cfpro.tool.openModal();
		},

		/**
		 * Trigger a tool opening from a settings page URL
		 * eg. wp-admin/admin.php?page=amazon-s3-and-cloudfront&tool={tool_key}
		 */
		openFromURL: function() {
			var page_url = window.location.search.substring( 1 );
			var query_string = page_url.split( '&' );

			for ( var i = 0; i < query_string.length; i++ ) {
				var param_name = query_string[ i ].split( '=' );

				if ( 'tool' === param_name[ 0 ] ) {
					this.open( param_name[ 1 ] );

					return;
				}
			}
		},

		/**
		 * Clone and store the modal views
		 */
		cloneViews: function() {
			this.$progressContentOriginal = $( '.progress-content' ).clone();

			$( '.progress-content' ).remove();
		},

		/**
		 * Animate the progress bars for all sidebar tool blocks to the desired widths
		 */
		animateProgressBars: function() {
			$( '.as3cf-sidebar.pro .block .progress-bar-wrapper .progress-bar' ).each( function() {
				$( this ).animate( {
					width: $( this ).parent().data( 'percentage' ) + '%'
				}, 1200 );
			} );
		},

		/**
		 * Render pie chart for sidebar tool block using simple trigonometry
		 */
		renderPieChart: function() {
			var percentage, path, angle, radius = 100, coords = [];

			percentage = $( '.as3cf-sidebar.pro .pie-chart' ).data( 'percentage' );

			if ( percentage >= 100 ) {
				$( '.as3cf-sidebar.pro .pie-chart ~ h4' ).addClass( 'completed' );
			}

			// Return early no pie chart display
			if ( percentage < 1 || percentage > 99 ) {
				return;
			}

			angle = percentage * 3.6;
			coords[0] = radius * Math.cos( Math.PI * angle / 180 );
			coords[1] = radius * Math.sin( Math.PI * angle / 180 );
			path = 'M0,0 L' + radius + ',0 A' + radius + ',' + radius + ' 0 1,1 ' + coords[0] + ',' + coords[1] + ' Z';

			$( '.as3cf-sidebar.pro .pie-chart ~ h4' ).removeClass( 'completed' );
			$( '.as3cf-sidebar.pro .pie-chart svg path' ).attr( 'd', path );
		},

		/**
		 * Open the Tool modal
		 */
		openModal: function() {
			var docHeight = $( document ).height();

			$( 'body' ).append( '<div id="overlay"></div>' );

			$( '#overlay' )
				.height( docHeight )
				.css( {
					'position': 'fixed',
					'top': 0,
					'left': 0,
					'width': '100%',
					'z-index': 99999,
					'display': 'none'
				} );

			this.showProgressModal();
			this.init();

			$( '#overlay' ).show();
		},

		/**
		 * Start the Tool process
		 */
		init: function() {
			var self = this;

			this.currentlyProcessing = true;
			this.doingAjax = true;

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: this.getAjaxAction( 'initiate' ),
					nonce: this.getAjaxNonce( 'initiate' )
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					self.ajaxError( jqXHR, textStatus, errorThrown );

					return;
				},
				success: function( data ) {
					if ( self.isError( data ) ) {
						return;
					}

					var progress = {
						bytes: 0,
						files: 0,
						total_bytes: 0,
						total_files: 0
					};

					if ( 'undefined' !== typeof data.progress ) {
						_.extend( progress, data.progress );
					}

					self.nextStepInProcess = { fn: self.calculateItemsRecursive, args: [ data.blogs, progress ] };
					self.executeNextStep();
				}
			} );
		},

		/**
		 * Show the main progress modal
		 */
		showProgressModal: function() {
			this.$progressContent = this.$progressContentOriginal.clone();

			this.$progressContent.find( 'h2.progress-title' ).html( this.getString( 'tool_title' ) );

			$( '#overlay' ).after( this.$progressContent );

			this.contentHeight = this.$progressContent.outerHeight();
			this.$progressContent.css( 'top', '-' + this.contentHeight + 'px' ).show().animate( { 'top': '0px' } );
			this.progressModalActive = true;

			$( '.upload-controls .cancel' ).after( '<img src="' + as3cfpro.spinnerUrl + '" alt="" class="upload-progress-ajax-spinner general-spinner" />' );

			this.setupCounter();
		},

		/**
		 * Cancel the Tool process
		 */
		cancel: function() {
			this.processCancelled = true;
			this.processPaused = false;
			$( '.upload-controls' ).fadeOut();
			$( '.upload-progress-ajax-spinner' ).show();
			$( '.progress-text' ).html( this.getString( 'completing_current_request' ) );

			if ( false === this.doingAjax ) {
				this.executeNextStep();
			}
		},

		/**
		 * Helper to pad a string with another string
		 *
		 * @param {string} n
		 * @param {number} width
		 * @param {string} z
		 * @returns {*}
		 */
		pad: function( n, width, z ) {
			z = z || '0';
			n = n + '';
			return n.length >= width ? n : new Array( width - n.length + 1 ).join( z ) + n;
		},

		/**
		 * Initialize the counter display
		 */
		setupCounter: function() {
			this.timerCount = 0;
			this.$counterDisplay = $( '.timer' );
			this.elapsedInterval = setInterval( this.count, 1000 );
		},

		/**
		 * Increment the counter
		 */
		count: function() {
			var self = as3cfpro.tool;

			self.timerCount = self.timerCount + 1;
			self.displayCount();
		},

		/**
		 * Render the counter display
		 */
		displayCount: function() {
			var hours = Math.floor( this.timerCount / 3600 ) % 24;
			var minutes = Math.floor( this.timerCount / 60 ) % 60;
			var seconds = this.timerCount % 60;
			var display = this.pad( hours, 2, 0 ) + ':' + this.pad( minutes, 2, 0 ) + ':' + this.pad( seconds, 2, 0 );

			this.$counterDisplay.html( display );
		},

		/**
		 * Format a number with comma thousand separator
		 *
		 * @param {number}
		 * @returns {string}
		 */
		numberFormat: function( number ) {
			number += '';
			var x = number.split( '.' );
			var x1 = x[ 0 ];
			var x2 = x.length > 1 ? '.' + x[ 1 ] : '';
			var rgx = /(\d+)(\d{3})/;
			while ( rgx.test( x1 ) ) {
				x1 = x1.replace( rgx, '$1' + ',' + '$2' );
			}

			return x1 + x2;
		},

		/**
		 * Helper to format bytes
		 *
		 * @param {number} bytes
		 * @returns {string}
		 */
		sizeFormat: function( bytes ) {
			var thresh = 1024;
			var units = [ 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ];

			if ( bytes < thresh ) {
				return bytes + ' B';
			}

			var unitsKey = -1;

			do {
				bytes = bytes / thresh;
				unitsKey++;
			} while ( bytes >= thresh );

			return bytes.toFixed( 1 ) + ' ' + units[ unitsKey ];
		},

		/**
		 * Pause and Resume the progress
		 *
		 * @param {object} event
		 */
		setPauseResumeButton: function( event ) {
			if ( true === this.processPaused ) {
				this.processPaused = false;
				this.doingAjax = true;
				$( '.upload-progress-ajax-spinner' ).show();
				$( '.pause-resume' ).html( this.getString( 'pause' ) );
				// Resume the timer
				this.elapsedInterval = setInterval( this.count, 1000 );
				this.executeNextStep();
			} else {
				$( this ).off( event ); // Is re-bound at executeNextStep when upload is finally paused
				this.processPaused = true;
				this.doingAjax = false;
				$( '.pause-resume' ).html( this.getString( 'pausing' ) ).addClass( 'disabled' );
			}

			this.updateProgressMessage();
		},

		/**
		 * Update the progress bar
		 *
		 * @param {number} amount
		 * @param {number} total
		 * @param {number} bytesSent
		 * @param {number} bytesToSend
		 */
		updateProgress: function( amount, total, bytesSent, bytesToSend ) {
			this.progressBytes = bytesSent;
			this.progressTotalBytes = bytesToSend;
			this.progressCount = amount;
			this.progressTotalCount = total;

			// If file size available, use for percentage, else use file count
			if ( bytesToSend > 0 ) {
				this.progressPercent = Math.round( 100 * bytesSent / bytesToSend );
			} else {
				this.progressPercent = Math.round( 100 * this.progressCount / this.progressTotalCount );
			}

			$( '.progress-content .progress-bar' ).width( this.progressPercent + '%' );

			this.renderPieChart();
			this.updateProgressMessage();
		},

		/**
		 * Update the text under the progress bar
		 */
		updateProgressMessage: function() {
			var uploadProgress = this.getString( 'files_processed' ).replace( '%1$d', this.progressCount ).replace( '%2$d', this.numberFormat( this.progressTotalCount ) );
			var progressMessage = this.progressPercent + '% ' + this.getString( 'complete' );
			var bytesMessage = '';

			if ( this.progressTotalBytes > 0 && as3cfpro.settings.tools[ this.ID ].show_file_size ) {
				bytesMessage = '(' + this.sizeFormat( this.progressBytes ) + ' / ' + this.sizeFormat( this.progressTotalBytes ) + ')';
			}

			$( '.upload-progress' ).html( uploadProgress );

			if ( false === this.processPaused ) {
				$( '.progress-text' ).html( progressMessage + ' ' + bytesMessage );
			} else {
				$( '.progress-text' ).html( this.getString( 'completing_current_request' ) );
			}
		},

		/**
		 * Get the tool specific string
		 *
		 * @param {string} name
		 * @returns {string}
		 */
		getString: function( name ) {
			if ( undefined !== as3cfpro.strings[ name ] ) {
				return as3cfpro.strings[ name ];
			}

			if ( undefined !== as3cfpro.strings.tools[ this.ID ][ name ] ) {
				return as3cfpro.strings.tools[ this.ID ][ name ];
			}

			return '';
		},

		/**
		 * Get the AJAX action
		 *
		 * @param {string} action
		 * @returns {string}
		 */
		getAjaxAction: function( action ) {
			return 'as3cfpro_' + action + '_' + this.ID;
		},

		/**
		 * Get the AJAX nonce
		 *
		 * @param {string} action
		 * @returns {string}
		 */
		getAjaxNonce: function( action ) {
			return as3cfpro.nonces[ action + '_' + this.ID ];
		},

		/**
		 * Refresh the media to upload notice
		 */
		updateSidebar: function() {
			var self = this;

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: 'as3cfpro_update_sidebar',
					nonce: as3cfpro.nonces.update_sidebar,
					tool: self.ID
				},
				success: function( response ) {
					if ( true !== response.success || 'undefined' === typeof response.data ) {
						return;
					}

					$.each( response.data, function( index, value ) {
						if ( 'undefined' === typeof value.block ) {
							return;
						}

						self.renderSidebarBlock( index, value.block );
						self.renderErrorNotices( index, value.notices );
					} );

					self.renderPieChart();
				}
			} );
		},

		/**
		 * Render sidebar block.
		 *
		 * @param {string} id
		 * @param {string} html
		 */
		renderSidebarBlock: function( id, html ) {
			var $sidebar = $( '.as3cf-sidebar.pro' );

			$sidebar.find( '#' + id ).remove();

			if ( html.length ) {
				$sidebar.append( html );
			}

			$sidebar.find( '#' + id ).show();
		},

		/**
		 * Render error notices.
		 *
		 * @param {string} id
		 * @param {bool|object} notices
		 */
		renderErrorNotices: function( id, notices ) {
			if ( 'undefined' === typeof notices || false === notices ) {
				return;
			}

			var $notice = $( '#' + as3cfpro.settings.errors_key_prefix + id );
			var tab = $( '#' + this.ID ).attr( 'data-tab' );

			if ( $notice.length ) {
				$notice.remove();
			}

			$.each( notices, function( index, notice ) {
				$( '#tab-' + tab ).prepend( notice );
			} );
		},

		/**
		 * Recursively calculate total items
		 *
		 * @param {object} blogs
		 * @param {object} progress
		 */
		calculateItemsRecursive: function( blogs, progress ) {
			var self = as3cfpro.tool;

			// All blogs processed
			if ( _.isEmpty( blogs ) ) {
				self.updateProgress( progress.files, progress.total_files, progress.bytes, progress.total_bytes );

				self.nextStepInProcess = { fn: self.processItemRecursive, args: [ progress ] };
				self.executeNextStep();
				return;
			}

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: self.getAjaxAction( 'calculate_items' ),
					blogs: blogs,
					progress: progress,
					nonce: self.getAjaxNonce( 'calculate_items' )
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					self.ajaxError( jqXHR, textStatus, errorThrown );

					return;
				},
				success: function( data ) {
					if ( self.isError( data ) ) {
						return;
					}

					self.nextStepInProcess = { fn: self.calculateItemsRecursive, args: [ data.blogs, data.progress ] };
					self.executeNextStep();
				}

			} );
		},

		/**
		 * Recursively process items
		 *
		 * @param progress
		 */
		processItemRecursive: function( progress ) {
			var self = as3cfpro.tool;

			if ( progress.files >= progress.total_files ) {
				// Finalise process
				self.itemsProcessed = true;
				self.nextStepInProcess = { fn: self.processComplete, args: [ progress ] };
				self.executeNextStep();

				return;
			}

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: self.getAjaxAction( 'process_items' ),
					progress: progress,
					nonce: self.getAjaxNonce( 'process_items' )
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					self.ajaxError( jqXHR, textStatus, errorThrown );

					return;
				},
				success: function( data ) {
					if ( self.isError( data ) ) {
						return;
					}

					self.updateNonFatalErrors( data );
					self.updateProgress( data.files, data.total_files, data.bytes, data.total_bytes );

					self.nextStepInProcess = { fn: self.processItemRecursive, args: [ data ] };
					self.executeNextStep();
				}

			} );
		},

		/**
		 * Run server side events on completion of tool
		 */
		processCompleteEvents: function() {
			var self = this;

			if ( false === this.processError ) {
				if ( true === this.nonFatalErrors ) {
					$( '.progress-text' ).addClass( 'upload-error' );
					var message = this.getString( 'completed_with_some_errors' );

					if ( true === this.processCancelled ) {
						message = this.getString( 'partial_complete_with_some_errors' );
					}

					$( '.progress-text' ).html( message );
				}
			}

			// Reset upload variables so consecutive uploads work correctly
			this.processError = false;
			this.currentlyProcessing = false;
			this.processCompleted = true;
			this.processPaused = false;
			this.processCancelled = false;
			this.doingAjax = false;
			this.nonFatalErrors = false;

			$( '.progress-label' ).remove();
			$( '.upload-progress-ajax-spinner' ).remove();
			$( '.close-progress-content' ).show();
			$( '#overlay' ).css( 'cursor', 'pointer' );
			clearInterval( this.elapsedInterval );

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					action: this.getAjaxAction( 'finish' ),
					nonce: this.getAjaxNonce( 'finish' ),
					completed: this.itemsProcessed
				},
				success: function() {
					self.updateSidebar();
				}
			} );

			this.itemsProcessed = false;
		},

		/**
		 * Complete the process
		 */
		processComplete: function() {
			var self = as3cfpro.tool;
			$( '.upload-controls' ).fadeOut();

			self.currentlyProcessing = false;

			if ( false === self.processError ) {
				$( '.progress-text' ).append( '<div class="dashicons dashicons-yes"></div>' );
				self.processCompleteEvents();
			}
		},

		/**
		 * Execute the next method
		 */
		executeNextStep: function() {
			var self = as3cfpro.tool;

			if ( true === self.processPaused ) {
				$( '.upload-progress-ajax-spinner' ).hide();
				// Pause the timer
				clearInterval( self.elapsedInterval );
				$( '.progress-text' ).html( self.getString( 'paused' ) );
				// Re-bind Pause/Resume button to Resume when we are finally Paused
				$( 'body' ).on( 'click', '.pause-resume', function( event ) {
					self.setPauseResumeButton( event );
				} );
				$( '.pause-resume' ).html( self.getString( 'resume' ) ).removeClass( 'disabled' );

				return;
			} else if ( true === self.processCancelled ) {
				$( '.progress-text' ).html( self.getString( 'process_cancelled' ) );
				self.processCompleteEvents();
			} else {
				self.nextStepInProcess.fn.apply( null, self.nextStepInProcess.args );
			}
		},

		/**
		 * Output and log an AJAX error
		 *
		 * @param {object} jqXHR
		 * @param {object} textStatus
		 * @param {string} errorThrown
		 */
		ajaxError: function( jqXHR, textStatus, errorThrown ) {
			var self = as3cfpro.tool;
			$( '.progress-title' ).html( self.getString( 'process_failed' ) );
			$( '.progress-text' ).not( '.media' ).html( jqXHR.responseText );
			$( '.progress-text' ).not( '.media' ).addClass( 'upload-error' );
			console.log( jqXHR );
			console.log( textStatus );
			console.log( errorThrown );
			self.processError = true;
			self.processCompleteEvents();
			self.doingAjax = false;
		},

		/**
		 * Perform common actions on error and display message
		 *
		 * @param {string} error
		 */
		returnError: function( error ) {
			var self = as3cfpro.tool;
			self.processError = true;
			self.processCompleteEvents();
			$( '.progress-title' ).html( self.getString( 'process_failed' ) );
			$( '.progress-text' ).addClass( 'upload-error' );
			$( '.progress-text' ).html( error );
			$( '.upload-controls' ).fadeOut();
			self.doingAjax = false;
		},

		/**
		 * Check for certain errors from our init method
		 *
		 * @param {object} data
		 *
		 * @returns {boolean}
		 */
		isError: function( data ) {
			if ( 'undefined' !== typeof data.as3cfpro_error && 1 === data.as3cfpro_error ) {
				this.returnError( data.body );

				return true;
			}

			if ( 'undefined' !== typeof data.success && false === data.success ) {
				this.returnError( data.data );
				this.updateNonFatalErrors( data );

				return true;
			}

			return false;
		},

		/**
		 * Update the modals error list with non fatals
		 *
		 * @param {object} data
		 */
		updateNonFatalErrors: function( data ) {
			if ( 'undefined' !== typeof data.errors ) {
				var $errorCount = $( '.progress-errors-title .error-count' );

				$.each( data.errors, function( index, value ) {
					$( '.progress-errors .progress-errors-detail ol' ).append( '<li>' + value + '</li>' );
					this.nonFatalErrors = true;
				} );

				if ( data.error_count > 0 ) {
					$( '.progress-errors' ).show();
				}

				$errorCount.html( data.error_count );

				if ( 1 === data.error_count ) {
					$( '.progress-errors-title .error-text' ).html( this.getString( 'error' ) );
				} else {
					$( '.progress-errors-title .error-text' ).html( this.getString( 'errors' ) );
				}
			}
		},

		/**
		 * Close the modal and hide the overlay
		 */
		hideOverlay: function() {
			$( '.modal-content' ).animate( { 'top': '-' + this.contentHeight + 'px' }, 400, 'swing', function() {
				$( '#overlay' ).remove();
				$( '.modal-content' ).remove();
			} );
			this.processCompleted = false;
			this.progressModalActive = false;

			as3cfpro.tool.renderPieChart();
		},

		/**
		 * Maybe close the modal and hide the available
		 */
		maybeHideOverlay: function() {
			if ( true === this.progressModalActive && true === this.processCompleted ) {
				this.hideOverlay();
			}
		}

	};

	window.onbeforeunload = function( e ) {
		if ( as3cfpro.tool.currentlyProcessing ) {
			e = e || window.event;

			var sure_string = as3cfpro.tool.getString( 'sure' );

			// For IE and Firefox prior to version 4
			if ( e ) {
				e.returnValue = sure_string;
			}

			// For Safari
			return sure_string;
		}
	};

	// Event Handlers
	$( document ).ready( function() {

		// Store the HTML of the views
		as3cfpro.tool.cloneViews();

		// Listen for any URLs for triggering tools
		as3cfpro.tool.openFromURL();

		// Animate sidebar progress bars
		as3cfpro.tool.renderPieChart();

		// Display Tool Modal
		$( 'body' ).on( 'click', 'a.as3cf-pro-tool', function( e ) {
			e.preventDefault();
			as3cfpro.tool.open( $( this ).parent().attr( 'id' ) );
		} );

		// Handle Pause / Resumes clicks
		$( 'body' ).on( 'click', '.pause-resume', function( event ) {
			as3cfpro.tool.setPauseResumeButton( event );
		} );

		// Handles Cancel clicks
		$( 'body' ).on( 'click', '.cancel', function() {
			as3cfpro.tool.cancel();
		} );

		// Close modal
		$( 'body' ).on( 'click', '.close-progress-content-button', function( e ) {
			as3cfpro.tool.hideOverlay();
		} );

		// Close modal on overlay click when possible
		$( 'body' ).on( 'click', '#overlay', function() {
			as3cfpro.tool.maybeHideOverlay();
		} );

		$( 'body' ).on( 'click', '.toggle-progress-errors', function( e ) {
			e.preventDefault();
			var $toggle = $( this );
			var $details = $toggle.closest( '.progress-errors-title' ).siblings( '.progress-errors-detail' );

			$details.toggle( 0, function() {
				$toggle.html( $( this ).is( ':visible' ) ? as3cfpro.tool.getString( 'hide' ) : as3cfpro.tool.getString( 'show' ) );
			} );

			return false;
		} );

		// Show / hide helper description
		$( 'body' ).on( 'click', '.general-helper', function( e ) {
			e.preventDefault();
			var icon = $( this );
			var bubble = $( this ).next();

			// Close any that are already open
			$( '.helper-message' ).not( bubble ).hide();

			var position = icon.position();
			bubble.css( {
				'left': ( position.left - bubble.width() - 35 ) + 'px',
				'top': ( position.top - 25 ) + 'px'
			} );

			bubble.toggle();
			e.stopPropagation();
		} );

		$( 'body' ).click( function() {
			$( '.helper-message' ).hide();
		} );

		$( '.helper-message' ).click( function( e ) {
			e.stopPropagation();
		} );
	} );

})( jQuery, _ );
