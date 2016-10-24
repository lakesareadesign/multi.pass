<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'home-slider.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'home-slider.php');

$main_navigation = upfront_create_region(
			array (
  'name' => 'main-navigation',
  'title' => 'Main Navigation',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main-navigation',
  'position' => 1,
  'allow_sidebar' => true,
  'sticky' => '1',
),
			array (
  'row' => 10,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 14,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ufc1',
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main_navigation->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-78269 upfront-module-spacer',
  'id' => 'module-1450867715-78269',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-12247',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-10574',
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

$main_navigation->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426155852070-1594',
  'id' => 'module-1426155852070-1594',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class=""><a target="_self" rel="external" href="{{upfront:home_url}}">PANiNO</a><br></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1426155852069-1714',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 7,
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
         'theme_style' => '',
         'row' => 14,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-brand-menu-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'brand-menu-mobile',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'u-brand-menu-m',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'brand-menu-mobile',
      )),
    )),
    'current_preset' => 'u-brand-menu-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426156559122-1722',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 7,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$main_navigation->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-57328 upfront-module-spacer',
  'id' => 'module-1450867715-57328',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-37994',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-94788',
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

$main_navigation->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-99135 upfront-module-spacer',
  'id' => 'module-1450867715-99135',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-56325',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-64262',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 1,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$main_navigation->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-32954 upfront-module-spacer',
  'id' => 'module-1450867715-32954',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-14865',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-9512',
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

$main_navigation->add_element("Unewnavigation", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426156754812-1401',
  'id' => 'module-1426156754812-1401',
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
         'menu-item-db-id' => 4605,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Our Story',
         'menu-item-url' => '#ourStory',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4605',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'anchor',
           'url' => '#ourStory',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 4608,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Menu',
         'menu-item-url' => '#menu',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4608',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'anchor',
           'url' => '#menu',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 4611,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4611',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 4615,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Gallery',
         'menu-item-url' => '#gallery',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4615',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'anchor',
           'url' => '#gallery',
           'target' => '',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 4617,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Find Us',
         'menu-item-url' => '#ourLocation',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '4617',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'link' =>
        (array)(array(
           'type' => 'anchor',
           'url' => '#ourLocation',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'main-nav-reversed',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'usingNewAppearance' => true,
    'menu_style' => 'horizontal',
    'menu_alignment' => 'center',
    'element_id' => 'unewnavigation-object-1426156754811-1745',
    'initialized' => false,
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'horizontal',
         'menu_alignment' => 'center',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
       'tablet' =>
      (array)(array(
         'theme_style' => '',
         'width' => 570,
         'burger_alignment' => 'right',
         'burger_over' => 'over',
         'menu_style' => 'triggered',
         'menu_alignment' => 'right',
         'row' => 12,
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'burger_alignment' => 'right',
         'burger_over' => 'over',
         'menu_style' => 'triggered',
         'menu_alignment' => 'right',
         'width' => 315,
         'row' => 7,
         'theme_style' => '',
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
    )),
    'menu_id' => false,
    'menu_slug' => 'panino-main-menu-home',
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'row' => 6,
    'theme_style' => '',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'main-nav-reversed',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '15',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'current_preset' => 'main-nav-reversed',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426156922342-1837',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 6,
      'order' => 0,
      'row' => 12,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'row' => 6,
      'top' => 0,
    ),
  ),
));

$main_navigation->add_element("Uspacer", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-3681 upfront-module-spacer',
  'id' => 'module-1450867715-3681',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-18797',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-62352',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 7,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$regions->add($main_navigation);

$home_our_story = upfront_create_region(
			array (
  'name' => 'home-our-story',
  'title' => 'Home Our Story',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'home-our-story',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 203,
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
  'background_image' => '{{upfront:style_url}}/images/archive-home/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'background_position' => '50% 50%',
  'version' => '1.0.0',
)
			);

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-18490 upfront-module-spacer',
  'id' => 'module-1450867715-18490',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-53536',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-85994',
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

$home_our_story->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426156559174-1975',
  'id' => 'module-1426156559174-1975',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">Our Story</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1426156559174-1067',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 41,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => 'ourStory',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 30,
         'top_padding_use' => true,
         'top_padding_num' => 75,
      )),
       'tablet' =>
      (array)(array(
         'row' => 17,
      )),
       'current_property' => 'lock_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 100,
    'bottom_padding_num' => '15',
    'preset' => 'u-section-title-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-section-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426158229468-1068',
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
      'row' => 17,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 30,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-72498 upfront-module-spacer',
  'id' => 'module-1450867715-72498',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-11039',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-17507',
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

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-9959 upfront-module-spacer',
  'id' => 'module-1450867715-9959',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-2129',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-34879',
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

