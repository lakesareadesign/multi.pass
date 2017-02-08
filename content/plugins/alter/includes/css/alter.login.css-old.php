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
?>
body, html { height: auto; }
body.login{background-color:<?php echo $this->aof_options['login_bg_color'] . ' !important;'; if(!empty($login_bg_img)) echo ' background-image: url(' . $login_background  . ');';
  if($this->aof_options['login_bg_img_repeat'] == 1) echo 'background-repeat: repeat'; else echo 'background-repeat: no-repeat'; ?>;
  background-position: center center; <?php if($this->aof_options['login_bg_img_scale']) echo 'background-size: 100% auto;'; ?>
  background-attachment: fixed; margin:0; padding:1px; top: 0; right: 0; bottom: 0; left: 0; }
html, body.login:after { display: block; clear: both; }
.alter-form-container {position: relative;margin: 0 auto;text-align: center;top:30%;width: 760px;overflow: hidden;box-shadow: 0px 0px 21px 0px rgba(0, 0, 0, 0.35);}
.alter-form-container .form-bg {background-repeat: no-repeat;background-size: cover;background-attachment: fixed;position: absolute;color: #fff;
  -webkit-filter: blur(15px);filter: blur(15px);width: 800px;height: 660px;margin: 0 auto ;text-align: center;left: -20px;top: -20px;}

