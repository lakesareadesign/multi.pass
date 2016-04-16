<?php
/*
{
    Module: photocrati-nextgen_pro_ecommerce
}
*/

define('NGG_ECOMMERCE_TRIGGER', 'photocrati-ecommerce');
define('NGG_PRO_PRICELIST_SOURCE_PAGE', 'ngg-pricelist-source-page');
define('NGG_PRO_ECOMMERCE_OPTIONS_PAGE', 'ngg_ecommerce_options');
define('NGG_PRO_ECOMMERCE_INSTRUCTIONS_PAGE', 'ngg-ecommerce-instructions-page');
define('NGG_PRO_MANUAL_PRICELIST_SOURCE', 'ngg_manual_pricelist');
define('NGG_PRO_DIGITAL_DOWNLOADS_SOURCE', 'ngg_digital_downloads');
define('NGG_PRO_PAYMENT_PAYMENT_FORM', 'ngg-payment-gateways');
define('NGG_PRO_ECOMMERCE_OPTIONS_FORM', 'ngg-ecommerce-options');
define('NGG_PRO_ECOMMERCE_INSTRUCTIONS_FORM', 'ngg-ecommerce-instructions');
define('NGG_PRO_MAIL_FORM', 'ngg-mail');

class M_NextGen_Pro_Ecommerce extends C_Base_Module
{
    function define($context=FALSE)
    {
        parent::define(
            'photocrati-nextgen_pro_ecommerce',
            'Ecommerce',
            'Provides ecommerce capabilities for the NextGEN Pro Lightbox',
            '0.10',
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com',
            $context
        );

        C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Ecommerce_Installer');
    }

    function initialize()
    {
        parent::initialize();

        if (!is_admin()) {
            // Add lightbox components
            if (version_compare(NGG_PLUGIN_VERSION, '2.0.67') >= 0)
                M_NextGen_Pro_Lightbox::add_component('photocrati-add_to_cart', 'C_NextGen_Pro_Add_To_Cart');
            else
                M_NextGen_Pro_Lightbox_Legacy::add_component('photocrati-add_to_cart', 'C_NextGen_Pro_Add_To_Cart');

            // Add trigger
            $triggers = C_Displayed_Gallery_Trigger_Manager::get_instance();
            $triggers->add(NGG_ECOMMERCE_TRIGGER, 'C_NextGen_Pro_Ecommerce_Trigger');

            C_NextGen_Shortcode_Manager::add('ngg_pro_cart_count', array(&$this, 'render_cart_count'));
            C_NextGen_Shortcode_Manager::add('ngg_pro_checkout', array(&$this, 'render_checkout_form'));
            C_NextGen_Shortcode_Manager::add('ngg_pro_digital_downloads', array(&$this, 'render_digital_downloads'));
            C_NextGen_Shortcode_Manager::add('ngg_pro_order_details', array(&$this, 'render_order_details'));
            C_NextGen_Shortcode_Manager::add('ngg_pro_verify_order', array(&$this, 'render_order_verification'));
        }

        // Add pricelist sources
        $sources = C_Pricelist_Source_Manager::get_instance();
        $sources->register(NGG_PRO_MANUAL_PRICELIST_SOURCE, array(
            'title'              =>  __('Manual Pricelist', 'nextgen-gallery-pro'),
            'shipping_method'    =>  'C_NextGen_Pro_Flat_Rate_Shipping_Calculator',
            'settings_field'     =>  'manual_settings',
        ));
        $sources->register(NGG_PRO_DIGITAL_DOWNLOADS_SOURCE, array(
            'title'             =>  __('Digital Downloads', 'nextgen-gallery-pro'),
            'shipping_method'   =>  NULL,
            'settings_field'    =>  'digital_download_settings'
        ));
    }

    function _register_adapters()
    {
        if (M_Attach_To_Post::is_atp_url() || is_admin())
        {
            $this->get_registry()->add_adapter('I_Form', 'A_Manual_Pricelist_Form', NGG_PRO_MANUAL_PRICELIST_SOURCE);
            $this->get_registry()->add_adapter('I_Form', 'A_Digital_Downloads_Form', NGG_PRO_DIGITAL_DOWNLOADS_SOURCE);
            $this->get_registry()->add_adapter('I_Form', 'A_Ecommerce_Instructions_Form', NGG_PRO_ECOMMERCE_INSTRUCTIONS_FORM);
            $this->get_registry()->add_adapter('I_Form', 'A_Ecommerce_Options_Form', NGG_PRO_ECOMMERCE_OPTIONS_FORM);
            $this->get_registry()->add_adapter('I_Form', 'A_Payment_Gateway_Form', NGG_PRO_PAYMENT_PAYMENT_FORM);
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Lightbox_Mail_Form', NGG_PRO_MAIL_FORM);
            $this->get_registry()->add_adapter('I_NextGen_Admin_Page', 'A_Ecommerce_Options_Controller', NGG_PRO_ECOMMERCE_OPTIONS_PAGE);
            $this->get_registry()->add_adapter('I_NextGen_Admin_Page', 'A_Ecommerce_Instructions_Controller', NGG_PRO_ECOMMERCE_INSTRUCTIONS_PAGE);
            $this->get_registry()->add_adapter('I_Page_Manager',   'A_Ecommerce_Pages');
            $this->get_registry()->add_adapter('I_Form', 'A_Reset_Ecommerce_Settings_Form', 'reset');

            // apply the settings form to the correct context
            if (class_exists('M_NextGen_Pro_Lightbox_Legacy'))
                $this->get_registry()->add_adapter('I_Form', 'A_Ecommerce_Pro_Lightbox_Form', NGG_PRO_LIGHTBOX . '_basic');
            else
                $this->get_registry()->add_adapter('I_Form', 'A_Ecommerce_Pro_Lightbox_Form', NGG_PRO_LIGHTBOX);
        }

        $this->get_registry()->add_adapter('I_Component_Factory', 'A_Ecommerce_Factory');
        $this->get_registry()->add_adapter('I_Gallery_Mapper', 'A_Ecommerce_Gallery');
        $this->get_registry()->add_adapter('I_Image_Mapper',   'A_Ecommerce_Image');

        if (!is_admin()) {
            $this->get_registry()->add_adapter('I_Ajax_Controller','A_Ecommerce_Ajax');
            $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NplModal_Ecommerce_Overrides');
        }
    }

