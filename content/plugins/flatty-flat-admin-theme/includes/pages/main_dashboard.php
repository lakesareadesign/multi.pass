<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function dashboard_init() {

	//DASHBOARD WIDGETS
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_recent_comments");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_quickpress");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_drafts");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_primary");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_news");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_links");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_plugins");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_activity");
	register_setting("flatty_dashboard", "flatty_wp_hide_dashboard_right_now");
}

add_action("admin_init","dashboard_init");

//////////////////////////////////////////////////////////////////////////////////////////////////PAGE
function options_main_dashboard() {
	?>

	<form method='post' action='options.php'>

		<div class="wrap flatty-form">

	        <div class="page-title">
	            <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
	            <div class="header"><?php _e('Dashboard', 'flatty-flat-admin-theme' ); ?></div>
	        </div>

			<div id="widgets-box" class="postbox flatty">
				<div class="title">
                    <i class="dashicons dashicons-schedule" style="background-color: #8da6a6;"></i>
                    <span><?php _e('Widgets', 'flatty-flat-admin-theme' ); ?></span>
                </div>

                <div class="option">
					<label for="flatty_wp_hide_dashboard_recent_comments"><?php _e('Remove "Recent Comments"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_recent_comments"
						id="flatty_wp_hide_dashboard_recent_comments"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_recent_comments')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_quickpress"><?php _e('Remove "Quick Press"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_quickpress"
						id="flatty_wp_hide_dashboard_quickpress"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_quickpress')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_drafts"><?php _e('Remove "Recent Drafts"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_drafts"
						id="flatty_wp_hide_dashboard_drafts"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_drafts')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_primary"><?php _e('Remove "Wordpress News"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_primary"
						id="flatty_wp_hide_dashboard_primary"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_primary')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_activity"><?php _e('Remove "Wordpress Activity"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_activity"
						id="flatty_wp_hide_dashboard_activity"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_activity')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_right_now"><?php _e('Remove "Wordpress at a glance"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_right_now"
						id="flatty_wp_hide_dashboard_right_now"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_right_now')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_links"><?php _e('Remove "Wordpress Incoming Links"', 'flatty-flat-admin-theme' ); ?></label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_links"
						id="flatty_wp_hide_dashboard_links"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_links')); ?>
					/>
				</div>

            </div>

		</div>

		<div class="buttons-container">
			<?php
				settings_fields('flatty_dashboard');
				submit_button('', 'primary large flatty-button-update');
			?>
			<div class="flatty-single"><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></div>
		</div>

	</form>

	<?php
}

?>