$home_our_story->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426158229525-1512',
  'id' => 'module-1426158229525-1512',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class="">We don\'t just love coffee -&nbsp;we live and breathe it.</h2><p class="">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.&nbsp;Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse. Lorem ipsum dolor sit amet lorem unim ad minim veniam ledgre me lius ii legunt saepiusud exerci tation ullamcorper suscipit, lorem ipsum dolor sit amet.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1426158229524-1137',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 169,
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
         'row' => 73,
         'theme_style' => '',
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'row' => 92,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 80,
    'bottom_padding_num' => '15',
    'preset' => 'u-paragraph-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'u-paragraph-m',
      )),
    )),
    'current_preset' => 'u-paragraph-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426159324840-1877',
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
      'row' => 73,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 92,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-64477 upfront-module-spacer',
  'id' => 'module-1450867715-64477',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-63884',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-32977',
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

$home_our_story->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426158858989-1915',
  'id' => 'module-1426158858989-1915',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">
	Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.&nbsp;</p><p class="">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1426158858989-1262',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 169,
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
         'row' => 71,
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 35,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'row' => 90,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 80,
    'bottom_padding_num' => '15',
    'preset' => 'u-paragraph-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'u-paragraph-m',
      )),
    )),
    'current_preset' => 'u-paragraph-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426159324841-1540',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 5,
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
      'row' => 67,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 90,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-78304 upfront-module-spacer',
  'id' => 'module-1450867715-78304',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-89865',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-66396',
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

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-89552 upfront-module-spacer',
  'id' => 'module-1450867715-89552',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-99439',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-77915',
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

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-32432 upfront-module-spacer',
  'id' => 'module-1450867715-32432',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-42026',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-88015',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 3,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uimage", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1430902566843-1606',
  'id' => 'module-1430902566843-1606',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-1-239x240-5140.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-1.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-1.jpg',
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
       'width' => 610,
       'height' => 340,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 1280,
       'height' => 714,
    )),
    'position' =>
    (array)(array(
       'top' => 68,
       'left' => 129.5,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 240,
       'height' => 240,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1824',
    'align' => 'center',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'u-image-rounded-m',
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
    'element_id' => 'image-1430902566840-1540',
    'row' => 57,
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 14,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 30,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-image-rounded-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1430903243437-1739',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 6,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'row' => 14,
      'hide' => 1,
      'top' => 0,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-43127 upfront-module-spacer',
  'id' => 'module-1450867715-43127',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-97714',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-46233',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-26660 upfront-module-spacer',
  'id' => 'module-1450867715-26660',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-97211',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-77568',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 3,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uimage", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1430903254042-1144',
  'id' => 'module-1430903254042-1144',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-2-240x240-7326.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-2.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/our-story-placeholder-2.jpg',
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
       'width' => 510,
       'height' => 340,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 6000,
       'height' => 4000,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 142,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 240,
       'height' => 246,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1825',
    'align' => 'center',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'u-image-rounded-m',
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
    'element_id' => 'object-1430903254042-1036',
    'row' => 58,
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 55,
      )),
       'mobile' =>
      (array)(array(
         'row' => 23,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 30,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-image-rounded-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1430903256414-1067',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 6,
      'order' => 0,
      'top' => 0,
      'row' => 55,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'row' => 23,
      'top' => 0,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-15536 upfront-module-spacer',
  'id' => 'module-1450867715-15536',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-29355',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-15330',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 5,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-32992 upfront-module-spacer',
  'id' => 'module-1450867715-32992',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-64111',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-10710',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Button", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429092902295-1219',
  'id' => 'module-1429092902295-1219',
  'options' =>
  array (
    'content' => 'ViEW OUR GALLERY',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-circle',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1429092902295-1413',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '#gallery',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 9,
    'theme_style' => '',
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 55,
         'theme_style' => '',
      )),
       'tablet' =>
      (array)(array(
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 50,
      )),
    )),
    'anchor' => '',
    'top_padding_use' => true,
    'top_padding_num' => 30,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'button-circle',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429092916049-1889',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 5,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 4,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 55,
      'top' => 0,
      'hide' => 1,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-27547 upfront-module-spacer',
  'id' => 'module-1450867715-27547',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-94227',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-56184',
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

