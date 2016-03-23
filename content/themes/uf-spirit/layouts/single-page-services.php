<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$services_title = upfront_create_region(
			array (
  'name' => 'services-title',
  'title' => 'Services Title',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'services-title',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 67,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 38,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '45',
       'top_bg_padding_slider' => '45',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 25,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '25',
       'top_bg_padding_slider' => '25',
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '80',
  'top_bg_padding_num' => '80',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-services/bg-page-services.jpg',
  'background_image_ratio' => 0.25,
  'version' => '1.0.0',
)
			);

$services_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425481042-1625 upfront-module-spacer',
  'id' => 'module-1453425481042-1625',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425481041-1994',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425481042-1634',
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

$services_title->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425360194-1851',
  'id' => 'module-1453425360194-1851',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1 style="text-align: center;">SERVICES</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425360193-1754',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '15',
    'row' => 19,
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'row' => 6,
      )),
       'current_property' => 'bottom_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'row' => 7,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453425458522-1811',
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
      'row' => 6,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 7,
    ),
  ),
));

$services_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425485739-1333 upfront-module-spacer',
  'id' => 'module-1453425485739-1333',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425485738-1139',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425485739-1653',
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

$regions->add($services_title);

$services_content = upfront_create_region(
			array (
  'name' => 'services-content',
  'title' => 'Services Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'services-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 212,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 241,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 360,
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
  'version' => '1.0.0',
)
			);

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425778555-1884 upfront-module-spacer',
  'id' => 'module-1453425778555-1884',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425778554-1342',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425778555-1264',
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

$services_content->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425458783-1148',
  'id' => 'module-1453425458783-1148',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}">HOME</a> &nbsp;/ &nbsp;SERVICES</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425458783-1679',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'preset' => 'breadcrumbs',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'breadcrumbs',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'row' => 10,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453425594425-1043',
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425780693-1523 upfront-module-spacer',
  'id' => 'module-1453425780693-1523',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425780692-1973',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425780693-1789',
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

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433682378-1472 upfront-module-spacer',
  'id' => 'module-1453433682378-1472',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453433682378-1104',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453433682378-1183',
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

$services_content->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433447948-1049',
  'id' => 'module-1453433447948-1049',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2 style="text-align: center;">WORK WITH ME</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453433447948-1282',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '25',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '25',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '30',
         'top_padding_num' => '30',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '30',
         'top_padding_num' => '30',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453433471129-1656',
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433684479-1941 upfront-module-spacer',
  'id' => 'module-1453433684479-1941',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453433684478-1701',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453433684479-1407',
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

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425820488-1317 upfront-module-spacer',
  'id' => 'module-1453425820488-1317',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425820488-1179',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425820488-1827',
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

$services_content->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425744532-1902',
  'id' => 'module-1453425744532-1902',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h3 style="text-align: center;">W<span style="font-weight: 300; line-height: 1.5em; text-transform: none;">hether you prefer one-on-one training or the dynamic environment of outdoor group fitness, you\'ll&nbsp;receive&nbsp;an individualized approach with high quality instructions and support.</span></h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425744531-1920',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '30',
    'bottom_padding_num' => '30',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
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
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'align-center',
      )),
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
  'wrapper_id' => 'wrapper-1453425811280-1466',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 3,
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
      'edited' => false,
      'left' => 0,
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425823393-1127 upfront-module-spacer',
  'id' => 'module-1453425823393-1127',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425823393-1215',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425823393-1114',
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

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433851171-1454 upfront-module-spacer',
  'id' => 'module-1453433851171-1454',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453433851170-1559',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453433851171-1010',
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

$services_content->add_group(array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1453433835690-1736',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1453433768105-1830',
  'original_col' => 24,
  'top_padding_num' => 0,
  'bottom_padding_num' => 0,
  'row' => 47,
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '15',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '15',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 4,
      'clear' => true,
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$services_content->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433662169-1868',
  'id' => 'module-1453433662169-1868',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h3 style="text-align: right;"><span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum</span></h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453433662168-1992',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'preset' => 'default',
    'use_padding' => false,
    'lock_padding' => 0,
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
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
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453433835697-1275',
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
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1453433835690-1736',
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433875912-1295 upfront-module-spacer',
  'id' => 'module-1453433875912-1295',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453433875912-1125',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453433875912-1126',
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
  'group' => 'module-group-1453433835690-1736',
));

