<?php
/* START_REGION_OUTPUT */
$footer_column = upfront_create_region(
			array (
  'name' => 'footer-column',
  'title' => 'Footer Column',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'footer',
  'sub' => 'left',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => 9,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 52,
       'hide' => 1,
       'background_type' => 'color',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'hide' => 0,
    )),
     'current_property' => 'background_color',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'background_color' => '#ffffff',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$footer_column->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-46563 upfront-module-spacer',
  'id' => 'module-1450121214-46563',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-11954',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-43732',
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

$footer_column->add_group(array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432595341702-1436',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1432816291986-1869',
  'original_col' => 3,
  'top_padding_use' => 'yes',
  'top_padding_num' => '15',
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'lock_padding' => '',
  'top_padding_slider' => '15',
  'row' => 33,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '10',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 0,
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 51,
      'top_padding_use' => true,
      'top_padding_num' => 25,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 15,
      'top_padding_use' => true,
      'top_padding_num' => 15,
      'hide' => 1,
    ),
  ),
));

$footer_column->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429876792130-1994',
  'id' => 'module-1429876792130-1994',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Parrot</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429876792130-1219',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 5,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 8,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'preset' => 'plaintxt-title-footer-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595346518-1121',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
  ),
  'group' => 'module-group-1432595341702-1436',
));

$footer_column->add_element("Unewnavigation", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429876792157-1142',
  'id' => 'module-1429876792157-1142',
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
         'menu-item-db-id' => 948,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '948',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 949,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Features',
         'menu-item-url' => '{{upfront:home_url}}/features/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '949',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/features/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 950,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Download',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '950',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 951,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '951',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'parrot-footer-nav-m',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'element_id' => 'unewnavigation-object-1429876792157-1146',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'menu_alignment' => 'left',
      )),
       'mobile' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'width' => 315,
         'row' => 28,
      )),
       'tablet' =>
      (array)(array(
         'row' => 32,
         'width' => 570,
      )),
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-footer-1',
    'row' => 41,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595346526-1956',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 32,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 28,
    ),
  ),
  'group' => 'module-group-1432595341702-1436',
));

$footer_column->add_group(array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432595366843-1513',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1432816295191-1929',
  'original_col' => 3,
  'top_padding_use' => true,
  'top_padding_num' => 15,
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'row' => 28,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_slider' => '10',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '10',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 3,
      'order' => 1,
      'row' => 37,
      'top' => 0,
      'top_padding_use' => true,
      'top_padding_num' => 25,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 42,
      'top_padding_use' => true,
      'top_padding_num' => 15,
      'hide' => 1,
    ),
  ),
));

$footer_column->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429877858930-1884',
  'id' => 'module-1429877858930-1884',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class=""><strong data-redactor-tag="strong" data-verified="redactor">Download</strong></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1429877858930-1707',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 5,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 9,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'preset' => 'plaintxt-title-footer-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595368253-1334',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 9,
    ),
  ),
  'group' => 'module-group-1432595366843-1513',
));

$footer_column->add_element("Unewnavigation", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429876908442-1481',
  'id' => 'module-1429876908442-1481',
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
         'menu-item-db-id' => 952,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'BlackBerry',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '952',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 953,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'iPhone',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '953',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 954,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Android',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '954',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'parrot-footer-nav-m',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'element_id' => 'object-1429876908442-1220',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
       'mobile' =>
      (array)(array(
         'row' => 22,
         'width' => 315,
      )),
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-footer-2',
    'row' => 41,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595368260-1025',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 22,
    ),
  ),
  'group' => 'module-group-1432595366843-1513',
));

$footer_column->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-4427 upfront-module-spacer',
  'id' => 'module-1450121214-4427',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-51238',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-7079',
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

$regions->add($footer_column);

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$footer = upfront_create_region(
			array (
  'name' => 'footer',
  'title' => 'Footer Area',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'footer',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 2,
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 37,
       'hide' => 1,
    )),
  )),
  'row' => 56,
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ffffff',
  'version' => '1.0.0',
)
			);

$footer->add_group(array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1444613391306-1229',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1444613397575-1019',
  'original_col' => 3,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => true,
  'top_padding_num' => 15,
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'row' => 16,
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$footer->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429877866132-1833',
  'id' => 'module-1429877866132-1833',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class=""><strong data-redactor-tag="strong" data-verified="redactor">Resources</strong></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1429877866132-1580',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 5,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 9,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'preset' => 'plaintxt-title-footer-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1444613391367-1461',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 1,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 9,
    ),
  ),
  'group' => 'module-group-1444613391306-1229',
));

