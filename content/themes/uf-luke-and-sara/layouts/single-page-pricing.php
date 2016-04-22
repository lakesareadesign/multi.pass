<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$luke_and_sara = upfront_create_region(
			array (
  'name' => 'luke-and-sara',
  'title' => 'Luke and Sara',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'luke-and-sara',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 110,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 73,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '125',
       'top_bg_padding_slider' => '125',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 85,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '110',
       'top_bg_padding_slider' => '110',
    )),
     'current_property' => 'top_bg_padding_slider',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '165',
  'top_bg_padding_num' => '165',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-pricing/bg-pricing.jpg',
  'background_image_ratio' => 0.38000000000000000444089209850062616169452667236328125,
  'version' => '1.0.0',
)
			);

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454466987386-1566 upfront-module-spacer',
  'id' => 'module-1454466987386-1566',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454466987386-1824',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454466987386-1225',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451439633745-1916',
  'id' => 'module-1451439633745-1916',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h1 class="" style="text-align: center;">Get 2 <span class="upfront_theme_color_5">free</span> album designs with every booking</h1>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451439633744-1443',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'row' => 27,
    'preset' => 'default',
    'padding_slider' => '10',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'row' => 11,
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'row' => 22,
      )),
    )),
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451439677470-1102',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 0,
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
      'col' => 12,
      'order' => 0,
      'row' => 11,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'row' => 22,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454466990335-1300 upfront-module-spacer',
  'id' => 'module-1454466990335-1300',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454466990335-1407',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454466990335-1295',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$luke_and_sara->add_element("Button", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451439487593-1465',
  'id' => 'module-1451439487593-1465',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'next-button',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1451439487592-1048',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/pricing/#next',
       'target' => '_self',
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 8,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 11,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
       'current_property' => 'bottom_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'row' => 4,
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451439760066-1908',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 3,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 11,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 4,
    ),
  ),
));

$regions->add($luke_and_sara);

$pro = upfront_create_region(
			array (
  'name' => 'pro',
  'title' => 'Pro',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'pro',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 90,
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
  'top_bg_padding_slider' => '55',
  'top_bg_padding_num' => '55',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(227,233,233,1)',
  'version' => '1.0.0',
)
			);

$pro->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451439677663-1626',
  'id' => 'module-1451439677663-1626',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_0" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_0">Pro</span> <span class="upfront_theme_color_3">649</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451439677662-1398',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'preset' => 'title-pricing',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => 'next',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 23,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 13,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 10,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451441827988-1698',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
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
      'col' => 12,
      'order' => 0,
      'row' => 10,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 13,
    ),
  ),
));

$pro->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519108049-1768 upfront-module-spacer',
  'id' => 'module-1451519108049-1768',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519108048-1147',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519108049-1263',
  'new_line' => true,
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

$pro->add_group(array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451442504654-1393',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1451442267598-1560',
  'original_col' => 24,
  'top_padding_num' => 0,
  'bottom_padding_num' => '0',
  'row' => 59,
  'lock_padding' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '0',
  'use_padding' => 'yes',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
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
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 39,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$pro->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451442574206-1223 upfront-module-spacer',
  'id' => 'module-1451442574206-1223',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451442574206-1760',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451442574206-1698',
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
  'group' => 'module-group-1451442504654-1393',
));

$pro->add_element("Button", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451439760374-1851',
  'id' => 'module-1451439760374-1851',
  'options' =>
  array (
    'content' => 'ENQUIRE',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'default',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1451439760372-1700',
    'link' =>
    (array)(array(
       'type' => 'lightbox',
       'url' => '#ltb-enquire-contact10',
       'target' => '_self',
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '115',
    'row' => 33,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '115',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'row' => 12,
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'row' => 12,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451442504657-1346',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 0,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 12,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451442504654-1393',
));

$pro->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451442578204-1459 upfront-module-spacer',
  'id' => 'module-1451442578204-1459',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451442578202-1270',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451442578204-1188',
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
  'group' => 'module-group-1451442504654-1393',
));

$pro->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454467148649-1978 upfront-module-spacer',
  'id' => 'module-1454467148649-1978',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454467148649-1563',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454467148649-1120',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451442504654-1393',
));

$pro->add_element("Uimage", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451439487507-1015',
  'id' => 'module-1451439487507-1015',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-pricing/camera-1-442x265-4310.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-pricing/camera-1.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-pricing/camera-1.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 442,
       'height' => 265,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 509,
       'height' => 305,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -26.5,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 495,
       'height' => 265,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1859,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1451439487503-1508',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'row' => 53,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'bottom_padding_use' => 'yes',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 27,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451442504658-1367',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 3,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
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
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'row' => 27,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451442504654-1393',
));

