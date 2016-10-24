<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$post_featured_image = upfront_create_region(
			array (
  'name' => 'post-featured-image',
  'title' => 'Post Featured Image',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'post-featured-image',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 66,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 53,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 33,
    )),
  )),
  'background_type' => 'featured',
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
  'background_color' => '#ufc5',
  'background_style' => 'full',
  'background_default' => 'image',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-post/img-new-york.jpg',
  'background_image_ratio' => 0.560000000000000053290705182007513940334320068359375,
)
			);

$regions->add($post_featured_image);

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 175,
  'background_type' => 'color',
  'background_color' => '#ufc6',
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
       'background_type' => 'color',
       'top_bg_padding_slider' => '15',
       'top_bg_padding_num' => '15',
    )),
     'current_property' => 'top_bg_padding_num',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '40',
  'top_bg_padding_num' => '40',
  'bottom_bg_padding_slider' => '70',
  'bottom_bg_padding_num' => '70',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461599976323-1134 upfront-module-spacer',
  'id' => 'module-1461599976323-1134',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461599976323-1297',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461599976322-1901',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 2,
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
));

$main->add_element("PostData", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461599654457-1525',
  'id' => 'module-1461599654457-1525',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'author-only',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'author',
      1 => 'gravatar',
      2 => 'author_email',
      3 => 'author_url',
      4 => 'author_bio',
    ),
    'gravatar_size' => '90',
    'post-part-author' => '<div class="upostdata-part author"><a href="{{url}}" {{target}}>{{name}}</a></div>',
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
    'static-gravatar-border-width' => '1',
    'static-gravatar-border-type' => 'solid',
    'static-gravatar-border-color' => 'rgb(0, 0, 0)',
    'static-author-use-typography' => 'yes',
    'static-author-font-family' => 'Lato',
    'static-author-weight' => '700',
    'static-author-fontstyle' => '700 normal',
    'static-author-style' => 'normal',
    'static-author-font-size' => '14',
    'static-author-line-height' => '1.45',
    'static-author-font-color' => 'rgb(37, 37, 37)',
    'static-author_email-use-typography' => 'yes',
    'static-author_email-font-family' => 'Lato',
    'static-author_email-weight' => '300',
    'static-author_email-fontstyle' => '300 normal',
    'static-author_email-style' => 'normal',
    'static-author_email-font-size' => '14',
    'static-author_email-line-height' => '1.45',
    'static-author_email-font-color' => '#ufc7',
    'static-author_url-use-typography' => 'yes',
    'static-author_url-font-family' => 'Lato',
    'static-author_url-weight' => '300',
    'static-author_url-fontstyle' => '300 normal',
    'static-author_url-style' => 'normal',
    'static-author_url-font-size' => '14',
    'static-author_url-line-height' => '1.45',
    'static-author_url-font-color' => '#ufc7',
    'static-author_bio-use-typography' => '',
    'static-author_bio-font-family' => 'Lato',
    'static-author_bio-weight' => '300',
    'static-author_bio-fontstyle' => '300 normal',
    'static-author_bio-style' => 'normal',
    'static-author_bio-font-size' => '22',
    'static-author_bio-line-height' => '1.4',
    'static-author_bio-font-color' => 'rgba(45,45,45,1)',
    'preset_style' => '',
    'static-gravatar-lock' => 'yes',
    'static-gravatar-use-radius' => 'yes',
    'static-gravatar-radius1' => '100',
    'static-gravatar-radius2' => '100',
    'static-gravatar-radius3' => '100',
    'static-gravatar-radius4' => '100',
    'static-gravatar-radius' => '100',
    'static-gravatar-radius_number' => '100',
    'target' =>
    array (
      0 => '_blank',
    ),
    'display_name' => 'first_last',
    'element_id' => 'post-data-object-1461599654454-1003',
    'top_padding_num' => 25,
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'author-only',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'author-only',
      )),
    )),
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_slider' => '10',
    'current_preset' => 'author-only',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 4,
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '10',
         'bottom_padding_num' => '10',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1461599654191-1517',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 3,
      'order' => 0,
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
      0 => 'edited',
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'close_wrapper' => false,
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '3',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-author',
      'view_class' => 'PostDataPartView',
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1461599654450-1897',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461599654451-1430',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'row' => 4,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 3,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'current_preset' => 'default',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 3,
          'order' => 0,
          'use_padding' => 'yes',
          'row' => 6,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
          'row' => 4,
        ),
        'current_property' =>
        array (
          0 => 'lock_padding',
        ),
      ),
    ),
  ),
));

