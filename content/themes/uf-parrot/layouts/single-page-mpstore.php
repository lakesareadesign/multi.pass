<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php');

$navigation_secondary = upfront_create_region(
			array (
  'name' => 'navigation-secondary',
  'title' => 'navigation-secondary',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'blog-header-area',
  'sub' => 'left',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => 4,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 14,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 11,
    )),
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'background_color' => 'rgba(0,0,0,0)',
  'version' => '1.0.0',
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'banner',
)
			);

$navigation_secondary->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-79057 upfront-module-spacer',
  'id' => 'module-1450121362-79057',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-20862',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-66579',
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

$navigation_secondary->add_element("Uimage", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444095748482-1141',
  'id' => 'module-1444095748482-1141',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-mpstore/logo-36x35-2629.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-mpstore/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-mpstore/logo.png',
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
       'width' => 36,
       'height' => 36,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 280,
       'height' => 280,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 70,
       'height' => 36,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '34',
    'align' => 'left',
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
    'when_clicked' => 'external',
    'image_link' => '{{upfront:home_url}}',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => '{{upfront:home_url}}',
       'target' => '_self',
       'display_url' => '{{upfront:home_url}}',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1444095748480-1248',
    'row' => 21,
    'link_target' => '_self',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 12,
         'top_padding_use' => true,
         'top_padding_num' => 20,
      )),
       'mobile' =>
      (array)(array(
         'row' => 13,
         'top_padding_use' => true,
         'top_padding_num' => 20,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 60,
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    array (
    ),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1444095759083-1375',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 2,
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
      'col' => 2,
      'order' => 0,
      'top' => 0,
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'row' => 13,
      'top' => 0,
    ),
  ),
));

$navigation_secondary->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-29967 upfront-module-spacer',
  'id' => 'module-1450121362-29967',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-92984',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-35322',
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

$navigation_secondary->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-20921 upfront-module-spacer',
  'id' => 'module-1450121362-20921',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-98406',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-4966',
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

$navigation_secondary->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-96638 upfront-module-spacer',
  'id' => 'module-1450121362-96638',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-44710',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-65731',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 8,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 8,
      'edited' => true,
    ),
  ),
));

$navigation_secondary->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121362-9245 upfront-module-spacer',
  'id' => 'module-1450121362-9245',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121362-6867',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121362-98862',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$navigation_secondary->add_element("Unewnavigation", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429557374225-1939',
  'id' => 'module-1429557374225-1939',
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
         'menu-item-db-id' => 1755,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1755',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}',
           'target' => '',
           'display_url' => '{{upfront:home_url}}',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 1756,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Features',
         'menu-item-url' => '{{upfront:home_url}}/features/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1756',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}/features/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/features/',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 1757,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Download',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1757',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/download/',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 1758,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact Us',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1758',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}/contact/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/contact/',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 1759,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1759',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/about/',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 1760,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1760',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'external',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/blog/',
        )),
      )),
    ),
    'preset' => 'parrot-main-nav-2-m',
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
    'element_id' => 'unewnavigation-object-1429557374224-1061',
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
         'burger_alignment' => 'right',
         'burger_over' => 'over',
         'menu_style' => 'triggered',
         'menu_alignment' => 'right',
         'width' => 570,
         'row' => 14,
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'burger_alignment' => 'right',
         'menu_style' => 'triggered',
         'menu_alignment' => 'right',
         'burger_over' => 'over',
         'width' => 315,
         'row' => 15,
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-main-nav',
    'row' => 45,
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
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'parrot-main-nav-2-m',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'parrot-main-nav-2-m',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'parrot-main-nav-2-m',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429558005324-1559',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 3,
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'row' => 13,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'row' => 14,
      'top' => 0,
    ),
  ),
));

$regions->add($navigation_secondary);

$blog_header_area = upfront_create_region(
			array (
  'name' => 'blog-header-area',
  'title' => 'Blog Header Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'blog-header-area',
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
  'row' => 94,
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
  'background_image' => '{{upfront:style_url}}/images/single-page-mpstore/hero-4.jpg',
  'background_image_ratio' => 0.31,
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => false,
)
			);

