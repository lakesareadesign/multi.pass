<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$content = upfront_create_region(
			array (
  'name' => 'content',
  'title' => 'Content',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'content',
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
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'main',
)
			);

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-17888 upfront-module-spacer',
  'id' => 'module-1449776257-17888',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-17695',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-57457',
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

$content->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414594578252-1331',
  'id' => 'module-1414594578252-1331',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 style="text-align: center;" class=""><span class="upfront_theme_color_0" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_0">Gallery</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414594578251-1525',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 35,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'top_padding_use' => true,
    'top_padding_num' => 115,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'preset' => 'default',
    'breakpoint_presets' =>
    (array)(array(
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1414594649440-1386',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => false,
      'edited' => true,
    ),
    'mobile' =>
    array (
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
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-50480 upfront-module-spacer',
  'id' => 'module-1449776257-50480',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-31937',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-71815',
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

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-5453 upfront-module-spacer',
  'id' => 'module-1449776257-5453',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-42823',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-2238',
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

$content->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445815125316-1397',
  'id' => 'module-1445815125316-1397',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class=""><span>Browse our collection of client work meticulously completed by our skilled tradespeople.</span><span></span></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1445815125316-1424',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 23,
      )),
       'mobile' =>
      array (
      ),
       'current_property' => 'use_padding',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1414594744894-1260',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 1,
      'clear' => false,
      'edited' => true,
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 23,
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
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$content->add_element("PlainTxt", array (
  'columns' => '11',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445815263095-1729',
  'id' => 'module-1445815263095-1729',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class=""><span>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</span><br></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1445815263095-1284',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 40,
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
         'theme_style' => 'text-center',
      )),
       'mobile' =>
      array (
      ),
       'current_property' => 'use_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 25,
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => 0,
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'breakpoint_presets' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'preset' => 'center-content',
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
  'wrapper_id' => 'wrapper-1445815266933-1058',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 12,
      'order' => 2,
      'clear' => false,
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
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$content->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-24983 upfront-module-spacer',
  'id' => 'module-1449776257-24983',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-30027',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-89832',
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

$gallery = upfront_create_region(
			array (
  'name' => 'gallery',
  'title' => 'Gallery',
  'type' => 'clip',
  'scope' => 'local',
  'container' => 'gallery',
  'position' => 1,
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
  'background_type' => 'color',
  'nav_region' => '',
  'background_color' => 'rgba(255,255,255,0.75)',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'version' => '1.0.0',
)
			);

$gallery->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-41806 upfront-module-spacer',
  'id' => 'module-1449776257-41806',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-11607',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-65313',
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

