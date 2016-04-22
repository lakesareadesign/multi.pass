<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$uf_404_content = upfront_create_region(
			array (
  'name' => '404-content',
  'title' => '404 Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => '404-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 101,
  'background_type' => 'image',
  'background_color' => '#ufc5',
  'version' => '1.0.0',
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
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '200',
  'top_bg_padding_num' => '200',
  'bottom_bg_padding_slider' => '200',
  'bottom_bg_padding_num' => '200',
  'bg_padding_slider' => '220',
  'bg_padding_num' => '220',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-404_page/404_background.jpg',
  'background_image_ratio' => 0.38000000000000000444089209850062616169452667236328125,
)
			);

$uf_404_content->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393279733-1522 upfront-module-spacer',
  'id' => 'module-1451393279733-1522',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451393279733-1995',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451393279733-1019',
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

$uf_404_content->add_element("PlainTxt", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393236187-1804',
  'id' => 'module-1451393236187-1804',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h1 style="text-align: center;"><span class="upfront_theme_color_5">SOMETHING IS NOT RIGHT</span></h1>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451393236187-1800',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '20',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '20',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451393256415-1318',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 4,
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
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
  ),
));

$uf_404_content->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393289502-1666 upfront-module-spacer',
  'id' => 'module-1451393289502-1666',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451393289502-1379',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451393289502-1340',
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

$uf_404_content->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393448101-1155 upfront-module-spacer',
  'id' => 'module-1451393448101-1155',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451393448101-1351',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451393448101-1973',
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

$uf_404_content->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452734991854-1712 upfront-module-spacer',
  'id' => 'module-1452734991854-1712',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452734991853-1902',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452734991854-1856',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 4,
    ),
  ),
));

$uf_404_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452735055381-1962 upfront-module-spacer',
  'id' => 'module-1452735055381-1962',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452735055380-1326',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452735055381-1029',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 1,
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
));

$uf_404_content->add_element("Button", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393236243-1718',
  'id' => 'module-1451393236243-1718',
  'options' =>
  array (
    'content' => 'TAKE ME HOME',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'white-button',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1451393236242-1721',
    'link' =>
    (array)(array(
       'type' => 'homepage',
       'url' => '{{upfront:home_url}}',
       'target' => '',
    )),
    'top_padding_num' => '20',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'row' => 14,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '20',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451393376492-1563',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
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
      'col' => 4,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
));

$uf_404_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452735057550-1474 upfront-module-spacer',
  'id' => 'module-1452735057550-1474',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452735057550-1135',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452735057550-1902',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
));

$uf_404_content->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452734995485-1880 upfront-module-spacer',
  'id' => 'module-1452734995485-1880',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452734995485-1175',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452734995485-1819',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
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
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 4,
    ),
  ),
));

$uf_404_content->add_element("Uspacer", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451393463296-1560 upfront-module-spacer',
  'id' => 'module-1451393463296-1560',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451393463295-1315',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451393463296-1867',
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

$regions->add($uf_404_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
