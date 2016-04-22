<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$sally_slider = upfront_create_region(
			array (
  'name' => 'sally-slider',
  'title' => 'Sally Slider',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'sally-slider',
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
       'edited' => true,
       'col' => 24,
       'row' => 73,
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
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'hover',
  'background_slider_images' =>
  array (
    0 => 'images/slider-sally-selfie.jpg',
    1 => 'images/slider-sally-woods.jpg',
  ),
  'version' => '1.0.0',
)
			);

$regions->add($sally_slider);

$sally_content = upfront_create_region(
			array (
  'name' => 'sally-content',
  'title' => 'Sally Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'sally-content',
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
  'background_image' => '{{upfront:style_url}}/images/single-page-sally/noise.jpg',
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

$sally_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145488823-1421 upfront-module-spacer',
  'id' => 'module-1452145488823-1421',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145488823-1524',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145488823-1581',
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

$sally_content->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145440592-1655',
  'id' => 'module-1452145440592-1655',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h1 style="text-align: center;">Sally</h1>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452145440592-1666',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '70',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '70',
    'padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452145464370-1361',
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

$sally_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452145491215-1113 upfront-module-spacer',
  'id' => 'module-1452145491215-1113',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452145491214-1687',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1452145491215-1575',
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

$sally_content->add_element("Uspacer", array (
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

$sally_content->add_element("PlainTxt", array (
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
    'content' => '<div class="plain-text-container">
<h6 class="" style="text-align: center;">DUIS MOLLIS, EST NON COMMODO LUCTUS, NISI ERAT PORTTITOR LIGULA, EGET LACINIA ODIO SEM NEC</h6>
</div>',
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
    'padding_slider' => '10',
    'preset' => 'default',
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

$sally_content->add_element("Uspacer", array (
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

$sally_content->add_element("Uspacer", array (
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

$sally_content->add_element("PlainTxt", array (
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
    'content' => '<p>Eam mentitum torquatos in, ex brute aperiam vis. Duis semper dolorem ei vel, et eum posse accusata. Mel eirmod accommodare ex, nam eu antiopam complectitur. Quando aliquid erroribus no mei, ullum delenit volutpat eos ut, cu deserunt eleifend suavitate eum. No mei erant repudiare repudiandae, utinam sensibus nec cu. Dicunt menandri elaboraret vel in. Dicunt vivendum instructior his eu, vide argumentum appellantur at vis. Posse elitr ne quo, quo rebum vitae instructior ut. Doctus denique reformidans in sit, soluta vivendo imperdiet pro et. Mundi abhorreant et has, cu elitr gloriatur theophrastus his. Ridens appetere sea te. Ad malis quando meliore eam, his veniam petentium repudiare id, solet admodum at sea.</p><p>Hinc quot no quo, mea impedit dolorem an, has quidam putant consequat no. Mei ad eruditi nostrum. Impetus nostrum no vim, no esse feugiat mel, usu debet sonet audire ei. Clita scaevola intellegam mel ex. Dicat alterum ad quo, no quo mollis tacimates intellegat. Possit aliquam debitis id per, erat quas dicam an sea. Ea ceteros salutandi ius, eam doming latine laboramus te. Duis iusto dolorem an usu, vero iuvaret usu et. Te pri legere doctus, id maiorum officiis mea, ei pri purto maluisset omittantur. Ne brute paulo deterruisset sed, ne mazim doming minimum his. Cu debitis praesent sit. Ut liber munere usu, insolens salutatus voluptatibus vix ne. Meis principes ullamcorper at nec, vix partem feugiat no. Mei noluisse atomorum postulant te, veri euismod scribentur est te, pri sanctus percipitur cu.Homero neglegentur cu has. Sea ex verear detracto. Cum ut iriure prodesset voluptatum, no choro erroribus ullamcorper vis. Fabellas efficiantur voluptatibus vim no, ei autem patrioque sea. us tacimates accusamus imperdiet ei, mea at eius adipisci. Nam tollit nullam voluptatum eu, ea iisque convenire per, verterem intellegat ad eos. Mei atqui malorum blandit id. Causae meliore eu eam, tollit doctus eripuit cum in. Has copiosae delicatissimi ne, eu maiorum electram cum, nec ut nostro regione. Libris cotidieque cum no.An mei alii unum facilis, no sit latine corrumpit, sea hinc eirmod ex. Ex sea alienum argumentum, in sit quod iuvaret conclusionemque, ea nisl movet placerat eos. Cum at meliore delicatissimi, docendi incorrupte nec ut, ius facer nostro cetero cu. Pri probatus reprimique dissentiet ut. Ne eos summo tollit offendit, vim semper dolores voluptatibus at.<br>&nbsp;</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452143862872-1692',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 72,
    'padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'content-center-aligned',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'content-center-aligned',
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

$sally_content->add_element("Uspacer", array (
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

$regions->add($sally_content);

$sally_images = upfront_create_region(
			array (
  'name' => 'sally-images',
  'title' => 'Sally Images',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'sally-images',
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
       'row' => 40,
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
  'background_image' => '{{upfront:style_url}}/images/single-page-sally/noise.jpg',
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

$sally_images->add_element("Uimage", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144297005-1982',
  'id' => 'module-1452144297005-1982',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-sally/img-sally-woods-1080x620-7127.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-sally/img-sally-woods.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-sally/img-sally-woods.jpg',
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
       'height' => 620,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 95,
    'align' => 'left',
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
    'row' => 124,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 62,
      )),
       'mobile' =>
      (array)(array(
         'row' => 36,
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
      'row' => 62,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 36,
    ),
  ),
));

$sally_images->add_element("Uimage", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144526272-1517',
  'id' => 'module-1452144526272-1517',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-sally/img-sally-dress-450x635-6127.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-sally/img-sally-dress.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-sally/img-sally-dress.jpg',
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
    'image_id' => 93,
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
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452145666898-1403',
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
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$sally_images->add_element("Uimage", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452144531874-1910',
  'id' => 'module-1452144531874-1910',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-sally/lukesara-extended-three-630x635-2484.jpg',
    'srcFull' => '{{upfront:style_url}}/images/single-page-sally/lukesara-extended-three.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-sally/lukesara-extended-three.jpg',
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
    'image_id' => 94,
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
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452145636056-1493',
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
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 63,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$regions->add($sally_images);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
