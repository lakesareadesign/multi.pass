<?php
/* START_REGION_OUTPUT */
$ltb_ny_map11 = upfront_create_region(
			array (
  'name' => 'ltb-ny-map11',
  'title' => 'NY Map',
  'type' => 'lightbox',
  'scope' => 'local',
  'container' => 'lightbox',
  'sub' => 'lightbox',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => '24',
  'height' => '400',
  'click_out_close' => 'yes',
  'show_close' => 'yes',
  'overlay_color' => 'rgba(248, 254, 255, 0.901961)',
  'lightbox_color' => 'rgb(255, 255, 255)',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 12,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 7,
    )),
  )),
  'background_type' => '',
  'use_padding' => 0,
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'delete' => false,
  'version' => '1.0.0',
)
			);

$ltb_ny_map11->add_element("Umap", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1452141743852-1501',
  'id' => 'module-1452141743852-1501',
  'options' =>
  array (
    'type' => 'MapModel',
    'view_class' => 'UmapView',
    'class' => 'c24 upfront-map_element-object',
    'has_settings' => 1,
    'id_slug' => 'upfront-map_element',
    'controls' =>
    array (
      0 => 'pan',
      1 => 'zoom',
      2 => 'overview_map',
    ),
    'map_center' =>
    array (
      0 => 40.7558858000000014953911886550486087799072265625,
      1 => -73.993710899999996399856172502040863037109375,
    ),
    'zoom' => '14',
    'style' => 'ROADMAP',
    'styles' => false,
    'draggable' => '',
    'scrollwheel' => false,
    'fallbacks' =>
    (array)(array(
       'script' => '/* Your code here */',
    )),
    'usingNewAppearance' => true,
    'element_id' => 'upfront-map_element-object-1452141743851-1956',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'markers' =>
    array (
      0 =>
      (array)(array(
         'lat' => 40.7558858000000014953911886550486087799072265625,
         'lng' => -73.993710899999996399856172502040863037109375,
      )),
    ),
    'address' => '350 W 39th Street New York',
    'row' => 84,
    'location' => '350 W 39th Street New York',
    'hide_markers' => '',
    'use_custom_map_code' => '1',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '10',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'script' => '[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
    'map_styles' => '[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1452141828726-1397',
  'new_line' => true,
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

$regions->add($ltb_ny_map11);

/* END_REGION_OUTPUT */