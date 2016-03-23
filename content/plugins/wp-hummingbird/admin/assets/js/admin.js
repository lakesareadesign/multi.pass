( function( $ ) {
    'use strict';

    var WPHB_Admin = {
        modules: [],
        // Common functionality to all screens
        init: function() {

            function updatePerformanceGraph($wrap){
              var $item = $wrap.find('.wphb-score-result-label'),
                  val = parseInt($item.text(), 10) || 100,
                  $circle = $wrap.find(".wphb-score-graph-result"),
                  r, c, pct
              ;
              r = $circle.attr('r');
              c = Math.PI*(r*2);
            
              if (val < 0) { val = 0;}
              if (val > 100) { val = 100;}
            
              pct = ((100-val)/100)*c;
            
              $circle.css({ strokeDashoffset: pct});
            }
            
            function updatePerformanceResultsGraphs(){
              
                // Update Overall Score
                $(".wphb-performance-report-overall-score").each(function(){
                    updatePerformanceGraph($(this));
                });

                // Update Current Score
                $(".wphb-performance-report-current-score").each(function(){
                    updatePerformanceGraph($(this));
                });

                // Update All Scores
                $(".wphb-performance-report-item-score").each(function(){
                    updatePerformanceGraph($(this));
                });

            }
            window.register_events_performance = function(){
                setTimeout(updatePerformanceResultsGraphs, 500);
            }
            $(function(){ setTimeout(updatePerformanceResultsGraphs, 500); });

        },
        initModule: function( module ) {
            if ( this.hasOwnProperty( module ) ) {
                return this.modules[ module ] = this[ module ].init();
            }

            return {};
        },
        getModule: function( module ) {
            if ( typeof this.modules[ module ] != 'undefined' )
                return this.modules[ module ];
            else
                return this.initModule( module );
        }
    };

    WPHB_Admin.performance = {

        module: 'performance',
        iteration: 0,

        init: function() {

            var self = this;

            if ( wphbPerformanceStrings )
                this.strings = wphbPerformanceStrings;

            this.$runTestButton = $( '#run-performance-test' );

            $(".performance-report-table").off( 'click','button' );
            $('.performance-report-table').on( 'click','.wphb-performance-report-item-cta .additional-content-opener' && 'tr.wphb-performance-report-item', function(e) {
                e.preventDefault();

                var getParentPerformanceItem    = $(this).closest(".wphb-performance-report-item"),
                    getNextAdditionalContentRow = getParentPerformanceItem.nextUntil(".wphb-performance-report-item");

                getNextAdditionalContentRow.toggleClass("wphb-performance-report-item-additional-content-opened");

                if (getNextAdditionalContentRow.hasClass("wphb-performance-report-item-additional-content-opened")) {
                    getParentPerformanceItem.addClass("wphb-performance-report-item-opened");
                } else {
                    getParentPerformanceItem.removeClass("wphb-performance-report-item-opened");
                }

            });

            if ( this.$runTestButton.length ) {
                this.$runTestButton.click( function( e ) {
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    self.performanceTest( self.strings.finishedTestURLsLink );
                });
            }

            // If a hash is present in URL, let's open the rule extra content
            var hash = window.location.hash;
            if ( hash ) {
                var row = $( hash );
                if ( row.length ) {
                    row.find( '.trigger-additional-content').trigger( 'click' );
                }

            }

            return this;

        },

        performanceTest: function( redirect ) {
            var self = this;

            if ( typeof redirect === 'undefined' )
                redirect = false;

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'wphb_ajax',
                    method: 'POST',
                    wphb_nonce: self.strings.performanceTestNonce,
                    nonce_name: 'wphb-welcome-performance-test',
                    module: self.module,
                    module_action: 'performance_test'
                }
            }).success(function( response ) {
                var finished = response.success;
                if ( ! finished ) {
                    // Try again 5 seconds later
                    window.setTimeout( function() {
                        self.performanceTest( redirect );
                    }, 10000 );
                }
                else {
                    if ( redirect )
                        window.location = redirect;
                }

            });

        }
    };

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
                )


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

    WPHB_Admin.chart = {
        module: 'chart',

        cache: [],

        google: null,

        init: function() {
            var self = this;

            if ( wphbMinificationStrings )
                self.strings = wphbMinificationStrings;

            self.google = google;
            self.google.load("visualization", "1.1", {packages:["sankey"]});

            $( '#wphb-chart-selector').change( function() {
                var value = $(this).val();

                if ( typeof self.cache[ value ] != 'undefined' ) {
                    self.reDraw( self.cache[ value ].chartData, self.cache[ value ].sourcesNumber );
                }

                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: self.module + '_switch_chart_area',
                        method: 'POST',
                        wphb_nonce: self.strings.chartNonce,
                        data: {area: value}
                    }
                })
                .success(function (data) {

                    if ( typeof data.data != 'undefined' ) {
                        self.cache[ value ] = data.data;
                        self.reDraw( data.data.chartData, data.data.sourcesNumber );
                    }

                });

            });

            return this;
        },

        reDraw: function( chartData, sourcesNumber ) {
            $('#sankey_multiple').css( 'height', 50 * sourcesNumber );
            this.draw( chartData );
        },

        draw: function( chartData ) {

            var data = new this.google.visualization.DataTable();
            data.addColumn('string', 'From');
            data.addColumn('string', 'To');
            data.addColumn('number', 'Files');
            data.addRows(chartData);


            // Set chart options
            var options = {
                width: '100%',
                sankey: {
                    node: {
                        label: {
                            fontName: 'Open Sans',
                            fontSize: 14,
                            color: '#333',
                            bold: false,
                            italic: false,
                            stroke: 'black',  // Color of the text border.
                            strokeWidth: 1    // Thickness of the text border (default 0).
                        },
                        labelPadding: 6,     // Horizontal distance between the label and the node.
                        nodePadding: 30,     // Vertical distance between nodes.
                        width: 20            // Thickness of the node.
                    },
                    link: {
                        colorMode: 'source',
                        color: {
                            fill: '#E3E3E3',     // Color of the link.
                            fillOpacity: 1, // Transparency of the link.
                            stroke: 'black',  // Color of the link border.
                            strokeWidth: 0    // Thickness of the link border (default 0).
                        }

                    }

                }
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new this.google.visualization.Sankey(document.getElementById('sankey_multiple'));
            chart.draw(data, options);

            $(window).resize(function(){
              chart.draw(data, options);
            });
        }

       

    };

    WPHB_Admin.gzip = {

        module: 'gzip',
        selectedServer: '',
        $serverSelector: null,
        $serverInstructions: [],

        init: function () {
            var self = this;

            if ( wphbGZipStrings )
                self.strings = wphbGZipStrings;

            this.$serverSelector = $( '#wphb-server-type' );
            this.selectedServer = this.$serverSelector.val();

            var instructionsList = $( '.wphb-server-instructions' );
            instructionsList.each( function( i, element ) {
                self.$serverInstructions[ $(this).data('server') ] = $(this);
            });

            this.showServerInstructions( this.selectedServer );

            this.$serverSelector.change( function() {
                var value = $(this).val();
                self.hideCurrentInstructions();
                self.showServerInstructions( value );
                self.selectedServer = value;
            });

            $( '#toggle-apache-instructions').click( function( e ) {
                e.preventDefault();
                $('.apache-instructions').toggle();
            });

            return this;
        },

        hideCurrentInstructions: function() {
            var selected = this.selectedServer;
            if ( this.$serverInstructions[ selected ] ) {
                this.$serverInstructions[ selected ].hide();
            }
        },

        showServerInstructions: function( server ) {
            if ( typeof this.$serverInstructions[ server ] != 'undefined' ) {
                this.$serverInstructions[ server ].show();
            }

            if ( 'apache' == server ) {
                $( '#enable-cache-wrap').show();
            }
            else {
                $( '#enable-cache-wrap').hide();
            }
        }
    };

    WPHB_Admin.caching = {

        module: 'caching',
        selectedServer: '',
        $serverSelector: null,
        $serverInstructions: [],
        $expirySelectors: [],
        $snippets: [],

        init: function () {
            var self                    = this,
                cachingMetabox          = $('#wphb-box-caching-enable'),
                cachingContent          = cachingMetabox.find('.box-content'),
                cachingContentSpinner   = cachingContent.find('.spinner'),
                cachingFooter           = cachingMetabox.find('.box-footer');

            if ( wphbCachingStrings )
                self.strings = wphbCachingStrings;

            this.$serverSelector = $( '#wphb-server-type' );
            this.selectedServer = this.$serverSelector.val();
            //this.$spinner = $('#wphb-box-caching-enable .spinner');

            self.$snippets['apache'] = $('#wphb-code-snippet-apache pre').first();
            self.$snippets['nginx'] = $('#wphb-code-snippet-nginx pre').first();

            var instructionsList = $( '.wphb-server-instructions' );
            instructionsList.each( function( i, element ) {
                self.$serverInstructions[ $(this).data('server') ] = $(this);
            });

            var expirySelectors = $( '.wphb-expiry-select' );

            expirySelectors.each( function( i, element ) {
                var type = $(this).data('type');
                if ( type ) {
                    $(this).change( function() {
                        //self.$spinner.css( 'visibility', 'visible' );
                        cachingContent.find('.wphb-content').hide();
                        cachingFooter.hide();
                        cachingContentSpinner.fadeIn();
                        $('.wphb-notice').hide();

                        // Expiration selector has changed
                        ( function( element ) {
                            var value = $( element ).val();
                            // Change the plugin settings
                            $.ajax({
                                url: ajaxurl,
                                method: 'POST',
                                data: {
                                    action: 'wphb_ajax',
                                    wphb_nonce: self.strings.setExpirationNonce,
                                    nonce_name: 'wphb-set-expiration',
                                    module: self.module,
                                    module_action: 'set_expiration',
                                    data: {
                                        type: type,
                                        value: value
                                    }
                                }
                            }).done( function() {
                                // And reload the code snippet
                                self.reloadSnippets();
                            });
                        })( this );
                    });
                }

            });

            this.showServerInstructions( this.selectedServer );

            this.$serverSelector.change( function() {
                var value = $(this).val();
                self.hideCurrentInstructions();
                self.showServerInstructions( value );
                self.setServer(value);
                self.selectedServer = value;
            });

            $( '#toggle-apache-instructions').click( function( e ) {
                e.preventDefault();
                $('.apache-instructions').slideToggle();
            });



            return this;
        },

        setServer: function( value ) {
            var self = this;
            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'wphb_ajax',
                    wphb_nonce: self.strings.setServerNonce,
                    nonce_name: 'wphb-set-server',
                    module: self.module,
                    module_action: 'set_server_type',
                    data: {
                        type: value
                    }
                }
            });
        },

        hideCurrentInstructions: function() {
            var selected = this.selectedServer;
            if ( this.$serverInstructions[ selected ] ) {
                this.$serverInstructions[ selected ].hide();
            }

        },

        showServerInstructions: function( server ) {
            if ( typeof this.$serverInstructions[ server ] != 'undefined' ) {
                this.$serverInstructions[ server ].show();
            }

            if ( 'apache' == server ) {
                $( '#enable-cache-wrap').show();
            }
            else {
                $( '#enable-cache-wrap').hide();
            }
        },

        reloadSnippets: function() {
            var self = this;
            var stop = false;
            for ( var i in self.$snippets ) {
                if ( self.$snippets.hasOwnProperty( i ) ) {
                    $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'wphb_ajax',
                            wphb_nonce: self.strings.setExpirationNonce,
                            nonce_name: 'wphb-set-expiration',
                            module: self.module,
                            module_action: 'reload_snippet',
                            data: {
                                type: i
                            }
                        }
                    }).success( function( result ) {
                        if ( result.success && ! stop ) {
                            self.$snippets[result.data.type].text( result.data.code );

                            // Make sure that we only do things when server displayed is the processed one
                            if ( result.data.type != self.selectedServer ) {
                                return;
                            }

                            if ( result.data.type == 'apache' && result.data.updatedFile ) {
                                $('#wphb-notice-code-snippet-htaccess-updated').show();
                                location.href = self.strings.recheckURL + '&caching-updated=true';
                            }
                            else if ( result.data.type == 'apache' && self.strings.cacheEnabled && ! result.data.updatedFile ) {
                                $('#wphb-notice-code-snippet-htaccess-error').show();
                                location.href = self.strings.htaccessErrorURL;
                            }
                            else {
                                $('#wphb-notice-code-snippet-updated').show();
                                location.href = self.strings.recheckURL + '&caching-updated=true';
                            }

                            //self.$spinner.css( 'visibility', 'hidden' );
                        }
                        else {
                        }
                    });

                }
            }
        }
    };

    WPHB_Admin.dashboard = {
        module: 'dashboard',

        init: function() {
            var self = this;

            if ( wphbDashboardStrings ) {
                self.strings = wphbDashboardStrings;
            }

            $( '.box-dashboard-welcome .close').click( function() {
                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'wphb_ajax',
                        wphb_nonce: self.strings.removeWelcomeBoxNonce,
                        nonce_name: 'wphb-remove-welcome-box',
                        module: self.module,
                        module_action: 'remove_welcome_box'
                    }
                });
            });

            $('#wphb-activate-minification').change( function() {
                var value = $(this).val();
                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'wphb_ajax',
                        wphb_nonce: self.strings.activateMinificationNonce,
                        nonce_name: 'wphb-activate-minification',
                        module: self.module,
                        module_action: 'activate_network_minification',
                        data: {
                            value: value
                        }
                    }
                })
                .done( function() {
                    var notice = $('#wphb-notice-minification-settings-updated');
                    notice.slideDown();
                    setTimeout( function() {
                        notice.slideUp();
                    }, 5000 );
                });
            });

            $('.wphb-performance-report-item').click( function( e ) {
                var url = $(this).data( 'performance-url' );
                if ( url ) {
                    location.href = url;
                }
            });
            return this;
        }
    };

    WPHB_Admin.uptime = {
        module: 'uptime',
        $dataRangeSelector: null,
        chartData: null,
        timer:null,
        $spinner: null,
        init: function() {
            this.$spinner = $('.spinner');
            this.strings = wphbUptimeStrings;
            this.$dataRangeSelector = $( '#wphb-uptime-data-range' );
            this.chartData = $('#uptime-chart-json').val();
            this.$disableUptime = $('#wphb-disable-uptime');

            this.$dataRangeSelector.change( function() {
                window.location.href = $(this).find( ':selected' ).data( 'url' );
            });

            var self = this;
            this.$disableUptime.change( function() {
                self.$spinner.css( 'visibility', 'visible' );
                var value = $(this).is(':checked');
                if ( value && self.timer ) {
                    clearTimeout( self.timer );
                    self.$spinner.css( 'visibility', 'hidden' );
                }
                else {
                    // you have 3 seconds to change your mind
                    self.timer = setTimeout( function() {
                        location.href = self.strings.disableUptimeURL;
                    }, 3000 );
                }

                return;
            });

            this.drawChart();

            /* Re-check Uptime status */
            $('#uptime-re-check-status').on( 'click', function(e){
                e.preventDefault();
                location.reload();
            });
        },

        drawChart: function() {
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Day');
            data.addColumn('number', 'Response Time (ms)');

            var chart_array = JSON.parse( this.chartData );
            for (var i = 0; i < chart_array.length; i++) {
                chart_array[i][0] = new Date( chart_array[i][0] );
            }

            data.addRows(chart_array);

            var options = {
                legend: { position: 'none' },
                vAxis: { format: 'short' },
                hAxis: { textPosition: 'none' },
                tooltip: { isHtml: true },
                series: {
                    0: {axis: 'Resp'}
                },
                axes: {
                    y: {
                        Resp: {label: 'Response Time (ms)'}
                    }
                }
            };

            var chart = new google.charts.Line(document.getElementById("uptime-chart"));
            chart.draw(data, options);

            $(window).resize(function(){
              chart.draw(data, options);
            });
        }
    };

    WPHB_Admin.utils = {

        membershipModal: {
            open: function() {
                $( '#wphb-upgrade-membership-modal-link').trigger( 'click' );
            }
        }
    };

    WPHB_Admin.notices = {

        init: function() {
            $( 'a.wphb-dismiss').click( function( e ) {
                e.preventDefault();
                var id = $(this).data( 'id' );
                var nonce = $(this).data( 'nonce' );

                $(this).parent( '.error' ).hide();
            });
        }
    };

    window.WPHB_Admin = WPHB_Admin;

}( jQuery ) );

jQuery(document).ready( function() {
    WPHB_Admin.init();
});
