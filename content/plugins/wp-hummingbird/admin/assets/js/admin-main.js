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
            };
            $(function(){ setTimeout(updatePerformanceResultsGraphs, 500); });

        },
        initModule: function( module ) {
            if ( this.hasOwnProperty( module ) ) {
                this.modules[ module ] = this[ module ].init();
                return this.modules[ module ];
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
    

    WPHB_Admin.utils = {

        membershipModal: {
            open: function() {
                $( '#wphb-upgrade-membership-modal-link').trigger( 'click' );
            }
        },

        post: function( data, module ) {
            data.action = 'wphb_ajax';
            data.module = module;
            return $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: data
            });
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