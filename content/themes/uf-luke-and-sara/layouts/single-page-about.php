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
  'row' => 220,
  'background_type' => 'color',
  'background_color' => '#ufc5',
  'nav_region' => '',
  'breakpoint' =>
  (array)(array(
     'custom-1410783042947' =>
    (array)(array(
       'edited' => false,
    )),
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 430,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 380,
    )),
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-about/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'region_role' => 'main',
)
			);

$luke_and_sara->add_group(array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432081577214-1560',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1428705152908-1478',
  'original_col' => 12,
  'version' => '1.0.0',
  'top_padding_num' => '10',
  'bottom_padding_num' => '100',
  'row' => 215,
  'lock_padding' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '100',
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '10',
  'href' => '',
  'linkTarget' => false,
  'left_padding_num' => 0,
  'right_padding_num' => 0,
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
      'top' => 0,
      'row' => 210,
      'bottom_padding_slider' => '50',
      'bottom_padding_num' => '50',
      'bottom_padding_use' => 'yes',
      'background_color' => 'rgba(168,144,132,0)',
      'use_padding' => 'yes',
      'lock_padding' => '',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 177,
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_num' => '0',
      'bottom_padding_slider' => '0',
      'background_color' => 'rgba(168,144,132,0)',
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$luke_and_sara->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1432051781221-1044',
  'id' => 'module-1432051781221-1044',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-about/img-luke-540x540-6013.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-about/img-luke.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-about/img-luke.jpg',
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
       'width' => 540,
       'height' => 540,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 540,
       'height' => 540,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 540,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 142,
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
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1432051781216-1188',
    'anchor' => '',
    'theme_style' => '',
    'row' => 120,
    'no_padding' => '1',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 63,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
      )),
       'tablet' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 108,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '60',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_slider' => '60',
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
  'wrapper_id' => 'wrapper-1432084336992-1611',
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
      'top' => 0,
      'row' => 108,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 63,
      'top' => 0,
    ),
  ),
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428703752491-1223',
  'id' => 'module-1428703752491-1223',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="">Luke</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428703752490-1357',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 9,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 18,
         'theme_style' => 'text-center',
         'top_padding_use' => 'yes',
         'top_padding_num' => '55',
         'use_padding' => 'yes',
         'top_padding_slider' => '55',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'top_padding_use' => 'yes',
         'top_padding_num' => '40',
         'lock_padding' => '',
         'top_padding_slider' => '40',
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '20',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'breakpoint_presets' =>
    array (
    ),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432084337010-1044',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 18,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
  ),
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-94453 upfront-module-spacer',
  'id' => 'module-1451189295-94453',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-59744',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-94326',
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
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428703775912-1685',
  'id' => 'module-1428703775912-1685',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h4 class=""><span rel="color: rgb(102, 102, 102); font-family: Verdana, Geneva, sans-serif; font-size: 10px; font-weight: normal; text-transform: none; background-color: rgb(255, 255, 255);" data-verified="redactor" data-redactor-tag="span"><span class="upfront_theme_color_1">The exquisite relationship between the man, the camera lens and the subject, have made Luke Brown a Master Photographer. His images capture our dreams!</span></span><br><span rel="color: rgb(84, 84, 84); font-family: arial, sans-serif; font-size: small; font-weight: normal; line-height: 16.5455px; text-transform: none; background-color: rgb(255, 255, 255);" data-verified="redactor" data-redactor-tag="span"></span></h4>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428703775912-1630',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 28,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 26,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
         'row' => 41,
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '30',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432084337016-1733',
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
      'row' => 26,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 41,
    ),
  ),
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-43258 upfront-module-spacer',
  'id' => 'module-1451189295-43258',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-1223',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-2303',
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
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-92232 upfront-module-spacer',
  'id' => 'module-1451189295-92232',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-49141',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-96974',
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
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452736976597-1735 upfront-module-spacer',
  'id' => 'module-1452736976597-1735',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452736976596-1826',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452736976597-1855',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 3,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428703803634-1228',
  'id' => 'module-1428703803634-1228',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud.&nbsp;exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428703803634-1653',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 26,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 47,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_slider' => '0',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432084337023-1042',
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
      'col' => 10,
      'order' => 0,
      'row' => 47,
      'top' => 0,
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
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454457948847-1201 upfront-module-spacer',
  'id' => 'module-1454457948847-1201',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454457948845-1575',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454457948846-1181',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
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
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1432081577214-1560',
));