    function _register_utilities()
    {
        $this->get_registry()->add_utility('I_Nextgen_Mail_Manager', 'C_Nextgen_Mail_Manager');
    }

    function _register_hooks()
    {
        add_action('init', array(&$this, 'register_post_types'), 1);
        add_action('init', array($this, 'register_display_type_settings'));
        add_filter('posts_results', array(&$this, 'serve_ecommerce_pages'), 10, 2);
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_resources'), 9);

        if (M_Attach_To_Post::is_atp_url() || is_admin())
        {
            add_action('admin_init', array(&$this, 'register_forms'));
            add_action('init', array($this, 'register_display_type_settings'), (PHP_INT_MAX-1));
            add_filter('ngg_manage_gallery_fields', array(&$this, 'add_gallery_pricelist_field'), 20, 2);
            add_filter('ngg_manage_images_number_of_columns', array(&$this, 'add_ecommerce_column'));
            add_filter('get_edit_post_link', array(&$this, 'custom_edit_link'));
            add_action('admin_init', array(&$this, 'redirect_to_manage_pricelist_page'));
            add_action('admin_menu', array(&$this, 'add_parent_menu'), 15);
	        add_action('admin_init', array(&$this, 'enqueue_backend_resources'));

            // Tweak our custom post type UIs
            if (strpos($_SERVER['SCRIPT_NAME'], '/wp-admin/edit.php') !== FALSE &&
                isset($_REQUEST['post_type']) && in_array($_REQUEST['post_type'], array('ngg_pricelist', 'ngg_order'))) {
                add_filter('post_row_actions', array(&$this, 'hide_quick_edit_link'), 10, 2);
                add_filter('bulk_actions-edit-ngg_order', array(&$this, 'set_bulk_actions'));
                add_filter('bulk_actions-edit-ngg_pricelist', array($this, 'set_pricelist_bulk_actions'));
                add_filter('views_edit-ngg_order', array(&$this, 'remove_post_status_views'));
                add_filter('views_edit-ngg_pricelist', array(&$this, 'remove_post_status_views'));
	            add_action('admin_init', array(&$this, 'duplicate_pricelist'));

                if ($_REQUEST['post_type'] == 'ngg_order') {
                    add_action('restrict_manage_posts', array(&$this, 'filter_orders_restrict_manage_posts'));
                    if (isset($_REQUEST['action']) && $_REQUEST['action'] == -1) {
                        add_action('pre_get_posts', array(&$this, 'filter_orders_pre_get_posts'));
                    }
                    add_filter('manage_ngg_order_posts_columns', array(&$this, 'order_columns'));
                    add_action('manage_ngg_order_posts_custom_column', array(&$this, 'output_order_column'), 10, 2);
                    add_filter('manage_edit-ngg_order_sortable_columns', array(&$this, 'order_columns'));

                    if (isset($_REQUEST['s'])) {
                        add_filter('get_search_query', array(&$this, 'restore_search_filter'));
                    }
                }

                // We want the Manage Pricelists page to be overwritten with our form used for
                // creating new pricelists
                if (isset($_REQUEST['ngg_edit'])) {
                    if (isset($_REQUEST['action'])) $_REQUEST['ngg_action'] = $_REQUEST['action'];
                    unset($_REQUEST['action']);
                    unset($_POST['action']);
                    add_action('all_admin_notices', array(&$this, 'buffer_for_manage_pricelist_page'), PHP_INT_MAX-1);
                    add_action('in_admin_footer', array(&$this, 'render_manage_pricelist_page'));
                }
            }
        }

        // Flush the cart when the order is complete
        if (isset($_REQUEST['ngg_order_complete']))
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue_flush_cart'));
    }

	function duplicate_pricelist()
	{
		if (isset($_REQUEST['ngg_duplicate']) && current_user_can('NextGEN Change options')) {
			$pricelist_mapper = C_Pricelist_Mapper::get_instance();
			if (($pricelist = $pricelist_mapper->find($_REQUEST['id'], TRUE))) {

				// Get items for the pricelist
				$items = $pricelist->get_items();

				// Find the unique post title
				$results = $pricelist_mapper->select()->where(array('post_title LIKE %s', $pricelist->post_title . '%'))->run_query();
				$i=0;
				foreach ($results as $p) {
					$number = intval(trim(str_replace($pricelist->post_title, '', $p->post_title)));
					if ($number > $i) $i = $number;
				}
				$i++;

				// Create new pricelist
				$pricelist->ID = NULL;
				$pricelist->post_date = $pricelist->post_date_gmt = $pricelist->post_modified = $pricelist->post_modified_gmt = NULL;
				$pricelist->post_title = $pricelist->title = "{$pricelist->title} {$i}";
				$pricelist_mapper->save($pricelist);

				// Duplicate pricelist items
				$item_mapper = C_Pricelist_Item_Mapper::get_instance();
				foreach ($items as $item) {
					$item->ID = NULL;
					$item->pricelist_id = $pricelist->ID;
					$item_mapper->save($item);
				}

				wp_redirect(admin_url("/edit.php?post_type={$_REQUEST['post_type']}"));
			}
		}
	}

