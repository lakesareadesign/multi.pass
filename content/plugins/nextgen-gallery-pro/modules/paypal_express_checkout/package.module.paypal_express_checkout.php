<?php
class A_PayPal_Express_Checkout_Ajax extends Mixin
{
    public function paypal_express_checkout_action()
    {
        $checkout = C_NextGen_Pro_Checkout::get_instance();
        $response = $checkout->set_express_checkout();
        unset($response['token']);
        // for security reasons
        return $response;
    }
}
class A_PayPal_Express_Checkout_Button extends Mixin
{
    public function get_checkout_buttons()
    {
        $buttons = parent::call_parent('get_checkout_buttons');
        if ($this->is_paypal_express_checkout_enabled()) {
            $buttons[] = 'paypal_express_checkout';
        }
        return $buttons;
    }
    public function is_paypal_express_checkout_enabled()
    {
        return C_NextGen_Settings::get_instance()->ecommerce_paypal_enable;
    }
    public function _render_paypal_express_checkout_button()
    {
        return $this->render_partial('photocrati-paypal_express_checkout#button', array('value' => __('Pay with PayPal', 'nextgen-gallery-pro'), 'processing_msg' => __('Processing...', 'nextgen-gallery-pro')), TRUE);
    }
    public function _paypal_request($method, $data)
    {
        $retval = array();
        $settings = C_NextGen_Settings::get_instance();
        // Determine which url to send the requests to
        $url = 'https://api-3t.paypal.com/nvp';
        if (defined('NGG_PRO_PAYPAL_LIVE_URL')) {
            $url = NGG_PRO_PAYPAL_LIVE_URL;
        }
        if ($settings->ecommerce_paypal_sandbox) {
            if (defined('NGG_PRO_PAYPAL_SANDBOX_URL')) {
                $url = NGG_PRO_PAYPAL_SANDBOX_URL;
            } else {
                $url = 'https://api-3t.sandbox.paypal.com/nvp';
            }
        }
        // Set standard parameters
        $data['METHOD'] = $method;
        $data['USER'] = $settings->ecommerce_paypal_username;
        $data['PWD'] = $settings->ecommerce_paypal_password;
        $data['SIGNATURE'] = $settings->ecommerce_paypal_signature;
        $data['VERSION'] = 109;
        // Encode the data for the request
        $request = array();
        foreach ($data as $key => $value) {
            $value = urlencode($value);
            $request[] = "{$key}={$value}";
        }
        $request = implode('&', $request);
        // Submit request
        $response = wp_remote_post($url, array('httpversion' => '1.1', 'body' => $request));
        // Check the response
        if ($response instanceof WP_Error) {
            $retval['ERROR'] = $response->get_error_message();
        } elseif (isset($response['body'])) {
            foreach (explode('&', urldecode($response['body'])) as $line) {
                $parts = explode('=', $line);
                $key = strtolower(array_shift($parts));
                $value = array_shift($parts);
                $retval[$key] = $value;
            }
        }
        return $retval;
    }
    public function create_paypal_express_order()
    {
        $retval = FALSE;
        if (isset($_REQUEST['token'])) {
            $response = $this->get_express_checkout_details($_REQUEST['token']);
            if (isset($response['email'])) {
                // Create cart
                $images = array('images' => array(), 'image_ids' => array());
                for ($i = 0; isset($response['l_number' . $i]); $i++) {
                    $parts = explode('-', $response['l_number' . $i]);
                    $image_id = array_shift($parts);
                    $item_id = array_shift($parts);
                    $images['image_ids'][] = $image_id;
                    if (!isset($images['images'][$image_id])) {
                        $images['images'][$image_id] = array('items' => array());
                    }
                    if (!isset($images['images'][$image_id]['items'])) {
                        $images['images'][$image_id]['items'] = array();
                    }
                    $images['images'][$image_id]['items'][$item_id] = array('quantity' => intval($response['l_qty' . $i]), 'price' => doubleval($response['l_amt' . $i]));
                }
                // Create order
                $order = $this->create_order($images, $response['firstname'] . ' ' . $response['lastname'], $response['email'], $response['amt'], 'paypal_express_checkout', $response['shiptostreet'], $response['shiptocity'], $response['shiptostate'], $response['shiptozip'], $response['shiptocountryname'], $response['custom']);
                if ($retval = $order->save()) {
                    $payer_id = isset($_REQUEST['payerid']) ? $_REQUEST['payerid'] : $_REQUEST['PayerID'];
                    $response = $this->do_express_checkout_payment($retval, $_REQUEST['token'], $payer_id, $response);
                    if (is_array($response) && isset($response['ack']) && $response['ack'] == 'Success') {
                        if (!isset($order->paypal_data)) {
                            $order->paypal_data = array();
                        }
                        $order->paypal_data = array_merge($order->paypal_data, $response);
                        $order->gateway_admin_note = __('Payment was successfully made via PayPal Express Checkout, with no further payment action required.', 'nextgen-gallery-pro');
                        $order->save();
                        $retval = $order->hash;
                    } else {
                        $order->destroy();
                    }
                }
            }
        }
        return $retval;
    }
    public function do_express_checkout_payment($order_id, $token, $payerid, $set_express_checkout_response)
    {
        $set_express_checkout_response['TOKEN'] = $token;
        $set_express_checkout_response['PAYERID'] = $payerid;
        $set_express_checkout_response['METHOD'] = 'DoExpressCheckoutPayment';
        return $this->_paypal_request('DoExpressCheckoutPayment', $set_express_checkout_response);
    }
    public function get_express_checkout_details($token)
    {
        $response = $this->_paypal_request('GetExpressCheckoutDetails', array('TOKEN' => $token));
        return $response;
    }
    public function _get_paypal_currency_code()
    {
        $settings = C_NextGen_Settings::get_instance();
        return C_NextGen_Pro_Currencies::$currencies[$settings['ecommerce_currency']]['code'];
    }
    public function set_express_checkout()
    {
        $router = C_Router::get_instance();
        $settings = C_NextGen_Settings::get_instance();
        $image_mapper = C_Image_Mapper::get_instance();
        $item_mapper = C_Pricelist_Item_Mapper::get_instance();
        $return_url = site_url('/?ngg_ppxc_rtn=1');
        $cancel_url = site_url('/?ngg_ppxc_ccl=1');
        $notify_url = site_url('/?ngg_ppxc_nfy=1');
        $cart = new C_NextGen_Pro_Cart();
        $currency = C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency];
        // Set up request data
        $data = array('RETURNURL' => $return_url, 'CANCELURL' => $cancel_url, 'CALLBACKTIMEOUT' => 6, 'NOSHIPPING' => 0, 'CALLBACKVERSION' => 61.0, 'PAYMENTREQUEST_0_NOTIFYURL' => $notify_url, 'PAYMENTREQUEST_0_PAYMENTREASON' => 'None', 'PAYMENTREQUEST_0_CURRENCYCODE' => $this->_get_paypal_currency_code(), 'PAYMENTREQUEST_0_CUSTOM' => $this->object->param('ship_to'));
        if ($settings->paypal_page_style) {
            $data['PAGESTYLE'] = $settings->paypal_page_style;
        }
        // Add items
        if ($cart_items = $this->param('items')) {
            $item_number = 0;
            foreach ($cart_items as $image_id => $items) {
                if ($image = $image_mapper->find($image_id)) {
                    $cart->add_image($image_id, $image);
                    foreach ($items as $item_id => $quantity) {
                        if ($item = $item_mapper->find($item_id)) {
                            $item->quantity = $quantity;
                            $cart->add_item($image_id, $item_id, $item);
                            $data['L_PAYMENTREQUEST_0_NAME' . $item_number] = $item->title . ' / ' . $image->alttext;
                            $data['L_PAYMENTREQUEST_0_DESC' . $item_number] = $image->filename;
                            $data['L_PAYMENTREQUEST_0_AMT' . $item_number] = sprintf("%.{$currency['exponent']}f", $item->price);
                            $data['L_PAYMENTREQUEST_0_NUMBER' . $item_number] = "{$image_id}-{$item_id}";
                            $data['L_PAYMENTREQUEST_0_QTY' . $item_number] = intval($quantity);
                            $data['L_PAYMENTREQUEST_0_ITEMCATEGORY' . $item_number] = 'Physical';
                            $item_number += 1;
                        } else {
                            $data['NOT_FOUND' . $item_number] = $item_id;
                        }
                    }
                }
            }
        }
        // Totals, Shipping & Taxes
        $subtotal = $cart->get_subtotal();
        if ($this->param('ship_to') === '1') {
            $local = TRUE;
        } else {
            $local = FALSE;
        }
        $shipping = $cart->get_shipping($local);
        $data['PAYMENTREQUEST_0_SHIPPINGAMT'] = sprintf("%.{$currency['exponent']}f", $shipping);
        $data['PAYMENTREQUEST_0_ITEMAMT'] = sprintf("%.{$currency['exponent']}f", $subtotal);
        $data['PAYMENTREQUEST_0_AMT'] = sprintf("%.{$currency['exponent']}f", bcadd($subtotal, $shipping, $currency['exponent']));
        // Submit the PayPal request
        $response = $this->_paypal_request('SetExpressCheckout', $data);
        if (isset($response['token'])) {
            if ($settings->ecommerce_paypal_sandbox) {
                $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
            } else {
                $url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
            }
            $response['redirect'] = $url . $response['token'];
        }
        if (isset($response['l_longmessage0'])) {
            $response['error'] = $response['l_longmessage0'];
        }
        if (isset($response['ERROR'])) {
            $response['error'] = $response['ERROR'];
            unset($response['ERROR']);
        }
        return $response;
    }
}