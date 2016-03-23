<?php
/* START_REGION_OUTPUT */
$bullets = upfront_create_region(
			array (
  'name' => 'bullets',
  'title' => 'Bullets',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'bullets',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 8,
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
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/global-regions/bullets/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
)
			);

$bullets->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450973283509-1469 upfront-module-spacer',
  'id' => 'module-1450973283509-1469',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1450973283508-1219',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450973283509-1918',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$bullets->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192798-64999 upfront-module-spacer',
  'id' => 'module-1451192798-64999',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451192798-92580',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192798-64727',
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

$bullets->add_element("Code", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450904872545-1553',
  'id' => 'module-1450904872545-1553',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'element_id' => 'upfront-code_element-object-1450904872544-1598',
    'top_padding_num' => '70',
    'bottom_padding_num' => '70',
    'code_selection_type' => 'Create',
    'markup' => '<div class="bullets"></div>',
    'style' => '/* Your styles here */
.bullets {
    width: 52px;
    height: 32px;
    display: block;
    margin: 0 auto;
    background: url("{{upfront:style_url}}/ui/sprites-v2.png");
    background-image: url("{{upfront:style_url}}/ui/sprites-v2.svg"), none;
    background-position: -374px -64px;
}',
    'script' => '/* Your code here */',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '70',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1450905065836-1979',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 4,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => false,
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
      'col' => 4,
      'order' => 1,
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

$bullets->add_element("Uspacer", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450973288190-1649 upfront-module-spacer',
  'id' => 'module-1450973288190-1649',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1450973288189-1163',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450973288190-1132',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 11,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$bullets->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192798-5120 upfront-module-spacer',
  'id' => 'module-1451192798-5120',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451192798-23130',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192798-61419',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
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

$regions->add($bullets);

/* END_REGION_OUTPUT */