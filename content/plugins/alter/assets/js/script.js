(function($) {
    $('#alt-repeater').repeater({
      show: function () {
      $(this).slideDown();
    },
    hide: function (remove) {
      if(confirm('Are you sure you want to remove this item?')) {
        $(this).slideUp(remove);
      }
    },
    isFirstItemUndeletable: true
  });
   $("a.alter-edit-expand").on('click', function(e) {
        e.preventDefault();
        $(this).next('.alter-menu-contents').slideToggle('fast');
    });
    $('.redirect-users .select_redirect_page').on('change', function (e) {
        var redirect_page = $("option:selected", this).val();
        //alert(redirect_page);
        if(redirect_page == "custom_url") {
            $(this).parent().next('div.custom_url').show('fast');
        }
        else {
            $(this).parent().next('div.custom_url').hide('fast');
        }
    });
})(jQuery);