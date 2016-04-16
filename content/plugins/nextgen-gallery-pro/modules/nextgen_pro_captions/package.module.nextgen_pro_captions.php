<?php
class A_NextGen_Pro_Captions_Form extends Mixin
{
    public function _get_field_names()
    {
        $fields = $this->call_parent('_get_field_names');
        $fields[] = 'nextgen_pro_captions_enabled';
        $fields[] = 'nextgen_pro_captions_display_sharing';
        $fields[] = 'nextgen_pro_captions_display_title';
        $fields[] = 'nextgen_pro_captions_display_description';
        $fields[] = 'nextgen_pro_captions_animation';
        return $fields;
    }
    public function enqueue_static_resources()
    {
        $this->call_parent('enqueue_static_resources');
        wp_enqueue_script('photocrati-nextgen_pro_captions_settings-js', $this->get_static_url('photocrati-nextgen_pro_captions#settings.js'), array('jquery.nextgen_radio_toggle'));
    }
    public function _render_nextgen_pro_captions_enabled_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'captions_enabled', __('Enable caption overlay', 'nextgen-gallery-pro'), isset($display_type->settings['captions_enabled']) ? $display_type->settings['captions_enabled'] : FALSE);
    }
    public function _render_nextgen_pro_captions_display_sharing_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'captions_display_sharing', __('Display share icons', 'nextgen-gallery-pro'), isset($display_type->settings['captions_display_sharing']) ? $display_type->settings['captions_display_sharing'] : TRUE, '', empty($display_type->settings['captions_enabled']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_captions_display_title_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'captions_display_title', __('Display image title', 'nextgen-gallery-pro'), isset($display_type->settings['captions_display_title']) ? $display_type->settings['captions_display_title'] : TRUE, '', empty($display_type->settings['captions_enabled']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_captions_display_description_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'captions_display_description', __('Display image description', 'nextgen-gallery-pro'), isset($display_type->settings['captions_display_description']) ? $display_type->settings['captions_display_description'] : TRUE, '', empty($display_type->settings['captions_enabled']) ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_captions_animation_field($display_type)
    {
        return $this->_render_select_field($display_type, 'captions_animation', __('Animation type', 'nextgen-gallery-pro'), array('fade' => __('Fade in', 'nextgen-gallery-pro'), 'slideup' => __('Slide up', 'nextgen-gallery-pro'), 'slidedown' => __('Slide down', 'nextgen-gallery-pro'), 'slideleft' => __('Slide left', 'nextgen-gallery-pro'), 'slidedown' => __('Slide down', 'nextgen-gallery-pro'), 'titlebar' => __('Titlebar', 'nextgen-gallery-pro'), 'plain' => __('Plain', 'nextgen-gallery-pro')), isset($display_type->settings['captions_animation']) ? $display_type->settings['captions_animation'] : 'slideup', '', empty($display_type->settings['captions_enabled']) ? TRUE : FALSE);
    }
}
class A_NextGen_Pro_Captions_Resources extends Mixin
{
    static $_galleries_displayed = array();
    static $_pro_captions_run_once = FALSE;
    public function get_effect_code($displayed_gallery)
    {
        // Swap the gallery placeholder
        $retval = $this->call_parent('get_effect_code', $displayed_gallery);
        if (isset($displayed_gallery->display_settings['captions_enabled']) && $displayed_gallery->display_settings['captions_enabled']) {
            $retval .= ' data-ngg-captions-enabled="1" data-ngg-captions-id="' . $displayed_gallery->id() . '"';
        }
        return $retval;
    }
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        if (!in_array($displayed_gallery->id(), self::$_galleries_displayed)) {
            self::$_galleries_displayed[] = $displayed_gallery->id();
            $ds = $displayed_gallery->display_settings;
            if (!empty($ds['captions_enabled']) && $ds['captions_enabled']) {
                $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.captions_enabled', TRUE, FALSE);
                $animation = !empty($ds['captions_animation']) ? $ds['captions_animation'] : 'slideup';
                $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.captions_animation', $animation, FALSE);
                $show_title = !empty($ds['captions_display_title']) ? $ds['captions_display_title'] : TRUE;
                $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.captions_display_title', $show_title, FALSE);
                $show_description = !empty($ds['captions_display_description']) ? $ds['captions_display_description'] : TRUE;
                $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.captions_display_description', $show_description, FALSE);
            } else {
                $this->object->_add_script_data('ngg_common', 'galleries.gallery_' . $displayed_gallery->id() . '.captions_enabled', FALSE, FALSE);
            }
        }
        if (isset($displayed_gallery->display_settings['captions_enabled']) && $displayed_gallery->display_settings['captions_enabled'] && !self::$_pro_captions_run_once) {
            wp_enqueue_script('jquery.dotdotdot');
            wp_enqueue_script('nextgen_pro_captions-js');
            wp_enqueue_style('nextgen_pro_captions-css');
            self::$_pro_captions_run_once = TRUE;
        }
    }
}