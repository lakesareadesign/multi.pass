<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$main_area = upfront_create_region(
			array (
  'name' => 'main-area',
  'title' => 'Main area',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 42,
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,0.75)',
  'nav_region' => '',
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
  'version' => '1.0.0',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '100',
  'bottom_bg_padding_num' => '100',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458658468623-1298 upfront-module-spacer',
  'id' => 'module-1458658468623-1298',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458658468623-1203',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458658468622-1010',
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

$main_area->add_element("PostData", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458452949546-1047',
  'id' => 'module-1458452949546-1047',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'date-only',
    'row' => 10,
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
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '16',
    'static-date_posted-line-height' => '1.875',
    'static-date_posted-font-color' => 'rgba(0,0,0,1)',
    'static-title-use-typography' => '',
    'static-title-font-family' => 'Cantata One',
    'static-title-weight' => '400',
    'static-title-fontstyle' => '400 normal',
    'static-title-style' => 'normal',
    'static-title-font-size' => '46',
    'static-title-line-height' => '1',
    'static-title-font-color' => 'rgba(192,149,51,1)',
    'preset_style' => '',
    'element_id' => 'post-data-object-1458452949545-1639',
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
       'tablet' =>
      (array)(array(
         'preset' => 'date-only-for-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'date-only-for-mobile',
      )),
    )),
    'theme_preset' => 'true',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 11,
         'top_padding_use' => 'yes',
         'top_padding_slider' => '40',
         'top_padding_num' => '40',
         'lock_padding' => '',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'row' => 7,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458454018777-1465',
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
      'row' => 11,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 7,
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
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1458667901401-1326',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458667901402-1069',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 1,
          'clear' => true,
        ),
      ),
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
          'row' => 11,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'row' => 7,
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

$main_area->add_element("PostData", array (
  'columns' => '19',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454099592-1534',
  'id' => 'module-1458454099592-1534',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'author-name-only',
    'row' => 12,
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
    'element_id' => 'post-data-object-1458454099591-1763',
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
         'preset' => 'author-name-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'author-name-only-for-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'author-name-only-for-mobile',
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
    'static-author-font-family' => 'Lato',
    'static-author-weight' => '400',
    'static-author-fontstyle' => '400 normal',
    'static-author-style' => 'normal',
    'static-author-font-size' => '16',
    'static-author-line-height' => '1.875',
    'static-author-font-color' => 'rgba(0,0,0,1)',
    'static-author_email-use-typography' => '',
    'static-author_email-font-family' => 'Lato',
    'static-author_email-weight' => '400',
    'static-author_email-fontstyle' => '400 normal',
    'static-author_email-style' => 'normal',
    'static-author_email-font-size' => '16',
    'static-author_email-line-height' => '1.875',
    'static-author_email-font-color' => 'rgba(111,206,206,1)',
    'static-author_url-use-typography' => '',
    'static-author_url-font-family' => 'Lato',
    'static-author_url-weight' => '400',
    'static-author_url-fontstyle' => '400 normal',
    'static-author_url-style' => 'normal',
    'static-author_url-font-size' => '16',
    'static-author_url-line-height' => '1.875',
    'static-author_url-font-color' => 'rgba(111,206,206,1)',
    'static-author_bio-use-typography' => '',
    'static-author_bio-font-family' => 'Lato',
    'static-author_bio-weight' => '400',
    'static-author_bio-fontstyle' => '400 normal',
    'static-author_bio-style' => 'normal',
    'static-author_bio-font-size' => '16',
    'static-author_bio-line-height' => '1.875',
    'static-author_bio-font-color' => 'rgba(0,0,0,1)',
    'preset_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 4,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
       'mobile' =>
      (array)(array(
         'row' => 6,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
    )),
    'theme_preset' => 'true',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458454354776-1587',
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
      'col' => 12,
      'order' => 1,
      'top' => 0,
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 1,
      'top' => 0,
      'row' => 6,
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
      'columns' => '19',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1458454413305-1219',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458454413306-1546',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'row' => 12,
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 1,
          'clear' => true,
        ),
      ),
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'row' => 4,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'row' => 6,
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

