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

/* 
 * Function to select the CSS theme file based on option panel settings
 * Also it can regenerate custom CSS file and enqueue 
 *  
 */


function ultra_core(){

    global $ultra_css_ver;
    global $ultraadmin;

    $ultraadmin = ultraadmin_network($ultraadmin);

    $globalmsg = "";

    $login_screen = "custom"; 
    if(isset($ultraadmin['enable-login']) && $ultraadmin['enable-login'] != "1" && $ultraadmin['enable-login'] == "0" && !$ultraadmin['enable-login']){ 
        $login_screen = "default"; 
    }


    /*----------- Check Permissions - Start ---------------*/

    $get_admintheme_page = ultra_get_option("ultraadmin_admintheme_page","enable");
    $get_logintheme_page = ultra_get_option("ultraadmin_logintheme_page","enable");

    $adminside = true;
    if(isset($get_admintheme_page) && $get_admintheme_page == "disable"){
        $adminside = false;
    }

    $loginside = true;
    if(isset($get_logintheme_page) && $get_logintheme_page == "disable"){
        $loginside = false;
    }

    //echo $adminside; echo $loginside;

    /*----------- Check Permissions - End---------------*/


        if($ultra_css_ver != ""){

            /* Add Options*/
            ultra_add_option("ultraadmin_menuorder", "");
            ultra_add_option("ultraadmin_submenuorder", "");
            ultra_add_option("ultraadmin_menurename", "");
            ultra_add_option("ultraadmin_submenurename", "");
            ultra_add_option("ultraadmin_menudisable", "");
            ultra_add_option("ultraadmin_submenudisable", "");

            add_action('admin_enqueue_scripts', 'ultra_disable_menu', 1);
            if($adminside){ 
                add_action('admin_enqueue_scripts', 'ultra_scripts', 1);
            }

            add_action('admin_enqueue_scripts', 'ultra_logo', 99);
            add_action('admin_enqueue_scripts', 'ultra_logo_url', 99);

            add_action('admin_enqueue_scripts', 'ultra_admintopbar', 1);
            add_action('admin_enqueue_scripts', 'ultra_admintopbar_links', 1);
            add_action('wp_enqueue_scripts', 'ultra_admintopbar_links', 1);
            add_action('wp_enqueue_scripts', 'ultra_wptopbar', 1);
            add_action('wp_before_admin_bar_render', 'ultra_topbar_logout_link' );
            add_action('wp_before_admin_bar_render', 'ultra_topbar_menuids' );
            add_action('admin_bar_menu', 'ultra_topbar_account_menu', 11);

            if($adminside){ 
                add_action('admin_enqueue_scripts', 'ultra_page_loader', 1);
                add_action('admin_enqueue_scripts', 'ultra_fonts', 99);
                add_action('admin_enqueue_scripts', 'ultra_admin_css', 99);
            }

            add_action('admin_enqueue_scripts', 'ultra_favicon', 99);
            add_action('admin_enqueue_scripts', 'ultra_custom_css', 99);

            add_action('admin_enqueue_scripts', 'ultra_extra_css', 99);

            /*add_action('admin_enqueue_scripts', 'ultraadmin_access', 99);*/
            add_filter('admin_footer_text', 'ultra_footer_admin');

            if($adminside){ 
                remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
            }

            if($login_screen == "custom" && $loginside)
            {
                add_action('login_enqueue_scripts', 'ultra_custom_login',99);
                add_filter( 'login_headerurl', 'ultra_custom_loginlogo_url' );
                add_action('login_enqueue_scripts', 'ultra_login_options',99);
            }

            if($adminside){ 
               ultra_dynamic_css_settings();
            }

            if($adminside){ 
                add_action('admin_menu', 'ultra_screen_tabs');
            }

        } else {
            echo "<script type='text/javascript'>console.log('Ultra WP Admin: WordPress Version Not Supported Yet!');</script>";
        }

}


function ultraadmin_network($default){

        if(is_multisite() && ultra_network_active()){
                    global $blog_id;
                    $current_blog_id = $blog_id;
                    switch_to_blog(1);
                    $site_specific_ultraadmin = get_option("ultra_demo");
                    $ultraadmin = $site_specific_ultraadmin;
                    switch_to_blog($current_blog_id);
        } else {
            $ultraadmin = $default;
        }

        return $ultraadmin;
}