$home_our_story->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-45345 upfront-module-spacer',
  'id' => 'module-1450867715-45345',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-56580',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-13513',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-68073 upfront-module-spacer',
  'id' => 'module-1450867715-68073',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-15350',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-47285',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 5,
      'edited' => true,
      'col' => 3,
    ),
    'mobile' =>
    array (
      'col' => 3,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-78113 upfront-module-spacer',
  'id' => 'module-1450867715-78113',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-31857',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-64776',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 6,
      'edited' => true,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 5,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-82240 upfront-module-spacer',
  'id' => 'module-1450867715-82240',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-10724',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-5115',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 6,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Button", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1427802908920-1998',
  'id' => 'module-1427802908920-1998',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '#anchorTop',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-anchor',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1427802908920-1833',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/#page',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 23,
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
         'row' => 18,
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 12,
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_num' => '70',
    'bottom_padding_num' => '70',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_slider' => '70',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
    'current_preset' => 'button-anchor',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1427803031352-1468',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 6,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 6,
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
      'order' => 1,
      'top' => 0,
      'row' => 27,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 12,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-1670 upfront-module-spacer',
  'id' => 'module-1450867715-1670',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-20842',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-16194',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-79242 upfront-module-spacer',
  'id' => 'module-1450867715-79242',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-65737',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-37274',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 6,
      'edited' => true,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 5,
      'edited' => true,
    ),
  ),
));

$home_our_story->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-3083 upfront-module-spacer',
  'id' => 'module-1450867715-3083',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-25919',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-49460',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 6,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$regions->add($home_our_story);

$home_special_menu = upfront_create_region(
			array (
  'name' => 'home-special-menu',
  'title' => 'Home Special Menu',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'home-special-menu',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 182,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 240,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 185,
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
  'background_image' => '{{upfront:style_url}}/images/archive-home/orig_Tile_brick.jpg',
  'background_image_ratio' => 0.810000000000000053290705182007513940334320068359375,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
)
			);

$home_special_menu->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-31439 upfront-module-spacer',
  'id' => 'module-1450867715-31439',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-40250',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-50131',
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

$home_special_menu->add_element("Utabs", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426155852080-1470',
  'id' => 'module-1426155852080-1470',
  'options' =>
  array (
    'type' => 'UtabsModel',
    'view_class' => 'UtabsView',
    'has_settings' => 1,
    'class' => 'c24 upfront-tabs',
    'tabs' =>
    array (
      0 =>
      (array)(array(
         'content' => '<h4 class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><b data-redactor-tag="b"><strong data-redactor-tag="strong" data-verified="redactor">FOOD</strong></b></span><span data-redactor-tag="span" data-verified="redactor"></span></h4><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">TOAST WITH HOUSE-CHURNED BUTTER &amp; SEASONAL PRESERVES - $7.50</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">SOAKED MUESLI WITH AUSTRALIAN GRAINS, HOUSE-MADE YOGHURT, FRUITS &amp; FLOWERS &nbsp;</span><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">- $13.00</span><span data-redactor-tag="span" data-verified="redactor"></span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">HOUSE-MADE COCONUT YOGHURT WITH GLUTEN-FREE GRAINS, SEEDS &amp; NUTS, PEAR, CITRUS POWDERS, FRUITS &amp; FLOWERS - $14.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">HOTCAKE WITH RICOTTA, BLUEBERRIES, PURE MAPLE, DOUBLE CREAM &amp; SEEDS - $18.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">POLENTA PORRIDGE WITH BURNT MAPLE, TEXTURES OF STRAWBERRY &amp; BASIL - $15.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">COCONUT-SET CHIA SEEDS, FRESH QLD MANGO, STRAWBERRIES, BLUEBERRIES, COCONUT, MAPLE, MACADAMIA &amp; LOCAL ROSE PETALS - $15.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">SEASONAL AVOCADO WITH CITRUS, TOAST &amp; LOCAL KELP SALT - $13.00 - EGGS YOUR WAY ON TOAST - $10.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">*</span></p>',
         'title' => 'FOOD',
      )),
      1 =>
      (array)(array(
         'title' => 'SIDES',
         'content' => '<h4 class=""><span data-redactor-tag="span" data-verified="redactor"></span><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><strong data-redactor-tag="strong" data-verified="redactor">SIDES</strong></span><span data-redactor-tag="span"></span></h4><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">EGG / TOAST - $3.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">BACON / CHORIZO / MUSHROOM&nbsp;/ RAW TOMATO - $4.00&nbsp;</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">FLINDERS ISLAND CURED WALLABY - $6.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">AVOCADO - $5.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">TATAKI OCEAN TROUT / RAW KALE SALAD- $7.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">GLUTEN FREE BREAD&nbsp;- ADD $1.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">*</span><span data-redactor-tag="span" data-verified="redactor"></span></p>',
      )),
      2 =>
      (array)(array(
         'title' => 'DRINKS',
         'content' => '<h4 class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><b data-redactor-tag="b">COFFEE</b></span></h4><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">BLACK - $4.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">MILK - $4.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">SOY - $0.20</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">MOCHA - $4.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">HOT CHOCOLATE - $4.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">ICED CHOCOLATE - $6.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">ICED COFFEE - $6.00</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">*</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">TEA</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">*</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">ENGLISH BREAKFAST<br>EARL GREY<br></span><span></span><span class="upfront_theme_color_1"><span>JASMINE<br></span><span>WHITE PEONY<br></span><span>LEMONGRASS &amp; GINGER<br></span><span>PEPPERMINT<br></span><span>OOLONG<br></span><span>- $4.00 -</span></span><span></span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">CHAI - $4.50</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">TORTE&nbsp;-&nbsp;$13</span></p><p class=""><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">*</span></p>',
      )),
    ),
    'tabs_count' => 3,
    'id_slug' => 'utabs',
    'preset' => 'special-menu-tabs',
    'usingNewAppearance' => true,
    'element_id' => 'utabs-object-1426155852079-1777',
    'row' => 55,
    'anchor' => 'menu',
    'theme_style' => '',
    'top_padding_use' => true,
    'top_padding_num' => 140,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 105,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '105',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '105',
      )),
       'current_property' => 'top_padding_num',
    )),
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'special-menu-tabs',
      )),
    )),
    'current_preset' => 'special-menu-tabs',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426159462867-1609',
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

