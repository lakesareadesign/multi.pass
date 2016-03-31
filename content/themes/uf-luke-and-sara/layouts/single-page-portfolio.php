<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$slider = upfront_create_region(
			array (
  'name' => 'slider',
  'title' => 'Slider',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'slider',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 104,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 80,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 60,
    )),
  )),
  'background_type' => 'slider',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'hover',
  'background_slider_images' =>
  array (
    0 => 'images/bg-happy.jpg',
    1 => 'images/bg-wedding.jpg',
  ),
)
			);

$regions->add($slider);

$platinum = upfront_create_region(
			array (
  'name' => 'platinum',
  'title' => 'Platinum',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'platinum',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 311,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 151,
       'hide' => 0,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 216,
       'background_position_y' => '50',
       'background_position_x' => '50',
       'background_type' => 'image',
       'bottom_bg_padding_slider' => '0',
       'bottom_bg_padding_num' => '0',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'background_type' => 'image',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => '#ufc5',
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio/noise.jpg',
  'background_image_ratio' => 1,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '60',
  'top_bg_padding_num' => '60',
  'bottom_bg_padding_slider' => '10',
  'bottom_bg_padding_num' => '10',
  'bg_padding_slider' => '10',
  'bg_padding_num' => '10',
)
			);

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-73562 upfront-module-spacer',
  'id' => 'module-1451192746-73562',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-33956',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-12213',
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

$platinum->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428710403815-1476',
  'id' => 'module-1428710403815-1476',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;">Portfolio<span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2"></span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428710403814-1437',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 12,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '_default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 13,
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_num' => '50',
         'top_padding_slider' => '50',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_num' => '10',
         'top_padding_slider' => '10',
         'use_padding' => 'yes',
      )),
       'current_property' => 'top_padding_num',
    )),
    'top_padding_use' => 'yes',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_slider' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1428706223198-1717',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 13,
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

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-13561 upfront-module-spacer',
  'id' => 'module-1451192746-13561',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-44568',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-84038',
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

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-33477 upfront-module-spacer',
  'id' => 'module-1451192746-33477',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-20012',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-65909',
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

$platinum->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428716789856-1230',
  'id' => 'module-1428716789856-1230',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h3 class="" style="text-align: center;"><span>With more than 10 years experience in wedding photography and video, our aim is to capture the beautiful moments on your big day.</span><span></span></h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428716789855-1899',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 6,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '_default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '50',
         'bottom_padding_slider' => '50',
         'row' => 13,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '40',
         'bottom_padding_slider' => '40',
         'row' => 22,
      )),
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '70',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '70',
    'preset' => 'default',
    'padding_slider' => '10',
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1428717211782-1102',
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'top' => 0,
      'row' => 13,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 22,
    ),
  ),
));

$platinum->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-55313 upfront-module-spacer',
  'id' => 'module-1451192746-55313',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-54542',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-26028',
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

