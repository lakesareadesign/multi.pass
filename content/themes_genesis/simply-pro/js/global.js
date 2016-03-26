jQuery( function ( $ ) {
	// FitVids
	$('.entry').fitVids();

    // Sticky Header options
    var options = {
        offset: '.site-inner'
    };

    // Initialize with options
    var header = new Headhesive('.site-header', options);

});