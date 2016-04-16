<?php
/**
{
	Module: photocrati-paypal_express_checkout
}
**/
class M_PayPal_Express_Checkout extends C_Base_Module
{
	function define()
	{
		parent::define(
			'photocrati-paypal_express_checkout',
			'PayPal Express Checkout',
			'Provides integration with PayPal Express Checkout',
			'0.8',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com'
		);

        C_Photocrati_Installer::add_handler($this->module_id, 'C_Paypal_Express_Checkout_Installer');
	}

	function _register_adapters()
	{
        if (!is_admin())
        {
            $this->get_registry()->add_adapter('I_NextGen_Pro_Checkout', 'A_PayPal_Express_Checkout_Button');
            $this->get_registry()->add_adapter('I_Ajax_Controller',      'A_PayPal_Express_Checkout_Ajax');
        }

	}

	function _register_hooks()
	{
		add_action('init', array(&$this, 'process_paypal_responses'));
		add_action('http_api_curl', array(&$this, 'disable_sslv3'), PHP_INT_MAX - 1, 3);
	}

	/**
	 * Due to Poodle vulnerability, we need to disable SSLv3
	 * @param $handle
	 * @param $r
	 * @param $url
	 */
	function disable_sslv3($handle, $r, $url)
	{
		if (strpos($url, 'paypal') !== FALSE)
        {
			$value = defined('CURL_SSLVERSION_TLSv1') ? CURL_SSLVERSION_TLSv1 : 1;
			$value = defined('CURL_SSLVERSION_TLSv1_0') ? CURL_SSLVERSION_TLSv1_0 : $value;
			curl_setopt($handle, CURLOPT_SSLVERSION, $value);
		}
	}

	function process_paypal_responses()
	{
        // Process return from PayPal
		if (isset($_REQUEST['ngg_ppxc_rtn']))
        {
            $checkout = C_NextGen_Pro_Checkout::get_instance();
            if (($order_hash = $checkout->create_paypal_express_order()))
                $checkout->redirect_to_thank_you_page($order_hash);
		}
        // Process cancelled PayPal order
		elseif (isset($_REQUEST['ngg_ppxc_ccl'])) {
            $checkout = C_NextGen_Pro_Checkout::get_instance();
            $checkout->redirect_to_cancel_page();
		}
	}

	function get_type_list()
	{
        return array(
            'A_PayPal_Express_Checkout_Button' => 'adapter.paypal_express_checkout_button.php',
            'A_PayPal_Express_Checkout_Ajax'   => 'adapter.paypal_express_checkout_ajax.php'
        );
	}
}

class C_Paypal_Express_Checkout_Installer
{
    function install()
    {
        $settings = C_NextGen_Settings::get_instance();
        $settings->set_default_value('ecommerce_paypal_enable', '0');
        $settings->set_default_value('ecommerce_paypal_sandbox', 1);
        $settings->set_default_value('ecommerce_paypal_email', '');
        $settings->set_default_value('ecommerce_paypal_username', '');
        $settings->set_default_value('ecommerce_paypal_password', '');
        $settings->set_default_value('ecommerce_paypal_signature', '');
    }
}

new M_PayPal_Express_Checkout;
