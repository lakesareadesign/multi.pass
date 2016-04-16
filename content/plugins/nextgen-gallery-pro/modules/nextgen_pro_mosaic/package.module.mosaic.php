<?php
class A_Mosaic_Controller extends Mixin
{
    public function index_action($displayed_gallery, $return = FALSE)
    {
        $params = $this->object->prepare_display_parameters($displayed_gallery, array());
        return $this->object->render_view(NGG_PRO_MOSAIC . '#default', $params, $return);
    }
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $size_name = C_Dynamic_Thumbnails_Manager::get_instance()->get_size_name(array('height' => $displayed_gallery->display_settings['row_height'] * 2, 'crop' => FALSE));
        $displayed_gallery->display_settings['override_image_settings'] = true;
        $displayed_gallery->display_settings['override_image_size_name'] = $size_name;
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        $this->object->enqueue_ngg_styles();
        M_Galleria::enqueue_entities($displayed_gallery, 0, $size_name);
        wp_enqueue_style('ngg_pro_mosaic_style', $this->object->get_static_url(NGG_PRO_MOSAIC . '#style.css'), NGG_PRO_MOSAIC_VERSION);
        wp_enqueue_script('ngg_pro_mosaic_base', $this->object->get_static_url(NGG_PRO_MOSAIC . '#justified-gallery-3.6.js'), array('jquery'), NGG_PRO_MOSAIC_VERSION, TRUE);
        wp_enqueue_script('ngg_pro_mosaic_script', $this->object->get_static_url(NGG_PRO_MOSAIC . '#mosaic_init.js'), array('ngg_pro_mosaic_base', 'underscore'), NGG_PRO_MOSAIC_VERSION, TRUE);
        $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.mosaic_effect_code', $this->object->get_effect_code($displayed_gallery), FALSE);
    }
}
class A_Mosaic_Forms extends Mixin
{
    public function get_forms($type, $instantiate = FALSE)
    {
        $this->add_form(NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_MOSAIC);
        return $this->call_parent('get_forms', $type, $instantiate);
    }
}
class A_Mosaic_Form extends Mixin_Display_Type_Form
{
    public function get_display_type_name()
    {
        return NGG_PRO_MOSAIC;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script(NGG_PRO_MOSAIC . '_admin_settings_js', $this->object->get_static_url(NGG_PRO_MOSAIC . '#settings.js'), array('jquery.nextgen_radio_toggle'), NGG_PRO_MOSAIC_VERSION);
        $atp = C_Attach_Controller::get_instance();
        if ($atp != null && $atp->has_method('mark_script')) {
            $atp->mark_script(NGG_PRO_MOSAIC . '_admin_settings_js');
        }
    }
    public function _get_field_names()
    {
        return array('mosaic_row_height', 'mosaic_margins', 'mosaic_last_row', 'mosaic_lazy_load_enable', 'mosaic_lazy_load_initial', 'mosaic_lazy_load_batch');
    }
    public function _render_mosaic_row_height_field($display_type)
    {
        $settings = $display_type->settings;
        return $this->_render_number_field($display_type, 'row_height', __('Row height', 'nextgen-gallery-pro'), $settings['row_height'], '', FALSE, '', 6);
    }
    public function _render_mosaic_margins_field($display_type)
    {
        $settings = $display_type->settings;
        return $this->_render_number_field($display_type, 'margins', __('Margins', 'nextgen-gallery-pro'), $settings['margins'], '', FALSE, '', 0);
    }
    public function _render_mosaic_last_row_field($display_type)
    {
        $settings = $display_type->settings;
        return $this->_render_select_field($display_type, 'last_row', __('Justify last row', 'nextgen-gallery-pro'), array('justify' => __('Justify', 'nextgen-gallery-pro'), 'nojustify' => __('Do not justify', 'nextgen-gallery-pro'), 'hide' => __('Hide', 'nextgen-gallery-pro')), $settings['last_row'], __('When aligning the last row some images may appear cropped. Select "Do not justify" to allow the last row to appear flush but "unfinished". "Hide" will omit any images that can not be justified without cropping.', 'nextgen-gallery-pro'));
    }
    public function _render_mosaic_lazy_load_enable_field($display_type)
    {
        // _render_radio_field($display_type, $name, $label, $value, $text = '', $hidden = FALSE)
        $settings = $display_type->settings;
        return $this->_render_radio_field($display_type, 'lazy_load_enable', __('Enable "lazy" image loading', 'nextgen-gallery-pro'), $settings['lazy_load_enable']);
    }
    public function _render_mosaic_lazy_load_initial_field($display_type)
    {
        $settings = $display_type->settings;
        return $this->_render_number_field($display_type, 'lazy_load_initial', __('Images to display at start', 'nextgen-gallery-pro'), $settings['lazy_load_initial'], '', empty($settings['lazy_load_enable']) ? TRUE : FALSE);
    }
    public function _render_mosaic_lazy_load_batch_field($display_type)
    {
        $settings = $display_type->settings;
        return $this->_render_number_field($display_type, 'lazy_load_batch', __('Images to load when scrolling', 'nextgen-gallery-pro'), $settings['lazy_load_batch'], '', empty($settings['lazy_load_enable']) ? TRUE : FALSE);
    }
}
class Mixin_Mosaic_Display_Type_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_MOSAIC) {
            $this->object->_set_default_value($entity, 'settings', 'localize_limit', '0');
            $this->object->_set_default_value($entity, 'settings', 'row_height', '180');
            $this->object->_set_default_value($entity, 'settings', 'margins', '5');
            $this->object->_set_default_value($entity, 'settings', 'last_row', 'justify');
            $this->object->_set_default_value($entity, 'settings', 'lazy_load_enable', '1');
            $this->object->_set_default_value($entity, 'settings', 'lazy_load_initial', '35');
            $this->object->_set_default_value($entity, 'settings', 'lazy_load_batch', '15');
        }
    }
}