    function add_parent_menu()
    {
        $controller = $this->get_registry()->get_utility('I_NextGen_Admin_Page', NGG_PRO_ECOMMERCE_OPTIONS_PAGE);

        add_menu_page(
            __('Ecommerce', 'nextgen-gallery-pro'),
            __('Ecommerce', 'nextgen-gallery-pro'),
            'NextGEN Change options',
            NGG_PRO_ECOMMERCE_OPTIONS_PAGE,
            array(&$controller, 'index_action'),
            path_join(NGGALLERY_URLPATH, 'admin/images/nextgen_16_color.png')
        );
    }

    function set_bulk_actions($actions)
    {
        unset($actions['edit']);
        return $actions;
    }

    function set_pricelist_bulk_actions($actions)
    {
        unset($actions['edit']);
        unset($actions['delete']);
        return $actions;
    }

    function remove_post_status_views($views)
    {
        unset($views['draft']);
        unset($views['publish']);
        if (count($views) == 1) $views = array();
        return $views;
    }

    function restore_search_filter()
    {
        return $_REQUEST['s'];
    }

    function order_columns($columns)
    {
	    unset($columns['title']);

        $columns['order_hash']      = __('ID', 'nextgen-gallery-pro');
        $columns['order_customer']  = __('Customer', 'nextgen-gallery-pro');
	    $columns['order_status']    = __('Order Status', 'nextgen-gallery-pro');
	    $columns['order_gateway']   = __('Payment Gateway', 'nextgen-gallery-pro');
	    $columns['order_total']     = __('Total', 'nextgen-gallery-pro');

        return $columns;
    }

    function output_order_column($column_name, $post_id)
    {
        global $post;
        $order_mapper = C_Order_Mapper::get_instance();
        $entity = $order_mapper->unserialize($post->post_content);
        switch ($column_name) {
            case 'order_gateway':
                $str = '';
                switch ($entity['payment_gateway']) {
                    case 'cheque':
                        $str = __('Cheque', 'nextgen-gallery-pro');
                        break;
                    case 'paypal_standard':
                    case 'paypal_express_checkout':
                        $str = __('PayPal', 'nextgen-gallery-pro');
                        break;
                    case 'stripe_checkout':
                        $str = __('Stripe', 'nextgen-gallery-pro');
                        break;
                    case 'test_gateway':
                        $str = __('Test', 'nextgen-gallery-pro');
                        break;
                    default:
                        break;
                }
                echo $str;
                break;
            case 'order_total':
                $cart = new C_NextGen_Pro_Cart($entity['cart']);
				$use_home_country = isset($entity['use_home_country']) ? $entity['use_home_country'] : FALSE;
                echo $this->get_formatted_price($cart->get_total($use_home_country));
                break;
            case 'order_status':
                echo esc_html($entity['status']);
                break;
            case 'order_hash':
               echo esc_html($post_id);
               break;
            case 'order_customer':
               $checkout = C_NextGen_Pro_Checkout::get_instance();
               $url = esc_attr($checkout->get_thank_you_page_url($entity['hash']));
               $name = esc_html($entity['customer_name']);
               echo "<a href='{$url}' target='_blank'>{$name}</a>";
                break;
        }
    }

    function filter_orders_restrict_manage_posts($post_type = FALSE)
    {
        if ($post_type !== 'ngg_order') return;

        // List of possible order statuses
        $options = array();
        $statuses = apply_filters('ngg_ecommerce_order_statuses', array(
            'all'        => __('All order statuses', 'nextgen-gallery-pro'),
            'verified'   => __('Verified', 'nextgen-gallery-pro'),
            'unverified' => __('Unverified', 'nextgen-gallery-pro'),
            'fraud'      => __('Fraud', 'nextgen-gallery-pro')
        ));

        // Sanitize
        foreach ($statuses as $key => $value) {
            $options[esc_attr($key)] = esc_html($value);
        }
        $statuses = $options;

        // Create options
        foreach ($statuses as $key => $value)
            $options[] = "<option value='{$key}'>{$value}</option>";
        $options = implode("\n", $options);

        echo "<select name='order_status'>{$options}</select>";
    }

    function filter_orders_pre_get_posts($query)
    {
        $meta_query = array();

        // Filter by order status
        if ($_REQUEST['order_status'] != 'all')
        {
            $meta_query[] = array(
                'key'   => 'status',
                'value' => urldecode($_REQUEST['order_status'])
            );
        }

        if (isset($_REQUEST['s']))
        {
            $query->set('s', NULL);
            $meta_query[] = array(
                'key'     => 'customer_name',
                'value'   => urldecode($_REQUEST['s']),
                'compare' => 'LIKE'
            );
        }

        if ($meta_query)
            $query->set('meta_query', $meta_query);
    }

    function register_forms()
    {
        // Add forms
        $forms = C_Form_Manager::get_instance();
        $forms->add_form(NGG_PRO_ECOMMERCE_INSTRUCTIONS_PAGE, NGG_PRO_ECOMMERCE_INSTRUCTIONS_FORM);
        $forms->add_form(NGG_PRO_PRICELIST_SOURCE_PAGE, NGG_PRO_MANUAL_PRICELIST_SOURCE);
        $forms->add_form(NGG_PRO_PRICELIST_SOURCE_PAGE, NGG_PRO_DIGITAL_DOWNLOADS_SOURCE);
        $forms->add_form(NGG_PRO_ECOMMERCE_OPTIONS_PAGE, NGG_PRO_ECOMMERCE_OPTIONS_FORM);
        $forms->add_form(NGG_PRO_ECOMMERCE_OPTIONS_PAGE, NGG_PRO_MAIL_FORM);
        $forms->add_form(NGG_PRO_ECOMMERCE_OPTIONS_PAGE, NGG_PRO_PAYMENT_PAYMENT_FORM);
    }

