<?php
/* START_REGION_OUTPUT */
$region_95972e = upfront_create_region(
			array (
  'name' => 'header',
  'title' => 'Header',
  'type' => 'clip',
  'scope' => 'global',
  'container' => 'header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 10,
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
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc0',
)
			);

$region_95972e->add_element("PlainTxt", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471919100681-1961',
  'id' => 'module-1471919100681-1961',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: center;"><span class="upfront_theme_color_6" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_6"><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}"><strong data-redactor-tag="strong" data-verified="redactor">IM</strong></a></span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1471919100680-1298',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'logo',
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'current_preset' => 'logo',
    'row' => 12,
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'logo',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'top_padding_slider' => '0',
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
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1471919133960-1180',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 2,
      'order' => 0,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 2,
      'order' => 0,
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
      'col' => 2,
      'left' => 0,
      'top' => 0,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'col' => 2,
      'left' => 0,
      'top' => 0,
      'edited' => true,
    ),
  ),
));

$region_95972e->add_element("Unewnavigation", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470519278643-1251',
  'id' => 'module-1470519278643-1251',
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
         'menu-item-db-id' => 1039,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Issues',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1039',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'sub' =>
        array (
          0 =>
          (array)(array(
             'menu-item-db-id' => 1040,
             'menu-item-parent-id' => '1039',
             'menu-item-type' => 'custom',
             'menu-item-title' => 'TV',
             'menu-item-url' => '{{upfront:home_url}}/tv/',
             'menu-item-object' => 'custom',
             'menu-item-object-id' => '1040',
             'menu-item-target' => '',
             'menu-item-position' => 2,
             'link' =>
            (array)(array(
               'type' => 'entry',
               'url' => '{{upfront:home_url}}/tv/',
               'target' => '',
            )),
          )),
          1 =>
          (array)(array(
             'menu-item-db-id' => 1041,
             'menu-item-parent-id' => '1039',
             'menu-item-type' => 'custom',
             'menu-item-title' => 'Photography',
             'menu-item-url' => '{{upfront:home_url}}/photography/',
             'menu-item-object' => 'custom',
             'menu-item-object-id' => '1041',
             'menu-item-target' => '',
             'menu-item-position' => 3,
             'link' =>
            (array)(array(
               'type' => 'entry',
               'url' => '{{upfront:home_url}}/photography/',
               'target' => '',
            )),
          )),
          2 =>
          (array)(array(
             'menu-item-db-id' => 1042,
             'menu-item-parent-id' => '1039',
             'menu-item-type' => 'custom',
             'menu-item-title' => 'Tech News',
             'menu-item-url' => '{{upfront:home_url}}/tech-news/',
             'menu-item-object' => 'custom',
             'menu-item-object-id' => '1042',
             'menu-item-target' => '',
             'menu-item-position' => 4,
             'link' =>
            (array)(array(
               'type' => 'entry',
               'url' => '{{upfront:home_url}}/tech-news/',
               'target' => '',
            )),
          )),
          3 =>
          (array)(array(
             'menu-item-db-id' => 1043,
             'menu-item-parent-id' => '1039',
             'menu-item-type' => 'custom',
             'menu-item-title' => 'Music',
             'menu-item-url' => '{{upfront:home_url}}/music/',
             'menu-item-object' => 'custom',
             'menu-item-object-id' => '1043',
             'menu-item-target' => '',
             'menu-item-position' => 5,
             'link' =>
            (array)(array(
               'type' => 'entry',
               'url' => '{{upfront:home_url}}/music/',
               'target' => '',
            )),
          )),
          4 =>
          (array)(array(
             'menu-item-db-id' => 1044,
             'menu-item-parent-id' => '1039',
             'menu-item-type' => 'custom',
             'menu-item-title' => 'Gallery',
             'menu-item-url' => '{{upfront:home_url}}/gallery/',
             'menu-item-object' => 'custom',
             'menu-item-object-id' => '1044',
             'menu-item-target' => '',
             'menu-item-position' => 6,
             'link' =>
            (array)(array(
               'type' => 'entry',
               'url' => '{{upfront:home_url}}/gallery/',
               'target' => '',
            )),
          )),
        ),
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 1045,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'About',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1045',
         'menu-item-target' => '',
         'menu-item-position' => 7,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 1046,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'FAQ',
         'menu-item-url' => '{{upfront:home_url}}/faq/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1046',
         'menu-item-target' => '',
         'menu-item-position' => 8,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/faq/',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 1047,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Contact',
         'menu-item-url' => '{{upfront:home_url}}/contact/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '1047',
         'menu-item-target' => '',
         'menu-item-position' => 9,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/contact/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'navigation-header',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'element_id' => 'unewnavigation-object-1470519278643-1968',
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'menu_id' => false,
    'menu_slug' => 'main-menu',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'navigation-header',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'navigation-header',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'navigation-header',
      )),
    )),
    'row' => 8,
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 7,
         'top_padding_num' => '14',
         'top_padding_use' => 'yes',
         'right_padding_num' => '15',
         'right_padding_use' => 'yes',
         'left_padding_num' => '15',
         'left_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_use' => 'yes',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'left_padding_num' => '15',
         'left_padding_use' => 'yes',
         'top_padding_num' => '14',
         'top_padding_use' => 'yes',
         'right_padding_num' => '15',
         'right_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_use' => 'yes',
      )),
    )),
    'top_padding_slider' => '0',
    'breakpoint_menu_id' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'menu_id' => 67,
         'menu_slug' => 'main-menu',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470521398017-1420',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'col' => 10,
      'order' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'col' => 5,
      'order' => 1,
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
      'col' => 10,
      'left' => 0,
      'top' => 0,
      'edited' => true,
      'row' => 7,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'col' => 5,
      'left' => 0,
      'top' => 0,
      'edited' => true,
    ),
  ),
));

$regions->add($region_95972e);

/* END_REGION_OUTPUT */