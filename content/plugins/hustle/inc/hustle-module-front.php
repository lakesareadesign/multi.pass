<?php

class Hustle_Module_Front {

	private $_hustle;

	private $_modules = array();
	private $_optin_layouts = array();
	private $_args_layouts = array();

	private $_styles;

	const AFTERCONTENT_CSS_CLASS = "hustle_module_after_content_wrap";
	const WIDGET_CSS_CLASS = "hustle_module_widget_wrap";
	const SHORTCODE_CSS_CLASS = "hustle_module_shortcode_wrap";
	const SHORTCODE_TRIGGER_CSS_CLASS = "hustle_module_shortcode_trigger";
	const SSHARE_WIDGET_CSS_CLASS = "hustle_sshare_module_widget_wrap";
	const SSHARE_SHORTCODE_CSS_CLASS = "hustle_sshare_module_shortcode_wrap";

	const SHORTCODE = "wd_hustle";

	public function __construct( Opt_In $hustle ) {

		$this->_hustle = $hustle;
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_shortcode(self::SHORTCODE, array( $this, "shortcode" ));
		// Legacy custom content support.
		add_shortcode("wd_hustle_cc", array( $this, "shortcode" ));
		// Legacy social sharing support.
		add_shortcode("wd_hustle_ss", array( $this, "shortcode" ));

		if( is_admin() ) return;

		add_action('wp_enqueue_scripts', array($this, "register_scripts"));
		// Enqueue it in the footer to overrider all the css that comes with the popup
		add_action('wp_footer', array($this, "register_styles"));

		add_action('template_redirect', array($this, "create_modules"), 0);

		add_action("wp_footer", array($this, "add_layout_templates"));

		add_filter("the_content", array($this, "show_after_page_post_content"), 20);

		// NextGEN Gallery compat
		add_filter('run_ngg_resource_manager', array($this, 'nextgen_compat'));
	}

	public function register_widget() {
		register_widget( 'Hustle_Module_Widget' );
		register_widget( 'Hustle_Module_Widget_Legacy' );
	}