$main->add_element("PostData", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461599469649-1023',
  'id' => 'module-1461599469649-1023',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'date-only',
    'row' => 3,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted"><span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '300',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.45',
    'static-date_posted-font-color' => 'rgb(37, 37, 37)',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '400',
    'static-title-fontstyle' => 'regular',
    'static-title-style' => 'normal',
    'static-title-font-size' => '45',
    'static-title-line-height' => '1.35',
    'static-title-font-color' => 'rgb(45, 45, 45)',
    'preset_style' => '#page .default.upost-data-object-post_data .title h1 {
    margin-top: 0;
    margin-bottom: 0;
}
',
    'predefined_date_format' => 'M d Y',
    'element_id' => 'post-data-object-1461599469646-1773',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'date-only',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'date-only',
      )),
    )),
    'top_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'date-only',
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
         'row' => 4,
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
    )),
    'bottom_padding_slider' => '0',
    'theme_preset' => 'true',
    'hidden_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'left_indent' => '5',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1461599654191-1517',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '3',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1461599469643-1445',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461599469644-1941',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'row' => 3,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 3,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'current_preset' => 'default',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 3,
          'order' => 0,
          'use_padding' => 'yes',
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
          'row' => 1,
        ),
        'current_property' =>
        array (
          0 => 'lock_padding',
        ),
      ),
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472191345242-1341 upfront-module-spacer',
  'id' => 'module-1472191345242-1341',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472191345242-1689',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 1,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472191345242-1826',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 9,
    ),
    'mobile' =>
    array (
      'col' => 7,
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
      'col' => 9,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472176176324-1541 upfront-module-spacer',
  'id' => 'module-1472176176324-1541',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1472176176324-1538',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1472176176323-1476',
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
  ),
));

$main->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461013596137-1251',
  'id' => 'module-1461013596137-1251',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-only',
    'row' => 8,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted"><span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '300',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.45',
    'static-date_posted-font-color' => 'rgb(37, 37, 37)',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '400',
    'static-title-fontstyle' => 'regular',
    'static-title-style' => 'normal',
    'static-title-font-size' => '45',
    'static-title-line-height' => '1.35',
    'static-title-font-color' => 'rgb(45, 45, 45)',
    'preset_style' => '#page .default.upost-data-object-post_data .title h1 {
    margin-top: 0;
    margin-bottom: 0;
}
',
    'predefined_date_format' => 'M d Y',
    'element_id' => 'post-data-object-1461013596130-1842',
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'title-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'title-only-for-tablet',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'title-only',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 17,
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'row' => 8,
      )),
    )),
    'theme_preset' => 'true',
    'hidden_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'left_indent' => '5',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1461599971282-1384',
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
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
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
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 17,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1461013596124-1947',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461013596125-1851',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'row' => 5,
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
      'current_preset' => 'default',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
          'row' => 9,
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'row' => 8,
        ),
        'current_property' =>
        array (
          0 => 'lock_padding',
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
  'class' => 'module-1461602466612-1894 upfront-module-spacer',
  'id' => 'module-1461602466612-1894',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461602466612-1338',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461602466611-1703',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 2,
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
));

$main->add_element("PostData", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1472101927458-1557',
  'id' => 'module-1472101927458-1557',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'indent-content-only',
    'row' => 112,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted"><span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '300',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.45',
    'static-date_posted-font-color' => 'rgb(37, 37, 37)',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '400',
    'static-title-fontstyle' => 'regular',
    'static-title-style' => 'normal',
    'static-title-font-size' => '45',
    'static-title-line-height' => '1.35',
    'static-title-font-color' => 'rgb(45, 45, 45)',
    'preset_style' => '#page .default.upost-data-object-post_data .title h1 {
    margin-top: 0;
    margin-bottom: 0;
}
',
    'predefined_date_format' => 'M d Y',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'element_id' => 'post-data-object-1472101927457-1600',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'current_preset' => 'indent-content-only',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'indent-content-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'indent-content-only-for-mobile',
      )),
    )),
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
    'hidden_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'left_indent' => '5',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1472096875465-1960',
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
      'col' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1472189511649-1561',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1472189511650-1199',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'current_preset' => 'default',
      'preset' => 'default',
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
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 0,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'lock_padding',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
        ),
      ),
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461713685690-1273 upfront-module-spacer',
  'id' => 'module-1461713685690-1273',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461713685690-1002',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461713685689-1134',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 6,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 6,
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
));

