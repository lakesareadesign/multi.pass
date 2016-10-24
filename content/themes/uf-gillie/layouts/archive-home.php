<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$slider_callout = upfront_create_region(
			array (
  'name' => 'slider-callout',
  'title' => 'slider callout',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main-slider',
  'sub' => 'left',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'col' => 9,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_slider' => '0',
       'top_bg_padding_slider' => '0',
       'bottom_bg_padding_slider' => '0',
       'bg_padding_num' => '0',
       'top_bg_padding_num' => '0',
       'bottom_bg_padding_num' => '0',
       'row' => 10,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_slider' => '0',
       'top_bg_padding_slider' => '0',
       'bottom_bg_padding_slider' => '0',
       'bg_padding_num' => '0',
       'top_bg_padding_num' => '0',
       'bottom_bg_padding_num' => '0',
       'hide' => 0,
       'row' => 2,
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '215',
  'top_bg_padding_num' => '215',
  'bottom_bg_padding_slider' => '215',
  'bottom_bg_padding_num' => '215',
  'bg_padding_slider' => '215',
  'bg_padding_num' => '215',
  'background_color' => 'rgba(0,0,0,0)',
)
			);

$slider_callout->add_group(array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1460099541038-1046',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1460101198369-1188',
  'original_col' => 24,
  'top_padding_num' => '40',
  'bottom_padding_num' => '40',
  'use_padding' => 'yes',
  'edited' => true,
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '40',
  'background_color' => '#ufc0',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'background_type' => 'color',
  'anchor' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '40',
  'left_padding_num' => 10,
  'right_padding_num' => 10,
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
      'edited' => false,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'row' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '40',
      'top_padding_num' => '40',
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 0,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460100088714-1519 upfront-module-spacer',
  'id' => 'module-1460100088714-1519',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460100088714-1754',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460100088713-1355',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907356115-1071 upfront-module-spacer',
  'id' => 'module-1470907356115-1071',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907356115-1333',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907356114-1575',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907413281-1912 upfront-module-spacer',
  'id' => 'module-1470907413281-1912',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907413281-1774',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907413280-1006',
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459768046085-1486',
  'id' => 'module-1459768046085-1486',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3">Free Stuff</span></h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459768046084-1149',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 7,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
    'padding_number' => 10,
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460099541040-1157',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 10,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471578983729-1901 upfront-module-spacer',
  'id' => 'module-1471578983729-1901',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471578983729-1375',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471578983728-1341',
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
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907415073-1255 upfront-module-spacer',
  'id' => 'module-1470907415073-1255',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907415072-1468',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907415072-1378',
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907367479-1036 upfront-module-spacer',
  'id' => 'module-1470907367479-1036',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907367479-1648',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907367478-1923',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460100087296-1367 upfront-module-spacer',
  'id' => 'module-1460100087296-1367',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460100087296-1801',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460100087295-1202',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907358003-1559 upfront-module-spacer',
  'id' => 'module-1470907358003-1559',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907358003-1112',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907358003-1124',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907409646-1446 upfront-module-spacer',
  'id' => 'module-1470907409646-1446',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907409646-1522',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907409646-1038',
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
      'order' => 2,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459768148015-1596',
  'id' => 'module-1459768148015-1596',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3">My Chord Book<br>Advanced 2</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1459768148015-1694',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 5,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460099541042-1577',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 2,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 10,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907411311-1152 upfront-module-spacer',
  'id' => 'module-1470907411311-1152',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907411311-1854',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907411311-1234',
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
      'order' => 2,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907364359-1334 upfront-module-spacer',
  'id' => 'module-1470907364359-1334',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907364358-1980',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907364358-1201',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460100090424-1169 upfront-module-spacer',
  'id' => 'module-1460100090424-1169',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460100090424-1537',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460100090423-1509',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907359723-1009 upfront-module-spacer',
  'id' => 'module-1470907359723-1009',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907359723-1098',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907359722-1667',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 6,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907416647-1783 upfront-module-spacer',
  'id' => 'module-1470907416647-1783',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907416646-1164',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907416646-1566',
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
      'order' => 3,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Button", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459768046113-1233',
  'id' => 'module-1459768046113-1233',
  'options' =>
  array (
    'content' => 'Download',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'light',
    'element_id' => 'button-object-1459768046113-1381',
    'link' =>
    (array)(array(
       'type' => 'unlink',
       'url' => '',
       'target' => '',
    )),
    'padding_slider' => '10',
    'top_padding_num' => '20',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'light',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '20',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'light',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460099541044-1342',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 6,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 3,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907419257-1188 upfront-module-spacer',
  'id' => 'module-1470907419257-1188',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907419257-1488',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907419256-1134',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
      'col' => 3,
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
      'hide' => 0,
      'left' => 0,
      'col' => 3,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470907290126-1339 upfront-module-spacer',
  'id' => 'module-1470907290126-1339',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470907290125-1339',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470907290125-1143',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 6,
      'col' => 8,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 8,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$slider_callout->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460100096802-1131 upfront-module-spacer',
  'id' => 'module-1460100096802-1131',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460100096802-1370',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460100096801-1829',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 5,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 5,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460099541038-1046',
));

