<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$pe_slider = upfront_create_region(
			array (
  'name' => 'pe-slider',
  'title' => 'PE Slider',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'pe-slider',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 104,
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
  'background_type' => 'slider',
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
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio-extended/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'hover',
  'background_slider_images' =>
  array (
    0 => 'images/bg-happy.jpg',
    1 => 'images/bg-wedding.jpg',
  ),
  'version' => '1.0.0',
)
			);

$regions->add($pe_slider);

$pe_content = upfront_create_region(
			array (
  'name' => 'pe-content',
  'title' => 'PE Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'pe-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 114,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 151,
       'hide' => 0,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 181,
    )),
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ufc5',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio-extended/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '10',
  'top_bg_padding_num' => '10',
  'bottom_bg_padding_slider' => '10',
  'bottom_bg_padding_num' => '10',
  'bg_padding_slider' => '10',
  'bg_padding_num' => '10',
)
			);

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-73562 upfront-module-spacer',
  'id' => 'module-1451192746-73562',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-33956',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-12213',
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

$pe_content->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428710403815-1476',
  'id' => 'module-1428710403815-1476',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container" style="text-align: center;">
<font color="#333333" face="Quattrocento, serif"><span style="font-size: 60px; line-height: 72px;">Harry + Sally</span></font>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428710403814-1437',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 18,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '_default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 13,
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_num' => '50',
         'top_padding_slider' => '50',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_num' => '40',
         'top_padding_slider' => '40',
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 70,
    'bottom_padding_num' => '10',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1428706223198-1717',
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
      'edited' => true,
      'col' => 7,
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
      'col' => 12,
      'order' => 0,
      'row' => 13,
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

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-13561 upfront-module-spacer',
  'id' => 'module-1451192746-13561',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-44568',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-84038',
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

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145340151-1124 upfront-module-spacer',
  'id' => 'module-1452145340151-1124',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145340151-1457',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145340151-1653',
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

$pe_content->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145288549-1321',
  'id' => 'module-1452145288549-1321',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h6 class="" style="text-align: center;">I LOVE ALL THINGS VINTAGE AND FLORAL AND BELIEVE OUR WEDDING TURNED OUT TO BE AN UNINTENTIONAL "GATSBY" VIBE.</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452145288549-1723',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '30',
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452145295842-1511',
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

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145344169-1775 upfront-module-spacer',
  'id' => 'module-1452145344169-1775',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145344168-1630',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145344169-1381',
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

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145132120-1501 upfront-module-spacer',
  'id' => 'module-1452145132120-1501',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145132120-1081',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145132120-1624',
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

$pe_content->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452143862872-1177',
  'id' => 'module-1452143862872-1177',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<p>Hoodie cornhole mustache, sustainable locavore fashion axe leggings twee blog forage you probably haven’t heard of them pour-over drinking vinegar Shoreditch chillwave. Cred readymade Echo Park, asymmetrical tattooed fashion axe salvia tote bag four loko pour-over distillery bicycle rights leggings vinyl chia. Keffiyeh photo booth 90’s Kickstarter, viral meh Bushwick gluten-free mumblecore. PBR craft beer pug, direct trade keffiyeh flannel vegan heirloom literally PBR&amp;B you probably haven’t trust fund bicycle rights leggings vinyl chia. Keffiyeh photo booth 90’s Kickstarter.</p><p>Normcore paleo pop-up gastropub kitsch messenger bag. Drinking vinegar ennui post-ironic twee flannel High Life, XOXO vegan. McSweeney’s trust fund cardigan, umami mixtape Tonx direct trade actually twee Carles kitsch whatever Marfa. Synth flannel blog heirloom. Portland 90’s Intelligentsia, flannel artisan crucifix pour-over. Mustache Tumblr pickled, vegan salvia selfies Austin roof party polaroid ugh. Shabby chic chambray normcore retro, mixtape drinking vinegar cardigan Drinking vinegar ennui post-ironic twee flannel High Life, XOXO vegan. McSweeney’s trust fund cardigan, umami mixtape.<br>&nbsp;</p>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452143862872-1692',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 72,
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452144247926-1131',
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

$pe_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145135639-1822 upfront-module-spacer',
  'id' => 'module-1452145135639-1822',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145135639-1398',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145135639-1455',
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

$regions->add($pe_content);

$pe_images = upfront_create_region(
			array (
  'name' => 'pe-images',
  'title' => 'PE Images',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'pe-images',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 134,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'hide' => 0,
       'col' => 24,
       'row' => 114,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'hide' => 0,
       'row' => 148,
    )),
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ufc5',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio-extended/noise.jpg',
  'background_image_ratio' => 1,
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => '80',
  'bg_padding_num' => '80',
  'background_repeat' => 'repeat',
)
			);

$pe_images->add_element("Uimage", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144297005-1982',
  'id' => 'module-1452144297005-1982',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-one-1080x635-7918.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-one.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-one.jpg',
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
       'width' => 1080,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 1080,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 1080,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1770',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144297001-1553',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'row' => 127,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 37,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144417167-1254',
  'new_line' => true,
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
      'col' => 12,
      'order' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 37,
    ),
  ),
));

$pe_images->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144526272-1517',
  'id' => 'module-1452144526272-1517',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-two-450x635-6128.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-two.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-two.jpg',
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
       'width' => 450,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 450,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 450,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1771',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144526265-1851',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'row' => 127,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 89,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144531694-1836',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 5,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 89,
    ),
  ),
));

$pe_images->add_element("Uimage", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144531874-1910',
  'id' => 'module-1452144531874-1910',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-three-630x635-3456.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-three.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-three.jpg',
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
       'width' => 630,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 630,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 630,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1772',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144531870-1915',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'row' => 127,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 63,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144584132-1255',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 7,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 63,
    ),
  ),
));

$pe_images->add_element("Uimage", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144584336-1353',
  'id' => 'module-1452144584336-1353',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-four-1080x635-2953.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-four.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-four.jpg',
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
       'width' => 1080,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 1080,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 1080,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1773',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144584330-1115',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'row' => 127,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 37,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144721900-1868',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 37,
    ),
  ),
));

$pe_images->add_element("Uimage", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144722101-1192',
  'id' => 'module-1452144722101-1192',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-five-630x635-3570.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-five.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-five.jpg',
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
       'width' => 630,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 630,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 630,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1774',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144722097-1334',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'row' => 127,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 63,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144836765-1844',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 7,
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
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 63,
    ),
  ),
));

$pe_images->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144837005-1868',
  'id' => 'module-1452144837005-1868',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-six-450x635-5325.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-six.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio-extended/lukesara-extended-six.jpg',
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
       'width' => 450,
       'height' => 635,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 450,
       'height' => 635,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 450,
       'height' => 635,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1775',
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
    'usingNewAppearance' => true,
    'element_id' => 'image-1452144836999-1936',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'row' => 127,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 63,
      )),
       'mobile' =>
      (array)(array(
         'row' => 89,
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
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
  'wrapper_id' => 'wrapper-1452144878928-1500',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 5,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 5,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 89,
    ),
  ),
));

$regions->add($pe_images);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
