<?php

/**
 * Main builder class.
 *
 * @since 1.0
 */
final class FLBuilder {

	/**
	 * The ID of a post that is currently being rendered.
	 *
	 * @since 1.6.4.2
	 * @var int $post_rendering
	 */
	static public $post_rendering = null;
	
	/**
	 * Stores the default directory name to look for in a theme for BB templates.
	 *
	 * @since 1.5.9-cf
	 * @var string $template_dir
	 */
	static private $template_dir = 'fl-builder/includes';

	/**
	 * Localization
	 *
	 * Load the translation file for current language. Checks the default WordPress
	 * languages folder first and then the languages folder inside the plugin.
	 *
	 * @since 1.4.4
	 * @return string|bool The translation file path or false if none is found.
	 */
	static public function load_plugin_textdomain()
	{
		//Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'fl-builder' );

		//Setup paths to current locale file
		$mofile_global = trailingslashit( WP_LANG_DIR ) . 'plugins/bb-plugin/' . $locale . '.mo';
		$mofile_local  = trailingslashit( FL_BUILDER_DIR ) . 'languages/' . $locale . '.mo';

		if ( file_exists( $mofile_global ) ) {
			//Look in global /wp-content/languages/plugins/bb-plugin/ folder
			return load_textdomain( 'fl-builder', $mofile_global );
		}
		else if ( file_exists( $mofile_local ) ) {
			//Look in local /wp-content/plugins/bb-plugin/languages/ folder
			return load_textdomain( 'fl-builder', $mofile_local );
		} 

		//Nothing found
		return false;
	}

	/**
	 * Initializes the builder interface.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init()
	{
		// Enable editing if the builder is active.
		if ( FLBuilderModel::is_builder_active() && ! defined( 'DOING_AJAX' ) ) {
			
			// Tell W3TC not to minify while the builder is active.
			define( 'DONOTMINIFY', true );
			
			// Tell Autoptimize not to minify while the builder is active.
			add_filter( 'autoptimize_filter_noptimize', '__return_true' );

			// Remove 3rd party editor buttons.
			remove_all_actions('media_buttons', 999999);
			remove_all_actions('media_buttons_context', 999999);

			// Get the post.
			require_once ABSPATH . 'wp-admin/includes/post.php';
			$post_id = FLBuilderModel::get_post_id();

			// Check to see if the post is locked.
			if(wp_check_post_lock($post_id) !== false) {
				header('Location: ' . admin_url('/post.php?post=' . $post_id . '&action=edit'));
			}
			else {
				FLBuilderModel::enable_editing();
			}
		}
	}

	/**
	 * Alias method for registering a module with the builder.
	 *
	 * @since 1.0
	 * @param string $class The module's PHP class name.
	 * @param array $form The module's settings form data.
	 * @return void
	 */
	static public function register_module($class, $form)
	{
		FLBuilderModel::register_module($class, $form);
	}

	/**
	 * Alias method for registering a settings form with the builder.
	 *
	 * @since 1.0
	 * @param string $id The form's ID.
	 * @param array $form The form data.
	 * @return void
	 */
	static public function register_settings_form($id, $form)
	{
		FLBuilderModel::register_settings_form($id, $form);
	}

	/**
	 * Send no cache headers when the builder interface is active.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function no_cache_headers()
	{
		if(isset($_GET['fl_builder'])) {
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', false);
			header('Pragma: no-cache');
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		}
	}

	/**
	 * Set the default text editor to tinymce when the builder is active.
	 *
	 * @since 1.0
	 * @param string $type The current default editor type.
	 * @return string
	 */
	static public function default_editor($type)
	{
		return FLBuilderModel::is_builder_active() ? 'tinymce' : $type;
	}

	/**
	 * Add custom CSS for the builder to the text editor.
	 *
	 * @since 1.0
	 * @param string $mce_css
	 * @return string
	 */
	static public function add_editor_css($mce_css)
	{
		if(FLBuilderModel::is_builder_active()) {

			if(!empty($mce_css)) {
				$mce_css .= ',';
			}

			$mce_css .= FL_BUILDER_URL . 'css/editor.css';
		}

		return $mce_css;
	}

	/**
	 * Add additional buttons to the text editor.
	 *
	 * @since 1.0
	 * @param array $buttons The current buttons array.
	 * @return array
	 */
	static public function editor_buttons_2($buttons)
	{
		if(FLBuilderModel::is_builder_active()) {

			array_shift($buttons);
			array_unshift($buttons, 'fontsizeselect');
			array_unshift($buttons, 'formatselect');

			if(($key = array_search('wp_help', $buttons)) !== false) {
				unset($buttons[$key]);
			}
		}

		return $buttons;
	}

	/**
	 * Custom font size options for the editor font size select.
	 *
	 * @since 1.6.3
	 * @param array $init The TinyMCE init array.
	 * @return array
	 */
	static public function editor_font_sizes( $init )
	{
		if ( FLBuilderModel::is_builder_active() ) {
			$init['fontsize_formats'] = implode( ' ', array(
				'10px',
				'12px',
				'14px',
				'16px',
				'18px',
				'20px',
				'22px',
				'24px',
				'26px',
				'28px',
				'30px',
				'32px',
				'34px',
				'36px',
				'38px',
				'40px',
				'42px',
				'44px',
				'46px',
				'48px',
			));
		}

		return $init;
	}

	/**
	 * Only allows certain text editor plugins to avoid conflicts
	 * with third party plugins.
	 *
	 * @since 1.0
	 * @param array $plugins The current editor plugins.
	 * @return array
	 */
	static public function editor_external_plugins($plugins)
	{
		if(FLBuilderModel::is_builder_active()) {

			$allowed = array(
				'anchor',
				'code',
				'insertdatetime',
				'nonbreaking',
				'print',
				'searchreplace',
				'table',
				'visualblocks',
				'visualchars',
				'emoticons',
				'advlist',
				'wptadv',
			);

			foreach($plugins as $key => $val) {
				if(!in_array($key, $allowed)) {
					unset($plugins[$key]);
				}
			}
		}

		return $plugins;
	}

