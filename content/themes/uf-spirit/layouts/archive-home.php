<?php
$layout_version = '1.0.0';

$home_header = upfront_create_region(
			array (
  'name' => 'home-header',
  'title' => 'Home Header',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'home-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 174,
  'background_type' => 'image',
  'background_color' => '#ufc6',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 96,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'hide' => 1,
    )),
  )),
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
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive-home/bg-home-banner.jpg',
  'background_image_ratio' => 0.560000000000000053290705182007513940334320068359375,
)
			);

$home_header->add_element("Uimage", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452572518182-1660',
  'id' => 'module-1452572518182-1660',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/logo-main-330x209-8737.png',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/logo-main.png',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/logo-main.png',
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
       'width' => 330,
       'height' => 209,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 355,
       'height' => 225,
    )),
    'position' =>
    (array)(array(
       'top' => -8,
       'left' => 0,
    )),
    'marginTop' => 8,
    'element_size' =>
    (array)(array(
       'width' => 330,
       'height' => 217,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '63',
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
       'type' => 'homepage',
       'url' => '{{upfront:home_url}}',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1452572518178-1011',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'row' => 17,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452573352753-1930',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'col' => 7,
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

$home_header->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453442501883-1278 upfront-module-spacer',
  'id' => 'module-1453442501883-1278',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453442501882-1101',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453442501883-1992',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 2,
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

$home_header->add_element("Uspacer", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452573423386-1121 upfront-module-spacer',
  'id' => 'module-1452573423386-1121',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452573423385-1965',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452573423386-1401',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$home_header->add_element("Button", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452572518275-1268',
  'id' => 'module-1452572518275-1268',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'arrow-down',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1452572518273-1648',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/#about',
       'target' => '_self',
    )),
    'top_padding_num' => '475',
    'bottom_padding_num' => '15',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'arrow-down',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '200',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '200',
         'top_padding_num' => '200',
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
  'wrapper_id' => 'wrapper-1452573475808-1085',
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

$regions->add($home_header);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$main_area = upfront_create_region(
			array (
  'name' => 'main-area',
  'title' => 'Main Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 45,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 55,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 80,
    )),
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '60',
  'top_bg_padding_num' => '60',
  'bottom_bg_padding_slider' => '60',
  'bottom_bg_padding_num' => '60',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '',
  'version' => '1.0.0',
)
			);

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452635796269-1587 upfront-module-spacer',
  'id' => 'module-1452635796269-1587',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452635796269-1030',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452635796269-1585',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$main_area->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452576215823-1280',
  'id' => 'module-1452576215823-1280',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class="" style="text-align: center;">JOIN THE WELLNESS REVOLUTION</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452576215821-1235',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '30',
    'bottom_padding_num' => '25',
    'is_edited' => true,
    'preset' => 'default',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => 'about',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '5',
         'top_padding_num' => '5',
         'row' => 15,
      )),
       'current_property' => 'top_padding_num',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '25',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452576261287-1617',
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
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 15,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452635798507-1886 upfront-module-spacer',
  'id' => 'module-1452635798507-1886',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452635798506-1677',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452635798507-1631',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452635787544-1875 upfront-module-spacer',
  'id' => 'module-1452635787544-1875',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452635787543-1831',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452635787544-1062',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$main_area->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452635359691-1575',
  'id' => 'module-1452635359691-1575',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h3 style="text-align: center;">Learn how to bring your&nbsp;mind and body into balance, move for the pure joy of it, look good and feel connected to all that life has to offer.</h3>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452635359690-1384',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452635691989-1991',
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
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452635790442-1395 upfront-module-spacer',
  'id' => 'module-1452635790442-1395',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452635790442-1915',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452635790442-1390',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644477408-1866 upfront-module-spacer',
  'id' => 'module-1452644477408-1866',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644477408-1151',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644477408-1667',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$main_area->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644182033-1751',
  'id' => 'module-1452644182033-1751',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p style="text-align: center;">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. <a target="_self" data-upfront-link-type="entry" href="{{upfront:home_url}}/about/">Read More</a></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452644182032-1546',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 21,
      )),
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'use_padding' => 'yes',
    'padding_number' => '15',
    'left_padding_num' => '60',
    'right_padding_num' => '60',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452644436782-1103',
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
      'col' => 12,
      'order' => 0,
      'row' => 21,
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
));

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644480200-1729 upfront-module-spacer',
  'id' => 'module-1452644480200-1729',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644480199-1142',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644480200-1580',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$regions->add($main_area);

