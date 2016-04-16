jQuery(function($){
    $('#manual_shipping_options').parent().css('width', 'auto');

    // Adds a new item from a script template
    $('.new_item').click(function(){
        var template_id = $(this).attr('data-template-id');
        var table_id    = $(this).attr('data-table-id');
        var template    = $("#"+template_id).html();
        var $table      = $('#'+table_id);
        var $element    = $(template.replace(/\{id\}/g, 'new-'+Math.random().toString(10).substr(2)));
        var $no_items   = $table.parent().find('.no_items:visible');
        var callback    = function(){
            $element.css('display', 'none');
            $table.append($element);
            $element.fadeIn(400);
        };

        if ($no_items.length > 0) {
            $no_items.fadeOut('fast', callback);
        }
        else callback();

    });

    // Deletes an item
    $('.delete_item').live('click', function(){
        var id          = $(this).attr('data-id');
        var table_id    = $(this).attr('data-table-id');
        var $table      = $('#'+table_id).parent();
        var $no_items   = $table.find('.no_items');

        $table.find('.item_'+id).fadeOut(400, function(){
            $(this).remove();
            if (id.indexOf('new') == -1) {
                var $deleted = $('<input/>').attr({
                   name:  'deleted_items[]',
                   type:  'hidden',
                   value: id
                });
                $('#ngg_page_content form').prepend($deleted);
            }

            if ($table.find('.item').length == 0) {
                $no_items.fadeIn();
            }
        });
    });

    // Hide/show global shipping options
    $('#manual_allow_global_shipping').change(function(){
        if ($(this).attr('checked') == 'checked') {
            $('#manual_global_shipping_options').fadeIn();
        }
        else {
            $('#manual_global_shipping_options').fadeOut(400);
        }
    }).change();

    // Hide/show licensing page options
    $('#show_digital_downloads_licensing_link').change(function(){
       if ($(this).attr('checked') == 'checked') {
           $('#digital_downloads_licensing_page').fadeIn();
       }
       else {
           $('#digital_downloads_licensing_page').fadeOut(400);
       }
    }).change();

    $('.button-primary').click(function(e){
       var retval = true;
       var $title = $('#title');
       if ($title.val().trim().length == 0) {
            $title.addClass('title_empty');
            e.preventDefault();
            $(window).scrollTop(0);
            retval = false;
       }
       else $title.removeClass('title_empty');

       return retval;
    });

    $('#title').keypress(function(){
       var $title = $(this);
       if ($title.val().trim().length == 0) {
           $title.addClass('title_empty');
       }
       else $title.removeClass('title_empty');
    });
});