<?php
/* START_REGION_OUTPUT */
$footer = upfront_create_region(
			array (
  'name' => 'footer',
  'title' => 'Footer',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'footer',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
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
       'edited' => false,
       'col' => 24,
    )),
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
  'background_color' => 'rgba(250,250,250,1)',
  'version' => '1.0.0',
)
			);

$footer->add_element("Unewnavigation", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453356812349-1925',
  'id' => 'module-1453356812349-1925',
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
         'menu-item-db-id' => 300,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'ADVERTISE',
         'menu-item-url' => '{{upfront:home_url}}/advertise/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '300',
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
         'menu-item-db-id' => 301,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'TERMS OF USE',
         'menu-item-url' => '{{upfront:home_url}}/terms-of-use/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '301',
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
    'preset' => 'footer-menu',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'element_id' => 'unewnavigation-object-1453356812347-1310',
    'top_padding_num' => '20',
    'bottom_padding_num' => '20',
    'usingNewAppearance' => true,
    'menu_slug' => 'footer-menu',
    'menu_id' => false,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'footer-menu',
      )),
    )),
    'row' => 8,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'lock_padding',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '20',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'current_preset' => 'footer-menu',
    'breakpoint_menu_id' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'menu_id' => 28,
         'menu_slug' => 'footer-menu',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453358060831-1340',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$footer->add_element("PlainTxt", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357589878-1163',
  'id' => 'module-1453357589878-1163',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: right;">2014-2016 INCSUB</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453357589875-1821',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '20',
    'bottom_padding_num' => '20',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'preset' => 'copy',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'copy',
      )),
    )),
    'row' => 9,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'use_padding',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '20',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'current_preset' => 'copy',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453358267890-1061',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 1,
      'clear' => false,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$regions->add($footer);

/* END_REGION_OUTPUT */