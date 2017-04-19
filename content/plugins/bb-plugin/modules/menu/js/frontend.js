(function($) {
	
	/**
	 * Class for Menu Module
	 *
	 * @since 1.6.1
	 */
	FLBuilderMenu = function( settings ){

		// set params
		this.nodeClass           = '.fl-node-' + settings.id;
		this.wrapperClass        = this.nodeClass + ' .fl-menu';
		this.type				 = settings.type;
		this.mobileToggle		 = settings.mobile;
		this.breakPoints         = settings.breakPoints;
		this.currentBrowserWidth = $( window ).width();

		// initialize the menu
		this._initMenu();

		// check if viewport is resizing
		$( window ).on( 'resize', $.proxy( function( e ){

			var width = $( window ).width();
			
			// if screen width is resized, reload the menu
		    if( width != this.currentBrowserWidth ){

				this._resizeDebounce();
		    	this.currentBrowserWidth = width;
			}

		}, this ) );

	};

	FLBuilderMenu.prototype = {
		nodeClass               : '',
		wrapperClass            : '',
		type 	                : '',
		breakPoints 			: {},
		$submenus				: null,

		/**
		 * Check if the screen size fits a mobile viewport.
		 *
		 * @since  1.6.1
		 * @return bool
		 */
		_isMobile: function(){
			return window.innerWidth < this.breakPoints.small ? true : false;
		},

		/**
		 * When screen is resized, reloads the menu in a determinded interval.
		 *
		 * @see    this._initMenu()
		 * @see    this._clickOrHover()
		 * @since  1.6.1
		 * @return void
		 */
 		_resizeDebounce: function(){
 			clearTimeout( this.resizeTimer );
 			this.resizeTimer = setTimeout( $.proxy( function() {
 				this._initMenu();
 				this._clickOrHover();
 			}, this ), 250 );
 
 		},

		/**
		 * Initialize the toggle logic for the menu.
		 *
		 * @see    this._isMobile()
		 * @see    this._menuOnCLick()
		 * @see    this._clickOrHover()
		 * @see    this._submenuOnRight()
		 * @see    this._toggleForMobile()
		 * @since  1.6.1
		 * @return void
		 */
		_initMenu: function(){
			this._menuOnFocus();

			if( this._isMobile() || this.type == 'accordion' ){
				
				$( this.wrapperClass ).off( 'mouseenter mouseleave' );
				this._menuOnClick();
				this._clickOrHover();

			} else {
				$( this.wrapperClass ).off( 'click' );
				this._submenuOnRight();
			}

			if( this.mobileToggle != 'expanded' ){
				this._toggleForMobile();
			}

		},

		/**
		 * Adds a focus class to menu elements similar to be used similar to CSS :hover psuedo event
		 *
		 * @since  1.9.0
		 * @return void
		 */
		_menuOnFocus: function(){
			$( this.nodeClass ).off('focus').on( 'focus', 'a', $.proxy( function( e ){
				var $menuItem	= $( e.target ).parents( '.menu-item' ).first(),
					$parents	= $( e.target ).parentsUntil( this.wrapperClass );
				
				$('.fl-menu .focus').removeClass('focus');
				
				$menuItem.addClass('focus');
				$parents.addClass('focus');
			}, this ) );
		},

		/**
		 * Logic for submenu toggling on accordions or mobile menus (vertical, horizontal)
		 *
		 * @since  1.6.1
		 * @return void
		 */
		_menuOnClick: function(){
			$( this.wrapperClass ).off().on( 'click', '.fl-has-submenu-container', $.proxy( function( e ){

				var $link			= $( e.target ).parents( '.fl-has-submenu' ).first(),
					$subMenu 		= $link.children( '.sub-menu' ).first(),
					$href	 		= $link.children('.fl-has-submenu-container').first().find('> a').attr('href'),
					$subMenuParents = $( e.target ).parents( '.sub-menu' ),
					$activeParent 	= $( e.target ).closest( '.fl-has-submenu.fl-active' );

				if( !$subMenu.is(':visible') || $(e.target).hasClass('fl-menu-toggle') 
					|| ($subMenu.is(':visible') && (typeof $href === 'undefined' || $href == '#')) ){
					e.preventDefault();
				}
				else {
					window.location.href = $href;
					return;
				}

				if ($(this.wrapperClass).hasClass('fl-menu-accordion-collapse')) {
					
					if ( !$link.parents('.menu-item').hasClass('fl-active') ) {						
						$('.fl-active', this.wrapperClass).not($link).removeClass('fl-active');
					}
					else if ($link.parents('.menu-item').hasClass('fl-active') && $link.parent('.sub-menu').length) {
						$('.fl-active', this.wrapperClass).not($link).not($activeParent).removeClass('fl-active');						
					}

					$('.sub-menu', this.wrapperClass).not($subMenu).not($subMenuParents).slideUp('normal');
				}
				
				$subMenu.slideToggle();
				$link.toggleClass( 'fl-active' );
				
			}, this ) );

		},

		/**
		 * Changes general styling and behavior of menus based on mobile / desktop viewport.
		 *
		 * @see    this._isMobile()
		 * @since  1.6.1
		 * @return void
		 */
		_clickOrHover: function(){
			this.$submenus = this.$submenus || $( this.wrapperClass ).find( '.sub-menu' );
			var $wrapper   = $( this.wrapperClass ),
				$menu      = $wrapper.find( '.menu' );
				$li        = $wrapper.find( '.fl-has-submenu' );

			if( this._isMobile() ){
				$li.each( function( el ){

					if( !$(this).hasClass('fl-active') ){
						$(this).find( '.sub-menu' ).fadeOut();
					}

				} );
			}
		},

		/**
		 * Logic to prevent submenus to go outside viewport boundaries.
		 *
		 * @since  1.6.1
		 * @return void
		 */
		_submenuOnRight: function(){

			$( this.wrapperClass )
				.on( 'mouseenter', '.fl-has-submenu', $.proxy( function( e ){

					if( $ ( e.currentTarget ).find('.sub-menu').length === 0 ) {
						return;
					}
		
					var $link           = $( e.currentTarget ),
						$parent         = $link.parent(),
						$subMenu        = $link.find( '.sub-menu' ),
						subMenuWidth    = $subMenu.width(),
						subMenuPos      = 0,
						winWidth        = $( window ).width();
					
					if( $link.closest( '.fl-menu-submenu-right' ).length !== 0) {
					
						$link.addClass( 'fl-menu-submenu-right' );
					
					} else if( $( 'body' ).hasClass( 'rtl' ) ) {
						
						subMenuPos = $parent.is( '.sub-menu' ) ?
									 $parent.offset().left - subMenuWidth:
									 $link.offset().left - subMenuWidth;
						
						if( subMenuPos <= 0 ) {
							$link.addClass( 'fl-menu-submenu-right' );
						}
					
					} else {
						
						subMenuPos = $parent.is( '.sub-menu' ) ?
									 $parent.offset().left + $parent.width() + subMenuWidth :
									 $link.offset().left + subMenuWidth;

						if( subMenuPos > winWidth ) {
							$link.addClass('fl-menu-submenu-right');
						}
					}
				}, this ) )
				.on( 'mouseleave', '.fl-has-submenu', $.proxy( function( e ){
					$( e.currentTarget ).removeClass( 'fl-menu-submenu-right' );
				}, this ) );
			
		},

		/**
		 * Logic for the mobile menu button.
		 *
		 * @since  1.6.1
		 * @return void
		 */
		_toggleForMobile: function(){

			var $wrapper = $( this.wrapperClass ),
				$menu    = $wrapper.children( '.menu' );

			if( this._isMobile() ){

				if( !$wrapper.find( '.fl-menu-mobile-toggle' ).hasClass( 'fl-active' ) ){
					$menu.css({ display: 'none' });
				}

				$wrapper.on( 'click', '.fl-menu-mobile-toggle', function( e ){
					$( this ).toggleClass( 'fl-active' );
					$menu.slideToggle();
				} );

				$menu.on( 'click', '.menu-item > a[href*="#"]', function(e){
					var $href = $(this).attr('href'),
						$targetID = '';

					if ( $href !== '#' ) {
						$targetID = $href.split('#')[1];

						if ( $('body').find('#'+  $targetID).length > 0 ) {
							e.preventDefault();
							$( this ).toggleClass( 'fl-active' );
							$menu.slideToggle('fast', function(){
								setTimeout(function(){
									$('html, body').animate({
								        scrollTop: $('#'+ $targetID).offset().top
								    }, 1000, function() {
								        window.location.hash = $targetID;
								    });
								}, 500);
							});
						}
					}
				});
			} else {
				$wrapper.find( '.fl-menu-mobile-toggle' ).removeClass( 'fl-active' );
				$menu.css({ display: '' });
			}

		}
	
	};
		
})(jQuery);