$luke_and_sara->add_group(array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432075248893-1390',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1428705001213-1995',
  'original_col' => 12,
  'row' => 210,
  'version' => '1.0.0',
  'top_padding_num' => '10',
  'bottom_padding_num' => '100',
  'lock_padding' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '100',
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '10',
  'href' => '',
  'linkTarget' => false,
  'left_padding_num' => 0,
  'right_padding_num' => 0,
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
      'row' => 208,
      'bottom_padding_use' => 'yes',
      'background_color' => 'rgba(168,144,132,0)',
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_slider' => '50',
      'bottom_padding_num' => '50',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 180,
      'top_padding_use' => 'yes',
      'top_padding_num' => '40',
      'lock_padding' => '',
      'top_padding_slider' => '40',
      'bottom_padding_use' => 'yes',
      'bottom_padding_num' => '40',
      'bottom_padding_slider' => '40',
      'background_color' => 'rgba(168,144,132,0)',
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$luke_and_sara->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1432073503055-1401',
  'id' => 'module-1432073503055-1401',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-about/img-sara-540x540-8441.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-about/img-sara.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-about/img-sara.jpg',
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
       'width' => 540,
       'height' => 540,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 540,
       'height' => 540,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 540,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 143,
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
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1432073503048-1713',
    'anchor' => '',
    'theme_style' => '',
    'no_padding' => '1',
    'top_padding_num' => '0',
    'bottom_padding_num' => '60',
    'row' => 120,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '60',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 56,
      )),
       'tablet' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'row' => 108,
      )),
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
  'wrapper_id' => 'wrapper-1432075257166-1118',
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
      'top' => 0,
      'row' => 108,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 56,
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428703878545-1545',
  'id' => 'module-1428703878545-1545',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1>Sara</h1>


',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428703878545-1457',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 9,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 22,
         'theme_style' => 'text-center',
         'top_padding_use' => 'yes',
         'top_padding_num' => '55',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '55',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'top_padding_use' => 'yes',
         'top_padding_num' => '40',
         'lock_padding' => '',
         'top_padding_slider' => '40',
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'current_property' => 'top_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '20',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432075257183-1856',
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
      'row' => 13,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-76689 upfront-module-spacer',
  'id' => 'module-1451189295-76689',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-94840',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-30533',
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
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737006485-1380 upfront-module-spacer',
  'id' => 'module-1452737006485-1380',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737006484-1555',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737006485-1608',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 2,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428704222445-1036',
  'id' => 'module-1428704222445-1036',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h4 class=""><span rel="color: rgb(102, 102, 102); font-family: Verdana, Geneva, sans-serif; font-size: 10px; font-weight: normal; text-transform: none; background-color: rgb(255, 255, 255);" data-verified="redactor" data-redactor-tag="span"><span class="upfront_theme_color_1">Every wedding is different, every wedding is unique. My philosophy is, it\'s not about me; it\'s about you, by telling your love story through my photographs.</span></span><br></h4>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428704222444-1632',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 26,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 27,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
         'row' => 41,
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '30',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432075257189-1073',
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
      'col' => 10,
      'order' => 0,
      'row' => 27,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 41,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454458013824-1790 upfront-module-spacer',
  'id' => 'module-1454458013824-1790',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454458013824-1413',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454458013824-1336',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 2,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
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
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-6639 upfront-module-spacer',
  'id' => 'module-1451189295-6639',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-29427',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-8940',
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
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-12071 upfront-module-spacer',
  'id' => 'module-1451189295-12071',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-71471',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-86097',
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
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737010084-1697 upfront-module-spacer',
  'id' => 'module-1452737010084-1697',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737010083-1555',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737010083-1958',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 3,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428704315734-1875',
  'id' => 'module-1428704315734-1875',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis.&nbsp;nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit&nbsp;</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428704315733-1353',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 29,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 38,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 44,
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432075257194-1997',
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
      'col' => 10,
      'order' => 0,
      'row' => 38,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 44,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454458016705-1824 upfront-module-spacer',
  'id' => 'module-1454458016705-1824',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1454458016704-1048',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1454458016705-1959',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
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
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1432075248893-1390',
));