$platinum->add_element("Ugallery", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428725161912-1974',
  'id' => 'module-1428725161912-1974',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => '1942',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-1-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-1-240x300.jpg',
            1 => 240,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-1-360x545-4517.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
             'full' =>
            (array)(array(
               'width' => 360,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 38,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 436,
                 'height' => 545,
              )),
               'id' => 1942,
               'element_id' => 'ugallery-object-1428725161910-1512',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 436,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 38,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-1-360x545-4517.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-1.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p class="nosortable" style="text-align: center;">SALLY</p>',
         'caption' => '<p class="nosortable" style="text-align: center;">SALLY</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/sally/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1776,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/sally/',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => '1971',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-2-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-2-240x300.jpg',
            1 => 240,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-2-360x545-8155.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
             'full' =>
            (array)(array(
               'width' => 360,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 38,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 436,
                 'height' => 545,
              )),
               'id' => 1971,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 436,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 38,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-2-360x545-8155.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-2.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p class="nosortable">HAPPILY EVER AFTER</p>',
         'caption' => '<p class="nosortable">HAPPILY EVER AFTER</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/happily-ever-after/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1784,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/happily-ever-after/',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => '1972',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-3-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-3-242x300.jpg',
            1 => 242,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
            1 => 363,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
            1 => 363,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
            1 => 363,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-3-360x545-5166.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
             'full' =>
            (array)(array(
               'width' => 363,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 40,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 440,
                 'height' => 545,
              )),
               'id' => 1972,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 440,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 40,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-3-360x545-5166.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-3.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p class="nosortable">HARRY + SALLY</p>',
         'caption' => '<p class="nosortable">HARRY + SALLY</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/harry-and-sally/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1789,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/harry-and-sally/',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => '1973',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-4-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-4-240x300.jpg',
            1 => 240,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-4-360x545-7358.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
             'full' =>
            (array)(array(
               'width' => 360,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 38,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 436,
                 'height' => 545,
              )),
               'id' => 1973,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 436,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 38,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-4-360x545-7358.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-4.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p>WEDDING DRESS</p>',
         'caption' => '<p>WEDDING DRESS</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/wedding-dress/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1792,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/wedding-dress/',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => '1974',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-5-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-5-240x300.jpg',
            1 => 240,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-5-360x545-5948.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
             'full' =>
            (array)(array(
               'width' => 360,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 38,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 436,
                 'height' => 545,
              )),
               'id' => 1974,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 436,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 38,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-5-360x545-5948.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-5.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p class="nosortable">BEAUTIFUL BRIDE</p>',
         'caption' => '<p class="nosortable">BEAUTIFUL BRIDE</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/beautiful-bride/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1795,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/beautiful-bride/',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => '1975',
         'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-6-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-6-240x300.jpg',
            1 => 240,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
            1 => 360,
            2 => 450,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-6-360x545-5154.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
             'full' =>
            (array)(array(
               'width' => 360,
               'height' => 450,
            )),
             'crop' =>
            (array)(array(
               'width' => 360,
               'height' => 545,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '360',
                 'height' => '545',
                 'left' => 38,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 436,
                 'height' => 545,
              )),
               'id' => 1975,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 436,
           'height' => 545,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 360,
           'height' => 545,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '360',
           'height' => '545',
           'left' => 38,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-portfolio/Image-6-360x545-5154.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1428725161910-1512',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-portfolio/Image-6.jpg',
         'rotation' => 0,
         'link' => 'original',
         'title' => '<p class="nosortable">GROOM\'S JACKET</p>',
         'caption' => '<p class="nosortable">GROOM\'S JACKET</p>',
         'alt' => '',
         'tags' =>
        array (
        ),
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'imageLink' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/jacket/',
           'target' => '',
           'object' => 'page',
           'object_id' => 1812,
        )),
         'linkTarget' => '',
         'imageLinkType' => 'entry',
         'imageLinkUrl' => '{{upfront:home_url}}/jacket/',
         'imageLinkTarget' => '',
      )),
    ),
    'elementSize' =>
    (array)(array(
       'width' => 0,
       'height' => 0,
    )),
    'labelFilters' => '',
    'thumbProportions' => '0.66',
    'thumbWidth' => '360',
    'thumbHeight' => 545,
    'thumbWidthNumber' => '360',
    'captionType' => 'over',
    'captionColor' => '#ffffff',
    'captionUseBackground' => true,
    'captionBackground' => 'rgba(0, 0, 0, 0.75)',
    'showCaptionOnHover' =>
    array (
      0 => 'true',
    ),
    'fitThumbCaptions' =>
    array (
    ),
    'thumbCaptionsHeight' => 20,
    'linkTo' => 'image',
    'even_padding' =>
    array (
      0 => 'true',
    ),
    'thumbPadding' => 0,
    'sidePadding' => 0,
    'bottomPadding' => 0,
    'thumbPaddingNumber' => 0,
    'thumbSidePaddingNumber' => 0,
    'thumbBottomPaddingNumber' => 0,
    'lockPadding' => '',
    'lightbox_show_close' =>
    array (
      0 => 'true',
    ),
    'lightbox_show_image_count' =>
    array (
      0 => 'true',
    ),
    'lightbox_click_out_close' =>
    array (
      0 => 'true',
    ),
    'lightbox_active_area_bg' => 'rgba(255,255,255,1)',
    'lightbox_overlay_bg' => 'rgba(0,0,0,0.2)',
    'styles' => '',
    'usingNewAppearance' => true,
    'element_id' => 'ugallery-object-1428725161910-1512',
    'row' => 218,
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'ugallery-tablet',
         'row' => 69,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '40',
         'bottom_padding_slider' => '40',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'ugallery-mobile',
         'row' => 138,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'top_padding_slider' => '0',
      )),
    )),
    'theme_style' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'preset' => 'big-gallery',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'big-gallery',
      )),
    )),
    'thumbSidePadding' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1428725955805-1993',
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
      'edited' => true,
      'col' => 7,
      'order' => 2,
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
      'row' => 69,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 138,
    ),
  ),
));

