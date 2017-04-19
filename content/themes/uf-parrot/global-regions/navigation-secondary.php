<?php
$navigation_secondary_container = ( !empty($region_container) ? $region_container : "header" );
$navigation_secondary_sub = ( !empty($region_sub) ? $region_sub: "left" );

/* START_REGION_OUTPUT */
$navigation_secondary = upfront_create_region(
			array (
  'name' => 'navigation-secondary',
  'title' => 'navigation-secondary',
  'type' => 'wide',
  'scope' => 'global',
  'container' => $navigation_secondary_container,
  'sub' => $navigation_secondary_sub,
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
    'src' => '{{upfront:style_url}}/images/global-regions/navigation-secondary/logo-36x35-2629.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/navigation-secondary/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/navigation-secondary/logo.png',
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
         'menu-item-db-id' => 14,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '14',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'homepage',
           'url' => '{{upfront:home_url}}',
           'target' => '',
           'display_url' => '{{upfront:home_url}}',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 15,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Features',
         'menu-item-url' => '{{upfront:home_url}}/features/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '15',
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
         'menu-item-db-id' => 16,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'post_type',
         'menu-item-title' => 'Download',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'page',
         'menu-item-object-id' => '3',
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
         'menu-item-db-id' => 17,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact Us',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '17',
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
         'menu-item-db-id' => 18,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '18',
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
         'menu-item-db-id' => 19,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '19',
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