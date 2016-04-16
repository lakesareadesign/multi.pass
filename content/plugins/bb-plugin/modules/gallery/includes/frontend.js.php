(function($) {
	
	$(function() {
		
		<?php if($settings->click_action == 'lightbox') : ?>
		$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content .fl-photo-content a, .fl-node-<?php echo $id; ?> .fl-gallery .fl-photo-content a').magnificPopup({
			closeBtnInside: false,
			type: 'image',
			gallery: {
				enabled: true
			}
		});
		<?php endif; ?>
		
		<?php if($settings->layout == 'collage') : ?>
		$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content').one( 'filled', function(){
			if ( 'undefined' != typeof $.waypoints ) {
				$.waypoints( 'refresh' );
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