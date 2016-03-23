<?php
/*
 * 27 May 2013: research needed as to how the version number is returned on ARGH! ( see _get_plugin_version_from_response() )
 *
 * TODO: We will get this straightened out when we have a premium version. We will use the autoupdate to upgrade user to a premium version.
 *
 * class that takes care of checking and updating the plugin version.
 * it is hooked into wordpress flow on the plugin's name ( farreaches-wp or socialmarketing).
 * code adapted from
 *
 * wp.tutsplus.com/tutorials/plugins/a-guide-to-the-wordpress-http-api-automatic-plugin-updates/
 * the filters intercepted here are used in wordpress/wp-admin/includes/plugin-install, line 320
 * and line 187 uses the transient update_plugins that we previously modified through the hook
 *

 	Plugin version:
 		needs to get a string with version number (version_compare'able will do i think)
 	Plugin Info:
		needs to get a json object similar to this:
		{
		    "version": "5.0", //new plugin version (version_compare'able string with the current version string)
		    "requires": "3.0", //Minimum SUPPORTED Wordpress version for the new Farreaches Plugin version
		    "tested": "3.4.2", //format: version_compare'able string with wordpress version of the highest wp version tested
		    "last_updated": "2012-01-12", //last time the plugin was updated. The format is anything that strtotime can understand.
		    							  // http://php.net/manual/en/function.strtotime.php
		    "homepage" : "http://farreach.es" //format:
		    "sections": {
		    // Displayable sections in the 'view version x.x.x details' in admin => dashboard => updates.
		    // Each subsection is a tab when wordpress displays the update details.
		    // The key must have no spaces. Wordpress uses key as the tab title.
		    // '_' are converted to spaces and the next letter is capitalized when the tab title is generated.
		        "description": "Publish content to several social networks from a single place",
		        "changelog": "This new version adds ...."
		    },
		    "download_link": "http://plugindownload/link.html" //format: uri with the zipped file
		}

		This is for the 'view version x.x.x details' in admin => dashboard => updates.
		Afterwards must be transformed into an StdClass with the same object

    Plugin Package
        Zip Package (this is a zip package to autoinstall the plugin).
        This is with all certainty the plugin folder simply zipped. server deployment
        should anticipate this and prepare a zipped package as a resource with some url
        on which it is accessible.
        The calls are made to the auto update urls which right now are hardcoded but should

 *
 */
class FarReaches_Autoupdate extends FarReaches_Base {

    private $current_plugin_version;
    // Note: about slugs:
    // we need two slugs because wordpress uses different slugs for the plugin version number
    // and other for the plugin information.
    /*
         * The slug must be a unique identifier for the plugin in WordPress.
         * By convention, the slug is the plugin file name minus folder, minus .php:
         * .../farreaches-wp.php => farreaches-wp
         * Wordpress uses an array with all the plugins indexed by this slug for the updated version
         *  information. it is also used for modifying the information for the plugin in case somebody
         *  wants to see the version details
         *
         */
    private $slug;
    /*
      * This slug is the plugin 'folder/name' combination and it is used to index the update information by
      * wordpress. It must be this folder/name combination, it is used by the plugins_api (and we can see
      * it in check_info
      */
    private $plugin_slug;

    /**
     *
     * @param FarReaches_Util $farReaches_Util
     * @param FarReaches_Communication $farReaches_Communication
     */
    function __construct(
        FarReaches_Util $farReaches_Util,
        FarReaches_Communication $farReaches_Communication,
        $current_plugin_version
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
        $this->current_plugin_version = $current_plugin_version;
        $this->plugin_slug = $this->get_plugin_file();
        list($t1, $t2) = explode('/', $this->plugin_slug);
        $this->slug = str_replace('.php', '', $t2);

        // this two filters will be called in different times. check_update will be called at first and only
        // in the case the version retrieved is bigger (in version_compare) than the plugin we have installed
        // the check_info will run.
        $this->add_filter('pre_set_site_transient_update_plugins', 'check_update');
        $this->add_filter('plugins_api', 'check_info');
    }

