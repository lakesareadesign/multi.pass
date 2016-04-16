<?php
/*
 {
    Module: photocrati-nextgen_pro_captions
 }
 */
class M_NextGen_Pro_Captions extends C_Base_Module
{
    function define($context=FALSE)
    {
        parent::define(
            'photocrati-nextgen_pro_captions',
            'NextGEN Pro Captions',
            "Provides image caption effects",
            '0.5',
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com',
            $context
        );
    }

    function _register_hooks()
    {
        add_action('wp_enqueue_scripts', array($this, 'register_captions'), -250);
    }

    function _register_adapters()
    {
        if (M_Attach_To_Post::is_atp_url() || is_admin())
        {
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Captions_Form', NGG_PRO_MASONRY);
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Captions_Form', NGG_PRO_THUMBNAIL_GRID);
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Captions_Form', NGG_PRO_BLOG_GALLERY);
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Captions_Form', NGG_PRO_FILM);
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Captions_Form', NGG_PRO_MOSAIC);
        }

        if (!is_admin())
            $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NextGen_Pro_Captions_Resources');
    }

    function register_captions()
    {
        $router = C_Router::get_instance();
        wp_register_script(
            'jquery.dotdotdot',
            $router->get_static_url('photocrati-nextgen_basic_album#jquery.dotdotdot-1.5.7-packed.js'),
            array('jquery')
        );
        wp_register_script(
            'nextgen_pro_captions-js',
            $router->get_static_url('photocrati-nextgen_pro_captions#captions.js'),
            array('jquery.dotdotdot'),
            FALSE,
            TRUE
        );
        wp_register_style(
            'nextgen_pro_captions-css',
            $router->get_static_url('photocrati-nextgen_pro_captions#captions.css')
        );
    }

    function get_type_list()
    {
        return array(
            'A_NextGen_Pro_Captions_Form'      => 'adapter.nextgen_pro_captions_form.php',
            'A_NextGen_Pro_Captions_Resources' => 'adapter.nextgen_pro_captions_resources.php'
        );
    }
}

new M_NextGen_Pro_Captions;
