<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function appearance_init() {
	//GENERAL
	register_setting("flatty_appearance", "flatty_google_font");
	register_setting("flatty_appearance", "flatty_wp_hide_topbar_logo");
	register_setting("flatty_appearance", "flatty_hide_worpdress_toolbar_frontend");
	register_setting("flatty_appearance", "flatty_wordpress_remove_generator");
	register_setting("flatty_appearance", "flatty_remove_help_menu");

	//BRANDING
	register_setting("flatty_appearance", "flatty_use_flatty_topbar");
	register_setting("flatty_appearance", "flatty_fixed_topbar");
	register_setting("flatty_appearance", "flatty_tall_topbar");
	register_setting("flatty_appearance", "flatty_show_topbar_profile");
	register_setting("flatty_appearance", "flatty_show_topbar_image");
	
	register_setting("flatty_appearance", "flatty_topbar_background_custom");
	register_setting("flatty_appearance", "flatty_topbar_background_color");
	register_setting("flatty_appearance", "flatty_topbar_background_image");
	register_setting("flatty_appearance", "flatty_topbar_background_type");
	register_setting("flatty_appearance", "flatty_topbar_background_blend");
	
	register_setting("flatty_appearance", "flatty_show_sitename");
	register_setting("flatty_appearance", "flatty_show_custom_sitename");
	register_setting("flatty_appearance", "flatty_where_sitename");
	register_setting("flatty_appearance", "flatty_custom_logo");
	register_setting("flatty_appearance", "flatty_hide_custom_logo");
	register_setting("flatty_appearance", "flatty_custom_favicon");

	//THEME SETTINGS
	register_setting("flatty_appearance", "flatty_new_checkbox");

	//SIDEBAR SETTINGS
	register_setting("flatty_appearance", "flatty_sidebar_folded");

	//FOOTER
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_custom_text");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_wordpress");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_mysql");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_php");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_server_protocol");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_server_address");
	register_setting("flatty_appearance", "flatty_wp_flatty_footer_show_server_software");
}

