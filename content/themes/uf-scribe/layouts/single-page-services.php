<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$services_header = upfront_create_region(
			array (
  'name' => 'services-header',
  'title' => 'Services Header',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'services-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 76,
  'background_type' => 'image',
  'background_color' => '#c5d0db',
  'nav_region' => '',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-services/services.jpg',
  'background_image_ratio' => 0.34999999999999998,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 47,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 42,
    )),
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
)
			);

$services_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-11049 upfront-module-spacer',
  'id' => 'module-1449776269-11049',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-35371',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-25568',
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

$services_header->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414231843243-1900',
  'id' => 'module-1414231843243-1900',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 style="text-align: center;" class=""><span class="upfront_theme_color_0" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_0"><span class="upfront_theme_color_2">Scribe Services</span></span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414231843242-1629',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'row' => 45,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
         'top_padding_use' => true,
         'top_padding_num' => 90,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'top_padding_use' => true,
         'top_padding_num' => 65,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 165,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445817382347-1063',
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
      'top' => 0,
    ),
  ),
));

$services_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-37439 upfront-module-spacer',
  'id' => 'module-1449776269-37439',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-62840',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-91970',
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

$regions->add($services_header);

$services = upfront_create_region(
			array (
  'name' => 'services',
  'title' => 'Services',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'services',
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
  'nav_region' => '',
  'background_color' => 'rgba(255,255,255,0.75)',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$services->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-61737 upfront-module-spacer',
  'id' => 'module-1449776269-61737',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-78734',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-69319',
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

$services->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414233333415-1917',
  'id' => 'module-1414233333415-1917',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class="" style="text-align: center;"><span rel="font-family: Lato, sans-serif; font-size: 16px; font-weight: normal; line-height: 30px; text-transform: none; background-color: rgba(255, 255, 255, 0.74902);" data-verified="redactor">Scribes offers a wide range of bookbinding and finishing services.&nbsp;Custom bindings, business card edging, boxes, menus and restoration.</span><br></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414233333414-1507',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 66,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 38,
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 75,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1419224678948-1665',
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
      'row' => 38,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
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

$services->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-75573 upfront-module-spacer',
  'id' => 'module-1449776269-75573',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-34409',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-16538',
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

$regions->add($services);

$services_business_cards = upfront_create_region(
			array (
  'name' => 'services-business-cards',
  'title' => 'Services Business Cards',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'services-business-cards',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 54,
  'background_type' => 'color',
  'nav_region' => '',
  'background_color' => 'rgba(255,255,255,0.75)',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 98,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
  )),
  'version' => '1.0.0',
)
			);

$services_business_cards->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453879185299-1660',
  'id' => 'module-1453879185299-1660',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-services/_MG_7887-540x270-3032.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-services/_MG_7887.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-services/_MG_7887.jpg',
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
       'width' => 547,
       'height' => 365,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 655,
       'height' => 437,
    )),
    'position' =>
    (array)(array(
       'top' => 73,
       'left' => 1,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 270,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1831',
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
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'element_id' => 'image-1453879185295-1396',
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 54,
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 31,
      )),
    )),
    'current_preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453879233901-1470',
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
      'top' => 0,
      'row' => 31,
    ),
  ),
));

$services_business_cards->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453879298363-1816 upfront-module-spacer',
  'id' => 'module-1453879298363-1816',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453879298362-1230',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453879298363-1877',
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

$services_business_cards->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454636934644-1856',
  'id' => 'module-1454636934644-1856',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4>Business Cards</h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1454636934643-1629',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '30',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1419224698225-1491',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => true,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'order' => 0,
      'clear' => true,
      'edited' => true,
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
  'close_wrapper' => false,
));

$services_business_cards->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414233551274-1383',
  'id' => 'module-1414233551274-1383',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet do ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414233551273-1211',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'row' => 32,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 20,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1419224698225-1491',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 2,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 2,
      'top' => 0,
    ),
  ),
));

$regions->add($services_business_cards);

$customs_books = upfront_create_region(
			array (
  'name' => 'customs-books',
  'title' => 'Customs Books',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'customs-books',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 48,
  'background_type' => 'color',
  'nav_region' => '',
  'background_color' => 'rgba(247,247,247,1)',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 106,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
)
			);

$customs_books->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-89098 upfront-module-spacer',
  'id' => 'module-1449776269-89098',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-17721',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-32593',
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

$customs_books->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454636610192-1789',
  'id' => 'module-1454636610192-1789',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4>Custom Books</h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1454636610191-1528',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '50',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '50',
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
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '55',
         'top_padding_num' => '55',
      )),
       'current_property' => 'use_padding',
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1445647251585-1006',
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
  'close_wrapper' => false,
));

$customs_books->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414233668134-1811',
  'id' => 'module-1414233668134-1811',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est n a nobis eleifend option congue nihil imp otare quam littera gothica, quam nunc putamus.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1414233668135-1138',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 31,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 29,
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 41,
      )),
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445647251585-1006',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'row' => 29,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 1,
      'top' => 0,
      'row' => 41,
    ),
  ),
));