    /**
     * Hides the quick edit button to avoid users changing the post_status of a pricelist
     * @param $actions
     * @return mixed
     */
    function hide_quick_edit_link($actions, $post)
    {
        $retval = array();

	    if ($post->post_type != 'ngg_order') {
		    if (!empty($actions['edit']))
			    $retval['edit'] = $actions['edit'];

		    if ($post->post_type == 'ngg_pricelist') {
			    $url = esc_attr(admin_url('/edit.php?post_type=ngg_pricelist&ngg_duplicate=1&id='.$post->ID));
			    $retval['ngg_duplicate_pricelist'] = "<a href='{$url}'>".__('Duplicate', 'nextgen-gallery-pro')."</a>";
		    }

		    if (!empty($actions['trash']))
			    $retval['trash'] = $actions['trash'];
		    if (!empty($actions['untrash']))
			    $retval['untrash'] = $actions['untrash'];
	    }

        return $retval;
    }

    function enqueue_flush_cart()
    {
        $router = C_Router::get_instance();
        wp_enqueue_script(
            'ngg_ecommerce_clear_cart',
            $router->get_static_url('photocrati-nextgen_pro_ecommerce#clear_cart.js'),
            array('photocrati_ajax'),
            FALSE,
            TRUE
        );
    }

    function serve_ecommerce_pages($posts, $query)
    {
	    if ($query->is_main_query()) {

		    if (isset($_REQUEST['ngg_pro_digital_downloads_page'])) {
			    $post = new stdClass;
			    $post->name = 'ngg_pro_digital_downloads_page';
			    $post->post_title = __('Digital Downloads', 'nextgen-gallery-pro');
			    $post->post_parent = 0;
			    $post->post_content = "[ngg_pro_digital_downloads]";
			    $post->post_type = 'page';
			    $posts = array($post);
			    $query->is_singular = TRUE;
		    }
		    elseif (isset($_REQUEST['ngg_pro_checkout_page'])) {
			    $post = new stdClass;
			    $post->name = 'ngg_pro_checkout_page';
			    $post->post_title = __('Checkout', 'nextgen-gallery-pro');
			    $post->post_parent = 0;
			    $post->post_content = "[ngg_pro_checkout]";
			    $post->post_type = 'page';
			    $post->comment_status = 'closed';
			    $posts = array($post);
			    $query->is_singular = TRUE;
		    }
		    elseif (isset($_REQUEST['ngg_pro_return_page'])) {
			    $post = new stdClass;
			    $post->name = 'ngg_pro_return_page';
			    $post->post_title = __('Order Details', 'nextgen-gallery-pro');
			    $post->post_parent = 0;
			    $post->post_content = "[ngg_pro_order_details]";
			    $post->post_type = 'page';
			    $post->comment_status = 'closed';
			    $posts = array($post);
			    $query->is_singular = TRUE;
		    }
		    elseif (isset($_REQUEST['ngg_pro_cancel_page'])) {
			    $post = new stdClass;
			    $post->name = 'ngg_pro_return_page';
			    $post->post_title = __('Order Cancelled', 'nextgen-gallery-pro');
			    $post->post_parent = 0;
			    $post->post_content = __('Your order was cancelled', 'nextgen-gallery-pro');
			    $post->post_type = 'page';
			    $post->comment_status = 'closed';
			    $posts = array($post);
			    $query->is_singular = TRUE;
		    }
		    elseif (isset($_REQUEST['ngg_pro_verify_page'])) {
			    $post = new stdClass;
			    $post->name = 'ngg_pro_verifying_order_page';
			    $post->post_title = __('Verifying order', 'nextgen-gallery-pro');
			    $post->post_parent = 0;
			    $post->post_content = '[ngg_pro_verify_order]';
			    $post->post_type = 'page';
			    $post->comment_status = 'closed';
			    $posts = array($post);
			    $query->is_singular = TRUE;
		    }

		    remove_filter('posts_results', array(&$this, 'serve_ecommerce_pages'), 10, 2);
	    }

        return $posts;
    }

    function render_cart_count()
    {
        self::enqueue_cart_resources();
        return "<script type=text/javascript'>document.write(Ngg_Pro_Cart.get_instance().length);</script>";
    }

    function render_checkout_form()
    {
        $checkout = C_NextGen_Pro_Checkout::get_instance();
        return $checkout->checkout_form();
    }

    function render_digital_downloads()
    {
        $controller = C_Digital_Downloads::get_instance();
        return $controller->index_action();
    }

    function render_order_verification()
    {
        $controller = C_NextGen_Pro_Order_Verification::get_instance();
        return $controller->render($_REQUEST['order']);
    }