$regions->add($slider_callout);

$main_slider = upfront_create_region(
			array (
  'name' => 'main-slider',
  'title' => 'main slider',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main-slider',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 142,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 46,
       'background_type' => 'slider',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 42,
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'slider',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'always',
  'background_slider_images' =>
  array (
    0 => 'images/main_slide_1.jpg',
    1 => 'images/main_slide_2.jpg',
    2 => 'images/main_slide_3.jpg',
  ),
)
			);

$regions->add($main_slider);

$about = upfront_create_region(
			array (
  'name' => 'about',
  'title' => 'about',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'about',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 4,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '60',
       'top_bg_padding_num' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '60',
       'top_bg_padding_num' => '60',
    )),
     'current_property' => 'top_bg_padding_num',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '100',
  'top_bg_padding_num' => '100',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
)
			);

$about->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460562065811-1463 upfront-module-spacer',
  'id' => 'module-1460562065811-1463',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460562065810-1160',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460562065810-1465',
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

$about->add_element("Uimage", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459758499265-1307',
  'id' => 'module-1459758499265-1307',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gillie_6-250x302-5550.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_6.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_6.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 260,
       'height' => 302,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 250,
       'height' => 290,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 5,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 250,
       'height' => 302,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '24',
    'align' => 'center',
    'stretch' => true,
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
    'element_id' => 'image-1459758499262-1136',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 62,
    'valign' => 'center',
    'isDotAlign' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 130,
         'element_size' =>
        (array)(array(
           'width' => 520,
           'height' => 628,
        )),
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 76,
         'element_size' =>
        (array)(array(
           'width' => 295,
           'height' => 356,
        )),
      )),
    )),
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459759650854-1415',
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
    'current_property' =>
    array (
      0 => 'order',
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
      'hide' => 1,
      'row' => 130,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 1,
      'row' => 76,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$about->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460562121366-1658 upfront-module-spacer',
  'id' => 'module-1460562121366-1658',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460562121366-1427',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460562121364-1190',
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

$about->add_group(array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1460562041490-1449',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1460562044226-1074',
  'original_col' => 24,
  'top_padding_num' => '50',
  'bottom_padding_num' => 0,
  'use_padding' => 'yes',
  'edited' => true,
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '50',
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'background_type' => 'color',
  'anchor' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '50',
  'left_padding_num' => 10,
  'right_padding_num' => 10,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '0',
      'bottom_padding_num' => '0',
      'row' => 52,
      'top_padding_use' => 'yes',
      'top_padding_slider' => '0',
      'top_padding_num' => '0',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '5',
      'top_padding_num' => '5',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '50',
      'bottom_padding_num' => '50',
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$about->add_element("PlainTxt", array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459758700854-1309',
  'id' => 'module-1459758700854-1309',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4>About Gillie Brown</h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459758700854-1140',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '20',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 7,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_num' => '0',
         'top_padding_use' => 'yes',
         'left_padding_num' => '',
         'right_padding_num' => '',
         'bottom_padding_num' => '0',
         'row' => 5,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
      )),
    )),
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'current_preset' => 'default',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'center',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460562041492-1125',
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
      'col' => 7,
      'order' => 1,
      'clear' => true,
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
      'row' => 5,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("PlainTxt", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459759810487-1014',
  'id' => 'module-1459759810487-1014',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<blockquote>It\'s not just a new way to learn,&nbsp;it\'s also a whole new mindset.</blockquote>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459759810486-1927',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'quote',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '30',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'is_edited' => true,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'quote',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'center',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'row' => 24,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
      )),
    )),
    'current_preset' => 'quote',
    'row' => 15,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460562041493-1158',
  'new_line' => true,
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
      0 => 'edited',
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
      'row' => 24,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470976889165-1083 upfront-module-spacer',
  'id' => 'module-1470976889165-1083',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470976889165-1678',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470976889164-1116',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
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
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("Button", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459758499292-1534',
  'id' => 'module-1459758499292-1534',
  'options' =>
  array (
    'content' => 'Read More',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'light',
    'element_id' => 'button-object-1459758499291-1308',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/about/',
       'target' => '',
       'object' => 'page',
       'object_id' => 83,
    )),
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'light',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
    )),
    'current_preset' => 'light',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460562041495-1778',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 3,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 3,
      'clear' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("Uspacer", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460562509381-1216 upfront-module-spacer',
  'id' => 'module-1460562509381-1216',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460562509381-1075',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460562509379-1048',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
      'col' => 9,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 9,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("Uspacer", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460562148834-1914 upfront-module-spacer',
  'id' => 'module-1460562148834-1914',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460562148834-1866',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460562148833-1652',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460562041490-1449',
));

