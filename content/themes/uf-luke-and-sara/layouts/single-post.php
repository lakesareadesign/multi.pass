<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$feat_image = upfront_create_region(
			array (
  'name' => 'feat-image',
  'title' => 'Feat Image',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'feat-image',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 104,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'top_bg_padding_slider' => '85',
       'top_bg_padding_num' => '85',
       'row' => 55,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'top_bg_padding_slider' => '40',
       'top_bg_padding_num' => '40',
       'row' => 38,
    )),
     'current_property' => 'top_bg_padding_slider',
  )),
  'background_type' => 'featured',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '200',
  'top_bg_padding_num' => '200',
  'bottom_bg_padding_slider' => '20',
  'bottom_bg_padding_num' => '20',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc1',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-post/bg-nophoto.jpg',
  'background_image_ratio' => 0.5300000000000000266453525910037569701671600341796875,
  'background_default' => 'image',
)
			);

$feat_image->add_element("PostData", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457529818552-1477',
  'id' => 'module-1457529818552-1477',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'the-title-white',
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
    'element_id' => 'post-data-object-1457529818548-1696',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
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
         'preset' => 'the-title-white',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'the-title-white-mobile',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'the-title-white-tablet',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 8,
      )),
       'current_property' => 'lock_padding',
       'tablet' =>
      array (
      ),
    )),
    'theme_style' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457530157520-1852',
  'new_line' => true,
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
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
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
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 8,
    ),
    'current_property' =>
    array (
      0 => 'edited',
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
      'wrapper_id' => 'wrapper-1457573407508-1151',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457573407510-1460',
      'padding_slider' => '10',
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
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 6,
      'new_line' => true,
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

$feat_image->add_group(array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1457531192918-1562',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1457531064239-1809',
  'original_col' => 24,
  'top_padding_num' => 0,
  'bottom_padding_num' => 0,
  'edited' => true,
  'use_padding' => 'yes',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
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
      0 => 'edited',
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
      0 => 'edited',
    ),
  ),
));

$feat_image->add_element("PostData", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457530158307-1290',
  'id' => 'module-1457530158307-1290',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'post-date',
    'row' => 4,
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
    'element_id' => 'post-data-object-1457530158302-1438',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
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
         'preset' => 'post-date',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'post-date-center',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'post-date',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'row' => 5,
      )),
       'current_property' => 'lock_padding',
       'tablet' =>
      array (
      ),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457531192922-1312',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 0,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
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
      'row' => 5,
      'hide' => 1,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1457531192918-1562',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '12',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1457531088698-1874',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457531088699-1326',
      'padding_slider' => '10',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 6,
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
      'preset' => 'default',
      'use_padding' => 'yes',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 6,
          'order' => 0,
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'hide' => 0,
          'row' => 8,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
      ),
    ),
  ),
));

$feat_image->add_element("PostData", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457531032498-1198',
  'id' => 'module-1457531032498-1198',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'author-only',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'author',
      1 => 'gravatar',
      2 => 'author_email',
      3 => 'author_url',
      4 => 'author_bio',
    ),
    'gravatar_size' => '200',
    'post-part-author' => '<div class="upostdata-part author"><a href="{{url}}" {{target}}>By {{name}}</a></div>',
    'post-part-gravatar' => '<div class="upostdata-part gravatar">
	{{gravatar}}
</div>',
    'post-part-author_email' => '<div class="upostdata-part author author-email">
	<a href="mailto:{{email}}">{{name}}</a>
</div>',
    'post-part-author_url' => '<div class="upostdata-part author author-url">
	<a href="{{url}}" rel="author external">{{name}}</a>
</div>',
    'post-part-author_bio' => '<div class="upostdata-part author author-bio">
	{{bio}}