function ultra_dynamic_css_settings() {

    global $ultra_css_ver;

    	global $ultraadmin;
    	//echo "<pre>"; print_r($ultraadmin); echo "</pre>"; 

    //$globalmsg = "TYPE: ".$ultraadmin['dynamic_css_type'];
    //echo "<div style='position:absolute;top:50px;right:50px;background: #333333;padding:5px;color:#ffffff;z-index:99999;'>".$globalmsg."</div>";

        $csstype = ultra_dynamic_css_type();

        //echo "csstype: ".$csstype;

        if (isset($csstype) && $csstype != "custom") {
    	    // enqueue default/ inbuilt CSS styles
    		add_action('admin_enqueue_scripts', 'ultra_default_css_colors', 99);

        } else {
        	
        	// load custom CSS style generated dynamically

    		$css_dir = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver);

        // if Not multisite
        if(!is_multisite()){
            if (is_writable($css_dir)) {
                //write the file if isn't there
                if (!file_exists($css_dir . '/ultra-colors.css')) {
                    ultra_regenerate_dynamic_css_file();
                }
    			add_action('admin_enqueue_scripts', 'ultra_dynamic_enqueue_style', 99);
            } else {
    			add_action('admin_head', 'ultra_wp_head_css');
            }

        } else if(is_multisite() && ultra_network_active()) {
            // multisite and network active
            if (is_writable($css_dir)) {

                global $wpdb;
                global $blog_id;
                $current_blog_id = $blog_id;

                $current_site = 1;
                switch_to_blog(1);

                //write the file if isn't there
                if (!file_exists($css_dir . '/ultra-colors-site-'.$current_site.'.css')) {

                    $site_specific_ultraadmin = get_option("ultra_demo");
                    $filename = 'site-'.$current_site;
                    //print_r($site_specific_ultraadmin);
                    ultra_regenerate_dynamic_css_file($site_specific_ultraadmin,$filename);
                }
                add_action('admin_enqueue_scripts', 'ultra_dynamic_enqueue_style', 99);                
                
                switch_to_blog($current_blog_id);

            } else {
                add_action('admin_head', 'ultra_wp_head_css');
            }

        }
        else 
        {
            // multisite and not network active

            // regenerate css file for the individual site only and enqueue it.
            if (is_writable($css_dir)) {

                global $wpdb;
                $current_site = $wpdb->blogid;

                //write the file if isn't there
                if (!file_exists($css_dir . '/ultra-colors-site-'.$current_site.'.css')) {

                    $site_specific_ultraadmin = get_option("ultra_demo");
                    $filename = 'site-'.$current_site;
                    //print_r($site_specific_ultraadmin);
                    ultra_regenerate_dynamic_css_file($site_specific_ultraadmin,$filename);
                }
                add_action('admin_enqueue_scripts', 'ultra_dynamic_enqueue_style', 99);
            } else {
                add_action('admin_head', 'ultra_wp_head_css');
            }

        }

        }
   
}

function ultra_framework_settings_saved(){

    global $ultra_css_ver;
    global $ultraadmin;

            $css_dir = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver);

        // if Not multisite
        if(!is_multisite()){

            if (is_writable($css_dir)) {
                    ultra_regenerate_dynamic_css_file();
            } 

        } else if(is_multisite() && ultra_network_active()) {
                global $wpdb;
                $current_blog_id = $wpdb->blogid;
                $current_site = 1;
                switch_to_blog(1);

                    $site_specific_ultraadmin = get_option("ultra_demo");
                    $filename = 'site-'.$current_site;
                    //print_r($site_specific_ultraadmin);
                    ultra_regenerate_dynamic_css_file($site_specific_ultraadmin,$filename);
                switch_to_blog($current_blog_id);

        } else {
            
        // multisite
            // regenerate css file for the individual site only

            if (is_writable($css_dir)) {

                global $wpdb;
                $current_site = $wpdb->blogid;

                    $site_specific_ultraadmin = get_option("ultra_demo");
                    $filename = 'site-'.$current_site;
                    //print_r($site_specific_ultraadmin);
                    ultra_regenerate_dynamic_css_file($site_specific_ultraadmin,$filename);
            }


        }

}



