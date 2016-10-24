<?php
/* START_REGION_OUTPUT */
$footer = upfront_create_region(
			array (
  'name' => 'footer',
  'title' => 'Footer',
  'type' => 'clip',
  'scope' => 'global',
  'container' => 'footer',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 8,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 4,
       'background_type' => 'color',
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc0',
)
			);

$footer->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471836713622-1328 upfront-module-spacer',
  'id' => 'module-1471836713622-1328',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471836713621-1636',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471836713619-1302',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$footer->add_element("PlainTxt", array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470499667631-1120',
  'id' => 'module-1470499667631-1120',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6 style="text-align: justify;"><span class="upfront_theme_color_6" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_6">2016 © INCSUB</span></h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1470499667631-1877',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '18',
    'bottom_padding_num' => '18',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 6,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'default',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 6,
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 5,
      )),
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'default',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'textbox-default-center',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470500096817-1623',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'edited' => true,
      'left' => 0,
      'top' => 0,
      'row' => 6,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
      'edited' => true,
      'row' => 5,
      'hide' => 1,
    ),
  ),
));

$footer->add_element("Unewnavigation", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470520456440-1347',
  'id' => 'module-1470520456440-1347',
  'options' =>
  array (
    'type' => 'UnewnavigationModel',
    'view_class' => 'UnewnavigationView',
    'class' => 'c24 upfront-navigation',
    'has_settings' => 1,
    'id_slug' => 'unewnavigation',
    'menu_items' =>
    array (
      0 =>
      (array)(array(
         'menu-item-db-id' => 628,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'ADVERTISE',
         'menu-item-url' => '{{upfront:home_url}}/advertise/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '628',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/advertise/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 629,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'TERMS OF USE',
         'menu-item-url' => '{{upfront:home_url}}/terms-of-use/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '629',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/terms-of-use/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'navigation-footer',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'element_id' => 'unewnavigation-object-1470520456440-1201',
    'padding_slider' => '15',
    'top_padding_num' => '9',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'menu_id' => false,
    'menu_slug' => 'footer-menu',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'navigation-footer',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'navigation-footer',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'navigation-footer',
      )),
    )),
    'row' => 7,
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'right_padding_num' => '15',
         'right_padding_use' => 'yes',
         'top_padding_num' => '10',
         'top_padding_use' => 'yes',
         'left_padding_num' => '15',
         'left_padding_use' => 'yes',
         'bottom_padding_num' => '12',
         'bottom_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'row' => 4,
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'right_padding_num' => '5',
         'right_padding_use' => 'yes',
         'top_padding_num' => '5',
         'top_padding_use' => 'yes',
         'bottom_padding_num' => '10',
         'bottom_padding_use' => 'yes',
         'left_padding_num' => '5',
         'left_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'top_padding_slider' => '5',
      )),
    )),
    'top_padding_slider' => '10',
    'breakpoint_menu_id' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'menu_id' => 95,
         'menu_slug' => 'footer-menu',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470521271113-1883',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 2,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 2,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'left' => 0,
      'top' => 0,
      'edited' => true,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
      'edited' => true,
      'hide' => 0,
    ),
  ),
));

$footer->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471836756508-1618 upfront-module-spacer',
  'id' => 'module-1471836756508-1618',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471836756508-1496',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471836756507-1480',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$regions->add($footer);

/* END_REGION_OUTPUT */