$regions->add($platinum);

$premium = upfront_create_region(
			array (
  'name' => 'premium',
  'title' => 'Premium',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'premium',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 134,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'hide' => 0,
       'col' => 24,
       'row' => 114,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'hide' => 0,
       'row' => 191,
       'background_type' => 'color',
       'top_bg_padding_slider' => '30',
       'top_bg_padding_num' => '30',
       'bottom_bg_padding_slider' => '0',
       'bottom_bg_padding_num' => '0',
    )),
     'current_property' => 'bottom_bg_padding_num',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_color' => 'rgba(237,237,237,1)',
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-portfolio/bg-polaroid.jpg',
  'background_image_ratio' => 0.429999999999999993338661852249060757458209991455078125,
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '80',
  'top_bg_padding_num' => '80',
  'bottom_bg_padding_slider' => '80',
  'bottom_bg_padding_num' => '80',
  'bg_padding_slider' => '80',
  'bg_padding_num' => '80',
)
			);

$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-7761 upfront-module-spacer',
  'id' => 'module-1451192746-7761',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-62960',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-66546',
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

$premium->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1428718898143-1591',
  'id' => 'module-1428718898143-1591',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class="" style="text-align: center;">Pricing</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1428718898140-1940',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 9,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => 'plaintxt-pricing-title',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 6,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 7,
         'top_padding_use' => 'yes',
         'top_padding_num' => '10',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '10',
      )),
       'current_property' => 'top_padding_num',
    )),
    'top_padding_use' => 'yes',
    'top_padding_num' => '10',
    'bottom_padding_num' => '40',
    'lock_padding' => '',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '40',
    'preset' => 'default',
    'padding_slider' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1428721630523-1053',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
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
      'row' => 6,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 7,
    ),
  ),
));

$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-44149 upfront-module-spacer',
  'id' => 'module-1451192746-44149',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-46057',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-81492',
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

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-16910 upfront-module-spacer',
  'id' => 'module-1451192746-16910',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-50141',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-84811',
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

$premium->add_group(array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1451411650028-1913',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1431563302180-1032',
  'original_col' => 7,
  'top_padding_num' => '35',
  'bottom_padding_num' => 0,
  'background_color' => 'rgba(226,233,232,1)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 0,
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '35',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '10',
  'row' => 76,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 1,
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
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '0',
      'top_padding_slider' => '0',
      'row' => 49,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '30',
      'top_padding_slider' => '30',
      'row' => 49,
    ),
    'current_property' =>
    array (
      0 => 'use_padding',
    ),
  ),
));

$premium->add_element("Uimage", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431561673586-1688',
  'id' => 'module-1431561673586-1688',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio/cam-pro-91x83-4167.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/cam-pro.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/cam-pro.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 91,
       'height' => 83,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 91,
       'height' => 83,
    )),
    'position' =>
    (array)(array(
       'top' => -1,
       'left' => -112,
    )),
    'marginTop' => 1,
    'element_size' =>
    (array)(array(
       'width' => 295,
       'height' => 85,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 1858,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => false,
    'quick_swap' => false,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1431561673581-1733',
    'row' => 18,
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 10,
         'top_padding_use' => 'yes',
         'top_padding_num' => '30',
         'lock_padding' => '',
         'top_padding_slider' => '30',
         'use_padding' => 'yes',
      )),
       'mobile' =>
      (array)(array(
         'row' => 12,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
      )),
       'current_property' => 'top_padding_num',
    )),
    'theme_style' => '_default',
    'no_padding' => '1',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '5',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '5',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451411697763-1660',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 12,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1451411650028-1913',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431561673578-1693',
  'id' => 'module-1431561673578-1693',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<div class="plain-text-container">