$customs_books->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-22316 upfront-module-spacer',
  'id' => 'module-1449776269-22316',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-76191',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-13994',
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

$customs_books->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414678713534-1826',
  'id' => 'module-1414678713534-1826',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-services/_MG_7750-544x300-1715.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-services/_MG_7750.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-services/_MG_7750.jpg',
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
       'width' => 549,
       'height' => 366,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 655,
       'height' => 437,
    )),
    'position' =>
    (array)(array(
       'top' => 9,
       'left' => 3,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 300,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1832,
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
    'element_id' => 'image-1414678713515-1847',
    'row' => 60,
    'no_padding' => '1',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 60,
      )),
       'mobile' =>
      (array)(array(
         'row' => 32,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'current_preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445647172909-1889',
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
      'order' => 2,
      'top' => 0,
      'row' => 60,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 2,
      'top' => 0,
      'row' => 32,
    ),
  ),
));

$regions->add($customs_books);

$student_binding = upfront_create_region(
			array (
  'name' => 'student-binding',
  'title' => 'Student Binding',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'student-binding',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 59,
  'background_type' => 'color',
  'nav_region' => '',
  'background_color' => 'rgba(255,255,255,0.75)',
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
  'version' => '1.0.0',
)
			);

$student_binding->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414679846556-1523',
  'id' => 'module-1414679846556-1523',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-services/_MG_7899-540x300-3324.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-services/_MG_7899.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-services/_MG_7899.jpg',
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
       'width' => 557,
       'height' => 372,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 655,
       'height' => 437,
    )),
    'position' =>
    (array)(array(
       'top' => 60,
       'left' => 7,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 300,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1833,
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
    'element_id' => 'image-1414679846547-1484',
    'row' => 60,
    'no_padding' => '1',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 58,
      )),
       'mobile' =>
      (array)(array(
         'row' => 28,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'current_preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1414679941054-1810',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'clear' => true,
      'order' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'clear' => true,
      'order' => 1,
      'edited' => true,
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
      'row' => 58,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'top' => 0,
      'order' => 0,
      'row' => 28,
    ),
  ),
));

$student_binding->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-36681 upfront-module-spacer',
  'id' => 'module-1449776269-36681',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-94739',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-77076',
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

$student_binding->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454636962901-1609',
  'id' => 'module-1454636962901-1609',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4>Bookbiding</h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1454636962899-1106',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '40',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '40',
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1414233009782-1954',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => false,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'order' => 0,
      'clear' => true,
      'edited' => true,
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
  'close_wrapper' => false,
));

$student_binding->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414233680985-1161',
  'id' => 'module-1414233680985-1161',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Dorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet do ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1414233680985-1197',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 32,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 44,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1414233009782-1954',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 2,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 2,
      'top' => 0,
      'row' => 44,
    ),
  ),
));

$student_binding->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-63733 upfront-module-spacer',
  'id' => 'module-1449776269-63733',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-96936',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-42137',
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

$regions->add($student_binding);

$region_1 = upfront_create_region(
			array (
  'name' => 'region-1',
  'title' => 'Region 1',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'region-1',
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
  'background_color' => 'rgba(247,247,247,1)',
  'version' => '1.0.0',
)
			);

$region_1->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-98105 upfront-module-spacer',
  'id' => 'module-1449776269-98105',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-22504',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-14969',
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

$region_1->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1454637074896-1635',
  'id' => 'module-1454637074896-1635',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4>Boxes</h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1454637074895-1502',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '40',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '40',
    'row' => 13,
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1445647773427-1744',
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
      'clear' => false,
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
  'close_wrapper' => false,
));

$region_1->add_element("PlainTxt", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414233694691-1509',
  'id' => 'module-1414233694691-1509',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Klaritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est n a nobis eleifend option congue nihil imp otare quam littera gothica, quam nunc putamus.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1414233694691-1712',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 29,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 20,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445647773427-1744',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'top' => 0,
      'order' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'top' => 0,
      'order' => 1,
    ),
  ),
));

$region_1->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776269-60945 upfront-module-spacer',
  'id' => 'module-1449776269-60945',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776269-14474',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776269-25018',
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

$region_1->add_element("Uimage", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414679941482-1320',
  'id' => 'module-1414679941482-1320',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-services/_MG_7900-544x300-4142.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-services/_MG_7900.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-services/_MG_7900.jpg',
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
       'width' => 574,
       'height' => 383,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 655,
       'height' => 437,
    )),
    'position' =>
    (array)(array(
       'top' => 76,
       'left' => 26,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 540,
       'height' => 300,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1834,
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
    'element_id' => 'image-1414679941473-1234',
    'row' => 60,
    'no_padding' => '1',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 44,
      )),
       'mobile' =>
      (array)(array(
         'row' => 33,
      )),
    )),
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'current_preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445647768129-1029',
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
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'top' => 0,
      'order' => 2,
      'row' => 44,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'top' => 0,
      'order' => 2,
      'row' => 33,
    ),
  ),
));

$regions->add($region_1);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-request-quote-gap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-request-quote-gap.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