</div>',
    'hidden_parts' =>
    array (
      0 => 'author',
      1 => 'author_bio',
      2 => 'author_url',
      3 => 'author_email',
    ),
    'link' => 'author',
    'theme_preset' => 'true',
    'static-author-use-typography' => 'yes',
    'static-author-font-family' => 'Quattrocento Sans',
    'static-author-fontstyle' => '',
    'static-author-weight' => '400',
    'static-author-style' => 'normal',
    'static-author-font-size' => '14',
    'static-author-line-height' => '1.563',
    'static-author-font-color' => '',
    'preset_style' => '#page .default.upost-data-object-author .upostdata-part.author {
    text-transform: uppercase;
    text-align: center;
}
',
    'element_id' => 'post-data-object-1457531032495-1105',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
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
         'preset' => 'author-only',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'author-only-for-mobile',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'author-only',
      )),
    )),
    'static-gravatar-lock' => 'yes',
    'email_link_text' => 'Email',
    'static-author_email-use-typography' => 'yes',
    'static-author_email-font-family' => 'Quattrocento Sans',
    'static-author_email-fontstyle' => '',
    'static-author_email-weight' => '400',
    'static-author_email-style' => 'normal',
    'static-author_email-font-size' => '14',
    'static-author_email-line-height' => '1.563',
    'static-author_email-font-color' => '#ufc2',
    'link_text' => 'Website',
    'target' =>
    array (
      0 => '_blank',
    ),
    'static-author_url-use-typography' => 'yes',
    'static-author_url-font-family' => 'Quattrocento Sans',
    'static-author_url-fontstyle' => '',
    'static-author_url-weight' => '400',
    'static-author_url-style' => 'normal',
    'static-author_url-font-size' => '14',
    'static-author_url-line-height' => '1.563',
    'static-author_url-font-color' => '#ufc2',
    'static-author_bio-use-typography' => 'yes',
    'static-author_bio-font-family' => 'Quattrocento Sans',
    'static-author_bio-fontstyle' => '',
    'static-author_bio-weight' => '400',
    'static-author_bio-style' => 'normal',
    'static-author_bio-font-size' => '14',
    'static-author_bio-line-height' => '1.563',
    'static-author_bio-font-color' => '#ufc1',
    'static-gravatar-use-radius' => 'yes',
    'static-gravatar-radius1' => '150',
    'static-gravatar-radius2' => '150',
    'static-gravatar-radius3' => '150',
    'static-gravatar-radius4' => '150',
    'static-gravatar-radius' => '150',
    'static-gravatar-radius_number' => '150',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'row' => 4,
      )),
       'current_property' => 'lock_padding',
       'tablet' =>
      array (
      ),
    )),
    'static-gravatar-use-border' => 'yes',
    'static-gravatar-border-width' => '1',
    'static-gravatar-border-type' => 'solid',
    'static-gravatar-border-color' => '#ufc2',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457531192924-1745',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 1,
      'clear' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 6,
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
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1457531192918-1562',
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
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1457531180361-1363',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457531180363-1170',
      'padding_slider' => '10',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 6,
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
      'preset' => 'default',
      'use_padding' => 'yes',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 6,
          'order' => 0,
          'hide' => 0,
          'use_padding' => 'yes',
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'hide' => 0,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$regions->add($feat_image);

$post_area = upfront_create_region(
			array (
  'name' => 'post-area',
  'title' => 'Post Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'post-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 64,
  'background_type' => 'image',
  'background_color' => '#ufc5',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 47,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_slider' => '70',
       'top_bg_padding_num' => '70',
       'bottom_bg_padding_slider' => '70',
       'bottom_bg_padding_num' => '70',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '50',
       'top_bg_padding_slider' => '50',
       'bottom_bg_padding_num' => '50',
       'bottom_bg_padding_slider' => '50',
    )),
     'current_property' => 'bottom_bg_padding_slider',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-post/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'expand_lock' => false,
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '55',
  'top_bg_padding_num' => '55',
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_default' => 'color',
)
			);

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457110287857-1199 upfront-module-spacer',
  'id' => 'module-1457110287857-1199',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457110287856-1735',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457110287855-1845',
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

$post_area->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457107697040-1470',
  'id' => 'module-1457107697040-1470',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'content-only',
    'row' => 847,
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
	<h3>{{title}}</h3>