    function render_order_details($attrs=array(), $inner_content='')
    {
        $retval = __('Oops! This page usually displays details for image purchases, but you have not ordered any images yet. Please feel free to continue browsing. Thanks for visiting.', 'nextgen-gallery-pro');

        // Get the order to display
        $order_id   = FALSE;
        $method     = FALSE;
        if     (isset($attrs['order'])) {
            $order_id = $attrs['order'];
            $method = 'find_by_hash';
        }
        elseif (isset($_REQUEST['order'])) {
            $order_id = $_REQUEST['order'];
            $method = 'find_by_hash';
        }
        elseif (isset($attrs['order_id'])) {
            $order_id = $attrs['order_id'];
            $method = 'find';
        }

        // If we have an order, continue...
        if ($method && (($order = C_Order_Mapper::get_instance()->$method($order_id, TRUE)))) {

            // If no inner connect has been added, then use our own
            if (!$inner_content) $inner_content = __("Thank you for your order, [customer_name]. You ordered the following items:
                [items]

                <h3>Order Details</h3>
                <p>
                Subtotal: [subtotal_amount]<br/>
                [if_ordered_shippable_items]Shipping: [shipping_amount]<br/>[/if_ordered_shippable_items]
                Total: [total_amount]<br/>
                </p>

                [if_ordered_shippable_items]
                <p>
                We will be shipping your items to:<br/>
                [shipping_street_address]<br/>
                [shipping_city], [shipping_state] [shipping_zip]<br/>
                [shipping_country]
                </p>
                [/if_ordered_shippable_items]

                [if_ordered_digital_downloads]
                <h3>Digital Downloads</h3>
                <p>You may download your digital products <a href='[digital_downloads_page_url]'>here.</a></p>
                [/if_ordered_digital_downloads]
            ", 'nextgen-gallery-pro');

            $retval = $inner_content;

            // Add some other values to the order object
            $other_values = array(
                'subtotal'                      =>  $order->get_cart()->get_subtotal(),
                'subtotal_amount'               =>  $order->get_cart()->get_subtotal(),
                'shipping'                      =>  $order->get_cart()->get_shipping($order->use_home_country),
                'shipping_amount'               =>  $order->get_cart()->get_shipping($order->use_home_country),
                'digital_downloads_page_url'    =>  $this->get_digital_downloads_url($order->hash),
	            'total'                         =>  $order->get_cart()->get_total($order->use_home_country),
	            'total_total'                   =>  $order->get_cart()->get_total($order->use_home_country),
            );
            foreach ($other_values as $key => $value) $order->$key = $value;

            // Substitute placeholders for each variable of the order
            foreach (get_object_vars($order->get_entity()) as $key => $value) {
                $escape = TRUE;
                switch ($key) {
                    case 'ID':
                        $key = 'order_id';
                        break;
                    case 'post_date':
                        $key = 'order_date';
                        break;
                    case 'post_author':
                    case 'post_title':
                    case 'post_excerpt':
                    case 'post_status':
                    case 'comment_status':
                    case 'ping_status':
                    case 'post_name':
                    case 'to_ping':
                    case 'pinged':
                    case 'post_content_filtered':
                    case 'post_content':
                    case 'menu_order':
                    case 'post_type':
                        continue;
                        break;
                    case 'meta_value':
                        $key = 'order_hash';
                        break;
                    case 'total_amount':
                    case 'shipping':
                    case 'shipping_amount':
                    case 'subtotal':
                    case 'subtotal_amount':
                        $value = self::get_formatted_price($value);
                        $escape = FALSE;
                        break;
                }
                if (!is_array($value)) $retval = str_replace("[{$key}]", ($escape ? esc_html($value): $value), $retval);
            };

            // Parse [if_ordered_shippable_items]
            $open_tag   = preg_quote("[if_ordered_shippable_items]", '#');
            $close_tag  = preg_quote("[/if_ordered_shippable_items]", '#');
            $regex      = "#{$open_tag}(.*?){$close_tag}#ms";
            if (preg_match_all($regex, $retval, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $replacement = $order->get_cart()->has_shippable_items() ? $match[1] : '';
                    $retval = str_replace($match[0], $replacement, $retval);
                }
            }

            // Parse [if_ordered_digital_downloads]
            $open_tag   = preg_quote("[if_ordered_digital_downloads]", '#');
            $close_tag  = preg_quote("[/if_ordered_digital_downloads]", '#');
            $regex      = "#{$open_tag}(.*?){$close_tag}#ms";
            $show_downloads = FALSE;
            if ($order->get_cart()->has_digital_downloads() && $order->status == 'verified')
                $show_downloads = TRUE;
            if (preg_match_all($regex, $retval, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $replacement = $show_downloads ? $match[1] : '';
                    $retval = str_replace($match[0], $replacement, $retval);
                }
            }

            // Render cart
            if (strpos($retval, '[items]') !== FALSE) {
                $retval = str_replace(
                    '[items]',
                    C_NextGen_Pro_Order_Controller::get_instance()->render($order->get_cart()),
                    $retval
                );
            }

            $retval = apply_filters('ngg_order_details', $retval, $order);

            // Unset any variables on the order we may have set
            foreach ($other_values as $key => $value) unset($order->$key);
        }

        return $retval;
    }

    static function get_formatted_price($value, $country=FALSE, $use_fontawesome=TRUE)
    {
        return sprintf(self::get_price_format_string($country, $use_fontawesome), $value);
    }

    static function get_price_format_string($currency = FALSE, $use_fontawesome=TRUE)
    {
        $settings = C_NextGen_Settings::get_instance();

        if (empty($currency))
            $currency = $settings->ecommerce_currency;

        $currency = C_NextGen_Pro_Currencies::$currencies[$currency];

        if (!empty($currency['fontawesome']) AND $use_fontawesome)
        {
            $symbol = $currency['fontawesome'];
            $symbol = "<i class='fa {$symbol}'></i>";
        }
        else {
            // decode so we don't send &#8364;2.01 when we want €2.01 and we send mail as text (not html)
            $symbol = html_entity_decode($currency['symbol']);
        }

        $retval = "%.{$currency['exponent']}f";


	    $locale = localeconv();
	    if (defined('WPLANG')) {
		    $original_locale = setlocale(LC_MONETARY, '0');
		    setlocale(LC_MONETARY, WPLANG);
		    $locale = localeconv();
		    setlocale(LC_MONETARY, $original_locale);
	    }

        $space = '';
//        if ($locale['p_sep_by_space'])
//            $space = ' ';

        if (array_key_exists('p_cs_precedes', $locale) && $locale['p_cs_precedes'])
            $retval = $symbol . $space . $retval;
        else
            $retval = $retval . $space . $symbol;


        return $retval;
    }

    static function enqueue_cart_resources()
    {
        $router = C_Router::get_instance();
        if (!wp_script_is('sprintf')) {
            wp_register_script('sprintf', $router->get_static_url('photocrati-nextgen_pro_ecommerce#sprintf.js'));
        }
        wp_register_script('ngg_pro_cart', $router->get_static_url('photocrati-nextgen_pro_ecommerce#cart.js'), array('photocrati_ajax', 'backbone', 'sprintf'));

        wp_enqueue_script('ngg_pro_cart');
        wp_localize_script('ngg_pro_cart', 'Ngg_Pro_Cart_Settings', array(
            'currency_format'    =>   M_NextGen_Pro_Ecommerce::get_price_format_string(),
            'checkout_url'       =>   M_NextGen_Pro_Ecommerce::get_checkout_page_url()
        ));
    }

	function enqueue_backend_resources()
	{
		$router = C_Router::get_instance();

		// When the Other Options page is opened, we're going to use JS to change the label
		// of the "Change options" capatibility in the Roles tab
		if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'ngg_other_options') {
			wp_enqueue_script('ngg_ecommerce_roles', $router->get_static_url('photocrati-nextgen_pro_ecommerce#roles.js'));
			wp_localize_script('ngg_ecommerce_roles', 'ngg_change_options_note', __('(includes Ecommerce Options)', 'nextgen-gallery-pro'));
		}
	}

