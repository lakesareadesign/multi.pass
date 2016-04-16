<?php
class A_Digital_Downloads_Form extends Mixin
{
    public function get_title()
    {
        return __('Digital Downloads', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('digital_downloads');
    }
    public function save_action()
    {
        return $this->get_model()->is_valid();
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script('nextgen_pro_lightbox_digital_downloads_form_settings', $this->get_static_url('photocrati-nextgen_pro_ecommerce#ecommerce_downloads_settings.js'), array('jquery-ui-tooltip'));
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->show_licensing_link = __('Display link to license terms?', 'nextgen-gallery-pro');
        $i18n->licensing_page = __('Licensing page:', 'nextgen-gallery-pro');
        $i18n->name_header = __('Name:', 'nextgen-gallery-pro');
        $i18n->price_header = __('Price:', 'nextgen-gallery-pro');
        $i18n->resolution_header = __('Longest Image Dimension:', 'nextgen-gallery-pro');
        $i18n->resolution_tooltip = __('A setting of 0px will deliver full-resolution images', 'nextgen-gallery-pro');
        $i18n->resolution_placeholder = __('Enter 0 for maximum', 'nextgen-gallery-pro');
        $i18n->item_title_placeholder = __('Enter title of the item', 'nextgen-gallery-pro');
        $i18n->delete = __('Delete', 'nextgen-gallery-pro');
        $i18n->add_another_item = __('Add another item', 'nextgen-gallery-pro');
        $i18n->no_items = __('No items available for this source.', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function get_image_resolutions()
    {
        $retval = array('100' => 'Full');
        for ($i = 90; $i > 0; $i -= 10) {
            $retval[$i] = "{$i}%";
        }
        return $retval;
    }
    public function get_pages()
    {
        return get_pages(array('number' => 100));
    }
    public function _render_digital_downloads_field()
    {
        $items = $this->get_model()->get_digital_downloads();
        if (!$items) {
            $item = new stdClass();
            $item->ID = uniqid('new-');
            $item->title = '';
            $item->price = '';
            $item->resolution = 0;
            $item->source = NGG_PRO_DIGITAL_DOWNLOADS_SOURCE;
            $item->post_status = 'publish';
            $items[] = $item;
        }
        return $this->object->render_partial('photocrati-nextgen_pro_ecommerce#digital_downloads', array('items' => $items, 'settings' => $this->get_model()->digital_download_settings, 'i18n' => $this->object->get_i18n_strings(), 'image_resolutions' => $this->object->get_image_resolutions(), 'pages' => $this->object->get_pages(), 'item_source' => NGG_PRO_DIGITAL_DOWNLOADS_SOURCE), TRUE);
    }
}
class A_Display_Type_Ecommerce_Form extends Mixin
{
    public function _get_field_names()
    {
        $fields = $this->call_parent('_get_field_names');
        // Add an option to enable e-commerce only if there are pricelists created
        if (C_Pricelist_Mapper::get_instance()->count() > 0) {
            if (is_array($fields)) {
                $fields[] = 'is_ecommerce_enabled';
            }
        }
        return $fields;
    }
    public function _render_is_ecommerce_enabled_field($display_type)
    {
        $output = $this->object->_render_radio_field($display_type, 'is_ecommerce_enabled', __('Enable ecommerce?', 'nextgen-gallery-pro'), isset($display_type->settings['is_ecommerce_enabled']) ? $display_type->settings['is_ecommerce_enabled'] : FALSE);
        // Add instructions link
        $label = esc_attr(__('see instructions', 'nextgen-gallery-pro'));
        $href = esc_attr(admin_url('/admin.php?page=ngg-ecommerce-instructions-page'));
        if (($index = strpos($output, '</label>')) !== FALSE) {
            $start = substr($output, 0, $index);
            $end = substr($output, $index);
            $output = $start . "<em style='font-size: smaller; display: block; font-style: italic'><a href='{$href}' target='_blank'>({$label})</a></em>" . $end;
        }
        return $output;
    }
}
class A_Ecommerce_Ajax extends Mixin
{
    /**
     * Read an image file into memory and display it
     *
     * This is necessary for htaccess or server-side protection that blocks access to filenames ending with "_backup"
     * At the moment it only supports the backup or full size image.
     */
    public function get_image_file_action()
    {
        $order_id = $this->param('order_id', FALSE);
        $image_id = $this->param('image_id', FALSE);
        $bail = FALSE;
        if (!$order_id || !$image_id) {
            $bail = TRUE;
        }
        $order = C_Order_Mapper::get_instance()->find_by_hash($order_id);
        if (!in_array($image_id, $order->cart['image_ids'])) {
            $bail = TRUE;
        }
        if ($order->status != 'verified') {
            $bail = TRUE;
        }
        if ($bail) {
            header('HTTP/1.1 404 Not found');
            die;
        }
        $storage = C_Gallery_Storage::get_instance();
        if (version_compare(NGG_PLUGIN_VERSION, '2.0.66.99') <= 0) {
            // Pre 2.0.67 didn't fallback to the original path if the backup file didn't exist
            $imagemapper = C_Image_Mapper::get_instance();
            $fs = C_Fs::get_instance();
            $image = $imagemapper->find($image_id);
            $gallery_path = $storage->get_gallery_abspath($image->galleryid);
            $abspath = $fs->join_paths($gallery_path, $image->filename . '_backup');
            if (!@file_exists($abspath)) {
                $abspath = $storage->get_image_abspath($image_id, 'full');
            }
        } else {
            $abspath = $storage->get_image_abspath($image_id, 'backup');
        }
        $mimetype = 'application/octet';
        if (function_exists('finfo_buffer')) {
            $finfo = new finfo(FILEINFO_MIME);
            $mimetype = @$finfo->file($abspath);
        } elseif (function_exists('mime_content_type')) {
            $mimetype = @mime_content_type($abspath);
        }
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . basename($storage->get_image_abspath($image_id, 'full')));
        header('Content-type: ' . $mimetype);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . @filesize($abspath));
        readfile($abspath);
        die;
    }
    public function get_digital_download_settings_action()
    {
        $retval = array();
        if ($pricelist = C_Pricelist_Mapper::get_instance()->find_for_image($this->param('image_id'))) {
            $retval = $pricelist->digital_download_settings;
            $retval['header'] = esc_html(__('Digital Downloads', 'nextgen-gallery-pro'));
            if (intval($retval['show_licensing_link']) > 0) {
                $retval['licensing_link'] = get_page_link($retval['licensing_page_id']);
                $view_licensing_terms = __('View license terms', 'nextgen-gallery-pro');
                $retval['header'] .= " <a href='{$retval['licensing_link']}'>({$view_licensing_terms})</a>";
            }
        }
        return $retval;
    }
    public function get_cart_items_action()
    {
        $cart = new C_NextGen_Pro_Cart($this->param('cart'));
        return $cart->to_array();
    }
    public function get_shipping_amount_action()
    {
        $cart = new C_NextGen_Pro_Cart($this->param('cart'));
        return array('shipping' => $cart->get_shipping($this->param('use_home_country')));
    }
    public function get_image_items_action()
    {
        $retval = array();
        if ($image_id = $this->param('image_id')) {
            $cart = $this->param('cart');
            if ($pricelist = C_Pricelist_Mapper::get_instance()->find_for_image($image_id, TRUE)) {
                $retval = $pricelist->get_items($image_id);
                // Determine if the item is in the cart. If so, set the item's quantity
                if (isset($cart['images'][$image_id])) {
                    foreach ($retval as &$item) {
                        foreach ($cart['images'][$image_id]['items'] as $item_id => $item_props) {
                            if ($item->{$item->id_field} == $item_id) {
                                $item->quantity = $item_props['quantity'];
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $retval;
    }
    public function is_order_verified_action()
    {
        $retval = array('verified' => FALSE);
        if ($order = C_Order_Mapper::get_instance()->find_by_hash($this->param('order'))) {
            if ($order->status == 'verified') {
                $retval['verified'] = TRUE;
                $checkout = C_NextGen_Pro_Checkout::get_instance();
                $retval['thank_you_page_url'] = $checkout->get_thank_you_page_url($order->hash, TRUE);
            }
        } else {
            $retval['error'] = __('We\'re sorry, but we couldn\'t find your order.', 'nextgen-gallery-pro');
        }
        return $retval;
    }
}
class A_Ecommerce_Factory extends Mixin
{
    public function ngg_pricelist($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return new C_Pricelist($properties, $mapper, $context);
    }
    public function pricelist($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return $this->ngg_pricelist($properties, $mapper, $context);
    }
    public function ngg_pricelist_item($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return new C_Pricelist_Item($properties, $mapper, $context);
    }
    public function pricelist_item($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return $this->pricelist_item($properties, $mapper, $context);
    }
    public function ngg_order($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return new C_NextGen_Pro_Order($properties, $mapper, $context);
    }
    public function order($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return $this->ngg_order($properties, $mapper, $context);
    }
}
class A_Ecommerce_Gallery extends Mixin
{
    public function define_columns()
    {
        $this->object->define_column('pricelist_id', 'BIGINT', 0, TRUE);
    }
}
class A_Ecommerce_Image extends Mixin
{
    public function define_columns()
    {
        $this->object->define_column('pricelist_id', 'BIGINT', 0, TRUE);
    }
}
class A_Ecommerce_Instructions_Controller extends C_NextGen_Admin_Page_Controller
{
    public function get_page_title()
    {
        return __('Instructions', 'nextgen-gallery-pro');
    }
    public function get_page_heading()
    {
        return __('Instructions', 'nextgen-gallery-pro');
    }
    public function get_required_permission()
    {
        return 'NextGEN Change options';
    }
}
class A_Ecommerce_Instructions_Form extends Mixin
{
    public function get_title()
    {
        return $this->get_page_heading();
    }
    public function get_page_heading()
    {
        return __('Getting Started', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('ecommerce_instructions');
    }
    public function _render_ecommerce_instructions_field()
    {
        return $this->render_partial('photocrati-nextgen_pro_ecommerce#instructions', array('i18n' => $this->get_i18n_strings()), TRUE);
    }
    public function get_i18n_strings()
    {
        $retval = new stdClass();
        $retval->ecomm_header = __('How to create a gallery with ecommerce', 'nextgen-gallery-pro');
        $retval->ecomm_step_1 = sprintf(__('Configure your %s.', 'nextgen-gallery-pro'), sprintf('<a href="%s" id="ecommerce_step_1">%s</a>', admin_url('admin.php?page=ngg_ecommerce_options'), __('ecommerce settings', 'nextgen-gallery-pro')));
        $retval->ecomm_step_2 = sprintf(__('Create one or more %s.', 'nextgen-gallery-pro'), sprintf('<a href="%s">%s</a>', admin_url('edit.php?post_type=ngg_pricelist'), __('pricelists', 'nextgen-gallery-pro')));
        $retval->ecomm_step_3 = sprintf(__('Using the %s page, associate a pricelist with any gallery or image you would like to sell.', 'nextgen-gallery-pro'), sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=nggallery-manage-gallery'), __('Manage Galleries', 'nextgen-gallery-pro')));
        $retval->ecomm_step_4 = __('When adding or editing a gallery via the NextGEN Insert Gallery Window, be sure to enable ecommerce.', 'nextgen-gallery-pro');
        $retval->ecomm_step_5 = __('Be sure to select ', 'nextgen-gallery-pro') . sprintf('<a href=\'%s\'>%s</a>', admin_url('admin.php?page=ngg_other_options#lightbox_effects'), __('NextGEN Pro Lightbox', 'nextgen-gallery-pro')) . __(' as your desired lightbox effect.', 'nextgen-gallery-pro');
        $retval->additional_documentation = sprintf(__('Additional Documentation on %s', 'nextgen-gallery-pro'), sprintf('<a target=\'_blank\' href=\'%s\'>%s</a>', 'http://www.nextgen-gallery.com', __('nextgen-gallery.com', 'nextgen-gallery-pro')));
        $retval->documentation_links = array('http://www.nextgen-gallery.com/ecommerce-overview' => __('Ecommerce Overview', 'nextgen-gallery-pro'), 'http://www.nextgen-gallery.com/ecommerce-settings' => __('How to Configure Ecommerce Options', 'nextgen-gallery-pro'), 'http://www.nextgen-gallery.com/create-pricelist' => __('How to Create and Assign a Pricelist', 'nextgen-gallery-pro'), 'http://www.nextgen-gallery.com/add-ecommerce/' => __('How to Add Ecommerce to a Gallery', 'nextgen-gallery-pro'));
        $retval->proofing_header = __('How to create a proofing gallery', 'nextgen-gallery-pro');
        $retval->proofing_step_1 = sprintf(__('Configure your %s.', 'nextgen-gallery-pro'), sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=ngg_ecommerce_options'), __('proofing settings', 'nextgen-gallery-pro')));
        $retval->proofing_step_2 = sprintf(__('Select %s as your desired lightbox effect.', 'nextgen-gallery-pro'), sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=ngg_other_options'), __('NextGen Pro Lightbox', 'nextgen-gallery-pro')));
        $retval->proofing_step_3 = __('When adding a gallery via the NextGen Insert Gallery Window, click the option to enable proofing.', 'nextgen-gallery-pro');
        return $retval;
    }
}
class A_Ecommerce_Options_Controller extends Mixin
{
    public function get_page_title()
    {
        return __('Ecommerce Options', 'nextgen-gallery-pro');
    }
    public function get_page_heading()
    {
        return $this->get_page_title();
    }
    public function get_required_permission()
    {
        return 'NextGEN Change options';
    }
    public function save_action()
    {
        if ($updates = $this->param('ecommerce')) {
            $settings = C_NextGen_Settings::get_instance();
            foreach ($updates as $key => $value) {
                $key = "ecommerce_{$key}";
                $settings->{$key} = $value;
            }
            $settings->save();
        }
    }
}
class A_Ecommerce_Options_Form extends Mixin
{
    public function get_title()
    {
        return $this->get_page_heading();
    }
    public function get_page_heading()
    {
        return __('General Options', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('nextgen_pro_ecommerce_home_country', 'nextgen_pro_ecommerce_currency', 'nextgen_pro_ecommerce_page_checkout', 'nextgen_pro_ecommerce_page_thanks', 'nextgen_pro_ecommerce_page_cancel', 'nextgen_pro_ecommerce_page_digital_downloads', 'nextgen_pro_ecommerce_not_for_sale_msg');
    }
    public function save_action()
    {
        $ecommerce = $this->param('ecommerce');
        if (empty($ecommerce)) {
            return;
        }
        $settings = C_NextGen_Settings::get_instance();
        $settings->ecommerce_home_country = $ecommerce['home_country'];
        $settings->ecommerce_currency = $ecommerce['currency'];
        if ($ecommerce['page_checkout'] == '') {
            $settings->ecommerce_page_checkout = $this->create_new_page(__('Shopping Cart', 'nextgen-gallery-pro'), '[ngg_pro_checkout]');
        } else {
            $this->add_shortcode_to_post($settings->ecommerce_page_checkout = $ecommerce['page_checkout'], '[ngg_pro_checkout]');
        }
        if ($ecommerce['page_thanks'] == '') {
            $settings->ecommerce_page_thanks = $this->create_new_page(__('Thanks', 'nextgen-gallery-pro'), '[ngg_pro_order_details]');
        } else {
            $this->add_shortcode_to_post($settings->ecommerce_page_thanks = $ecommerce['page_thanks'], '[ngg_pro_order_details]');
        }
        if ($ecommerce['page_cancel'] == '') {
            $settings->ecommerce_page_cancel = $this->create_new_page(__('Order Cancelled', 'nextgen-gallery-pro'), __('You order was cancelled.', 'nextgen-gallery-pro'));
        } else {
            $this->add_shortcode_to_post($settings->ecommerce_page_cancel = $ecommerce['page_cancel'], __('Your order was cancelled', 'nextgen-gallery-pro'), TRUE);
        }
        if ($ecommerce['page_digital_downloads'] == '') {
            $settings->ecommerce_page_digital_downloads = $this->create_new_page(__('Digital Downloads', 'nextgen-gallery-pro'), __('[ngg_pro_digital_downloads]'));
        } else {
            $this->add_shortcode_to_post($settings->ecommerce_page_digital_downloads = $ecommerce['page_digital_downloads'], '[ngg_pro_digital_downloads]');
        }
        $settings->save();
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
    public function enqueue_static_resources()
    {
        $this->call_parent('enqueue_static_resources');
        wp_enqueue_style('photocrati-nextgen_pro_ecommerce_options', $this->get_static_url('photocrati-nextgen_pro_ecommerce#ecommerce_options.css'));
        wp_enqueue_script('photocrati-nextgen_pro_ecommerce_options-settings-js', $this->get_static_url('photocrati-nextgen_pro_ecommerce#ecommerce_options_form_settings.js'), array('jquery', 'jquery-ui-tooltip'));
        wp_localize_script('photocrati-nextgen_pro_ecommerce_options-settings-js', 'NGG_Pro_EComm_Settings', array('iso_4217_countries' => C_NextGen_Pro_Currencies::$countries));
    }
    public function create_new_page($title, $content)
    {
        global $user_ID;
        $page = array('post_type' => 'page', 'post_status' => 'publish', 'post_content' => $content, 'post_author' => $user_ID, 'post_title' => $title, 'comment_status' => 'closed');
        return wp_insert_post($page);
    }
    public function _render_nextgen_pro_ecommerce_not_for_sale_msg_field()
    {
        $settings = C_NextGen_Settings::get_instance();
        // _render_select_field only needs $model->name
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_textarea_field($model, 'not_for_sale_msg', __('"Not for sale" Message', 'nextgen-gallery-pro'), $settings->ecommerce_not_for_sale_msg);
    }
    public function _render_nextgen_pro_ecommerce_home_country_field($model)
    {
        $settings = C_NextGen_Settings::get_instance();
        // _render_select_field only needs $model->name
        $model = new stdClass();
        $model->name = 'ecommerce';
        $countries = array();
        foreach (C_NextGen_Pro_Currencies::$countries as $country) {
            $countries[$country['id']] = $country['name'];
        }
        return $this->_render_select_field($model, 'home_country', __('Home Country', 'nextgen-gallery-pro'), $countries, $settings->ecommerce_home_country);
    }
    public function _retrieve_page_list()
    {
        $pages = apply_filters('ngg_ecommerce_page_list', get_pages());
        $options = array('' => __('Create new', 'nextgen-gallery-pro'));
        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }
        return $options;
    }
    public function _render_nextgen_pro_ecommerce_currency_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        $currencies = array();
        foreach (C_NextGen_Pro_Currencies::$currencies as $id => $currency) {
            $currencies[$id] = $currency['name'];
        }
        return $this->_render_select_field($model, 'currency', __('Currency', 'nextgen-gallery-pro'), $currencies, C_NextGen_Settings::get_instance()->ecommerce_currency);
    }
    public function _render_nextgen_pro_ecommerce_page_checkout_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        $pages = $this->_retrieve_page_list();
        return $this->_render_select_field($model, 'page_checkout', __('Checkout page', 'nextgen-gallery-pro'), $pages, C_NextGen_Settings::get_instance()->ecommerce_page_checkout, __('This page requires the [ngg_pro_checkout] shortcode, which will be automatically added if not already present. Selecting "Create new" will create a new page that will appear in your Primary Menu unless you\'ve customized your menu settings: http://codex.wordpress.org/Appearance_Menus_SubPanel', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_ecommerce_page_thanks_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        $pages = $this->_retrieve_page_list();
        return $this->_render_select_field($model, 'page_thanks', __('Thank-you page', 'nextgen-gallery-pro'), $pages, C_NextGen_Settings::get_instance()->ecommerce_page_thanks, __('This page should have the [ngg_pro_order_details] shortcode, which will be automatically added if not already present. Selecting "Create new" will create a new page that will appear in your Primary Menu unless you\'ve customized your menu settings: http://codex.wordpress.org/Appearance_Menus_SubPanel', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_ecommerce_page_cancel_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        $pages = $this->_retrieve_page_list();
        return $this->_render_select_field($model, 'page_cancel', __('Cancel page', 'nextgen-gallery-pro'), $pages, C_NextGen_Settings::get_instance()->ecommerce_page_cancel, __('Selecting "Create new" will create a new page that will appear in your Primary Menu unless you\'ve customized your menu settings: http://codex.wordpress.org/Appearance_Menus_SubPanel', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_ecommerce_page_digital_downloads_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        $pages = $this->_retrieve_page_list();
        return $this->_render_select_field($model, 'page_digital_downloads', __('Digital downloads page', 'nextgen-gallery-pro'), $pages, C_NextGen_Settings::get_instance()->ecommerce_page_digital_downloads, __('This page requires the [ngg_pro_digital_downloads] shortcode, which will be automatically added if not already present. Selecting "Create new" will create a new page that will appear in your Primary Menu unless you\'ve customized your menu settings: http://codex.wordpress.org/Appearance_Menus_SubPanel', 'nextgen-gallery-pro'));
    }
}
class A_Ecommerce_Pages extends Mixin
{
    public function setup()
    {
        $this->object->add(NGG_PRO_ECOMMERCE_OPTIONS_PAGE, array('adapter' => 'A_Ecommerce_Options_Controller', 'parent' => 'ngg_ecommerce_options', 'add_menu' => TRUE));
        $this->object->add('ngg_manage_pricelists', array('url' => '/edit.php?post_type=ngg_pricelist', 'menu_title' => __('Manage Pricelists', 'nextgen-gallery-pro'), 'permission' => 'NextGEN Change options', 'parent' => 'ngg_ecommerce_options'));
        $this->object->add('ngg_manage_orders', array('url' => '/edit.php?post_type=ngg_order', 'menu_title' => __('View Orders', 'nextgen-gallery-pro'), 'permission' => 'NextGEN Change options', 'parent' => 'ngg_ecommerce_options'));
        $this->object->add('ngg_manage_proofs', array('url' => '/edit.php?post_type=nextgen_proof', 'menu_title' => __('View Proofs', 'nextgen-gallery-pro'), 'permission' => 'NextGEN Change options', 'parent' => 'ngg_ecommerce_options'));
        $this->object->add(NGG_PRO_ECOMMERCE_INSTRUCTIONS_PAGE, array('adapter' => 'A_Ecommerce_Instructions_Controller', 'parent' => 'ngg_ecommerce_options'));
        return $this->call_parent('setup');
    }
}
class A_Ecommerce_Pro_Lightbox_Form extends A_NextGen_Pro_Lightbox_Form
{
    public function _get_field_names()
    {
        $fields = $this->call_parent('_get_field_names');
        $fields[] = 'ecommerce_pro_lightbox_display_cart';
        return $fields;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script('ngg_pro_ecommerce_lightbox_form', $this->object->get_static_url('photocrati-nextgen_pro_ecommerce#ecommerce_pro_lightbox_form.js'));
        return $this->call_parent('enqueue_static_resources');
    }
    public function _render_ecommerce_pro_lightbox_display_cart_field($lightbox)
    {
        $value = NULL;
        if (is_array($lightbox->values) && isset($lightbox->values['nplModalSettings'])) {
            if (isset($lightbox->values['nplModalSettings']['display_cart'])) {
                $value = $lightbox->values['nplModalSettings']['display_cart'];
            }
        } elseif (isset($lightbox->display_settings['display_cart'])) {
            $value = $lightbox->display_settings['display_cart'];
        }
        return $this->_render_radio_field($lightbox, 'display_cart', __('Display cart', 'nextgen-gallery-pro'), $value, __('When on the cart sidebar will be opened at startup. If the "Display Comments" option is also on the comments panel will open instead.', 'nextgen-gallery-pro'));
    }
}
class A_Manual_Pricelist_Form extends Mixin
{
    public function get_title()
    {
        return __('Manual Pricelist', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('manual_pricelist_items');
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->name_header = __('Name', 'nextgen-gallery-pro');
        $i18n->price_header = __('Price', 'nextgen-gallery-pro');
        $i18n->item_title_placeholder = __('Enter title of the item', 'nextgen-gallery-pro');
        $i18n->delete = __('Delete', 'nextgen-gallery-pro');
        $i18n->add_another_item = __('Add another item', 'nextgen-gallery-pro');
        $i18n->no_items = __('No items available for this source.', 'nextgen-gallery-pro');
        $i18n->domestic_shipping = __('Domestic shipping rate:', 'nextgen-gallery-pro');
        $i18n->global_shipping = __('International shipping rate:', 'nextgen-gallery-pro');
        $i18n->allow_global_shipping = __('Enable international shipping rate?', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function save_action()
    {
        return $this->get_model()->is_valid();
    }
    public function _render_manual_pricelist_items_field()
    {
        $items = $this->get_model()->get_manual_items();
        if (!$items) {
            $item = new stdClass();
            $item->ID = uniqid('new-');
            $item->title = '';
            $item->price = '';
            $item->source = NGG_PRO_MANUAL_PRICELIST_SOURCE;
            $item->post_status = 'publish';
            $items[] = $item;
        }
        return $this->object->render_partial('photocrati-nextgen_pro_ecommerce#manual_pricelist', array('items' => $items, 'manual_settings' => $this->get_model()->manual_settings, 'i18n' => $this->get_i18n_strings(), 'shipping_methods' => $this->object->get_shipping_methods(), 'item_source' => NGG_PRO_MANUAL_PRICELIST_SOURCE), TRUE);
    }
    public function get_shipping_methods()
    {
        return array('flat' => __('Flat Rate', 'nextgen-gallery-pro'), 'percentage' => __('Percentage', 'nextgen-gallery-pro'));
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_style('ngg-pro-lightbox-admin', $this->object->get_static_url('photocrati-nextgen_pro_ecommerce#admin.css'));
        wp_enqueue_script('ngg-pro-lightbox-admin', $this->object->get_static_url('photocrati-nextgen_pro_ecommerce#admin.js'));
    }
}
class A_NextGen_Pro_Lightbox_Mail_Form extends Mixin
{
    public function get_title()
    {
        return __('E-mail', 'nextgen-gallery-pro');
    }
    public function get_page_heading()
    {
        return __('E-mail Settings', 'nextgen-gallery-pro');
    }
    public function _get_field_names()
    {
        return array('ngg_pro_ecommerce_email_notification_subject', 'ngg_pro_ecommerce_email_notification_recipient', 'ngg_pro_ecommerce_email_notification_body', 'ngg_pro_ecommerce_enable_email_receipt', 'ngg_pro_ecommerce_email_receipt_subject', 'ngg_pro_ecommerce_email_receipt_body');
    }
    public function get_proxy_model()
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $model;
    }
    public function get_model()
    {
        return $settings = C_Settings_Model::get_instance();
    }
    public function _render_ngg_pro_ecommerce_email_notification_subject_field()
    {
        return $this->_render_text_field($this->get_proxy_model(), 'email_notification_subject', __('Order notification e-mail subject:', 'nextgen-gallery-pro'), $this->get_model()->ecommerce_email_notification_subject, NULL, NULL, __('Subject', 'nextgen-gallery-pro'));
    }
    public function _render_ngg_pro_ecommerce_email_notification_recipient_field()
    {
        return $this->_render_text_field($this->get_proxy_model(), 'email_notification_recipient', __('Order notification e-mail recipient:', 'nextgen-gallery-pro'), $this->get_model()->ecommerce_email_notification_recipient, NULL, NULL, __('john@example.com', 'nextgen-gallery-pro'));
    }
    public function _render_ngg_pro_ecommerce_email_notification_body_field()
    {
        return $this->_render_textarea_field($this->get_proxy_model(), 'email_notification_body', __('Order notification e-mail content:', 'nextgen-gallery-pro'), $this->get_model()->ecommerce_email_notification_body, __('Wrap placeholders in %%param%%. Accepted placeholders: customer_name, email, total_amount, item_count, shipping_street_address, shipping_city, shipping_state, shipping_zip, shipping_country, order_id, hash, order_details_page, admin_email, blog_name, blog_description, blog_url, site_url, home_url, and file_list', 'nextgen-gallery-pro'), NULL);
    }
    public function _render_ngg_pro_ecommerce_enable_email_receipt_field()
    {
        $model = $this->get_model();
        return $this->_render_radio_field($this->get_proxy_model(), 'enable_email_receipt', __('Send e-mail receipt to customer?', 'nextgen-gallery-pro'), $model->ecommerce_enable_email_receipt, __('If enabled a receipt will be sent to the customer after successful checkout', 'nextgen-gallery-pro'));
    }
    public function _render_ngg_pro_ecommerce_email_receipt_subject_field()
    {
        $model = $this->get_model();
        return $this->_render_text_field($this->get_proxy_model(), 'email_receipt_subject', __('E-mail subject:', 'nextgen-gallery-pro'), $this->get_model()->ecommerce_email_receipt_subject, NULL, $model->ecommerce_enable_email_receipt ? FALSE : TRUE, __('Subject', 'nextgen-gallery-pro'));
    }
    public function _render_ngg_pro_ecommerce_email_receipt_body_field()
    {
        $model = $this->get_model();
        return $this->_render_textarea_field($this->get_proxy_model(), 'email_receipt_body', __('E-mail content:', 'nextgen-gallery-pro'), $this->get_model()->ecommerce_email_receipt_body, __('Wrap placeholders in %%param%%. Accepted placeholders: customer_name, email, total_amount, item_count, shipping_street_address, shipping_city, shipping_state, shipping_zip, shipping_country, order_id, hash, order_details_page, admin_email, blog_name, blog_description, blog_url, site_url, and home_url', 'nextgen-gallery-pro'), $model->ecommerce_enable_email_receipt ? FALSE : TRUE);
    }
}
class A_NplModal_Ecommerce_Overrides extends Mixin
{
    public function enqueue_lightbox_resources($displayed_gallery)
    {
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->thumbEffect == NGG_PRO_LIGHTBOX) {
            wp_enqueue_script('ngg_nplmodal_ecommerce', $this->get_static_url('photocrati-nextgen_pro_ecommerce#nplmodal_overrides.js'));
        }
        $this->call_parent('enqueue_lightbox_resources', $displayed_gallery);
    }
}
class A_Payment_Gateway_Form extends Mixin
{
    public function get_title()
    {
        return $this->get_page_heading();
    }
    public function get_page_heading()
    {
        return __('Payment Gateway', 'nextgen-gallery-pro');
    }
    /**
     * These should be moved to their appropriate module
     * @return array
     */
    public function _get_field_names()
    {
        return array('nextgen_pro_ecommerce_test_gateway_enable', 'nextgen_pro_ecommerce_cheque_enable', 'nextgen_pro_ecommerce_cheque_instructions', 'nextgen_pro_ecommerce_stripe_enable', 'nextgen_pro_ecommerce_stripe_key_public', 'nextgen_pro_ecommerce_stripe_key_private', 'nextgen_pro_ecommerce_paypal_enable', 'nextgen_pro_ecommerce_paypal_sandbox', 'nextgen_pro_ecommerce_paypal_email', 'nextgen_pro_ecommerce_paypal_username', 'nextgen_pro_ecommerce_paypal_password', 'nextgen_pro_ecommerce_paypal_signature');
    }
    public function save_action()
    {
        $ecommerce = $this->param('ecommerce');
        if (empty($ecommerce)) {
            return;
        }
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_script('photocrati-nextgen_pro_ecommerce_payment_gateway-settings-js', $this->get_static_url('photocrati-nextgen_pro_ecommerce#ecommerce_payment_gateway_form_settings.js'), array('jquery.nextgen_radio_toggle'));
    }
    public function _render_nextgen_pro_ecommerce_stripe_enable_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'stripe_enable', __('Enable Stripe', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_stripe_enable, __('Not all currencies are supported by all payment gateways. Please be sure to confirm your desired currency is supported by Stripe', 'nextgen-gallery-pro'));
    }
    /**
     * Displays a warning if the user has chosen a currency not available to Stripe.
     *
     * See: https://support.stripe.com/questions/which-currencies-does-stripe-support
     * @param $model
     * @return string
     */
    public function _render_nextgen_pro_ecommerce_stripe_currencies_supported_field($model)
    {
        $settings = C_NextGen_Settings::get_instance();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        $supported = array('AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EEK', 'EGP', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LTL', 'LVL', 'MAD', 'MDL', 'MGA', 'MKD', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SVC', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'UYU', 'UZS', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW');
        if (!in_array($currency['code'], $supported)) {
            $message = __('Stripe does not support your currently chosen currency', 'nextgen-gallery-pro');
            return "<tr id='tr_ecommerce_stripe_currencies_supported'><td colspan='2'>{$message}</td></tr>";
        }
    }
    public function _render_nextgen_pro_ecommerce_stripe_sandbox_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'stripe_sandbox', __('Use sandbox', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_stripe_sandbox, __('If enabled transactions will use testing servers on which no currency is actually moved', 'nextgen-gallery-pro'), !C_NextGen_Settings::get_instance()->ecommerce_stripe_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_stripe_key_public_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'stripe_key_public', __('Public key', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_stripe_key_public, '', !C_NextGen_Settings::get_instance()->ecommerce_stripe_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_stripe_key_private_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'stripe_key_private', __('Private key', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_stripe_key_private, '', !C_NextGen_Settings::get_instance()->ecommerce_stripe_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_paypal_enable_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'paypal_enable', __('Enable PayPal Express Checkout', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_enable, __('Not all currencies are supported by all payment gateways. Please be sure to confirm your desired currency is supported by PayPal', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_ecommerce_paypal_currencies_supported_field($model)
    {
        $settings = C_NextGen_Settings::get_instance();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        $supported = array('CAD', 'EUR', 'GBP', 'USD', 'JPY', 'AUD', 'NZD', 'CHF', 'HKD', 'SGD', 'SEK', 'DKK', 'PLN', 'NOK', 'HUF', 'CZK', 'ILS', 'MXN', 'BRL', 'MYR', 'PHP', 'TWD', 'THB', 'TRY', 'RUB');
        if (!in_array($currency['code'], $supported)) {
            $message = __('PayPal does not support your currently chosen currency', 'nextgen-gallery-pro');
            return "<tr id='tr_ecommerce_paypal_currencies_supported'><td colspan='2'>{$message}</td></tr>";
        }
    }
    public function _render_nextgen_pro_ecommerce_paypal_sandbox_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'paypal_sandbox', __('Use sandbox?', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_sandbox, __('If enabled transactions will use testing servers on which no currency is actually moved', 'nextgen-gallery-pro'), !C_NextGen_Settings::get_instance()->ecommerce_paypal_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_paypal_email_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'paypal_email', __('Email', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_email, '', !C_NextGen_Settings::get_instance()->ecommerce_paypal_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_paypal_username_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'paypal_username', __('API Username', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_username, '', !C_NextGen_Settings::get_instance()->ecommerce_paypal_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_paypal_password_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'paypal_password', __('API Password', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_password, '', !C_NextGen_Settings::get_instance()->ecommerce_paypal_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_paypal_signature_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_text_field($model, 'paypal_signature', __('API Signature', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_paypal_signature, '', !C_NextGen_Settings::get_instance()->ecommerce_paypal_enable ? TRUE : FALSE);
    }
    public function _render_nextgen_pro_ecommerce_test_gateway_enable_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'test_gateway_enable', __('Enable Testing Gateway', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_test_gateway_enable, __('Enables a gateway that does not collect payments and sends users directly to their order confirmation', 'nextgen-gallery-pro'));
    }
    public function _render_nextgen_pro_ecommerce_cheque_enable_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_radio_field($model, 'cheque_enable', __('Enable Checks', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_cheque_enable);
    }
    public function _render_nextgen_pro_ecommerce_cheque_instructions_field($model)
    {
        $model = new stdClass();
        $model->name = 'ecommerce';
        return $this->_render_textarea_field($model, 'cheque_instructions', __('Instructions', 'nextgen-gallery-pro'), C_NextGen_Settings::get_instance()->ecommerce_cheque_instructions, __('Use this to inform users how to pay and where they should send their payment', 'nextgen-gallery-pro'), !C_NextGen_Settings::get_instance()->ecommerce_cheque_enable ? TRUE : FALSE);
    }
}
class A_Reset_Ecommerce_Settings_Form extends Mixin
{
    public function render()
    {
        // Get the rendered form
        $retval = $this->call_parent('render');
        // Inject a paragraph, warning the user that this includes all Pro and e-commerce settings
        $warning = esc_html__('Please note that this includes all NextGEN Pro settings, including ecommerce options.');
        if (($index = strrpos($retval, '</td>')) !== FALSE) {
            $beginning = substr($retval, 0, $index);
            $end = substr($retval, $index);
            $retval = "{$beginning}<p><em>{$warning}</em></p>{$end}";
        }
        return $retval;
    }
}
/**
 * NextGEN Gallery 2.0.66 didn't have proper implementations of handling backup images
 */
class Mixin_Pro_Storage extends Mixin
{
    /**
     * Use the 'backup' image as the 'original' so that generated images use the backup image as their source
     *
     * @param $image
     * @param bool $check_existance
     *
     * @return mixed
     */
    public function get_original_abspath($image, $check_existance = FALSE)
    {
        return $this->object->get_image_abspath($image, 'backup', $check_existance);
    }
    /**
     * Gets the absolute path where the image is stored
     * Can optionally return the path for a particular sized image
     */
    public function get_image_abspath($image, $size = 'full', $check_existance = FALSE)
    {
        $retval = NULL;
        $fs = C_Fs::get_instance();
        // Ensure that we have a size
        if (!$size) {
            $size = 'full';
        }
        // If we have the id, get the actual image entity
        if (is_numeric($image)) {
            $image = $this->object->_image_mapper->find($image);
        }
        // Ensure we have the image entity - user could have passed in an
        // incorrect id
        if (is_object($image)) {
            if ($gallery_path = $this->object->get_gallery_abspath($image->galleryid)) {
                $folder = $prefix = $size;
                switch ($size) {
                    # Images are stored in the associated gallery folder
                    case 'full':
                    case 'original':
                    case 'image':
                        $retval = $fs->join_paths($gallery_path, $image->filename);
                        break;
                    case 'backup':
                        $retval = $fs->join_paths($gallery_path, $image->filename . '_backup');
                        if (!@file_exists($retval)) {
                            $retval = $fs->join_paths($gallery_path, $image->filename);
                        }
                        break;
                    case 'thumbnails':
                    case 'thumbnail':
                    case 'thumb':
                    case 'thumbs':
                        $size = 'thumbnail';
                        $folder = 'thumbs';
                        $prefix = 'thumbs';
                    // deliberately no break here
                    // We assume any other size of image is stored in the a
                    //subdirectory of the same name within the gallery folder
                    // gallery folder, but with the size appended to the filename
                    default:
                        $image_path = $fs->join_paths($gallery_path, $folder);
                        // NGG 2.0 stores relative filenames in the meta data of
                        // an image. It does this because it uses filenames
                        // that follow conventional WordPress naming scheme.
                        if (isset($image->meta_data) && isset($image->meta_data[$size]) && isset($image->meta_data[$size]['filename'])) {
                            $image_path = $fs->join_paths($image_path, $image->meta_data[$size]['filename']);
                        } else {
                            $image_path = $fs->join_paths($image_path, "{$prefix}_{$image->filename}");
                        }
                        $retval = $image_path;
                        break;
                }
            }
        }
        // Check the existance of the file
        if ($retval && $check_existance) {
            if (!file_exists($retval)) {
                $retval = NULL;
            }
        }
        return $retval ? rtrim($retval, '/\\') : $retval;
    }
    /**
     * Backs up an image file
     * @param int|object $image
     */
    public function backup_image($image)
    {
        $retval = FALSE;
        if ($image_path = $this->object->get_image_abspath($image)) {
            $retval = copy($image_path, $this->object->get_backup_abspath($image));
            // Store the dimensions of the image
            if (function_exists('getimagesize')) {
                if (!is_object($image)) {
                    $image = C_Image_Mapper::get_instance()->find($image);
                }
                if ($image) {
                    $dimensions = getimagesize($retval);
                    $image->meta_data['backup'] = array('filename' => basename($retval), 'width' => $dimensions[0], 'height' => $dimensions[1], 'generated' => microtime());
                }
            }
        }
        return $retval;
    }
    /**
     * Gets the absolute path of the backup of an original image
     * @param string $image
     */
    public function get_backup_abspath($image)
    {
        return $this->object->get_image_abspath($image, 'backup');
    }
    public function get_backup_dimensions($image)
    {
        return $this->object->get_image_dimensions($image, 'backup');
    }
    public function get_backup_url($image)
    {
        return $this->object->get_image_url($image, 'backup');
    }
}
/**
 * Class Mixin_Pro_Ecomm_Storage
 *
 * NextGen Gallery's get_original_abspath() points to the fullsize image which we don't want
 */
class Mixin_Pro_Ecomm_Storage extends Mixin
{
    /**
     * Use the 'backup' image as the 'original' so that generated images use the backup image as their source
     *
     * @param $image
     * @param bool $check_existance
     *
     * @return mixed
     */
    public function get_original_abspath($image, $check_existance = FALSE)
    {
        return $this->object->get_image_abspath($image, 'backup', $check_existance);
    }
}
class C_Digital_Downloads extends C_MVC_Controller
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
    public function get_i18n_strings($order)
    {
        $retval = new stdClass();
        $retval->image_header = __('Image', 'nextgen-gallery-pro');
        $retval->resolution_header = __('Resolution', 'nextgen-gallery-pro');
        $retval->item_description_header = __('Item', 'nextgen-gallery-pro');
        $retval->download_header = __('Download', 'nextgen-gallery-pro');
        $retval->order_info = sprintf(__('Digital Downloads for Order #%s', 'nextgen-gallery-pro'), $order->ID);
        return $retval;
    }
    public function index_action()
    {
        wp_enqueue_style('ngg-digital-downloads-page', $this->get_static_url('photocrati-nextgen_pro_ecommerce#digital_downloads_page.css'));
        $retval = __('Oops! This page usually displays details for image purchases, but you have not ordered any images yet. Please feel free to continue browsing. Thanks for visiting.', 'nextgen-gallery-pro');
        if ($order = C_Order_Mapper::get_instance()->find_by_hash($this->param('order'), TRUE)) {
            // Display digital downloads for verified transactions
            if ($order->status == 'verified') {
                $retval = $this->render_download_list($order);
            } else {
                $retval = $this->render_partial('photocrati-nextgen_pro_ecommerce#waiting_for_confirmation', array('msg' => __('We haven\'t received payment confirmation yet. This may take a few minutes. Please wait...')), TRUE);
            }
        }
        return $retval;
    }
    public function get_gallery_storage()
    {
        $storage = C_Gallery_Storage::get_instance();
        if (version_compare(NGG_PLUGIN_VERSION, '2.0.66.99') <= 0) {
            $storage->get_wrapped_instance()->add_mixin('Mixin_Pro_Storage');
        } else {
            $storage->get_wrapped_instance()->add_mixin('Mixin_Pro_Ecomm_Storage');
        }
        return $storage;
    }
    public function render_download_list($order)
    {
        $cart = $order->get_cart()->to_array();
        $storage = $this->get_gallery_storage();
        $images = array();
        $settings = C_NextGen_Settings::get_instance();
        foreach ($cart['images'] as $image_obj) {
            foreach ($image_obj->items as $item) {
                $image = new stdClass();
                foreach (get_object_vars($image_obj) as $key => $val) {
                    $image->{$key} = $val;
                }
                if ($item->source == NGG_PRO_DIGITAL_DOWNLOADS_SOURCE) {
                    $named_size = 'backup';
                    // Use the full resolution image
                    if ($item->resolution != 0) {
                        $dynthumbs = C_Dynamic_Thumbnails_Manager::get_instance();
                        $params = array('width' => $item->resolution, 'height' => $item->resolution, 'crop' => FALSE, 'watermark' => FALSE, 'quality' => 100);
                        $named_size = $dynthumbs->get_size_name($params);
                        if (!$storage->get_image_abspath($image, $named_size, TRUE)) {
                            $storage->generate_image_size($image, $named_size);
                        }
                    }
                    if ($named_size == 'backup') {
                        // in case the backup files are protected by server side rules we serve fullsize images from
                        // an ajax endpoint.
                        //
                        // we don't need to honor permalink styles as this is mostly hidden just determine the most
                        // reliable path to the photocrati_ajax controller
                        $url = $settings->get('ajax_url');
                        $pos = strpos($url, '?');
                        if ($pos === FALSE) {
                            $url .= '?';
                        } else {
                            $url .= '&';
                        }
                        $url .= 'action=get_image_file&order_id=' . $order->hash . '&image_id=' . $image_obj->{$image_obj->id_field};
                        $image->download_url = $url;
                    } else {
                        $image->download_url = $storage->get_image_url($image, $named_size);
                    }
                    // Set other properties
                    $dimensions = $storage->get_image_dimensions($image, $named_size);
                    $image->dimensions = $dimensions;
                    $image->resolution = $dimensions['width'] . 'x' . $dimensions['height'];
                    $image->item_description = $item->title;
                    $image->thumbnail_url = $storage->get_thumbnail_url($image);
                    array_push($images, $image);
                }
            }
        }
        return $this->render_partial('photocrati-nextgen_pro_ecommerce#digital_downloads_list', array('images' => $images, 'order' => $order, 'i18n' => $this->get_i18n_strings($order)), TRUE);
    }
}
class C_Nextgen_Mail_Content
{
    public $_list;
    public $_private;
    public $_template;
    public function __construct()
    {
        $this->_list = array();
        $this->_private = array();
    }
    public function is_property($name)
    {
        return isset($this->_list[$name]);
    }
    public function is_property_private($name)
    {
        return isset($this->_private[$name]) && $this->_private[$name];
    }
    public function get_property($name)
    {
        if (isset($this->_list[$name])) {
            return $this->_list[$name];
        }
        return null;
    }
    public function set_property($name, $value)
    {
        $this->_list[$name] = $value;
        $this->_private[$name] = false;
    }
    public function set_property_private($name, $value)
    {
        $this->_list[$name] = $value;
        $this->_private[$name] = true;
    }
    public function get_subject()
    {
        return $this->get_property('subject');
    }
    public function set_subject($subject)
    {
        $this->set_property_private('subject', $subject);
    }
    public function get_sender()
    {
        return $this->get_property('sender');
    }
    public function set_sender($sender)
    {
        $this->set_property_private('sender', $sender);
    }
    public function load_template($template_text)
    {
        $this->_template = $template_text;
    }
    public function evaluate_template($template_text = null)
    {
        if ($template_text == null) {
            $template_text = $this->_template;
        }
        $template_text = str_replace(array('
', '
'), '
', $template_text);
        $matches = null;
        if (preg_match_all('/%%(\\w+)%%/', $template_text, $matches, PREG_SET_ORDER) > 0) {
            foreach ($matches as $match) {
                $var = $match[1];
                $parts = explode('_', $var);
                $root = array_shift($parts);
                $name = implode('_', $parts);
                $replace = null;
                $var_value = !$this->is_property_private($var) ? $this->get_property($var) : null;
                if ($var_value == null) {
                    $var_meta = !$this->is_property_private($root) ? $this->get_property($root) : null;
                    if ($var_meta != null && isset($var_meta[$name])) {
                        $var_value = $var_meta[$name];
                    }
                }
                if ($var_value == null) {
                    // This is a place to have certain defaults set, or values which are not easily settable in a property list. It could also be extended in the future with custom callbacks etc.
                    switch ($root) {
                        case 'time':
                            switch ($name) {
                                case 'now_utc':
                                    // for clarification in case it's not obvious, this will replace the meta variable %%time_now_utc%% in the mail template
                                    $var_value = date(DATE_RFC850);
                                    break;
                            }
                            break;
                    }
                }
                if ($var_value != null) {
                    $replace = $var_value;
                }
                $template_text = str_replace($match[0], $replace, $template_text);
            }
        }
        return $template_text;
    }
}
/*
* How you would send an e-mail

	$mailman = $registry->get_utility('I_Nextgen_Mail_Manager');
	$content = $mailman->create_content();
	$content->set_subject('test');
	$content->set_property('user', 'Test');
	$content->load_template('Hi %%user%%, test');

	$mailman->send_mail($content, 'some@email.com');
*/
class Mixin_Nextgen_Mail_Manager extends Mixin
{
    public function create_content($type = null)
    {
        if ($type == null) {
            $type = 'C_Nextgen_Mail_Content';
        }
        return new $type();
    }
    public function send_mail($content, $receiver, $subject = null, $sender = null, $mail_headers = array())
    {
        $mail_body = null;
        if (is_string($content)) {
            $mail_body = $content;
        } else {
            if ($content instanceof C_Nextgen_Mail_Content) {
                if ($subject == null) {
                    $subject = $content->get_subject();
                }
                if ($sender == null) {
                    $sender = $content->get_sender();
                }
                $mail_body = $content->evaluate_template();
            }
        }
        if ($mail_body != null) {
            if ($sender != null) {
                $mail_headers['From'] = $sender;
            }
            wp_mail($receiver, $subject, $mail_body, $mail_headers);
        }
    }
}
class C_Nextgen_Mail_Manager extends C_Component
{
    static $_instances = array();
    public function define($context = FALSE)
    {
        parent::define($context);
        $this->implement('I_Nextgen_Mail_Manager');
        $this->add_mixin('Mixin_Nextgen_Mail_Manager');
    }
    static function get_instance($context = False)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_Nextgen_Mail_Manager($context);
        }
        return self::$_instances[$context];
    }
}
class C_NextGen_Pro_Add_To_Cart
{
    static $_template_rendered = FALSE;
    public function enqueue_static_resources()
    {
        $router = C_Router::get_instance();
        wp_enqueue_script('jquery-ui-accordion');
        // For some reason ajax.js isn't registered yet in 2.0.67.14 and above, so we have
        // to do it manually.
        if (method_exists('M_Ajax', 'register_scripts')) {
            M_Ajax::register_scripts();
        }
        $dependencies = array('nextgen_pro_captions-js');
        if (version_compare(NGG_PLUGIN_VERSION, '2.0.67') <= 0) {
            $dependencies[] = 'ngg-store-js';
        }
        wp_enqueue_script('ngg-pro-lightbox-ecommerce-overrides', $router->get_static_url('photocrati-nextgen_pro_ecommerce#lightbox_overrides.js'), $dependencies);
        wp_enqueue_style('ngg-pro-add-to-cart', $router->get_static_url('photocrati-nextgen_pro_ecommerce#add_to_cart.css'));
        M_NextGen_Pro_Ecommerce::enqueue_cart_resources();
        if (!self::$_template_rendered) {
            self::$_template_rendered = TRUE;
            $parameters = array('not_for_sale_msg' => C_NextGen_Settings::get_instance()->ecommerce_not_for_sale_msg, 'sources' => $this->get_sources(), 'i18n' => $this->get_i18n_strings());
            $add_to_cart_tmpl = new C_MVC_View('photocrati-nextgen_pro_ecommerce#add_to_cart_tmpl', $parameters);
            $add_to_cart_item_tmpl = new C_MVC_View('photocrati-nextgen_pro_ecommerce#add_to_cart_source_item_tmpl', $parameters);
            $add_to_cart_items_tmpl = new C_MVC_View('photocrati-nextgen_pro_ecommerce#add_to_cart_source_items_tmpl', $parameters);
            wp_localize_script('ngg-pro-lightbox-ecommerce-overrides', 'ngg_add_to_cart_templates', array('add_to_cart' => $add_to_cart_tmpl->render(TRUE), 'add_to_cart_item' => $add_to_cart_item_tmpl->render(TRUE), 'add_to_cart_items' => $add_to_cart_items_tmpl->render(TRUE)));
            wp_localize_script('ngg-pro-lightbox-ecommerce-overrides', 'ngg_cart_i18n', (array) $this->get_i18n_strings());
        }
    }
    public function get_sources()
    {
        return array(NGG_PRO_MANUAL_PRICELIST_SOURCE => $this->_render_manual_pricelist_template(), NGG_PRO_DIGITAL_DOWNLOADS_SOURCE => $this->_render_digital_download_template());
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->add_to_cart = __('Add To Cart', 'nextgen-gallery-pro');
        $i18n->qty_add_desc = __('Change quantities to update your cart.', 'nextgen-gallery-pro');
        $i18n->checkout = __('View Cart / Checkout', 'nextgen-gallery-pro');
        $i18n->not_for_sale = __('This image is not for sale', 'nextgen-gallery-pro');
        $i18n->quantity = __('Quantity', 'nextgen-gallery-pro');
        $i18n->description = __('Description', 'nextgen-gallery-pro');
        $i18n->price = __('Price', 'nextgen-gallery-pro');
        $i18n->total = __('Total', 'nextgen-gallery-pro');
        $i18n->update_cart = __('Update Cart', 'nextgen-gallery-pro');
        $i18n->nggpl_toggle_sidebar = __('Toggle cart sidebar', 'nextgen-gallery-pro');
        $i18n->nggpl_cart_updated = __('Your cart has been updated', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function _render_manual_pricelist_template()
    {
        $heading = __('Prints & Products', 'nextgen-gallery-pro');
        $id = NGG_PRO_MANUAL_PRICELIST_SOURCE;
        return "<h3>{$heading}</h3><div class='nggpl-source_contents' id='{$id}'></div>";
    }
    public function _render_digital_download_template()
    {
        $heading = __('Digital Downloads', 'nextgen-gallery-pro');
        $license_terms = __('View license terms', 'nextgen-gallery-pro');
        $id = NGG_PRO_DIGITAL_DOWNLOADS_SOURCE;
        return "<h3><span id='ngg_digital_downloads_header'>{$heading}</span></h3><div class='nggpl-source_contents' id='{$id}'></div>";
    }
}
class C_NextGen_Pro_Cart
{
    public $_state = array();
    public function __construct($json = NULL)
    {
        if ($json) {
            $this->_parse_state($json);
        }
    }
    /**
     * Simplified state to represent the cart:
     * array(
     *  'images'                        =>  array(
     *          1 (image_id)            =>  array(
     *              'items'             =>  array(
     *                  1 (item_id)     =>  array(
     *                      'quantity'  =>  2
     *                  )
     *              ),
     *              'item_ids'          =>  array(
     *                  1 (item_id)
     *              )
     *          )
     *  ),
     *  'image_ids'                     =>  array(
     *          1 (image_id)
     *  )
     * )
     * @var array
     */
    public function _parse_state($client_state)
    {
        if (isset($client_state['images']) and is_array($client_state['images'])) {
            foreach ($client_state['images'] as $image_id => $image_props) {
                $this->add_image($image_id, $image_props);
            }
        }
    }
    public function has_items()
    {
        return count($this->_state) ? TRUE : FALSE;
    }
    public function add_image($image_id, $image_props)
    {
        // Get the items associated with the image
        $items = array();
        if (is_array($image_props)) {
            unset($image_props['item_ids']);
            if (isset($image_props['items'])) {
                $items = $image_props['items'];
            }
        } else {
            unset($image_props->item_ids);
            if (isset($image_props->items)) {
                $items = $image_props->items;
            }
        }
        // Does the image exist?
        if ($image = C_Image_Mapper::get_instance()->find($image_id)) {
            $storage = C_Gallery_Storage::get_instance();
            $image->thumbnail_url = $storage->get_thumbnail_url($image);
            $image->dimensions = $storage->get_thumbnail_dimensions($image);
            $image->width = $image->dimensions['width'];
            $image->height = $image->dimensions['height'];
            $this->_state[$image_id] = $image;
            foreach ($items as $item_id => $item_props) {
                if (is_numeric($item_id)) {
                    $this->add_item($image_id, $item_id, $item_props);
                }
            }
        }
    }
    public function add_item($image_id, $item_id, $item_props = array())
    {
        // Treat an object as if it were an array
        if (is_object($item_props)) {
            $item_props = get_object_vars($item_props);
        }
        // Find the item
        $item = C_Pricelist_Item_Mapper::get_instance()->find($item_id);
        // Find the image
        if ($image = C_Image_Mapper::get_instance()->find($image_id) and $item) {
            // Ensure that the image has been added
            if (!isset($this->_state[$image_id])) {
                $image->items = array();
                $this->_state[$image_id] = $image;
            } else {
                $image = $this->_state[$image_id];
            }
            // Ensure that the image has an items array
            if (!isset($image->items)) {
                $image->items = array();
            }
            // Ensure that the items source key exists as an array
            if (!isset($image->items[$item->source])) {
                $image->items[$item->source] = array();
            }
            // Ensure that the item's pricelist id exists as a key in the array
            if (!isset($image->items[$item->source][$item->pricelist_id])) {
                $image->items[$item->source][$item->pricelist_id] = array();
            }
            // Has the item already been added? If so, increment it's quantity
            if (isset($image->items[$item->source][$item->pricelist_id][$item_id])) {
                $previous_quantity = intval($image->items[$item->source][$item->pricelist_id][$item_id]->quantity);
                $image->items[$item->source][$item->pricelist_id][$item_id]->quantity = $previous_quantity + intval($item_props['quantity']);
            } else {
                $item->quantity = isset($item_props['quantity']) ? intval($item_props['quantity']) : 1;
                $image->items[$item->source][$item->pricelist_id][$item_id] = $item;
            }
        } else {
            unset($this->_state[$image_id]);
        }
    }
    public function has_international_shipping_rate()
    {
        $retval = FALSE;
        $mapper = C_Pricelist_Mapper::get_instance();
        $sources = C_Pricelist_Source_Manager::get_instance();
        foreach ($this->_state as $image_id => $image) {
            foreach ($image->items as $source => $items_array) {
                foreach ($items_array as $pricelist_id => $inner_items_array) {
                    foreach ($inner_items_array as $item_id => $item) {
                        $pricelist = $mapper->find($pricelist_id);
                        $field = $sources->get($item->source, 'settings_field');
                        $settings = $pricelist->{$field};
                        if (isset($settings['allow_global_shipments']) && $settings['allow_global_shipments']) {
                            $retval = TRUE;
                            break;
                        }
                    }
                    if ($retval) {
                        break;
                    }
                }
                if ($retval) {
                    break;
                }
            }
            if ($retval) {
                break;
            }
        }
        return $retval;
    }
    public function to_array($use_home_country = TRUE)
    {
        $subtotal = $this->get_subtotal();
        $shipping = $this->get_shipping($use_home_country);
        $total = $this->get_total($use_home_country);
        $retval = array('images' => array(), 'image_ids' => array(), 'subtotal' => $subtotal, 'shipping' => $shipping, 'total' => $total, 'allow_international_shipping' => $this->has_international_shipping_rate());
        foreach ($this->_state as $image_id => $image) {
            $items = $image->items;
            $image->item_ids = array();
            $image->items = array();
            foreach ($items as $source => $items_array) {
                foreach ($items_array as $pricelist_id => $inner_items_array) {
                    foreach ($inner_items_array as $item_id => $item) {
                        $image->item_ids[] = $item_id;
                        $image->items[$item_id] = $item;
                    }
                }
            }
            $retval['images'][$image_id] = $image;
            $retval['image_ids'][] = $image_id;
        }
        return $retval;
    }
    /**
     * Determines if the cart has digital downloads
     * @return bool
     */
    public function has_digital_downloads()
    {
        $retval = FALSE;
        $sources = C_Pricelist_Source_Manager::get_instance();
        foreach ($this->_state as $image_id => $image_props) {
            if (!isset($image_props->items)) {
                $image_props->items = array();
            }
            foreach (array_keys($image_props->items) as $source) {
                if (!$sources->get($source, 'shipping_method')) {
                    $retval = TRUE;
                    break;
                }
            }
        }
        return $retval;
    }
    /**
     * Gets the subtotal of all items in the cart
     * @return float|string
     */
    public function get_subtotal()
    {
        $retval = 0;
        $settings = C_NextGen_Settings::get_instance();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        foreach ($this->_state as $image_id => $image) {
            foreach ($image->items as $source => $pricelists) {
                foreach ($pricelists as $pricelist_id => $items) {
                    foreach ($items as $item_id => $item) {
                        $retval = bcadd($retval, bcmul($item->price, $item->quantity, $currency['exponent']), $currency['exponent']);
                    }
                }
            }
        }
        return $retval;
    }
    public function get_shipping($use_home_country = TRUE)
    {
        $retval = 0;
        $sources = C_Pricelist_Source_Manager::get_instance();
        $mapper = C_Pricelist_Mapper::get_instance();
        $settings = C_NextGen_Settings::get_instance();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        // Consolidate items via pricelist
        $consolidated = array();
        foreach ($this->_state as $image_id => $image) {
            foreach ($image->items as $source => $pricelists) {
                foreach ($pricelists as $pricelist_id => $items) {
                    if (!isset($consolidated[$pricelist_id])) {
                        $consolidated[$pricelist_id] = array();
                    }
                    if (!isset($consolidated[$pricelist_id][$source])) {
                        $consolidated[$pricelist_id][$source] = array();
                    }
                    foreach ($items as $item) {
                        $consolidated[$pricelist_id][$source][] = $item;
                    }
                }
            }
        }
        // Foreach pricelist, calculate the items shipping
        foreach ($consolidated as $pricelist_id => $source_array) {
            foreach ($source_array as $source => $items) {
                // Normally, we would instantiate the class responsible for calculating
                // the shipping method. But for now, for simplicity sake, we'll just assume that there is
                // only one calculation method
                if ($shipping_klass = $sources->get($source, 'shipping_method')) {
                    $pricelist = $mapper->find($pricelist_id);
                    $settings = $pricelist->manual_settings;
                    // Calculate the item subtotal
                    $subtotal = 0;
                    foreach ($items as $item_id => $item) {
                        $subtotal = bcadd($subtotal, bcmul($item->price, $item->quantity, $currency['exponent']), $currency['exponent']);
                    }
                    // Calculate the shipping cost for local orders
                    $local_rate = 0;
                    if ($settings['domestic_shipping_method'] == 'flat') {
                        $local_rate = bcadd($local_rate, $settings['domestic_shipping_rate'], $currency['exponent']);
                    } else {
                        $local_rate = bcadd($local_rate, bcmul($settings['domestic_shipping_rate'], $subtotal / 100, $currency['exponent']), $currency['exponent']);
                    }
                    // Calculate the shipping cost for international orders
                    $global_rate = 0;
                    if ($settings['global_shipping_method'] == 'flat') {
                        $global_rate = bcadd($global_rate, $settings['global_shipping_rate'], $currency['exponent']);
                    } else {
                        $global_rate = bcadd($global_rate, bcmul($settings['global_shipping_rate'], $subtotal / 100, $currency['exponent']), $currency['exponent']);
                    }
                    // Determine what rate to use. The local rate is used as a minimum rate as well
                    if ($use_home_country) {
                        $retval = bcadd($retval, $local_rate, $currency['exponent']);
                    } else {
                        if ($local_rate > $global_rate) {
                            $retval = bcadd($retval, $local_rate, $currency['exponent']);
                        } else {
                            $retval = bcadd($retval, $global_rate, $currency['exponent']);
                        }
                    }
                }
            }
        }
        return $retval;
    }
    public function get_total($use_home_country = TRUE)
    {
        $settings = C_NextGen_Settings::get_instance();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        return bcadd($this->get_shipping($use_home_country), $this->get_subtotal(), $currency['exponent']);
    }
    /**
     * Determines if the cart has shippable items
     * @return bool
     */
    public function has_shippable_items()
    {
        $retval = FALSE;
        $sources = C_Pricelist_Source_Manager::get_instance();
        foreach ($this->_state as $image_id => $image_props) {
            if (!isset($image_props->items)) {
                $image_props->items = array();
            }
            foreach (array_keys($image_props->items) as $source) {
                if ($sources->get($source, 'shipping_method')) {
                    $retval = TRUE;
                    break;
                }
            }
        }
        return $retval;
    }
}
class C_NextGen_Pro_Checkout extends C_MVC_Controller
{
    static $_instance = NULL;
    static function get_instance()
    {
        if (!self::$_instance) {
            $klass = get_class();
            self::$_instance = new $klass();
        }
        return self::$_instance;
    }
    public function define()
    {
        parent::define();
        $this->implement('I_NextGen_Pro_Checkout');
        $this->add_mixin('Mixin_NextGen_Pro_Checkout');
    }
}
class Mixin_NextGen_Pro_Checkout extends Mixin
{
    /**
     * Adapters are expected to override to provide more payment gateway buttons
     * @return array
     */
    public function get_checkout_buttons()
    {
        return array();
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->image_header = __('Image', 'nextgen-gallery-pro');
        $i18n->quantity_header = __('Quantity', 'nextgen-gallery-pro');
        $i18n->item_header = __('Description', 'nextgen-gallery-pro');
        $i18n->price_header = __('Price', 'nextgen-gallery-pro');
        $i18n->total_header = __('Totals', 'nextgen-gallery-pro');
        $i18n->subtotal = __('Subtotal:', 'nextgen-gallery-pro');
        $i18n->shipping = __('Shipping:', 'nextgen-gallery-pro');
        $i18n->total = __('Total:', 'nextgen-gallery-pro');
        $i18n->no_items = __('There have been no items added to your cart.', 'nextgen-gallery-pro');
        $i18n->continue_shopping = __('Continue shopping', 'nextgen-gallery-pro');
        $i18n->empty_cart = __('Empty cart', 'nextgen-gallery-pro');
        $i18n->ship_to = __('Ship to:', 'nextgen-gallery-pro');
        $i18n->ship_elsewhere = __('International', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function enqueue_static_resources()
    {
        M_NextGen_Pro_Ecommerce::enqueue_cart_resources();
        // Enqueue fontawesome
        if (method_exists('M_Gallery_Display', 'enqueue_fontawesome')) {
            M_Gallery_Display::enqueue_fontawesome();
        } else {
            C_Display_Type_Controller::get_instance()->enqueue_displayed_gallery_trigger_buttons_resources();
        }
        wp_enqueue_style('fontawesome');
        wp_enqueue_style('ngg-pro-checkout', $this->get_static_url('photocrati-nextgen_pro_ecommerce#checkout.css'));
        foreach ($this->object->get_checkout_buttons() as $btn) {
            $method = "enqueue_{$btn}_resources";
            if ($this->object->has_method($method)) {
                $this->object->{$method}();
            }
        }
    }
    public function get_continue_shopping_url()
    {
        return isset($_GET['referrer']) ? $_GET['referrer'] : '';
    }
    public function checkout_form()
    {
        $this->enqueue_static_resources();
        if ($this->is_post_request()) {
            $this->processor();
        }
        // Get checkout buttons
        $buttons = array();
        foreach ($this->object->get_checkout_buttons() as $btn) {
            $method = "_render_{$btn}_button";
            $buttons[] = $this->object->{$method}();
        }
        // Get country
        $country = C_NextGen_Pro_Currencies::$countries[840];
        $country_id = C_NextGen_Settings::get_instance()->ecommerce_home_country;
        if (isset(C_NextGen_Pro_Currencies::$countries[$country_id])) {
            $country = C_NextGen_Pro_Currencies::$countries[$country_id];
            $country = $country['name'];
        }
        return $this->render_partial('photocrati-nextgen_pro_ecommerce#checkout_form', array('buttons' => $buttons, 'referrer_url' => $this->get_continue_shopping_url(), 'i18n' => $this->get_i18n_strings(), 'country' => $country), TRUE);
    }
    public function processor()
    {
        if ($gateway = $this->param('ngg_pro_checkout')) {
            $method = "process_{$gateway}_request";
            if ($this->object->has_method($method)) {
                $this->object->{$method}();
            }
        }
    }
    public function create_order($cart, $customer_name, $email, $total_amount, $payment_gateway, $shipping_street_address = NULL, $shipping_city = NULL, $shipping_state = NULL, $shipping_zip = NULL, $shipping_country = NULL, $use_home_country = TRUE, $status = 'verified')
    {
        $order_mapper = C_Order_Mapper::get_instance();
        $properties = array('customer_name' => $customer_name, 'email' => $email, 'payment_gateway' => $payment_gateway, 'total_amount' => $total_amount, 'cart' => $cart, 'shipping_street_address' => $shipping_street_address, 'shipping_city' => $shipping_city, 'shipping_state' => $shipping_state, 'shipping_zip' => $shipping_zip, 'shipping_country' => $shipping_country, 'status' => $status, 'use_home_country' => $use_home_country, 'post_status' => 'publish');
        $order = $order_mapper->create($properties);
        return $order;
    }
    public function _send_email($order_hash, $subject, $body, $to = NULL)
    {
        $retval = FALSE;
        // Get the destination url
        $order_details_page = $this->get_thank_you_page_url($order_hash, TRUE);
        // Ensure that we have a valid order
        if ($order = C_Order_Mapper::get_instance()->find_by_hash($order_hash)) {
            // Get needed components
            $mail = C_Nextgen_Mail_Manager::get_instance();
            // Set additional order variables
            $order->order_details_page = $order_details_page;
            $order->total_amount = M_NextGen_Pro_Ecommerce::get_formatted_price($order->total_amount, FALSE, FALSE);
            $order->admin_email = bloginfo('admin_email');
            $order->blog_description = bloginfo('description');
            $order->blog_name = bloginfo('name');
            $order->blog_url = site_url();
            $order->site_url = site_url();
            $order->home_url = home_url();
            $order->order_id = $order->ID;
            // Determine item count
            $item_count = 0;
            $file_list = '';
            foreach ($order->cart['images'] as $image) {
                $imageObj = C_Image_Mapper::get_instance()->find($image[$image['id_field']]);
                $name = pathinfo($imageObj->filename);
                $name = $name['filename'];
                if ($item_count == 0) {
                    $file_list = $name;
                } else {
                    $file_list .= ',' . $name;
                }
                foreach ($image['items'] as $tmpid => $item) {
                    // TODO: remove this if. I can't determine why these are being added as items
                    if (in_array($tmpid, array('ngg_digital_downloads', 'ngg_manual_pricelist'))) {
                        continue;
                    }
                    $item_count += intval($item['quantity']);
                }
            }
            $order->item_count = $item_count;
            $order->file_list = $file_list;
            // Send the e-mail
            $content = $mail->create_content();
            $content->set_subject($subject);
            $content->load_template($body);
            foreach (get_object_vars($order) as $key => $val) {
                $content->set_property($key, $val);
            }
            $mail->send_mail($content, $to ? $to : $order->email);
            $retval = TRUE;
        }
        return $retval;
    }
    public function send_email_receipt($order_hash)
    {
        $retval = FALSE;
        $settings = C_NextGen_Settings::get_instance();
        // Send e-mail receipt to customer
        if ($settings->ecommerce_enable_email_receipt) {
            $retval = $this->_send_email($order_hash, $settings->ecommerce_email_receipt_subject, $settings->ecommerce_email_receipt_body);
        }
        return $retval;
    }
    public function send_email_notification($order_hash)
    {
        $retval = FALSE;
        $settings = C_NextGen_Settings::get_instance();
        // Send admin notification
        if ($settings->ecommerce_enable_email_notification) {
            $this->_send_email($order_hash, $settings->ecommerce_email_notification_subject, $settings->ecommerce_email_notification_body, $settings->ecommerce_email_notification_recipient);
            $retval = TRUE;
        }
        return $retval;
    }
    public function redirect_to_thank_you_page($order_hash)
    {
        // Expose hook for third-parties
        do_action('ngg_pro_purchase_complete');
        // Get the destination url
        $order_details_page = $this->get_thank_you_page_url($order_hash, TRUE);
        // Get the order
        if ($order = C_Order_Mapper::get_instance()->find_by_hash($order_hash)) {
            if (!isset($order->sent_emails) or !$order->sent_emails) {
                // Send the admin notification only when the purchase has been verified
                if ($order->status == 'verified') {
                    $this->send_email_notification($order_hash);
                }
                // Send the e-mail receipt as soon as we can
                $this->send_email_receipt($order_hash);
            }
        } else {
            die(__('We couldn\'t find your order. We apologize for the inconvenience', 'nextgen-gallery-pro'));
        }
        wp_redirect($order_details_page);
        throw new E_Clean_Exit();
    }
    public function redirect_to_cancel_page()
    {
        wp_redirect($this->get_cancel_page_url());
        throw new E_Clean_Exit();
    }
    public function redirect_to_order_verification_page($order_hash)
    {
        wp_redirect($this->get_order_verification_page_url($order_hash));
        throw new E_Clean_Exit();
    }
    public function get_thank_you_page_url($order_id, $order_complete = FALSE)
    {
        $params = array('order' => $order_id);
        if ($order_complete) {
            $params['ngg_order_complete'] = 1;
        }
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->ecommerce_page_thanks) {
            return $this->get_page_url(C_NextGen_Settings::get_instance()->ecommerce_page_thanks, $params);
        } else {
            return $this->_add_to_querystring(site_url('/?ngg_pro_return_page=1'), $params);
        }
    }
    public function _add_to_querystring($url, $params = array())
    {
        if ($params) {
            $qs = array();
            foreach ($params as $key => $value) {
                $qs[] = urlencode($key) . '=' . urlencode($value);
            }
            $url .= (strpos($url, '?') === FALSE ? '?' : '&') . implode('&', $qs);
        }
        return $url;
    }
    public function get_order_verification_page_url($order_hash)
    {
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->get('ecommerce_page_order_verification', FALSE)) {
            return $this->_add_to_querystring($this->get_page_url($settings->get('ecommerce_page_order_verification')), array('order' => $order_hash));
        } else {
            return site_url('/?ngg_pro_verify_page=1&order=' . $order_hash);
        }
    }
    public function get_cancel_page_url()
    {
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->ecommerce_page_cancel) {
            return $this->get_page_url($settings->ecommerce_page_cancel);
        } else {
            return $this->_add_to_querystring(site_url('/?ngg_pro_cancel_page=1'));
        }
    }
    public function get_page_url($page_id, $params = array())
    {
        $link = get_page_link($page_id);
        if ($params) {
            $link = $this->_add_to_querystring($link, $params);
        }
        return $link;
    }
    public function redirect_to_page($page_id, $params = array())
    {
        wp_redirect($this->get_page_url($page_id, $params));
    }
}
class C_NextGen_Pro_Currencies
{
    /**
     * Nations by ISO 3166 listing with currency (ISO 4217) mapping
     *
     * @link http://en.wikipedia.org/wiki/Iso_3166
     * @var array Countries
     */
    public static $countries = array(4 => array('name' => 'Afghanistan', 'code' => 'AF', 'id' => 4, 'currency_code' => '971'), 248 => array('name' => 'Åland Islands', 'code' => 'AX', 'id' => 248, 'currency_code' => '978'), 8 => array('name' => 'Albania', 'code' => 'AL', 'id' => 8, 'currency_code' => '008'), 12 => array('name' => 'Algeria', 'code' => 'DZ', 'id' => 12, 'currency_code' => '012'), 16 => array('name' => 'American Samoa', 'code' => 'AS', 'id' => 16, 'currency_code' => '840'), 20 => array('name' => 'Andorra', 'code' => 'AD', 'id' => 20, 'currency_code' => '978'), 24 => array('name' => 'Angola', 'code' => 'AO', 'id' => 24, 'currency_code' => '973'), 660 => array('name' => 'Anguilla', 'code' => 'AI', 'id' => 660, 'currency_code' => '951'), 28 => array('name' => 'Antigua and Barbuda', 'code' => 'AG', 'id' => 28, 'currency_code' => '951'), 32 => array('name' => 'Argentina', 'code' => 'AR', 'id' => 32, 'currency_code' => '032'), 51 => array('name' => 'Armenia', 'code' => 'AM', 'id' => 51, 'currency_code' => '051'), 533 => array('name' => 'Aruba', 'code' => 'AW', 'id' => 533, 'currency_code' => '533'), 36 => array('name' => 'Australia', 'code' => 'AU', 'id' => 36, 'currency_code' => '036'), 40 => array('name' => 'Austria', 'code' => 'AT', 'id' => 40, 'currency_code' => '978'), 31 => array('name' => 'Azerbaijan', 'code' => 'AZ', 'id' => 31, 'currency_code' => '944'), 44 => array('name' => 'Bahamas', 'code' => 'BS', 'id' => 44, 'currency_code' => '044'), 48 => array('name' => 'Bahrain', 'code' => 'BH', 'id' => 48, 'currency_code' => '048'), 50 => array('name' => 'Bangladesh', 'code' => 'BD', 'id' => 50, 'currency_code' => '050'), 52 => array('name' => 'Barbados', 'code' => 'BB', 'id' => 52, 'currency_code' => '052'), 112 => array('name' => 'Belarus', 'code' => 'BY', 'id' => 112, 'currency_code' => '974'), 56 => array('name' => 'Belgium', 'code' => 'BE', 'id' => 56, 'currency_code' => '978'), 84 => array('name' => 'Belize', 'code' => 'BZ', 'id' => 84, 'currency_code' => '084'), 204 => array('name' => 'Benin', 'code' => 'BJ', 'id' => 204, 'currency_code' => '952'), 60 => array('name' => 'Bermuda', 'code' => 'BM', 'id' => 60, 'currency_code' => '060'), 64 => array('name' => 'Bhutan', 'code' => 'BT', 'id' => 64, 'currency_code' => '356'), 68 => array('name' => 'Bolivia, Plurinational State of', 'code' => 'BO', 'id' => 68, 'currency_code' => '068'), 535 => array('name' => 'Bonaire, Sint Eustatius and Saba', 'code' => 'BQ', 'id' => 535, 'currency_code' => '840'), 70 => array('name' => 'Bosnia and Herzegovina', 'code' => 'BA', 'id' => 70, 'currency_code' => '977'), 72 => array('name' => 'Botswana', 'code' => 'BW', 'id' => 72, 'currency_code' => '072'), 74 => array('name' => 'Bouvet Island', 'code' => 'BV', 'id' => 74, 'currency_code' => '578'), 76 => array('name' => 'Brazil', 'code' => 'BR', 'id' => 76, 'currency_code' => '986'), 86 => array('name' => 'British Indian Ocean Territory', 'code' => 'IO', 'id' => 86, 'currency_code' => '840'), 96 => array('name' => 'Brunei Darussalam', 'code' => 'BN', 'id' => 96, 'currency_code' => '096'), 100 => array('name' => 'Bulgaria', 'code' => 'BG', 'id' => 100, 'currency_code' => '975'), 854 => array('name' => 'Burkina Faso', 'code' => 'BF', 'id' => 854, 'currency_code' => '952'), 108 => array('name' => 'Burundi', 'code' => 'BI', 'id' => 108, 'currency_code' => '108'), 116 => array('name' => 'Cambodia', 'code' => 'KH', 'id' => 116, 'currency_code' => '116'), 120 => array('name' => 'Cameroon', 'code' => 'CM', 'id' => 120, 'currency_code' => '950'), 124 => array('name' => 'Canada', 'code' => 'CA', 'id' => 124, 'currency_code' => '124'), 132 => array('name' => 'Cape Verde', 'code' => 'CV', 'id' => 132, 'currency_code' => '132'), 136 => array('name' => 'Cayman Islands', 'code' => 'KY', 'id' => 136, 'currency_code' => '136'), 140 => array('name' => 'Central African Republic', 'code' => 'CF', 'id' => 140, 'currency_code' => '950'), 148 => array('name' => 'Chad', 'code' => 'TD', 'id' => 148, 'currency_code' => '950'), 152 => array('name' => 'Chile', 'code' => 'CL', 'id' => 152, 'currency_code' => '152'), 156 => array('name' => 'China', 'code' => 'CN', 'id' => 156, 'currency_code' => '156'), 162 => array('name' => 'Christmas Island', 'code' => 'CX', 'id' => 162, 'currency_code' => '036'), 166 => array('name' => 'Cocos (Keeling) Islands', 'code' => 'CC', 'id' => 166, 'currency_code' => '036'), 170 => array('name' => 'Colombia', 'code' => 'CO', 'id' => 170, 'currency_code' => '170'), 174 => array('name' => 'Comoros', 'code' => 'KM', 'id' => 174, 'currency_code' => '174'), 178 => array('name' => 'Congo', 'code' => 'CG', 'id' => 178, 'currency_code' => '950'), 180 => array('name' => 'Congo, the Democratic Republic of the', 'code' => 'CD', 'id' => 180, 'currency_code' => '976'), 184 => array('name' => 'Cook Islands', 'code' => 'CK', 'id' => 184, 'currency_code' => '554'), 188 => array('name' => 'Costa Rica', 'code' => 'CR', 'id' => 188, 'currency_code' => '188'), 191 => array('name' => 'Croatia', 'code' => 'HR', 'id' => 191, 'currency_code' => '191'), 192 => array('name' => 'Cuba', 'code' => 'CU', 'id' => 192, 'currency_code' => '192'), 531 => array('name' => 'Curaçao', 'code' => 'CW', 'id' => 531, 'currency_code' => '532'), 196 => array('name' => 'Cyprus', 'code' => 'CY', 'id' => 196, 'currency_code' => '978'), 203 => array('name' => 'Czech Republic', 'code' => 'CZ', 'id' => 203, 'currency_code' => '203'), 384 => array('name' => 'Côte d\'Ivoire', 'code' => 'CI', 'id' => 384, 'currency_code' => '952'), 208 => array('name' => 'Denmark', 'code' => 'DK', 'id' => 208, 'currency_code' => '208'), 262 => array('name' => 'Djibouti', 'code' => 'DJ', 'id' => 262, 'currency_code' => '262'), 212 => array('name' => 'Dominica', 'code' => 'DM', 'id' => 212, 'currency_code' => '951'), 214 => array('name' => 'Dominican Republic', 'code' => 'DO', 'id' => 214, 'currency_code' => '214'), 218 => array('name' => 'Ecuador', 'code' => 'EC', 'id' => 218, 'currency_code' => '840'), 818 => array('name' => 'Egypt', 'code' => 'EG', 'id' => 818, 'currency_code' => '818'), 222 => array('name' => 'El Salvador', 'code' => 'SV', 'id' => 222, 'currency_code' => '840'), 226 => array('name' => 'Equatorial Guinea', 'code' => 'GQ', 'id' => 226, 'currency_code' => '950'), 232 => array('name' => 'Eritrea', 'code' => 'ER', 'id' => 232, 'currency_code' => '232'), 233 => array('name' => 'Estonia', 'code' => 'EE', 'id' => 233, 'currency_code' => '978'), 231 => array('name' => 'Ethiopia', 'code' => 'ET', 'id' => 231, 'currency_code' => '230'), 238 => array('name' => 'Falkland Islands (Malvinas)', 'code' => 'FK', 'id' => 238, 'currency_code' => '238'), 234 => array('name' => 'Faroe Islands', 'code' => 'FO', 'id' => 234, 'currency_code' => '208'), 242 => array('name' => 'Fiji', 'code' => 'FJ', 'id' => 242, 'currency_code' => '242'), 246 => array('name' => 'Finland', 'code' => 'FI', 'id' => 246, 'currency_code' => '978'), 250 => array('name' => 'France', 'code' => 'FR', 'id' => 250, 'currency_code' => '978'), 254 => array('name' => 'French Guiana', 'code' => 'GF', 'id' => 254, 'currency_code' => '978'), 258 => array('name' => 'French Polynesia', 'code' => 'PF', 'id' => 258, 'currency_code' => '953'), 260 => array('name' => 'French Southern Territories', 'code' => 'TF', 'id' => 260, 'currency_code' => '978'), 266 => array('name' => 'Gabon', 'code' => 'GA', 'id' => 266, 'currency_code' => '950'), 270 => array('name' => 'Gambia', 'code' => 'GM', 'id' => 270, 'currency_code' => '270'), 268 => array('name' => 'Georgia', 'code' => 'GE', 'id' => 268, 'currency_code' => '981'), 276 => array('name' => 'Germany', 'code' => 'DE', 'id' => 276, 'currency_code' => '978'), 288 => array('name' => 'Ghana', 'code' => 'GH', 'id' => 288, 'currency_code' => '936'), 292 => array('name' => 'Gibraltar', 'code' => 'GI', 'id' => 292, 'currency_code' => '292'), 300 => array('name' => 'Greece', 'code' => 'GR', 'id' => 300, 'currency_code' => '978'), 304 => array('name' => 'Greenland', 'code' => 'GL', 'id' => 304, 'currency_code' => '208'), 308 => array('name' => 'Grenada', 'code' => 'GD', 'id' => 308, 'currency_code' => '951'), 312 => array('name' => 'Guadeloupe', 'code' => 'GP', 'id' => 312, 'currency_code' => '978'), 316 => array('name' => 'Guam', 'code' => 'GU', 'id' => 316, 'currency_code' => '840'), 320 => array('name' => 'Guatemala', 'code' => 'GT', 'id' => 320, 'currency_code' => '320'), 831 => array('name' => 'Guernsey', 'code' => 'GG', 'id' => 831, 'currency_code' => '826'), 324 => array('name' => 'Guinea', 'code' => 'GN', 'id' => 324, 'currency_code' => '324'), 624 => array('name' => 'Guinea-Bissau', 'code' => 'GW', 'id' => 624, 'currency_code' => '952'), 328 => array('name' => 'Guyana', 'code' => 'GY', 'id' => 328, 'currency_code' => '328'), 332 => array('name' => 'Haiti', 'code' => 'HT', 'id' => 332, 'currency_code' => '840'), 334 => array('name' => 'Heard Island and McDonald Mcdonald Islands', 'code' => 'HM', 'id' => 334, 'currency_code' => '036'), 336 => array('name' => 'Holy See (Vatican City State)', 'code' => 'VA', 'id' => 336, 'currency_code' => '978'), 340 => array('name' => 'Honduras', 'code' => 'HN', 'id' => 340, 'currency_code' => '340'), 344 => array('name' => 'Hong Kong', 'code' => 'HK', 'id' => 344, 'currency_code' => '344'), 348 => array('name' => 'Hungary', 'code' => 'HU', 'id' => 348, 'currency_code' => '348'), 352 => array('name' => 'Iceland', 'code' => 'IS', 'id' => 352, 'currency_code' => '352'), 356 => array('name' => 'India', 'code' => 'IN', 'id' => 356, 'currency_code' => '356'), 360 => array('name' => 'Indonesia', 'code' => 'ID', 'id' => 360, 'currency_code' => '360'), 364 => array('name' => 'Iran, Islamic Republic of', 'code' => 'IR', 'id' => 364, 'currency_code' => '364'), 368 => array('name' => 'Iraq', 'code' => 'IQ', 'id' => 368, 'currency_code' => '368'), 372 => array('name' => 'Ireland', 'code' => 'IE', 'id' => 372, 'currency_code' => '978'), 833 => array('name' => 'Isle of Man', 'code' => 'IM', 'id' => 833, 'currency_code' => '826'), 376 => array('name' => 'Israel', 'code' => 'IL', 'id' => 376, 'currency_code' => '376'), 380 => array('name' => 'Italy', 'code' => 'IT', 'id' => 380, 'currency_code' => '978'), 388 => array('name' => 'Jamaica', 'code' => 'JM', 'id' => 388, 'currency_code' => '388'), 392 => array('name' => 'Japan', 'code' => 'JP', 'id' => 392, 'currency_code' => '392'), 832 => array('name' => 'Jersey', 'code' => 'JE', 'id' => 832, 'currency_code' => '826'), 400 => array('name' => 'Jordan', 'code' => 'JO', 'id' => 400, 'currency_code' => '400'), 398 => array('name' => 'Kazakhstan', 'code' => 'KZ', 'id' => 398, 'currency_code' => '398'), 404 => array('name' => 'Kenya', 'code' => 'KE', 'id' => 404, 'currency_code' => '404'), 296 => array('name' => 'Kiribati', 'code' => 'KI', 'id' => 296, 'currency_code' => '036'), 408 => array('name' => 'Korea, Democratic People\'s Republic of', 'code' => 'KP', 'id' => 408, 'currency_code' => '408'), 410 => array('name' => 'Korea, Republic of', 'code' => 'KR', 'id' => 410, 'currency_code' => '410'), 414 => array('name' => 'Kuwait', 'code' => 'KW', 'id' => 414, 'currency_code' => '414'), 417 => array('name' => 'Kyrgyzstan', 'code' => 'KG', 'id' => 417, 'currency_code' => '417'), 418 => array('name' => 'Lao People\'s Democratic Republic', 'code' => 'LA', 'id' => 418, 'currency_code' => '418'), 428 => array('name' => 'Latvia', 'code' => 'LV', 'id' => 428, 'currency_code' => '428'), 422 => array('name' => 'Lebanon', 'code' => 'LB', 'id' => 422, 'currency_code' => '422'), 426 => array('name' => 'Lesotho', 'code' => 'LS', 'id' => 426, 'currency_code' => '710'), 430 => array('name' => 'Liberia', 'code' => 'LR', 'id' => 430, 'currency_code' => '430'), 434 => array('name' => 'Libya', 'code' => 'LY', 'id' => 434, 'currency_code' => '434'), 438 => array('name' => 'Liechtenstein', 'code' => 'LI', 'id' => 438, 'currency_code' => '756'), 440 => array('name' => 'Lithuania', 'code' => 'LT', 'id' => 440, 'currency_code' => '440'), 442 => array('name' => 'Luxembourg', 'code' => 'LU', 'id' => 442, 'currency_code' => '978'), 446 => array('name' => 'Macao', 'code' => 'MO', 'id' => 446, 'currency_code' => '446'), 807 => array('name' => 'Macedonia, the Former Yugoslav Republic of', 'code' => 'MK', 'id' => 807, 'currency_code' => '807'), 450 => array('name' => 'Madagascar', 'code' => 'MG', 'id' => 450, 'currency_code' => '969'), 454 => array('name' => 'Malawi', 'code' => 'MW', 'id' => 454, 'currency_code' => '454'), 458 => array('name' => 'Malaysia', 'code' => 'MY', 'id' => 458, 'currency_code' => '458'), 462 => array('name' => 'Maldives', 'code' => 'MV', 'id' => 462, 'currency_code' => '462'), 466 => array('name' => 'Mali', 'code' => 'ML', 'id' => 466, 'currency_code' => '952'), 470 => array('name' => 'Malta', 'code' => 'MT', 'id' => 470, 'currency_code' => '978'), 584 => array('name' => 'Marshall Islands', 'code' => 'MH', 'id' => 584, 'currency_code' => '840'), 474 => array('name' => 'Martinique', 'code' => 'MQ', 'id' => 474, 'currency_code' => '978'), 478 => array('name' => 'Mauritania', 'code' => 'MR', 'id' => 478, 'currency_code' => '478'), 480 => array('name' => 'Mauritius', 'code' => 'MU', 'id' => 480, 'currency_code' => '480'), 175 => array('name' => 'Mayotte', 'code' => 'YT', 'id' => 175, 'currency_code' => '978'), 484 => array('name' => 'Mexico', 'code' => 'MX', 'id' => 484, 'currency_code' => '484'), 583 => array('name' => 'Micronesia, Federated States of', 'code' => 'FM', 'id' => 583, 'currency_code' => '840'), 498 => array('name' => 'Moldova, Republic of', 'code' => 'MD', 'id' => 498, 'currency_code' => '498'), 492 => array('name' => 'Monaco', 'code' => 'MC', 'id' => 492, 'currency_code' => '978'), 496 => array('name' => 'Mongolia', 'code' => 'MN', 'id' => 496, 'currency_code' => '496'), 499 => array('name' => 'Montenegro', 'code' => 'ME', 'id' => 499, 'currency_code' => '978'), 500 => array('name' => 'Montserrat', 'code' => 'MS', 'id' => 500, 'currency_code' => '951'), 504 => array('name' => 'Morocco', 'code' => 'MA', 'id' => 504, 'currency_code' => '504'), 508 => array('name' => 'Mozambique', 'code' => 'MZ', 'id' => 508, 'currency_code' => '943'), 104 => array('name' => 'Myanmar', 'code' => 'MM', 'id' => 104, 'currency_code' => '104'), 516 => array('name' => 'Namibia', 'code' => 'NA', 'id' => 516, 'currency_code' => '710'), 520 => array('name' => 'Nauru', 'code' => 'NR', 'id' => 520, 'currency_code' => '036'), 524 => array('name' => 'Nepal', 'code' => 'NP', 'id' => 524, 'currency_code' => '524'), 528 => array('name' => 'Netherlands', 'code' => 'NL', 'id' => 528, 'currency_code' => '978'), 540 => array('name' => 'New Caledonia', 'code' => 'NC', 'id' => 540, 'currency_code' => '953'), 554 => array('name' => 'New Zealand', 'code' => 'NZ', 'id' => 554, 'currency_code' => '554'), 558 => array('name' => 'Nicaragua', 'code' => 'NI', 'id' => 558, 'currency_code' => '558'), 562 => array('name' => 'Niger', 'code' => 'NE', 'id' => 562, 'currency_code' => '952'), 566 => array('name' => 'Nigeria', 'code' => 'NG', 'id' => 566, 'currency_code' => '566'), 570 => array('name' => 'Niue', 'code' => 'NU', 'id' => 570, 'currency_code' => '554'), 574 => array('name' => 'Norfolk Island', 'code' => 'NF', 'id' => 574, 'currency_code' => '036'), 580 => array('name' => 'Northern Mariana Islands', 'code' => 'MP', 'id' => 580, 'currency_code' => '840'), 578 => array('name' => 'Norway', 'code' => 'NO', 'id' => 578, 'currency_code' => '578'), 512 => array('name' => 'Oman', 'code' => 'OM', 'id' => 512, 'currency_code' => '512'), 586 => array('name' => 'Pakistan', 'code' => 'PK', 'id' => 586, 'currency_code' => '586'), 585 => array('name' => 'Palau', 'code' => 'PW', 'id' => 585, 'currency_code' => '840'), 591 => array('name' => 'Panama', 'code' => 'PA', 'id' => 591, 'currency_code' => '840'), 598 => array('name' => 'Papua New Guinea', 'code' => 'PG', 'id' => 598, 'currency_code' => '598'), 600 => array('name' => 'Paraguay', 'code' => 'PY', 'id' => 600, 'currency_code' => '600'), 604 => array('name' => 'Peru', 'code' => 'PE', 'id' => 604, 'currency_code' => '604'), 608 => array('name' => 'Philippines', 'code' => 'PH', 'id' => 608, 'currency_code' => '608'), 612 => array('name' => 'Pitcairn', 'code' => 'PN', 'id' => 612, 'currency_code' => '554'), 616 => array('name' => 'Poland', 'code' => 'PL', 'id' => 616, 'currency_code' => '985'), 620 => array('name' => 'Portugal', 'code' => 'PT', 'id' => 620, 'currency_code' => '978'), 630 => array('name' => 'Puerto Rico', 'code' => 'PR', 'id' => 630, 'currency_code' => '840'), 634 => array('name' => 'Qatar', 'code' => 'QA', 'id' => 634, 'currency_code' => '634'), 642 => array('name' => 'Romania', 'code' => 'RO', 'id' => 642, 'currency_code' => '946'), 643 => array('name' => 'Russian Federation', 'code' => 'RU', 'id' => 643, 'currency_code' => '643'), 646 => array('name' => 'Rwanda', 'code' => 'RW', 'id' => 646, 'currency_code' => '646'), 638 => array('name' => 'Réunion', 'code' => 'RE', 'id' => 638, 'currency_code' => '978'), 652 => array('name' => 'Saint Barthélemy', 'code' => 'BL', 'id' => 652, 'currency_code' => '978'), 654 => array('name' => 'Saint Helena, Ascension and Tristan da Cunha', 'code' => 'SH', 'id' => 654, 'currency_code' => '654'), 659 => array('name' => 'Saint Kitts and Nevis', 'code' => 'KN', 'id' => 659, 'currency_code' => '951'), 662 => array('name' => 'Saint Lucia', 'code' => 'LC', 'id' => 662, 'currency_code' => '951'), 663 => array('name' => 'Saint Martin (French part)', 'code' => 'MF', 'id' => 663, 'currency_code' => '978'), 666 => array('name' => 'Saint Pierre and Miquelon', 'code' => 'PM', 'id' => 666, 'currency_code' => '978'), 670 => array('name' => 'Saint Vincent and the Grenadines', 'code' => 'VC', 'id' => 670, 'currency_code' => '951'), 882 => array('name' => 'Samoa', 'code' => 'WS', 'id' => 882, 'currency_code' => '882'), 674 => array('name' => 'San Marino', 'code' => 'SM', 'id' => 674, 'currency_code' => '978'), 678 => array('name' => 'Sao Tome and Principe', 'code' => 'ST', 'id' => 678, 'currency_code' => '678'), 682 => array('name' => 'Saudi Arabia', 'code' => 'SA', 'id' => 682, 'currency_code' => '682'), 686 => array('name' => 'Senegal', 'code' => 'SN', 'id' => 686, 'currency_code' => '952'), 688 => array('name' => 'Serbia', 'code' => 'RS', 'id' => 688, 'currency_code' => '941'), 690 => array('name' => 'Seychelles', 'code' => 'SC', 'id' => 690, 'currency_code' => '690'), 694 => array('name' => 'Sierra Leone', 'code' => 'SL', 'id' => 694, 'currency_code' => '694'), 702 => array('name' => 'Singapore', 'code' => 'SG', 'id' => 702, 'currency_code' => '702'), 534 => array('name' => 'Sint Maarten (Dutch part)', 'code' => 'SX', 'id' => 534, 'currency_code' => '532'), 703 => array('name' => 'Slovakia', 'code' => 'SK', 'id' => 703, 'currency_code' => '978'), 705 => array('name' => 'Slovenia', 'code' => 'SI', 'id' => 705, 'currency_code' => '978'), 90 => array('name' => 'Solomon Islands', 'code' => 'SB', 'id' => 90, 'currency_code' => '090'), 706 => array('name' => 'Somalia', 'code' => 'SO', 'id' => 706, 'currency_code' => '706'), 710 => array('name' => 'South Africa', 'code' => 'ZA', 'id' => 710, 'currency_code' => '710'), 728 => array('name' => 'South Sudan', 'code' => 'SS', 'id' => 728, 'currency_code' => '728'), 724 => array('name' => 'Spain', 'code' => 'ES', 'id' => 724, 'currency_code' => '978'), 144 => array('name' => 'Sri Lanka', 'code' => 'LK', 'id' => 144, 'currency_code' => '144'), 729 => array('name' => 'Sudan', 'code' => 'SD', 'id' => 729, 'currency_code' => '938'), 740 => array('name' => 'Suriname', 'code' => 'SR', 'id' => 740, 'currency_code' => '968'), 744 => array('name' => 'Svalbard and Jan Mayen', 'code' => 'SJ', 'id' => 744, 'currency_code' => '578'), 748 => array('name' => 'Swaziland', 'code' => 'SZ', 'id' => 748, 'currency_code' => '748'), 752 => array('name' => 'Sweden', 'code' => 'SE', 'id' => 752, 'currency_code' => '752'), 756 => array('name' => 'Switzerland', 'code' => 'CH', 'id' => 756, 'currency_code' => '756'), 760 => array('name' => 'Syrian Arab Republic', 'code' => 'SY', 'id' => 760, 'currency_code' => '760'), 158 => array('name' => 'Taiwan, Province of China', 'code' => 'TW', 'id' => 158, 'currency_code' => '901'), 762 => array('name' => 'Tajikistan', 'code' => 'TJ', 'id' => 762, 'currency_code' => '972'), 834 => array('name' => 'Tanzania, United Republic of', 'code' => 'TZ', 'id' => 834, 'currency_code' => '834'), 764 => array('name' => 'Thailand', 'code' => 'TH', 'id' => 764, 'currency_code' => '764'), 626 => array('name' => 'Timor-Leste', 'code' => 'TL', 'id' => 626, 'currency_code' => '840'), 768 => array('name' => 'Togo', 'code' => 'TG', 'id' => 768, 'currency_code' => '952'), 772 => array('name' => 'Tokelau', 'code' => 'TK', 'id' => 772, 'currency_code' => '554'), 776 => array('name' => 'Tonga', 'code' => 'TO', 'id' => 776, 'currency_code' => '776'), 780 => array('name' => 'Trinidad and Tobago', 'code' => 'TT', 'id' => 780, 'currency_code' => '780'), 788 => array('name' => 'Tunisia', 'code' => 'TN', 'id' => 788, 'currency_code' => '788'), 792 => array('name' => 'Turkey', 'code' => 'TR', 'id' => 792, 'currency_code' => '949'), 795 => array('name' => 'Turkmenistan', 'code' => 'TM', 'id' => 795, 'currency_code' => '934'), 796 => array('name' => 'Turks and Caicos Islands', 'code' => 'TC', 'id' => 796, 'currency_code' => '840'), 798 => array('name' => 'Tuvalu', 'code' => 'TV', 'id' => 798, 'currency_code' => '036'), 800 => array('name' => 'Uganda', 'code' => 'UG', 'id' => 800, 'currency_code' => '800'), 804 => array('name' => 'Ukraine', 'code' => 'UA', 'id' => 804, 'currency_code' => '980'), 784 => array('name' => 'United Arab Emirates', 'code' => 'AE', 'id' => 784, 'currency_code' => '784'), 826 => array('name' => 'United Kingdom', 'code' => 'GB', 'id' => 826, 'currency_code' => '826'), 840 => array('name' => 'United States', 'code' => 'US', 'id' => 840, 'currency_code' => '840'), 581 => array('name' => 'United States Minor Outlying Islands', 'code' => 'UM', 'id' => 581, 'currency_code' => '840'), 858 => array('name' => 'Uruguay', 'code' => 'UY', 'id' => 858, 'currency_code' => '858'), 860 => array('name' => 'Uzbekistan', 'code' => 'UZ', 'id' => 860, 'currency_code' => '860'), 548 => array('name' => 'Vanuatu', 'code' => 'VU', 'id' => 548, 'currency_code' => '548'), 862 => array('name' => 'Venezuela, Bolivarian Republic of', 'code' => 'VE', 'id' => 862, 'currency_code' => '937'), 704 => array('name' => 'Viet Nam', 'code' => 'VN', 'id' => 704, 'currency_code' => '704'), 92 => array('name' => 'Virgin Islands, British', 'code' => 'VG', 'id' => 92, 'currency_code' => '840'), 850 => array('name' => 'Virgin Islands, U.S.', 'code' => 'VI', 'id' => 850, 'currency_code' => '840'), 876 => array('name' => 'Wallis and Futuna', 'code' => 'WF', 'id' => 876, 'currency_code' => '953'), 732 => array('name' => 'Western Sahara', 'code' => 'EH', 'id' => 732, 'currency_code' => '504'), 887 => array('name' => 'Yemen', 'code' => 'YE', 'id' => 887, 'currency_code' => '886'), 894 => array('name' => 'Zambia', 'code' => 'ZM', 'id' => 894, 'currency_code' => '967'), 716 => array('name' => 'Zimbabwe', 'code' => 'ZW', 'id' => 716, 'currency_code' => '932'));
    /**
     * Currencies of the world by ISO 4217
     *
     * @link http://en.wikipedia.org/wiki/ISO_4217
     * @var array
     */
    public static $currencies = array('971' => array('code' => 'AFN', 'name' => 'Afghani', 'exponent' => '2', 'symbol' => '&#1547;'), '008' => array('code' => 'ALL', 'name' => 'Lek', 'exponent' => '2', 'symbol' => 'L'), '012' => array('code' => 'DZD', 'name' => 'Algerian Dinar', 'exponent' => '2', 'symbol' => 'دج'), '840' => array('code' => 'USD', 'name' => 'US Dollar', 'exponent' => '2', 'symbol' => '$', 'fontawesome' => 'fa-usd'), '978' => array('code' => 'EUR', 'name' => 'Euro', 'exponent' => '2', 'symbol' => '&#8364;', 'fontawesome' => 'fa-eur'), '973' => array('code' => 'AOA', 'name' => 'Angolan Kwanza', 'exponent' => '2', 'symbol' => 'Kz'), '951' => array('code' => 'XCD', 'name' => 'East Caribbean Dollar', 'exponent' => '2', 'symbol' => '$'), '032' => array('code' => 'ARS', 'name' => 'Argentine Peso', 'exponent' => '2', 'symbol' => '$'), '051' => array('code' => 'AMD', 'name' => 'Armenian Dram', 'exponent' => '2', 'symbol' => '&#1423;'), '533' => array('code' => 'AWG', 'name' => 'Aruban Florin', 'exponent' => '2', 'symbol' => '&#402;'), '036' => array('code' => 'AUD', 'name' => 'Australian Dollar', 'exponent' => '2', 'symbol' => '$'), '944' => array('code' => 'AZN', 'name' => 'Azerbaijanian Manat', 'exponent' => '2', 'symbol' => 'm.'), '044' => array('code' => 'BSD', 'name' => 'Bahamian Dollar', 'exponent' => '2', 'symbol' => '$'), '048' => array('code' => 'BHD', 'name' => 'Bahraini Dinar', 'exponent' => '3', 'symbol' => '.د.ب'), '050' => array('code' => 'BDT', 'name' => 'Taka', 'exponent' => '2', 'symbol' => '&#2547;'), '052' => array('code' => 'BBD', 'name' => 'Barbados Dollar', 'exponent' => '2', 'symbol' => '$'), '974' => array('code' => 'BYR', 'name' => 'Belarussian Ruble', 'exponent' => '0', 'symbol' => 'Br'), '084' => array('code' => 'BZD', 'name' => 'Belize Dollar', 'exponent' => '2', 'symbol' => '$'), '952' => array('code' => 'XOF', 'name' => 'CFA Franc BCEAO', 'exponent' => '0', 'symbol' => 'CFA'), '060' => array('code' => 'BMD', 'name' => 'Bermudian Dollar', 'exponent' => '2', 'symbol' => '$'), '356' => array('code' => 'INR', 'name' => 'Indian Rupee', 'exponent' => '2', 'symbol' => '&#8377;', 'fontawesome' => 'fa-inr'), '068' => array('code' => 'BOB', 'name' => 'Boliviano', 'exponent' => '2', 'symbol' => 'Bs.'), '977' => array('code' => 'BAM', 'name' => 'Convertible Mark', 'exponent' => '2', 'symbol' => 'KM'), '072' => array('code' => 'BWP', 'name' => 'Pula', 'exponent' => '2', 'symbol' => 'P'), '578' => array('code' => 'NOK', 'name' => 'Norwegian Krone', 'exponent' => '2', 'symbol' => 'kr'), '986' => array('code' => 'BRL', 'name' => 'Brazilian Real', 'exponent' => '2', 'symbol' => 'R$'), '096' => array('code' => 'BND', 'name' => 'Brunei Dollar', 'exponent' => '2', 'symbol' => '$'), '975' => array('code' => 'BGN', 'name' => 'Bulgarian Lev', 'exponent' => '2', 'symbol' => 'лв'), '108' => array('code' => 'BIF', 'name' => 'Burundi Franc', 'exponent' => '0', 'symbol' => 'FBu'), '116' => array('code' => 'KHR', 'name' => 'Riel', 'exponent' => '2', 'symbol' => '&#6107;'), '950' => array('code' => 'XAF', 'name' => 'CFA Franc BEAC', 'exponent' => '0', 'symbol' => 'FCFA'), '124' => array('code' => 'CAD', 'name' => 'Canadian Dollar', 'exponent' => '2', 'symbol' => '$'), '132' => array('code' => 'CVE', 'name' => 'Cape Verde Escudo', 'exponent' => '2', 'symbol' => 'Esc'), '136' => array('code' => 'KYD', 'name' => 'Cayman Islands Dollar', 'exponent' => '2', 'symbol' => '$'), '152' => array('code' => 'CLP', 'name' => 'Chilean Peso', 'exponent' => '0', 'symbol' => '$'), '156' => array('code' => 'CNY', 'name' => 'Yuan Renminbi', 'exponent' => '2', 'symbol' => '&#165;', 'fontawesome' => 'fa-cny'), '170' => array('code' => 'COP', 'name' => 'Colombian Peso', 'exponent' => '2', 'symbol' => 'COL$'), '174' => array('code' => 'KMF', 'name' => 'Comoro Franc', 'exponent' => '0', 'symbol' => 'Fr'), '976' => array('code' => 'CDF', 'name' => 'Congolese Franc', 'exponent' => '2', 'symbol' => 'Fr'), '554' => array('code' => 'NZD', 'name' => 'New Zealand Dollar', 'exponent' => '2', 'symbol' => '$'), '188' => array('code' => 'CRC', 'name' => 'Costa Rican Colon', 'exponent' => '2', 'symbol' => '&#8353;'), '191' => array('code' => 'HRK', 'name' => 'Croatian Kuna', 'exponent' => '2', 'symbol' => 'kn'), '192' => array('code' => 'CUP', 'name' => 'Cuban Peso', 'exponent' => '2', 'symbol' => '$MN', 'fontawesome' => 'fa-rouble'), '532' => array('code' => 'ANG', 'name' => 'Netherlands Antillean Guilder', 'exponent' => '2', 'symbol' => 'NA&#402;'), '203' => array('code' => 'CZK', 'name' => 'Czech Koruna', 'exponent' => '2', 'symbol' => 'Kč'), '208' => array('code' => 'DKK', 'name' => 'Danish Krone', 'exponent' => '2', 'symbol' => 'kr'), '262' => array('code' => 'DJF', 'name' => 'Djibouti Franc', 'exponent' => '0', 'symbol' => 'fr'), '214' => array('code' => 'DOP', 'name' => 'Dominican Peso', 'exponent' => '2', 'symbol' => 'RD$'), '818' => array('code' => 'EGP', 'name' => 'Egyptian Pound', 'exponent' => '2', 'symbol' => 'ج.م.'), '232' => array('code' => 'ERN', 'name' => 'Nakfa', 'exponent' => '2', 'symbol' => 'Nfk'), '230' => array('code' => 'ETB', 'name' => 'Ethiopian Birr', 'exponent' => '2', 'symbol' => 'Br'), '238' => array('code' => 'FKP', 'name' => 'Falkland Islands Pound', 'exponent' => '2', 'symbol' => '&#163;'), '242' => array('code' => 'FJD', 'name' => 'Fiji Dollar', 'exponent' => '2', 'symbol' => '$'), '953' => array('code' => 'XPF', 'name' => 'CFP Franc', 'exponent' => '0', 'symbol' => 'F'), '270' => array('code' => 'GMD', 'name' => 'Dalasi', 'exponent' => '2', 'symbol' => 'D'), '981' => array('code' => 'GEL', 'name' => 'Lari', 'exponent' => '2', 'symbol' => '&#4314;'), '936' => array('code' => 'GHS', 'name' => 'Ghana Cedi', 'exponent' => '2', 'symbol' => 'GH&#8373;'), '292' => array('code' => 'GIP', 'name' => 'Gibraltar Pound', 'exponent' => '2', 'symbol' => '&#163;'), '320' => array('code' => 'GTQ', 'name' => 'Quetzal', 'exponent' => '2', 'symbol' => 'Q'), '826' => array('code' => 'GBP', 'name' => 'Pound Sterling', 'exponent' => '2', 'symbol' => '&#163;', 'fontawesome' => 'fa-gbp'), '324' => array('code' => 'GNF', 'name' => 'Guinea Franc', 'exponent' => '0', 'symbol' => 'Fr'), '328' => array('code' => 'GYD', 'name' => 'Guyana Dollar', 'exponent' => '2', 'symbol' => 'G$'), '340' => array('code' => 'HNL', 'name' => 'Lempira', 'exponent' => '2', 'symbol' => 'L'), '344' => array('code' => 'HKD', 'name' => 'Hong Kong Dollar', 'exponent' => '2', 'symbol' => 'HK$'), '348' => array('code' => 'HUF', 'name' => 'Forint', 'exponent' => '2', 'symbol' => 'Ft'), '352' => array('code' => 'ISK', 'name' => 'Iceland Krona', 'exponent' => '0', 'symbol' => 'Íkr'), '360' => array('code' => 'IDR', 'name' => 'Rupiah', 'exponent' => '2', 'symbol' => 'Rp'), '364' => array('code' => 'IRR', 'name' => 'Iranian Rial', 'exponent' => '2', 'symbol' => 'ريال'), '368' => array('code' => 'IQD', 'name' => 'Iraqi Dinar', 'exponent' => '3', 'symbol' => 'د.ع'), '376' => array('code' => 'ILS', 'name' => 'New Israeli Sheqel', 'exponent' => '2', 'symbol' => '&#8362;'), '388' => array('code' => 'JMD', 'name' => 'Jamaican Dollar', 'exponent' => '2', 'symbol' => 'J$'), '392' => array('code' => 'JPY', 'name' => 'Yen', 'exponent' => '0', 'symbol' => '&#165;', 'fontawesome' => 'fa-jpy'), '400' => array('code' => 'JOD', 'name' => 'Jordanian Dinar', 'exponent' => '3', 'symbol' => 'JD'), '398' => array('code' => 'KZT', 'name' => 'Tenge', 'exponent' => '2', 'symbol' => '&#8376;'), '404' => array('code' => 'KES', 'name' => 'Kenyan Shilling', 'exponent' => '2', 'symbol' => 'Ksh'), '410' => array('code' => 'KRW', 'name' => 'Won', 'exponent' => '0', 'symbol' => '&#8361;', 'fontawesome' => 'fa-krw'), '414' => array('code' => 'KWD', 'name' => 'Kuwaiti Dinar', 'exponent' => '3', 'symbol' => 'د.ك'), '417' => array('code' => 'KGS', 'name' => 'Som', 'exponent' => '2', 'symbol' => 'сом'), '418' => array('code' => 'LAK', 'name' => 'Kip', 'exponent' => '2', 'symbol' => '&#8365;'), '428' => array('code' => 'LVL', 'name' => 'Latvian Lats', 'exponent' => '2', 'symbol' => 'Ls'), '422' => array('code' => 'LBP', 'name' => 'Lebanese Pound', 'exponent' => '2', 'symbol' => '&#163;'), '710' => array('code' => 'ZAR', 'name' => 'Rand', 'exponent' => '2', 'symbol' => 'R'), '430' => array('code' => 'LRD', 'name' => 'Liberian Dollar', 'exponent' => '2', 'symbol' => '$'), '434' => array('code' => 'LYD', 'name' => 'Libyan Dinar', 'exponent' => '3', 'symbol' => 'ل.د'), '756' => array('code' => 'CHF', 'name' => 'Swiss Franc', 'exponent' => '2', 'symbol' => 'SFr'), '440' => array('code' => 'LTL', 'name' => 'Lithuanian Litas', 'exponent' => '2', 'symbol' => 'Lt'), '446' => array('code' => 'MOP', 'name' => 'Pataca', 'exponent' => '2', 'symbol' => 'MOP$'), '807' => array('code' => 'MKD', 'name' => 'Denar', 'exponent' => '2', 'symbol' => '&#1076;&#1077;&#1085;'), '969' => array('code' => 'MGA', 'name' => 'Malagasy Ariary', 'exponent' => '2', 'symbol' => 'Ar'), '454' => array('code' => 'MWK', 'name' => 'Kwacha', 'exponent' => '2', 'symbol' => 'MK'), '458' => array('code' => 'MYR', 'name' => 'Malaysian Ringgit', 'exponent' => '2', 'symbol' => 'RM'), '462' => array('code' => 'MVR', 'name' => 'Rufiyaa', 'exponent' => '2', 'symbol' => 'Rf.'), '478' => array('code' => 'MRO', 'name' => 'Ouguiya', 'exponent' => '2', 'symbol' => 'UM'), '480' => array('code' => 'MUR', 'name' => 'Mauritius Rupee', 'exponent' => '2', 'symbol' => 'Rs'), '484' => array('code' => 'MXN', 'name' => 'Mexican Peso', 'exponent' => '2', 'symbol' => '$'), '498' => array('code' => 'MDL', 'name' => 'Moldovan Leu', 'exponent' => '2', 'symbol' => '$'), '496' => array('code' => 'MNT', 'name' => 'Tugrik', 'exponent' => '2', 'symbol' => '&#8366;'), '504' => array('code' => 'MAD', 'name' => 'Moroccan Dirham', 'exponent' => '2', 'symbol' => 'د.م.'), '943' => array('code' => 'MZN', 'name' => 'Mozambique Metical', 'exponent' => '2', 'symbol' => 'MT'), '104' => array('code' => 'MMK', 'name' => 'Kyat', 'exponent' => '2', 'symbol' => 'K'), '524' => array('code' => 'NPR', 'name' => 'Nepalese Rupee', 'exponent' => '2', 'symbol' => 'Rs'), '558' => array('code' => 'NIO', 'name' => 'Cordoba Oro', 'exponent' => '2', 'symbol' => 'C$'), '566' => array('code' => 'NGN', 'name' => 'Naira', 'exponent' => '2', 'symbol' => '&#8358;'), '512' => array('code' => 'OMR', 'name' => 'Rial Omani', 'exponent' => '3', 'symbol' => 'ر.ع.'), '586' => array('code' => 'PKR', 'name' => 'Pakistan Rupee', 'exponent' => '2', 'symbol' => 'PKR'), '598' => array('code' => 'PGK', 'name' => 'Kina', 'exponent' => '2', 'symbol' => 'K'), '600' => array('code' => 'PYG', 'name' => 'Guarani', 'exponent' => '0', 'symbol' => '₲'), '604' => array('code' => 'PEN', 'name' => 'Nuevo Sol', 'exponent' => '2', 'symbol' => 'S/.'), '608' => array('code' => 'PHP', 'name' => 'Philippine Peso', 'exponent' => '2', 'symbol' => '&#8369;'), '985' => array('code' => 'PLN', 'name' => 'Zloty', 'exponent' => '2', 'symbol' => 'zł'), '634' => array('code' => 'QAR', 'name' => 'Qatari Rial', 'exponent' => '2', 'symbol' => 'ر.ق'), '946' => array('code' => 'RON', 'name' => 'New Romanian Leu', 'exponent' => '2', 'symbol' => '$'), '643' => array('code' => 'RUB', 'name' => 'Russian Ruble', 'exponent' => '2', 'symbol' => 'py6', 'fontawesome' => 'fa-rub'), '646' => array('code' => 'RWF', 'name' => 'Rwanda Franc', 'exponent' => '0', 'symbol' => 'FRw'), '654' => array('code' => 'SHP', 'name' => 'Saint Helena Pound', 'exponent' => '2', 'symbol' => '&#163;'), '882' => array('code' => 'WST', 'name' => 'Tala', 'exponent' => '2', 'symbol' => 'WS$'), '678' => array('code' => 'STD', 'name' => 'Dobra', 'exponent' => '2', 'symbol' => 'Db'), '682' => array('code' => 'SAR', 'name' => 'Saudi Riyal', 'exponent' => '2', 'symbol' => 'ر.س'), '941' => array('code' => 'RSD', 'name' => 'Serbian Dinar', 'exponent' => '2', 'symbol' => 'дин'), '690' => array('code' => 'SCR', 'name' => 'Seychelles Rupee', 'exponent' => '2', 'symbol' => 'SRe'), '694' => array('code' => 'SLL', 'name' => 'Leone', 'exponent' => '2', 'symbol' => 'Le'), '702' => array('code' => 'SGD', 'name' => 'Singapore Dollar', 'exponent' => '2', 'symbol' => 'S$'), '090' => array('code' => 'SBD', 'name' => 'Solomon Islands Dollar', 'exponent' => '2', 'symbol' => 'SI$'), '706' => array('code' => 'SOS', 'name' => 'Somali Shilling', 'exponent' => '2', 'symbol' => 'Sh.So.'), '728' => array('code' => 'SSP', 'name' => 'South Sudanese Pound', 'exponent' => '2', 'symbol' => '&#163;'), '144' => array('code' => 'LKR', 'name' => 'Sri Lanka Rupee', 'exponent' => '2', 'symbol' => 'Rs'), '938' => array('code' => 'SDG', 'name' => 'Sudanese Pound', 'exponent' => '2', 'symbol' => '&#163;'), '968' => array('code' => 'SRD', 'name' => 'Surinam Dollar', 'exponent' => '2', 'symbol' => 'SRD$'), '748' => array('code' => 'SZL', 'name' => 'Lilangeni', 'exponent' => '2', 'symbol' => 'E'), '752' => array('code' => 'SEK', 'name' => 'Swedish Krona', 'exponent' => '2', 'symbol' => 'kr'), '760' => array('code' => 'SYP', 'name' => 'Syrian Pound', 'exponent' => '2', 'symbol' => '&#163;'), '901' => array('code' => 'TWD', 'name' => 'New Taiwan Dollar', 'exponent' => '2', 'symbol' => '$'), '972' => array('code' => 'TJS', 'name' => 'Somoni', 'exponent' => '2', 'symbol' => '$'), '764' => array('code' => 'THB', 'name' => 'Baht', 'exponent' => '2', 'symbol' => '&#3647;'), '776' => array('code' => 'TOP', 'name' => 'Pa’anga', 'exponent' => '2', 'symbol' => 'T$'), '780' => array('code' => 'TTD', 'name' => 'Trinidad and Tobago Dollar', 'exponent' => '2', 'symbol' => 'TT$'), '788' => array('code' => 'TND', 'name' => 'Tunisian Dinar', 'exponent' => '3', 'symbol' => 'د.ت'), '949' => array('code' => 'TRY', 'name' => 'Turkish Lira', 'exponent' => '2', 'symbol' => '&#8378;', 'fontawesome' => 'fa-try'), '934' => array('code' => 'TMT', 'name' => 'Turkmenistan New Manat', 'exponent' => '2', 'symbol' => 'T'), '800' => array('code' => 'UGX', 'name' => 'Uganda Shilling', 'exponent' => '0', 'symbol' => 'USh'), '980' => array('code' => 'UAH', 'name' => 'Hryvnia', 'exponent' => '2', 'symbol' => '&#8372;'), '784' => array('code' => 'AED', 'name' => 'UAE Dirham', 'exponent' => '2', 'symbol' => 'د.إ'), '858' => array('code' => 'UYU', 'name' => 'Peso Uruguayo', 'exponent' => '2', 'symbol' => '$U'), '548' => array('code' => 'VUV', 'name' => 'Vatu', 'exponent' => '0', 'symbol' => 'VT'), '937' => array('code' => 'VEF', 'name' => 'Bolivar', 'exponent' => '2', 'symbol' => 'Bs.F.'), '704' => array('code' => 'VND', 'name' => 'Dong', 'exponent' => '0', 'symbol' => '&#8363;'), '886' => array('code' => 'YER', 'name' => 'Yemeni Rial', 'exponent' => '2', 'symbol' => '&#164;'), '967' => array('code' => 'ZMW', 'name' => 'Zambian Kwacha', 'exponent' => '2', 'symbol' => 'ZK'), '932' => array('code' => 'ZWL', 'name' => 'Zimbabwe Dollar', 'exponent' => '2', 'symbol' => 'Z$'));
}
class C_NextGen_Pro_Ecommerce_Trigger extends C_NextGen_Pro_Lightbox_Trigger
{
    static function is_renderable($name, $displayed_gallery)
    {
        $retval = FALSE;
        if (self::is_pro_lightbox_enabled() && self::are_triggers_enabled($displayed_gallery)) {
            if (self::does_source_return_images($displayed_gallery)) {
                if (isset($displayed_gallery->display_settings['is_ecommerce_enabled'])) {
                    $retval = intval($displayed_gallery->display_settings['is_ecommerce_enabled']) ? TRUE : FALSE;
                }
                if (isset($displayed_gallery->display_settings['original_settings']) && isset($displayed_gallery->display_settings['original_settings']['is_ecommerce_enabled'])) {
                    $retval = intval($displayed_gallery->display_settings['original_settings']['is_ecommerce_enabled']) ? TRUE : FALSE;
                }
            }
        }
        return $retval;
    }
    public function get_attributes()
    {
        $attrs = parent::get_attributes();
        $attrs['data-nplmodal-show-cart'] = 1;
        $attrs['data-nplmodal-gallery-id'] = $this->displayed_gallery->id();
        if ($this->view->get_id() == 'nextgen_gallery.image') {
            $image = $this->view->get_object();
            $attrs['data-image-id'] = $image->{$image->id_field};
        }
        return $attrs;
    }
    public function get_css_class()
    {
        return 'fa ngg-trigger nextgen_pro_lightbox fa-shopping-cart';
    }
    public function render()
    {
        $retval = '';
        $context = $this->view->get_context('object');
        // For Galleria & slideshow displays: show the gallery trigger if a single
        // image is available for sale
        if ($context && get_class($context) == 'C_MVC_View' && !empty($context->_params['images'])) {
            $mapper = C_Pricelist_Mapper::get_instance();
            foreach ($context->_params['images'] as $image) {
                if ($mapper->find_for_image($image)) {
                    $retval = parent::render();
                    break;
                }
            }
        } else {
            // Display the trigger if the image is for sale
            $mapper = C_Pricelist_Mapper::get_instance();
            if ($mapper->find_for_image($context)) {
                $retval = parent::render();
            }
        }
        return $retval;
    }
}
class C_NextGen_Pro_Order extends C_DataMapper_Model
{
    public $_mapper_interface = 'I_Order_Mapper';
    public $_cart = NULL;
    public function define($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        parent::define($mapper, $properties, $context);
        $this->implement('I_Order');
    }
    public function initialize($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        // If no mapper was specified, then get the mapper
        if (!$mapper) {
            $mapper = $this->get_registry()->get_utility($this->_mapper_interface);
        }
        // Construct the model
        parent::initialize($mapper, $properties);
        if (is_object($properties) && isset($properties->cart)) {
            $this->_cart = new C_NextGen_Pro_Cart($properties->cart);
        } elseif (is_array($properties) && isset($properties['cart'])) {
            $this->_cart = new C_NextGen_Pro_Cart($properties['cart']);
        }
    }
    public function get_cart()
    {
        return $this->_cart;
    }
}
class C_NextGen_Pro_Order_Controller extends C_MVC_Controller
{
    static $_instance = NULL;
    static function get_instance()
    {
        if (is_null(self::$_instance)) {
            $klass = get_class();
            self::$_instance = new $klass();
        }
        return self::$_instance;
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->image = __('Image', 'nextgen-gallery-pro');
        $i18n->quantity = __('Quantity', 'nextgen-gallery-pro');
        $i18n->description = __('Description', 'nextgen-gallery-pro');
        $i18n->price = __('Price', 'nextgen-gallery-pro');
        $i18n->total = __('Total', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function enqueue_static_resources()
    {
        wp_enqueue_style('ngg-pro-order-info', $this->get_static_url('photocrati-nextgen_pro_ecommerce#order_info.css'));
    }
    public function render($cart)
    {
        $this->enqueue_static_resources();
        $cart = $cart->to_array();
        return $this->object->render_partial('photocrati-nextgen_pro_ecommerce#order', array('images' => $cart['images'], 'i18n' => $this->get_i18n_strings()), TRUE);
    }
}
class C_NextGen_Pro_Order_Verification extends C_MVC_Controller
{
    static $_instance = NULL;
    static function get_instance()
    {
        if (!isset(self::$_instance)) {
            $klass = get_class();
            self::$_instance = new $klass();
        }
        return self::$_instance;
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->please_wait_msg = __('Please wait - we appreciate your patience.', 'nextgen-gallery-pro');
        $i18n->verifying_order_msg = __('We\'re verifying your order. This might take a few minutes.', 'nextgen-gallery-pro');
        $i18n->redirect_msg = __('This page will redirect automatically.', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function render($order_hash)
    {
        wp_enqueue_script('photocrati_ajax');
        return $this->render_partial('photocrati-nextgen_pro_ecommerce#order_verification', array('order_hash' => $order_hash, 'i18n' => $this->get_i18n_strings()), TRUE);
    }
}
class C_Order_Mapper extends C_CustomPost_DataMapper_Driver
{
    public static $_instances = array();
    public static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            $klass = get_class();
            self::$_instances[$context] = new $klass($context);
        }
        return self::$_instances[$context];
    }
    public function define($context = FALSE)
    {
        $object_name = 'ngg_order';
        // Add the object name to the context of the object as well
        // This allows us to adapt the driver itself, if required
        if (!is_array($context)) {
            $context = array($context);
        }
        array_push($context, $object_name);
        parent::define($object_name, $context);
        $this->add_mixin('Mixin_Order_Mapper');
        $this->set_model_factory_method($object_name);
        // Define columns/properties
        $this->define_column('ID', 'BIGINT', 0);
        $this->define_column('email', 'VARCHAR(255)');
        $this->define_column('customer_name', 'VARCHAR(255');
        $this->define_column('phone', 'VARCHAR(255)');
        $this->define_column('total_amount', 'DECIMAL', 0.0);
        $this->define_column('payment_gateway', 'VARCHAR(255)');
        $this->define_column('shipping_street_address', 'VARCHAR(255)');
        $this->define_column('shipping_address_line', 'VARCHAR(255)');
        $this->define_column('shipping_city', 'VARCHAR(255)');
        $this->define_column('shipping_state', 'VARCHAR(255)');
        $this->define_column('shipping_zip', 'VARCHAR(255)');
        $this->define_column('shipping_country', 'VARCHAR(255)');
        $this->define_column('shipping_phone', 'VARCHAR(255)');
        $this->define_column('cart', 'TEXT');
        $this->define_column('hash', 'VARCHAR(255)');
        $this->define_column('gateway_admin_note', 'VARCHAR(255)');
        $this->add_serialized_column('cart');
    }
    public function initialize($context = FALSE)
    {
        parent::initialize('ngg_order');
    }
    public function find_by_hash($hash, $model = FALSE)
    {
        $results = $this->select()->where(array('hash = %s', $hash))->run_query(NULL, $model);
        return array_pop($results);
    }
}
class Mixin_Order_Mapper extends Mixin
{
    public function _save_entity($entity)
    {
        // Create a unique hash
        if (!property_exists($entity, 'hash') or !$entity->hash) {
            $entity->hash = md5(time() . $entity->email . (is_string($this->cart) ? $this->cart : json_encode($this->cart)));
        }
        return $this->call_parent('_save_entity', $entity);
    }
    /**
     * Uses the title attribute as the post title
     * @param stdClass $entity
     * @return string
     */
    public function get_post_title($entity)
    {
        return $entity->customer_name;
    }
    public function set_defaults($entity)
    {
        // Pricelists should be published by default
        $entity->post_status = 'publish';
        // TODO: This should be part of the datamapper actually
        $entity->post_title = $this->get_post_title($entity);
    }
}
class C_Pricelist extends C_DataMapper_Model
{
    public $_mapper_interface = 'I_Pricelist_Mapper';
    public function define($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        parent::define($mapper, $properties, $context);
        $this->implement('I_Pricelist');
    }
    /**
     * Initializes a display type with properties
     * @param FALSE|C_Display_Type_Mapper $mapper
     * @param array|stdClass|C_Display_Type $properties
     * @param FALSE|string|array $context
     */
    public function initialize($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        // If no mapper was specified, then get the mapper
        if (!$mapper) {
            $mapper = $this->get_registry()->get_utility($this->_mapper_interface);
        }
        // Construct the model
        parent::initialize($mapper, $properties);
    }
    /**
     * Gets all items from all sources for the pricelist, optionally filtered by an image
     * @param null $image
     * @return array
     */
    public function get_items($image = NULL)
    {
        $retval = array();
        foreach (C_Pricelist_Source_Manager::get_instance()->get_ids() as $id) {
            $method = "get_{$id}_items";
            if ($this->has_method($method)) {
                $items = $this->{$method}($image);
                $retval = array_merge($retval, $items);
            }
        }
        return $retval;
    }
    public function delete_items($ids = array())
    {
        $this->get_mapper()->destroy_items($this->id(), $ids);
    }
    public function destroy_items($ids = array())
    {
        return $this->delete_items($ids);
    }
    public function get_ngg_manual_pricelist_items($image)
    {
        return $this->get_manual_items($image);
    }
    public function get_ngg_digital_downloads_items($image)
    {
        return $this->get_digital_downloads($image);
    }
    /**
     * Gets all manual items of the pricelist
     * @param null $image
     * @return mixed
     */
    public function get_manual_items($image = NULL)
    {
        $mapper = C_Pricelist_Item_Mapper::get_instance();
        $conditions = array(array('pricelist_id = %d', $this->object->id()), array('source IN %s', array(NGG_PRO_MANUAL_PRICELIST_SOURCE)));
        return $mapper->select()->where($conditions)->order_by('ID', 'ASC')->run_query();
    }
    /**
     * Gets all digital downloads for the pricelist
     * @param null $image_id
     * @return mixed
     */
    public function get_digital_downloads($image_id = NULL)
    {
        // Find digital download items
        $mapper = C_Pricelist_Item_Mapper::get_instance();
        $conditions = array(array('pricelist_id = %d', $this->object->id()), array('source IN %s', array(NGG_PRO_DIGITAL_DOWNLOADS_SOURCE)));
        $items = $mapper->select()->where($conditions)->order_by('ID', 'ASC')->run_query();
        // Filter by image resolutions
        if ($image_id) {
            $image = is_object($image_id) ? $image_id : C_Image_Mapper::get_instance()->find($image_id);
            if ($image) {
                $retval = array();
                $storage = C_Gallery_Storage::get_instance();
                foreach ($items as $item) {
                    $source_width = $image->meta_data['width'];
                    $source_height = $image->meta_data['height'];
                    // the downloads themselves come from the backup as source so if possible only filter images
                    // whose backup file doesn't have sufficient dimensions
                    $backup_abspath = $storage->get_backup_abspath($image);
                    if (@file_exists($backup_abspath)) {
                        $dimensions = @getimagesize($backup_abspath);
                        $source_width = $dimensions[0];
                        $source_height = $dimensions[1];
                    }
                    if (isset($item->resolution) && $item->resolution >= 0 && ($source_height >= $item->resolution or $source_width >= $item->resolution)) {
                        $retval[] = $item;
                    }
                }
                $items = $retval;
            }
        }
        return $items;
    }
    public function validate()
    {
        $this->validates_presence_of('title');
    }
}
class C_Pricelist_Item extends C_DataMapper_Model
{
    public $_mapper_interface = 'I_Pricelist_Item_Mapper';
    public function define($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        parent::define($mapper, $properties, $context);
        $this->implement('I_Pricelist_Item');
    }
    /**
     * Initializes a display type with properties
     * @param FALSE|C_Display_Type_Mapper $mapper
     * @param array|stdClass|C_Display_Type $properties
     * @param FALSE|string|array $context
     */
    public function initialize($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        // If no mapper was specified, then get the mapper
        if (!$mapper) {
            $mapper = $this->get_registry()->get_utility($this->_mapper_interface);
        }
        // Construct the model
        parent::initialize($mapper, $properties);
    }
    public function validation()
    {
        $this->validates_presence_of('title');
        $this->validates_presence_of('price');
        $this->validates_presence_of('source');
        $this->validates_presence_of('pricelist_id');
        $this->validates_numericality_of('price', 0.0, '>');
    }
}
class C_Pricelist_Item_Mapper extends C_CustomPost_DataMapper_Driver
{
    public static $_instances = array();
    public static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_Pricelist_Item_Mapper();
        }
        return self::$_instances[$context];
    }
    public function define($context = FALSE)
    {
        $object_name = 'ngg_pricelist_item';
        // Add the object name to the context of the object as well
        // This allows us to adapt the driver itself, if required
        if (!is_array($context)) {
            $context = array($context);
        }
        array_push($context, $object_name);
        parent::define($object_name, $context);
        $this->set_model_factory_method($object_name);
        // Define columns
        $this->define_column('ID', 'BIGINT', 0);
        $this->define_column('pricelist_id', 'BIGINT', 0);
        $this->define_column('price', 'DECIMAL', 0.0);
        $this->define_column('source', 'VARCHAR(255)');
        $this->define_column('resolution', 'DECIMAL');
        $this->define_column('is_shippable', 'BOOLEAN', FALSE);
    }
    public function initialize($context = FALSE)
    {
        parent::initialize('ngg_pricelist_item');
    }
    /**
     * Uses the title attribute as the post title
     * @param stdClass $entity
     * @return string
     */
    public function get_post_title($entity)
    {
        return $entity->title;
    }
}
class C_Pricelist_Mapper extends C_CustomPost_DataMapper_Driver
{
    public static $_instances = array();
    static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            $klass = get_class();
            self::$_instances[$context] = new $klass($context);
        }
        return self::$_instances[$context];
    }
    public function define($context = FALSE, $not_used = FALSE)
    {
        $object_name = 'ngg_pricelist';
        // Add the object name to the context of the object as well
        // This allows us to adapt the driver itself, if required
        if (!is_array($context)) {
            $context = array($context);
        }
        array_push($context, $object_name);
        parent::define($object_name, $context);
        $this->add_mixin('Mixin_Pricelist_Mapper');
        $this->set_model_factory_method($object_name);
        // Define columns
        $this->define_column('ID', 'BIGINT');
        $this->define_column('post_author', 'BIGINT');
        $this->define_column('title', 'VARCHAR(255)');
        $this->define_column('manual_settings', 'TEXT');
        $this->define_column('digital_download_settings', 'TEXT');
        // Mark the columns which should be unserialized
        $this->add_serialized_column('manual_settings');
        $this->add_serialized_column('digital_download_settings');
    }
    public function initialize($context = FALSE)
    {
        parent::initialize('ngg_pricelist');
    }
}
class Mixin_Pricelist_Mapper extends Mixin
{
    public function destroy($entity)
    {
        if ($this->call_parent('destroy', $entity)) {
            return $this->destroy_items($entity);
        } else {
            return FALSE;
        }
    }
    public function destroy_items($pricelist_id, $ids = array())
    {
        global $wpdb;
        // If no ids have been provided, then delete all items for the given pricelist
        if (!$ids) {
            // Ensure we have the pricelist id
            if (!is_int($pricelist_id)) {
                $pricelist_id = $pricelist_id->ID;
            }
            // Find all item ids
            $item_mapper = C_Pricelist_Item_Mapper::get_instance();
            $ids = array();
            $results = $item_mapper->select('ID, post_parent')->where(array('pricelist_id = %d', $pricelist_id))->run_query();
            foreach ($results as $row) {
                $ids[] = $row->ID;
                if ($row->post_parent) {
                    $ids[] = $row->post_parent;
                }
            }
        }
        // Get unique ids
        $ids = array_unique($ids);
        // Delete all posts and post meta for the item ids
        $sql = array();
        $sql[] = "DELETE FROM {$wpdb->posts} WHERE ID IN (" . implode(',', $ids) . ')';
        $sql[] = "DELETE FROM {$wpdb->postmeta} WHERE post_id IN (" . implode(',', $ids) . ')';
        foreach ($sql as $query) {
            $wpdb->query($query);
        }
        return TRUE;
    }
    /**
     * Uses the title attribute as the post title
     * @param stdClass $entity
     * @return string
     */
    public function get_post_title($entity)
    {
        return $entity->title;
    }
    public function find_for_gallery($id, $model = FALSE)
    {
        $retval = NULL;
        if (is_object($id)) {
            $id = $id->{$id->id_field};
        }
        $mapper = C_Gallery_Mapper::get_instance();
        if ($gallery = $mapper->find($id)) {
            if (isset($gallery->pricelist_id)) {
                $retval = $this->object->find($gallery->pricelist_id, $model);
            }
        }
        return $retval;
    }
    public function find_for_image($id, $model = FALSE)
    {
        $retval = NULL;
        $image = NULL;
        // Find the image
        if (is_object($id)) {
            $image = $id;
        } else {
            $mapper = C_Image_Mapper::get_instance();
            $image = $mapper->find($id);
        }
        // If we've found the image, then find it's pricelist
        if ($image) {
            if ($image->pricelist_id) {
                $retval = $this->object->find($image->pricelist_id, $model);
            } else {
                $retval = $this->find_for_gallery($image->galleryid, $model);
            }
        }
        return $retval;
    }
    public function set_defaults($entity)
    {
        // Set defaults for manual pricelist settings
        if (!isset($entity->manual_settings)) {
            $entity->manual_settings = array();
        }
        if (!isset($entity->manual_settings['domestic_shipping_method'])) {
            $entity->manual_settings['domestic_shipping_method'] = 'flat';
        }
        if (!array_key_exists('domestic_shipping_rate', $entity->manual_settings)) {
            $entity->manual_settings['domestic_shipping_rate'] = 5.0;
        }
        if (!isset($entity->manual_settings['allow_global_shipments'])) {
            $entity->manual_settings['allow_global_shipments'] = 0;
        }
        if (!isset($entity->manual_settings['global_shipping_method'])) {
            $entity->manual_settings['global_shipping_method'] = 'flat';
        }
        if (!array_key_exists('global_shipping_rate', $entity->manual_settings)) {
            $entity->manual_settings['global_shipping_rate'] = 5.0;
        }
        // Set defaults for digital download settings
        if (!isset($entity->digital_download_settings)) {
            $entity->digital_download_settings = array();
        }
        if (!isset($entity->digital_download_settings['show_licensing_link'])) {
            $entity->digital_download_settings['show_licensing_link'] = 0;
        }
        if (!isset($entity->digital_download_settings['licensing_page_id'])) {
            $entity->digital_download_settings['licensing_page_id'] = 0;
        }
        // Pricelists should be published by default
        $entity->post_status = 'publish';
        // TODO: This should be part of the datamapper actually
        $entity->post_title = $this->get_post_title($entity);
    }
}
class C_Pricelist_Source_Manager
{
    static $_instance = NULL;
    public $_registered = array();
    /**
     * @return C_Pricelist_Source_Manager
     */
    static function get_instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new C_Pricelist_Source_Manager();
        }
        return self::$_instance;
    }
    /**
     * Registers a pricelist source with the system
     * @param $id
     * @param array $properties
     */
    public function register($id, $properties = array())
    {
        $this->_registered[$id] = $properties;
    }
    /**
     * Deregisters a pricelist source with the system
     * @param $id
     */
    public function deregister($id)
    {
        unset($this->_registered[$id]);
    }
    /**
     * Updates a source properties
     * @param $id
     * @param array $properties
     */
    public function update($id, $properties = array())
    {
        $retval = FALSE;
        if (isset($this->_registered[$id])) {
            foreach ($properties as $k => $v) {
                $this->_registered[$id][$k] = $v;
            }
            $retval = TRUE;
        }
        return $retval;
    }
    /**
     * Gets all or a specific property of a pricelist source
     * @param $id
     * @param bool $property
     * @return null
     */
    public function get($id, $property = FALSE)
    {
        $retval = NULL;
        if (isset($this->_registered[$id])) {
            if ($property && isset($this->_registered[$id][$property])) {
                $retval = $this->_registered[$id][$property];
            } else {
                if (!$property) {
                    $retval = $this->_registered[$id];
                }
            }
        }
        return $retval;
    }
    /**
     * Gets ids of all registered sources
     * @return array
     */
    public function get_ids()
    {
        return array_keys($this->_registered);
    }
}
class C_Pricelist_Source_Page extends C_NextGen_Admin_Page_Controller
{
    static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_Pricelist_Source_Page();
        }
        return self::$_instances[$context];
    }
    public function define()
    {
        parent::define(NGG_PRO_PRICELIST_SOURCE_PAGE);
    }
    public function get_required_permission()
    {
        return 'NextGEN Change options';
    }
    public function get_page_heading()
    {
        return __('Manage Pricelist', 'nextgen-gallery-pro');
    }
    public function enqueue_backend_resources()
    {
        parent::enqueue_backend_resources();
        $router = C_Router::get_instance();
        if (!wp_script_is('sprintf')) {
            wp_register_script('sprintf', $router->get_static_url('photocrati-nextgen_pro_ecommerce#sprintf.js'));
        }
        wp_enqueue_script('sprintf');
        wp_enqueue_script('jquery.number');
        // Enqueue fontawesome
        if (method_exists('M_Gallery_Display', 'enqueue_fontawesome')) {
            M_Gallery_Display::enqueue_fontawesome();
        } else {
            C_Display_Type_Controller::get_instance()->enqueue_displayed_gallery_trigger_buttons_resources();
        }
        wp_enqueue_style('fontawesome');
    }
    public function index_template()
    {
        return 'photocrati-nextgen_pro_ecommerce#manage_pricelist';
    }
    public function get_model()
    {
        if (!isset($this->pricelist)) {
            $pricelist_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
            $mapper = C_Pricelist_Mapper::get_instance();
            if (!($this->pricelist = $mapper->find($pricelist_id, TRUE))) {
                $this->pricelist = $mapper->create();
            }
        }
        return $this->pricelist;
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->saved = __('Saved pricelist successfully', 'nextgen-gallery-pro');
        $i18n->deleted = __('Deleted pricelist', 'nextgen-gallery-pro');
        return $i18n;
    }
    /**
     * Gets the action to be executed
     * @return string
     */
    public function _get_action()
    {
        $action = $this->object->param('action');
        if (!$action && isset($_REQUEST['action_proxy'])) {
            $action = $_REQUEST['action_proxy'];
        }
        $retval = preg_quote($action, '/');
        $retval = strtolower(preg_replace('/[^\\w]/', '_', $retval));
        return preg_replace('/_{2,}/', '_', $retval) . '_action';
    }
    public function get_success_message()
    {
        $retval = $this->param('message');
        if (!$retval) {
            if ($this->_get_action() == 'delete_action') {
                $retval = 'deleted';
            } else {
                $retval = 'saved';
            }
        }
        return $this->get_i18n_strings()->{$retval};
    }
    public function save_action()
    {
        $retval = FALSE;
        // Do I need to check security token?
        $pricelist = $this->get_model();
        // disable caching or the changes we're about to save() won't be displayed
        $mapper = C_Pricelist_Mapper::get_instance();
        $mapper->_use_cache = FALSE;
        if ($pricelist->save($_REQUEST['pricelist'])) {
            // Reset the pricelist object
            $this->pricelist = $pricelist;
            // Create price list items
            $item_mapper = C_Pricelist_Item_Mapper::get_instance();
            foreach ($_POST['pricelist_item'] as $id => $updates) {
                // Set the pricelist associated to each item
                $updates['pricelist_id'] = $pricelist->id();
                if (strpos($id, 'new-') !== FALSE) {
                    $item = $item_mapper->create($updates);
                    $item->save();
                } else {
                    $item = $item_mapper->find($id, TRUE);
                    $item->save($updates);
                }
            }
            if (!isset($_REQUEST['id'])) {
                wp_redirect(admin_url('edit.php?post_type=ngg_pricelist&id=' . $pricelist->id() . '&message=saved'));
            }
        }
        if (isset($_REQUEST['deleted_items'])) {
            $pricelist->destroy_items($_REQUEST['deleted_items']);
        }
        return $retval;
    }
    public function delete_action()
    {
        if ($this->get_model()->destroy()) {
            wp_redirect(admin_url('edit.php?post_type=ngg_pricelist&ids=' . $this->get_model()->id()));
        } else {
            return FALSE;
        }
    }
}