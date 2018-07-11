<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTER')) {

  class ALTER
  {
  	private $wp_df_menu;
  	private $wp_df_submenu;
    public $aof_options;

  	function __construct()
  	{
      $this->aof_options = $this->alter_get_option_data(ALTER_OPTIONS_SLUG);
      add_action('admin_menu', array($this, 'wps_sub_menus'));
	    add_action('admin_init', array($this, 'initialize_defaults'), 19);

	    add_filter('admin_title', array($this, 'custom_admin_title'), 999, 2);
	    add_action( 'init', array($this, 'initFunctionss') );

	    add_action( 'admin_bar_menu', array($this, 'alter_add_title_menu'), 1 );
	    add_action( 'admin_bar_menu', array($this, 'alter_add_nav_menus'), 99);

      add_action( 'wp_before_admin_bar_render', array($this, 'alter_save_adminbar_nodes'), 999 );
      add_action('wp_before_admin_bar_render', array($this, 'alter_remove_admin_bar_items'), 999);

      if($this->aof_options['disable_styles_login'] != 1) {
          if ( ! has_action( 'login_enqueue_scripts', array($this, 'alter_login_assets') ) )
          add_action('login_enqueue_scripts', array($this, 'alter_login_assets'), 10);
          add_action('login_head', array($this, 'alterLogincss'));
          add_action('login_header', array($this, 'alter_login_form_wrap_start'), 1);
          add_action('login_footer', array($this, 'alter_login_form_wrap_close'), 1);
      }

	    add_action( 'admin_enqueue_scripts', array($this, 'alter_main_assets'), 99999 );
      add_action('admin_head', array($this, 'alterMaincss'), 999);

	    add_filter('login_headerurl', array($this, 'alter_login_url'));
	    add_filter('login_headertitle', array($this, 'alter_login_title'));
	    add_action('admin_head', array($this, 'generalFns'));

	    add_action('admin_bar_menu', array($this, 'update_avatar_size'), 5 );
	    add_action('plugins_loaded',array($this, 'save_change_texts'));
      add_action('alter_data_saved',array($this, 'get_admin_users'));
      add_action('aof_save_data', array($this, 'save_additional_data'));
	    add_action('login_footer', array($this, 'login_footer_content'));

	    add_action('wp_head', array($this, 'frontendActions'), 99999);
      add_action('activated_plugin', array($this, 'alter_activated' ));
      add_action('aof_before_heading', array($this, 'alter_welcome_msg'));

   }

  /*
  * Redirect to settings page after plugin activation
  */
  function alter_activated( $plugin ) {
     if( $plugin == plugin_basename( ALTER_PATH . "/alter.php" ) ) {
         exit( wp_redirect( admin_url( 'admin.php?page=alter-options&status=alter-activated' ) ) );
     }
  }

  function alter_welcome_msg() {
     if(isset($_GET['status']) && $_GET['status'] == "alter-activated") {
         echo '<h1 style="line-height: 1.2em;font-size: 2.8em;font-weight: 400;">' . __('Welcome to ', 'alter') . 'Alter ' . ALTER_VERSION . '</h1>';
         echo '<div class="alter_kb_link"><a target="_blank" href="http://kb.acmeedesign.com/kbase_categories/alter-white-label-wordpress-plugin/">';
         echo __('Visit Knowledgebase', 'alter');
         echo '</a></div>';
     }
  }

  function alter_load_textdomain()
  {
      load_plugin_textdomain('alter', false, dirname( plugin_basename( __FILE__ ) )  . '/languages' );
  }

	public function initialize_defaults(){
	    global $menu, $submenu;
	    $this->wp_df_menu = $menu;
	    $this->wp_df_submenu = $submenu;
	}

  /*
  * function to determine multi customization is enabled
  */
	function is_wp_single() {
	    if(!is_multisite())
		    return true;
	    elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL'))
		    return true;
	    else return false;
	}

  function alter_get_wproles() {
      global $wp_roles;
      if ( ! isset( $wp_roles ) ) {
          $wp_roles = new WP_Roles();
      }
      return $wp_roles->get_names();
  }

  function alter_get_user_role() {
      global $current_user;
      $get_user_roles = $current_user->roles;
      $get_user_role = array_shift($get_user_roles);
      return $get_user_role;
  }

	public function initFunctionss(){
      if($this->aof_options['disable_auto_updates'] == 1)
        add_filter( 'automatic_updater_disabled', '__return_true' );

      if($this->aof_options['disable_update_emails'] == 1)
        add_filter( 'auto_core_update_send_email', '__return_false' );

      if($this->aof_options['hide_profile_color_picker'] == 1) {
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
      }
      register_nav_menus(array(
        'alter_add_adminbar_menu' => 'Adminbar Menu'
      ));
      add_filter('gettext', array($this, 'change_admin_texts'), 99999, 3);
      //add_filter('gettext_with_context', array($this, 'change_admin_texts'), 99999, 3);
	}

  function alter_login_form_wrap_start() {
    echo '<div class="alter-form-container">
    <div class="form-bg"></div>';
  }

  function alter_login_form_wrap_close() {
    echo '<div class="clear"></div></div>';
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery( "#user_login" ).before( "<div class='alter-icon-login'></div>" );
        jQuery( "#user_email" ).before( "<div class='alter-icon-email'></div>" );
        jQuery( "#user_pass" ).before( "<div class='alter-icon-pwd'></div>" );
      });
    </script>
    <?php
  }

	public function alter_login_assets()
	{
    wp_enqueue_script("jquery");
    wp_enqueue_script( 'loginjs-js', ALTER_DIR_URI . 'assets/js/loginjs.js', array( 'jquery' ), '', true );
	}

	public function alter_main_assets($nowpage)
	{
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'jquery-ui-sortable' );

    if($nowpage == 'alter_page_alter_add_dash_widgets' || $nowpage == 'alter_page_alter_change_text'
    || $nowpage == 'alter_page_alter_redirect_users' || $nowpage == 'alter_page_admin_menu_management') {
      wp_enqueue_script( 'alter-repeater', ALTER_DIR_URI . 'assets/js/jquery.repeater.js', array( 'jquery' ), '', true );
      wp_enqueue_script( 'alter-scriptjs', ALTER_DIR_URI . 'assets/js/script.js', array( 'jquery' ), '', true );
      wp_enqueue_script( 'alter-sortjs', ALTER_DIR_URI . 'assets/js/sortjs.js', array( 'jquery' ), '', true );
    }

    wp_enqueue_style('alterfmk', ALTER_DIR_URI . 'assets/css/alter.framework.css', '', ALTER_VERSION);

    if(isset($this->aof_options['disable_admin_pages_styles']) && $this->aof_options['disable_admin_pages_styles'] == 1)
      return;

    wp_enqueue_style('alterAdmin-css', ALTER_DIR_URI . 'assets/css/alter.styles.css', '', ALTER_VERSION);
    if($nowpage == 'toplevel_page_alter-options') {
      wp_enqueue_script( 'alter-livepreview', ALTER_DIR_URI . 'assets/js/live-preview.js', array( 'jquery' ), '', true );
    }

	}

	public function alterLogincss()
	{
    include_once( ALTER_PATH . '/includes/css/alter.login.css.php' );
	}

	public function alterMaincss()
	{
    if(isset($this->aof_options['disable_admin_pages_styles']) && $this->aof_options['disable_admin_pages_styles'] == 1)
    return;
	  include_once( ALTER_PATH . '/includes/css/alter.admin.css.php' );
	}

	public function generalFns() {
    $screen = "";
    if(function_exists('get_current_screen')) {
	    $screen = get_current_screen();
    }
    $admin_general_options_data = ( !empty($this->aof_options['admin_generaloptions']) ) ? $this->aof_options['admin_generaloptions'] : "";
    $admin_generaloptions = (is_serialized( $admin_general_options_data )) ? unserialize( $admin_general_options_data ) : $admin_general_options_data;
    if(!empty($admin_generaloptions)) {
      foreach($admin_generaloptions as $general_opt) {
        if(isset($screen) && !empty($screen) && $general_opt == 1) {
          $screen->remove_help_tabs();
        }
        elseif($general_opt == 2) {
          add_filter('screen_options_show_screen', '__return_false');
        }
        elseif($general_opt == 3) {
          remove_action('admin_notices', 'update_nag', 3);
          remove_submenu_page('index.php', 'update-core.php');
        }
        elseif($general_opt == 4) {
          echo '<style type="text/css">.plugin-update-tr{ display:none}</style>';
        }
      }
    }
	    //footer contents
	    add_filter( 'admin_footer_text', array($this, 'alter_custom_footer_content') );
	    //remove wp version
	    add_filter( 'update_footer', array($this, 'alter_remove_wp_version'), 99);

	    //prevent access to Alter menu for non-superadmin
	    if( (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') ){
    		if($screen->id == "toplevel_page_alter-options" || $screen->id == "alter_page_admin_menu_management" || $screen->id == "alter_page_alter_change_text"
      || $screen->id == "alter_page_alter_impexp_settings") {
    		    wp_die("<div style='width:70%; margin: 30px auto; padding:30px; background:#fff'><h4>Sorry, you don't have sufficient previlege to access to this page!</h4></div>");
    		    exit();
    		}
	    }

	}

	public function custom_admin_title($admin_title, $title)
	{
	    return get_bloginfo('name') . " &#45; " . $title;
	}

	function custom_email_addr($email){
      if($this->aof_options['email_settings'] == 1)
        return get_option('admin_email');
      else return $this->aof_options['email_from_addr'];
	}

	function custom_email_name($name){
      if($this->aof_options['email_settings'] == 1)
        return get_option('blogname');
      else return $this->aof_options['email_from_name'];
	}

  function change_admin_texts($translated_text, $default_text, $domain) {
      //if(!is_admin())
          //return $translated_text;
      $change_texts = (isset($this->aof_options['change_text'])) ? $this->aof_options['change_text'] : "";
      if(!empty($change_texts) && is_array($change_texts)) {
          foreach ($change_texts as $findandreplace) {
              if(isset($findandreplace['casensitive'][0])) {
                  $translated_text = str_replace($findandreplace['find'], $findandreplace['replace'], $translated_text);
              }
              else {
                  $translated_text = str_ireplace($findandreplace['find'], $findandreplace['replace'], $translated_text);
              }
          }
      }
      return $translated_text;
  }

	function wps_sub_menus()
	{
	    //add options page to sort and remove admin menus.
      add_submenu_page( ALTER_MENU_SLUG, __('Change Text', 'alter'), __('Change Text', 'alter'), 'manage_options', 'alter_change_text', array($this, 'alterChangetext') );

	    //Remove Alter menu
	    if( defined('HIDE_ALTER_OPTION_LINK') || (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') )
		    remove_menu_page(ALTER_MENU_SLUG);
	}

  function alterChangetext() {
        ?>
    <div class="wrap alter-wrap">
        <h2><?php _e('Change text on admin pages', 'alter'); ?></h2>
        <form name="alter_change_text" method="post">
            <div id="alt-repeater">
                <div data-repeater-list="change_text">
                    <?php
                    if(isset($this->aof_options['change_text']) && !empty($this->aof_options['change_text'])) {
                    //display saved repeaters
                    foreach ($this->aof_options['change_text'] as $repeater) {
                        ?>
                    <div data-repeater-item="" class="repeater-item">
                        <button type="button" class="r-btnRemove button action" data-repeater-delete=""><?php _e('Remove', 'alter'); ?></button>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="find-text"><strong><?php _e('Text to find', 'alter'); ?></strong></label>
                            </div>
                            <div class="field_content">
                                <input type="text" name="change_text[0][find]" value="<?php echo esc_attr(stripslashes($repeater['find'])); ?>" />
                            </div>
                        </div>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="replace-text">
                                    <strong><?php _e('Text to replace', 'alter'); ?></strong>
                                </label>
                            </div>
                            <div class="field_content">
                                <input type="text" name="change_text[0][replace]" value="<?php echo esc_attr(stripslashes($repeater['replace'])); ?>" />
                            </div>
                        </div>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="case-sensitive">
                                    <strong><?php _e('Case sensitive?', 'alter'); ?></strong>
                                </label>
                            </div>
                            <div class="field_content">
                                <?php $checked = (isset($repeater['casensitive'][0])) ? "checked=checked" : ""; ?>
                                <input type="checkbox" name="change_text[0][casensitive]" <?php echo $checked; ?> />
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    }
                    ?>
                    <div data-repeater-item="" class="repeater-item">
                        <button type="button" class="r-btnRemove button action" data-repeater-delete=""><?php _e('Remove', 'alter'); ?></button>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="find-text"><strong><?php _e('Text to find', 'alter'); ?></strong></label>
                            </div>
                            <div class="field_content">
                                <input type="text" name="change_text[0][find]"  />
                            </div>
                        </div>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="replace-text">
                                    <strong><?php _e('Text to replace', 'alter'); ?></strong>
                                </label>
                            </div>
                            <div class="field_content">
                                <input type="text" name="change_text[0][replace]"  />
                            </div>
                        </div>
                        <div class="field_wrap">
                            <div class="label">
                                <label for="case-sensitive">
                                    <strong><?php _e('Case sensitive?', 'alter'); ?></strong>
                                </label>
                            </div>
                            <div class="field_content">
                                <input type="checkbox" name="change_text[0][casensitive]" value="1" />
                            </div>
                        </div>

                    </div>

                </div>
                <div class="button-group">
                    <button type="button" class="button button-primary alt-text-add" data-repeater-create=""><?php _e('Add text', 'alter'); ?></button>
                </div>
            </div>
            <input type="hidden" name="alter_change_text" value="1" />
            <input type="submit" name="submit" value="<?php _e('Save Now', 'alter'); ?>" class="save button button-primary button-hero" />
        </form>
    </div>
  <?php
          }

  //filter fn to add extra data to aof framework options
  function save_additional_data($data) {
      $saved_data = $this->aof_options;
      $data = array_merge($saved_data, $data);
      return $data;
  }

	public function save_change_texts()
	{
      if(isset($_POST['alter_change_text'])) {
          if(!empty($_POST['change_text'])) {
              $repeater_array = $_POST['change_text'];
                  foreach($repeater_array as $repeaters ) {
                      //if(!empty($repeaters['find']) && !empty($repeaters['replace'])) {
                      if(!empty($repeaters['find'])) {
                          $repeater['change_text'][] = $repeaters;
                      }
                  }
                  $saved_data = $this->alter_get_option_data(ALTER_OPTIONS_SLUG);
                  $data = array_merge($saved_data, $repeater);
                  $this->updateOption(ALTER_OPTIONS_SLUG,$data);
                  wp_safe_redirect( admin_url( 'admin.php?page=alter_change_text&status=updated' ) );
                  exit();

          }
      }
	}

  function customizephpFix($url) {
      if(preg_match('/customize.php?/', $url) && preg_match('/autofocus/', $url)) {
          $url_decode = explode('autofocus[control]=', rawurldecode($url));
          return $url_decode[1];
      }
      else return $url;
  }

	function login_footer_content()
	{
    if($this->aof_options['disable_styles_login'] != 1) {
      $login_footer_content = $this->aof_options['login_footer_content'];
      echo '<div class="login_footer_content">';
      echo '<div class="footer_content">';
      if(!empty($login_footer_content)) {
          echo do_shortcode ($this->aof_options['login_footer_content']);
      }
      echo '</div>';
      echo '</div>';
    }
	}

	function alter_custom_footer_content()
	{
    echo $this->aof_options['admin_footer_txt'];
	}

	function alter_remove_wp_version()
	{
		return '';
	}

	//admin bar customization
	function alter_remove_admin_bar_items()
	{
      global $wp_admin_bar;
      if(isset($this->aof_options['remove_adminbar_items']) && !empty($this->aof_options['remove_adminbar_items'])){
        foreach ($this->aof_options['remove_adminbar_items'] as $hide_bar_menu) {
          $wp_admin_bar->remove_menu($hide_bar_menu);
        }
      }
	}

	public function alter_add_title_menu($wp_admin_bar) {
      if(!empty($this->aof_options['admin_logo']) || !empty($this->aof_options['admin_external_logo_url'])) {
        $wp_admin_bar->add_node( array(
          'id'    => 'alter_admin_title',
          'href'  => admin_url(),
          'meta'  => array( 'class' => 'alter_admin_title' )
        ) );
      }
	}

	public function alter_add_nav_menus($wp_admin_bar)
	{
		//add Nav items to adminbar
		if( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'alter_add_adminbar_menu' ] ) ) {

			$custom_nav_object = wp_get_nav_menu_object( $locations[ 'alter_add_adminbar_menu' ] );
			if(!isset($custom_nav_object->term_id))
				return;
			$menu_items = wp_get_nav_menu_items( $custom_nav_object->term_id );

			foreach( (array) $menu_items as $key => $menu_item ) {
				if( $menu_item->classes ) {
					$classes = implode( ' ', $menu_item->classes );
				} else {
					$classes = "";
				}
				$meta = array(
					'class' 	=> $classes,
					'target' 	=> $menu_item->target,
					'title' 	=> $menu_item->attr_title
				);
				if( $menu_item->menu_item_parent ) {
					$wp_admin_bar->add_node(
						array(
						'parent' 	=> $menu_item->menu_item_parent,
						'id' 		=> $menu_item->ID,
						'title' 	=> $menu_item->title,
						'href' 		=> $menu_item->url,
						'meta' 		=> $meta
						)
					);
				} else {
					$wp_admin_bar->add_node(
						array(
						'id' 		=> $menu_item->ID,
						'title' 	=> $menu_item->title,
						'href' 		=> $menu_item->url,
						'meta' 		=> $meta
						)
					);
				}
			} //foreach
		}
	}

	public function update_avatar_size( $wp_admin_bar ) {

		//update avatar size
		$user_id      = get_current_user_id();
		$current_user = wp_get_current_user();
		if ( ! $user_id )
			return;
		$avatar = get_avatar( $user_id, 36 );
		$howdy  = sprintf( __('Howdy, %1$s'), $current_user->display_name );
		$account_node = $wp_admin_bar->get_node( 'my-account' );
		$title = $howdy . $avatar;
		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'title' => $title
			) );

	}

  //fn to save options
  public function updateOption($option='', $data) {
      if(empty($option)) {
          $option = ALTER_OPTIONS_SLUG;
      }
      if(isset($data) && !empty($data)) {
          if($this->is_wp_single())
            update_option($option, $data);
          else
            update_site_option($option, $data);
      }
  }

	function alter_get_option_data( $option_id ) {
	    if($this->is_wp_single()) {
          $alter_get_option_data = (is_serialized(get_option($option_id))) ? unserialize(get_option($option_id)) : get_option($option_id);
       }
	    else {
          $alter_get_option_data = (is_serialized(get_site_option($option_id))) ? unserialize(get_site_option($option_id)) : get_site_option($option_id);
      }
      return $alter_get_option_data;
	}

  function alter_get_icon_class($iconData) {
      if(!empty($iconData)) {
          $icon_class = explode('|', $iconData);
          if(isset($icon_class[0]) && isset($icon_class[1])) {
              return $icon_class[0] . ' ' . $icon_class[1];
          }
      }
  }

	public function alter_get_image_url($imgid, $size='full') {
	    global $switched, $wpdb;

	    if ( is_numeric( $imgid ) ) {
      	if(!$this->is_wp_single()) {
          switch_to_blog(1);
          $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
          restore_current_blog();
        }
        else $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
      	return $imageAttachment[0];
	    }
	}

	public function alter_login_url()
	{
    $login_logo_url = $this->aof_options['login_logo_url'];
    if(empty($login_logo_url))
            return site_url();
    else return $login_logo_url;
	}
	public function alter_login_title()
	{
    return get_bloginfo('name');
	}

	private function wps_clean_name($var){
    $variable = trim(strtolower($var));
    $variable = str_replace(" ", "_", $variable);
    return $variable;
	}

  function clean_title($title) {
    $clean_title = trim(preg_replace('/[0-9]+/', '', $title));
    return $clean_title;
  }

  function alter_clean_slug($slug) {
    $clean_slug = trim(preg_replace("/[^a-zA-Z0-9]+/", "", $slug));
    return $clean_slug;
  }

  public function alterCompress_css($css) {
    $cssContents = "";
    // Remove comments
    $cssContents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove space after colons
    $cssContents = str_replace(': ', ':', $cssContents);
    // Remove whitespace
    $cssContents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $cssContents);
    return $cssContents;
  }

  function alter_save_adminbar_nodes() {
    global $wp_admin_bar;
    if ( !is_object( $wp_admin_bar ) )
        return;

    $all_nodes = $wp_admin_bar->get_nodes();
    $adminbar_nodes = array();
    foreach( $all_nodes as $node )
    {
      if(!empty($node->parent)) {
        $node_data = $node->id . " <strong>(Parent: " . $node->parent . ")</strong>";
      }
      else {
        $node_data = $node->id;
      }
      $adminbar_nodes[$node->id] = $node_data;
    }
    $this->updateOption(ALTER_ADMINBAR_LISTS_SLUG,$adminbar_nodes);
  }

  /* Convert hexdec color string to rgb(a) string */
  function alter_hex2rgba($color, $opacity = false) {

  	$default = 'rgb(0,0,0)';

  	//Return default if no color provided
  	if(empty($color))
      return $default;

  	//Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
    	$color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity){
    	if(abs($opacity) > 1)
    		$opacity = 1.0;
    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
    	$output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
  }

  function get_admin_users() {
    if(isset($_POST) && isset($_POST['aof_options_save'])) {
      $admin_users = array();
      $admin_user_query = new WP_User_Query( array( 'meta_key' => 'wp_user_level', 'meta_value' => '10' ) );
      if(empty($admin_user_query) && !is_array($admin_user_query)) {
        $admin_user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
      }

      foreach ($admin_user_query->results as $admin_data) {
        if(!empty($admin_data->data->display_name)) {
          $user_display_name = $admin_data->data->display_name;
        }
        else {
          $user_display_name = $admin_data->data->user_login;
        }
        $admin_users[$admin_data->ID] = $user_display_name;
      }

      // $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
      // if(isset($user_query) && !empty($user_query)) {
      //     if ( ! empty( $user_query->results ) ) {
      //         foreach ( $user_query->results as $user_detail ) {
      //             $admin_users[$user_detail->ID] = $user_detail->display_name;
      //         }
      //     }
      // }

      if(!empty($admin_users)) {
        update_option(ALTER_ADMIN_USERS_SLUG, $admin_users);
      }
    }
  }

	function frontendActions()
	{
    //remove admin bar
    if($this->aof_options['hide_admin_bar'] == 1) {
        add_filter( 'show_admin_bar', '__return_false' );
        echo '<style type="text/css">html { margin-top: 0 !important; }</style>';
    }
    else {
?>
<style type="text/css">
    #wpadminbar, #wpadminbar .menupop .ab-sub-wrapper, .ab-sub-secondary, #wpadminbar .quicklinks .menupop ul.ab-sub-secondary, #wpadminbar .quicklinks .menupop ul.ab-sub-secondary .ab-submenu { background: <?php echo $this->aof_options['admin_bar_color']; ?>;}
#wpadminbar a.ab-item, #wpadminbar>#wp-toolbar span.ab-label, #wpadminbar>#wp-toolbar span.noticon, #wpadminbar .ab-icon:before, #wpadminbar .ab-item:before { color: <?php echo $this->aof_options['admin_bar_menu_color']; ?> }
#wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a { color: <?php echo $this->aof_options['admin_bar_menu_color']; ?>; font-size:13px !important }

#wpadminbar .ab-top-menu>li.hover>.ab-item,#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,#wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus{background:<?php echo $this->aof_options['admin_bar_menu_bg_hover_color']; ?>; color:<?php echo $this->aof_options['admin_bar_menu_hover_color']; ?>}
#wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label,#wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label,#wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar.mobile .quicklinks .hover .ab-icon:before,#wpadminbar.mobile .quicklinks .hover .ab-item:before, #wpadminbar .quicklinks .menupop .ab-sub-secondary>li .ab-item:focus a,#wpadminbar .quicklinks .menupop .ab-sub-secondary>li>a:hover, #wpadminbar #wp-admin-bar-user-info .display-name, #wpadminbar>#wp-toolbar>#wp-admin-bar-root-default li:hover span.ab-label  {color:<?php echo $this->aof_options['admin_bar_menu_hover_color']; ?>}
#wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a,#wpadminbar .quicklinks .menupop ul li a:focus,#wpadminbar .quicklinks .menupop ul li a:focus strong,#wpadminbar .quicklinks .menupop ul li a:hover,#wpadminbar .quicklinks .menupop ul li a:hover strong,#wpadminbar .quicklinks .menupop.hover ul li a:focus,#wpadminbar .quicklinks .menupop.hover ul li a:hover,#wpadminbar li #adminbarsearch.adminbar-focused:before,#wpadminbar li .ab-item:focus:before,#wpadminbar li a:focus .ab-icon:before,#wpadminbar li.hover .ab-icon:before,#wpadminbar li.hover .ab-item:before,#wpadminbar li:hover #adminbarsearch:before,#wpadminbar li:hover .ab-icon:before,#wpadminbar li:hover .ab-item:before,#wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus,#wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover, #wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a .blavatar,#wpadminbar .quicklinks li a:focus .blavatar,#wpadminbar .quicklinks li a:hover .blavatar{color:<?php echo $this->aof_options['admin_bar_menu_hover_color']; ?>}
#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {background:<?php echo $this->aof_options['admin_bar_menu_bg_hover_color']; ?>;}

#wpadminbar .ab-submenu .ab-item, #wpadminbar .quicklinks .menupop ul.ab-submenu li a, #wpadminbar .quicklinks .menupop ul.ab-submenu li a.ab-item { color: <?php echo $this->aof_options['admin_bar_sbmenu_link_color']; ?>;}
#wpadminbar .ab-submenu .ab-item:hover, #wpadminbar .quicklinks .menupop ul.ab-submenu li a:hover, #wpadminbar .quicklinks .menupop ul.ab-submenu li a.ab-item:hover { color: <?php echo $this->aof_options['admin_bar_sbmenu_link_hover_color']; ?>;}

    div#wpadminbar li#wp-admin-bar-alter_admin_title {
    <?php if(isset($this->aof_options['admin_bar_logo_bg_color'])) { ?>
    background-color: <?php echo $this->aof_options['admin_bar_logo_bg_color']; ?>;
    <?php } ?>
    }

.quicklinks li.alter_admin_title { width: 200px !important; }
.quicklinks li.alter_admin_title a{ margin-left:20px !important; outline:none; border:none;}
<?php
if(!empty($this->aof_options['admin_external_logo_url']) && filter_var($this->aof_options['admin_external_logo_url'], FILTER_VALIDATE_URL)) {
  $adminbar_logo = esc_url( $this->aof_options['admin_external_logo_url']);
}
else {
  $adminbar_logo = (is_numeric($this->aof_options['admin_logo'])) ? $this->alter_get_image_url($this->aof_options['admin_logo']) : $this->aof_options['admin_logo'];
}

if(!empty($adminbar_logo)){
  $hor_position = (empty($this->aof_options['logo_position']) || $this->aof_options['logo_position'] == 1) ?
  "20px" : $this->aof_options['logo_position'];
  ?>
.quicklinks li.alter_admin_title a, .quicklinks li.alter_admin_title a:hover, .quicklinks li.alter_admin_title a:focus {
    background:url(<?php echo $adminbar_logo;  ?>) <?php echo $hor_position; ?> center no-repeat !important; text-indent:-9999px !important; width: auto;background-size: contain!important;
}
<?php } ?>
#wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img {width: 20px; height: 20px; border-radius: 100px; -moz-border-radius: 100px; -webkit-border-radius: 100px; border: none; }
#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input { -webkit-box-shadow: none !important;	-moz-box-shadow: none !important;box-shadow: none !important;}
		</style>
		<?php
	    }
	}

  public function hideupdateNotices() {
    echo '<style>.update-nag, .updated, .notice { display: none; }</style>';
  }

	public static function deleteOptions()
	{
		//delete_option( ALTER_OPTIONS_SLUG );
	}

        }

}

new ALTER();
