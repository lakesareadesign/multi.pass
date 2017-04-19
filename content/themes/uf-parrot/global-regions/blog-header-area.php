<?php
/* START_REGION_OUTPUT */
$navigation_secondary = upfront_create_region(
			array (
  'name' => 'navigation-secondary',
  'title' => 'navigation-secondary',
  'type' => 'wide',
  'scope' => 'global',
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
  'region_role' => false,
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
    'src' => '{{upfront:style_url}}/images/global-regions/blog-header-area/logo-36x35-2629.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/blog-header-area/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/blog-header-area/logo.png',
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
    (array)(array(
    )),
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
         'menu-item-db-id' => 640,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '640',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}',
           'target' => '',
           'display_url' => '{{upfront:home_url}}',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 641,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Features',
         'menu-item-url' => '{{upfront:home_url}}/features/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '641',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/features/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/features/',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 642,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Download',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '642',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/download/',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 643,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact Us',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '643',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/contact/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/contact/',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 644,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '644',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/about/',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 645,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '645',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
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

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$blog_header_area = upfront_create_region(
			array (
  'name' => 'blog-header-area',
  'title' => 'Blog Header Area',
  'type' => 'wide',
  'scope' => 'global',
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
  'background_image' => '{{upfront:style_url}}/images/global-regions/blog-header-area/hero-4.jpg',
  'background_image_ratio' => 0.31,
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => false,
)
			);

$blog_header_area->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-21994 upfront-module-spacer',
  'id' => 'module-1450121556-21994',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-81253',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-93905',
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-94674 upfront-module-spacer',
  'id' => 'module-1450121556-94674',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-99470',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-3401',
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-95823 upfront-module-spacer',
  'id' => 'module-1450121556-95823',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-14465',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-55313',
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

$blog_header_area->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444704102177-1076',
  'id' => 'module-1444704102177-1076',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/blog-header-area/parrot-logo-text-green-136x45-1148.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/blog-header-area/parrot-logo-text-green.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/blog-header-area/parrot-logo-text-green.png',
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
       'top' => 0,
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
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1444704102176-1891',
    'row' => 17,
    'top_padding_use' => true,
    'top_padding_num' => 60,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'row' => 10,
      )),
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'row' => 12,
      )),
       'current_property' => 'top_padding_num',
    )),
    'bottom_padding_num' => '10',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
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
  'wrapper_id' => 'wrapper-1444704116474-1229',
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
      'row' => 12,
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-86325 upfront-module-spacer',
  'id' => 'module-1450121556-86325',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-60543',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-42214',
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-89490 upfront-module-spacer',
  'id' => 'module-1450121556-89490',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-36309',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-37433',
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

$blog_header_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-12886 upfront-module-spacer',
  'id' => 'module-1450121556-12886',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-82555',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-64873',
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

$blog_header_area->add_element("Posts", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1430415942775-1618',
  'id' => 'module-1430415942775-1618',
  'options' =>
  array (
    'type' => 'PostsModel',
    'view_class' => 'PostsView',
    'has_settings' => 1,
    'class' => 'c24 uposts-object',
    'id_slug' => 'posts',
    'display_type' => 'list',
    'list_type' => 'generic',
    'offset' => '1',
    'taxonomy' => '',
    'term' => '',
    'content' => 'excerpt',
    'limit' => '3',
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'thumbnail_size' => 'large',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'featured_image',
      1 => 'title',
      2 => 'content',
      3 => 'author',
      4 => 'date_posted',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'featured_image',
      3 => 'title',
      4 => 'content',
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
    'post-part-date_posted' => '<div class="uposts-part date_posted"> <span class="date">{{date_1}}</span> <span class="time">{{date_2}}</span> <span class="year">{{date_3}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">
	By <a href="{{url}}">{{name}}</a> -&nbsp;</div>',
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
    'element_id' => 'posts-object-1430415942771-1101',
    'row' => 89,
    'anchor' => '',
    'post_type' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 8,
         'theme_style' => '',
      )),
       'mobile' =>
      (array)(array(
         'row' => 329,
         'theme_style' => '',
      )),
       'current_property' => 'use_padding',
    )),
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
  'wrapper_id' => 'wrapper-1430876322089-1352',
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
      'row' => 8,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 329,
    ),
  ),
));

$blog_header_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121556-45495 upfront-module-spacer',
  'id' => 'module-1450121556-45495',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121556-73935',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121556-91784',
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

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$header_bottom = upfront_create_region(
			array (
  'name' => 'header_bottom',
  'title' => 'Header Area bottom',
  'type' => 'wide',
  'scope' => 'global',
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
  'region_role' => false,
)
			);

$regions->add($header_bottom);

/* END_REGION_OUTPUT */