</div>',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'static-date_posted-font-family' => '',
    'static-date_posted-fontstyle' => '',
    'static-date_posted-weight' => '400',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '',
    'static-date_posted-line-height' => '',
    'static-date_posted-font-color' => '',
    'element_id' => 'post-data-object-1457107697036-1893',
    'top_padding_num' => '10',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
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
    'theme_preset' => 'true',
    'static-date_posted-use-typography' => 'yes',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.title {
    text-align: center;
}
#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    text-transform: uppercase;
    text-align: center;
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
    'theme_style' => '',
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
  'wrapper_id' => 'wrapper-1457110199075-1914',
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
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458671256080-1482',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458671256081-1111',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'row' => 847,
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
      'preset' => 'default',
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

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457110292147-1300 upfront-module-spacer',
  'id' => 'module-1457110292147-1300',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457110292147-1814',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457110292146-1978',
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

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458714651374-1253 upfront-module-spacer',
  'id' => 'module-1458714651374-1253',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458714651374-1514',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458714651372-1282',
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

$post_area->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458714339623-1951',
  'id' => 'module-1458714339623-1951',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-taxonomy',
    'id_slug' => 'post-data',
    'data_type' => 'taxonomy',
    'preset' => 'categories-only',
    'row' => 10,
    'type_parts' =>
    array (
      0 => 'tags',
      1 => 'categories',
    ),
    'categories_limit' => '3',
    'tags_limit' => '3',
    'post-part-tags' => '<div class="upostdata-part post_tags">
    <h6>Tags</h6>
	<div class="list_post_tags">{{tags}}</div>
</div>',
    'post-part-categories' => '<div class="upostdata-part post_categories">
    <h6>Category</h6>
    <div class="list_post_categories">{{categories}}</div>
</div>',
    'preset_style' => '#page .default.upost-data-object-taxonomy  {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #d5d5d5;
    border-top-color: rgba(0,0,0,0.2);
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags, #page .default.upost-data-object-taxonomy .upostdata-part.post_categories {
    padding-left: 30px;
    color: /*#ufc1*/#61737b;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags {
    border-left: 4px solid /*#ufc1*/#61737b;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_categories {
    border-left: 4px solid /*#ufc2*/#01bc9d;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags h6, #page .default.upost-data-object-taxonomy .upostdata-part.post_categories h6 {
    margin-bottom: 10px;
    color: /*#ufc1*/#61737b;
    font-size: 18px;
    line-height: 25px;
    font-family: "Quattrocento", serif;
    font-weight: 700;
    font-style: normal;
    text-transform: uppercase;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags a, #page .default.upost-data-object-taxonomy .upostdata-part.post_categories a {
    display: inline-block;
    margin-right: 10px;
    padding: 6px 10px 4px;
    text-transform: uppercase;
    transition: 0.25s ease;
    -ms-transition: 0.25s ease;
    -moz-transition: 0.25s ease;
    -webkit-transition: 0.25s ease;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags a {
    border: 1px solid /*#ufc0*/#333333;
    background: /*#ufc1*/#61737b;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_categories a {
    border: 1px solid /*#ufc4*/#007051;
    background: /*#ufc3*/#00a384;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags a:last-child, #page .default.upost-data-object-taxonomy .upostdata-part.post_categories a:last-child {
    margin-right: 0;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_tags a:hover {
    background: /*#ufc0*/#333333;
}
#page .default.upost-data-object-taxonomy .upostdata-part.post_categories a:hover {
    background: /*#ufc4*/#007051;
}
#page .default.upost-data-object-taxonomy  .upostdata-part.list_post_tags, #page .default.upost-data-object-taxonomy  .upostdata-part.list_post_categories {
    display: block;
}
',
    'categories_separator' => '',
    'static-categories-use-typography' => 'yes',
    'static-categories-font-family' => 'Quattrocento Sans',
    'static-categories-fontstyle' => 'regular',
    'static-categories-weight' => '400',
    'static-categories-style' => 'normal',
    'static-categories-font-size' => '14',
    'static-categories-line-height' => '1.4',
    'static-categories-font-color' => '#ufc5',
    'theme_preset' => 'true',
    'tags_separator' => '',
    'static-tags-use-typography' => 'yes',
    'static-tags-font-family' => 'Quattrocento Sans',
    'static-tags-fontstyle' => '',
    'static-tags-weight' => '400',
    'static-tags-style' => 'normal',
    'static-tags-font-size' => '14',
    'static-tags-line-height' => '1.4',
    'static-tags-font-color' => '#ufc5',
    'element_id' => 'post-data-object-1458714339616-1143',
    'top_padding_num' => '45',
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
         'preset' => 'categories-only',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '45',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458714587895-1007',
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
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'categories',
      'wrapper_id' => 'wrapper-1458715098007-1116',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458715098008-1133',
      'padding_slider' => '10',
      'use_padding' => 'yes',
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
      'new_line' => true,
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

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458714654677-1852 upfront-module-spacer',
  'id' => 'module-1458714654677-1852',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458714654677-1196',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458714654676-1258',
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

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458365136552-1886 upfront-module-spacer',
  'id' => 'module-1458365136552-1886',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458365136551-1182',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458365136549-1315',
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