$luke_and_sara->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-3638 upfront-module-spacer',
  'id' => 'module-1451189295-3638',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-18346',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-17950',
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
  'group' => 'module-group-1432075248893-1390',
));

$regions->add($luke_and_sara);

$testimonials_area = upfront_create_region(
			array (
  'name' => 'testimonials-area',
  'title' => 'Testimonials Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'testimonials-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 76,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_position_y' => '50',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '85',
       'top_bg_padding_slider' => '85',
       'bottom_bg_padding_num' => '0',
       'bottom_bg_padding_slider' => '0',
       'row' => 83,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 100,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_num' => '0',
       'bottom_bg_padding_slider' => '0',
    )),
     'current_property' => 'bottom_bg_padding_slider',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-about/bg-testimonials.jpg',
  'background_image_ratio' => 0.299999999999999988897769753748434595763683319091796875,
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '90',
  'top_bg_padding_num' => '90',
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => '0',
  'bg_padding_num' => '0',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'background_default' => 'hide',
  'featured_fallback_background_color' => '#ffffff',
  'region_role' => 'complementary',
)
			);

$testimonials_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452735623714-1757 upfront-module-spacer',
  'id' => 'module-1452735623714-1757',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452735623713-1573',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452735623714-1170',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$testimonials_area->add_element("Code", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452735187335-1549',
  'id' => 'module-1452735187335-1549',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'upfront-code_element-object-1452735187333-1530',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'code_selection_type' => 'Create',
    'markup' => '<div id="testimonials">

    <!-- Slider Setup -->
    <input type="radio" name="testimonial" id="testimonial1" selected="true">
    <input checked="" type="radio" name="testimonial" id="testimonial2" selected="false">
    <input type="radio" name="testimonial" id="testimonial3" selected="false">

    <!-- CSS3 Slider -->
    <div id="slides">

        <div id="overflow">

            <div class="inner">

                <article class="editable"><div class="info nosortable">
                        <h6>Dr Seuss</h6>
                        <blockquote>You know you\'re in love when you can\'t fall asleep because reality is finally better than your dreams.</blockquote>
                    </div></article>

                <article class="editable">
                    <div class="info">
                        <h6>Socrates</h6>
                        <blockquote>My advice to you is get married; if you find a good wife you\'ll be happy; if not, you\'ll become a philosopher.</blockquote>
                    </div>
                </article>

                <article class="editable">
                    <div class="info">
                        <h6>Jack N.</h6>
                        <blockquote>My philosphy; live today. Do not leave undone things you really want to do, even if they seem a bad idea.</blockquote>
                    </div>
                </article>

            </div><!-- .inner -->

        </div><!-- #overflow -->

    </div><!-- #slides -->

    <div id="active">

        <label for="testimonial1"><img class="editable" src="{{upfront:style_url}}/ui/img-bill.png"></label>
        <label for="testimonial2"><img class="editable" src="{{upfront:style_url}}/ui/img-socrates.png"></label>
        <label for="testimonial3"><img class="editable" src="{{upfront:style_url}}/ui/img-jack.png"></label>

    </div><!-- #active -->

</div><!-- #testimonials -->',
    'style' => '#testimonials {
    width: 100%;
    height: auto;
    display: block;
    position: relative;
    margin: 0 auto;
    text-align: center;
    padding: 0 20px;
}
/* Slider Setup */
#testimonials input {
    display: none;
}
#testimonial1:checked ~ #slides .inner {
    margin-left: 0;
}
#testimonial2:checked ~ #slides .inner {
    margin-left:-100%;
}
#testimonial3:checked ~ #slides .inner {
    margin-left:-200%;
}
#overflow {
    width: 100%;
    overflow: hidden;
}
#slides .inner {
    width: 500%;
    line-height: 0;
}
#slides article {
    width: 20%;
    float: left;
}
/* Active Setup */
#active {
    margin: 30px 0 0;
    text-align: center;
}
#active label {
    width: 45px;
    height: 45px;
    display: inline-block;
    margin-right: 18px;
    border: 2px solid #acacac;
    border-radius: 100%;
    -moz-border-radius: 100%;
    -webkit-border-radius: 100%;
}
#active label:last-child {
    margin-right: 0;
}
#active label:hover {
    border-color: #007051;
    cursor: pointer;
}
#active label img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 100%;
    -moz-border-radius: 100%;
    -webkit-border-radius: 100%;
}
#testimonial1:checked ~ #active label:nth-child(1),
#testimonial2:checked ~ #active label:nth-child(2),
#testimonial3:checked ~ #active label:nth-child(3) {
    border-color: #01bc9d !important;
}
#testimonial1:checked ~ #active label:nth-child(1):hover,
#testimonial2:checked ~ #active label:nth-child(2):hover,
#testimonial2:checked ~ #active label:nth-child(3):hover {
    border-color: #007051 !important;
}
/* Slider and Slides Styling */
#slides {
    margin: 0;
}
#slides .info,
#slides .info h1,
#slides .info h2,
#slides .info h3,
#slides .info h4,
#slides .info h5,
#slides .info h6,
#slides .info p {
    margin-top: 0;
    margin-bottom: 0.4em;
    color: #01bc9d;
    font-family: "Quattrocento Sans";
    font-weight: 400;
    font-style: normal;
    font-weight: 700;
    text-transform: none;
    padding: 0 20px;
}
.info blockquote {
    margin-top: 0;
    margin-bottom: 0;
    color: #ffffff;
    line-height: 1.286em;
    font-weight: 700;
    letter-spacing: -0.7px;
}
.info blockquote:before, .info blockquote:after {
    content: "";
    width: 14px;
    height: 36px;
    display: inline-block;
    vertical-align: top;
    background: url("{{upfront:style_url}}/ui/sprites-v2.png") no-repeat;
    background-image: url("{{upfront:style_url}}/ui/sprites-v2.svg"), none;
}
.info blockquote:before {
    margin-right: 10px;
    background-position: -393px -223px;
}
.info blockquote:after {
    margin-left: 10px;
    background-position: -393px -388px;
}
/* Animation */
#slider {
    transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
    -ms-transition: all 0.5s ease-out;
    -moz-transition: all 0.5s ease-out;
    -webkit-transition: all 0.5s ease-out;
}
#slides .inner {
    -webkit-transform: translateZ(0);
    transition: all 800ms cubic-bezier(0.770, 0.000, 0.175, 1.000); /* easeInOutQuart */
    -o-transition: all 800ms cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -ms-transition: all 800ms cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -moz-transition: all 800ms cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -webkit-transition: all 800ms cubic-bezier(0.770, 0.000, 0.175, 1.000);
    transition-timing-function: cubic-bezier(0.770, 0.000, 0.175, 1.000); /* easeInOutQuart */
    -o-transition-timing-function: cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -ms-transition-timing-function: cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -moz-transition-timing-function: cubic-bezier(0.770, 0.000, 0.175, 1.000);
    -webkit-transition-timing-function: cubic-bezier(0.770, 0.000, 0.175, 1.000);
}
#testimonial1:checked ~ #slides article:nth-child(1) .info,
#testimonial2:checked ~ #slides article:nth-child(2) .info,
#testimonial3:checked ~ #slides article:nth-child(3) .info {
    opacity: 1;
    transition: all 1s ease-out 0.6s;
    -o-transition: all 1s ease-out 0.6s;
    -ms-transition: all 1s ease-out 0.6s;
    -moz-transition: all 1s ease-out 0.6s;
    -webkit-transition: all 1s ease-out 0.6s;
}
#slides, .info, .info p, .info blockquote, #active, #active label {
    -webkit-transform: translateZ(0);
    transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
    -ms-transition: all 0.5s ease-out;
    -moz-transition: all 0.5s ease-out;
    -webkit-transition: all 0.5s ease-out;
}',
    'script' => '/* Your code here */',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452735357220-1629',
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

