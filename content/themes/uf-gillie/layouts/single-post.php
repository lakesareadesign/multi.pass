<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$cover_left = upfront_create_region(
			array (
  'name' => 'cover-left',
  'title' => 'cover left',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'cover-post',
  'sub' => 'left',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'col' => 9,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '0',
       'top_bg_padding_num' => '0',
       'bg_padding_type' => 'equal',
       'bg_padding_slider' => '0',
       'bottom_bg_padding_slider' => '0',
       'bg_padding_num' => '0',
       'bottom_bg_padding_num' => '0',
       'row' => 36,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_type' => 'equal',
       'bg_padding_slider' => '0',
       'top_bg_padding_slider' => '0',
       'bottom_bg_padding_slider' => '0',
       'bg_padding_num' => '0',
       'top_bg_padding_num' => '0',
       'bottom_bg_padding_num' => '0',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '250',
  'top_bg_padding_num' => '250',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => '215',
  'bg_padding_num' => '215',
  'background_color' => 'rgba(0,0,0,0)',
  'sub_regions' =>
  array (
    0 => false,
  ),
  'region_role' => false,
)
			);

$cover_left->add_group(array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1460365331630-1347',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1460365387006-1758',
  'original_col' => 18,
  'top_padding_num' => '35',
  'bottom_padding_num' => '50',
  'use_padding' => 'yes',
  'edited' => true,
  'lock_padding' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '35',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '50',
  'background_color' => '#ufc0',
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'background_type' => 'color',
  'anchor' => '',
  'left_padding_num' => 10,
  'right_padding_num' => 10,
  'href' => '',
  'linkTarget' => false,
  'origin_position_y' => 50,
  'origin_position_x' => 50,
  'use_background_size_percent' => '',
  'background_size_percent' => 100,
  'featured_fallback_background_color' => '#ffffff',
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
      'use_padding' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'use_padding' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460365469676-1591 upfront-module-spacer',
  'id' => 'module-1460365469676-1591',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460365469676-1369',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460365469675-1168',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571596860-1842 upfront-module-spacer',
  'id' => 'module-1471571596860-1842',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571596860-1297',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571596859-1047',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571644543-1561 upfront-module-spacer',
  'id' => 'module-1471571644543-1561',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571644543-1034',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571644543-1256',
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
    'current_property' =>
    array (
      0 => 'edited',
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("PostData", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460364580360-1397',
  'id' => 'module-1460364580360-1397',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'cover-author-name',
    'row' => 3,
    'type_parts' =>
    array (
      0 => 'author',
      1 => 'gravatar',
      2 => 'author_email',
      3 => 'author_url',
      4 => 'author_bio',
    ),
    'gravatar_size' => 200,
    'post-part-author' => '<div class="upostdata-part author">
	By <a href="{{url}}" {{target}}>{{name}}</a></div>',
    'post-part-gravatar' => '<div class="upostdata-part gravatar">
	{{gravatar}}
</div>',
    'post-part-author_email' => '<div class="upostdata-part author author-email">
	<a href="mailto:{{email}}">{{email_string}}</a>
</div>',
    'post-part-author_url' => '<div class="upostdata-part author author-url">
	<a href="{{url}}" rel="author external">{{url_string}}</a>
</div>',
    'post-part-author_bio' => '<div class="upostdata-part author author-bio">
	{{bio}}
</div>',
    'element_id' => 'post-data-object-1460364580359-1955',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'cover-author-name',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'static-gravatar-use-border' => '',
    'static-gravatar-border-width' => '1',
    'static-gravatar-border-type' => 'solid',
    'static-gravatar-border-color' => 'rgb(0, 0, 0)',
    'static-author-use-typography' => '',
    'static-author-font-family' => 'Special Elite',
    'static-author-weight' => '400',
    'static-author-fontstyle' => '400 normal',
    'static-author-style' => 'normal',
    'static-author-font-size' => '18',
    'static-author-line-height' => '2.222',
    'static-author-font-color' => '#ufc0',
    'static-author_email-use-typography' => '',
    'static-author_email-font-family' => 'Special Elite',
    'static-author_email-weight' => '400',
    'static-author_email-fontstyle' => '400 normal',
    'static-author_email-style' => 'normal',
    'static-author_email-font-size' => '18',
    'static-author_email-line-height' => '2.222',
    'static-author_email-font-color' => '#ufc0',
    'static-author_url-use-typography' => '',
    'static-author_url-font-family' => 'Special Elite',
    'static-author_url-weight' => '400',
    'static-author_url-fontstyle' => '400 normal',
    'static-author_url-style' => 'normal',
    'static-author_url-font-size' => '18',
    'static-author_url-line-height' => '2.222',
    'static-author_url-font-color' => '#ufc0',
    'static-author_bio-use-typography' => '',
    'static-author_bio-font-family' => 'Special Elite',
    'static-author_bio-weight' => '400',
    'static-author_bio-fontstyle' => '400 normal',
    'static-author_bio-style' => 'normal',
    'static-author_bio-font-size' => '18',
    'static-author_bio-line-height' => '2.222',
    'static-author_bio-font-color' => '#ufc0',
    'preset_style' => '',
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
    'theme_preset' => 'true',
    'static-gravatar-radius1' => '',
    'static-gravatar-radius2' => '',
    'static-gravatar-radius3' => '',
    'static-gravatar-radius4' => '',
    'static-gravatar-radius' => '',
    'static-gravatar-radius_number' => '',
    'current_preset' => 'cover-author-name',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460365331632-1876',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 10,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '7',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-author',
      'view_class' => 'PostDataPartView',
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1460364580354-1884',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1460364580354-1943',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'row' => 3,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 10,
        ),
        'mobile' =>
        array (
          'col' => 5,
        ),
      ),
      'preset' => 'cover-author-name',
      'current_preset' => 'cover-author-name',
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 10,
          'order' => 0,
          'use_padding' => 'yes',
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 5,
          'order' => 0,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571646748-1662 upfront-module-spacer',
  'id' => 'module-1471571646748-1662',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571646748-1365',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571646748-1766',
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
    'current_property' =>
    array (
      0 => 'edited',
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571598966-1670 upfront-module-spacer',
  'id' => 'module-1471571598966-1670',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571598966-1746',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571598965-1015',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 1,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460365475009-1361 upfront-module-spacer',
  'id' => 'module-1460365475009-1361',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460365475009-1738',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460365475008-1197',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460365471243-1032 upfront-module-spacer',
  'id' => 'module-1460365471243-1032',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460365471243-1858',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460365471242-1147',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571594534-1455 upfront-module-spacer',
  'id' => 'module-1471571594534-1455',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571594533-1928',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571594532-1815',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 2,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571641449-1256 upfront-module-spacer',
  'id' => 'module-1471571641449-1256',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571641449-1635',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571641448-1379',
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
      'order' => 2,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("PostData", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460039232147-1573',
  'id' => 'module-1460039232147-1573',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'cover-title',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h2>{{title}}</h2>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1460039232146-1730',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'cover-title',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'top_padding_slider' => '0',
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
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => 'Special Elite',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '18',
    'static-date_posted-line-height' => '2.222',
    'static-date_posted-font-color' => '#ufc0',
    'static-title-use-typography' => '',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '300',
    'static-title-fontstyle' => '300 normal',
    'static-title-style' => 'normal',
    'static-title-font-size' => '35',
    'static-title-line-height' => '1.429',
    'static-title-font-color' => '#ufc0',
    'preset_style' => '',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'cover-title',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460365331634-1182',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 2,
      'clear' => false,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 10,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '7',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1460039232143-1520',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1460039232144-1060',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 10,
        ),
        'mobile' =>
        array (
          'col' => 5,
        ),
      ),
      'row' => 10,
      'preset' => 'default',
      'current_preset' => 'default',
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 10,
          'order' => 0,
          'use_padding' => 'yes',
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 5,
          'order' => 0,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571642833-1859 upfront-module-spacer',
  'id' => 'module-1471571642833-1859',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571642832-1083',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571642832-1722',
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
      'order' => 2,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
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
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1471571600618-1782 upfront-module-spacer',
  'id' => 'module-1471571600618-1782',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1471571600618-1852',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1471571600618-1582',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 2,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$cover_left->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460365473175-1301 upfront-module-spacer',
  'id' => 'module-1460365473175-1301',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460365473175-1066',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460365473174-1866',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
  'group' => 'module-group-1460365331630-1347',
));