add_action("admin_init","appearance_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_appearance() {
?>

<form method='post' action='options.php'>

	<div class="flatty-header">
		<div class="flatty-flex">
	        <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
	        <h1><?php _e('Appearance', 'flatty-flat-admin-theme' ); ?></h1>
	    </div>
		<div class="flatty-column">
			<?php
				settings_fields('flatty_appearance');
				submit_button('', 'flatty-button update');
			?>
			<p><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></p>
		</div>
    </div>

	<div class="flatty-column">

		<div class="flatty-container" id="general">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #2196F3 0%,#607D8B 100%);">
				<i class="dashicons dashicons-admin-settings" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('General', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--SYSTEM FONT-->
            	<div class="flatty-option">
            		<div class="flatty-column">
						<label for="flatty_google_font"><?php _e('Use Google Font instead of System Font', 'flatty-flat-admin-theme' ); ?></label>
						<div class="flatty-description"><?php _e('System font is quicker, custom font is nicer (on Windows xD)', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_google_font"
							id="flatty_google_font"
							value='1'
							<?php checked(1, get_option('flatty_google_font')); ?>
						/>
					</div>
            	</div>
            	<!--HIDE META LINKS-->
            	<div class="flatty-option">
            		<div class="flatty-column">
						<label for="flatty_remove_help_menu"><?php _e('Remove help menu', 'flatty-flat-admin-theme' ); ?></label>
						<div class="flatty-description"><?php _e('Removes Wordpress "Help" dropdown menu', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_remove_help_menu"
							id="flatty_remove_help_menu"
							value='1'
							<?php checked(1, get_option('flatty_remove_help_menu')); ?>
						/>
					</div>
            	</div>
            	<!--WORDPRESS LOGO-->
            	<div class="flatty-option">
            		<div class="flatty-column">
						<label for="flatty_wp_hide_topbar_logo"><?php _e('Remove Wordpress Logo', 'flatty-flat-admin-theme' ); ?></label>
						<div class="flatty-description"><?php _e('When the default Wordpress toolbar is enabled', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_hide_topbar_logo"
							id="flatty_wp_hide_topbar_logo"
							value='1'
							<?php checked(1, get_option('flatty_wp_hide_topbar_logo')); ?>
						/>
					</div>
            	</div>
            	<!--WORDPRESS TOOLBAR FRONTEND-->
            	<div class="flatty-option">
            		<div class="flatty-column">
						<label for="flatty_hide_worpdress_toolbar_frontend"><?php _e('Force remove Wordpress Toolbar from Front-end', 'flatty-flat-admin-theme' ); ?></label>
						<div class="flatty-description"><?php _e('The black toolbar that shows on top of your site when you are logged in', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_hide_worpdress_toolbar_frontend"
							id="flatty_hide_worpdress_toolbar_frontend"
							value='1'
							<?php checked(1, get_option('flatty_hide_worpdress_toolbar_frontend')); ?>
						/>
					</div>
            	</div>
            	<!--WORDPRESS META TAGS-->
            	<div class="flatty-option">
            		<div class="flatty-column">
						<label for="flatty_wordpress_remove_generator"><?php _e('Remove Wordpress meta tags', 'flatty-flat-admin-theme' ); ?></label>
						<div class="flatty-description"><?php _e('Like "generated by Wordpress" and Wordpress version in the "head"', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wordpress_remove_generator"
							id="flatty_wordpress_remove_generator"
							value='1'
							<?php checked(1, get_option('flatty_wordpress_remove_generator')); ?>
						/>
					</div>
            	</div>
            </div>
        </div>

        <div class="flatty-container" id="custom-logo-box">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
				<i class="dashicons dashicons-welcome-view-site" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Custom Logo', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--CUSTOM LOGO-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_custom_logo"><?php _e('Custom Logo', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Upload a custom logo to show in the custom header. Recommended max height 50px.', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
		            	<?php
							$customLogo = get_option('flatty_custom_logo');
						?>
						<input
							type="hidden"
							name="flatty_custom_logo"
							id="flatty_custom_logo"
							placeholder="Custom logo url"
							value='<?php echo get_option('flatty_custom_logo'); ?>'
						/>

						<div id="button-remove_logo"
							<?= ($customLogo !== false && strlen($customLogo) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
							class="button-remove"><i class="dashicons dashicons-dismiss"></i>
						</div>

						<div id="button-upload_logo"
							<?= ($customLogo !== false && strlen($customLogo) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
							class="button button-primary"><?php _e('Upload Logo', 'flatty-flat-admin-theme' ); ?>
						</div>
					</div>
            	</div>
            	<!--CUSTOM FAVICON-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_custom_favicon"><?php _e('Custom Favicon', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Max image size: 96px X 96px', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
	            		<?php
							$customFavIcon = get_option('flatty_custom_favicon');
						?>
		            	<img
							id="flatty_custom_favicon_img"
							style="<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'display:block;' : 'display:none;'  ?>
							position: relative; max-width: 32px; max-height: 32px;"
							<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'src="' . $customFavIcon . '"' : ''  ?>
						/>
					</div>
	            	<div class="flatty-column">
						<input
							type="hidden"
							name="flatty_custom_favicon"
							id="flatty_custom_favicon"
							placeholder="Custom Favicon url"
							value='<?php echo get_option('flatty_custom_favicon'); ?>'
						/>

						<div id="button-remove_favicon"
							<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
							class="button-remove"><i class="dashicons dashicons-dismiss"></i>
						</div>

						<div id="button-upload_favicon"
							<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
							class="button button-primary"><?php _e('Upload Favicon', 'flatty-flat-admin-theme' ); ?>
						</div>
					</div>
            	</div>
            </div>
        </div>
		
		<div class="flatty-container" id="sidebar">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
				<i class="dashicons dashicons-list-view" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Sidebar', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--FOLDED SIDEBAR-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_sidebar_folded"><?php _e('Enable always folded sidebar', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('This helps to add some horizontal space.', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_sidebar_folded"
							id="flatty_sidebar_folded"
							value='1'
							<?php checked(1, get_option('flatty_sidebar_folded')); ?>
						/>
					</div>
            	</div>
            </div>
        </div>

        <div class="flatty-container" id="components">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
				<i class="dashicons dashicons-welcome-widgets-menus" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Components', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--CHECKBOX & RADIO-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_new_checkbox"><?php _e('Disable new checkbox/radio style', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Disable if you have compatibility issues', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_new_checkbox"
							id="flatty_new_checkbox"
							value='1'
							<?php checked(1, get_option('flatty_new_checkbox')); ?>
						/>
					</div>
            	</div>
            </div>
        </div>

        <div class="flatty-container" id="topbar">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #8BC34A 0%,#CDDC39 100%);">
				<i class="dashicons dashicons-menu" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Flatty\'s Admin Bar', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--ENABLE CUSTOM TOPBAR-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_use_flatty_topbar"><?php _e('Enable custom admin bar', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('The full experience of Flatty ;)', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_use_flatty_topbar"
							id="flatty_use_flatty_topbar"
							value='1'
							<?php checked(1, get_option('flatty_use_flatty_topbar')); ?>
						/>
					</div>
            	</div>
            	<!--ENABLE FIXED TOPBAR-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_fixed_topbar"><?php _e('Enable fixed topbar', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Make it sticky to the top', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_fixed_topbar"
							id="flatty_fixed_topbar"
							value='1'
							<?php checked(1, get_option('flatty_fixed_topbar')); ?>
						/>
					</div>
            	</div>
            	<!--ENABLE TALL TOOLBAR-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_tall_topbar"><?php _e('Enable tall topbar', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('When size matters ;)', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_tall_topbar"
							id="flatty_tall_topbar"
							value='1'
							<?php checked(1, get_option('flatty_tall_topbar')); ?>
						/>
					</div>
            	</div>
            	<!--SHOW SITE NAME-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_show_sitename"><?php _e('Add site/blog name', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Add the title of the site to the topbar', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_show_sitename"
							id="flatty_show_sitename"
							value='1'
							<?php checked(1, get_option('flatty_show_sitename')); ?>
						/>
					</div>
            	</div>
            	<!--USE CUSTOM NAME-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_show_custom_sitename"><?php _e('Use a custom site/blog name', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Leave blank if not needed', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="text"
							name="flatty_show_custom_sitename"
							id="flatty_show_custom_sitename"
							maxlength="20"
							placeholder="<?php echo get_option('blogname'); ?>"
							value='<?php echo get_option('flatty_show_custom_sitename'); ?>'
						/>
					</div>
            	</div>
            	<!--SHOW USER PROFILE-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_show_topbar_profile"><?php _e('Add user profile', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Add the user profile shortcut to the topbar', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_show_topbar_profile"
							id="flatty_show_topbar_profile"
							value='1'
							<?php checked(1, get_option('flatty_show_topbar_profile')) ?>
						/>
					</div>
            	</div>
            	<!--SHOW USER PROFILE IMAGE-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_show_topbar_image"><?php _e('Use profile image', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('I will use your profile image instead of nothing', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_show_topbar_image"
							id="flatty_show_topbar_image"
							value='1'
							<?php checked(1, get_option('flatty_show_topbar_image')) ?>
						/>
					</div>
            	</div>
            	<!--CUSTOM BACKGROUND-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_topbar_background_custom"><?php _e('Use custom background', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Change the aspect of the background', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_topbar_background_custom"
							id="flatty_topbar_background_custom"
							value='1'
							<?php checked(1, get_option('flatty_topbar_background_custom')) ?>
						/>
					</div>
            	</div>
            	<!--CUSTOM BACKGROUND COLOR-->
            	<div class="flatty-option" id="custom_background_color">
            		<div class="flatty-column">
	            		<label for="flatty_topbar_background_color"><?php _e('Choose color', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Change the color of the background', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="text"
							class="color_field"
							name="flatty_topbar_background_color"
							id="flatty_topbar_background_color"
							value='<?php echo get_option('flatty_topbar_background_color'); ?>'
						/>
					</div>
            	</div>
            	<!--CUSTOM BACKGROUND IMAGE-->
            	<div class="flatty-option" id="custom_background_image">
            		<?php
						$customTopbarBackgroundImage = get_option('flatty_topbar_background_image');
					?>
            		<div class="flatty-column">
	            		<label for="flatty_topbar_background_image"><?php _e('Custom Background Image', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Recommended image size: 1920px X 180px.', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="hidden"
							name="flatty_topbar_background_image"
							id="flatty_topbar_background_image"
							placeholder="Custom Background Image"
							value='<?php echo get_option('flatty_topbar_background_image'); ?>'
						/>

						<div id="button-remove_background_image"
							<?= ($customTopbarBackgroundImage !== false && strlen($customTopbarBackgroundImage) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
							class="button-remove"><i class="dashicons dashicons-dismiss"></i>
						</div>

						<div id="button-upload_background_image"
							<?= ($customTopbarBackgroundImage !== false && strlen($customTopbarBackgroundImage) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
							class="button button-primary"><?php _e('Upload Background', 'flatty-flat-admin-theme' ); ?>
						</div>
					</div>
            	</div>
            	<!--CUSTOM BACKGROUND TYPE-->
            	<div class="flatty-option" id="custom_background_type">
            		<div class="flatty-column">
	            		<label for="flatty_topbar_background_type"><?php _e('Background Type', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('It\'s a pattern or an image?', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<select id="flatty_topbar_background_type" name="flatty_topbar_background_type">
							<option value="image" <?php selected( 'image', get_option('flatty_topbar_background_type') ); ?>> <?php _e('Image (cover)', 'flatty-flat-admin-theme' ); ?></option>
							<option value="pattern" <?php selected( 'pattern', get_option('flatty_topbar_background_type') ); ?>> <?php _e('Pattern (repeat)', 'flatty-flat-admin-theme' ); ?></option>
						</select>
					</div>
            	</div>
            	<!--CUSTOM BACKGROUND BLEND-->
            	<div class="flatty-option" id="custom_background_blend">
            		<div class="flatty-column">
	            		<label for="flatty_topbar_background_blend"><?php _e('Background Blending style', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Design at it\'s finest', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<select id="flatty_topbar_background_blend" name="flatty_topbar_background_blend">
							<option value="normal" <?php selected( 'normal', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Normal', 'flatty-flat-admin-theme' ); ?></option>
							<option value="color" <?php selected( 'color', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Color', 'flatty-flat-admin-theme' ); ?></option>
							<option value="color-burn" <?php selected( 'color-burn', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Color-burn', 'flatty-flat-admin-theme' ); ?></option>
							<option value="color-dodge" <?php selected( 'color-dodge', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Color-dodge', 'flatty-flat-admin-theme' ); ?></option>
							<option value="darken" <?php selected( 'darken', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Darken', 'flatty-flat-admin-theme' ); ?></option>
							<option value="difference" <?php selected( 'difference', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Difference', 'flatty-flat-admin-theme' ); ?></option>
							<option value="exclusion" <?php selected( 'exclusion', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Exclusion', 'flatty-flat-admin-theme' ); ?></option>
							<option value="hard-light" <?php selected( 'hard-light', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Hard-light', 'flatty-flat-admin-theme' ); ?></option>
							<option value="hue" <?php selected( 'hue', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Hue', 'flatty-flat-admin-theme' ); ?></option>
							<option value="lighten" <?php selected( 'lighten', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Lighten', 'flatty-flat-admin-theme' ); ?></option>
							<option value="luminosity" <?php selected( 'luminosity', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Luminosity', 'flatty-flat-admin-theme' ); ?></option>
							<option value="multiply" <?php selected( 'multiply', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Multiply', 'flatty-flat-admin-theme' ); ?></option>
							<option value="overlay" <?php selected( 'overlay', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Overlay', 'flatty-flat-admin-theme' ); ?></option>
							<option value="saturation" <?php selected( 'saturation', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Saturation', 'flatty-flat-admin-theme' ); ?></option>
							<option value="screen" <?php selected( 'screen', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Screen', 'flatty-flat-admin-theme' ); ?></option>
							<option value="soft-light" <?php selected( 'soft-light', get_option('flatty_topbar_background_blend') ); ?>> <?php _e('Soft-light', 'flatty-flat-admin-theme' ); ?></option>
						</select>
					</div>
            	</div>
            </div>
        </div>

        <div class="flatty-container" id="footer">
			<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
				<i class="dashicons dashicons-info" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
                <span><?php _e('Custom Footer', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="flatty-container-content">
            	<!--USE CUSTOM FOOTER-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show"><?php _e('Enable custom footer', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('This will hide Worpdress "Thank You" and version by default', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show"
							id="flatty_wp_flatty_footer_show"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show')); ?>
						/>
					</div>
            	</div>
            	<!--ADD CUSTOM TEXT-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_custom_text"><?php _e('Add custom text', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Leave blank if not needed', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="text"
							name="flatty_wp_flatty_footer_custom_text"
							id="flatty_wp_flatty_footer_custom_text"
							placeholder="Luke, i am your father"
							value='<?php echo get_option('flatty_wp_flatty_footer_custom_text'); ?>'
						/>
					</div>
            	</div>
            	<!--ADD WORDPRESS VERSION-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_wordpress"><?php _e('Add Wordpress version', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Don\'t read me', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_wordpress"
							id="flatty_wp_flatty_footer_show_wordpress"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_wordpress')); ?>
						/>
					</div>
            	</div>
            	<!--ADD MYSQL VERSION-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_mysql"><?php _e('Add MySql version', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Don\'t work in all servers :/', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_mysql"
							id="flatty_wp_flatty_footer_show_mysql"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_mysql')); ?>
						/>
					</div>
            	</div>
            	<!--ADD PHP VERSION-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_php"><?php _e('Add Php version', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('Don\'t work in all servers :/', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_php"
							id="flatty_wp_flatty_footer_show_php"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_php')); ?>
						/>
					</div>
            	</div>
            	<!--ADD SERVER PROTOCOL-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_server_protocol"><?php _e('Add server protocol (Ex: HTTP/1.1)', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('It\'s just BLA BLA BLA if you don\'t need it ;)', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_server_protocol"
							id="flatty_wp_flatty_footer_show_server_protocol"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_server_protocol')); ?>
						/>
					</div>
            	</div>
            	<!--ADD SERVER ADDRESS-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_server_address"><?php _e('Add server address', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('It\'s just BLA BLA BLA if you don\'t need it ;)', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_server_address"
							id="flatty_wp_flatty_footer_show_server_address"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_server_address')); ?>
						/>
					</div>
            	</div>
            	<!--ADD SERVER ADDRESS-->
            	<div class="flatty-option">
            		<div class="flatty-column">
	            		<label for="flatty_wp_flatty_footer_show_server_software"><?php _e('Add server identification string', 'flatty-flat-admin-theme' ); ?></label>
	            		<div class="flatty-description"><?php _e('That\'s real BLA BLA BLA', 'flatty-flat-admin-theme' ); ?></div>
	            	</div>
	            	<div class="flatty-column">
						<input
							type="checkbox"
							name="flatty_wp_flatty_footer_show_server_software"
							id="flatty_wp_flatty_footer_show_server_software"
							value='1'
							<?php checked(1, get_option('flatty_wp_flatty_footer_show_server_software')); ?>
						/>
					</div>
            	</div>
            </div>
        </div>

	</div>

</form>

<?php
}
?>
