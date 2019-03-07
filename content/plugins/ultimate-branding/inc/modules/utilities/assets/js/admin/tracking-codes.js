;jQuery( document ).ready( function( $ ) {
    $('.wp-list-table.tracking-codes span.delete a').on( 'click', function() {
        return window.confirm( ub_tracking_codes.delete );
    });
    $('.tab-tracking-codes .button.action').on( 'click', function() {
        var value = $('select', $(this).parent()).val();
        if ( '-1' === value ) {
            return false;
        }
        if ( 'delete' === value ) {
            return window.confirm( ub_tracking_codes.bulk_delete );
        }
        return true;
    });
    /**
     * save code
     */
    $( 'button.branda-tracking-codes-save' ).on( 'click', function() {
        var dialog = $(this).closest( '.sui-dialog' );
        var data = {
            action: 'branda_tracking_codes_save',
            _wpnonce: $(this).data('nonce'),
        };
        $('input, select, textarea', dialog ).each( function() {
            if ( undefined === $(this).attr( 'name' ) ) {
                return;
            }
            if ( 'radio' === $(this).attr( 'type' ) ) {
                if ( $(this).is(':checked' ) ) {
                    data[$(this).attr('name')] = $(this).val();
                }
            } else {
                data[$(this).attr('name')] = $(this).val();
            }
        });
        var i= 0;
        var editor = $('.branda-general-code label', dialog ).attr( 'for' );
        data['branda[code]'] = SUI.editors[ editor ].getValue();
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
    /**
     * delete item/bulk
     */
    $( '.branda-tracking-codes-delete' ).on( 'click', function() {
        var id = $(this).data('id');
        var action = 'branda_tracking_codes_delete';
        var ids = [];
        if ( 'bulk' === id ) {
            action = 'branda_tracking_codes_bulk_delete';
            $('tbody .check-column input:checked').each( function() {
                ids.push( $(this).val() );
            });
        }
        var data = {
            action: action,
            id: $(this).data('id' ),
            ids: ids,
            _wpnonce: $(this).data('nonce'),
        };
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
});
