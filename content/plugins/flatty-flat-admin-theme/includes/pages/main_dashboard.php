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
		<div class="flatty-header">
			<div class="flatty-flex">
		        <img src="<?php echo plugins_url(FLATTY_PLUGIN_URL . 'assets/flatty-logo.png') ?>" class="flatty-logo"/>
		        <h1><?php _e('Dashboard', 'flatty-flat-admin-theme' ); ?></h1>
		    </div>
			<div class="flatty-column">
				<?php
					settings_fields('flatty_dashboard');
					submit_button('', 'flatty-button update');
				?>
				<p><?php _e('*Don\'t forget to save changes', 'flatty-flat-admin-theme' ); ?></p>
			</div>
	    </div>

		<div class="flatty-column">

			<div class="flatty-container" id="dashboard_widgets">
	            <div class="flatty-container-title" style="background: linear-gradient(135deg, #3F51B5 0%,#2196F3 100%);">
	                <i class="dashicons dashicons-welcome-widgets-menus" style="width:auto; height:auto; font-size:50px; margin-bottom:10px;"></i>
	                <span><?php _e('Widgets', 'flatty-flat-admin-theme' ); ?></span>
	            </div>
	            <div class="flatty-container-content">
	                <!--RECENT COMMENTS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_recent_comments"><?php _e('Remove "Recent Comments"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_recent_comments"
								id="flatty_wp_hide_dashboard_recent_comments"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_recent_comments')); ?>
							/>
	                    </div>
	                </div>
	                <!--QUICKPRESS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_quickpress"><?php _e('Remove "Quick Press"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_quickpress"
								id="flatty_wp_hide_dashboard_quickpress"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_quickpress')); ?>
							/>
	                    </div>
	                </div>
	                <!--RECENT DRAFTS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_drafts"><?php _e('Remove "Recent Drafts"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_drafts"
								id="flatty_wp_hide_dashboard_drafts"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_drafts')); ?>
							/>
	                    </div>
	                </div>
	                <!--RECENT PRIMARY-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_primary"><?php _e('Remove "Wordpress News"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_primary"
								id="flatty_wp_hide_dashboard_primary"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_primary')); ?>
							/>
	                    </div>
	                </div>
	                <!--RECENT ACTIVITY-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_activity"><?php _e('Remove "Wordpress Activity"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_activity"
								id="flatty_wp_hide_dashboard_activity"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_activity')); ?>
							/>
	                    </div>
	                </div>
	                <!--RIGHT NOW-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_right_now"><?php _e('Remove "Wordpress at a glance"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
	                        <input
								type="checkbox"
								name="flatty_wp_hide_dashboard_right_now"
								id="flatty_wp_hide_dashboard_right_now"
								value='1'
								<?php checked(1, get_option('flatty_wp_hide_dashboard_right_now')); ?>
							/>
	                    </div>
	                </div>
	                <!--INCOMING LINKS-->
	                <div class="flatty-option">
	                    <div class="flatty-column">
	                        <label for="flatty_wp_hide_dashboard_links"><?php _e('Remove "Wordpress Incoming Links"', 'flatty-flat-admin-theme' ); ?></label>
	                    </div>
	                    <div class="flatty-column">
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
	        </div>
		</div>

	</form>

	<?php
}

?>