$pro->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454467151328-1294 upfront-module-spacer',
  'id' => 'module-1454467151328-1294',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454467151328-1390',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454467151328-1379',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451442504654-1393',
));

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php');
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php');
$pro->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451443240087-1890 upfront-module-spacer',
  'id' => 'module-1451443240087-1890',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451443240086-1624',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451443240087-1810',
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

$pro->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451442598277-1440',
  'id' => 'module-1451442598277-1440',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Pre-wedding mini photography session</p><p class="">5 hours continuous wedding day coverage</p><p class="">2x photographers</p><p class="">You get the RAW photos</p><h6 class="">Soft copy wedding albums on DVD</h6><h6 class="">3x wedding albums</h6><p class="">Album design – <span class="upfront_theme_color_3">FREE FOR SEP 2015</span></p><h6 class="">Photo booth</h6><h6 class="">Online gallery</h6><h6 class="">All travel on the day is included</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451442598277-1997',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 57,
    'preset' => 'check-uncheck-list',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 81,
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 95,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'check-uncheck-tablet',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451442836570-1242',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 81,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 95,
    ),
  ),
));

$pro->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451443248849-1821 upfront-module-spacer',
  'id' => 'module-1451443248849-1821',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451443248848-1503',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451443248849-1809',
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

$regions->add($pro);

$platinum = upfront_create_region(
			array (
  'name' => 'platinum',
  'title' => 'Platinum',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'platinum',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 108,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 129,
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
  'top_bg_padding_slider' => '55',
  'top_bg_padding_num' => '55',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc5',
  'version' => '1.0.0',
)
			);

$platinum->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454464589774-1233',
  'id' => 'module-1454464589774-1233',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_0" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_0">Platinum</span>&nbsp;<span class="upfront_theme_color_3">1199</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1454464589774-1149',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'preset' => 'title-pricing',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => 'next',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 23,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 13,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 10,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1454464594757-1752',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
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
      'col' => 12,
      'order' => 0,
      'row' => 10,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 13,
    ),
  ),
));

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451445247134-1293 upfront-module-spacer',
  'id' => 'module-1451445247134-1293',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451445247133-1972',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451445247134-1381',
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

$platinum->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451444443240-1228',
  'id' => 'module-1451444443240-1228',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Pre-wedding mini photography session</p><p class="">Unlimited wedding photos</p><p class="">2x photographers</p><p class="">You get the RAW photos</p><p class="">Soft copy wedding albums on DVD</p><p class="">3x wedding albums</p><p class="">Album design – <span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2">FREE FOR SEP 2015</span></p><p class="">Photo booth</p><p class="">Online gallery</p><p class="">All travel on the day is included<br></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1451444443240-1812',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 63,
    'preset' => 'check-uncheck-list',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 74,
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 79,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'check-uncheck-tablet',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451444445837-1575',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 74,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 79,
    ),
  ),
));

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451445251520-1718 upfront-module-spacer',
  'id' => 'module-1451445251520-1718',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451445251519-1873',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451445251519-1220',
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

$platinum->add_group(array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451525765857-1492',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1451444950699-1888',
  'original_col' => 12,
  'top_padding_num' => '20',
  'bottom_padding_num' => 0,
  'row' => 76,
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '20',
  'use_padding' => 'yes',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 5,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '0',
      'top_padding_slider' => '0',
      'row' => 10,
      'use_padding' => 'yes',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '55',
      'top_padding_slider' => '55',
      'row' => 12,
      'use_padding' => 'yes',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '30',
      'bottom_padding_num' => '30',
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$platinum->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451525812224-1857 upfront-module-spacer',
  'id' => 'module-1451525812224-1857',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451525812223-1554',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451525812224-1161',
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
  'group' => 'module-group-1451525765857-1492',
));

$platinum->add_element("Button", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451442163858-1216',
  'id' => 'module-1451442163858-1216',
  'options' =>
  array (
    'content' => 'ENQUIRE',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'default',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1451442163857-1515',
    'link' =>
    (array)(array(
       'type' => 'lightbox',
       'url' => '#ltb-enquire-contact10',
       'target' => '_self',
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '80',
    'row' => 24,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '80',
    'top_padding_use' => 'yes',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'row' => 12,
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'row' => 12,
      )),
    )),
    'top_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451525782137-1012',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 0,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 12,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451525765857-1492',
));

$platinum->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451525816692-1947 upfront-module-spacer',
  'id' => 'module-1451525816692-1947',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451525816692-1934',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451525816692-1748',
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
  'group' => 'module-group-1451525765857-1492',
));

$platinum->add_element("Uimage", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451442039089-1265',
  'id' => 'module-1451442039089-1265',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-pricing/camera-2-467x280-3356.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-pricing/camera-2.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-pricing/camera-2.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 467,
       'height' => 280,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 509,
       'height' => 305,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -14,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 495,
       'height' => 280,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 58,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1451442039085-1045',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'row' => 56,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 37,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
      )),
       'tablet' =>
      (array)(array(
         'row' => 56,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
       'current_property' => 'use_padding',
    )),
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451525782148-1422',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 56,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 37,
      'hide' => 1,
    ),
  ),
  'group' => 'module-group-1451525765857-1492',
));

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php');
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php');
$platinum->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451525776733-1653 upfront-module-spacer',
  'id' => 'module-1451525776733-1653',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451525776733-1244',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451525776733-1895',
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

