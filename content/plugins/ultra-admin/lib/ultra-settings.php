<?php


/* --------------- Admin Settings ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'ultra-menu-settings.php' );


function ultra_panel_settings(){
	global $ultraadmin;
	//print_r($ultraadmin);

	ultra_add_option( "ultraadmin_plugin_access", "manage_options");
	ultra_add_option( "ultraadmin_plugin_page", "show");
	ultra_add_option( "ultraadmin_plugin_userid", "");
	ultra_add_option( "ultraadmin_menumng_page", "enable");
	ultra_add_option( "ultraadmin_admin_menumng_page", "enable");
	ultra_add_option( "ultraadmin_admintheme_page", "enable");
	ultra_add_option( "ultraadmin_logintheme_page", "enable");
	ultra_add_option( "ultraadmin_master_theme", "0");

	$get_menumng_page = ultra_get_option( "ultraadmin_menumng_page","enable");
	$get_admin_menumng_page = ultra_get_option( "ultraadmin_admin_menumng_page","enable");
	$get_admintheme_page = ultra_get_option( "ultraadmin_admintheme_page","enable");
	$get_logintheme_page = ultra_get_option( "ultraadmin_logintheme_page","enable");
	$get_mastertheme_page = ultra_get_option( "ultraadmin_master_theme","0");


                // manageoptions and super admin
                $ultraadmin_permissions = ultra_get_option( "ultraadmin_plugin_access","manage_options");
                if($ultraadmin_permissions == "super_admin" && is_super_admin()){
                    $ultraadmin_permissions = 'manage_options';
                }

                // specific user
                $ultraadmin_userid = ultra_get_option( "ultraadmin_plugin_userid","");
                if($ultraadmin_permissions == "specific_user" && $ultraadmin_userid == get_current_user_id()){
                    $ultraadmin_permissions = 'read';
                }

    $showtabs = true;
	if(is_multisite() && ultra_network_active()){
		if(!is_main_site()){
			$showtabs = false;			
		}
	}

	if($showtabs){
		    add_menu_page('Ultra Admin Addon', __('Ultra Admin Addon', 'ultra_framework'), $ultraadmin_permissions, 'ultra_permission_settings', 'ultra_permission_settings_page');
		    add_submenu_page('ultra_permission_settings', 'Plugin Settings', __('Plugin Settings', 'ultra_framework'), $ultraadmin_permissions, 'ultra_permission_settings', 'ultra_permission_settings_page');
			if($get_menumng_page != "disable"){
			    add_submenu_page('ultra_permission_settings', 'Menu Management', __('Menu Management', 'ultra_framework'), $ultraadmin_permissions, 'ultra_menumng_settings', 'ultra_menumng_settings_page');
			}
		}


}



function ultra_permission_settings_page(){

    if (isset($_POST['action']) && $_POST['action'] == 'ultra_save_settings') {
        ultra_save_permission_settings();
	}

$currentUser = wp_get_current_user();
$isMultisite = is_multisite();
$isSuperAdmin = is_super_admin();

$get_plugin_access = ultra_get_option( "ultraadmin_plugin_access","manage_options");
$get_plugin_page = ultra_get_option( "ultraadmin_plugin_page","show");

$get_menumng_page = ultra_get_option( "ultraadmin_menumng_page","enable");
$get_admin_menumng_page = ultra_get_option( "ultraadmin_admin_menumng_page","enable");

$get_admintheme_page = ultra_get_option( "ultraadmin_admintheme_page","enable");
$get_logintheme_page = ultra_get_option( "ultraadmin_logintheme_page","enable");
$get_mastertheme_page = ultra_get_option( "ultraadmin_master_theme","0");


global $ultraadmin;
//echo $ultraadmin['dynamic-css-type'];
//echo "jhi";
global $wpdb;
global $blog_id;
	?>

<div class="wrap">

	<h2>Ultra Admin Settings</h2>

<?php
$ultra_plugin_settings = true;
if(ultra_network_active() && $blog_id != 1){
	$ultra_plugin_settings = false;
}
?>


<?php if($ultra_plugin_settings) { ?>
	<form method="post" action="<?php echo esc_url(add_query_arg(array())); ?>" id="ultraadmin_settings_form">
		<table class="form-table">
			<tbody>

			<tr>
				<th scope="row">
					Plugin Access Rights
				</th>
				<td>
					<fieldset>
						<p>
							<label>
								<input type="radio" name="plugin_access" value="super_admin"
									<?php checked('super_admin', $get_plugin_access); ?>
									>
									Super Admin

								<?php if ( !$isMultisite ) : ?>
									<br><span class="description">
										On a single site installation this is usually
										the same as the Administrator role.
									</span>
								<?php endif; ?>
							</label>
						</p>

						<p>
							<label>
								<input type="radio" name="plugin_access" value="manage_options"
									<?php checked('manage_options', $get_plugin_access); ?>
									>
								User the "manage_options" capability

								<br><span class="description">
									Only Administrators have this capability by default.
								</span>
							</label>
						</p>

						<p>
							<label>
								<input type="radio" name="plugin_access" value="specific_user"
									<?php checked('specific_user', $get_plugin_access); ?>
									<?php disabled( $isMultisite && !$isSuperAdmin ); ?>>
								Only the current user

								<br>
								<span class="description">
									Login: <?php echo $currentUser->user_login; ?>,
								 	user ID: <?php echo get_current_user_id(); ?>
								</span>
							</label>
						</p>
					</fieldset>

					<p>
						<label>
							<input type="checkbox" name="hide_plugin_from_others" value="1"
								<?php checked( $get_plugin_page == "hide" ); ?>
								<?php disabled( $isMultisite && !is_super_admin() ); ?>
							>
							Hide the "Ultra Admin" entry on the "Plugins" page from other users.<br><span class="description">(Other users are all users expect selected user type or user above.)</span>
						</label>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					Menu Management
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="ultra_disable_menumng" value="1"
								<?php checked( $get_menumng_page == "disable" ); ?>
								<?php disabled( $isMultisite && !is_super_admin() ); ?>
							>
							Check to <u>DISABLE</u> Ultra Admin MENU MANAGEMENT Addon.<br><span class="description">Generally disabled when the admin menu management is managed by some other premium plugins (providing similar functionality).</span>
						</label>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					User Based Menu Management
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="ultra_disable_admin_menumng" value="1"
								<?php checked( $get_admin_menumng_page == "disable" ); ?>
								<?php disabled( $isMultisite && !is_super_admin() ); ?>
							>
							Check to show Original Admin menu to administrator or super admin user. <br><span class="description">Means the edited menu (from Menu Management Addon) will be shown to all users except administrator or super admin users.</span>
						</label>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					Ultra Theme on Admin Pages
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="ultra_disable_admintheme" value="1"
								<?php checked( $get_admintheme_page == "disable" ); ?>
								<?php disabled( $isMultisite && !is_super_admin() ); ?>
							>
							Check to <u>DISABLE</u> Ultra Admin Theme on ADMIN PAGES after successful user login.
						</label>
					</p>
				</td>
			</tr>


			<tr>
				<th scope="row">
					Ultra Theme on Login Page
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="ultra_disable_logintheme" value="1"
								<?php checked( $get_logintheme_page == "disable" ); ?>
								<?php disabled( $isMultisite && !is_super_admin() ); ?>
							>
							Check to <u>DISABLE</u> Ultra Admin Theme on LOGIN PAGE.
						</label>
					</p>
				</td>
			</tr>


<?php /* if($isMultisite && $isSuperAdmin){ ?>

			<tr>
				<th scope="row">
					Ultra Admin Theme (on all network)
				</th>
				<td>
					<p>
						<select name='ultra_multisite_options' id='ultra_multisite_options'>
						<option value='0'>Individual Site Settings</option>
						<?php 
						$blogarr = ultra_multisite_allsites();
							foreach ($blogarr as $blogid => $blogname) {

								if($get_mastertheme_page == $blogid){ $mastersel = "selected"; } else { $mastersel = "";}
						        echo '<option value="'.$blogid.'" '.$mastersel.'>'.$blogname.'</option>';
							} 
						?>
						</select>

						<br>Selected site &quot;Ultra Admin theme options&quot; will be applied to all the sites on network. All the sites on network will have same look and feel. &quot;Individual site settings&quot; means all the sites will have their own individual settings.

					</p>
				</td>
			</tr>
<?php  } */ ?>