<h6 class="" style="text-align: center;">PRO</h6>
</div>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431561673578-1032',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 6,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 6,
      )),
       'tablet' =>
      (array)(array(
         'row' => 4,
         'theme_style' => 'plaintxt-new-style-2',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
       'current_property' => 'top_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451411697781-1587',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 1,
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
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 6,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1451411650028-1913',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445914138418-1383',
  'id' => 'module-1445914138418-1383',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3">694</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1445914138418-1164',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 5,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 13,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '20',
         'bottom_padding_slider' => '20',
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 5,
         'theme_style' => 'title-pricing',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '10',
    'preset' => 'title-with-pricing',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'title-with-pricing',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'title-with-pricing',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'title-with-pricing',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451411697792-1722',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 2,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 5,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 13,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1451411650028-1913',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431563043248-1529',
  'id' => 'module-1431563043248-1529',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">10 hours&nbsp;wedding day</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431563043247-1024',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 19,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 27,
      )),
       'mobile' =>
      (array)(array(
         'row' => 9,
         'theme_style' => 'list-pricing-center',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'preset' => 'paragraph-check',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'paragraph-check',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451411697803-1356',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'clear' => true,
      'order' => 3,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'clear' => true,
      'order' => 3,
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
      'row' => 27,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 9,
      'hide' => 1,
    ),
  ),
  'group' => 'module-group-1451411650028-1913',
));

$premium->add_element("Button", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431561673638-1332',
  'id' => 'module-1431561673638-1332',
  'options' =>
  array (
    'content' => 'CHOOSE',
    'href' => '{{upfront:home_url}}/pricing/',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'green-button',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1431561673638-1113',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/pricing/',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 10,
    'is_edited' => true,
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 10,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
      )),
       'tablet' =>
      (array)(array(
         'row' => 10,
      )),
       'current_property' => 'top_padding_num',
    )),
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1451411697812-1737',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 4,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
  ),
  'group' => 'module-group-1451411650028-1913',
));

$premium->add_group(array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1431569989944-1237',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1431566260785-1673',
  'original_col' => 8,
  'background_color' => '#ufc5',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => '',
  'background_type' => 'color',
  'anchor' => '',
  'theme_style' => '_default',
  'row' => 84,
  'top_padding_use' => 'yes',
  'top_padding_num' => '65',
  'version' => '1.0.0',
  'bottom_padding_num' => '0',
  'top_padding_slider' => '65',
  'bottom_padding_use' => 0,
  'bottom_padding_slider' => '0',
  'lock_padding' => '',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 3,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 51,
      'top_padding_use' => 'yes',
      'top_padding_num' => '20',
      'top_padding_slider' => '20',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 27,
      'theme_style' => 'pricing-table-corners',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '30',
      'top_padding_slider' => '30',
    ),
  ),
));

