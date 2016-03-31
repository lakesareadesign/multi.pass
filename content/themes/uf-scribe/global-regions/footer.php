<?php
/* START_REGION_OUTPUT */
$footer = upfront_create_region(
			array (
  'name' => 'footer',
  'title' => 'Footer',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'footer',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 60,
  'background_type' => 'color',
  'nav_region' => '',
  'background_color' => 'rgba(51,51,51,1)',
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
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
)
			);

$footer->add_group(array (
  'columns' => '5',
  'margin_left' => '1',
  'margin_right' => '0',
  'margin_top' => '3',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1424335523683-1633',
  'wrapper_id' => 'wrapper-1421730041154-1488',
  'type' => 'ModuleGroup',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 6,
      'clear' => true,
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
      'left' => 1,
      'col' => 5,
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

$footer->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414173076476-1425',
  'id' => 'module-1414173076476-1425',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: start;" class=""><span class="upfront_theme_color_0">Services</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414173076475-1146',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'row' => 8,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591792-1656',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 5,
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
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335523683-1633',
));

$footer->add_element("Unewnavigation", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '2',
  'margin_bottom' => '0',
  'class' => 'module-1419133617210-1555',
  'id' => 'module-1419133617210-1555',
  'options' =>
  array (
    'type' => 'UnewnavigationModel',
    'view_class' => 'UnewnavigationView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-navigation',
    'has_settings' => 1,
    'id_slug' => 'unewnavigation',
    'menu_items' =>
    array (
      0 =>
      (array)(array(
         'menu-item-db-id' => 33,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Custom Books',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '33',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 34,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Student Binding',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '34',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 35,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Boxes',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '35',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 36,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Restoration',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '36',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 37,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Hospitality',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '37',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 38,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Business Cards',
         'menu-item-url' => '{{upfront:home_url}}/service-business-cards/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '38',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/service-business-cards/',
           'target' => '',
        )),
      )),
    ),
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
      0 => 'no',
    ),
    'element_id' => 'unewnavigation-object-1419133617209-1645',
    'initialized' => false,
    'menu_id' => false,
    'menu_slug' => 'services',
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => 'footer-menu',
    'row' => 55,
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591799-1654',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 5,
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
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335523683-1633',
));

$footer->add_group(array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '3',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1424335508236-1827',
  'wrapper_id' => 'wrapper-1414934067025-1983',
  'type' => 'ModuleGroup',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 5,
      'clear' => false,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'col' => 6,
      'order' => 0,
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 1,
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

$footer->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414173132297-1300',
  'id' => 'module-1414173132297-1300',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: start;" class=""><span class="upfront_theme_color_0">Tuition</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414173132294-1061',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 9,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591811-1358',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 5,
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
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335508236-1827',
));