$services_content->add_element("PlainTxt", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433768366-1005',
  'id' => 'module-1453433768366-1005',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class="">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming.<span>​</span><span>&nbsp;</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453433768364-1401',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'preset' => 'default',
    'use_padding' => false,
    'lock_padding' => 0,
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
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
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'align-center',
      )),
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
  'wrapper_id' => 'wrapper-1453433843705-1563',
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1453433835690-1736',
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433853426-1695 upfront-module-spacer',
  'id' => 'module-1453433853426-1695',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453433853425-1819',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453433853426-1574',
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

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430885793-1429 upfront-module-spacer',
  'id' => 'module-1453430885793-1429',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453430885793-1076',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453430885793-1819',
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

$services_content->add_element("Ugallery", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430326935-1315',
  'id' => 'module-1453430326935-1315',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'preset' => 'default',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => '1725',
         'srcFull' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-180x180-1783.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
            )),
             'crop' =>
            (array)(array(
               'width' => 180,
               'height' => 180,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '180',
                 'height' => '180',
                 'left' => 45,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 270,
                 'height' => 180,
              )),
               'id' => 1725,
               'element_id' => 'ugallery-object-1453430326931-1944',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 270,
           'height' => 180,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 180,
           'height' => 180,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '180',
           'height' => '180',
           'left' => 45,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five-180x180-1783.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>Image caption</p>',
         'caption' => 'Image description',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-services/img-gallery-five.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => '1724',
         'srcFull' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-300x131.jpg',
            1 => 300,
            2 => 131,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-768x334.jpg',
            1 => 768,
            2 => 334,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-1024x446.jpg',
            1 => 1024,
            2 => 446,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
            1 => 1080,
            2 => 470,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-180x180-7479.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 470,
            )),
             'crop' =>
            (array)(array(
               'width' => 180,
               'height' => 180,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '180',
                 'height' => '180',
                 'left' => 117,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 414,
                 'height' => 180,
              )),
               'id' => 1724,
               'element_id' => 'ugallery-object-1453430326931-1944',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 414,
           'height' => 180,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 180,
           'height' => 180,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '180',
           'height' => '180',
           'left' => 117,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four-180x180-7479.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>Image caption</p>',
         'caption' => 'Image description',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-services/img-gallery-four.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => '1726',
         'srcFull' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-180x180-3456.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
            )),
             'crop' =>
            (array)(array(
               'width' => 180,
               'height' => 180,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '180',
                 'height' => '180',
                 'left' => 45,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 270,
                 'height' => 180,
              )),
               'id' => 1726,
               'element_id' => 'ugallery-object-1453430326931-1944',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 270,
           'height' => 180,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 180,
           'height' => 180,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '180',
           'height' => '180',
           'left' => 45,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six-180x180-3456.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>Image caption</p>',
         'caption' => 'Image description',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-services/img-gallery-six.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => '1727',
         'srcFull' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven-210x300.jpg',
            1 => 210,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven-180x180-6443.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
             'full' =>
            (array)(array(
               'width' => 630,
               'height' => 900,
            )),
             'crop' =>
            (array)(array(
               'width' => 180,
               'height' => 180,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '180',
                 'height' => '180',
                 'left' => 0,
                 'top' => 38,
              )),
               'resize' =>
              (array)(array(
                 'width' => 180,
                 'height' => 257,
              )),
               'id' => 1727,
               'element_id' => 'ugallery-object-1453430326931-1944',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 180,
           'height' => 257,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 180,
           'height' => 180,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '180',
           'height' => '180',
           'left' => 0,
           'top' => 38,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven-180x180-6443.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>Image caption</p>',
         'caption' => 'Image description',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-services/img-gallery-seven.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => '1728',
         'srcFull' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-180x180-3365.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
            )),
             'crop' =>
            (array)(array(
               'width' => 180,
               'height' => 180,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '180',
                 'height' => '180',
                 'left' => 45,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 270,
                 'height' => 180,
              )),
               'id' => 1728,
               'element_id' => 'ugallery-object-1453430326931-1944',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 270,
           'height' => 180,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 180,
           'height' => 180,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '180',
           'height' => '180',
           'left' => 45,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight-180x180-3365.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>Image caption</p>',
         'caption' => 'Image description',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-services/img-gallery-eight.jpg',
         'imageLinkTarget' => '',
      )),
    ),
    'elementSize' =>
    (array)(array(
       'width' => 0,
       'height' => 0,
    )),
    'labelFilters' =>
    array (
    ),
    'thumbProportions' => '1',
    'thumbWidth' => '180',
    'thumbHeight' => 180,
    'thumbWidthNumber' => '180',
    'captionType' => 'none',
    'captionColor' => '#ffffff',
    'captionUseBackground' => 0,
    'captionBackground' => '#000000',
    'showCaptionOnHover' => 0,
    'fitThumbCaptions' => false,
    'thumbCaptionsHeight' => 20,
    'linkTo' => 'image',
    'even_padding' =>
    array (
      0 => 'false',
    ),
    'thumbPadding' => 15,
    'sidePadding' => '15',
    'bottomPadding' => '15',
    'thumbPaddingNumber' => 15,
    'thumbSidePaddingNumber' => '15',
    'thumbBottomPaddingNumber' => '15',
    'lockPadding' => '',
    'lightbox_show_close' =>
    array (
      0 => 'true',
    ),
    'lightbox_show_image_count' =>
    array (
      0 => 'true',
    ),
    'lightbox_click_out_close' =>
    array (
      0 => 'true',
    ),
    'lightbox_active_area_bg' => 'rgba(255,255,255,1)',
    'lightbox_overlay_bg' => 'rgba(0,0,0,0.2)',
    'styles' => '',
    'element_id' => 'ugallery-object-1453430326931-1944',
    'padding_slider' => '15',
    'top_padding_num' => '60',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
    'row' => 47,
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453430469291-1102',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 5,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 5,
      'clear' => true,
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430888177-1850 upfront-module-spacer',
  'id' => 'module-1453430888177-1850',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453430888177-1831',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453430888177-1867',
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

