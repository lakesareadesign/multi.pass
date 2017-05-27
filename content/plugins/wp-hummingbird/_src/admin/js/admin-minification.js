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

            // Filter action button on Minification page
            $('#wphb-minification-filter-button').on('click', function(e) {
                e.preventDefault();
                $('#wphb-minification-filter').toggle('slow');
            });

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

            $( '.wphb-enqueued-files input' ).on( 'change', function() {
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

            this.rowsCollection = new WPHB_Admin.minification.RowsCollection();

            var rows = $('.wphb-border-row');

            rows.each( function( index, row ) {
                var _row;
                if ( $(row).data('filter-secondary') ) {
                    _row = new WPHB_Admin.minification.Row( $(row), $(row).data('filter'), $(row).data('filter-secondary') );
                }
                else {
                    _row = new WPHB_Admin.minification.Row( $(row), $(row).data('filter') );
                }
                self.rowsCollection.push( _row );
            });

            $('#wphb-s').keyup( function() {
                self.rowsCollection.addFilter( $(this).val(), 'primary' );
                self.rowsCollection.applyFilters();
            });

            $('#wphb-secondary-filter').change( function() {
                self.rowsCollection.addFilter( $(this).val(), 'secondary' );
                self.rowsCollection.applyFilters();
            });

            $('.filter-toggles').change( function() {
                var element = $(this);
                var what = element.data('toggles');
                var value = element.prop( 'checked' );
                var visibleItems = self.rowsCollection.getVisibleItems();

                for ( var i in visibleItems ) {
                    visibleItems[i].change( what, value );
                }
            });

            // Files selectors
            var filesList = $('input.wphb-minification-file-selector');

            filesList.click( function() {
                var $this = $( this );
                var element = self.rowsCollection.getItemById( $this.data( 'type' ), $this.data( 'handle' ) );
                if ( ! element ) {
                    return;
                }

                if ( $this.is( ':checked' ) ) {
                    element.select();
                }
                else {
                    element.unSelect();
                }
            });

            // Include/exclude file checkbox
            $('.toggle-cross').on('click', function(e) {
                var $this = $(this);
                var checkbox = $this.find( 'input.toggle-include' );
                var row = self.rowsCollection.getItemById( $this.data( 'type' ), $this.data( 'handle' ) );
                // Mark the item as include or not in the rows list
                if ( row ) {
                    row.change( 'include', ! checkbox.prop( 'checked' ) );
                    row.getElement().find( 'input:not(.toggle-include)' ).prop('disabled', ! checkbox.prop( 'checked' ) );
                }
            });

            // Handle two CDN checkboxes on Minification page
            var checkboxes = $("input[type=checkbox][name=use_cdn]");
            checkboxes.change( function() {
                var checkedState = $(this).prop('checked');

                checkboxes.each( function() {
                    this.checked = checkedState;
                });
            });

            /* Show details of minification row on mobile devices */
            $('body').on('click', '.wphb-minification-file-details', function(e) {
                if ( window.innerWidth < 783 ) {
                    $(this).parent().find('.wphb-minification-row-details').toggle('slow');
                }
            });

            /*
             Catch window resize and revert styles for responsive divs
             1/4 of a second should be enough to trigger during device rotations (from portrait to landscape mode)
             */
            var minification_resize_rows = _.debounce(function() {

                if ( window.innerWidth >= 783 ) {
                    $('.wphb-minification-row-details').css('display', 'flex');
                } else {
                    $('.wphb-minification-row-details').css('display', 'none');
                }

            }, 250);

            window.addEventListener('resize', minification_resize_rows);

            return this;
        },

        checkFiles: function( redirect ) {
            var self = this;

            if ( typeof redirect === 'undefined' )
                redirect = false;

            if ( ! self.minificationStarted ) {
                // Store the progress in session storage to persist during page reloads
                // If there is no previous value, we init one with 10%
                if ( sessionStorage.getItem('progress') === null ) {
                    sessionStorage.setItem('progress', 10);
                }
                // Update progress bar
                $('.wphb-scan-progress .wphb-scan-progress-text span').text( sessionStorage.getItem('progress') + '%' );
                $('.wphb-scan-progress .wphb-scan-progress-bar span').width( sessionStorage.getItem('progress') + '%' );

                // Send an AJAX request that will flag the check files as started
                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'wphb_ajax',
                        method: 'POST',
                        wphb_nonce: self.strings.checkFilesNonce,
                        nonce_name: 'wphb-minification-check-files',
                        module: self.module,
                        module_action: 'start_check',
                        progress: sessionStorage.getItem('progress')
                    }
                }).success(function(results) {
                    // Set the number of steps to be used in percentage count. Only if not set already.
                    if ( ( typeof results.data.steps !== 'undefined' ) && ( sessionStorage.getItem('steps') === null ) ) {
                        sessionStorage.setItem('steps', results.data.steps);
                    }

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
                        module_action: 'check_step',
                        progress: sessionStorage.getItem('progress'),
                        step: Math.round( 80 / sessionStorage.getItem('steps') )
                    }
                }).always( function(results) {
                    if ( typeof results.data.finished !== 'undefined' ) {
                        // Finished
                        if ( results.data.finished && redirect ) {
                            // Clear session storage
                            sessionStorage.clear();

                            // Update progress bar
                            $('.wphb-scan-progress .wphb-scan-progress-text span').text('100%');
                            $('.wphb-scan-progress .wphb-scan-progress-bar span').width('100%');

                            // Show enable cdn modal only for members
                            if ( true === results.data.show_cnd ) {
                                var args = {};
                                args.class = "wphb-modal small wphb-progress-modal no-close";
                                WDP.showOverlay("#enable-cdn-modal", args);
                            } else {
                                window.location.href = redirect;
                            }

                            return;
                        }
                        // Next step
                        else if ( ! results.data.finished ) {
                            // Store the progress in session storage to persist during page reloads
                            var progress = parseInt( sessionStorage.getItem('progress') ) + Math.round( 80 / sessionStorage.getItem('steps') );
                            sessionStorage.setItem('progress', progress)

                            if ( progress >= 90 ) {
                                $('.wphb-progress-state .wphb-progress-state-text').text('Finalizing...');
                            }
                            if ( progress > 100 ) {
                                progress = 100;
                            }
                            // Update progress bar
                            $('.wphb-scan-progress .wphb-scan-progress-text span').text( progress + '%' );
                            $('.wphb-scan-progress .wphb-scan-progress-bar span').width( progress + '%' );

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
            selected = false,
            visible = true;

        var $include = $el.find( '.toggle-include' ),
            $combine = $el.find( '.toggle-combine' ),
            $minify = $el.find( '.toggle-minify' );

        var $posFooter = $el.find('.toggle-position-footer');

        var $disableIcon = $el.find( '.toggle-cross > i' );

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

            getId: function() {
                return $el.attr('id');
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
                return filterSecondary === text;
            },

            isVisible: function() {
                return visible;
            },

            isSelected: function() {
                return selected;
            },

            select: function() {
                selected = true;
            },

            unSelect: function() {
                selected = false;
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
                        $disableIcon.removeClass();
                        $include.prop( 'checked', value );
                        if ( value ) {
                            $el.removeClass('disabled');
                            $disableIcon.addClass('dev-icon dev-icon-cross');
                            $include.attr( 'checked', true );
                        } else {
                            $el.addClass('disabled');
                            $disableIcon.addClass('wdv-icon wdv-icon-refresh');
                            $include.removeAttr( 'checked' );
                        }
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

            /**
             * Get a collection item by type and ID
             * @param type
             * @param id
             */
            getItemById: function( type, id ) {
                var value = false;
                for ( var i in items ) {
                    if ( 'wphb-file-' + type + '-' + id === items[i].getId() ) {
                        value = items[i];
                        break;
                    }
                }
                return value;
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

            getSelectedItems: function() {
                var selected = [];

                for ( var i in items ) {
                    if ( items[i].isVisible() && items[i].isSelected() ) {
                        selected.push( items[i] );
                    }
                }

                return selected;
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