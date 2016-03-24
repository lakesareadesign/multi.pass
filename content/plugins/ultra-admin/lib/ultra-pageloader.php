<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */
?>
<?php

function ultra_page_loader()
{
    global $ultra_css_ver;

    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       


    //print_r($ultraadmin);


    if(isset($ultraadmin['enable-pageloader']) && $ultraadmin['enable-pageloader'] == "1" && $ultraadmin['enable-pageloader'] != "0" && $ultraadmin['enable-pageloader']){

        $url = plugins_url('/', __FILE__).'../js/ultra-pace.min.js';
        wp_deregister_script('ultra-pace-js');
        wp_register_script('ultra-pace-js', $url);
        wp_enqueue_script('ultra-pace-js');

        $url = plugins_url('/', __FILE__).'../js/ultra-pace-script.js';
        wp_deregister_script('ultra-pace-script-js');
        wp_register_script('ultra-pace-script-js', $url);
        wp_enqueue_script('ultra-pace-script-js');

        $url = plugins_url('/', __FILE__).'../css/ultra-pace.css';
        wp_deregister_style('ultra-pace-css', $url);
        wp_register_style('ultra-pace-css', $url);
        wp_enqueue_style('ultra-pace-css');
    }

}

?>