$blog_header_area->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1487646440656-1541',
  'id' => 'module-1487646440656-1541',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1 style="text-align: center;">PARROT</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1487646440653-1745',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'brand-2',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'brand-2',
      )),
    )),
    'padding_slider' => '10',
    'top_padding_num' => '65',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'anchor' => '',
    'current_preset' => 'brand-2',
    'theme_style' => '',
    'row' => 23,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '65',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1487646544938-1494',
  'new_line' => true,
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1487646613850-1449 upfront-module-spacer',
  'id' => 'module-1487646613850-1449',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1487646613849-1117',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1487646613849-1866',
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

$blog_header_area->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1467787537272-1394',
  'id' => 'module-1467787537272-1394',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'mp-landing-page',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1467787537271-1215',
    'top_padding_num' => '70',
    'bottom_padding_num' => '35',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'left_padding_num' => 15,
    'right_padding_num' => 15,
    'lock_padding' => '',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data  .upfront-postpart-author:hover {
    color: /*#ufc0*/#2a8a5e;
    font-weight: 700;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    color: /*#ufc6*/#766856;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.538em;
}
#page .default.upost-data-object-post_data  .part-featured_image.no-featured_image {
    display: none;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content ul, #page .default.upost-data-object-post_data .content ol, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    margin: 0 0 30px;
}
#page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content h6 {
    margin: 0 0 10px;
}
#page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h4 {
    text-align: center
}
#page .default.upost-data-object-post_data .content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data .content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content img {
    display: block;
    height: auto;
    max-width: 100%;
    margin-top:10px;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 0 15px 30px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 30px 15px 0;
}
#page .default.upost-data-object-post_data .content h4 {
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data .content p {
    -ms-word-break: break-word;
    word-break: break-word;
}
#page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options), #page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options) {
    list-style-position: outside;
}
#page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options) li {
    text-indent: -15px
}
#page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options) li, #page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options) li {
    margin-bottom: 10px;
}
#page .default.upost-data-object-post_data  .wp-caption-text {
    position: relative;
    padding: 5px 0 0;
    font-size: 13px;
    letter-spacing: -0.1px;
}
#page .default.upost-data-object-post_data  .wp-caption-text:after {
    width: 50px;
    content: "";
    height: 100%;
    margin-top: 6px;
    border-bottom: 1px solid #ddf2f8;
    display: block;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    margin-bottom: 0;
    font-size: 13px;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#2a8a5e;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6em;
}
#page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .ueditor-insert {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-full-width, #page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-center {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-right {
    margin: 0 0 15px 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-left {
    margin: 0 30px 15px 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-full-width img, #page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-center img {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc5*/#666666;
    font-size: 15px;
    font-weight: 400;
    line-height: 2em;
    min-height: auto !important;
    margin: 0;
    padding: 5px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content blockquote {
    margin: 60px 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .content blockquote p {
    color: /*#ufc2*/#ffffff;
    font-size: 20px;
    line-height: 1.4em;
    margin: 0;
    padding: 15px;
}
#page .default.upost-data-object-post_data .content blockquote cite {
    color: #000;
    font-style: normal;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.5em;
    padding: 0;
    margin-left:0px;
    margin-right:0px;
}
#page .default.upost-data-object-post_data .content blockquote a {
    color: #000;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Open Sans',
    'static-date_posted-fontstyle' => '700 normal',
    'static-date_posted-weight' => '700',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '12',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc6',
    'left_indent' => '1',
    'right_indent' => '1',
    'content_part' => '0',
    'theme_preset' => 'true',
    'calculated_left_indent' => 45,
    'calculated_right_indent' => 45,
    'hidden_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '70',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '35',
    'anchor' => '',
    'current_preset' => 'mp-landing-page',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'mp-landing-page',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1478803789499-1274',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 2,
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1467787537270-1603',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1467787537271-1078',
      'padding_slider' => 15,
      'use_padding' => 'yes',
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
      'top_padding_num' => 15,
      'left_padding_num' => 15,
      'right_padding_num' => 15,
      'bottom_padding_num' => 15,
      'lock_padding' => '',
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
    ),
  ),
));

$blog_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1478803795418-1135 upfront-module-spacer',
  'id' => 'module-1478803795418-1135',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1478803795418-1589',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1478803795416-1128',
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

$regions->add($blog_header_area);

$header_bottom = upfront_create_region(
			array (
  'name' => 'header_bottom',
  'title' => 'Header Area bottom',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'blog-header-area',
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
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$regions->add($header_bottom);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
