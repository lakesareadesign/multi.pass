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
       'hide' => 0,
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
  'background_color' => '#ffffff',
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
  'background_image' => '{{upfront:style_url}}/images/single-post/slider-img-1.jpg',
  'background_image_ratio' => 0.5500000000000000444089209850062616169452667236328125,
)
			);

$page_header->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1446776418823-1997',
  'id' => 'module-1446776418823-1997',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p>My awesome stub content goes here</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1446776418823-1122',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => 'anchorTop',
    'theme_style' => 'u-anchor-top',
    'row' => 9,
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1446776621414-1520',
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
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

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
  'row' => 188,
  'background_type' => 'image',
  'background_color' => '#c5d0db',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
       'row' => 54,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 54,
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
  'background_image' => '{{upfront:style_url}}/images/single-post/orig_gray-pattern-bg.jpg',
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
  'class' => 'module-1457092674764-1673 upfront-module-spacer',
  'id' => 'module-1457092674764-1673',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457092674764-1763',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457092674763-1331',
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
  'class' => 'module-1457092082441-1928',
  'id' => 'module-1457092082441-1928',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'default',
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
    'preset_style' => '#page .default .upfront-post-data-part.part-title, #page .default .upfront-post-data-part.part-content {
    padding-top: 0;
    padding-bottom: 0;
}
#page .default .date_posted {
    background-color: /*#ufc0*/#f9d632;
    border-radius: 50%;
    display: block;
    height: 88px;
    text-align: center;
    width: 88px;
}
#page .default .title h1 {
    margin: 0;
    padding: 0;
    text-transform: uppercase;
}
#page .default .upfront-post-data-part.part-content {
    margin-top: 10px;
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
    'static-date_posted-font-size' => '',
    'static-date_posted-line-height' => '',
    'static-date_posted-font-color' => '#ufc5',
    'element_id' => 'post-data-object-1457092082438-1406',
    'top_padding_num' => '135',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '135',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'top_padding_num',
    )),
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'mobile',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'mobile',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457092649967-1261',
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
      'columns' => '3',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1457092082433-1577',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457092082435-1726',
      'padding_slider' => '15',
      'edited' => true,
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
      'use_padding' => 'yes',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
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
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '1',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-object-spacer',
      'wrapper_id' => 'wrapper-1457092665254-1770',
      'default_hide' => 1,
      'toggle_hide' => 0,
      'hide' => 0,
      'type' => 'UspacerModel',
      'view_class' => 'UspacerView',
      'element_id' => 'spacer-object-1457092665254-1471',
      'id_slug' => 'uspacer',
      'edited' => true,
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
      'preset' => 'default',
    ),
    2 =>
    array (
      'columns' => '12',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1457092660360-1027',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457092082436-1878',
      'padding_slider' => '15',
      'edited' => true,
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
      'use_padding' => 'yes',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
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
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
      ),
    ),
    3 =>
    array (
      'columns' => '4',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-object-spacer',
      'wrapper_id' => 'wrapper-1457092733164-1167',
      'default_hide' => 1,
      'toggle_hide' => 0,
      'hide' => 0,
      'type' => 'UspacerModel',
      'view_class' => 'UspacerView',
      'element_id' => 'spacer-object-1457092733166-1271',
      'id_slug' => 'uspacer',
      'edited' => true,
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
      'preset' => 'default',
      'new_line' => true,
    ),
    4 =>
    array (
      'columns' => '12',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1457092082436-1163',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457092082437-1752',
      'padding_slider' => '15',
      'edited' => true,
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
      'use_padding' => 'yes',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
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
        ),
        'current_property' =>
        array (
          0 => 'hide',
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
  'class' => 'module-1457092677757-1461 upfront-module-spacer',
  'id' => 'module-1457092677757-1461',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457092677756-1343',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457092677756-1647',
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

$main->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457094761283-1875 upfront-module-spacer',
  'id' => 'module-1457094761283-1875',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457094761283-1368',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457094761282-1882',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 8,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$main->add_element("PostData", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457094755222-1371',
  'id' => 'module-1457094755222-1371',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'no-count-and-no-pagination',
    'row' => 25,
    'type_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments',
      2 => 'comments_pagination',
      3 => 'comment_form',
    ),
    'comment_count_hide' => '0',
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
    'limit' => '50',
    'paginated' => '0',
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
    'static-comments-use-typography' => 'yes',
    'static-comments-font-family' => 'Special Elite',
    'static-comments-fontstyle' => 'regular',
    'static-comments-weight' => '400',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '16',
    'static-comments-line-height' => '1.875',
    'static-comments-font-color' => '#ufc3',
    'preset_style' => '#page .default  .upfront-comments {
    list-style: none;
}
',
    'hidden_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments_pagination',
    ),
    'element_id' => 'post-data-object-1457094755217-1928',
    'top_padding_num' => '60',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '60',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'anchor' => '',
    'theme_preset' => 'true',
    'static-comment_form-font-family' => '',
    'static-comment_form-fontstyle' => '',
    'static-comment_form-weight' => '400',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '',
    'static-comment_form-line-height' => '',
    'static-comment_form-font-color' => 'rgba(0, 0, 0, 0)',
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
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'no-count-and-no-pagination-mobile',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'no-count-and-no-pagination-mobile',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'no-count-and-no-pagination',
      )),
    )),
    'right_padding_use' => 'yes',
    'left_padding_use' => 'yes',
    'static-comment_count-use-typography' => 'yes',
    'static-comment_count-font-family' => 'Special Elite',
    'static-comment_count-fontstyle' => '',
    'static-comment_count-weight' => '400',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '18',
    'static-comment_count-line-height' => '1.4',
    'static-comment_count-font-color' => '#ufc1',
    'static-comments_pagination-use-typography' => 'yes',
    'static-comments_pagination-font-family' => 'Lato',
    'static-comments_pagination-fontstyle' => 'regular',
    'static-comments_pagination-weight' => '400',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '16',
    'static-comments_pagination-line-height' => '1',
    'static-comments_pagination-font-color' => '#ufc3',
    'static-comment_form-use-typography' => 'yes',
    'current_preset' => 'no-count-and-no-pagination',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457094758294-1920',
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
      'columns' => '12',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-comments',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1457094755215-1567',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457094755215-1465',
      'padding_slider' => '15',
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
      'use_padding' => 'yes',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
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
        ),
        'current_property' =>
        array (
          0 => 'hide',
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
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1457095622107-1096',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457095622108-1898',
      'padding_slider' => '15',
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
      'use_padding' => 'yes',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
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
        ),
        'current_property' =>
        array (
          0 => 'hide',
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
  'class' => 'module-1457094764174-1148 upfront-module-spacer',
  'id' => 'module-1457094764174-1148',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457094764174-1964',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457094764174-1408',
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