$home_special_menu->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-45789 upfront-module-spacer',
  'id' => 'module-1450867715-45789',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-86535',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-64667',
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

$home_special_menu->add_element("Uimage", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1434005864469-1676',
  'id' => 'module-1434005864469-1676',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/dot_new_menu-195x193-1810.png',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/dot_new_menu.png',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/dot_new_menu.png',
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
       'width' => 195,
       'height' => 193,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 191,
       'height' => 189,
    )),
    'position' =>
    (array)(array(
       'top' => -1,
       'left' => 0,
    )),
    'marginTop' => 1,
    'element_size' =>
    (array)(array(
       'width' => 195,
       'height' => 194,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1732',
    'align' => 'left',
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
    'element_id' => 'image-1434005864466-1197',
    'row' => 71,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 36,
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'right_padding_use' => true,
         'right_padding_num' => 105,
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 245,
         'left_padding_use' => true,
         'left_padding_num' => 60,
         'right_padding_use' => true,
         'right_padding_num' => 60,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 295,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'anchor' => '',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426160435930-1357',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 6,
      'order' => 1,
      'clear' => true,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'order' => 1,
      'clear' => true,
      'edited' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 1,
      'top' => 0,
      'row' => 35,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 1,
      'top' => 0,
      'hide' => 1,
    ),
  ),
  'close_wrapper' => false,
));

$home_special_menu->add_element("Button", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444614048589-1104',
  'id' => 'module-1444614048589-1104',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-social-facebook',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1444614048588-1194',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => 'http://www.facebook.com',
       'target' => '_blank',
    )),
    'currentpreset' => false,
    'row' => 11,
    'theme_style' => '',
    'is_edited' => true,
    'top_padding_use' => true,
    'top_padding_num' => 40,
    'left_padding_use' => true,
    'left_padding_num' => 60,
    'right_padding_use' => true,
    'right_padding_num' => 60,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 55,
         'left_padding_use' => true,
         'left_padding_num' => 375,
      )),
       'mobile' =>
      (array)(array(
         'left_padding_use' => true,
         'left_padding_num' => 60,
         'right_padding_use' => true,
         'right_padding_num' => 150,
      )),
    )),
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'anchor' => '',
    'current_preset' => 'button-social-facebook',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426160435930-1357',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 2,
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'hide' => 1,
    ),
    'desktop' =>
    array (
      'hide' => 0,
    ),
  ),
  'close_wrapper' => false,
));