$main_area->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458658484733-1477 upfront-module-spacer',
  'id' => 'module-1458658484733-1477',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458658484733-1540',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458658484733-1531',
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

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454633999-1040 upfront-module-spacer',
  'id' => 'module-1458454633999-1040',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458454633998-1113',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458454633996-1050',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
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

$main_area->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454099584-1110',
  'id' => 'module-1458454099584-1110',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-only',
    'row' => 10,
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
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '16',
    'static-date_posted-line-height' => '1.875',
    'static-date_posted-font-color' => 'rgba(0,0,0,1)',
    'static-title-use-typography' => '',
    'static-title-font-family' => 'Cantata One',
    'static-title-weight' => '400',
    'static-title-fontstyle' => '400 normal',
    'static-title-style' => 'normal',
    'static-title-font-size' => '46',
    'static-title-line-height' => '1',
    'static-title-font-color' => 'rgba(192,149,51,1)',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .post_content {
    padding-bottom: 0;
}
#page .default.upost-data-object-post_data  .upfront-postpart-date {
    padding-right: 0;
}
#page .default.upost-data-object-post_data  .upfront-postpart-wrapper.part-date {
    position: relative;
}
#page .default.upost-data-object-post_data  .upfront-postpart-wrapper.part-date:after {
    color: /*#ufc3*/#000000;
    content: "/";
    font-family: "Lato", Arial, sans-serif;
    font-size: 14px;
    line-height: 30px;
    position: absolute;
    right: 20px;
    top: -1px;
}
#page .default.upost-data-object-post_data  time.post_date {
    color: /*#ufc3*/#000000;
    font-size: 13px;
    font-weight: 300;
    line-height: 30px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .upfront-postpart-author {
    padding-left: 0;
}
#page .default.upost-data-object-post_data  a.post_author {
    color: /*#ufc0*/#c09533;
    font-size: 13px;
    font-weight: 400;
    line-height: 30px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  a.post_author:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-post_data  .post_title, #page .default.upost-data-object-post_data  .post_title a {
    color: /*#ufc0*/#c09533;
    padding: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data  .post_title a:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-post_data  .upfront-postpart-wrapper.part-featured_image.no-featured_image {
    display: none;
}
#page .default.upost-data-object-post_data  .post_content h1, #page .default.upost-data-object-post_data  .post_content h2, #page .default.upost-data-object-post_data  .post_content address, #page .default.upost-data-object-post_data  .post_content table {
    margin: 0 0 45px;
    padding: 0;
}
#page .default.upost-data-object-post_data  .post_content h2 {
    text-align: center;
}
#page .default.upost-data-object-post_data  .post_content h3, #page .default.upost-data-object-post_data  .post_content h4, #page .default.upost-data-object-post_data  .post_content h5, #page .default.upost-data-object-post_data  .post_content h6 {
    margin: 0 0 10px;
    padding: 0;
}
#page .default.upost-data-object-post_data  .post_content h4:after {
    border-bottom: none;
}
#page .default.upost-data-object-post_data  .post_content p {
    margin: 0 0 25px;
    padding: 0;
}
#page .default.upost-data-object-post_data  .post_content pre, #page .default.upost-data-object-post_data  .post_content cite, #page .default.upost-data-object-post_data  .post_content q, #page .default.upost-data-object-post_data  .post_content iframe, #page .default.upost-data-object-post_data  .post_content embed {
    margin: 0 0 25px;
    padding: 0;
}
#page .default.upost-data-object-post_data  .post_content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data  .post_content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .post_content img {
    display: block;
    height: auto;
    max-width: 100%;
}
#page .default.upost-data-object-post_data  .post_content .alignnone, #page .default.upost-data-object-post_data  .post_content .aligncenter, #page .default.upost-data-object-post_data  .post_content .alignright, #page .default.upost-data-object-post_data  .post_content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data  .post_content .alignnone, #page .default.upost-data-object-post_data  .post_content div.alignnone, #page .default.upost-data-object-post_data  .post_content .aligncenter, #page .default.upost-data-object-post_data  .post_content div.aligncenter, #page .default.upost-data-object-post_data  .post_content img.aligncenter {
    display: block;
    margin: 0 auto 45px auto;
}
#page .default.upost-data-object-post_data  .post_content .alignright, #page .default.upost-data-object-post_data  .post_content img.alignright {
    float: right;
    margin: 0 0 45px 45px;
}
#page .default.upost-data-object-post_data  .post_content .alignleft, #page .default.upost-data-object-post_data  .post_content img.alignleft {
    float: left;
    margin: 0 45px 45px 0;
}
#page .default.upost-data-object-post_data  .post_content h3 {
    color: /*#ufc3*/#000000;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data  .post_content h3:after {
    display: none;
}
#page .default.upost-data-object-post_data  .post_content p {
    -ms-word-break: break-word;
    word-break: break-word;
}
#page .default.upost-data-object-post_data  .post_content .wp-caption-text p, #page .default.upost-data-object-post_data  .post_content p.wp-caption-text {
    color: /*#ufc3*/#000000;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5em;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data  .post_content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data  .post_content .wp-caption-text a {
    color: /*#ufc0*/#c09533;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.563em;
}
#page .default.upost-data-object-post_data  .post_content .wp-caption-text a:hover {
    color: /*#ufc5*/#9a7729;
}
#page .default.upost-data-object-post_data  .post_content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data  .post_content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data  .post_content .ueditor-insert {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data  .post_content .ueditor-insert-variant .ueditor-image-style-full-width, #page .default.upost-data-object-post_data  .post_content .ueditor-insert-variant .ueditor-image-style-center {
    margin-bottom: 45px;
}
#page .default.upost-data-object-post_data  .post_content .ueditor-insert-variant .ueditor-image-style-right {
    margin: 0 0 30px 45px;
}
#page .default.upost-data-object-post_data  .post_content .ueditor-insert-variant .ueditor-image-style-left {
    margin: 0 45px 30px 0;
}
#page .default.upost-data-object-post_data  .post_content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data  .post_content .upfront-wrapper.wp-caption-text {
    color: /*#ufc3*/#000000;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data  .post_content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data  .post_content blockquote {
    margin: 45px 0 45px;
    display:block;
    position: relative;
    text-align: center;
}
#page .default.upost-data-object-post_data  .post_content blockquote:before {
    border-left: 3px solid /*#ufc1*/#6fcece;
    content: "";
    display: inline-block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data  .post_content blockquote p {
    margin: 0 60px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .post_content blockquote p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .post_content blockquote cite {
    display: block;
    font-weight: 300;
    font-size: 16px;
    font-style: normal;
    line-height: 1.875em;
    position: relative;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .post_content blockquote cite:before, #page .default.upost-data-object-post_data  .post_content blockquote cite:after {
    content: "-";
}
#page .default.upost-data-object-post_data  .post_content blockquote cite:before {
    margin-right: 5px;
}
#page .default.upost-data-object-post_data  .post_content blockquote cite:after {
    margin-left: 5px;
}
#page .default.upost-data-object-post_data  .post_content ol, #page .default.upost-data-object-post_data  .post_content ul {
    position: relative;
    list-style: none;
}
#page .default.upost-data-object-post_data  .post_content ol {
    counter-reset: my-counter;
}
#page .default.upost-data-object-post_data  .post_content li {
    margin-bottom: 14px;
}
#page .default.upost-data-object-post_data  .post_content ol > li, #page .default.upost-data-object-post_data  .post_content ul > li {
    padding-left: 25px;
}
#page .default.upost-data-object-post_data  .post_content ol > li:before {
    content: counter(my-counter) ".";
    counter-increment: my-counter;
    position: absolute;
    left: 0;
    color: #c09533;
}
#page .default.upost-data-object-post_data  .post_content ul > li:before {
    content: "•";
    width: 24px;
    height: 24px !important;
    position: absolute;
    left: 0;
    color: #c09533;
}
',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458454099582-1746',
    'top_padding_num' => '55',
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
         'preset' => 'title-only',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '55',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 15,
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
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
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458454602635-1059',
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
      'wrapper_id' => 'wrapper-1458454099579-1302',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458454099580-1647',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'row' => 10,
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
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
          'row' => 15,
        ),
      ),
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454638156-1649 upfront-module-spacer',
  'id' => 'module-1458454638156-1649',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458454638155-1817',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458454638154-1605',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
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

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458453843609-1864 upfront-module-spacer',
  'id' => 'module-1458453843609-1864',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458453843609-1642',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458453843607-1278',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 4,
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

