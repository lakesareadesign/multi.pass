<?php
/**
 * Handles all Admin access functionality.
 */
class Bau_AdminPages {

	var $data;

	function __construct () {
		$this->data = new Bau_Options;
	}

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	static function serve () {
		$me = new Bau_AdminPages;
		$me->add_hooks();
	}

	function register_settings () {
		global $wp_version;
		$version = preg_replace('/-.*$/', '', $wp_version);
		$form = new Bau_AdminFormRenderer;

		register_setting( 'bau', 'bau' );
		add_settings_section( 'bau_settings', __( 'Enable components', 'bau' ), null, 'bau_options_page' );
		add_settings_field( 'bau_show_add_new_users', __( 'Enable Add New Users', 'bau' ), array( $form, 'create_show_add_new_users_box' ), 'bau_options_page', 'bau_settings' );
		add_settings_field( 'bau_show_add_existing_users', __( 'Enable Add Existing Users', 'bau' ), array( $form, 'create_show_add_existing_users_box' ), 'bau_options_page', 'bau_settings' );
		add_settings_field( 'bau_show_add_blogs', __( 'Enable Blogs', 'bau' ), array( $form, 'create_show_add_blogs_box' ), 'bau_options_page', 'bau_settings' ) ;

		add_settings_section( 'bau_username_message', __( 'Message popups', 'bau' ), array( $form, 'create_messages_info' ), 'bau_options_page' );
		add_settings_field( 'bau_username_title_popup', __( 'Message title', 'bau' ), array( $form, 'create_username_title_popup_box' ), 'bau_options_page', 'bau_username_message' );
		add_settings_field( 'bau_username_body_popup', __( 'Message body', 'bau' ), array( $form, 'create_username_body_popup_box' ), 'bau_options_page', 'bau_username_message' );

		add_settings_section( 'bau_password_message', __( 'Password message', 'bau' ), null, 'bau_options_page' );
		add_settings_field( 'bau_password_title_popup', __( 'Message title', 'bau' ), array( $form, 'create_password_title_popup_box' ), 'bau_options_page', 'bau_password_message' );
		add_settings_field( 'bau_password_body_popup', __( 'Message body', 'bau' ), array( $form, 'create_password_body_popup_box' ), 'bau_options_page', 'bau_password_message' );

		add_settings_section( 'bau_email_message', __( 'Email message', 'bau' ), null, 'bau_options_page' );
		add_settings_field( 'bau_email_title_popup', __( 'Message title', 'bau' ), array( $form, 'create_email_title_popup_box' ), 'bau_options_page', 'bau_email_message' );
		add_settings_field( 'bau_email_body_popup', __( 'Message body', 'bau' ), array( $form, 'create_email_body_popup_box' ), 'bau_options_page', 'bau_email_message' );
	}

	function create_site_admin_menu_entry () {
		if (@$_POST && isset($_POST['option_page']) && 'bau' == @$_POST['option_page']) {
			$this->data->set_options(stripslashes_deep($_POST['bau']));
			$goback = add_query_arg('settings-updated', 'true',  wp_get_referer());
			wp_redirect($goback);
			die;
		}
		add_submenu_page('settings.php', 'Blog &amp; User Creator', 'Blog &amp; User Creator', 'manage_network_options', 'bau', array($this, 'create_settings_page'));
	}

	function create_users_menu_entry () {
		/*
		if (@$_POST && isset($_POST['bau_add'])) {
			$this->_process();
		}
		*/
		if ( ! is_network_admin() ) add_submenu_page('users.php', 'Blog &amp; User Creator', 'Blog &amp; User Creator', 'manage_options', 'bau', array($this, 'create_action_page'));
	}

	function create_settings_page () {
		include(BAU_PLUGIN_BASE_DIR . '/lib/forms/plugin_settings.php');
	}

