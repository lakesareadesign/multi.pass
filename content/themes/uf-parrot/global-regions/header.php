<?php
/* START_REGION_OUTPUT */
$navigation = upfront_create_region(
			array (
  'name' => 'navigation',
  'title' => 'navigation',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'header',
  'sub' => 'left',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => 5,
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
  'background_color' => 'rgba(0,0,0,0)',
)
			);

$navigation->add_element("Uimage", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '13',
  'margin_bottom' => '0',
  'class' => 'module-1429723190869-1838',
  'id' => 'module-1429723190869-1838',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/header/logo-53x53-8169.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/header/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/header/logo.png',
    'image_title' => '',
    'alternative_text' => '',
    'when_clicked' => 'external',
    'image_link' => 'http:///',
    'include_image_caption' => false,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 53,
       'height' => 53,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 280,
       'height' => 280,
    )),
    'position' =>
    (array)(array(
       'top' => -7,
       'left' => -8.5,
    )),
    'marginTop' => 7,
    'element_size' =>
    (array)(array(
       'width' => 70,
       'height' => 65,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '109',
    'align' => 'center',
    'stretch' => false,
    'vstretch' => false,
    'quick_swap' => false,
    'gifImage' => 0,
    'placeholder_class' => '',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'usingNewAppearance' => true,
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'element_id' => 'image-1429723190862-1165',
    'row' => 17,
    'anchor' => '',
    'link_target' => '_self',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1429723445014-1393',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 7,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 5,
      'col' => 2,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 2,
      'col' => 3,
      'order' => 0,
    ),
  ),
));

$navigation->add_element("Unewnavigation", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '3',
  'margin_bottom' => '0',
  'class' => 'module-1429557374225-1939',
  'id' => 'module-1429557374225-1939',
  'options' =>
  array (
    'type' => 'UnewnavigationModel',
    'view_class' => 'UnewnavigationView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-navigation',
    'has_settings' => 1,
    'id_slug' => 'unewnavigation',
    'menu_items' => false,
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'element_id' => 'unewnavigation-object-1429557374224-1061',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'width' => 1080,
      )),
    )),
    'menu_id' => false,
    'menu_slug' => 'parrot-main-nav',
    'row' => 64,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1429558005324-1559',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 9,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 6,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 3,
      'col' => 6,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 1,
      'col' => 5,
      'order' => 0,
    ),
  ),
));

$regions->add($navigation);

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$region_e6c034 = upfront_create_region(
			array (
  'name' => 'header',
  'title' => 'Header Area',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
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
  'row' => 142,
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => 'bottom',
  ),
  'background_color' => '#ffffff',
  'background_slider_transition' => 'crossfade',
  'background_slider_rotate' => true,
  'background_slider_rotate_time' => 5,
  'background_slider_control' => 'always',
  'background_slider_images' =>
  array (
    0 => '/images/hero-2.jpg',
    1 => '/images/hero.jpg',
  ),
  'background_style' => 'full',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/global-regions/header/hero-1.jpg',
  'background_image_ratio' => 0.309999999999999997779553950749686919152736663818359375,
)
			);

$region_e6c034->add_group(array (
  'columns' => '5',
  'margin_left' => '2',
  'margin_right' => '0',
  'margin_top' => '4',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1430490040343-1057',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1430490090906-1064',
  'original_col' => 5,
  'row' => 12,
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 9,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 6,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 3,
      'col' => 6,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 1,
      'col' => 5,
      'order' => 0,
    ),
  ),
));

$region_e6c034->add_element("Uimage", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1429723190869-1838',
  'id' => 'module-1429723190869-1838',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/header/logo-53x53-8169.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/header/logo.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/header/logo.png',
    'image_title' => '',
    'alternative_text' => '',
    'when_clicked' => 'external',
    'image_link' => 'http:///',
    'include_image_caption' => false,
    'image_caption' => 'My awesome image caption',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 53,
       'height' => 53,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 280,
       'height' => 280,
    )),
    'position' =>
    (array)(array(
       'top' => -7,
       'left' => -8.5,
    )),
    'marginTop' => 7,
    'element_size' =>
    (array)(array(
       'width' => 70,
       'height' => 65,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => '109',
    'align' => 'center',
    'stretch' => false,
    'vstretch' => false,
    'quick_swap' => false,
    'gifImage' => 0,
    'placeholder_class' => '',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'usingNewAppearance' => true,
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'element_id' => 'image-1429723190862-1165',
    'row' => 17,
    'anchor' => '',
    'link_target' => '_self',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1430490040376-1207',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 2,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 4,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 2,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 1,
      'col' => 3,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1430490040343-1057',
));

