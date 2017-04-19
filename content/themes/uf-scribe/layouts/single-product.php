<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

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
  'version' => '1.0.0',
  'row' => 177,
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
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_type' => 'color',
  'background_color' => '#ffffff',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1477143051064-1201 upfront-module-spacer',
  'id' => 'module-1477143051064-1201',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1477143051063-1045',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1477143051063-1743',
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
  'class' => 'module-1477143004831-1957',
  'id' => 'module-1477143004831-1957',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'default',
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
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '400',
    'static-date_posted-fontstyle' => '400 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.875',
    'static-date_posted-font-color' => 'rgba(0,0,0,1)',
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
#page .default.upost-data-object-post_data .upostdata-part.title h1 {
    margin: 0;
}
#page .default.upost-data-object-post_data .content {
    padding-bottom: 0;
}
#page .default.upost-data-object-post_data  .upfront-postpart-date {
    padding-right: 0;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    position: relative;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    color: /*#ufc3*/#000000;
    font-size: 13px;
    font-weight: 300;
    line-height: 30px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .upfront-postpart-author {
    padding-left: 0;
}
#page .default.upost-data-object-post_data  .upostdata-part.author a {
    color: /*#ufc0*/#c09533;
    font-size: 13px;
    font-weight: 400;
    line-height: 30px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .upostdata-part.author a:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-post_data .upostdata-part.title, #page .default.upost-data-object-post_data .upostdata-part.title a {
    color: /*#ufc0*/#c09533;
    padding: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.title a:hover {
    color: /*#ufc3*/#000000;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table {
    margin: 0 0 45px;
    padding: 0;
}
#page .default.upost-data-object-post_data .content h2 {
    text-align: center;
}
#page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content h6 {
    margin: 0 0 10px;
    padding: 0;
}
#page .default.upost-data-object-post_data .content h4:after {
    border-bottom: none;
}
#page .default.upost-data-object-post_data .content p {
    margin: 0 0 25px;
    padding: 0;
}
#page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    margin: 0 0 25px;
    padding: 0;
}
#page .default.upost-data-object-post_data .content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data .content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content img {
    display: block;
    height: auto;
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 45px auto;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 0 45px 45px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 45px 45px 0;
}
#page .default.upost-data-object-post_data .content h3 {
    color: /*#ufc3*/#000000;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data .content h3:after {
    display: none;
}
#page .default.upost-data-object-post_data .content p {
    -ms-word-break: break-word;
    word-break: break-word;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    color: /*#ufc3*/#000000;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5em;
    margin-top: 10px;
    margin-bottom: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#c09533;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.563em;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a:hover {
    color: /*#ufc5*/#9a7729;
}
#page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .ueditor-insert {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-full-width, #page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-center {
    margin-bottom: 45px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-right {
    margin: 0 0 30px 45px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-image-style-left {
    margin: 0 45px 30px 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc3*/#000000;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content blockquote {
    margin: 45px 0 45px;
    display:block;
    position: relative;
    text-align: center;
}
#page .default.upost-data-object-post_data .content blockquote:before {
    border-left: 3px solid /*#ufc1*/#6fcece;
    content: "";
    display: inline-block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data .content blockquote p {
    margin: 0 60px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .content blockquote p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content blockquote cite {
    display: block;
    font-weight: 300;
    font-size: 16px;
    font-style: normal;
    line-height: 1.875em;
    position: relative;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .content blockquote cite:before, #page .default.upost-data-object-post_data .content blockquote cite:after {
    content: "-";
}
#page .default.upost-data-object-post_data .content blockquote cite:before {
    margin-right: 5px;
}
#page .default.upost-data-object-post_data .content blockquote cite:after {
    margin-left: 5px;
}
#page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options), #page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options) {
    position: relative;
    list-style: none;
}
#page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options) {
    counter-reset: my-counter;
}
#page .default.upost-data-object-post_data .content li {
    margin-bottom: 14px;
}
#page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options) > li, #page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options) > li {
    padding-left: 25px;
}
#page .default.upost-data-object-post_data .content ol:not(.upfront-field-select-options) > li:before {
    content: counter(my-counter) ".";
    counter-increment: my-counter;
    position: absolute;
    left: 0;
    color: #c09533;
}
#page .default.upost-data-object-post_data .content ul:not(.upfront-field-select-options) > li:before {
    content: "•";
    width: 24px;
    height: 24px !important;
    position: absolute;
    left: 0;
    color: #c09533;
}
',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'element_id' => 'post-data-object-1477143004830-1414',
    'top_padding_num' => '60',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'bottom_padding_num' => '15',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1477143047103-1922',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 1,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1477143004829-1808',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1477143004829-1107',
      'padding_slider' => '15',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
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
    ),
    1 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1477143004829-1618',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1477143004830-1097',
      'padding_slider' => '15',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
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
    ),
    2 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1477143004830-1888',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1477143004830-1885',
      'padding_slider' => '15',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
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
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1477143057429-1991 upfront-module-spacer',
  'id' => 'module-1477143057429-1991',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1477143057428-1122',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1477143057428-1807',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
