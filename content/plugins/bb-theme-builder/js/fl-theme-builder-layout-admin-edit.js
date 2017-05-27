( function( $ ) {

	/**
	 * Handles logic for the theme layout admin edit interface.
	 *
	 * @class FLThemeBuilderLayoutAdminEdit
	 * @since 1.0
	 */
	FLThemeBuilderLayoutAdminEdit = {

		/**
		 * Cache for location object data that is retrieved via AJAX.
		 *
		 * @since 1.0
		 * @access private
		 * @property {Object} _locationObjectCache
		 */
		_locationObjectCache : {},

		/**
		 * Initializes the theme layout admin edit interface.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
			this._initNonce();
			this._initLayoutSettings();
			this._initLocationRules();
			this._initUserRules();
		},

		/**
		 * Binds events for the theme layout admin edit interface.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			// General events
			$( '.fl-launch-builder, .fl-view-template' ).on( 'click', this._launchBuilderClicked );
			$( '.fl-mb-row-heading-help' ).tipTip();

			// Header events
			$( 'select[name="fl-theme-layout-settings[sticky]"]' ).on( 'change', this._stickyChanged );

			// Location events
			$( '.fl-theme-builder-saved-locations' ).delegate( '.fl-theme-builder-location', 'change', this._locationSelectChanged );
			$( '.fl-theme-builder-saved-locations' ).delegate( '.fl-theme-builder-remove-location', 'click', this._removeLocationClicked );
			$( '.fl-theme-builder-add-location.button' ).on( 'click', this._addLocationClicked );
			$( '.fl-theme-builder-add-exclusion.button' ).on( 'click', this._addExclusionClicked );

			// User events
			$( '.fl-theme-builder-saved-user-rules' ).delegate( '.fl-theme-builder-user-rule', 'change', this._userRuleSelectChanged );
			$( '.fl-theme-builder-add-user-rule.button' ).on( 'click', this._addUserRuleClicked );
			$( '.fl-theme-builder-saved-user-rules' ).delegate( '.fl-theme-builder-remove-user-rule', 'click', this._removeUserRuleClicked );
		},

		/**
		 * Initializes the theme builder nonce.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initNonce
		 */
		_initNonce: function()
		{
			$( '#post' ).append( '<input type="hidden" name="fl-theme-builder-nonce" value="' + FLThemeBuilderConfig.nonce + '" />' );
		},

		/**
		 * Init the layout settings based on type.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initLayoutSettings
		 */
		_initLayoutSettings: function()
		{
			var type      = $( 'input[name=fl-theme-layout-type]' ).val(),
				sticky    = $( '.fl-theme-layout-header-sticky' ),
				shrink    = $( '.fl-theme-layout-header-shrink' ),
				overlay   = $( '.fl-theme-layout-header-overlay' ),
				hookRow   = $( '.fl-theme-layout-hook-row' ),
				hook      = $( 'select[name=fl-theme-layout-hook]' ),
				orderRow  = $( '.fl-theme-layout-order-row' ),
				order     = $( 'input[name=fl-theme-layout-order]' );

			if ( 'header' == type ) {
				sticky.show().find( 'select' ).trigger( 'change' );
				overlay.show();
			} else {
				sticky.hide();
				shrink.hide();
				overlay.hide();
			}

			if ( 'part' == type ) {
				hookRow.show();
				orderRow.show();
			} else {
				hookRow.hide();
				hook.val( '' );
				orderRow.hide();
				order.val( '0' );
			}
		},

		/**
		 * Initializes all location rule forms.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initLocationRules
		 */
		_initLocationRules: function()
		{
			var exclusions = $( '.fl-theme-builder-exclusion-rules' ),
				button     = $( '.fl-theme-builder-add-exclusion' );

			$( '.fl-theme-builder-location-rules' ).each( this._initLocations );

			if ( FLThemeBuilderConfig.exclusions.saved.length > 0 ) {
				exclusions.show();
				button.hide();
			}
		},

		/**
		 * Initializes rules for a location form.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initLocations
		 */
		_initLocations: function()
		{
			var wrap           = $( this ),
				savedWrap      = wrap.find( '.fl-theme-builder-saved-locations' ),
				template       = wp.template( 'fl-theme-builder-saved-location' ),
				type           = null,
				config         = null,
				parts          = null,
				locationWrap   = null,
				locationSelect = null,
				location       = null,
				objectSelect   = null,
				data           = null,
				id             = null,
				i              = 0;

			if ( wrap.hasClass( 'fl-theme-builder-exclusion-rules' ) ) {
				type   = 'exclusion';
				config = FLThemeBuilderConfig.exclusions;
			}
			else {
				type   = 'location';
				config = FLThemeBuilderConfig.locations;
			}

			if ( 0 === config.saved.length ) {

				savedWrap.append( template( { type : type } ) );

				if ( 'exclusion' == type ) {
					savedWrap.find( '.fl-theme-builder-remove-rule-button' ).show();
				}

			} else {

				for ( ; i < config.saved.length; i++ ) {

					savedWrap.append( template( { type : type } ) );

					parts          = config.saved[ i ].split( ':' );
					locationWrap   = wrap.find( '.fl-theme-builder-saved-location' ).last();
					locationSelect = locationWrap.find( '.fl-theme-builder-location' );
					objectSelect   = locationWrap.find( '.fl-theme-builder-location-objects' );

					if ( 'post' == parts[0] || 'taxonomy' == parts[0]  ) {
						if ( parts.length <= 3 ) {
							location = parts[0] + ':' + parts[1];
							data     = config[ parts[0] ][ parts[1] ];
							id       = 3 === parts.length ? parts[2] : undefined;
						} else {
							location = parts[0] + ':' + parts[1] + ':' + parts[2] + ':' + parts[3];
							data     = config[ parts[2] ][ parts[3] ];
							id       = 5 === parts.length ? parts[4] : undefined;
						}
					}
					else {
						location = parts[0] + ':' + parts[1];
					}

					locationWrap.find( '[data-location="' + location + '"]' ).attr( 'selected', 'selected' );

					if ( 'post' == parts[0] || 'taxonomy' == parts[0]  ) {
						FLThemeBuilderLayoutAdminEdit._showLocationObjectSelect( objectSelect.parent(), data, id );
					}
				}

				savedWrap.find( '.fl-theme-builder-remove-rule-button' ).show();
			}

			FLThemeBuilderLayoutAdminEdit._removeLocationOptions();
			FLThemeBuilderLayoutAdminEdit._removeLocationObjectOptions();
		},

		/**
		 * Removes locations that aren't used for singular
		 * or archive layouts.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeLocationOptions
		 */
		_removeLocationOptions: function()
		{
			var type    = $( 'input[name=fl-theme-layout-type]' ).val(),
				options = $( '.fl-theme-builder-location option' );

			if ( 'archive' == type ) {
				options.filter( '[data-location="general:site"]' ).remove();
				options.filter( '[data-location="general:single"]' ).remove();
				options.filter( '[data-location="general:404"]' ).remove();
				options.filter( '[data-type="post"]' ).remove();

			} else if ( 'singular' == type ) {
				options.filter( '[data-location="general:site"]' ).remove();
				options.filter( '[data-location="general:archive"]' ).remove();
				options.filter( '[data-location="general:author"]' ).remove();
				options.filter( '[data-location="general:date"]' ).remove();
				options.filter( '[data-location="general:search"]' ).remove();
				options.filter( '[data-location="general:404"]' ).remove();
				options.filter( '[data-type="archive"]' ).remove();
				options.filter( '[data-type="taxonomy"]' ).remove();
			} else if ( '404' == type ) {
				options.not( '[data-location="general:404"]' ).remove();
				$( '.fl-theme-builder-locations-form' ).hide();
			}

			if ( '404' != type ) {
				$( '.fl-theme-builder-locations-form' ).show();
			}

			$( '.fl-theme-builder-exclusion-rules option[data-location="general:site"]' ).remove();

			$( '.fl-theme-builder-location optgroup' ).filter( function() {
			    return '' === $.trim( $( this ).text() );
			} ).remove();
		},

		/**
		 * Removes location object options that don't make
		 * sense in certain situations.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeLocationObjectOptions
		 */
		_removeLocationObjectOptions: function()
		{
			$( '.fl-theme-builder-location-objects' ).each( function() {
				var select   = $( this ),
					location = select.attr( 'data-location' );

				if ( /post:[a-zA-Z]+:post:[a-zA-Z]+/.test( location ) ) {
					select.find( 'option' ).eq( 0 ).remove();
				}
			} );
		},

		/**
		 * Shows or hides an additional select if necessary when
		 * the location select is changed.
		 *
		 * @since 1.0
		 * @access private
		 * @method _locationSelectChanged
		 */
		_locationSelectChanged: function()
		{
			var self           = FLThemeBuilderLayoutAdminEdit,
				select         = $( this ),
				wrap           = select.closest( '.fl-theme-builder-location-rules' ),
				parent         = select.parent(),
				locations      = wrap.find( '.fl-theme-builder-saved-location' ),
				location       = select.val(),
				locationString = '',
				remove         = wrap.find( '.fl-theme-builder-saved-locations .fl-theme-builder-remove-rule-button' ),
				actionType     = 'terms';

			if ( '' == location ) {

				parent.removeClass( 'fl-theme-builder-rule-objects-visible' );

				if ( 1 === locations.length ) {
					remove.hide();
				}
			} else {

				location       = JSON.parse( location );
				locationString = location.type + ':' + location.id;

				if ( 'taxonomy' == location.type || 'post' == location.type ) {

					if ( typeof self._locationObjectCache[ locationString ] != 'undefined' ) {
						self._showLocationObjectSelect( parent, self._locationObjectCache[ locationString ] );
					} else {

						self._showRowLoading( select );

						if ( 'post' == location.type ) {
							if ( location.id.indexOf( ':taxonomy' ) > -1 ) {
								actionType  = 'terms';
								location.id = location.id.split( ':taxonomy:' )[1];
							}
							else {
								actionType  = 'posts';
							}
						}

						$.post( ajaxurl, {
							action : 'fl_theme_builder_get_location_' + actionType,
							id     : location.id,
							nonce  : FLThemeBuilderConfig.nonce
						}, function( response ) {
							FLThemeBuilderLayoutAdminEdit._showLocationObjectSelect( parent, JSON.parse( response ) );
						} );
					}
				} else {
					parent.removeClass( 'fl-theme-builder-rule-objects-visible' );
				}

				remove.show();
			}
		},

		/**
		 * Shows the location object select and populates
		 * it with the provided data.
		 *
		 * @since 1.0
		 * @access private
		 * @method _showLocationObjectSelect
		 * @param {Object} parent
		 * @param {Object} data
		 * @param {Number} id
		 */
		_showLocationObjectSelect: function( parent, data, id )
		{
			var locationSelect = parent.find( '.fl-theme-builder-location' ),
				location       = JSON.parse( locationSelect.val() ),
				locationString = location.type + ':' + location.id,
				objectSelect   = parent.find( '.fl-theme-builder-location-objects' ),
				objectLocation = null,
				parent         = objectSelect.parent(),
				allLabel       = FLThemeBuilderConfig.strings.allObjects.replace( '%s', data.label ),
				options        = '<option value="" data-location="' + locationString + '">' + allLabel + '</option>',
				selected       = null,
				i              = 0;

			for ( ; i < data.objects.length; i++ ) {
				objectLocation = ' data-location="' + locationString + ':' + data.objects[ i ].id + '"';
				selected = 'undefined' != typeof id && id == data.objects[ i ].id ? ' selected' : '';
				options += '<option value=\'' + JSON.stringify( data.objects[ i ] ) + '\'' + selected + objectLocation + '>' + data.objects[ i ].name + '</option>';
			}

			objectSelect.html( options );
			objectSelect.attr( 'data-location', locationString );
			objectSelect.attr( 'data-type', data.type );
			parent.addClass( 'fl-theme-builder-rule-objects-visible' );

			this._locationObjectCache[ locationString ] = data;

			FLThemeBuilderLayoutAdminEdit._hideRowLoading( locationSelect );

			if ( 'disabled' == objectSelect.find( 'option' ).eq( 0 ).attr( 'disabled' ) ) {
				objectSelect.find( 'option' ).eq( 1 ).attr( 'selected', 'selected' );
			}

			FLThemeBuilderLayoutAdminEdit._removeLocationObjectOptions();
		},

		/**
		 * Adds a location select when the Add button is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _addLocationClicked
		 * @param {Object} e
		 */
		_addLocationClicked: function( e )
		{
			var self      = FLThemeBuilderLayoutAdminEdit,
				wrap      = $( this ).closest( '.fl-theme-builder-location-rules' ),
				savedWrap = wrap.find( '.fl-theme-builder-saved-locations' ),
				template  = wp.template( 'fl-theme-builder-saved-location' ),
				type      = wrap.hasClass( 'fl-theme-builder-exclusion-rules' ) ? 'exclusion' : 'location';

			savedWrap.append( template( { type : type } ) );
			savedWrap.find( '.fl-theme-builder-remove-rule-button' ).show();

			self._removeLocationOptions();
		},

		/**
		 * Removes a location from the saved locations list.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeLocationClicked
		 * @param {Object} e
		 */
		_removeLocationClicked: function( e )
		{
			var button      = $( e.target ),
				wrap        = button.closest( '.fl-theme-builder-location-rules' ),
				parent      = button.parents( '.fl-theme-builder-saved-location' ),
				select      = parent.find( '.fl-theme-builder-location' ),
				locations   = wrap.find( '.fl-theme-builder-saved-location' ),
				remove      = wrap.find( '.fl-theme-builder-saved-locations .fl-theme-builder-remove-rule-button' ),
				isExclusion = button.closest( '.fl-theme-builder-exclusion-rules' ).length ? true : false;

			if ( locations.length > 1 ) {
				button.closest( '.fl-theme-builder-saved-location' ).remove();
			}

			if ( 1 === locations.length ) {

				select.val( '' ).parent().removeClass( 'fl-theme-builder-rule-objects-visible' );

				if ( ! isExclusion ) {
					remove.hide();
				}
				if ( isExclusion ) {
					$( '.fl-theme-builder-exclusion-rules' ).hide();
					$( '.fl-theme-builder-add-exclusion' ).show();
				}

			} else if ( ! isExclusion && 2 === locations.length && '' == wrap.find( '.fl-theme-builder-location' ).eq( 0 ).val() ) {
				remove.hide();
			}
		},

		/**
		 * Shows the exclusion rule settings if they are hidden.
		 *
		 * @since 1.0
		 * @access private
		 * @method _addExclusionClicked
		 * @param {Object} e
		 */
		_addExclusionClicked: function( e )
		{
			var button     = $( '.fl-theme-builder-add-exclusion' ),
				exclusions = $( '.fl-theme-builder-exclusion-rules' );

			button.hide();
			exclusions.show();
		},

		/**
		 * Initializes user rules.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initUserRules
		 */
		_initUserRules: function()
		{
			var saved          = FLThemeBuilderConfig.userRules,
				savedWrap      = $( '.fl-theme-builder-saved-user-rules' ),
				template       = wp.template( 'fl-theme-builder-saved-user-rule' ),
				ruleWrap       = null,
				ruleSelect     = null,
				selected       = null,
				i              = 0;

			if ( 0 === saved.length ) {
				savedWrap.append( template() );
				return;
			}

			for ( ; i < saved.length; i++ ) {

				savedWrap.append( template() );

				parts          = saved[ i ].split( ':' );
				ruleWrap   = $( '.fl-theme-builder-saved-user-rule' ).last();
				ruleSelect = ruleWrap.find( '.fl-theme-builder-user-rule' );
				selected   = ruleWrap.find( '[data-rule="' + parts[0] + ':' + parts[1] + '"]' );

				selected.attr( 'selected', 'selected' );
			}

			savedWrap.find( '.fl-theme-builder-remove-rule-button' ).show();
		},

		/**
		 * Fires when a user rule select changes.
		 *
		 * @since 1.0
		 * @access private
		 * @method _userRuleSelectChanged
		 * @param {Object} e
		 */
		_userRuleSelectChanged: function( e )
		{
			var rule   = $( e.target ).val(),
				rules  = $( '.fl-theme-builder-saved-user-rule' ),
				remove = $( '.fl-theme-builder-saved-user-rules .fl-theme-builder-remove-rule-button' );

			if ( '' == rule ) {
				if ( 1 === rules.length ) {
					remove.hide();
				}
			} else {
				remove.show();
			}
		},

		/**
		 * Adds a user rule when the Add button is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _addUserRuleClicked
		 * @param {Object} e
		 */
		_addUserRuleClicked: function( e )
		{
			var savedWrap = $( '.fl-theme-builder-saved-user-rules' ),
				template  = wp.template( 'fl-theme-builder-saved-user-rule' );

			savedWrap.append( template() );
			savedWrap.find( '.fl-theme-builder-remove-rule-button' ).show();
		},

		/**
		 * Removes a user rule from the saved user rules list.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeUserRuleClicked
		 * @param {Object} e
		 */
		_removeUserRuleClicked: function( e )
		{
			var button = $( e.target ),
				parent = button.parents( '.fl-theme-builder-saved-user-rule' ),
				select = parent.find( '.fl-theme-builder-user-rule' ),
				rules  = $( '.fl-theme-builder-saved-user-rule' ),
				remove = $( '.fl-theme-builder-saved-user-rules .fl-theme-builder-remove-rule-button' );

			if ( rules.length > 1 ) {
				button.closest( '.fl-theme-builder-saved-user-rule' ).remove();
			}

			if ( 1 === rules.length ) {
				select.val( '' );
				remove.hide();
			} else if ( 2 === rules.length && '' == $( '.fl-theme-builder-user-rule' ).val() ) {
				remove.hide();
			}
		},

		/**
		 * Callback for when the button to launch the
		 * builder is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _launchBuilderClicked
		 */
		_launchBuilderClicked: function( e )
		{
			var form = $( 'form[name=post]' ),
				url  = $( this ).attr( 'href' );

			form.append( '<input type="hidden" name="redirect" value="' + url + '" />' );
			form.submit();
			e.preventDefault();
		},

		/**
		 * Callback for then the header sticky select is changed.
		 *
		 * @since 1.0
		 * @access private
		 * @method _stickyChanged
		 */
		_stickyChanged: function()
		{
			$( '.fl-theme-layout-header-shrink' ).toggle( '1' == $( this ).val() );
		},

		/**
		 * Shows the loading icon in the meta box header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _showLoading
		 */
		_showLoading: function()
		{
			var header = $( '#fl-theme-builder-settings h2.hndle span' );

			if ( ! header.find( '.spinner' ).length ) {
				header.append( '<span class="spinner"></span>' );
			}
		},

		/**
		 * Hides the loading icon in the meta box header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _hideLoading
		 */
		_hideLoading: function()
		{
			$( '#fl-theme-builder-settings h2.hndle .spinner' ).remove();
		},

		/**
		 * Shows the loading overlay for a meta box row.
		 *
		 * @since 1.0
		 * @access private
		 * @method _showRowLoading
		 * @param {Object} ele
		 */
		_showRowLoading: function( ele )
		{
			ele.closest( '.fl-mb-row-content' ).prepend( '<div class="fl-mb-loading"></div>' );
		},

		/**
		 * Hides the loading overlay for a meta box row.
		 *
		 * @since 1.0
		 * @access private
		 * @method _hideRowLoading
		 * @param {Object} ele
		 */
		_hideRowLoading: function( ele )
		{
			ele.closest( '.fl-mb-row-content' ).find( '.fl-mb-loading' ).remove();
		}
	};

	// Initialize
	$( function() { FLThemeBuilderLayoutAdminEdit._init(); } );

} )( jQuery );
