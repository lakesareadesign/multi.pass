<?php
$sidebar_left_container = ( !empty($region_container) ? $region_container : "block-content" );
$sidebar_left_sub = ( !empty($region_sub) ? $region_sub: "right" );

/* START_REGION_OUTPUT */
$sidebar_left = upfront_create_region(
			array (
  'name' => 'sidebar-left',
  'title' => 'Sidebar Left',
  'type' => 'wide',
  'scope' => 'global',
  'container' => $sidebar_left_container,
  'sub' => $sidebar_left_sub,
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'col' => 6,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'hide' => 1,
    )),
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '45',
  'bottom_bg_padding_num' => '45',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(0,0,0,0)',
  'sub_regions' =>
  array (
    0 => false,
  ),
)
			);

$sidebar_left->add_element("Uwidget", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466822570564-1788',
  'id' => 'module-1466822570564-1788',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'preset' => 'widget-alternative',
    'widget' => 'recent-posts-2',
    'element_id' => 'uwidget-object-1466822570563-1089',
    'current_widget' => 'recent-posts-2',
    'current_widget_specific_settings' =>
    (array)(array(
       'widget-recent-posts-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-recent-posts-__i__-number' =>
      (array)(array(
         'label' => 'Number of posts to show:',
         'name' => 'number',
         'type' => 'number',
         'value' => '5',
      )),
       'widget-recent-posts-__i__-show_date' =>
      (array)(array(
         'name' => 'show_date',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display post date?',
      )),
    )),
    'padding_slider' => '15',
    'top_padding_num' => '5',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_widget_specific_fields' =>
    (array)(array(
       'widget-recent-posts-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-recent-posts-__i__-number' =>
      (array)(array(
         'label' => 'Number of posts to show:',
         'name' => 'number',
         'type' => 'number',
         'value' => '5',
      )),
       'widget-recent-posts-__i__-show_date' =>
      (array)(array(
         'name' => 'show_date',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display post date?',
      )),
    )),
    'title' => 'NEWEST NEWS',
    'show_date' =>
    array (
    ),
    'widget_specific_fields' =>
    (array)(array(
       'widget-recent-posts-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-recent-posts-__i__-number' =>
      (array)(array(
         'label' => 'Number of posts to show:',
         'name' => 'number',
         'type' => 'number',
         'value' => '5',
      )),
       'widget-recent-posts-__i__-show_date' =>
      (array)(array(
         'name' => 'show_date',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display post date?',
      )),
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'widget-alternative',
      )),
    )),
    'top_padding_use' => 'yes',
    'row' => 12,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'widget-alternative',
    'top_padding_slider' => '5',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466825510397-1171',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 6,
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
      'col' => 6,
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

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466825544792-1638 upfront-module-spacer',
  'id' => 'module-1466825544792-1638',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466825544792-1506',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466825544791-1319',
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

$sidebar_left->add_group(array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1466893545608-1404',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1466893505276-1415',
  'original_col' => 6,
  'top_padding_num' => '20',
  'bottom_padding_num' => '25',
  'use_padding' => 'yes',
  'edited' => true,
  'background_color' => 'rgba(240,246,245,1)',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '20',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '25',
  'lock_padding' => '',
  'row' => 39,
  'href' => '{{upfront:home_url}}/contact/',
  'linkTarget' => false,
  'left_padding_num' => '15',
  'right_padding_num' => '15',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 6,
      'order' => 2,
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
      'edited' => false,
      'left' => 0,
      'col' => 6,
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

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466893505277-1682 upfront-module-spacer',
  'id' => 'module-1466893505277-1682',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466893505277-1984',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466893545609-1202',
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
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("Uimage", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466890533011-1850',
  'id' => 'module-1466890533011-1850',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/sidebar-left/i-icons-105x50-4790.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/sidebar-left/i-icons.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/sidebar-left/i-icons.png',
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
       'width' => 960,
       'height' => 1120,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 960,
       'height' => 1120,
       'top' => 400,
       'left' => 1695,
    )),
    'position' =>
    (array)(array(
       'top' => 216,
       'left' => 828,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 105,
       'height' => 50,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '388',
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
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'element_id' => 'image-1466890533010-1827',
    'padding_slider' => '15',
    'top_padding_num' => '35',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'valign' => 'center',
    'isDotAlign' => false,
    'row' => 16,
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
    'current_preset' => 'default',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '35',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466893545609-1242',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 4,
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
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 4,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466893442329-1763 upfront-module-spacer',
  'id' => 'module-1466893442329-1763',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466893442329-1955',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466893545611-1596',
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
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471923628101-1837 upfront-module-spacer',
  'id' => 'module-1471923628101-1837',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471923628101-1105',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471923628100-1133',
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
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("PlainTxt", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466890533010-1778',
  'id' => 'module-1466890533010-1778',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: center;"><span style="color:rgb(131, 142, 141)" rel="color:rgb(131, 142, 141)" data-verified="redactor" data-redactor-tag="span" data-redactor-style="color:rgb(131, 142, 141)">CONTACT US NOW</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1466890533010-1688',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '30',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 11,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'top_padding_use' => 'yes',
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
    'current_preset' => 'default',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466893545612-1636',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 2,
      'clear' => false,
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
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471923626551-1744 upfront-module-spacer',
  'id' => 'module-1471923626551-1744',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471923626550-1557',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471923626550-1087',
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
  'group' => 'module-group-1466893545608-1404',
));

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466893547953-1830 upfront-module-spacer',
  'id' => 'module-1466893547953-1830',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466893547953-1180',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466893547952-1035',
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

$sidebar_left->add_element("Uimage", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466893370411-1369',
  'id' => 'module-1466893370411-1369',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/sidebar-left/img-poster-195x277-4498.jpg',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/sidebar-left/img-poster.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/sidebar-left/img-poster.jpg',
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
       'width' => 195,
       'height' => 277,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 190,
       'height' => 270,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 195,
       'height' => 277,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '39',
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
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'element_id' => 'image-1466893370409-1176',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'valign' => 'center',
    'isDotAlign' => false,
    'row' => 62,
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
    'current_preset' => 'default',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466893917998-1326',
  'new_line' => true,
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

$sidebar_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1466894068570-1709 upfront-module-spacer',
  'id' => 'module-1466894068570-1709',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1466894068570-1645',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1466894068568-1304',
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

$regions->add($sidebar_left);

/* END_REGION_OUTPUT */