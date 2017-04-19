<?php
/* START_REGION_OUTPUT */
$newsletter = upfront_create_region(
			array (
  'name' => 'newsletter',
  'title' => 'Newsletter',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'newsletter',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 105,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 69,
       'background_position_y' => '50',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '30',
       'top_bg_padding_slider' => '30',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '25',
       'top_bg_padding_slider' => '25',
       'row' => 76,
    )),
     'current_property' => 'background_type',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '70',
  'top_bg_padding_num' => '70',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/global-regions/newsletter/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'expand_lock' => false,
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'background_default' => 'hide',
  'featured_fallback_background_color' => '#ffffff',
  'region_role' => 'complementary',
)
			);

$newsletter->add_element("Code", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451390954826-1485',
  'id' => 'module-1451390954826-1485',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'object-1451390954826-1616',
    'top_padding_num' => '10',
    'bottom_padding_num' => '80',
    'code_selection_type' => 'Create',
    'markup' => '<div class="bullets"></div>',
    'style' => '/* Your styles here */
.bullets {
    width: 52px;
    height: 32px;
    display: block;
    margin: 0 auto;
    background: url("{{upfront:style_url}}/ui/sprites-v2.png");
    background-image: url("{{upfront:style_url}}/ui/sprites-v2.svg"), none;
    background-position: -374px -64px;
}',
    'script' => '/* Your code here */',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '80',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '30',
         'bottom_padding_slider' => '30',
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '10',
         'bottom_padding_slider' => '10',
         'row' => 16,
      )),
       'current_property' => 'use_padding',
    )),
    'preset' => 'default',
    'padding_slider' => '10',
    'row' => 7,
    'use_padding' => 'yes',
    'current_preset' => 'default',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451390958229-1627',
  'new_line' => true,
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
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$newsletter->add_group(array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451186748784-1281',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1451186734022-1447',
  'original_col' => 24,
  'top_padding_num' => '0',
  'bottom_padding_num' => '0',
  'background_color' => 'rgba(241,241,241,1)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 0,
  'top_padding_slider' => '0',
  'bottom_padding_use' => 0,
  'bottom_padding_slider' => '0',
  'lock_padding' => '',
  'version' => '1.0.0',
  'background_default' => 'color',
  'left_padding_num' => '10',
  'right_padding_num' => '10',
  'origin_position_y' => 50,
  'origin_position_x' => 50,
  'background_size_percent' => 100,
  'href' => '',
  'linkTarget' => false,
  'use_background_size_percent' => '',
  'featured_fallback_background_color' => '#ffffff',
  'new_line' => true,
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
    'current_property' =>
    array (
      0 => 'order',
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
      'row' => 20,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 30,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$newsletter->add_element("Uimage", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451184993078-1564',
  'id' => 'module-1451184993078-1564',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/newsletter/optin-495x195-1513.jpg',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/newsletter/optin.jpg',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/newsletter/optin.jpg',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 495,
       'height' => 195,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 495,
       'height' => 195,
       'top' => 2305,
       'left' => 440,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 495,
       'height' => 195,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '1926',
    'align' => 'left',
    'stretch' => true,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => 'external',
       'url' => '',
       'target' => false,
       'display_url' => '',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1451184993073-1294',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'row' => 39,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 35,
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'row' => 25,
      )),
       'current_property' => 'use_padding',
    )),
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451186748787-1520',
  'new_line' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 35,
      'hide' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 25,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451186748784-1281',
));

$newsletter->add_element("Code", array (
  'columns' => '13',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451185471848-1921',
  'id' => 'module-1451185471848-1921',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'upfront-code_element-object-1451185471847-1544',
    'top_padding_num' => '30',
    'bottom_padding_num' => '30',
    'code_selection_type' => 'Create',
    'markup' => '<div id="news-optin">
    <h4>Join the daily mail</h4>
    <p>Sign up with your email to get updates about special offers</p>
    <form class="news-input cf">
        <input type="email" placeholder="Your email address">
        <input type="submit" value="Sign Up">
    </form>
</div>',
    'style' => '/* Your styles here */
#news-optin {
    display: block;
    padding: 0 20px;
}
#news-optin h4 {
    color: #ufc1;
    margin: 0 0 5px;
    padding: 0;
    letter-spacing: -1px;
    text-align: center;
}
#news-optin p {
    margin-top: 0;
    margin-bottom: 0;
    padding-bottom: 15px;
    letter-spacing: 0;
    text-align: center;
}
#news-optin .news-input {
    width: 100%;
    display: block;
    position: relative;
}
#news-optin form input {
    border-radius: 2px;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    -webkit-transition: all 0.2s ease-in;
    color: #333333;
}
.news-input input[type="email"] {
    width: 100%;
    height: 45px;
    display: block;
    padding: 0 15px;
    border: 2px solid #ufc5;
    background: #ufc5;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    color: #333333;
    font-size: 16px;
    font-family: "Quattrocento Sans";
    line-height: 45px;
}
.news-input input[type="email"]:hover {
    border-color: #ufc2;
}
.news-input input[type="email"]:focus {
    border-color: #ufc2;
    color: #333333;
}
.news-input input[type="submit"] {
    height: 41px;
    position: absolute;
    top: 2px;
    right: 2px;
    padding: 0 20px;
    border: 1px solid transparent;
    border-radius: 0;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    background: #ufc5;
    color: #ufc2 !important;
    font-size: 15px;
    line-height: 41px;
    font-family: "Quattrocento Sans";
    font-weight: 700;
    text-transform: uppercase;
    transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    -webkit-transition: all 0.2s ease-in;
}
.news-input input[type="submit"]:hover {
    background: #ufc2;
    color: #ufc5 !important;
}',
    'script' => '/* Your code here */',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 18,
      )),
       'current_property' => 'use_padding',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'current_preset' => 'default',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451186748789-1034',
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
      'edited' => false,
      'col' => 7,
      'order' => 2,
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
      'row' => 18,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1451186748784-1281',
));

$regions->add($newsletter);

/* END_REGION_OUTPUT */