$home_special_menu->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428999312133-1120',
  'id' => 'module-1428999312133-1120',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Like Us on</p><div class=""><p>Facebook</p></div><div class=""></div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428999312133-1162',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 19,
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
         'left_padding_use' => true,
         'left_padding_num' => 60,
      )),
       'mobile' =>
      (array)(array(
         'left_padding_use' => true,
         'left_padding_num' => 60,
         'right_padding_use' => true,
         'right_padding_num' => 60,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-script-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-script-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426160435930-1357',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 5,
      'top' => 0,
      'row' => 23,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 3,
      'top' => 0,
      'hide' => 1,
    ),
    'desktop' =>
    array (
      'hide' => 0,
    ),
  ),
  'close_wrapper' => false,
));

$home_special_menu->add_element("Button", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1434013057002-1989',
  'id' => 'module-1434013057002-1989',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-social-twitter',
    'usingNewAppearance' => true,
    'element_id' => 'object-1434013057002-1100',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => 'http://www.twitter.com',
       'target' => '_blank',
    )),
    'currentpreset' => false,
    'row' => 8,
    'is_edited' => true,
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 26,
         'top_padding_use' => true,
         'top_padding_num' => 40,
         'left_padding_use' => true,
         'left_padding_num' => 195,
      )),
       'mobile' =>
      (array)(array(
         'left_padding_use' => true,
         'left_padding_num' => 105,
         'right_padding_use' => true,
         'right_padding_num' => 105,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 25,
    'left_padding_use' => true,
    'left_padding_num' => 60,
    'right_padding_use' => true,
    'right_padding_num' => 60,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'anchor' => '',
    'current_preset' => 'button-social-twitter',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426160435930-1357',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 3,
      'top' => 0,
      'row' => 21,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 4,
      'hide' => 1,
      'top' => 0,
    ),
    'desktop' =>
    array (
      'hide' => 0,
    ),
  ),
  'close_wrapper' => false,
));

$home_special_menu->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429004339913-1833',
  'id' => 'module-1429004339913-1833',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="">Follow Us on</p><div class=""><p class="">Twitter</p></div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1429004339913-1997',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 22,
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
         'row' => 27,
         'left_padding_use' => true,
         'left_padding_num' => 150,
      )),
       'mobile' =>
      (array)(array(
         'row' => 19,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-script-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-script-m',
      )),
    )),
    'current_preset' => 'u-script-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426160435930-1357',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
      'order' => 6,
      'top' => 0,
      'row' => 27,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 6,
      'row' => 19,
      'top' => 0,
      'hide' => 1,
    ),
    'desktop' =>
    array (
      'hide' => 0,
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-76647 upfront-module-spacer',
  'id' => 'module-1450867715-76647',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-51312',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-32741',
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

$home_special_menu->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-42384 upfront-module-spacer',
  'id' => 'module-1450867715-42384',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-87586',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-10854',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-4210 upfront-module-spacer',
  'id' => 'module-1450867715-4210',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-43530',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-32224',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 6,
    ),
    'mobile' =>
    array (
      'col' => 6,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 6,
      'edited' => true,
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-52173 upfront-module-spacer',
  'id' => 'module-1450867715-52173',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-13229',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-22310',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453307493595-1649 upfront-module-spacer',
  'id' => 'module-1453307493595-1649',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453307493595-1710',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453307493595-1000',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 4,
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

$home_special_menu->add_element("Button", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1427803031535-1379',
  'id' => 'module-1427803031535-1379',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '#anchorTop',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-anchor',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1427803031535-1416',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/#page',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 6,
    'theme_style' => '',
    'top_padding_num' => '70',
    'bottom_padding_num' => '70',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
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
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
         'row' => 18,
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 9,
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '70',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
    'current_preset' => 'button-anchor',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1427803097896-1564',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 4,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 2,
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
      'col' => 2,
      'order' => 7,
      'top' => 0,
      'row' => 18,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 7,
      'top' => 0,
      'row' => 9,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453307495416-1914 upfront-module-spacer',
  'id' => 'module-1453307495416-1914',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453307495416-1869',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453307495416-1341',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 4,
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

$home_special_menu->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-40099 upfront-module-spacer',
  'id' => 'module-1450867715-40099',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-33819',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-89097',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_special_menu->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-77093 upfront-module-spacer',
  'id' => 'module-1450867715-77093',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-61690',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-4551',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$regions->add($home_special_menu);

$home_gallery = upfront_create_region(
			array (
  'name' => 'home-gallery',
  'title' => 'Home Gallery',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'home-gallery',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 84,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 183,
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
  'background_color' => '#ufc2',
  'version' => '1.0.0',
)
			);

$home_gallery->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-17343 upfront-module-spacer',
  'id' => 'module-1450867715-17343',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-11821',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-6634',
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

$home_gallery->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426161787193-1093',
  'id' => 'module-1426161787193-1093',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;">Gallery</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1426161787193-1940',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 27,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => 'gallery',
    'theme_style' => '',
    'top_padding_use' => true,
    'top_padding_num' => 90,
    'bottom_padding_num' => '15',
    'preset' => 'u-section-title-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '70',
         'top_padding_num' => '70',
         'row' => 16,
      )),
       'current_property' => 'top_padding_num',
    )),
    'current_preset' => 'u-section-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426161797285-1440',
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
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 16,
    ),
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-3879 upfront-module-spacer',
  'id' => 'module-1450867715-3879',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-75489',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-37074',
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

