<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/*
 * Plugin Name: NextGEN Pro by Photocrati
 * Description: The complete "Pro" add-on for NextGEN Gallery. Enjoy ecommerce, beautiful new gallery displays, and a fullscreen, responsive Pro Lightbox with social sharing and commenting.
 * Version: 2.3.42
 * Plugin URI: http://www.nextgen-gallery.com
 * Author: Photocrati Media
 * Author URI: http://www.photocrati.com
 * License: GPLv2
 */

// in case bcmath isn't enabled we provide these wrappers
if (!function_exists('bcadd')) { function bcadd($one, $two, $scale) { return $one + $two; }}
if (!function_exists('bcmul')) { function bcmul($one, $two, $scale) { return $one * $two; }}
if (!function_exists('bcdiv')) { function bcdiv($one, $two, $scale) { return $one / $two; }}
if (!function_exists('bcsub')) { function bcsub($one, $two, $scale) { return $one - $two; }}
if (!function_exists('bcmod')) { function bcmod($one, $two)         { return $one % $two; }}

class NextGEN_Gallery_Pro
{
	static $minimum_ngg_version = '2.0.63';
	static $product_loaded = FALSE;

    // Initialize the plugin
    function __construct()
    {
	    // We only load the plugin if we're outside of the activation request, loaded in an iframe
	    // by WordPress. Reason being, if WP_DEBUG is enabled, and another Pope-based plugin (such as
	    // the photocrati theme or NextGEN Pro/Plus), then PHP will output strict warnings
	    if ($this->is_not_activating()) {
		    define('NGG_PRO_PLUGIN_BASENAME', plugin_basename(__FILE__));
		    define('NGG_PRO_MODULE_URL', plugins_url(path_join(basename(dirname(__FILE__)), 'modules')));
		    // NOTE: for legacy reasons we keep a definition of the old constant name as well, this might otherwise break when incorrect autoupdate modules are used
		    define('NEXTGEN_GALLERY_PRO_MODULE_URL', NGG_PRO_MODULE_URL);
		    define('NGG_PRO_PLUGIN_VERSION', '2.3.42');

		    if (class_exists('C_Component_Registry') && did_action('load_nextgen_gallery_modules')) {
			    add_action('init', array(get_class(), 'load_product'));
		    }
		    else {
			    add_action('load_nextgen_gallery_modules', array(get_class(), 'load_product'));
		    }
	    }

	    $this->_register_hooks();
    }

    /**
     * Loads the product providing NextGEN Gallery Pro functionality
     * @param C_Component_Registry $registry
     */
    function load_product($registry = NULL)
    {
	    $retval = FALSE;

	    if (!self::$product_loaded) {
		    // version mismatch: do not load
		    if (!defined('NGG_PLUGIN_VERSION') || version_compare(NGG_PLUGIN_VERSION, self::$minimum_ngg_version) == -1)
			    return;

		    // Don't load Pro if Plus was recently activated
		    if (defined('NGG_PLUS_PLUGIN_VERSION') OR get_option('photocrati_plus_recently_activated', FALSE)) {
			    return;
		    }

		    // Get the component registry if one wasn't provided
		    if (!$registry) $registry = C_Component_Registry::get_instance();

		    // Tell the registry where it can find our products/modules
		    $dir = dirname(__FILE__);
		    $registry->add_module_path($dir, TRUE, TRUE);
		    $registry->initialize_all_modules();

		    $retval = self::$product_loaded = TRUE;
	    }
	    else {
		    $retval = self::$product_loaded;
	    }

	    return $retval;
    }

