<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'download-wrap.php');

$region_container = 'header';
$region_sub = 'left';
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'navigation-secondary.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'navigation-secondary.php');

$region_503131 = upfront_create_region(
			array (
  'name' => 'header',
  'title' => 'Header Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
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
  'row' => 41,
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => 'bottom',
  ),
  'background_color' => '#ffffff',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'always',
  'background_slider_images' =>
  array (
    0 => '/images/hero-2.jpg',
    1 => '/images/hero.jpg',
  ),
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-post/hero-1.jpg',
  'background_image_ratio' => 0.31,
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '15',
  'bottom_bg_padding_num' => '15',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$region_503131->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_top' => '0',
  'class' => '',
  'id' => 'module-1487646841645-1023',
  'options' =>
  array (
    'content' => '<p style="text-align: center;">PARROT</p>',
    'type' => 'PlainTxtModel',
    'view_class' => 'PlainTxtView',
    'element_id' => 'text-object-1487646841645-1323',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'id_slug' => 'plain_text',
    'preset' => 'brand-2',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'brand-2',
      )),
    )),
    'padding_slider' => '10',
    'top_padding_num' => '60',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'anchor' => '',
    'current_preset' => 'brand-2',
    'theme_style' => '',
    'row' => 21,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
  ),
  'row' => 21,
  'wrapper_id' => 'wrapper-1487646870769-1254',
  'edited' => true,
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
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$region_503131->add_element("Uspacer", array (
  'columns' => '4',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1487646919286-1737',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'element_id' => 'spacer-object-1487646919286-1222',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
  ),
  'wrapper_id' => 'wrapper-1487646919285-1414',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 0,
  'edited' => true,
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458591539078-1652',
  'id' => 'module-1458591539078-1652',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-only',
    'row' => 12,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'M j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	<span class="date">{{date}}</span>
</div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-align: center;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Open Sans',
    'static-date_posted-fontstyle' => '700 normal',
    'static-date_posted-weight' => '700',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '12',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc6',
    'left_indent' => '1',
    'right_indent' => '1',
    'content_part' => '0',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458591539076-1837',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'title-only',
      )),
    )),
    'calculated_left_indent' => 45,
    'calculated_right_indent' => 45,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458591976803-1344',
  'edited' => true,
  'new_line' => true,
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
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1458591539074-1330',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458591539074-1020',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'row' => 13,
      'preset' => 'default',
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
    ),
  ),
));

$region_503131->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458591987611-1621 upfront-module-spacer',
  'id' => 'module-1458591987611-1621',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458591987610-1897',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458591987609-1011',
  'edited' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458592023751-1983',
  'id' => 'module-1458592023751-1983',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'date-only',
    'row' => 5,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'M j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	<span class="date">{{date}}</span>
</div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-align: center;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Open Sans',
    'static-date_posted-fontstyle' => '700 normal',
    'static-date_posted-weight' => '700',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '12',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc6',
    'left_indent' => '1',
    'right_indent' => '1',
    'content_part' => '0',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458592023749-1884',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'date-only',
      )),
    )),
    'calculated_left_indent' => 45,
    'calculated_right_indent' => 45,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458592077804-1543',
  'edited' => true,
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
  'close_wrapper' => false,
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1458592023743-1599',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458592023745-1857',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'row' => 5,
      'preset' => 'default',
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
    ),
  ),
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458595297940-1226',
  'id' => 'module-1458595297940-1226',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'author-only',
    'row' => 5,
    'type_parts' =>
    array (
      0 => 'author',
      1 => 'gravatar',
      2 => 'author_email',
      3 => 'author_url',
      4 => 'author_bio',
    ),
    'gravatar_size' => '200',
    'post-part-author' => '<div class="upostdata-part author">
	Posted by <a href="{{url}}" {{target}}>{{name}}</a>
</div>',
    'post-part-gravatar' => '<div class="upostdata-part gravatar">
	{{gravatar}}
</div>',
    'post-part-author_email' => '<div class="upostdata-part author author-email">
	<a href="mailto:{{email}}">{{name}}</a>
</div>',
    'post-part-author_url' => '<div class="upostdata-part author author-url">
	<a href="{{url}}" rel="author external">{{name}}</a>
</div>',
    'post-part-author_bio' => '<div class="upostdata-part author author-bio">
	{{bio}}
</div>',
    'preset_style' => '#page .default.upost-data-object-author .upostdata-part.author {
 text-align: right;
}
',
    'link' => 'author',
    'static-author-use-typography' => 'yes',
    'static-author-font-family' => 'Open Sans',
    'static-author-fontstyle' => '700 normal',
    'static-author-weight' => '700',
    'static-author-style' => 'normal',
    'static-author-font-size' => '12',
    'static-author-line-height' => '1.3',
    'static-author-font-color' => '#ufc6',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458595297939-1647',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'author-only',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458592077804-1543',
  'edited' => true,
  'new_line' => true,
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
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-author',
      'view_class' => 'PostDataPartView',
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1458595297935-1988',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458595297935-1067',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'row' => 7,
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
    ),
  ),
));

