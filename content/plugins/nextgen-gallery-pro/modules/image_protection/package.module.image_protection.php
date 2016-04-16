<?php
class A_Image_Protection_Effect_Code extends Mixin
{
    public function get_effect_code($displayed_gallery)
    {
        $retval = $this->call_parent('get_effect_code', $displayed_gallery);
        if (C_NextGen_Settings::get_instance()->protect_images) {
            $retval .= ' data-ngg-protect="1"';
        }
        return $retval;
    }
}
class A_Image_Protection_Form extends Mixin
{
    public function get_model()
    {
        return C_Settings_Model::get_instance();
    }
    public function get_title()
    {
        return __('Image Protection', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('nextgen_pro_image_protection_enable', 'nextgen_pro_image_protection_global');
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_style('nextgen_pro_image_protection_admin_settings_style', $this->object->get_static_url('photocrati-image_protection#settings.css'));
        wp_enqueue_script('nextgen_pro_image_protection_admin_settings_script', $this->get_static_url('photocrati-image_protection#settings.js'), array('jquery.nextgen_radio_toggle'));
    }
    public function _render_nextgen_pro_image_protection_enable_field($settings)
    {
        $model = new stdClass();
        $model->name = 'image_protection';
        $field = $this->object->_render_radio_field($model, 'protect_images', __('Protect images', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->protect_images, __('Protect images from being downloaded both by right click or drag &amp; drop', 'nextgen-gallery-pro'));
        return $field;
    }
    public function _render_nextgen_pro_image_protection_global_field($settings)
    {
        $model = new stdClass();
        $model->name = 'image_protection';
        $field = $this->object->_render_radio_field($model, 'protect_images_globally', __('Disable right click menu completely', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->protect_images_globally, __('By default the right click menu is only disabled for NextGEN images. Enable this to disable the right click menu on the whole page.', 'nextgen-gallery-pro'), !empty(C_NextGen_Settings::get_instance()->protect_images) ? FALSE : TRUE);
        return $field;
    }
    public function save_action($options)
    {
        if (!empty($options)) {
            $settings = C_NextGen_Settings::get_instance();
            $settings->protect_images = $options['protect_images'];
            $settings->protect_images_globally = $options['protect_images_globally'];
            $settings->save();
        }
    }
}
class Mixin_Image_Protection_Manager extends Mixin
{
    public function _get_protector_list()
    {
        $protector_files = array('apache-config' => array('path' => '.htaccess', 'content' => '
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule _backup$ - [L,F]
</IfModule>' . '
', 'tag-start' => '# BEGIN NextGEN Pro Protection' . '
', 'tag-end' => '# END NextGEN Pro Protection' . '
'), 'php-index' => array('path' => 'index.php', 'content' => '// silence is golden' . '
', 'tag-start' => '<?php # BEGIN NextGEN Pro Protection' . '
', 'tag-end' => '# END NextGEN Pro Protection' . '
'));
        return $protector_files;
    }
    public function _find_protector_content($text, $protector)
    {
        $tag_start = $protector['tag-start'];
        $tag_end = $protector['tag-end'];
        $pos_1 = strpos($text, $tag_start);
        $len_1 = strlen($tag_start);
        if ($pos_1 !== false) {
            $start = $pos_1 + $len_1;
            $pos_2 = strpos($text, $tag_end, $start);
            $len_2 = strlen($tag_end);
            if ($pos_2 !== false) {
                $content = substr($text, $start, $pos_2 - $start);
                return array('content' => $content, 'start' => $start, 'end' => $pos_2, 'size' => $pos_2 - $start);
            }
        }
        return false;
    }
    // $skip_cache not supported yet... we should probably cache this to avoid file access?
    public function is_gallery_protected($gallery, $skip_cache = false)
    {
        $storage = C_Gallery_Storage::get_instance();
        $gallery_path = $storage->get_gallery_abspath($gallery);
        if ($gallery_path != null && file_exists($gallery_path)) {
            $protector_files = $this->_get_protector_list();
            $retval = false;
            foreach ($protector_files as $name => $protector) {
                $path = $protector['path'];
                $full_path = path_join($gallery_path, $path);
                $retval = false;
                if (file_exists($full_path)) {
                    $full = file_get_contents($full_path);
                    $result = $this->_find_protector_content($full, $protector);
                    if ($result != null && $result['content'] == $protector['content']) {
                        $retval = true;
                    }
                }
                if (!$retval) {
                    break;
                }
            }
            return $retval;
        }
        return false;
    }
    public function protect_gallery($gallery, $force = false)
    {
        $retval = $this->object->is_gallery_protected($gallery);
        if ($force || !$retval) {
            $storage = C_Gallery_Storage::get_instance();
            $gallery_path = $storage->get_gallery_abspath($gallery);
            if ($gallery_path != null && file_exists($gallery_path)) {
                $protector_files = $this->_get_protector_list();
                foreach ($protector_files as $name => $protector) {
                    $path = $protector['path'];
                    $full_path = path_join($gallery_path, $path);
                    $full = null;
                    if (file_exists($full_path)) {
                        $full = @file_get_contents($full_path);
                        $result = $this->_find_protector_content($full, $protector);
                        if ($result != null) {
                            $full = substr_replace($full, $protector['content'], $result['start'], $result['size']);
                        }
                    } else {
                        $full = $protector['tag-start'] . $protector['content'] . $protector['tag-end'];
                    }
                    if (is_writable($full_path)) {
                        @file_put_contents($full_path, $full);
                    }
                    $retval = true;
                }
            }
        }
        return $retval;
    }
    // $skip_cache not supported yet... we should probably cache this to avoid file access?
    public function is_image_protected($image, $skip_cache = false)
    {
    }
    public function protect_image($image, $force = false)
    {
    }
}
class C_Image_Protection_Manager extends C_Component
{
    static $_instances = array();
    public function define($context = FALSE)
    {
        parent::define($context);
        $this->implement('I_Image_Protection_Manager');
        $this->add_mixin('Mixin_Image_Protection_Manager');
    }
    static function get_instance($context = False)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_Image_Protection_Manager($context);
        }
        return self::$_instances[$context];
    }
}