/**
 * Search icons
 */
jQuery(document).ready(function($){
    $('.branda-general-icon-search')
        .on( 'change keydown keyup blur reset copy paste cut input', function() {
            var search = $(this).val();
            var target = $('.branda-general-icon');
            var re;
            if ( '' === search ) {
                $('.branda-dashicons, .branda-dashicons span', target ).show();
                return;
            }
            re = new RegExp( search, 'i' );
            $('.branda-dashicons span', target).each( function() {
                var value = $(this).data('code');
                if ( value.match( re ) ) {
                    $(this).show();
                    $(this).closest('.branda-dashicons').show();
                } else {
                    $(this).hide();
                }
            });
            $('.branda-dashicons', target).each( function() {
                if ( 1 > $('span:visible', $(this)).length ) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
});

jQuery(document).ready(function($){
    var Branda_Ordering = {
        children : function(hide){
            hide = typeof hide === "undefined" ? true : false;
            if( hide ){
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default > li").css({
                    cursor : "move"
                }).find(".ab-sub-wrapper").css({
                    visibility : "hidden"
                });
            }else{
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default > li").css({
                    cursor : "default"
                }).find(".ab-sub-wrapper").css({
                    visibility : "visible"
                });
            }

        },
        sortable : function( make ) {
            make = typeof make === "undefined" ? true : false;
            if( make ){
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default .ab-item").addClass("click_disabled");
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default").sortable({
                    axis: "x",
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    distance : 2,
                    handle: ".ab-item",
                    tolerance: "intersect",
                    cursor: "move"
                }).sortable( "enable" );
            }else{
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default .ab-item").removeClass("click_disabled");
                $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default").sortable( "disable" );
            }
        },
        wiggle : function(wiggle) {
            wiggle = typeof wiggle === "undefined" ? true : false;
            var $el = $("#ub_admin_bar_wrap ul#wp-admin-bar-root-default > li");
            if( wiggle ){
                $el.ClassyWiggle("start", {
                    degrees: ['2', '4', '2', '0', '-2', '-4', '-2', '0'],
                    delay : 90
                });
            }else{
                $el.ClassyWiggle("stop");
            }
        },
        add_save_button : function(){
            $("#ub_admin_bar_save_ordering").remove();
            $("#wp-admin-bar-root-default").after('<button id="ub_admin_bar_save_ordering" class="sui-button sui-button-blue" type="button"><span class="sui-loading-text"><i class="sui-icon-save"></i>'+ub_admin.buttons.save_changes+'</span</button>' );
        },
        start : function(){
            this.children();
            this.sortable();
            this.wiggle();
            this.add_save_button();
        },
        stop : function(){
            this.children( false );
            this.sortable( false );
            this.wiggle( false );
            $("#ub_admin_bar_save_ordering").slideUp(100, function(){
                $(this).remove();
            });
        },
        save : function(){
            var self = this, $button = $( "#ub_admin_bar_save_ordering" );
            $button.attr("disabled", true).addClass("ub_loading");
            order = [];
            $("#ub_admin_bar_wrap #wp-admin-bar-root-default > li").each(function(){
                if( typeof this.id === "string" &&  this.is !== "" ){
                    order.push( this.id.replace( "wp-admin-bar-", "" ) );
                }
            });
            $.ajax({
                url      : ajaxurl,
                type     : 'post',
                data     : {
                    action   : 'branda_admin_bar_order_save',
                    _wpnonce: $('#branda-admin-bar-reorder-nonce').val(),
                    order    : order
                },
                success  : function( response ) {
                    if ( "undefined" !== typeof response.data.message ) {
                        if ( response.success ) {
                            window.ub_sui_notice( response.data.message );
                        } else {
                            window.ub_sui_notice( response.data.message, 'error' );
                        }
                    }
                },
                complete: function() {
                    $button.attr("disabled", false).removeClass("ub_loading").remove();
                    self.stop();
                }
            });
        }
    };
    $("#ub_admin_bar_start_ordering").on("click", function( e ){
        e.preventDefault();
        Branda_Ordering.start();
    });
    $(document).on("click", "#ub_admin_bar_save_ordering", function( e ){
        e.preventDefault();
        Branda_Ordering.save();
    });
});
/**
 * Add item
 */
