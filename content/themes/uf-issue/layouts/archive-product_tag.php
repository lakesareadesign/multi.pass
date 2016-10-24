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
  'row' => 7,
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
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '4',
  'top_bg_padding_num' => '4',
  'bottom_bg_padding_slider' => '15',
  'bottom_bg_padding_num' => '15',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc6',
)
			);

$breadcrumbs->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1470607845656-1899 upfront-module-spacer',
  'id' => 'module-1470607845656-1899',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470607845656-1127',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470607845656-1277',
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
  'class' => 'module-1470607801668-1562',
  'id' => 'module-1470607801668-1562',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h6 style="text-align: right;"><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}"></a><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}"></a></span><span class="upfront_theme_color_7"><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1"><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}">Home</a> </span><span class="upfront_theme_color_7" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_7">/</span></span><span class="upfront_theme_color_7" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_7"></span>&nbsp;Shop</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1470607801668-1852',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'default',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 6,
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
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1470607808253-1732',
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
  'class' => 'module-1470607843016-1107 upfront-module-spacer',
  'id' => 'module-1470607843016-1107',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1470607843016-1367',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1470607843015-1713',
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

$block_content = upfront_create_region(
			array (
  'name' => 'block-content',
  'title' => 'Block Content',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'block-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 80,
  'background_type' => 'color',
  'background_color' => '#ufc6',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '30',
       'bottom_bg_padding_num' => '40',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '10',
       'bottom_bg_padding_num' => '40',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '10',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => '45',
  'bottom_bg_padding_num' => '135',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$block_content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1477204841321-1671',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'element_id' => 'spacer-object-1477204841321-1120',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1477204841320-1005',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 0,
  'edited' => true,
  'new_line' => true,
));

$block_content->add_element("PlainTxt", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460688550153-1282',
  'id' => 'module-1460688550153-1282',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2><span class="upfront_theme_bg_color_6" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_bg_color_6"><span class="upfront_theme_color_1" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_1">&nbsp;&nbsp;SHOP &nbsp;</span></span></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1460688550152-1108',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'preset' => 'box-title',
    'padding_slider' => '15',
    'top_padding_num' => '13',
    'bottom_padding_num' => '30',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'box-title',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'box-title',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'box-title',
      )),
    )),
    'row' => 12,
    'top_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '25',
         'bottom_padding_num' => '25',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
         'row' => 5,
      )),
    )),
    'current_preset' => 'box-title',
    'bottom_padding_slider' => '30',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1477204838187-1448',
  'edited' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
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

$block_content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1477204842749-1587',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'element_id' => 'spacer-object-1477204842749-1671',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1477204842749-1862',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 0,
  'edited' => true,
));

$block_content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1477204847522-1225',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'element_id' => 'spacer-object-1477204847522-1545',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1477204847521-1184',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 0,
  'edited' => true,
  'new_line' => true,
));

$block_content->add_element("Posts", array (
  'columns' => '16',
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
    'has_settings' => 1,
    'class' => 'c24 uposts-object',
    'id_slug' => 'posts',
    'display_type' => 'list',
    'list_type' => 'generic',
    'offset' => 1,
    'taxonomy' => '',
    'term' => '',
    'content' => 'excerpt',
    'limit' => '7',
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'thumbnail_size' => 'medium',
    'custom_thumbnail_width' => '180',
    'custom_thumbnail_height' => '180',
    'post_parts' =>
    array (
      0 => 'featured_image',
      1 => 'title',
      2 => 'content',
      3 => 'date_posted',
      4 => 'author',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'featured_image',
      3 => 'title',
      4 => 'content',
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
    'content_length' => '22',
    'resize_featured' => '1',
    'gravatar_size' => 200,
    'preset' => 'default',
    'post-part-date_posted' => '<div class="uposts-part date_posted"><span class="datetime">{{datetime}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">&nbsp;- By <a href="{{url}}">{{name}}</a></div>',
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
    'element_id' => 'module-1442668077434-1795-object',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'padding_slider' => '15',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '5',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_slider' => '0',
    'usingNewAppearance' => true,
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'posts-default-tablet',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'posts-default-mobile',
      )),
    )),
    'row' => 155,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'row' => 143,
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'row' => 459,
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
    )),
    'current_preset' => 'default',
    'left_padding_use' => 'yes',
  ),
  'row' => 155,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1442668095508-1224',
  'edited' => true,
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
      'left' => 0,
      'top' => 0,
      'order' => 0,
      'edited' => true,
      'row' => 143,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'left' => 0,
      'top' => 0,
      'order' => 0,
      'edited' => true,
      'row' => 459,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$block_content->add_element("Uspacer", array (
  'columns' => '1',
  'class' => 'upfront-module-spacer',
  'id' => 'module-1477204845230-1683',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'element_id' => 'spacer-object-1477204845230-1153',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'wrapper_id' => 'wrapper-1477204845229-1808',
  'default_hide' => 1,
  'toggle_hide' => 0,
  'hide' => 0,
  'edited' => true,
));

$regions->add($block_content);

$region_container = 'block-content';
$region_sub = 'right';
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'sidebar-left.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'sidebar-left.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'social-footer.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
