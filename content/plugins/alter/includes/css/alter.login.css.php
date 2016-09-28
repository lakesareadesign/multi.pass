<style type="text/css">
<?php
$login_bg_img = $this->aof_options['login_bg_img'];
$admin_login_logo = $this->aof_options['admin_login_logo'];

$login_background = (is_numeric($login_bg_img)) ? $this->alter_get_image_url($login_bg_img) : $login_bg_img;
$login_logo = (is_numeric($admin_login_logo)) ? $this->alter_get_image_url($admin_login_logo) : $admin_login_logo;
?>
body, html { height: auto; }
body.login{background-color:<?php echo $this->aof_options['login_bg_color'] . ' !important;'; if(!empty($login_bg_img)) echo ' background-image: url(' . $login_background  . ');'; if($this->aof_options['login_bg_img_repeat'] == 1) echo 'background-repeat: repeat'; else echo 'background-repeat: no-repeat'; ?>; background-position: center center; <?php if($this->aof_options['login_bg_img_scale']) echo 'background-size: 100% auto;'; ?> background-attachment: fixed; margin:0; padding:1px; top: 0; right: 0; bottom: 0; left: 0; }
html, body.login:after { display: block; clear: both; }
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
div#login { background: <?php if($this->aof_options['login_divbg_transparent'] ==1) echo 'transparent'; else echo $this->aof_options['login_divbg_color']; ?>; margin-top: <?php echo $this->aof_options['login_form_margintop']; ?>px; padding: 18px 0 }
body.interim-login div#login {width: 95% !important; height: auto }
.login label, .login form, .login form p { color: <?php echo $this->aof_options['form_text_color']; ?> !important }
.login a { text-decoration: underline; color: <?php echo $this->aof_options['form_link_color']; ?> !important }
.login a:focus, .login a:hover { color: <?php echo $this->aof_options['form_link_hover_color']; ?> !important; }
.login form { background: <?php if($this->aof_options['login_divbg_transparent'] == 1) echo 'transparent'; else echo $this->aof_options['login_formbg_color']; ?> !important; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;<?php if($this->aof_options['login_divbg_transparent'] != 1) echo 'border-bottom: 1px solid ' .$this->aof_options['form_border_color'] . ';'; if($this->aof_options['login_divbg_transparent'] == 1) echo  'padding: 26px 0px 30px !important'; else echo 'padding: 26px 24px 30px !important'; ?> }
form#loginform .button-primary, form#registerform .button-primary, .button-primary { background:<?php echo $this->aof_options['pry_button_color']; ?> !important; border:none !important; color: <?php echo $this->aof_options['pry_button_text_color']; ?> !important; text-shadow: none;}
form#loginform .button-primary.focus,form#loginform .button-primary.hover,form#loginform .button-primary:focus,form#loginform .button-primary:hover, form#registerform .button-primary.focus, form#registerform .button-primary.hover,form#registerform .button-primary:focus,form#registerform .button-primary:hover { background: <?php echo $this->aof_options['pry_button_hover_color']; ?> !important;border-color:<?php echo $this->aof_options['pry_button_hover_border_color']; ?> !important; }
<?php if($this->aof_options['login_divbg_transparent'] == 1) { ?>.login #backtoblog, .login #nav { margin : 0; padding: 0 } .login form { padding-top: 2px !important}<?php } ?>

.login form input.input { background: <?php if(!empty($this->aof_options['login_inputs_bg_color'])) echo $this->aof_options['login_inputs_bg_color']; else echo '#324148' ?> url(<?php echo ALTER_DIR_URI; ?>assets/images/login-sprite.png) no-repeat; 
        padding: 9px 0 9px 38px !important; font-size: 16px !important; line-height: 1; outline: none !important; border: none !important;
color: <?php if(!empty($this->aof_options['login_inputs_text_color'])) echo $this->aof_options['login_inputs_text_color']; else echo '#e5e5e5' ?>;
border:1px solid #101010; box-shadow: 0 0 2px #222;
}

input#user_login { background-position:12px -6px !important; }
input#user_pass, input#user_email, input#pass1, input#pass2 { background-position:12px -56px !important; }
input#user_login, input#pass1, input#pass2 { margin-bottom: 5px }
.login form #wp-submit { width: 100%; height: 35px }
p.forgetmenot { margin-bottom: 16px !important; }
.login #pass-strength-result {margin: 12px 0 16px !important }
p.indicator-hint { clear:both }

/* Message box */
div.updated, .login #login_error, .login .message { border-left: 4px solid <?php echo $this->aof_options['msgbox_border_color']; ?>; background-color: <?php echo $this->aof_options['msg_box_color']; ?>; color: <?php echo $this->aof_options['msgbox_text_color']; ?>; }
div.updated a, .login #login_error a, .login .message a { color: <?php echo $this->aof_options['msgbox_link_color']; ?>; }
div.updated a:hover, .login #login_error a:hover, .login .message a:hover { color: <?php echo $this->aof_options['msgbox_link_hover_color']; ?>; }

.login_footer_content { padding: 40px 0; text-align:center; }
.footer_content { }
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

@media only screen and (min-width: 800px) {
	div#login {
		width: <?php echo $this->aof_options['login_form_width']; ?>% !important;
	}
}
@media screen and (max-width: 800px){
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