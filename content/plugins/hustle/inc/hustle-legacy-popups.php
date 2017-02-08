<?php

/**
 * Class Hustle_Legacy_Popups
 *
 *
 */
class Hustle_Legacy_Popups
{
    /**
     * @var $_query WP_Query
     */
    private $_query;

    public function __construct()
    {

    }

    /**
     * Returns array of all legacy popups
     *
     * @param int $posts_per_page
     * @return array
     */
    public function get_all( $posts_per_page = -1 ){
        $this->_query = new WP_Query(array(
            "post_type" => "inc_popup",
            "posts_per_page" => $posts_per_page,
            'meta_query' => array(
                array(
                    'key'     => 'hustle_migrated',
                    'compare' => 'NOT EXISTS',
                ),
            )
        ));

        return $this->_query->posts;
    }

    /**
     * @return WP_Query
     */
    function get_query(){
        return $this->_query;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_content( WP_Post $popup ){
        return $popup->post_content;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_title( WP_Post $popup ){
        return $popup->post_title;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_heading( WP_Post $popup ){
        return get_post_meta( $popup->ID, 'po_title', true );
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_subheading( WP_Post $popup ){
        return get_post_meta( $popup->ID, 'po_subtitle', true );
    }

    /**
     * @param $id
     * @return array|null|WP_Post
     */
    function get( $id ){
        return get_post( $id );
    }

    /**
     * Returns array containing design settings of the popup
     *
     * @param WP_Post $popup
     * @return array
     */
    static function get_design_data( WP_Post $popup  ){
        $popup_id = $popup->ID;
        return array(
            "border" => true,
            "border_radius" => get_post_meta( $popup_id, "po_round_corners", true ) ? 5 : 0,
            "image" => get_post_meta( $popup_id, "po_image", true ),
            "hide_image_on_mobile" => !get_post_meta( $popup_id, "po_image_mobile", true ),
            "image_position" => get_post_meta( $popup_id, "po_image_pos", true ),
            "cta_label" => get_post_meta( $popup_id, "po_cta_label", true ),
            "cta_url" => get_post_meta( $popup_id, "po_cta_link", true ),
            "cta_target" => get_post_meta( $popup_id, "po_cta_target", true )
        );
    }

    /**
     * Retuns array containing the display/behaviour/rules/triggers for the popup
     *
     * @param WP_Post $popup
     * @return array
     */
    static function get_settings_data( WP_Post $popup ){
        $popup_id = $popup->ID;

        return array(
            "enabled" =>  $popup->post_status === "publish",
            "conditions" =>  self::_get_conditions_settings( $popup ),
            "triggers" =>  self::_get_trigger_settings( $popup ),
            "animation_in" =>  get_post_meta( $popup_id, "po_animation_in", true ),
            "animation_out" =>  get_post_meta( $popup_id, "po_animation_out", true ),
            "add_never_see_link" =>  get_post_meta( $popup_id, "po_can_hide", true ),
            "close_btn_as_never_see" =>  get_post_meta( $popup_id, "po_close_hides", true ),
            "expiration_days" =>  get_post_meta( $popup_id, "po_hide_expire", true )
        );
    }

    /**
     * Returns popup trigger settings with keys compatible with Hustle  Custom Content triggers
     *
     * @param WP_Post $popup
     * @return array
     */
    private static function _get_trigger_settings( WP_Post $popup ){
        $popup_id = $popup->ID;
        $saved_settings = (array) maybe_unserialize( get_post_meta( $popup_id, "po_display_data", true ) );
        $triggers = wp_parse_args( array(
            "trigger" => get_post_meta( $popup_id, "po_display", true ),
            "on_time" => isset( $saved_settings['delay'] ) && $saved_settings['delay'] == "0" ? "immediately" : "time",
            "on_time_delay" => (int) isset( $saved_settings['delay'] ) ? $saved_settings['delay'] : 0,
            "on_time_unit" => isset( $saved_settings['delay'] ) && $saved_settings['delay'] === "s" ? "seconds" : "minutes",
            "on_scroll" => "scrolled",
            "on_scroll_page_percent" => isset( $saved_settings['scroll'] ) ? $saved_settings['scroll'] : 20,
            "on_click_element" => isset( $saved_settings['anchor'] ) ? $saved_settings['anchor'] : ""
        ), Hustle_Custom_Content_Meta::$triggers_default );

        if( $triggers['trigger'] == "delay" )
            $triggers['trigger'] = "time";

        if( $triggers['trigger'] == "anchor" )
            $triggers['trigger'] = "click";


        return $triggers;
    }

    private static function _get_conditions_settings( WP_Post $popup ){

        $popup_id = $popup->ID;
        $rules = (array) maybe_unserialize( get_post_meta( $popup_id, "po_rule", true ) );
        $rules_data = (array) maybe_unserialize( get_post_meta( $popup_id, "po_rule_data", true ) );
        $map = array(
            "login" => "visitor_logged_in",
            "no_login" => "visitor_not_logged_in",
            "count" => "shown_less_than",
            "mobile" => "only_on_mobile",
            "no_mobile" => "not_on_mobile",
            "referrer" => "from_specific_ref",
            "no_internal" => "not_from_internal_link",
            "searchengine" => "from_search_engine",
//            "no_prosite" => ""
            "url" => "on_specific_url",
            "comment" => "visitor_has_commented",
            "country" => "in_a_country",
            "no_referrer" => "not_from_specific_ref",
            "no_url" => "not_on_specific_url",
            "no_comment" => "visitor_has_never_commented",
            "no_country" => "not_in_a_country"
        );

        foreach( $rules as $rule_name ){
            $conditions[ $map[ $rule_name ] ] = isset( $rules_data[ $rule_name ] ) ? $rules_data[ $rule_name ]  : true;
        }

        return $conditions;
    }
}