function ultra_scripts(){
    global $ultraadmin;
        $url = plugins_url('/', __FILE__).'../js/ultra-scripts.js';
        wp_deregister_script('ultra-scripts-js');
        wp_register_script('ultra-scripts-js', $url);
        wp_enqueue_script('ultra-scripts-js');

        $url = plugins_url('/', __FILE__).'../js/ultra-smoothscroll.min.js';
        wp_deregister_script('ultra-smoothscroll-js');
        wp_register_script('ultra-smoothscroll-js', $url);
        wp_enqueue_script('ultra-smoothscroll-js');

    global $wp_version;
    $plug = trim(get_current_screen()->id);
    //echo "<div style='float:right;'>".$plug."</div>"; 
    
    if (isset($plug) && $plug == "ultra-admin-addon_page_ultra_menumng_settings"){

        $url = plugins_url('/', __FILE__).'../css/jquery-ui/minified/jquery-ui.min.css';
        wp_deregister_style('ultra-jqueryui');
        wp_register_style('ultra-jqueryui', $url);
        wp_enqueue_style('ultra-jqueryui');

        $url = plugins_url('/', __FILE__).'../js/ultra-jquery.ui.elements.js';
        wp_deregister_script('ultra-jqueryui');
        wp_register_script('ultra-jqueryui', $url);
        wp_enqueue_script('ultra-jqueryui');
    }
        wp_localize_script('ultra-scripts-js', 'ultra_vars', array(
            'ultra_nonce' => wp_create_nonce('ultra-nonce')
                )
        );




    if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/ultra-settings-panel-css.css')) {
        wp_deregister_style('ultra-settings-panel-css');
        wp_register_style('ultra-settings-panel-css', plugins_url('/', __FILE__) . "../demo-settings/ultra-settings-panel-css.css");
        wp_enqueue_style('ultra-settings-panel-css');
    }
    
    if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/ultra-settings-panel-js.js')) {
        wp_deregister_script('ultra-settings-panel-js');
        wp_register_script('ultra-settings-panel-js', plugins_url('/', __FILE__) . "../demo-settings/ultra-settings-panel-js.js");
        wp_enqueue_script('ultra-settings-panel-js');
    }






}



function ultra_admin_css()
{
    global $ultra_css_ver;

    $url = plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/ultra-admin.css';
    wp_deregister_style('ultra-admin', $url);
    wp_register_style('ultra-admin', $url);
    wp_enqueue_style('ultra-admin');

    /*ame*/
    $url = plugins_url('/', __FILE__).'../css/ultra-ame.css';
    wp_deregister_style('ultra-ame', $url);
    wp_register_style('ultra-ame', $url);
    wp_enqueue_style('ultra-ame');

    /*wordfence*/
    $url = plugins_url('/', __FILE__).'../css/ultra-wordfence.css';
    wp_deregister_style('ultra-wordfence', $url);
    wp_register_style('ultra-wordfence', $url);
    wp_enqueue_style('ultra-wordfence');

    /*other plugins compatibility*/
    $url = plugins_url('/', __FILE__).'../css/ultra-external.css';
    wp_deregister_style('ultra-external', $url);
    wp_register_style('ultra-external', $url);
    wp_enqueue_style('ultra-external');
}

/*function ultra_color()
{
    global $ultra_css_ver;
    global $ultraadmin;
    global $ultra_color;

    $csstype = ultra_dynamic_css_type();
    
    if (isset($csstype) && $csstype != "custom" && trim($csstype) != "")
    {
        $dyn_data = $ultra_color[$csstype];
        $ultraadmin = ultra_newdata($dyn_data);
    }
    return $ultraadmin;
}*/

