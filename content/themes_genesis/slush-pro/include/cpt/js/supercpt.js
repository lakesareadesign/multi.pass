/**
 * This script adds the jquery effects to the custom post types of the Slush Pro Theme.
 *
 * @package Slush_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery( function( $ ){

	if ( $( "input[type='date'].scpt-field" ).length )
		$( "input[type='date'].scpt-field" ).datepicker( { dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true } );
	$( '#post-body' ).on( 'click', '.scpt-remove-thumbnail', function(e) {
		e.preventDefault();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( '' );
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).show();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( '' );
	});

	$( '#post-body' ).on( 'click', '.scpt-add-media', function() {
		var old_send_to_editor = wp.media.editor.send.attachment;
		var input = this;
		wp.media.editor.send.attachment = function( props, attachment ) {
			props.size = 'thumbnail';
			props = wp.media.string.props( props, attachment );
			props.align = null;
			var preview = '<span class="scpt-image_holder">';
			$(input).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( attachment.id );
			if ( attachment.type == 'image' ) {
				preview += '<img src="' + props.src + '" />';
			} else {
				preview += wp.media.string.link( props );
			}
			preview += '<a class="button scpt-remove-thumbnail" href="#">X</a>';
			preview += '<a href="#" class="button scpt-add-media" style="">Add Image</a>';
			preview += '</span>';
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( preview );
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).hide();
			wp.media.editor.send.attachment = old_send_to_editor;
		}
		wp.media.editor.open( input );
	} );
	
	// Multiple media.
	var product_gallery_frame;
	var $image_gallery_ids = $( '.scpt-multiple_media-ids' );
	var $product_images    = $( '.scpt-multiple_media-preview' );

	jQuery( '.scpt-add-multiple_media' ).on( 'click', function( event ) {
		var $el = $( this );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( product_gallery_frame ) {
			product_gallery_frame.open();
			return;
		}

		// Create the media frame.
		product_gallery_frame = wp.media.frames.product_gallery = wp.media({
			// Set the title of the modal.
			title: $el.data( 'choose' ),
			button: {
				text: $el.data( 'update' )
			},
			states: [
				new wp.media.controller.Library({
					title: $el.data( 'choose' ),
					filterable: 'all',
					multiple: true
				})
			]
		});

		// When an image is selected, run a callback.
		product_gallery_frame.on( 'select', function() {
			var selection = product_gallery_frame.state().get( 'selection' );
			var attachment_ids = $image_gallery_ids.val();

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
					attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
					var attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					//$product_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
					
					$product_images.append( '<div class="zp_image_holder"  data-attachment_id="' + attachment.id + '" ><img src="' + attachment_image + '" /><a class="button scpt-remove-multiple_media-thumbnail" href="#">X</a></div>' );
					
				}
			});

			$image_gallery_ids.val( attachment_ids );
		});

		// Finally, open the modal.
		product_gallery_frame.open();
	});

	// Image ordering.
	$product_images.sortable({
		items: '.zp_image_holder',
		cursor: 'move',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'wc-metabox-sortable-placeholder',
		start: function( event, ui ) {
			ui.item.css( 'background-color', '#f6f6f6' );
		},
		stop: function( event, ui ) {
			ui.item.removeAttr( 'style' );
		},
		update: function() {
			var attachment_ids = '';

			$( '.scpt-multiple_media-preview .zp_image_holder' ).css( 'cursor', 'default' ).each( function() {
				var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});

			$image_gallery_ids.val( attachment_ids );
		}
	});

	// Remove images.
	$( '.scpt-multiple_media-preview' ).on( 'click','.scpt-remove-multiple_media-thumbnail' , function() {
		var attachment_ids = '';
		var zp_image_container_id = $( this ).parents( '.scpt-multiple_media-preview' ).attr( 'id' );

		$( this ).closest( '.zp_image_holder' ).remove();

		$( '#'+zp_image_container_id ).find('.zp_image_holder' ).css( 'cursor', 'default' ).each( function() {
			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});
		
		$( '.'+zp_image_container_id+'-wrap .scpt-multiple_media-ids' ).val( attachment_ids );

		return false;
	});

	// Clear images.
	$( '.scpt-clear-multiple_media' ).on( 'click', function() {
		$( '.zp_image_holder' ).remove();
		$image_gallery_ids.val( '' );
		return false;
	});

	// Color Picker.
	$('.scpt-field-color').wpColorPicker();

} );