    /**
     * Return the remote version
     * @return bool|string $remote_version
     */
    private function get_remote_version() {
        //what needs to come out of this function is a string with the version, that's it.
        // we get version by getting the whole information object, and extracting version string.
        // hence, here we use the same method rest of the code uses to get the information object,
        // so that we remain consistent.
        $info = $this->get_remote_information();
        if ($info) {
            return $info->version;
        } else {
            //this is in case there was nothing retrieved by the api call for some reason
            return false;
        }
    }

    /**
     * Get the info file from the server and add other needed data -slug and link-
     * related to server/plugin
     */
    public function get_remote_information() {
        $response = $this->api_call(FarReaches_Api_Call::PLUGIN_INFO);
        if ($this->is_response_in_error($response)) {
            return false;
        }
        $json_response = $response;
        if (!empty($json_response)) {
            $information = (object)$json_response;
            $information->slug = $this->slug;
            $information->download_link = $this->_get_download_uri();
            return $information;
        } else {
            return false;
        }
    }

    /**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     * @return object $transient
     */
    public function check_update($transient) {
        if (empty($transient->last_checked)) {
            return $transient;
        }

        $remote_version = $this->get_remote_version();
        // If a newer version is available, add the update
        // version number is compared using php standardized versioning
        // http://php.net/manual/en/function.version-compare.php
        if ($remote_version && version_compare($this->current_plugin_version, $remote_version, '<')) {
            //here comes the version and update data.
            $obj = new stdClass();
            //the slug so wordpress knows to which plugin it belongs
            $obj->slug = $this->slug;
            // this is the new plugin version string that will appear on the update page
            // version number is compared as php version numbering, so for new versions make sure
            // they are have bigger php syle version number than the previous version
            $obj->version = $remote_version;
            // wp-admin/includes/update.php:206 - requires 'new_version'
            // but (other places - I forget exactly where) require 'version' as the object property.
            $obj->new_version = $remote_version;

            $obj->package = $this->_get_download_uri();
            $transient->response[$this->plugin_slug] = $obj;
        }
        return $transient;
    }

    /**
     * Add the self-hosted description to the filter
     *
     * this is the function that hooks the wp filter that feeds the whole plugin information system
     * This will either return false if communications failed or return the information for the update
     * in case communications went through and there is effectively an update available.
     * this will capture all other wp plugins so there must not be anything added when the slug is not the
     * FR wp plugin slug
     *
     * This filter hooks just before the wordpress install checks for updates in www.wordpress.com/plugins.
     * the previously mentioned check will not be performed, if this returns anything, and whatever the
     * farreaches server returns (from get_remote_information()) will be used as the plugin info,
     * and that will be displayed in an iframe by pressing 'view version info' in dashboard => updates
     *
     * Note: that this method is called based on the 'plugins_api' hook which is called for many reasons: not just plugin_information
     *
     * Filter is used here: wordpress/wp-admin/includes/plugin-install:187
     **/
    public function check_info($false, $action, $arg) {
        // this method is called based on the 'plugins_api' hook which is called for many reasons: not just plugin_information
        if ($action == 'plugin_information' && $arg->slug === $this->slug) {
            $information = $this->get_remote_information();
            if ($information instanceof stdClass) {
                return $information;
            }
        }
        return false;
    }

    /** Retrieve the uri from here to allow for stats tracking with downloads.
     *  This url should redirect to the proper zip file with the folder contents of the plugin.
     */
    private function _get_download_uri() {
        return $this->farReaches_Communication->get_full_api_uri(FarReaches_Api_Call::PLUGIN_DOWNLOAD);
    }

    /**
     * Very not clear on if new_version or version is supposed to be the result return by update checks.
     *
     *
     * @param unknown_type $json_response
     */
    private function _get_plugin_version_from_info($info) {
        if ($info === false) {
            return false;
        } else if ( property_exists($info, 'new_version')) {
            return $info->new_version;
        } else if ( property_exists($info, 'version')) {
            return $info->version;
        } else {
            return false;
        }
    }
}

