(function($) {

	$('#commentform label').each(function(){
		var placeholderText = $(this).text();
		$(this).hide().find('+ input, + textarea').attr('placeholder', placeholderText);
	});

})(jQuery);