	public function register_scripts() {
		$is_on_upfront_builder = class_exists('UpfrontThemeExporter') && function_exists('upfront_exporter_is_running') && upfront_exporter_is_running();

		if ( !$is_on_upfront_builder ) {
			if( is_customize_preview() || ! $this->has_modules() || isset( $_REQUEST['fl_builder'] ) ) {
				return;
			}
		}

		global $wp;

		/**
		 * Register popup requirements
		 */

		wp_register_script('hustle_front', $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/front.min.js', array('jquery', 'underscore'), '1.1',  $this->_hustle->get_const_var(  "VERSION" ), false);
		wp_register_script( 'hustle_front_fitie', $this->_hustle->get_static_var( "plugin_url" ) . 'assets/js/vendor/fitie/fitie.js', array(), $this->_hustle->get_const_var( "VERSION" ), false );

		$modules = apply_filters("hustle_front_modules", $this->_modules);
		wp_localize_script('hustle_front', 'Modules', $modules);

		$vars = apply_filters("hustle_front_vars", array(
			"ajaxurl" => admin_url("admin-ajax.php", is_ssl() ? 'https' : 'http'),
			'page_id' => get_queried_object_id(),
			'page_type' => $this->_hustle->current_page_type(),
			'current_url' => esc_url( home_url( $wp->request ) ),
			'is_admin' => (int) current_user_can('administrator'),
			'is_upfront' => class_exists( "Upfront" ) && isset( $_GET['editmode'] ) && "true" === $_GET['editmode'] ,
			'is_caldera_active' => class_exists( "Caldera_Forms" ),
			'adblock_detector_js' => $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/ads.js',
			'l10n' => array(
				"never_see_again" => __("Never see this message again", Opt_In::TEXT_DOMAIN),
				'success' => __("Congratulations! You have been subscribed to {name}", Opt_In::TEXT_DOMAIN),
				'submit_failure' => __("Something went wrong, please try again.", Opt_In::TEXT_DOMAIN),
				'test_cant_submit' => __("Form can't be submitted in test mode.", Opt_In::TEXT_DOMAIN),
			)
		) );
		wp_localize_script('hustle_front', 'inc_opt', $vars );
		wp_localize_script('hustle_front', 'hustle_vars', $vars );

		do_action("hustle_register_scripts");
		wp_enqueue_script('hustle_front');
		wp_enqueue_script('hustle_front_fitie');
		add_filter( 'script_loader_tag', array($this, "handle_specific_script"), 10, 2 );
		add_filter( 'style_loader_tag', array($this, "handle_specific_style"), 10, 2 );
	}

	/**
	 * Handling specific scripts for each scenario
	 *
	 */
	public function handle_specific_script( $tag, $handle ) {
		if ( 'hustle_front_fitie' === $handle ) {
			$tag = "<!--[if IE]>". $tag ."<![endif]-->";
		}
		return $tag;
	}

	/**
	 * Handling specific style for each scenario
	 *
	 */
	public function handle_specific_style( $tag, $handle ) {
		if ( 'hustle_front_ie' === $handle ) {
			$tag = "<!--[if IE]>". $tag ."<![endif]-->";
		}
		return $tag;
	}

	public function register_styles() {
		$is_on_upfront_builder = class_exists('UpfrontThemeExporter') && function_exists('upfront_exporter_is_running') && upfront_exporter_is_running();

		if ( !$is_on_upfront_builder ) {
			if ( ! $this->has_modules() || isset( $_REQUEST['fl_builder'] ) ) {
				return;
			}
		}

		wp_register_style( 'hstl-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i', $this->_hustle->get_const_var(  "VERSION" ) );
		wp_register_style( 'hstl-opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i', $this->_hustle->get_const_var(  "VERSION" ) );
		wp_register_style( 'hustle_front', $this->_hustle->get_static_var(  "plugin_url" )  . 'assets/css/front.min.css', array( 'dashicons' ), $this->_hustle->get_const_var(  "VERSION" ) );
		wp_register_style( 'hustle_front_ie', $this->_hustle->get_static_var(  "plugin_url" )  . 'assets/css/ie-front.min.css', array( 'dashicons' ), $this->_hustle->get_const_var(  "VERSION" ) );
		wp_register_style( 'hstl-source-code-pro', 'https://fonts.googleapis.com/css?family=Source+Code+Pro', $this->_hustle->get_const_var(  "VERSION" ) );

		$load_google_fonts = apply_filters( 'hustle_load_google_fonts', true );
		if ( $load_google_fonts ) {
			wp_enqueue_style( 'hstl-roboto' );
			wp_enqueue_style( 'hstl-opensans' );
			wp_enqueue_style( 'hstl-source-code-pro' );
		}
		wp_enqueue_style( 'hustle_front' );
		wp_enqueue_style( 'hustle_front_ie' );

		$this->_inject_styles();
	}

	/**
	 * Enqueues Select2 script if required
	*/
	public function enqueue_select2_script(){
		wp_enqueue_script('hustle_front_select2', $this->_hustle->get_static_var( "plugin_url" ) . 'lib/wpmu-lib/js/select2.3.min.js', array(), $this->_hustle->get_const_var( "VERSION" ), true );
		wp_enqueue_style('hustle_front_select2_style', $this->_hustle->get_static_var( "plugin_url" ) . 'lib/wpmu-lib/css/select2.3.min.css', array(), $this->_hustle->get_const_var( "VERSION" ), false );
	}

	/**
	 * Enqueues modules to be displayed on Frontend
	*/
	public function create_modules() {
		global $post;

		$modules = Hustle_Module_Collection::instance()->get_all(true);
		$modules = apply_filters( 'hustle_sort_modules', $modules );
		$module_front_data = array();
		$has_dropdown = 0;
		$enqueue_adblock_detector = false;
		foreach( $modules as $module ) {
			if ( 'social_sharing' === $module->module_type ) {
				$data = array(
					'content' => $module->get_sshare_content()->to_array(),
					'design' => $module->get_sshare_design()->to_array(),
					'settings' => $module->get_sshare_display_settings()->to_array(),
					'tracking_types' => $module->get_tracking_types(),
					'test_types' => $module->get_test_types()
				);
				if( $module->is_click_counter_type_enabled( 'native' ) && is_object( $post ) ) {
					$data = $module->set_network_shares( $data, $post->ID );
				}
			} else {
				$data = array(
					'content' => $module->get_content()->to_array(),
					'design' => $module->get_design()->to_array(),
					'settings' => $module->get_display_settings()->to_array(),
					'tracking_types' => $module->get_tracking_types(),
					'test_types' => $module->get_test_types()
				);
			}
			$data = wp_parse_args( $module->get_data(), $data );

			// backwards compatibility for new counter types from 3.0.3
			if ( isset( $data['content']['click_counter'] ) ) {
				if ( '1' === $data['content']['click_counter'] ) {
					$data['content']['click_counter'] = 'click';
				} elseif ( '0' === $data['content']['click_counter'] ) {
					$data['content']['click_counter'] = 'none';
				}
			}
			if ( isset( $data['content']['main_content'] ) ) {
				$data['content']['main_content'] = do_shortcode( $data['content']['main_content'] );
			}

			// handle provider args
			if ( isset( $data['content']['active_email_service'] ) ) {
				$provider = Opt_In::get_provider_by_id( $data['content']['active_email_service'] );
				$provider = Opt_In::provider_instance( $provider );
				if( method_exists( $provider, 'get_args' ) ) {
					$data['content']['args'] = $provider->get_args($data['content']);
				}
			}

			// remove provider credentials
			if ( isset( $data['content']['email_services'] ) ) {
				unset($data['content']['email_services']);
			}

			$is_active = (bool) $module->active;
			$is_allowed = $module->is_allowed_to_display( $data['settings'], $module->module_type );
			$is_content_module = (
					// Is embed or social sharing (migrating can cause popups or slide ins to have widget/shortcodes settings enabled).
					'embedded' === $module->module_type || 'social_sharing' === $module->module_type
				)
				&& (
					// Is widget?
					( isset($data['settings']['widget_enabled']) && 'true' === $data['settings']['widget_enabled'] )
					// Is shortcode?
					|| ( isset($data['settings']['shortcode_enabled']) && 'true' === $data['settings']['shortcode_enabled'] )
				);
			if ( $is_active && ( $is_allowed || $is_content_module ) ){

				if ( $is_content_module && !$is_allowed ) {
					//just disable Floating Social or After Content and show everything else
					'embedded' === $module->module_type ?  $data['settings']['after_content_enabled'] = 'false' : $data['settings']['floating_social_enabled'] = 'false';
				}
				$module_front_data[] = $data;
				$this->_styles .= $module->get_decorated()->get_module_styles( $module->module_type );
				//check if any active module has a dropdown group list
				if ( isset( $data['content']['args']['group']['type'] ) && 'dropdown' === $data['content']['args']['group']['type'] ) {
					$has_dropdown++;
				}
			}
			if (
				// If Trigger exists.
				!empty($data['settings']['triggers']['trigger'])
				// If trigger is adblock.
				&& 'adblock' === $data['settings']['triggers']['trigger']
				// If on_adblock toggle is enabled.
				&& !empty($data['settings']['triggers']['on_adblock'])
			) {
				// Bring in the fake ad script.
				$enqueue_adblock_detector = true;
			}
		}
		if ( $has_dropdown > 0 ) {
			add_action ('wp_enqueue_scripts',  array($this, 'enqueue_select2_script') );
		}
		$this->_modules = $module_front_data;

		// Look for adblocker.
		if( $enqueue_adblock_detector ) {
			wp_enqueue_script('hustle_front_ads', $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/ads.js', array(), '1.0', $this->_hustle->get_const_var(  "VERSION" ), false);
		}
	}

	/**
	 * Check if current page has renderable opt-ins.
	 **/
	public function has_modules() {
		$has_modules = ! empty( $this->_modules );

		return apply_filters( 'hustle_front_handler', $has_modules );
	}

	/**
	 * By-pass NextGEN Gallery resource manager
	 *
	 * @return false
	 */
	public function nextgen_compat() {
		return false;
	}

	private function _get_unique_id() {
		return uniqid("IncOpt");
	}

	private function _inject_styles(){
		?>
		<style type="text/css" id="hustle-module-styles"><?php echo $this->_styles; ?></style>
		<?php
	}

	/**
	 * Returns unique registered layout numbers
	 *
	 * @since 1.0.1
	 * @return array
	 */
	private function _get_registered_layouts(){
		return array_unique( $this->_optin_layouts );
	}


	/**
	 * Returns unique registered arg layout numbers
	 *
	 * @since 1.0.1
	 * @return array
	 */
	// private function _get_registered_arg_layouts(){
		// return array_unique( $this->_args_layouts );
	// }

	/**
	 * Adds needed layouts
	 *
	 * @since 1.0
	 */
	public function add_layout_templates(){
		if ( ! $this->has_modules() ) {
			return;
		}

		$this->_hustle->render( "general/modals/optin-true", array() );
		$this->_hustle->render( "general/modals/optin-false", array() );
		$this->_hustle->render( "general/sshare", array() );

		foreach( $this->_hustle->get_providers_with_args() as $provider_name ){
			$this->_hustle->render("general/providers/" . $provider_name );
		}
	}

	public function shortcode( $atts, $content ){
		$atts = shortcode_atts( array(
			'id' => '',
			'type' => 'embedded'
		), $atts, self::SHORTCODE );
		// Enforce embedded/social_sharing type.
		$enforce_type = true;

		if( empty( $atts['id'] ) ) return "";

		// If shortcode type is not embed or sshare.
		if ( 'embedded' !== $atts['type'] && 'social_sharing' !== $atts['type'] ) {
			// Do not enforce embedded/social_sharing type.
			$enforce_type = false;
		}

		// Get the module data.
		$module = Hustle_Module_Model::instance()->get_by_shortcode( $atts['id'], $enforce_type );
		// Type from module data.
		$type = $module->module_type;

		if ( 'social_sharing' === $module->module_type ) {
			$module = Hustle_SShare_Model::instance()->get( $module->id );
			$settings = $module->get_sshare_display_settings();
			$shortcode_class = self::SSHARE_SHORTCODE_CSS_CLASS;
		} else {
			$settings = $module->get_display_settings();
			$shortcode_class = self::SHORTCODE_CSS_CLASS;
		}
		$shortcode_enabled = ( $settings->shortcode_enabled || in_array( $settings->shortcode_enabled, array( 'true', true ), true ) );

		if( !$module || !$module->active ) return "";

		/**
		 * Maybe add trigger link (For popups and slideins).
		 */
		if( !empty( $content ) && ( "popup" === $type || "slidein" === $type ) )
			return sprintf("<a href='#' class='%s' data-id='%s' data-type='%s'>%s</a>", self::SHORTCODE_TRIGGER_CSS_CLASS . " hustle_module_" . $module->id, $module->id, esc_attr( $type ),  $content );


		return sprintf("<div class='%s' data-type='shortcode' data-id='%s'></div>", $shortcode_class . " hustle_module_" . esc_attr( $module->id ) . " module_id_" . esc_attr( $module->id ), esc_attr( $module->id ));
	}

	/**
	 * Only for After Content display on Embedded module
	 * @param $content
	 * @return string
	 */
	public function show_after_page_post_content( $content ) {


		/**
		 * Return the content immediately if there are no renderable embeddeds.
		 **/
		if ( empty( $this->_modules ) || isset( $_REQUEST['fl_builder'] ) || is_home() || is_archive() ) {
			return $content;
		}

		foreach( $this->_modules as $module ) {
			if ( 'embedded' === $module['module_type'] && isset( $module['settings'] ) && isset( $module['settings']['after_content_enabled'] ) ) {
				if ( 'true' === $module['settings']['after_content_enabled'] ) {
					$content .= sprintf( '<div class="%s" data-id="%s" data-type="after_content" ></div>', self::AFTERCONTENT_CSS_CLASS . ' module_id_' . $module['module_id'], $module['module_id'] );
				}
			}
		}

		remove_filter("the_content", array($this, "show_after_page_post_content"));

		return $content;
	}
}