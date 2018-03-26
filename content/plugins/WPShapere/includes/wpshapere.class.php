<?php
/*
 * WPSHAPERE
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('WPSHAPERE')) {

  class WPSHAPERE
  {
  	private $wp_df_menu;
  	private $wp_df_submenu;
  	private $wps_options = WPSHAPERE_OPTIONS_SLUG;
  	private $wps_menuorder_options = 'wpshapere_menuorder';
    private $wps_purchase_data = 'wps_purchase_data';
    public $aof_options;
    private $do_not_save;

	function __construct()
	{
      $this->do_not_save = array('title', 'openTab', 'import', 'export');
      $this->aof_options = $this->get_wps_option_data($this->wps_options);
      add_action('admin_menu', array($this, 'wps_sub_menus'));
      add_action('wp_dashboard_setup', array($this, 'initialize_dash_widgets'), 999);

	    add_filter('admin_title', array($this, 'custom_admin_title'), 999, 2);
	    add_action( 'init', array($this, 'initFunctionss') );

	    add_action( 'admin_bar_menu', array($this, 'add_wpshapere_menus'), 1 );
	    add_action( 'admin_bar_menu', array($this, 'add_wpshapere_nav_menus'), 99);
      add_action( 'admin_bar_menu', array($this, 'wps_save_adminbar_nodes'), 999 );
	    add_action('wp_dashboard_setup', array($this, 'widget_functions'), 9999);
      if($this->aof_options['disable_styles_login'] != 1) {
          if ( ! has_action( 'login_enqueue_scripts', array($this, 'wpshapereloginAssets') ) )
            add_action('login_enqueue_scripts', array($this, 'wpshapereloginAssets'), 10);
          add_action('login_head', array($this, 'wpshapeLogincss'));
       }
	    add_action( 'admin_enqueue_scripts', array($this, 'wpshapereAssets'), 99999 );
      add_action('admin_head', array($this, 'wpshapeOptionscss'));
	    add_action('wp_before_admin_bar_render', array($this, 'wps_remove_bar_links'), 0);
	    add_filter('login_headerurl', array($this, 'wpshapere_login_url'));
	    add_filter('login_headertitle', array($this, 'wpshapere_login_title'));
	    add_action('admin_head', array($this, 'generalFns'));

	    //add_action('plugins_loaded',array($this, 'download_settings'));
      add_action('plugins_loaded',array($this, 'get_admin_users'));
	    add_action('login_footer', array($this, 'login_footer_content'));

	    add_action('wp_head', array($this, 'frontendActions'), 99999);
      add_action( 'activated_plugin', array($this, 'wps_activated' ));
      add_action( 'aof_before_heading', array($this, 'wps_welcome_msg'));
      add_filter( 'login_title', array($this, 'login_page_title') );
	}

    /*
    * Redirect to settings page after plugin activation
    */
   function wps_activated( $plugin ) {
     if( $plugin == plugin_basename( WPSHAPERE_PATH . "wpshapere.php" ) ) {
       exit( wp_redirect( admin_url( 'admin.php?page=wpshapere-options&status=wps-activated' ) ) );
     }
   }

  function wps_welcome_msg() {
     if(isset($_GET['status']) && $_GET['status'] == "wps-activated") {
       echo '<h1 style="line-height: 1.2em;font-size: 2.8em;font-weight: 400;">' . __('Welcome to WPShapere ', 'wps') . WPSHAPERE_VERSION . '</h1>';
       echo '<div class="wps_kb_link"><a target="_blank" href="http://kb.acmeedesign.com/kbase_categories/wpshapere/">';
       echo __('Visit Knowledgebase', 'wps');
       echo '</a></div>';
     }
  }

  function wps_load_textdomain()
  {
    load_plugin_textdomain('wps', false, dirname( plugin_basename( __FILE__ ) )  . '/languages' );
  }

  /* custom login page title */
  function login_page_title() {
    if(!empty($this->aof_options['login_page_title'])) {
      return $this->aof_options['login_page_title'];
    }
    else return get_bloginfo('name');
  }

  /*
  * function to determine multi customization is enabled
  */
	public function is_wps_single() {
	    if(!is_multisite())
		return true;
	    elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL'))
		return true;
	    else return false;
	}

	public function initFunctionss(){
		if($this->aof_options['disable_auto_updates'] == 1)
			add_filter( 'automatic_updater_disabled', '__return_true' );

		if($this->aof_options['disable_update_emails'] == 1)
			add_filter( 'auto_core_update_send_email', '__return_false' );

		if($this->aof_options['email_settings'] != 3) {
			add_filter( 'wp_mail_from', array($this, 'custom_email_addr') );
			add_filter( 'wp_mail_from_name', array($this, 'custom_email_name') );
		}

		if($this->aof_options['hide_profile_color_picker'] == 1) {
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		}
		register_nav_menus(array(
			'wpshapere_adminbar_menu' => 'Adminbar Menu'
		));
	}

	public function wpshapereloginAssets()
	{
		echo "<link rel='stylesheet' id='wpshapeLogin-css-css'  href='" . admin_url('admin-ajax.php') . "?action=wpshapeLogincss' type='text/css' media='all' />";
		wp_enqueue_script("jquery");
		wp_enqueue_script( 'loginjs-js', WPSHAPERE_DIR_URI . 'assets/js/loginjs.js', array( 'jquery' ), '', true );
	}
	public function wpshapereAssets($nowpage)
	{
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style('fontAwesome', WPSHAPERE_DIR_URI . 'assets/font-awesome/css/font-awesome.min.css', '', WPSHAPERE_VERSION);
    if($nowpage == 'toplevel_page_wpshapere-options') {
      wp_enqueue_script( 'wps-livepreview', WPSHAPERE_DIR_URI . 'assets/js/live-preview.js', array( 'jquery' ), '', true );
    }
	}

	public function wpshapeLogincss()
	{
    include_once(WPSHAPERE_PATH.'assets/css/wpshapere.login.css.php');
	}

	public function wpshapeOptionscss()
	{
	  include_once(WPSHAPERE_PATH.'assets/css/wpshapere.css.php');
    //echo '<link rel="stylesheet" href="'. WPSHAPERE_DIR_URI .'assets/styles/style.css">';
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

      if(!empty($admin_users)) {
        update_option(WPS_ADMIN_USERS_SLUG, $admin_users);
      }
    }
  }

	public function generalFns() {
	    $screen = get_current_screen();
      $admin_general_options_data = ( !empty($this->aof_options['admin_generaloptions']) ) ? $this->aof_options['admin_generaloptions'] : "";
      $admin_generaloptions = (is_serialized( $admin_general_options_data )) ? unserialize( $admin_general_options_data ) : $admin_general_options_data;
      if(!empty($admin_generaloptions)) {
        foreach($admin_generaloptions as $general_opt) {
          if(isset($screen) && $general_opt == 1) {
                  $screen->remove_help_tabs();
          }
          elseif($general_opt == 2) {
                  add_filter('screen_options_show_screen', '__return_false');
          }
          elseif($general_opt == 3) {
                  remove_action('admin_notices', 'update_nag', 3);
          }
          elseif($general_opt == 4) {
                  remove_submenu_page('index.php', 'update-core.php');
          }
        }
	    }
	    //footer contents
	    add_filter( 'admin_footer_text', array($this, 'wpsbrandFooter') );
	    //remove wp version
	    add_filter( 'update_footer', array($this, 'wpsremoveVersion'), 99);
      //add video responsive styles
      add_action('admin_head', array($this, 'wps_video_frame_css'), 999);

	    //prevent access to wpshapere menu for non-superadmin
	    if( (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') ){
		if($screen->id == "toplevel_page_wpshapere-options" || $screen->id == "wpshapere-options_page_wps_admin_menuorder" || $screen->id == "wpshapere-options_page_wps_impexp_settings") {
		    wp_die("<div style='width:70%; margin: 30px auto; padding:30px; background:#fff'><h4>Sorry, you don't have sufficient previlege to access to this page!</h4></div>");
		    exit();
		}
	    }
	?>

		<?php
	}

	public function custom_admin_title($admin_title, $title)
	{
	    return get_bloginfo('name') . " &#45; " . $title;
	}

	public function custom_email_addr($email){
		if($this->aof_options['email_settings'] == 1)
			return get_option('admin_email');
		else return $this->aof_options['email_from_addr'];
	}

	public function custom_email_name($name){
		if($this->aof_options['email_settings'] == 1)
			return get_option('blogname');
		else return $this->aof_options['email_from_name'];
	}

	public function wps_sub_menus()
	{
    //Remove wpshapere menu
    if( defined('HIDE_WPSHAPERE_OPTION_LINK') || (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') )
	    remove_menu_page('wpshapere-options');
	}

	public function wpsmenuOrder()
	{
	    global $menu, $submenu,$aof_options;
	    $wps_sorteddmenu = $this->get_wps_option_data($this->wps_menuorder_options);
	    $submenu_sort_exists = $wps_sorteddmenu['index.php_sbchild'];
      $aof_options->licenseValidate();
	    echo '<div class="wrap"><h2>';
      echo __('Customize Admin Menus', 'wps');
      echo '</h2><div id="message" class="updated below-h2"><p>';
      echo __('By default, all menu items will be shown to administrator users. ', 'wps');
      echo '<a href="' . admin_url() . 'admin.php?page=wpshapere-options&tab=general_options#wpshapere_show_all_menu_to_admin2"><strong>';
      echo __('Click here ', 'wps');
      echo '</strong></a>';
      echo __('to customize who can access to all menu items.', 'wps');
      echo '</p></div><div class="wps_menu_order">';
	    echo '<form class="menu_sort_form" name="menu_sort" method="post" action="">';
	    echo '<ol class="sortable sortUls" id="menu_sortable_left">';
	    $menu_num = 0;

	    $parItems = $this->wp_df_menu;

	    foreach ($parItems as $k => $menuItem) {
		$menu_num++;
		if(!empty($menuItem[0])) {
		    $menu_slug = $menuItem[2];
		    $get_menu_name = explode("<span", $menuItem[0]);
		    $menu_name = (empty($get_menu_name[0])) ? $menu_slug : $get_menu_name[0];
		    $wps_clean_name = $this->wps_clean_name($get_menu_name[0]);
		    $wps_menu_data = (isset($wps_sorteddmenu[$wps_clean_name])) ? $wps_sorteddmenu[$wps_clean_name] : NULL; //print_r($wps_menu_data);
		    $menu_hide = ($wps_menu_data[3] == "hide") ? "checked='checked'" : "";
		    $custom_menu_label = (isset($wps_menu_data[0])) ? $wps_menu_data[0] : "";
		    $custom_menu_icon = (isset($wps_menu_data[2])) ? $wps_menu_data[2] : "";
		    $custom_icon = (isset($custom_menu_icon)) ? explode("|", $custom_menu_icon) : "";
echo '<li><div class="menuDiv">';
echo '<div class="menu_handle">' . $menu_name . '<a href="" id="' . $menu_num . '" class="admin_menu_edit"></a>';
echo '<a href="" title="Click to show/hide children" id="' . $menu_num . '" class="disclose plus"></a>';
echo '</div>';
echo '<div style="display:none;" class="menu_edit_content" id="menu_edit_'.$menu_num.'">';
echo '<input type="hidden" name="parentmenu_item['.$menu_num.']" value="'.$wps_clean_name.'^' . $menu_slug . '^' . $menu_num . '" />';
//menu name
echo '<input type="hidden" name="menu_item_name['.$menu_num.']" value="'.$wps_clean_name.'" />';
//custom label
echo '<div class="menu_edit_wrap"><label>Rename Label</label><input autocomplete="off" type="text" class="widefat edit-menu-item-title" name="menu_item_label['.$menu_num.']" value="'. $custom_menu_label .'" /></div>';
//custom icon
echo '<div class="menu_edit_wrap"><input class="regular-text" type="hidden" id="menu_icon_picker_'.$menu_num.'" name="menu_item_icon['.$menu_num.']" value="'.$custom_menu_icon.'"/>
<label for="icon_picker">Choose Icon</label><div id="" data-target="#menu_icon_picker_'.$menu_num.'" class="icon-picker ';
if(isset($custom_icon)) echo $custom_icon[0] . " " . $custom_icon[1];
echo '"></div></div>';
//Show/Hide Link
echo '<div class="menu_edit_wrap"><input type="checkbox"' . $menu_hide . ' class="widefat edit-menu-item-title" name="menu_item_hide['.$menu_num.']" value="hide" /> <label>Hide Link</label></div>';
	echo  '</div></div>';

	//Populating sub menu
	$subItems = (isset($this->wp_df_submenu[$menuItem[2]])) ? $this->wp_df_submenu[$menuItem[2]] : ""; //print_r($subItems);

	if(isset($subItems) && !empty($subItems)) {
    echo '<ol id="child_' . $menu_num . '">';
    foreach($subItems as $subItem_key => $subItem){
      $menu_num++;
      $submenu_name = explode("<span", $subItem[0]);
      $submenu_name = trim($submenu_name[0]);
      $subItem_url = $this->customizephpFix($subItem[2]); //fix for customize.php encoded urls
      $wps_clean_subname = $this->wps_clean_name($submenu_name);
      $sbmenu_custom_label = (isset($wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem_url][1])) ? $wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem_url][1] : ""; //print_r($subItem);

      $sbmenu_hide = (isset($wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem_url][3])) ? $wps_sorteddmenu[$menuItem[2] .'_sbchild'][$subItem_url][3] : "";

      $arr_num = $subItem_key;

      $sbmenu_chk_val = (isset($sbmenu_hide) && $sbmenu_hide == 'hide') ? "checked='checked'" : "";
      echo '<li id="'. $wps_clean_subname .'_'.$menu_num.'"><div class="menu_handle">'. $submenu_name . '<a href="" id="' . $menu_num . '" class="admin_menu_edit"></a></div>';
      echo '<div style="display:none;" class="menu_edit_content" id="menu_edit_'.$menu_num.'">';
      //custom label
      echo '<div class="menu_edit_wrap"><label>Rename Label</label><input type="text" class="widefat edit-menu-item-title" name="' . $wps_clean_name . '_child_label['.$arr_num.']" value="'. $sbmenu_custom_label .'" /></div>';
      echo '<div class="menu_edit_wrap"><input type="checkbox" '. $sbmenu_chk_val . ' class="widefat edit-menu-item-title" name="' . $wps_clean_name . '_child_hide['.$arr_num.']" value="hide" /> <label>Hide Link</label></div>';
      echo '<input type="hidden" name="'. $wps_clean_name .'_child['. $subItem_key .']" value="' . $submenu_name . "^" . $subItem_url . '^' . $subItem_key . '" />';
      echo '</div></li>';
    }
    echo '</ol>';
	}

	echo '</li>'; //close of parent list

		}
	    }

	    echo '</ol>';

	    wp_nonce_field('wps_admin_custommenu_nonce','wps_admin_custommenu_field');
	    echo '<br /><input name="save_sorting" class="button button-primary button-hero" type="submit" value="Save Customization" /><br /><br /><input class="button action" type="submit" name="reset_sorting" value="Reset Customization" onClick="return confirm(\'Do you really want to Reset?\');" />
	    </form>';
	    echo '</div></div>';

	}


  function removeSubmenuitem($item ='' )
  {
      global $submenu;
      if(!empty($subitems)) {
          foreach ($submenu as $key => &$value) {
              if (is_array($value)) {
                  foreach ($value as $subkey => $subvalue) {
                      if ($subvalue[2] == $item) {
                          unset($submenu[$key][$subkey]);
                      }
                  }
              }
          }
      }
  }

  function initialize_dash_widgets() {
      global $wp_meta_boxes;

      $context = array("normal","side","advanced");
      $priority =array("high","low","default","core");

      $wps_widgets_list = $wp_meta_boxes['dashboard'];
      $wps_get_dash_Widgets = array();
      if (!is_array($wps_widgets_list['normal']['core'])) {
          $wps_widgets_list = array('normal'=>array('core'=>array()), 'side'=>array('core'=>array()),'advanced'=>array('core'=>array()));
      }
      foreach ($context as $context_value)
      {
          foreach ($priority as $priority_value)
          {
              if(isset($wps_widgets_list[$context_value][$priority_value]) && is_array($wps_widgets_list[$context_value][$priority_value]))
              {
                  foreach ($wps_widgets_list[$context_value][$priority_value] as $key=>$data) {
                      $key = $key . "|".$context_value;
                      $widget_title = preg_replace("/Configure/", "", strip_tags($data['title']));
                      $wps_get_dash_Widgets[] = array($key, $widget_title);
                  }
              }
          }
      }

      $this->updateOption('wps_widgets_list', $wps_get_dash_Widgets);

  }

	function customizephpFix($url) {
      if(preg_match('/customize.php?/', $url) && preg_match('/autofocus/', $url)) {
          $url_decode = explode('autofocus[control]=', rawurldecode($url));
          return $url_decode[1];
      }
      elseif(preg_match('/customize.php?/', $url)) {
        return 'customize.php';
      }
      else return $url;
  }

	function login_footer_content()
	{
    $login_footer_content = $this->aof_options['login_footer_content'];
    echo '<div class="login_footer_content">';
    if(!empty($login_footer_content)) {
        echo do_shortcode ($this->aof_options['login_footer_content']);
    }
    echo '</div>';
	}

	function wpsbrandFooter()
	{
    echo $this->aof_options['admin_footer_txt'];
	}

	function wpsremoveVersion()
	{
		return '';
	}

  function wps_save_adminbar_nodes() {
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
    $this->updateOption(WPS_ADMINBAR_LIST_SLUG, $adminbar_nodes);
  }

  /**
  * admin bar customization
  * @since 4.9 admin bar customization method rewritten
  * @return null
  */
	function wps_remove_bar_links()
	{
    global $wp_admin_bar;
    $current_user_id = get_current_user_id();
    $wps_menu_access = $this->aof_options['show_all_menu_to_admin'];
    $wps_privilege_users = $this->get_privilege_users();

    if(is_super_admin($current_user_id)) {
      if(isset($wps_menu_access) && $wps_menu_access == 2 && !empty($wps_privilege_users) &&
      !in_array($current_user_id, $wps_privilege_users) && isset($this->aof_options['hide_admin_bar_menus']) && !empty($this->aof_options['hide_admin_bar_menus'])){
        foreach ($this->aof_options['hide_admin_bar_menus'] as $hide_bar_menu) {
                $wp_admin_bar->remove_menu($hide_bar_menu);
        }
      }
    }
    elseif(isset($this->aof_options['hide_admin_bar_menus']) && !empty($this->aof_options['hide_admin_bar_menus'])) {
      foreach ($this->aof_options['hide_admin_bar_menus'] as $hide_bar_menu) {
              $wp_admin_bar->remove_menu($hide_bar_menu);
      }
    }

	}

	function add_wpshapere_menus($wp_admin_bar) {
    $admin_logo_url = (!empty($this->aof_options['adminbar_logo_link'])) ? $this->aof_options['adminbar_logo_link'] : admin_url();
		if(!empty($this->aof_options['admin_logo']) || !empty($this->aof_options['adminbar_external_logo_url'])) {
			$wp_admin_bar->add_node( array(
				'id'    => 'wpshapere_site_title',
				'href'  => $admin_logo_url,
				'meta'  => array( 'class' => 'wpshapere_site_title' )
			) );
		}
	}

	function add_wpshapere_nav_menus($wp_admin_bar)
	{
		//add Nav items to adminbar
		if( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'wpshapere_adminbar_menu' ] ) ) {

			$custom_nav_object = wp_get_nav_menu_object( $locations[ 'wpshapere_adminbar_menu' ] );
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

	function get_wps_option($option_id) {
    //$getoptions = unserialize(get_option( 'wpshapere_options' ));
   // return $getoptions[$option_id];
    //return $this->wpshapereOptions->getOption( $option_id );
	}

	public function get_wps_option_data( $option_id ) {
    if($this->is_wps_single()) {
        $get_wps_option_data = (is_serialized(get_option($option_id))) ? unserialize(get_option($option_id)) : get_option($option_id);
     }
    else {
        $get_wps_option_data = (is_serialized(get_site_option($option_id))) ? unserialize(get_site_option($option_id)) : get_site_option($option_id);
    }
    return $get_wps_option_data;
	}

	function get_wps_image_url($imgid, $size='full') {
    global $switched, $wpdb;

    if ( is_numeric( $imgid ) ) {
  		if(!$this->is_wps_single()) {
          switch_to_blog(1);
          $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
          restore_current_blog();
      }
      else $imageAttachment = wp_get_attachment_image_src( $imgid, $size );
  		return $imageAttachment[0];
    }
	}

  function wps_get_user_role() {
      global $current_user;
      $get_user_roles = $current_user->roles;
      $get_user_role = array_shift($get_user_roles);
      return $get_user_role;
  }

  function wps_get_wproles() {
      global $wp_roles;
      if ( ! isset( $wp_roles ) ) {
          $wp_roles = new WP_Roles();
      }
      return $wp_roles->get_names();
  }

  //fn to save options
  public function updateOption($option='', $data) {
      if(empty($option)) {
        $option = WPSHAPERE_OPTIONS_SLUG;
      }
      if(isset($data) && !empty($data)) {
        if($this->is_wps_single())
          update_option($option, $data);
        else
          update_site_option($option, $data);
      }
  }

	function wpshapere_login_url()
	{
		$login_logo_url = $this->aof_options['login_logo_url'];
		if(empty($login_logo_url))
			return site_url();
		else return $login_logo_url;
	}

	function wpshapere_login_title()
	{
		return get_bloginfo('name');
	}

  function clean_title($title) {
    $clean_title = trim(preg_replace('/[0-9]+/', '', $title));
    return $clean_title;
  }

  function wps_get_file_url_ext($url) {
      $ext = parse_url($url, PHP_URL_PATH);
      if (strpos($ext,'.') !== false) {
          $basename = explode('.', basename($ext));
          return $basename[1];
      }
  }

  function wps_get_domain_name($url) {
      $parse_url = parse_url($url);
      $hostname = explode('.', $parse_url['host']);
      return $hostname;
  }

  public function wps_get_icons(){
    //new method with fa icons php array written instead of using wp_remote_get method
  	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
  	$file_contents = wp_remote_get( WPSHAPERE_DIR_URI . 'assets/font-awesome/css/font-awesome.css' );

    if(is_wp_error($file_contents))
        return;
    if ( 200 == wp_remote_retrieve_response_code( $file_contents ) ) {
            $icon_contents = $file_contents['body'];
    }

  	$icons = array();
  	if(!empty($icon_contents)) {
        preg_match_all($pattern, $icon_contents, $matches, PREG_SET_ORDER);
        foreach($matches as $match){
                $icons[$match[1]] = $match[2];
        }
    }
    return $icons;
  }

    function wps_get_icon_class($iconData) {
        if(!empty($iconData)) {
            $icon_class = explode('|', $iconData);
            if(isset($icon_class[0]) && isset($icon_class[1])) {
                return $icon_class[0] . ' ' . $icon_class[1];
            }
        }
    }

  	public function wpsiconStyles(){
  		$wps_sorteddmenu = $this->get_wps_option_data('wpshapere_menuorder');
      $faicons = new WPSFAICONS();
      $faicons_data = $faicons->wps_fa_icons();

  		if(!empty($wps_sorteddmenu)){

        $icon_styles = "";
    		foreach($wps_sorteddmenu as $menu_data_key => $menu_data_val){
    			$sel_icon = (isset($menu_data_val[2])) ? $menu_data_val[2] : "";
    			$icon_data = explode("|", $sel_icon);
    			if( strpos($menu_data_key, '_sbchild') === false && $icon_data[0] == 'fa') {
    				if(isset($icon_data[1]) && !empty($icon_data[1])){
    				$icon_styles .= '#adminmenu li.wps_icon_' . $menu_data_key . ' a.wps_icon_' . $menu_data_key . ' div.wp-menu-image:before {';
    				$icon_styles .= 'font-family: "FontAwesome" !important; content: "' . $faicons_data[$icon_data[1]] . '" !important';
    				$icon_styles .= '}';
    				}
    			}
    		}

        return $icon_styles;

  		}

  	}

    public function wps_compress_css($css) {
      $cssContents = "";
      // Remove comments
      $cssContents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
      // Remove space after colons
      $cssContents = str_replace(': ', ':', $cssContents);
      // Remove whitespace
      $cssContents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $cssContents);
      return $cssContents;
    }

    function get_privilege_users() {
      //return WPS privilege users
      $wps_privilege_users = (!empty($this->aof_options['privilege_users'])) ? $this->aof_options['privilege_users'] : array();
      return $wps_privilege_users;
    }

  function manage_dash_widgets() {
      if(!isset($this->aof_options['remove_dash_widgets']))
          return;

      global $wp_meta_boxes;
      $dash_widgets_removal_data = $this->aof_options['remove_dash_widgets'];
      $remove_dash_widgets = (is_serialized($dash_widgets_removal_data)) ? unserialize($dash_widgets_removal_data) : $dash_widgets_removal_data;

      //Removing unwanted widgets
      if(!empty($remove_dash_widgets) && is_array($remove_dash_widgets)) {
          foreach ($remove_dash_widgets as $widget_to_rm) {
              if($widget_to_rm == "welcome_panel") {
                  remove_action('welcome_panel', 'wp_welcome_panel');
              }
              else {
                  $widget_data = explode("|", $widget_to_rm);
                  $widget_id = $widget_data[0];
                  $widget_pos = $widget_data[1];
                  unset($wp_meta_boxes['dashboard'][$widget_pos]['core'][$widget_id]);
              }
          }
      }
  }

  function widget_functions() {

    $current_user_id = get_current_user_id();
    $wps_menu_access = $this->aof_options['show_all_menu_to_admin'];
    $wps_privilege_users = $this->get_privilege_users();

    if(is_super_admin($current_user_id) && isset($wps_menu_access) && $wps_menu_access == 2 && !empty($wps_privilege_users) && in_array($current_user_id, $wps_privilege_users))
      return;

    global $wp_meta_boxes;
    $dash_widgets_removal_data = (isset($this->aof_options['remove_dash_widgets'])) ? $this->aof_options['remove_dash_widgets'] : "";
    $remove_dash_widgets = (is_serialized($dash_widgets_removal_data)) ? unserialize($dash_widgets_removal_data) : $dash_widgets_removal_data;

    //Removing unwanted widgets
    if(!empty($remove_dash_widgets) && is_array($remove_dash_widgets)) {
      if(is_super_admin($current_user_id)) {
        if(isset($wps_menu_access) && $wps_menu_access == 2 && !empty($wps_privilege_users) && !in_array($current_user_id, $wps_privilege_users)) {
          foreach ($remove_dash_widgets as $widget_to_rm) {
              if($widget_to_rm == "welcome_panel") {
                  remove_action('welcome_panel', 'wp_welcome_panel');
              }
              else {
                  $widget_data = explode("|", $widget_to_rm);
                  $widget_id = $widget_data[0];
                  $widget_pos = $widget_data[1];
                  unset($wp_meta_boxes['dashboard'][$widget_pos]['core'][$widget_id]);
              }
          }
        }
      }
      else {
        foreach ($remove_dash_widgets as $widget_to_rm) {
            if($widget_to_rm == "welcome_panel") {
                remove_action('welcome_panel', 'wp_welcome_panel');
            }
            else {
                $widget_data = explode("|", $widget_to_rm);
                $widget_id = $widget_data[0];
                $widget_pos = $widget_data[1];
                unset($wp_meta_boxes['dashboard'][$widget_pos]['core'][$widget_id]);
            }
        }
      }

    }

  	//Creating new widgets
  	$wps_widget_handle = array();
  	for($i = 1; $i <= 4; $i++) {
  		$wps_widget_handle['type'] = $this->aof_options[ 'wps_widget_' . $i .'_type' ];
  		$wps_widget_handle['pos'] = $this->aof_options[ 'wps_widget_' . $i .'_position' ];
  		$wps_widget_handle['title'] = $this->aof_options[ 'wps_widget_' . $i .'_title' ];

      $wps_widget_content = wpautop($this->aof_options[ 'wps_widget_' . $i .'_content'], true);

  		$wps_widget_handle['content'] = do_shortcode($wps_widget_content);
  		$wps_widget_handle['rss'] = $this->aof_options[ 'wps_widget_' . $i .'_rss' ];
  		if(!empty($wps_widget_handle['title']) || !empty($wps_widget_handle['content']) || !empty($wps_widget_handle['rss'])) {
  			add_meta_box('wps_dashwidget_' . $i, $wps_widget_handle['title'], array($this, 'wps_display_widget_content'), 'dashboard', $wps_widget_handle['pos'], 'high', $wps_widget_handle);
      }
  	}
}

