<?php
/* START_REGION_OUTPUT */
$region_b0e10e = upfront_create_region(
			array (
  'name' => 'header',
  'title' => 'Header',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'header',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 5,
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
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ufc0',
  'version' => '1.0.0',
)
			);

$region_b0e10e->add_element("Uimage", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453435671712-1880',
  'id' => 'module-1453435671712-1880',
  'options' =>
  array (
    'src' => '{{upfront:style_url}}/images/global-regions/header/logo-nav-75x35-3150.png',
    'srcFull' => '{{upfront:style_url}}/images/global-regions/header/logo-nav.png',
    'srcOriginal' => '{{upfront:style_url}}/images/global-regions/header/logo-nav.png',
    'image_title' => '',
    'alternative_text' => '',
    'include_image_caption' => false,
    'image_caption' => '<p>My awesome image caption</p>',
    'caption_position' => false,
    'caption_alignment' => false,
    'caption_trigger' => 'always_show',
    'image_status' => 'ok',
    'size' =>
    (array)(array(
       'width' => 75,
       'height' => 35,
    )),
    'fullSize' =>
    (array)(array(
       'width' => 75,
       'height' => 35,
    )),
    'position' =>
    (array)(array(
       'top' => 0,
       'left' => 0,
    )),
    'marginTop' => 0,
    'element_size' =>
    (array)(array(
       'width' => 105,
       'height' => 30,
    )),
    'rotation' => 0,
    'color' => '#ffffff',
    'background' => '#000000',
    'captionBackground' => '0',
    'image_id' => 25,
    'align' => 'left',
    'stretch' => false,
    'vstretch' => true,
    'quick_swap' => false,
    'is_locked' => true,
    'gifImage' => 0,
    'placeholder_class' => '',
    'preset' => 'default',
    'display_caption' => 'showCaption',
    'type' => 'UimageModel',
    'view_class' => 'UimageView',
    'has_settings' => 1,
    'class' => 'c24 upfront-image',
    'id_slug' => 'image',
    'when_clicked' => false,
    'image_link' => '',
    'link' =>
    (array)(array(
       'type' => 'homepage',
       'url' => '{{upfront:home_url}}',
       'target' => false,
    )),
    'element_id' => 'image-1453435671708-1574',
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'row' => 12,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
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
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453435708433-1472',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 4,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 4,
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
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$region_b0e10e->add_element("Unewnavigation", array (
  'columns' => '17',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452574180065-1300',
  'id' => 'module-1452574180065-1300',
  'options' =>
  array (
    'type' => 'UnewnavigationModel',
    'view_class' => 'UnewnavigationView',
    'class' => 'c24 upfront-navigation',
    'has_settings' => 1,
    'id_slug' => 'unewnavigation',
    'menu_items' =>
    array (
      0 =>
      (array)(array(
         'menu-item-db-id' => 294,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'SERVICES',
         'menu-item-url' => '{{upfront:home_url}}/services/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '294',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/services/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 295,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'ABOUT',
         'menu-item-url' => '{{upfront:home_url}}/about/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '295',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/about/',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 296,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'TESTIMONIALS',
         'menu-item-url' => '{{upfront:home_url}}/testimonials/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '296',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/testimonials/',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 297,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'GALLERY',
         'menu-item-url' => '{{upfront:home_url}}/gallery/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '297',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/gallery/',
           'target' => '',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 298,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'BLOG',
         'menu-item-url' => '{{upfront:home_url}}/blog/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '298',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/blog/',
           'target' => '',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 299,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'CONTACT US',
         'menu-item-url' => '{{upfront:home_url}}/contactus/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '299',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/contactus/',
           'target' => '',
        )),
      )),
    ),
    'preset' => 'default',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'element_id' => 'unewnavigation-object-1452574180059-1299',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'menu_slug' => 'main-menu',
    'menu_id' => false,
    'theme_style' => '',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'row' => 6,
    'usingNewAppearance' => true,
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'row' => 12,
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '15',
         'top_padding_num' => '15',
      )),
    )),
    'current_preset' => 'default',
    'breakpoint_menu_id' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'menu_id' => 27,
         'menu_slug' => 'main-menu',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452574228749-1830',
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
      'col' => 3,
      'order' => 1,
      'clear' => false,
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
      'row' => 12,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 3,
      'order' => 0,
      'top' => 0,
    ),
  ),
));

$region_b0e10e->add_element("Code", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452574180089-1476',
  'id' => 'module-1452574180089-1476',
  'options' =>
  array (
    'type' => 'CodeModel',
    'view_class' => 'CodeView',
    'class' => 'c24 upfront-code_element-object',
    'has_settings' => 0,
    'id_slug' => 'upfront-code_element',
    'fallbacks' =>
    (array)(array(
       'markup' => '<b>Enter your markup here...</b>',
       'style' => '/* Your styles here */',
       'script' => '/* Your code here */',
    )),
    'element_id' => 'upfront-code_element-object-1452574180088-1304',
    'top_padding_num' => '15',
    'bottom_padding_num' => '10',
    'code_selection_type' => 'Create',
    'markup' => '<ul class="socials">
  <li><a class="social-icon youtube" href="http://youtube.com" target="_blank"></a></li>
  <li><a class="social-icon facebook" href="http://facebook.com" target="_blank"></a></li>
  <li><a class="social-icon twitter" href="http://twitter.com" target="_blank"></a></li>
</ul>',
    'style' => '/* Your styles here */
.socials {
    height: 34px;
    list-style: none;
    padding: 0px;
    margin: 0;
    text-align: right;
}
.socials li {
    display: inline-block;
}
.socials li a {
    display: block;
    width: 35px;
    height: 34px;
    margin: 0 5px;
}

.social-icon:before {
    content: "";
    background: url("{{upfront:style_url}}/ui/sprite.png");
    background-image: url("{{upfront:style_url}}/ui/sprite.svg"), none;
    width: 35px;
    height: 35px;
    display: block;
}

.youtube:before {
 background-position: -63px -222px;
}
 .youtube:hover:before,  .youtube.dark { background-position: -223px -222px;
}
 .facebook:before {
 background-position: -63px -383px;
}
 .facebook:hover:before,  .facebook.dark { background-position: -223px -383px;
}
 .twitter:before {
 background-position: -63px -543px;
}
 .twitter:hover:before,  .twitter.dark { background-position: -223px -543px;
}',
    'script' => '/* Your code here */',
    'row' => 5,
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'current_preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'lock_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452574716523-1923',
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
      'hide' => 1,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'hide' => 1,
    ),
  ),
));

$regions->add($region_b0e10e);

/* END_REGION_OUTPUT */