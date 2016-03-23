<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$search_header = upfront_create_region(
			array (
  'name' => 'search-header',
  'title' => 'Search Header',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'search-header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,0.75)',
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
  'nav_region' => '',
  'version' => '1.0.0',
)
			);

$search_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-72706 upfront-module-spacer',
  'id' => 'module-1449775955-72706',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-42560',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-76492',
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

$search_header->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'default-nav-text-module',
  'id' => 'default-nav-text-module',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plaintxt',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_0" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_0">Search Scribe</span></h1>',
    'element_id' => 'default-nav-text-object',
    'class' => 'c24',
    'type' => 'PlainTxtModel',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 34,
    'top_padding_use' => true,
    'top_padding_num' => 115,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 60,
      )),
    )),
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'default-nav-text-module-wrapper',
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
      'order' => 0,
      'clear' => true,
      'edited' => true,
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
    ),
  ),
));

$search_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-94352 upfront-module-spacer',
  'id' => 'module-1449775955-94352',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-91334',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-14852',
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

$search_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-33711 upfront-module-spacer',
  'id' => 'module-1449775955-33711',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-90655',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-35501',
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

$search_header->add_element("Uwidget", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1419826329276-1373',
  'id' => 'module-1419826329276-1373',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'widget' => 'search-2',
    'usingNewAppearance' => true,
    'element_id' => 'uwidget-object-1419826329275-1077',
    'selected_widget' => 'search-2',
    'anchor' => '',
    'widget_specific_fields' =>
    (array)(array(
       'widget-search--title' =>
      (array)(array(
         'label' => 'Title: ',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
    )),
    'title' => '',
    'theme_style' => 'search-widget-archive',
    'row' => 13,
    'current_widget' => 'search-2',
    'current_widget_specific_settings' =>
    (array)(array(
       'widget-search--title' =>
      (array)(array(
         'label' => 'Title: ',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1419826502876-1452',
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
      'edited' => true,
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
  ),
));

$search_header->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-12390 upfront-module-spacer',
  'id' => 'module-1449775955-12390',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-71529',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-15999',
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

$regions->add($search_header);

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
  'row' => 80,
  'background_type' => 'color',
  'background_color' => 'rgba(255,255,255,0.75)',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
    )),
     'current_property' => 'background_type',
  )),
  'nav_region' => '',
  'version' => '1.0.0',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '70',
  'bottom_bg_padding_num' => '70',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-75386 upfront-module-spacer',
  'id' => 'module-1449775955-75386',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-37812',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-2233',
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

$content->add_element("Posts", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1419826329327-1760',
  'id' => 'module-1419826329327-1760',
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
    'post_parts' =>
    array (
      0 => 'title',
      1 => 'date_posted',
      2 => 'content',
      3 => 'read_more',
      4 => 'categories',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
      3 => 'read_more',
      4 => 'categories',
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
    ),
    'date_posted_format' => 'F j, Y',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => '18',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'post-part-date_posted' => '<div class="uposts-part date_posted"><span class="date">{{date_1}} {{date_2}} {{date_3}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">
	By <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'post-part-title' => '<div class="uposts-part title">
	<h3><a href="{{permalink}}" title="{{title}}">{{title}}</a></h3>
</div>',
    'post-part-content' => '<div class="uposts-part content">
	{{content}}
</div>',
    'post-part-read_more' => '<div class="uposts-part read_more">
	<a href="{{permalink}}">Read more</a></div>',
    'post-part-tags' => '<div class="uposts-part post_tags">
	{{tags}}
</div>',
    'post-part-categories' => '<div class="uposts-part post_categories">
	<span class="category-label">Category:</span> {{categories}}
</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'usingNewAppearance' => true,
    'element_id' => 'posts-object-1419826329323-1532',
    'row' => 57,
    'anchor' => '',
    'theme_style' => 'archive-search',
    'top_padding_use' => true,
    'top_padding_num' => 55,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'use_padding' => '',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'search-posts',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'search-posts',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'search-posts',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 27,
      )),
       'current_property' => 'use_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1419826596650-1041',
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
      'order' => 1,
      'clear' => true,
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
      'row' => 27,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449775955-17350 upfront-module-spacer',
  'id' => 'module-1449775955-17350',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449775955-7474',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449775955-16534',
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

$regions->add($content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
