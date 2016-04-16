<?php
class A_NextGen_Pro_Slideshow extends Mixin
{
}
// TODO: This should be replaced by a dynamic stylesheet adapter
class A_NextGen_Pro_Slideshow_Controller extends A_Galleria_Controller
{
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $router = C_Router::get_instance();
        $displayed_gallery->display_settings['theme'] = 'nextgen_pro_slideshow';
        wp_enqueue_script('ngg_pro_slideshow_theme_js', $router->get_static_url(NGG_PRO_SLIDESHOW . '#theme/galleria.nextgen_pro_slideshow.js'), array('ngg_galleria_init'), '2.0');
        wp_enqueue_style('ngg_pro_slideshow_theme_css', $router->get_static_url(NGG_PRO_SLIDESHOW . '#theme/galleria.nextgen_pro_slideshow.css'), array(), '2.0');
        return C_Display_Type_Controller::get_instance(NGG_PRO_GALLERIA)->enqueue_frontend_resources($displayed_gallery);
    }
}
class A_NextGen_Pro_Slideshow_Form extends Mixin_Display_Type_Form
{
    public function get_display_type_name()
    {
        return NGG_PRO_SLIDESHOW;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script($this->get_display_type_name() . '-js', $this->get_static_url('photocrati-nextgen_pro_slideshow#settings.js'));
        $atp = C_Attach_Controller::get_instance();
        if ($atp != null && $atp->has_method('mark_script')) {
            $atp->mark_script($this->object->get_display_type_name() . '-js');
        }
    }
    /**
     * Returns a list of fields to render on the settings page
     */
    public function _get_field_names()
    {
        return array('nextgen_pro_slideshow_image_crop', 'nextgen_pro_slideshow_image_pan', 'nextgen_pro_slideshow_show_playback_controls', 'nextgen_pro_slideshow_show_captions', 'nextgen_pro_slideshow_caption_class', 'nextgen_pro_slideshow_caption_height', 'nextgen_pro_slideshow_aspect_ratio', 'nextgen_pro_slideshow_width_and_unit', 'nextgen_pro_slideshow_transition', 'nextgen_pro_slideshow_transition_speed', 'nextgen_pro_slideshow_slideshow_speed', 'nextgen_pro_slideshow_border_size', 'nextgen_pro_slideshow_border_color');
    }
    /**
     * A similiar function is available in photocrati-nextgen_admin but has an inappropriate tooltip
     */
    public function _render_nextgen_pro_slideshow_width_and_unit_field($display_type)
    {
        return $this->object->render_partial('photocrati-nextgen_admin#field_generator/nextgen_settings_field_width_and_unit', array('display_type_name' => $display_type->name, 'name' => 'width', 'label' => __('Gallery width', 'nextgen-gallery-pro'), 'value' => $display_type->settings['width'], 'text' => '', 'placeholder' => '', 'unit_name' => 'width_unit', 'unit_value' => $display_type->settings['width_unit'], 'options' => array('px' => __('Pixels', 'nextgen-gallery-pro'), '%' => __('Percent', 'nextgen-gallery-pro'))), TRUE);
    }
    public function _render_nextgen_pro_slideshow_image_crop_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'image_crop', __('Crop images', 'nextgen-gallery-pro'), $display_type->settings['image_crop']);
    }
    public function _render_nextgen_pro_slideshow_image_pan_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'image_pan', __('Pan images', 'nextgen-gallery-pro'), $display_type->settings['image_pan'], '', empty($display_type->settings['image_crop']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_slideshow_show_captions_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'show_captions', __('Show captions', 'nextgen-gallery-pro'), $display_type->settings['show_captions']);
    }
    public function _render_nextgen_pro_slideshow_caption_class_field($display_type)
    {
        return $this->_render_select_field($display_type, 'caption_class', __('Caption location', 'nextgen-gallery-pro'), array('caption_above_stage' => __('Top', 'nextgen-gallery-pro'), 'caption_below_stage' => __('Bottom', 'nextgen-gallery-pro'), 'caption_overlay_top' => __('Top (Overlay)', 'nextgen-gallery-pro'), 'caption_overlay_bottom' => __('Bottom (Overlay)', 'nextgen-gallery-pro')), $display_type->settings['caption_class'], '', empty($display_type->settings['show_captions']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_slideshow_caption_height_field($display_type)
    {
        return $this->_render_number_field($display_type, 'caption_height', __('Caption height', 'nextgen-gallery-pro'), $display_type->settings['caption_height'], __('Measured in pixels', 'nextgen-gallery-pro'), empty($display_type->settings['show_captions']) ? TRUE : FALSE, __('pixels', 'nextgen-gallery-pro'), 1);
    }
    public function _render_nextgen_pro_slideshow_slideshow_speed_field($display_type)
    {
        return $this->_render_number_field($display_type, 'slideshow_speed', __('Slideshow speed', 'nextgen-gallery-pro'), $display_type->settings['slideshow_speed'], __('Measured in seconds', 'nextgen-gallery-pro'), FALSE, __('seconds', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_slideshow_transition_field($display_type)
    {
        return $this->_render_select_field($display_type, 'transition', __('Transition effect', 'nextgen-gallery-pro'), array('fade' => __('Crossfade between images', 'nextgen-gallery-pro'), 'flash' => __('Fades into background color between images', 'nextgen-gallery-pro'), 'pulse' => __('Quickly move the image into the background color, then fade into the next image', 'nextgen-gallery-pro'), 'slide' => __('Slide images depending on image position', 'nextgen-gallery-pro'), 'fadeslide' => __('Fade between images and slide slightly at the same time', 'nextgen-gallery-pro')), $display_type->settings['transition'], '', FALSE);
    }
    public function _render_nextgen_pro_slideshow_transition_speed_field($display_type)
    {
        return $this->_render_number_field($display_type, 'transition_speed', __('Transition speed', 'nextgen-gallery-pro'), $display_type->settings['transition_speed'], __('Measured in seconds', 'nextgen-gallery-pro'), FALSE, __('seconds', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_slideshow_border_size_field($display_type)
    {
        return $this->_render_number_field($display_type, 'border_size', __('Border size', 'nextgen-gallery-pro'), $display_type->settings['border_size'], __('Borders will not be applied if "Crop Images" is enabled', 'nextgen-gallery-pro'), !empty($display_type->settings['image_crop']) ? TRUE : FALSE, '', 0);
    }
    public function _render_nextgen_pro_slideshow_border_color_field($display_type)
    {
        return $this->_render_color_field($display_type, 'border_color', __('Border color', 'nextgen-gallery-pro'), $display_type->settings['border_color'], '', !empty($display_type->settings['image_crop']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_slideshow_aspect_ratio_field($display_type)
    {
        return $this->_render_select_field($display_type, 'aspect_ratio', __('Stage aspect ratio', 'nextgen-gallery-pro'), $this->_get_aspect_ratio_options(), $display_type->settings['aspect_ratio'], '', FALSE);
    }
    public function _render_nextgen_pro_slideshow_show_playback_controls_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'show_playback_controls', __('Show play controls', 'nextgen-gallery-pro'), $display_type->settings['show_playback_controls']);
    }
}
class A_NextGen_Pro_Slideshow_Forms extends Mixin
{
    public function get_forms($type, $instantiate = FALSE)
    {
        $this->add_form(NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_SLIDESHOW);
        return $this->call_parent('get_forms', $type, $instantiate);
    }
}
class A_NextGen_Pro_Slideshow_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_SLIDESHOW) {
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_pan', 1);
            $this->object->_set_default_value($entity, 'settings', 'show_playback_controls', 1);
            $this->object->_set_default_value($entity, 'settings', 'show_captions', 0);
            $this->object->_set_default_value($entity, 'settings', 'caption_class', 'caption_overlay_bottom');
            $this->object->_set_default_value($entity, 'settings', 'caption_height', 70);
            $this->object->_set_default_value($entity, 'settings', 'aspect_ratio', '1.5');
            $this->object->_set_default_value($entity, 'settings', 'width', 100);
            $this->object->_set_default_value($entity, 'settings', 'width_unit', '%');
            $this->object->_set_default_value($entity, 'settings', 'transition', 'fade');
            $this->object->_set_default_value($entity, 'settings', 'transition_speed', 1);
            $this->object->_set_default_value($entity, 'settings', 'slideshow_speed', 5);
            $this->object->_set_default_value($entity, 'settings', 'border_size', 0);
            $this->object->_set_default_value($entity, 'settings', 'border_color', '#ffffff');
            $this->object->_set_default_value($entity, 'settings', 'localize_limit', '0');
            $this->object->_set_default_value($entity, 'settings', 'ngg_triggers_display', 'always');
        }
    }
}