<?php
class A_NextGen_Pro_Thumbnail_Grid_Controller extends Mixin
{
    public function initialize()
    {
        parent::initialize();
        $this->add_mixin('Mixin_NextGen_Basic_Pagination');
    }
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        wp_enqueue_style('nextgen_pro_thumbnail_grid', $this->get_static_url('photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid.css'));
        wp_enqueue_style('nextgen_pagination_style', $this->get_static_url('photocrati-nextgen_pagination#style.css'));
        $id = 'displayed_gallery_' . $displayed_gallery->id();
        // Enqueue dynamic stylesheet
        $dyn_styles = C_Dynamic_Stylesheet_Controller::get_instance('all');
        $dyn_styles->enqueue('nextgen_pro_thumbnail_grid', $this->array_merge_assoc($displayed_gallery->display_settings, array('id' => $id)));
        $this->enqueue_ngg_styles();
    }
    public function index_action($displayed_gallery, $return = FALSE)
    {
        // The HTML id of the gallery
        $id = 'displayed_gallery_' . $displayed_gallery->id();
        // Get named size of thumbnail images
        $thumbnail_size_name = 'thumbnail';
        $display_settings = $displayed_gallery->display_settings;
        if ($display_settings['override_thumbnail_settings']) {
            $dynthumbs = C_Dynamic_Thumbnails_Manager::get_instance();
            $dyn_params = array('width' => $display_settings['thumbnail_width'], 'height' => $display_settings['thumbnail_height']);
            if ($display_settings['thumbnail_quality']) {
                $dyn_params['quality'] = $display_settings['thumbnail_quality'];
            }
            if ($display_settings['thumbnail_crop']) {
                $dyn_params['crop'] = true;
            }
            if ($display_settings['thumbnail_watermark']) {
                $dyn_params['watermark'] = true;
            }
            $thumbnail_size_name = $dynthumbs->get_size_name($dyn_params);
        }
        $current_page = (int) $this->param('nggpage', $displayed_gallery->id(), 1);
        $offset = $display_settings['images_per_page'] * ($current_page - 1);
        $total = $displayed_gallery->get_entity_count();
        $images = $displayed_gallery->get_included_entities($display_settings['images_per_page'], $offset);
        if (in_array($displayed_gallery->source, array('random', 'recent'))) {
            $display_settings['disable_pagination'] = TRUE;
        }
        if ($images) {
            if ($display_settings['images_per_page'] && !$display_settings['disable_pagination']) {
                $pagination_result = $this->object->create_pagination($current_page, $total, $display_settings['images_per_page']);
            }
        }
        $pagination = !empty($pagination_result['output']) ? $pagination_result['output'] : NULL;
        $params = array('images' => $images, 'storage' => C_Gallery_Storage::get_instance(), 'thumbnail_size_name' => $thumbnail_size_name, 'effect_code' => $this->object->get_effect_code($displayed_gallery), 'id' => $id, 'pagination' => $pagination);
        $params = $this->object->prepare_display_parameters($displayed_gallery, $params);
        // Render view/template. We remove whitespace from between HTML elements lest the browser think we want
        // a space character (&nbsp;) between each image-causing columns to appear between images
        return preg_replace('~>\\s*\\n\\s*<~', '><', $this->render_view('photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid', $params, $return));
    }
}
class A_NextGen_Pro_Thumbnail_Grid_Form extends Mixin_Display_Type_Form
{
    public function get_display_type_name()
    {
        return NGG_PRO_THUMBNAIL_GRID;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script($this->object->get_display_type_name() . '-js', $this->object->get_static_url('photocrati-nextgen_pro_thumbnail_grid#settings.js'));
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
        return array('thumbnail_override_settings', 'nextgen_pro_thumbnail_grid_images_per_page', 'nextgen_pro_thumbnail_grid_border_size', 'nextgen_pro_thumbnail_grid_border_color', 'nextgen_pro_thumbnail_grid_spacing', 'nextgen_pro_thumbnail_grid_number_of_columns');
    }
    /**
     * Renders the images_per_page settings field
     *
     * @param C_Display_Type $display_type
     * @return string
     */
    public function _render_nextgen_pro_thumbnail_grid_images_per_page_field($display_type)
    {
        return $this->_render_number_field($display_type, 'images_per_page', __('Images per page', 'nextgen-gallery-pro'), $display_type->settings['images_per_page'], __('"0" will display all images at once', 'nextgen-gallery-pro'), FALSE, __('# of images', 'nextgen-gallery-pro'), 0);
    }
    public function _render_nextgen_pro_thumbnail_grid_border_size_field($display_type)
    {
        return $this->_render_number_field($display_type, 'border_size', __('Border size', 'nextgen-gallery-pro'), $display_type->settings['border_size'], '', FALSE, '', 0);
    }
    public function _render_nextgen_pro_thumbnail_grid_spacing_field($display_type)
    {
        return $this->_render_number_field($display_type, 'spacing', __('Spacing', 'nextgen-gallery-pro'), $display_type->settings['spacing']);
    }
    public function _render_nextgen_pro_thumbnail_grid_number_of_columns_field($display_type)
    {
        return $this->_render_number_field($display_type, 'number_of_columns', __('Number of columns to display', 'nextgen-gallery-pro'), $display_type->settings['number_of_columns'], __('An empty or zero in this field will use a responsive layout', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_thumbnail_grid_border_color_field($display_type)
    {
        return $this->_render_color_field($display_type, 'border_color', __('Border color', 'nextgen-gallery-pro'), $display_type->settings['border_color']);
    }
}
class A_NextGen_Pro_Thumbnail_Grid_Forms extends Mixin
{
    public function get_forms($type, $instantiate = FALSE)
    {
        $this->add_form(NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_THUMBNAIL_GRID);
        return $this->call_parent('get_forms', $type, $instantiate);
    }
}
class A_NextGen_Pro_Thumbnail_Grid_Mapper extends Mixin
{
    public function set_defaults($entity)
    {
        $this->call_parent('set_defaults', $entity);
        if ($entity->name == NGG_PRO_THUMBNAIL_GRID) {
            $settings = C_NextGen_Settings::get_instance();
            $this->_set_default_value($entity, 'settings', 'override_thumbnail_settings', 0);
            $this->_set_default_value($entity, 'settings', 'thumbnail_width', $settings->thumbwidth);
            $this->_set_default_value($entity, 'settings', 'thumbnail_height', $settings->thumbheight);
            $this->_set_default_value($entity, 'settings', 'thumbnail_quality', $settings->thumbquality);
            $this->_set_default_value($entity, 'settings', 'thumbnail_crop', $settings->thumbfix);
            $this->_set_default_value($entity, 'settings', 'thumbnail_watermark', 0);
            $this->_set_default_value($entity, 'settings', 'images_per_page', $settings->galImages);
            $this->_set_default_value($entity, 'settings', 'disable_pagination', 0);
            $this->_set_default_value($entity, 'settings', 'border_color', '#eeeeee');
            $this->_set_default_value($entity, 'settings', 'border_size', 0);
            $this->_set_default_value($entity, 'settings', 'spacing', 2);
            $this->_set_default_value($entity, 'settings', 'number_of_columns', 0);
            $this->_set_default_value($entity, 'settings', 'ngg_triggers_display', 'never');
        }
    }
}