$main_area->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458657699856-1855',
  'id' => 'module-1458657699856-1855',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-featured_image',
    'id_slug' => 'post-data',
    'data_type' => 'featured_image',
    'preset' => 'default',
    'row' => 65,
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
    'element_id' => 'post-data-object-1458657699855-1105',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458453839037-1969',
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
      0 => 'edited',
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
      'wrapper_id' => 'wrapper-1458657699854-1334',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458657699855-1344',
      'row' => 65,
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
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
    ),
  ),
));

$main_area->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458453033430-1469',
  'id' => 'module-1458453033430-1469',
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
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '16',
    'static-date_posted-line-height' => '1.875',
    'static-date_posted-font-color' => 'rgba(0,0,0,1)',
    'static-title-use-typography' => '',
    'static-title-font-family' => 'Cantata One',
    'static-title-weight' => '400',
    'static-title-fontstyle' => '400 normal',
    'static-title-style' => 'normal',
    'static-title-font-size' => '46',
    'static-title-line-height' => '1',
    'static-title-font-color' => 'rgba(192,149,51,1)',
    'preset_style' => '',
    'element_id' => 'post-data-object-1458453033428-1816',
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
    'theme_preset' => 'true',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'use_padding',
       'mobile' =>
      array (
      ),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458453839037-1969',
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
      'wrapper_id' => 'wrapper-1458660963530-1597',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458660963531-1584',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 1,
          'clear' => true,
        ),
      ),
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
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458453847158-1986 upfront-module-spacer',
  'id' => 'module-1458453847158-1986',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458453847157-1429',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458453847157-1075',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 4,
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

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458453173462-1015 upfront-module-spacer',
  'id' => 'module-1458453173462-1015',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458453173462-1089',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458453173461-1594',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 4,
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