$home_gallery->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-54191 upfront-module-spacer',
  'id' => 'module-1450867715-54191',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-8230',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-81863',
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

$home_gallery->add_element("Ugallery", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426161275974-1956',
  'id' => 'module-1426161275974-1956',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'preset' => 'fancy',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => 4356,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-1-145x145-9686.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-1-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-1-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-1-140x140-9062.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 30,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-1.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => 4357,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-2-145x145-4966.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-2-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-2-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-2-140x140-2883.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 31,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-2.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => 4358,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-3-145x145-6457.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-3-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-3-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-3-140x140-9374.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 32,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-3.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => 4359,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-4-145x145-9253.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-4-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-4-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-4-140x140-7162.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 33,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-4.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => 4360,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-5-145x145-7755.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-5-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-5-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-5-140x140-9116.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 34,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-5.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => 4361,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-6-145x145-2902.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-6-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-6-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-6-140x140-1758.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 35,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-6.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => 4362,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-7-145x145-7839.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-7-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-7-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-7-140x140-5152.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 36,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-7.jpg',
         'imageLinkTarget' => '',
      )),
      7 =>
      (array)(array(
         'id' => 4363,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-8-145x145-5358.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-8-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-8-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-8-140x140-9672.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 37,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-8.jpg',
         'imageLinkTarget' => '',
      )),
      8 =>
      (array)(array(
         'id' => 4364,
         'src' => '{{upfront:style_url}}/images/archive-home/gallery-img-9-145x145-1380.jpg',
         'srcFull' => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-9-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-9-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-9-140x140-7156.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
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
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 38,
               'element_id' => 'ugallery-object-1426161275973-1113',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
         'title' => 'Image caption',
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
           'url' => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1426161275973-1113',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/archive-home/gallery-img-9.jpg',
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
    'thumbProportions' => 'theme',
    'thumbWidth' => '145',
    'thumbHeight' => 145,
    'thumbWidthNumber' => 140,
    'captionType' => 'none',
    'captionColor' => '#ffffff',
    'captionUseBackground' => 0,
    'captionBackground' => '#000000',
    'showCaptionOnHover' =>
    array (
      0 => 'true',
    ),
    'fitThumbCaptions' => false,
    'thumbCaptionsHeight' => 20,
    'linkTo' => 'image',
    'even_padding' =>
    array (
      0 => 'true',
    ),
    'thumbPadding' => 35,
    'sidePadding' => 35,
    'bottomPadding' => 35,
    'thumbPaddingNumber' => 35,
    'thumbSidePaddingNumber' => 35,
    'thumbBottomPaddingNumber' => 35,
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
    'usingNewAppearance' => true,
    'element_id' => 'ugallery-object-1426161275973-1113',
    'row' => 58,
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 155,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 84,
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 85,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'fancy',
      )),
    )),
    'thumbSidePadding' => 35,
    'current_preset' => 'fancy',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426162029531-1998',
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
      'row' => 84,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 155,
      'top' => 0,
    ),
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-41778 upfront-module-spacer',
  'id' => 'module-1450867715-41778',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-18085',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-58511',
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