    function enqueue_resources()
    {
        $router = null;

        if (!wp_script_is('sprintf')) {
            $router = $router ? $router : C_Router::get_instance();
            wp_register_script('sprintf', $router->get_static_url('photocrati-nextgen_pro_ecommerce#sprintf.js'));
        }

        // When the ngg_order_complete parameter is present in the querystring, then
        // we'll enqueue ngg_order_complete and then use the_posts filter to append a <script> tag
        // to the post content, which will delete the cart
        if (isset($_REQUEST['ngg_order_complete'])) {
            wp_enqueue_script('photocrati_ajax');
        }

        // When the pro lightbox is selected as the desired lightbox effect, we will
        // enqueue some JS to extend the Pro Lightbox with the add to cart functionality
        $settings = C_NextGen_Settings::get_instance();
        if (is_null($settings->thumbEffectContext)) $settings->thumbEffectContext = '';
        if ($settings->thumbEffect == 'NGG_PRO_LIGHTBOX' && $settings->thumbEffectContext != 'nextgen_images') {
            $router = $router ? $router : C_Router::get_instance();
            wp_enqueue_script('ngg_nplmodal_ecommerce', $router->get_static_url('photocrati-nextgen_pro_ecommerce#nplmodal_overrides.js'));
        }
    }

    function register_post_types()
    {
        register_post_type('ngg_pricelist', array(
            'show_ui'               =>  TRUE,
            'labels'                =>  array(
                'name'              =>  __('Pricelists', 'nextgen-gallery-pro'),
                'singular_name'     =>  __('Pricelist', 'nextgen-gallery-pro'),
                'menu_name'         =>  __('Pricelist', 'nextgen-gallery-pro'),
                'add_new_item'      =>  __('Add New Pricelist', 'nextgen-gallery-pro'),
                'edit_item'         =>  __('Edit Pricelist', 'nextgen-gallery-pro'),
                'new_item'          =>  __('New Pricelist', 'nextgen-gallery-pro'),
                'view_item'         =>  __('View Pricelist', 'nextgen-gallery-pro'),
                'search_items'      =>  __('Search Pricelists', 'nextgen-gallery-pro'),
                'not_found'         =>  __('No pricelists found', 'nextgen-gallery-pro'),
            ),
            'publicly_queryable'    =>  FALSE,
            'exclude_from_search'   =>  TRUE,
            'supports'              =>  array('title'),
            'show_in_menu'          =>  FALSE
        ));

        register_post_type('ngg_pricelist_item', array(
            'label'                 =>  __('Pricelist Item', 'nextgen-gallery-pro'),
            'publicly_queryable'    =>  FALSE,
            'exclude_from_search'   =>  TRUE
        ));

        register_post_type('ngg_order', array(
            'show_ui'               =>  TRUE,
            'labels'                =>  array(
                'name'              =>  __('Orders', 'nextgen-gallery-pro'),
                'singular_name'     =>  __('Order', 'nextgen-gallery-pro'),
                'menu_name'         =>  __('Orders', 'nextgen-gallery-pro'),
                'add_new_item'      =>  __('Add New Order', 'nextgen-gallery-pro'),
                'edit_item'         =>  __('View Order', 'nextgen-gallery-pro'),
                'new_item'          =>  __('New Order', 'nextgen-gallery-pro'),
                'view_item'         =>  __('View Order', 'nextgen-gallery-pro'),
                'search_items'      =>  __('Search Orders', 'nextgen-gallery-pro'),
                'not_found'         =>  __('No orders found', 'nextgen-gallery-pro'),
            ),
            'publicly_queryable'    =>  FALSE,
            'exclude_from_search'   =>  TRUE,
            'show_in_menu'          =>  FALSE,
            'map_meta_cap'          =>  TRUE,
            'capabilities'          =>  array(
                'create_posts'      =>  FALSE,
                'edit_post'         =>  'edit_post',
                'edit_posts'        =>  'edit_posts'
            )
        ));
    }

    /**
     * Provides new settings to every display type
     */
    function register_display_type_settings()
    {
        foreach (C_Display_type_Mapper::get_instance()->find_all() as $display_type) {
            $this->get_registry()->add_adapter('I_Form', 'A_Display_Type_Ecommerce_Form', $display_type->name);
        }
    }