$region_14 = upfront_create_region(
			array (
  'name' => 'region-14',
  'title' => 'Region 14',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'region-14',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 100,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_position_y' => '50',
       'background_style' => 'fixed',
       'background_position_x' => '50',
       'background_type' => 'image',
       'background_repeat' => 'no-repeat',
       'background_position' => '50% 50%',
       'row' => 68,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 54,
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_repeat' => 'no-repeat',
       'background_position' => '50% 50%',
       'background_position_x' => '50',
       'background_type' => 'image',
    )),
     'current_property' => 'background_style',
  )),
  'background_type' => 'image',
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
  'background_color' => '#ffffff',
  'background_style' => 'fixed',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive-home/bg-home-about.jpg',
  'background_image_ratio' => 0.4699999999999999733546474089962430298328399658203125,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'version' => '1.0.0',
)
			);

$regions->add($region_14);

$region_4 = upfront_create_region(
			array (
  'name' => 'region-4',
  'title' => 'Region 4',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'region-4',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 21,
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
  'top_bg_padding_slider' => '60',
  'top_bg_padding_num' => '60',
  'bottom_bg_padding_slider' => '60',
  'bottom_bg_padding_num' => '60',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'version' => '1.0.0',
)
			);

$region_4->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644841601-1912 upfront-module-spacer',
  'id' => 'module-1452644841601-1912',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644841600-1386',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644841601-1595',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_4->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644436942-1006',
  'id' => 'module-1452644436942-1006',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h2 style="text-align: center;">SERVICES</h2>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452644436941-1953',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '30',
    'bottom_padding_num' => '25',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '25',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '5',
         'top_padding_num' => '5',
         'row' => 10,
      )),
       'current_property' => 'top_padding_num',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'row' => 11,
      )),
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452644756767-1477',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
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
      'row' => 11,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_4->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644838538-1872 upfront-module-spacer',
  'id' => 'module-1452644838538-1872',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644838538-1601',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644838538-1589',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_4->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644831597-1021 upfront-module-spacer',
  'id' => 'module-1452644831597-1021',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644831596-1747',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644831597-1557',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_4->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644756939-1772',
  'id' => 'module-1452644756939-1772',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h3 class="" style="text-align: center;">Whether you prefer one-on-one training or the dynamic environment of outdoor group fitness, you\'ll receive an individualized approach with high quality instructions and support.</h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452644756938-1786',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'is_edited' => true,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452644794140-1067',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
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
      'edited' => false,
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
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_4->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452644833688-1061 upfront-module-spacer',
  'id' => 'module-1452644833688-1061',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452644833687-1006',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452644833688-1997',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$regions->add($region_4);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-consultations.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-consultations.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-training.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-training.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-retreats.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-retreats.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-wellness.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 's-wellness.php');

$region_8 = upfront_create_region(
			array (
  'name' => 'region-8',
  'title' => 'Region 8',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'region-8',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
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
  'top_bg_padding_slider' => '60',
  'top_bg_padding_num' => '60',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(250,250,250,1)',
  'version' => '1.0.0',
)
			);

$region_8->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452647095628-1755',
  'id' => 'module-1452647095628-1755',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 style="text-align: center;">TESTIMONIALS</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452647095628-1044',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '25',
    'is_edited' => true,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '25',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '5',
         'top_padding_num' => '5',
         'row' => 9,
      )),
       'current_property' => 'top_padding_num',
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452648356514-1925',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
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
      'row' => 9,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$regions->add($region_8);

$region_11_a = upfront_create_region(
			array (
  'name' => 'region-11-a',
  'title' => 'Region 11 A',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'region-11-a',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 23,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '30',
       'top_bg_padding_num' => '30',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '40',
       'bottom_bg_padding_num' => '40',
       'top_bg_padding_slider' => '40',
       'top_bg_padding_num' => '40',
    )),
     'current_property' => 'top_bg_padding_num',
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
  'bottom_bg_padding_slider' => '20',
  'bottom_bg_padding_num' => '20',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(250,250,250,1)',
  'version' => '1.0.0',
)
			);