function ultra_dynamic_css_type(){

    //global $wpdb;
    //echo $wpdb->blogid;

    global $ultra_css_ver;
    global $ultraadmin;


    $csstype = "custom";

    if(is_multisite()){

            global $blog_id;
            $current_blog_id = $blog_id;
            $network_active = ultra_network_active();

            //echo "<br><br>id:".$current_blog_id;
            
            if($network_active){
                //if network activate, switch to main blog
                switch_to_blog(1);
            }
            
            //echo $blog_id;
            
            // get current site framework options and thus gets it csstype value
            $current_site = get_option("ultra_demo");
            if(isset($current_site['dynamic-css-type'])){
                $csstype = $current_site['dynamic-css-type'];
            }
            //print_r($current_site);
            //echo $csstype;
            if($network_active){
                // switch back to current blog again if network active
                switch_to_blog($current_blog_id);
            }
            //echo $blog_id;

    } else {

        if(sizeof($ultraadmin) == 0){
            $ultraadmin = get_option("ultra_demo");
        }
        if(isset($ultraadmin['dynamic-css-type'])){
            $csstype = $ultraadmin['dynamic-css-type'];
        } 
    }

    /* --------------- Ultra Settings Panel - for demo purposes ---------------- */
   if(!has_action('plugins_loaded', 'ultra_regenerate_all_dynamic_css_file') && has_action('admin_footer', 'ultra_admin_footer_function')){
        if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/ultra-settings-panel-session.php')) {
            include( trailingslashit(dirname( __FILE__ )) . '../demo-settings/ultra-settings-panel-session.php' );
        }
    }
    return $csstype;
}


function ultra_default_css_colors() {
    global $ultra_css_ver;
    global $ultraadmin;
    $csstype = ultra_dynamic_css_type();
    //echo "default:".$csstype;
    $css_path = trailingslashit(plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/colors');
	$css_dir = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver.'/colors');

    if (isset($csstype) && $csstype != "custom" && trim($csstype) != "") {
        
        $style_color = trim($csstype);
        
        if(file_exists($css_dir . 'ultra-colors-' . $style_color . '.css'))
        {
            //echo " file exists";
            // check if file exists or not

            // deregister default wp admin color skins
//            wp_deregister_style('colors');
            wp_deregister_style('ultra-colors');
            wp_register_style('ultra-colors', $css_path . 'ultra-colors-' . $style_color . '.css');
            wp_enqueue_style('ultra-colors');
        } else {
            // enqueue the default ultra-colors.css file   
            ultra_dynamic_enqueue_style();   
        }
    }
}


function ultra_dynamic_enqueue_style()
{
    global $ultra_css_ver;

    if(!is_multisite()){
    	$url = plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/ultra-colors.css';
    } else if(is_multisite() && ultra_network_active()){
        // IF NETWORK ACTIVE
        global $wpdb;
        $current_site = 1;
        $url = plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/ultra-colors-site-'.$current_site.'.css';
    } else {
        // IF NOT NETWORK ACTIVE - FOR INDIVIDUAL SITES ONLY
        global $wpdb;
        $current_site = $wpdb->blogid;
        $url = plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/ultra-colors-site-'.$current_site.'.css';
    }
    wp_deregister_style('ultra-colors');
    wp_register_style('ultra-colors', $url);
    wp_enqueue_style('ultra-colors');

    $style_type = 'custom';

}


function ultra_wp_head_css() {

    global $ultra_css_ver;
    global $ultraadmin;

    global $wpdb;
    $current_blog_id = $wpdb->blogid;

    if(is_multisite() && ultra_network_active()){
                switch_to_blog(1);
                $site_specific_ultraadmin = get_option("ultra_demo");
                $ultraadmin = $site_specific_ultraadmin;
                switch_to_blog($current_blog_id);
    }
    //print_r($ultraadmin);

    echo '<style type="text/css">';

    $dynamic_css_file = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver) . 'dynamic_css.php';

    // buffer css 
    ob_start();
    require($dynamic_css_file); // Generate CSS
    $dynamic_css = ob_get_contents();
    ob_get_clean();

    // compress css
    $dynamic_css = ultra_compress_css($dynamic_css);

    echo $dynamic_css;
    echo '</style>';

    $style_type = 'custom';
}