$post_area->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458364313693-1700',
  'id' => 'module-1458364313693-1700',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'comments-with-form-only',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments',
      2 => 'comments_pagination',
      3 => 'comment_form',
    ),
    'comment_count_hide' => 0,
    'disable_showing' =>
    array (
      0 => 'trackbacks',
    ),
    'disable' =>
    array (
      0 => 'trackbacks',
      1 => 'comments',
    ),
    'order' => 'comment_date_gmt',
    'direction' => 'DESC',
    'limit' => 50,
    'paginated' => 0,
    'post-part-comment_count' => '<div class="upostdata-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-comments' => '<div class="upostdata-part comments">
	{{comments}}
</div>',
    'post-part-comments_pagination' => '<div class="upostdata-part comments comments_pagination">
	{{pagination}}
</div>',
    'post-part-comment_form' => '<div class="upostdata-part comment_form">
	{{comment_form}}
</div>',
    'element_id' => 'post-data-object-1458364313691-1888',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'static-comment_count-use-typography' => '',
    'static-comment_count-font-family' => 'Quattrocento Sans',
    'static-comment_count-weight' => '400',
    'static-comment_count-fontstyle' => '400 normal',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '17',
    'static-comment_count-line-height' => '2',
    'static-comment_count-font-color' => '#ufc0',
    'static-comments-use-typography' => 'yes',
    'static-comments-font-family' => 'Quattrocento Sans',
    'static-comments-weight' => '400',
    'static-comments-fontstyle' => '400 normal',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '17',
    'static-comments-line-height' => '2',
    'static-comments-font-color' => '#ufc0',
    'static-comments_pagination-use-typography' => 'yes',
    'static-comments_pagination-font-family' => 'Quattrocento Sans',
    'static-comments_pagination-weight' => '400',
    'static-comments_pagination-fontstyle' => '400 normal',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '16',
    'static-comments_pagination-line-height' => '1.2',
    'static-comments_pagination-font-color' => '#ufc0',
    'static-comment_form-use-typography' => 'yes',
    'static-comment_form-font-family' => 'Quattrocento Sans',
    'static-comment_form-weight' => '400',
    'static-comment_form-fontstyle' => '400 normal',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '16',
    'static-comment_form-line-height' => '1.2',
    'static-comment_form-font-color' => '#ufc1',
    'preset_style' => '#page .default.upost-data-object-comments .upfront-post-data-part {
    padding-top: 0;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments {
    padding-top: 35px;
    border-top: 1px solid #ededed;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments > li, #page .default.upost-data-object-comments  .upfront-post_data-comments .children > li {
    list-style: none;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .children {
    margin-left: 30px;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments article {
    position: relative;
    margin-bottom: 30px;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .avatar {
    display: none;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .comment-author cite.fn {
    font-size: 20px;
    font-weight: 700;
    font-style: normal;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .comment-author cite.fn a {
    font-size: 20px;
    font-weight: 400;
    font-style: normal;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .comment-content, #page .default.upost-data-object-comments  .upfront-post_data-comments .reply {
    display: block;
    padding: 10px 20px;
    border: 1px solid #ededed;
    background: /*#ufc5*/#ffffff;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .comment-content p:last-child {
    margin-bottom: 0;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .reply {
    height: 35px;
    padding: 0 20px;
    border-top: 0;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments a {
    color: /*#ufc2*/#01bc9d;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments a:hover {
    color: /*#ufc3*/#00a384;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .reply a {
    width: 28px;
    height: 28px;
    display: block;
    position: relative;
    top: 4px;
    margin-right: 0;
    margin-left: auto;
    background: url("//lukesara.upfront.one/wp-content/themes/uf-luke-and-sara/ui/sprites-v2.png") no-repeat;
    background-image: url("//lukesara.upfront.one/wp-content/themes/uf-luke-and-sara/ui/sprites-v2.svg"), none;
    background-position: -386px -707px;
    text-indent: -9999px;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments .reply span {
    display: none;
}
#page .default.upost-data-object-comments  .upfront-post_data-comments a.comment-time {
    position: absolute;
    bottom: 1px;
    left: 20px;
    color: #666666;
    font-size: 15px;
    font-family: "Quattrocento";
    font-weight: 400;
    font-style: normal;
}
#page .default.upost-data-object-comments  .comments_pagination {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #ededed;
}
#page .default.upost-data-object-comments  .comments_pagination .page-numbers {
    margin-right: 12px;
    padding: 0 3px;
    border-bottom: 2px solid transparent;
    transition: all 0.3s;
    -moz-transition: all 0.3s;
    -webkit-transition: all 0.3s;
}
#page .default.upost-data-object-comments  .comments_pagination .page-numbers:last-child {
    margin-right: 0;
}
#page .default.upost-data-object-comments  .comments_pagination .page-numbers.current {
    border-bottom-color: /*#ufc2*/#01bc9d;
    color: /*#ufc2*/#01bc9d;
}
#page .default.upost-data-object-comments  .comments_pagination .prev.page-numbers, #page .default.upost-data-object-comments  .comments_pagination .next.page-numbers {
    position: absolute;
    margin-right: 0;
    padding: 0;
    color: /*#ufc2*/#01bc9d;
}
#page .default.upost-data-object-comments  .comments_pagination .prev.page-numbers {
    left: 0;
}
#page .default.upost-data-object-comments  .comments_pagination .next.page-numbers {
    right: 0;
}
#page .default.upost-data-object-comments  .comments_pagination .prev.page-numbers:before, #page .default.upost-data-object-comments  .comments_pagination .next.page-numbers:after {
    display: block;
    position: absolute;
    top: 0;
    bottom: 2px;
    background: url("//lukesara.upfront.one/wp-content/themes/uf-luke-and-sara/ui/noise.jpg") /*#ufc5*/#ffffff;
}
#page .default.upost-data-object-comments  .comments_pagination .prev.page-numbers:before {
    content: "<";
    left: 0;
}
#page .default.upost-data-object-comments  .comments_pagination .prev.page-numbers:after {
    content: ">";
    right: 0;
}
#page .default.upost-data-object-comments  .comment-respond .comment-reply-title {
    margin: 0;
    padding: 0;
    font-size: 25px;
    line-height: 1.4em;
    font-family: "Quattrocento";
    font-style: normal;
    text-transform: uppercase;
}
#page .default.upost-data-object-comments  .comment-respond .comment-reply-title small a {
    display: block;
    font-size: 13px;
    font-family: "Lato";
}
#page .default.upost-data-object-comments  .comment_form * {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}
#page .default.upost-data-object-comments  .comment_form p {
    width: 100%;
    display: block;
    margin: 0 auto 20px;
    padding: 0;
}
#page .default.upost-data-object-comments  .comment-respond p.logged-in-as {
    margin-bottom: 25px;
    font-size: 15px;
}
#page .default.upost-data-object-comments  .comment-respond p.logged-in-as a {
    color: /*#ufc2*/#01bc9d;
    font-size: 15px;
}
#page .default.upost-data-object-comments  .comment_form label {
    color: /*#ufc1*/#61737b;
    font-family: "Quattrocento", Arial, sans-serif;
    font-weight: 400;
    font-style: normal;
    display: block;
    font-size: 16px;
    line-height: 1.563em;
    margin-bottom: 5px;
}
#page .default.upost-data-object-comments  .comment_form input {
    -webkit-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
}
#page .default.upost-data-object-comments  .comment_form input[type="text"], #page .default.upost-data-object-comments  .comment_form input[type="email"], #page .default.upost-data-object-comments  .comment_form textarea {
    width: 100%;
    border: 2px solid #ededed;
    background: /*#ufc5*/#ffffff;
    color: /*#ufc1*/#61737b;
    display: block;
    font-size: 16px;
    line-height: 1.2em;
    border-radius: 2px;
    -webkit-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
}
#page .default.upost-data-object-comments  .comment-form-comment label {
    display: none;
}
#page .default.upost-data-object-comments  .comment_form input[type="text"] {
    padding: 10px 15px;
}
#page .default.upost-data-object-comments  .comment_form input[type="email"], #page .default.upost-data-object-comments  .comment-form textarea {
    padding: 15px;
}
#page .default.upost-data-object-comments  .comment_form textarea {
    -webkit-transition-property: background, border-color, color;
    transition-property: background, border-color, color;
}
#page .default.upost-data-object-comments  .comment_form input[type="text"]:focus, #page .default.upost-data-object-comments  .comment_form input[type="email"]:focus, #page .default.upost-data-object-comments  .comment_form textarea:focus {
    border-color: /*#ufc2*/#01bc9d;
}
#page .default.upost-data-object-comments  .comment_form p.form-allowed-tags {
    color: #bdbdbd;
    font-size: 14px;
    text-align: justify;
}
#page .default.upost-data-object-comments  .comment_form p.form-allowed-tags code {
    color: #61737b;
}
#page .default.upost-data-object-comments  .comment-respond .form-submit {
    text-align: right;
    margin: 0;
}
#page .default.upost-data-object-comments  .comment-respond .form-submit input {
    margin: 0;
    padding: 10px 22px 8px;
    border: 2px solid /*#ufc2*/#01bc9d;
    background: transparent;
    color: /*#ufc2*/#01bc9d;
    font-weight: bold;
    text-transform: uppercase;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
}
#page .default.upost-data-object-comments  .comment-respond .form-submit input:hover {
    border-color: /*#ufc2*/#01bc9d;
    background: /*#ufc2*/#01bc9d;
    color: /*#ufc5*/#ffffff;
}
#page .default.upost-data-object-comments  .comment-respond .form-submit input:active, #page .default.upost-data-object-comments  .comment-respond .form-submit input:visited {
    border-color: /*#ufc2*/#01bc9d;
    background: /*#ufc2*/#01bc9d;
    color: /*#ufc5*/#ffffff;
}
',
    'hidden_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments_pagination',
    ),
    'theme_preset' => 'true',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'comments-with-form-only',
      )),
    )),
    'theme_style' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458364671545-1892',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 3,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 3,
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
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_count',
      'wrapper_id' => 'wrapper-1458669850979-1540',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458669850981-1759',
      'padding_slider' => '10',
      'use_padding' => 'yes',
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
      'preset' => 'default',
      'new_line' => true,
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
    1 =>
    array (
      'columns' => '18',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1458689376318-1315',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458689376320-1168',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 2,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 2,
          'clear' => true,
        ),
      ),
      'preset' => 'default',
      'new_line' => true,
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
    2 =>
    array (
      'columns' => '18',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1458689392089-1017',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458689392090-1054',
      'padding_slider' => '10',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'order' => 3,
          'clear' => true,
        ),
        'mobile' =>
        array (
          'col' => 7,
          'order' => 3,
          'clear' => true,
        ),
      ),
      'preset' => 'default',
      'new_line' => true,
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

$post_area->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458365141656-1729 upfront-module-spacer',
  'id' => 'module-1458365141656-1729',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458365141656-1857',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458365141655-1369',
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

$regions->add($post_area);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
