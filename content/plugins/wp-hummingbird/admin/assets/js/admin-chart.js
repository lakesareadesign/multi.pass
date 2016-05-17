( function( $ ) {
    WPHB_Admin.chart = {
        module: 'chart',

        cache: [],

        google: null,

        init: function() {
            var self = this;

            if ( wphbMinificationStrings )
                self.strings = wphbMinificationStrings;

            self.google = google;
            self.google.load("visualization", "1.1", {
                packages:["sankey"],
                callback: function() {
                     
                }
            });

            $( '.wphb-chart-selector').change( function() {
                var value = $(this).val();
                var type = $(this).data('type');
                var spinner = $('#output-spinner-' + type );

                spinner.css( 'visibility', 'visible' );
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
                            self.reDraw( data.data.chartData, data.data.sourcesNumber, type );
                            spinner.css( 'visibility', 'hidden' );
                        }

                    });

            });

            return this;
        },

        reDraw: function( chartData, sourcesNumber, type ) {
            var element = $('#sankey_multiple_' + type );
            if ( element.length ) {
                element.css( 'height', 50 * sourcesNumber[ type ] );
                this.draw( chartData[ type ], 'sankey_multiple_' + type );
            }

        },

        draw: function( chartData, container ) {

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
            var chart = new this.google.visualization.Sankey(document.getElementById(container));
            chart.draw(data, options);

            $(window).resize(function(){
                chart.draw(data, options);
            });
        }



    };
}(jQuery));