/* ------------ Generate / Update dynamic CSS file on saving / changing plugin settings ----------*/
function ultra_regenerate_dynamic_css_file($newultraadmin = array(),$filename = "",$basedir = "") {

    global $ultra_css_ver;
    global $ultraadmin;
    if(sizeof($ultraadmin) == 0){
        $ultraadmin = get_option("ultra_demo");
    }
    if (is_array($newultraadmin) && sizeof($newultraadmin) > 0) {
        $ultraadmin = $newultraadmin;
    }
    
    //echo $filename; print_r($ultraadmin); echo "<hr>";

    global $ultra_color;
    
    $newfilename = "ultra-colors";
    if(trim($filename) != ""){$newfilename = "ultra-colors-".$filename;}

    $dynamic_css = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver) . 'dynamic_css.php';
    ob_start(); // Capture all output (output buffering)
    require($dynamic_css); // Generate CSS
    $css = ob_get_clean(); // Get generated CSS (output buffering)
    $css = ultra_compress_css($css);

	$css_dir = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver);

    if(isset($basedir) && $basedir != ""){
        $css_dir = $basedir;
    }
    
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    if (!$wp_filesystem->put_contents($css_dir . '/'.$newfilename.'.css', $css, 0644)) {
        return true;
    }

}


/*******************
* ultra_regenerate_all_dynamic_css_file();
* Generate all Colors CSS files Function
* Function called in main plugin file
*********************/

function ultra_regenerate_all_dynamic_css_file(){

    global $ultra_css_ver;
    global $ultraadmin;

    if(sizeof($ultraadmin) == 0){
        //switch_to_blog(1);
        $get_ultraadmin = get_option("ultra_demo");
        $ultraadmin = $get_ultraadmin;
    }

    $ultraadmin_backup = $ultraadmin;
    //echo "hi";
    //print_r($ultraadmin_backup);
    //die();

    global $ultra_color;

	$basedir = trailingslashit(plugin_dir_path(__FILE__).'../'.$ultra_css_ver.'/colors');
    // loop through each color
    foreach($ultra_color as $filename => $dyn_data)
    {
        $ultraadmin = ultra_newdata($dyn_data);
        //echo $filename."<pre>"; print_r($ultraadmin); echo "</pre>";

        //regenerate new css file
        ultra_regenerate_dynamic_css_file($ultraadmin,$filename,$basedir);
        $ultraadmin = $ultraadmin_backup;
    }
    
    // V. Imp to restore the original $data in variable back.
    $ultraadmin = $ultraadmin_backup;
    //die;
}



function ultra_newdata($dyn_data)
{

    global $ultra_css_ver;
    global $ultraadmin;
    //print_r($ultraadmin);
    //die();
    //print_r($dyn_data);
        // loop through dynamic values
        foreach($dyn_data as $type => $val)
        {
            // string type options
            if(!is_array($val) && trim($val) != "")
            {
                $ultraadmin[$type] = $val;
            }
            
            // array type options
            if(is_array($val) && sizeof($val) > 0)
            {
                foreach($val as $type2 => $val2)
                {
                    if(!is_array($val2) && trim($val2) != "")
                    {
                        $ultraadmin[$type][$type2] = $val2;
                    }
                }
            }
        }
        
        return $ultraadmin;
}



function ultra_compress_css($css) {
    //return $css;
    /* remove comments */
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

    /* remove tabs, spaces, newlines, etc. */
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    return $css;
}



function ultraadmin_access(){

       global $ultraadmin;
       $str = "";

        $element = 'enable-allusers-ultraadmin';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            if(!is_admin()){
                $str .= ".toplevel_page__ultraoptions{display:none;}";
                $str .= "#wp-admin-bar-_ultraoptions{display:none;}";
            }
        }

        echo "<style type='text/css'>".$str."</style>";
}




function ultra_custom_css(){

       global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);
    
       $str = "";

        $element = 'custom-css';
        if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
                $str .= $ultraadmin[$element];
        }

        echo "<style type='text/css' id='ultra-custom-css'>".$str."</style>";
}


