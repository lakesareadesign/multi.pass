<?php


class Hustle_Dashboard_Data
{
    var $optins = array();
    var $custom_contents = array();
    var $data_exists = false;

    var $active_modules = 0;
    var $active_optin_modules = array();
    var $inactive_optin_modules = array();
    var $active_cc_modules = array();
    var $inactive_cc_modules = array();
    var $all_modules = 0;

    var $conversions_today = 0;
    var $most_converted_optin = '-';

    var $has_optins = false;
    var $has_custom_content = false;
    var $has_social_sharing = true; // set to true just to avoid showing it in the dashboard as this is not a feature for 2.0
    var $has_social_rewards = true; // set to true just to avoid showing it in the dashboard as this is not a feature for 2.0

    var $optins_conversions = array();

    var $color = 0;
    var $types = array();
    var  $colors = array(
        "#FFDB00",
        "#00EAFF",
        "#AA00FF",
        "#FF7F00",
        "#BFFF00",
        "#0095FF",
        "#FF00AA",
        "#FFD400",
        "#EDB9B9",
        "#B9D7ED",
        "#E7E9B9",
        "#DCB9ED"
    );

    var  $conversion_data;

    function __construct()
    {
        $this->_prepare_data();
        $this->has_optins = $this->optins !== array();
    }

