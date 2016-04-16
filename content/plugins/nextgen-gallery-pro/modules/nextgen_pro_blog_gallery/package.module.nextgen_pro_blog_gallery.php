<?php
class A_NextGen_Pro_Blog_Controller extends Mixin
{
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        wp_enqueue_style('nextgen_pro_blog_gallery', $this->get_static_url('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog_gallery.css'));
        $dyn_styles = C_Dynamic_Stylesheet_Controller::get_instance('all');
        $dyn_styles->enqueue('nextgen_pro_blog', $this->array_merge_assoc($displayed_gallery->display_settings, array('id' => 'displayed_gallery_' . $displayed_gallery->id())));
        $this->enqueue_ngg_styles();
    }
    public function index_action($displayed_gallery, $return = FALSE)
    {
        // The HTML id of the gallery
        $id = 'displayed_gallery_' . $displayed_gallery->id();
        $image_size_name = 'full';
        $display_settings = $displayed_gallery->display_settings;
        if ($display_settings['override_image_settings']) {
            $dynthumbs = C_Dynamic_Thumbnails_Manager::get_instance();
            $dyn_params = array();
            if ($display_settings['image_quality']) {
                $dyn_params['quality'] = $display_settings['image_quality'];
            }
            if ($display_settings['image_crop']) {
                $dyn_params['crop'] = true;
            }
            if ($display_settings['image_watermark']) {
                $dyn_params['watermark'] = true;
            }
            $image_size_name = $dynthumbs->get_size_name($dyn_params);
        }
        $params = array('images' => $displayed_gallery->get_included_entities(), 'storage' => C_Gallery_Storage::get_instance(), 'effect_code' => $this->object->get_effect_code($displayed_gallery), 'id' => $id, 'image_size_name' => $image_size_name, 'image_display_size' => $displayed_gallery->display_settings['image_display_size'], 'border_size' => $displayed_gallery->display_settings['border_size']);
        $params = $this->object->prepare_display_parameters($displayed_gallery, $params);
        // Render view/template
        return $this->render_view('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog', $params, $return);
    }
}
class A_NextGen_Pro_Blog_Form extends Mixin_Display_Type_Form
{
    public function get_display_type_name()
    {
        return NGG_PRO_BLOG_GALLERY;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script($this->object->get_display_type_name() . '-js', $this->get_static_url('photocrati-nextgen_pro_blog_gallery#settings.js'));
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
        return array('image_override_settings', 'nextgen_pro_blog_gallery_image_display_size', 'nextgen_pro_blog_gallery_image_max_height', 'nextgen_pro_blog_gallery_spacing', 'nextgen_pro_blog_gallery_border_size', 'nextgen_pro_blog_gallery_border_color', 'nextgen_pro_blog_gallery_display_captions', 'nextgen_pro_blog_gallery_caption_location');
    }
    public function _render_nextgen_pro_blog_gallery_border_size_field($display_type)
    {
        return $this->_render_number_field($display_type, 'border_size', __('Border size', 'nextgen-gallery-pro'), $display_type->settings['border_size'], '', FALSE, '', 0);
    }
    public function _render_nextgen_pro_blog_gallery_border_color_field($display_type)
    {
        return $this->_render_color_field($display_type, 'border_color', __('Border color', 'nextgen-gallery-pro'), $display_type->settings['border_color']);
    }
    public function _render_nextgen_pro_blog_gallery_image_display_size_field($display_type)
    {
        return $this->_render_number_field($display_type, 'image_display_size', __('Image display size', 'nextgen-gallery-pro'), $display_type->settings['image_display_size'], __('Measured in pixels', 'nextgen-gallery-pro'), FALSE, __('image width', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_blog_gallery_image_max_height_field($display_type)
    {
        return $this->_render_number_field($display_type, 'image_max_height', __('Image maximum height', 'nextgen-gallery-pro'), $display_type->settings['image_max_height'], __('Measured in pixels. Empty or 0 will not impose a limit.', 'nextgen-gallery-pro'), FALSE, '', 0);
    }
    public function _render_nextgen_pro_blog_gallery_spacing_field($display_type)
    {
        return $this->_render_number_field($display_type, 'spacing', __('Image spacing', 'nextgen-gallery-pro'), $display_type->settings['spacing'], __('Measured in pixels', 'nextgen-gallery-pro'), FALSE, '', 0);
    }
    public function _render_nextgen_pro_blog_gallery_display_captions_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'display_captions', __('Display captions', 'nextgen-gallery-pro'), $display_type->settings['display_captions']);
    }
    public function _render_nextgen_pro_blog_gallery_caption_location_field($display_type)
    {
        return $this->_render_select_field($display_type, 'caption_location', __('Caption location', 'nextgen-gallery-pro'), array('above' => __('Above', 'nextgen-gallery-pro'), 'below' => __('Below', 'nextgen-gallery-pro')), $display_type->settings['caption_location'], '', !empty($display_type->settings['display_captions']) ? FALSE : TRUE);
    }
}
class A_NextGen_Pro_Blog_Forms extends Mixin
{
    public function get_forms($type, $instantiate = FALSE)
    {
        $this->add_form(NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_BLOG_GALLERY);
        return $this->call_parent('get_forms', $type, $instantiate);
    }
}
class A_NextGen_Pro_Blog_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_BLOG_GALLERY) {
            $this->object->_set_default_value($entity, 'settings', 'override_image_settings', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_quality', '100');
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_watermark', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_display_size', 800);
            $this->object->_set_default_value($entity, 'settings', 'image_max_height', 0);
            $this->object->_set_default_value($entity, 'settings', 'spacing', 5);
            $this->object->_set_default_value($entity, 'settings', 'border_size', 0);
            $this->object->_set_default_value($entity, 'settings', 'border_color', '#FFFFFF');
            $this->object->_set_default_value($entity, 'settings', 'display_captions', 0);
            $this->object->_set_default_value($entity, 'settings', 'caption_location', 'below');
            $this->object->_set_default_value($entity, 'settings', 'ngg_triggers_display', 'always');
        }
    }
}