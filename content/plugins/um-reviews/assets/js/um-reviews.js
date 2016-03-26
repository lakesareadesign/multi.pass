jQuery(window).load(function() {

	setTimeout(function(){

		jQuery('.um-reviews-d-p span').each(function(){
			jQuery(this).animate({ 'width' : jQuery(this).attr('data-width') + '%' });
		});

	}, 2000 );

});

jQuery(document).ready(function() {

	jQuery(document).on('submit', '.um-reviews-form', function(e){
		e.preventDefault();

		var this_form = jQuery(this);

		if ( this_form.find('.um-reviews-rate input').val() == '' ) {
			this_form.find('.um-field-error').html('Please add a rating.').show();
		} else if ( this_form.find('.um-reviews-title input').val().length < 1 ) {
			this_form.find('.um-field-error').html('You must provide a title.').show();
		} else if ( this_form.find('.um-reviews-content textarea').val().length < 1 ) {
			this_form.find('.um-field-error').html('You must provide review content.').show();
		} else {

			this_form.find('.um-field-error').hide().empty();

			jQuery.ajax({
				url: ultimatemember_ajax_url,
				type: 'post',
				dataType: 'json',
				data: this_form.serialize(),
				success: function(data) {

					if ( data.error ) {
						this_form.find('.um-field-error').html( data.error ).show();
					} else {

						this_form.parents('.um-reviews-item').find('.um-reviews-post.review-form').hide();
						if ( this_form.parents('.um-reviews-item').find('.um-reviews-post.review-new').length ) {
							conta = this_form.parents('.um-reviews-item').find('.um-reviews-post.review-new');
						} else {
							conta = this_form.parents('.um-reviews-item').find('.um-reviews-post.review-list');
						}
						conta.show();
						conta.find('.um-reviews-title').html( '<span>' + data.title  + '</span>' );
						conta.find('.um-reviews-content').html( data.content );
						conta.find('.um-reviews-send').hide();
						conta.find('.um-reviews-avg').raty({
							half: 		true,
							starType: 	'i',
							number: 	function() {return jQuery(this).attr('data-number');},
							score: 		data.rating,
							hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
							space: false,
							readOnly: true
						});

						if ( data.pending ) {
							conta.find('.um-reviews-note').html( data.pending ).css({'display':'inline-block'}).show();
						}
					}

				}
			});

		}
		return false;
	});

	jQuery(document).on('click', '.um-reviews-cancel-add', function(e){
		e.preventDefault();
		jQuery('.um-reviews-prepost').show();
		jQuery(this).parent().hide();
		return false;
	});

	jQuery(document).on('click', '.um-reviews-cancel-edit', function(e){
		e.preventDefault();
		jQuery(this).parents('.um-reviews-item').find('.review-list').show();
		jQuery(this).parent().hide();
		return false;
	});

	jQuery(document).on('click', '.um-reviews-edit a', function(e){
		e.preventDefault();
		var fade__ = jQuery(this).parents('.um-reviews-item').find('.um-reviews-post.review-form');
		jQuery(this).parents('.um-reviews-item').find('.um-reviews-post.review-list').hide();
		fade__.show();
		return false;
	});

	jQuery(document).on('click', '.um-reviews-prepost', function(e){
		var fade__ = jQuery(this).parent().find('.um-reviews-post.review-form');
		jQuery(this).hide();
		fade__.show();
	});

	jQuery(document).on('click', '.um-reviews-remove a', function(e){
		e.preventDefault();
		if ( jQuery(this).parents('.um-reviews-item').find('.um-reviews-remove-a').length == 0 ) {
		jQuery(this).hide();
		var text = jQuery(this).attr('data-remove');
		var note = jQuery(this).parents('.um-reviews-item').find('.um-reviews-note');
		note.html( text ).css({'display':'inline-block'}).show();
		note.after('<div class="um-reviews-remove-a"><a href="#">Remove</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="#" class="cancel-remove">Cancel</a></div>');
		}
		return false;
	});

	jQuery(document).on('click', '.um-reviews-remove-a a:not(.cancel-remove)', function(e){
		e.preventDefault();
		var review_id = jQuery(this).parents('.um-reviews-item').attr('data-review_id');
		var user_id = jQuery(this).parents('.um-reviews-item').attr('data-user_id');
		jQuery(this).parents('.um-reviews-item').remove();
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_review_trash', review_id: review_id, user_id: user_id }
		});
		return false;
	});

	jQuery(document).on('click', '.um-reviews-remove-a a.cancel-remove', function(e){
		e.preventDefault();
		jQuery(this).parents('.um-reviews-item').find('.um-reviews-remove a').show();
		jQuery(this).parents('.um-reviews-item').find('.um-reviews-note').empty().hide();
		jQuery(this).parent().remove();
		return false;
	});

	jQuery(document).on('click', '.um-reviews-flag a', function(e){
		e.preventDefault();
		var flag = jQuery(this).parent();
		var item = jQuery(this).parents('.um-reviews-item');
		var review_id = jQuery(this).parents('.um-reviews-item').attr('data-review_id');
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_review_flag', review_id: review_id },
			success: function(data) {

				item.find('.um-reviews-note').html( data.response ).css({'display':'inline-block'}).show();
				flag.hide();

			}
		});
		return false;
	});

	jQuery('.um-reviews-avg').raty({
		half: 		true,
		starType: 	'i',
		number: 	function() {return jQuery(this).attr('data-number');},
		score: 		function() {return jQuery(this).attr('data-score');},
		hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
		space: false,
		readOnly: true
	});

	jQuery('.um-reviews-rate').raty({
		half: 		false,
		starType: 	'i',
		number: 	function() {return jQuery(this).attr('data-number');},
		score: 		function() {return jQuery(this).attr('data-score');},
		scoreName: 	function(){return jQuery(this).attr('data-key');},
		hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
		space: false
	});

});
