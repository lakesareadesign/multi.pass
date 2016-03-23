<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$has_slider = upfront_create_region(
			array (
  'name' => 'has-slider',
  'title' => 'HAS Slider',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'has-slider',
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
       'row' => 70,
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
    0 => 'images/slider-wedding-cake.jpg',
    1 => 'images/slider-couple-woods.jpg',
  ),
)
			);

$regions->add($has_slider);

$has_content = upfront_create_region(
			array (
  'name' => 'has-content',
  'title' => 'HAS Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'has-content',
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
  'background_image' => '{{upfront:style_url}}/images/single-page-harry-and-sally/noise.jpg',
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

$has_content->add_element("Uspacer", array (
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

$has_content->add_element("PlainTxt", array (
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
<h1 style="text-align: center;">Harry + Sally</h1>
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

$has_content->add_element("Uspacer", array (
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

$has_content->add_element("Uspacer", array (
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

$has_content->add_element("PlainTxt", array (
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
<h6 class="" style="text-align: center;">CARITAS EST ETIAM PROCESSUS DYNAMICUS, QUI SEQUITUR MUTATIONEM CONSUETUDIUM LECTORUM. MIRUM EST NOTARE QUAM LITTERA GOTHICA.</h6>
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

$has_content->add_element("Uspacer", array (
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

$has_content->add_element("Uspacer", array (
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

$has_content->add_element("PlainTxt", array (
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
    'content' => '<p>Ipsum dolor sit amet, an sed appetere menandri, est ut liber feugait, semper detracto ea vix. Feugiat referrentur in eos, pri ea iusto dictas intellegam. An meis salutandi vim, quo ferri populo abhorreant et, saepe invenire ne vel. Ut vivendo mediocrem qui, ei pro consul eruditi, dicta suscipit nominati no eos. At mutat definiebas vis, id wisi antiopam tincidunt vel. Et latine facilisi splendide sit, mollis assentior ea cum. Eam causae evertitur signiferumque ut, sea omittam delectus ut, in dictas dolorem perpetua sea. Mei delenit detracto ut, usu te dico volutpat. Eam ex numquam atomorum, cum hinc zril omittantur ad. Discere accumsan cum ex. Ne ius summo dissentiunt. An partem aperiam eam. Ad omnium menandri pro. An has semper invenire eloquentiam. Cu etiam omittantur eum, cu everti consetetur vix, mea animal convenire et.</p><p>Suscipiantur necessitatibus eu usu, ei unum habemus tincidunt usu. Veniam melius torquatos vis ea, cu oratio sapientem usu. Labore eirmod delenit id pri. Ad mea affert detraxit oportere, audire legimus qui ut, cu augue deleniti est. Cu laudem periculis dissentiunt pri, ea est sumo inani dolore, aeterno aliquam per ea. Facer laoreet dignissim in pri. Pro an impedit eloquentiam, sit solet alterum philosophia no, at has nostrum efficiantur. Duo in dico inermis dolorem, cum quod diceret aliquid at. Suas semper equidem ea eum. Primis mandamus ea vis, his oportere consequat similique te.</p><p>Est eu philosophia conclusionemque, pri te elitr numquam imperdiet. Has viderer inermis te, eam aperiri integre gubergren ut. Dicta graece euismod ex vim, mei tibique electram et. Nam ea ullum virtute vituperatoribus. Te phaedrum gloriatur forensibus per, et eirmod convenire assueverit duo, dicant temporibus mel eu. Pro et dolore deleniti, vim eu tamquam nostrud. Cu sea lorem novum. Pro labitur ponderum voluptaria ea. Sit ex dicat viderer adolescens.</p><p>No nec dicunt molestiae. Impetus gubergren expetendis mei cu, te hinc incorrupte mei. Eam iudico dolores cu, agam duis ipsum usu in. At qui vitae putent mentitum, cu vix tota recusabo intellegat. Labore inimicus nam te, odio dicunt verterem ut per, quaestio vituperata pro ut. Pri eu summo volumus appetere, an graece omittam instructior quo, molestie sapientem accommodare id nec. Homero civibus nec in. Equidem debitis explicari cu vix. Has tibique singulis an, ad magna imperdiet dissentiunt ius. Est dicit platonem ea, in ius sale vidit probo. Congue graece nostro cum id, tantas quaestio usu at, est saperet veritus perpetua et. Pro et affert moderatius, virtute voluptua salutandi sea ne, pri id case postulant adolescens. Mei graecis fuisset nominati ea, volutpat aliquando accommodare has ad, ut per mundi menandri vituperata. Et movet explicari usu. Pri dicunt elaboraret ne, alii antiopam mnesarchum ne cum.</p><p>Eu qui quas menandri adipisci, qui hinc debet possim id, cu malorum fabulas appellantur cum. Mei eu nulla nonumes nostrum, nam natum everti recusabo ei. Oratio bonorum iudicabit qui in. Ne essent debitis sententiae mea, in fierent perfecto vel. Augue veniam meliore at eos. Invidunt accusata ea eam, mel ad wisi soluta repudiare. Id ius fugit constituam. Dolorum maiestatis at sed, id vis scripta ceteros. Partem noluisse invenire cu nec, an nobis accusam dissentiunt quo. Et vim munere eruditi. Diam labore nostrud pri no, dolorum forensibus mei et. Pro at fabulas scriptorem, consul admodum pro at. Vix tempor nonumes qualisque cu, inani viris reprehendunt ut mea. Vel quot saperet legendos ei, mei ut phaedrum dissentiet, doming oblique ne sit. Pro meliore persequeris definitionem no.<br>&nbsp;&nbsp;&nbsp;&nbsp;</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1452143862872-1692',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'row' => 55,
    'padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => false,
    'lock_padding' => 0,
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

$has_content->add_element("Uspacer", array (
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

$regions->add($has_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
