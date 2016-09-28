<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function login_init() {
	//LOGIN
	register_setting("flatty_login", "flatty_logo_hide");
	register_setting("flatty_login", "flatty_login_style");
	register_setting("flatty_login", "flatty_login_custom-link");
	register_setting("flatty_login", "flatty_login_custom-link_title");
	register_setting("flatty_login", "flatty_login_hide-lostpassword");
	register_setting("flatty_login", "flatty_login_hide-backtoblog");
	register_setting("flatty_login", "flatty_login_hide-messages");
	register_setting("flatty_login", "flatty_login_hide-errors");
	register_setting("flatty_login", "flatty_login_show-footer");
}

add_action("admin_init","login_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_login() {
?>

<form method='post' action='options.php'>

	<div class="wrap flatty-form">
		
        <div class="page-title">
            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
            <div class="header">Login</div>
        </div>

		<div id="login-logo" class="postbox flatty">
			<div class="title">
                <i class="fa fa-picture-o" style="background-color: #3ea4e6;"></i>
                <span>Logo</span>
            </div>

            <div class="option">
                <label for="flatty_logo_hide">Hide logo on login</label>
                <input
                    type="checkbox"
                    name="flatty_logo_hide"
                    id="flatty_logo_hide"
                    value='1'
                    <?php checked(1, get_option('flatty_logo_hide')); ?>
                />
            </div>

            <div id="login-link-url" class="option">
                <label for="flatty_login_custom-link">Change logo link</label>
                <input
                    type="text"
                    name="flatty_login_custom-link"
                    id="flatty_login_custom-link"
                    placeholder="http://www.google.com"
                    value='<?php echo get_option('flatty_login_custom-link'); ?>'
                />
                <div class="flatty-description">The link when you click the logo on login</div>
            </div>

            <div id="login-link-title" class="option">
				<label for="flatty_login_custom-link_title">Change logo link title</label>
				<input
					type="text"
					name="flatty_login_custom-link_title"
					id="flatty_login_custom-link_title"
					placeholder="Leave empty to remove title"
					value='<?php echo get_option('flatty_login_custom-link_title'); ?>'
				/>
                <div class="flatty-description">The title when you hover the logo</div>
			</div>

        </div>

        <div id="login-style" class="postbox flatty">
            <div class="title">
                <i class="fa fa-paint-brush" style="background-color: #e6bc3e;"></i>
                <span>Style</span>
            </div>

            <div class="option">
                <label for="flatty_logo_hide">Choose login theme style</label>

                <select id="flatty_login_style" name="flatty_login_style">
                    <option value="light" <?php selected( 'light', get_option('flatty_login_style') ); ?>>Light</option>
                    <option value="dark" <?php selected( 'dark', get_option('flatty_login_style') ); ?>>Dark</option>
                </select>
            </div>

            <div class="option">
                <label for="flatty_login_show-footer">Show custom footer</label>
                <input
                    type="text"
                    name="flatty_login_show-footer"
                    id="flatty_login_show-footer"
                    placeholder="Custom footer"
                    value='<?php echo get_option('flatty_login_show-footer'); ?>'
                />
                <div class="flatty-description">Leave blank if not necessary</div>
            </div>

            <div class="option">
				<label for="flatty_login_hide-backtoblog">Hide "Back to blog"</label>
				<input
					type="checkbox"
					name="flatty_login_hide-backtoblog"
					id="flatty_login_hide-backtoblog"
					value='1'
					<?php checked(1, get_option('flatty_login_hide-backtoblog')); ?>
				/>
			</div>

        </div>

        <div id="login-security" class="postbox flatty">
            <div class="title">
                <i class="fa fa-lock" style="background-color: #41535e;"></i>
                <span>Security</span>
            </div>

            <div class="option">
				<label for="flatty_login_hide-errors">Hide Errors</label>
				<input
					type="checkbox"
					name="flatty_login_hide-errors"
					id="flatty_login_hide-errors"
					value='1'
					<?php checked(1, get_option('flatty_login_hide-errors')); ?>
				/>
			</div>

            <div class="option">
                <label for="flatty_login_hide-lostpassword">Hide "Lost password"</label>
                <input
                    type="checkbox"
                    name="flatty_login_hide-lostpassword"
                    id="flatty_login_hide-lostpassword"
                    value='1'
                    <?php checked(1, get_option('flatty_login_hide-lostpassword')); ?>
                />
            </div>

            <div class="option">
				<label for="flatty_login_hide-messages">Hide Notices and messages</label>
				<input
					type="checkbox"
					name="flatty_login_hide-messages"
					id="flatty_login_hide-messages"
					value='1'
					<?php checked(1, get_option('flatty_login_hide-messages')); ?>
				/>
			</div>

        </div>

	</div>

	<div class="buttons-container">
		<?php
			settings_fields('flatty_login');
			submit_button('', 'primary large flatty-button-update');
		?>
		<div class="flatty-single">*Don't forget to save changes</div>
	</div>

</form>

<?php
}
?>
