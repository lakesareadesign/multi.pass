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
                        //add_action('plugins_loaded', array($this, 'alter_load_textdomain'));
                        $this->aof_options = $this->alter_get_option_data(ALTER_OPTIONS_SLUG);
                        add_action('admin_menu', array($this, 'wps_sub_menus'));
	    add_action('admin_init', array($this, 'initialize_defaults'), 19);

	    add_filter('admin_title', array($this, 'custom_admin_title'), 999, 2);	
	    add_action( 'init', array($this, 'initFunctionss') );
	    
	    add_action( 'admin_bar_menu', array($this, 'alter_add_title_menu'), 1 );
	    add_action( 'admin_bar_menu', array($this, 'alter_add_nav_menus'), 99);
            
                        add_action( 'admin_bar_menu', array($this, 'alter_save_adminbar_nodes'), 999 );
                        add_action('wp_before_admin_bar_render', array($this, 'alter_remove_admin_bar_items'), 999);

                        if($this->aof_options['disable_styles_login'] != 1) {
                            if ( ! has_action( 'login_enqueue_scripts', array($this, 'alter_login_assets') ) )
                                add_action('login_enqueue_scripts', array($this, 'alter_login_assets'), 10);
                            add_action('login_head', array($this, 'alterLogincss'));
                        }
                        
	    add_action( 'admin_enqueue_scripts', array($this, 'alter_main_assets'), 99999 );
                        add_action('admin_head', array($this, 'alterMaincss'), 999);
	    
	    add_filter('login_headerurl', array($this, 'alter_login_url'));
	    add_filter('login_headertitle', array($this, 'alter_login_title'));
	    add_action('admin_head', array($this, 'generalFns'));    
	    
	    add_action( 'admin_bar_menu', array($this, 'update_avatar_size'), 99 );
	    add_action('plugins_loaded',array($this, 'save_change_texts'));
                        add_action( 'aof_save_data', array($this, 'save_additional_data'));
	    add_action('login_footer', array($this, 'login_footer_content'));
		
	    add_action('wp_head', array($this, 'frontendActions'), 99999);
                        add_action( 'activated_plugin', array($this, 'alter_activated' ));
                        add_action( 'aof_before_heading', array($this, 'alter_welcome_msg'));
                        
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
                           echo '<h1 style="line-height: 1.2em;font-size: 2.8em;font-weight: 400;">' . __('Welcome to Alter ', 'alter') . ALTER_VERSION . '</h1>';
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

                        if($this->aof_options['email_settings'] != 3) {
                                add_filter( 'wp_mail_from', array($this, 'custom_email_addr') );
                                add_filter( 'wp_mail_from_name', array($this, 'custom_email_name') );
                        }

                        if($this->aof_options['hide_profile_color_picker'] == 1) {
                                remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
                        }		
                        register_nav_menus(array(			
                                'alter_add_adminbar_menu' => 'Adminbar Menu'
                        ));
                        add_filter('gettext', array($this, 'change_admin_texts'), 99999, 3);
	}

	public function alter_login_assets()
	{
                        echo "<link rel='stylesheet' id='alter-login-css'  href='" . admin_url('admin-ajax.php') . "?action=alterLogincss' type='text/css' media='all' />";
                        wp_enqueue_script("jquery");
                        wp_enqueue_script( 'loginjs-js', ALTER_DIR_URI . 'assets/js/loginjs.js', array( 'jquery' ), '', true );
	}
        
	public function alter_main_assets($nowpage) 
	{ 
                        wp_enqueue_script('jquery');
	    wp_enqueue_style('alterAdmin-css', ALTER_DIR_URI . 'assets/css/alter.styles.css', '', ALTER_VERSION);
	    if($nowpage == 'toplevel_page_alter-options') {	            
                            wp_enqueue_script( 'alter-livepreview', ALTER_DIR_URI . 'assets/js/live-preview.js', array( 'jquery' ), '', true );
	   }
                            wp_enqueue_script( 'alter-repeater', ALTER_DIR_URI . 'assets/js/jquery.repeater.js', array( 'jquery' ), '', true );
                            wp_enqueue_script( 'alter-scriptjs', ALTER_DIR_URI . 'assets/js/script.js', array( 'jquery' ), '', true );

	}

	public function alterLogincss()
	{
                        include_once( ALTER_PATH . '/includes/css/alter.login.css.php' );
	}
        
	public function alterMaincss() 
	{
	  include_once( ALTER_PATH . '/includes/css/alter.admin.css.php' );
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
	    add_filter( 'admin_footer_text', array($this, 'alter_custom_footer_content') );
	    //remove wp version
	    add_filter( 'update_footer', array($this, 'alter_remove_wp_version'), 99);

	    //prevent access to wpshapere menu for non-superadmin
	    if( (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') ){
		if($screen->id == "toplevel_page_wpshapere-options" || $screen->id == "wpshapere-options_page_wps_admin_menuorder" || $screen->id == "wpshapere-options_page_wps_impexp_settings") {
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
                        if(!is_admin())
                            return $translated_text;
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
                        add_submenu_page( 'alter-options', __('Change Text', 'alter'), __('Change Text', 'alter'), 'manage_options', 'alter_change_text', array($this, 'alterChangetext') );
		
	    //Remove wpshapere menu
	    if( defined('HIDE_ALTER_OPTION_LINK') || (!current_user_can('manage_network')) && defined('NETWORK_ADMIN_CONTROL') )
		    remove_menu_page('wpshapere-options');
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
                                        <input type="submit" name="submit" value="Save Now" class="save button button-primary button-hero" />
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
                                        if(!empty($repeaters['find']) && !empty($repeaters['replace'])) {
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

	public function login_footer_content()
	{
	        $login_footer_content = $this->aof_options['login_footer_content'];
                            echo '<div class="login_footer_content">';
                            echo '<div class="footer_content">';
                            if(!empty($login_footer_content)) {
                                echo do_shortcode ($this->aof_options['login_footer_content']);
                            }
                            echo '</div>';
                            echo '</div>';
	}

	public function alter_custom_footer_content() 
	{
                        echo $this->aof_options['admin_footer_txt'];
	}

	public function alter_remove_wp_version()
	{
		return '';
	}

	//admin bar customization
	public function alter_remove_admin_bar_items() 
	{
                        global $wp_admin_bar;
                        if(isset($this->aof_options['remove_adminbar_items']) && !empty($this->aof_options['remove_adminbar_items'])){
                                foreach ($this->aof_options['remove_adminbar_items'] as $hide_bar_menu) {
                                        $wp_admin_bar->remove_menu($hide_bar_menu);
                                }
                        }
	}

	public function alter_add_title_menu($wp_admin_bar) {
                        $admin_logo = $this->aof_options['admin_logo'];
                        if(!empty($admin_logo)) {
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
                            if( !$node->parent || 'top-secondary' == $node->parent )
                            {
                                $adminbar_nodes[$node->id] = $node->id;
                            }           
                        }
                        update_option(ALTER_ADMINBAR_LISTS_SLUG, $adminbar_nodes);
                    }
	
	public function frontendActions()
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
$admin_logo = $this->aof_options['admin_logo'];
$admin_logo_url = (is_numeric($admin_logo)) ? $this->alter_get_image_url($admin_logo) : $admin_logo;
if(!empty($admin_logo_url)){ ?>
.quicklinks li.alter_admin_title a, .quicklinks li.alter_admin_title a:hover, .quicklinks li.alter_admin_title a:focus {
    background:url(<?php echo $admin_logo_url;  ?>) left 0px no-repeat !important; text-indent:-9999px !important; width: auto; background-size: contain !important;
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
