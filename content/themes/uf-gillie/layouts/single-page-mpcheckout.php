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
  'background_color' => '#ufc3',
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
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => '100',
  'bottom_bg_padding_num' => '100',
  'bg_padding_num' => '100',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1478590575863-1460 upfront-module-spacer',
  'id' => 'module-1478590575863-1460',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1478590575862-1530',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1478590575862-1072',
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

$main->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_top' => '0',
  'class' => '',
  'id' => 'module-1479744455766-1649',
  'options' =>
  array (
    'content' => '<h1>Checkout</h1>',
    'type' => 'PlainTxtModel',
    'view_class' => 'PlainTxtView',
    'element_id' => 'text-object-1479744455766-1934',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'id_slug' => 'plain_text',
    'preset' => 'mp-page-title',
    'padding_slider' => 10,
    'top_padding_num' => '0',
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 5,
    'anchor' => '',
    'current_preset' => 'mp-page-title',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'mp-page-title',
      )),
    )),
  ),
  'row' => 5,
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
  'columns' => '16',
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
    'top_padding_num' => 15,
    'bottom_padding_num' => 15,
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
    'static-date_posted-use-typography' => 'yes',
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
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content > *:last-child, #page .default.upost-data-object-post_data .content .upfront-content-marker > *:last-child, #page .default.upost-data-object-post_data .content .upfront-indented_content > *:last-child, #page .default.upost-data-object-post_data .content .upfront-content-marker > p:last-of-type, #page .default.upost-data-object-post_data .content .upfront-indented_content > p:last-of-type {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content img, #page .default.upost-data-object-post_data .content .wp-caption {
    display: block;
    height: auto;
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content .alignleft {
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content .alignnone, #page .default.upost-data-object-post_data .content div.alignnone, #page .default.upost-data-object-post_data .content .aligncenter, #page .default.upost-data-object-post_data .content div.aligncenter, #page .default.upost-data-object-post_data .content img.aligncenter {
    display: block;
    margin: 0 auto 40px auto;
}
#page .default.upost-data-object-post_data .content .alignright, #page .default.upost-data-object-post_data .content img.alignright {
    float: right;
    margin: 0 0 40px 40px;
}
#page .default.upost-data-object-post_data .content .alignleft, #page .default.upost-data-object-post_data .content img.alignleft {
    float: left;
    margin: 0 40px 40px 0;
}
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content h5, #page .default.upost-data-object-post_data .content h6, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed, #page .default.upost-data-object-post_data .content blockquote, #page .default.upost-data-object-post_data .content ol, #page .default.upost-data-object-post_data .content ul, #page .default.upost-data-object-post_data .content dl {
    margin: 0 0 40px;
}
#page .default.upost-data-object-post_data .content ul, #page .default.upost-data-object-post_data .content ol {
    margin-left: 20px;
}
#page .default.upost-data-object-post_data .content ul ul, #page .default.upost-data-object-post_data .content ol ol, #page .default.upost-data-object-post_data .content ul ol, #page .default.upost-data-object-post_data .content ol ul {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content blockquote > p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content p {
    -ms-word-break: break-word;
    word-break: break-word;
}
#page .default.upost-data-object-post_data .content .wp-caption {
    margin-bottom: 40px;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text {
    margin-top: 10px;
    margin-bottom: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data .content .wp-caption-text p, #page .default.upost-data-object-post_data .content p.wp-caption-text, #page .default.upost-data-object-post_data .content .wp-caption-text a {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/2.5em "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data .content .wp-caption-text > * {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin: 0;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert {
    margin: 0 0 40px;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-center, #page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-page-center {
    margin-right: auto;
    margin-left: auto;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-full-width, #page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-page-full-width {
    margin-right: 0;
    margin-left: 0;
    width: 100%;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-right, #page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-page-right {
    margin-bottom: 20px;
    margin-left: 45px;
}
#page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-left, #page .default.upost-data-object-post_data .content .upfront-inserted_image-wrapper.ueditor-insert .ueditor-insert.ueditor-image-style-page-left {
    margin-right: 45px;
    margin-bottom: 20px;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.uinsert-image-wrapper {
    padding: 0 10px;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/2.5em "Lato", Arial, sans-serif;;
    min-height: auto !important;
    margin: 0;
    text-align: center;
    padding: 10px 0 0;
}
#page .default.upost-data-object-post_data .content .upfront-wrapper.wp-caption-text p {
    margin: 0;
}
#page .default.upost-data-object-post_data .content table {
    border-spacing: 0;
    border-collapse: collapse;
    margin-bottom: 30px;
    max-width: 100%;
    width: 100%;
}
#page .default.upost-data-object-post_data .content table > tbody > tr > td, #page .default.upost-data-object-post_data .content table > tbody > tr > th, #page .default.upost-data-object-post_data .content table > tfoot > tr > td, #page .default.upost-data-object-post_data .content table > tfoot > tr > th, #page .default.upost-data-object-post_data .content table > thead > tr > td, #page .default.upost-data-object-post_data .content table > thead > tr > th {
    border-top: 1px solid /*#ufc7*/#e8ded3;
    color: /*#ufc0*/#4f3f2c;
    font: 400 18px/2.222em "Special Elite", Arial, sans-serif;
    padding: 10px;
    text-align: left;
    vertical-align: top;
}
#page .default.upost-data-object-post_data .content table > thead > tr > th {
    border-bottom: 2px solid /*#ufc1*/#a59787;
    font-weight: 700;
    vertical-align: bottom;
}
#page .default.upost-data-object-post_data .content table thead > tr:first-child > td, #page .default.upost-data-object-post_data .content table thead > tr:first-child > th, #page .default.upost-data-object-post_data .content table thead > tr:first-child > td, #page .default.upost-data-object-post_data .content table thead > tr:first-child > th, #page .default.upost-data-object-post_data .content table > thead:first-child > tr:first-child > td, #page .default.upost-data-object-post_data .content table > thead:first-child > tr:first-child > th {
    border-top: 0;
}
#page .default.upost-data-object-post_data .content dl {
    font: 400 18px/2.222em "Special Elite", Arial, sans-serif;
    color: /*#ufc0*/#4f3f2c;
}
#page .default.upost-data-object-post_data .content dt {
    text-decoration: underline;
}
#page .default.upost-data-object-post_data .content dd {
    color: /*#ufc1*/#a59787;
    margin: 0;
    padding: 0 0 0 15px;
}
#page .default.upost-data-object-post_data .content pre {
    background: /*#ufc6*/#faf5f0;
    color: /*#ufc0*/#4f3f2c;
    padding: 15px;
    white-space: pre-wrap;
}
#page .default.upost-data-object-post_data .content address {
    color: /*#ufc0*/#4f3f2c;
    font-family: 400 18px/2.222em "Special Elite", Arial, sans-serif;
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data .content .post-password-form input[type="password"] {
    border: 1px solid /*#ufc7*/#e8ded3;
}
#page .default.upost-data-object-post_data .content .post-password-form input[type="submit"] {
    border-radius: 20px;
    min-width: 115px;
    margin-top: 20px;
}
#page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed {
    display: block;
    max-width: 100%;
}
#page .default.upost-data-object-post_data .content blockquote cite {
    color: /*#ufc0*/#4f3f2c;
    display: block;
    font-size: 14px;
    line-height: 2.5em;
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data .content blockquote cite:before {
    content: "-";
    display: inline-block;
    margin-right: 15px;
}
#page .default.upost-data-object-post_data .content .gallery-icon img {
    width: 100%;
}
#page .default.upost-data-object-post_data .content .gallery-caption {
    padding: 0;
}
#page .default.upost-data-object-post_data .upfront-indented_content > h2:first-child {
    font-size: 35px;
    line-height: 1.429em;
}
#page .default.upost-data-object-post_data .content ul li, #page .default.upost-data-object-post_data .content ol li {
    margin-top: 10px;
}
#page .default.upost-data-object-post_data .content ul > li:first-child, #page .default.upost-data-object-post_data .content ol > li:first-child {
    margin-top: 0;
}
#page .default.upost-data-object-post_data /* WooCommerce Global Styles */
.woocommerce p {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/2.5em "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data  .woocommerce h2 {
    font: 700 25px/1.4em "Lato", Arial, sans-serif;
    margin: 0 0 10px;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table {
    border: none;
    border-collapse: collapse;
    border-radius: 0;
    font: 400 14px/2.5em "Lato", Arial, sans-serif;
    margin: 0;
    max-width: 100%;
    vertical-align: middle;
    width: 100%;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table td, #page .default.upost-data-object-post_data  .woocommerce table.shop_table th {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
    padding: 10px;
    vertical-align: middle;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table thead th {
    border-bottom: 1px solid /*#ufc0*/#4f3f2c;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table th {
    font-weight: 700;
    font-size: 18px;
    line-height: 1.4em;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table tbody td {
    border-top: 1px solid /*#ufc7*/#e8ded3;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table tbody tr:first-child th, #page .default.upost-data-object-post_data  .woocommerce table.shop_table tbody tr:first-child td {
    border-top: none;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table tfoot tr:first-child th, #page .default.upost-data-object-post_data  .woocommerce table.shop_table tfoot tr:first-child td {
    border-top-color: /*#ufc0*/#4f3f2c;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table tbody tr:first-child td {
    border-top: none;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table td a:not(.remove):not(.button) {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table td a:not(.remove):not(.button):hover {
    color: /*#ufc5*/#3b2e1e;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table dl {
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table dl dt {
    margin: 0 5px 0 0;
    padding: 0;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table dl dd {
    margin: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table dl dd, #page .default.upost-data-object-post_data  .woocommerce table.shop_table dl dd p {
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table dl dd p {
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce form .form-row {
    margin: 0 0 15px;
}
#page .default.upost-data-object-post_data  .woocommerce form p:last-of-type {
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-error > li {
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .customer_details + header.title > h3, #page .default.upost-data-object-post_data  .woocommerce .addresses h3 {
    font: 700 25px/1.4em "Lato", Arial, sans-serif;
    margin: 0 0 10px;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data  .woocommerce .customer_details + header.title + address, #page .default.upost-data-object-post_data  .woocommerce .addresses address {
    font: 300 18px/1.4em "Lato", Arial, sans-serif;
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .addresses .title .edit, #page .default.upost-data-object-post_data  .woocommerce ul.digital-downloads li .count {
    color: /*#ufc9*/#ef4836;
    font: 400 14px/20px "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data /* WooCommerce Products */
.woocommerce ul.products {
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce ul.products li.product {
    margin-top: 0;
}
#page .default.upost-data-object-post_data  .woocommerce ul.products li.product h3 {
    margin: 0 0 10px;
}
#page .default.upost-data-object-post_data /* WooCommerce: Cart Page */
.woocommerce table.cart td.actions {
    border-top-color: /*#ufc0*/#4f3f2c;
}
#page .default.upost-data-object-post_data  .woocommerce table.cart td.actions .coupon .input-text {
    background: /*#ufc3*/#ffffff;
    border: 1px solid /*#ufc7*/#e8ded3;
    float: left;
    line-height: 2.5em;
    margin: 0 10px 0 0;
    min-width: 120px;
    padding: 0 10px;
}
#page .default.upost-data-object-post_data  .woocommerce table.cart td.actions .coupon .button {
    background: /*#ufc6*/#faf5f0;
    color: /*#ufc0*/#4f3f2c;
    float: left;
    line-height: 2.5em;
}
#page .default.upost-data-object-post_data  .woocommerce table.cart td.actions .coupon .button:hover {
    background: /*#ufc7*/#e8ded3;
}
#page .default.upost-data-object-post_data  .woocommerce table.cart td.actions > input[type="submit"].button {
    float: right;
    line-height: 2.5em;
}
#page .default.upost-data-object-post_data  .woocommerce .cart-collaterals {
    border-top: 1px solid /*#ufc7*/#e8ded3;
    margin-top: 40px;
    padding-top: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce .cross-sells h2, #page .default.upost-data-object-post_data  .woocommerce .cart_totals h2 {
    margin: 0 0 20px;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table td .woocommerce-shipping-calculator a.shipping-calculator-button {
    color: /*#ufc9*/#ef4836;
    font: 700 14px/1.5em "Lato", Arial, sans-serif;
    text-decoration: underline;
}
#page .default.upost-data-object-post_data  .woocommerce .wc-proceed-to-checkout a.checkout-button {
    font-size: 14px;
    line-height: 2.5em;
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .cart-empty, #page .default.upost-data-object-post_data  .woocommerce .return-to-shop {
    margin: 0;
    text-align: center;
}
#page .default.upost-data-object-post_data  .woocommerce .return-to-shop {
    margin-top: 10px;
}
#page .default.upost-data-object-post_data /* WooCommerce: Checkout Page */
.woocommerce form.checkout_coupon {
    background: /*#ufc6*/#faf5f0;
    border: none;
    border-radius: 0;
    margin: 0;
    padding: 10px 20px 20px;
}
#page .default.upost-data-object-post_data  .woocommerce .checkout_coupon p {
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .checkout_coupon .input-text, #page .default.upost-data-object-post_data  .woocommerce .checkout_coupon .button {
    float: left;
}
#page .default.upost-data-object-post_data  .woocommerce .checkout_coupon .button {
    margin-left: 5px;
}
#page .default.upost-data-object-post_data  .woocommerce form.woocommerce-checkout {
    margin-top: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce form.woocommerce-checkout .woocommerce-info, #page .default.upost-data-object-post_data  .woocommerce form.woocommerce-checkout .woocommerce-error, #page .default.upost-data-object-post_data  .woocommerce form.woocommerce-checkout .woocommerce-message {
    margin-bottom: 40px !important;
}
#page .default.upost-data-object-post_data  .woocommerce #payment {
    background: transparent;
    border-radius: 0;
    margin: 40px 0 0;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce #payment ul.payment_methods {
    background: /*#ufc6*/#faf5f0;
    border: 1px solid /*#ufc7*/#e8ded3;
    margin: 0;
    padding: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce #payment ul.payment_methods li {
    font: 700 18px/1.4em "Lato", Arial, sans-serif;
    margin-top: 20px;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce #payment ul.payment_methods li:first-child {
    margin-top: 0;
}
#page .default.upost-data-object-post_data  .woocommerce #payment ul.payment_methods li input {
    float: left;
    margin: 5px 10px 0 0;
}
#page .default.upost-data-object-post_data  .woocommerce #payment div.payment_box {
    background: /*#ufc7*/#e8ded3;
    border-radius: 0;
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/2.5em "Lato", Arial, sans-serif;
    margin: 20px 0 0;
    padding: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce #payment div.payment_box p {
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    line-height: inherit;
}
#page .default.upost-data-object-post_data  .woocommerce #payment div.payment_box:before {
    border-bottom: 15px solid /*#ufc7*/#e8ded3;
    left: 30px;
    margin: 0;
    top: -29px;
}
#page .default.upost-data-object-post_data  .woocommerce #payment .payment_method_paypal .about_paypal {
    display: inline-block;
    float: none;
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
    margin: 10px 0 0 24px;
}
#page .default.upost-data-object-post_data  .woocommerce #payment ul.payment_methods li img {
    margin: 10px 0 0 24px;
}
#page .default.upost-data-object-post_data  .woocommerce #payment div.form-row.place-order {
    margin: 20px 0 0;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-billing-fields > h3, #page .default.upost-data-object-post_data  .woocommerce .woocommerce-shipping-fields > h3, #page .default.upost-data-object-post_data  #order_review_heading {
    font-size: 25px;
    line-height: 1.4em;
    margin: 0 0 20px;
    text-transform: capitalize;
}
#page .default.upost-data-object-post_data  .woocommerce #customer_details {
    border-bottom: 1px solid /*#ufc7*/#e8ded3;
    margin-bottom: 40px;
    padding-bottom: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-info + form.login {
    border: none;
    padding: 0 20px 20px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-info + form.login > p:not(.form-row), #page .default.upost-data-object-post_data  .woocommerce .create-account > p:not(.form-row) {
    margin-bottom: 10px;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table .cart-discount td, #page .default.upost-data-object-post_data  .woocommerce table.shop_table .cart-discount td .woocommerce-Price-amount {
    color: /*#ufc8*/#3fc380;
}
#page .default.upost-data-object-post_data  .woocommerce table.shop_table .cart-discount td a.woocommerce-remove-coupon {
    color: /*#ufc9*/#ef4836;
}
#page .default.upost-data-object-post_data /* WooCommerce: Order Received Page */
.woocommerce .woocommerce-thankyou-order-received {
    background: /*#ufc6*/#faf5f0;
    border-top: 2px solid /*#ufc8*/#3fc380;
    color: /*#ufc0*/#4f3f2c;
    margin: 0 0 40px;
    padding: 10px 20px;
}
#page .default.upost-data-object-post_data  .woocommerce ul.order_details, #page .default.upost-data-object-post_data  .woocommerce table.order_details, #page .default.upost-data-object-post_data  .woocommerce table.customer_details {
    margin: 0 0 40px;
}
#page .default.upost-data-object-post_data  .woocommerce ul.order_details li {
    border-right-color: /*#ufc0*/#4f3f2c;
    font: 400 14px/1em "Lato", Arial, sans-serif;
    margin: 0 20px 0 0;
    padding-right: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce ul.order_details li strong {
    font-size: 18px;
    line-height: 1.4em;
}
#page .default.upost-data-object-post_data  .woocommerce ul.woocommerce-thankyou-order-details {
    margin-bottom: 10px;
}
#page .default.upost-data-object-post_data  .woocommerce ul.woocommerce-thankyou-order-details + .clear + p {
    margin-bottom: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details-heading, #page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details + h2, #page .default.upost-data-object-post_data  .woocommerce .order_details + header, #page .default.upost-data-object-post_data  .woocommerce table.customer_details + header.title, #page .default.upost-data-object-post_data  .woocommerce table.customer_details + .addresses {
    border-top: 1px solid /*#ufc7*/#e8ded3;
    padding-top: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details-heading + h3 {
    font: 700 18px/1.4em "Lato", Arial, sans-serif;
    margin: 0 0 10px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-thankyou-order-details, #page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details {
    border: 1px solid /*#ufc7*/#e8ded3;
    padding: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce ul.wc-bacs-bank-details {
    background: /*#ufc6*/#faf5f0;
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details + h3 {
    font: 700 18px/1.4em "Lato", Arial, sans-serif;
    margin: 10px 0;
}
#page .default.upost-data-object-post_data  .woocommerce .wc-bacs-bank-details + h2 {
    margin-top: 40px;
}
#page .default.upost-data-object-post_data /* WooCommerce: Login */
.woocommerce form.login, #page .default.upost-data-object-post_data  .woocommerce #customer_login form.register {
    background: /*#ufc6*/#faf5f0;
    border: 1px solid /*#ufc7*/#e8ded3;
    border-radius: 0;
    margin: 0;
    padding: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce form #rememberme {
    display: inline-block;
    vertical-align: middle;
}
#page .default.upost-data-object-post_data /* WooCommerce: My Account Page */
.woocommerce .woocommerce-MyAccount-content > p {
    margin-bottom: 10px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-content > p > a {
    text-decoration: underline;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-content > p > a:hover {
    color: /*#ufc5*/#3b2e1e;
}
#page .default.upost-data-object-post_data  .woocommerce .addresses .woocommerce-Address-title h3 {
    display: block;
    float: none;
    margin: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .addresses .edit {
    display: inline-block;
    float: none;
    margin: 0 0 5px;
}
#page .default.upost-data-object-post_data  .woocommerce .edit-account fieldset {
    background: /*#ufc6*/#faf5f0;
    border: 1px solid /*#ufc7*/#e8ded3;
    margin: 0;
    padding: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce .edit-account fieldset legend {
    color: /*#ufc0*/#4f3f2c;
    font: 700 14px/1.4em "Lato", Arial, sans-serif
}
#page .default.upost-data-object-post_data  .woocommerce .edit-account input[type="submit"].button {
    margin-top: 20px;
}
#page .default.upost-data-object-post_data  .woocommerce table.account-orders-table .woocommerce-Price-amount {
    display: block;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-navigation {
    background: /*#ufc6*/#faf5f0;
    border: 1px solid /*#ufc7*/#e8ded3;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-navigation ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
#page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link, #page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link a {
    color: /*#ufc0*/#4f3f2c;
    font: 400 14px/1.5em "Lato", Arial, sans-serif;
}
#page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link {
    margin: 0;
    padding: 10px;
}
#page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active {
    background: /*#ufc0*/#4f3f2c;
}
#page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active, #page .default.upost-data-object-post_data  .woocommerce ul .woocommerce-MyAccount-navigation-link.is-active a {
    color: /*#ufc3*/#ffffff;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-downloads td.download-actions:before {
    content: "";
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-content p.order-again {
    margin-bottom: 40px;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-content p.order-again a {
    text-decoration: none;
}
#page .default.upost-data-object-post_data  .woocommerce .woocommerce-MyAccount-content p.order-again a:hover {
    color: /*#ufc3*/#ffffff;
}
',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'theme_style' => '',
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
      'columns' => '16',
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
      'row' => 10,
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
      'columns' => '16',
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
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1478590579256-1685 upfront-module-spacer',
  'id' => 'module-1478590579256-1685',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1478590579256-1590',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1478590579256-1011',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