<?php /*			<tr>
				<th scope="row">
					Multisite settings
				</th>
				<td>
					<fieldset id="ame-menu-scope-settings">
						<p>
							<label>
								<input type="radio" name="menu_config_scope" value="global"
								       id="ame-menu-config-scope-global"
									<?php checked('global', $settings['menu_config_scope']); ?>
									<?php disabled(!$isMultisite || !$isSuperAdmin); ?>>
								Global &mdash;
								Use the same admin menu settings for all network sites.
							</label><br>
						</p>


						<label>
							<input type="radio" name="menu_config_scope" value="site"
								<?php checked('site', $settings['menu_config_scope']); ?>
								<?php disabled(!$isMultisite || !$isSuperAdmin); ?>>
							Per-site &mdash;
							Use different admin menu settings for each site.
						</label>
					</fieldset>
				</td>
			</tr> */ 
?>
			</tbody>
		</table>
		<input type="hidden" name="plugin_userid" value="<?php echo get_current_user_id(); ?>">
		<input type="hidden" name="action" value="ultra_save_settings">
		<?php
		wp_nonce_field('save_settings');
		submit_button();
		?>
	</form>
<?php } ?>

</div>


<?php



}



function ultra_save_permission_settings(){

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_settings')) {
        die('Save Permissions check failed.');
    }

    global $wpdb;
	
	$plugin_access = "manage_options";
	//print_r($_POST);
    
    if ($_POST['action'] == 'ultra_save_settings') 
    {

    	// plugin access
        $plugin_access = $_POST['plugin_access'];
		ultra_update_option( "ultraadmin_plugin_access", $plugin_access);
	
		// show on plugin page
		$plugin_page = "show";
	    if (isset($_POST['hide_plugin_from_others'])) {
	    	$plugin_page = "hide";
	    }
		ultra_update_option( "ultraadmin_plugin_page", $plugin_page);

		// user specific
		$onlyuser = "";
	    if ($plugin_access == "specific_user") {
	    	$onlyuser = $_POST['plugin_userid'];
	    }
		ultra_update_option( "ultraadmin_plugin_userid", $onlyuser);


		// show on menu mngmnt page
		$menumng_page = "enable";
	    if (isset($_POST['ultra_disable_menumng'])) {
	    	$menumng_page = "disable";
	    }
		ultra_update_option( "ultraadmin_menumng_page", $menumng_page);

		// show on menu mngmnt page for admin users
		$admin_menumng_page = "enable";
	    if (isset($_POST['ultra_disable_admin_menumng'])) {
	    	$admin_menumng_page = "disable";
	    }
		ultra_update_option( "ultraadmin_admin_menumng_page", $admin_menumng_page);

		// show on admin theme
		$admintheme_page = "enable";
	    if (isset($_POST['ultra_disable_admintheme'])) {
	    	$admintheme_page = "disable";
	    }
		ultra_update_option( "ultraadmin_admintheme_page", $admintheme_page);


		// show on login theme
		$logintheme_page = "enable";
	    if (isset($_POST['ultra_disable_logintheme'])) {
	    	$logintheme_page = "disable";
	    }
		ultra_update_option( "ultraadmin_logintheme_page", $logintheme_page);




		/*Update multisite in one click settings*/
		$master_theme = 0;
		$master_options = "";
	    if (isset($_POST['ultra_multisite_options']) && $_POST['ultra_multisite_options'] != "0" && is_numeric($_POST['ultra_multisite_options'])) {
	    	$master_theme = $_POST['ultra_multisite_options'];
			update_option( "ultraadmin_master_theme", $master_theme);

		    if($master_theme != "0"){
		    	$master_options = get_blog_option( $master_theme, 'ultra_demo' );

					$blogarr = ultra_multisite_allsites();
					foreach ($blogarr as $blogid => $blogname) {
						update_blog_option($blogid, 'ultra_demo', $master_options);
					}
			}
	    }

    }



}



