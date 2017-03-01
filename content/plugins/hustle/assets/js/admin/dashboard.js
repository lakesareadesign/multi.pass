Hustle.define("Dashboard.View", function($, doc, win){
    "use strict";

    if( pagenow !== 'toplevel_page_inc_optins' || _.isTrue( optin_vars.is_free ) ) return;

    var dashboard_view = Backbone.View.extend({
        el: ".wph-dashboard",
        conversions_chart: null,
        chart_data: null,
        chart_options : null,
        empty_chart: true,
        default_dataset_options: {
                fill: false,
                cubicInterpolationMode: 'monotone',
                borderCapStyle: 'butt',
                borderDash: [],
                borderWidth: 1,
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBackgroundColor: "#fff",
                pointBorderWidth: 3,
                pointHoverRadius: 5,
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                spanGaps: false,
                cubicInterpolationMode: 'monotone'
        },
        events: {
            "click .wph-icon.i-close": "close"
        },
        initialize: function( opts ){
            var datasets = [];
            for (var i = 0; i < hustle_vars.conversion_chart_data.length; i++){
                if( hustle_vars.conversion_chart_data[i].data.length >= 1 )
                    this.empty_chart = false;
                var newds = {
                    label: hustle_vars.conversion_chart_data[i].module_name,
                    data: hustle_vars.conversion_chart_data[i].data,
                    backgroundColor: hustle_vars.conversion_chart_data[i].color,
                    borderColor: hustle_vars.conversion_chart_data[i].color,
                    pointBorderColor: hustle_vars.conversion_chart_data[i].color,
                    pointHoverBackgroundColor: hustle_vars.conversion_chart_data[i].color
                };
                datasets.push( $.extend(true, {}, this.default_dataset_options, newds) );
            }
            this.chart_data = {
                datasets: datasets
            };
            this.chart_options = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display:false
                },
                scales: {
                    xAxes:[{
                        type: 'time',
                        time: {
                            unit: 'week',
                            unitStepSize: 3,
							tooltipFormat: 'D MMM',
							displayFormat: 'D MMM',
							min: hustle_vars.previous_month,
							max: hustle_vars.today
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes:[{
                        ticks: {
                            min: 0
                        },
                        gridLines: {
                            display: false
                        }

                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data){
                            var returnArray = [];
							returnArray.push( tooltipItem.yLabel + " Conv" );
                            return returnArray;
                        }
                    },
					cornerRadius: 3,
					displayColors: false,
					backgroundColor: "rgba(11,47,63,1)",
                },
				hover: {
					mode: 'nearest',
					intersect: true
				}

            };
            return this.render();
        },
        render: function(){
            $(".tabs-header li label").on('click', this.toggle_overview);
            $(".can-close .wph-icon.i-close").on('click', this.close);
            
            var canvas = $("#conversions_chart");
            if( !canvas.length ) return;

            if(!this.empty_chart){
				// setting canvas height
				var $module_table = canvas.closest('#wph-module-stats').find('table.wph-table.wph-module--stats'),
					module_table_height = $module_table.outerHeight();
				;
				if ( module_table_height > 230 ) {
					canvas.attr('height', module_table_height);
				} else {
					canvas.attr('height', 230);
				}
				
				// sort the dates properly
                for( var key in this.chart_data.datasets ) {
					if ( this.chart_data.datasets[key].data ) {
                        this.chart_data.datasets[key].data = _.sortBy(this.chart_data.datasets[key].data, "x");
					}
                }
				
				// rendering the chart
                this.conversions_chart = new Chart(canvas, {
					type: 'line',
                    data: this.chart_data,
                    options: this.chart_options
                });
				
            } else {
                canvas.parent()
					.css('height', '100%')
					.css('width', '100%')
					.css('display', 'table')
				;
				
				var $no_data = $('<div class="graph-no-data">' + optin_vars.messages.dashboard.not_enough_data + '</div>');
				$no_data
					.css('display', 'table-cell')
					.css('text-align', 'center')
					.css('vertical-align', 'middle')
				;
				canvas.replaceWith($no_data);
            }

        },
		close: function(e){
			e.preventDefault();
			// var $parent_section = $(e.target).closest('.content-box').remove();
			var $parent_container = $(e.target).closest('.row'),
				$parent_section = $(e.target).closest('#wph-welcome'),
				nonce = $parent_section.data("nonce")
			;
			$parent_container.slideToggle(300, function(){
				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						action: "persist_new_welcome_close",
						_ajax_nonce: nonce
					},
					complete: function(d){
						$parent_container.remove();
					}
				});
			});
		},
		toggle_overview: function(e){
			e.preventDefault();
			var $this = $(e.target),
				value = $this.find('input').val(),
				$target = $("#wph-"+ value +"-overview"),
				$li = $this.parent();
			
			$(".wph-modules-overview").not($target).removeClass("current");
			$target.addClass("current");
			$(".tabs-header li").not($li).removeClass("current");
			$li.addClass("current");
		}
    });

    new dashboard_view;
});