input, select, textarea, input:hover, select:hover, textarea:hover, input:focus, select:focus, textarea:focus {transition:All 0.45s ease;-webkit-transition:All 0.45s ease;-moz-transition:All 0.45s ease;-o-transition:All 0.45s ease;}
input[type=text], input[type=password], input[type=email], textarea {border-bottom: 1px solid <?php if(!empty($this->aof_options['login_inputs_border_color'])) echo $this->aof_options['login_inputs_border_color']; else echo '#e2e2e2';?>;
border-top: none!important;border-left: none!important;border-right: none!important;
-moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none;}
input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, textarea:focus {outline: none;-moz-box-shadow:none;-webkit-box-shadow:none;
box-shadow:none;}
input[type=text]:hover, input[type=password]:hover, input[type=email]:hover, textarea:hover,
input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, textarea:focus{border-color: <?php if(!empty($this->aof_options['login_inputs_border_hover_color'])) echo $this->aof_options['login_inputs_border_hover_colorF@']; else echo '#756c6c';?>;}
body.login-action-register { position: relative }
body.login-action-login, body.login-action-lostpassword { position: fixed }
.login h1 a {
<?php if(!empty($login_logo)) { ?>
width: 100%;
background: url(<?php echo $login_logo; ?>) center center no-repeat;
<?php if($this->aof_options['admin_logo_resize']) { ?>
background-size: <?php echo $this->aof_options['admin_logo_size_percent']; ?>%;
<?php }
} ?>
height:<?php echo $this->aof_options['admin_logo_height']; ?>px; margin: 0 auto 20px; }
div#login { background: <?php if($this->aof_options['login_divbg_transparent'] ==1) echo 'transparent'; else echo $this->aof_options['login_divbg_color']; ?>; margin-top: <?php echo $this->aof_options['login_form_margintop']; ?>%; padding: 18px 0 }
body.interim-login div#login {width: 95% !important; height: auto }
.login label, .login form, .login form p { color: <?php echo $this->aof_options['form_text_color']; ?> !important }
.login a { text-decoration: underline; color: <?php echo $this->aof_options['form_link_color']; ?> !important }
.login a:focus, .login a:hover { color: <?php echo $this->aof_options['form_link_hover_color']; ?> !important; }
.login form { background: <?php if($this->aof_options['login_divbg_transparent'] == 1) echo 'transparent'; else echo $this->aof_options['login_formbg_color']; ?> !important; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;<?php if($this->aof_options['login_divbg_transparent'] != 1) echo 'border-bottom: 1px solid ' .$this->aof_options['form_border_color'] . ';'; if($this->aof_options['login_divbg_transparent'] == 1) echo  'padding: 26px 0px 30px !important'; else echo 'padding: 26px 37px 37px !important'; ?> }
.login form { background: transparent!important}
div#login{background-color: rgba(0, 0, 0, 0.0);padding-top: 0;-webkit-box-shadow: none;box-shadow: none;}
.login h1 {
  float: left;
  width: 320px;
  height: 400px;
  background-color: rgba(0, 250, 0, 0.3); /*Logo BG Color*/
  padding-top: 60px;
  color: #fff;
}
form#loginform .button-primary, form#registerform .button-primary, .button-primary { background:<?php echo $this->aof_options['pry_button_color']; ?> !important; border:none !important; color: <?php echo $this->aof_options['pry_button_text_color']; ?> !important; text-shadow: none;}
form#loginform .button-primary.focus,form#loginform .button-primary.hover,form#loginform .button-primary:focus,form#loginform .button-primary:hover, form#registerform .button-primary.focus, form#registerform .button-primary.hover,form#registerform .button-primary:focus,form#registerform .button-primary:hover { background: <?php echo $this->aof_options['pry_button_hover_color']; ?> !important;border-color:<?php echo $this->aof_options['pry_button_hover_border_color']; ?> !important; }
<?php if($this->aof_options['login_divbg_transparent'] == 1) { ?>.login #backtoblog, .login #nav { margin : 0; padding: 0 } .login form { padding-top: 2px !important}<?php } ?>

.login form input.input { background: <?php if($this->aof_options['login_inputs_transparent'] != 1)
  echo $this->aof_options['login_inputs_bg_color']; else echo 'transparent' ?> url(<?php echo ALTER_DIR_URI; ?>assets/images/login-sprite.png) no-repeat;
        padding: 20px 0 15px 38px !important; font-size: 16px !important; line-height: 1; outline: none !important;
color: <?php if(!empty($this->aof_options['login_inputs_text_color'])) echo $this->aof_options['login_inputs_text_color']; else echo '#e5e5e5' ?>;
}

p#nav,p#backtoblog {text-align:center;}
/*form#loginform,form {-moz-box-shadow:0px 3px 23px #d8d3d8;-webkit-box-shadow:0px 3px 23px #d8d3d8;box-shadow:0px 3px 23px #d8d3d8;}*/

input#user_login { background-position:12px -6px !important; }
input#user_pass, input#user_email, input#pass1, input#pass2 { background-position:12px -56px !important; }
input#user_login, input#pass1, input#pass2 { margin-bottom: 5px }
.login form #wp-submit { width:100%; height:57px;text-transform:uppercase;margin-top:15px;border-radius:2px;-moz-border-radius:2px;-webkit-border-radius:2px;}
p.forgetmenot { margin-bottom: 16px !important; }
.login #pass-strength-result {margin: 12px 0 16px !important }
p.indicator-hint { clear:both }

/* Message box */
div.updated, .login #login_error, .login .message { border-left: 4px solid <?php echo $this->aof_options['msgbox_border_color']; ?>; background-color: <?php echo $this->aof_options['msg_box_color']; ?>; color: <?php echo $this->aof_options['msgbox_text_color']; ?>; }
div.updated a, .login #login_error a, .login .message a { color: <?php echo $this->aof_options['msgbox_link_color']; ?>; }
div.updated a:hover, .login #login_error a:hover, .login .message a:hover { color: <?php echo $this->aof_options['msgbox_link_hover_color']; ?>; }

.login_footer_content { padding: 40px 0; text-align:center; }
.footer_content { }
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
<?php if($this->aof_options['hide_backtoblog'] == 1) echo '#backtoblog { display:none !important; }';
if($this->aof_options['hide_remember'] == 1) echo 'p.forgetmenot { display:none !important; }';

if($this->aof_options['design_type'] == 2) { ?>
.wp-core-ui .button,.wp-core-ui .button-secondary {border-color:<?php echo $this->aof_options['sec_button_border_color']; ?>;-webkit-box-shadow:inset 0 1px 0 <?php echo $this->aof_options['sec_button_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 <?php echo $this->aof_options['sec_button_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.08);}
.wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover {border-color:<?php echo $this->aof_options['sec_button_hover_border_color']; ?>; -webkit-box-shadow:inset 0 1px 0 <?php echo $this->aof_options['sec_button_hover_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 <?php echo $this->aof_options['sec_button_hover_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.08);}
.wp-core-ui .button-primary, .wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled, .wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled] {border-color:<?php echo $this->aof_options['pry_button_border_color']; ?> !important;-webkit-box-shadow:inset 0 1px 0 <?php echo $this->aof_options['pry_button_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.15) !important; box-shadow: inset 0 1px 0 <?php echo $this->aof_options['pry_button_shadow_color']; ?>, 0 1px 0 rgba(0,0,0,.15) !important;}
.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.active,.wp-core-ui .button-primary.active:focus,.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active {border-color:<?php echo $this->aof_options['pry_button_hover_border_color']; ?> !important;-webkit-box-shadow:inset 0 1px 0 <?php echo $this->aof_options['pry_button_hover_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.15) !important; box-shadow: inset 0 1px 0 <?php echo $this->aof_options['pry_button_hover_shadow_color']; ?>,0 1px 0 rgba(0,0,0,.15) !important;}
<?php }
if($this->aof_options['design_type'] == 1) {
?>
.login .message, .button-primary, .wp-core-ui .button-primary {
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    text-shadow: none;
}
.button-primary, .wp-core-ui .button-primary {
    border: none;
}

<?php } //end of design_type

echo $this->aof_options['login_custom_css']; ?>

@media only screen and (min-width: 992px) {
	div#login {
		width: <?php echo $this->aof_options['login_form_width']; ?>% !important;
	}
}
@media screen and (max-width: 992px){
	div#login {
		width: 90% !important;
	}
	body.login {
		background-size: auto;
	}
	body.login-action-login, body.login-action-lostpassword {
		position: relative;
	}
}
</style>
