jQuery(document).ready(function() {

	jQuery('.um-account-tab select.country_select,.um-account-tab select.state_select').select2({
		width: '100%'
	});

	jQuery('.um-woo-review-avg').raty({
		half: 		true,
		starType: 	'i',
		number: 	function() {return jQuery(this).attr('data-number');},
		score: 		function() {return jQuery(this).attr('data-score');},
		hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
		space: false,
		readOnly: true
	});

	if(window.location.href.indexOf("#!/") > -1) {
		var order_id = window.location.href.split(/[/ ]+/).pop();
		if ( order_id ) {

			prepare_Modal();

			jQuery.ajax({
				url: um_scripts.ajaxurl,
				type: 'post',
				data: { action: 'um_woocommerce_get_order', order_id: order_id },
				success: function(data){
					if ( data ) {
						show_Modal( data );
						responsive_Modal();
					} else {
						remove_Modal();
					}
				}
			});

		}
	}

	jQuery(document).on('click', '.um-woo-view-order',function(e){
		e.preventDefault();

		var order_id = jQuery(this).parents('tr').attr('data-order_id');

		window.history.pushState("string", "Orders",  jQuery(this).attr('href') );

		prepare_Modal();

		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			data: { action: 'um_woocommerce_get_order', order_id: order_id },
			success: function(data){
					if ( data ) {
						show_Modal( data );
						responsive_Modal();
					} else {
						remove_Modal();
					}
			}
		});

		return false;
	});

	jQuery(document).on('click', '.um-woo-order-hide',function(e){
		e.preventDefault();
		remove_Modal();
		return false;
	});

});