$about->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460562142740-1471 upfront-module-spacer',
  'id' => 'module-1460562142740-1471',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460562142739-1021',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460562142738-1592',
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

$regions->add($about);

$banners_top = upfront_create_region(
			array (
  'name' => 'banners-top',
  'title' => 'banners top',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'banners-top',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
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
       'edited' => true,
       'col' => 24,
       'row' => 9,
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
  'background_color' => '#ffffff',
)
			);

$banners_top->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459521087346-1684 upfront-module-spacer',
  'id' => 'module-1459521087346-1684',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459521087345-1057',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459521087345-1958',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
));

$banners_top->add_element("Uimage", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459520887172-1865',
  'id' => 'module-1459520887172-1865',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gallery-5-610x340-1137.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-5.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-5.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 844,
       'height' => 562,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 1364,
       'height' => 909,
    )),
    'position' =>
    (array)(array(
       'top' => 169.5,
       'left' => 202,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 610,
       'height' => 340,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '2638',
    'align' => 'center',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'video-link',
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
       'type' => 'image',
       'url' => '{{upfront:style_url}}/images/archive-home/1394411563gallery-5.jpg',
       'target' => '_self',
    )),
    'element_id' => 'image-1459520887169-1555',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 6,
    'valign' => 'center',
    'isDotAlign' => false,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'video-link',
      )),
    )),
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'row' => 25,
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
    )),
    'current_preset' => 'video-link',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459521078337-1860',
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
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
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
      'row' => 25,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$banners_top->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459520826299-1324',
  'id' => 'module-1459520826299-1324',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gillie_3-160x160-5073.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_3.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_3.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '11',
    'align' => 'center',
    'stretch' => true,
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
    'element_id' => 'image-1459520826294-1710',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 18,
    'valign' => 'center',
    'isDotAlign' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 63,
         'element_size' =>
        (array)(array(
           'width' => 295,
           'height' => 295,
        )),
      )),
    )),
    'current_preset' => 'default',
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459520887009-1207',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 1,
      'row' => 63,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'close_wrapper' => false,
));

