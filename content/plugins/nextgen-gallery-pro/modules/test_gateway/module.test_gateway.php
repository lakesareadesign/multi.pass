<?php
/**
{
    Module: photocrati-test_gateway
}
 **/
class M_Photocrati_Test_Gateway extends C_Base_Module
{
    function define()
    {
        parent::define(
            'photocrati-test_gateway',
            'Test gateway',
            'Provides a dummy payment gateway',
            '0.7',
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com'
        );

        C_Photocrati_Installer::add_handler($this->module_id, 'C_Test_Gateway_Installer');
    }

    function _register_adapters()
    {
        if (!is_admin())
        {
            $this->get_registry()->add_adapter('I_NextGen_Pro_Checkout', 'A_Test_Gateway_Checkout_Button');
            $this->get_registry()->add_adapter('I_Ajax_Controller',      'A_Test_Gateway_Checkout_Ajax');
        }

    }

    function get_type_list()
    {
        return array(
            'A_Test_Gateway_Checkout_Button' => 'adapter.test_gateway_checkout_button.php',
            'A_Test_Gateway_Checkout_Ajax'   => 'adapter.test_gateway_checkout_ajax.php'
        );
    }
}

class C_Test_Gateway_Installer
{
    function install()
    {
        $settings = C_NextGen_Settings::get_instance();
        $settings->set_default_value('ecommerce_test_gateway_enable', '0');
    }
}

new M_Photocrati_Test_Gateway;
