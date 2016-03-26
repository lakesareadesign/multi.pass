jQuery(window).load(function() {
	
	setTimeout( function() {
	jQuery('.um-mycred-progress-done').each(function(){
		var pct = jQuery(this).attr('data-pct');
		jQuery(this).animate({ width: pct + '%' }, 300);
	});
	}, 1000 );
	
	jQuery('.um-profile-body.badges .the-badge img').tipsy({gravity: 'n', opacity: 1, live: true, offset: 3 });

});