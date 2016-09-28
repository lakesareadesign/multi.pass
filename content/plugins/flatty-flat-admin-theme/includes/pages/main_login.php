<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function login_init() {
	//LOGIN
	register_setting("flatty_login", "flatty_logo_hide");
    
	register_setting("flatty_login", "flatty_login_style");
    register_setting("flatty_login", "flatty_login_custom_css");
    register_setting("flatty_login", "flatty_login_custom_bkg");
    
	register_setting("flatty_login", "flatty_login_custom-link");
	register_setting("flatty_login", "flatty_login_custom-link_title");
	register_setting("flatty_login", "flatty_login_hide-lostpassword");
	register_setting("flatty_login", "flatty_login_hide-backtoblog");
	register_setting("flatty_login", "flatty_login_hide-messages");
	register_setting("flatty_login", "flatty_login_hide-errors");
	register_setting("flatty_login", "flatty_login_show-footer");

    register_setting("flatty_login", "flatty_login_recaptcha-use");
    register_setting("flatty_login", "flatty_login_recaptcha-secret");
    register_setting("flatty_login", "flatty_login_recaptcha-site");
    register_setting("flatty_login", "flatty_login_recaptcha-error");
    
}

add_action("admin_init","login_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_login() {
?>

<form method='post' action='options.php'>

	<div class="wrap flatty-form">
		
        <div class="page-title">
            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
            <div class="header"><?php _e('Login', 'flatty-flat-admin-theme' ); ?></div>
        </div>

        <!--LOGO-->
		<div id="login-logo" class="postbox flatty">
			<div class="title">
                <?php
                    $customLogo = get_option('flatty_custom_logo');
                ?>
                <?php if ($customLogo !== false && strlen($customLogo) > 0) {
                    ?>
                    <img
                        id="flatty_custom_logo_img"
                        height="50"
                        style="
                            display: block;
                            position: relative;
                            max-width: 300px;
                            padding: 10px;
                            margin: -40px auto 0;
                            background-color: #ccc;
                            border-radius: 10px;
                            "
                        <?= ($customLogo !== false && strlen($customLogo) > 0) ? 'src="' . $customLogo . '"' : ''  ?>
                    />
                    <?php
                } else {
                    ?>
                        <i class="dashicons dashicons-format-image" style="background-color: #c3c94b;"></i>
                    <?php
                }
                ?>
                <span><?php _e('Logo', 'flatty-flat-admin-theme' ); ?></span>
            </div>

            <div class="option">
                <label for="flatty_logo_hide"><?php _e('Hide logo on login', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="checkbox"
                    name="flatty_logo_hide"
                    id="flatty_logo_hide"
                    value='1'
                    <?php checked(1, get_option('flatty_logo_hide')); ?>
                />
            </div>

            <div id="login-link-url" class="option">
                <label for="flatty_login_custom-link"><?php _e('Change logo link', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="text"
                    name="flatty_login_custom-link"
                    id="flatty_login_custom-link"
                    placeholder="http://www.google.com"
                    value='<?php echo get_option('flatty_login_custom-link'); ?>'
                />
                <div class="flatty-description"><?php _e('The link when you click the logo on login', 'flatty-flat-admin-theme' ); ?></div>
            </div>

            <div id="login-link-title" class="option">
				<label for="flatty_login_custom-link_title"><?php _e('Change logo link title attribute', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="text"
					name="flatty_login_custom-link_title"
					id="flatty_login_custom-link_title"
					placeholder="Leave empty to remove title"
					value='<?php echo get_option('flatty_login_custom-link_title'); ?>'
				/>
                <div class="flatty-description"><?php _e('The title when you hover the link', 'flatty-flat-admin-theme' ); ?></div>
			</div>

        </div>

        <!--BRANDING-->
        <div id="login-style" class="postbox flatty">
            <div class="title">
                <i class="dashicons dashicons-admin-customizer" style="background-color: #e6bc3e;"></i>
                <span><?php _e('Branding', 'flatty-flat-admin-theme' ); ?></span>
            </div>

            <div class="option">
                <label for="flatty_login_show-footer"><?php _e('Show custom footer', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="text"
                    name="flatty_login_show-footer"
                    id="flatty_login_show-footer"
                    placeholder="Custom footer"
                    value='<?php echo get_option('flatty_login_show-footer'); ?>'
                />
                <div class="flatty-description"><?php _e('Leave blank if not necessary', 'flatty-flat-admin-theme' ); ?></div>
            </div>

            <div class="option">
                <label for="flatty_login_hide-backtoblog"><?php _e('Hide "back to blog" link', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="checkbox"
                    name="flatty_login_hide-backtoblog"
                    id="flatty_login_hide-backtoblog"
                    value='1'
                    <?php checked(1, get_option('flatty_login_hide-backtoblog')); ?>
                />
            </div>

            <div id="fl-login-bkg" class="option">
                <?php
                    $customLoginBackground = get_option('flatty_login_custom_bkg');
                ?>

                <img
                    id="flatty_login_custom_bkg_img"
                    width="160"
                    height="80"
                    style="<?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'display:block;' : 'display:none;'  ?>
                    position: relative; max-width: 300px; padding:4px; margin:0 10px 0 0; background-color:#fff; box-shadow: 0 0 20px #dedede; border-radius:10px;"
                    <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'src="' . $customLoginBackground . '"' : ''  ?>
                />

                <label for="flatty_login_custom_bkg"><?php _e('Custom Background', 'flatty-flat-admin-theme' ); ?></label>

                    <input
                        type="hidden"
                        name="flatty_login_custom_bkg"
                        id="flatty_login_custom_bkg"
                        placeholder="Custom Favicon url"
                        value='<?php echo get_option('flatty_login_custom_bkg'); ?>'
                    />

                    <div id="button-remove_login_background"
                        <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
                        class="button-remove"><i class="dashicons dashicons-dismiss"></i>
                    </div>

                    <div id="button-upload_login_background"
                        <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
                        class="button button-primary"><?php _e('Upload Background', 'flatty-flat-admin-theme' ); ?>
                    </div>

                <div class="flatty-description"><?php _e('Recommended image size: 1920px X 1080px', 'flatty-flat-admin-theme' ); ?></div>
            </div>

        </div>

        <!--THEME-->
        <div id="login-theme" class="postbox flatty">
            <div class="title">
                <i class="dashicons dashicons-admin-appearance" style="background-color: #FF5722;"></i>
                <span><?php _e('Theme', 'flatty-flat-admin-theme' ); ?></span>
            </div>

            <div class="option">
                <label for="flatty_login_theme" style="width:100%; margin-bottom:10px;"><?php _e('Choose login theme', 'flatty-flat-admin-theme' ); ?></label>
                <fieldset class="flexy-column">

                    <div class="flexy-element">
                        <?php
                            echo '<img width="145" height="100" style="border: solid 4px #fff; border-radius: 10px; margin-right: 20px; box-shadow: 0 0 20px #dedede;" src="' . plugins_url( '../../assets/imgs/light.jpg', __FILE__ ) . '" > ';
                        ?>
                        <span><?php _e('Light', 'flatty-flat-admin-theme' ); ?></span>
                        <input type="radio" name="flatty_login_style" value="light" <?php checked( 'light', get_option('flatty_login_style') ) ?> />
                    </div>
                    <div class="flexy-element">
                        <?php
                            echo '<img width="145" height="100" style="border: solid 4px #fff; border-radius: 10px; margin-right: 20px; box-shadow: 0 0 20px #dedede;" src="' . plugins_url( '../../assets/imgs/dark.jpg', __FILE__ ) . '" > ';
                        ?>
                        <span><?php _e('Dark', 'flatty-flat-admin-theme' ); ?></span>
                        <input type="radio" name="flatty_login_style" value="dark" <?php checked( 'dark', get_option('flatty_login_style') ) ?> />
                    </div>
                    <div class="flexy-element">
                        <?php
                            echo '<img width="145" height="100" style="border: solid 4px #fff; border-radius: 10px; margin-right: 20px; box-shadow: 0 0 20px #dedede;" src="' . plugins_url( '../../assets/imgs/minimal_light.jpg', __FILE__ ) . '" > ';
                        ?>
                        <span><?php _e('Minimal Light', 'flatty-flat-admin-theme' ); ?></span>
                        <input type="radio" name="flatty_login_style" value="minimal-light" <?php checked( 'minimal-light', get_option('flatty_login_style') ) ?>/>
                    </div>
                    <div class="flexy-element">
                        <?php
                            echo '<img width="145" height="100" style="border: solid 4px #fff; border-radius: 10px; margin-right: 20px; box-shadow: 0 0 20px #dedede;" src="' . plugins_url( '../../assets/imgs/minimal_dark.jpg', __FILE__ ) . '" > ';
                        ?>
                        <span><?php _e('Minimal Dark', 'flatty-flat-admin-theme' ); ?></span>
                        <input type="radio" name="flatty_login_style" value="minimal-dark" <?php checked( 'minimal-dark', get_option('flatty_login_style') ) ?>/>
                    </div>
                    <div class="flexy-element">
                        <div class="">
                            <?php
                                echo '<img width="145" height="100" style="border: solid 4px #fff; border-radius: 10px; margin-right: 20px; box-shadow: 0 0 20px #dedede;" src="' . plugins_url( '../../assets/imgs/custom.jpg', __FILE__ ) . '" > ';
                            ?>
                        </div>
                        <div class="flexy-column">
                            <div class="flexy-element" style="width:100%;">
                                <span><?php _e('Custom CSS', 'flatty-flat-admin-theme' ); ?></span>
                                <input type="radio" name="flatty_login_style" value="custom_css" <?php checked( 'custom_css', get_option('flatty_login_style') ) ?>/>
                            </div>
                            <textarea name="flatty_login_custom_css" style="width:100%;"><?php echo get_option('flatty_login_custom_css'); ?></textarea>  
                        </div>
                    </div>
                
                </fieldset>
            </div>

        </div>

        <!--SECURITY-->
        <div id="login-security" class="postbox flatty">
            <div class="title">
                <i class="dashicons dashicons-lock" style="background-color: #41535e;"></i>
                <span><?php _e('Security', 'flatty-flat-admin-theme' ); ?></span>
            </div>

            <div class="option">
                <label for="flatty_login_recaptcha-use"><?php _e('Use Google Recaptcha', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="checkbox"
                    name="flatty_login_recaptcha-use"
                    id="flatty_login_recaptcha-use"
                    value='1'
                    <?php checked(1, get_option('flatty_login_recaptcha-use')); ?>
                />
            </div>

            <div id="google-recaptcha-config" style="background: linear-gradient(to bottom, rgba(0,0,0,0.15) 0%,rgba(0,0,0,.02) 50%); border-bottom: solid 1px #ECECEC;">

                <div style="font-size:12px;padding:20px; margin:0;"><?php _e('Visit', 'flatty-flat-admin-theme' ); ?> <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('this link', 'flatty-flat-admin-theme' ); ?></a> <?php _e('and register your domain to obtain the Google Recaptcha API keys.', 'flatty-flat-admin-theme' ); ?></div>

                <div class="option">
                    <label for="flatty_login_recaptcha-site"><?php _e('Google Site Key', 'flatty-flat-admin-theme' ); ?></label>
                    <input
                        type="text"
                        name="flatty_login_recaptcha-site"
                        id="flatty_login_recaptcha-site"
                        placeholder="Google Site Key"
                        value='<?php echo get_option('flatty_login_recaptcha-site'); ?>'
                    />
                </div>

                <div class="option">
                    <label for="flatty_login_recaptcha-secret"><?php _e('Google Secret Key', 'flatty-flat-admin-theme' ); ?></label>
                    <input
                        type="text"
                        name="flatty_login_recaptcha-secret"
                        id="flatty_login_recaptcha-secret"
                        placeholder="Google Secret Key"
                        value='<?php echo get_option('flatty_login_recaptcha-secret'); ?>'
                    />
                    <div class="flatty-description"><?php _e('Do not share this key to anyone.', 'flatty-flat-admin-theme' ); ?></div>
                </div>

                <div class="option">
                    <label for="flatty_login_recaptcha-error"><?php _e('Use this custom error when fails', 'flatty-flat-admin-theme' ); ?></label>
                    <input
                        type="text"
                        name="flatty_login_recaptcha-error"
                        id="flatty_login_recaptcha-error"
                        placeholder="Custom error"
                        value='<?php echo get_option('flatty_login_recaptcha-error'); ?>'
                    />
                    <div class="flatty-description"> <?php _e('Shows when a user fails to check the box.', 'flatty-flat-admin-theme' ); ?></div>
                </div>
            </div>

            <div class="option">
				<label for="flatty_login_hide-errors"><?php _e('Hide login errors', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_login_hide-errors"
					id="flatty_login_hide-errors"
					value='1'
					<?php checked(1, get_option('flatty_login_hide-errors')); ?>
				/>
			</div>

            <div class="option">
                <label for="flatty_login_hide-lostpassword"><?php _e('Hide "lost password" link', 'flatty-flat-admin-theme' ); ?></label>
                <input
                    type="checkbox"
                    name="flatty_login_hide-lostpassword"
                    id="flatty_login_hide-lostpassword"
                    value='1'
                    <?php checked(1, get_option('flatty_login_hide-lostpassword')); ?>
                />
            </div>

            <div class="option">
				<label for="flatty_login_hide-messages"><?php _e('Hide every notices and messages', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_login_hide-messages"
					id="flatty_login_hide-messages"
					value='1'
					<?php checked(1, get_option('flatty_login_hide-messages')); ?>
				/>
                <div class="flatty-description"><?php _e('Like "You are now logged out"', 'flatty-flat-admin-theme' ); ?></div>
			</div>

        </div>

	</div>

	<div class="buttons-container">
		<?php
			settings_fields('flatty_login');
			submit_button('', 'primary large flatty-button-update');
		?>
		<div class="flatty-single"><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></div>
	</div>

</form>

<?php
}
?>
