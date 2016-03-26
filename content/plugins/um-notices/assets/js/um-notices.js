jQuery(document).ready(function() {

	jQuery(document).on('click', '.um-notices-close', function(e){
		
		e.preventDefault();
	
		var notice_id = jQuery(this).parents('.um-notices-wrap').attr('data-notice_id');
		var user_id = jQuery(this).parents('.um-notices-wrap').attr('data-user_id');
		
		jQuery.ajax({
			url: ultimatemember_ajax_url,
			type: 'post',
			data: {
				action: 'um_notices_mark_notice_seen',
				notice_id: notice_id,
				user_id: user_id
			}
		});
		
		var wrap = jQuery(this).parents('.um-notices-wrap');
		if ( wrap.parent('.um-notices-shortcode').length ) {
			
			wrap.parent().hide();
			
		} else {
			
			wrap.animate({'bottom' : '-300px'});
			
		}
		
		return false;
		
	});

});

jQuery(window).load(function(){
	
	if ( jQuery('.um-notices-wrap.no-shortcode').length ) {
		
	setTimeout(function(){
		jQuery('.um-notices-wrap.no-shortcode').animate({
			'bottom' : '0px'
		}, 900);
	},1000);
	
	}
	
});