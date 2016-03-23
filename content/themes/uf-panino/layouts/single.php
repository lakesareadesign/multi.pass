<?php
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
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
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
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1446776621414-1520',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 0,
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
  'background_image' => '{{upfront:style_url}}/images/single/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
)
			);

$main->add_element("ThisPost", array (
  'columns' => '16',
  'margin_left' => '4',
  'margin_right' => '0',
  'margin_top' => '24',
  'margin_bottom' => '0',
  'class' => 'default-post',
  'id' => 'default-post',
  'options' =>
  array (
    'type' => 'ThisPostModel',
    'view_class' => 'ThisPostView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-this_post',
    'has_settings' => 1,
    'id_slug' => 'this_post',
    'row' => 85,
    'post_data' =>
    array (
      0 => 'date',
    ),
    'disable_resize' => false,
    'disable_drag' => false,
    'layout' =>
    array (
      0 =>
      (array)(array(
         'classes' => 'c24 clr',
         'objects' =>
        array (
          0 =>
          (array)(array(
             'slug' => 'title',
             'classes' => 'post-part c24',
          )),
        ),
      )),
      1 =>
      (array)(array(
         'classes' => 'c24 clr',
         'objects' =>
        array (
          0 =>
          (array)(array(
             'slug' => 'date',
             'classes' => ' post-part c24',
          )),
        ),
      )),
      2 =>
      (array)(array(
         'classes' => 'c24 clr',
         'objects' =>
        array (
          0 =>
          (array)(array(
             'slug' => 'contents',
             'classes' => ' post-part c24',
          )),
        ),
      )),
    ),
    'element_id' => 'default-post-object',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'single-post-mobile',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'single-post-mobile',
      )),
    )),
    'hide_featured_image' => '',
    'full_featured_image' => '',
    'theme_style' => '_default',
  ),
  'row' => 6,
  'sticky' => true,
  'wrapper_id' => 'default-post-wrapper',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => true,
      'edited' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 20,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 17,
    ),
  ),
));

$regions->add($main);

$comments_content = upfront_create_region(
			array (
  'name' => 'comments-content',
  'title' => 'Comments Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'comments-content',
  'position' => 20,
  'allow_sidebar' => true,
),
			array (
  'row' => 60,
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
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
)
			);

$comments_content->add_element("Ucomment", array (
  'columns' => '13',
  'margin_left' => '7',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1446105804983-1545',
  'id' => 'module-1446105804983-1545',
  'options' =>
  array (
    'id_slug' => 'ucomment',
    'type' => 'UcommentModel',
    'view_class' => 'UcommentView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-comment',
    'has_settings' => 1,
    'prepend_form' => false,
    'element_id' => 'ucomment-object-1446105804982-1220',
    'row' => 214,
    'anchor' => '',
    'theme_style' => '_default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 4,
         'theme_style' => 'comment-responsive',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'comment-responsive',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1446105866515-1147',
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
      'row' => 4,
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

$comments_content->add_element("Button", array (
  'columns' => '22',
  'margin_left' => '1',
  'margin_right' => '0',
  'margin_top' => '1',
  'margin_bottom' => '0',
  'class' => 'module-1446776418939-1159',
  'id' => 'module-1446776418939-1159',
  'options' =>
  array (
    'content' => 'Click here',
    'href' => '',
    'linkTarget' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'ubutton',
    'preset' => 'button-anchor',
    'element_id' => 'button-object-1446776418939-1110',
    'link' =>
    (array)(array(
       'type' => 'anchor',
       'url' => '{{upfront:home_url}}/single/#logoAnchor',
       'target' => '_self',
    )),
    'theme_style' => 'u-button-anchor',
    'anchor' => '',
    'row' => 27,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1446776533255-1752',
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

$regions->add($comments_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
