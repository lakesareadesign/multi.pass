<?php
/* START_REGION_OUTPUT */
$main_header = upfront_create_region(
			array (
  'name' => 'main-header',
  'title' => 'Main Header',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'main-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 7,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 12,
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
  'background_color' => '#ufc1',
  'version' => '1.0.0',
)
			);

$main_header->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867942-25331 upfront-module-spacer',
  'id' => 'module-1450867942-25331',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867942-2090',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867942-59970',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
));

$main_header->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426701313231-1079',
  'id' => 'module-1426701313231-1079',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class=""><a href="{{upfront:home_url}}">PANiNO</a></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1426701313231-1709',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => 'logoAnchor',
    'theme_style' => '',
    'row' => 11,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => '',
         'row' => 9,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-brand-menu-m',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-brand-menu-m',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'brand-menu-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'brand-menu-mobile',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426701469176-1639',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 9,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$main_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867942-94303 upfront-module-spacer',
  'id' => 'module-1450867942-94303',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867942-47598',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867942-91011',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
));

$main_header->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867942-25626 upfront-module-spacer',
  'id' => 'module-1450867942-25626',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867942-89068',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867942-56542',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 1,
      'edited' => true,
      'col' => 6,
    ),
    'mobile' =>
    array (
      'col' => 6,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 6,
      'edited' => true,
    ),
  ),
));

$main_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867942-2018 upfront-module-spacer',
  'id' => 'module-1450867942-2018',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867942-75664',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867942-43433',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 1,
      'edited' => true,
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 1,
      'edited' => true,
    ),
  ),
));

$main_header->add_element("Unewnavigation", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426701313249-1591',
  'id' => 'module-1426701313249-1591',
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
         'menu-item-db-id' => 4106,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Our Story',
         'menu-item-url' => '{{upfront:home_url}}/our-story/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4106',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/our-story/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 4107,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Menu',
         'menu-item-url' => '{{upfront:home_url}}/our-menu/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4107',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/our-menu/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 4108,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4108',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 4109,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Gallery',
         'menu-item-url' => '{{upfront:home_url}}/our-gallery/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4109',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/our-gallery/',
           'target' => '',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 4110,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Find Us',
         'menu-item-url' => '{{upfront:home_url}}/our-location/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4110',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/our-location/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'main-nav-reversed',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'horizontal',
    'menu_alignment' => 'center',
    'element_id' => 'unewnavigation-object-1426701313248-1620',
    'initialized' => false,
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => '',
         'burger_over' => 'pushes',
         'menu_style' => 'horizontal',
         'menu_alignment' => 'center',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
       'mobile' =>
      (array)(array(
         'burger_menu' => 'yes',
         'burger_alignment' => 'right',
         'burger_over' => 'over',
         'menu_style' => 'horizontal',
         'menu_alignment' => 'right',
         'width' => 315,
         'row' => 11,
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
      )),
       'tablet' =>
      (array)(array(
         'theme_style' => '',
         'width' => 570,
         'burger_menu' => 'yes',
         'menu_alignment' => 'right',
         'row' => 7,
         'burger_alignment' => 'right',
         'burger_over' => 'over',
         'menu_style' => 'horizontal',
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'menu_id' => false,
    'menu_slug' => 'panino-main-menu',
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => '',
    'burger_over' => 'pushes',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
    'row' => 9,
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426701461098-1339',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 1,
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'row' => 6,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'row' => 10,
      'top' => 0,
    ),
  ),
));

$main_header->add_element("Uspacer", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867942-75739 upfront-module-spacer',
  'id' => 'module-1450867942-75739',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867942-71208',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867942-39426',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 7,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$regions->add($main_header);

/* END_REGION_OUTPUT */