$regions->add($cover_left);

$cover_post = upfront_create_region(
			array (
  'name' => 'cover-post',
  'title' => 'cover post',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'cover-post',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 142,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 15,
       'background_type' => 'featured',
       'background_position_y' => '50',
       'background_style' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => '50% 50%',
       'background_position_x' => '50',
       'background_default' => 'color',
       'hide' => 1,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'featured',
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_default' => 'color',
       'row' => 15,
       'hide' => 1,
    )),
     'current_property' => 'background_style',
  )),
  'background_type' => 'featured',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => '0',
  'bg_padding_num' => '0',
  'background_color' => '#ufc2',
  'background_style' => 'full',
  'background_default' => 'color',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-post/testimonials.jpg',
  'background_image_ratio' => 0.36999999999999999555910790149937383830547332763671875,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'featured_fallback_background_color' => '#ufc2',
  'region_role' => 'complementary',
)
			);

$regions->add($cover_post);

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 60,
  'background_type' => 'color',
  'background_color' => '#ufc3',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
    )),
     'current_property' => 'bottom_bg_padding_slider',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '100',
  'top_bg_padding_num' => '100',
  'bottom_bg_padding_slider' => '100',
  'bottom_bg_padding_num' => '100',
  'bg_padding_slider' => '100',
  'bg_padding_num' => '100',
  'region_role' => 'main',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460106231232-1334 upfront-module-spacer',
  'id' => 'module-1460106231232-1334',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460106231232-1367',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460106231231-1878',
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