$banners_top->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459520942606-1926',
  'id' => 'module-1459520942606-1926',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gillie_4-160x160-3326.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_4.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_4.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '12',
    'align' => 'center',
    'stretch' => true,
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
    'element_id' => 'object-1459520942606-1647',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 18,
    'valign' => 'center',
    'isDotAlign' => true,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459520887009-1207',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 12,
      'order' => 1,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$banners_top->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459521108894-1220 upfront-module-spacer',
  'id' => 'module-1459521108894-1220',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459521108893-1259',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459521108892-1409',
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

$regions->add($banners_top);

$main_callout = upfront_create_region(
			array (
  'name' => 'main-callout',
  'title' => 'main callout',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main-callout',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 91,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'row' => 31,
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 4,
       'hide' => 1,
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(0,0,0,0)',
  'background_style' => 'fixed',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '-25',
  'background_image' => '{{upfront:style_url}}/images/archive-home/guitar.png',
  'background_image_ratio' => 0.39000000000000001332267629550187848508358001708984375,
  'background_repeat' => 'no-repeat',
  'background_position' => '-25% 50%',
)
			);

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460035396794-1016 upfront-module-spacer',
  'id' => 'module-1460035396794-1016',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460035396793-1909',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460035396793-1610',
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

$main_callout->add_group(array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1460035394387-1207',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1460034836758-1499',
  'original_col' => 24,
  'top_padding_num' => '40',
  'bottom_padding_num' => '40',
  'use_padding' => 'yes',
  'edited' => true,
  'background_color' => '#ufc6',
  'background_style' => 'fixed',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '-105',
  'background_type' => 'image',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '40',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '40',
  'background_image' => '{{upfront:style_url}}/images/archive-home/guitar.png',
  'background_image_ratio' => 0.39000000000000001332267629550187848508358001708984375,
  'background_repeat' => 'no-repeat',
  'background_position' => '-105% 50%',
  'left_padding_num' => 10,
  'right_padding_num' => 10,
  'lock_padding' => 0,
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
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'background_position_y' => '50',
      'background_style' => 'fixed',
      'background_repeat' => 'no-repeat',
      'background_position' => '50% 50%',
      'background_position_x' => '50',
      'use_padding' => 0,
      'row' => 61,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'background_position_y' => '25',
      'background_style' => 'fixed',
      'background_repeat' => 'no-repeat',
      'background_position' => '100% 25%',
      'background_position_x' => '100',
      'use_padding' => 0,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$main_callout->add_element("Uspacer", array (
  'columns' => '17',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460035417549-1161 upfront-module-spacer',
  'id' => 'module-1460035417549-1161',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460035417548-1414',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460035417547-1853',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561154239-1970 upfront-module-spacer',
  'id' => 'module-1460561154239-1970',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561154239-1775',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561154238-1609',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 7,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 7,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563619209-1396 upfront-module-spacer',
  'id' => 'module-1460563619209-1396',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563619208-1233',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563619208-1031',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 2,
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
      'hide' => 0,
      'left' => 0,
      'col' => 2,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'tablet' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("PlainTxt", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459524992795-1599',
  'id' => 'module-1459524992795-1599',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2 class="" style="text-align: right;">Find Gillie Brown on YouTube<br></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1459524992796-1015',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'callout-message',
    'padding_slider' => '10',
    'top_padding_num' => '250',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '200',
    'padding_number' => '10',
    'left_padding_num' => '20',
    'right_padding_num' => '0',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'callout-message',
      )),
    )),
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'callout-message',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460035394391-1289',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 4,
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470904382463-1549 upfront-module-spacer',
  'id' => 'module-1470904382463-1549',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470904382463-1314',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470904382463-1473',
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470904363979-1737 upfront-module-spacer',
  'id' => 'module-1470904363979-1737',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470904363978-1795',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470904363977-1552',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470904282013-1383 upfront-module-spacer',
  'id' => 'module-1470904282013-1383',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470904282012-1496',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470904282011-1987',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460035428868-1425 upfront-module-spacer',
  'id' => 'module-1460035428868-1425',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460035428868-1627',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460035428867-1760',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561156793-1463 upfront-module-spacer',
  'id' => 'module-1460561156793-1463',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561156793-1588',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561156792-1062',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 4,
      'col' => 8,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 8,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563616397-1795 upfront-module-spacer',
  'id' => 'module-1460563616397-1795',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563616397-1012',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563616397-1824',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 6,
      'col' => 3,
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
      'hide' => 0,
      'left' => 0,
      'col' => 3,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'tablet' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460034538710-1741',
  'id' => 'module-1460034538710-1741',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: right;"><span class="uf_font_icon" style="font-size: 35px; top: 0px;" rel="font-size: 35px; top: 0px;" data-verified="redactor" data-redactor-tag="span" data-redactor-style="font-size: 35px; top: 0px;"><a target="_blank" data-upfront-link-type="external" href="http://youtube.com"><span style="color:rgb(230, 92, 65)">y</span></a></span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1460034538709-1333',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'icon-link',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 7,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'icon-link',
      )),
    )),
    'theme_style' => '',
    'current_preset' => 'icon-link',
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460035424873-1952',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 4,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 6,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460564055660-1099 upfront-module-spacer',
  'id' => 'module-1460564055660-1099',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460564055660-1019',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460564055659-1931',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 4,
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
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563614370-1249 upfront-module-spacer',
  'id' => 'module-1460563614370-1249',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563614370-1978',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563614369-1237',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 6,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'tablet' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460035545455-1241 upfront-module-spacer',
  'id' => 'module-1460035545455-1241',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460035545454-1552',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460035545453-1715',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main_callout->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460035398748-1714 upfront-module-spacer',
  'id' => 'module-1460035398748-1714',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460035398747-1424',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460035398747-1378',
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

