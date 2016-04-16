jQuery(function($){
    var $element = $('#roles_and_capabilities_content').find("label[for='change_options']").parent().prev();
    $element.append("<div style='font-size: 11px;'>"+ngg_change_options_note+"</div>");
});