$region_11_a->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690077037-1273 upfront-module-spacer',
  'id' => 'module-1453690077037-1273',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690077037-1118',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690077037-1422',
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

$region_11_a->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453737909480-1064 upfront-module-spacer',
  'id' => 'module-1453737909480-1064',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453737909479-1121',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453737909480-1119',
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
      'order' => 1,
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

$region_11_a->add_element("Uimage", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452648555420-1969',
  'id' => 'module-1452648555420-1969',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-one-105x105-4604.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-one.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-one.jpg',
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
       'width' => 105,
       'height' => 105,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 140,
       'height' => 140,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -67.5,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 105,
       'height' => 105,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 229436,
    'align' => 'center',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'circle-image',
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
    'element_id' => 'image-1452648555414-1787',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'row' => 27,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'circle-image',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 30,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '25',
         'top_padding_num' => '25',
      )),
       'current_property' => 'top_padding_num',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453690056376-1516',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 1,
      'clear' => true,
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
      0 => 'order',
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
      'row' => 30,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_11_a->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453737911236-1608 upfront-module-spacer',
  'id' => 'module-1453737911236-1608',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453737911236-1721',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453737911236-1862',
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

$region_11_a->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690147412-1224 upfront-module-spacer',
  'id' => 'module-1453690147412-1224',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690147412-1807',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690147412-1397',
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

$region_11_a->add_group(array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1452648933642-1587',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1453690067255-1494',
  'original_col' => 19,
  'top_padding_num' => 0,
  'bottom_padding_num' => 0,
  'background_color' => 'rgba(0,0,0,0)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '15',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '15',
  'version' => '1.0.0',
  'left_padding_num' => '15',
  'right_padding_num' => '15',
  'lock_padding' => 0,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 9,
      'order' => 2,
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
      'col' => 9,
      'order' => 0,
      'top' => 0,
      'background_color' => 'rgba(0,0,0,0)',
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '0',
      'bottom_padding_num' => '0',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 64,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '0',
      'bottom_padding_num' => '0',
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_11_a->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452648356715-1881',
  'id' => 'module-1452648356715-1881',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: left;"><span style="font-weight: 300; font-family: \'Open Sans\', sans-serif; color: rgb(51, 51, 51); font-size: 22px; line-height: 1.7em; text-align: right; background-color: rgba(0, 0, 0, 0);" rel="font-weight: 300; font-family: \'Open Sans\', sans-serif; color: rgb(51, 51, 51); font-size: 22px; line-height: 1.7em; text-align: right; background-color: rgba(0, 0, 0, 0);" data-verified="redactor" data-redactor-tag="span" data-redactor-style="font-weight: 300; font-family: \'Open Sans\', sans-serif; color: rgb(51, 51, 51); font-size: 22px; line-height: 1.7em; text-align: right; background-color: rgba(0, 0, 0, 0);">"Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat..."</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452648356714-1505',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'row' => 22,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'use_padding',
       'tablet' =>
      array (
      ),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452648933644-1014',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 9,
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
      'col' => 9,
      'order' => 0,
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
  'group' => 'module-group-1452648933642-1587',
));

$region_11_a->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452648594346-1068',
  'id' => 'module-1452648594346-1068',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h6>Fiona Beauchamp</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452648594345-1991',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'row' => 5,
    'use_padding' => 'yes',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'lock_padding',
       'tablet' =>
      array (
      ),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452648933645-1543',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 9,
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
      'edited' => false,
      'left' => 0,
      'col' => 9,
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
      'row' => 6,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1452648933642-1587',
));

$region_11_a->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690081100-1365 upfront-module-spacer',
  'id' => 'module-1453690081100-1365',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690081099-1475',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690081100-1037',
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

$regions->add($region_11_a);

$region_11_b = upfront_create_region(
			array (
  'name' => 'region-11-b',
  'title' => 'Region 11 B',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'region-11-b',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 26,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 34,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '90',
       'bottom_bg_padding_num' => '90',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 64,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '90',
       'bottom_bg_padding_num' => '90',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '15',
  'top_bg_padding_num' => '15',
  'bottom_bg_padding_slider' => '60',
  'bottom_bg_padding_num' => '60',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => 'rgba(250,250,250,1)',
  'version' => '1.0.0',
)
			);

