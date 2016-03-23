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
  'row' => 140,
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,1)',
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
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '100',
  'bottom_bg_padding_num' => '100',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454861052-1263 upfront-module-spacer',
  'id' => 'module-1458454861052-1263',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458454861051-1058',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458454861050-1861',
  'new_line' => true,
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

$main->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454857152-1313',
  'id' => 'module-1458454857152-1313',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-only',
    'row' => 24,
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
    'element_id' => 'post-data-object-1458454857149-1979',
    'top_padding_num' => '60',
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
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 20,
      )),
       'mobile' =>
      (array)(array(
         'row' => 16,
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458454856624-1705',
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
      'row' => 20,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 16,
      'top' => 0,
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
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1458454857146-1659',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458454857147-1131',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 24,
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
          'row' => 20,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'row' => 16,
        ),
      ),
    ),
  ),
));

$main->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454836116-1168',
  'id' => 'module-1458454836116-1168',
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
    'element_id' => 'post-data-object-1458454836114-1512',
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
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'lock_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458454856624-1705',
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458454836113-1335',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458454836114-1228',
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

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458454869873-1107 upfront-module-spacer',
  'id' => 'module-1458454869873-1107',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458454869873-1357',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458454869872-1878',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
