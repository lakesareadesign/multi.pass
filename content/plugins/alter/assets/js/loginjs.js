(function($) {
   $('.login label input.input').each(function() {
      label = $(this).parent().text();
      $(this).attr("placeholder", label);
      $(this).insertBefore($(this).parent());
      $(this).next().remove();
    });
    var msgbox = $('p.message');
    msgbox.detach();
    msgbox.appendTo('.alter-form-container');
    msgbox.wrap('<div class="alter-form-message"></div>');
})(jQuery);
