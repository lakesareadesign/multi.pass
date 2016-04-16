<?php
class A_NextGen_Pro_Horizontal_Filmstrip_Controller extends A_Galleria_Controller
{
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $router = C_Router::get_instance();
        $displayed_gallery->display_settings['theme'] = 'nextgen_pro_horizontal_filmstrip';
        wp_enqueue_script('ngg_pro_horizontal_filmstrip_theme_js', $router->get_static_url(NGG_PRO_HORIZONTAL_FILMSTRIP . '#theme/galleria.nextgen_pro_horizontal_filmstrip.js'), array('ngg_galleria_init'), '2.0');
        wp_enqueue_style('ngg_pro_horizontal_filmstrip_theme_css', $router->get_static_url(NGG_PRO_HORIZONTAL_FILMSTRIP . '#theme/galleria.nextgen_pro_horizontal_filmstrip.css'), array(), '2.0');
        return C_Display_Type_Controller::get_instance(NGG_PRO_GALLERIA)->enqueue_frontend_resources($displayed_gallery);
    }
}
class A_NextGen_Pro_Horizontal_Filmstrip_Form extends A_NextGen_Pro_Slideshow_Form
{
    public function get_display_type_name()
    {
        return NGG_PRO_HORIZONTAL_FILMSTRIP;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script($this->object->get_display_type_name() . '-js', $this->get_static_url('photocrati-nextgen_pro_horizontal_filmstrip#settings.js'));
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
        $fields = parent::_get_field_names();
        $fields[] = 'thumbnail_override_settings';
        return $fields;
    }
}
class A_NextGen_Pro_Horizontal_Filmstrip_Forms extends Mixin
{
    public function get_forms($type, $instantiate = FALSE)
    {
        $this->add_form(NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_HORIZONTAL_FILMSTRIP);
        return $this->call_parent('get_forms', $type, $instantiate);
    }
}
class A_NextGen_Pro_Horizontal_Filmstrip_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_HORIZONTAL_FILMSTRIP) {
            $settings = C_NextGen_Settings::get_instance();
            $this->object->_set_default_value($entity, 'settings', 'override_thumbnail_settings', 1);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_width', 120);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_height', 90);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_quality', $settings->thumbquality);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_crop', $settings->thumbfix);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_watermark', 0);
            $this->object->_set_default_value($entity, 'settings', 'override_image_settings', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_quality', '100');
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_watermark', 0);
            // options inherited from the pro-slideshow module
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