	function is_activating()
	{
		$retval =  strpos($_SERVER['REQUEST_URI'], 'plugins.php') !== FALSE && isset($_REQUEST['action']) && $_REQUEST['action'] == 'activate';
		if (!$retval && strpos($_SERVER['REQUEST_URI'], 'update.php') !== FALSE && isset($_REQUEST['action']) && $_REQUEST['action'] == 'install-plugin' && isset($_REQUEST['plugin']) && strpos($_REQUEST['plugin'], 'nextgen-gallery-pro') === 0) {
			$retval = TRUE;
		}
		if (!$retval && strpos($_SERVER['REQUEST_URI'], 'update.php') !== FALSE && isset($_REQUEST['action']) && $_REQUEST['action'] == 'activate-plugin' && isset($_REQUEST['plugin']) && strpos($_REQUEST['plugin'], 'nextgen-gallery-pro') === 0) {
			$retval = TRUE;
		}
		if (!$retval && strpos($_SERVER['REQUEST_URI'], 'plugins.php') !== FALSE && isset($_REQUEST['action']) && $_REQUEST['action'] == 'activate-selected' && isset($_REQUEST['checked']) && is_array($_REQUEST['checked']) && in_array('nextgen-gallery-pro/nggallery-pro.php', $_REQUEST['checked'])) {
			$retval = TRUE;
		}

		return $retval;
	}

	function is_not_activating()
	{
		return !$this->is_activating();
	}

    function _register_hooks()
    {
        add_action('activate_' . plugin_basename(__FILE__), array(get_class(), 'activate'));
        add_action('deactivate_' . plugin_basename(__FILE__), array(get_class(), 'deactivate'));
	    add_action('plugins_loaded', array(&$this, 'remove_ngg_third_party_compat_hook'));

        // hooks for showing available updates
        add_action('after_plugin_row_' . plugin_basename(__FILE__), array(get_class(), 'after_plugin_row'));
        add_action('admin_notices', array(&$this, 'admin_notices'));
        add_action('admin_init', array(&$this, 'deactivate_plus'));
    }

	/**
	 * Allow CSS/JS to be minified with NGG 2.1.15
	 */
	function remove_ngg_third_party_compat_hook()
	{
		global $wp_filter;
		if (class_exists('M_Third_Party_Compat') && !empty($wp_filter['ngg_non_minified_modules'][10])) {
			foreach ($wp_filter['ngg_non_minified_modules'][10] as $id => $filter) {
				if (!strpos($id, 'dont_minify_nextgen_pro_cssjs'))
					continue;
				$object = $filter['function'][0];
				if (!is_object($object) || get_class($object) != 'M_Third_Party_Compat')
					continue;
				remove_filter('ngg_non_minified_modules', array($object, 'dont_minify_nextgen_pro_cssjs'), 10);
			}
		}
	}

	function do_not_minify($modules)
	{
		$modules += P_Photocrati_NextGen_Pro::$modules;

		return $modules;
	}

    function deactivate_plus()
    {
        if (get_option('photocrati_pro_recently_activated', false) && defined('NGG_PLUS_PLUGIN_BASENAME')) {
            deactivate_plugins(NGG_PLUS_PLUGIN_BASENAME);
        }
    }

    static function activate()
    {
        // admin_notices will check for this later
        update_option('photocrati_pro_recently_activated', 'true');
    }

    static function deactivate()
    {
    	if (class_exists('C_Photocrati_Installer')) {
            C_Photocrati_Installer::uninstall('photocrati-nextgen-pro');
    	}
    }
    
    static function _get_update_admin()
    {
    	if (class_exists('C_Component_Registry') && method_exists('C_Component_Registry', 'get_instance')) {
    		$registry = C_Component_Registry::get_instance();
    		$update_admin = $registry->get_module('photocrati-auto_update-admin');
    		
    		return $update_admin;
    	}
    	
    	return null;
    }

    static function _get_update_message()
    {
			$update_admin = self::_get_update_admin();
			
			if ($update_admin != NULL && method_exists($update_admin, 'get_update_page_url')) {
				$url = $update_admin->get_update_page_url();
	  	
  			return sprintf(__('There are updates available. You can <a href="%s">Update Now</a>.', 'nextgen-gallery-pro'), $url);
  		}
  		
  		return null;
    }

