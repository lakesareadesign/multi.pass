<?php
/* START_REGION_OUTPUT */
$newsletter = upfront_create_region(
			array (
  'name' => 'newsletter',
  'title' => 'Newsletter',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'newsletter',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 31,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 43,
       'background_type' => 'color',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 26,
       'background_type' => 'color',
    )),
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ffffff',
  'version' => '1.0.0',
)
			);

$newsletter->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-53564 upfront-module-spacer',
  'id' => 'module-1450121214-53564',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-57863',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-40284',
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
));

$newsletter->add_element("Code", array (
  'columns' => '10',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429807657881-1121',
  'id' => 'module-1429807657881-1121',
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
    'element_id' => 'upfront-code_element-object-1429807657881-1316',
    'row' => 19,
    'code_selection_type' => 'Create',
    'markup' => '<form name="newsletter" class="newsletter-form" action="" method="post">
    <input type="email" name="user-email" placeholder="Enter your email for exclusive news">
    <span class="newsletter-btn">
        <input type="submit" value="Submit">
    </span>
</form>',
    'style' => '.newsletter-form {
    display: table;
    border-collapse: separate;
}
.newsletter-form input[type="email"] {
    padding: 12px;
    border-right-width: 0;
    display: table-cell;
}
.newsletter-form input[type="email"]:focus {
    outline: 0;
}
.newsletter-btn {
    white-space: nowrap;
    vertical-align: middle;
    font-size: 0;
    margin-left: -1px;
    display: table-cell;
    width: 1%;
}
.newsletter-form input[type="submit"] {
    opacity: 1;
    border-radius: 0 4px 4px 0;
    border-color: transparent;
    display: inline-block;
    padding: 10px 34px;
    margin-bottom: 0;
    line-height: 1.4;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    width: 100%;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    position: relative;
    font-family: \'open sans\';
}
.newsletter-form input[type="submit"]:hover {
   border-color: #ufc1;
}',
    'script' => '/* Your code here */',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 22,
         'top_padding_use' => true,
         'top_padding_num' => 55,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 40,
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432816225517-1293',
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
      'top' => 0,
      'row' => 14,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$newsletter->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-86338 upfront-module-spacer',
  'id' => 'module-1450121214-86338',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-34415',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-88602',
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

$newsletter->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-96694 upfront-module-spacer',
  'id' => 'module-1450121214-96694',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-13169',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-30618',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'order' => 1,
      'edited' => true,
      'col' => 2,
    ),
    'mobile' =>
    array (
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$newsletter->add_element("PlainTxt", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429806548995-1306',
  'id' => 'module-1429806548995-1306',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h3 class="" style="text-align: center;"><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3"><span class="upfront_theme_color_3">Get Your App</span></span></h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429806548994-1155',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 19,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 11,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '25',
         'top_padding_num' => '25',
      )),
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 20,
         'row' => 13,
      )),
       'current_property' => 'top_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'top_padding_use' => true,
    'top_padding_num' => 40,
    'bottom_padding_num' => '10',
    'preset' => 'default',
    'theme_style' => '',
    'use_padding' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432816230524-1648',
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
      'col' => 4,
      'order' => 7,
      'top' => 0,
      'row' => 13,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 6,
      'row' => 11,
      'top' => 0,
      'hide' => 0,
    ),
  ),
));

$newsletter->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-65368 upfront-module-spacer',
  'id' => 'module-1450121214-65368',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-20029',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-91747',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$newsletter->add_group(array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1432497114224-1860',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1432816233524-1091',
  'original_col' => 3,
  'href' => '{{upfront:home_url}}/download/',
  'linkTarget' => '_self',
  'background_color' => '#ffffff',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_num' => '40',
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'lock_padding' => '',
  'top_padding_slider' => '40',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 2,
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'row' => 10,
      'top' => 0,
      'top_padding_use' => 'yes',
      'top_padding_num' => '20',
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_slider' => '20',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'row' => 7,
      'top' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '0',
      'top_padding_num' => '0',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '15',
      'bottom_padding_num' => '15',
    ),
    'current_property' =>
    array (
      0 => 'bottom_padding_num',
    ),
  ),
));

