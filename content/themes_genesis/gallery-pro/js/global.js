jQuery( function ( $ ) {
	// FitVids
	$('.entry').fitVids();

	// Sticky Header options
	var options = {
			offset: 500
	};

	// Initialize with options
	var header = new Headhesive('.site-header', options);

});
