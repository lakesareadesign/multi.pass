jQuery(document).ready(function($){
    var footers = $('footer');
    if ( 0 === footers.length ) {
        return;
    }
    footers = footers.toArray().reverse();
    $.each( footers, function() {
        var parent = $(this).closest( '.wph-modal' );
        if ( 0 == parent.length ) {
            $(".ub_global_footer_inside").appendTo($(this));
            return false;
        }
    });
});
