<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$cover_page = upfront_create_region(
			array (
  'name' => 'cover-page',
  'title' => 'cover page',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'cover-page',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 102,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 52,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 52,
    )),
  )),
  'background_type' => 'featured',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => '0',
  'bg_padding_num' => '0',
  'background_color' => '#ufc2',
  'background_style' => 'fixed',
  'background_default' => 'color',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-woocheckout/testimonials.jpg',
  'background_image_ratio' => 0.36999999999999999555910790149937383830547332763671875,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'featured_fallback_background_color' => '#ffffff',
  'background_size' => 'auto',
  'region_role' => 'complementary',
)
			);

$cover_page->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460020341180-1540 upfront-module-spacer',
  'id' => 'module-1460020341180-1540',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460020341180-1391',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460020341179-1959',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
    ),
  ),
));

$cover_page->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479814890345-1133',
  'id' => 'module-1479814890345-1133',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1>Checkout</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1479814890345-1902',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => 10,
    'top_padding_num' => '325',
    'left_padding_num' => 10,
    'right_padding_num' => 10,
    'bottom_padding_num' => 10,
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '325',
    'is_edited' => true,
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459864469279-1133',
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

$cover_page->add_element("Uspacer", array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460020351300-1882 upfront-module-spacer',
  'id' => 'module-1460020351300-1882',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460020351299-1936',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460020351299-1033',
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
));

$regions->add($cover_page);

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
  'row' => 60,
  'background_type' => 'color',
  'background_color' => '#ufc3',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
    )),
     'current_property' => 'bottom_bg_padding_slider',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '100',
  'top_bg_padding_num' => '100',
  'bottom_bg_padding_slider' => '100',
  'bottom_bg_padding_num' => '100',
  'bg_padding_slider' => '100',
  'bg_padding_num' => '100',
  'region_role' => 'main',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460106231232-1334 upfront-module-spacer',
  'id' => 'module-1460106231232-1334',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460106231232-1367',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460106231231-1878',
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
  'class' => 'module-1460106181154-1819',
  'id' => 'module-1460106181154-1819',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'woocommerce',
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
    'element_id' => 'post-data-object-1460106181153-1972',
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
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'woocommerce',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'content-only-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'content-only-mobile',
      )),
    )),
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
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'theme_style' => '',
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
#page .default.upost-data-object-post_data .content h1, #page .default.upost-data-object-post_data .content h2, #page .default.upost-data-object-post_data .content h3, #page .default.upost-data-object-post_data .content h4, #page .default.upost-data-object-post_data .content p, #page .default.upost-data-object-post_data .content address, #page .default.upost-data-object-post_data .content table, #page .default.upost-data-object-post_data .content pre, #page .default.upost-data-object-post_data .content cite, #page .default.upost-data-object-post_data .content q, #page .default.upost-data-object-post_data .content iframe, #page .default.upost-data-object-post_data .content embed, #page .default.upost-data-object-post_data .content blockquote {
    margin: 0 0 40px;
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
',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'woocommerce',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460106228025-1263',
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
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1460106181152-1143',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1460106181152-1927',
      'padding_slider' => '10',
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
      'preset' => 'default',
      'row' => 122,
      'current_preset' => 'default',
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
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
          0 => 'col',
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
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1479814840086-1875',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1479814840087-1488',
      'padding_slider' => 10,
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
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
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 1,
        ),
        'current_property' =>
        array (
          0 => 'col',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'hide' => 1,
        ),
      ),
    ),
    2 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1479814842823-1262',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1479814842824-1510',
      'padding_slider' => 10,
      'top_padding_num' => 10,
      'left_padding_num' => 10,
      'right_padding_num' => 10,
      'bottom_padding_num' => 10,
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
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'hide' => 1,
        ),
        'current_property' =>
        array (
          0 => 'col',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'hide' => 1,
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
  'class' => 'module-1460106233115-1907 upfront-module-spacer',
  'id' => 'module-1460106233115-1907',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460106233115-1848',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460106233114-1471',
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