jQuery( window.document ).ready( function( $ ){
    "use strict";
    /**
     * Open add/edit modal
     */
    $('.branda-admin-bar-save').on( 'click', function() {
        var parent = $('.sui-box-body', $(this).closest( '.sui-box' ) );
        var reqired = false;
        var id = $(this).data('id');
        $('[data-required=required]', parent ).each( function() {
            if ( '' === $(this).val() ) {
                var local_parent = $(this).parent();
                local_parent.addClass('sui-form-field-error');
                $( 'span', local_parent ).addClass( 'sui-error-message' );
                reqired = true;
            }
        });
        if ( reqired ) {
            return;
        }
        var data = {
            action: 'branda_admin_bar_menu_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
        };
        $('input, textarea', parent).each( function() {
            var n = $(this).attr('name');
            switch( $(this).attr('type') ) {
                case 'checkbox':
                case 'radio':
                    if ( $(this).is(':checked') ) {
                        data[n] = $(this).val();
                    }
                    break;
                default:
                    data[n] = $(this).val();
            }
        });
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
    $('.branda-admin-bar-delete').on( 'click', function() {
        var data = {
            action: 'branda_admin_bar_delete',
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
     * Reset order
     */
    $('.branda-admin-bar-reset').on( 'click', function() {
        var data = {
            action: 'branda_admin_bar_order_reset',
            _wpnonce: $(this).data('nonce')
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
     * Submenu: select dashicon
     */
    $('.branda-dashicons span.dashicons').on( 'click', function() {
        var code = $(this).data('code');
        var parent = $(this).closest('.sui-form-field');
        var html = '<span class="dashicons dashicons-' + code +  '"></span>';
        $('[name="branda[icon]"]', parent ).val( code );
        $('.sui-accordion-col span', parent ).html( html );
        $('.branda-admin-bar-selected .branda-admin-bar-dashicon-preview', parent ).html( html );
        $('.branda-admin-bar-selected' ).show();
    });
    $('.branda-admin-bar-selected .branda-admin-bar-clear').on( 'click', function() {
        var parent = $(this).closest('.sui-form-field');
        $('[name="branda[icon]"]', parent ).val( '' );
        $('.sui-accordion-col span', parent ).html( '' );
        $('.branda-admin-bar-selected .branda-admin-bar-dashicon-preview', parent ).html( '' );
        $('.branda-admin-bar-selected' ).hide();
        return false;
    });
    /**
     * Submenu: add
     */
    function bind_branda_submenu_title( parent ) {
        $('.branda-admin-bar-submenu-title input[type=text]', parent ).on( 'change paste cut keydown keyup keypress', function( event ) {
            $('.sui-accordion-item-title', $(this).closest('.sui-accordion-item')).html(
                '<i class="sui-icon-drag" aria-hidden="true"></i>' + $(this).val()
            );
        });
    }
    bind_branda_submenu_title( $('body') );
    $('.branda-admin-bar-submenu-add').on( 'click', function() {
        var target = $('.sui-box-builder-body', $(this).closest('.sui-form-field') );
        var template = wp.template( $(this).data('template') );
        var id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        var args = {
            id: id,
            target: 'current',
            url: 'admin',
            url_admin: '',
            url_site: '',
            url_custom: ''
        };
        var submenu;
        $('.sui-accordion', target ).append( template( args ) );
        SUI.brandaSideTabs();
        $('.branda-admin-bar-no-submenu').hide();
        submenu = $('#branda-admin-bar-submenu-'+id );
        bind_branda_submenu_title( submenu );
        $('.branda-admin-bar-submenu-delete', submenu ).on( 'click', function() {
            var parent = $(this).closest( '.sui-box-builder-body');
            var length = $('.sui-accordion-item', parent ).length;
            $(this).closest('.sui-accordion-item').detach();
            if ( 2 > length ) {
                $('.branda-admin-bar-no-submenu', parent).show();
            }
        });
    });
    /**
     * Submenu: delete
     */
    $('.branda-admin-bar-submenu-delete').on( 'click', function() {
        $(this).closest('.sui-accordion-item').detach();
    });
    /**
     * Submenu: restore
     */
    $('.branda-admin-bar-submenu-restore').on( 'click', function() {
        var parent = $(this).closest( '.sui-box' );
        var data = {
            action: 'branda_admin_bar_submenu_restore',
            _wpnonce: $(this).data('nonce'),
            id: $(this).data('id')
        };
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                var value = response.data[0];
                /**
                 * Menu title
                 */
                $('[name="branda[title]"]', parent ).val( value.title );
                /**
                 * Icon
                 */
                var icon = $('[name="branda[icon]"]', parent );
                icon.val( value.icon );
                $('.sui-accordion-item-header span.dashicons', icon.parent() ).attr( 'class', 'dashicons dashicons-' + value.icon );
                /**
                 * Redirect users to
                 */
                $('[name="branda[url]"][value="'+value.url+'"]', parent).trigger( 'click' );
                /**
                 * Open link in
                 */
                $('[name="branda[target]"][value="'+value.target+'"]', parent ).trigger( 'click' );
                /**
                 * User Roles
                 */
                $('.branda-visibility-roles input[type="checkbox"]', parent ).each( function() {
                    if ( 'undefined' === typeof value.roles[ $(this).val() ] ) {
                        $(this).removeProp( 'checked' );
                    } else {
                        $(this).prop( 'checked', 'checked' );
                    }
                });
                /**
                 * Submenu Items
                 */
                var target = $('.sui-box-builder-body', parent );
                var template = wp.template( $('.branda-admin-bar-submenu-add', parent ).data('template') );
                $('.sui-accordion-item', target).detach();
                $.each( value.submenu, function( id, args ) {
                    $('.sui-accordion', target ).append( template( args ) );
                });
                SUI.suiTabs();
                $('.branda-admin-bar-no-submenu').hide();
            } else {
                window.ub_sui_notice( response.data.message, 'error' );
            }
        });
    });
});
/**
 * "Redirect user to" section
 */
jQuery( window.document ).ready( function( $ ) {
    var ids = [
        'branda-admin-bar-add'
    ];
    $('.branda-settings-tab-content-admin-bar .sui-dialog').each( function() {
        if ( $(this).attr('id' ).match( /^branda-admin-bar-edit-/ ) ) {
            ids.push( $(this).attr('id' ) );
        }
    });
    function branda_admin_bar_dialog_change( dialog ) {
        var value = $('.branda-general-url input:checked', dialog ).val();
        if ( undefined === value ) {
            value = $('.branda-general-url .active input', dialog ).val();
        }
        switch( value ) {
            case 'custom':
                $('.branda-general-custom', dialog ).show();
                $('.branda-admin-bar-url-options', dialog ).show();
                break;
            case 'main':
            case 'current':
            case 'wp-admin':
                $('.branda-general-custom', dialog ).hide();
                $('.branda-admin-bar-url-options', dialog ).show();
                break;
            default:
                $('.branda-general-custom', dialog ).hide();
                $('.branda-admin-bar-url-options', dialog ).hide();
        }
    }
    function branda_admin_bar_dialog_add_bind( ids ) {
        if (
            'undefined' === typeof SUI ||
            'undefined' === typeof SUI.dialogs
        ) {
            window.setTimeout( branda_admin_bar_dialog_add_bind, 100, ids );
        } else if ( 'object' === typeof SUI.dialogs['branda-admin-bar-add'] ) {
            $.each( ids, function( index, id ) {
                SUI.dialogs[id].on( 'show', function() {
                    var dialog = $( '#' + id );
                    if ( dialog.hasClass( 'branda-alredy-bind' ) ) {
                        return;
                    }
                    branda_admin_bar_dialog_change( dialog );
                    dialog.addClass( 'branda-alredy-bind' );
                    $('.branda-general-url input', dialog ).on( 'change', function() {
                        branda_admin_bar_dialog_change( dialog );
                    });
                });
            });
        }
    }
    branda_admin_bar_dialog_add_bind( ids );
});
