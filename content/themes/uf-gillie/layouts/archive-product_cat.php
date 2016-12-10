<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$cover_archive = upfront_create_region(
			array (
  'name' => 'cover-archive',
  'title' => 'cover archive',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'cover-archive',
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
  'background_type' => 'image',
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
  'background_color' => '#ffffff',
  'background_style' => 'fixed',
  'background_default' => 'hide',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/archive-product_cat/404.jpg',
  'background_image_ratio' => 0.36999999999999999555910790149937383830547332763671875,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
)
			);

$cover_archive->add_element("Uspacer", array (
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

$cover_archive->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459864358879-1591',
  'id' => 'module-1459864358879-1591',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h1><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3">Gillie Brown<br>Products</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1459864358878-1017',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'cover-message',
    'padding_slider' => '10',
    'top_padding_num' => '325',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 5,
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'cover-message',
      )),
    )),
    'top_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '140',
         'top_padding_num' => '140',
      )),
       'current_property' => 'top_padding_num',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 24,
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '160',
         'top_padding_num' => '160',
      )),
    )),
    'current_preset' => 'cover-message',
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
      'edited' => false,
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
      'row' => 24,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$cover_archive->add_element("Uspacer", array (
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

$regions->add($cover_archive);

$widgets = upfront_create_region(
			array (
  'name' => 'widgets',
  'title' => 'widgets',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'widgets',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 8,
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
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'equal',
  'top_bg_padding_slider' => '10',
  'top_bg_padding_num' => '10',
  'bottom_bg_padding_slider' => '10',
  'bottom_bg_padding_num' => '10',
  'bg_padding_slider' => '10',
  'bg_padding_num' => '10',
  'background_color' => '#ffffff',
)
			);

$widgets->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460027712590-1513 upfront-module-spacer',
  'id' => 'module-1460027712590-1513',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460027712590-1413',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460027712588-1543',
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

$widgets->add_element("Uwidget", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460027328780-1262',
  'id' => 'module-1460027328780-1262',
  'options' =>
  array (
    'id_slug' => 'uwidget',
    'type' => 'UwidgetModel',
    'view_class' => 'UwidgetView',
    'class' => 'c24 upfront-widget',
    'has_settings' => 1,
    'preset' => 'search-only',
    'widget' => 'woocommerce_product_search-1',
    'element_id' => 'uwidget-object-1460027328779-1485',
    'current_widget' => 'woocommerce_product_search-1',
    'current_widget_specific_settings' =>
    (array)(array(
       'widget-search-__i__-title' =>
      (array)(array(
         'label' => 'Title: ',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
    )),
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'current_widget_specific_fields' =>
    (array)(array(
       'widget-woocommerce_product_search-__i__-title' =>
      (array)(array(
         'label' => 'Title',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
    )),
    'title' => 'Search',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'search-only',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'search-only-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'search-only-mobile',
      )),
    )),
    'widget_specific_fields' =>
    (array)(array(
       'widget-woocommerce_product_search-__i__-title' =>
      (array)(array(
         'label' => 'Title',
         'name' => 'title',
         'type' => 'text',
         'value' => '',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'row' => 6,
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
    'current_preset' => 'search-only',
    'theme_style' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460027642380-1877',
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

$widgets->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460027714593-1660 upfront-module-spacer',
  'id' => 'module-1460027714593-1660',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460027714592-1221',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460027714591-1072',
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

$regions->add($widgets);

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
  'row' => 47,
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
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bg_padding_slider' => '60',
       'top_bg_padding_slider' => '60',
       'bottom_bg_padding_slider' => '60',
       'bg_padding_num' => '60',
       'top_bg_padding_num' => '60',
       'bottom_bg_padding_num' => '60',
    )),
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
)
			);

$content->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460023593926-1703 upfront-module-spacer',
  'id' => 'module-1460023593926-1703',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460023593925-1425',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460023593924-1584',
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

$content->add_element("Posts", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460023298816-1918',
  'id' => 'module-1460023298816-1918',
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
    'limit' => '5',
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'thumbnail_size' => 'thumbnail',
    'custom_thumbnail_width' => 200,
    'custom_thumbnail_height' => 200,
    'post_parts' =>
    array (
      0 => 'title',
      1 => 'content',
      2 => 'date_posted',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
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
    'content_length' => '8',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'woocommerce',
    'post-part-date_posted' => '<div class="uposts-part date_posted">
	<span class="datetime">{{datetime}}</span></div>',
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
	<h2><a href="{{permalink}}" title="{{title}}">{{title}}</a></h2>
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
    'element_id' => 'posts-object-1460023298814-1261',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
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
    )),
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
    'current_preset' => 'woocommerce',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1460023546625-1653',
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
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460023596342-1726 upfront-module-spacer',
  'id' => 'module-1460023596342-1726',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460023596342-1611',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460023596342-1388',
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

$regions->add($content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