$gallery->add_element("Ugallery", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1444384005348-1814',
  'id' => 'module-1444384005348-1814',
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
         'id' => '65',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739-200x300.jpg',
            1 => 200,
            2 => 300,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
            1 => 291,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
            1 => 291,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739-190x190-3726.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
             'full' =>
            (array)(array(
               'width' => 291,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 0,
                 'top' => 47,
              )),
               'resize' =>
              (array)(array(
                 'width' => 190,
                 'height' => 285,
              )),
               'id' => 65,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 190,
           'height' => 285,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 0,
           'top' => 47,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739-190x190-3726.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7739.jpg',
         'imageLinkTarget' => '',
      )),
      1 =>
      (array)(array(
         'id' => '66',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741-190x190-3811.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 66,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741-190x190-3811.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7741.jpg',
         'imageLinkTarget' => '',
      )),
      2 =>
      (array)(array(
         'id' => '67',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750-190x190-9052.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 67,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750-190x190-9052.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7750.jpg',
         'imageLinkTarget' => '',
      )),
      3 =>
      (array)(array(
         'id' => '68',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751-190x190-6847.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 68,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751-190x190-6847.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7751.jpg',
         'imageLinkTarget' => '',
      )),
      4 =>
      (array)(array(
         'id' => '69',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813-200x300.jpg',
            1 => 200,
            2 => 300,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
            1 => 655,
            2 => 983,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
            1 => 655,
            2 => 983,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813-190x190-4979.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 983,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 0,
                 'top' => 47,
              )),
               'resize' =>
              (array)(array(
                 'width' => 190,
                 'height' => 285,
              )),
               'id' => 69,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 190,
           'height' => 285,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 0,
           'top' => 47,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813-190x190-4979.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7813.jpg',
         'imageLinkTarget' => '',
      )),
      5 =>
      (array)(array(
         'id' => '70',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887-190x190-4265.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 70,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887-190x190-4265.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7887.jpg',
         'imageLinkTarget' => '',
      )),
      6 =>
      (array)(array(
         'id' => '71',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899-190x190-8319.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 71,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899-190x190-8319.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7899.jpg',
         'imageLinkTarget' => '',
      )),
      7 =>
      (array)(array(
         'id' => '72',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900-190x190-3043.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 72,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900-190x190-3043.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7900.jpg',
         'imageLinkTarget' => '',
      )),
      8 =>
      (array)(array(
         'id' => '73',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902-190x190-9010.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 73,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902-190x190-9010.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7902.jpg',
         'imageLinkTarget' => '',
      )),
      9 =>
      (array)(array(
         'id' => '74',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904-190x190-1954.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 74,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904-190x190-1954.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7904.jpg',
         'imageLinkTarget' => '',
      )),
      10 =>
      (array)(array(
         'id' => '75',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907-190x190-4264.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 75,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907-190x190-4264.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7907.jpg',
         'imageLinkTarget' => '',
      )),
      11 =>
      (array)(array(
         'id' => '76',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908-190x190-2041.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 76,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908-190x190-2041.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7908.jpg',
         'imageLinkTarget' => '',
      )),
      12 =>
      (array)(array(
         'id' => '77',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911-190x190-8209.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 77,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911-190x190-8209.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7911.jpg',
         'imageLinkTarget' => '',
      )),
      13 =>
      (array)(array(
         'id' => '78',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914-190x190-9645.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 78,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914-190x190-9645.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7914.jpg',
         'imageLinkTarget' => '',
      )),
      14 =>
      (array)(array(
         'id' => '79',
         'srcFull' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917-150x150.jpg',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917-300x200.jpg',
            1 => 300,
            2 => 200,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
            1 => 655,
            2 => 437,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917-190x190-2272.jpg',
             'urlOriginal' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
             'full' =>
            (array)(array(
               'width' => 655,
               'height' => 437,
            )),
             'crop' =>
            (array)(array(
               'width' => 190,
               'height' => 190,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '190',
                 'height' => '190',
                 'left' => 47,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 285,
                 'height' => 190,
              )),
               'id' => 79,
            )),
          )),
        )),
         'size' =>
        (array)(array(
           'width' => 285,
           'height' => 190,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 190,
           'height' => 190,
        )),
         'cropOffset' =>
        (array)(array(
           'width' => '190',
           'height' => '190',
           'left' => 47,
           'top' => 0,
        )),
         'src' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917-190x190-2272.jpg',
         'loading' => false,
         'status' => 'ok',
         'element_id' => 'ugallery-object-1444384005345-1474',
         'urlType' => 'image',
         'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
         'rotation' => 0,
         'link' => 'original',
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
           'url' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
           'target' => '',
        )),
         'linkTarget' => '',
         'imageLinkType' => 'image',
         'imageLinkUrl' => '{{upfront:style_url}}/images/single-page-gallery/_MG_7917.jpg',
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
    'thumbWidth' => '185',
    'thumbHeight' => 185,
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
    'thumbPadding' => 1,
    'sidePadding' => 1,
    'bottomPadding' => 1,
    'thumbPaddingNumber' => 1,
    'thumbSidePaddingNumber' => 1,
    'thumbBottomPaddingNumber' => 1,
    'lockPadding' => 1,
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
    'element_id' => 'ugallery-object-1444384005345-1474',
    'row' => 127,
    'anchor' => '',
    'theme_style' => 'ugallery-scribe-style',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => 'responsive-gallery',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '_default',
      )),
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'thumbSidePadding' => 1,
    'padding_slider' => '15',
    'breakpoint_presets' =>
    (array)(array(
    )),
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'lock_padding' => 0,
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1444384057664-1807',
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
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$gallery->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776257-78062 upfront-module-spacer',
  'id' => 'module-1449776257-78062',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776257-33993',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776257-52391',
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

$regions->add($gallery);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-request-quote-gap.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'pre-request-quote-gap.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'get-quote.php');

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