$regions->add($main_callout);

$testimonials = upfront_create_region(
			array (
  'name' => 'testimonials',
  'title' => 'testimonials',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'testimonials',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 5,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 5,
       'background_type' => 'color',
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 5,
       'hide' => 1,
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
  'background_color' => '#ffffff',
)
			);

$testimonials->add_element("USlider", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459847506586-1175',
  'id' => 'module-1459847506586-1175',
  'options' =>
  array (
    'id_slug' => 'uslider',
    'type' => 'USliderModel',
    'view_class' => 'USliderView',
    'class' => 'c24 upfront-uslider',
    'has_settings' => 1,
    'preset' => 'side-slide',
    'primaryStyle' => 'notext',
    'style' => 'right',
    'controls' => 'both',
    'controlsWhen' => 'always',
    'rotate' =>
    array (
      0 => 'true',
    ),
    'rotateTime' => 5,
    'transition' => 'crossfade',
    'slides' =>
    array (
      0 =>
      (array)(array(
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_8-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_8-194x300.jpg',
            1 => 194,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_8.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_8.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_8.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gillie_8-349x525-2073.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_8.jpg',
             'full' =>
            (array)(array(
               'width' => 340,
               'height' => 525,
            )),
             'crop' =>
            (array)(array(
               'width' => 349,
               'height' => 525,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '349',
                 'height' => '525',
                 'left' => 0,
                 'top' => 7,
              )),
               'resize' =>
              (array)(array(
                 'width' => 349,
                 'height' => 539,
              )),
               'id' => 64,
               'element_id' => 'uslider-object-1459847506585-1319',
            )),
          )),
        )),
         'id' => 2218,
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_8.jpg',
         'status' => 'ok',
         'src' => '{{upfront:style_url}}/images/archive-home/gillie_8-315x525-2009.jpg',
         'size' =>
        (array)(array(
           'width' => 340,
           'height' => 525,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 315,
           'height' => 525,
        )),
         'cropOffset' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
           'width' => 315,
           'height' => 525,
        )),
         'rotation' => 0,
         'url' => '',
         'urlType' => '',
         'text' => '<p class="nosortable">Jason, aged 8</p><blockquote class="nosortable"><span id="selection-marker-1" class="redactor-selection-marker" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-selection-marker">​</span>"My son started guitar lessons with Gillie just two months ago and has already gained a huge knowledge and understanding of music and how to play guitar well."​<span id="selection-marker-2" class="redactor-selection-marker" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-selection-marker">​</span></blockquote><p class="nosortable"><a target="_self" data-upfront-link-type="entry" href="{{upfront:home_url}}/testimonials/">View all</a></p>',
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'captionColor' => '#ffffff',
         'captionBackground' => '#000000',
         'style' => 'right',
         'rightImageWidth' => 3,
         'rightWidth' => 6,
         'breakpoint' =>
        (array)(array(
           'tablet' =>
          (array)(array(
             'style' => 'below',
          )),
           'mobile' =>
          (array)(array(
             'style' => 'below',
          )),
        )),
      )),
      1 =>
      (array)(array(
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_9-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_9-194x300.jpg',
            1 => 194,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_9.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_9.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gillie_9.jpg',
            1 => 340,
            2 => 525,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gillie_9-349x525-7161.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_9.jpg',
             'full' =>
            (array)(array(
               'width' => 340,
               'height' => 525,
            )),
             'crop' =>
            (array)(array(
               'width' => 349,
               'height' => 525,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '349',
                 'height' => '525',
                 'left' => 0,
                 'top' => 7,
              )),
               'resize' =>
              (array)(array(
                 'width' => 349,
                 'height' => 539,
              )),
               'id' => 66,
            )),
          )),
        )),
         'id' => 2219,
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_9.jpg',
         'status' => 'ok',
         'src' => '{{upfront:style_url}}/images/archive-home/gillie_9-315x525-6736.jpg',
         'size' =>
        (array)(array(
           'width' => 340,
           'height' => 525,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 315,
           'height' => 525,
        )),
         'cropOffset' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
           'width' => 315,
           'height' => 525,
        )),
         'rotation' => 0,
         'url' => '',
         'urlType' => '',
         'text' => '<p class="nosortable">Angela, aged 14</p><blockquote class="nosortable">"Gillie is awesome! She has taught me to play so much on guitar. Not only is she a great teacher but she become a great friend to me as well. Lessons with her are definitely fun!"​</blockquote><p class="nosortable"><a target="_self" data-upfront-link-type="entry" href="{{upfront:home_url}}/testimonials/">View all</a>​</p>',
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'captionColor' => '#ffffff',
         'captionBackground' => '#000000',
         'style' => 'right',
         'rightImageWidth' => 3,
         'rightWidth' => 6,
         'breakpoint' =>
        (array)(array(
           'tablet' =>
          (array)(array(
             'style' => 'below',
          )),
           'mobile' =>
          (array)(array(
             'style' => 'below',
          )),
        )),
      )),
    ),
    'captionUseBackground' => '0',
    'captionBackground' => 'transparent',
    'rightImageWidth' => 8,
    'rightWidth' => 22,
    'element_id' => 'uslider-object-1459847506585-1319',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 81,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '55',
    'right_padding_num' => '55',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'side-slide',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'side-slide-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'side-slide-mobile',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
      )),
    )),
    'current_preset' => 'side-slide',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459847543619-1168',
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
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'hide' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$regions->add($testimonials);

