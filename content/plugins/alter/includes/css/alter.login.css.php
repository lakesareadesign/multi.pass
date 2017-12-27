<style type="text/css">
<?php
$output = "";

$output .= '@font-face {
  font-family: "linea-basic-10";
  src:url("'. ALTER_DIR_URI . 'assets/css/fonts/linea-basic-10.eot");
  src:url("'. ALTER_DIR_URI . 'assets/css/fonts/linea-basic-10.eot?#iefix") format("embedded-opentype"),
    url("'. ALTER_DIR_URI . 'assets/css/fonts/linea-basic-10.woff") format("woff"),
    url("'. ALTER_DIR_URI . 'assets/css/fonts/linea-basic-10.ttf") format("truetype"),
    url("'. ALTER_DIR_URI . 'assets/css/fonts/linea-basic-10.svg#linea-basic-10") format("svg");
  font-weight: normal;
  font-style: normal;
}';

$login_bg_img = (!empty($this->aof_options['login_bg_img'])) ? $this->aof_options['login_bg_img'] : "";
$admin_login_logo = (!empty($this->aof_options['admin_login_logo'])) ? $this->aof_options['admin_login_logo'] : "";

if(!empty($this->aof_options['login_external_logo_url']) && filter_var($this->aof_options['login_external_logo_url'], FILTER_VALIDATE_URL)) {
  $login_logo = esc_url( $this->aof_options['login_external_logo_url']);
}
else {
  $login_logo = (is_numeric($admin_login_logo)) ? $this->alter_get_image_url($admin_login_logo) : $admin_login_logo;
}

$bg_opacity = 0.5;
if($this->aof_options['login_form_style'] == 2) {
  $bg_opacity = 1;
}

$login_logo_bg = (!empty($this->aof_options['login_logo_bg_color'])) ? $this->alter_hex2rgba($this->aof_options['login_logo_bg_color'], $bg_opacity) : "rgba(0, 250, 0, $bg_opacity)";
$form_bg_color = (!empty($this->aof_options['login_formbg_color'])) ? $this->alter_hex2rgba($this->aof_options['login_formbg_color'], $bg_opacity) : "rgba(66,49,67, $bg_opacity)";
$form_width = (empty($this->aof_options['login_form_width_in_px']) || $this->aof_options['login_form_width_in_px'] < 480) ? "760" : $this->aof_options['login_form_width_in_px'];
$inp_plholder_color = (!empty($this->aof_options['login_inputs_plholder_color'])) ? $this->aof_options['login_inputs_plholder_color'] : "#5f6f82";
$logo_top_margin = (!empty($this->aof_options['login_logo_top_margin'])) ? $this->aof_options['login_logo_top_margin'] : "80";
$login_button_color = (!empty($this->aof_options['login_button_color'])) ? $this->aof_options['login_button_color'] : "#122133";
$login_button_hover_color = (!empty($this->aof_options['login_button_hover_color'])) ? $this->aof_options['login_button_hover_color'] : "#101e2f";
$login_button_text_color = (!empty($this->aof_options['login_button_text_color'])) ? $this->aof_options['login_button_text_color'] : "#ffffff";

  if(empty($this->aof_options['disable_login_bg_img'])) {
    $output .= 'body,.form-bg{ background-image: url("';
      if(!empty($login_bg_img)) {
        $output .= $login_bg_img;
      }
      else {
        $output .= ALTER_DIR_URI . 'assets/images/mountain.jpg';
      }
    $output .= '");}';
  }
  $output .= 'body{
    background-color:'. $this->aof_options['login_bg_color'] . '!important;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    width: 100%;
    height: 100%;
}
.login label, .login form, .login form p { color: '. $this->aof_options['form_text_color'] .'!important }
.login a { text-decoration: underline; color: '. $this->aof_options['form_link_color'] .'!important }
.login a:focus, .login a:hover { color: '. $this->aof_options['form_link_hover_color'] .'!important; }
.login form { background: '. $this->aof_options['login_formbg_color']. '!important;}
.login form { background: transparent!important}
.alter-form-container {
  position: relative;
  margin: 0 auto ;
  text-align: center;
  top: 30%;
  width: '. $form_width . 'px;
  overflow: hidden;
  box-shadow: 0px 0px 21px 0px rgba(0, 0, 0, 0.35);
}
.form-bg {
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
  position: absolute;
  color: #fff;
  -webkit-filter: blur(15px);
  filter: blur(15px);
  width: 800px;
  height: 660px;
  margin: 0 auto ;
  text-align: center;
  left: -20px;
  top: -20px;

}

#login {
  position: relative;
  z-index: 100;
  padding: 0;
  background: '. $form_bg_color .';
  width: 100%;
  overflow: hidden;
  height: 350px;

}

#lostpasswordform {
  padding-top: 60px;
}

.login form {
  background-color: rgba(0, 0, 0, 0.0);
  padding-top: 10px;
  -webkit-box-shadow: none;
  box-shadow: none;
}

