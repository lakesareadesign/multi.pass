<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$wd_slider = upfront_create_region(
			array (
  'name' => 'wd-slider',
  'title' => 'WD Slider',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'wd-slider',
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
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'hover',
  'background_slider_images' =>
  array (
    0 => 'images/slider-dress.jpg',
    1 => 'images/slider-bride.jpg',
  ),
)
			);

$regions->add($wd_slider);

$wd_content = upfront_create_region(
			array (
  'name' => 'wd-content',
  'title' => 'WD Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'wd-content',
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
  'background_image' => '{{upfront:style_url}}/images/single-page-wedding-dress/noise.jpg',
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

$wd_content->add_element("Uspacer", array (
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

$wd_content->add_element("PlainTxt", array (
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
    'content' => '<h1 style="text-align: center;">Wedding Dress</h1>',
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

$wd_content->add_element("Uspacer", array (
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

$wd_content->add_element("Uspacer", array (
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

$wd_content->add_element("PlainTxt", array (
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
    'content' => '<h6 class="" style="text-align: center;">OMNIS DICIT FACILIS PER, ZRIL COTIDIEQUE DUO AN. EIRMOD MAIESTATIS PRO AD, PERCIPIT DEFINITIONEM EA MEA. ULLUM AETERNO NOSTRUD VIX AN. SUSCIPIT LIBERAVISSE EST IN. EUM CASE MALORUM PERSEQUERIS.</h6>',
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

$wd_content->add_element("Uspacer", array (
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

$wd_content->add_element("Uspacer", array (
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

$wd_content->add_element("PlainTxt", array (
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
<p>His te modus insolens voluptatum, et omnis dicit facilis per, zril cotidieque duo an. Eirmod maiestatis pro ad, percipit definitionem ea mea. Ullum aeterno nostrud vix an. Suscipit liberavisse est in. Eum case malorum persequeris id, nec in quem pericula. Movet eripuit vulputate cum ex.Nec integre nostrum suscipit ad, oporteat urbanitas assentior vis ne. Probo prima ut nec, id tale idque petentium quo, eam id animal evertitur. An vel minim paulo signiferumque. Erat tritani vituperatoribus mel ea, meis movet delicatissimi per at.</p><p>Eam mentitum torquatos in, ex brute aperiam vis. Duis semper dolorem ei vel, et eum posse accusata. Mel eirmod accommodare ex, nam eu antiopam complectitur. Quando aliquid erroribus no mei, ullum delenit volutpat eos ut, cu deserunt eleifend suavitate eum. No mei erant repudiare repudiandae, utinam sensibus nec cu. Dicunt menandri elaboraret vel in. Dicunt vivendum instructior his eu, vide argumentum appellantur at vis. Posse elitr ne quo, quo rebum vitae instructior ut. Doctus denique reformidans in sit, soluta vivendo imperdiet pro et. Mundi abhorreant et has, cu elitr gloriatur theophrastus his. Ridens appetere sea te. Ad malis quando meliore eam, his veniam petentium repudiare id, solet admodum at sea.</p><p>Hinc quot no quo, mea impedit dolorem an, has quidam putant consequat no. Mei ad eruditi nostrum. Impetus nostrum no vim, no esse feugiat mel, usu debet sonet audire ei. Clita scaevola intellegam mel ex. Dicat alterum ad quo, no quo mollis tacimates intellegat. Possit aliquam debitis id per, erat quas dicam an sea. Ea ceteros salutandi ius, eam doming latine laboramus te. Duis iusto dolorem an usu, vero iuvaret usu et. Te pri legere doctus, id maiorum officiis mea, ei pri purto maluisset omittantur. Ne brute paulo deterruisset sed, ne mazim doming minimum his. Cu debitis praesent sit. Ut liber munere usu, insolens salutatus voluptatibus vix ne. Meis principes ullamcorper at nec, vix partem feugiat no. Mei noluisse atomorum postulant te, veri euismod scribentur est te, pri sanctus percipitur cu.Homero neglegentur cu has. Sea ex verear detracto. Cum ut iriure prodesset voluptatum, no choro erroribus ullamcorper vis. Fabellas efficiantur voluptatibus vim no, ei autem patrioque sea. us tacimates accusamus imperdiet ei, mea at eius adipisci. Nam tollit nullam voluptatum eu, ea iisque convenire per, verterem intellegat ad eos. Mei atqui malorum blandit id. Causae meliore eu eam, tollit doctus eripuit cum in. Has copiosae delicatissimi ne, eu maiorum electram cum, nec ut nostro regione. Libris cotidieque cum no.An mei alii unum facilis, no sit latine corrumpit, sea hinc eirmod ex. Ex sea alienum argumentum, in sit quod iuvaret conclusionemque, ea nisl movet placerat eos. Cum at meliore delicatissimi, docendi incorrupte nec ut, ius facer nostro cetero cu. Pri probatus reprimique dissentiet ut. Ne eos summo tollit offendit, vim semper dolores voluptatibus at.</p>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452143862872-1692',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 170,
    'padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => '',
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
      )),
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'content-center-aligned',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'content-center-aligned',
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

$wd_content->add_element("Uspacer", array (
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

$regions->add($wd_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
