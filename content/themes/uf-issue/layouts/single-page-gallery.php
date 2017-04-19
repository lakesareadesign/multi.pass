<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$breadcrumbs = upfront_create_region(
			array (
  'name' => 'breadcrumbs',
  'title' => 'Breadcrumbs',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'breadcrumbs',
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
  'top_bg_padding_slider' => '4',
  'top_bg_padding_num' => '4',
  'bottom_bg_padding_slider' => '15',
  'bottom_bg_padding_num' => '15',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc6',
  'region_role' => 'complementary',
)
			);

$breadcrumbs->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470546467280-1103 upfront-module-spacer',
  'id' => 'module-1470546467280-1103',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470546467279-1389',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470546467279-1841',
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

$breadcrumbs->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470546392830-1640',
  'id' => 'module-1470546392830-1640',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6 style="text-align: right;"><a href="{{upfront:home_url}}" target="_self" data-upfront-link-type="homepage">Home</a> <span class="upfront_theme_color_7">/</span> Gallery</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1470546392829-1106',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 5,
    'current_preset' => 'default',
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
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470546439259-1441',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 1,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
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
      'col' => 12,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$breadcrumbs->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470546465153-1478 upfront-module-spacer',
  'id' => 'module-1470546465153-1478',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470546465152-1392',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470546465152-1329',
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

$regions->add($breadcrumbs);

$block_title = upfront_create_region(
			array (
  'name' => 'block-title',
  'title' => 'Block Title',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'block-title',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 14,
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
       'background_type' => 'color',
       'row' => 6,
       'bottom_bg_padding_num' => '20',
       'bottom_bg_padding_slider' => '20',
    )),
     'current_property' => 'bottom_bg_padding_slider',
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
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc6',
  'region_role' => 'main',
)
			);

$block_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461788575317-1472 upfront-module-spacer',
  'id' => 'module-1461788575317-1472',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461788575317-1852',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461788575315-1552',
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

$block_title->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461788328004-1627',
  'id' => 'module-1461788328004-1627',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2><span class="upfront_theme_bg_color_6" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_bg_color_6">&nbsp;&nbsp;<span class="upfront_theme_color_1">GALLERY </span>&nbsp;</span></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1461788328004-1600',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'box-title',
    'padding_slider' => '15',
    'top_padding_num' => '13',
    'bottom_padding_num' => '30',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'box-title',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'box-title',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'box-title',
      )),
    )),
    'row' => 6,
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '25',
         'bottom_padding_num' => '25',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'row' => 4,
      )),
    )),
    'current_preset' => 'box-title',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1461788467788-1819',
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
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$block_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461788577184-1830 upfront-module-spacer',
  'id' => 'module-1461788577184-1830',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461788577184-1116',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461788577184-1829',
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

$regions->add($block_title);

$block_banner = upfront_create_region(
			array (
  'name' => 'block-banner',
  'title' => 'Block Banner',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'block-banner',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 31,
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
  'background_color' => '#ufc6',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-gallery/issue-bg-about.jpg',
  'background_image_ratio' => 0.2300000000000000099920072216264088638126850128173828125,
  'region_role' => 'main',
)
			);

$block_banner->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466810717445-1608 upfront-module-spacer',
  'id' => 'module-1466810717445-1608',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466810717445-1423',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466810717445-1561',
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

$block_banner->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461788467919-1231',
  'id' => 'module-1461788467919-1231',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class=""><span style="color:rgb(131, 142, 141)" rel="color:rgb(131, 142, 141)" data-verified="redactor" data-redactor-tag="span" data-redactor-style="color:rgb(131, 142, 141)">Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.&nbsp;</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1461788467919-1184',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'row' => 23,
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
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
  'wrapper_id' => 'wrapper-1461805628938-1010',
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
      'edited' => true,
      'col' => 7,
      'order' => 0,
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$block_banner->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466810605642-1092',
  'id' => 'module-1466810605642-1092',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class=""><span style="color:rgb(131, 142, 141)" rel="color:rgb(131, 142, 141)" data-verified="redactor" data-redactor-tag="span" data-redactor-style="color:rgb(131, 142, 141)">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex eaconsequat.</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1466810605642-1964',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 24,
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
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466810712461-1415',
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
      'edited' => true,
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$block_banner->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466810719887-1208 upfront-module-spacer',
  'id' => 'module-1466810719887-1208',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466810719887-1644',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466810719886-1574',
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

$regions->add($block_banner);

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 103,
  'background_type' => 'color',
  'background_color' => '#ufc6',
  'version' => '1.0.0',
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
       'background_type' => 'color',
       'bottom_bg_padding_num' => '10',
       'bottom_bg_padding_slider' => '10',
       'top_bg_padding_num' => '10',
       'top_bg_padding_slider' => '10',
    )),
     'current_property' => 'top_bg_padding_slider',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '30',
  'top_bg_padding_num' => '30',
  'bottom_bg_padding_slider' => '80',
  'bottom_bg_padding_num' => '80',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472863543532-1367 upfront-module-spacer',
  'id' => 'module-1472863543532-1367',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472863543532-1676',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472863543532-1299',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
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
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472864267315-1295 upfront-module-spacer',
  'id' => 'module-1472864267315-1295',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472864267315-1031',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472864267314-1648',
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
  ),
));

