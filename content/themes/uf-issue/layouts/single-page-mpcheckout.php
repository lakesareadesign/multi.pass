<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$breadcrumbs = upfront_create_region(
			array (
  'name' => 'breadcrumbs',
  'title' => 'Breadcrumbs',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'breadcrumbs',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 4,
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
  'bg_padding_type' => 'varied',
  'top_bg_padding_num' => '4',
  'bottom_bg_padding_num' => '15',
  'bg_padding_num' => 0,
)
			);

$breadcrumbs->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479451127776-1185 upfront-module-spacer',
  'id' => 'module-1479451127776-1185',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479451127775-1406',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479451127775-1486',
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

$breadcrumbs->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479450959130-1061',
  'id' => 'module-1479450959130-1061',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6 style="text-align: right;"><a href="{{upfront:home_url}}" target="_self" data-upfront-link-type="homepage"><span class="upfront_theme_color_1">Home</span></a> <span class="upfront_theme_color_7">/</span> <a href="{{upfront:home_url}}/store/" target="_self" data-upfront-link-type="entry"><span class="upfront_theme_color_1">Store</span></a> <span class="upfront_theme_color_7">/</span>&nbsp;Checkout</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1479450959130-1305',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'bottom_padding_num' => '15',
    'lock_padding' => '',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
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
  'wrapper_id' => 'wrapper-1479451012739-1292',
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

$breadcrumbs->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479451125464-1587 upfront-module-spacer',
  'id' => 'module-1479451125464-1587',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479451125463-1499',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479451125463-1584',
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