function ultra_extra_css(){

       global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);

        //print_r($ultraadmin);

       $transform = "uppercase";
       $style = "";
       $upgrade = "inline";


        /*-----------------*/
       /* Check admin side theme permission */
        $get_admintheme_page = ultra_get_option("ultraadmin_admintheme_page","enable");

        $adminside = true;
        if(isset($get_admintheme_page) && $get_admintheme_page == "disable"){
            $adminside = false;
        }
        //echo $adminside;

        if($adminside){
            $element = 'menu-transform-text';
            if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
                    $transform = $ultraadmin[$element];
            }
            $style .= " #adminmenu .wp-submenu-head, #adminmenu a.menu-top { text-transform:".$transform." !important; } ";
        }

        /*-----------------*/


        $element = 'footer_version';
        if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
            if($ultraadmin[$element] == "0"){
                $upgrade = "none";
        }}
        $style .= " #wpfooter #footer-upgrade { display:".$upgrade." !important; } ";

        echo "<style type='text/css' id='ultra-extra-css'>".$style."</style>";
}


function ultra_disable_menu(){

    $str = "";
    $menudisable = get_option("ultraadmin_menudisable","");
    $exp = array_unique(array_filter(explode("|", $menudisable)));
    foreach($exp as $menuid){
        $str .= "#".$menuid.", ";
    }

    $str = substr($str,0,-2);

    //echo "<style id='ultra-disablemenu'>"; 
    //echo $str." {display:none !important;opacity:0 !important;} ";
    //echo "</style>";

}


function ultraprint($name,$arr){

    echo "<div style='max-height:400px;overflow:auto;width:500px;'>";
    echo $name;
    echo "<pre>"; print_r($arr); echo "</pre></div>";
}   

//change admin footer text
function ultra_footer_admin () {

       global $ultraadmin;
        
       $ultraadmin = ultraadmin_network($ultraadmin);       
       
       $str = 'Thank you for creating with <a href="https://wordpress.org/">WordPress</a> and <a target="_blank" href="http://codecanyon.net/item/ultra-wordpress-admin-theme/9220673">Ultra WordPress Admin Theme</a>';

        //print_r($ultraadmin);

        $element = 'footer_text';
        if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
                $str = $ultraadmin[$element];
        }
    
    echo $str;
}





function ultra_multisite_allsites(){

    $arr = array();
                        // get all blogs
                        $blogs = get_blog_list( 0, 'all' );

                        if ( 0 < count( $blogs ) ) :
                            foreach( $blogs as $blog ) : 
                                switch_to_blog( $blog[ 'blog_id' ] );

                                if ( get_theme_mod( 'show_in_home', 'on' ) !== 'on' ) {
                                    continue;
                                }

                                $blog_details = get_blog_details( $blog[ 'blog_id' ] );
                                //print_r($blog_details);
                                
                                //echo "<div style='height:200px; overflow:auto;width:100%;'>"; print_r(get_blog_option( $blog[ 'blog_id' ], 'ultra_demo' )); echo "</div>";

                                $id = $blog['blog_id'];
                                $name = $blog_details->blogname;
                                $arr[$id] = $name;

                            endforeach;
                        endif;

                        return $arr;
}


