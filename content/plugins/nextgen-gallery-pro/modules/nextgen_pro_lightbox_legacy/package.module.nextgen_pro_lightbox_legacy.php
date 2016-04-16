<?php
class A_NextGen_Pro_Lightboxy_Legacy_Ajax extends Mixin
{
    /**
     * Provides a Galleria-formatted JSON array of get_included_entities() results
     */
    public function pro_lightbox_load_images_action()
    {
        $retval = array();
        if ($id = $this->param('id')) {
            $displayed_gallery_mapper = C_Displayed_Gallery_Mapper::get_instance();
            if ($this->param('lang', NULL, FALSE)) {
                if (class_exists('SitePress')) {
                    global $sitepress;
                    $sitepress->switch_lang($this->param('lang'));
                }
            }
            // Fetch ATP galleries or build our displayed gallery by parameters
            if (is_numeric($id)) {
                $displayed_gallery = $displayed_gallery_mapper->find($id, TRUE);
            } else {
                $factory = C_Component_Factory::get_instance();
                $displayed_gallery = $factory->create('displayed_gallery', $this->param('gallery'), $displayed_gallery_mapper);
            }
            if ($displayed_gallery) {
                $settings = C_NextGen_Settings::get_instance()->get('ngg_pro_lightbox');
                $retval = M_NextGen_Pro_Lightbox_Legacy::parse_entities_for_galleria($displayed_gallery->get_entities(FALSE, $settings['localize_limit']));
            }
        }
        return $retval;
    }
}
class A_NextGen_Pro_Lightbox_Effect_Code extends Mixin
{
    static $galleries_displayed = array();
    public function get_effect_code($displayed_gallery)
    {
        $retval = $this->call_parent('get_effect_code', $displayed_gallery);
        if (C_NextGen_Settings::get_instance()->thumbEffect == NGG_PRO_LIGHTBOX) {
            $retval = str_replace('%PRO_LIGHTBOX_GALLERY_ID%', $displayed_gallery->id(), $retval);
            $mapper = C_Lightbox_Library_Mapper::get_instance();
            $lightbox = $mapper->find_by_name(NGG_PRO_LIGHTBOX);
            if ($lightbox->display_settings['display_comments']) {
                $retval .= ' data-nplmodal-show-comments="1"';
            }
        }
        return $retval;
    }
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        if (C_NextGen_Settings::get_instance()->thumbEffect == NGG_PRO_LIGHTBOX && !in_array($displayed_gallery->id(), self::$galleries_displayed)) {
            // prevent calling get_included_entities() more than once
            self::$galleries_displayed[] = $displayed_gallery->id();
            foreach (M_NextGen_Pro_Lightbox_Legacy::get_components() as $name => $handler) {
                $handler = new $handler();
                $handler->name = $name;
                $handler->displayed_gallery = $displayed_gallery;
                $handler->enqueue_static_resources();
            }
            $mapper = C_Lightbox_Library_Mapper::get_instance();
            $lightbox = $mapper->find_by_name(NGG_PRO_LIGHTBOX);
            // localize the gallery images for startup performance
            $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.images_list', M_NextGen_Pro_Lightbox_Legacy::parse_entities_for_galleria($displayed_gallery->get_entities($lightbox->display_settings['localize_limit'])), FALSE);
            // inform the lightbox js it needs to do an ajax request to load the rest of the gallery
            $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.images_list_limit_reached', $displayed_gallery->get_entity_count() > $lightbox->display_settings['localize_limit'] ? TRUE : FALSE, FALSE);
        }
    }
}
class A_NextGen_Pro_Lightbox_Form extends A_Lightbox_Library_Form
{
    public function get_model()
    {
        return $this->object->get_registry()->get_utility('I_Lightbox_Library_Mapper')->find_by_name(NGG_PRO_LIGHTBOX, TRUE);
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script('photocrati-nextgen_pro_lightbox_legacy_settings-js', $this->get_static_url('photocrati-nextgen_pro_lightbox_legacy#settings.js'), array('jquery.nextgen_radio_toggle'));
    }
    /**
     * Returns a list of fields to render on the settings page
     */
    public function _get_field_names()
    {
        return array('nextgen_pro_lightbox_router_slug', 'nextgen_pro_lightbox_icon_color', 'nextgen_pro_lightbox_icon_background_enabled', 'nextgen_pro_lightbox_icon_background_rounded', 'nextgen_pro_lightbox_icon_background', 'nextgen_pro_lightbox_overlay_icon_color', 'nextgen_pro_lightbox_sidebar_button_color', 'nextgen_pro_lightbox_sidebar_button_background', 'nextgen_pro_lightbox_carousel_text_color', 'nextgen_pro_lightbox_background_color', 'nextgen_pro_lightbox_sidebar_background_color', 'nextgen_pro_lightbox_carousel_background_color', 'nextgen_pro_lightbox_image_pan', 'nextgen_pro_lightbox_interaction_pause', 'nextgen_pro_lightbox_enable_routing', 'nextgen_pro_lightbox_enable_sharing', 'nextgen_pro_lightbox_enable_comments', 'nextgen_pro_lightbox_display_comments', 'nextgen_pro_lightbox_display_captions', 'nextgen_pro_lightbox_display_carousel', 'nextgen_pro_lightbox_localize_limit', 'nextgen_pro_lightbox_transition_speed', 'nextgen_pro_lightbox_slideshow_speed', 'nextgen_pro_lightbox_style', 'nextgen_pro_lightbox_transition_effect', 'nextgen_pro_lightbox_touch_transition_effect', 'nextgen_pro_lightbox_image_crop');
    }
    /**
     * Renders the 'slug' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    public function _render_nextgen_pro_lightbox_router_slug_field($lightbox)
    {
        return $this->_render_text_field($lightbox, 'router_slug', __('Router slug', 'nextgen-gallery-pro'), $lightbox->display_settings['router_slug'], __('Used to route JS actions to the URL', 'nextgen-gallery-pro'));
    }
    /**
     * Renders the lightbox 'icon color' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    public function _render_nextgen_pro_lightbox_icon_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'icon_color', __('Icon color', 'nextgen-gallery-pro'), $lightbox->display_settings['icon_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_icon_background_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'icon_background', __('Icon background', 'nextgen-gallery-pro'), $lightbox->display_settings['icon_background'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'), empty($lightbox->display_settings['icon_background_enabled']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_lightbox_icon_background_enabled_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'icon_background_enabled', __('Display background on carousel icons', 'nextgen-gallery-pro'), $lightbox->display_settings['icon_background_enabled']);
    }
    public function _render_nextgen_pro_lightbox_icon_background_rounded_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'icon_background_rounded', __('Display rounded background on carousel icons', 'nextgen-gallery-pro'), $lightbox->display_settings['icon_background_rounded'], '', empty($lightbox->display_settings['icon_background_enabled']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_lightbox_overlay_icon_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'overlay_icon_color', __('Floating elements color', 'nextgen-gallery-pro'), $lightbox->display_settings['overlay_icon_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_sidebar_button_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'sidebar_button_color', __('Sidebar button text color', 'nextgen-gallery-pro'), $lightbox->display_settings['sidebar_button_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_sidebar_button_background_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'sidebar_button_background', __('Sidebar button background', 'nextgen-gallery-pro'), $lightbox->display_settings['sidebar_button_background'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_carousel_text_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'carousel_text_color', __('Carousel text color', 'nextgen-gallery-pro'), $lightbox->display_settings['carousel_text_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_background_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'background_color', __('Background color', 'nextgen-gallery-pro'), $lightbox->display_settings['background_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_carousel_background_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'carousel_background_color', __('Carousel background color', 'nextgen-gallery-pro'), $lightbox->display_settings['carousel_background_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_sidebar_background_color_field($lightbox)
    {
        return $this->_render_color_field($lightbox, 'sidebar_background_color', __('Sidebar background color', 'nextgen-gallery-pro'), $lightbox->display_settings['sidebar_background_color'], __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_image_pan_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'image_pan', __('Pan cropped images', 'nextgen-gallery-pro'), $lightbox->display_settings['image_pan'], __('When enabled images can be panned with the mouse', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_interaction_pause_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'interaction_pause', __('Pause on interaction', 'nextgen-gallery-pro'), $lightbox->display_settings['interaction_pause'], __('When enabled image display will be paused if the user presses a thumbnail or any navigational link', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_enable_routing_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'enable_routing', __('Enable browser routing', 'nextgen-gallery-pro'), $lightbox->display_settings['enable_routing'], __('Necessary for commenting to be enabled', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_enable_sharing_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'enable_sharing', __('Enable sharing', 'nextgen-gallery-pro'), $lightbox->display_settings['enable_sharing'], __('When enabled social-media sharing icons will be displayed', 'nextgen-gallery-pro'), empty($lightbox->display_settings['enable_routing']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_lightbox_enable_comments_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'enable_comments', __('Enable comments', 'nextgen-gallery-pro'), $lightbox->display_settings['enable_comments'], '', empty($lightbox->display_settings['enable_routing']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_lightbox_display_comments_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'display_comments', __('Display comments', 'nextgen-gallery-pro'), $lightbox->display_settings['display_comments'], __('When on the commenting sidebar will be opened at startup', 'nextgen-gallery-pro'), empty($lightbox->display_settings['enable_comments']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_lightbox_display_captions_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'display_captions', __('Display captions', 'nextgen-gallery-pro'), $lightbox->display_settings['display_captions'], __('When on the captions toolbar will be opened at startup', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_display_carousel_field($lightbox)
    {
        return $this->_render_radio_field($lightbox, 'display_carousel', __('Display carousel', 'nextgen-gallery-pro'), $lightbox->display_settings['display_carousel'], __('When disabled the navigation carousel will be docked and hidden offscreen at startup', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_localize_limit_field($lightbox)
    {
        return $this->_render_number_field($lightbox, 'localize_limit', __('Localize limit', 'nextgen-gallery-pro'), $lightbox->display_settings['localize_limit'], __('For performance gallery images are localized as javascript. Galleries with more images this limit will make an AJAX call to load the rest at startup. Set to 0 to include every image in displayed galleries.', 'nextgen-gallery-pro'), FALSE, '#', 0);
    }
    public function _render_nextgen_pro_lightbox_transition_speed_field($lightbox)
    {
        return $this->_render_number_field($lightbox, 'transition_speed', __('Transition speed', 'nextgen-gallery-pro'), $lightbox->display_settings['transition_speed'], __('Measured in seconds', 'nextgen-gallery-pro'), FALSE, __('seconds', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_lightbox_slideshow_speed_field($lightbox)
    {
        return $this->_render_number_field($lightbox, 'slideshow_speed', __('Slideshow speed', 'nextgen-gallery-pro'), $lightbox->display_settings['slideshow_speed'], __('Measured in seconds', 'nextgen-gallery-pro'), FALSE, __('seconds', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_lightbox_style_field($lightbox)
    {
        $available_styles = array('' => __('Default: a dark theme', 'nextgen-gallery-pro'), 'black' => __('All black: Removes borders from the comments panel', 'nextgen-gallery-pro'), 'white' => __('All white: A white based theme', 'nextgen-gallery-pro'));
        $lightbox->display_settings['style'] = str_replace('.css', '', $lightbox->display_settings['style']);
        return $this->_render_select_field($lightbox, 'style', __('Style', 'nextgen-gallery-pro'), $available_styles, $lightbox->display_settings['style'], __('Preset styles to customize the display. Selecting an option may reset some color fields', 'nextgen-gallery-pro'));
    }
    public function get_effect_options()
    {
        return array('fade' => __('Crossfade betweens images', 'nextgen-gallery-pro'), 'flash' => __('Fades into background color between images', 'nextgen-gallery-pro'), 'pulse' => __('Quickly removes the image into background color, then fades the next image', 'nextgen-gallery-pro'), 'slide' => __('Slides the images depending on image position', 'nextgen-gallery-pro'), 'fadeslide' => __('Fade between images and slide slightly at the same time', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_transition_effect_field($lightbox)
    {
        return $this->_render_select_field($lightbox, 'transition_effect', __('Transition effect', 'nextgen-gallery-pro'), $this->get_effect_options(), $lightbox->display_settings['transition_effect']);
    }
    public function _render_nextgen_pro_lightbox_touch_transition_effect_field($lightbox)
    {
        return $this->_render_select_field($lightbox, 'touch_transition_effect', __('Touch transition effect', 'nextgen-gallery-pro'), $this->get_effect_options(), $lightbox->display_settings['touch_transition_effect'], __('The transition to use on touch devices if the default transition is too intense', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_lightbox_image_crop_field($lightbox)
    {
        return $this->_render_select_field($lightbox, 'image_crop', __('Crop image display', 'nextgen-gallery-pro'), array('true' => __('Images will be scaled to fill the display, centered and cropped', 'nextgen-gallery-pro'), 'false' => __('Images will be scaled down until the entire image fits', 'nextgen-gallery-pro'), 'height' => __('Images will scale to fill the height of the display', 'nextgen-gallery-pro'), 'width' => __('Images will scale to fill the width of the display', 'nextgen-gallery-pro'), 'landscape' => __('Landscape images will fill the display, but scale portraits to fit', 'nextgen-gallery-pro'), 'portrait' => __('Portrait images will fill the display, but scale landscapes to fit', 'nextgen-gallery-pro')), $lightbox->display_settings['image_crop']);
    }
}
class A_Nextgen_Pro_Lightbox_Resources extends Mixin
{
    protected static $run_once = FALSE;
    public function enqueue_lightbox_resources($displayed_gallery = FALSE)
    {
        $this->call_parent('enqueue_lightbox_resources', $displayed_gallery);
        $this->enqueue_pro_lightbox_resources($displayed_gallery);
    }
    public function enqueue_pro_lightbox_resources($displayed_gallery = FALSE)
    {
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->thumbEffect == NGG_PRO_LIGHTBOX) {
            $router = C_Router::get_instance();
            if (!self::$run_once) {
                // ensure the gallery exists
                if ($displayed_gallery && $displayed_gallery->id()) {
                    $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.wordpress_page_root', get_permalink(), FALSE);
                }
                wp_enqueue_script('underscore');
                wp_enqueue_script('backbone');
                wp_enqueue_script('velocity', $router->get_static_url('photocrati-nextgen_pro_lightbox_legacy#velocity.min.js'));
                wp_enqueue_script('galleria', $router->get_static_url('photocrati-galleria#galleria-1.4.2.min.js'));
                wp_enqueue_style('ngg_pro_lightbox_theme_css', $router->get_static_url('photocrati-nextgen_pro_lightbox_legacy#theme/galleria.nextgen_pro_lightbox.css'));
                wp_enqueue_script('ngg_pro_lightbox_theme_js', $router->get_static_url('photocrati-nextgen_pro_lightbox_legacy#theme/galleria.nextgen_pro_lightbox.js'), 'galleria');
                if (!wp_style_is('fontawesome', 'registered')) {
                    C_Display_Type_Controller::get_instance()->enqueue_displayed_gallery_trigger_buttons_resources();
                }
                wp_enqueue_style('fontawesome');
                // retrieve the lightbox so we can examine its settings
                $mapper = C_Lightbox_Library_Mapper::get_instance();
                $library = $mapper->find_by_name(NGG_PRO_LIGHTBOX, TRUE);
                $library->display_settings += array('is_front_page' => is_front_page() ? 1 : 0, 'share_url' => $router->get_url('/nextgen-share/{gallery_id}/{image_id}/{named_size}', TRUE, 'root'), 'protect_images' => !empty($settings->protect_images) ? TRUE : FALSE, 'style' => str_replace('.css', '', $library->display_settings['style']), 'i18n' => array('toggle_social_sidebar' => __('Toggle social sidebar', 'nextgen-gallery-pro'), 'play_pause' => __('Play / Pause', 'nextgen-gallery-pro'), 'toggle_fullscreen' => __('Toggle fullscreen', 'nextgen-gallery-pro'), 'toggle_image_info' => __('Toggle image info', 'nextgen-gallery-pro'), 'close_window' => __('Close window', 'nextgen-gallery-pro'), 'share' => array('twitter' => __('Share on Twitter', 'nextgen-gallery-pro'), 'googlep' => __('Share on Google+', 'nextgen-gallery-pro'), 'facebook' => __('Share on Facebook', 'nextgen-gallery-pro'), 'pinterest' => __('Share on Pinterest', 'nextgen-gallery-pro'))));
                // provide the current language so ajax requests can request translations in the same locale
                if (defined('ICL_LANGUAGE_CODE')) {
                    $library->display_settings['lang'] = $router->param('lang', NULL, FALSE) ? $router->param('lang') : ICL_LANGUAGE_CODE;
                }
                wp_localize_script('photocrati_ajax', 'nplModalSettings', $library->display_settings);
            }
            self::$run_once = TRUE;
        }
    }
}
class A_NextGen_Pro_Lightbox_Triggers_Form extends Mixin
{
    public function _get_field_names()
    {
        $ret = $this->call_parent('_get_field_names');
        $ret[] = 'nextgen_pro_lightbox_triggers_display';
        return $ret;
    }
    public function _render_nextgen_pro_lightbox_triggers_display_field($display_type)
    {
        return $this->_render_select_field($display_type, 'ngg_triggers_display', __('Display Triggers', 'nextgen-gallery-pro'), array('always' => __('Always', 'nextgen-gallery-pro'), 'exclude_mobile' => __('Exclude Small Screens', 'nextgen-gallery-pro'), 'never' => __('Never', 'nextgen-gallery-pro')), isset($display_type->settings['ngg_triggers_display']) ? $display_type->settings['ngg_triggers_display'] : 'always');
    }
    public function _render_nextgen_pro_lightbox_triggers_style_field($display_type)
    {
        return $this->_render_select_field($display_type, 'ngg_triggers_style', __('Triggers Style', 'nextgen-gallery-pro'), array('plain' => __('Plain', 'nextgen-gallery-pro'), 'fancy' => __('Fancy', 'nextgen-gallery-pro')), isset($display_type->settings['ngg_triggers_style']) ? $display_type->settings['ngg_triggers_style'] : 'plain');
    }
}
class A_Pro_Lightbox_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_LIGHTBOX) {
            $this->object->_set_default_value($entity, 'display_settings', 'background_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'enable_routing', 1);
            $this->object->_set_default_value($entity, 'display_settings', 'icon_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'icon_background', '');
            $this->object->_set_default_value($entity, 'display_settings', 'icon_background_enabled', '0');
            $this->object->_set_default_value($entity, 'display_settings', 'icon_background_rounded', '1');
            $this->object->_set_default_value($entity, 'display_settings', 'overlay_icon_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'sidebar_button_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'sidebar_button_background', '');
            $this->object->_set_default_value($entity, 'display_settings', 'router_slug', 'gallery');
            $this->object->_set_default_value($entity, 'display_settings', 'carousel_background_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'carousel_text_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'enable_comments', 1);
            $this->object->_set_default_value($entity, 'display_settings', 'enable_sharing', 1);
            $this->object->_set_default_value($entity, 'display_settings', 'display_comments', 0);
            $this->object->_set_default_value($entity, 'display_settings', 'display_captions', 0);
            $this->object->_set_default_value($entity, 'display_settings', 'display_carousel', 1);
            $this->object->_set_default_value($entity, 'display_settings', 'localize_limit', 100);
            $this->object->_set_default_value($entity, 'display_settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'display_settings', 'image_pan', 0);
            $this->object->_set_default_value($entity, 'display_settings', 'interaction_pause', 1);
            $this->object->_set_default_value($entity, 'display_settings', 'sidebar_background_color', '');
            $this->object->_set_default_value($entity, 'display_settings', 'slideshow_speed', '5');
            $this->object->_set_default_value($entity, 'display_settings', 'style', '');
            $this->object->_set_default_value($entity, 'display_settings', 'touch_transition_effect', 'slide');
            $this->object->_set_default_value($entity, 'display_settings', 'transition_effect', 'slide');
            $this->object->_set_default_value($entity, 'display_settings', 'transition_speed', '0.4');
        }
    }
}
class C_NextGen_Pro_Lightbox_Trigger extends C_Displayed_Gallery_Trigger
{
    static $_pro_lightbox_enabled = NULL;
    static $_pro_lightbox = NULL;
    public function get_css_class()
    {
        $classes = 'fa ngg-trigger nextgen_pro_lightbox';
        if ($this->name == NGG_PRO_LIGHTBOX_TRIGGER) {
            return $classes . ' fa-share-square';
        } else {
            return $classes . ' fa-comment';
        }
    }
    static function are_triggers_enabled($displayed_gallery)
    {
        return isset($displayed_gallery->display_settings['ngg_triggers_display']) && $displayed_gallery->display_settings['ngg_triggers_display'] != 'never';
    }
    static function is_renderable($name, $displayed_gallery)
    {
        $retval = FALSE;
        // Both of these triggers require the Pro Lightbox to be configured as the lightbox effect
        if (self::are_triggers_enabled($displayed_gallery) && self::is_pro_lightbox_enabled() && self::does_source_return_images($displayed_gallery)) {
            // If comments are enabled, display the trigger button to open the comments sidebar
            if ($name == NGG_PRO_LIGHTBOX_COMMENT_TRIGGER) {
                $library = self::get_pro_lightbox();
                if (isset($library->display_settings['enable_comments']) && $library->display_settings['enable_comments']) {
                    $retval = TRUE;
                }
            } else {
                $retval = TRUE;
            }
        }
        return $retval;
    }
    static function does_source_return_images($displayed_gallery)
    {
        $retval = FALSE;
        if (($source = $displayed_gallery->get_source()) && in_array('image', $source->returns)) {
            $retval = TRUE;
        }
        return $retval;
    }
    static function is_pro_lightbox_enabled()
    {
        if (is_null(self::$_pro_lightbox_enabled)) {
            $settings = C_NextGen_Settings::get_instance();
            if ($settings->thumbEffect == NGG_PRO_LIGHTBOX) {
                self::$_pro_lightbox_enabled = TRUE;
            } else {
                self::$_pro_lightbox_enabled = FALSE;
            }
        }
        return self::$_pro_lightbox_enabled;
    }
    static function get_pro_lightbox()
    {
        if (is_null(self::$_pro_lightbox)) {
            $mapper = C_Lightbox_Library_Mapper::get_instance();
            self::$_pro_lightbox = $mapper->find_by_name(NGG_PRO_LIGHTBOX);
        }
        return self::$_pro_lightbox;
    }
    public function get_attributes()
    {
        $retval = array('class' => $this->get_css_class(), 'data-nplmodal-gallery-id' => $this->displayed_gallery->id());
        // If we're adding the trigger to an image, then we need
        // to add an attribute for the Pro Lightbox to know which image to display
        if ($this->view->get_id() == 'nextgen_gallery.image') {
            $image = $this->view->get_object();
            $retval['data-image-id'] = $image->{$image->id_field};
        }
        // If we're adding the commenting trigger, then we need to tell the
        // Pro Lightbox to open the sidebar when clicked
        if ($this->name == NGG_PRO_LIGHTBOX_COMMENT_TRIGGER) {
            $retval['data-nplmodal-show-comments'] = 1;
        }
        return $retval;
    }
}
class C_OpenGraph_Controller extends C_MVC_Controller
{
    static $_instances = array();
    /**
     * Returns an instance of the controller in a particular context
     * @param bool $context
     * @return mixed
     */
    static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            $klass = get_class();
            self::$_instances[$context] = new $klass($context);
        }
        return self::$_instances[$context];
    }
    // /nextgen-share/{url}/{slug}
    public function index_action()
    {
        wp_dequeue_script('photocrati_ajax');
        wp_dequeue_script('frame_event_publisher');
        wp_dequeue_script('jquery');
        wp_dequeue_style('nextgen_gallery_related_images');
        $img_mapper = C_Image_Mapper::get_instance();
        $image_id = $this->param('image_id');
        if ($image = $img_mapper->find($image_id)) {
            $displayed_gallery_id = $this->param('displayed_gallery_id');
            // Template parameters
            $params = array('img' => $image);
            // Get the url & dimensions
            $named_size = $this->param('named_size');
            $storage = C_Gallery_Storage::get_instance();
            $dimensions = $storage->get_image_dimensions($image, $named_size);
            $image->url = $storage->get_image_url($image, $named_size, TRUE);
            $image->width = $dimensions['width'];
            $image->height = $dimensions['height'];
            // Generate the lightbox url
            $router = $this->get_router();
            $mapper = $this->get_registry()->get_utility('I_Lightbox_Library_Mapper');
            $lightbox = $mapper->find_by_name(NGG_PRO_LIGHTBOX);
            $uri = urldecode($this->param('uri'));
            $lightbox_slug = $lightbox->display_settings['router_slug'];
            $qs = $this->get_querystring();
            if ($qs) {
                $lightbox_url = $router->get_url('/', FALSE, 'root');
                $lightbox_url .= '?' . $qs;
            } else {
                $lightbox_url = $router->get_url($uri, FALSE, 'root');
                $lightbox_url .= '/';
            }
            // widget galleries shouldn't have a url specific to one image
            if (FALSE !== strpos($displayed_gallery_id, 'widget-ngg-images-')) {
                $image_id = '!';
            }
            $params['lightbox_url'] = "{$lightbox_url}#{$lightbox_slug}/{$displayed_gallery_id}/{$image_id}";
            // Add the blog name
            $params['blog_name'] = get_bloginfo('name');
            // Add routed url
            $protocol = $router->is_https() ? 'https://' : 'http://';
            $params['routed_url'] = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            // Render the opengraph metadata
            $this->expires('+1 day');
            $this->render_view('photocrati-nextgen_pro_lightbox_legacy#opengraph', $params);
        } else {
            header(__('Status: 404 Image not found', 'nextgen-gallery-pro'));
            echo __('Image not found', 'nextgen-gallery-pro');
        }
    }
    /**
     * The querystring contains the URI segment to return to, but possibly other querystring data that should be included
     * in the lightbox url. This function returns the querystring without the return data
     */
    public function get_querystring()
    {
        return preg_replace('/uri=[^&]+&?/', '', $this->get_router()->get_querystring());
    }
}