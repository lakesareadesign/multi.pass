<?php
/**
 * Class Opt_In_Meta_Design
 *
 *
 * @property int $form_location
 * @property array $elements
 * @property string $image_location
 * @property string $image_style
 * @property string $image_src
 * @property Opt_In_Meta_Design_Colors $colors
 * @property Opt_In_Meta_Design_Borders $borders
 * @property string $opening_animation
 * @property string $closing_animation
 * @property string $css
 * @property string $page_redirect_url
 */
class Opt_In_Meta_Design extends Hustle_Meta{

    var $defaults = array(
        "success_message" => "Congratulations! You have been subscribed to {name}",
        "form_location" => 0,
        "elements" => array('image'),
        "image_location" => "left",
        "image_style" => "cover",
        "image_src" => "",
        "colors" => array(),
        "borders" => array(),
        "opening_animation" => "",
        "closing_animation" => "",
        "css" => "",
        "input_icons" => "animated_icon", // possible values no_icon|none_animated_icon|animated_icon,
        "on_submit" => "success_message", // success_message|page_redirect
        "on_submit_page_id" =>  ""
    );

    function __construct( array $data, Hustle_Model $model  ){
        parent::__construct( $data, $model );
        if( isset( $this->data['image_src'] ) )
            $this->data['image_src'] = set_url_scheme( $this->data['image_src'], is_ssl() ? "https" : "http" );
    }
    /**
     * @return Opt_In_Meta_Design_Colors
     */
    function get_colors(){
        return new Opt_In_Meta_Design_Colors( isset( $this->data['colors'] ) ? (array)  $this->data['colors'] : array() , $this->model );
    }

    /**
     * @return Opt_In_Meta_Design_Borders
     */
    function get_borders(){
        return new Opt_In_Meta_Design_Borders( isset( $this->data['borders'] ) ? (array)  $this->data['borders'] : array() , $this->model );
    }

    function get_page_redirect_url(){
        if( isset( $this->data['on_submit'],  $this->data['on_submit_page_id'] ) && $this->data['on_submit'] == "page_redirect"  )
            return get_permalink( $this->data['on_submit_page_id']  );

        return "";
    }

    function to_array(){
       return array_merge( wp_parse_args( $this->data,  $this->defaults ), array( "page_redirect_url" => $this->get_page_redirect_url() ) );
    }
}