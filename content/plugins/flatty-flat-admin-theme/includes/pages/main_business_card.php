<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
add_action("admin_init","business_card_init");
function business_card_init() {

	//CUSTOMER SERVICE BOX
	register_setting("flatty_business_card", "flatty_business_card_firstname");
	register_setting("flatty_business_card", "flatty_business_card_lastname");
	register_setting("flatty_business_card", "flatty_business_card_company_show");
	register_setting("flatty_business_card", "flatty_business_card_company");
	register_setting("flatty_business_card", "flatty_business_card_phone");
	register_setting("flatty_business_card", "flatty_business_card_email");
	register_setting("flatty_business_card", "flatty_business_card_website");
	register_setting("flatty_business_card", "flatty_business_card_picture");

	register_setting("flatty_business_card", "flatty_business_card_show_dashboard");
	register_setting("flatty_business_card", "flatty_business_card_widget_title");
	register_setting("flatty_business_card", "flatty_business_card_widget_description");

	register_setting("flatty_business_card", "flatty_business_card_show_topbar");

}
//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_sub_business_card() {
	?>

	<form method='post' action='options.php'>

		<div class="flatty-header">
			<div class="flatty-flex">
		        <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
		        <h1><?php _e('Business Card', 'flatty-flat-admin-theme' ); ?></h1>
		    </div>
			<div class="flatty-column">
				<?php
					settings_fields('flatty_business_card');
					submit_button('', 'flatty-button update');
				?>
				<p><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></p>
			</div>
	    </div>

	    <div class="flatty-column">

		    <div class="flatty-container" id="profile">
				<div class="flatty-container-title" style="background: linear-gradient(135deg, #8BC34A 0%,#CDDC39 100%);">
					<i class="dashicons dashicons-id" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
	                <span><?php _e('Profile', 'flatty-flat-admin-theme' ); ?></span>
	            </div>
	            <div class="flatty-container-content">
	            	<!--CARD FIRSTNAME-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_firstname"><?php _e('Firstname', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Firstname', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_firstname"
								id="flatty_business_card_firstname"
								maxlength="20"
								placeholder="John"
								value='<?php echo get_option('flatty_business_card_firstname'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD LASTNAME-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_lastname"><?php _e('Lastname', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Lastname', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_lastname"
								id="flatty_business_card_lastname"
								maxlength="20"
								placeholder="Appleseed"
								value='<?php echo get_option('flatty_business_card_lastname'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD SHOWS AS A COMPANY-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_company_show"><?php _e('Shows as a company', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Give priority to the company details', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="checkbox"
								name="flatty_business_card_company_show"
								id="flatty_business_card_company_show"
								value='1'
								<?php checked(1, get_option('flatty_business_card_company_show')); ?>
							/>
						</div>
	            	</div>
	            	<!--CARD COMPANY NAME-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_company"><?php _e('Company', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Company name', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_company"
								id="flatty_business_card_company"
								maxlength="20"
								placeholder="Fruit"
								value='<?php echo get_option('flatty_business_card_company'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD PHONE-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_phone"><?php _e('Phone', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Phone', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_phone"
								id="flatty_business_card_phone"
								maxlength="20"
								placeholder="123456789"
								value='<?php echo get_option('flatty_business_card_phone'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD EMAIL-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_email"><?php _e('E-mail', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('E-mail', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_email"
								id="flatty_business_card_email"
								maxlength="40"
								placeholder="mail@mail.com"
								value='<?php echo get_option('flatty_business_card_email'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD WEBSITE-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_website"><?php _e('Website', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Website (with http://)', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_website"
								id="flatty_business_card_website"
								maxlength="100"
								placeholder="http://yourwebsite.com"
								value='<?php echo get_option('flatty_business_card_website'); ?>'
							/>
						</div>
	            	</div>
	            	<!--CARD PICTURE-->
	            	<div id="flatty-business_card-picture" class="flatty-option">
	            		<div class="flatty-column">
	            			<?php
								$supportPicture = get_option('flatty_business_card_picture');
							?>
		            		<label for="flatty_custom_favicon"><?php _e('Profile picture or logo', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Recommended image size: 300px X 300px', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
			            	<input
								type="hidden"
								name="flatty_business_card_picture"
								id="flatty_business_card_picture"
								placeholder="Custom Logo url"
								value='<?php echo get_option('flatty_business_card_picture'); ?>'
							/>
							<div id="button_remove_business_card_picture"
								<?= ($supportPicture !== false && strlen($supportPicture) > 0) ? 'style="display:block;"' : 'style="display:none;"'  ?>
								class="button-remove"><i class="dashicons dashicons-dismiss"></i>
							</div>
							<div id="button_upload_business_card_picture"
								<?= ($supportPicture !== false && strlen($supportPicture) > 0) ? 'style="display:none;"' : 'style="display:block;"'  ?>
								class="button button-primary"><?php _e('Upload Picture', 'flatty-flat-admin-theme' ); ?>
							</div>
						</div>
	            	</div>
	            </div>
	        </div>

	        <div class="flatty-container" id="dashboard">
	        	<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
					<i class="dashicons dashicons-id" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
	                <span><?php _e('Dashboard', 'flatty-flat-admin-theme' ); ?></span>
	            </div>
	            <div class="flatty-container-content">
	            	<!--ADD TO THE DASHBOARD-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_email"><?php _e('Add to the dashboard', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Show the business card in the dashboard', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="checkbox"
								name="flatty_business_card_show_dashboard"
								id="flatty_business_card_show_dashboard"
								value='1'
								<?php checked(1, get_option('flatty_business_card_show_dashboard')); ?>
							/>
						</div>
	            	</div>
	            	<!--WIDGET TITLE-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_widget_title"><?php _e('Widget Title', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Change the widget title', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="text"
								name="flatty_business_card_widget_title"
								id="flatty_business_card_widget_title"
								maxlength="15"
								placeholder="Business Card"
								value='<?php echo get_option('flatty_business_card_widget_title'); ?>'
							/>
						</div>
	            	</div>
	            </div>
	        </div>

	        <div class="flatty-container" id="topbar">
	        	<div class="flatty-container-title" style="background: linear-gradient(135deg, #9E9E9E 0%,#607D8B 100%);">
					<i class="dashicons dashicons-id" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
	                <span><?php _e('Flatty\'s Topbar', 'flatty-flat-admin-theme' ); ?></span>
	            </div>
	            <div class="flatty-container-content">
	            	<!--ADD TO THE TOPBAR-->
	            	<div class="flatty-option">
	            		<div class="flatty-column">
		            		<label for="flatty_business_card_email"><?php _e('Add to the Flatty\'sTopbar', 'flatty-flat-admin-theme' ); ?></label>
		            		<div class="flatty-description"><?php _e('Show the business card in the Flatty\'s topbar if enabled', 'flatty-flat-admin-theme' ); ?></div>
		            	</div>
		            	<div class="flatty-column">
							<input
								type="checkbox"
								name="flatty_business_card_show_topbar"
								id="flatty_business_card_show_topbar"
								value='1'
								<?php checked(1, get_option('flatty_business_card_show_topbar')); ?>
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
