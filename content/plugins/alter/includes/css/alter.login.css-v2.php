<style type="text/css">
@font-face {
  font-family: "linea-basic-10";
  src:url("<?php echo ALTER_DIR_URI ?>assets/css/fonts/linea-basic-10.eot");
  src:url("<?php echo ALTER_DIR_URI ?>assets/css/fonts/linea-basic-10.eot?#iefix") format("embedded-opentype"),
    url("<?php echo ALTER_DIR_URI ?>assets/css/fonts/linea-basic-10.woff") format("woff"),
    url("<?php echo ALTER_DIR_URI ?>assets/css/fonts/linea-basic-10.ttf") format("truetype"),
    url("<?php echo ALTER_DIR_URI ?>assets/css/fonts/linea-basic-10.svg#linea-basic-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
<?php
$login_bg_img = $this->aof_options['login_bg_img'];
$admin_login_logo = $this->aof_options['admin_login_logo'];

$login_background = (is_numeric($login_bg_img)) ? $this->alter_get_image_url($login_bg_img) : $login_bg_img;
$login_logo = (is_numeric($admin_login_logo)) ? $this->alter_get_image_url($admin_login_logo) : $admin_login_logo;

$output = "";

  if(!empty($login_bg_img)) {
  $output .= 'body,.form-bg{ background-image: url("' . $login_bg_img . '");}';
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
  width: 760px;
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
  background: rgba(60,80,120,0.5); /*Here To Change The Form BG Color*/
  width: 100%;
  overflow: hidden;
  height: 320px;

}

#lostpasswordform {
  padding-top: 60px;
}

.login form {
  background-color: rgba(0, 0, 0, 0.0);
  padding-top: 0;

  -webkit-box-shadow: none;
  box-shadow: none;
}

.login h1 {
  float: left;
  width: 320px;
  height: 400px;
  background-color: rgba(0, 250, 0, 0.3); /*Logo BG Color*/
  padding-top: 60px;
  color: #fff;
}

.alter-heading {
  font-size: 16px;
}';

if(!empty($login_logo)) {
  $login_logo_size = ($this->aof_options['admin_logo_resize']) ? $this->aof_options['admin_logo_size_percent']."%" : "auto";
$output .= '.login h1 a {
    background-image: url("' . $login_logo . '");
  background-size: '. $login_logo_size .';
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

form label[for=rememberme] {
  display: none;
}

.login form .input, .login input[type=text] {
  background-color: transparent;
  border: none;
  box-shadow: none;
  border-bottom: 1px solid #fff;
  color: #fff;
  font-size: 16px;
  font-weight: 300;
  line-height: 40px;
  padding-left: 30px;
}


form input::-webkit-input-placeholder {
  color:#fff;
}
form input::-moz-placeholder          {
  color:#fff;
}
form input:-moz-placeholder           {
  color:#fff;
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
}


#nav, #backtoblog {
  text-align: right;
  width: 180px;
  margin-top: 0;
  position: relative;
  float: right;
  bottom: 36%;
}


#backtoblog {
  margin: 6px 0;
}


.login #backtoblog a, .login #nav a {
  color: #fff;
  font-size: 14px;
  font-weight: 300;
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

';

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
$output .= '.login .message, .button-primary, .wp-core-ui .button-primary {
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    text-shadow: none;
}
.button-primary, .wp-core-ui .button-primary {
    border: none;
}';

} //end of design_type

$output .= $this->aof_options['login_custom_css'];

echo $output;
?>
</style>
