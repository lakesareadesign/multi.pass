<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$services_title = upfront_create_region(
			array (
  'name' => 'services-title',
  'title' => 'Services Title',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'services-title',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 67,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 38,
       'background_position_y' => '0',
       'background_style' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => '50% 0%',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '45',
       'top_bg_padding_slider' => '45',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 25,
       'background_position_y' => '0',
       'background_style' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => '50% 0%',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '25',
       'top_bg_padding_slider' => '25',
    )),
     'current_property' => 'top_bg_padding_slider',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '80',
  'top_bg_padding_num' => '80',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '',
  'background_style' => 'fixed',
  'background_position_y' => '0',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-blog/bg-archive.jpg',
  'background_image_ratio' => 0.2300000000000000099920072216264088638126850128173828125,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 0%',
  'version' => '1.0.0',
)
			);

$services_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425481042-1625 upfront-module-spacer',
  'id' => 'module-1453425481042-1625',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425481041-1994',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425481042-1634',
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

$services_title->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425360194-1851',
  'id' => 'module-1453425360194-1851',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1 style="text-align: center;">BLOG</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425360193-1754',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '15',
    'row' => 21,
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'row' => 7,
         'lock_padding' => '',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'row' => 10,
      )),
    )),
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453425458522-1811',
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 7,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 10,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$services_title->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425485739-1333 upfront-module-spacer',
  'id' => 'module-1453425485739-1333',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425485738-1139',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425485739-1653',
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

$regions->add($services_title);

$services_content = upfront_create_region(
			array (
  'name' => 'services-content',
  'title' => 'Services Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'services-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 212,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 241,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 360,
    )),
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'version' => '1.0.0',
)
			);

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425778555-1884 upfront-module-spacer',
  'id' => 'module-1453425778555-1884',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425778554-1342',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425778555-1264',
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

$services_content->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425458783-1148',
  'id' => 'module-1453425458783-1148',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}">HOME</a> &nbsp;/ &nbsp;BLOG</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425458783-1679',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '20',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'preset' => 'breadcrumbs',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'breadcrumbs',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '20',
    'row' => 6,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453425594425-1043',
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
));

$services_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425780693-1523 upfront-module-spacer',
  'id' => 'module-1453425780693-1523',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425780692-1973',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425780693-1789',
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

$services_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453447910483-1299 upfront-module-spacer',
  'id' => 'module-1453447910483-1299',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453447910482-1592',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453447910483-1569',
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

$services_content->add_element("Posts", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453447636346-1647',
  'id' => 'module-1453447636346-1647',
  'options' =>
  array (
    'type' => 'PostsModel',
    'view_class' => 'PostsView',
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
    'thumbnail_size' => 'uf_post_featured_image',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'featured_image',
      1 => 'date_posted',
      2 => 'title',
      3 => 'author',
      4 => 'content',
      5 => 'read_more',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'featured_image',
      3 => 'title',
      4 => 'content',
      5 => 'read_more',
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
    'date_posted_format' => 'd M',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => '25',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'default',
    'post-part-date_posted' => '<div class="uposts-part date_posted"><span class="date date-day">{{date_1}}</span><span class="date date-month">{{date_2}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">
	Written By <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}"><a href="{{permalink}}">{{thumbnail}}</a></div>',
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
    'post-part-categories' => '<div class="uposts-part post_categories">
	{{categories}}
</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'element_id' => 'posts-object-1453447636339-1376',
    'padding_slider' => '15',
    'top_padding_num' => '30',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453447719433-1221',
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
));

$services_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453447913348-1377 upfront-module-spacer',
  'id' => 'module-1453447913348-1377',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453447913347-1826',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453447913348-1972',
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

$regions->add($services_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