add_filter('all_plugins', 'ultra_filter_plugin_list');

function ultra_filter_plugin_list(){

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	//print_r($plugins);

		$currentUser = wp_get_current_user();
		$uaccess = ultra_get_option( "ultraadmin_plugin_access","manage_options");
		$upage = ultra_get_option( "ultraadmin_plugin_page","show");
		$uid = ultra_get_option( "ultraadmin_plugin_userid","");

		if($upage == "hide"){

			if($uaccess == "super_admin" && !is_super_admin()){
				unset($plugins['ultra-admin/ultra-core.php']);
			}

			if($uaccess == "specific_user" && $uid != get_current_user_id()){
				unset($plugins['ultra-admin/ultra-core.php']);
			}

			if($uaccess == "manage_options" && !current_user_can('manage_options')){
				unset($plugins['ultra-admin/ultra-core.php']);
			}

		}


	return $plugins;

/*


		if($get_plugin_access == "specific_user" && $get_plugin_page == "hide"){

		}

		$get_plugin_userid == get_current_user_id()
		$allowed_user_id = $this->wp_menu_editor->get_plugin_option('plugins_page_allowed_user_id');
		if ( get_current_user_id() != $allowed_user_id ) {
			unset($plugins[$this->wp_menu_editor->plugin_basename]);
		}
		return $plugins;*/
}
   

?>