$services_content->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453433800632-1200',
  'id' => 'module-1453433800632-1200',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2 style="text-align: center;">MORE</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453433800631-1202',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '45',
    'bottom_padding_num' => '45',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 14,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '45',
    'preset' => 'default',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '45',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '75',
         'bottom_padding_num' => '75',
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '75',
         'bottom_padding_num' => '75',
      )),
       'current_property' => 'bottom_padding_num',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453434539865-1966',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 6,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 6,
      'clear' => true,
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$regions->add($services_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-training.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-training.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-retreats.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-retreats.php');

$workplace_wellness = upfront_create_region(
			array (
  'name' => 'workplace-wellness',
  'title' => 'Workplace Wellness',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'workplace-wellness',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 57,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 56,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 56,
    )),
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_style' => 'fixed',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-services/bg-wellness.jpg',
  'background_image_ratio' => 0.25,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'version' => '1.0.0',
)
			);

$workplace_wellness->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452647620441-1456',
  'id' => 'module-1452647620441-1456',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h5 style="text-align: left;">WORKPLACE WELLNESS</h5>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1452647620441-1747',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '80',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '80',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 12,
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '60',
         'top_padding_num' => '60',
         'lock_padding' => '',
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '80',
         'top_padding_num' => '80',
         'lock_padding' => '',
      )),
       'current_property' => 'lock_padding',
    )),
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'usingNewAppearance' => true,
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
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
  'wrapper_id' => 'wrapper-1452647622815-1959',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 7,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$workplace_wellness->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453437458958-1504 upfront-module-spacer',
  'id' => 'module-1453437458958-1504',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453437458957-1186',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453437458958-1243',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
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
      'hide' => 0,
      'left' => 0,
      'col' => 5,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$workplace_wellness->add_element("Uspacer", array (
  'columns' => '13',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452647642685-1330 upfront-module-spacer',
  'id' => 'module-1452647642685-1330',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1452647642684-1279',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452647642685-1539',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$workplace_wellness->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452647629581-1828',
  'id' => 'module-1452647629581-1828',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: left;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1452647629581-1993',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'row' => 11,
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'row' => 10,
      )),
       'current_property' => 'bottom_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '30',
         'bottom_padding_num' => '30',
         'row' => 12,
      )),
    )),
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'usingNewAppearance' => true,
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
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
  'wrapper_id' => 'wrapper-1452647632644-1463',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 7,
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
      0 => 'col',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 10,
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
));

$workplace_wellness->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453437405892-1086 upfront-module-spacer',
  'id' => 'module-1453437405892-1086',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453437405891-1952',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453437405892-1673',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
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
      'hide' => 0,
      'left' => 0,
      'col' => 5,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$workplace_wellness->add_element("Uspacer", array (
  'columns' => '13',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452647649313-1242 upfront-module-spacer',
  'id' => 'module-1452647649313-1242',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1452647649313-1958',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452647649313-1776',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$regions->add($workplace_wellness);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
