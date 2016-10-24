<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php');	   	 	  	    			    

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
  'row' => 40,
  'background_type' => 'image',
  'background_color' => '#ufc5',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'row' => 34,
       'background_position_y' => '50',
       'background_style' => 'tile',
       'background_repeat' => 'repeat',
       'background_position_x' => '50',
       'background_type' => 'image',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'row' => 136,
    )),
     'current_property' => 'background_type',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-our-gallery/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
)
			);

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867984-86503 upfront-module-spacer',
  'id' => 'module-1450867984-86503',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867984-36235',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867984-64142',
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

$main->add_element("PlainTxt", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429597710225-1950',
  'id' => 'module-1429597710225-1950',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 style="text-align: center;" class="">Gallery</h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429597710225-1840',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 32,
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
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 90,
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'top_padding_use' => true,
         'top_padding_num' => 50,
      )),
    )),
    'top_padding_use' => true,
    'top_padding_num' => 105,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'u-section-title-m',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-section-title-m',
      )),
    )),
    'current_preset' => 'u-section-title-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429597719412-1061',
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

$main->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867984-42013 upfront-module-spacer',
  'id' => 'module-1450867984-42013',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867984-30129',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867984-60765',
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

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867984-28201 upfront-module-spacer',
  'id' => 'module-1450867984-28201',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867984-22437',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867984-79227',
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

$main->add_element("Ugallery", array (
  'columns' => '12',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429597710231-1415',
  'id' => 'module-1429597710231-1415',
  'options' =>
  array (
    'type' => 'UgalleryModel',
    'view_class' => 'UgalleryView',
    'has_settings' => 1,
    'class' => 'c24 upfront-gallery',
    'id_slug' => 'ugallery',
    'preset' => 'fancy',
    'status' => 'ok',
    'images' =>
    array (
      0 =>
      (array)(array(
         'id' => 4356,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1-145x145-2908.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1-140x140-2740.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 140,
               'height' => 140,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '140',
                 'height' => '140',
                 'left' => 70,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 280,
                 'height' => 140,
              )),
               'id' => 1809,
               'element_id' => 'ugallery-object-1429597710229-1285',
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 140,
           'height' => 140,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '140',
           'height' => '140',
           'left' => 70,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-1.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => 4357,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2-145x145-3095.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2-145x145-3095.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1810,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-2.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => 4358,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3-145x145-5227.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3-145x145-5227.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1811,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-3.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => 4359,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4-145x145-5445.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4-145x145-5445.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1812,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-4.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => 4360,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5-145x145-3697.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5-145x145-3697.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1813,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-5.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => 4361,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6-145x145-8374.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6-145x145-8374.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1814,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-6.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => 4362,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7-145x145-4737.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7-145x145-4737.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1815,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-7.jpg',
         'imageLinkTarget' => '',
      )),
      7 =>
      (array)(array(
         'id' => 4363,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8-145x145-1375.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8-145x145-1375.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1816,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-8.jpg',
         'imageLinkTarget' => '',
      )),
      8 =>
      (array)(array(
         'id' => 4364,
         'src' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9-145x145-8469.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9-300x150.jpg',
            1 => 300,
            2 => 150,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
            1 => 600,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9-145x145-8469.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
             'full' =>
            (array)(array(
               'width' => 600,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 145,
               'height' => 145,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '145',
                 'height' => '145',
                 'left' => 72,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 290,
                 'height' => 145,
              )),
               'id' => 1817,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 290,
           'height' => 145,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 145,
           'height' => 145,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '145',
           'height' => '145',
           'left' => 72,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
         'title' => 'Image caption',
         'caption' => 'Image description',
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
           'url' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1429597710229-1285',
         'urlType' => 'image',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-our-gallery/gallery-img-9.jpg',
         'imageLinkTarget' => '',
      )),
    ),
    'elementSize' =>
    (array)(array(
       'width' => 0,
       'height' => 0,
    )),
    'labelFilters' =>
    array (
    ),
    'thumbProportions' => '1',
    'thumbWidth' => '145',
    'thumbHeight' => 145,
    'thumbWidthNumber' => 140,
    'captionType' => 'none',
    'captionColor' => '#ffffff',
    'captionUseBackground' => 0,
    'captionBackground' => '#000000',
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
    'thumbPadding' => 35,
    'sidePadding' => 35,
    'bottomPadding' => 35,
    'thumbPaddingNumber' => 35,
    'thumbSidePaddingNumber' => 35,
    'thumbBottomPaddingNumber' => 35,
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
    'element_id' => 'ugallery-object-1429597710229-1285',
    'row' => 54,
    'anchor' => '',
    'theme_style' => '',
    'top_padding_use' => true,
    'top_padding_num' => 75,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 35,
         'row' => 68,
      )),
       'mobile' =>
      (array)(array(
         'top_padding_use' => true,
         'top_padding_num' => 30,
      )),
    )),
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'fancy',
      )),
    )),
    'thumbSidePadding' => 35,
    'current_preset' => 'fancy',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429597772735-1845',
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
      'row' => 68,
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

$main->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867984-51584 upfront-module-spacer',
  'id' => 'module-1450867984-51584',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867984-60656',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867984-16256',
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

$main->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429597719473-1347',
  'id' => 'module-1429597719473-1347',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class=""><span>Our coffees come with a smile.</span><span></span></h2><p class="">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica quam.</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429597719473-1541',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 29,
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
         'row' => 15,
         'theme_style' => '',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '35',
         'top_padding_num' => '35',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'row' => 42,
      )),
       'current_property' => 'lock_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 75,
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'u-paragraph-m',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'u-paragraph-m',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'center',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'center',
      )),
    )),
    'current_preset' => 'u-paragraph-m',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1429597938550-1175',
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
      'row' => 15,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 42,
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1450867984-79351 upfront-module-spacer',
  'id' => 'module-1450867984-79351',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'usingNewAppearance' => true,
    'element_id' => 'spacer-object-1450867984-60836',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1450867984-69599',
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

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
