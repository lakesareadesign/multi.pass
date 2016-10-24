<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php');

$region_container = 'archive-header-area';
$region_sub = 'left';
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'navigation-secondary.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'navigation-secondary.php');

$archive_header_area = upfront_create_region(
			array (
  'name' => 'archive-header-area',
  'title' => 'Archive Header Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'archive-header-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
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
  'row' => 65,
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => 'bottom',
  ),
  'background_color' => '#ffffff',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'always',
  'background_slider_images' =>
  array (
    0 => '/images/hero-2.jpg',
    1 => '/images/hero.jpg',
  ),
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive-product_tag/hero-1.jpg',
  'background_image_ratio' => 0.31,
  'version' => '1.0.0',
)
			);

$archive_header_area->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-94599 upfront-module-spacer',
  'id' => 'module-1450121362-94599',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-55407',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-97951',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 6,
    ),
    'mobile' =>
    array (
      'col' => 6,
    ),
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-14300 upfront-module-spacer',
  'id' => 'module-1450121362-14300',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-93678',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-64023',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 0,
      'edited' => true,
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 4,
      'edited' => true,
    ),
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-74575 upfront-module-spacer',
  'id' => 'module-1450121362-74575',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-90492',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-68907',
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

$archive_header_area->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444680120904-1100',
  'id' => 'module-1444680120904-1100',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-product_tag/parrot-logo-text-green-136x25-7392.png',
    'srcFull' => '{{upfront:style_url}}/images/archive-product_tag/parrot-logo-text-green.png',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-product_tag/parrot-logo-text-green.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => false,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 136,
       'height' => 45,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 136,
       'height' => 45,
    )),
    'position' =>
    (array)(array(
       'top' => 10,
       'left' => -12,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 45,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '28',
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
    'element_id' => 'image-1444680120901-1027',
    'row' => 23,
    'top_padding_use' => true,
    'top_padding_num' => 80,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '20',
         'row' => 4,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'row' => 10,
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1444680159768-1259',
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
      'col' => 4,
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
      'row' => 10,
    ),
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-82822 upfront-module-spacer',
  'id' => 'module-1450121362-82822',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-99298',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-66561',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 10,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-20167 upfront-module-spacer',
  'id' => 'module-1450121362-20167',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-92540',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-60662',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 0,
      'edited' => true,
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 4,
      'edited' => true,
    ),
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-73873 upfront-module-spacer',
  'id' => 'module-1450121362-73873',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-57054',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-63506',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'clear' => false,
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

$archive_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-58335 upfront-module-spacer',
  'id' => 'module-1450121362-58335',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-24077',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-99445',
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

$archive_header_area->add_element("Uwidget", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1430221110055-1308',
  'id' => 'module-1430221110055-1308',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'preset' => 'default',
    'widget' => 'search-2',
    'usingNewAppearance' => true,
    'element_id' => 'uwidget-object-1430221110054-1665',
    'selected_widget' => 'search-2',
    'anchor' => '',
    'widget_specific_fields' => false,
    'title' => '',
    'row' => 15,
    'theme_style' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '80',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 35,
      )),
    )),
    'current_widget' => 'search-2',
    'current_widget_specific_settings' => false,
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'current_widget_specific_fields' => false,
    'top_padding_slider' => '80',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1430882477160-1831',
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
      'edited' => false,
      'left' => 0,
      'col' => 12,
      'order' => 0,
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
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-78198 upfront-module-spacer',
  'id' => 'module-1450121362-78198',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-89657',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-36078',
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

$archive_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-71182 upfront-module-spacer',
  'id' => 'module-1450121362-71182',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-24979',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-15135',
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

$archive_header_area->add_element("Code", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1430244473762-1123',
  'id' => 'module-1430244473762-1123',
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
    'element_id' => 'upfront-code_element-object-1430244473761-1800',
    'code_selection_type' => 'Create',
    'markup' => '<hr class="parrot-divider">',
    'row' => 11,
    'style' => '/* Your styles here */',
    'script' => '/* Your code here */',
    'top_padding_use' => true,
    'top_padding_num' => 40,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 25,
      )),
    )),
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'preset' => 'default',
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
  'wrapper_id' => 'wrapper-1430882477161-1302',
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
  ),
));

$archive_header_area->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-69589 upfront-module-spacer',
  'id' => 'module-1450121362-69589',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-28946',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-44102',
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

$regions->add($archive_header_area);

$header_bottom = upfront_create_region(
			array (
  'name' => 'header_bottom',
  'title' => 'Header Area bottom',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'archive-header-area',
  'sub' => 'bottom',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
    )),
  )),
  'row' => 30,
  'background_type' => 'color',
  'use_padding' => 0,
  'background_color' => 'rgba(255,255,255,0.35)',
  'version' => '1.0.0',
)
			);

$regions->add($header_bottom);

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
  'row' => 63,
  'background_type' => 'color',
  'background_color' => '#ufc2',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '0',
       'bottom_bg_padding_num' => '0',
       'row' => 53,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'current_property' => 'background_type',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
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

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-85236 upfront-module-spacer',
  'id' => 'module-1450121362-85236',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-54138',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-46329',
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

$main->add_element("Posts", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'default-posts',
  'id' => 'default-posts',
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
    'limit' => 5,
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'thumbnail_size' => 'large',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'title',
      1 => 'content',
      2 => 'author',
      3 => 'date_posted',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'title',
      3 => 'content',
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
    'date_posted_format' => 'F j, Y',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => '23',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'default',
    'post-part-date_posted' => '<div class="uposts-part date_posted"> ― <span class="date">{{date_1}}</span> <span class="time">{{date_2}}</span> <span class="year">{{date_3}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">Posted by <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}">
	<a href="{{permalink}}">{{thumbnail}}</a>
</div>',
    'post-part-title' => '<div class="uposts-part title">
	<h2><a href="{{permalink}}" title="{{title}}">{{title}}</a></h2>
</div>',
    'post-part-content' => '<div class="uposts-part content">
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
    'usingNewAppearance' => true,
    'content_type' => 'excerpt',
    'featured_image' => '1',
    'post_data' =>
    array (
      0 => 'date',
    ),
    'element_id' => 'default-posts-object',
    'anchor' => '',
    'row' => 53,
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 386,
      )),
       'tablet' =>
      (array)(array(
         'row' => 293,
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'lock_padding',
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'mobile',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'mobile',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'default-posts-wrapper',
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
      'top' => 0,
      'row' => 293,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 386,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-12202 upfront-module-spacer',
  'id' => 'module-1450121362-12202',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-42041',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-42509',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
