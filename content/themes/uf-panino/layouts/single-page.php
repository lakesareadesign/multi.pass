<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php');

$page_header = upfront_create_region(
			array (
  'name' => 'page-header',
  'title' => 'Page Header',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'page-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 77,
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
  'background_type' => 'featured',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ufc2',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_default' => 'image',
  'background_image' => '{{upfront:style_url}}/images/single-page/slider-img-1.jpg',
  'background_image_ratio' => 0.5500000000000000444089209850062616169452667236328125,
)
			);

$regions->add($page_header);

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
  'row' => 40,
  'background_type' => 'image',
  'background_color' => '#c5d0db',
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
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
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
  'class' => 'module-1458561073754-1632 upfront-module-spacer',
  'id' => 'module-1458561073754-1632',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458561073754-1782',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458561073753-1275',
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
  'class' => 'module-1458561062830-1091',
  'id' => 'module-1458561062830-1091',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-and-content',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'd M',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
    <div class="date">
        <span class="date_part date_part_1">{{date_1}}</span>
        <span class="date_part date_part_2">{{date_2}}</span>
    </div>
</div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'theme_preset' => 'true',
    'preset_style' => '#page .default.upost-data-object-post_data .upfront-post-data-part {
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content {
    margin-top: 30px;
}
#page .default.upost-data-object-post_data .upostdata-part:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .date_posted {
    background-color: /*#ufc0*/#f9d632;
    border-radius: 50%;
    display: block;
    height: 88px;
    margin: 0 auto;
    text-align: center;
    width: 88px;
}
#page .default.upost-data-object-post_data .date {
    display: block;
    padding: 15px 0;
}
#page .default.upost-data-object-post_data .date .date_part {
    display: block;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .date .date_part_2 {
    font-size: 22px;
}
#page .default.upost-data-object-post_data .title h1 {
    margin: 0;
    padding: 0;
    -ms-word-wrap: break-word;
    word-wrap: break-word;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    margin: 0 0 30px;
}
#page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content h6 {
    margin: 0 0 10px;
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
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 5px 30px 15px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 15px 30px 5px;
}
#page .default.upost-data-object-post_data .content h4 {
    line-height: 1.667em;
}
#page .default.upost-data-object-post_data .content p {
    -ms-word-break: break-word;
    word-break: break-word;
}
#page .default.upost-data-object-post_data .content ul, #page .default.upost-data-object-post_data .content ol {
    margin-bottom: 30px
}
#page .default.upost-data-object-post_data .content ul li, #page .default.upost-data-object-post_data .content ol li {
    margin-bottom: 10px
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    color: /*#ufc1*/#2c3130;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.667em;
    margin-top: 15px;
    margin-bottom: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#f9d632;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.333em;
}
#page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .ueditor-insert {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert {
    margin: 0 0 30px;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-center {
    margin-right: auto;
    margin-left: auto;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-full-width {
    margin-right: 0;
    margin-left: 0;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-right {
    margin-left: 30px;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-left {
    margin-right: 30px;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc1*/#2c3130;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.667em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content dl {
    font-family: "Special Elite", Arial, sans-serif;
    font-weight: 400;
    font-size: 18px;
    font-style: normal;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content dt {
    line-height: 2.2em;
    text-decoration: underline;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content dd {
    color: /*#ufc3*/#7e8c89;
    line-height: 2.2em;
    margin: 0;
    padding: 0 0 0 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content pre {
    background: /*#ufc3*/#7e8c89;
    padding: 15px !important;
    white-space: pre-wrap;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content address {
    color: /*#ufc3*/#7e8c89;
    font-family: "Special Elite", Arial, sans-serif;
    font-weight: 400;
    font-size: 18px;
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table {
    border-spacing: 0;
    border-collapse: collapse;
    margin-bottom: 30px;
    max-width: 100%;
    width: 100%;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > tbody > tr > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > tbody > tr > th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > tfoot > tr > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > tfoot > tr > th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > thead > tr > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > thead > tr > th {
    border-top: 1px solid #cacbcb;
    color: /*#ufc3*/#7e8c89;
    font-family: "Special Elite", Arial, sans-serif;
    line-height: 1.4em;
    padding: 10px;
    text-align: left;
    vertical-align: top;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > thead > tr > th {
    border-bottom: 2px solid #cacbcb;
    color: /*#ufc1*/#2c3130;
    font-size: 18px;
    vertical-align: bottom;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table thead > tr:first-child > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table thead > tr:first-child > th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table thead > tr:first-child > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table thead > tr:first-child > th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > thead:first-child > tr:first-child > td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content table > thead:first-child > tr:first-child > th {
    border-top: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content .post-password-form input[type="password"] {
    background: /*#ufc2*/#ededed;
    box-sizing: border-box;
    color: /*#ufc3*/#7e8c89;
    font-family: "Lato", Arial, sans-serif;
    font-size: 13px;
    padding: 15px;
    width: 100%;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content .post-password-form input[type="submit"] {
    background: /*#ufc0*/#f9d632;
    color: /*#ufc5*/#ffffff;
    font-size: 16px;
    margin-top: 15px;
    padding: 10px 20px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content iframe, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content embed {
    display: block;
    max-width: 100%;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content blockquote cite {
    color: /*#ufc3*/#7e8c89;
    display: block;
    font-size: 20px;
    text-transform: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content blockquote cite:before {
    content: "-";
    display: inline-block;
    margin-right: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content blockquote cite a {
    text-decoration: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content .gallery-icon img {
    width: 100%;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .content .gallery-caption {
    padding: 0;
}
',
    'static-title-font-family' => 'Lato',
    'static-title-fontstyle' => 'regular',
    'static-title-weight' => '400',
    'static-title-style' => 'normal',
    'static-title-font-size' => '',
    'static-title-line-height' => '',
    'static-title-font-color' => '#ufc0',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Special Elite',
    'static-date_posted-fontstyle' => '',
    'static-date_posted-weight' => '400',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '40',
    'static-date_posted-line-height' => '1',
    'static-date_posted-font-color' => '#ufc5',
    'element_id' => 'post-data-object-1458561062827-1013',
    'top_padding_num' => '90',
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
         'preset' => 'title-and-content',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '90',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'title-and-content',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458561068908-1040',
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
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1458561062825-1625',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458561062825-1022',
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
    1 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458561062826-1363',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458561062826-1090',
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
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
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

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458561077511-1813 upfront-module-spacer',
  'id' => 'module-1458561077511-1813',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458561077511-1384',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458561077510-1967',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