$main_area->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458452337778-1350',
  'id' => 'module-1458452337778-1350',
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
    'element_id' => 'post-data-object-1458452337778-1420',
    'top_padding_num' => '30',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
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
         'preset' => 'comments-and-form-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'comments-and-form-only-for-mobile',
      )),
    )),
    'static-comment_count-use-typography' => '',
    'static-comment_count-font-family' => 'Lato',
    'static-comment_count-weight' => '400',
    'static-comment_count-fontstyle' => '400 normal',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '16',
    'static-comment_count-line-height' => '1.875',
    'static-comment_count-font-color' => 'rgba(0,0,0,1)',
    'static-comments-use-typography' => '',
    'static-comments-font-family' => 'Lato',
    'static-comments-weight' => '400',
    'static-comments-fontstyle' => '400 normal',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '16',
    'static-comments-line-height' => '1.875',
    'static-comments-font-color' => 'rgba(0,0,0,1)',
    'static-comments_pagination-use-typography' => '',
    'static-comments_pagination-font-family' => 'Lato',
    'static-comments_pagination-weight' => '400',
    'static-comments_pagination-fontstyle' => '400 normal',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '16',
    'static-comments_pagination-line-height' => '1.875',
    'static-comments_pagination-font-color' => 'rgba(111,206,206,1)',
    'static-comment_form-use-typography' => '',
    'static-comment_form-font-family' => 'Lato',
    'static-comment_form-weight' => '400',
    'static-comment_form-fontstyle' => '400 normal',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '16',
    'static-comment_form-line-height' => '1.875',
    'static-comment_form-font-color' => 'rgba(0,0,0,1)',
    'preset_style' => '#page .default.upost-data-object-comments  .upfront-comments {
    border-top: 1px dashed /*#ufc3*/#000000;
    list-style: none;
    margin: 0;
    padding: 50px 0 0;
}
#page .default.upost-data-object-comments .comment-respond {
    border-top: 1px dashed /*#ufc3*/#000000;
    margin-top: 50px;
    overflow: hidden;
    padding-top: 50px;
}
#page .default.upost-data-object-comments  .upfront-comments + .comment-respond {
    border-top-style: dashed;
}
#page .default.upost-data-object-comments  .upfront-comments ol.children {
    margin-left: 45px;
}
#page .default.upost-data-object-comments li.comment {
    list-style-type: none;
    margin: 10px 0;
    overflow: hidden;
}
#page .default.upost-data-object-comments li.comment.depth-1:first-child {
    margin-top: 0;
}
#page .default.upost-data-object-comments article {
    overflow: hidden;
}
#page .default.upost-data-object-comments .comment-wrapper {
    background-color: rgba(247,247,247,1);
    overflow: hidden;
    padding: 25px 30px;
}
#page .default.upost-data-object-comments .comment-avatar {
    float: left;
    max-height: 75px;
    margin-right: 30px;
}
#page .default.upost-data-object-comments .avatar {
    background: /*#ufc2*/#ffffff;
    box-sizing: border-box;
    padding: 2px;
    border: 1px solid /*#ufc0*/#c09533;
    border-radius: 50%;
    height: 75px;
    width: 75px;
}
#page .default.upost-data-object-comments .comment-content-wrapper {
    float: left;
    width: 100%;
}
#page .default.upost-data-object-comments .depth-2 .comment-content-wrapper {
    width: 100%;
}
#page .default.upost-data-object-comments  .depth-3 .comment-content-wrapper {
    width: 100%;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-author .fn, #page .default.upost-data-object-comments  .upfront-comments .comment-author a {
    color: /*#ufc0*/#c09533;
    font-size: 25px;
    font-style: normal;
    font-weight: 300;
    line-height: 1.7em;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-author a:hover {
    color: /*#ufc5*/#9a7729;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time {
    margin-top: -5px;
    margin-bottom: 5px;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time a {
    color: /*#ufc3*/#000000;
    font-size: 13px;
    font-weight: 400;
    line-height: 25px;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time a:hover {
    text-decoration: none;
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments .comment-content {
    margin-bottom: 5px;
}
#page .default.upost-data-object-comments .comment-content p {
    padding: 0;
}
#page .default.upost-data-object-comments .comment-content p:last-child {
    margin: 0;
}
#page .default.upost-data-object-comments  .edit-link {
    margin-bottom: 0;
    padding: 0;
}
#page .default.upost-data-object-comments  .comment-edit-link {
    color:/*#ufc0*/#c09533;
    font-size: 13px;
    font-weight: 400;
    line-height: 25px;
}
#page .default.upost-data-object-comments  .comment-edit-link:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments .comment-meta-actions {
    margin-top: 5px;
    overflow: hidden;
}
#page .default.upost-data-object-comments  p.comment-awaiting-moderap.comment-awaiting-moderation {
    float: left;
    font-size: 14px;
    font-style: italic;
    line-height: 25px;
    margin-bottom: 0;
    width: 100%;
}
#page .default.upost-data-object-comments  p.comment-awaiting-moderation + .comment-reply {
    float: left;
    max-width: 25%;
}
#page .default.upost-data-object-comments .comment-reply {
    text-align: right;
    width: 100%;
}
#page .default.upost-data-object-comments .comment-reply a {
    font-weight: 400;
    color:/*#ufc0*/#c09533;
    font-size: 13px;
    line-height: 25px;
}
#page .default.upost-data-object-comments .comment-reply a:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments h3.comment-reply-title {
    font-size: 25px;
    font-weight: 300;
    line-height: 1.7em;
    margin: 0;
    padding: 0;
    letter-spacing: -0.5px;
}
#page .default.upost-data-object-comments h3.comment-reply-title:after {
    display: none;
}
#page .default.upost-data-object-comments h3.comment-reply-title a {
    color: /*#ufc0*/#c09533;
    text-transform: none;
    font-weight: 300;
}
#page .default.upost-data-object-comments h3.comment-reply-title small {
    display: block;
}
#page .default.upost-data-object-comments #cancel-comment-reply-link {
    color: /*#ufc1*/#6fcece;
    font-size: 13px;
    line-height: 25px;
    letter-spacing: 0px;
}
#page .default.upost-data-object-comments #cancel-comment-reply-link:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments p.logged-in-as {
    color: /*#ufc3*/#000000;
    font-size: 15px;
    line-height: 25px;
}
#page .default.upost-data-object-comments p.logged-in-as a {
    color: /*#ufc0*/#c09533;
    font-weight: 300;
}
#page .default.upost-data-object-comments p.logged-in-as a:last-child {
}
#page .default.upost-data-object-comments p.logged-in-as a:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments .comment-form input[type="text"], #page .default.upost-data-object-comments .comment-form textarea {
    border-radius:4px;
    border: 1px solid #cacaca;
    box-sizing: border-box;
    color: #808080;
    font-family: "Lato", Arial, sans-serif;
    font-size: 16px;
    line-height: 30px;
    -webkit-transition: border-color .4s;
    transition: border-color .4s;
    width: 100%;
}
#page .default.upost-data-object-comments .comment-form input[type="text"] {
    padding: 5px 15px;
}
#page .default.upost-data-object-comments .comment-form textarea {
    padding: 10px 15px;
}
#page .default.upost-data-object-comments .comment-form input[type="text"]:focus, #page .default.upost-data-object-comments .comment-form textarea:focus {
    border-color: /*#ufc1*/#6fcece;
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-comments .comment-form label {
    color: /*#ufc3*/#000000;
    display: block;
    font-size:13px;
    font-weight: 400;
    line-height: 1.7em;
    margin: 0 0 5px;
    padding: 0;
}
#page .default.upost-data-object-comments .comment-form-comment label {
    display: none;
}
#page .default.upost-data-object-comments .comment-form p {
    padding: 0;
}
#page .default.upost-data-object-comments  p.comment-form-author, #page .default.upost-data-object-comments  p.comment-form-email, #page .default.upost-data-object-comments  p.comment-form-url {
    float: left;
    margin-left: 2%;
    width: 32%;
}
#page .default.upost-data-object-comments  p.comment-form-author {
    margin-left: 0;
}
#page .default.upost-data-object-comments p.comment-form-comment {
    clear: both;
}
#page .default.upost-data-object-comments  p.comment-notes {
    color: /*#ufc3*/#000000;
    font-size: 12px;
    line-height: 25px;
}
#page .default.upost-data-object-comments p.form-submit {
    margin: 0;
    text-align: right;
}
#page .default.upost-data-object-comments input.submit {
    background: /*#ufc0*/#c09533;
    border-bottom: 2px solid /*#ufc5*/#9a7729;
    border-radius:4px;
    color: /*#ufc2*/#ffffff;
    font-family: "Lato", Arial, sans-serif;
    font-size: 14px;
    font-weight: 500;
    line-height: 40px;
    min-width: 150px;
    padding: 0 15px;
    text-decoration: none;
    text-transform: uppercase;
    -webkit-transition: background-color .2s;
    transition: background-color .2s;
    margin-bottom:0;
}
#page .default.upost-data-object-comments input.submit:hover {
    background-color: /*#ufc5*/#9a7729;
}
',
    'hidden_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments_pagination',
    ),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      array (
      ),
    )),
    'theme_preset' => 'true',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458452350096-1246',
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
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1458666879721-1965',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458666879723-1514',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 1,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 1,
          'clear' => true,
        ),
      ),
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
      ),
    ),
    1 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1458666891505-1497',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458666891506-1197',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 2,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 2,
          'clear' => true,
        ),
      ),
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
      ),
    ),
  ),
));

$main_area->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458453175711-1763 upfront-module-spacer',
  'id' => 'module-1458453175711-1763',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458453175711-1591',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458453175710-1834',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 4,
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

$regions->add($main_area);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
