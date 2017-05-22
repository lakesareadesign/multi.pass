/**
 * This script adds the post load more jquery to the Slush Pro Theme.
 *
 * @package Slush_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */
jQuery('.load_more:not(.loading)').on('click',function(e){
	e.preventDefault();		
	var load_more_btn = jQuery(this);
	var post_type = zp_load_more.post_type;
	var offset = jQuery('#zp_masonry_container .zp_masonry_item').length;
	var nonce = load_more_btn.attr('data-nonce');
	var container_width = jQuery('#zp_masonry_container').width();

	jQuery.ajax({
		type : "post",
		context: this,
		dataType : "json",
		url : zp_load_more.ajaxurl,
		data : {action: "zp_load_posts", offset:offset, columns:zp_load_more.columns, category: zp_load_more.category, nonce:nonce, post_type:post_type, posts_per_page:zp_load_more.posts_per_page},
		beforeSend: function(data) {
			// Here u can do some loading animation...
			load_more_btn.addClass('loading').html( zp_load_more.loading_label );
		},
		success: function(response) {
			if (response['have_posts'] == 1){ // If have posts:
				load_more_btn.removeClass('loading').html( zp_load_more.button_label );
				var newElems = jQuery(response['html'].replace(/(\r\n|\n|\r)/gm, ''));
				jQuery('#zp_masonry_container').append( newElems );
				zp_portfolio_item_width();
				// Checks pre-selected category.
				filter_item = jQuery('.zp_masonry_filter .option-set a.selected').attr('data-option-value');
				// jQuery('#zp_masonry_container').isotope( 'insert', newElems );

				jQuery('#zp_masonry_container').append( newElems ).isotope('appended', newElems );

				jQuery('#zp_masonry_container').imagesLoaded(function(){
					jQuery('#zp_masonry_container').isotope('layout');
				});
				
				zp_set_liked();
				// jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({ hook: 'data-rel',deeplinking: false });
				jQuery('.gallery-popup').magnificPopup({
					delegate: 'a',
					type: 'image',
					closeOnContentClick: 'true',
					mainClass: 'mfp-with-zoom',
					zoom: {
						enabled: true, 
						duration: 300, 
						easing: 'ease-in-out',
						opener: function(openerElement) {
						  return openerElement.is('img') ? openerElement : openerElement.find('img');
						}
					}
				});
				// Pops up Image.
				jQuery('.gallery-image a').magnificPopup({ type: 'image' });
				// Pops up image slider.
				jQuery(".gallery-slide").magnificPopup({
					delegate: "a",
					type: "image",
					tLoading: "Loading image...",
					mainClass: "mfp-img-mobile",
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1]
					},
					callbacks: {
						buildControls: function() {
							this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
					}
					
				  }
				});

				// Pop-up for portfolio videos.
				jQuery('.gallery-video').magnificPopup({
					delegate: 'a',
					type: 'iframe',
					closeOnContentClick: 'true',
					zoom: {
						enabled: true, 
						duration: 300, 
						easing: 'ease-in-out'
					},
					disableOn: 700,
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			} else {
				// End of posts (no posts found).
				load_more_btn.removeClass('loading').addClass('end_of_posts').html('<span>'+zp_load_more.end_post +'</span>');
			}
		}
	});

});