    function get_checkout_page_url($scheme=NULL)
    {
        $retval = site_url('/?ngg_pro_checkout_page=1', $scheme);
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->ecommerce_page_checkout) {
            $retval = get_page_link($settings->ecommerce_page_checkout);
        }
        return $retval;
    }

    function get_digital_downloads_url($order_hash)
    {
        $retval = site_url('?ngg_pro_digital_downloads_page=1');
        $settings = C_NextGen_Settings::get_instance();
        if ($settings->ecommerce_page_digital_downloads) {
            $retval = get_page_link($settings->ecommerce_page_digital_downloads);
        }

        $retval = add_query_arg('order', $order_hash, $retval);

        return $retval;
    }


    /**
     * We want to display our form for adding pricelists on the same page that lists all pricelists. We choose
     * to do that when the 'ngg_edit' parameter is present in the querystring. Because WordPress exposes no hooks
     * to override the contents of the page, we use what hooks are available to start a buffer, flush the
     * original contents, and then output our own contents
     *
     * We start the buffer using the admin_all_notices hook
     */
    function buffer_for_manage_pricelist_page()
    {
        ob_start();
    }

    /**
     * See the inline doc for buffer_for_manage_pricelist_page() for more details. This method is used
     * to flush the buffer and output our own content for the Manage Pricelists page
     */
    function render_manage_pricelist_page()
    {
        // WP uses a parameter called 'action', so we have to temporary call it 'ngg_action'
        if (isset($_REQUEST['ngg_action'])) $_POST['action'] = $_REQUEST['action'] = $_REQUEST['ngg_action'];

        ob_end_clean();

        $page       = C_Pricelist_Source_Page::get_instance();
        $page->index_action();

        echo '<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div><!-- wpbody -->
<div class="clear"></div></div><!-- wpcontent -->

<div id="wpfooter">';
    }

    function redirect_to_manage_pricelist_page()
    {
        if (strpos($_SERVER['SCRIPT_NAME'], '/wp-admin/post-new.php') !== FALSE && isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'ngg_pricelist') {
            wp_redirect(admin_url('/edit.php?post_type=ngg_pricelist&ngg_edit=1'));
        }
    }

    function custom_edit_link($url)
    {
        global $post;

        // we can't always assume $post exists
        if (empty($post))
            return $url;

        if ($post->post_type == 'ngg_pricelist') {
            $url = admin_url('/edit.php?post_type=ngg_pricelist&ngg_edit=1&id='.$post->ID);
        }
        elseif ($post->post_type == 'ngg_order') {
            $mapper = C_Order_Mapper::get_instance();
            if (($order = $mapper->find($post->ID))) {
                $checkout = C_NextGen_Pro_Checkout::get_instance();
                $url = $checkout->get_thank_you_page_url($order->hash);
            }
        }

        return $url;
    }

    /**
     * Adds a pricelist field for galleries
     * @param $fields
     * @param $gallery
     * @return mixed
     */
    function add_gallery_pricelist_field($fields, $gallery)
    {
        $fields['right']['pricelist'] = array(
            'label'         =>  __('Pricelist', 'nextgen-gallery-pro'),
            'id'            =>  'gallery_pricelist',
            'callback'      =>  array(&$this, 'render_gallery_pricelist_field')
        );
        return $fields;
    }

    /**
     * Adds another column on the Manage Galleries (edit mode) page
     * @param $columns
     * @return mixed
     */
    function add_ecommerce_column($columns)
    {
        $columns += 1;

        add_filter(
            "ngg_manage_images_column_{$columns}_header",
            array(&$this, 'render_ecommerce_column_header'),
            20,
            2
        );

        add_filter(
            "ngg_manage_images_column_{$columns}_content",
            array(&$this, 'render_ecommerce_column'),
            20,
            2
        );

        return $columns;
    }

    function render_ecommerce_column_header()
    {
        return __('Ecommerce', 'nextgen-gallery-pro');
    }

    function render_ecommerce_column($output, $picture)
    {
        $image_id               = $picture->{$picture->id_field};
        $mapper                 = C_Pricelist_Mapper::get_instance();
        $gallery_default_label  = esc_html__("Use gallery's pricelist", 'nextgen-gallery-pro');
        $selected_pricelist_id  = isset($picture->pricelist_id) ? $picture->pricelist_id : 0;
        $selected               = selected($selected_pricelist_id, 0, FALSE);
        $none_selected          = selected($selected_pricelist_id, -1, FALSE);
        $no_pricelist_label     = esc_html__("None (not for sale)", 'nextgen-gallery-pro');

        $out = array();
        $out[] = "<select id='image_{$image_id}_pricelist' name='images[{$image_id}][pricelist_id]'>";
        $out[] = "<option {$selected} value='0'>{$gallery_default_label}</option>";
        $out[] = "<option {$none_selected} value='-1'>{$no_pricelist_label}</option>";

        foreach ($mapper->find_all() as $pricelist) {
            $pricelist_id       = esc_attr($pricelist->{$pricelist->id_field});
            $pricelist_title    = esc_html($pricelist->title);
            $selected           = selected($selected_pricelist_id, $pricelist_id, FALSE);
            $out[] = "<option {$selected} value='{$pricelist_id}'>{$pricelist_title}</option>";
        }

        $out[] = "</select>";

        return $output.implode("\n", $out);
    }

    /**
     * Renders the gallery pricelist field
     */
    function render_gallery_pricelist_field($gallery)
    {
        $mapper = C_Pricelist_Mapper::get_instance();
        $selected_pricelist_id = 0;
        if (($selected_pricelist = $mapper->find_for_gallery($gallery))) {
            $selected_pricelist_id = $selected_pricelist->{$selected_pricelist->id_field};
        }

        echo "<select name='pricelist_id' id='gallery_pricelist'>";
        $selected = selected($selected_pricelist_id, 0, FALSE);
        echo "<option value='0' {$selected}>" . __('None', 'nextgen-gallery-pro') . "</option>";

        foreach ($mapper->find_all() as $pricelist) {
            $pricelist_id       = $pricelist->{$pricelist->id_field};
            $pricelist_title    = esc_html($pricelist->title);
            $selected           = selected($selected_pricelist_id, $pricelist_id, FALSE);
            echo "<option {$selected} value='{$pricelist_id}'>{$pricelist_title}</option>";
        }

        echo "</select>";
    }

    function get_type_list()
    {
        return array(
            'C_NextGen_Pro_Add_To_Cart'             =>  'class.nextgen_pro_add_to_cart.php',
            'A_Ecommerce_Pages'                     =>  'adapter.ecommerce_pages.php',
            'C_Digital_Downloads'                   =>  'class.digital_downloads.php',
            'A_Ecommerce_Gallery'                   =>  'adapter.ecommerce_gallery.php',
            'A_Ecommerce_Image'                     =>  'adapter.ecommerce_image.php',
            'C_Pricelist_Mapper'                    =>  'class.pricelist_mapper.php',
            'C_Pricelist_Item_Mapper'               =>  'class.pricelist_item_mapper.php',
            'C_Pricelist'                           =>  'class.pricelist.php',
            'C_Pricelist_Item'                      =>  'class.pricelist_item.php',
            'C_Pricelist_Source_Page'               =>  'class.pricelist_source_page.php',
            'C_Order_Mapper'                        =>  'class.order_mapper.php',
            'C_NextGen_Pro_Order'                   =>  'class.nextgen_pro_order.php',
            'C_NextGen_Pro_Checkout'                =>  'class.nextgen_pro_checkout.php',
            'A_Manual_Pricelist_Form'               =>  'adapter.manual_pricelist_form.php',
            'A_Digital_Downloads_Form'              =>  'adapter.digital_downloads_form.php',
            'A_Payment_Gateway_Form'                =>  'adapter.payment_gateway_form.php',
            'A_Ecommerce_Options_Controller'        =>  'adapter.ecommerce_options_controller.php',
            'A_NextGen_Pro_Lightbox_Mail_Form'      =>  'adapter.nextgen_pro_lightbox_mail_form.php',
            'A_Ecommerce_Ajax'                      =>  'adapter.ecommerce_ajax.php',
            'C_NextGen_Pro_Ecommerce_Trigger'       =>  'class.nextgen_pro_ecommerce_trigger.php',
            'C_Nextgen_Mail_Manager'                => 'class.nextgen_mail_manager.php',
            'A_Ecommerce_Options_Form'              =>  'adapter.ecommerce_options_form.php',
            'A_Display_Type_Ecommerce_Form'         =>  'adapter.display_type_ecommerce_form.php',
            'C_NextGen_Pro_Currencies'              => 'class.nextgen_pro_currencies.php',
            'C_NextGen_Pro_Order_Controller'        =>  'class.nextgen_pro_order_controller.php',
            'C_Pricelist_Source_Manager'            =>  'class.pricelist_source_manager.php',
            'C_NextGen_Pro_Cart'                    =>  'class.nextgen_pro_cart.php',
            'A_Ecommerce_Instructions_Form'         =>  'adapter.ecommerce_instructions_form.php',
            'C_NextGen_Pro_Order_Verification'      =>  'class.nextgen_pro_order_verification.php',
            'A_Reset_Ecommerce_Settings_Form'       =>  'adapter.reset_ecommerce_settings_form.php',
            'A_NplModal_Ecommerce_Overrides'        =>  'adapter.nplmodal_ecommerce_overrides.php',
            'A_Ecommerce_Factory'                   =>  'adapter.ecommerce_factory.php',
            'A_Ecommerce_Instructions_Controller'   =>  'adapter.ecommerce_instructions_controller.php',
            'A_Ecommerce_Pro_Lightbox_Form'         =>  'adapter.ecommerce_pro_lightbox_form.php',
            'C_Ecommerce_Pro_Lightbox_Installer'    =>  'class.ecommerce_pro_lightbox_installer.php'
        );
    }
}