$banners_bottom = upfront_create_region(
			array (
  'name' => 'banners-bottom',
  'title' => 'banners bottom',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'banners-bottom',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 60,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 8,
       'background_type' => 'color',
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 4,
       'hide' => 1,
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
  'background_color' => '#ffffff',
)
			);

$banners_bottom->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459522835455-1408 upfront-module-spacer',
  'id' => 'module-1459522835455-1408',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459522835455-1785',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459522835452-1936',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
));

$banners_bottom->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459521078538-1625',
  'id' => 'module-1459521078538-1625',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gillie_1-520x340-9186.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_1.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_1.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 521,
       'height' => 340,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 521,
       'height' => 340,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 520,
       'height' => 339,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '9',
    'align' => 'center',
    'stretch' => true,
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
    'element_id' => 'image-1459521078535-1047',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 15,
    'valign' => 'center',
    'isDotAlign' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
         'row' => 76,
         'element_size' =>
        (array)(array(
           'width' => 520,
           'height' => 340,
        )),
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 43,
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
         'element_size' =>
        (array)(array(
           'width' => 295,
           'height' => 195,
        )),
      )),
    )),
    'current_preset' => 'default',
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459522758385-1055',
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
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'row' => 76,
      'hide' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 43,
      'hide' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$banners_bottom->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459522758521-1936',
  'id' => 'module-1459522758521-1936',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/gillie_2-160x160-1625.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/gillie_2.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/gillie_2.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 160,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '10',
    'align' => 'center',
    'stretch' => true,
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
    'element_id' => 'image-1459522758518-1022',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => 18,
    'valign' => 'center',
    'isDotAlign' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 108,
         'element_size' =>
        (array)(array(
           'width' => 520,
           'height' => 520,
        )),
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 63,
         'element_size' =>
        (array)(array(
           'width' => 295,
           'height' => 295,
        )),
      )),
    )),
    'current_preset' => 'default',
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459522814401-1597',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'hide' => 1,
      'row' => 108,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 0,
      'row' => 63,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$banners_bottom->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459522857111-1576 upfront-module-spacer',
  'id' => 'module-1459522857111-1576',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459522857110-1882',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459522857110-1539',
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