$home_gallery->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426161275957-1603',
  'id' => 'module-1426161275957-1603',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class=""><span>Our coffees come with a smile.</span><span></span></h2><p class="">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica&nbsp;quam.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1426161275957-1759',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 98,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 14,
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 30,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'row' => 44,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'current_property' => 'use_padding',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_use' => true,
    'top_padding_num' => 80,
    'bottom_padding_num' => '15',
    'preset' => 'u-paragraph-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'u-paragraph-m',
      )),
    )),
    'current_preset' => 'u-paragraph-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1426161966744-1124',
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
      'row' => 14,
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
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-74597 upfront-module-spacer',
  'id' => 'module-1450867715-74597',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-7182',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-99896',
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

$home_gallery->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-18127 upfront-module-spacer',
  'id' => 'module-1450867715-18127',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-38407',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-39995',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453307485663-1031 upfront-module-spacer',
  'id' => 'module-1453307485663-1031',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453307485662-1916',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453307485663-1904',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 3,
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

$home_gallery->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453369518046-1918 upfront-module-spacer',
  'id' => 'module-1453369518046-1918',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453369518046-1886',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453369518046-1867',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 3,
      'col' => 2,
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
      'col' => 2,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$home_gallery->add_element("Button", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1427803098075-1283',
  'id' => 'module-1427803098075-1283',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '#anchorTop',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-anchor',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1427803098075-1415',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/#page',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 9,
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 6,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 10,
      )),
    )),
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '70',
    'bottom_padding_num' => '70',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_slider' => '70',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
    'padding_slider' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'button-anchor',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1430982573288-1041',
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
      'col' => 3,
      'order' => 3,
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
      'col' => 2,
      'order' => 0,
      'row' => 6,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
      'row' => 10,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453369519882-1952 upfront-module-spacer',
  'id' => 'module-1453369519882-1952',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453369519882-1501',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453369519882-1652',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
      'col' => 2,
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
      'col' => 2,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$home_gallery->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453307489335-1904 upfront-module-spacer',
  'id' => 'module-1453307489335-1904',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453307489335-1925',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453307489335-1851',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 3,
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

$home_gallery->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-48673 upfront-module-spacer',
  'id' => 'module-1450867715-48673',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-2625',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-43206',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$regions->add($home_gallery);

$home_contacts = upfront_create_region(
			array (
  'name' => 'home-contacts',
  'title' => 'Home Contacts',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'home-contacts',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 159,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 199,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 133,
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
  'background_image' => '{{upfront:style_url}}/images/archive-home/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
)
			);

$home_contacts->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-17017 upfront-module-spacer',
  'id' => 'module-1450867715-17017',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-64846',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-74503',
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-86550 upfront-module-spacer',
  'id' => 'module-1450867715-86550',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-86320',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-64078',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 0,
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-63880 upfront-module-spacer',
  'id' => 'module-1450867715-63880',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-92768',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-24810',
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

$home_contacts->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1426161275966-1819',
  'id' => 'module-1426161275966-1819',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/home-contacts-map-424x424-5007.png',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/home-contacts-map.png',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/home-contacts-map.png',
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
       'width' => 424,
       'height' => 424,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 511,
       'height' => 511,
       'top' => 4624,
       'left' => 699,
    )),
    'position' =>
    (array)(array(
       'top' => -33,
       'left' => 0,
    )),
    'marginTop' => 33,
    'element_size' =>
    (array)(array(
       'width' => 420,
       'height' => 490,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '28',
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
    'element_id' => 'image-1426161275963-1684',
    'row' => 125,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 58,
         'top_padding_use' => 'yes',
         'top_padding_num' => '70',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '70',
      )),
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 55,
         'row' => 105,
      )),
       'current_property' => 'top_padding_num',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 120,
    'bottom_padding_num' => '15',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => 0,
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
  'wrapper_id' => 'wrapper-1426163611286-1412',
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
      'col' => 10,
      'order' => 0,
      'top' => 0,
      'row' => 105,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 58,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-24248 upfront-module-spacer',
  'id' => 'module-1450867715-24248',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-46710',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-77383',
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-83825 upfront-module-spacer',
  'id' => 'module-1450867715-83825',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-73764',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-12752',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 0,
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-3412 upfront-module-spacer',
  'id' => 'module-1450867715-3412',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-3656',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-68539',
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-68101 upfront-module-spacer',
  'id' => 'module-1450867715-68101',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-24343',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-48058',
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