$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-61730 upfront-module-spacer',
  'id' => 'module-1451192746-61730',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-20088',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-89806',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uimage", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431565374898-1569',
  'id' => 'module-1431565374898-1569',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio/cam-platinum-80x89-9194.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/cam-platinum.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/cam-platinum.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 80,
       'height' => 89,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 80,
       'height' => 89,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -40,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 160,
       'height' => 90,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 158,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => false,
    'quick_swap' => false,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1431565374894-1462',
    'row' => 18,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 17,
         'top_padding_use' => 'yes',
         'top_padding_num' => '20',
         'lock_padding' => '',
         'top_padding_slider' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '20',
         'bottom_padding_slider' => '20',
      )),
       'mobile' =>
      (array)(array(
         'row' => 13,
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
      )),
    )),
    'anchor' => '',
    'theme_style' => '_default',
    'no_padding' => '1',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1431570016030-1493',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 17,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 13,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-7788 upfront-module-spacer',
  'id' => 'module-1451192746-7788',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-1580',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-96567',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-56930 upfront-module-spacer',
  'id' => 'module-1451192746-56930',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-85392',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-40717',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("PlainTxt", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445912977895-1246',
  'id' => 'module-1445912977895-1246',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h6 class="" style="text-align: center;">PLATINUM</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1445912977895-1796',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 5,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 5,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '10',
         'bottom_padding_slider' => '10',
      )),
       'tablet' =>
      (array)(array(
         'row' => 5,
         'theme_style' => 'plaintxt-new-style-2',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '15',
         'bottom_padding_slider' => '15',
         'use_padding' => 'yes',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445912979796-1035',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 3,
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
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 5,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 5,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-49374 upfront-module-spacer',
  'id' => 'module-1451192746-49374',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-73634',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-56627',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-58146 upfront-module-spacer',
  'id' => 'module-1451192746-58146',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-60859',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-93060',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("PlainTxt", array (
  'columns' => '6',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431565478608-1589',
  'id' => 'module-1431565478608-1589',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_3">1199</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431565478608-1608',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 7,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 4,
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '20',
         'bottom_padding_slider' => '20',
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 5,
         'theme_style' => 'title-pricing',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '0',
         'bottom_padding_slider' => '0',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '10',
    'preset' => 'title-with-pricing',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'title-with-pricing-tablet',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'title-with-pricing-tablet',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'title-with-pricing',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1431573665151-1814',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 5,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 4,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-25498 upfront-module-spacer',
  'id' => 'module-1451192746-25498',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-62093',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-35737',
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
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431566346555-1055',
  'id' => 'module-1431566346555-1055',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">Unlimited wedding photos</p><p class="" style="text-align: center;">3x wedding albums</p><p class="" style="text-align: center;">Photo booth</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431566346555-1076',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 24,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 23,
      )),
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset' => 'paragraph-check',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'paragraph-check',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1431570016065-1127',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 6,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 3,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 23,
      'hide' => 1,
    ),
  ),
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_element("Button", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431565522155-1051',
  'id' => 'module-1431565522155-1051',
  'options' =>
  array (
    'content' => 'CHOOSE',
    'href' => '{{upfront:home_url}}/pricing/',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'green-button',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1431565522155-1806',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/pricing/',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 10,
    'is_edited' => true,
    'theme_style' => 'button-pricing',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 10,
      )),
       'tablet' =>
      (array)(array(
         'row' => 8,
      )),
    )),
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'right_padding_use' => 'yes',
    'bottom_padding_use' => 'yes',
    'left_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1431570016071-1162',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 7,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 4,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 8,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
  ),
  'group' => 'module-group-1431569989944-1237',
));

$premium->add_group(array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1445984248224-1196',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1431565374620-1618',
  'original_col' => 7,
  'background_color' => 'rgba(226,233,232,1)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => '',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_num' => '45',
  'version' => '1.0.0',
  'bottom_padding_num' => '10',
  'lock_padding' => '',
  'top_padding_slider' => '45',
  'bottom_padding_use' => false,
  'bottom_padding_slider' => '10',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'row' => 46,
      'top' => 0,
      'top_padding_use' => 'yes',
      'top_padding_num' => '0',
      'lock_padding' => '',
      'top_padding_slider' => '0',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 39,
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_num' => '30',
      'top_padding_slider' => '30',
    ),
    'current_property' =>
    array (
      0 => 'use_padding',
    ),
  ),
));