$regions->add($banners_bottom);

$callouts = upfront_create_region(
			array (
  'name' => 'callouts',
  'title' => 'callouts',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'callouts',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 12,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'background_color' => 'rgba(0,0,0,0)',
       'hide' => 0,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'current_property' => 'background_color',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => '0',
  'bg_padding_num' => '0',
  'background_color' => '#ffffff',
)
			);

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459843709203-1316 upfront-module-spacer',
  'id' => 'module-1459843709203-1316',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459843709202-1963',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459843709202-1229',
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

$callouts->add_group(array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1459761678049-1463',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1459761602484-1392',
  'original_col' => 24,
  'top_padding_num' => 0,
  'bottom_padding_num' => 0,
  'use_padding' => 'yes',
  'edited' => true,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_type' => 'image',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '10',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '10',
  'background_image' => '{{upfront:style_url}}/images/archive-home/gillie_7.jpg',
  'background_image_ratio' => 0.57999999999999996003197111349436454474925994873046875,
  'row' => 54,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'left_padding_num' => 10,
  'right_padding_num' => 10,
  'lock_padding' => 0,
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
      'edited' => false,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
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
      'background_position_y' => '50',
      'background_style' => 'full',
      'background_position_x' => '50',
      'use_padding' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '0',
      'top_padding_num' => '0',
      'row' => 54,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'background_position_y' => '50',
      'background_style' => 'full',
      'background_position_x' => '50',
      'use_padding' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761602485-1473 upfront-module-spacer',
  'id' => 'module-1459761602485-1473',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761602485-1998',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678052-1484',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561247548-1438 upfront-module-spacer',
  'id' => 'module-1460561247548-1438',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561247548-1545',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561247547-1521',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
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
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563980438-1168 upfront-module-spacer',
  'id' => 'module-1460563980438-1168',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563980438-1866',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563980438-1583',
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459760995178-1568',
  'id' => 'module-1459760995178-1568',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p>Blog</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459760995178-1744',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '35',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '35',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 7,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
    'padding_number' => 10,
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459761678053-1669',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 11,
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 11,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563987334-1782 upfront-module-spacer',
  'id' => 'module-1460563987334-1782',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563987333-1443',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563987333-1731',
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761605274-1816 upfront-module-spacer',
  'id' => 'module-1459761605274-1816',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761605274-1329',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678055-1207',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761598373-1871 upfront-module-spacer',
  'id' => 'module-1459761598373-1871',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761598372-1575',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678056-1416',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561245964-1695 upfront-module-spacer',
  'id' => 'module-1460561245964-1695',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561245963-1362',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561245962-1029',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
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
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563979313-1690 upfront-module-spacer',
  'id' => 'module-1460563979313-1690',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563979313-1073',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563979311-1399',
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
      'order' => 2,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761011136-1064',
  'id' => 'module-1459761011136-1064',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2>News &amp; Tips<br>sit amet lorem<br>ipsum dolor</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459761011135-1519',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 5,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459761678060-1843',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 11,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 2,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 11,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563985501-1738 upfront-module-spacer',
  'id' => 'module-1460563985501-1738',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563985500-1623',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563985500-1453',
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
      'order' => 2,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761599749-1261 upfront-module-spacer',
  'id' => 'module-1459761599749-1261',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761599749-1710',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678062-1156',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761608661-1065 upfront-module-spacer',
  'id' => 'module-1459761608661-1065',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761608660-1903',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678063-1764',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
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
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561251125-1212 upfront-module-spacer',
  'id' => 'module-1460561251125-1212',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561251125-1235',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561251125-1062',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 8,
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
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460563981794-1570 upfront-module-spacer',
  'id' => 'module-1460563981794-1570',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460563981793-1707',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460563981792-1937',
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
      'order' => 3,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Button", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459760328930-1895',
  'id' => 'module-1459760328930-1895',
  'options' =>
  array (
    'content' => 'View all',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'light',
    'element_id' => 'button-object-1459760328929-1358',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/blog/',
       'target' => '',
       'object' => 'page',
       'object_id' => 265,
    )),
    'padding_slider' => '10',
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'row' => '',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'light',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'light',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459761678065-1003',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 8,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 3,
      'clear' => false,
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
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470978348690-1583 upfront-module-spacer',
  'id' => 'module-1470978348690-1583',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470978348690-1800',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470978348689-1483',
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
      'order' => 3,
      'col' => 1,
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
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460561215824-1904 upfront-module-spacer',
  'id' => 'module-1460561215824-1904',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460561215823-1992',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460561215822-1859',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 8,
      'col' => 8,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 8,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459761610925-1665 upfront-module-spacer',
  'id' => 'module-1459761610925-1665',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459761610924-1921',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459761678067-1906',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 6,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 6,
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
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1459761678049-1463',
));