    private function _prepare_data(){
        $opt_col_instance = Opt_In_Collection::instance();
        $cc_col_instance = Hustle_Custom_Content_Collection::instance();

        $this->optins = $opt_col_instance->get_all_optins( null, array() );
        $this->all_modules = count( $this->optins );

        $this->custom_contents = $cc_col_instance->get_all( null );
        $this->all_modules += count( $this->custom_contents );

        $this->types = $types = array(
            'after_content' => __('AFTER CONTENT', Opt_In::TEXT_DOMAIN),
            'popup' => __('POP UP', Opt_In::TEXT_DOMAIN),
            'slide_in' => __('SLIDE IN', Opt_In::TEXT_DOMAIN),
            'shortcode' => __("Shortcode", Opt_In::TEXT_DOMAIN),
            'widget' => __("Widget", Opt_In::TEXT_DOMAIN)
        );


        foreach ( array_merge( $this->optins, $this->custom_contents ) as $key => $optin ) {

            if( $optin->active ){
                $this->active_modules++;
				if ( $optin->get_module_type() === "custom_content" ) {
					array_push($this->active_cc_modules, $optin);
				} else {
					array_push($this->active_optin_modules, $optin);
				}
            } else {
				if ( $optin->get_module_type() === "custom_content" ) {
					array_push($this->inactive_cc_modules, $optin);
				} else {
					array_push($this->inactive_optin_modules, $optin);
				}
                continue;
            }

            foreach ( $types as $type_key => $type ) {
                if( !$optin->has_type( $type_key ) ) continue; // make sure this module has the type

                $type_stats = $optin->get_module_type() === "custom_content" ? $optin->get_stats($type_key) : $optin->{$type_key};

                if ( !$this->data_exists && intval( $type_stats->views_count ) > 0 ) {
                    $this->data_exists = true;
                }



                $conversion_array = $type_stats->conversion_data;

                if( $this->color >= count( $this->colors ) ) $this->color = 0;

                if( !isset( $this->optins_conversions[ $optin->optin_name ] ) ) {
                    $this->optins_conversions[ $optin->optin_name ] = array(
                        'week' => 0,
                        'month' => 0,
                        'all' => 0,
                        'total_views' => 0,
                        'rate' => 0.0,
                        'chart_data' => array(),
                        'color' => $this->colors[$this->color++],
                        "module_type" => $optin->module_type
                    );
                }

                foreach ( $conversion_array as $item ) {

                    $conversion_data = json_decode( $item->meta_value );

                    // Check if this particular conversion log is from today
                    if( date('Ymd') == date( 'Ymd', $conversion_data->date ) ) {
                        $this->conversions_today++;
                        // No need to do more date calculations, we know its from the current week and month too
                        $this->optins_conversions[ $optin->optin_name ]['week']++;
                        $this->optins_conversions[ $optin->optin_name ]['month']++;
                    } else if( date("W") == date("W", $conversion_data->date ) ) {
                        $this->optins_conversions[ $optin->optin_name ]['week']++;
                    } else if( date("m") == date("m", $conversion_data->date ) ) {
						$this->optins_conversions[ $optin->optin_name ]['month']++;
                    }

					// includes current month and the previous month
                    if( date("m") == date("m", $conversion_data->date )
						|| date("m",strtotime(date("m")."-1 month")) == date("m", $conversion_data->date )
					) {
                        $day_timestamp = floor( $conversion_data->date / 86400 ) * 86400; // to set all conversions of the same day in a single timestamp
                        $day_timestamp *= 1000; // chartjs uses millisecond timestamp
                        $key = false;
                        for ($i = 0; $i < count($this->optins_conversions[$optin->optin_name]['chart_data']); $i++ ) {
                            if( $this->optins_conversions[$optin->optin_name]['chart_data'][$i]['x'] == $day_timestamp ) {
                                $key = $i;
                                break;
                            }
                        }
                        if( $key === false ) {
                            array_push( $this->optins_conversions[ $optin->optin_name ]['chart_data'], array( 'x' => $day_timestamp, 'y' => 1 ) );
                        } else {
                            $this->optins_conversions[ $optin->optin_name ]['chart_data'][$key]['y']++;
                        }

                    }

                    $this->optins_conversions[ $optin->optin_name ]['all']++;

                }

				$chart_data = $this->optins_conversions[ $optin->optin_name ]['chart_data'];
				if ( count($chart_data) ) {
					$new_chart_data = array();
					$has_previous = false;
					$has_today = false;
					$today_timestamp = strtotime(date("Y-m-d")) * 1000;
					$previous_month_timestamp = strtotime( date("Y-m-d") . " -1 month" ) * 1000;
					foreach( $chart_data as $data ){
						if ( $data["x"] == $today_timestamp ) {
							$has_today = true;
						}
						if ( $data["x"] == $previous_month_timestamp ) {
							$has_previous = true;
						}
					}
					if ( !$has_today ) {
						$dummy_today = array( "x" => $today_timestamp, "y" => 0 );
						array_push($this->optins_conversions[ $optin->optin_name ]['chart_data'], $dummy_today );
					}
					if ( !$has_previous ) {
						$dummy_previous = array( "x" => $previous_month_timestamp, "y" => 0 );
						array_unshift($this->optins_conversions[ $optin->optin_name ]['chart_data'], $dummy_previous );
					}
				}


                $this->optins_conversions[ $optin->optin_name ]['total_views'] += $type_stats->views_count;

            }

            $this->optins_conversions[ $optin->optin_name ]['rate'] = $this->optins_conversions[ $optin->optin_name ]['total_views'] ? round( ( $this->optins_conversions[ $optin->optin_name ]['all'] / $this->optins_conversions[ $optin->optin_name ]['total_views'] ) * 100, 2 ) : 0;

        }

        $best_optins = array();
        $amount = 1;
        do {
            $most_conversions = -1; // setting this to -1 to include optins with no conversion
			$most_views = -1;
            $to_move = null;
            foreach ($this->optins_conversions as $optin_name => $conversions) {
                if ($conversions['all'] > $most_conversions) {
                    $most_conversions = $conversions['all'];
                    $to_move = $optin_name;
                } elseif ( $conversions['all'] == $most_conversions ) {
					// if same conversion value, let's battle this one with views
					if ( $conversions['total_views'] > $most_views ) {
						$most_views = $conversions['total_views'];
						$to_move = $optin_name;
					}
				}

            }
            if( $to_move != null ) {
                $best_optins[ $to_move ] = $this->optins_conversions[ $to_move ];
                unset($this->optins_conversions[ $to_move ]);
                if( $this->most_converted_optin == '-' ) $this->most_converted_optin = $to_move;
                $amount++;
            }
        }while( $amount <= 5 && $to_move != null );

        $this->conversion_data = $best_optins;
    }
}