$regions->add($breadcrumbs);

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 140,
  'background_type' => 'color',
  'background_color' => '#ufc6',
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
  'top_bg_padding_num' => '40',
  'bottom_bg_padding_num' => '70',
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1479451121173-1266 upfront-module-spacer',
  'id' => 'module-1479451121173-1266',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479451121172-1020',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479451121172-1400',
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
         'preset' => 'mp-checkout-for-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'mp-checkout-for-mobile',
      )),
    )),
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Lato',
    'static-date_posted-weight' => '300',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '14',
    'static-date_posted-line-height' => '1.45',
    'static-date_posted-font-color' => 'rgb(37, 37, 37)',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Lato',
    'static-title-weight' => '400',
    'static-title-fontstyle' => 'regular',
    'static-title-style' => 'normal',
    'static-title-font-size' => '45',
    'static-title-line-height' => '1.35',
    'static-title-font-color' => 'rgb(45, 45, 45)',
    'preset_style' => '#page .default.upost-data-object-post_data  .title h1 {
    margin-top: 0;
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .content h1, #page .default.upost-data-object-post_data  .content h2, #page .default.upost-data-object-post_data  .content h3, #page .default.upost-data-object-post_data  .content h4, #page .default.upost-data-object-post_data  .content h5, #page .default.upost-data-object-post_data  .content h6, #page .default.upost-data-object-post_data  .content p, #page .default.upost-data-object-post_data  .content ul, #page .default.upost-data-object-post_data  .content ol, #page .default.upost-data-object-post_data  .content blockquote {
    margin-bottom: 30px;
}
#page .default.upost-data-object-post_data  .content a {
    border-bottom: 1px solid /*#ufc7*/#b96446;
    transition: 0.2s ease-in-out;
    -ms-transition: 0.2s ease-in-out;
    -moz-transition: 0.2s ease-in-out;
    -webkit-transition: 0.2s ease-in-out;
}
#page .default.upost-data-object-post_data  .content a:hover, #page .default.upost-data-object-post_data  {
    border-bottom-color: #d43f0a;
}
#page .default.upost-data-object-post_data  .content a:visited {
    color: #993917;
    border-bottom-color: #993917;
}
#page .default.upost-data-object-post_data  .content ol, #page .default.upost-data-object-post_data  .content ul:not(.upfront-field-select-options) {
    list-style: none;
}
#page .default.upost-data-object-post_data  .content ol {
    counter-reset: uf-counter;
}
#page .default.upost-data-object-post_data  .content ol li, #page .default.upost-data-object-post_data  .content ul:not(.upfront-field-select-options) li {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .content ol li:before {
    margin-right: 10px;
    color: #86b7bb;
    content: counter(uf-counter) ".";
    counter-increment: uf-counter;
}
#page .default.upost-data-object-post_data  .content ul:not(.upfront-field-select-options) li:before {
    content: "";
    width: 8px;
    height: 8px;
    display: inline-block;
    margin-top: -4px;
    margin-right: 15px;
    vertical-align: middle;
    background: /*#ufc2*/#5aadaa;
}
#page .default.upost-data-object-post_data  .content p {
    text-align: justify;
}
#page .default.upost-data-object-post_data  .content blockquote {
    position: relative;
    padding-left: 73px;
}
#page .default.upost-data-object-post_data  .content blockquote * {
    margin-bottom: 0;
}
#page .default.upost-data-object-post_data  .content blockquote:before {
    content: "";
    width: 48px;
    height: 48px;
    display: block;
    position: absolute;
    top: 10px;
    left: 0;
    background: url("//issue.upfront.mp/wp-content/themes/uf-issue/ui/sprite.png") no-repeat transparent;
    background-image: url("//issue.upfront.mp/wp-content/themes/uf-issue/ui/sprite.svg"), none;
    background-position: -56px -376px;
}
#page .default.upost-data-object-post_data  .content blockquote:not(.upfront-quote-alternative) {
    min-height: 55px;
}
#page .default.upost-data-object-post_data  .content blockquote.upfront-quote-alternative {
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data  .content blockquote.upfront-quote-alternative {
    padding-left: 0;
}
#page .default.upost-data-object-post_data  .content blockquote.upfront-quote-alternative:before {
    display: none;
}
#page .default.upost-data-object-post_data  .content .ueditor-insert.upfront-inserted_image-wrapper, #page .default.upost-data-object-post_data  .content .ueditor-insert.upfront-inserted_image-wrapper:hover {
    margin-bottom: 30px;
    margin-left: 0 !important;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-image-style-full-width, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-image-style-center {
    max-width: 100%;
    display: block;
    margin-right: auto !important;
    margin-left: auto !important;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right {
    margin-right: 0 !important;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left {
    margin-left: 0 !important;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right .uinsert-image-wrapper, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left .uinsert-image-wrapper {
    min-height: auto !important;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .uinsert-image-wrapper {
    padding: 0;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .uinsert-image-wrapper a {
    display: block;
    position: relative;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .uinsert-image-wrapper a:before {
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;
    opacity: 0;
    background: /*#ufc1*/#de7854;
    transition: 0.2s ease-in;
    -moz-transition: 0.2s ease-in;
    -webkit-transition: 0.2s ease-in;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .uinsert-image-wrapper a:hover:before {
    opacity: 0.7;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .uinsert-image-wrapper img {
    display: block;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .wp-caption-text {
    padding-right: 0;
    padding-bottom: 0;
    padding-left: 0;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .wp-caption-text, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .wp-caption-text p {
    margin-bottom: 0;
    color: #838e8d;
    font-size: 16px;
    line-height: 35px;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right .wp-caption-text, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right .wp-caption-text p, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left .wp-caption-text, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left .wp-caption-text p {
    line-height: 28px;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right {
    width: auto;
    max-width: 500px !important;
    height: auto;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-image-style-center img, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-left img, #page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-insert-variant-group.ueditor-insert-float-right img {
    width: auto;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
}
#page .default.upost-data-object-post_data  .content .upfront-inserted_image-wrapper .ueditor-image-style-center .uinsert-image-wrapper {
    min-height: 1px !important;
}
',
    'predefined_date_format' => 'M d Y',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'theme_preset' => 'true',
    'hidden_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
    ),
    'left_indent' => '0',
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
  'class' => 'module-1479451123459-1483 upfront-module-spacer',
  'id' => 'module-1479451123459-1483',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1479451123459-1778',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1479451123458-1927',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