$region_11_b->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690106200-1507 upfront-module-spacer',
  'id' => 'module-1453690106200-1507',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690106199-1148',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690106200-1048',
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

$region_11_b->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453737842693-1879 upfront-module-spacer',
  'id' => 'module-1453737842693-1879',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453737842693-1201',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453737842693-1821',
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
      'order' => 0,
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

$region_11_b->add_element("Uimage", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453356812327-1244',
  'id' => 'module-1453356812327-1244',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-two-105x105-2465.jpg',
    'srcFull' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-two.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/archive-home/spirit-testimonial-two.jpg',
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
       'width' => 105,
       'height' => 105,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 140,
       'height' => 140,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 105,
       'height' => 105,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '62',
    'align' => 'center',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'circle-image',
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
    'element_id' => 'image-1453356812319-1357',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'row' => 27,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'circle-image',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453690094560-1010',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
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
      'col' => 3,
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
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_11_b->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453737844924-1705 upfront-module-spacer',
  'id' => 'module-1453737844924-1705',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453737844923-1465',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453737844924-1384',
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
      'order' => 0,
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

$region_11_b->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690149294-1392 upfront-module-spacer',
  'id' => 'module-1453690149294-1392',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690149294-1391',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690149294-1366',
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

$region_11_b->add_group(array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1453357159591-1789',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1453690102075-1872',
  'original_col' => 24,
  'top_padding_num' => 0,
  'bottom_padding_num' => '0',
  'use_padding' => 'yes',
  'lock_padding' => '',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '0',
  'background_color' => 'rgba(12,6,6,0)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => false,
  'top_padding_slider' => '15',
  'row' => 35,
  'version' => '1.0.0',
  'left_padding_num' => '15',
  'right_padding_num' => '15',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 9,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 1,
      'clear' => true,
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
      'col' => 9,
      'order' => 0,
      'top' => 0,
      'row' => 39,
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '0',
      'bottom_padding_num' => '0',
      'use_padding' => 'yes',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '0',
      'bottom_padding_num' => '0',
      'row' => 58,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$region_11_b->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357038609-1888',
  'id' => 'module-1453357038609-1888',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p class=""><span style="font-weight: 300; font-family: \'Open Sans\', sans-serif; color: rgb(51, 51, 51); font-size: 22px; line-height: 1.7em; text-align: right; background-color: rgba(0, 0, 0, 0);">"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat..."</span></p>',
    'type' => 'PlainTxtModel',
    'usingNewAppearance' => true,
    'element_id' => 'text-object-1453357038608-1945',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'row' => 23,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'use_padding',
       'tablet' =>
      array (
      ),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357159595-1235',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 9,
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
      'edited' => false,
      'left' => 0,
      'col' => 9,
      'order' => 0,
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
  'group' => 'module-group-1453357159591-1789',
));

$region_11_b->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357076345-1783',
  'id' => 'module-1453357076345-1783',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6>Jodie Lamberg</h6>',
    'type' => 'PlainTxtModel',
    'usingNewAppearance' => true,
    'element_id' => 'text-object-1453357076344-1653',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'row' => 4,
    'padding_slider' => '15',
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'lock_padding',
       'tablet' =>
      array (
      ),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357159597-1156',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 9,
      'order' => 1,
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
      'order' => 0,
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
  'group' => 'module-group-1453357159591-1789',
));

$region_11_b->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453690119512-1573 upfront-module-spacer',
  'id' => 'module-1453690119512-1573',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453690119512-1596',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453690119512-1106',
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

$regions->add($region_11_b);

$region_9 = upfront_create_region(
			array (
  'name' => 'region-9',
  'title' => 'Region 9',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'region-9',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 60,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'row' => 66,
    )),
     'current_property' => 'background_type',
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
  'background_color' => '#ufc4',
  'version' => '1.0.0',
)
			);

