<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php');

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
  'background_color' => 'rgba(248,252,213,1)',
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
    )),
  )),
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => '90',
  'bg_padding_num' => 0,
  'background_style' => 'tile',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'background_size_percent' => '100',
  'background_image' => '{{upfront:style_url}}/images/single-page-mpcheckout/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1478776372694-1425 upfront-module-spacer',
  'id' => 'module-1478776372694-1425',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1478776372693-1137',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1478776372692-1745',
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

$main->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_top' => '0',
  'class' => '',
  'id' => 'module-1479742287968-1675',
  'options' =>
  array (
    'content' => '<h1>Checkout</h1>',
    'type' => 'PlainTxtModel',
    'view_class' => 'PlainTxtView',
    'element_id' => 'text-object-1479742287968-1714',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'id_slug' => 'plain_text',
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '90',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '90',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 15,
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
  'close_wrapper' => false,
));

$main->add_element("PostData", array (
  'columns' => '18',
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
    'preset' => 'mp',
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
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'left_padding_num' => 15,
    'right_padding_num' => 15,
    'lock_padding' => '',
    'anchor' => '',
    'current_preset' => 'mp',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'mp',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'mp-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'mp-mobile',
      )),
    )),
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
#page .default.upost-data-object-post_data /* WooCommerce Global Styles */
.upfront-post-data-part.part-content .woocommerce h2 {
    font-size: 24px;
    line-height: 1.3em;
    margin: 0 0 15px;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce h3 {
    background: transparent;
    color: /*#ufc1*/#2c3130;
    font: 400 24px/1.3em "Special Elite", Arial, sans-serif;
    margin: 0 0 15px;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce li:before {
    content: "";
    display: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table {
    border: none;
    border-radius: 0;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table th {
    padding: 10px;
    vertical-align: middle;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table thead th {
    border-bottom: 1px solid /*#ufc4*/#474e4d;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table th {
    font-weight: 700;
    line-height: 1.4em;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tbody th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tbody td {
    border-top: 1px solid /*#ufc2*/#ededed;
    color: /*#ufc1*/#2c3130;
    line-height: 1.4em;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tbody tr:first-child th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tbody tr:first-child td {
    border-top: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tfoot th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tfoot td {
    border-top: 1px solid /*#ufc2*/#ededed;
    color: /*#ufc1*/#2c3130;
    line-height: 1.4em;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tfoot tr:first-child th, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table tfoot tr:first-child td {
    border-top-color: /*#ufc1*/#2c3130;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td a:not(.remove):not(.button) {
    color: /*#ufc1*/#2c3130;
    text-decoration: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td a:not(.remove):not(.button):hover {
    color: /*#ufc0*/#f9d632;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl dt {
    font-size: 15px;
    line-height: 30px;
    margin: 0 5px 0 0;
    padding: 0;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl dd {
    margin: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl dd, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl dd p {
    font-size: 15px;
    line-height: 30px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table dl dd p {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td p {
    margin: 0 0 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td p:last-of-type:last-child {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form .form-row {
    margin: 0 0 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-error > li {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .customer_details + header.title > h3, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .addresses h3 {
    font-weight: 700;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .customer_details + header.title + address, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .addresses address {
    font: 400 18px/1.667em "Special Elite", Arial, sans-serif;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .addresses .title .edit, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.digital-downloads li .count {
    color: /*#ufc7*/#ef4836;
    font: 400 15px/20px "Special Elite", Arial, sans-serif;
}
#page .default.upost-data-object-post_data /* WooCommerce: Products */
.upfront-post-data-part.part-content .woocommerce ul.products li.product {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data /* WooCommerce: Cart Page */
.upfront-post-data-part.part-content .woocommerce table.cart td.actions {
    border-top-color: /*#ufc4*/#474e4d;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.cart td.actions .coupon .input-text {
    border-color: /*#ufc2*/#ededed;
    float: left;
    margin: 0 10px 0 0;
    padding: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.cart td.actions .coupon .button {
    background: /*#ufc3*/#7e8c89;
    color: /*#ufc5*/#ffffff;
    float: left;
    line-height: 30px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.cart td.actions .coupon .button:hover {
    background: /*#ufc4*/#474e4d;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.cart td.actions > input[type="submit"].button {
    float: right;
    line-height: 30px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart-collaterals {
    border-top: 1px solid /*#ufc2*/#ededed;
    margin-top: 45px;
    padding-top: 45px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cross-sells h2, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart_totals h2 {
    margin: 0 0 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td .woocommerce-shipping-calculator > p {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td .woocommerce-shipping-calculator a.shipping-calculator-button {
    color: /*#ufc7*/#ef4836;
    font-size: 16px;
    text-decoration: underline;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td .woocommerce-shipping-calculator .shipping-calculator-form {
    margin-top: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-shipping-calculator select {
    background: /*#ufc5*/#ffffff;
    border: 1px solid /*#ufc2*/#ededed;
    color: /*#ufc1*/#2c3130;
    font: 400 18px/2.23em "Lato", Arial, sans-serif;
    height: 40px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td .woocommerce-shipping-calculator .button {
    background: /*#ufc4*/#474e4d;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table td .woocommerce-shipping-calculator .button:hover {
    background: /*#ufc1*/#2c3130;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-proceed-to-checkout a.checkout-button {
    font-size: 18px;
    margin: 0;
    padding: 17px 20px 13px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart-empty, #page .default.upost-data-object-post_data  .woocommerce .return-to-shop {
    margin: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .return-to-shop {
    margin-top: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .return-to-shop .button {
    font: 400 18px/30px "Special Elite", Arial, sans-serif;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart-collaterals .cross-sells ul.products {
    margin: 30px 0 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart-collaterals .cross-sells ul.products li.product {
    width: 47.5%;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .cart-collaterals .cross-sells ul.products li.product:nth-child(2n) {
    margin-right: 0;
}
#page .default.upost-data-object-post_data /* WooCommerce: Checkout */
.upfront-post-data-part.part-content .woocommerce form.woocommerce-checkout .woocommerce-info, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form.woocommerce-checkout .woocommerce-error, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form.woocommerce-checkout .woocommerce-message {
    margin-bottom: 45px !important;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-billing-fields > h3, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-shipping-fields > h3, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content #order_review_heading {
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form.checkout_coupon {
    background: /*#ufc2*/#ededed;
    border: none;
    border-radius: 0;
    margin: 0;
    padding: 10px 15px 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .checkout_coupon p {
    margin: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .checkout_coupon .input-text, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .checkout_coupon .button {
    float: left;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .checkout_coupon .button {
    line-height: 30px;
    margin-left: 5px;
    padding: 5px 20px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-info + form.login {
    border: none;
    padding: 10px 15px 15px;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-info + form.login > p:not(.form-row), #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .create-account > p:not(.form-row) {
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_details {
    border-bottom: 1px solid /*#ufc2*/#ededed;
    margin-bottom: 45px;
    padding-bottom: 45px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table .cart-discount td, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table .cart-discount td .woocommerce-Price-amount {
    color: /*#ufc8*/#3fc380;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.shop_table .cart-discount td a.woocommerce-remove-coupon {
    color: /*#ufc7*/#ef4836;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment {
    background: transparent;
    border-radius: 0;
    margin: 30px 0 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment ul.payment_methods {
    background: /*#ufc5*/#ffffff;
    border: 1px solid /*#ufc2*/#ededed;
    margin: 0;
    padding: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment ul.payment_methods li {
    color: /*#ufc1*/#2c3130;
    font: 700 18px/1.667em "Special Elite", Arial, sans-serif;
    margin-top: 15px;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment ul.payment_methods li input {
    float: left;
    margin: 5px 15px 0 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment div.payment_box {
    background: /*#ufc2*/#ededed;
    border-radius: 0;
    color: /*#ufc1*/#2c3130;
    font: 400 15px/1.667em "Special Elite", Arial, sans-serif;
    margin: 15px 0 0;
    padding: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment div.payment_box p {
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    line-height: inherit;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment div.payment_box p:last-child {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment div.payment_box:before {
    border-bottom: 15px solid /*#ufc2*/#ededed;
    left: 20px;
    margin: 0;
    top: -30px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment .payment_method_paypal .about_paypal {
    color: /*#ufc1*/#2c3130;
    display: inline-block;
    float: none;
    font: 400 16px/1.667em "Special Elite", Arial, sans-serif;
    margin: 10px 0 0 29px;
    text-decoration: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment ul.payment_methods li img {
    margin: 10px 0 0 29px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #payment div.form-row.place-order {
    margin: 30px 0 0;
    padding: 0;
}
#page .default.upost-data-object-post_data /* WooCommerce: Checkout Complete */
.upfront-post-data-part.part-content .woocommerce .woocommerce-thankyou-order-received {
    background: /*#ufc2*/#ededed;
    border-top: 2px solid /*#ufc8*/#3fc380;
    color: /*#ufc1*/#2c3130;
    margin: 0 0 45px;
    padding: 10px 20px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details-heading, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details + h2, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .order_details + header, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.customer_details + header.title, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.customer_details + .addresses {
    border-top: 1px solid /*#ufc2*/#ededed;
    padding-top: 45px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-thankyou-order-details, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details {
    border: 1px solid /*#ufc3*/#7e8c89;
    color: /*#ufc1*/#2c3130;
    padding: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.woocommerce-thankyou-order-details {
    background: /*#ufc0*/#f9d632;
    border-color: /*#ufc6*/#eabe24;
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.woocommerce-thankyou-order-details + .clear + p {
    margin-bottom: 45px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.order_details, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.customer_details {
    margin: 0 0 45px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.order_details {
    margin: 0 0 20px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.order_details li {
    border-right-color: /*#ufc3*/#7e8c89;
    font: 400 16px/1.667em "Special Elite", Arial, sans-serif;
    margin: 0 10px 0 0;
    padding-right: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.order_details li strong {
    font-size: 18px;
    line-height: 1.667em;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.wc-bacs-bank-details {
    background: /*#ufc5*/#ffffff;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details-heading + h3, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details + h3 {
    font-weight: 700;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details-heading + h3 {
    margin: 0 0 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details + h3 {
    margin: 10px 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul.wc-bacs-bank-details li {
    margin: 0 15px 0 0;
    padding-right: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .wc-bacs-bank-details + h2 {
    margin-top: 45px;
}
#page .default.upost-data-object-post_data /* WooCommerce: My Account Page */
.upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > p {
    color: /*#ufc1*/#2c3130;
    margin-bottom: 15px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > p > a {
    color: /*#ufc1*/#2c3130;
    text-decoration: underline;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > p > a:hover {
    color: /*#ufc0*/#f9d632;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-navigation {
    background: /*#ufc5*/#ffffff;
    border: 1px solid /*#ufc2*/#ededed;
    padding: 5px 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-navigation ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link a {
    color: /*#ufc1*/#2c3130;
    font: 400 15px/1.667em "Special Elite", Arial, sans-serif;
    text-decoration: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link {
    margin: 0;
    padding: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active {
    background: /*#ufc0*/#f9d632;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active a {
    color: /*#ufc1*/#2c3130;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.my_account_orders .order-actions .button {
    background: /*#ufc3*/#7e8c89;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.my_account_orders .order-actions .button:hover {
    background: /*#ufc4*/#474e4d;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce table.account-orders-table .woocommerce-Price-amount {
    display: block;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .addresses .woocommerce-Address-title h3 {
    display: block;
    float: none;
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .addresses .edit {
    display: inline-block;
    float: none;
    margin: 0 0 5px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .edit-account fieldset {
    background: /*#ufc5*/#ffffff;
    border: 1px solid /*#ufc2*/#ededed;
    margin: 0;
    padding: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .edit-account fieldset legend {
    color: /*#ufc1*/#2c3130;
    font: 700 18px/1.667em "Special Elite", Arial, sans-serif
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .edit-account input[type="submit"].button {
    float: right;
    margin-top: 20px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content .order_details, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > .order-again {
    margin-bottom: 30px
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > .order-again > a {
    text-decoration: none;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce .woocommerce-MyAccount-content > .order-again ~ header {
    border-top: 1px solid /*#ufc2*/#ededed;
    padding-top: 45px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-downloads td.download-actions:before {
    content: "";
}
#page .default.upost-data-object-post_data /* WooCommerce: Login */
.upfront-post-data-part.part-content .woocommerce form.login, #page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_login form.register {
    background: /*#ufc5*/#ffffff;
    border: 1px solid transparent;
    border-radius: 0;
    margin: 0;
    padding: 10px;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form.login {
    background: /*#ufc2*/#ededed;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form.login > p {
    color: /*#ufc1*/#2c3130;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce form #rememberme {
    display: inline-block;
    vertical-align: middle;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce p.woocommerce-LostPassword {
    margin: 0;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_login form.register {
    background: /*#ufc0*/#f9d632;
    border-color: /*#ufc6*/#eabe24;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_login form.register .button {
    background: /*#ufc4*/#474e4d;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_login form.register .button:hover {
    background: /*#ufc1*/#2c3130;
}
#page .default.upost-data-object-post_data .upfront-post-data-part.part-content .woocommerce #customer_login form.login {
    background: /*#ufc5*/#ffffff;
    border: 1px solid /*#ufc2*/#ededed;
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
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'theme_style' => '',
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
      'columns' => '18',
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
          0 => 'col',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '18',
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
          0 => 'col',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
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
  'class' => 'module-1478776375512-1244 upfront-module-spacer',
  'id' => 'module-1478776375512-1244',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1478776375512-1352',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1478776375512-1530',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