	/**
	 * Register the styles and scripts for builder layouts.
	 *
	 * @since 1.7.4
	 * @return void
	 */
	static public function register_layout_styles_scripts()
	{
		$ver     = FL_BUILDER_VERSION;
		$css_url = plugins_url('/css/', FL_BUILDER_FILE);
		$js_url  = plugins_url('/js/', FL_BUILDER_FILE);

		// Register additional CSS
		wp_register_style('fl-slideshow',           $css_url . 'fl-slideshow.css', array(), $ver);
		wp_register_style('jquery-bxslider',        $css_url . 'jquery.bxslider.css', array(), $ver);
		wp_register_style('jquery-magnificpopup',   $css_url . 'jquery.magnificpopup.css', array(), $ver);
		
		// Register icon CDN CSS
		wp_register_style('font-awesome',           'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), $ver);
		wp_register_style('foundation-icons',       'https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css', array(), $ver);

		// Register additional JS
		wp_register_script('fl-slideshow',          $js_url . 'fl-slideshow.js', array('yui3'), $ver, true);
		wp_register_script('fl-gallery-grid',       $js_url . 'fl-gallery-grid.js', array('jquery'), $ver, true);
		wp_register_script('jquery-bxslider',       $js_url . 'jquery.bxslider.min.js', array('jquery-easing', 'jquery-fitvids'), $ver, true);
		wp_register_script('jquery-easing',         $js_url . 'jquery.easing.1.3.js', array('jquery'), '1.3', true);
		wp_register_script('jquery-fitvids',        $js_url . 'jquery.fitvids.js', array('jquery'), $ver, true);
		wp_register_script('jquery-imagesloaded', 	$js_url . 'jquery.imagesloaded.js', array('jquery'), $ver, true);
		wp_register_script('jquery-infinitescroll', $js_url . 'jquery.infinitescroll.js', array('jquery'), $ver, true);
		wp_register_script('jquery-magnificpopup',  $js_url . 'jquery.magnificpopup.min.js', array('jquery'), $ver, true);
		wp_register_script('jquery-mosaicflow',     $js_url . 'jquery.mosaicflow.min.js', array('jquery'), $ver, true);
		wp_register_script('jquery-waypoints',      $js_url . 'jquery.waypoints.min.js', array('jquery'), $ver, true);
		wp_register_script('jquery-wookmark',       $js_url . 'jquery.wookmark.min.js', array('jquery'), $ver, true);
		
		// YUI 3 (Needed for the slideshow)
		if(FLBuilderModel::is_ssl()) {
			wp_register_script('yui3', 'https://yui-s.yahooapis.com/3.5.1/build/yui/yui-min.js', array(), '3.5.1', false);
		}
		else {
			wp_register_script('yui3', 'http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js', array(), '3.5.1', false);
		}
	}

	/**
	 * Enqueue the styles and scripts for all builder layouts 
	 * in the main WordPress query.
	 *
	 * @since 1.7.4
	 * @return void
	 */
	static public function enqueue_all_layouts_styles_scripts()
	{
		global $wp_query;
		global $post;

		$original_post = $post;

		// Enqueue assets for posts in the main query.
		if ( isset( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $post ) {
				self::enqueue_layout_styles_scripts( $post->ID );
			}
		}

		// Enqueue assets for posts via the fl_builder_global_posts filter.
		$post_ids = FLBuilderModel::get_global_posts();

		if(count($post_ids) > 0) {

			$posts = get_posts(array(
				'post__in' 			=> $post_ids, 
				'post_type' 		=> get_post_types(),
				'posts_per_page'	=> -1
			));
			
			foreach($posts as $post) {
				self::enqueue_layout_styles_scripts($post->ID);
			}
		}

		// Reset the global post variable.
		$post = $original_post;
	}

	/**
	 * Enqueue the styles and scripts for a single layout.
	 *
	 * @since 1.0
	 * @param int $post_id The post ID for this layout.
	 * @return void
	 */
	static public function enqueue_layout_styles_scripts($post_id)
	{
		if(FLBuilderModel::is_builder_enabled()) {

			$nodes 		= FLBuilderModel::get_categorized_nodes();
			$asset_info = FLBuilderModel::get_asset_info();
			$asset_ver  = FLBuilderModel::get_asset_version();

			// Enqueue required row CSS and JS
			foreach($nodes['rows'] as $row) {
				if($row->settings->bg_type == 'slideshow') {
					wp_enqueue_script('yui3');
					wp_enqueue_script('fl-slideshow');
					wp_enqueue_style('fl-slideshow');
				}
				else if($row->settings->bg_type == 'video') {
					wp_enqueue_script('jquery-imagesloaded');
				}
			}

			// Enqueue required module CSS and JS
			foreach($nodes['modules'] as $module) {

				$module->enqueue_icon_styles();
				$module->enqueue_font_styles();
				$module->enqueue_scripts();

				foreach($module->css as $handle => $props) {
					wp_enqueue_style($handle, $props[0], $props[1], $props[2], $props[3]);
				}
				foreach($module->js as $handle => $props) {
					wp_enqueue_script($handle, $props[0], $props[1], $props[2], $props[3]);
				}
				if(!empty($module->settings->animation)) {
					wp_enqueue_script('jquery-waypoints');
				}
			}

			// Enqueue main CSS
			if(!file_exists($asset_info['css']) || (defined('WP_DEBUG') && WP_DEBUG)) {
				FLBuilder::render_css();
			}
			
			$deps 	= apply_filters( 'fl_builder_layout_style_dependencies', array() );
			$media 	= apply_filters( 'fl_builder_layout_style_media', 'all' );

			wp_enqueue_style('fl-builder-layout-' . $post_id, $asset_info['css_url'], $deps, $asset_ver, $media);

			// Enqueue Google Fonts
			FLBuilderFonts::enqueue_styles();

			// Enqueue main JS
			if(!file_exists($asset_info['js']) || (defined('WP_DEBUG') && WP_DEBUG)) {
				FLBuilder::render_js();
			}

			wp_enqueue_script('fl-builder-layout-' . $post_id, $asset_info['js_url'], array('jquery'), $asset_ver, true);
		}
	}

	/**
	 * Register and enqueue the styles and scripts for the builder UI.
	 *
	 * @since 1.7.4
	 * @return void
	 */
	static public function enqueue_ui_styles_scripts()
	{
		if(FLBuilderModel::is_builder_active()) {

			$ver     = FL_BUILDER_VERSION;
			$css_url = plugins_url('/css/', FL_BUILDER_FILE);
			$js_url  = plugins_url('/js/', FL_BUILDER_FILE);

			/* Frontend builder styles */
			wp_enqueue_style('dashicons');
			wp_enqueue_style('font-awesome');
			wp_enqueue_style('foundation-icons');
			wp_enqueue_style('jquery-nanoscroller',     $css_url . 'jquery.nanoscroller.css', array(), $ver);
			wp_enqueue_style('jquery-autosuggest',      $css_url . 'jquery.autoSuggest.min.css', array(), $ver);
			wp_enqueue_style('jquery-tiptip',           $css_url . 'jquery.tiptip.css', array(), $ver);
			wp_enqueue_style('bootstrap-tour',          $css_url . 'bootstrap-tour-standalone.min.css', array(), $ver);
			
			// Enqueue individual builder styles if WP_DEBUG is on.
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				wp_enqueue_style('fl-color-picker',         $css_url . 'fl-color-picker.css', array(), $ver);
				wp_enqueue_style('fl-lightbox',             $css_url . 'fl-lightbox.css', array(), $ver);
				wp_enqueue_style('fl-icon-selector',        $css_url . 'fl-icon-selector.css', array(), $ver);
				wp_enqueue_style('fl-builder',              $css_url . 'fl-builder.css', array(), $ver);
			}
			else {
				wp_enqueue_style('fl-builder-min',          $css_url . 'fl-builder.min.css', array(), $ver);
			}
			
			/* Custom Icons */
			FLBuilderIcons::enqueue_all_custom_icons_styles();

			/* RTL Support */
			if(is_rtl()) {
				wp_enqueue_style('fl-builder-rtl',      	$css_url . 'fl-builder-rtl.css', array(), $ver);
			}

			/* We have a custom version of sortable that fixes a bug. */
			wp_deregister_script('jquery-ui-sortable');

			/* Frontend builder scripts */
			wp_enqueue_media();
			wp_enqueue_script('heartbeat');
			wp_enqueue_script('wpdialogs');
			wp_enqueue_script('wpdialogs-popup');
			wp_enqueue_script('wplink');
			wp_enqueue_script('editor');
			wp_enqueue_script('quicktags');
			wp_enqueue_script('json2');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-widget');
			wp_enqueue_script('jquery-ui-position');
			wp_enqueue_script('jquery-ui-sortable',     	$js_url . 'jquery.ui.sortable.js', array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'), $ver, true);
			wp_enqueue_script('jquery-nanoscroller',    	$js_url . 'jquery.nanoscroller.min.js', array(), $ver, true);
			wp_enqueue_script('jquery-autosuggest',     	$js_url . 'jquery.autoSuggest.min.js', array(), $ver, true);
			wp_enqueue_script('jquery-tiptip',          	$js_url . 'jquery.tiptip.min.js', array(), $ver, true);
			wp_enqueue_script('jquery-simulate',        	$js_url . 'jquery.simulate.js', array(), $ver, true);
			wp_enqueue_script('jquery-validate',        	$js_url . 'jquery.validate.min.js', array(), $ver, true);
			wp_enqueue_script('bootstrap-tour',         	$js_url . 'bootstrap-tour-standalone.min.js', array(), $ver, true);
			wp_enqueue_script('ace', 						$js_url . 'ace/ace.js', array(), $ver, true);
			wp_enqueue_script('ace-language-tools', 		$js_url . 'ace/ext-language_tools.js', array(), $ver, true);
			
			// Enqueue individual builder scripts if WP_DEBUG is on.
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				wp_enqueue_script('fl-color-picker',        	$js_url . 'fl-color-picker.js', array(), $ver, true);
				wp_enqueue_script('fl-lightbox',            	$js_url . 'fl-lightbox.js', array(), $ver, true);
				wp_enqueue_script('fl-icon-selector',       	$js_url . 'fl-icon-selector.js', array(), $ver, true);
				wp_enqueue_script('fl-stylesheet',          	$js_url . 'fl-stylesheet.js', array(), $ver, true);
				wp_enqueue_script('fl-builder',             	$js_url . 'fl-builder.js', array(), $ver, true);
				wp_enqueue_script('fl-builder-ajax-layout',   	$js_url . 'fl-builder-ajax-layout.js', array(), $ver, true);
				wp_enqueue_script('fl-builder-preview',     	$js_url . 'fl-builder-preview.js', array(), $ver, true);
				wp_enqueue_script('fl-builder-services',    	$js_url . 'fl-builder-services.js', array(), $ver, true);
				wp_enqueue_script('fl-builder-tour',        	$js_url . 'fl-builder-tour.js', array(), $ver, true);
			}
			else {
				wp_enqueue_script('fl-builder-min',             $js_url . 'fl-builder.min.js', array(), $ver, true);
			}
			
			/* Core template settings */
			if(file_exists(FL_BUILDER_DIR . 'js/fl-builder-template-settings.js')) {
				wp_enqueue_script('fl-builder-template-settings', FL_BUILDER_URL . 'js/fl-builder-template-settings.js', array(), $ver, true);
			}

			/* Additional module styles and scripts */
			foreach(FLBuilderModel::$modules as $module) {

				$module->enqueue_scripts();

				foreach($module->css as $handle => $props) {
					wp_enqueue_style($handle, $props[0], $props[1], $props[2], $props[3]);
				}
				foreach($module->js as $handle => $props) {
					wp_enqueue_script($handle, $props[0], $props[1], $props[2], $props[3]);
				}
			}
		}
	}

	/**
	 * Include a jQuery fallback script when the builder is
	 * enabled for a page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function include_jquery()
	{
		if(FLBuilderModel::is_builder_enabled()) {
			include FL_BUILDER_DIR . 'includes/jquery.php';
		}
	}

	/**
	 * Adds builder classes to the body class.
	 *
	 * @since 1.0
	 * @param array $classes An array of existing classes.
	 * @return array
	 */
	static public function body_class($classes)
	{
		if(FLBuilderModel::is_builder_enabled() && !is_archive()) {
			$classes[] = 'fl-builder';
		}
		if(FLBuilderModel::is_builder_active() && !FLBuilderModel::current_user_has_editing_capability()) {
			$classes[] = 'fl-builder-simple';
		}

		return $classes;
	}

	/**
	 * Adds the page builder button to the WordPress admin bar.
	 *
	 * @since 1.0
	 * @param object $wp_admin_bar An instance of the WordPress admin bar.
	 * @return void
	 */
	static public function admin_bar_menu($wp_admin_bar)
	{
		global $wp_the_query;

		if ( FLBuilderModel::is_post_editable() ) {

			$wp_admin_bar->add_node( array(
				'id'    => 'fl-builder-frontend-edit-link',
				'title' => '<style> #wp-admin-bar-fl-builder-frontend-edit-link .ab-icon:before { content: "\f116" !important; top: 2px; margin-right: 3px; } </style><span class="ab-icon"></span>' . FLBuilderModel::get_branding(),
				'href'  => FLBuilderModel::get_edit_url( $wp_the_query->post->ID )
			));
		}
	}
	
	static public function locate_template_file( $template_base, $slug )
	{
		$specific_template = $template_base . '-' . $slug . '.php';
		$general_template = $template_base . '.php';
		$default_dir = trailingslashit( FL_BUILDER_DIR ) . 'includes/';
		
		// Try to find the specific template, then repeat the same process for general.
		
		$locate_template_order = apply_filters( 'fl_builder_locate_template_order', array(
			self::$template_dir . $specific_template,
			self::$template_dir . $general_template
		), self::$template_dir, $template_base, $slug );
		
		$template_path = locate_template( $locate_template_order );
		
		if ( ! $template_path ) {
			if ( file_exists( $default_dir . $specific_template ) ) {
				$template_path = $default_dir . $specific_template;
			}
			else if ( file_exists( $default_dir . $general_template ) ) {
				$template_path = $default_dir . $general_template;
			}
		}
		
		return apply_filters( 'fl_builder_template_path', $template_path, $template_base, $slug );
	}

