<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function branding_init() {
	//BRANDING
	register_setting("flatty_branding", "flatty_use_flatty_topbar");
	register_setting("flatty_branding", "flatty_show_topbar_profile");
	register_setting("flatty_branding", "flatty_show_topbar_image");
	
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

		<div id="branding-box" class="postbox flatty">
			<div class="title">
        <i class="dashicons dashicons-megaphone" style="background-color: #c949c4;"></i>
        <span><?php _e('Branding', 'flatty-flat-admin-theme' ); ?></span>
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