public function wps_display_widget_content($post, $wps_widget_handle)
{
	if($wps_widget_handle['args']['type'] == 1) {
		echo '<div class="rss-widget">';
		 wp_widget_rss_output(array(
			  'url' => $wps_widget_handle['args']['rss'],
			  'items' => 5,
			  'show_summary' => 1,
			  'show_author' => 1,
			  'show_date' => 1
		 ));
		 echo "</div>";
	}
	else {
		echo $wps_widget_handle['args']['content'];
	}
}

function wps_video_frame_css()
{
  for($i = 1; $i <= 4; $i++) {
    if(isset($this->aof_options['wps_widget_' . $i . '_type']) && $this->aof_options['wps_widget_' . $i . '_type'] == 3) {
      echo '<style>#wps_dashwidget_' . $i . ' .inside{position:relative;padding-bottom:56.25%;padding-top:25px;height:0;margin-top:0}#wps_dashwidget_' . $i . ' .inside object,#wps_dashwidget_' . $i . ' .inside embed,#wps_dashwidget_' . $i . ' .inside iframe{position: absolute;top:0;left:0;width:100%;height:100%;}</style>';
    }
  }
}

	public function frontendActions()
	{
	    //remove admin bar
	    if($this->aof_options['hide_admin_bar'] == 1) {
        add_filter( 'show_admin_bar', '__return_false' );
        echo '<style type="text/css">html { margin-top: 0 !important; }</style>';
	    }
	    else {
        echo '<link rel="stylesheet" href="'.WPSHAPERE_DIR_URI.'assets/styles/style.css">';
?>
		<style>
		#wpadminbar, #wpadminbar .menupop .ab-sub-wrapper { background: <?php echo $this->aof_options['admin_bar_color']; ?>;}
#wpadminbar a.ab-item, #wpadminbar>#wp-toolbar span.ab-label, #wpadminbar>#wp-toolbar span.noticon { color: <?php echo $this->aof_options['admin_bar_menu_color']; ?> }
#wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar-nojs .ab-top-menu>li.menupop:hover>.ab-item, #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover, #wpadminbar li:hover .ab-item:after, #wpadminbar>#wp-toolbar a:focus span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar>#wp-toolbar li:hover span.ab-label { color: <?php echo $this->aof_options['admin_bar_menu_hover_color']; ?> }

.quicklinks li.wpshapere_site_title { width: 200px !important; }
.quicklinks li.wpshapere_site_title a{ outline:none; border:none;
<?php

  $admin_logo_url = (is_numeric($this->aof_options['admin_logo'])) ? $this->get_wps_image_url($this->aof_options['admin_logo']) : $this->aof_options['admin_logo'];

if(!empty($admin_logo_url)){ ?>
background-image:url(<?php echo $admin_logo_url;  ?>) !important; background-repeat: no-repeat !important; background-position: center center !important; background-size: 70% auto !important; text-indent:-9999px !important; width: auto !important;
<?php } ?>
 }

#wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar-nojs .ab-top-menu>li.menupop:hover>.ab-item, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item, #wpadminbar .ab-top-menu>li.hover>.ab-item { background: none }
#wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a { color: <?php echo $this->aof_options['admin_bar_menu_color']; ?>; font-size:13px !important }
#wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img {	width: 20px; height: 20px; border-radius: 100px; -moz-border-radius: 100px; -webkit-border-radius: 100px; 	border: none; }
		</style>
		<?php
	    }
	}

  public function hideupdateNotices() {
          echo '<style>.update-nag, .updated, .notice { display: none; }</style>';
  }

  }

}

$wpshapere = new WPSHAPERE();
