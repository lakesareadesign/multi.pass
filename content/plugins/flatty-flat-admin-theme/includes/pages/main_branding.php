<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function branding_init() {
	//BRANDING
	register_setting("flatty_branding", "flatty_show_sitename");
	register_setting("flatty_branding", "flatty_custom_logo");
	register_setting("flatty_branding", "flatty_hide_custom_logo");
	register_setting("flatty_branding", "flatty_custom_favicon");

	//SUPPORT BOX
	register_setting("flatty_branding", "flatty_show_site_developer_info");
	register_setting("flatty_branding", "flatty_show_site_developer_info_name");
	register_setting("flatty_branding", "flatty_show_site_developer_info_website");
	register_setting("flatty_branding", "flatty_show_site_developer_info_email");
	register_setting("flatty_branding", "flatty_show_site_developer_info_phone");
}

add_action("admin_init","branding_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_branding() {
?>

<form method='post' action='options.php'>

	<div class="wrap flatty-form">

        <div class="page-title">
            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
            <div class="header">Branding</div>
        </div>

		<div id="branding-box" class="postbox flatty">
			<div class="title">
                <i class="fa fa-at" style="background-color: #c949c4;"></i>
                <span>Branding</span>
            </div>

			<div class="option">
				<label for="flatty_show_sitename">Show sitename</label>
				<input
					type="checkbox"
					name="flatty_show_sitename"
					id="flatty_show_sitename"
					value='1'
					<?php checked(1, get_option('flatty_show_sitename')); ?>
				/>
			</div>

			<div class="option">
				<label for="flatty_show_sitename">More coming soon...</label>
			</div>

        </div>

		<div id="developer-box" class="postbox flatty">
			<div class="title">
                <i class="fa fa-bookmark-o" style="background-color: #4ac96a;"></i>
                <span>Developer Info Box</span>
            </div>

			<div class="option">
				<label for="flatty_show_site_developer_info">Show support box</label>
				<input
					type="checkbox"
					name="flatty_show_site_developer_info"
					id="flatty_show_site_developer_info"
					value='1'
					<?php checked(1, get_option('flatty_show_site_developer_info')); ?>
				/>
				<div class="flatty-description">Company's or developer's contacts</div>
			</div>
			<div id="developer_infos" style="opacity:0; transition:.3s;">
				<div class="option">
					<label for="flatty_show_site_developer_info_name">Name:</label>
					<input
						type="text"
						name="flatty_show_site_developer_info_name"
						id="flatty_show_site_developer_info_name"
						maxlength="20"
						placeholder="John Appleseed"
						value='<?php echo get_option('flatty_show_site_developer_info_name'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_site_developer_info_website">Website:</label>
					<input
						type="text"
						name="flatty_show_site_developer_info_website"
						id="flatty_show_site_developer_info_website"
						placeholder="http://johnappleseed.com"
						value='<?php echo get_option('flatty_show_site_developer_info_website'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_site_developer_info_email">E-mail:</label>
					<input
						type="text"
						name="flatty_show_site_developer_info_email"
						id="flatty_show_site_developer_info_email"
						placeholder="johnappleseed@apple.com"
						value='<?php echo get_option('flatty_show_site_developer_info_email'); ?>'
					/>
				</div>
				<div class="option">
					<label for="flatty_show_site_developer_info_phone">Phone:</label>
					<input
						type="text"
						name="flatty_show_site_developer_info_phone"
						id="flatty_show_site_developer_info_phone"
						maxlength="20"
						placeholder="Insert phone number"
						value='<?php echo get_option('flatty_show_site_developer_info_phone'); ?>'
					/>
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
						    background: #fff;
						    border-radius: 10px;
							"
						<?= ($customLogo !== false && strlen($customLogo) > 0) ? 'src="' . $customLogo . '"' : ''  ?>
					/>
					<?php
				} else {
					?>
						<i class="fa fa-camera" style="background-color: #c3c94b;"></i>
					<?php
				}
				?>
                <span>Custom Logo</span>
            </div>

			<div class="option">
				<label for="flatty_custom_logo">Custom logo</label>
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
						class="button-remove"><i class="fa fa-times-circle"></i>
					</div>

					<div id="button-upload_logo"
						<?= ($customLogo !== false && strlen($customLogo) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
						class="button button-primary">Upload Logo
					</div>

				<div class="flatty-description">Recommended max height 50px</div>
			</div>

			<div class="option">
				<label for="flatty_hide_custom_logo">Hide custom logo in the backend</label>
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
					position: relative; max-width: 300px; padding:10px; margin:0 10px 0 0; border:solid 1px #eee;"
					<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'src="' . $customFavIcon . '"' : ''  ?>
				/>

				<label for="flatty_custom_favicon">Custom FavIcon</label>

					<input
						type="hidden"
						name="flatty_custom_favicon"
						id="flatty_custom_favicon"
						placeholder="Custom Favicon url"
						value='<?php echo get_option('flatty_custom_favicon'); ?>'
					/>

					<div id="button-remove_favicon"
						<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
						class="button-remove"><i class="fa fa-times-circle"></i>
					</div>

					<div id="button-upload_favicon"
						<?= ($customFavIcon !== false && strlen($customFavIcon) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
						class="button button-primary">Upload Favicon
					</div>

				<div class="flatty-description">Recommended image size: 16px X 16px</div>
			</div>

		</div>

	</div>

	<div class="buttons-container">
		<?php
			settings_fields('flatty_branding');
			submit_button('', 'primary large flatty-button-update');
		?>
		<div class="flatty-single">*Don't forget to save changes</div>
	</div>

</form>

<?php
}
?>