    static function has_updates()
    {
  		$update_admin = self::_get_update_admin();
  		
  		if ($update_admin != NULL && method_exists($update_admin, '_get_update_list')) {
  			$list = $update_admin->_get_update_list();
  			
  			if ($list != NULL) {
  				$ngg_pro_count = 0;
  				
  				foreach ($list as $update) {
  					if (isset($update['info']['product-id']) && $update['info']['product-id'] == 'photocrati-nextgen-pro') {
  						$ngg_pro_count++;
  					}
  				}
  				
  				if ($ngg_pro_count > 0) {
  					return true;
  				}
  			}
  		}
    	
    	return false;
    }

    static function after_plugin_row()
    {
    	if (self::has_updates()) {
				$update_message = self::_get_update_message();
				
				if ($update_message != NULL) {
    			echo '<tr style=""><td colspan="5" style="padding: 6px 8px; ">' . $update_message . '</td></tr>';
    		}
    	}
    }
    
    function admin_notices()
    {
        $nextgen_found = FALSE;
        if (defined('NGG_PLUGIN_VERSION'))
            $nextgen_found = 'NGG_PLUGIN_VERSION';
        if (defined('NEXTGEN_GALLERY_PLUGIN_VERSION'))
            $nextgen_found = 'NEXTGEN_GALLERY_PLUGIN_VERSION';
        $nextgen_version = @constant($nextgen_found);

        if (FALSE == $nextgen_found)
        {
            $message = __('Please install &amp; activate <a href="http://wordpress.org/plugins/nextgen-gallery/" target="_blank">NextGEN Gallery</a> to allow NextGEN Pro to work.', 'nextgen-gallery-pro');
            echo '<div class="updated"><p>' . $message . '</p></div>';
        }
		else if (version_compare($nextgen_version, self::$minimum_ngg_version) == -1) {
			$ngg_pro_version = NGG_PRO_PLUGIN_VERSION;
			$upgrade_url 	 = admin_url('/plugin-install.php?tab=plugin-information&plugin=nextgen-gallery&section=changelog&TB_iframe=true&width=640&height=250');
			$message = sprintf(
                __("NextGEN Gallery %s is incompatible with NextGEN Pro %s. Please update <a class='thickbox' href='%s'>NextGEN Gallery</a> to version %s or higher. NextGEN Pro has been deactivated.", 'nextgen-gallery-pro'),
                $nextgen_version,
                $ngg_pro_version,
                $upgrade_url,
                self::$minimum_ngg_version
            );
			echo '<div class="updated"><p>' . $message . '</p></div>';
            deactivate_plugins(NGG_PRO_PLUGIN_BASENAME);
		}
        elseif (delete_option('photocrati_pro_recently_activated')) {
            $message = __('To activate the NextGEN Pro Lightbox please go to Gallery > Other Options > Lightbox Effects.', 'nextgen-gallery-pro');
            echo '<div class="updated"><p>' . $message . '</p></div>';

            if (!extension_loaded('bcmath'))
            {
                $message = __('Warning: your server does not have BCMath enabled. Please enable BCMath to prevent possible issues with ecommerce orders', 'nextgen-gallery-pro');
                echo '<div class="updated"><p>' . $message . '</p></div>';
            }
        }

    	if (class_exists('C_Page_Manager'))
        {
    		$pages = C_Page_Manager::get_instance();

			if (isset($_REQUEST['page']))
            {
				if (in_array($_REQUEST['page'], array_keys($pages->get_all()))
                ||  preg_match("/^nggallery-/", $_REQUEST['page'])
                ||  $_REQUEST['page'] == 'nextgen-gallery')
                {
					if (self::has_updates())
                    {
						$update_message = self::_get_update_message();
						echo '<div class="updated"><p>' . $update_message . '</p></div>';
					}
				}
			}
    	}
    }
}

new NextGEN_Gallery_Pro;
