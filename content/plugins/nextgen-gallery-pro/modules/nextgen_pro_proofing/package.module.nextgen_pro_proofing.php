<?php
/**
 * Provides AJAX actions for the proofing actions
 */
class A_NextGen_Pro_Proofing_Ajax extends Mixin
{
    /**
     * Submits proofed image list
     */
    public function submit_proofed_gallery_action()
    {
        $settings = C_NextGen_Settings::get_instance();
        $response = array();
        $proofed_gallery = $this->object->param('proofed_gallery');
        $email = $this->object->param('email');
        $customer_name = $this->object->param('customer_name');
        $referer = $_SERVER['HTTP_REFERER'];
        // Do we have fields to work with?
        if ($this->object->validate_ajax_request()) {
            $image_list = isset($proofed_gallery['image_list']) ? $proofed_gallery['image_list'] : null;
            $file_list = '';
            if (!empty($image_list)) {
                $i = 0;
                foreach ($image_list as $image_id) {
                    $image = C_Image_Mapper::get_instance()->find($image_id);
                    $name = pathinfo($image->filename);
                    $name = $name['filename'];
                    if ($i == 0) {
                        $file_list = $name;
                    } else {
                        $file_list .= ',' . $name;
                    }
                    $i++;
                }
            }
            if ($image_list != null && $email != null) {
                $post_title = sprintf(__('Proof request by %1$s (%2$d images)', 'nextgen-gallery-pro'), $email, count($image_list));
                $proof_mapper = C_NextGen_Pro_Proofing_Mapper::get_instance();
                $proof = $proof_mapper->create(array('customer_name' => $customer_name, 'email' => $email, 'proofed_gallery' => $proofed_gallery, 'referer' => $referer, 'title' => $post_title));
                $post_id = $proof_mapper->save($proof);
                if ($post_id) {
                    $response['message'] = __('Done', 'nextgen-gallery-pro');
                    $confirmation_params = array('proof' => $proof->hash);
                    if (!empty($settings->proofing_page_confirmation)) {
                        $confirmation_url = M_NextGen_Pro_Proofing::get_page_url($settings->proofing_page_confirmation, $confirmation_params);
                    } else {
                        $confirmation_url = M_NextGen_Pro_Proofing::add_to_querystring(site_url('/?ngg_pro_proofing_page=1'), $confirmation_params);
                    }
                    // send e-mail to the site admin (get_option(admin_email))
                    $mailman = $this->object->get_registry()->get_utility('I_Nextgen_Mail_Manager');
                    $content = $mailman->create_content();
                    $content->set_subject($post_title);
                    $content->set_property('admin', get_bloginfo('name'));
                    $content->set_property('site_name', get_bloginfo('name'));
                    $content->set_property('file_list', $file_list);
                    $content->set_property('proof_link', $confirmation_url);
                    $content->set_property('user', array('email' => $email, 'name' => $customer_name));
                    $content->load_template($settings->proofing_email_template);
                    $mailman->send_mail($content, get_bloginfo('admin_email'));
                    // potentially send email to the submitting user
                    if ($settings->proofing_enable_user_email) {
                        $content = $mailman->create_content();
                        $content->set_subject($settings->proofing_user_email_subject);
                        $content->set_property('proof_link', $confirmation_url);
                        $content->set_property('user', array('email' => $email, 'name' => $customer_name));
                        $content->load_template($settings->proofing_user_email_template);
                        $mailman->send_mail($content, $email);
                    }
                    $response['redirect'] = $confirmation_url;
                } else {
                    $response['error'] = __('Proof post could not be created', 'nextgen-gallery-pro');
                }
            } else {
                if (empty($email) || empty($customer_name)) {
                    $response['error'] = __('Please provide a name and e-mail address', 'nextgen-gallery-pro');
                } else {
                    if ($image_list == null) {
                        // Sanity check, submit button is disabled when 0 images are selected
                        $response['error'] = __('No images selected', 'nextgen-gallery-pro');
                    }
                }
            }
        } else {
            $response['error'] = __('Invalid request', 'nextgen-gallery-pro');
        }
        return $response;
    }
    public function validate_ajax_request($check_token = false)
    {
        $valid_request = false;
        if (true) {
            $valid_request = true;
        }
        return $valid_request;
    }
}
class A_NextGen_Pro_Proofing_Factory extends Mixin
{
    public function nextgen_proof($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return new C_NextGen_Pro_Proofing($properties, $mapper, $context);
    }
}
class A_NextGen_Pro_Proofing_Form extends Mixin
{
    public function _get_field_names()
    {
        $fields = $this->call_parent('_get_field_names');
        $fields[] = 'nextgen_pro_proofing_display';
        return $fields;
    }
    public function _render_nextgen_pro_proofing_display_field($display_type)
    {
        return $this->_render_radio_field($display_type, 'ngg_proofing_display', __('Enable proofing?', 'nextgen-gallery-pro'), isset($display_type->settings['ngg_proofing_display']) ? $display_type->settings['ngg_proofing_display'] : FALSE, __('Trigger buttons or hover captions need to be enabled for proofing to work', 'nextgen-gallery-pro'));
    }
}
class A_NextGen_Pro_Proofing_Settings_Form extends Mixin
{
    public function get_title()
    {
        return $this->get_page_heading();
    }
    public function get_page_heading()
    {
        return __('Proofing', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        $fields = array('proofing_page_confirmation', 'proofing_trigger_text', 'proofing_user_confirmation_not_found', 'proofing_user_confirmation_template', 'proofing_enable_user_email', 'proofing_user_email_subject', 'proofing_user_email_template', 'proofing_email_template', 'proofing_lightbox_active_color');
        return $fields;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_style('photocrati-nextgen_pro_proofing_options_style', $this->get_static_url('photocrati-nextgen_pro_proofing#options.css'));
        wp_enqueue_script('photocrati-nextgen_pro_proofing_options_script', $this->get_static_url('photocrati-nextgen_pro_proofing#options.js'), array('jquery.nextgen_radio_toggle'));
    }
    public function save_action()
    {
        if ($changes = $this->param('proofing')) {
            $settings = C_NextGen_Settings::get_instance();
            foreach ($changes as $key => $value) {
                $key = "proofing_{$key}";
                $settings->{$key} = $value;
            }
            if ($changes['page_confirmation'] == '') {
                $settings->proofing_page_confirmation = $this->create_new_page(__('Proofed Images', 'nextgen-gallery-pro'), '[ngg_pro_proofing]');
            } else {
                $this->add_shortcode_to_post($settings->proofing_page_confirmation = $changes['page_confirmation'], '[ngg_pro_proofing]');
            }
            $settings->save();
        }
    }
    public function create_new_page($title, $content)
    {
        global $user_ID;
        return wp_insert_post(array('post_type' => 'page', 'post_status' => 'publish', 'post_content' => $content, 'post_author' => $user_ID, 'post_title' => $title, 'comment_status' => 'closed'));
    }
    public function add_shortcode_to_post($post_id, $shortcode, $only_if_empty = FALSE)
    {
        if ($post = get_post($post_id)) {
            if ($only_if_empty) {
                if (strlen($post->post_content) == 0) {
                    $post->post_content .= '
' . $shortcode;
                    wp_update_post($post);
                }
            } elseif (strpos($post->post_content, $shortcode) === FALSE) {
                $post->post_content .= '
' . $shortcode;
                wp_update_post($post);
            }
        }
    }
    public function _retrieve_page_list()
    {
        $pages = get_pages();
        $options = array('' => __('Create new', 'nextgen-gallery-pro'));
        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }
        return $options;
    }
    public function _render_proofing_page_confirmation_field($model)
    {
        $model = new stdClass();
        $model->name = 'proofing';
        $pages = $this->_retrieve_page_list();
        return $this->_render_select_field($model, 'page_confirmation', __('Confirmation page', 'nextgen-gallery-pro'), $pages, C_NextGen_Settings::get_instance()->proofing_page_confirmation, __('This page requires the [ngg_pro_proofing] shortcode, which will be automatically added if not already present. Selecting "Create new" will create a new page that will appear in your Primary Menu unless you\'ve customized your menu settings: http://codex.wordpress.org/Appearance_Menus_SubPanel', 'nextgen-gallery-pro'));
    }
    public function _render_proofing_lightbox_active_color_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_color_field($model, 'lightbox_active_color', __('Pro Lightbox icon color', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_lightbox_active_color, __('When the NextGen Pro Lightbox is active an additional icon is added for image proofing, this controls the color of that icon for chosen images', 'nextgen-gallery-pro'));
    }
    public function _render_proofing_trigger_text_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_text_field($model, 'trigger_text', __('Trigger text', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_trigger_text);
    }
    public function _render_proofing_email_template_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_textarea_field($model, 'email_template', __('Admin email message', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_email_template, __('Possible substitution fields: admin, file_list, proof_link, user_name, user_email', 'nextgen-gallery-pro'));
    }
    public function _render_proofing_enable_user_email_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_radio_field($model, 'enable_user_email', __('Send confirmation to users', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_enable_user_email);
    }
    public function _render_proofing_user_email_subject_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_text_field($model, 'user_email_subject', __('Confirmation subject', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_user_email_subject, '', !C_NextGen_Settings::get_instance()->proofing_enable_user_email ? TRUE : FALSE);
    }
    public function _render_proofing_user_email_template_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_textarea_field($model, 'user_email_template', __('Confirmation email', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_user_email_template, __('Possible substition fields: user_name, user_email, proof_link', 'nextgen-gallery-pro'), !C_NextGen_Settings::get_instance()->proofing_enable_user_email ? TRUE : FALSE);
    }
    public function _render_proofing_user_confirmation_not_found_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_text_field($model, 'user_confirmation_not_found', __('Not found message', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_user_confirmation_not_found, __('This is displayed to users viewing the proofing page without a valid proofing to view', 'nextgen-gallery-pro'));
    }
    public function _render_proofing_user_confirmation_template_field()
    {
        $model = new stdClass();
        $model->name = 'proofing';
        return $this->_render_textarea_field($model, 'user_confirmation_template', __('Confirmation template', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->proofing_user_confirmation_template, __('Possible substition fields: user_name, user_email, proof_link, proof_details', 'nextgen-gallery-pro'));
    }
}
class A_NextGen_Pro_Proofing_Trigger_Element extends Mixin
{
    public function render_object()
    {
        $root_element = $this->call_parent('render_object');
        if (($displayed_gallery = $this->object->get_param('displayed_gallery')) && !empty($displayed_gallery->display_settings['ngg_proofing_display'])) {
            foreach ($root_element->find('nextgen_gallery.gallery_container', TRUE) as $container) {
                $div = '<div class="ngg-pro-proofing-trigger-link" data-gallery-id="' . $displayed_gallery->id() . '"><a href="#" class="ngg_pro_proofing_btn ngg_pro_btn">';
                $div .= C_NextGen_Settings::get_instance()->proofing_trigger_text;
                $div .= '</a></div>';
                $container->append($div);
            }
        }
        return $root_element;
    }
}
/**
 * Class A_NextGen_Pro_Proofing_Trigger_Resources
 * Provides frontend resources for image proofing
 */
class A_NextGen_Pro_Proofing_Trigger_Resources extends Mixin
{
    protected $run_once = FALSE;
    public function enqueue_frontend_resources($displayed_gallery)
    {
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        return $this->enqueue_nextgen_proofing_trigger_buttons_resources($displayed_gallery);
    }
    public function enqueue_nextgen_proofing_trigger_buttons_resources($displayed_gallery = FALSE)
    {
        $retval = FALSE;
        if (!$this->run_once && !empty($displayed_gallery) && !empty($displayed_gallery->display_settings['ngg_proofing_display'])) {
            $router = C_Component_Registry::get_instance()->get_utility('I_Router');
            wp_enqueue_script('jquery-placeholder', $router->get_static_url('photocrati-nextgen_admin#jquery.placeholder.min.js'), 'jquery', FALSE, FALSE);
            wp_enqueue_script('ngg-pro-proofing-script', $router->get_static_url('photocrati-nextgen_pro_proofing#nextgen_pro-proofing.js'), array('jquery', 'underscore', 'jquery-placeholder', 'nextgen_pro_captions-js'), FALSE, FALSE);
            wp_localize_script('ngg-pro-proofing-script', 'ngg_pro_proofing_i18n', array('image_list' => __('Submitting {0} image{1}', 'nextgen-gallery-pro'), 'submit_cancel' => __('Cancel', 'nextgen-gallery-pro'), 'submit_button' => __('Send', 'nextgen-gallery-pro'), 'submit_message' => __('Submitting...', 'nextgen-gallery-pro'), 'example_name' => __('Name', 'nextgen-gallery-pro'), 'example_email' => __('Email', 'nextgen-gallery-pro'), 'nggpl_title' => __('Proof image?', 'nextgen-gallery-pro')));
            $deps = false;
            if (wp_script_is('ngg-trigger-buttons', 'registered')) {
                $deps = array('ngg-trigger-buttons');
            }
            wp_enqueue_style('ngg-pro-proofing-style', $router->get_static_url('photocrati-nextgen_pro_proofing#nextgen_pro-proofing.css'), $deps);
            $this->run_once = TRUE;
        }
        return $retval;
    }
}
class C_NextGen_Pro_Proofing extends C_DataMapper_Model
{
    public $_mapper_interface = 'I_NextGen_Pro_Proofing_Mapper';
    public function define($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        parent::define($mapper, $properties, $context);
    }
    public function initialize($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        if (!$mapper) {
            $mapper = $this->get_registry()->get_utility($this->_mapper_interface);
        }
        parent::initialize($mapper, $properties);
    }
}
class C_NextGen_Pro_Proofing_Controller extends C_MVC_Controller
{
    static $instance = NULL;
    static function get_instance()
    {
        if (!self::$instance) {
            $klass = get_class();
            self::$instance = new $klass();
        }
        return self::$instance;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_style('nextgen_pro_proofing-confirmation', $this->get_static_url('photocrati-nextgen_pro_proofing#confirmation.css'));
    }
    public function index_action()
    {
        $this->enqueue_static_resources();
        $settings = C_NextGen_Settings::get_instance();
        $retval = $settings->proofing_user_confirmation_not_found;
        if ($proof = C_NextGen_Pro_Proofing_Mapper::get_instance()->find_by_hash($this->param('proof'), TRUE)) {
            $image_mapper = C_Image_Mapper::get_instance();
            $images = array();
            foreach ($proof->proofed_gallery['image_list'] as $image_id) {
                $images[] = $image_mapper->find($image_id);
            }
            $message = $settings->proofing_user_confirmation_template;
            if (preg_match_all('/%%(\\w+)%%/', $settings->proofing_user_confirmation_template, $matches, PREG_SET_ORDER) > 0) {
                foreach ($matches as $match) {
                    switch ($match[1]) {
                        case 'user_name':
                            $message = str_replace('%%user_name%%', $proof->customer_name, $message);
                            break;
                        case 'user_email':
                            $message = str_replace('%%user_email%%', $proof->email, $message);
                            break;
                        case 'proof_link':
                            $message = str_replace('%%proof_link%%', $proof->referer, $message);
                            break;
                        case 'proof_details':
                            $imagehtml = $this->object->render_partial('photocrati-nextgen_pro_proofing#confirmation', array('images' => $images, 'storage' => C_Gallery_Storage::get_instance()), TRUE);
                            $message = str_replace('%%proof_details%%', $imagehtml, $message);
                            break;
                    }
                }
                $retval = $message;
            }
        }
        return $retval;
    }
}
class C_NextGen_Pro_Proofing_Lightbox
{
    static $_localized_once = FALSE;
    /**
     * lightbox_overrides.js holds all of the pro-lightbox related proofing features
     */
    public function enqueue_static_resources()
    {
        if (!self::$_localized_once) {
            self::$_localized_once = TRUE;
            $router = C_Router::get_instance();
            wp_enqueue_script('ngg-pro-lightbox-proofing-js', $router->get_static_url('photocrati-nextgen_pro_proofing#lightbox_overrides.js'));
            wp_localize_script('ngg-pro-lightbox-proofing-js', 'ngg_proofing_settings', array('active_color' => C_NextGen_Settings::get_instance()->proofing_lightbox_active_color));
        }
    }
}
class C_NextGen_Pro_Proofing_Mapper extends C_CustomPost_DataMapper_Driver
{
    public static $_instances = array();
    public static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_NextGen_Pro_Proofing_Mapper();
        }
        return self::$_instances[$context];
    }
    public function define($context = FALSE)
    {
        $object_name = 'nextgen_proof';
        if (!is_array($context)) {
            $context = array($context);
        }
        array_push($context, $object_name);
        parent::define($object_name, $context);
        $this->add_mixin('Mixin_Proofing_Mapper');
        $this->set_model_factory_method($object_name);
        $this->define_column('ID', 'BIGINT', 0);
        $this->define_column('title', 'VARCHAR(255)');
        $this->define_column('email', 'VARCHAR(255)');
        $this->define_column('customer_name', 'VARCHAR(255)');
        $this->define_column('proofed_gallery', 'VARCHAR(255)');
        $this->define_column('referer', 'VARCHAR(255)');
        $this->define_column('hash', 'VARCHAR(255)');
    }
    public function initialize($context = FALSE)
    {
        parent::initialize('nextgen_proof');
    }
    public function find_by_hash($hash, $model = FALSE)
    {
        return array_pop($this->select()->where(array('hash = %s', $hash))->run_query(NULL, $model));
    }
}
class Mixin_Proofing_Mapper extends Mixin
{
    public function _save_entity($entity)
    {
        if (empty($entity->hash)) {
            $entity->hash = md5(time() . $entity->email . $entity->customer_name);
        }
        return $this->call_parent('_save_entity', $entity);
    }
    public function set_defaults($entity)
    {
        $entity->post_status = 'publish';
        $entity->post_title = $this->get_post_title($entity);
    }
    public function get_post_title($entity)
    {
        return $entity->title;
    }
}
class C_NextGen_Pro_Proofing_Trigger extends C_NextGen_Pro_Lightbox_Trigger
{
    public function get_css_class()
    {
        $classes = 'fa ngg-trigger ngg-trigger-proofing nextgen_pro_proofing fa-star';
        return $classes;
    }
    static function is_renderable($name, $displayed_gallery)
    {
        $retval = FALSE;
        if (self::is_pro_lightbox_enabled() && self::are_triggers_enabled($displayed_gallery) && self::does_source_return_images($displayed_gallery) && isset($displayed_gallery->display_settings['ngg_proofing_display']) && $displayed_gallery->display_settings['ngg_proofing_display']) {
            $retval = TRUE;
        }
        return $retval;
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
        return $retval;
    }
}