$main->add_element("Ugallery", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472863530562-1898',
  'id' => 'module-1472863530562-1898',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'preset' => 'gallery-alternative',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => 121,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-tech-190x190-3621.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-tech-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-tech-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-tech-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-tech-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-tech-140x140-9635.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 140,
               'height' => 140,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '140',
                 'height' => '140',
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 234377,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'left' => 48,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 48,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-tech.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => 122,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-work-190x190-5476.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-work-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-work-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-work-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-work-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-work-190x190-5476.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234378,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-work.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => 123,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-190x190-4764.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee-190x190-4764.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234379,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-coffee.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => 124,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-190x190-8708.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity-190x190-8708.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234380,
               'element_id' => 'ugallery-object-1472863530561-1851',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-creativity.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => 125,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-blur-190x190-2051.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-blur-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-blur-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-blur-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-blur-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-blur-190x190-2051.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234382,
               'element_id' => 'ugallery-object-1472863530561-1851',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-blur.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => 126,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-190x190-3923.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
            1 => 1280,
            2 => 853,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile-190x190-3923.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 853,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234383,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-mobile.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => 127,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-190x190-3103.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-300x205.jpg',
            1 => 300,
            2 => 205,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-768x525.jpg',
            1 => 768,
            2 => 525,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-1024x700.jpg',
            1 => 1024,
            2 => 700,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
            1 => 1280,
            2 => 875,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless-190x190-3103.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
             'full' =>
            (array)(array(
               'width' => 1280,
               'height' => 875,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 44,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 278,
                 'height' => 190,
              )),
               'id' => 234384,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 278,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 44,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-wireless.jpg',
         'imageLinkTarget' => '',
      )),
      7 =>
      (array)(array(
         'id' => 128,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-190x190-1389.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
            1 => 1024,
            2 => 683,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration-190x190-1389.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
             'full' =>
            (array)(array(
               'width' => 1024,
               'height' => 683,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 234385,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1472863530561-1851',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-inspiration.jpg',
         'imageLinkTarget' => '',
      )),
    ),
    'elementSize' =>
    (array)(array(
       'width' => 0,
       'height' => 0,
    )),
    'labelFilters' => 'true',
    'thumbProportions' => '1',
    'thumbWidth' => '190',
    'thumbHeight' => 190,
    'thumbWidthNumber' => '190',
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
    'thumbPadding' => '30',
    'sidePadding' => 15,
    'bottomPadding' => 15,
    'thumbPaddingNumber' => '30',
    'thumbSidePaddingNumber' => 15,
    'thumbBottomPaddingNumber' => 15,
    'lockPadding' => 'yes',
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
    'styles' => '

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-gallery {
    transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -webkit-transform-style: preserve-3d;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-close {
    width: 48px !important;
    height: 48px !important;
    cursor: pointer;
    top: 15px !important;
    right: 15px !important;
    border-radius: 100%;
    -moz-border-radius: 100%;
    -webkit-border-radius: 100%;
    background: url("//vowels.dev/wp-content/themes/uf-issue/ui/sprite.png") no-repeat center transparent;
    background-image: url("//vowels.dev/wp-content/themes/uf-issue/ui/sprite.svg"), none;
    background-position: -216px -536px;
    color: transparent;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .glb-content-container {
    width: 100%;
    max-width: 880px;
    margin: 0 auto;
    padding: 0;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .glb-content-container .mfp-img {
    width: 100% !important;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .glb-caption-container {
    min-height: 65px;
    position: relative;
    margin-top: 0;
    padding: 20px;
    background: #ufc8;
    transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -webkit-transform-style: preserve-3d;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-title {
    padding-right: 80px;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-title, .mfp-title p {
    color: #373d3c;
    font: 300 18px/25px "Lato", sans-serif;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-counter {
    display: block;
    position: absolute;
    top: 50%;
    right: 30px;
    transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    color: #ufc2 !important;
    font: 300 18px/20px "Lato", sans-serif;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-left, .mfp-arrow-right {
    height: 48px;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-left {
    left: 10%;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-right {
    right: 10%;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-left:before, .mfp-arrow-right:before {
    width: 48px;
    height: 48px;
    margin-top: 0;
    border: 0;
    background: url("//vowels.dev/wp-content/themes/uf-issue/ui/sprite.png") no-repeat center transparent;
    background-image: url("//vowels.dev/wp-content/themes/uf-issue/ui/sprite.svg"), none;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-left:before {
    background-position: -376px -536px;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-right:before {
    background-position: -536px -536px;
}

.gallery-ugallery-object-1472863530561-1851-lightbox .mfp-arrow-left:after,
.mfp-arrow-right:after {
    display: none;
}',
    'element_id' => 'ugallery-object-1472863530561-1851',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '25',
    'right_padding_num' => '25',
    'anchor' => '',
    'current_preset' => 'gallery-alternative',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'gallery-alternative',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'gallery-alternative-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'gallery-alternative-mobile',
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
         'left_padding_num' => '15',
         'left_padding_use' => 'yes',
         'right_padding_num' => '15',
         'right_padding_use' => 'yes',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1472863540987-1823',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'col' => 10,
      'order' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
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
      'col' => 10,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472864270680-1850 upfront-module-spacer',
  'id' => 'module-1472864270680-1850',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472864270680-1671',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472864270679-1450',
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
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472863545656-1788 upfront-module-spacer',
  'id' => 'module-1472863545656-1788',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472863545656-1370',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472863545656-1378',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
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
  ),
));

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
