( function( $ ) {
    'use strict';
    
    WPHB_Admin.minification = {

        strings: null,
        $checkFilesButton: null,
        $checkFilesResultsContainer : null,
        module: 'minification',
        checkURLSList: null,
        checkedURLS: 0,
        $spinner: null,

        init: function() {
            var self = this;

            if ( wphbMinificationStrings )
                self.strings = wphbMinificationStrings;

            // Check files button
            this.$checkFilesButton = $( '#check-files' );
            this.$disableMinification = $('#wphb-disable-minification');
            this.$spinner = $('.spinner');

            if ( this.$checkFilesButton.length ) {
                this.$checkFilesButton.click( function( e ) {
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    self.checkFiles( self.strings.finishedCheckURLsLink );
                });
            }

            $('.wphb-discard').click( function(e) {
                e.preventDefault();

                if ( confirm( self.strings.discardAlert ) ) {
                    location.reload();
                }
                return false;

            });

            $( 'table.wphb-enqueued-files input, #wphb-minification-filter-block-bulk input' ).on( 'change', function() {
                $('.wphb-discard').attr( 'disabled', false );
            });

            $('#use_cdn').change( function() {
                var data = {
                    wphb_nonce: self.strings.advancedSettingsNonce,
                    nonce_name: 'wphb-minification-advanced',
                    module_action: 'toggle_use_cdn',
                    data: {
                        value: $(this).is(':checked')
                    }
                };
                WPHB_Admin.utils.post( data, self.module )
                    .always( function() {
                        var notice = $('#wphb-notice-minification-advanced-settings-updated');
                        notice.slideDown();
                        setTimeout( function() {
                            notice.slideUp();
                        }, 5000 );
                    });
            });

            this.$disableMinification.change( function() {
                var value = $(this).is(':checked');

                self.$spinner.css( 'visibility', 'visible' );

                if ( self.timer && value ) {
                    clearTimeout( self.timer );
                    self.$spinner.css( 'visibility', 'hidden' );
                }

                self.timer = setTimeout(
                    function() {
                        $.ajax({
                            url: ajaxurl,
                            method: 'POST',
                            data: {
                                action: 'wphb_ajax',
                                wphb_nonce: self.strings.toggleMinificationNonce,
                                nonce_name: 'wphb-toggle-minification',
                                module: self.module,
                                module_action: 'toggle_minification',
                                data: {
                                    value: value
                                }
                            }
                        }).always( function() {
                            location.reload();
                        });

                    }, 3000
                );


            });

            var rowsCollection = new WPHB_Admin.minification.RowsCollection();

            var rows = $('.wphb-minification-row');

            rows.each( function( index, row ) {
                var _row;
                if ( $(row).data('filter-secondary') ) {
                    _row = new WPHB_Admin.minification.Row( $(row), $(row).data('filter'), $(row).data('filter-secondary') );
                }
                else {
                    _row = new WPHB_Admin.minification.Row( $(row), $(row).data('filter') );
                }

                rowsCollection.push( _row );
            });

            $('#wphb-s').keyup( function() {
                rowsCollection.addFilter( $(this).val(), 'primary' );
                rowsCollection.applyFilters();
            });

            $('#wphb-secondary-filter').change( function() {
                rowsCollection.addFilter( $(this).val(), 'secondary' );
                rowsCollection.applyFilters();
            });

            $('.filter-toggles').change( function() {
                var element = $(this);
                var what = element.data('toggles');
                var value = element.prop( 'checked' );
                var visibleItems = rowsCollection.getVisibleItems();

                for ( var i in visibleItems ) {
                    visibleItems[i].change( what, value );
                }
            });
            $('input[name="filter-position"]').change( function() {
                var element = $(this);
                var what = element.data('toggles');
                var value = element.prop( 'checked' );
                var visibleItems = rowsCollection.getVisibleItems();

                for ( var i in visibleItems ) {
                    visibleItems[i].setPosition( what, value );
                }
            });



            return this;
        },


        checkFiles: function( redirect ) {
            var self = this;

            if ( typeof redirect === 'undefined' )
                redirect = false;

            if ( ! self.minificationStarted ) {
                // Send an AJAX request that will flag the check files as started
                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'wphb_ajax',
                        method: 'POST',
                        wphb_nonce: self.strings.checkFilesNonce,
                        nonce_name: 'wphb-minification-check-files',
                        module: self.module,
                        module_action: 'start_check'
                    }
                }).success(function() {
                    self.minificationStarted = true;
                    self.checkFiles( redirect );
                });
            }
            else {
                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'wphb_ajax',
                        method: 'POST',
                        wphb_nonce: self.strings.checkFilesNonce,
                        nonce_name: 'wphb-minification-check-files',
                        module: self.module,
                        module_action: 'check_step'
                    }
                }).always( function(results) {
                    if ( typeof results.data.finished !== 'undefined' ) {
                        if ( results.data.finished && redirect ) {
                            // Redirect
                            // Wait 10 seconds for the files to be processed
                            window.location.href = redirect;
                            return;
                        }
                        else if ( ! results.data.finished ) {
                            // Wait 3 seconds before calling again
                            window.setTimeout( function() {
                                self.checkFiles( redirect );
                            }, 3000);
                        }
                    }
                    else {
                        // Error
                        window.location.href = redirect;
                        return;
                    }
                });
            }


        }

    };

    WPHB_Admin.minification.Row = function( _element, _filter, _filter_sec ) {
        var $el = _element,
            filter = _filter.toLowerCase(),
            filterSecondary = false,
            visible = true;

        var $include = $el.find( '.toggle-include' ),
            $combine = $el.find( '.toggle-combine' ),
            $minify = $el.find( '.toggle-minify' );

        var $posHeader = $el.find('.toggle-position-header'),
            $posDefault = $el.find('.toggle-position-default'),
            $posFooter = $el.find('.toggle-position-footer');

        if ( _filter_sec ) {
            filterSecondary = _filter_sec.toLowerCase();
        }


        return {
            hide: function() {
                $el.addClass( 'out-of-filter' );
                visible = false;
            },

            show: function() {
                $el.removeClass( 'out-of-filter' );
                visible = true;
            },

            getElement: function() {
                return $el;
            },

            getFilter: function() {
                return filter;
            },

            matchFilter: function( text ) {
                if ( text === '' ) {
                    return true;
                }

                text = text.toLowerCase();
                return filter.search( text ) > -1;
            },

            matchSecondaryFilter: function( text ) {
                if ( text === '' ) {
                    return true;
                }

                if ( ! filterSecondary ) {
                    return false;
                }

                text = text.toLowerCase();
                return filterSecondary == text;
            },

            isVisible: function() {
                return visible;
            },

            change: function( what, value ) {
                switch ( what ) {
                    case 'minify': {
                        $minify.prop( 'checked', value );
                        break;
                    }
                    case 'combine': {
                        $combine.prop( 'checked', value );
                        break;
                    }
                    case 'include': {
                        $include.prop( 'checked', value );
                        break;
                    }
                }
            },

            setPosition: function( position, value ) {
                switch ( position ) {
                    case 'header': {
                        $posHeader.prop( 'checked', value );
                        break;
                    }
                    case 'default': {
                        $posDefault.prop( 'checked', value );
                        break;
                    }
                    case 'footer': {
                        $posFooter.prop( 'checked', value );
                        break;
                    }
                }
            }

        };
    };

    WPHB_Admin.minification.RowsCollection = function() {
        var items = [];
        var currentFilter = '';
        var currentSecondaryFilter = '';

        return {
            push: function( row ) {
                if ( typeof row === 'object' ) {
                    items.push( row );
                }
            },

            getItems: function() {
                return items;
            },

            getItem: function( i ) {
                if ( items[i] ) {
                    return items[i];
                }
                return false;
            },

            getVisibleItems: function() {
                var visible = [];
                for ( var i in items ) {
                    if ( items[i].isVisible() ) {
                        visible.push( items[i] );
                    }
                }
                return visible;
            },

            addFilter: function( filter, type ) {
                if ( type === 'secondary' ) {
                    currentSecondaryFilter = filter;
                }
                else {
                    currentFilter = filter;
                }
            },

            applyFilters: function() {
                for ( var i in items ) {
                    if ( items[i] ) {
                        if ( items[i].matchFilter( currentFilter ) && items[i].matchSecondaryFilter( currentSecondaryFilter ) ) {
                            items[i].show();
                        }
                        else {
                            items[i].hide();
                        }
                    }

                }
            }
        };
    };

}( jQuery ));