$main->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1461713436497-1230',
  'id' => 'module-1461713436497-1230',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'default',
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
    'element_id' => 'post-data-object-1461713436496-1487',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'presets-default-for-mobile',
      )),
    )),
    'theme_style' => '',
    'static-comment_count-use-typography' => 'yes',
    'static-comment_count-font-family' => 'Lato',
    'static-comment_count-weight' => '300',
    'static-comment_count-fontstyle' => '300 normal',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '30',
    'static-comment_count-line-height' => '1',
    'static-comment_count-font-color' => 'rgb(45, 45, 45)',
    'static-comments-use-typography' => 'yes',
    'static-comments-font-family' => 'Lato',
    'static-comments-weight' => '300',
    'static-comments-fontstyle' => '300 normal',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '18',
    'static-comments-line-height' => '1.7',
    'static-comments-font-color' => 'rgba(45,45,45,1)',
    'static-comments_pagination-use-typography' => 'yes',
    'static-comments_pagination-font-family' => 'Lato',
    'static-comments_pagination-weight' => '300',
    'static-comments_pagination-fontstyle' => '300 normal',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '18',
    'static-comments_pagination-line-height' => '2',
    'static-comments_pagination-font-color' => 'rgb(88, 172, 169)',
    'static-comment_form-use-typography' => 'yes',
    'static-comment_form-font-family' => 'Lato',
    'static-comment_form-weight' => '300',
    'static-comment_form-fontstyle' => '300 normal',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '30',
    'static-comment_form-line-height' => '1.5',
    'static-comment_form-font-color' => 'rgb(45, 45, 45)',
    'preset_style' => '#page .default.upost-data-object-comments .upfront-wrapper:first-child:before, #page .default.upost-data-object-comments  .upfront-output-wrapper:first-child:before {
    content: "";
    width: 100%;
    height: 4px;
    margin-left: 15px;
    margin-right: 15px;
    background: /*#ufc1*/#de7854;
}
#page .default.upost-data-object-comments .upfront-post_data-comments, #page .default.upost-data-object-comments .upfront-post_data-comments ol.children {
    list-style: none;
}
#page .default.upost-data-object-comments .upfront-post_data-comments ol.children > li {
    margin-left: 90px;
}
#page .default.upost-data-object-comments .upfront-post_data-comments article.comment {
    position: relative;
    padding-bottom: 20px;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .avatar {
    width: 60px;
    height: 60px;
    float: left;
    margin-right: 30px;
    border-radius: 50%;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-meta .fn {
    color: /*#ufc7*/#b96446;
    font-style: normal;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-meta .comment-time {
    display: block;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-meta .comment-time, #page .default.upost-data-object-comments .upfront-post_data-comments .comment-meta .comment-time time {
    color: /*#ufc5*/#a4b2b0;
    font-size: 14px;
    line-height: 20px;
    font-weight: 500;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-content {
    margin-left: 90px;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-content, #page .default.upost-data-object-comments .upfront-post_data-comments .comment-content p {
    color: #120e0f;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-content p {
    margin-bottom: 0;
    padding-bottom: 15px;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .edit-link, #page .default.upost-data-object-comments .upfront-post_data-comments .edit-link a {
    color: /*#ufc7*/#b96446;
    font-size: 14px;
    line-height: 18px;
    font-weight: 500;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .edit-link a {
    color: /*#ufc7*/#b96446;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .comment-reply a:hover {
    color: /*#ufc1*/#de7854;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .reply {
    position: absolute;
    top: 0;
    right: 0;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .reply a {
    color: #c5d6d3;
    font-size: 12px;
    line-height: 14px;
    font-weight: 500;
    text-transform: uppercase;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .reply a:before {
    content: "";
    width: 14px;
    height: 10px;
    display: inline-block;
    margin-right: 5px;
    background: url("//issue.upfront.demo/wp-content/themes/uf-issue/ui/sprite.png") no-repeat transparent;
    background-image: url("//issue.upfront.demo/wp-content/themes/uf-issue/ui/sprite.svg"), none;
    background-position: -234px -1035px;
}
#page .default.upost-data-object-comments .upfront-post_data-comments .reply span {
    display: none;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title {
    color: inherit;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title a {
    color: /*#ufc7*/#b96446;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title a:hover {
    color: /*#ufc1*/#de7854;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title small {
    display: inline-block;
    vertical-align: middle;
    margin-left: 15px;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title small a {
    display: block;
    vertical-align: middle;
    padding: 4px 10px 5px;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    background: /*#ufc7*/#b96446;
    color: /*#ufc6*/#ffffff;
    font-size: 14px;
    line-height: 16px;
    font-weight: 500;
    transition: 0.2s ease-in;
    -moz-transition: 0.2s ease-in;
    -webkit-transition: 0.2s ease-in;
}
#page .default.upost-data-object-comments .comment-respond .comment-reply-title small a:hover {
    background: /*#ufc1*/#de7854;
    color: /*#ufc6*/#ffffff;
}
#page .default.upost-data-object-comments .comment-respond .logged-in-as, #page .default.upost-data-object-comments .comment-respond .logged-in-as a {
    font-size: 18px;
}
#page .default.upost-data-object-comments .comment-respond .comment-form > p.comment-form-author, #page .default.upost-data-object-comments .comment-respond .comment-form > p.comment-form-email, #page .default.upost-data-object-comments .comment-respond .comment-form > p.comment-form-url {
    height: 30px;
    position: relative;
    line-height: 30px;
}
#page .default.upost-data-object-comments .comment-respond .comment-form label {
    position: absolute;
    top: 0;
    left: 15px;
    padding-top: 5px;
    padding-bottom: 5px;
    color: /*#ufc4*/#7c8a87;
    font-size: 18px;
    line-height: 20px;
}
#page .default.upost-data-object-comments .comment-respond .comment-form-comment label {
    display: none;
}
#page .default.upost-data-object-comments .comment-respond .comment-form input, #page .default.upost-data-object-comments .comment-respond .comment-form textarea {
    display: block;
    padding: 5px 15px;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    background: #edf3f2;
    color: /*#ufc4*/#7c8a87;
    font-size: 18px;
    line-height: 20px;
}
#page .default.upost-data-object-comments .comment-respond .comment-form input {
    width: 100%;
    max-width: 280px;
}
#page .default.upost-data-object-comments .comment-respond .comment-form textarea {
    width: 100%;
    height: 120px;
    resize: none;
}
#page .default.upost-data-object-comments .comment-respond .form-submit input.submit {
    max-width: 180px;
    height: 45px;
    padding: 9px 15px 11px;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    background: /*#ufc1*/#de7854;
    color: /*#ufc6*/#ffffff;
    font-size: 18px;
    line-height: 25px;
    font-weight: 500;
    transition: 0.2s ease-in;
    -ms-transition: 0.2s ease-in;
    -moz-transition: 0.2s ease-in;
    -webkit-transition: 0.2s ease-in;
}
#page .default.upost-data-object-comments .comment-respond .form-submit input.submit:hover {
    background: /*#ufc7*/#b96446;
}
',
    'hidden_parts' =>
    array (
      0 => 'comments_pagination',
    ),
    'theme_preset' => 'true',
    'current_preset' => 'default',
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
         'row' => 6189,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1461713452376-1161',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 4,
      'clear' => true,
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
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 6189,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-comment_count',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_count',
      'wrapper_id' => 'wrapper-1461713436493-1843',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461713436494-1779',
      'padding_slider' => '15',
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
      'current_preset' => 'default',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
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
          0 => 'lock_padding',
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1461728623297-1938',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461728623299-1620',
      'padding_slider' => '15',
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
      'current_preset' => 'default',
      'preset' => 'default',
      'row' => 3611,
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
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
          0 => 'lock_padding',
        ),
      ),
    ),
    2 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1461728623388-1103',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1461728623389-1856',
      'padding_slider' => '15',
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
      'current_preset' => 'default',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
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
          0 => 'lock_padding',
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
  'class' => 'module-1461713687996-1883 upfront-module-spacer',
  'id' => 'module-1461713687996-1883',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1461713687996-1029',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1461713687996-1991',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 2,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 2,
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
));

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'featured-articles.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'featured-articles.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