$home_contacts->add_group(array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1446094563957-1599',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1446094571151-1525',
  'original_col' => 9,
  'row' => 105,
  'top_padding_use' => true,
  'top_padding_num' => 185,
  'version' => '1.0.0',
  'bottom_padding_num' => '15',
  'background_color' => 'rgba(0,0,0,0)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_slider' => '15',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '15',
  'left_padding_num' => '15',
  'right_padding_num' => '15',
  'lock_padding' => 0,
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
      'row' => 16,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '15',
      'top_padding_num' => '15',
      'background_color' => 'rgba(0,0,0,0)',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '15',
      'top_padding_num' => '15',
      'row' => 68,
    ),
    'current_property' =>
    array (
      0 => 'use_padding',
    ),
  ),
));

$home_contacts->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429522463788-1536',
  'id' => 'module-1429522463788-1536',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h4 class="" style="text-align: center;"><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><span class="upfront_theme_color_6">PANiNO</span></span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429522463788-1293',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 12,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => 'ourLocation',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 13,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-brand-title-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-brand-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446094568380-1399',
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
      'col' => 10,
      'order' => 0,
      'top' => 0,
      'row' => 13,
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
  'group' => 'module-group-1446094563957-1599',
));

$home_contacts->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429522480249-1745',
  'id' => 'module-1429522480249-1745',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h5 class="" style="text-align: center;">305 Lygon Street,&nbsp;Carlton VIC 3053&nbsp;</h5>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429522480249-1779',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 11,
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
         'theme_style' => '',
         'row' => 10,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446094568392-1201',
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
      'col' => 10,
      'order' => 0,
      'row' => 10,
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
  'group' => 'module-group-1446094563957-1599',
));

$home_contacts->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429522544223-1764',
  'id' => 'module-1429522544223-1764',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">. . . . . . . . . . . . . . . . . . . . . . . . . . . . .</p>
',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429522544223-1886',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 5,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 12,
      )),
       'mobile' =>
      (array)(array(
         'row' => 4,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'u-bullets-m',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'u-bullets-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446094568397-1718',
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
      'edited' => true,
      'left' => 0,
      'col' => 10,
      'order' => 0,
      'row' => 12,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1446094563957-1599',
));

$home_contacts->add_element("PlainTxt", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429522597384-1500',
  'id' => 'module-1429522597384-1500',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">Phone: (03) 9876 5431<br>Fax: (03) 9876 5432<br>General Orders : (03) 9347 2801</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429522597384-1890',
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
         'row' => 24,
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446094568401-1048',
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
      'col' => 10,
      'order' => 0,
      'row' => 24,
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
  'group' => 'module-group-1446094563957-1599',
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-41334 upfront-module-spacer',
  'id' => 'module-1450867715-41334',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-5221',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-31574',
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-47516 upfront-module-spacer',
  'id' => 'module-1450867715-47516',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-5117',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-72352',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-25550 upfront-module-spacer',
  'id' => 'module-1450867715-25550',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-83722',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-37556',
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

$home_contacts->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-53322 upfront-module-spacer',
  'id' => 'module-1450867715-53322',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-41881',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-67263',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 5,
      'edited' => true,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-72219 upfront-module-spacer',
  'id' => 'module-1450867715-72219',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-95696',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-88392',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$home_contacts->add_element("Button", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1427803149358-1554',
  'id' => 'module-1427803149358-1554',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '#anchorTop',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-anchor',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1427803149357-1183',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/#page',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 14,
    'theme_style' => '',
    'top_padding_use' => true,
    'top_padding_num' => 70,
    'bottom_padding_num' => '70',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
         'row' => 14,
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 12,
      )),
    )),
    'padding_slider' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'button-anchor',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1427803167387-1220',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
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
      'col' => 2,
      'order' => 5,
      'top' => 0,
      'row' => 14,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 5,
      'top' => 0,
      'row' => 12,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-84924 upfront-module-spacer',
  'id' => 'module-1450867715-84924',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-44113',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-46950',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-18169 upfront-module-spacer',
  'id' => 'module-1450867715-18169',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-16385',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-8792',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 5,
    ),
    'mobile' =>
    array (
      'col' => 5,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 5,
      'edited' => true,
    ),
  ),
));

$home_contacts->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867715-16333 upfront-module-spacer',
  'id' => 'module-1450867715-16333',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867715-42646',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867715-35909',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$regions->add($home_contacts);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
