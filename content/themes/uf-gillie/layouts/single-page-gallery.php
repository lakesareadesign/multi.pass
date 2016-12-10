<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$cover_gallery = upfront_create_region(
			array (
  'name' => 'cover-gallery',
  'title' => 'cover gallery',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'cover-gallery',
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
  'background_image' => '{{upfront:style_url}}/images/single-page-gallery/gallery.jpg',
  'background_image_ratio' => 0.36999999999999999555910790149937383830547332763671875,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
)
			);

$cover_gallery->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460019868239-1158 upfront-module-spacer',
  'id' => 'module-1460019868239-1158',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460019868239-1579',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460019868238-1447',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 1,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
));

$cover_gallery->add_element("PlainTxt", array (
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
    'content' => '<h1><span class="upfront_theme_color_3" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_3">Our<br>​Gallery​</span></h1>',
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
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
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
      'edited' => true,
      'col' => 12,
      'order' => 1,
      'clear' => false,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 7,
      'order' => 1,
      'clear' => false,
    ),
    'current_property' =>
    array (
      0 => 'edited',
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
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$cover_gallery->add_element("Uspacer", array (
  'columns' => '15',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1460019870385-1450 upfront-module-spacer',
  'id' => 'module-1460019870385-1450',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1460019870385-1822',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1460019870384-1293',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
    'mobile' =>
    array (
      'edited' => true,
    ),
  ),
));

$regions->add($cover_gallery);

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
  'row' => 7,
  'background_type' => 'color',
  'background_color' => '#ufc3',
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
     'current_property' => 'bottom_bg_padding_num',
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
  'version' => '1.0.0',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459949388064-1863 upfront-module-spacer',
  'id' => 'module-1459949388064-1863',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459949388064-1620',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459949388063-1937',
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

$main->add_element("Ugallery", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459949278572-1501',
  'id' => 'module-1459949278572-1501',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'preset' => 'default',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => 2715,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-250x250-2080.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/949845122gallery-1.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-300x199.jpg',
            1 => 300,
            2 => 199,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-768x510.jpg',
            1 => 768,
            2 => 510,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-1024x680.jpg',
            1 => 1024,
            2 => 680,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-1.jpg',
            1 => 1364,
            2 => 906,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1-250x250-2080.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 906,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 63,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 376,
                 'height' => 250,
              )),
               'id' => 2634,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 376,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 63,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable"><span>Sed diam nonummy nibh euismod</span></h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-1.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => 2716,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-250x250-7943.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/319644766gallery-2.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-2.jpg',
            1 => 1364,
            2 => 909,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2-250x250-7943.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 909,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 62,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 375,
                 'height' => 250,
              )),
               'id' => 2635,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 375,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 62,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable"><span rel="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: normal; line-height: 17px; text-align: justify; text-transform: none;" data-verified="redactor">Mirum est notare quam littera gothica</span><br></h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-2.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => 2717,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-250x250-1251.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/1917948972gallery-3.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-3.jpg',
            1 => 1364,
            2 => 909,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3-250x250-1251.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 909,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 62,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 375,
                 'height' => 250,
              )),
               'id' => 2636,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 375,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 62,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable">Fiant sollemnes in futurum</h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-3.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => 2718,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-250x250-1124.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/368393788gallery-4.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-4.jpg',
            1 => 1364,
            2 => 910,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4-250x250-1124.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 910,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 62,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 375,
                 'height' => 250,
              )),
               'id' => 2637,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 375,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 62,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable">Consectetuer adipiscing elit<br></h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-4.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => 3474,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-250x250-5808.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
            1 => 1364,
            2 => 909,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5-250x250-5808.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 909,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 62,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 375,
                 'height' => 250,
              )),
               'id' => 2638,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 375,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 62,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable">Eodem modo typi</h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-5.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => 2720,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-250x250-2414.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/1268716390gallery-6.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-181x300.jpg',
            1 => 181,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-768x1273.jpg',
            1 => 768,
            2 => 1273,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-618x1024.jpg',
            1 => 618,
            2 => 1024,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-6.jpg',
            1 => 1364,
            2 => 2261,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6-250x250-2414.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 2261,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 0,
                 'top' => 82,
              )),
               'resize' =>
              (array)(array(
                 'width' => 250,
                 'height' => 414,
              )),
               'id' => 2639,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 250,
           'height' => 414,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 0,
           'top' => 82,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable"><span rel="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: normal; line-height: 17px; text-align: justify; text-transform: none;" data-verified="redactor">Claritas est etiam processus</span><br></h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-6.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => 2721,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-250x250-6914.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/319406660gallery-7.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-1024x682.jpg',
            1 => 1024,
            2 => 682,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/gallery-7.jpg',
            1 => 1364,
            2 => 909,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7-250x250-6914.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7.jpg',
             'full' =>
            (array)(array(
               'width' => 1364,
               'height' => 909,
            )),
             'crop' =>
            (array)(array(
               'width' => 250,
               'height' => 250,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '250',
                 'height' => '250',
                 'left' => 62,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 375,
                 'height' => 250,
              )),
               'id' => 2640,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 375,
           'height' => 250,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 250,
           'height' => 250,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '250',
           'height' => '250',
           'left' => 62,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7.jpg',
         'title' => '<p>Image caption</p>',
         'caption' => '<h5 class="nosortable"><span rel="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: normal; line-height: 17px; text-align: justify; text-transform: none;" data-verified="redactor">Typi non habent claritatem</span><br></h5>',
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
           'type' => 'image',
           'url' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1459949278569-1312',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/gallery-7.jpg',
         'imageLinkTarget' => '',
      )),
    ),
    'elementSize' =>
    (array)(array(
       'width' => 0,
       'height' => 0,
    )),
    'labelFilters' => '',
    'thumbProportions' => '1',
    'thumbWidth' => '250',
    'thumbHeight' => 250,
    'thumbWidthNumber' => '250',
    'captionType' => 'none',
    'captionColor' => '#ffffff',
    'captionUseBackground' => 0,
    'captionBackground' => '#000000',
    'showCaptionOnHover' => 0,
    'fitThumbCaptions' => false,
    'thumbCaptionsHeight' => 20,
    'linkTo' => 'image',
    'even_padding' =>
    array (
      0 => 'false',
    ),
    'thumbPadding' => '10',
    'sidePadding' => 15,
    'bottomPadding' => 15,
    'thumbPaddingNumber' => '10',
    'thumbSidePaddingNumber' => 15,
    'thumbBottomPaddingNumber' => 15,
    'lockPadding' => 'yes',
    'lightbox_show_close' =>
    array (
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
    'element_id' => 'ugallery-object-1459949278569-1312',
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
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1459949307432-1810',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1459949390336-1898 upfront-module-spacer',
  'id' => 'module-1459949390336-1898',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1459949390335-1366',
    'preset' => 'default',
    'current_preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1459949390335-1413',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
