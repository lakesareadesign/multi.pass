<?php
class A_Galleria_Controller extends Mixin
{
    public function enqueue_frontend_resources($displayed_gallery)
    {
        // Add some properties to the displayed gallery
        $this->object->_compute_aspect_ratio($displayed_gallery);
        // Include ngg_common.js
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        M_Galleria::enqueue_entities($displayed_gallery);
        wp_enqueue_script('ngg_galleria');
        wp_enqueue_script('ngg_galleria_init', $this->get_static_url(NGG_PRO_GALLERIA . '#ngg_galleria.js'), array('ngg_galleria'), '1.0');
        $this->enqueue_ngg_styles();
    }
    public function _compute_aspect_ratio($displayed_gallery, $type = null)
    {
        $storage = C_Gallery_Storage::get_instance();
        $list = $displayed_gallery->get_included_entities();
        if ($type == null) {
            $type = !empty($displayed_gallery->display_settings['aspect_ratio']) ? $displayed_gallery->display_settings['aspect_ratio'] : 'image_average';
        }
        switch ($type) {
            case 'first_image':
                if ($list != null) {
                    $image = $list[0];
                    $dims = $storage->get_image_dimensions($image);
                    $ratio = round($dims['width'] / $dims['height'], 2);
                    $displayed_gallery->display_settings['aspect_ratio_computed'] = $ratio;
                }
                break;
            case 'image_average':
                if ($list != null) {
                    $computed_ratio = 0;
                    foreach ($list as $image) {
                        $dims = $storage->get_image_dimensions($image);
                        $ratio = round($dims['width'] / $dims['height'], 2);
                        if ($computed_ratio == 0) {
                            $computed_ratio = $ratio;
                        } else {
                            if (abs($computed_ratio - $ratio) > 0.001) {
                                $computed_ratio = ($computed_ratio + $ratio) / 2;
                            }
                        }
                    }
                    if ($computed_ratio > 0) {
                        $displayed_gallery->display_settings['aspect_ratio_computed'] = $computed_ratio;
                    }
                }
                break;
        }
    }
    public function index_action($displayed_gallery, $return = FALSE)
    {
        $params = array('theme' => $displayed_gallery->display_settings['theme'], 'displayed_gallery_id' => $displayed_gallery->id());
        $params = $this->object->prepare_display_parameters($displayed_gallery, $params);
        return $this->object->render_view(NGG_PRO_GALLERIA . '#galleria', $params, $return);
    }
}