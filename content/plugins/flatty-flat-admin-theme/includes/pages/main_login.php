<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function login_init() {
	//LOGIN
	register_setting("flatty_login", "flatty_login_logo_hide");

    register_setting("flatty_login", "flatty_login_logo_customlink_url");
    register_setting("flatty_login", "flatty_login_logo_customlink_title");

    register_setting("flatty_login", "flatty_login_footer_show");
    
    register_setting("flatty_login", "flatty_login_theme_enable");
	register_setting("flatty_login", "flatty_login_theme");
    register_setting("flatty_login", "flatty_login_custom_css_enable");
    register_setting("flatty_login", "flatty_login_custom_css");

    register_setting("flatty_login", "flatty_login_background_enable");
    register_setting("flatty_login", "flatty_login_background_url");
    
	register_setting("flatty_login", "flatty_login_hide_messages");
	register_setting("flatty_login", "flatty_login_hide_errors");
    register_setting("flatty_login", "flatty_login_hide_lostpassword");
    register_setting("flatty_login", "flatty_login_hide_backtoblog");
	
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

    <div class="flatty-header">
        <div class="flatty-flex">
            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
            <h1><?php _e('Login', 'flatty-flat-admin-theme' ); ?></h1>
        </div>
        <div class="flatty-row" style="align-items:flex-start; justify-content: flex-end;">
            <a class="button flatty-button preview" href="..\wp-login.php" target="_blank"><?php _e('View Login', 'flatty-flat-admin-theme' ); ?></a>
            <div class="flatty-column">
                <?php
                    settings_fields('flatty_login');
                    submit_button('', 'flatty-button update');
                ?>
                <p><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></p>
            </div>
        </div>
    </div>

    <div class="flatty-column">

        <div class="flatty-container" id="appearance">
            <div class="flatty-container-title" style="background: linear-gradient(135deg, #3F51B5 0%,#2196F3 100%);">
                <i class="dashicons dashicons-admin-customizer" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Login Appearance', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
                <!--HIDE LOGO-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_logo_hide"><?php _e('Hide logo on login', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('This will hide Wordpress or custom logo from the Login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_logo_hide"
                            id="flatty_login_logo_hide"
                            value='1'
                            <?php checked(1, get_option('flatty_login_logo_hide')); ?>
                        />
                    </div>
                </div>
                <!--HIDE BACK TO BLOG-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_hide_backtoblog"><?php _e('Hide "Back to blog" link', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Add a custom footer to the login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_hide_backtoblog"
                            id="flatty_login_hide_backtoblog"
                            value='1'
                            <?php checked(1, get_option('flatty_login_hide_backtoblog')); ?>
                        />
                    </div>
                </div>
                <!--CHANGE LOGIN URL-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_logo_customlink_url"><?php _e('Change URL of the login logo', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Change the default link.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_logo_customlink_url"
                            id="flatty_login_logo_customlink_url"
                            placeholder="http://www.google.com"
                            value='<?php echo get_option('flatty_login_logo_customlink_url'); ?>'
                        />
                    </div>
                </div>
                <!--CHANGE LOGIN TITLE-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_logo_customlink_title"><?php _e('Change the title of the link', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Change the default link title.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_logo_customlink_title"
                            id="flatty_login_logo_customlink_title"
                            placeholder="http://www.google.com"
                            value='<?php echo get_option('flatty_login_logo_customlink_title'); ?>'
                        />
                    </div>
                </div>
                <!--ADD A CUSTOM FOOTER-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_footer_show"><?php _e('Custom Footer', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Add a custom footer to the login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_footer_show"
                            id="flatty_login_footer_show"
                            placeholder="Custom footer"
                            value='<?php echo get_option('flatty_login_footer_show'); ?>'
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="flatty-container" id="theme">
            <div class="flatty-container-title" style="background: linear-gradient(135deg, #4CAF50 0%,#8BC34A 100%);">
                <i class="dashicons dashicons-art" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Login Theme', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
                <!--USE CUSTOM BACKGROUND-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_background_enable"><?php _e('Enable custom background', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Add a custom background to the page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_background_enable"
                            id="flatty_login_background_enable"
                            value='1'
                            <?php checked(1, get_option('flatty_login_background_enable')); ?>
                        />
                    </div>
                </div>
                <!--CUSTOM BACKGROUND-->
                <div class="flatty-option">
                    <?php
                        $customLoginBackground = get_option('flatty_login_background_url');
                    ?>
                    <div class="flatty-column">
                        <label for="flatty_login_background_url"><?php _e('Custom background', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Recommended image size: 1920px X 1080px', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <!--
                        <img
                            id="flatty_login_background_url_img"
                            width="160"
                            height="80"
                            style="<?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'display:block;' : 'display:none;'  ?>
                            position: relative; max-width: 300px; padding:4px; margin:0 10px 0 0; background-color:#fff; box-shadow: 0 0 20px #dedede; border-radius:10px;"
                            <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'src="' . $customLoginBackground . '"' : ''  ?>
                        />-->
                    </div>
                    <div class="flatty-column">
                        <input
                            type="hidden"
                            name="flatty_login_background_url"
                            id="flatty_login_background_url"
                            value='<?php echo get_option('flatty_login_background_url'); ?>'
                        />
                        <div id="button_flatty_login_background_remove"
                            <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
                            class="button-remove"><i class="dashicons dashicons-dismiss"></i>
                        </div>
                        <div id="button_flatty_login_background_upload"
                            <?= ($customLoginBackground !== false && strlen($customLoginBackground) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
                            class="button button-primary"><?php _e('Upload Background', 'flatty-flat-admin-theme' ); ?>
                        </div>
                    </div>
                </div>
                <!--USE CUSTOM THEME-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_theme_enable"><?php _e('Enable custom theme', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Enable custom theme for login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_theme_enable"
                            id="flatty_login_theme_enable"
                            value='1'
                            <?php checked(1, get_option('flatty_login_theme_enable')); ?>
                        />
                    </div>
                </div>
                <!--CUSTOM THEME-->
                <div class="flatty-option">
                    <fieldset class="flatty-column">
                        <div class="flatty-row">
                            <label for="flatty_login_theme_light">
                                <?php _e('Light theme', 'flatty-flat-admin-theme' ); ?></label>
                                <div class="flatty-preview login-light"></div>
                            </label>
                            <input type="radio" name="flatty_login_theme" value="light" <?php checked( 'light', get_option('flatty_login_theme') ) ?> />
                        </div>
                        <div class="flatty-row">
                            <label for="flatty_login_theme_minimal_light">
                                <?php _e('Minimal Light theme', 'flatty-flat-admin-theme' ); ?></label>
                                <div class="flatty-preview login-minimal-light"></div>
                            </label>
                            <input type="radio" name="flatty_login_theme" value="minimal_light" <?php checked( 'minimal_light', get_option('flatty_login_theme') ) ?> />
                        </div>
                        <div class="flatty-row">
                            <label for="flatty_login_theme_dark">
                                <?php _e('Dark theme', 'flatty-flat-admin-theme' ); ?></label>
                                <div class="flatty-preview login-dark"></div>
                            </label>
                            <input type="radio" name="flatty_login_theme" value="dark" <?php checked( 'dark', get_option('flatty_login_theme') ) ?> />
                        </div>
                        <div class="flatty-row">
                            <label for="flatty_login_theme_minimal_dark">
                                <?php _e('Minimal Dark theme', 'flatty-flat-admin-theme' ); ?></label>
                                <div class="flatty-preview login-minimal-dark"></div>
                            </label>
                            <input type="radio" name="flatty_login_theme" value="minimal_dark" <?php checked( 'minimal_dark', get_option('flatty_login_theme') ) ?> />
                        </div>
                    </fieldset> 
                </div>
            </div>
        </div>

        <div class="flatty-container" id="custom-css">
            <div class="flatty-container-title" style="background: linear-gradient(135deg, #a97a36 0%,#af3c18 100%);">
                <i class="dashicons dashicons-tagcloud" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Custom CSS', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
                <!--ENABLE CUSTOM CSS-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_custom_css_enable"><?php _e('Enable custom css', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Enable custom css for login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_custom_css_enable"
                            id="flatty_login_custom_css_enable"
                            value='1'
                            <?php checked(1, get_option('flatty_login_custom_css_enable')); ?>
                        />
                    </div>
                </div>
                <!--CUSTOM CSS-->
                <div class="flatty-option">
                    <div class="flatty-column" style="justify-content:flex-start;">
                        <label for="flatty_login_custom_css"><?php _e('Custom css', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Use custom css for the login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column" style="flex-grow: 1; margin-left: 20px;">
                        <textarea name="flatty_login_custom_css" style="min-height:150px;">
                            <?php echo get_option('flatty_login_custom_css'); ?>
                        </textarea> 
                    </div>
                </div>
            </div>
        </div>

        <div class="flatty-container" id="security">
            <div class="flatty-container-title" style="background: linear-gradient(135deg, #31373a 0%,#807070 100%);">
                <i class="dashicons dashicons-lock" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Security', 'flatty-flat-admin-theme' ); ?></span>
                <div style="font-size:12px;padding:20px; margin:0;"><?php _e('Visit', 'flatty-flat-admin-theme' ); ?> <a style="color:yellow" href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('this link', 'flatty-flat-admin-theme' ); ?></a> <?php _e('and register your domain to obtain the Google Recaptcha API keys.', 'flatty-flat-admin-theme' ); ?></div>
            </div>
            <div class="flatty-container-content">
                <!--RECAPTCHA-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_recaptcha"><?php _e('Use Google Recaptcha', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Protect your login from Bots.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_recaptcha-use"
                            id="flatty_login_recaptcha-use"
                            value='1'
                            <?php checked(1, get_option('flatty_login_recaptcha-use')); ?>
                        />
                    </div>
                </div>
                <!--GOOGLE SITE KEY-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_recaptcha-site"><?php _e('Google Site Key', 'flatty-flat-admin-theme' ); ?></label>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_recaptcha-site"
                            id="flatty_login_recaptcha-site"
                            placeholder="Google Site Key"
                            value='<?php echo get_option('flatty_login_recaptcha-site'); ?>'
                        />
                    </div>
                </div>
                <!--GOOGLE SECRET KEY-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_recaptcha-secret"><?php _e('Google Secret Key', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Do not share this key to anyone.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_recaptcha-secret"
                            id="flatty_login_recaptcha-secret"
                            placeholder="Google Secret Key"
                            value='<?php echo get_option('flatty_login_recaptcha-secret'); ?>'
                        />
                    </div>
                </div>
                <!--GOOGLE ERROR-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_recaptcha-error"><?php _e('Use this custom error when fails', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"> <?php _e('Shows when a user fails to check the box.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="text"
                            name="flatty_login_recaptcha-error"
                            id="flatty_login_recaptcha-error"
                            placeholder="Custom error"
                            value='<?php echo get_option('flatty_login_recaptcha-error'); ?>'
                        />
                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="flatty-container" id="misc">
            <div class="flatty-container-title" style="background: linear-gradient(135deg, #607D8B 0%,#9E9E9E 100%);">
                <i class="dashicons dashicons-admin-network" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Misc', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
                <!--HIDE LOGIN MESSAGES-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_hide_messages"><?php _e('Hide login messages', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Hide every kind of message on login page.', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_hide_messages"
                            id="flatty_login_hide_messages"
                            value='1'
                            <?php checked(1, get_option('flatty_login_hide_messages')); ?>
                        />
                    </div>
                </div>
                <!--HIDE LOGIN ERROR-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_hide_errors"><?php _e('Hide login errors', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Hide every message of error on the login page (like wrong password).', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_hide_errors"
                            id="flatty_login_hide_errors"
                            value='1'
                            <?php checked(1, get_option('flatty_login_hide_errors')); ?>
                        />
                    </div>
                </div>
                <!--HIDE LOGIN LOST PASSWORD-->
                <div class="flatty-option">
                    <div class="flatty-column">
                        <label for="flatty_login_hide_lostpassword"><?php _e('Hide "Lost Password" link', 'flatty-flat-admin-theme' ); ?></label>
                        <div class="flatty-description"><?php _e('Hide the lost password link (reduce spam).', 'flatty-flat-admin-theme' ); ?></div>
                    </div>
                    <div class="flatty-column">
                        <input
                            type="checkbox"
                            name="flatty_login_hide_lostpassword"
                            id="flatty_login_hide_lostpassword"
                            value='1'
                            <?php checked(1, get_option('flatty_login_hide_lostpassword')); ?>
                        />
                    </div>
                </div>
                
            </div>
        </div>

</form>

<?php
}
?>
