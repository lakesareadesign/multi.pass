jQuery( document ).ready( function() {

	/* Primary menu subpages */

	var expand_link = jQuery( '<button class="menu-expand"><span class="screen-reader-text">' + js_i18n.next + '</span></button>' );
	var back_link = jQuery( '<li><button class="menu-back">'+ js_i18n.back +'</button></li>' );

	jQuery('#slide-menu .nav-menu').data('depth', 0);
	jQuery('#slide-menu .menu-item-has-children > a, #slide-menu .page_item_has_children > a').after(expand_link);
	jQuery('#slide-menu .sub-menu, #slide-menu .children').prepend(back_link);
	jQuery('#slide-menu .sub-menu, #slide-menu .children').hide();
	jQuery('.menu-back').click( function() {
		var parent_ul = jQuery(this).closest( 'ul' );
		menu_level_down(parent_ul);
		return false;
	});

	jQuery( '.menu-expand' ).click( function() {
		var parent_ul = jQuery( this ).parent().find( 'ul:first' );
		menu_level_up( parent_ul );
		return false;
	});

	function menu_level_up( parent_ul ) {
		var depth = jQuery( '#slide-menu .nav-menu' ).data( 'depth' );
		var old_depth=depth;
		var new_depth = depth + 1;
		parent_ul.show();
		jQuery( '#slide-menu .nav-menu' ).data( 'depth', new_depth ).addClass( 'depth-' + new_depth ).removeClass( 'depth-' + old_depth) ;
	}

	function menu_level_down( parent_ul ) {
		var depth = jQuery( '#slide-menu ul' ).data( 'depth' );
		var old_depth = depth;
		var new_depth = depth - 1;
		parent_ul.hide( 250 );
		if ( new_depth <= 0 ) {
			new_depth = 0;
		}

		jQuery( '#slide-menu .nav-menu' ).data( 'depth', new_depth ).addClass( 'depth-' + new_depth ).removeClass( 'depth-' + old_depth );
	}

	/* Taming mobile slide menu lengths */
	
	var menu_heights = jQuery( '.slide-menu ul' ).map(function() {
		return jQuery( this ).height();
	}).get();

	var max_menu_height = Math.max.apply( null, menu_heights );
	
	var site_logo_height = jQuery( '.site-logo' ).outerHeight( true) ;
	
	var menu_height = max_menu_height + site_logo_height + 35;

	if ( jQuery(window).width() <= 435 ) {	
		jQuery( '.menu-toggle' ).click( function() {
			if ( ! jQuery( '.site' ).hasClass( 'height-restricted' ) ) {
				jQuery( '.site' ).css( 'height', menu_height ).delay( 500 ).queue(function() {
					jQuery( this ).addClass( 'height-restricted' ).dequeue();
				});
			} else {
				jQuery( '.site' ).removeAttr( 'style' ).removeClass( 'height-restricted' );
			}
		});
	}

	/* Add wrapper for avatar by post author */

	jQuery( '.bypostauthor .avatar' ).wrap( '<div class="avatar-wrap"></div>' );

	/* Featured Content Adjustments */

	var featuredPrimary = jQuery( '.featured-area > div:first-child' );
	var featuredPrimaryWrap = jQuery( '.featured-area > div:first-child .entry-header, .featured-area > div:first-child .entry-content' );

	if ( featuredPrimary.length ) {
		featuredPrimary.addClass( 'featured-primary' );
		featuredPrimaryWrap.wrapAll( '<div class="featured-content"></div>' );
	}

	var featuredRow = jQuery( '.featured-area > div:nth-child(n+2)' );

	if ( featuredRow.length ) {
		featuredRow.addClass( 'featured-row' );
		jQuery( '.featured-row .entry .entry-title' ).each( function() {
			jQuery( this ).next( '.featured-row .entry .entry-meta' ).after( this );
		});
	}

	/* No Sidebar Adjustments */
	if ( ! jQuery( '#genesis-sidebar-primary .widget' ).length ) {
		jQuery('body').addClass('no-sidebar');
	}

	/* Comment Markup Adjustments */
	var commentEditLinks = jQuery( '.comment-edit-link' );
	var commentMetas = jQuery( '.comment-meta' );

	if ( commentEditLinks.length ) {
		commentMetas.each( function() {
			var commentMeta = jQuery( this );
			var commentEditLink = commentMeta.next( commentEditLinks );
			commentMeta.append( commentEditLink );
		});		
	}

	/* Comment Nav Markup Adjustments */
	var commentNavigation = jQuery( '.comments-pagination' );
	var commentHeader = jQuery( '.comments-header' );

	if ( commentNavigation.length ) {
		commentNavigation.appendTo( commentHeader );
	}

	/* Masonry for archive pages */

	if ( jQuery( 'body' ).hasClass( 'archive' ) ) {
		jQuery( '#article-wrap' ).masonry( {
			// options
			itemSelector : '.entry'
		});
		
		// When Jetpack Infinite scroll posts have loaded
		jQuery( document.body ).on( 'post-load', function() {

			jQuery( '#article-wrap' ).masonry( 'reloadItems' );
			
			jQuery( '#article-wrap' ).imagesLoaded( function() {
				jQuery( '#article-wrap' ).masonry({
					itemSelector: '.entry'
				});
		
				// Fade blocks in after images are ready (prevents jumping and re-rendering)
				jQuery( '.entry' ).fadeIn();
			});
		});
	}

} );