$testimonials_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452735628679-1519 upfront-module-spacer',
  'id' => 'module-1452735628679-1519',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452735628679-1134',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452735628679-1142',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$regions->add($testimonials_area);

$our_studio_area = upfront_create_region(
			array (
  'name' => 'our-studio-area',
  'title' => 'Our Studio Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'our-studio-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 36,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 81,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 105,
    )),
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ffffff',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-about/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '10',
  'top_bg_padding_num' => '10',
  'bottom_bg_padding_slider' => '10',
  'bottom_bg_padding_num' => '10',
  'bg_padding_slider' => '10',
  'bg_padding_num' => '10',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'background_default' => 'hide',
  'featured_fallback_background_color' => '#ffffff',
  'region_role' => 'complementary',
)
			);

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-9519 upfront-module-spacer',
  'id' => 'module-1451189295-9519',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-65083',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451189295-48408',
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

$our_studio_area->add_group(array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451407911116-1741',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1432077576977-1434',
  'original_col' => 23,
  'top_padding_num' => '90',
  'bottom_padding_num' => '90',
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '90',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '90',
  'row' => 48,
  'use_padding' => 'yes',
  'href' => '',
  'linkTarget' => false,
  'left_padding_num' => 0,
  'right_padding_num' => 0,
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
      'row' => 59,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '40',
      'top_padding_slider' => '40',
      'bottom_padding_use' => 'yes',
      'bottom_padding_num' => '50',
      'bottom_padding_slider' => '50',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '50',
      'top_padding_slider' => '50',
      'bottom_padding_use' => 'yes',
      'bottom_padding_num' => '10',
      'bottom_padding_slider' => '10',
      'row' => 61,
      'use_padding' => 'yes',
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$our_studio_area->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428705687404-1133',
  'id' => 'module-1428705687404-1133',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428705687404-1236',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 21,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 28,
         'theme_style' => 'text-center',
         'top_padding_use' => true,
         'top_padding_num' => 50,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 56,
         'top_padding_use' => 'yes',
         'top_padding_num' => '20',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '20',
      )),
       'current_property' => 'top_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'breakpoint_presets' =>
    array (
    ),
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451407911121-1576',
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
      'row' => 28,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 56,
    ),
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-68263 upfront-module-spacer',
  'id' => 'module-1451189295-68263',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-59409',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451407911123-1286',
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
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737072746-1764 upfront-module-spacer',
  'id' => 'module-1452737072746-1764',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737072745-1220',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737072746-1854',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 2,
    ),
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737325117-1685 upfront-module-spacer',
  'id' => 'module-1452737325117-1685',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737325116-1615',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737325117-1100',
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
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1432075072580-1098',
  'id' => 'module-1432075072580-1098',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-about/lukeSaraLogo-416x130-2235.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-about/lukeSaraLogo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-about/lukeSaraLogo.png',
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
       'width' => 416,
       'height' => 130,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 464,
       'height' => 145,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -7,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 430,
       'height' => 130,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1947,
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
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1432075072575-1477',
    'row' => 26,
    'anchor' => '',
    'theme_style' => 'no-padding',
    'no_padding' => '1',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 23,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
      )),
       'mobile' =>
      (array)(array(
         'row' => 15,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
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
  'wrapper_id' => 'wrapper-1451407911127-1883',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 8,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
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
      'col' => 8,
      'order' => 0,
      'row' => 23,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'row' => 15,
      'top' => 0,
    ),
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737328181-1799 upfront-module-spacer',
  'id' => 'module-1452737328181-1799',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737328180-1469',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737328181-1495',
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
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737076173-1851 upfront-module-spacer',
  'id' => 'module-1452737076173-1851',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737076172-1500',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737076173-1074',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 2,
    ),
  ),
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451189295-68486 upfront-module-spacer',
  'id' => 'module-1451189295-68486',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451189295-60712',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451407911130-1799',
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
  'group' => 'module-group-1451407911116-1741',
));

$our_studio_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452737431839-1456 upfront-module-spacer',
  'id' => 'module-1452737431839-1456',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452737431838-1534',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452737431839-1283',
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

$regions->add($our_studio_area);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
