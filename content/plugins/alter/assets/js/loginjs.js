(function($) {
   $('.login label input.input').each(function() {
      label = $(this).parent().text();
      $(this).attr("placeholder", label);
      $(this).insertBefore($(this).parent());
      $(this).next().remove();
});
})(jQuery);