$regions->add($platinum);

$premium = upfront_create_region(
			array (
  'name' => 'premium',
  'title' => 'Premium',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'premium',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 60,
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
  'top_bg_padding_slider' => '55',
  'top_bg_padding_num' => '55',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(227,233,233,1)',
  'version' => '1.0.0',
)
			);

$premium->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454465001261-1495',
  'id' => 'module-1454465001261-1495',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;">Premium&nbsp;<span class="upfront_theme_color_3">859</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1454465001261-1939',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'preset' => 'title-pricing',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => 'next',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 23,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 13,
      )),
       'tablet' =>
      (array)(array(
         'row' => 10,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1454465004166-1461',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
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
      'col' => 12,
      'order' => 0,
      'row' => 10,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 13,
    ),
  ),
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519393116-1883 upfront-module-spacer',
  'id' => 'module-1451519393116-1883',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519393115-1545',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519393116-1333',
  'new_line' => true,
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

$premium->add_group(array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451519020365-1042',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1451518935188-1839',
  'original_col' => 24,
  'top_padding_num' => '15',
  'bottom_padding_num' => 0,
  'row' => 73,
  'use_padding' => 'yes',
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '15',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '0',
      'top_padding_slider' => '0',
      'use_padding' => 'yes',
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 46,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '30',
      'top_padding_num' => '30',
    ),
    'current_property' =>
    array (
      0 => 'top_padding_num',
    ),
  ),
));

$premium->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519152905-1841 upfront-module-spacer',
  'id' => 'module-1451519152905-1841',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519152904-1100',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519152905-1554',
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
  'group' => 'module-group-1451519020365-1042',
));

$premium->add_element("Button", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451518513930-1582',
  'id' => 'module-1451518513930-1582',
  'options' =>
  array (
    'content' => 'ENQUIRE',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'default',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1451518513926-1019',
    'link' =>
    (array)(array(
       'type' => 'lightbox',
       'url' => '#ltb-enquire-contact10',
       'target' => '_self',
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '90',
    'row' => 28,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '90',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'row' => 12,
      )),
       'current_property' => 'bottom_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '40',
         'bottom_padding_num' => '40',
         'row' => 18,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451519020369-1180',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
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
      'col' => 12,
      'order' => 0,
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 18,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451519020365-1042',
));

$premium->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519155418-1390 upfront-module-spacer',
  'id' => 'module-1451519155418-1390',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519155418-1408',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519155418-1095',
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
  'group' => 'module-group-1451519020365-1042',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454467339880-1201 upfront-module-spacer',
  'id' => 'module-1454467339880-1201',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454467339879-1222',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454467339880-1486',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451519020365-1042',
));

$premium->add_element("Uimage", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451518513871-1522',
  'id' => 'module-1451518513871-1522',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-pricing/camera-3-476x285-7350.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-pricing/camera-3.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-pricing/camera-3.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 476,
       'height' => 285,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 509,
       'height' => 305,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -9.5,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 495,
       'height' => 285,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 57,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1451518513867-1455',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'row' => 57,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 27,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451519020371-1083',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'hide' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'row' => 27,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451519020365-1042',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454467342605-1024 upfront-module-spacer',
  'id' => 'module-1454467342605-1024',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454467342604-1099',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454467342604-1377',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451519020365-1042',
));

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'lightbox.php');
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'lightboxes' . DIRECTORY_SEPARATOR . 'ltb-enquire-contact10.php');
$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519237296-1071 upfront-module-spacer',
  'id' => 'module-1451519237296-1071',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519237295-1173',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519237296-1768',
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

$premium->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519221097-1046',
  'id' => 'module-1451519221097-1046',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Pre-wedding mini photography session</p><p class="">10 hours wedding day coverage</p><p class="">2x photographers</p><p class="">You get the RAW photos</p><h6 class="">Soft copy wedding albums on&nbsp;DVD<br></h6><p class="">3x wedding albums</p><p class="">Album design – <span class="upfront_theme_color_3">FREE FOR SEP 2015</span></p><h6 class="">Photo booth</h6><h6 class="">Online gallery</h6><h6 class="">All travel on the day is included</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1451519221097-1154',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 53,
    'preset' => 'check-uncheck-list',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'check-uncheck-tablet',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'check-uncheck-list',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451519226547-1163',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 77,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451519248176-1539 upfront-module-spacer',
  'id' => 'module-1451519248176-1539',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451519248175-1845',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451519248176-1533',
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

$regions->add($premium);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