$region_503131->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458592085733-1224 upfront-module-spacer',
  'id' => 'module-1458592085733-1224',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458592085733-1258',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458592085732-1564',
  'edited' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458624389860-1494',
  'id' => 'module-1458624389860-1494',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-featured_image',
    'id_slug' => 'post-data',
    'data_type' => 'featured_image',
    'preset' => 'default',
    'row' => 53,
    'type_parts' =>
    array (
      0 => 'featured_image',
    ),
    'full_featured_image' => '0',
    'hide_featured_image' => '0',
    'fallback_image' => '0',
    'fallback_color' => '#f00',
    'fallback_hide' => 0,
    'fallback_option' => 'hide',
    'post-part-featured_image' => '<div class="upostdata-part thumbnail" {{fallback}} data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'element_id' => 'post-data-object-1458624389859-1773',
    'top_padding_num' => '15',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458592023158-1588',
  'edited' => true,
  'new_line' => true,
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
  'close_wrapper' => false,
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-featured_image',
      'view_class' => 'PostDataPartView',
      'part_type' => 'featured_image',
      'wrapper_id' => 'wrapper-1458624389858-1038',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458624389859-1419',
      'row' => 53,
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
    ),
  ),
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458591977438-1481',
  'id' => 'module-1458591977438-1481',
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
    'date_posted_format' => 'M j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	<span class="date">{{date}}</span>
</div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-align: center;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Open Sans',
    'static-date_posted-fontstyle' => '700 normal',
    'static-date_posted-weight' => '700',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '12',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc6',
    'left_indent' => '1',
    'right_indent' => '1',
    'content_part' => '0',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458591977434-1922',
    'top_padding_num' => '15',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'content-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'content-only-for-mobile',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
       'mobile' =>
      array (
      ),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'calculated_left_indent' => 45,
    'calculated_right_indent' => 45,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458592023158-1588',
  'edited' => true,
  'new_line' => true,
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
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458614825279-1754',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458614825280-1059',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 124,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
          'hide' => 0,
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
    ),
  ),
));

$region_503131->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458592030463-1800 upfront-module-spacer',
  'id' => 'module-1458592030463-1800',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458592030463-1471',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458592030462-1640',
  'edited' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$region_503131->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457365002056-1424',
  'id' => 'module-1457365002056-1424',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'comments-and-form-only',
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
    'element_id' => 'post-data-object-1457365002055-1925',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'hidden_parts' =>
    array (
      0 => 'comment_count',
    ),
    'static-comments-use-typography' => 'yes',
    'static-comments-font-family' => '',
    'static-comments-fontstyle' => '',
    'static-comments-weight' => '400',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '',
    'static-comments-line-height' => '',
    'static-comments-font-color' => '',
    'theme_preset' => 'true',
    'preset_style' => '#page .default.upost-data-object-comments .upostdata-part.comments ol {
    list-style: none;
}
',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'comments-and-form-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'comments-and-form-only-for-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'comments-and-form-only-for-mobile',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'theme_style' => '',
    'static-comment_count-use-typography' => 'yes',
    'static-comment_count-font-family' => 'Open Sans',
    'static-comment_count-fontstyle' => '',
    'static-comment_count-weight' => '400',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '16',
    'static-comment_count-line-height' => '1.8',
    'static-comment_count-font-color' => '',
    'static-comments_pagination-use-typography' => 'yes',
    'static-comments_pagination-font-family' => 'Open Sans',
    'static-comments_pagination-fontstyle' => '',
    'static-comments_pagination-weight' => '400',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '16',
    'static-comments_pagination-line-height' => '1',
    'static-comments_pagination-font-color' => '',
    'static-comment_form-use-typography' => 'yes',
    'static-comment_form-font-family' => 'Open Sans',
    'static-comment_form-fontstyle' => '',
    'static-comment_form-weight' => '400',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '16',
    'static-comment_form-line-height' => '1.8',
    'static-comment_form-font-color' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457368145129-1701',
  'edited' => true,
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 5,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 5,
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
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1458596872175-1445',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458596872176-1063',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 1,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 1,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
          0 => 'col',
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
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1458596874081-1218',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458596874081-1779',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'clear' => true,
          'order' => 2,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'clear' => true,
          'order' => 2,
        ),
        'current_property' =>
        array (
          0 => 'order',
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '10',
      'left_padding_num' => '10',
      'right_padding_num' => '10',
      'bottom_padding_num' => '10',
      'lock_padding' => 0,
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
          0 => 'col',
        ),
      ),
    ),
  ),
));

$region_503131->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457368183054-1330 upfront-module-spacer',
  'id' => 'module-1457368183054-1330',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457368183053-1067',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457368183053-1059',
  'edited' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$regions->add($region_503131);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
