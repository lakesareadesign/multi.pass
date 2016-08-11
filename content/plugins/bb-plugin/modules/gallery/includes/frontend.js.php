(function($) {
	
	$(function() {
		
		<?php if($settings->click_action == 'lightbox') : ?>
		$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content, .fl-node-<?php echo $id; ?> .fl-gallery').magnificPopup({
			delegate: '.fl-photo-content a',
			closeBtnInside: false,
			type: 'image',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
			},
			'image': {
				titleSrc: function(item) {
					<?php if($settings->show_captions == 'below') : ?>
						return item.el.parent().next('.fl-photo-caption').text();
					<?php elseif($settings->show_captions == 'hover') : ?>
						return item.el.next('.fl-photo-caption').text();
					<?php endif; ?>
				}
			}
		});
		<?php endif; ?>
		
		<?php if($settings->layout == 'collage') : ?>
		$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content').one( 'filled', function(){
			var hash = window.location.hash.replace( '#', '' );
			if ( hash != '' ) {
				FLBuilderLayout._scrollToElement( $( '#' + hash ) );
			}
			if ( 'undefined' != typeof Waypoint ) {
				Waypoint.refreshAll();
			}
		}).mosaicflow({
			itemSelector: '.fl-mosaicflow-item',
			columnClass: 'fl-mosaicflow-col',
			minItemWidth: <?php echo $settings->photo_size; ?>
		});
		<?php else : ?>
		$('.fl-node-<?php echo $id; ?> .fl-gallery-item').wookmark({
			align: 'center',
			autoResize: true,
			container: $('.fl-node-<?php echo $id; ?> .fl-gallery'),
			offset: <?php echo $settings->photo_spacing; ?>,
			itemWidth: 150
		});
		<?php endif; ?>
	});
	
})(jQuery);