.login h1 {
  float: left;
  width: 320px;
  height: 400px;
  background-color: '. $login_logo_bg .';
  padding-top: '. $logo_top_margin .'px;
  color: #fff;
  font-size: 12px;
  font-weight:300;
}
';

if($form_width < 550) {
  $output .= '.login h1 {
    width:220px;
  }';
}

if(!empty($login_logo)) {
  $login_logo_size = (!empty($this->aof_options['admin_logo_resize'])) ? $this->aof_options['admin_logo_size_percent']."%" : "auto";
$output .= '.login h1 a {
    background-image: url("' . $login_logo . '");
  background-size: '. $login_logo_size .';
  background-position: center center;
  height: '. $this->aof_options['admin_logo_height'] .'px;
  width: auto;
}';
}

$output .= '.login #login_error{
  margin-left: 320px;
  position: absolute;
  padding: 4px;
  width: 440px;
}

.login .message {
  margin-left: 320px;
  position: absolute;
  padding: 4px;
  width: 440px;
}

.alter-icon-login, .alter-icon-pwd {
  font-size: 16px;
  width: 20px;
  text-align: left;
  position: absolute;
}

.alter-icon-login:before {
  font-family: "linea-basic-10" !important;
  content: "u";
  color: #fff;
  position: absolute;
  top: 16px;
  font-style: normal !important;
  font-weight: 400;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.alter-icon-pwd:before {
  font-family: "linea-basic-10" !important;
  content: "9";
  color: #fff;
  position: absolute;
  top: 16px;
  font-style: normal !important;
  font-weight: 400;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.alter-icon-email::before {
    color: #b2acb2;
    content: "&";
    font-family: "linea-basic-10";
    font-style: normal;
    font-variant: normal;
    font-weight: 400;
    line-height: 1;
    position: absolute;
    text-transform: none;
    top: 16px;
}
.alter-icon-email {
    font-size: 16px;
    position: absolute;
    text-align: left;
    width: 20px;
}

form label[for=user_login], form label[for=user_pass] {
font-size: 0px;
color: transparent;
padding: 0;
margin: 0;
cursor: default;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

.login form .forgetmenot {
  float:right;
}

.login form .input, .login input[type=text], .login input[type=password], .login input[type=email] {
  background-color: transparent;
  border: none;
  box-shadow: none;
  border-bottom: 1px solid '. $this->aof_options['login_inputs_border_color'] .';
  color: '. $this->aof_options['login_inputs_text_color'] .';
  font-size: 16px;
  font-weight: 300;
  line-height: 40px;
  padding-left: 30px;
}


form input::-webkit-input-placeholder {
  color:'. $inp_plholder_color .';
}
form input::-moz-placeholder          {
  color:'. $inp_plholder_color .';
}
form input:-moz-placeholder           {
  color:'. $inp_plholder_color .';
}

.login label {
  font-size: 16px;
  font-weight: lighter;
  color: #fff;
}

.button.button-primary.button-large {
  font-size: 14px;
  font-weight: 700;
  background-color: #0090d8;
  float: left;
  padding-right: 16px;
  padding-left: 16px;
  min-width: 130px;
  height: 43px;
  border-radius: 100px;
  text-transform: uppercase;
  border: none;
  text-shadow: none;
  margin-top: 20px;
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important;
}

#nav, #backtoblog {
  text-align: left;
  width: 280px;
  margin-top: 0;
  position: relative;
  float: left;
  bottom: 17%;
}

.login #nav {
  margin-top:57px;
}

#backtoblog {
  margin: 6px 0;
}

.login #backtoblog a, .login #nav a {
  color: #fff;
  text-transform:uppercase;
  font-size:11px;
  font-weight: 300;
  letter-spacing:0.1em;
  position: relative;
}

.login #backtoblog a:after, .login #nav a:after {
  content: "";
  position: absolute;
  width: 100%;
  height: 1px;
  bottom: 0;
  left: 0;
  background-color: '.$this->aof_options['form_link_hover_color'].';
  visibility: hidden;
  -webkit-transform: scaleX(0);
  transform: scaleX(0);
  -webkit-transition: all 0.3s ease-in-out 0s;
  transition: all 0.3s ease-in-out 0s;
}
.login #backtoblog a:hover:after, .login #nav a:hover:after {
  visibility: visible;
  -webkit-transform: scaleX(1);
  transform: scaleX(1);
}

.login #backtoblog a:hover, .login #nav a:hover {
  color: #fff;
}

.login_footer_content {
  position:absolute;
  bottom:40px;
  text-align:center;
  display:block;
  width:100%;
}

.login .message {
  position: relative;
  width: auto;
  margin-left: 0;
  text-align: center;
  z-index: 9;
  border-left: none;
  padding: 8px;
  margin-bottom: 0
}

@media only screen and (max-height: 760px) {
  body {
    min-height: 560px;
  }
  .alter-form-container {
    top: 20%;
  }
}

