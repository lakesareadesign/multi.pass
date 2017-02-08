<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function branding_init() {
	//BRANDING
	register_setting("flatty_branding", "flatty_use_flatty_topbar");
	register_setting("flatty_branding", "flatty_fixed_topbar");
	register_setting("flatty_branding", "flatty_show_topbar_profile");
	register_setting("flatty_branding", "flatty_show_topbar_image");
	
	register_setting("flatty_branding", "flatty_topbar_background_custom");
	register_setting("flatty_branding", "flatty_topbar_background_color");
	register_setting("flatty_branding", "flatty_topbar_background_image");
	
	register_setting("flatty_branding", "flatty_show_sitename");
	register_setting("flatty_branding", "flatty_show_custom_sitename");
	register_setting("flatty_branding", "flatty_where_sitename");
	register_setting("flatty_branding", "flatty_custom_logo");
	register_setting("flatty_branding", "flatty_hide_custom_logo");
	register_setting("flatty_branding", "flatty_custom_favicon");

	//CUSTOMER SERVICE BOX
	register_setting("flatty_branding", "flatty_show_customer_service_box");
	register_setting("flatty_branding", "flatty_where_customer_service_box");
	register_setting("flatty_branding", "flatty_show_customer_service_box_widget_title");
	register_setting("flatty_branding", "flatty_show_customer_service_box_widget_description");
	register_setting("flatty_branding", "flatty_show_customer_service_box_name");
	register_setting("flatty_branding", "flatty_show_customer_service_box_website");
	register_setting("flatty_branding", "flatty_show_customer_service_box_email");
	register_setting("flatty_branding", "flatty_show_customer_service_box_phone");
	register_setting("flatty_branding", "flatty_show_customer_service_logo");

	//THEME SETTINGS
	register_setting("flatty_branding", "flatty_system_font");
	register_setting("flatty_branding", "flatty_hide_worpdress_toolbar_frontend");

	//SIDEBAR SETTINGS
	register_setting("flatty_branding", "flatty_sidebar_folded");

	//WHITELABELING
	register_setting("flatty_branding", "flatty_wp_hide_topbar_logo");
	register_setting("flatty_branding", "flatty_wordpress_remove_generator");

	//FOOTER
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_custom_text");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_wordpress");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_mysql");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_php");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_server_protocol");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_server_address");
	register_setting("flatty_branding", "flatty_wp_flatty_footer_show_server_software");
}