$footer->add_element("Unewnavigation", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429876915357-1962',
  'id' => 'module-1429876915357-1962',
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
         'menu-item-db-id' => 955,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '955',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'parrot-footer-nav-m',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'element_id' => 'object-1429876915357-1530',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
       'tablet' =>
      (array)(array(
         'row' => 30,
         'width' => 570,
      )),
       'mobile' =>
      (array)(array(
         'row' => 28,
         'width' => 315,
      )),
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-footer-3',
    'row' => 41,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1444613391372-1529',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 30,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 28,
    ),
  ),
  'group' => 'module-group-1444613391306-1229',
));

$footer->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-44801 upfront-module-spacer',
  'id' => 'module-1450121214-44801',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-35553',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-26192',
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

$footer->add_group(array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432595381161-1359',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1432816322353-1826',
  'original_col' => 3,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => true,
  'top_padding_num' => 15,
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'row' => 26,
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
      'col' => 6,
      'order' => 1,
      'row' => 10,
      'top' => 0,
      'top_padding_use' => true,
      'top_padding_num' => 5,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 39,
      'top_padding_use' => true,
      'top_padding_num' => 5,
    ),
  ),
));

$footer->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429877873720-1147',
  'id' => 'module-1429877873720-1147',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class=""><strong data-redactor-tag="strong" data-verified="redactor">Get in Touch</strong></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1429877873720-1756',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 5,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 8,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'preset' => 'plaintxt-title-footer-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595381181-1259',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
  ),
  'group' => 'module-group-1432595381161-1359',
));

$footer->add_element("Unewnavigation", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429876920429-1668',
  'id' => 'module-1429876920429-1668',
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
         'menu-item-db-id' => 956,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact Us',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '956',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/contact/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 957,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Facebook',
         'menu-item-url' => 'http://facebook.com/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '957',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => 'http://facebook.com/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 958,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Twitter',
         'menu-item-url' => 'http://twitter.com',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '958',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => 'http://twitter.com',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'parrot-footer-nav-m',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'element_id' => 'object-1429876920429-1070',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
       'tablet' =>
      (array)(array(
         'row' => 30,
         'width' => 570,
      )),
       'mobile' =>
      (array)(array(
         'row' => 26,
         'width' => 315,
      )),
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-footer-4',
    'row' => 41,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432595381182-1265',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 30,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 26,
    ),
  ),
  'group' => 'module-group-1432595381161-1359',
));

$footer->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-51830 upfront-module-spacer',
  'id' => 'module-1450121214-51830',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-30541',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-45982',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 1,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$regions->add($footer);

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$footer_column1 = upfront_create_region(
			array (
  'name' => 'footer-column1',
  'title' => 'Footer Column1',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'footer',
  'sub' => 'right',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => 9,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 19,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 12,
    )),
  )),
  'version' => '1.0.0',
  'background_type' => 'color',
  'use_padding' => 0,
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
)
			);

$footer_column1->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-17760 upfront-module-spacer',
  'id' => 'module-1450121214-17760',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-4128',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-94055',
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
    ),
  ),
));

$footer_column1->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-30731 upfront-module-spacer',
  'id' => 'module-1450121214-30731',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-49957',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-22630',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 0,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$footer_column1->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-52846 upfront-module-spacer',
  'id' => 'module-1450121214-52846',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-70274',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-81645',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 0,
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

$footer_column1->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429807657659-1059',
  'id' => 'module-1429807657659-1059',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;"></p><p class="" style="text-align: center;">© 2004-2016 Incsub</p><p class=""></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429807657659-1456',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 8,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 16,
      )),
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '30',
         'bottom_padding_num' => '30',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'preset' => 'plaintxt-title-footer-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'plaintxt-title-footer-m',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432816326543-1370',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
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
      'col' => 6,
      'order' => 10,
      'top' => 0,
      'row' => 16,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 7,
      'top' => 0,
    ),
  ),
));

$footer_column1->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-29929 upfront-module-spacer',
  'id' => 'module-1450121214-29929',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-33746',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-25936',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
    ),
  ),
));

$footer_column1->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-49761 upfront-module-spacer',
  'id' => 'module-1450121214-49761',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-41704',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-17276',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 0,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$footer_column1->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-63800 upfront-module-spacer',
  'id' => 'module-1450121214-63800',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-14007',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-65112',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
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

$regions->add($footer_column1);

/* END_REGION_OUTPUT */