@media only screen and (max-width: 860px) {
  body {
    min-height: 740px;
  }
  .alter-form-container {
    top: 10%;
    width: 320px;
  }

  .login h1 {
    float: none;
    height: 180px;
    padding-top: 40px;
    color: #fff;
  }
  .login h1 a {
    margin-bottom: 20px;
  }

  #login {
    height: 590px;
  }

  #nav, #backtoblog {
    text-align: center;
    width: auto;
    bottom: 8%;
    float: none;
    }

  .button.button-primary.button-large {
    float: none;
    width: 100%;
    }
  p.submit {
    text-align: center;
    }

    .login .message, .login #login_error {
      margin-left: 0;
      width: 308px;
    }

}

@media only screen and (max-width: 420px) {
  .alter-form-container {
    width: 286px;
  }

  .login h1 {
    width: 288px;
  }
}

body #dashboard-widgets .postbox form .submit { padding: 10px 0 !important; }
  @media (max-width:860px) {
  .login .message {
  position: relative;
  }
}

';

$output .= 'form#loginform .button-primary, form#registerform .button-primary, .button-primary {
  background:'. $login_button_color .';
  color: '. $login_button_text_color .';}';
$output .= 'form#loginform .button-primary.focus,form#loginform .button-primary.hover,form#loginform
.button-primary:focus,form#loginform .button-primary:hover, form#registerform .button-primary.focus,
form#registerform .button-primary.hover,form#registerform .button-primary:focus,form#registerform .button-primary:hover {
  background: '. $login_button_hover_color .' !important;}';

if($this->aof_options['hide_backtoblog'] == 1) $output .= '#backtoblog { display:none !important; }';
if($this->aof_options['hide_remember'] == 1) $output .= 'p.forgetmenot { display:none !important; }';

if($this->aof_options['design_type'] == 2) {
$output .= '.wp-core-ui .button,.wp-core-ui .button-secondary {
  border-color:'. $this->aof_options['sec_button_border_color'] . ';
  -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_shadow_color'] . ',0 1px 0 rgba(0,0,0,.08);
  box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_shadow_color'] . ',0 1px 0 rgba(0,0,0,.08);}
.wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover,
.wp-core-ui .button:focus, .wp-core-ui .button:hover {
  border-color:'. $this->aof_options['sec_button_hover_border_color'] .';
  -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_hover_shadow_color'].',0 1px 0 rgba(0,0,0,.08);
  box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_hover_shadow_color'].',0 1px 0 rgba(0,0,0,.08);}
.wp-core-ui .button-primary, .wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled,
.wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled] {
  border-color:'. $this->aof_options['pry_button_border_color'].'!important;
  -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['pry_button_shadow_color'].',0 1px 0 rgba(0,0,0,.15) !important;
  box-shadow: inset 0 1px 0 '. $this->aof_options['pry_button_shadow_color'].', 0 1px 0 rgba(0,0,0,.15) !important;}
.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus,
.wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.active,.wp-core-ui .button-primary.active:focus,
.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active {
  border-color:'. $this->aof_options['pry_button_hover_border_color'].'!important;
  -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['pry_button_hover_shadow_color'].',0 1px 0 rgba(0,0,0,.15) !important;
  box-shadow: inset 0 1px 0 '. $this->aof_options['pry_button_hover_shadow_color'].',0 1px 0 rgba(0,0,0,.15) !important;}';
}

if($this->aof_options['design_type'] == 1) {
$output .= '.login .message, .button-primary, .wp-core-ui .button-primary, .wp-core-ui .button, .wp-core-ui .button-secondary {
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    text-shadow: none;
}
.button-primary, .wp-core-ui .button-primary {
    border: none;
}';

} //end of design_type

if($this->aof_options['login_form_style'] == 2) {
  $output .= '
  .alter-form-container { top: 24%; }
  @media only screen and (max-width: 640px) {
    .alter-form-container { top: 12%; }
  }
  .login h1 {
    float: none;
    height: auto;
    padding-top: 0;
    width: auto;
    }
    #login {
    height: auto;
    }
    .login #nav {
    margin-top: 0;
    }
    .form-bg {
    display: none;
    }

    .login #login_error {
        margin-left: auto;
        padding: 4px;
        position: relative;
        width: auto;
    }

    @media only screen and (max-width: 640px) {
    .alter-form-container {
    width: 400px; }
    }
    @media only screen and (max-width: 500px) {
    .alter-form-container {
    width: 300px; }
  }
  #login { padding-bottom: 20px; }
';
}

//Message box
$output .= 'div.updated, .login #login_error, .login .message { border-left: 4px solid '. $this->aof_options['msgbox_border_color'] .';
  background-color: '. $this->aof_options['msg_box_color'] .'; color: '. $this->aof_options['msgbox_text_color'] .'; }
div.updated a, .login #login_error a, .login .message a { color: '. $this->aof_options['msgbox_link_color'] .'; }
div.updated a:hover, .login #login_error a:hover, .login .message a:hover { color:'. $this->aof_options['msgbox_link_hover_color'] .'; }';

$output .= $this->aof_options['login_custom_css'];

echo $this->alterCompress_css($output);
?>


/* New Login Styles */

</style>
