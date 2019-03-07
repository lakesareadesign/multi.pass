/**
 * Branda: Dashboard Feeds
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
    $('.branda-dashboard-feeds-add, .branda-dashboard-feeds-save').on( 'click', function() {
        var parent = $('.sui-box-body', $(this).closest( '.sui-box' ) );
        var reqired = false;
        var id = $(this).data('id');
        $( '[data-required=required]', parent ).each( function() {
            if ( '' === $(this).val() ) {
                var local_parent = $(this).parent();
                local_parent.addClass('sui-form-field-error');
                $('span', local_parent ).addClass( 'sui-error-message' );
                reqired = true;
            }
        });
        if ( reqired ) {
            return;
        }
        var data = {
            action: 'branda_dashboard_feed_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
            link: $('#branda-general-link-' + id, parent).val(),
            url: $('#branda-general-url-' + id, parent).val(),
            title: $('#branda-general-title-' + id, parent).val(),
            items: $('#branda-display-items-' + id, parent).val(),
            show_summary: $('.branda-display-show_summary input[type=radio]:checked', parent).val(),
            show_date: $('.branda-display-show_date input[type=radio]:checked', parent).val(),
            show_author: $('.branda-display-show_author input[type=radio]:checked', parent).val(),
            site: $('.branda-visibility-site input[type=radio]:checked', parent).val(),
            network: $('.branda-visibility-network input[type=radio]:checked', parent).val(),
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
     * Delete feed
     */
    $('.branda-dashboard-feeds-delete').on( 'click', function() {
        if ( 'bulk' === $(this).data('id') ) {
            return;
        }
        var data = {
            action: 'branda_dashboard_feed_delete',
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
    /**
     * Bulk: confirm
     */
    $( '.branda-dashboard-feeds-delete[data-id=bulk]').on( 'click', function() {
        var data = {
            action: 'branda_dashboard_feed_delete_bulk',
            _wpnonce: $(this).data('nonce'),
            ids: [],
        }
        $('#branda-dashboard-feeds-panel .check-column :checked').each( function() {
            data.ids.push( $(this).val() );
        });
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
});
