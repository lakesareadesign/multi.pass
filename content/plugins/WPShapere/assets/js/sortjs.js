jQuery(function() {
        var j = 0;
        jQuery( ".sortUls" ).sortable({
            connectWith: ".sortUls",
            placeholder: "sortable-placeholder",

        });
       
       jQuery("a.admin_menu_edit").on('click', function(e) {
           e.preventDefault();
           var click_id = jQuery(this).attr('id');
               jQuery('#menu_edit_' + click_id).slideToggle('fast');
         });
         
         jQuery("a.disclose").on('click', function(e) {
           e.preventDefault();
           var disclose_id = jQuery(this).attr('id');
            jQuery('ol#child_' + disclose_id).slideToggle('fast');
            jQuery(this).toggleClass('plus').toggleClass('minus');
         });    
       
    });