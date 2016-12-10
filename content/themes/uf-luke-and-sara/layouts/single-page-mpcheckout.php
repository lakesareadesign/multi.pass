<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$checkout_header = upfront_create_region(
			array (
  'name' => 'checkout-header',
  'title' => 'Checkout Header',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'checkout-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 28,
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
  'background_type' => 'image',
  'background_color' => '#ffffff',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'background_style' => 'full',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'background_size_percent' => '100',
  'background_image' => '{{upfront:style_url}}/images/single-page-mpcheckout/bg-store.jpg',
  'background_image_ratio' => 0.1499999999999999944488848768742172978818416595458984375,
)
			);

$checkout_header->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479018935294-1142',
  'id' => 'module-1479018935294-1142',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1 style="text-align: center;"><span class="upfront_theme_color_5">CHECKOUT</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1479018935294-1688',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '50',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '50',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
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
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1479020688500-1190',
  'new_line' => true,
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
));

$checkout_header->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479020688753-1672',
  'id' => 'module-1479020688753-1672',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: center;"><span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2">EVENTS • TIPS • PHOTOS</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1479020688753-1423',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '10',
    'top_padding_num' => '0',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'row' => 5,
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
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1479020714229-1275',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 2,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 2,
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
));

$regions->add($checkout_header);

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
       'bg_padding_num' => '30',
       'top_bg_padding_num' => '30',
       'bottom_bg_padding_num' => '30',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_num' => '70',
  'bottom_bg_padding_num' => '90',
  'bg_padding_num' => 0,
  'background_style' => 'tile',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'background_size_percent' => '100',
  'background_repeat' => 'repeat',
  'background_image' => '{{upfront:style_url}}/images/single-page-mpcheckout/noise.jpg',
  'background_image_ratio' => 1,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479018998148-1723 upfront-module-spacer',
  'id' => 'module-1479018998148-1723',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479018998148-1330',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479018998148-1359',
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
  'class' => 'module-1467787537272-1394',
  'id' => 'module-1467787537272-1394',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'mp-checkout',
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
    'element_id' => 'post-data-object-1467787537271-1215',
    'top_padding_num' => 15,
    'bottom_padding_num' => 15,
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'left_padding_num' => 15,
    'right_padding_num' => 15,
    'lock_padding' => '',
    'anchor' => '',
    'current_preset' => 'mp-checkout',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'mp-checkout',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'mp-checkout-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'mp-checkout-mobile',
      )),
    )),
    'static-date_posted-font-family' => 'Quattrocento Sans',
    'static-date_posted-fontstyle' => '',
    'static-date_posted-weight' => '400',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.563',
    'static-date_posted-font-color' => '#ufc2',
    'theme_preset' => 'true',
    'static-date_posted-use-typography' => 'yes',
    'preset_style' => '#page .default.upost-data-object-post_data  .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data  .upostdata-part.date_posted {
    text-transform: uppercase;
    text-align: center;
}
#page .default.upost-data-object-post_data  .content h1, #page .default.upost-data-object-post_data  .content h2, #page .default.upost-data-object-post_data  .content h3, #page .default.upost-data-object-post_data  .content h4, #page .default.upost-data-object-post_data  .content h5, #page .default.upost-data-object-post_data  .content p, #page .default.upost-data-object-post_data  .content address, #page .default.upost-data-object-post_data  .content table, #page .default.upost-data-object-post_data  .content pre, #page .default.upost-data-object-post_data  .content cite, #page .default.upost-data-object-post_data  .content q, #page .default.upost-data-object-post_data  .content iframe, #page .default.upost-data-object-post_data  .content embed {
    margin: 0 0 35px;
    padding: 0;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data  .content h6 {
    margin: 0 0 5px;
    padding: 0;
    text-transform: uppercase;
    word-break: break-word;
    -ms-word-break: break-word;
}
#page .default.upost-data-object-post_data  .content p:last-of-type {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .content > ul, #page .default.upost-data-object-post_data  .content > ol {
    margin: 0 0 35px;
}
#page .default.upost-data-object-post_data  .content > ul li, #page .default.upost-data-object-post_data  .content > ol li {
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data  .content > ul {
    list-style: none;
    margin-left: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data  .content > ul li:before {
    background: url("//lukesara.upfront.mp/wp-content/themes/uf-luke-and-sara/ui/sprites-v2.png") no-repeat;
    background-image: url("//lukesara.upfront.mp/wp-content/themes/uf-luke-and-sara/ui/lightning.svg"), none;
    background-position: -871px -74px;
    content: "";
    display: block;
    float: left;
    height: 14px;
    margin: 10px 10px 0 0;
    width: 18px;
}
#page .default.upost-data-object-post_data  .content > .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data  .content > *:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .content img {
    display: block;
    height: auto;
    max-width: 100%;
    margin-top: 10px;
}
#page .default.upost-data-object-post_data  .content .alignnone, #page .default.upost-data-object-post_data  .content .aligncenter, #page .default.upost-data-object-post_data  .content .alignright, #page .default.upost-data-object-post_data  .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data  .content .alignnone, #page .default.upost-data-object-post_data  .content div.alignnone, #page .default.upost-data-object-post_data  .content .aligncenter, #page .default.upost-data-object-post_data  .content div.aligncenter, #page .default.upost-data-object-post_data  .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data  .content div.alignnone, #page .default.upost-data-object-post_data  .content p img.alignnone, #page .default.upost-data-object-post_data  .content div.aligncenter, #page .default.upost-data-object-post_data  .content p img.aligncenter, #page .default.upost-data-object-post_data  .content div.alignright, #page .default.upost-data-object-post_data  .content p img.alignright, #page .default.upost-data-object-post_data  .content div.alignleft, #page .default.upost-data-object-post_data  .content p img.alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data  .content div.alignnone, #page .default.upost-data-object-post_data  .content img.alignnone .content div.aligncenter, #page .default.upost-data-object-post_data  .content img.aligncenter {
    display: block;
    margin: 0 auto 30px auto;
}
#page .default.upost-data-object-post_data  .content img {
    max-width: 100%;
    height: auto;
    display: block;
}
#page .default.upost-data-object-post_data  .content .alignright, #page .default.upost-data-object-post_data  .content img.alignright {
    float: right;
    margin: 0 0 30px 30px;
}
#page .default.upost-data-object-post_data  .content .alignleft, #page .default.upost-data-object-post_data  .content img.alignleft {
    float: left;
    margin: 0 30px 30px 0;
}
#page .default.upost-data-object-post_data  .content .wp-caption-text p, #page .default.upost-data-object-post_data  .content p.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "Lato";
    font-size: 15px;
    line-height: 1.333em;
    margin-top: 15px;
    margin-bottom: 0;
    padding: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data  .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data  .content .wp-caption-text a {
    color: /*#ufc0*/#333333;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.333em;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data  .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data  .upfront-inserted_image-wrapper.ueditor-insert-variant .ueditor-insert {
    margin: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-full-width, #page .default.upost-data-object-post_data  .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-center {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-right {
    margin: 0 0 15px 30px;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert-variant .ueditor-insert.ueditor-image-style-left {
    margin: 0 30px 15px 0;
}
#page .default.upost-data-object-post_data  .content .upfront-wrapper.uinsert-image-wrapper {
    min-height: auto !important;
    padding: 0;
}
#page .default.upost-data-object-post_data  .uinsert-image-wrapper img {
    margin-right: auto;
    margin-left: auto;
    width: auto;
}
#page .default.upost-data-object-post_data  .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc1*/#61737b;
    font-family: "lato";
    font-size: 15px;
    line-height: 1.333em;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 15px 0 0;
}
#page .default.upost-data-object-post_data  .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data  .content blockquote {
    margin: 0 45px 45px;
    padding-top:10px;
    text-align: center;
}
#page .default.upost-data-object-post_data  .content blockquote p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .post_content form p {
    position: relative;
}
#page .default.upost-data-object-post_data  .content input[type="password"] {
    width: 100%;
    max-width: 240px;
    padding: 6px 80px 6px 6px;
    border: 1px solid #dddddd;
    background: #fcfcfc;
    font-size: 16px;
    line-height: 1.5em;
}
#page .default.upost-data-object-post_data  .content input[type="submit"] {
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
#page .default.upost-data-object-post_data  .content input[type="submit"]:hover {
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
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
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
  'wrapper_id' => 'wrapper-1467787553104-1347',
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
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1478133859020-1319',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1478133846931-1138',
      'padding_slider' => 15,
      'top_padding_num' => 15,
      'left_padding_num' => 15,
      'right_padding_num' => 15,
      'bottom_padding_num' => 15,
      'lock_padding' => '',
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
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'use_padding' => 'yes',
          'hide' => 0,
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
    1 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1467787537270-1603',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1467787537271-1078',
      'padding_slider' => 15,
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
      'top_padding_num' => 15,
      'left_padding_num' => 15,
      'right_padding_num' => 15,
      'bottom_padding_num' => 15,
      'lock_padding' => '',
      'current_preset' => 'default',
      'preset' => 'default',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
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
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479019000510-1682 upfront-module-spacer',
  'id' => 'module-1479019000510-1682',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479019000510-1666',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479019000509-1434',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
