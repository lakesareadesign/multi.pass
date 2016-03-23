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

function ultra_custom_login() {
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    global $ultra_css_ver;

    $url = plugins_url('/', __FILE__).'../'.$ultra_css_ver.'/ultra-login.css';
    wp_deregister_style('ultra-login');
    wp_register_style('ultra-login', $url);
    wp_enqueue_style('ultra-login');



    echo "\n<style type='text/css'>";

    /*text, backgrounds, link color*/
    echo ultra_css_background("body, #wp-auth-check-wrap #wp-auth-check", "login-background") . "\n";
    echo ultra_css_background(".login form", "login-form-background") . "\n";
    echo ultra_link_color(".login #backtoblog a, .login #nav a, .login a", "login-link-color") . "\n";
    echo ultra_css_color(".login, .login form label, .login form, .login .message", "login-text-color") . "\n";

    /*login button*/
    echo ultra_css_bgcolor(".login.wp-core-ui .button-primary", "login-button-bg") . "\n";
    echo ultra_css_bgcolor(".login.wp-core-ui .button-primary:hover, .login.wp-core-ui .button-primary:focus", "login-button-hover-bg") . "\n";
    echo ultra_css_color(".login.wp-core-ui .button-primary", "login-button-text-color") . "\n";


    /*form input fields - text and checkbox*/
    echo ultra_css_bgcolor(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-bg-color", ($ultraadmin['login-input-bg-opacity']) == "" ? "0.5" : $ultraadmin['login-input-bg-opacity']) . "\n";
    echo ultra_css_bgcolor(".login form .input:hover, .login form input[type=checkbox]:hover, .login input[type=text]:hover, .login form .input:focus, .login form input[type=checkbox]:focus, .login input[type=text]:focus", "login-input-bg-color", ($ultraadmin['login-input-bg-hover-opacity']) == "" ? "0.8" : $ultraadmin['login-input-bg-hover-opacity']) . "\n";
    echo ultra_css_color(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-text-color") . "\n";
    echo ultra_css_color(".login.wp-core-ui input[type=checkbox]:checked:before", "login-input-text-color") . "\n";


    /*form input fields - other fields - for future use*/
    echo ultra_css_bgcolor("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-bg-color", ($ultraadmin['login-input-bg-opacity']) == "" ? "0.5" : $ultraadmin['login-input-bg-opacity']) . "\n";
    echo ultra_css_color("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-text-color") . "\n";


    /*login error message*/
    echo ultra_css_bgcolor(".login #login_error, .login .message", "login-input-bg-color", ($ultraadmin['login-input-bg-opacity']) == "" ? "0.5" : $ultraadmin['login-input-bg-opacity']) . "\n";
    echo ultra_css_color(" .login .message,  .login .message a, .login #login_error, .login #login_error a", "login-input-text-color") . "\n";


    /*login logo*/
	$logo_url = "";
    if (isset($ultraadmin['login-logo']['url']) && $ultraadmin['login-logo']['url'] != "") {
        $logo_url = $ultraadmin['login-logo']['url'];
    } else {
        $logo_url = $ultraadmin['logo']['url'];
    }

    echo '.login h1 a { background-image: url("' . $logo_url . '");}';


echo "</style>\n"; 


/*


    echo '.login{color: '.$ultraadmin['login-link-color']['regular'].'}';
    echo '.login.wp-core-ui .button-primary{ 
    height: 34px;
    line-height: 28px;
    border-radius : 0px;
    padding: 0 12px 2px;
    border-color: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
    -ms-box-shadow: none;
    -moz-box-shadow: none;
    -o-shadow: none;
}';

    echo ".login.wp-core-ui input[type=checkbox]{
    box-shadow: none;
    -ms-box-shadow: none;
    -moz-box-shadow: none;
    -o-shadow: none; 
    border-color: " . $ultraadmin['separator-color'] . "
    }";

    if (isset($ultraadmin['login-logo']['url']) && $ultraadmin['login-logo']['url'] != "") {
        $logo_url = $ultraadmin['login-logo']['url'];
    } else {
        $logo_url = $ultraadmin['logo']['url'];
    }

    echo '.login h1 a { background-image: url("' . $logo_url . '");'
    . 'background-size: contain;min-height: 88px;width:auto;}';

    */



}


function ultra_custom_loginlogo_url() {

    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    $logourl = "https://wordpress.org/";

    if(isset($ultraadmin['logo-url']) && trim($ultraadmin['logo-url']) != ""){
        $logourl = $ultraadmin['logo-url'];
    }
    return $logourl;
}




function ultra_login_options(){

       global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

       // back to blog
       $backtoblog = "block";
       $element = 'backtosite_login_link';
       
       if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
            if($ultraadmin[$element] == "0"){
                $backtoblog = "none";
       }}
         
       $style = "";
       $style .= " #backtoblog { display:".$backtoblog." !important; } ";


       // forgot password

       $forgot = "block";
       $element = 'forgot_login_link';
       
       if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
            if($ultraadmin[$element] == "0"){
                $forgot = "none";
       }}
       
       $style .= " #nav { display:".$forgot." !important; } ";

       echo "<style type='text/css' id='ultra-login-extra-css'>".$style."</style>";

}


// change title
function ultra_loginlogo_title() {
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    $logourl = "";

    if(isset($ultraadmin['login-logo-title']) && trim($ultraadmin['login-logo-title']) != ""){
        $logourl = $ultraadmin['login-logo-title'];
    }
    return $logourl;
}
add_filter( 'login_headertitle', 'ultra_loginlogo_title' );



// lost password

/*
function remove_lostpassword_text ( $text ) {
     if ($text == 'Lost your password?'){$text = '';}
        return $text;
     }
//add_filter( 'gettext', 'remove_lostpassword_text' );




// change login redirect link

function admin_login_redirect( $redirect_to, $request, $user )
{
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) ) {
            return $redirect_to;
        } else {
            return home_url();
        }
    }
    else 
    {
        return $redirect_to;
    }
}
add_filter("login_redirect", "admin_login_redirect", 10, 3);

*/
/*
$args = array(
        'echo' => true,         // To echo the form on the page
        'redirect' => site_url( $_SERVER['REQUEST_URI'] ),   // The URL you redirect logged in users
        'form_id' => 'loginform',                            // Id of the form
        'label_username' => __( 'Username' ),                // Label of username
        'label_password' => __( 'Password' ),                // Label of password
        'label_remember' => __( 'Remember Me' ),             // Label for remember me
        'label_log_in' => __( 'Log In' ),                    // Label for log in
        'id_username' => 'user_login',                       // Id on username textbox
        'id_password' => 'user_pass',                        // Id on password textbox
        'id_remember' => 'rememberme',                       // Id on rememberme textbox
        'id_submit' => 'wp-submit',                          // Id on submit button
        'remember' => true,                                  // Display remember me checkbox
        'value_username' => NULL,                            // Default username value
        'value_remember' => false );                         // Default rememberme checkbox

wp_login_form( $args );

*/




?>