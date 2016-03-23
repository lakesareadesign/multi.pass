<?php
if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

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
  'row' => 140,
  'background_type' => 'color',
  'background_color' => '#c5d0db',
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
  'version' => '1.0.0',
)
			);

$main->add_element("ThisPost", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'default-post',
  'id' => 'default-post',
  'options' =>
  array (
    'type' => 'ThisPostModel',
    'view_class' => 'ThisPostView',
    'class' => 'c24 upfront-this_post',
    'has_settings' => 1,
    'id_slug' => 'this_post',
    'row' => 11,
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
    'top_padding_use' => true,
    'top_padding_num' => 20,
    'bottom_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'default-post-wrapper',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
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

$main->add_element("Ucomment", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'default-comment',
  'id' => 'default-comment',
  'options' =>
  array (
    'id_slug' => 'ucomment',
    'type' => 'UcommentModel',
    'view_class' => 'UcommentView',
    'class' => 'c24 upfront-comment',
    'has_settings' => 0,
    'prepend_form' => false,
    'element_id' => 'default-comment-object',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'default-comment-wrapper',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-footer-gap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-footer-gap.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
