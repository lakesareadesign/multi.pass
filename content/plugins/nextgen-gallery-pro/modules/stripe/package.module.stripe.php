<?php
class A_Stripe_Checkout_Ajax extends Mixin
{
    public function stripe_checkout_action()
    {
        $checkout = C_NextGen_Pro_Checkout::get_instance();
        return $checkout->create_stripe_charge();
    }
}
class A_Stripe_Checkout_Button extends Mixin
{
    public function get_checkout_buttons()
    {
        $buttons = parent::call_parent('get_checkout_buttons');
        if ($this->is_stripe_enabled()) {
            $buttons[] = 'stripe_checkout';
        }
        return $buttons;
    }
    public function is_stripe_enabled()
    {
        return C_NextGen_Settings::get_instance()->ecommerce_stripe_enable;
    }
    public function get_i18n_strings()
    {
        $i18n = new stdClass();
        $i18n->pay_with_card = __('Pay with Card', 'nextgen-gallery-pro');
        return $i18n;
    }
    public function get_stripe_vars($include_private_key = FALSE)
    {
        $settings = C_NextGen_Settings::get_instance();
        $retval = array('site_name' => get_bloginfo('name'), 'key' => $settings->ecommerce_stripe_key_public, 'currency' => C_NextGen_Pro_Currencies::$currencies[$settings->ecommerce_currency]['code'], 'shippingAddress' => TRUE);
        if ($include_private_key) {
            $retval['private_key'] = $settings->ecommerce_stripe_key_private;
        }
        return $retval;
    }
    public function enqueue_stripe_checkout_resources()
    {
        wp_enqueue_script('stripe-checkout', 'https://checkout.stripe.com/checkout.js');
        wp_enqueue_style('stripe-checkout', 'https://checkout.stripe.com/v3/checkout/button.css');
    }
    public function _render_stripe_checkout_button()
    {
        return $this->render_partial('photocrati-stripe#button', array('i18n' => $this->get_i18n_strings(), 'stripe_vars' => json_encode($this->object->get_stripe_vars())), TRUE);
    }
    public function create_stripe_charge()
    {
        $retval = array();
        $total = 0.0;
        // Include the SDK if another plugin hasn't already done so
        if (!class_exists('Stripe')) {
            include_once 'stripe-sdk/lib/Stripe.php';
        }
        // Get Stripe input params
        if (($stripe = $this->param('stripe')) && isset($stripe['token']) && $this->param('items')) {
            $stripe = array_merge($stripe, $this->get_stripe_vars(TRUE));
            // Set Stripe API key
            Stripe::setApiKey($stripe['private_key']);
            // Ensure we have sufficient data returned from Stripe Checkout
            $req_fields = array('customer_name', 'email', 'shipping_street_address', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country');
            $missing_fields = array();
            foreach ($req_fields as $field) {
                if (!isset($stripe[$field])) {
                    $missing_fields[] = $field;
                }
            }
            if ($missing_fields) {
                $retval['error'] = __('Invalid request', 'nextgen-gallery-pro');
            } else {
                $image_mapper = C_Image_Mapper::get_instance();
                $item_mapper = C_Pricelist_Item_Mapper::get_instance();
                $cart = new C_NextGen_Pro_Cart();
                $use_home_country = $this->object->param('ship_to');
                // Calculate the order total
                foreach ($this->param('items') as $image_id => $items) {
                    if ($image = $image_mapper->find($image_id)) {
                        $cart->add_image($image_id, $image);
                        foreach ($items as $item_id => $quantity) {
                            if ($item = $item_mapper->find($item_id)) {
                                $item->quantity = $quantity;
                                $cart->add_item($image_id, $item_id, $item);
                            }
                        }
                    }
                }
                $subtotal = $cart->get_subtotal();
                $shipping = $cart->get_shipping($use_home_country);
                $total = $cart->get_total($use_home_country);
                // Create order
                $order = $this->create_order($cart->to_array(), $stripe['customer_name'], $stripe['email'], $total, 'stripe_checkout', $stripe['shipping_street_address'], $stripe['shipping_city'], $stripe['shipping_state'], $stripe['shipping_zip'], $stripe['shipping_country'], $use_home_country);
                $order->gateway_admin_note = __('Payment was successfully made via Stripe, with no further payment action required.', 'nextgen-gallery-pro');
                $order->save();
                try {
                    $charge_params = array('amount' => round($total, 2) * 100, 'currency' => $stripe['currency'], 'card' => $stripe['token'], 'metadata' => array('order_id' => $order->ID(), 'description' => sprintf(__('Order from %s for %s (%s)', 'nextgen-gallery-pro'), $stripe['site_name'], $stripe['customer_name'], $stripe['email'])));
                    $charge = Stripe_Charge::create($charge_params);
                    $order->stripe_data = get_object_vars($charge);
                    if ($order->save()) {
                        $retval['redirect'] = site_url('/?ngg_stripe_rtn=1&order=' . $order->hash);
                    }
                } catch (Stripe_Error $ex) {
                    $retval['request'] = $charge_params;
                    $retval['error'] = $ex->getMessage();
                    $order->destroy();
                }
            }
        } else {
            $retval['error'] = __('Invalid request', 'nextgen-gallery-pro');
        }
        return $retval;
    }
}