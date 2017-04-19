<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$gallery_title = upfront_create_region(
			array (
  'name' => 'gallery-title',
  'title' => 'Gallery Title',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'gallery-title',
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
       'background_position_y' => '50',
       'background_style' => 'full',
       'background_position_x' => '50',
       'background_type' => 'image',
       'top_bg_padding_num' => '45',
       'top_bg_padding_slider' => '45',
       'row' => 38,
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 25,
       'background_position_y' => '50',
       'background_style' => 'full',
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
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-page-gallery/bg-page-gallery.jpg',
  'background_image_ratio' => 0.25,
  'background_repeat' => 'no-repeat',
  'background_position' => '50% 50%',
  'version' => '1.0.0',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'background_default' => 'hide',
  'featured_fallback_background_color' => '#ffffff',
  'region_role' => 'complementary',
)
			);

$gallery_title->add_element("Uspacer", array (
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

$gallery_title->add_element("PlainTxt", array (
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
    'content' => '<h1 style="text-align: center;">GALLERY</h1>',
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
    'row' => 16,
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
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
         'row' => 7,
      )),
       'current_property' => 'bottom_padding_num',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '15',
         'bottom_padding_num' => '15',
         'row' => 8,
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
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
      'row' => 8,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 7,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$gallery_title->add_element("Uspacer", array (
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

$regions->add($gallery_title);

$gallery_content = upfront_create_region(
			array (
  'name' => 'gallery-content',
  'title' => 'Gallery Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'gallery-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 46,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 24,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '60',
       'bottom_bg_padding_num' => '60',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'row' => 88,
       'background_type' => 'color',
       'bottom_bg_padding_slider' => '60',
       'bottom_bg_padding_num' => '60',
    )),
     'current_property' => 'bottom_bg_padding_num',
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
  'region_role' => 'main',
)
			);

$gallery_content->add_element("Uspacer", array (
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

$gallery_content->add_element("PlainTxt", array (
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
    'content' => '<p><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}">HOME</a> &nbsp;/ &nbsp;GALLERY</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425458783-1679',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
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
    'top_padding_slider' => '15',
    'row' => 11,
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

$gallery_content->add_element("Uspacer", array (
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

$gallery_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425820488-1317 upfront-module-spacer',
  'id' => 'module-1453425820488-1317',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425820488-1179',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425820488-1827',
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

$gallery_content->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425744532-1902',
  'id' => 'module-1453425744532-1902',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h3 style="text-align: center;">Discover a powerful new approach to looking and feeling great without depriving yourself of the foods you love.</h3>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453425744531-1920',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '30',
    'bottom_padding_num' => '30',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'preset' => 'default',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      array (
      ),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'align-center',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453425811280-1466',
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

$gallery_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453425823393-1127 upfront-module-spacer',
  'id' => 'module-1453425823393-1127',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453425823393-1215',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453425823393-1114',
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

$gallery_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430885793-1429 upfront-module-spacer',
  'id' => 'module-1453430885793-1429',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453430885793-1076',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453430885793-1819',
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

$gallery_content->add_element("Ugallery", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430326935-1315',
  'id' => 'module-1453430326935-1315',
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
         'id' => 77,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-220x220-4377.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one-140x140-1759.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
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
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 1721,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 330,
           'height' => 220,
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
           'left' => 35,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 32,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-one.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => 78,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-220x220-9023.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-300x140.jpg',
            1 => 300,
            2 => 140,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-768x358.jpg',
            1 => 768,
            2 => 358,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-1024x477.jpg',
            1 => 1024,
            2 => 477,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
            1 => 1080,
            2 => 503,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two-140x140-9348.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 503,
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
                 'left' => 80,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 301,
                 'height' => 140,
              )),
               'id' => 1722,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 473,
           'height' => 220,
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
           'left' => 80,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 73,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-two.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => 79,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-220x220-6523.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three-140x140-6258.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
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
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 1723,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 330,
           'height' => 220,
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
           'left' => 35,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 32,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-three.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => 80,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-220x220-6844.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-300x131.jpg',
            1 => 300,
            2 => 131,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-768x334.jpg',
            1 => 768,
            2 => 334,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-1024x446.jpg',
            1 => 1024,
            2 => 446,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
            1 => 1080,
            2 => 470,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four-140x140-4361.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 470,
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
                 'left' => 91,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 322,
                 'height' => 140,
              )),
               'id' => 1724,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 506,
           'height' => 220,
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
           'left' => 91,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 83,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-four.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => 81,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-220x220-2785.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five-140x140-5709.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
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
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 1725,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 330,
           'height' => 220,
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
           'left' => 35,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 32,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-five.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => 82,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-220x220-1804.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six-140x140-9270.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
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
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 1726,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 330,
           'height' => 220,
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
           'left' => 35,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 32,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-six.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => 83,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven-220x220-3824.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven-210x300.jpg',
            1 => 210,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
            1 => 630,
            2 => 900,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven-140x140-8633.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
             'full' =>
            (array)(array(
               'width' => 630,
               'height' => 900,
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
                 'left' => 0,
                 'top' => 30,
              )),
               'resize' =>
              (array)(array(
                 'width' => 140,
                 'height' => 200,
              )),
               'id' => 1727,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 220,
           'height' => 314.28571428599997261699172668159008026123046875,
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
           'left' => 0,
           'top' => 30,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 28,
           'left' => 0,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-seven.jpg',
         'imageLinkTarget' => '',
      )),
      7 =>
      (array)(array(
         'id' => 84,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-220x220-3853.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-768x512.jpg',
            1 => 768,
            2 => 512,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-1024x683.jpg',
            1 => 1024,
            2 => 683,
            3 => true,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
            1 => 1080,
            2 => 720,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight-140x140-5158.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
             'full' =>
            (array)(array(
               'width' => 1080,
               'height' => 720,
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
                 'left' => 35,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 210,
                 'height' => 140,
              )),
               'id' => 1728,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 330,
           'height' => 220,
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
           'left' => 35,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 32,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-eight.jpg',
         'imageLinkTarget' => '',
      )),
      8 =>
      (array)(array(
         'id' => 85,
         'src' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine-220x220-5229.jpg',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine-300x300.jpg',
            1 => 300,
            2 => 300,
            3 => true,
          ),
           'medium_large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
            1 => 500,
            2 => 500,
            3 => false,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
            1 => 500,
            2 => 500,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
            1 => 500,
            2 => 500,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine-140x140-6819.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
             'full' =>
            (array)(array(
               'width' => 500,
               'height' => 500,
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
                 'left' => 0,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 140,
                 'height' => 140,
              )),
               'id' => 1729,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 220,
           'height' => 220,
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
           'left' => 0,
           'top' => 0,
        )),
         'rotation' => 0,
         'link' => 'original',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
         'title' => '<p>Image caption</p>',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1453430326931-1944',
         'urlType' => 'image',
         'cropPosition' =>
        (array)(array(
           'top' => 0,
           'left' => 0,
        )),
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/img-gallery-nine.jpg',
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
    'thumbWidth' => '220',
    'thumbHeight' => 220,
    'thumbWidthNumber' => '220',
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
    'thumbPadding' => 15,
    'sidePadding' => '25',
    'bottomPadding' => '25',
    'thumbPaddingNumber' => 15,
    'thumbSidePaddingNumber' => '25',
    'thumbBottomPaddingNumber' => '25',
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
    'element_id' => 'ugallery-object-1453430326931-1944',
    'padding_slider' => '15',
    'top_padding_num' => '30',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'row' => 138,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 73,
      )),
    )),
    'current_preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453430469291-1102',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 12,
      'order' => 3,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 3,
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
      'row' => 73,
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

$gallery_content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453430888177-1850 upfront-module-spacer',
  'id' => 'module-1453430888177-1850',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1453430888177-1831',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1453430888177-1867',
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

$regions->add($gallery_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