$main->add_element("PostData", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460106181154-1819',
  'id' => 'module-1460106181154-1819',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'content-only',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1460106181153-1972',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'content-only',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'content-only-mobile',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'content-only-mobile',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
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
    'theme_style' => '',
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => 'Special Elite',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '18',
    'static-date_posted-line-height' => '2.222',
    'static-date_posted-font-color' => '#ufc0',
    'static-title-use-typography' => '',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '300',
    'static-title-fontstyle' => '300 normal',
    'static-title-style' => 'normal',
    'static-title-font-size' => '35',
    'static-title-line-height' => '1.429',
    'static-title-font-color' => '#ufc0',
    'preset_style' => '',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'content-only',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460106228025-1263',
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1460106181152-1143',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1460106181152-1927',
      'padding_slider' => '10',
      'use_padding' => 'yes',
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
      'preset' => 'default',
      'current_preset' => 'default',
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460106233115-1907 upfront-module-spacer',
  'id' => 'module-1460106233115-1907',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460106233115-1848',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460106233114-1471',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460368596514-1308 upfront-module-spacer',
  'id' => 'module-1460368596514-1308',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460368596513-1496',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460368596512-1982',
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

$main->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460367788895-1170',
  'id' => 'module-1460367788895-1170',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'comments-and-form',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments',
      2 => 'comments_pagination',
      3 => 'comment_form',
    ),
    'comment_count_hide' => 0,
    'disable_showing' =>
    array (
      0 => 'trackbacks',
    ),
    'disable' =>
    array (
      0 => 'trackbacks',
      1 => 'comments',
    ),
    'order' => 'comment_date_gmt',
    'direction' => 'DESC',
    'limit' => 50,
    'paginated' => 0,
    'post-part-comment_count' => '<div class="upostdata-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-comments' => '<div class="upostdata-part comments">
	{{comments}}
</div>',
    'post-part-comments_pagination' => '<div class="upostdata-part comments comments_pagination">
	{{pagination}}
</div>',
    'post-part-comment_form' => '<div class="upostdata-part comment_form">
	{{comment_form}}
</div>',
    'element_id' => 'post-data-object-1460367788894-1393',
    'top_padding_num' => '60',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'comments-and-form',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'comments-and-form-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'comments-and-form-mobile',
      )),
    )),
    'static-comment_count-use-typography' => '',
    'static-comment_count-font-family' => 'Special Elite',
    'static-comment_count-weight' => '400',
    'static-comment_count-fontstyle' => '400 normal',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '18',
    'static-comment_count-line-height' => '2.222',
    'static-comment_count-font-color' => '#ufc0',
    'static-comments-use-typography' => '',
    'static-comments-font-family' => 'Special Elite',
    'static-comments-weight' => '400',
    'static-comments-fontstyle' => '400 normal',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '18',
    'static-comments-line-height' => '2.222',
    'static-comments-font-color' => '#ufc0',
    'static-comments_pagination-use-typography' => '',
    'static-comments_pagination-font-family' => 'Special Elite',
    'static-comments_pagination-weight' => '400',
    'static-comments_pagination-fontstyle' => '400 normal',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '18',
    'static-comments_pagination-line-height' => '2.222',
    'static-comments_pagination-font-color' => '#ufc0',
    'static-comment_form-use-typography' => '',
    'static-comment_form-font-family' => 'Special Elite',
    'static-comment_form-weight' => '400',
    'static-comment_form-fontstyle' => '400 normal',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '18',
    'static-comment_form-line-height' => '2.222',
    'static-comment_form-font-color' => '#ufc0',
    'preset_style' => '',
    'hidden_parts' =>
    array (
      0 => 'comments_pagination',
    ),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
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
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'theme_style' => '',
    'theme_preset' => 'true',
    'current_preset' => 'comments-and-form',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460368562378-1334',
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '24',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1487758194674-1954',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1487758194675-1029',
      'padding_slider' => 10,
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => 0,
      'use_padding' => 'yes',
      'new_line' => true,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'clear' => true,
          'col' => 12,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
        'mobile' =>
        array (
          'clear' => true,
          'col' => 7,
          'order' => 1,
        ),
      ),
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'hide' => 0,
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '24',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments_pagination',
      'wrapper_id' => 'wrapper-1487758194811-1907',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1487758194812-1151',
      'padding_slider' => 10,
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => 0,
      'use_padding' => 'yes',
      'new_line' => true,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'clear' => true,
          'col' => 12,
          'order' => 2,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
        'mobile' =>
        array (
          'clear' => true,
          'col' => 7,
          'order' => 2,
        ),
      ),
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 1,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'hide' => 1,
        ),
      ),
    ),
    2 =>
    array (
      'columns' => '24',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1487758213368-1675',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1487758213369-1281',
      'padding_slider' => 10,
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
      'lock_padding' => 0,
      'use_padding' => 'yes',
      'new_line' => true,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'clear' => true,
          'col' => 12,
          'order' => 3,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
        'mobile' =>
        array (
          'clear' => true,
          'col' => 7,
          'order' => 3,
        ),
      ),
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'hide' => 0,
        ),
      ),
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460368598863-1514 upfront-module-spacer',
  'id' => 'module-1460368598863-1514',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460368598863-1505',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460368598862-1233',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
