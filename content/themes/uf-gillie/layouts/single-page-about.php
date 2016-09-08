<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$cover_about = upfront_create_region(
			array (
  'name' => 'cover-about',
  'title' => 'cover about',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'cover-about',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 102,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 52,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 52,
    )),
  )),
  'background_type' => 'image',
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
  'background_style' => 'fixed',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-about/about.jpg',
  'background_image_ratio' => 0.36999999999999999555910790149937383830547332763671875,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
)
			);

$cover_about->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460018561746-1593 upfront-module-spacer',
  'id' => 'module-1460018561746-1593',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460018561746-1496',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460018561745-1660',
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
));

$cover_about->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459864358879-1591',
  'id' => 'module-1459864358879-1591',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1><span class="upfront_theme_color_3">Gillie<br>Brown</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459864358878-1017',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'cover-message',
    'padding_slider' => '10',
    'top_padding_num' => '325',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 5,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'cover-message',
      )),
    )),
    'top_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '140',
         'top_padding_num' => '140',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '160',
         'top_padding_num' => '160',
      )),
    )),
    'current_preset' => 'cover-message',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459864469279-1133',
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
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$cover_about->add_element("Uspacer", array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460018569818-1296 upfront-module-spacer',
  'id' => 'module-1460018569818-1296',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460018569818-1055',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460018569817-1974',
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
));

$regions->add($cover_about);

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
  'row' => 60,
  'background_type' => 'color',
  'background_color' => '#ufc3',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_slider' => '60',
       'bottom_bg_padding_num' => '60',
       'bg_padding_type' => 'equal',
       'bg_padding_slider' => '60',
       'bg_padding_num' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_type' => 'equal',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '100',
  'top_bg_padding_num' => '100',
  'bottom_bg_padding_slider' => '40',
  'bottom_bg_padding_num' => '40',
  'bg_padding_slider' => '100',
  'bg_padding_num' => '100',
  'version' => '1.0.0',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459933629218-1204 upfront-module-spacer',
  'id' => 'module-1459933629218-1204',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459933629218-1832',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459933629217-1512',
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
  'class' => 'module-1459932174969-1826',
  'id' => 'module-1459932174969-1826',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2 class="" style="text-align: center;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459932174969-1534',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'block-heading',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '40',
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
         'preset' => 'block-heading',
      )),
    )),
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '40',
         'bottom_padding_num' => '40',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'block-heading',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '40',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459932184836-1772',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459933626866-1399 upfront-module-spacer',
  'id' => 'module-1459933626866-1399',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459933626866-1657',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459933626864-1622',
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
  'class' => 'module-1459933743607-1324 upfront-module-spacer',
  'id' => 'module-1459933743607-1324',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459933743607-1205',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459933743607-1126',
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
  'class' => 'module-1459933659975-1892',
  'id' => 'module-1459933659975-1892',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class="">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459933659975-1209',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'bottom_padding_num' => '40',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '40',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 98,
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
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
  'wrapper_id' => 'wrapper-1459933739737-1247',
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
      'row' => 98,
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459933746250-1493 upfront-module-spacer',
  'id' => 'module-1459933746250-1493',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459933746249-1439',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459933746249-1189',
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
  'class' => 'module-1460037895506-1468 upfront-module-spacer',
  'id' => 'module-1460037895506-1468',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460037895505-1734',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460037895503-1897',
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

$main->add_group(array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1460035394387-1207',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1460037382234-1730',
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
  'background_image' => '{{upfront:style_url}}/images/single-page-about/guitar.png',
  'background_image_ratio' => 0.39000000000000001332267629550187848508358001708984375,
  'background_repeat' => 'no-repeat',
  'background_position' => '-105% 50%',
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
      'background_position_y' => '50',
      'background_style' => 'fixed',
      'background_repeat' => 'no-repeat',
      'background_position' => '50% 50%',
      'background_position_x' => '50',
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '40',
      'bottom_padding_num' => '40',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'background_position_y' => '50',
      'background_style' => 'fixed',
      'background_repeat' => 'no-repeat',
      'background_position' => '50% 50%',
      'background_position_x' => '50',
      'row' => 66,
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$main->add_element("Uspacer", array (
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

$main->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460534354926-1026 upfront-module-spacer',
  'id' => 'module-1460534354926-1026',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460534354926-1660',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460534354925-1622',
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

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460534668286-1607 upfront-module-spacer',
  'id' => 'module-1460534668286-1607',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460534668285-1029',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460534668284-1925',
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

$main->add_element("PlainTxt", array (
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
    'content' => '<h2 style="text-align: right;">Find Gillie<br>Brown on<br>YouTube</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1459524992796-1015',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
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
         'preset' => 'default',
      )),
       'mobile' =>
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
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '200',
         'top_padding_num' => '200',
      )),
    )),
    'theme_style' => '',
    'current_preset' => 'default',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470904794904-1788 upfront-module-spacer',
  'id' => 'module-1470904794904-1788',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470904794904-1797',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470904794903-1580',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470904727103-1788 upfront-module-spacer',
  'id' => 'module-1470904727103-1788',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470904727103-1616',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470904727102-1050',
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460534362570-1906 upfront-module-spacer',
  'id' => 'module-1460534362570-1906',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460534362570-1008',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460534362569-1692',
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

$main->add_element("Uspacer", array (
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

$main->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460534357797-1890 upfront-module-spacer',
  'id' => 'module-1460534357797-1890',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460534357797-1240',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460534357795-1382',
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
  'group' => 'module-group-1460035394387-1207',
));

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460535867411-1588 upfront-module-spacer',
  'id' => 'module-1460535867411-1588',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460535867410-1347',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460535867409-1931',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 8,
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

$main->add_element("PlainTxt", array (
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
         'top_padding_num' => '10',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '10',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'row' => 7,
      )),
    )),
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'current_preset' => 'icon-link',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'icon-link',
      )),
    )),
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
      'order' => 8,
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
      'row' => 7,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460035394387-1207',
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460535930022-1339 upfront-module-spacer',
  'id' => 'module-1460535930022-1339',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460535930022-1509',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460535930021-1359',
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
      'clear' => false,
      'order' => 8,
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460534364208-1965 upfront-module-spacer',
  'id' => 'module-1460534364208-1965',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460534364208-1244',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460534364208-1524',
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

$main->add_element("Uspacer", array (
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460037897682-1677 upfront-module-spacer',
  'id' => 'module-1460037897682-1677',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460037897682-1005',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460037897681-1171',
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
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459935074186-1365 upfront-module-spacer',
  'id' => 'module-1459935074186-1365',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459935074185-1271',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459935074185-1382',
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
  'class' => 'module-1459933795532-1960',
  'id' => 'module-1459933795532-1960',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class="">Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1459933795532-1086',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '40',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '40',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 6,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'row' => 40,
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459935053507-1903',
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
      'row' => 40,
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459935076187-1748 upfront-module-spacer',
  'id' => 'module-1459935076187-1748',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459935076187-1973',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459935076186-1413',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
