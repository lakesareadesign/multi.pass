<?php
$navigation_primary_container = ( !empty($region_container) ? $region_container : "index-header" );
$navigation_primary_sub = ( !empty($region_sub) ? $region_sub: "left" );

/* START_REGION_OUTPUT */
$navigation_primary = upfront_create_region(
			array (
  'name' => 'navigation-primary',
  'title' => 'navigation-primary',
  'type' => 'wide',
  'scope' => 'global',
  'container' => $navigation_primary_container,
  'sub' => $navigation_primary_sub,
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => 5,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'row' => 14,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'hide' => 0,
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

$navigation_primary->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-61997 upfront-module-spacer',
  'id' => 'module-1450121214-61997',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-61492',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-52064',
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

$navigation_primary->add_element("Uimage", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444095544643-1268',
  'id' => 'module-1444095544643-1268',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/navigation-primary/logo-35x35-1016.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/navigation-primary/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/navigation-primary/logo.png',
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
       'width' => 35,
       'height' => 35,
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
       'height' => 35,
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
    'element_id' => 'image-1444095544633-1421',
    'row' => 29,
    'no_padding' => '',
    'anchor' => '',
    'link_target' => '_self',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 11,
         'top_padding_use' => true,
         'top_padding_num' => 30,
      )),
       'mobile' =>
      (array)(array(
         'row' => 10,
         'top_padding_use' => true,
         'top_padding_num' => 20,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 100,
    'bottom_padding_num' => '10',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_slider' => '10',
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
  'wrapper_id' => 'wrapper-1444095624865-1950',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 2,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 2,
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
      'col' => 2,
      'order' => 0,
      'row' => 11,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'top' => 0,
      'row' => 9,
      'hide' => 0,
    ),
  ),
));

$navigation_primary->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-63081 upfront-module-spacer',
  'id' => 'module-1450121214-63081',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-71619',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-10375',
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

$navigation_primary->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-68700 upfront-module-spacer',
  'id' => 'module-1450121214-68700',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-33764',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-25688',
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

$navigation_primary->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-26854 upfront-module-spacer',
  'id' => 'module-1450121214-26854',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-15076',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-86042',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 1,
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

$navigation_primary->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-60693 upfront-module-spacer',
  'id' => 'module-1450121214-60693',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-14401',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-33124',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 1,
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

$navigation_primary->add_element("Unewnavigation", array (
  'columns' => '4',
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
         'menu-item-db-id' => 307,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '307',
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
         'menu-item-db-id' => 308,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Features',
         'menu-item-url' => '{{upfront:home_url}}/features/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '308',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/features/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/features...',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 309,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Download',
         'menu-item-url' => '{{upfront:home_url}}/download/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '309',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/download/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/download...',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 310,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact Us',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '310',
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
         'menu-item-db-id' => 311,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '311',
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
         'menu-item-db-id' => 312,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Blog',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '312',
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
    'preset' => 'parrot-main-nav-1-m',
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
         'row' => 12,
         'theme_style' => '',
         'is_floating' => 'no',
         'top_padding_use' => true,
         'top_padding_num' => 30,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'burger_alignment' => 'right',
         'menu_style' => 'triggered',
         'menu_alignment' => 'right',
         'burger_over' => 'over',
         'width' => 315,
         'row' => 12,
         'is_floating' => 'no',
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 20,
      )),
       'current_property' => 'use_padding',
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-main-nav',
    'row' => 43,
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
         'preset' => 'parrot-main-nav-1-m',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'parrot-main-nav-1-m',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'parrot-main-nav-1-m',
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
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 2,
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
      'col' => 2,
      'order' => 0,
      'row' => 12,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'row' => 11,
      'top' => 0,
    ),
  ),
));

$regions->add($navigation_primary);

/* END_REGION_OUTPUT */