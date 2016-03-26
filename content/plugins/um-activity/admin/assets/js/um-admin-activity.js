jQuery(document).ready(function() {

	/* Show hidden post content */
	jQuery(document).on('click', '.um-activity-seemore a', function(e){
		e.preventDefault();
		p = jQuery(this).parent().parent();
		p.find('.um-activity-seemore').remove();
		p.find('.um-activity-hiddentext').show();
		return false;
	});

});