$premium->add_element("Uimage", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445984201621-1480',
  'id' => 'module-1445984201621-1480',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/single-page-portfolio/cam-premium-97x60-1465.png',
    'srcFull' => '{{upfront:style_url}}/images/single-page-portfolio/cam-premium.png',
    'srcOriginal' => '{{upfront:style_url}}/images/single-page-portfolio/cam-premium.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => true,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 97,
       'height' => 60,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 99,
       'height' => 61,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => -109,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 295,
       'height' => 60,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 2098,
    'align' => 'center',
    'stretch' => false,
    'vstretch' => true,
    'quick_swap' => false,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image uimage-no-padding',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => false,
       'url' => '',
       'target' => false,
    )),
    'usingNewAppearance' => true,
    'element_id' => 'image-1445984201620-1070',
    'row' => 12,
    'no_padding' => '1',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '40',
         'lock_padding' => '',
         'top_padding_slider' => '40',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '10',
         'bottom_padding_slider' => '10',
         'use_padding' => 'yes',
      )),
       'current_property' => 'top_padding_num',
    )),
    'bottom_padding_num' => '0',
    'lock_padding' => '',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445984303216-1425',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'col' => 4,
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
  'group' => 'module-group-1445984248224-1196',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445914326244-1758',
  'id' => 'module-1445914326244-1758',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h6 style="text-align: center;" class="">PREMIUM</h6>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1445914326244-1900',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 5,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 8,
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '10',
         'bottom_padding_slider' => '10',
      )),
       'tablet' =>
      (array)(array(
         'row' => 6,
         'theme_style' => 'plaintxt-new-style-2',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_num' => '10',
         'top_padding_slider' => '10',
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '15',
         'bottom_padding_slider' => '15',
         'use_padding' => 'yes',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '_default',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset' => 'default',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445984303225-1811',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
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
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 6,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 8,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1445984248224-1196',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431563097882-1574',
  'id' => 'module-1431563097882-1574',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 class="" style="text-align: center;"><span class="upfront_theme_color_3">859</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431563097882-1033',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 6,
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 5,
         'bottom_padding_use' => 'yes',
         'bottom_padding_num' => '20',
         'bottom_padding_slider' => '20',
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 4,
         'theme_style' => 'title-pricing',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'top_padding_num' => '0',
    'bottom_padding_num' => '10',
    'preset' => 'title-with-pricing',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'title-with-pricing-tablet',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'title-with-pricing-tablet',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'title-with-pricing',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445984303229-1439',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 2,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 2,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 5,
      'hide' => 0,
    ),
  ),
  'group' => 'module-group-1445984248224-1196',
));

$premium->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431565460457-1264',
  'id' => 'module-1431565460457-1264',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class="" style="text-align: center;">10 hours&nbsp;wedding day</p><p class="" style="text-align: center;">3x wedding albums</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1431565460456-1946',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 23,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 14,
      )),
    )),
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '10',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset' => 'paragraph-check',
    'use_padding' => 'yes',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'paragraph-check',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445984303231-1240',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 3,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
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
      'top' => 0,
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 14,
      'hide' => 1,
    ),
  ),
  'group' => 'module-group-1445984248224-1196',
));

$premium->add_element("Button", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1431563267339-1059',
  'id' => 'module-1431563267339-1059',
  'options' =>
  array (
    'content' => 'CHOOSE',
    'href' => '{{upfront:home_url}}/pricing/',
    'linkTarget' => '_self',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'preset' => 'green-button',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1431563267338-1626',
    'link' =>
    (array)(array(
       'type' => 'entry',
       'url' => '{{upfront:home_url}}/pricing/',
       'target' => '_self',
    )),
    'currentpreset' => false,
    'row' => 10,
    'theme_style' => 'button-pricing',
    'is_edited' => true,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 10,
      )),
       'tablet' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '0',
         'lock_padding' => '',
         'top_padding_slider' => '0',
         'row' => 5,
      )),
    )),
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '0',
    'right_padding_num' => '0',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'left_padding_use' => 'yes',
    'right_padding_use' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445984303233-1821',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 4,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 4,
      'clear' => true,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 5,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 10,
    ),
  ),
  'group' => 'module-group-1445984248224-1196',
));

$premium->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1451192746-37432 upfront-module-spacer',
  'id' => 'module-1451192746-37432',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1451192746-92444',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1451192746-88241',
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

$regions->add($premium);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'newsletter.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
