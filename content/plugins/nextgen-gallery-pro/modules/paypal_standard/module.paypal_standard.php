<?php
/**
{
    Module: photocrati-paypal_standard
}
**/
class M_PayPal_Standard extends C_Base_Module
{
    function define()
    {
        parent::define(
            'photocrati-paypal_standard',
            'PayPal Standard',
            'Provides integration with PayPal Standard',
            '0.8',
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com'
        );

        C_Photocrati_Installer::add_handler($this->module_id, 'C_Paypal_Standard_Installer');
    }

    function _register_adapters()
    {
        if (!is_admin())
        {
            $this->get_registry()->add_adapter('I_Ajax_Controller', 'A_PayPal_Standard_Ajax');
            $this->get_registry()->add_adapter('I_NextGen_Pro_Checkout', 'A_PayPal_Standard_Button');
        }
        if (is_admin())
            $this->get_registry()->add_adapter('I_Form', 'A_PayPal_Standard_Form', NGG_PRO_PAYMENT_PAYMENT_FORM);
    }

    function _register_hooks()
    {
        add_action('init', array(&$this, 'process_paypal_responses'));
	    add_action('http_api_curl', array(&$this, 'disable_sslv3'), PHP_INT_MAX-1, 3);
    }

	/**
	 * Due to Poodle vulnerability, we need to disable SSLv3
	 * @param $handle
	 * @param $r
	 * @param $url
	 */
	function disable_sslv3($handle, $r, $url)
	{
		if (strpos($url, 'paypal') !== FALSE) {
			$value = defined('CURL_SSLVERSION_TLSv1') ? CURL_SSLVERSION_TLSv1 : 1;
			$value = defined('CURL_SSLVERSION_TLSv1_0') ? CURL_SSLVERSION_TLSv1_0 : $value;
			curl_setopt($handle, CURLOPT_SSLVERSION, $value);
		}
	}

    function process_paypal_responses()
    {
        // Process return from PayPal
        if (isset($_REQUEST['ngg_pstd_rtn']))
        {
            C_NextGen_Pro_Checkout::get_instance()->create_paypal_standard_order();
        }
        // Process cancelled PayPal order
        elseif (isset($_REQUEST['ngg_pstd_cnl'])) {
            $checkout = C_NextGen_Pro_Checkout::get_instance();
            $checkout->redirect_to_cancel_page();

        }
        // Process IPN notications
        elseif (isset($_REQUEST['ngg_pstd_nfy'])) {
            $checkout = C_NextGen_Pro_Checkout::get_instance();
            $checkout->paypal_ipn_listener();
        }

    }

    function get_type_list()
    {
        return array(
            'A_PayPal_Standard_Button' => 'adapter.paypal_standard_button.php',
            'A_PayPal_Standard_Form'   => 'adapter.paypal_standard_form.php',
            'A_PayPal_Standard_Ajax'   => 'adapter.paypal_standard_ajax.php'
        );
    }
}

class C_PayPal_Standard_Installer
{
    function install()
    {
        $settings = C_NextGen_Settings::get_instance();
        $settings->set_default_value('ecommerce_paypal_std_enable', 0);
        $settings->set_default_value('ecommerce_paypal_std_sandbox', 1);
        $settings->set_default_value('ecommerce_paypal_std_email', '');
    }
}

new M_PayPal_Standard;
