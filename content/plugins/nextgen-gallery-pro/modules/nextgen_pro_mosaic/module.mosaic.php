<?php

/* { Module: photocrati-nextgen_pro_mosaic } */

define('NGG_PRO_MOSAIC', 'photocrati-nextgen_pro_mosaic');
define('NGG_PRO_MOSAIC_VERSION', '0.9');

class M_NextGen_Pro_Mosaic extends C_Base_Module
{
    function define($context = FALSE)
    {
        parent::define(
            NGG_PRO_MOSAIC,
            'Mosaic Display Type',
            'Provides the Pro Mosaic display type',
            NGG_PRO_MOSAIC_VERSION,
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com',
            $context
        );
    }

    function _register_utilities()
    {
        C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Mosaic_Installer');
    }

    function _register_adapters()
    {
        $this->get_registry()
             ->add_adapter('I_Display_Type_Mapper',
                           'Mixin_Mosaic_Display_Type_Mapper');

        $this->get_registry()
             ->add_adapter('I_Display_Type_Controller',
                           'A_Mosaic_Controller',
                           $this->module_id);

        if (M_Attach_To_Post::is_atp_url() || is_admin())
        {
            $this->get_registry()
                 ->add_adapter('I_Form',
                               'A_Mosaic_Form',
                               $this->module_id);

            $this->get_registry()
                 ->add_adapter('I_Form_Manager',
                               'A_Mosaic_Forms');
        }
    }

    function get_type_list()
    {
        return array(
            'A_Mosaic_Controller'               => 'adapter.mosaic_controller.php',
            'Mixin_Mosaic_Display_Type_Mapper' => 'mixin.mosaic_display_type_mapper.php',
            'A_Mosaic_Form'                    => 'adapter.mosaic_forms.php',
            'A_Mosaic_Forms'                   => 'adapter.mosaic_forms.php'
        );
    }
}

class C_NextGen_Pro_Mosaic_Installer extends C_Gallery_Display_Installer
{
    function install()
    {
        $this->install_display_type(
            NGG_PRO_MOSAIC, array(
                'title'                 => __('NextGen Pro Mosaic', 'nextgen-gallery-pro'),
                'entity_types'          => array('image'),
                'default_source'        => 'galleries',
                'preview_image_relpath' => NGG_PRO_MOSAIC . '#preview.jpg',
                'hidden_from_ui'        => FALSE,
                'view_order'            => NGG_DISPLAY_PRIORITY_BASE + (NGG_DISPLAY_PRIORITY_STEP * 10) + 55
            )
        );
    }

    function uninstall($hard)
    {
        $mapper = C_Display_Type_Mapper::get_instance();
        if (($entity = $mapper->find_by_name(NGG_PRO_MOSAIC)))
        {
            if ($hard)
            {
                $mapper->destroy($entity);
            }
            else {
                $entity->hidden_from_ui = TRUE;
                $mapper->save($entity);
            }
        }
    }
}

$M_NextGen_Pro_Mosaic = new M_NextGen_Pro_Mosaic();
