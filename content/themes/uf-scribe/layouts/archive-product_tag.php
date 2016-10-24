<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$content = upfront_create_region(
			array (
  'name' => 'content',
  'title' => 'Content Area',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 286,
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,0.75)',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_num' => '140',
       'top_bg_padding_slider' => '140',
       'bottom_bg_padding_num' => '0',
       'bottom_bg_padding_slider' => '0',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_num' => '0',
       'bottom_bg_padding_slider' => '0',
    )),
     'current_property' => 'bottom_bg_padding_slider',
  )),
  'nav_region' => '',
  'version' => '1.0.0',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '140',
  'top_bg_padding_num' => '140',
  'bottom_bg_padding_slider' => '70',
  'bottom_bg_padding_num' => '70',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453872698266-1344 upfront-module-spacer',
  'id' => 'module-1453872698266-1344',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453872698265-1179',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453872698266-1955',
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
  'class' => 'module-1453872353964-1902',
  'id' => 'module-1453872353964-1902',
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
    'thumbnail_size' => 'medium',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'featured_image',
      2 => 'title',
      3 => 'content',
      4 => 'read_more',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'featured_image',
      2 => 'title',
      3 => 'content',
      4 => 'read_more',
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
    'date_posted_format' => 'F j, Y',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => '16',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'archive-posts',
    'post-part-date_posted' => '<div class="uposts-part date_posted"><span class="datetime">{{datetime}}</span></div>',
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
    'post-part-categories' => '<div class="uposts-part post_categories">
	{{categories}}
</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'element_id' => 'posts-object-1453872353958-1733',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
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
         'preset' => 'archive-posts',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'archive-posts-responsive',
      )),
    )),
    'row' => 221,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      array (
      ),
       'current_property' => 'lock_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453872686112-1301',
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

$content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453872702505-1080 upfront-module-spacer',
  'id' => 'module-1453872702505-1080',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453872702502-1228',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453872702504-1567',
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

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