$newsletter->add_element("Button", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429806456925-1035',
  'id' => 'module-1429806456925-1035',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'parrot-blackberry-sm',
    'usingNewAppearance' => true,
    'element_id' => 'object-1429806456925-1858',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/download/',
       'target' => false,
       'object' => 'page',
       'object_id' => 4,
    )),
    'currentpreset' => false,
    'row' => 6,
    'theme_style' => '',
    'is_edited' => true,
    'anchor' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432497114255-1748',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'col' => 1,
      'order' => 1,
      'top' => 0,
      'hide' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 1,
      'order' => 0,
      'top' => 0,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1432497114224-1860',
));

$newsletter->add_element("Button", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429806573620-1459',
  'id' => 'module-1429806573620-1459',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'parrot-apple-sm',
    'usingNewAppearance' => true,
    'element_id' => 'object-1429806573620-1842',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/download/',
       'target' => false,
       'object' => 'page',
       'object_id' => 4,
    )),
    'currentpreset' => false,
    'row' => 6,
    'theme_style' => '',
    'is_edited' => true,
    'anchor' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432497114258-1060',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
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
      'col' => 1,
      'order' => 3,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 1,
      'order' => 1,
      'top' => 0,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1432497114224-1860',
));

$newsletter->add_element("Button", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429806166863-1041',
  'id' => 'module-1429806166863-1041',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'parrot-android-sm',
    'usingNewAppearance' => true,
    'element_id' => 'object-1429806166863-1396',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/download/',
       'target' => false,
       'object' => 'page',
       'object_id' => 4,
    )),
    'currentpreset' => false,
    'row' => 6,
    'theme_style' => '',
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 9,
      )),
    )),
    'anchor' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1432497114259-1119',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
      'order' => 2,
      'clear' => false,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 1,
      'order' => 2,
      'top' => 0,
      'row' => 9,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 1,
      'order' => 0,
      'top' => 0,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1432497114224-1860',
));

$newsletter->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-80210 upfront-module-spacer',
  'id' => 'module-1450121214-80210',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-14986',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-90699',
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
));

$newsletter->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-68862 upfront-module-spacer',
  'id' => 'module-1450121214-68862',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-92971',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-6012',
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
));

$newsletter->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-94646 upfront-module-spacer',
  'id' => 'module-1450121214-94646',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-1801',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-17211',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
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
      'hide' => 0,
      'left' => 0,
      'col' => 3,
      'edited' => true,
    ),
  ),
));

$newsletter->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-83466 upfront-module-spacer',
  'id' => 'module-1450121214-83466',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-4084',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-29569',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
    ),
    'mobile' =>
    array (
      'clear' => false,
      'order' => 2,
      'edited' => true,
      'col' => 2,
    ),
  ),
  'breakpoint' =>
  array (
    'mobile' =>
    array (
      'hide' => 0,
      'left' => 0,
      'col' => 2,
      'edited' => true,
    ),
  ),
));

$newsletter->add_element("Code", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1433199509879-1163',
  'id' => 'module-1433199509879-1163',
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
    'element_id' => 'upfront-code_element-object-1433199509878-1190',
    'code_selection_type' => 'Create',
    'markup' => '<hr class="parrot-divider">',
    'style' => '/* Your styles here */',
    'script' => '/* Your code here */',
    'row' => 11,
    'top_padding_use' => true,
    'top_padding_num' => 30,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 25,
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 30,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'bottom_padding_num' => '10',
    'padding_slider' => '10',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1433199523232-1770',
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
      'edited' => true,
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
  ),
));

$newsletter->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450121214-31880 upfront-module-spacer',
  'id' => 'module-1450121214-31880',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450121214-72958',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450121214-68574',
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
));

$regions->add($newsletter);

/* END_REGION_OUTPUT */