$region_9->add_element("Code", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453356812372-1002',
  'id' => 'module-1453356812372-1002',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'upfront-code_element-object-1453356812371-1417',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'code_selection_type' => 'Create',
    'markup' => '<div class="gift-icon"></div>',
    'style' => '/* Your styles here */
.gift-icon:before {
    content: "";
    width: 90px;
    height: 90px;
    display: block;
    position: relative;
    margin: -60px auto 0;
    background: url("{{upfront:style_url}}/ui/sprite.png") no-repeat transparent;
    background-image: url("{{upfront:style_url}}/ui/sprite.svg"), none;
    background-position: -355px -675px;
}',
    'script' => '/* Your code here */',
    'row' => 8,
    'padding_slider' => '15',
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 8,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'current_property' => 'top_padding_num',
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357391773-1456',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 1,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 0,
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
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 8,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357689263-1980 upfront-module-spacer',
  'id' => 'module-1453357689263-1980',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357689262-1644',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357689262-1168',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_9->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357115573-1505',
  'id' => 'module-1453357115573-1505',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h5 style="text-align: center;"><span class="upfront_theme_color_7">JOIN THE WELLNESS REVOLUTION</span></h5>',
    'type' => 'PlainTxtModel',
    'usingNewAppearance' => true,
    'element_id' => 'text-object-1453357115573-1392',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '15',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'row' => 11,
    'padding_slider' => '15',
    'preset' => 'default',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357537044-1003',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357695021-1786 upfront-module-spacer',
  'id' => 'module-1453357695021-1786',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357695020-1832',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357695021-1947',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357692073-1617 upfront-module-spacer',
  'id' => 'module-1453357692073-1617',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357692072-1000',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357692073-1837',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_9->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357537364-1338',
  'id' => 'module-1453357537364-1338',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: center;">Receive a weekly serving of motivation, recipes and <strong data-redactor-tag="strong" data-verified="redactor"><span class="upfront_theme_color_0">FREE</span></strong> resources directly to your inbox.</p>',
    'type' => 'PlainTxtModel',
    'usingNewAppearance' => true,
    'element_id' => 'text-object-1453357537363-1570',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'row' => 6,
    'padding_slider' => '15',
    'preset' => 'default',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357589629-1145',
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
      'edited' => true,
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
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357699118-1616 upfront-module-spacer',
  'id' => 'module-1453357699118-1616',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357699116-1478',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357699117-1862',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 3,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357805054-1349 upfront-module-spacer',
  'id' => 'module-1453357805054-1349',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357805053-1157',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357805054-1119',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
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
      'col' => 5,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 5,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$region_9->add_element("Code", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357391989-1053',
  'id' => 'module-1453357391989-1053',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'upfront-code_element-object-1453357391988-1398',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'code_selection_type' => 'Create',
    'markup' => '<form name="newsletter" class="newsletter-form" action="" method="post">
    <input type="email" name="user-email" placeholder="Email address">
    <input type="submit" value="Send">
</form>',
    'style' => '/* Your styles here */
.newsletter-form {
    padding:0px;
    margin:0px;
    width:100%;
}

.newsletter-form input[type="email"] {
    width: 75%;
    text-indent: 15px;
    line-height: 38px;
    height: 38px;
    box-sizing: border-box;
    font: 15px \'Open Sans\', Arial;
    font-weight: 300;
    color: #707070;
    background: #ufc6;
    outline: 0px;
    border: 1px solid #ufc6;
    border-radius: 4px 0 0 4px;
    display: inline-block;
    float:left;
}

.newsletter-form input[type="email"]:focus {
 outline: 0px;
 border: 1px solid #ufc0;
 color:#ufc7;
}

.newsletter-form input[type="submit"] {
    background: #ufc0;
    border-bottom: 2px solid #ufc1;
    border-radius: 0 4px 4px 0;
    color: #ufc6;
    font-family: "Oswald", Arial, sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 38px;
    height: 38px;
    width: 25%;
    padding: 0px;
    margin:0px;
    text-decoration: none;
    text-transform: uppercase;
    -moz-transition: background-color .2s;
    -ms-transition: background-color .2s;
    -o-transition: background-color .2s;
    -webkit-transition: background-color .4s;
    transition: background-color .2s;
}
.newsletter-form input[type="submit"]:hover {
   background: #ufc1;
}',
    'row' => 8,
    'script' => '/* Your code here */',
    'padding_slider' => '15',
    'preset' => 'default',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453357708384-1745',
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
      'edited' => true,
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
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$region_9->add_element("Uspacer", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453357809036-1586 upfront-module-spacer',
  'id' => 'module-1453357809036-1586',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1453357809035-1026',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453357809036-1155',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
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
      'col' => 5,
      'left' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'col' => 5,
      'left' => 0,
      'top' => 0,
    ),
  ),
));

$regions->add($region_9);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