	/**
	 * Renders the markup for the builder interface.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_ui()
	{
		global $wp_the_query;

		if ( FLBuilderModel::is_builder_active() ) {

			$post_id            = $wp_the_query->post->ID;
			$help_button 		= FLBuilderModel::get_help_button_settings();
			$enabled_templates  = FLBuilderModel::get_enabled_templates();
			$color_presets      = FLBuilderModel::get_color_presets();
			$simple_ui			= ! FLBuilderModel::current_user_has_editing_capability();
			$categories         = FLBuilderModel::get_categorized_modules();
			$row_templates		= null;
			$module_templates	= null;
			
			if ( ! FLBuilderModel::is_post_user_template( 'module' ) && ! $simple_ui ) {
				
				if ( class_exists( 'FLBuilderTemplatesOverride' ) ) {
					
					if ( FLBuilderTemplatesOverride::show_modules() ) {
						$module_templates = FLBuilderTemplatesOverride::get_selector_data( 'module' );
					}
					if ( FLBuilderTemplatesOverride::show_rows() && ! FLBuilderModel::is_post_user_template( 'row' ) ) {
						$row_templates = FLBuilderTemplatesOverride::get_selector_data( 'row' );
					}
				}
				
				include FL_BUILDER_DIR . 'includes/ui-panel.php';
			}
			
			include FL_BUILDER_DIR . 'includes/ui-bar.php';
			include FL_BUILDER_DIR . 'includes/ui-fields.php';
			include FL_BUILDER_DIR . 'includes/ui-js-templates.php';
			include FL_BUILDER_DIR . 'includes/ui-js-config.php';
		}
	}

	/**
	 * Renders the markup for the title in the builder's bar.
	 *
	 * @since 1.6.3
	 * @return void
	 */
	static public function render_ui_bar_title()
	{
		global $wp_the_query;
		
		$post_id = $wp_the_query->post->ID;
		
		// Get the bar title.
		if( FLBuilderModel::is_post_user_template() ) {
			$title = sprintf( __( 'Template: %s', 'fl-builder' ), get_the_title( $post_id ) );
		}
		else {
			$title = FLBuilderModel::get_branding();
		}
		
		// Render the bar title.
		if ( '' == FLBuilderModel::get_branding_icon() ) {
			echo '<span class="fl-builder-bar-title fl-builder-bar-title-no-icon">' . $title . '</span>';
		}
		else {
			echo '<span class="fl-builder-bar-title">';
			echo '<img src="' . FLBuilderModel::get_branding_icon() . '" /> ';
			echo '<span>' . $title . '</span></span>';
		}
	}

	/**
	 * Renders the markup for the buttons in the builder's bar.
	 *
	 * @since 1.6.3
	 * @return void
	 */
	static public function render_ui_bar_buttons()
	{
		$help_button 		= FLBuilderModel::get_help_button_settings();
		$enabled_templates  = FLBuilderModel::get_enabled_templates();
		$simple_ui			= ! FLBuilderModel::current_user_has_editing_capability();
		
		$buttons = array(
			'help' => array(
				'label' => '<i class="fa fa-question-circle"></i>',
				'show'	=> $help_button['enabled'] && ! $simple_ui
			),
			'upgrade' => array(
				'label' => __( 'Upgrade!', 'fl-builder' ),
				'show'	=> true === FL_BUILDER_LITE
			),
			'buy' => array(
				'label' => __( 'Buy Now!', 'fl-builder' ),
				'show'	=> stristr( home_url(), 'demo.wpbeaverbuilder.com' )
			),
			'done' => array(
				'label' => __( 'Done', 'fl-builder' ),
				'class' => 'fl-builder-button-primary'
			),
			'tools' => array(
				'label' => __( 'Tools', 'fl-builder' ),
				'show'	=> ! FLBuilderModel::is_post_user_template( 'module' ) && ! $simple_ui
			),
			'templates' => array(
				'label' => __( 'Templates', 'fl-builder' ),
				'show'	=> ! FLBuilderModel::is_post_user_template() && true !== FL_BUILDER_LITE && $enabled_templates != 'disabled' && ! $simple_ui
			),
			'add-content' => array(
				'label' => __( 'Add Content', 'fl-builder' ),
				'show'	=> ! FLBuilderModel::is_post_user_template( 'module' ) && ! $simple_ui
			)	
		);
		
		echo '<div class="fl-builder-bar-actions">';
		
		foreach ( $buttons as $slug => $button ) {
			
			if ( isset( $button['show'] ) && ! $button['show'] ) {
				continue;
			}
			
			echo '<span class="fl-builder-' . $slug . '-button fl-builder-button';
			
			if ( isset( $button['class'] ) ) {
				echo ' ' . $button['class'];
			}
			
			echo '">' . $button['label'] . '</span>';
		}
		
		echo '<div class="fl-clear"></div></div>';
	}

	/**
	 * Renders the UI panel for node templates.
	 *
	 * @since 1.6.3
	 * @return void
	 */
	static public function render_ui_panel_node_templates()
	{
		$file = FL_BUILDER_DIR . 'includes/ui-panel-node-templates.php';
		
		if ( file_exists( $file ) && FLBuilderModel::node_templates_enabled() ) {
			
			$saved_rows    = FLBuilderModel::get_node_templates( 'row' );
			$saved_modules = FLBuilderModel::get_node_templates( 'module' );
			$node_template = FLBuilderModel::is_post_node_template();
			
			// Don't global rows for node templates.
			foreach ( $saved_rows as $key => $val ) {
				if ( $node_template && $val['global'] ) {
					unset( $saved_rows[ $key ] );
				}
			}
			
			// Don't global modules for node templates.
			foreach ( $saved_modules as $key => $val ) {
				if ( $node_template && $val['global'] ) {
					unset( $saved_modules[ $key ] );
				}
			}
			
			include $file;
		}
	}

	/**
	 * Renders layouts using a new instance of WP_Query with the provided 
	 * args and enqueues the necessary styles and scripts. We set the global 
	 * $wp_query variable so the builder thinks we are in the loop when content 
	 * is rendered without having to call query_posts.
	 *
	 * @link https://codex.wordpress.org/Class_Reference/WP_Query See for a complete list of args.
	 *
	 * @since 1.7
	 * @param array|string $args An array or string of args to be passed to a new instance of WP_Query.
	 * @return void
	 */
	static public function render_query( $args )
	{
		global $post;
		global $wp_query;
		
		$original_post 	= $post;
		$wp_query  		= new WP_Query( $args );
		$post_data 		= FLBuilderModel::get_post_data();
		
		// Make sure the builder's render content filter is present.
		add_filter( 'the_content', 'FLBuilder::render_content' );
		
		// Unset the builder's post_data post ID so the global $post is used.
		FLBuilderModel::update_post_data( 'post_id', null );
		
		// Loop through the posts.
		while ( $wp_query->have_posts() ) {
			
			// Set the global post.
			$wp_query->the_post();
			
			// Make sure this isn't the same post as the original post to prevent infinite loops.
			if ( $original_post->ID === $post->ID ) {
				continue;
			}
			
			// Enqueue styles and scripts for this post.
			self::enqueue_layout_styles_scripts( $post->ID );
			
			// Print the styles since we are outside of the head tag.
			ob_start();
			wp_print_styles();
			$styles = str_replace( "\n", '', ob_get_clean() );
			
			// Added stylesheets inline can mess with specificity, so we add them to the head with JS.
			if ( ! empty( $styles ) ) {
				echo '<script>jQuery("head").prepend("' . str_replace( '"', "'", $styles ) . '");</script>';
			}
			
			// Backup the main query in case it is overwritten in the_content().
			$backup_query = $wp_query;
			
			// Render the content.
			the_content();
			
			// Restore the main query in case it was overwritten.
			$wp_query = $backup_query;
		}
		
		// Reset the post_id if we have one in $post_data.
		if ( isset( $post_data['post_id'] ) ) {
			FLBuilderModel::update_post_data( 'post_id', $post_data['post_id'] );
		}
		
		// Reset the global query.
		wp_reset_query();
	}

	/**
	 * Renders the content for a builder layout while in the loop. 
	 * This method should only be called by the_content filter as 
	 * defined in fl-builder.php. To output builder content, use 
	 * the_content function while in a WordPress loop. 
	 *
	 * @since 1.0
	 * @param string $content The existing content.
	 * @return string
	 */
	static public function render_content( $content )
	{
		$post_id        = FLBuilderModel::get_post_id();
		$enabled        = FLBuilderModel::is_builder_enabled();
		$rendering      = $post_id === self::$post_rendering;
		$in_loop        = in_the_loop();
		$is_global      = in_array( $post_id, FLBuilderModel::get_global_posts() );

		if( $enabled && ! $rendering && ( $in_loop || $is_global ) ) {
			
			// Set the post rendering ID.
			self::$post_rendering = $post_id;

			// Remove the builder's render_content filter so it's not called again.
			remove_filter( 'the_content', 'FLBuilder::render_content' );
			
			// Render the content.
			
			ob_start();

			do_action( 'fl_builder_before_render_content', $content );

			echo '<div class="' . self::render_content_classes() . '" data-post-id="' . $post_id . '">';
			self::render_nodes();
			echo '</div>';
			
			do_action( 'fl_builder_after_render_content', $content );
			
			$content = ob_get_clean();
			
			// Reapply the builder's render_content filter.
			add_filter( 'the_content', 'FLBuilder::render_content' );
			
			// Do shortcodes here since letting the WP filter run can cause an infinite loop.
			if ( apply_filters( 'fl_builder_render_shortcodes', true ) ) {
				$pattern = get_shortcode_regex();
				$content = preg_replace_callback( "/$pattern/s", 'FLBuilder::double_escape_shortcodes', $content );
				$content = do_shortcode( $content );
			}
			
			// Add srcset attrs to images with the class wp-image-<ID>.
			if ( function_exists( 'wp_make_content_images_responsive' ) ) {
				$content = wp_make_content_images_responsive( $content );
			}
			
			// Clear the post rendering ID.
			self::$post_rendering = null;
		}

		return $content;
	}

	/**
	 * Escaped shortcodes need to be double escaped or they will
	 * be parsed by WP's shortcodes filter.
	 *
	 * @since 1.6.4.1
	 * @param array $matches The existing content.
	 * @return string
	 */
	static public function double_escape_shortcodes( $matches )
	{
		if ( $matches[1] == '[' && $matches[6] == ']' ) {
			return '[' . $matches[0] . ']';
		}
		
		return $matches[0];
	}