	function create_action_page () {
		$show_add_new_users = ($this->data->get_option('show_add_new_users') && current_user_can($this->data->get_option('show_add_new_users')));
		$show_add_existing_users = ($this->data->get_option('show_add_existing_users') && current_user_can($this->data->get_option('show_add_existing_users')));
		$show_add_blogs = ($this->data->get_option('show_add_blogs') && current_user_can($this->data->get_option('show_add_blogs')));

		$supporter_ad_free_remaining = 0;
		if (function_exists('supporter_ads')) { // Integrate Supporter Ads
			$supporter_ad_free_remaining = (int)$this->_calculate_remaining_ad_free_blogs();
		}

		$tab_id = 'bau_add_new_users';
		switch (@$_GET['action']) {
			case 'add_existing':
				$tab_id = 'bau_add_existing_users';
				break;
			case 'add_blog':
				$tab_id = 'bau_add_blogs';
				break;
			case 'add_new':
			default:
				$tab_id = 'bau_add_new_users';
				break;
		}

		$display_templates = false;
		if ( class_exists( 'blog_templates' ) ) {
			global  $blog_templates;
			$display_templates = true;
		}

		include(BAU_PLUGIN_BASE_DIR . '/lib/forms/action_page.php');
	}

	function js_print_scripts () {
		global $wp_version;
		$version = preg_replace('/-.*$/', '', $wp_version);
		wp_enqueue_script('jquery');
		if (version_compare($version, '3.3', '<')) {
			wp_enqueue_script('bau_jquery_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js');
		} else {
			wp_enqueue_script(array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				'jquery-ui-dialog',
				'jquery-ui-tabs',
				'jquery-ui-datepicker',
				'jquery-ui-dialog',
				'jquery-ui-slider',
				'jquery-ui-progressbar',
			));
		}
		 wp_enqueue_script('wp-pointer');
	}

	function css_print_styles () {
		//wp_enqueue_style('bau_jquery_ui_style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css');
		wp_enqueue_style('bau', BAU_PLUGIN_URL . '/css/bau.css');
		wp_enqueue_style('bau_jquery_ui', BAU_PLUGIN_URL . '/css/external/smoothness/jquery-ui-1.8.13.custom.css');
		wp_enqueue_style('wp-pointer');
	}

	function show_message () {
		if (!isset($_GET['page']) || 'bau' != $_GET['page']) return false;
		if (!isset($_GET['msg'])) return false;
		$status = $msg = false;
		if (isset($_GET['status'])) $status = (int)$_GET['status'];
		$class = $status ? 'updated' : 'error';
		$msg = '<strong>' . ($status ? __('Success', 'wdeb') : __('Failure', 'wdeb')) . '</strong>';
		$msg .= isset($_GET['msg']) ? ': ' . esc_html($_GET['msg']) : '';
		$msg .= $status ? '<br /><a href="' . admin_url('users.php') . '">' . __('Show users', 'wdeb') . '</a>' : '';

		echo "<div id='bau_status_message' class='{$class}'><p>{$msg}</p></div>";
	}

	/**
	 * Calculates remaining ad free blogs.
	 * Requires Supporter Ads to be present and active.
	 *
	 * @return int Number of ad free blogs remaining.
	 * @access private
	 */
	function _calculate_remaining_ad_free_blogs () {
		if (!function_exists('supporter_ads')) return 0;
		global $wpdb;
		$supporter_ad_free_blogs = get_site_option('supporter_ad_free_blogs');
		$supporter_ad_free_blogs_current = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "'");
		return (int)$supporter_ad_free_blogs - (int)$supporter_ad_free_blogs_current;
	}

	/**
	 * Upgrades the new blog and removes ads.
	 * Requires Supporter Ads to be present and active.
	 *
	 * @access private
	 */
	function _upgrade_new_blog ($blog_id) {
		if (!function_exists('supporter_ads')) return false;
		global $wpdb;

		$supporter_ad_free_blogs_remaining = (int)$this->_calculate_remaining_ad_free_blogs();
		if (!$supporter_ad_free_blogs_remaining) return false;

		$expire = supporter_get_expire();
		$existing_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "' AND blog_ID = '" . $blog_id . "'");

		if ($existing_check < 1) {
			$wpdb->query("INSERT INTO " . $wpdb->base_prefix . "supporter_ads (blog_ID, supporter_blog_ID) VALUES ( '" . $blog_id . "', '" . $wpdb->blogid . "' )");
		}
		$wpdb->query("UPDATE " . $wpdb->base_prefix . "supporter_ads SET expire = '" . $expire . "' WHERE supporter_blog_ID = '" . $wpdb->blogid . "'");
	}

	/**
	 * Creates a new user.
	 *
	 * @return bool User ID on success, false on failure
	 * @access private
	 */
	function _create_new_user ($user) {
		if (!$user['username'] || !$user['email']) throw new Bau_Exception(__('Username and email are required', 'bau'));//return false; // Required
		if (!is_email($user['email'])) throw new Bau_Exception(__('Invalid email', 'bau'));//return false;

		$username = preg_replace('/[^a-z0-9]/', '', strtolower($user['username']));
		$username = sanitize_user($username); // Suspenders and belt
		if (username_exists($username)) throw new Bau_Exception(__('Username already exists', 'bau'));//return false;

		$email = $user['email'];
		if (email_exists($email)) throw new Bau_Exception(__('Email already exists', 'bau'));//return false;
		$password = $user['password'] ? $user['password'] : wp_generate_password();

		$user_id = wp_create_user($username, $password,  $email);

		// Notify user!
		wp_new_user_notification($user_id, $password);

		return $user_id;
	}

	/**
	 * Creates a new user assigns him/her to a blog.
	 *
	 * @return bool True on success, false on failure
	 * @access private
	 */
	function _add_new_user ($user, $blog_id) {
		$user_id = $this->_create_new_user($user);
		if (!$user_id) return false;

		$role = @$user['role'] ? $user['role'] : 'subscriber';

		$result = add_user_to_blog($blog_id, $user_id, $role);
		if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//return false;

		return true;
	}

	/**
	 * Handles new user creation and adding to current blog.
	 * Uses POST array, as formatted by the action page.
	 * Currently, NO error logging.
	 * @TODO: refactor?
	 *
	 * @return int Number of successfully processed entries.
	 * @access private
	 */
	function _add_new_users () {
		if (!is_array($_POST['bau_user'])) return false;

		$overall_result = 0;
		$blog_id = get_current_blog_id();

		foreach ($_POST['bau_user'] as $user) {
			if (!$user['username']) continue;
			$overall_result += (int)$this->_add_new_user($user, $blog_id);
		}
		return $overall_result;
	}

	/**
	 * Handles adding existing users to current blog.
	 * Uses POST array, as formatted by the action page.
	 * Currently, NO error logging.
	 * @TODO: refactor?
	 *
	 * @return int Number of successfully processed entries.
	 * @access private
	 */
	function _add_existing_users () {
		if (!is_array($_POST['bau_user'])) return false;

		$overall_result = 0;
		$blog_id = get_current_blog_id();

		foreach ($_POST['bau_user'] as $user) {
			if (!$user['username']) continue; // Required

			$wp_user = (is_email($user['username'])) ? get_user_by_email($user['username']) : get_user_by('login', sanitize_user($user['username']));
			if (!$wp_user || !$wp_user->ID) throw new Bau_Exception(__('No such user found', 'bau'));//continue; // No such user

			$role = @$user['role'] ? $user['role'] : 'subscriber';

			$result = add_user_to_blog($blog_id, $wp_user->ID, $role);
			if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//continue;

			// Send email to added user
			$blog_name = get_bloginfo('name');
			$blog_url = site_url();
			@wp_mail(
				$wp_user->user_email,
				sprintf(__('You have been added to blog "%s"', 'bau'), $blog_name),
				sprintf(
					__("Hello %s,\n\nYou have been added to blog \"%s\" as %s.\nYou can visit this blog here: %s", 'bau'),
					$wp_user->user_login, $blog_name, ucfirst($role), $blog_url
				)
			);

			$overall_result += 1;
		}
		return $overall_result;
	}

	/**
	 * Handles new user AND blogs creation, as well as adding to the newly created blog.
	 * Uses POST array, as formatted by the action page.
	 * Currently, NO error logging.
	 * @TODO: refactor?
	 *
	 * @return int Number of successfully processed entries.
	 * @access private
	 */
	function _add_blogs () {
		global $current_site;
		if (!is_array($_POST['bau_user'])) return false;

		$overall_result = 0;
		$overall_blog_names = '';
		$my_new_blog_role = @$_POST['bau_new_blog_my_role'];
		$user_new_blog_role = @$_POST['bau_new_blog_user_role'];
		$user_this_blog_role = @$_POST['bau_this_blog_user_role'];
		if (!$user_new_blog_role) return false; // The only required option

		foreach ($_POST['bau_user'] as $user) {
			// Sanitize blog url
			$blog_url = strtolower(preg_replace('~[^a-zA-Z0-9]+~', '', $user['blog_url']));
			$blog_title = @$user['blog_title'] ? esc_html($user['blog_title']) : esc_html($user['username']);

			if (!$blog_url) continue;

			if (constant('VHOST') == 'yes') {
				$blog_domain = $blog_url . '.' . $current_site->domain;
				$blog_path = '/';
			} else {
				$blog_domain = $current_site->domain;
				$blog_path = $current_site->path . $blog_url . '/';
			}

			if (get_id_from_blogname($blog_url)) throw new Bau_Exception(__('Blog already exists', 'bau'));//continue; // Blog already exists

			// We'll need an admin for the new blog
			$admin_id = false;

			// Try hard to find existing user
			$wp_user = (is_email($user['email'])) ? get_user_by_email($user['email']) : false;

			// Error out if we already have an user with this username
			$existing = get_user_by('login', sanitize_user($user['username']));
			if ($existing) {
				throw new Bau_Exception(__('This username already exists', 'bau'));//continue; // User already exists
			}

			if (!$wp_user || !$wp_user->ID) { // No such user, we'll need to create it first
				$user['password'] = @$user['password'] ? $user['password'] : wp_generate_password();
				$user_id = $this->_create_new_user($user);
				if (!$user_id) continue;
/*
				// Add user to this blog with appropriate roles, if needed
				if ($user_this_blog_role) {
					$result = add_user_to_blog(get_current_blog_id(), $user_id, $user_this_blog_role);
					if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//continue;
				}
*/
			} else {
				$user_id = $wp_user->ID;
			}
			if ('administrator' == $user_new_blog_role) $admin_id = $user_id;

			// If the admin wants to be the admin of the new blog too, obey unconditionally
			if ('administrator' == $my_new_blog_role) {
				$admin_id = get_current_user_id();
			}
			if (!$admin_id) throw new Bau_Exception(__('No admin for the new blog', 'bau'));//continue;

			$meta = array();
			if ( isset( $user['template'] ) && $template = absint( $user['template'] ) ) {
				$meta = array( 'blog_template' => $template );
			}
			$blog_id = wpmu_create_blog($blog_domain, $blog_path, $blog_title, $admin_id, $meta, $current_site->id);
			if (!$blog_id) throw new Bau_Exception(__('Blog not created', 'bau'));//continue;

			if ($user_id != $admin_id) { // User is not admin - we still need to take care of him/her
				$result = add_user_to_blog($blog_id, $user_id, $user_new_blog_role);
				if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//continue;
			}
			if (get_current_user_id() != $admin_id && $my_new_blog_role) { // Current user is not added, but she should be - we still need to take care of her
				$result = add_user_to_blog($blog_id, get_current_user_id(), $my_new_blog_role);
				if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//continue;
			}

			// Lastly, upgrade and remove ads, if requested
			if (isset($_POST['bau_new_blog_upgrade']) && (int)$_POST['bau_new_blog_upgrade']) {
				$this->_upgrade_new_blog($blog_id);
			}

			// Add user to this blog with appropriate roles, if needed
			if ($user_this_blog_role && $user_id != get_current_user_id()) {
				$result = add_user_to_blog(get_current_blog_id(), $user_id, $user_this_blog_role);
				if (is_wp_error($result)) throw new Bau_Exception(__('User not added to blog', 'bau'));//continue;
			}

			// Make the new blog his primary blog
			update_user_meta($user_id, 'primary_blog', $blog_id);

			// Send welcome email to the user
			wpmu_welcome_notification($blog_id, $user_id, $user['password'], $blog_title, '');

			$overall_blog_names .= "\n" . sprintf(__('%s, titled %s', 'bau'), get_blog_option($blog_id, 'siteurl'), get_blog_option($blog_id, 'blogname'));
			$overall_result += 1;
		}

		// Notify admin, if we added blogs
		if ($overall_result) {
			$current_user = wp_get_current_user();
			@wp_mail(
				get_option('admin_email'),
				sprintf(__('%d New Blogs Created on [%s]', 'bau'), $overall_result, $current_site->site_name),
				sprintf(__('Your user %s created %d new blogs: %s', 'bau'), $current_user->user_login, $overall_result, $overall_blog_names)
			);
		}
		return $overall_result;
	}

	function add_pointer_popups () {
		$pointers = array();
		$email_ttl = esc_html(wp_strip_all_tags($this->data->get_option('email_msg_title')));
		$email_msg = esc_html(wp_strip_all_tags($this->data->get_option('email_msg_body')));
		if ($email_msg && $email_ttl) {
			$pointers[] = array(
				'selector' => '.bau_container [name$="[email]"]',
				'message' => '<h3>' . esc_js($email_ttl) . '</h3><p>' . esc_js($email_msg) . '</p>',
			);
		}
		$username_ttl = esc_html(wp_strip_all_tags($this->data->get_option('username_msg_title')));
		$username_msg = esc_html(wp_strip_all_tags($this->data->get_option('username_msg_body')));
		if ($username_msg && $username_ttl) {
			$pointers[] = array(
				'selector' => '.bau_container [name$="[username]"]',
				'message' => '<h3>' . esc_js($username_ttl) . '</h3><p>' . esc_js($username_msg) . '</p>',
			);
		}
		$pwd_ttl = esc_html(wp_strip_all_tags($this->data->get_option('password_msg_title')));
		$pwd_msg = esc_html(wp_strip_all_tags($this->data->get_option('password_msg_body')));
		if ($pwd_msg && $pwd_ttl) {
			$pointers[] = array(
				'selector' => '.bau_container [name$="[password]"]',
				'message' => '<h3>' . esc_js($pwd_ttl) . '</h3><p>' . esc_js($pwd_msg) . '</p>',
			);
		}
		// ...

		if ( ! $pointers )
			return;
		?>
		<script>
			jQuery(document).ready(function($) {
				$(document).on( "bau-tab_selected", function () {
					if ( typeof( jQuery().pointer ) == "undefined" )
						return false;

					<?php foreach ( $pointers as $pointer ): ?>
						$('<?php echo $pointer["selector"]; ?>').first().pointer({
							"position": { "edge": "left", "align": "center" },
							"content": "<?php echo $pointer['message']; ?>"
						}).pointer("open");
					<?php endforeach; ?>
				});
			});
		</script>
		<?php
	}

	/**
	 * Process POSTed request and take appropriate actions.
	 * Redirect with status message when done.
	 */
	function _process () {
		$msg = __('Skipping', 'bau');
		$action = isset($_POST['bau_add']) ? $_POST['bau_add'] : false;
		$result = 1;

		try {
			switch ($action) {
				case "add_new":
					$result = $this->_add_new_users();
					$msg = $result ? __('user(s) successfully added', 'bau') : $msg;
					break;
				case "add_existing":
					$result = $this->_add_existing_users();
					$msg = $result ? __('user(s) successfully added', 'bau') : $msg;
					break;
				case "add_blog":
					$result = $this->_add_blogs();
					$msg = $result ? __('blog(s) successfully created', 'bau') : $msg;
					break;
			}
		} catch (Bau_Exception $e) {
			$msg = $e->getMessage();
			$result = -1;
		} catch (Exception $e) {
			$msg = __('Something went terribly wrong', 'bau');
			$result = -1;
		}
		/*
		$status = $result ? 1 : 0;
		$goback = add_query_arg(array(
			'action' => $action,
			'msg' => urlencode($msg),
			'status' => (int)$status
		),  wp_get_referer());
		wp_redirect($goback);
		*/
		header('Content-type: application/json');
		echo json_encode(array(
			'status' => $result,
			'msg' => $msg,
		));
		exit();
	}

	function add_hooks () {
		if (  is_network_admin() ) {
			add_action('admin_init', array($this, 'register_settings'));
			add_action('network_admin_menu', array($this, 'create_site_admin_menu_entry'));
		}
		add_action('admin_menu', array($this, 'create_users_menu_entry'));
		add_action('admin_print_scripts', array($this, 'js_print_scripts'));
		add_action('admin_print_styles', array($this, 'css_print_styles'));
		add_action('admin_notices', array($this, 'show_message'));

		add_action('wp_ajax_bau_process', array($this, '_process'));

		add_action('admin_footer', array($this, 'add_pointer_popups'));
	}
}