function ultra_network_active(){

        if ( ! function_exists( 'is_plugin_active_for_network' ) ){
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        // Makes sure the plugin is defined before trying to use it
            if ( is_plugin_active_for_network( 'ultra-admin/ultra-core.php' )){
                return true;
            }

            return false;
}


function ultra_add_option($variable,$default){
    if(ultra_network_active()){
        add_site_option($variable,$default);
    } else {
        add_option($variable,$default);
    }
}

function ultra_get_option($variable,$default){
    if(ultra_network_active()){
        return get_site_option($variable,$default);
    } else {
        return get_option($variable,$default);
    }
}

function ultra_update_option($variable,$default){
    if(ultra_network_active()){
        update_site_option($variable,$default);
    } else {
        update_option($variable,$default);
    }
}



function ultra_get_user_type(){
    $get_admin_menumng_page = ultra_get_option("ultraadmin_admin_menumng_page","enable");
    
    $enablemenumng = true;
    if((is_super_admin() || current_user_can('manage_options')) && $get_admin_menumng_page == "disable"){
        $enablemenumng = false;
    }
    return $enablemenumng;
}

function ultra_generate_inbuilt_theme_import_file(){
    global $ultra_color;
    foreach ($ultra_color as $key => $value) {
        $str = "";
        $str .= '{"dynamic-css-type":"custom","primary-color":"'.$value['primary-color'].'",';
        $str .= '"page-bg":{"background-color":"'.$value['page-bg']['background-color'].'"},';
        $str .= '"heading-color":"'.$value['heading-color'].'",';
        $str .= '"body-text-color":"'.$value['body-text-color'].'",';
        $str .= '"link-color":{"regular":"'.$value['link-color']['regular'].'","hover":"'.$value['link-color']['hover'].'"},';
        $str .= '"menu-bg":{"background-color":"'.$value['menu-bg']['background-color'].'"},';
        $str .= '"menu-color":"'.$value['menu-color'].'",';
        $str .= '"menu-hover-color":"'.$value['menu-hover-color'].'",';
        $str .= '"submenu-color":"'.$value['submenu-color'].'",';
        $str .= '"menu-primary-bg":"'.$value['menu-primary-bg'].'",';
        $str .= '"menu-secondary-bg":"'.$value['menu-secondary-bg'].'",';
        $str .= '"logo-bg":"'.$value['logo-bg'].'",';
        $str .= '"box-bg":{"background-color":"'.$value['box-bg']['background-color'].'"},';
        $str .= '"box-head-bg":{"background-color":"'.$value['box-head-bg']['background-color'].'"},';
        $str .= '"box-head-color":"'.$value['box-head-color'].'",';
        $str .= '"button-primary-bg":"'.$value['button-primary-bg'].'",';
        $str .= '"button-primary-hover-bg":"'.$value['button-primary-hover-bg'].'",';
        $str .= '"button-secondary-bg":"'.$value['button-secondary-bg'].'",';
        $str .= '"button-secondary-hover-bg":"'.$value['button-secondary-hover-bg'].'",';
        $str .= '"button-text-color":"'.$value['button-text-color'].'",';
        $str .= '"form-bg":"'.$value['form-bg'].'",';
        $str .= '"form-text-color":"'.$value['form-text-color'].'",';
        $str .= '"form-border-color":"'.$value['form-border-color'].'",';
        $str .= '"topbar-menu-color":"'.$value['topbar-menu-color'].'",';
        $str .= '"topbar-menu-bg":{"background-color":"'.$value['topbar-menu-bg']['background-color'].'"},';
        $str .= '"topbar-submenu-color":"'.$value['topbar-submenu-color'].'",';
        $str .= '"topbar-submenu-bg":"'.$value['topbar-submenu-bg'].'",';
        $str .= '"topbar-submenu-hover-bg":"'.$value['topbar-submenu-hover-bg'].'","redux_import_export":"","redux-backup":1}';

        ultra_inbuilttheme_file_create($key,$str);

    }
}


function ultra_inbuilttheme_file_create($filename,$str){

    if(trim($filename) != "" && trim($str) != ""){
        $css_dir = trailingslashit(plugin_dir_path(__FILE__).'../inbuilt_themes_import');

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global $wp_filesystem;
        if (!$wp_filesystem->put_contents($css_dir . '/'.$filename.'.txt', $str, 0644)) {
            return true;
        }
    }
}



function ultra_admin_footer_function() {
/* --------------- Settings Panel ----------------- */
if(!has_action('plugins_loaded', 'ultra_regenerate_all_dynamic_css_file')){
    if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/ultra-settings-panel.php')) {
        require_once( trailingslashit(dirname( __FILE__ )) . '../demo-settings/ultra-settings-panel.php' );
    }
}}


function ultra_screen_tabs(){


    global $ultra_css_ver;
    global $ultraadmin;

    $ultraadmin = ultraadmin_network($ultraadmin);

            /*Remove Screen Option & Help Tabs*/
    
            $screenoption = true;
            $element = 'screen_option_tab';

            //echo $ultraadmin[$element];

            if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
                if($ultraadmin[$element] == "0"){
                    $screenoption = false;
            }}

            $screenhelp = true;
            $element = 'screen_help_tab';
            if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
                if($ultraadmin[$element] == "0"){
                    $screenhelp = false;
            }}

            if(!$screenoption){
                add_filter('screen_options_show_screen', '__return_false');
            }

            if(!$screenhelp){
                add_action('admin_head', 'ultra_remove_help_tabs');
            }

}

function ultra_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}


?>