$region_e6c034->add_element("Button", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '6',
  'margin_bottom' => '0',
  'class' => 'module-1429800012921-1982',
  'id' => 'module-1429800012921-1982',
  'options' =>
  array (
    'content' => '&nbsp;',
    'href' => '',
    'align' => 'center',
    'type' => 'ButtonModel',
    'view_class' => 'ButtonView',
    'usingNewAppearance' => true,
    'element_id' => 'button-object-1429800012920-1857',
    'class' => 'c24 upfront-button',
    'has_settings' => 1,
    'id_slug' => 'button',
    'currentpreset' => 'parrot-logo-green',
    'row' => 6,
    'theme_style' => '',
    'is_edited' => true,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1430490040377-1230',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 3,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'col' => 4,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 3,
      'order' => 1,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 1,
      'col' => 3,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1430490040343-1057',
));

$region_e6c034->add_element("Code", array (
  'columns' => '9',
  'margin_left' => '6',
  'margin_right' => '0',
  'margin_top' => '7',
  'margin_bottom' => '0',
  'class' => 'module-1429807657881-1121',
  'id' => 'module-1429807657881-1121',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'element_id' => 'upfront-code_element-object-1429807657881-1316',
    'row' => 14,
    'code_selection_type' => 'Create',
    'markup' => '<form name="newsletter" class="newsletter-form" action="" method="post">
    <input type="email" name="user-email" placeholder="Enter me when it\'s ready">
    <span class="newsletter-btn">
        <input type="submit" value="Submit">
    </span>
</form>',
    'style' => '.newsletter-form {
    position: relative;
    display: table;
    border-collapse: separate;
    width: 100%;
}
.newsletter-form input[type="email"] {
    width: 100%;
    padding: 12px 80px 12px 12px;
    font-size: 14px;
    line-height: 1.4;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #63c9e2;
    opacity: 0.6;
    border-radius: 4px 0 0 4px;
    display: table-cell;
    position: relative;
    float: left;
}
.newsletter-form input[type="email"]:focus {
    opacity: 1;
    outline: 0;
}
.newsletter-btn {
    white-space: nowrap;
    vertical-align: middle;
    font-size: 0;
    margin-left: -1px;
    position: absolute;
    right: 0;
}
.newsletter-form input[type="submit"] {
    background-color: #2a8a5e;
    color: #FFFFFF;
    border-radius: 0 4px 4px 0;
    border: 1px solid #2a8a5e;
    display: inline-block;
    padding: 12px 28px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.4;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    position: relative;
}
.newsletter-form input[type="submit"]:hover {
   background-color: #ufc1;
}',
    'script' => '/* Your code here */',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1430490114655-1282',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 11,
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
      'left' => 1,
      'col' => 10,
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

$region_e6c034->add_element("PlainTxt", array (
  'columns' => '20',
  'margin_left' => '2',
  'margin_right' => '0',
  'margin_top' => '19',
  'margin_bottom' => '0',
  'class' => 'module-1429800300014-1995',
  'id' => 'module-1429800300014-1995',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2" style="" rel=""><h1 style="text-align: center;"><span class="upfront_theme_color_2" data-verified="redactor" data-redactor-tag="span" data-redactor-class="upfront_theme_color_2"></span>Beautiful, simple and easy to use chat manager</h1></span>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1429800300014-1641',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 15,
    'is_edited' => true,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1430492007165-1252',
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

$region_e6c034->add_element("USlider", array (
  'columns' => '20',
  'margin_left' => '2',
  'margin_right' => '0',
  'margin_top' => '2',
  'margin_bottom' => '0',
  'class' => 'module-1430489284838-1089',
  'id' => 'module-1430489284838-1089',
  'options' =>
  array (
    'id_slug' => 'uslider',
    'type' => 'USliderModel',
    'view_class' => 'USliderView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-uslider',
    'has_settings' => 1,
    'primaryStyle' => 'below',
    'style' => 'below',
    'controls' => 'dots',
    'controlsWhen' => 'hover',
    'rotate' =>
    array (
      0 => 'true',
    ),
    'rotateTime' => 5,
    'transition' => 'crossfade',
    'slides' =>
    array (
      0 =>
      (array)(array(
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-devices-150x150.png',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-devices-300x113.png',
            1 => 300,
            2 => 113,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-devices.png',
            1 => 800,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-devices.png',
            1 => 800,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/global-regions/header/slide-devices-430x225-2860.png',
             'urlOriginal' => '{{upfront:style_url}}/images/global-regions/header/slide-devices.png',
             'full' =>
            (array)(array(
               'width' => 800,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 430,
               'height' => 225,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '430',
                 'height' => '225',
                 'left' => 85,
                 'top' => 0,
              )),
               'resize' =>
              (array)(array(
                 'width' => 600,
                 'height' => 225,
              )),
               'id' => 128,
               'element_id' => 'uslider-object-1430489284836-1867',
            )),
          )),
        )),
         'id' => '128',
         'srcFull' => '{{upfront:style_url}}/images/global-regions/header/slide-devices.png',
         'status' => 'ok',
         'src' => '{{upfront:style_url}}/images/global-regions/header/slide-devices-960x317-8159.png',
         'size' =>
        (array)(array(
           'width' => 1050,
           'height' => 394,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 960,
           'height' => 317,
        )),
         'cropOffset' =>
        (array)(array(
           'left' => 90,
           'top' => 13,
        )),
         'rotation' => 0,
         'url' => '',
         'urlType' => '',
         'text' => '<div data-tagblock="redactor" style="text-align: center;" class="nosortable"></div><span class="upfront_theme_color_5 nosortable"><div data-tagblock="redactor" style="text-align: center;" class="nosortable">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut leo. Duis vel nibh at velit scelerisque suscipit. Etiam feugiat lorem non metus.<span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable"></span></div><span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable"></span></span><span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable"></span>',
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'captionColor' => '#ffffff',
         'captionBackground' => '#000000',
         'style' => 'below',
         'rightImageWidth' => 3,
         'rightWidth' => 6,
      )),
      1 =>
      (array)(array(
         'sizes' =>
        (array)(array(
           'thumbnail' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-iphone-150x150.png',
            1 => 150,
            2 => 150,
            3 => true,
          ),
           'medium' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-iphone-300x113.png',
            1 => 300,
            2 => 113,
            3 => true,
          ),
           'large' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-iphone.png',
            1 => 800,
            2 => 300,
            3 => false,
          ),
           'full' =>
          array (
            0 => '{{upfront:style_url}}/images/global-regions/header/slide-iphone.png',
            1 => 800,
            2 => 300,
            3 => false,
          ),
           'custom' =>
          (array)(array(
             'error' => false,
             'url' => '{{upfront:style_url}}/images/global-regions/header/slide-iphone-790x277-1414.png',
             'urlOriginal' => '{{upfront:style_url}}/images/global-regions/header/slide-iphone.png',
             'full' =>
            (array)(array(
               'width' => 800,
               'height' => 300,
            )),
             'crop' =>
            (array)(array(
               'width' => 790,
               'height' => 277,
            )),
             'editdata' =>
            (array)(array(
               'rotate' => 0,
               'crop' =>
              (array)(array(
                 'width' => '790',
                 'height' => '277',
                 'left' => 0,
                 'top' => 9,
              )),
               'resize' =>
              (array)(array(
                 'width' => 790,
                 'height' => 296,
              )),
               'id' => 1706,
            )),
          )),
        )),
         'id' => '1706',
         'srcFull' => '{{upfront:style_url}}/images/global-regions/header/slide-iphone.png',
         'status' => 'ok',
         'src' => '{{upfront:style_url}}/images/global-regions/header/slide-iphone-952x317-3308.png',
         'size' =>
        (array)(array(
           'width' => 952,
           'height' => 357,
        )),
         'cropSize' =>
        (array)(array(
           'width' => 960,
           'height' => 317,
        )),
         'cropOffset' =>
        (array)(array(
           'left' => 0,
           'top' => 9,
        )),
         'rotation' => 0,
         'url' => '',
         'urlType' => '',
         'text' => '<div data-tagblock="redactor" style="text-align: center;" class="nosortable"></div><span class="upfront_theme_color_5 nosortable"><div data-tagblock="redactor" style="text-align: center;" class="nosortable">Donec posuere vulputate arcu. Vestibulum volutpat pretium libero. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi.<span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable">​</span></div><span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable"></span></span><span class="redactor-invisible-space nosortable" data-verified="redactor" data-redactor-tag="span" data-redactor-class="redactor-invisible-space nosortable"></span>',
         'margin' =>
        (array)(array(
           'left' => 0,
           'top' => 0,
        )),
         'captionColor' => '#ffffff',
         'captionBackground' => '#000000',
         'style' => 'bottomOver',
         'rightImageWidth' => 3,
         'rightWidth' => 6,
      )),
    ),
    'captionUseBackground' => '0',
    'captionBackground' => 'transparent',
    'rightImageWidth' => 3,
    'rightWidth' => 22,
    'element_id' => 'uslider-object-1430489284836-1867',
    'row' => 75,
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1430492059682-1962',
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

$regions->add($region_e6c034);

/* END_REGION_OUTPUT */
/* START_REGION_OUTPUT */
$header_bottom = upfront_create_region(
			array (
  'name' => 'header_bottom',
  'title' => 'Header Area bottom',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'header',
  'sub' => 'bottom',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
    )),
  )),
  'row' => 30,
  'background_type' => 'color',
  'use_padding' => 0,
  'background_color' => 'rgba(255,255,255,0.35)',
)
			);

$regions->add($header_bottom);

/* END_REGION_OUTPUT */