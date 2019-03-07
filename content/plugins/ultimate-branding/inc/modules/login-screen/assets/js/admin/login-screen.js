jQuery( document ).ready( function( $ ) {
    /**
     * Radio selector change.
     */
    $( 'input[name=branda-login-screen-template]' ).on( 'change', function() {
        $( '.branda-login-screen-choose-template-dialog li').removeClass( 'branda-selected' );
        if( $(this).is(':checked') ) {
            $(this).closest('li').addClass( 'branda-selected' );
        }
    });
    /**
     * Set selected template
     */
    $('.branda-login-screen-choose-template').on( 'click', function() {
        var id = $( 'input[name=branda-login-screen-template]:checked' ).val();
        if ( id ) {
            var data = {
                action: 'branda_login_screen_set_template',
                _wpnonce: $(this).data('nonce'),
                id: id
            };
            $.post( ajaxurl, data, function( response ) {
                if ( response.success ) {
                    window.location.reload();
                } else {
                    window.ub_sui_notice( response.data.message, 'error' );
                }
            });
        }
    });
});