	/**
	 * Renders the CSS classes for the main content div tag.
	 *
	 * @since 1.6.4
	 * @return string
	 */
	static public function render_content_classes()
	{
		// Build the content class.
		$classes = 'fl-builder-content fl-builder-content-' . FLBuilderModel::get_post_id();
		
		// Add template classes to the content class.
		if ( FLBuilderModel::is_post_user_template() ) {
			$classes .= ' fl-builder-template';
			$classes .= ' fl-builder-' . FLBuilderModel::get_user_template_type() . '-template';
		}
		
		// Add the global templates locked class.
		if ( ! current_user_can( FLBuilderModel::get_global_templates_editing_capability() ) ) {
			$classes .= ' fl-builder-global-templates-locked';
		}
		
		// Add browser specific classes.
		if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) {
			if ( stristr( $_SERVER[ 'HTTP_USER_AGENT' ], 'Trident/7.0' ) && stristr( $_SERVER[ 'HTTP_USER_AGENT' ], 'rv:11.0' ) ) {
				$classes .= ' fl-builder-ie-11';
			}
		}
		
		return $classes;
	}

	/**
	 * Renders the markup for all nodes in a layout.
	 *
	 * @since 1.6.3
	 * @return void
	 */
	static public function render_nodes()
	{
		do_action( 'fl_builder_before_render_nodes' );
		
		if ( FLBuilderModel::is_post_user_template( 'module' ) ) {
			self::render_modules();
		}
		else {
			self::render_rows();
		}
		
		do_action( 'fl_builder_after_render_nodes' );
	}

	/**
	 * Renders the stripped down content for a layout
	 * that is saved to the WordPress editor.
	 *
	 * @since 1.0
	 * @param string $content The existing content.
	 * @return string
	 */
	static public function render_editor_content()
	{
		$rows = FLBuilderModel::get_nodes('row');

		ob_start();

		// Render the modules.
		foreach($rows as $row) {

			$groups = FLBuilderModel::get_nodes('column-group', $row);

			foreach($groups as $group) {

				$cols = FLBuilderModel::get_nodes('column', $group);

				foreach($cols as $col) {

					$modules = FLBuilderModel::get_modules($col);

					foreach($modules as $module) {

						if($module->editor_export) {

							// Don't crop photos to ensure media library photos are rendered.
							if($module->settings->type == 'photo') {
								$module->settings->crop = false;
							}

							FLBuilder::render_module_html($module->settings->type, $module->settings, $module);
						}
					}
				}
			}
		}

		// Get the content.
		$content = ob_get_clean();

		// Remove unnecessary tags.
		$content = preg_replace('/<\/?div[^>]*\>/i',                '', $content);
		$content = preg_replace('/<\/?span[^>]*\>/i',               '', $content);
		$content = preg_replace('#<script(.*?)>(.*?)</script>#is',  '', $content);
		$content = preg_replace('/<i [^>]*><\\/i[^>]*>/',           '', $content);
		$content = preg_replace('/ class=".*?"/',                   '', $content);

		// Remove empty lines.
		$content = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', "\n", $content);

		return $content;
	}

	/**
	 * Renders a settings form.
	 *
	 * @since 1.0
	 * @param array $form The form data.
	 * @param object $settings The settings data.
	 * @return array
	 */
	static public function render_settings($form = array(), $settings)
	{
		$defaults = array(
			'class'     => '',
			'attrs'     => '',
			'title'     => '',
			'badges'	=> array(),
			'tabs'      => array(),
			'buttons'	=> array()
		);

		$form = array_merge($defaults, $form);

		ob_start();
		include FL_BUILDER_DIR . 'includes/settings.php';
		$html = ob_get_clean();

		return array( 'html' => $html );
	}

	/**
	 * Renders a settings form field.
	 *
	 * @since 1.0
	 * @param string $name The field name.
	 * @param array $field An array of setup data for the field.
	 * @param object $settings Form settings data object.
	 * @return void
	 */
	static public function render_settings_field($name, $field, $settings = null)
	{
		$field              = apply_filters( 'fl_builder_render_settings_field', $field, $name, $settings ); // Allow field settings filtering first
		$i                  = null;
		$is_multiple        = isset($field['multiple']) && $field['multiple'] === true;
		$supports_multiple  = $field['type'] != 'editor' && $field['type'] != 'photo' && $field['type'] != 'service';
		$settings           = ! $settings ? new stdClass() : $settings;
		$value              = isset($settings->$name) ? $settings->$name : '';
		$preview            = isset($field['preview']) ? json_encode($field['preview']) : json_encode(array('type' => 'refresh'));
		$row_class          = isset($field['row_class']) ? ' ' . $field['row_class'] : '';

		if($is_multiple && $supports_multiple) {

			$values     = $value;
			$arr_name   = $name;
			$name      .= '[]';

			echo '<tbody class="fl-field fl-builder-field-multiples" data-type="form" data-preview=\'' . $preview . '\'>';

			for($i = 0; $i < count($values); $i++) {
				$value = $values[$i];
				echo '<tr class="fl-builder-field-multiple" data-field="'. $arr_name .'">';
				include FL_BUILDER_DIR . 'includes/field.php';
				echo '<td class="fl-builder-field-actions">';
				echo '<i class="fl-builder-field-move fa fa-arrows"></i>';
				echo '<i class="fl-builder-field-copy fa fa-copy"></i>';
				echo '<i class="fl-builder-field-delete fa fa-times"></i>';
				echo '</td>';
				echo '</tr>';
			}

			echo '<tr>';

			if(empty($field['label'])) {
				echo '<td colspan="2">';
			}
			else {
				echo '<td>&nbsp;</td><td>';
			}

			echo '<a href="javascript:void(0);" onclick="return false;" class="fl-builder-field-add fl-builder-button" data-field="'. $arr_name .'">'. sprintf( _x( 'Add %s', 'Field name to add.', 'fl-builder' ), $field['label'] ) .'</a>';
			echo '</td>';
			echo '</tr>';
			echo '</tbody>';
		}
		else {
			echo '<tr id="fl-field-'. $name .'" class="fl-field' . $row_class . '" data-type="' . $field['type'] . '" data-preview=\'' . $preview . '\'>';
			include FL_BUILDER_DIR . 'includes/field.php';
			echo '</tr>';
		}
	}

	/**
	 * Renders a settings form.
	 *
	 * @since 1.0
	 * @param string $type The type of form to render.
	 * @param object $settings The settings data.
	 * @return array
	 */
	static public function render_settings_form($type = null, $settings = null)
	{
		$form = FLBuilderModel::get_settings_form( $type );

		if(isset($settings) && !empty($settings)) {
			$defaults = FLBuilderModel::get_settings_form_defaults( $type );
			$settings = (object)array_merge((array)$defaults, (array)$settings);
		}
		else {
			$settings = FLBuilderModel::get_settings_form_defaults( $type );
		}

		return self::render_settings(array(
			'title' => $form['title'],
			'tabs'  => $form['tabs']
		), $settings);
	}

	/**
	 * Renders the markup for the layout settings form.
	 *
	 * @since 1.8
	 * @return array
	 */
	static public function render_layout_settings()
	{
		$settings 	= FLBuilderModel::get_layout_settings();
		$form 		= FLBuilderModel::$settings_forms['layout'];

		return self::render_settings( array(
			'class'   => 'fl-builder-layout-settings',
			'title'   => $form['title'],
			'tabs'    => $form['tabs']
		), $settings );
	}

	/**
	 * Renders the markup for the global settings form.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function render_global_settings()
	{
		$settings 	= FLBuilderModel::get_global_settings();
		$form 		= FLBuilderModel::$settings_forms['global'];

		return self::render_settings(array(
			'class'   => 'fl-builder-global-settings',
			'title'   => $form['title'],
			'tabs'    => $form['tabs']
		), $settings);
	}

	/**
	 * Registers the custom post type for builder templates.
	 *
	 * @since 1.1.3
	 * @since 1.5.7 Added template category taxonomy.
	 * @return void
	 */
	static public function register_templates_post_type()
	{
		// Template classes aren't included in the lite version. 
		if(FL_BUILDER_LITE === true) {
			return;
		}
		
		// Vars for checking if the templates admin should be public.
		$admin_enabled 	= FLBuilderModel::user_templates_admin_enabled();
		$can_edit 		= FLBuilderModel::current_user_has_editing_capability();
		
		// Get the array of supported features for the templates post type.
		$supports = array(
			'title',
			'revisions',
			'page-attributes'
		);
		
		// Include thumbnail support if core templates can be overridden.
		if ( class_exists( 'FLBuilderTemplatesOverride' ) ) {
			$supports[] = 'thumbnail';	
		}
		
		// Register the template post type.
		register_post_type('fl-builder-template', array(
			'public'            => $admin_enabled && $can_edit ? true : false,
			'labels'            => array(
				'name'               => _x( 'Templates', 'Custom post type label.', 'fl-builder' ),
				'singular_name'      => _x( 'Template', 'Custom post type label.', 'fl-builder' ),
				'menu_name'          => _x( 'Templates', 'Custom post type label.', 'fl-builder' ),
				'name_admin_bar'     => _x( 'Template', 'Custom post type label.', 'fl-builder' ),
				'add_new'            => _x( 'Add New', 'Custom post type label.', 'fl-builder' ),
				'add_new_item'       => _x( 'Add New Template', 'Custom post type label.', 'fl-builder' ),
				'new_item'           => _x( 'New Template', 'Custom post type label.', 'fl-builder' ),
				'edit_item'          => _x( 'Edit Template', 'Custom post type label.', 'fl-builder' ),
				'view_item'          => _x( 'View Template', 'Custom post type label.', 'fl-builder' ),
				'all_items'          => _x( 'All Templates', 'Custom post type label.', 'fl-builder' ),
				'search_items'       => _x( 'Search Templates', 'Custom post type label.', 'fl-builder' ),
				'parent_item_colon'  => _x( 'Parent Templates:', 'Custom post type label.', 'fl-builder' ),
				'not_found'          => _x( 'No templates found.', 'Custom post type label.', 'fl-builder' ),
				'not_found_in_trash' => _x( 'No templates found in Trash.', 'Custom post type label.', 'fl-builder' )
			),
			'menu_icon'			=> 'dashicons-welcome-widgets-menus',
			'supports'          => $supports,
			'taxonomies'		=> array(
				'fl-builder-template-category'
			),
			'publicly_queryable' 	=> $can_edit,
			'exclude_from_search'	=> true
		) );
		
		// Register the template category tax.
		register_taxonomy( 'fl-builder-template-category', array( 'fl-builder-template' ), array(
			'labels'            => array(
				'name'              => _x( 'Template Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'singular_name'     => _x( 'Template Category', 'Custom taxonomy label.', 'fl-builder' ),
				'search_items'      => _x( 'Search Template Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'all_items'         => _x( 'All Template Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'parent_item'       => _x( 'Parent Template Category', 'Custom taxonomy label.', 'fl-builder' ),
				'parent_item_colon' => _x( 'Parent Template Category:', 'Custom taxonomy label.', 'fl-builder' ),
				'edit_item'         => _x( 'Edit Template Category', 'Custom taxonomy label.', 'fl-builder' ),
				'update_item'       => _x( 'Update Template Category', 'Custom taxonomy label.', 'fl-builder' ),
				'add_new_item'      => _x( 'Add New Template Category', 'Custom taxonomy label.', 'fl-builder' ),
				'new_item_name'     => _x( 'New Template Category Name', 'Custom taxonomy label.', 'fl-builder' ),
				'menu_name'         => _x( 'Categories', 'Custom taxonomy label.', 'fl-builder' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true
		) );
		
		// Register the template type tax.
		register_taxonomy( 'fl-builder-template-type', array( 'fl-builder-template' ), array(
			'label'             => _x( 'Type', 'Custom taxonomy label.', 'fl-builder' ),
			'hierarchical'      => false,
			'public'            => false,
			'show_admin_column' => true
		) );
	}

	/**
	 * Renders the markup for the template selector.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function render_template_selector()
	{
		if(file_exists(FL_BUILDER_DIR . 'includes/template-selector.php')) {

			$enabled_templates  = FLBuilderModel::get_enabled_templates();
			$user_templates     = FLBuilderModel::get_user_templates();
			$templates          = FLBuilderModel::get_template_selector_data();

			ob_start();
			include FL_BUILDER_DIR . 'includes/template-selector.php';
			$html = ob_get_clean();

			return array( 'html' => $html );
		}
	}

	/**
	 * Renders the settings form for saving a user defined template.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function render_user_template_settings()
	{
		$defaults = FLBuilderModel::get_settings_form_defaults( 'user_template' );
		$form     = FLBuilderModel::get_settings_form( 'user_template' );

		return self::render_settings(array(
			'class'   => 'fl-builder-user-template-settings',
			'title'   => $form['title'],
			'tabs'    => $form['tabs']
		), $defaults);
	}

	/**
	 * Renders the settings form for saving a node template.
	 *
	 * @since 1.6.3
	 * @param string $node_id The node whose template settings to load.
	 * @return array
	 */
	static public function render_node_template_settings( $node_id = null )
	{
		$defaults 	= FLBuilderModel::get_settings_form_defaults( 'node_template' );
		$form     	= FLBuilderModel::get_settings_form( 'node_template' );
		$node 		= FLBuilderModel::get_node( $node_id );

		return self::render_settings(array(
			'class'   => 'fl-builder-node-template-settings',
			'attrs'   => 'data-node="'. $node->node .'"',
			'title'   => str_replace( '%s', ucwords( $node->type ), $form['title'] ),
			'tabs'    => $form['tabs']
		), $defaults);
	}

	/**
	 * Trys to load page.php for editing a builder template.
	 *
	 * @since 1.0
	 * @param string $template The current template to be loaded.
	 * @return string
	 */
	static public function render_template( $template )
	{
		global $post;
		
		if ( 'string' == gettype( $template ) && $post && $post->post_type == 'fl-builder-template' ) {

			$page = locate_template( array( 'page.php' ) );

			if ( ! empty( $page ) ) {
				return $page;
			}
		}

		return $template;
	}

	/**
	 * Renders the markup for the icon selector.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function render_icon_selector()
	{
		$icon_sets = FLBuilderIcons::get_sets();

		ob_start();
		include FL_BUILDER_DIR . 'includes/icon-selector.php';
		$html = ob_get_clean();
		
		return array( 'html' => $html );
	}

	/**
	 * Renders the markup for all of the rows in a layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_rows()
	{
		$rows = FLBuilderModel::get_nodes('row');
		
		do_action( 'fl_builder_before_render_rows', $rows );

		foreach($rows as $row) {
			self::render_row($row);
		}
		
		do_action( 'fl_builder_after_render_rows', $rows );
	}

	/**
	 * Renders the markup for a single row.
	 *
	 * @since 1.0
	 * @param object $row The row to render.
	 * @return void
	 */
	static public function render_row($row)
	{
		$groups = FLBuilderModel::get_nodes('column-group', $row);
		
		do_action( 'fl_builder_before_render_row', $row, $groups );
		
		$template_file = self::locate_template_file(
			apply_filters( 'fl_builder_row_template_base', 'row', $row ),
			apply_filters( 'fl_builder_row_template_slug', '', $row )
		);
		
		if ( $template_file ) {
			include $template_file;
		}
		
		do_action( 'fl_builder_after_render_row', $row, $groups );
	}

	/**
	 * Renders the HTML attributes for a single row.
	 *
	 * @since 1.0
	 * @param object $row A row node object.
	 * @return void
	 */
	static public function render_row_attributes( $row )
	{
		$custom_class = apply_filters( 'fl_builder_row_custom_class', $row->settings->class, $row );
		$overlay_bgs  = array( 'photo', 'parallax', 'slideshow', 'video' );
		$active		  = FLBuilderModel::is_builder_active();
		$global       = FLBuilderModel::is_node_global( $row );
		
		// ID
		if ( ! empty( $row->settings->id ) ) {
			echo ' id="' . esc_attr( $row->settings->id ) . '"';
		}
		
		// Class
		echo ' class="fl-row';
		echo ' fl-row-' . $row->settings->width . '-width';
		echo ' fl-row-bg-' . $row->settings->bg_type;

		if ( ! empty( $row->settings->full_height ) && $row->settings->full_height == 'full' ) {
			echo ' fl-row-full-height';
		}

		if ( in_array( $row->settings->bg_type, $overlay_bgs ) && ! empty( $row->settings->bg_overlay_color ) ) {
			echo ' fl-row-bg-overlay';
		}
		if ( ! empty( $row->settings->responsive_display ) ) {
			echo ' fl-visible-' . $row->settings->responsive_display;
		}
		if ( ! empty( $custom_class ) ) {
			echo ' ' . trim( esc_attr( $custom_class ) );
		}
		if ( $global && $active ) {
			echo ' fl-node-global';
		}
		
		echo ' fl-node-' . $row->node;
		echo '"';
		
		// Data
		echo ' data-node="' . $row->node . '"';

		if ( $row->settings->bg_type == 'parallax' && ! empty( $row->settings->bg_parallax_image_src ) ) {
			echo ' data-parallax-speed="' . $row->settings->bg_parallax_speed . '"';
			echo ' data-parallax-image="' . $row->settings->bg_parallax_image_src . '"';
		}
		if ( $global && $active ) {
			echo ' data-template="' . $row->template_id . '"';
			echo ' data-template-node="' . $row->template_node_id . '"';
			echo ' data-template-url="' . FLBuilderModel::get_node_template_edit_url( $row->template_id ) . '"';
		}
	}

	/**
	 * Renders the markup for a row's background.
	 *
	 * @since 1.0
	 * @param object $row A row node object.
	 * @return void
	 */
	static public function render_row_bg($row)
	{
		do_action( 'fl_builder_before_render_row_bg', $row );
		
		if($row->settings->bg_type == 'video') {

			$vid_data = FLBuilderModel::get_row_bg_data($row);

			if($vid_data) {
				$template_file = self::locate_template_file(
					apply_filters( 'fl_builder_row_video_bg_template_base', 'row-video', $row ),
					apply_filters( 'fl_builder_row_video_bg_template_slug', '', $row )
				);
				
				if ( $template_file ) {
					include $template_file;
				}
			}
		}
		else if($row->settings->bg_type == 'slideshow') {
			echo '<div class="fl-bg-slideshow"></div>';
		}
		
		do_action( 'fl_builder_after_render_row_bg', $row );
	}

	/**
	 * Renders the HTML class for a row's content wrapper.
	 *
	 * @since 1.0
	 * @param object $row A row node object.
	 * @return void
	 */
	static public function render_row_content_class($row)
	{
		echo 'fl-row-content';
		echo ' fl-row-' . $row->settings->content_width . '-width';
		echo ' fl-node-content';
	}

	/**
	 * Renders the settings lightbox for a row.
	 *
	 * @since 1.0
	 * @param string $node_id A row node ID.
	 * @return array
	 */
	static public function render_row_settings($node_id = null)
	{
		$node       = FLBuilderModel::get_node($node_id);
		$settings   = $node->settings;
		$form       = FLBuilderModel::$settings_forms['row'];
		$global     = FLBuilderModel::is_node_global( $node );
		$buttons    = array();
		
		if ( ! $global && ! FLBuilderModel::is_post_node_template() && FLBuilderModel::node_templates_enabled() ) {
			$buttons[] = 'save-as';
		}
		
		$rendered_settings = self::render_settings(array(
			'class'     => 'fl-builder-row-settings',
			'attrs'     => 'data-node="'. $node->node .'"',
			'title'     => $form['title'],
			'badges'	=> $global ? array( 'global' => _x( 'Global', 'Indicator for global node templates.', 'fl-builder' ) ) : array(),
			'tabs'      => $form['tabs'],
			'buttons'	=> $buttons
		), $settings);

		return array(
			'settings' => $rendered_settings['html'],
			'state'    => FLBuilderAJAXLayout::render( $node_id )
		);
	}

	/**
	 * Renders the markup for a column group.
	 *
	 * @since 1.0
	 * @param object $group A column group node object.
	 * @return void
	 */
	static public function render_column_group($group)
	{
		$cols = FLBuilderModel::get_nodes('column', $group);

		do_action( 'fl_builder_before_render_column_group', $group, $cols );

		$template_file = self::locate_template_file(
			apply_filters( 'fl_builder_column_group_template_base', 'column-group', $group ),
			apply_filters( 'fl_builder_column_group_template_slug', '', $group )
		);
		
		if ( $template_file ) {
			include $template_file;
		}
		
		do_action( 'fl_builder_after_render_column_group', $group, $cols );
	}

	/**
	 * Adds a new column group and renders it.
	 *
	 * @since 1.0
	 * @param string $node_id The node ID of a row to add the new group to.
	 * @param string $cols The type of column layout to use.
	 * @param int $position The position of the new column group in the row.
	 * @return void
	 */
	static public function render_column_group_attributes( $group )
	{
		$equal_height = self::is_column_equal_height( $group ) ? ' fl-col-group-equal-height' : '';
		$custom_width = self::column_has_custom_width( $group ) ? ' fl-col-group-custom-width' : '';
		echo ' class="fl-col-group fl-node-' . $group->node . $equal_height . $custom_width . '"';
		echo ' data-node="' . $group->node . '"';
	}
	
	/**
	 * Checks if the columns in a group are equal height.
	 *
	 * @since 1.6.4
	 * @param string $group A group node who's columns to check.
	 * @return bool
	 */
	static public function is_column_equal_height( $group )
	{
		$cols = FLBuilderModel::get_nodes( 'column', $group );

		foreach( $cols as $col ) {
			if( isset( $col->settings->equal_height ) && $col->settings->equal_height == 'yes' ) {
				return true;
			}
		}
		
		return false;
	}

	/**
	 * Checks to see if the columns in a group have custom responsive widths.
	 *
	 * @since 1.6.4
	 * @param string $group A group node who's columns to check.
	 * @return bool
	 */
	static public function column_has_custom_width( $group )
	{
		$cols = FLBuilderModel::get_nodes( 'column', $group );

		foreach( $cols as $col ) {
			if( isset( $col->settings->responsive_size ) && $col->settings->responsive_size == 'custom' ) {
				return true;
			}	
		}
		
		return false;
	}

	/**
	 * Renders the markup for a single column.
	 *
	 * @since 1.7
	 * @param string|object $col_id A column ID or object.
	 * @return void
	 */
	static public function render_column( $col_id = null )
	{
		$col = is_object( $col_id ) ? $col_id : FLBuilderModel::get_node( $col_id );
		
		include FL_BUILDER_DIR . 'includes/column.php';
	}

	/**
	 * Renders the markup for the column settings lightbox.
	 *
	 * @since 1.0
	 * @param string $node_id A column node ID.
	 * @return array
	 */
	static public function render_column_settings($node_id = null)
	{
		$node       = FLBuilderModel::get_node($node_id);
		$settings   = $node->settings;
		$form       = FLBuilderModel::$settings_forms['col'];
		$global 	= FLBuilderModel::is_node_global( $node );

		$rendered_settings = self::render_settings(array(
			'class'     => 'fl-builder-col-settings',
			'attrs'     => 'data-node="'. $node->node .'"',
			'title'     => $form['title'],
			'badges'	=> $global ? array( 'global' => _x( 'Global', 'Indicator for global node templates.', 'fl-builder' ) ) : array(),
			'tabs'      => $form['tabs']
		), $settings);

		return array(
			'settings' => $rendered_settings['html'],
			'state'    => FLBuilderAJAXLayout::render( $node_id )
		);
	}

	/**
	 * Renders the HTML attributes for a single column.
	 *
	 * @since 1.0
	 * @param object $col A column node object.
	 * @return void
	 */
	static public function render_column_attributes( $col )
	{
		$custom_class = apply_filters( 'fl_builder_column_custom_class', $col->settings->class, $col );
		$overlay_bgs  = array( 'photo' );
		$active		  = FLBuilderModel::is_builder_active();
		$global       = FLBuilderModel::is_node_global( $col );
		
		// ID
		if ( ! empty( $col->settings->id ) ) {
			echo ' id="' . esc_attr( $col->settings->id ) . '"';
		}
		
		// Class
		echo ' class="fl-col';

		if ( $col->settings->size <= 50 ) {
			echo ' fl-col-small';
		}
		if ( in_array( $col->settings->bg_type, $overlay_bgs ) && ! empty( $col->settings->bg_overlay_color ) ) {
			echo ' fl-col-bg-overlay';
		}
		if ( ! empty( $col->settings->responsive_display ) ) {
			echo ' fl-visible-' . $col->settings->responsive_display;
		}
		if ( ! empty( $custom_class ) ) {
			echo ' ' . trim( esc_attr( $custom_class ) );
		}
		if ( $global && $active ) {
			echo ' fl-node-global';
		}
		
		echo ' fl-node-' . $col->node;
		echo '"';
		
		// Width
		echo ' style="width: ' . $col->settings->size . '%;"';
		
		// Data
		echo ' data-node="' . $col->node . '"';
		
		if ( $global && $active ) {
			echo ' data-template="' . $col->template_id . '"';
			echo ' data-template-node="' . $col->template_node_id . '"';
		}
	}

	/**
	 * Renders the markup for all modules in a column.
	 *
	 * @since 1.0
	 * @param string|object $col_id A column ID or object.
	 * @return void
	 */
	static public function render_modules( $col_id = null )
	{
		$modules = FLBuilderModel::get_modules( $col_id );
		
		do_action( 'fl_builder_before_render_modules', $modules, $col_id );

		foreach ( $modules as $module ) {
			self::render_module( $module );
		}
		
		do_action( 'fl_builder_after_render_modules', $modules, $col_id );
	}

	/**
	 * Renders the markup for a single module.
	 *
	 * @since 1.7
	 * @param string|object $module_id A module ID or object.
	 * @return void
	 */
	static public function render_module( $module_id = null )
	{
		$module 	= is_object( $module_id ) ? $module_id : FLBuilderModel::get_module( $module_id );
		$settings 	= $module->settings;
		$id 		= $module->node;

		do_action( 'fl_builder_before_render_module', $module );

		
		$template_file = self::locate_template_file(
			apply_filters( 'fl_builder_module_template_base', 'module', $module ),
			apply_filters( 'fl_builder_module_template_slug', '',  $module )
		);
		
		if ( $template_file ) {
			include $template_file;
		}

		do_action( 'fl_builder_after_render_module', $module );
	}

	/**
	 * Renders the settings lightbox for a module.
	 *
	 * @since 1.0
	 * @param string $node_id The module node ID.
	 * @param string $type The type of module.
	 * @param string $parent_id The parent column node ID.
	 * @param bool $render_state Whether to render the preview state or not.
	 * @return array
	 */
	static public function render_module_settings($node_id = null, $type = null, $parent_id = null, $render_state = true)
	{
		$buttons = array();
		$assets  = '';
		
		// Get the module and settings.
		if($node_id) {
			$module     = FLBuilderModel::get_module($node_id);
			$settings   = $module->settings;
		}
		else {
			$module     = FLBuilderModel::$modules[$type];
			$settings   = FLBuilderModel::get_module_defaults($type);
		}
		
		// Is this module global?
		$global = FLBuilderModel::is_node_global( $module );
		
		// Add the Save As button?
		if ( ! $global && ! FLBuilderModel::is_post_node_template() && FLBuilderModel::node_templates_enabled() ) {
			$buttons[] = 'save-as';
		}

		// Render the settings CSS/JS assets.
		if(file_exists($module->dir .'css/settings.css')) {
			$assets .= '<link class="fl-builder-settings-css" rel="stylesheet" href="'. $module->url .'css/settings.css" />';
		}
		if(file_exists($module->dir .'js/settings.js')) {
			$assets .= '<script class="fl-builder-settings-js" src="'. $module->url .'js/settings.js"></script>';
		}

		// Render the form.
		$rendered_settings = self::render_settings(array(
			'class' 	=> 'fl-builder-module-settings fl-builder-'. $type .'-settings',
			'attrs' 	=> 'data-node="'. $node_id .'" data-parent="'. $parent_id .'" data-type="'. $type .'"',
			'title' 	=> sprintf( _x( '%s Settings', '%s stands for module name.', 'fl-builder' ), $module->name ),
			'badges'	=> $global ? array( 'global' => _x( 'Global', 'Indicator for global node templates.', 'fl-builder' ) ) : array(),
			'tabs'  	=> $module->form,
			'buttons'	=> $buttons
		), $settings);
		
		// Return the HTML.
		return array( 
			'settings' => $assets . $rendered_settings['html'],
			'state'    => $render_state ? FLBuilderAJAXLayout::render( $node_id ) : null
		);
	}

	/**
	 * Renders the markup for a single module. This can be used to render
	 * the markup of a module within another module by passing the type 
	 * and settings params and leaving the module param null.
	 *
	 * @since 1.0
	 * @param string $type The type of module.
	 * @param object $settings A module settings object.
	 * @param object $module Optional. An existing module object to use.
	 * @return void
	 */
	static public function render_module_html($type, $settings, $module = null)
	{
		// Settings
		$defaults = FLBuilderModel::get_module_defaults($type);
		$settings = (object)array_merge((array)$defaults, (array)$settings);

		// Module
		$class = get_class(FLBuilderModel::$modules[$type]);
		$module = new $class();
		$module->settings = $settings;

		// Shorthand reference to the module's id.
		$id = $module->node;

		include $module->dir .'includes/frontend.php';
	}

	/**
	 * Renders the HTML attributes for a single module.
	 *
	 * @since 1.0
	 * @param object $module A module node object.
	 * @return void
	 */
	static public function render_module_attributes( $module )
	{
		$custom_class = apply_filters( 'fl_builder_module_custom_class', $module->settings->class, $module );
		$active		  = FLBuilderModel::is_builder_active();
		$global       = FLBuilderModel::is_node_global( $module );
		
		// ID
		if ( ! empty( $module->settings->id ) ) {
			echo ' id="' . esc_attr( $module->settings->id ) . '"';
		}
		
		// Class
		echo ' class="fl-module';
		echo ' fl-module-' . $module->settings->type;

		if ( ! empty( $module->settings->responsive_display ) ) {
			echo ' fl-visible-' . $module->settings->responsive_display;
		}
		if ( ! empty( $module->settings->animation ) ) {
			echo ' fl-animation fl-' . $module->settings->animation;
		}
		if ( ! empty( $custom_class ) ) {
			echo ' ' . trim( esc_attr( $custom_class ) );
		}
		if ( $global && $active ) {
			echo ' fl-node-global';
		}
		
		echo ' fl-node-' . $module->node;
		echo '"';
		
		// Data
		echo ' data-node="' . $module->node . '" ';
		echo ' data-animation-delay="' . $module->settings->animation_delay . '" ';

		if ( $active ) {
			echo ' data-parent="' . $module->parent . '" ';
			echo ' data-type="' . $module->settings->type . '" ';
			echo ' data-name="' . $module->name . '" ';
		}
		if ( $global && $active ) {
			echo ' data-template="' . $module->template_id . '"';
			echo ' data-template-node="' . $module->template_node_id . '"';
		}
	}

	/**
	 * Renders the CSS for a single module.
	 *
	 * @since 1.0
	 * @param string $type The type of module.
	 * @param object $id A module node ID.
	 * @param object $settings A module settings object.
	 * @return void
	 */
	static public function render_module_css($type, $id, $settings)
	{
		// Settings
		$global_settings = FLBuilderModel::get_global_settings();
		$defaults = FLBuilderModel::get_module_defaults($type);
		$settings = (object)array_merge((array)$defaults, (array)$settings);

		// Module
		$class = get_class(FLBuilderModel::$modules[$type]);
		$module = new $class();
		$module->settings = $settings;

		include $module->dir .'includes/frontend.css.php';
	}

	/**
	 * Renders the CSS and JS assets.
	 *
	 * @since 1.7
	 * @return void
	 */
	static public function render_assets()
	{
		self::render_css();
		self::render_js();
	}

	/**
	 * Renders custom CSS in a style tag so it can be edited 
	 * using the builder interface.
	 *
	 * @since 1.7
	 * @return void
	 */
	static public function render_custom_css_for_editing()
	{
		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		}
		
		$global_settings = FLBuilderModel::get_global_settings();
		$layout_settings = FLBuilderModel::get_layout_settings();
		
		echo '<style id="fl-builder-global-css">' . $global_settings->css . '</style>';
		echo '<style id="fl-builder-layout-css">' . $layout_settings->css . '</style>';
	}

	/**
	 * Renders and caches the CSS for a builder layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_css()
	{
		// Delete the old file.
		FLBuilderModel::delete_asset_cache('css');

		// Get info on the new file.
		$nodes 				= FLBuilderModel::get_categorized_nodes();
		$node_status		= FLBuilderModel::get_node_status();
		$global_settings    = FLBuilderModel::get_global_settings();
		$asset_info         = FLBuilderModel::get_asset_info();
		$post_id            = FLBuilderModel::get_post_id();
		$post               = get_post($post_id);
		$compiled           = array();

		// Core layout css
		$css = file_get_contents(FL_BUILDER_DIR . '/css/fl-builder-layout.css');
		
		// Core layout RTL css
		if(is_rtl()) {
			$css .= file_get_contents(FL_BUILDER_DIR . '/css/fl-builder-layout-rtl.css');
		}

		// Responsive layout css
		if($global_settings->responsive_enabled) {
			
			$css .= '@media (max-width: '. $global_settings->medium_breakpoint .'px) { ';
			$css .= file_get_contents(FL_BUILDER_DIR . '/css/fl-builder-layout-medium.css');
			$css .= ' }';
			$css .= '@media (max-width: '. $global_settings->responsive_breakpoint .'px) { ';
			$css .= file_get_contents(FL_BUILDER_DIR . '/css/fl-builder-layout-responsive.css');
			
			if ( ! isset( $global_settings->auto_spacing ) || $global_settings->auto_spacing ) {
				$css .= file_get_contents(FL_BUILDER_DIR . '/css/fl-builder-layout-auto-spacing.css');
			}
			
			$css .= ' }';
		}

		// Global row margins
		$css .= '.fl-row-content-wrap { margin: '. $global_settings->row_margins .'px; }';

		// Global row padding
		$css .= '.fl-row-content-wrap { padding: '. $global_settings->row_padding .'px; }';

		// Global row width
		$css .= '.fl-row-fixed-width { max-width: '. $global_settings->row_width .'px; }';

		// Global module margins
		$css .= '.fl-module-content { margin: '. $global_settings->module_margins .'px; }';

		// Loop through rows
		foreach($nodes['rows'] as $row) {

			// Instance row css
			ob_start();
			include FL_BUILDER_DIR . 'includes/row-css.php';
			$css .= ob_get_clean();

			// Instance row margins
			$css .= self::render_row_margins($row);

			// Instance row padding
			$css .= self::render_row_padding($row);
		}
		
		// Loop through the columns.
		foreach($nodes['columns'] as $col) {
			
			// Instance column css
			ob_start();
			include FL_BUILDER_DIR . 'includes/column-css.php';
			$css .= ob_get_clean();

			// Instance column margins
			$css .= self::render_column_margins($col);

			// Instance column padding
			$css .= self::render_column_padding($col);

			// Get the modules in this column.
			$modules = FLBuilderModel::get_modules($col);
		}
		
		// Loop through the modules.
		foreach($nodes['modules'] as $module) {

			// Global module css
			$file = $module->dir . 'css/frontend.css';
			$file_responsive = $module->dir . 'css/frontend.responsive.css';

			// Only include global module css that hasn't been included yet.
			if(!in_array($module->settings->type, $compiled)) {

				// Add to the compiled array so we don't include it again.
				$compiled[] = $module->settings->type;

				// Get the standard module css.
				if(file_exists($file)) {
					$css .= file_get_contents($file);
				}

				// Get the responsive module css.
				if($global_settings->responsive_enabled && file_exists($file_responsive)) {
					$css .= '@media (max-width: '. $global_settings->responsive_breakpoint .'px) { ';
					$css .= file_get_contents($file_responsive);
					$css .= ' }';
				}
			}

			// Instance module css
			$file       = $module->dir . 'includes/frontend.css.php';
			$settings   = $module->settings;
			$id         = $module->node;

			if(file_exists($file)) {
				ob_start();
				include $file;
				$css .= ob_get_clean();
			}

			// Instance module margins
			$css .= self::render_module_margins($module);
			
			if ( ! isset( $global_settings->auto_spacing ) || $global_settings->auto_spacing ) {
				$css .= self::render_responsive_module_margins($module);
			}
		}

		// Default page heading
		if($post && !$global_settings->show_default_heading && !empty($global_settings->default_heading_selector)) {
			if ( $post->post_type == 'page' ) {
				$css .= '.page ' . $global_settings->default_heading_selector . ' { display:none; }';
			}
			else if ( $post->post_type == 'fl-builder-template' ) {
				$css .= '.single-fl-builder-template ' . $global_settings->default_heading_selector . ' { display:none; }';	
			}
		}
		
		// Custom Global CSS
		if ( 'published' == $node_status ) {
			$css .= $global_settings->css;
		}
		
		// Custom Global Nodes CSS
		$css .= self::render_global_nodes_custom_code( 'css' );
		
		// Custom Layout CSS
		if ( 'published' == $node_status ) {
			$css .= FLBuilderModel::get_layout_settings()->css;
		}

		// Save the css
		if(!empty($css)) {
			
			$css = apply_filters( 'fl_builder_render_css', $css, $nodes, $global_settings );
			
			if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
				$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
				$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
			}
			
			file_put_contents($asset_info['css'], $css);
			
			do_action( 'fl_builder_after_render_css' );
		}
	}

	/**
	 * Forcing HTTPS in URLs when `FLBuilderModel::is_ssl()` returns TRUE
	 *
	 * @since 1.7.6
	 * @param string $content A string where the URLs will be modified.
	 * @return string String with SSL ready URLs.
	 */
	static public function rewrite_css_cache_urls( $content )
	{
		if ( FLBuilderModel::is_ssl() ) {
			$content = str_ireplace( 'http:', 'https:', $content );
		}
		
		return $content;
	}

	/**
	 * Renders the CSS margins for a row.
	 *
	 * @since 1.0
	 * @param object $row A row node object.
	 * @return string The row CSS margins string.
	 */
	static public function render_row_margins($row)
	{
		$settings   = $row->settings;
		$margins    = '';
		$css        = '';

		if($settings->margin_top != '') {
			$margins    .= 'margin-top:'    . $settings->margin_top . 'px;';
		}
		if($settings->margin_bottom != '') {
			$margins    .= 'margin-bottom:' . $settings->margin_bottom . 'px;';
		}
		if($settings->margin_left != '') {
			$margins    .= 'margin-left:'   . $settings->margin_left . 'px;';
		}
		if($settings->margin_right != '') {
			$margins    .= 'margin-right:'  . $settings->margin_right . 'px;';
		}
		if($margins != '') {
			$css .= '.fl-node-' . $row->node . ' .fl-row-content-wrap {' . $margins . '}';
		}

		return $css;
	}

	/**
	 * Renders the CSS padding for a row.
	 *
	 * @since 1.0
	 * @param object $row A row node object.
	 * @return string The row CSS padding string.
	 */
	static public function render_row_padding($row)
	{
		$settings = $row->settings;
		$padding  = '';
		$css      = '';

		if($settings->padding_top != '') {
			$padding .= 'padding-top:' . $settings->padding_top . 'px;';
		}
		if($settings->padding_bottom != '') {
			$padding .= 'padding-bottom:' . $settings->padding_bottom . 'px;';
		}
		if($settings->padding_left != '') {
			$padding .= 'padding-left:' . $settings->padding_left . 'px;';
		}
		if($settings->padding_right != '') {
			$padding .= 'padding-right:' . $settings->padding_right . 'px;';
		}
		if($padding != '') {
			$css = '.fl-node-' . $row->node . ' .fl-row-content-wrap {' . $padding . '}';
		}

		return $css;
	}

	/**
	 * Renders the CSS margins for a column.
	 *
	 * @since 1.0
	 * @param object $col A column node object.
	 * @return string The column CSS margins string.
	 */
	static public function render_column_margins($col)
	{
		$settings   = $col->settings;
		$margins    = '';
		$css        = '';

		if($settings->margin_top != '') {
			$margins    .= 'margin-top:'    . $settings->margin_top . 'px;';
		}
		if($settings->margin_bottom != '') {
			$margins    .= 'margin-bottom:' . $settings->margin_bottom . 'px;';
		}
		if($settings->margin_left != '') {
			$margins    .= 'margin-left:'   . $settings->margin_left . 'px;';
		}
		if($settings->margin_right != '') {
			$margins    .= 'margin-right:'  . $settings->margin_right . 'px;';
		}
		if($margins != '') {
			$css .= '.fl-node-' . $col->node . ' .fl-col-content {' . $margins . '}';
		}

		return $css;
	}

	/**
	 * Renders the CSS padding for a column.
	 *
	 * @since 1.0
	 * @param object $col A column node object.
	 * @return string The column CSS padding string.
	 */
	static public function render_column_padding($col)
	{
		$settings = $col->settings;
		$padding  = '';
		$css      = '';

		if($settings->padding_top != '') {
			$padding .= 'padding-top:' . $settings->padding_top . 'px;';
		}
		if($settings->padding_bottom != '') {
			$padding .= 'padding-bottom:' . $settings->padding_bottom . 'px;';
		}
		if($settings->padding_left != '') {
			$padding .= 'padding-left:' . $settings->padding_left . 'px;';
		}
		if($settings->padding_right != '') {
			$padding .= 'padding-right:' . $settings->padding_right . 'px;';
		}
		if($padding != '') {
			$css = '.fl-node-' . $col->node . ' .fl-col-content {' . $padding . '}';
		}

		return $css;
	}

	/**
	 * Renders the CSS margins for a module.
	 *
	 * @since 1.0
	 * @param object $module A module node object.
	 * @return string The module CSS margins string.
	 */
	static public function render_module_margins($module)
	{
		$settings  = $module->settings;
		$margins   = '';
		$css       = '';

		if($settings->margin_top != '') {
			$margins .= 'margin-top:' . $settings->margin_top . 'px;';
		}
		if($settings->margin_bottom != '') {
			$margins .= 'margin-bottom:' . $settings->margin_bottom . 'px;';
		}
		if($settings->margin_left != '') {
			$margins .= 'margin-left:' . $settings->margin_left . 'px;';
		}
		if($settings->margin_right != '') {
			$margins .= 'margin-right:' . $settings->margin_right . 'px;';
		}
		if($margins != '') {
			$css = '.fl-node-' . $module->node . ' .fl-module-content {' . $margins . '}';
		}

		return $css;
	}

	/**
	 * Renders the responsive CSS margins for a module.
	 *
	 * @since 1.0
	 * @param object $module A module node object.
	 * @return string The module CSS margins string.
	 */
	static public function render_responsive_module_margins($module)
	{
		$global_settings    = FLBuilderModel::get_global_settings();
		$default            = $global_settings->module_margins;
		$settings           = $module->settings;
		$margins            = '';
		$css                = '';

		if($settings->margin_top != '' && ($settings->margin_top > $default || $settings->margin_top < 0)) {
			$margins .= 'margin-top:' . $default . 'px;';
		}
		if($settings->margin_bottom != '' && ($settings->margin_bottom > $default || $settings->margin_bottom < 0)) {
			$margins .= 'margin-bottom:' . $default . 'px;';
		}
		if($settings->margin_left != '' && ($settings->margin_left > $default || $settings->margin_left < 0)) {
			$margins .= 'margin-left:' . $default . 'px;';
		}
		if($settings->margin_right != '' && ($settings->margin_right > $default || $settings->margin_right < 0)) {
			$margins .= 'margin-right:' . $default . 'px;';
		}
		if($margins != '') {
			$css .= '@media (max-width: '. $global_settings->responsive_breakpoint .'px) { ';
			$css .= '.fl-node-' . $module->node . ' .fl-module-content {' . $margins . '}';
			$css .= ' }';
		}

		return $css;
	}

	/**
	 * Renders and caches the JavaScript for a builder layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_js()
	{
		// Delete the old file.
		FLBuilderModel::delete_asset_cache('js');

		// Get info on the new file.
		$nodes 		   		= FLBuilderModel::get_categorized_nodes();
		$global_settings    = FLBuilderModel::get_global_settings();
		$layout_settings 	= FLBuilderModel::get_layout_settings();
		$rows          		= FLBuilderModel::get_nodes('row');
		$asset_info    		= FLBuilderModel::get_asset_info();
		$compiled      		= array();
		$js            		= '';
		
		// Layout config object.
		ob_start();
		include FL_BUILDER_DIR . 'includes/layout-js-config.php';
		$js .= ob_get_clean();

		// Main JS
		$js .= file_get_contents(FL_BUILDER_DIR . 'js/fl-builder-layout.js');

		// Loop through the rows.
		foreach($nodes['rows'] as $row) {
			$js .= self::render_row_js( $row );
		}
		
		// Loop through the modules.
		foreach($nodes['modules'] as $module) {
			$js .= self::render_module_js( $module, $compiled );
		}
		
		// Add the global and layout settings JS.
		$js .= $global_settings->js;
		$js .= self::render_global_nodes_custom_code( 'js' );
		$js .= $layout_settings->js;

		// Add the path legacy vars (FLBuilderLayoutConfig.paths should be used instead).
		$js .= "var wpAjaxUrl = '" . admin_url('admin-ajax.php') . "';";
		$js .= "var flBuilderUrl = '" . FL_BUILDER_URL . "';";

		// Call the FLBuilder._renderLayoutComplete method if we're currently editing.
		if(stristr($asset_info['js'], '-draft.js') || stristr($asset_info['js'], '-preview.js')) {
			$js .= "; if(typeof FLBuilder !== 'undefined' && typeof FLBuilder._renderLayoutComplete !== 'undefined') FLBuilder._renderLayoutComplete();";
		}

		// Include FLJSMin
		if(!class_exists('FLJSMin')) {
			include FL_BUILDER_DIR . 'classes/class-fl-jsmin.php';
		}

		// Save the js
		if(!empty($js)) {
			
			$js = apply_filters( 'fl_builder_render_js', $js, $nodes, $global_settings );
			
			if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
				$js = FLJSMin::minify( $js );
			}
			
			file_put_contents($asset_info['js'], $js);
			
			do_action( 'fl_builder_after_render_js' );
		}
	}

	/**
	 * Renders the JavaScript for a single row.
	 *
	 * @since 1.7
	 * @param string|object $row_id A row ID or object.
	 * @return string
	 */
	static public function render_row_js( $row_id )
	{
		$row 		= is_object( $row_id ) ? $row_id : FLBuilderModel::get_node( $row_id );
		$settings   = $row->settings;
		$id         = $row->node;

		ob_start();
		include FL_BUILDER_DIR . 'includes/row-js.php';
		return ob_get_clean();
	}

	/**
	 * Renders the JavaScript for all modules in a single row.
	 *
	 * @since 1.7
	 * @param string|object $row_id A row ID or object.
	 * @return string
	 */
	static public function render_row_modules_js( $row_id )
	{
		$row 				= is_object( $row_id ) ? $row_id : FLBuilderModel::get_node( $row_id );
		$nodes 				= FLBuilderModel::get_categorized_nodes();
		$template_post_id 	= FLBuilderModel::is_node_global( $row );
		$compiled 			= array();
		$js					= '';

		// Render the JS.
		foreach( $nodes['groups'] as $group ) {
			if ( $row->node == $group->parent || ( $template_post_id && $row->template_node_id == $group->parent ) ) {
				foreach( $nodes['columns'] as $column ) {
					if ( $group->node == $column->parent ) {
						foreach( $nodes['modules'] as $module ) {
							if ( $column->node == $module->parent ) {
								$js .= self::render_module_js( $module, $compiled );
							}
						}
					}
				}
			}
		}
		
		// Return the JS.
		return $js;
	}

	/**
	 * Renders the JavaScript for all modules in a single column.
	 *
	 * @since 1.7
	 * @param string|object $col_id A column ID or object.
	 * @return string
	 */
	static public function render_column_modules_js( $col_id )
	{
		$col 		= is_object( $col_id ) ? $col_id : FLBuilderModel::get_node( $col_id );
		$nodes 		= FLBuilderModel::get_categorized_nodes();
		$compiled 	= array();
		$js			= '';
		
		// Render the JS.
		foreach( $nodes['modules'] as $module ) {
			if ( $col->node == $module->parent ) {
				$js .= self::render_module_js( $module, $compiled );
			}
		}
		
		// Return the JS.
		return $js;
	}

	/**
	 * Renders the JavaScript for a single module.
	 *
	 * @since 1.7
	 * @param string|object $module_id A module ID or object.
	 * @param array $compiled An array of module types that have already has frontend.js compiled.
	 * @return string
	 */
	static public function render_module_js( $module_id, &$compiled = array() )
	{
		$module 			= is_object( $module_id ) ? $module_id : FLBuilderModel::get_module( $module_id );
		$global_settings    = FLBuilderModel::get_global_settings();
		$js     			= '';
		
		// Global module JS
		$file = $module->dir . 'js/frontend.js';

		if ( file_exists( $file ) && ! in_array( $module->settings->type, $compiled ) ) {
			$js .= "\n" . file_get_contents( $file );
			$compiled[] = $module->settings->type;
		}

		// Instance module JS
		$file       = $module->dir . 'includes/frontend.js.php';
		$settings   = $module->settings;
		$id         = $module->node;

		if ( file_exists( $file ) ) {
			ob_start();
			include $file;
			$js .= ob_get_clean();
		}
		
		// Return the JS.
		return $js;
	}

	/**
	 * Renders the custom CSS or JS for all global nodes in a layout. 
	 *
	 * @since 1.7
	 */
	static public function render_global_nodes_custom_code( $type = 'css' )
	{
		$code 		 = '';
		$rendered 	 = array();
		
		if ( ! FLBuilderModel::is_post_node_template() ) {
			
			$nodes 		 = FLBuilderModel::get_layout_data();
			$node_status = FLBuilderModel::get_node_status();
			
			foreach( $nodes as $node_id => $node ) {
				
				$template_post_id = FLBuilderModel::is_node_global( $node );
				
				if ( $template_post_id && ! in_array( $template_post_id, $rendered ) ) {
					
					$rendered[] = $template_post_id;
					$code .= FLBuilderModel::get_layout_settings( $node_status, $template_post_id )->{ $type };
				}
			}
		}
		
		return $code;
	}

	/**
	 * Custom logging function that handles objects and arrays.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function log()
	{
		foreach ( func_get_args() as $arg ) {
			ob_start();
			print_r( $arg );
			error_log( ob_get_clean() );
		}
	}

	/**
	 * @since 1.0
	 * @deprecated 1.7.4
	 */
	static public function layout_styles_scripts( $post_id )
	{
		_deprecated_function( __METHOD__, '1.7.4', __CLASS__ . '::enqueue_layout_styles_scripts()' );
		
		self::enqueue_layout_styles_scripts( $post_id );
	}

	/**
	 * @since 1.0
	 * @deprecated 1.7.4
	 */
	static public function styles_scripts()
	{
		_deprecated_function( __METHOD__, '1.7.4', __CLASS__ . '::enqueue_ui_styles_scripts()' );
		
		self::enqueue_ui_styles_scripts();
	}
}