add_action("admin_init","branding_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_branding() {
?>

<form method='post' action='options.php'>

	<div class="wrap flatty-form">

        <div class="page-title">
            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
            <div class="header"><?php _e('Branding', 'flatty-flat-admin-theme' ); ?></div>
        </div>

        <div id="custom-logo-box" class="postbox flatty">
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
                <span><?php _e('Custom Logo', 'flatty-flat-admin-theme' ); ?></span>
            </div>

			<div class="option">
				<label for="flatty_custom_logo"><?php _e('Custom Logo', 'flatty-flat-admin-theme' ); ?></label>
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

				<div class="flatty-description"><?php _e('Recommended max height 50px', 'flatty-flat-admin-theme' ); ?></div>
			</div>

			<div class="option">
				<label for="flatty_hide_custom_logo"><?php _e('Hide custom Logo in the admin area', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_hide_custom_logo"
					id="flatty_hide_custom_logo"
					value='1'
					<?php checked(1, get_option('flatty_hide_custom_logo')); ?>
				/>
			</div>

			<div id="fl-favicon" class="option">
				<?php
					$customFavIcon = get_option('flatty_custom_favicon');
				?>

				<img
					id="flatty_custom_favicon_img"
					width="16"
					height="16"
					style="<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'display:block;' : 'display:none;'  ?>
					position: relative; max-width: 300px; padding:10px; margin:0 10px 0 0; background-color:#ccc; border-radius:4px;"
					<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'src="' . $customFavIcon . '"' : ''  ?>
				/>

				<label for="flatty_custom_favicon"><?php _e('Custom Favicon', 'flatty-flat-admin-theme' ); ?></label>

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

				<div class="flatty-description"><?php _e('Recommended image size: 16px X 16px', 'flatty-flat-admin-theme' ); ?></div>
			</div>
		</div>

		<div id="whitelabel-box" class="postbox flatty">
			<div class="title">
                <i class="dashicons dashicons-wordpress" style="background-color: #404386;"></i>
                <span><?php _e('Whitelabel Wordpress', 'flatty-flat-admin-theme' ); ?></span>
            </div>
            <div class="option">
				<label for="flatty_hide_worpdress_toolbar_frontend"><?php _e('Remove Wordpress Toolbar from Front-end', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_hide_worpdress_toolbar_frontend"
					id="flatty_hide_worpdress_toolbar_frontend"
					value='1'
					<?php checked(1, get_option('flatty_hide_worpdress_toolbar_frontend')); ?>
				/>
			</div>
			<div class="option">
				<label for="flatty_wordpress_remove_generator"><?php _e('Remove Wordpress meta tags', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_wordpress_remove_generator"
					id="flatty_wordpress_remove_generator"
					value='1'
					<?php checked(1, get_option('flatty_wordpress_remove_generator')); ?>
				/>
				<div class="flatty-description"><?php _e('Like "generated by Wordpress" and Wordpress version in the "head"', 'flatty-flat-admin-theme' ); ?></div>
			</div>
			<div class="option">
				<label for="flatty_wp_hide_topbar_logo"><?php _e('Hide Wordpress Logo', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_wp_hide_topbar_logo"
					id="flatty_wp_hide_topbar_logo"
					value='1'
					<?php checked(1, get_option('flatty_wp_hide_topbar_logo')); ?>
				/>
				<div class="flatty-description"><?php _e('If Wordpress default topbar is enabled', 'flatty-flat-admin-theme' ); ?></div>
			</div>
        </div>

		<div id="branding-box" class="postbox flatty">
			<div class="title">
		    	<i class="dashicons dashicons-megaphone" style="background-color: #c949c4;"></i>
		    	<span><?php _e('Generic', 'flatty-flat-admin-theme' ); ?></span>
		    </div>

      		<div class="option">
				<label for="flatty_system_font"><?php _e('Use system Font instead of Google Font', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_system_font"
					id="flatty_system_font"
					value='1'
					<?php checked(1, get_option('flatty_system_font')); ?>
				/>
				<div class="flatty-description"><?php _e('System font is quicker, custom font is nicer', 'flatty-flat-admin-theme' ); ?></div>
			</div>

			<div class="option">
				<label for="flatty_sidebar_folded"><?php _e('Enable always folded sidebar', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_sidebar_folded"
					id="flatty_sidebar_folded"
					value='1'
					<?php checked(1, get_option('flatty_sidebar_folded')); ?>
				/>
			</div>

    	</div>

    	<div id="custom-topbar-box" class="postbox flatty">
			<div class="title">
		        <i class="dashicons dashicons-menu" style="background-color: #FFC107;"></i>
		        <span><?php _e('Custom Admin Topbar', 'flatty-flat-admin-theme' ); ?></span>
	    	</div>

	    	<div class="option">
				<label for="flatty_use_flatty_topbar"><?php _e('Use Flatty\'s Topbar instead of Wordpress default', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_use_flatty_topbar"
					id="flatty_use_flatty_topbar"
					value='1'
					<?php checked(1, get_option('flatty_use_flatty_topbar')); ?>
				/>
			</div>

			<div id="flatty_topbar_addons" style="background:#eee; border-bottom: solid 1px #e6e6e6;">
				<div class="option">
					<label for="flatty_fixed_topbar"><?php _e('Enable fixed topbar', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_fixed_topbar"
						id="flatty_fixed_topbar"
						value='1'
						<?php checked(1, get_option('flatty_fixed_topbar')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_show_topbar_profile"><?php _e('Show user profile in the topbar', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_show_topbar_profile"
						id="flatty_show_topbar_profile"
						value='1'
						<?php checked(1, get_option('flatty_show_topbar_profile')) ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_show_topbar_image"><?php _e('Show user image in the topbar', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_show_topbar_image"
						id="flatty_show_topbar_image"
						value='1'
						<?php checked(1, get_option('flatty_show_topbar_image')) ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_topbar_background_custom"><?php _e('Use custom background', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_topbar_background_custom"
						id="flatty_topbar_background_custom"
						value='1'
						<?php checked(1, get_option('flatty_topbar_background_custom')) ?>
					/>
				</div>

				<div id="custom_background_color" class="option">
					<label for="flatty_topbar_background_color"><?php _e('Choose color', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_topbar_background_color"
						id="flatty_topbar_background_color"
						value='<?php echo get_option('flatty_topbar_background_color'); ?>'
					/>
				</div>

				<div id="fl-topbar_background_image" class="option">
					<?php
						$customTopbarBackgroundImage = get_option('flatty_topbar_background_image');
					?>

					<label for="flatty_topbar_background_image"><?php _e('Custom Background Image', 'flatty-flat-admin-theme' ); ?></label>

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

					<div class="flatty-description"><?php _e('Recommended image size: 1920px X 70px', 'flatty-flat-admin-theme' ); ?></div>
				</div>
			</div>

			<div class="option">
				<label for="flatty_show_sitename"><?php _e('Show this site name', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_show_sitename"
					id="flatty_show_sitename"
					value='1'
					<?php checked(1, get_option('flatty_show_sitename')); ?>
				/>
			</div>

			<div id="option_flatty_show_sitename" style="background:#eee; border-bottom: solid 1px #e6e6e6;">
				<div class="option">
					<label for="flatty_show_custom_sitename"><?php _e('or use a custom header', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_show_custom_sitename"
						id="flatty_show_custom_sitename"
						maxlength="20"
						placeholder="<?php echo get_option('blogname'); ?>"
						value='<?php echo get_option('flatty_show_custom_sitename'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_where_sitename"><?php _e('and place it', 'flatty-flat-admin-theme' ); ?></label>
					<select id="flatty_where_sitename" name="flatty_where_sitename">
						<option value="topbar" <?php selected( 'topbar', get_option('flatty_where_sitename') ); ?>> <?php _e('in the Flatty\'s top bar (if enabled)', 'flatty-flat-admin-theme' ); ?></option>
						<option value="h-small" <?php selected( 'h-small', get_option('flatty_where_sitename') ); ?>> <?php _e('as a small header', 'flatty-flat-admin-theme' ); ?></option>
						<option value="h-big" <?php selected( 'h-big', get_option('flatty_where_sitename') ); ?>> <?php _e('as a big header', 'flatty-flat-admin-theme' ); ?></option>
					</select>
				</div>
			</div>
	    </div>

		<div id="customer-service-box" class="postbox flatty">
			<div class="title">
		        <i class="dashicons dashicons-id" style="background-color: #4ac96a;"></i>
		        <span><?php _e('Customer service box', 'flatty-flat-admin-theme' ); ?></span>
	    	</div>

			<div class="option">
				<label for="flatty_show_customer_service_box"><?php _e('Show customer service box', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_show_customer_service_box"
					id="flatty_show_customer_service_box"
					value='1'
					<?php checked(1, get_option('flatty_show_customer_service_box')); ?>
				/>
				<div class="flatty-description"><?php _e('Company\'s or developer\'s contacts', 'flatty-flat-admin-theme' ); ?></div>
			</div>

			<div id="info_customer_service_box" style="background:#eee; border-bottom: solid 1px #e6e6e6;">

				<div id="option_flatty_where_customer_service_box" class="option">
					<label for="flatty_where_customer_service_box"><?php _e('and place it', 'flatty-flat-admin-theme' ); ?></label>
					<select id="flatty_where_customer_service_box" name="flatty_where_customer_service_box">
						<option value="panel" <?php selected( 'panel', get_option('flatty_where_customer_service_box') ); ?>> <?php _e('in his separate panel', 'flatty-flat-admin-theme' ); ?></option>
						<option value="topbar" <?php selected( 'topbar', get_option('flatty_where_customer_service_box') ); ?>> <?php _e('in the Flatty\'s top bar (if enabled)', 'flatty-flat-admin-theme' ); ?></option>
						<option value="widget" <?php selected( 'widget', get_option('flatty_where_customer_service_box') ); ?>> <?php _e('as a Widget in the admin dashboard', 'flatty-flat-admin-theme' ); ?></option>
					</select>
				</div>

				<div id="info_customer_service_box_widget">
					<div class="option">
						<label for="flatty_show_customer_service_box_name"><?php _e('Widget title', 'flatty-flat-admin-theme' ); ?></label>
						<input
							type="text"
							name="flatty_show_customer_service_box_widget_title"
							id="flatty_show_customer_service_box_widget_title"
							maxlength="30"
							placeholder="Customer Service Support"
							value='<?php echo get_option('flatty_show_customer_service_box_widget_title'); ?>'
						/>
					</div>
					<div class="option">
						<label for="flatty_show_customer_service_box_widget_description"><?php _e('Widget description', 'flatty-flat-admin-theme' ); ?></label>
						<input
							type="text"
							name="flatty_show_customer_service_box_widget_description"
							id="flatty_show_customer_service_box_widget_description"
							maxlength="230"
							placeholder="Contact our support team for more informations regarding the use of this admin area."
							value='<?php echo get_option('flatty_show_customer_service_box_widget_description'); ?>'
						/>
					</div>
				</div>

				<div class="option">
					<label for="flatty_show_customer_service_box_name"><?php _e('Name', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_show_customer_service_box_name"
						id="flatty_show_customer_service_box_name"
						maxlength="20"
						placeholder="John Appleseed"
						value='<?php echo get_option('flatty_show_customer_service_box_name'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_customer_service_box_website"><?php _e('Website', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_show_customer_service_box_website"
						id="flatty_show_customer_service_box_website"
						placeholder="http://johnappleseed.com"
						value='<?php echo get_option('flatty_show_customer_service_box_website'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_customer_service_box_email"><?php _e('E-mail', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_show_customer_service_box_email"
						id="flatty_show_customer_service_box_email"
						placeholder="johnappleseed@apple.com"
						value='<?php echo get_option('flatty_show_customer_service_box_email'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_customer_service_box_phone"><?php _e('Phone', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="text"
						name="flatty_show_customer_service_box_phone"
						id="flatty_show_customer_service_box_phone"
						maxlength="20"
						placeholder="Insert phone number"
						value='<?php echo get_option('flatty_show_customer_service_box_phone'); ?>'
					/>
				</div>
				<div id="fl-customer-service-logo" class="option">
					<?php
						$customerLogo = get_option('flatty_show_customer_service_logo');
					?>

					<img
						id="flatty_customer_service_logo_img"
						width="16"
						height="16"
						style="<?= ($customerLogo !== false && strlen($customerLogo) > 0) ? 'display:block;' : 'display:none;'  ?>
						position: relative; max-width: 300px; padding:10px; margin:0 10px 0 0; background-color:#ccc; border-radius:4px;"
						<?= ($customerLogo !== false && strlen($customerLogo) > 0) ? 'src="' . $customerLogo . '"' : ''  ?>
					/>

					<label for="flatty_custom_favicon"><?php _e('Logo', 'flatty-flat-admin-theme' ); ?></label>

						<input
							type="hidden"
							name="flatty_show_customer_service_logo"
							id="flatty_show_customer_service_logo"
							placeholder="Custom Logo url"
							value='<?php echo get_option('flatty_show_customer_service_logo'); ?>'
						/>

						<div id="button-remove_customer_logo"
							<?= ($customerLogo !== false && strlen($customerLogo) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
							class="button-remove"><i class="dashicons dashicons-dismiss"></i>
						</div>

						<div id="button-upload_customer_logo"
							<?= ($customerLogo !== false && strlen($customerLogo) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
							class="button button-primary"><?php _e('Upload Logo', 'flatty-flat-admin-theme' ); ?>
						</div>

					<div class="flatty-description"><?php _e('Recommended image size: 16px X 16px', 'flatty-flat-admin-theme' ); ?></div>
				</div>
			</div>
		</div>

		<div id="footer-box" class="postbox flatty">
			<div class="title">
                <i class="dashicons dashicons-info" style="background-color: #F44336;"></i>
                <span><?php _e('Custom Footer', 'flatty-flat-admin-theme' ); ?></span>
            </div>

            <div class="option">
				<label for="flatty_wp_flatty_footer_show"><?php _e('Enable Flatty\'s Custom Footer', 'flatty-flat-admin-theme' ); ?></label>
				<input
					type="checkbox"
					name="flatty_wp_flatty_footer_show"
					id="flatty_wp_flatty_footer_show"
					value='1'
					<?php checked(1, get_option('flatty_wp_flatty_footer_show')); ?>
				/>
				<div class="flatty-description"><?php _e('This will hide Worpdress "Thank You" by default', 'flatty-flat-admin-theme' ); ?></div>
			</div>

			<div id="flatty_custom_footer" style="background:#eee; border-bottom: solid 1px #e6e6e6;">

				<div class="option">
					<label for="flatty_wp_flatty_footer_custom_text"><?php _e('Custom Text', 'flatty-flat-admin-theme' ); ?></label>
					<input
						name="flatty_wp_flatty_footer_custom_text"
						id="flatty_wp_flatty_footer_custom_text"
						placeholder="Luke, i am your father"
						value='<?php echo get_option('flatty_wp_flatty_footer_custom_text'); ?>'
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_wordpress"><?php _e('Show Wordpress version', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_flatty_footer_show_wordpress"
						id="flatty_wp_flatty_footer_show_wordpress"
						value='1'
						<?php checked(1, get_option('flatty_wp_flatty_footer_show_wordpress')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_mysql"><?php _e('Show MySql version', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_flatty_footer_show_mysql"
						id="flatty_wp_flatty_footer_show_mysql"
						value='1'
						<?php checked(1, get_option('flatty_wp_flatty_footer_show_mysql')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_php"><?php _e('Show Php version', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_flatty_footer_show_php"
						id="flatty_wp_flatty_footer_show_php"
						value='1'
						<?php checked(1, get_option('flatty_wp_flatty_footer_show_php')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_server_protocol"><?php _e('Show server protocol (Ex: HTTP/1.1)', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_flatty_footer_show_server_protocol"
						id="flatty_wp_flatty_footer_show_server_protocol"
						value='1'
						<?php checked(1, get_option('flatty_wp_flatty_footer_show_server_protocol')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_server_address"><?php _e('Show server address', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_flatty_footer_show_server_address"
						id="flatty_wp_flatty_footer_show_server_address"
						value='1'
						<?php checked(1, get_option('flatty_wp_flatty_footer_show_server_address')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_flatty_footer_show_server_software"><?php _e('Show server identification string', 'flatty-flat-admin-theme' ); ?></label>
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

	<div class="buttons-container">
		<?php
			settings_fields('flatty_branding');
			submit_button('', 'primary large flatty-button-update');
		?>
		<div class="flatty-single"><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></div>
	</div>

</form>

<?php
}
?>
