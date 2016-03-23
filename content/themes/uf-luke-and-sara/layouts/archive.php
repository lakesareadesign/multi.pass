<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$title_area = upfront_create_region(
			array (
  'name' => 'title-area',
  'title' => 'Title Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'title-area',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 40,
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
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '0',
  'bottom_bg_padding_num' => '0',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive/bg-archive.jpg',
  'background_image_ratio' => 0.1499999999999999944488848768742172978818416595458984375,
)
			);

$title_area->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451394993885-1388',
  'id' => 'module-1451394993885-1388',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<h1 style="text-align: center;"><span class="upfront_theme_color_5">ARCHIVE</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451394993884-1990',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '50',
    'bottom_padding_num' => '0',
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 13,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '50',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451395074084-1413',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 0,
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
));

$title_area->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451395074265-1705',
  'id' => 'module-1451395074265-1705',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<p style="text-align: center;"><span class="upfront_theme_color_2">EVENTS • TIPS • PHOTOS</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1451395074264-1416',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'top_padding_num' => '0',
    'bottom_padding_num' => '10',
    'is_edited' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'row' => 4,
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451395569870-1896',
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
));

$regions->add($title_area);

$content = upfront_create_region(
			array (
  'name' => 'content',
  'title' => 'Content Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 80,
  'background_type' => 'image',
  'background_color' => '#ufc5',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 294,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
       'bottom_bg_padding_slider' => '0',
       'bottom_bg_padding_num' => '0',
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
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '20',
  'top_bg_padding_num' => '20',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
)
			);

$content->add_element("Uspacer", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451401162179-1337 upfront-module-spacer',
  'id' => 'module-1451401162179-1337',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451401162177-1673',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451401162179-1351',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 7,
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1452733892515-1846',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452733892514-1489',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1452733892515-1501',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 1,
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => true,
      'order' => 0,
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
));

$content->add_element("Uwidget", array (
  'columns' => '9',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451399126393-1820',
  'id' => 'module-1451399126393-1820',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'widget' => 'search-2',
    'element_id' => 'uwidget-object-1451399126392-1594',
    'current_widget' => 'search-2',
    'current_widget_specific_settings' => false,
    'top_padding_num' => '10',
    'bottom_padding_num' => '40',
    'preset' => 'default',
    'theme_style' => '',
    'use_padding' => '',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'widget_specific_fields' => false,
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '40',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451401132332-1962',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 10,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 0,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 10,
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
));

$content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1452733895293-1923',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1452733895292-1658',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1452733895293-1432',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 1,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'clear' => false,
      'order' => 0,
      'col' => 1,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'hide' => 0,
      'left' => 0,
      'col' => 1,
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451401165603-1288 upfront-module-spacer',
  'id' => 'module-1451401165603-1288',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451401165602-1621',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451401165602-1705',
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

$content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451401029903-1100 upfront-module-spacer',
  'id' => 'module-1451401029903-1100',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451401029901-1139',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451401029903-1629',
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

$content->add_element("Posts", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1442668077434-1795',
  'id' => 'module-1442668077434-1795',
  'options' =>
  array (
    'type' => 'PostsModel',
    'view_class' => 'PostsView',
    'usingNewAppearance' => true,
    'has_settings' => 1,
    'class' => 'c24 uposts-object',
    'id_slug' => 'posts',
    'display_type' => 'list',
    'list_type' => 'generic',
    'offset' => 1,
    'taxonomy' => '',
    'term' => '',
    'content' => 'excerpt',
    'limit' => 5,
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'post_parts' =>
    array (
      0 => 'featured_image',
      1 => 'gravatar',
      2 => 'title',
      3 => 'date_posted',
      4 => 'author',
      5 => 'categories',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'gravatar',
      3 => 'featured_image',
      4 => 'title',
      5 => 'categories',
    ),
    'default_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'gravatar',
      3 => 'comment_count',
      4 => 'featured_image',
      5 => 'title',
      6 => 'content',
      7 => 'read_more',
      8 => 'tags',
      9 => 'categories',
      10 => 'meta',
    ),
    'date_posted_format' => 'j F, Y',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => 120,
    'resize_featured' => '1',
    'gravatar_size' => '68',
    'post-part-date_posted' => '<div class="uposts-part date_posted"><span class="date">{{date_1}}</span> <span class="time">{{date_2}}</span> <span class="time">{{date_3}}</span> &middot;</div>',
    'post-part-author' => '<div class="uposts-part author">
	By <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'post-part-title' => '<div class="uposts-part title">
	<h3><a href="{{permalink}}" title="{{title}}">{{title}}</a></h3>
</div>',
    'post-part-content' => '<div class="uposts-part content {{content_type}}">
	{{content}}
</div>',
    'post-part-read_more' => '<div class="uposts-part read_more">
	<a href="{{permalink}}">Read more</a></div>',
    'post-part-tags' => '<div class="uposts-part post_tags">
	{{tags}}
</div>',
    'post-part-categories' => '<div class="uposts-part post_categories"><span>Category: </span>{{categories}}</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'element_id' => 'module-1442668077434-1795-object',
    'top_padding_use' => true,
    'top_padding_num' => 40,
    'bottom_padding_num' => '60',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '60',
    'preset' => 'archives',
    'theme_style' => '',
    'row' => 302,
    'breakpoint_presets' =>
    (array)(array(
      'mobile' =>
      (array)(array(
         'preset' => 'archives-responsive',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'archives-responsive',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'archives',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 219,
      )),
       'mobile' =>
      (array)(array(
         'row' => 226,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1442668095508-1224',
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
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'left' => 0,
      'top' => 0,
      'order' => 0,
      'edited' => true,
      'row' => 219,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
      'order' => 0,
      'edited' => true,
      'row' => 226,
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451401032778-1903 upfront-module-spacer',
  'id' => 'module-1451401032778-1903',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'usingNewAppearance' => true,
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1451401032778-1603',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451401032778-1685',
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

$regions->add($content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