$callouts->add_element("Posts", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459843618973-1100',
  'id' => 'module-1459843618973-1100',
  'options' =>
  array (
    'type' => 'PostsModel',
    'view_class' => 'PostsView',
    'has_settings' => 1,
    'class' => 'c24 uposts-object',
    'id_slug' => 'posts',
    'display_type' => 'list',
    'list_type' => 'generic',
    'offset' => 1,
    'taxonomy' => '',
    'term' => '',
    'content' => 'excerpt',
    'limit' => '2',
    'pagination' => '',
    'sticky' => '',
    'posts_list' => '',
    'thumbnail_size' => 'thumbnail',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'default_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'gravatar',
      3 => 'comment_count',
      4 => 'featured_image',
      5 => 'title',
      6 => 'content',
      7 => 'read_more',
      8 => 'tags',
      9 => 'categories',
      10 => 'meta',
    ),
    'date_posted_format' => 'j F',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => 0,
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'grid-home',
    'post-part-date_posted' => '<div class="uposts-part date_posted">
<span class="datetime">{{datetime}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">
	By <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'post-part-title' => '<div class="uposts-part title">
	<h2><a href="{{permalink}}" title="{{title}}">{{title}}</a></h2>
</div>',
    'post-part-content' => '<div class="uposts-part content {{content_type}}">
	{{content}}
</div>',
    'post-part-read_more' => '<div class="uposts-part read_more">
	<a href="{{permalink}}">Read more</a></div>',
    'post-part-tags' => '<div class="uposts-part post_tags">
	{{tags}}
</div>',
    'post-part-categories' => '<div class="uposts-part post_categories">
	{{categories}}
</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'element_id' => 'posts-object-1459843618970-1462',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'grid-home',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'grid-home-mobile',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'top_padding_num' => '10',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'row' => 108,
      )),
    )),
    'current_preset' => 'grid-home',
    'left_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459843706101-1967',
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
      'order' => 2,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
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
      'row' => 108,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$callouts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459843727440-1822 upfront-module-spacer',
  'id' => 'module-1459843727440-1822',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459843727440-1050',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459843727439-1420',
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

$regions->add($callouts);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
