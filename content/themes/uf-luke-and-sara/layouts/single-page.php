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
  'background_type' => 'image',
  'background_color' => '#ufc5',
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
  'background_image' => '{{upfront:style_url}}/images/single-page/noise.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '90',
  'top_bg_padding_num' => '90',
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458729124703-1673 upfront-module-spacer',
  'id' => 'module-1458729124703-1673',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458729124702-1253',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458729124702-1384',
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
  'class' => 'module-1458728998806-1816',
  'id' => 'module-1458728998806-1816',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'the-title',
    'row' => 6,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h3>{{title}}</h3>
</div>',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-font-family' => 'Quattrocento Sans',
    'static-date_posted-fontstyle' => '',
    'static-date_posted-weight' => '400',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.563',
    'static-date_posted-font-color' => '#ufc2',
    'theme_preset' => 'true',
    'static-date_posted-use-typography' => 'yes',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-transform: uppercase;
    text-align: center;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    margin: 0 0 35px;
    padding: 0;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data .content h6 {
    margin: 0 0 5px;
    padding: 0;
    text-transform: uppercase;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data .content p:last-of-type {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content > ul, #page .default.upost-data-object-post_data .content > ol {
    margin: 0 0 35px;
}
#page .default.upost-data-object-post_data .content > ul li, #page .default.upost-data-object-post_data .content > ol li {
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data .content > ul {
    list-style: none;
    margin-left: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .content > ul li:before {
    background: url("//uf-lukesara.dev/wp-content/themes/uf-luke-and-sara/ui/sprites-v2.png") no-repeat;
    background-image: url("//uf-lukesara.dev/wp-content/themes/uf-luke-and-sara/ui/lightning.svg"), none;
    background-position: -871px -74px;
    content: "";
    display: block;
    float: left;
    height: 14px;
    margin: 10px 10px 0 0;
    width: 18px;
}
#page .default.upost-data-object-post_data .content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data .content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content img {
    display: block;
    height: auto;
    max-width: 100%;
    margin-top: 10px;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content p img.alignnone, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content p img.aligncenter, #page .default.upost-data-object-post_data .content div.alignright, #page .default.upost-data-object-post_data .content p img.alignright, #page .default.upost-data-object-post_data .content div.alignleft, #page .default.upost-data-object-post_data .content p img.alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content img.alignnone .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content img {
    max-width: 100%;
    height: auto;
    display: block;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 0 30px 30px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 30px 30px 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "Lato";
    font-size: 15px;
    line-height: 1.333em;
    margin-top: 15px;
    margin-bottom: 0;
    padding: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#333333;
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
#page .default.upost-data-object-post_data  .upfront-inserted_image-wrapper.ueditor-insert-variant .ueditor-insert {
    margin: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-full-width, #page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-center {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-right {
    margin: 0 0 15px 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-left {
    margin: 0 30px 15px 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data  .uinsert-image-wrapper img {
    margin-right: auto;
    margin-left: auto;
    width: auto;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "lato";
    font-size: 15px;
    line-height: 1.333em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content blockquote {
    margin: 0 45px 45px;
    padding-top:10px;
    text-align: center;
}
#page .default.upost-data-object-post_data .content blockquote p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .post_content form p {
    position: relative;
}
#page .default.upost-data-object-post_data .content input[type="password"] {
    width: 100%;
    max-width: 240px;
    padding: 6px 80px 6px 6px;
    border: 1px solid #dddddd;
    background: #fcfcfc;
    font-size: 16px;
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data .content input[type="submit"] {
    position: absolute;
    top: 1px;
    left: 242px;
    padding: 4px 8px;
    border-left: 1px solid #dddddd;
    background: #01bc9d;
    color: #ffffff;
    line-height: 28px;
    font-weight: 700;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s ease-in;
    -o-transition: background 0.3s ease-in;
    -ms-transition: background 0.3s ease-in;
    -moz-transition: background 0.3s ease-in;
    -webkit-transition: background 0.3s ease-in;
}
#page .default.upost-data-object-post_data .content input[type="submit"]:hover {
    background: #00a384;
}
',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Quattrocento',
    'static-title-fontstyle' => '',
    'static-title-weight' => '400',
    'static-title-style' => 'normal',
    'static-title-font-size' => '60',
    'static-title-line-height' => '1.2',
    'static-title-font-color' => '#ufc0',
    'predefined_date_format' => '0',
    'element_id' => 'post-data-object-1458728998804-1564',
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
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'the-title',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'the-title-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'the-title-mobile',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
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
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458729120677-1968',
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
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1458729658723-1552',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458729658724-1965',
      'padding_slider' => '10',
      'use_padding' => 'yes',
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
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458729190786-1439 upfront-module-spacer',
  'id' => 'module-1458729190786-1439',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458729190785-1577',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458729190785-1383',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458729374359-1684 upfront-module-spacer',
  'id' => 'module-1458729374359-1684',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458729374359-1553',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458729374358-1657',
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
  'class' => 'module-1458729121005-1588',
  'id' => 'module-1458729121005-1588',
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
    'date_posted_format' => 'F j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h3>{{title}}</h3>
</div>',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-font-family' => 'Quattrocento Sans',
    'static-date_posted-fontstyle' => '',
    'static-date_posted-weight' => '400',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.563',
    'static-date_posted-font-color' => '#ufc2',
    'theme_preset' => 'true',
    'static-date_posted-use-typography' => 'yes',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-transform: uppercase;
    text-align: center;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    margin: 0 0 35px;
    padding: 0;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data .content h6 {
    margin: 0 0 5px;
    padding: 0;
    text-transform: uppercase;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data .content p:last-of-type {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content > ul, #page .default.upost-data-object-post_data .content > ol {
    margin: 0 0 35px;
}
#page .default.upost-data-object-post_data .content > ul li, #page .default.upost-data-object-post_data .content > ol li {
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data .content > ul {
    list-style: none;
    margin-left: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .content > ul li:before {
    background: url("//uf-lukesara.dev/wp-content/themes/uf-luke-and-sara/ui/sprites-v2.png") no-repeat;
    background-image: url("//uf-lukesara.dev/wp-content/themes/uf-luke-and-sara/ui/lightning.svg"), none;
    background-position: -871px -74px;
    content: "";
    display: block;
    float: left;
    height: 14px;
    margin: 10px 10px 0 0;
    width: 18px;
}
#page .default.upost-data-object-post_data .content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data .content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content img {
    display: block;
    height: auto;
    max-width: 100%;
    margin-top: 10px;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content p img.alignnone, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content p img.aligncenter, #page .default.upost-data-object-post_data .content div.alignright, #page .default.upost-data-object-post_data .content p img.alignright, #page .default.upost-data-object-post_data .content div.alignleft, #page .default.upost-data-object-post_data .content p img.alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content img.alignnone .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data .content img {
    max-width: 100%;
    height: auto;
    display: block;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 0 30px 30px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 30px 30px 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "Lato";
    font-size: 15px;
    line-height: 1.333em;
    margin-top: 15px;
    margin-bottom: 0;
    padding: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#333333;
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
#page .default.upost-data-object-post_data  .upfront-inserted_image-wrapper.ueditor-insert-variant .ueditor-insert {
    margin: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-full-width, #page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-center {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-right {
    margin: 0 0 15px 30px;
}
#page .default.upost-data-object-post_data .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-left {
    margin: 0 30px 15px 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data  .uinsert-image-wrapper img {
    margin-right: auto;
    margin-left: auto;
    width: auto;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "lato";
    font-size: 15px;
    line-height: 1.333em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content blockquote {
    margin: 0 45px 45px;
    padding-top:10px;
    text-align: center;
}
#page .default.upost-data-object-post_data .content blockquote p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .post_content form p {
    position: relative;
}
#page .default.upost-data-object-post_data .content input[type="password"] {
    width: 100%;
    max-width: 240px;
    padding: 6px 80px 6px 6px;
    border: 1px solid #dddddd;
    background: #fcfcfc;
    font-size: 16px;
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data .content input[type="submit"] {
    position: absolute;
    top: 1px;
    left: 242px;
    padding: 4px 8px;
    border-left: 1px solid #dddddd;
    background: #01bc9d;
    color: #ffffff;
    line-height: 28px;
    font-weight: 700;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s ease-in;
    -o-transition: background 0.3s ease-in;
    -ms-transition: background 0.3s ease-in;
    -moz-transition: background 0.3s ease-in;
    -webkit-transition: background 0.3s ease-in;
}
#page .default.upost-data-object-post_data .content input[type="submit"]:hover {
    background: #00a384;
}
',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Quattrocento',
    'static-title-fontstyle' => '',
    'static-title-weight' => '400',
    'static-title-style' => 'normal',
    'static-title-font-size' => '60',
    'static-title-line-height' => '1.2',
    'static-title-font-color' => '#ufc0',
    'predefined_date_format' => '0',
    'element_id' => 'post-data-object-1458729121003-1844',
    'top_padding_num' => '25',
    'bottom_padding_num' => '0',
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
         'preset' => 'content-only-for-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'content-only-for-tablet',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '25',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
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
  'wrapper_id' => 'wrapper-1458729347893-1931',
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '18',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458729121002-1233',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458729121002-1147',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'row' => 79,
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
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458729377304-1404 upfront-module-spacer',
  'id' => 'module-1458729377304-1404',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458729377303-1040',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458729377303-1680',
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
