<?php
/* START_REGION_OUTPUT */
$region_64c3bb = upfront_create_region(
			array (
  'name' => 'header',
  'title' => 'Header',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 30,
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,1)',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 16,
       'background_type' => 'color',
       'bg_padding_type' => 'varied',
       'bottom_bg_padding_slider' => '5',
       'bottom_bg_padding_num' => '5',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 19,
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '10',
  'top_bg_padding_num' => '10',
  'bottom_bg_padding_slider' => '10',
  'bottom_bg_padding_num' => '10',
  'bg_padding_slider' => '10',
  'bg_padding_num' => '10',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/global-regions/header/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'region_role' => 'banner',
)
			);

$region_64c3bb->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450887910297-1176 upfront-module-spacer',
  'id' => 'module-1450887910297-1176',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450887910296-1662',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450887910297-1212',
  'new_line' => true,
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

$region_64c3bb->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450887526922-1889',
  'id' => 'module-1450887526922-1889',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/header/logo-main-128x55-8099.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/header/logo-main.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/header/logo-main.png',
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
       'width' => 128,
       'height' => 56,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 128,
       'height' => 56,
    )),
    'position' =>
    (array)(array(
       'top' => 0.5,
       'left' => -16,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 55,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '4',
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
       'type' => 'homepage',
       'url' => '{{upfront:home_url}}',
       'target' => false,
       'display_url' => '{{upfront:home_url}}',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1450887526917-1886',
    'top_padding_num' => 15,
    'bottom_padding_num' => 15,
    'row' => 17,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 14,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'row' => 15,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'current_preset' => 'default',
    'breakpoint_presets' =>
    array (
    ),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1450887775394-1380',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
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
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 14,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 15,
    ),
  ),
));

$region_64c3bb->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450888422203-1095 upfront-module-spacer',
  'id' => 'module-1450888422203-1095',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450888422202-1818',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450888422203-1354',
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

$region_64c3bb->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453685186051-1611 upfront-module-spacer',
  'id' => 'module-1453685186051-1611',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453685186051-1369',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453685186051-1704',
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

$region_64c3bb->add_element("Unewnavigation", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450887526944-1953',
  'id' => 'module-1450887526944-1953',
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
         'menu-item-db-id' => 283,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Home',
         'menu-item-url' => '{{upfront:home_url}}',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '283',
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
         'menu-item-db-id' => 284,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '284',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/about/',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 285,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Portfolio',
         'menu-item-url' => '{{upfront:home_url}}/portfolio/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '285',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/portfolio/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/portfoli...',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 286,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Pricing',
         'menu-item-url' => '{{upfront:home_url}}/pricing/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '286',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/pricing/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/pricing/',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 287,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'News',
         'menu-item-url' => '{{upfront:home_url}}/news/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '287',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/news/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/news/',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 288,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '288',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'menu-item-classes' => '',
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/contact/',
           'target' => '',
           'display_url' => '{{upfront:home_url}}/contact/',
        )),
      )),
    ),
    'preset' => 'menu-header',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'usingNewAppearance' => true,
    'element_id' => 'unewnavigation-object-1450887526941-1305',
    'top_padding_num' => '0',
    'bottom_padding_num' => '10',
    'menu_slug' => 'luke-menu',
    'menu_id' => false,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'left_padding_use' => '',
    'right_padding_use' => '',
    'top_padding_use' => 'yes',
    'bottom_padding_use' => '',
    'row' => 5,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '20',
         'top_padding_slider' => '20',
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '20',
         'top_padding_slider' => '20',
         'row' => 9,
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'menu-header',
      )),
    )),
    'top_padding_slider' => '0',
    'current_preset' => 'menu-header',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1450890402548-1546',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 8,
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
      'col' => 8,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
      'row' => 9,
    ),
  ),
));

$region_64c3bb->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453685189540-1813 upfront-module-spacer',
  'id' => 'module-1453685189540-1813',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453685189539-1727',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453685189540-1761',
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

$regions->add($region_64c3bb);

/* END_REGION_OUTPUT */