$footer->add_element("Unewnavigation", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '2',
  'margin_bottom' => '0',
  'class' => 'module-1419133633692-1449',
  'id' => 'module-1419133633692-1449',
  'options' =>
  array (
    'type' => 'UnewnavigationModel',
    'view_class' => 'UnewnavigationView',
    'usingNewAppearance' => true,
    'class' => 'c24 upfront-navigation',
    'has_settings' => 1,
    'id_slug' => 'unewnavigation',
    'menu_items' =>
    array (
      0 =>
      (array)(array(
         'menu-item-db-id' => 39,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #1',
         'menu-item-url' => '{{upfront:home_url}}/course1/',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '39',
         'menu-item-target' => '',
         'menu-item-position' => 1,
         'link' =>
        (array)(array(
           'type' => 'entry',
           'url' => '{{upfront:home_url}}/course1/',
           'target' => '',
        )),
      )),
      1 =>
      (array)(array(
         'menu-item-db-id' => 40,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #2',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '40',
         'menu-item-target' => '',
         'menu-item-position' => 2,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      2 =>
      (array)(array(
         'menu-item-db-id' => 41,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #3',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '41',
         'menu-item-target' => '',
         'menu-item-position' => 3,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      3 =>
      (array)(array(
         'menu-item-db-id' => 42,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #4',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '42',
         'menu-item-target' => '',
         'menu-item-position' => 4,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      4 =>
      (array)(array(
         'menu-item-db-id' => 43,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #5',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '43',
         'menu-item-target' => '',
         'menu-item-position' => 5,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
      5 =>
      (array)(array(
         'menu-item-db-id' => 44,
         'menu-item-parent-id' => '0',
         'menu-item-type' => 'custom',
         'menu-item-title' => 'Course #6',
         'menu-item-url' => '#',
         'menu-item-object' => 'custom',
         'menu-item-object-id' => '44',
         'menu-item-target' => '',
         'menu-item-position' => 6,
         'link' =>
        (array)(array(
           'type' => 'unlink',
           'url' => '#',
           'target' => '',
        )),
      )),
    ),
    'menu_style' => 'vertical',
    'menu_alignment' => 'left',
    'allow_sub_nav' =>
    array (
      0 => 'no',
    ),
    'allow_new_pages' =>
    array (
    ),
    'element_id' => 'unewnavigation-object-1419133633690-1146',
    'initialized' => false,
    'menu_slug' => 'tuition',
    'menu_id' => false,
    'burger_menu' =>
    array (
    ),
    'burger_alignment' => 'left',
    'burger_over' => 'over',
    'is_floating' =>
    array (
    ),
    'anchor' => '',
    'theme_style' => 'footer-menu',
    'breakpoint' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'burger_alignment' => 'left',
         'burger_over' => 'over',
         'menu_style' => 'vertical',
         'menu_alignment' => 'left',
         'is_floating' =>
        array (
        ),
         'width' => 1080,
      )),
    )),
    'row' => 41,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591817-1309',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 5,
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
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335508236-1827',
));

$footer->add_group(array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '3',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1424335461041-1793',
  'wrapper_id' => 'wrapper-1424335195103-1746',
  'type' => 'ModuleGroup',
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

$footer->add_element("PlainTxt", array (
  'columns' => '5',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414905614485-1363',
  'id' => 'module-1414905614485-1363',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: start;" class="upfront_theme_color_0"><span class="upfront_theme_color_0">Contact</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'object-1414905614485-1100',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'row' => 10,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591824-1201',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 6,
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
      'left' => 0,
      'col' => 6,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335461041-1793',
));

$footer->add_element("PlainTxt", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1424331624980-1433',
  'id' => 'module-1424331624980-1433',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<p class="">
	120 Bay Street
</p>
<p class="">
	Port Melbourne
</p>
<p class="">
	<span></span>3207
</p>
<p class="">
	<span></span>VIC
</p>
<p class="">
	<span></span>AUSTRALIA
</p>
<p class="">
	<span class="upfront_theme_color_1">+61-401-100-900 </span>
</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1424331624980-1618',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 44,
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591827-1942',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 5,
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
      'left' => 1,
      'col' => 4,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 5,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335461041-1793',
));

$footer->add_group(array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '3',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1424335541226-1839',
  'wrapper_id' => 'wrapper-1424335043679-1677',
  'type' => 'ModuleGroup',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 10,
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
      'left' => 2,
      'col' => 8,
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

$footer->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414172646650-1707',
  'id' => 'module-1414172646650-1707',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'usingNewAppearance' => true,
    'id_slug' => 'plain_text',
    'content' => '<h4 style="text-align: start;" class=""><span class="upfront_theme_color_0">News</span></h4>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414172646648-1657',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 10,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => '',
    'bg_color' => '',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 9,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591830-1226',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 8,
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
      'col' => 8,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'row' => 9,
      'top' => 0,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335541226-1839',
));

$footer->add_element("Posts", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '2',
  'margin_bottom' => '0',
  'class' => 'module-1419134466596-1228',
  'id' => 'module-1419134466596-1228',
  'options' =>
  array (
    'type' => 'PostsModel',
    'view_class' => 'PostsView',
    'usingNewAppearance' => true,
    'has_settings' => 1,
    'class' => 'c24 uposts-object',
    'id_slug' => 'posts',
    'display_type' => 'single',
    'list_type' => 'generic',
    'offset' => 1,
    'taxonomy' => '',
    'term' => '',
    'content' => 'excerpt',
    'limit' => 5,
    'pagination' => 'numeric',
    'sticky' => '',
    'posts_list' => '',
    'post_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'gravatar',
      3 => 'comment_count',
      4 => 'featured_image',
      5 => 'title',
      6 => 'content',
      7 => 'read_more',
      8 => 'tags',
      9 => 'categories',
    ),
    'enabled_post_parts' =>
    array (
      0 => 'featured_image',
      1 => 'title',
      2 => 'content',
      3 => 'read_more',
    ),
    'default_parts' =>
    array (
      0 => 'date_posted',
      1 => 'author',
      2 => 'gravatar',
      3 => 'comment_count',
      4 => 'featured_image',
      5 => 'title',
      6 => 'content',
      7 => 'read_more',
      8 => 'tags',
      9 => 'categories',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'categories_limit' => 3,
    'tags_limit' => 3,
    'comment_count_hide' => 0,
    'content_length' => '32',
    'resize_featured' =>
    array (
    ),
    'gravatar_size' => 200,
    'post-part-date_posted' => '<div class="uposts-part date_posted">
	Posted on <span class="date">{{date_1}}</span>, at <span class="time">{{date_2}}</span></div>',
    'post-part-author' => '<div class="uposts-part author">
	By <a href="{{url}}">{{name}}</a></div>',
    'post-part-gravatar' => '<div class="uposts-part gravatar">
	{{gravatar}}
</div>',
    'post-part-comment_count' => '<div class="uposts-part comment_count">
	{{comment_count}}
</div>',
    'post-part-featured_image' => '<div class="uposts-part thumbnail" data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'post-part-title' => '<div class="uposts-part title">
	<h3><a href="{{permalink}}" title="{{title}}">{{title}}</a></h3>
</div>',
    'post-part-content' => '<div class="uposts-part content">
	{{content}}
</div>',
    'post-part-read_more' => '<div class="uposts-part read_more">
	<a href="{{permalink}}">Read more</a></div>',
    'post-part-tags' => '<div class="uposts-part post_tags">
	{{tags}}
</div>',
    'post-part-categories' => '<div class="uposts-part post_categories">
	{{categories}}
</div>',
    'post-part-meta' => '<div class="uposts-part meta">

</div>
',
    'element_id' => 'posts-object-1419134466592-1693',
    'anchor' => '',
    'theme_style' => 'footer-news',
    'row' => 63,
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 52,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'wrapper_id' => 'wrapper-1444383591833-1957',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => false,
      'col' => 8,
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
      'col' => 8,
      'order' => 0,
    ),
    'mobile' =>
    array (
      'edited' => false,
      'left' => 0,
      'col' => 7,
      'row' => 52,
      'top' => 3,
      'order' => 0,
    ),
  ),
  'group' => 'module-group-1424335541226-1839',
));

$regions->add($footer);

/* END_REGION_OUTPUT */