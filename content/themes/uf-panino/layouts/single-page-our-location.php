<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php');

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 44,
  'background_type' => 'image',
  'background_color' => '#ufc5',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 32,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 36,
    )),
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-our-location/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-55726 upfront-module-spacer',
  'id' => 'module-1450867999-55726',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-80800',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-2665',
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

$main->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445483928725-1160',
  'id' => 'module-1445483928725-1160',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;">Find Us</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1445483928724-1996',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'row' => 36,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => '',
      )),
       'mobile' =>
      (array)(array(
         'row' => 11,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 105,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'u-section-title-m',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-section-title-m',
      )),
    )),
    'current_preset' => 'u-section-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445483973110-1574',
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
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 11,
      'top' => 0,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-93095 upfront-module-spacer',
  'id' => 'module-1450867999-93095',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-93153',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-32587',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-43335 upfront-module-spacer',
  'id' => 'module-1450867999-43335',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-47979',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-31261',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-66477 upfront-module-spacer',
  'id' => 'module-1450867999-66477',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-54077',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-10263',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 1,
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 1,
      'edited' => true,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-14384 upfront-module-spacer',
  'id' => 'module-1450867999-14384',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-92185',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-40099',
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

$main->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429598218239-1669',
  'id' => 'module-1429598218239-1669',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-our-location/home-contacts-map-420x420-8420.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-our-location/home-contacts-map.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-our-location/home-contacts-map.png',
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
       'width' => 420,
       'height' => 420,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 424,
       'height' => 424,
       'top' => 130,
       'left' => 699,
    )),
    'position' =>
    (array)(array(
       'top' => -35,
       'left' => 0,
    )),
    'marginTop' => 35,
    'element_size' =>
    (array)(array(
       'width' => 420,
       'height' => 455,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 850,
    'align' => 'center',
    'stretch' => true,
    'vstretch' => false,
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
    'element_id' => 'image-1429598218237-1901',
    'row' => 106,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 33,
         'top_padding_use' => true,
         'top_padding_num' => 30,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 60,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429598250975-1845',
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
      'col' => 10,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 1,
      'row' => 30,
      'top' => 0,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-71984 upfront-module-spacer',
  'id' => 'module-1450867999-71984',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-46499',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-43110',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-48051 upfront-module-spacer',
  'id' => 'module-1450867999-48051',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-31506',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-16315',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 1,
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 1,
      'edited' => true,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-31035 upfront-module-spacer',
  'id' => 'module-1450867999-31035',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-59139',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-85399',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 1,
      'edited' => true,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-94184 upfront-module-spacer',
  'id' => 'module-1450867999-94184',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-93851',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-18891',
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

$main->add_group(array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1446095854029-1671',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1429598303861-1674',
  'original_col' => 9,
  'row' => 102,
  'top_padding_use' => true,
  'top_padding_num' => 135,
  'version' => '1.0.0',
  'bottom_padding_num' => '15',
  'use_padding' => 'yes',
  'left_padding_num' => '15',
  'right_padding_num' => '15',
  'lock_padding' => 0,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 2,
      'clear' => false,
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
      'col' => 10,
      'order' => 0,
      'top' => 0,
      'row' => 73,
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
      'row' => 69,
      'top_padding_use' => true,
      'top_padding_num' => 25,
    ),
  ),
));

$main->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429598218236-1765',
  'id' => 'module-1429598218236-1765',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h4 class="" style="text-align: center;"><span class="upfront_theme_color_6">PANiNO</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429598218236-1846',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 14,
    'is_edited' => true,
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
         'row' => 12,
      )),
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'u-brand-title-m',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-brand-title-m',
      )),
    )),
    'current_preset' => 'u-brand-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446095857728-1655',
  'new_line' => true,
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
      'col' => 10,
      'order' => 0,
      'top' => 0,
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
  ),
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429598303949-1113',
  'id' => 'module-1429598303949-1113',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h5 class="" style="text-align: center;">305 Lygon Street,&nbsp;Carlton VIC 3053</h5>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429598303949-1053',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 12,
    'is_edited' => true,
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
         'row' => 11,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'left_padding_num' => '15',
         'left_padding_use' => '',
         'right_padding_num' => '15',
         'right_padding_use' => '',
         'top_padding_num' => '15',
         'bottom_padding_num' => '15',
         'top_padding_use' => '',
         'bottom_padding_use' => '',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446095857743-1790',
  'new_line' => true,
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
      'col' => 10,
      'order' => 0,
      'top' => 0,
      'row' => 11,
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
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450868000-86293 upfront-module-spacer',
  'id' => 'module-1450868000-86293',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450868000-39713',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450868000-90555',
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
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429598356150-1968',
  'id' => 'module-1429598356150-1968',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">. . . . . . . . . . . . . . . . . . . . . . . . . . . . .</p>
',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429598356150-1915',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 13,
    'is_edited' => true,
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
         'row' => 4,
      )),
       'mobile' =>
      (array)(array(
         'row' => 8,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'u-bullets-m',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-bullets-m',
      )),
    )),
    'current_preset' => 'u-bullets-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446095857748-1545',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 2,
      'clear' => false,
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
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
  ),
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450868000-17800 upfront-module-spacer',
  'id' => 'module-1450868000-17800',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450868000-55028',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450868000-57032',
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
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429598376452-1278',
  'id' => 'module-1429598376452-1278',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">Phone: (03) 9876 5431<br>Fax: (03) 9876 5432<br>General Orders : (03) 9347 2801</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429598376451-1248',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 27,
    'is_edited' => true,
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
         'row' => 23,
         'top_padding_use' => true,
         'top_padding_num' => 25,
      )),
       'mobile' =>
      (array)(array(
         'row' => 20,
         'theme_style' => '',
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'default',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446095857753-1168',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'col' => 10,
      'order' => 0,
      'row' => 21,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 20,
      'top' => 0,
    ),
  ),
  'group' => 'module-group-1446095854029-1671',
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-10522 upfront-module-spacer',
  'id' => 'module-1450867999-10522',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-52398',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-31639',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867999-34158 upfront-module-spacer',
  'id' => 'module-1450867999-34158',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867999-93460',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867999-99358',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 1,
      'edited' => true,
    ),
  ),
));

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
