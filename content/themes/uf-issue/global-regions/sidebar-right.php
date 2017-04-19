<?php
$sidebar_right_container = ( !empty($region_container) ? $region_container : "main-area" );
$sidebar_right_sub = ( !empty($region_sub) ? $region_sub: "right" );

/* START_REGION_OUTPUT */
$sidebar_right = upfront_create_region(
			array (
  'name' => 'sidebar-right',
  'title' => 'Sidebar Right',
  'type' => 'wide',
  'scope' => 'global',
  'container' => $sidebar_right_container,
  'sub' => $sidebar_right_sub,
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'col' => 5,
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
  'background_color' => '#ffffff',
  'sub_regions' =>
  array (
    0 => false,
  ),
  'region_role' => 'main',
)
			);

$sidebar_right->add_element("PlainTxt", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1467494259277-1556',
  'id' => 'module-1467494259277-1556',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">FILTER BY:</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1467494259277-1501',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 6,
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
    'bottom_padding_use' => 'yes',
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
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1467494271576-1314',
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
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$sidebar_right->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1467931467889-1849 upfront-module-spacer',
  'id' => 'module-1467931467889-1849',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1467931467889-1546',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1467931467888-1186',
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

$sidebar_right->add_element("Uwidget", array (
  'columns' => '4',
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
    'preset' => 'default',
    'widget' => 'archives-2',
    'element_id' => 'uwidget-object-1466822570563-1089',
    'current_widget' => 'archives-2',
    'current_widget_specific_settings' =>
    (array)(array(
       'widget-archives-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-archives-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-archives-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
    )),
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '5',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_widget_specific_fields' =>
    (array)(array(
       'widget-archives-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-archives-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-archives-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
    )),
    'title' => 'DATE RANGE',
    'show_date' =>
    array (
    ),
    'widget_specific_fields' =>
    (array)(array(
       'widget-archives-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-archives-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-archives-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'top_padding_use' => 'yes',
    'row' => 12,
    'dropdown' =>
    array (
    ),
    'count' =>
    array (
    ),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 15,
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'current_preset' => 'default',
    'bottom_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_slider' => '5',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1466825510397-1171',
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
      'order' => 1,
      'top' => 0,
      'row' => 15,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$sidebar_right->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1467506590522-1188 upfront-module-spacer',
  'id' => 'module-1467506590522-1188',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1467506590522-1142',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1467506590521-1967',
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

$sidebar_right->add_element("Uwidget", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470525443484-1839',
  'id' => 'module-1470525443484-1839',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'preset' => 'default',
    'widget' => 'categories-2',
    'element_id' => 'uwidget-object-1470525443483-1976',
    'current_widget' => 'categories-2',
    'current_widget_specific_settings' =>
    (array)(array(
       'widget-categories-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-categories-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-categories-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
       'widget-categories-__i__-hierarchical' =>
      (array)(array(
         'name' => 'hierarchical',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show hierarchy',
      )),
    )),
    'padding_slider' => '15',
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'default',
    'current_widget_specific_fields' =>
    (array)(array(
       'widget-categories-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-categories-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-categories-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
       'widget-categories-__i__-hierarchical' =>
      (array)(array(
         'name' => 'hierarchical',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show hierarchy',
      )),
    )),
    'title' => 'SECTIONS',
    'dropdown' =>
    array (
    ),
    'count' =>
    array (
    ),
    'hierarchical' =>
    array (
    ),
    'widget_specific_fields' =>
    (array)(array(
       'widget-categories-__i__-title' =>
      (array)(array(
         'label' => 'Title:',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
       'widget-categories-__i__-dropdown' =>
      (array)(array(
         'name' => 'dropdown',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Display as dropdown',
      )),
       'widget-categories-__i__-count' =>
      (array)(array(
         'name' => 'count',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show post counts',
      )),
       'widget-categories-__i__-hierarchical' =>
      (array)(array(
         'name' => 'hierarchical',
         'type' => 'checkbox',
         'value' => '',
         'label' => 'Show hierarchy',
      )),
    )),
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
    'breakpoint_presets' =>
    array (
    ),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470525465701-1073',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 3,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 3,
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

$sidebar_right->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470525472393-1249 upfront-module-spacer',
  'id' => 'module-1470525472393-1249',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470525472393-1505',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470525472393-1358',
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

$regions->add($sidebar_right);

/* END_REGION_OUTPUT */