class C_NextGen_Pro_Ecommerce_Installer
{
    function install()
    {
        $settings = C_NextGen_Settings::get_instance();
        $this->install_ecommerce_settings($settings);
    }

    function install_ecommerce_settings($settings)
    {
        $settings->set_default_value('ecommerce_currency', 840); // 'USD'
        $settings->set_default_value('ecommerce_home_country', 840); // 'United States'
        $settings->set_default_value('ecommerce_page_checkout', '');
        $settings->set_default_value('ecommerce_page_thanks', '');
        $settings->set_default_value('ecommerce_page_cancel', '');
        $settings->set_default_value('ecommerce_page_digital_downloads', '');
        $settings->set_default_value('ecommerce_enable_email_notification', TRUE);
        $settings->set_default_value('ecommerce_email_notification_subject', __('New Purchase!', 'nextgen-gallery-pro'));
        $settings->set_default_value('ecommerce_email_notification_recipient', get_bloginfo('admin_email'));
        $settings->set_default_value('ecommerce_enable_email_receipt', TRUE);
        $settings->set_default_value('ecommerce_email_receipt_subject', __("Thank you for your purchase!", 'nextgen-gallery-pro'));
        $settings->set_default_value('ecommerce_email_receipt_body', __("Thank you for your order, %%customer_name%%.\n\nYou ordered %%item_count%% items, and have been billed a total of %%total_amount%%.\n\nTo review your order, please go to %%order_details_page%%.\n\nThanks for shopping at %%site_url%%!", 'nextgen-gallery-pro'));
        $settings->set_default_value('ecommerce_email_notification_body', __("You received a payment of %%total_amount%% from %%customer_name%%. For more details, visit: %%order_details_page%%\n\n%%gateway_admin_note%%\n\nHere is a comma separated list of the image file names. You can copy and\npaste this in your favorite image management software to quickly search for\nand find all selected images.\n\nFiles: %%file_list%%", 'nextgen-gallery-pro'));
        $settings->set_default_value('ecommerce_not_for_sale_msg', __("Sorry, this image is not currently for sale.", 'nextgen-gallery-pro'));

        $ngg_pro_lightbox = $settings->get('ngg_pro_lightbox');
        if (empty($ngg_pro_lightbox['display_cart']))
        {
            $ngg_pro_lightbox['display_cart'] = 0;
            $settings->set('ngg_pro_lightbox', $ngg_pro_lightbox);
        }
    }
}

new M_NextGen_Pro_Ecommerce;
