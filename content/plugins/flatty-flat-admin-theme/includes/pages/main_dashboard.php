<?php
///////////////////////////////SETTINGS\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function dashboard_init() {

	//DASHBOARD WIDGETS
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
	            <div class="header">Dashboard</div>
	        </div>

			<div id="widgets-box" class="postbox flatty">
				<div class="title">
                    <i class="fa fa-object-group" style="background-color: #8da6a6;"></i>
                    <span>Widgets</span>
                </div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_quickpress">Remove Quick Press</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_quickpress"
						id="flatty_wp_hide_dashboard_quickpress"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_quickpress')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_drafts">Remove Recent drafts</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_drafts"
						id="flatty_wp_hide_dashboard_drafts"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_drafts')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_primary">Remove Wordpress News</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_primary"
						id="flatty_wp_hide_dashboard_primary"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_primary')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_activity">Remove Wordpress Activity</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_activity"
						id="flatty_wp_hide_dashboard_activity"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_activity')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_right_now">Remove Wordpress 'At a glance'</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_right_now"
						id="flatty_wp_hide_dashboard_right_now"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_right_now')); ?>
					/>
				</div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_links">Remove Wordpress incoming links</label>
					<input
						type="checkbox"
						name="flatty_wp_hide_dashboard_links"
						id="flatty_wp_hide_dashboard_links"
						value='1'
						<?php checked(1, get_option('flatty_wp_hide_dashboard_links')); ?>
					/>
				</div>

            </div>

			<div id="widgets-box" class="postbox flatty">
				<div class="title">
                    <i class="fa fa-info" style="background-color: #6aa1d4;"></i>
                    <span>Custom Support Widget</span>
                </div>

				<div class="option">
					<label for="flatty_wp_hide_dashboard_plugins">Coming soon...</label>
				</div>

			</div>

		</div>

		<div class="buttons-container">
			<?php
				settings_fields('flatty_dashboard');
				submit_button('', 'primary large flatty-button-update');
			?>
			<div class="flatty-single">*Don't forget to save changes</div>
		</div>

	</form>

	<?php
}

?>
