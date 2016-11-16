(function( $, _ ) {

	// Local reference to the WordPress media namespace.
	var media = wp.media;

	// Store ids of attachments selected for bulk grid actions
	var selection_ids = [];

	/**
	 * A button for S3 actions
	 *
	 * @constructor
	 * @augments wp.media.view.Button
	 * @augments wp.media.View
	 * @augments wp.Backbone.View
	 * @augments Backbone.View
	 */
	media.view.s3Button = media.view.Button.extend( {
		defaults: {
			text: '',
			style: 'primary',
			size: 'large',
			disabled: false
		},
		initialize: function( options ) {
			if ( options ) {
				this.options = options;
				this.defaults.text = as3cfpro_media.strings[ this.options.action ];
			}

			this.options = _.extend( {}, this.defaults, this.options );

			media.view.Button.prototype.initialize.apply( this, arguments );

			this.controller.on( 'selection:toggle', this.toggleDisabled, this );
		},

		toggleDisabled: function() {
			this.model.set( 'disabled', ! this.controller.state().get( 'selection' ).length );
		},

		click: function( e ) {
			e.preventDefault();
			if ( this.$el.hasClass( 'disabled' ) ) {
				return;
			}

			var selection = this.controller.state().get( 'selection' );

			if ( ! selection.length ) {
				return;
			}

			var askConfirm = false;

			var that = this;
			var ids = [];
			selection.each( function( model ) {
				ids.push( model.id );

				if ( ! askConfirm && that.options.confirm ) {
					if ( model.attributes[ that.options.confirm ] ) {
						askConfirm = true;
					}
				}
			} );

			// Add ids to the unique array
			selection_ids = _.union( selection_ids, ids );

			if ( this.options.confirm && askConfirm ) {
				if ( ! confirm( as3cfpro_media.strings[ this.options.confirm ] ) ) {
					return;
				}
			}

			var nonce = as3cfpro_media.nonces[ this.options.action + '_media' ];

			var payload = {
				_nonce: nonce,
				s3_action: this.options.action,
				ids: ids
			};

			this.startS3Action();
			this.fireS3Action( payload );
		},

		startS3Action: function() {
			$( '.media-toolbar .spinner' ).css( 'visibility', 'visible' ).show();
			$( '.media-toolbar-secondary .button' ).addClass( 'disabled' );
		},

		fireS3Action: function( payload ) {
			wp.ajax.send( 'as3cfpro_process_media_action', { data: payload } ).done( _.bind( this.returnS3Action, this ) );
		},

		returnS3Action: function( response ) {
			if ( response && '' !== response ) {
				$( '.as3cf-notice' ).remove();
				$( '#wp-media-grid h2' ).after( response );
			}

			this.controller.trigger( 'selection:action:done' );
			$( '.media-toolbar .spinner' ).hide();
			$( '.media-toolbar-secondary .button' ).removeClass( 'disabled' );
		},

		render: function() {
			media.view.Button.prototype.render.apply( this, arguments );
			if ( this.controller.isModeActive( 'select' ) ) {
				this.$el.addClass( 's3-actions-selected-button' );
			} else {
				this.$el.addClass( 's3-actions-selected-button hidden' );
			}
			this.toggleDisabled();
			return this;
		}
	} );

	/**
	 * Show and hide the S3 buttons for the grid view only
	 */
	// Local instance of the SelectModeToggleButton to extend
	var wpSelectModeToggleButton = media.view.SelectModeToggleButton;

	/**
	 * Extend the SelectModeToggleButton functionality to show and hide
	 * the S3 buttons when the Bulk Select button is clicked
	 */
	media.view.SelectModeToggleButton = wpSelectModeToggleButton.extend( {
		toggleBulkEditHandler: function() {
			wpSelectModeToggleButton.prototype.toggleBulkEditHandler.call( this, arguments );
			var toolbar = this.controller.content.get().toolbar;

			if ( this.controller.isModeActive( 'select' ) ) {
				toolbar.$( '.s3-actions-selected-button' ).removeClass( 'hidden' );
			} else {
				toolbar.$( '.s3-actions-selected-button' ).addClass( 'hidden' );
			}
		}
	} );

	// Local instance of the AttachmentsBrowser
	var wpAttachmentsBrowser = media.view.AttachmentsBrowser;

	/**
	 * Extend the Attachments browser toolbar to add the S3 buttons
	 */
	media.view.AttachmentsBrowser = wpAttachmentsBrowser.extend( {
		createToolbar: function() {
			wpAttachmentsBrowser.prototype.createToolbar.call( this );

			this.toolbar.set( 'copyS3SelectedButton', new media.view.s3Button( {
				action: 'copy',
				controller: this.controller,
				priority: -60
			} ).render() );

			this.toolbar.set( 'removeS3SelectedButton', new media.view.s3Button( {
				action: 'remove',
				controller: this.controller,
				priority: -60,
				confirm: 'bulk_local_warning'
			} ).render() );

			this.toolbar.set( 'downloadS3SelectedButton', new media.view.s3Button( {
				action: 'download',
				controller: this.controller,
				priority: -60
			} ).render() );

		}
	} );

	$( document ).ready( function() {
		/**
		 * Add bulk action to the select
		 *
		 * @param string action
		 */
		function addBulkAction( action ) {
			var bulkAction = '<option value="bulk_as3cfpro_' + action + '">' + as3cfpro_media.strings[ action ] + '</option>';

			$( 'select[name^="action"] option:last-child' ).after( bulkAction );
		}

		/**
		 * Add new items to the Bulk Actions using Javascript.
		 *
		 * A last minute change to the "bulk_actions-xxxxx" filter in 3.1 made it not
		 * possible to add items using that filter.
		 */
		function addMediaBulkActions() {
			addBulkAction( 'copy' );
			addBulkAction( 'remove' );
			addBulkAction( 'download' );
		}

		// Load up the bulk actions
		addMediaBulkActions();

		// Ask for confirmation when trying to remove attachment from S3 when the local file is missing
		$( 'body' ).on( 'click', '.as3cfpro_remove a.local-warning', function( event ) {
			if ( confirm( as3cfpro_media.strings.local_warning ) ) {
				return true;
			}
			event.preventDefault();
			event.stopImmediatePropagation();
			return false;
		} );

		// Ask for confirmation on bulk action removal from S3
		$( 'body' ).on( 'click', '.bulkactions #doaction', function( e ) {

			var action = $( '#bulk-action-selector-top' ).val();
			if ( 'bulk_as3cfpro_remove' !== action ) {
				// No need to do anything when not removing from S3
				return true;
			}

			var continueRemoval = false;
			var mediaChecked = 0;

			// Show warning if we have selected attachments to remove that have missing local files
			$( 'input:checkbox[name="media[]"]:checked' ).each( function() {
				var $titleTh = $( this ).parent().siblings( '.column-title' );

				if ( $titleTh.find( '.row-actions span.as3cfpro_remove a' ).hasClass( 'local-warning' ) ) {
					mediaChecked++;

					if ( confirm( as3cfpro_media.strings.bulk_local_warning ) ) {
						continueRemoval = true;
					}

					// Break out of loop early
					return false;
				}
			} );

			if ( mediaChecked > 0 ) {
				// If media selected that have local files missing, return the outcome of the confirmation
				return continueRemoval;
			}

			// No media selected continue form submit
			return true;
		} );

	} );

})( jQuery, _ );
