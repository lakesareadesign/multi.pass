jQuery(document).ready(function() {
	
	/**
		Cancel add
	**/
	jQuery(document).on('click', '.profilec-cancel',function(e){
		e.preventDefault();
		jQuery('.profilec-field').empty();
		jQuery('.profilec-add').removeAttr('disabled');
		return false;
	});
	
	/**
		Make inline edit
	**/
	jQuery(document).on('click', '.profilec-edit',function(e){
		e.preventDefault();
		jQuery(this).parents('p').after( jQuery('.profilec-inline') );
		jQuery('.profilec-inline').show();
		jQuery('.profilec-inline').find('#progress_valuei').val( parseInt( jQuery(this).parents('p').find('ins').html() ) );
		jQuery('.profilec-inline').find('#progress_fieldi').val( jQuery(this).parents('p').find('.profilec-key').html() );
		return false;
	});
	
	/**
		Remove a profile field
	**/
	jQuery(document).on('click', '.profilec-remove',function(e){
		e.preventDefault();
		
		var saveb = jQuery(this);
		var cont = jQuery(this).parents('.profilec-inline');
		var post_id = cont.attr('data-post_id');
		cont.find('.spinner').show();
		saveb.attr('disabled','disabled');

		var progress_value = cont.find('#progress_valuei').val();
		var progress_field = cont.find('#progress_fieldi').val();
		
		var current_crit = jQuery('p[data-key='+progress_field+']');
		
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_admin_profile_completeness_remove', post_id: post_id, progress_value: progress_value, progress_field: progress_field },
			success: function(data){

				cont.find('.spinner').hide();
				saveb.removeAttr('disabled');
				saveb.parents('.profilec-inline').hide();
				
				jQuery('.profilec-ajax').html( parseInt( jQuery('.profilec-ajax').html() ) + parseInt( progress_value ) );
				
				current_crit.remove();
				
			}
		});
		
		return false;
	});
	
	/**
		Update a profile field to completion
	**/
	jQuery(document).on('click', '.profilec-update',function(e){
		e.preventDefault();
		
		var saveb = jQuery(this);
		var cont = jQuery(this).parents('.profilec-inline');
		var post_id = cont.attr('data-post_id');
		cont.find('.spinner').show();
		saveb.attr('disabled','disabled');

		var progress_value = cont.find('#progress_valuei').val();
		var progress_field = cont.find('#progress_fieldi').val();
		
		var current_crit = jQuery('p[data-key='+progress_field+']').find('ins');
		
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_admin_profile_completeness_update', post_id: post_id, progress_value: progress_value, progress_field: progress_field },
			success: function(data){

				cont.find('.spinner').hide();
				saveb.removeAttr('disabled');
				
				jQuery('.profilec-ajax').html( data.remaining );
				
				current_crit.html( data.pct );
				
				saveb.parents('.profilec-inline').hide();
				
				if ( data.remaining == 0 ) {
					jQuery('.profilec-add').parents('p').hide();
				} else {
					jQuery('.profilec-add').parents('p').show();
				}
				
			}
		});
		
		return false;
	});
	
	/**
		Save a profile field to completion
	**/
	jQuery(document).on('click', '.profilec-save',function(e){
		e.preventDefault();
		
		var saveb = jQuery(this);
		var cont = jQuery(this).parents('.profilec-field');
		var post_id = cont.attr('data-post_id');
		cont.find('.spinner').show();
		saveb.attr('disabled','disabled');
		
		var progress_value = jQuery('#progress_value').val();
		var progress_field = jQuery('#progress_field').val();
		
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_admin_profile_completeness_save', post_id: post_id, progress_value: progress_value, progress_field: progress_field },
			success: function(data){
				cont.find('.spinner').hide();
				saveb.removeAttr('disabled');
				jQuery('.profilec-field').empty();
				jQuery('.profilec-add').removeAttr('disabled');
				jQuery('.profilec-data').prepend( data.res );
				var new_pct =  parseInt( jQuery('.profilec-ajax').html() ) - data.pct;
				if ( new_pct == 0 ) {
					jQuery('.profilec-add').parents('p').hide();
				}
				jQuery('.profilec-ajax').html( new_pct );
				
			}
		});
		
		return false;
	});
	
	/**
		Add a profile field to completion
	**/
	jQuery(document).on('click', '.profilec-add',function(e){
		e.preventDefault();
		
		var addb = jQuery(this);
		var cont = jQuery(this).parents('.profilec-setup');
		var post_id = cont.attr('data-post_id');
		cont.find('.spinner').show();
		addb.attr('disabled','disabled');
		
		jQuery.ajax({
			url: um_scripts.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: { action: 'um_admin_profile_completeness_add', post_id: post_id },
			success: function(data){
				cont.find('.spinner').hide();
				jQuery('.profilec-field').html( data.res );
			}
		});
		
		return false;
	});

});