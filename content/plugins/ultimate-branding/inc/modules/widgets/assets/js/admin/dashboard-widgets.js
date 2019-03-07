/**
 * Branda: Dashboard Widgets
 * http://premium.wpmudev.org/
 *
 * Copyright (c) 2018 Incsub
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */

/**
 * Add feed
 */
jQuery( window.document ).ready( function( $ ){
    "use strict";

    /**
     * Open add/edit modal
     */
    $('.branda-dashboard-widgets-text-add, .branda-dashboard-widgets-text-save').on( 'click', function() {
        var parent = $('.sui-box-body', $(this).closest( '.sui-box' ) );
        var id = $(this).data('id');
        var editor_id = 'branda-general-content-' + id;
        var data = {
            action: 'branda_dashboard_widget_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
            content: $.fn.branda_editor( editor_id ),
            title: $( '#branda-general-title-' + id, parent ).val(),
            site: $( '[name="branda[site]"]:checked', parent).val(),
            network: $( '[name="branda[network]"]:checked', parent).val(),
        };
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });

    /**
     * Delete item
     */
    $('.branda-dashboard-widgets-delete').on( 'click', function() {
        var data = {
            action: 'branda_dashboard_widget_delete',
            _wpnonce: $(this).data('nonce'),
            id: $(this).data('id' )
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
