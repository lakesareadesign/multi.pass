<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$post_breadcrumbs = upfront_create_region(
			array (
  'name' => 'post-breadcrumbs',
  'title' => 'Post Breadcrumbs',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'post-breadcrumbs',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 11,
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
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_type' => 'color',
  'background_color' => '#ffffff',
  'bg_padding_type' => 'equal',
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_num' => 0,
  'region_role' => 'complementary',
)
			);

$post_breadcrumbs->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453832287772-1403',
  'id' => 'module-1453832287772-1403',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<p><a target="_self" data-upfront-link-type="homepage" href="{{upfront:home_url}}">HOME</a> / <a href="{{upfront:home_url}}/blog/" target="_self" data-upfront-link-type="entry">BLOG</a> / POST</p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453832287771-1485',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '15',
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '15',
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
    'is_edited' => true,
    'row' => 7,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'left_padding_num' => '15',
         'top_padding_num' => '15',
         'right_padding_num' => '15',
         'bottom_padding_num' => '15',
         'top_padding_use' => '',
         'bottom_padding_use' => '',
         'left_padding_use' => 'yes',
         'right_padding_use' => 'yes',
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '15',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457708207142-1945',
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

$regions->add($post_breadcrumbs);

$post_title = upfront_create_region(
			array (
  'name' => 'post-title',
  'title' => 'Post Title',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'post-title',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'version' => '1.0.0',
  'row' => 28,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '40',
       'top_bg_padding_num' => '40',
       'row' => 19,
       'bottom_bg_padding_num' => '4',
       'bottom_bg_padding_slider' => '4',
    )),
     'mobile' =>
    (array)(array(
       'edited' => true,
       'col' => 24,
       'background_type' => 'color',
       'top_bg_padding_slider' => '45',
       'top_bg_padding_num' => '45',
       'bottom_bg_padding_slider' => '4',
       'bottom_bg_padding_num' => '4',
       'row' => 18,
    )),
     'current_property' => 'top_bg_padding_slider',
  )),
  'background_type' => 'color',
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => false,
  ),
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '120',
  'top_bg_padding_num' => '120',
  'bottom_bg_padding_slider' => '9',
  'bottom_bg_padding_num' => '9',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_color' => '#ffffff',
  'region_role' => 'main',
)
			);

$post_title->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458623080461-1435 upfront-module-spacer',
  'id' => 'module-1458623080461-1435',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458623080460-1486',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458623080459-1321',
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

$post_title->add_group(array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1457707870756-1334',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1457708223827-1154',
  'original_col' => 22,
  'top_padding_num' => '0',
  'bottom_padding_num' => '0',
  'edited' => true,
  'background_color' => 'rgba(0,0,0,0)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_slider' => '0',
  'bottom_padding_use' => 'yes',
  'bottom_padding_slider' => '0',
  'row' => 11,
  'background_default' => 'color',
  'lock_padding' => '',
  'href' => '',
  'linkTarget' => false,
  'left_padding_num' => 0,
  'right_padding_num' => 0,
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
      'top' => 0,
      'row' => 9,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 13,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
));

$post_title->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457583396122-1405',
  'id' => 'module-1457583396122-1405',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'title-only',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1457583396120-1772',
    'top_padding_num' => '15',
    'bottom_padding_num' => '6',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'title-only',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '5',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .upostdata-part.title h1 {
    letter-spacing: -0.2px;
    text-transform: uppercase;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Oswald',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-weight' => '300',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '15',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc2',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Open Sans',
    'static-title-fontstyle' => '700 normal',
    'static-title-weight' => '700',
    'static-title-style' => 'normal',
    'static-title-font-size' => '25',
    'static-title-line-height' => '1.3',
    'static-title-font-color' => '#ufc7',
    'hidden_parts' =>
    array (
      0 => 'title',
    ),
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 6,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'theme_style' => '',
    'theme_preset' => 'true',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457707870761-1317',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 8,
      'order' => 0,
      'clear' => true,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'col' => 5,
      'order' => 0,
      'clear' => true,
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
      'col' => 8,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 6,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'close_wrapper' => false,
  'group' => 'module-group-1457707870756-1334',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-title',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1457583396115-1244',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457583396115-1051',
      'padding_slider' => '15',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 8,
        ),
        'mobile' =>
        array (
          'col' => 5,
        ),
      ),
      'use_padding' => 'yes',
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 8,
          'order' => 0,
          'row' => 4,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 5,
          'order' => 0,
          'row' => 7,
        ),
      ),
    ),
  ),
));

$post_title->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457583900472-1405',
  'id' => 'module-1457583900472-1405',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-author',
    'id_slug' => 'post-data',
    'data_type' => 'author',
    'preset' => 'the-author',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'author',
      1 => 'gravatar',
      2 => 'author_email',
      3 => 'author_url',
      4 => 'author_bio',
    ),
    'gravatar_size' => 200,
    'post-part-author' => '<div class="upostdata-part author">
	By <a href="{{url}}" {{target}}>{{name}}</a></div>',
    'post-part-gravatar' => '<div class="upostdata-part gravatar">
	{{gravatar}}
</div>',
    'post-part-author_email' => '<div class="upostdata-part author author-email">
	<a href="mailto:{{email}}">{{name}}</a>
</div>',
    'post-part-author_url' => '<div class="upostdata-part author author-url">
	<a href="{{url}}" rel="author external">{{name}}</a>
</div>',
    'post-part-author_bio' => '<div class="upostdata-part author author-bio">
	{{bio}}
</div>',
    'element_id' => 'post-data-object-1457583900470-1758',
    'top_padding_num' => '0',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'the-author',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'preset_style' => '#page .default.upost-data-object-author .upostdata-part.author {
    letter-spacing: 0.2px;
    text-transform: uppercase;
}
',
    'static-gravatar-lock' => 'yes',
    'link' => 'author',
    'static-author-use-typography' => 'yes',
    'static-author-font-family' => 'Oswald',
    'static-author-fontstyle' => '300 normal',
    'static-author-weight' => '300',
    'static-author-style' => 'normal',
    'static-author-font-size' => '15',
    'static-author-line-height' => '1.3',
    'static-author-font-color' => '#ufc2',
    'static-gravatar-use-border' => 'yes',
    'static-gravatar-border-width' => '1',
    'static-gravatar-border-type' => 'solid',
    'static-gravatar-border-color' => '#ufc0',
    'static-gravatar-use-radius' => 'yes',
    'static-gravatar-radius1' => '100',
    'static-gravatar-radius2' => '100',
    'static-gravatar-radius3' => '100',
    'static-gravatar-radius4' => '100',
    'static-gravatar-radius' => '100',
    'static-gravatar-radius_number' => '100',
    'email_link_text' => 'SEND EMAIL',
    'static-author_email-use-typography' => 'yes',
    'static-author_email-font-family' => 'Oswald',
    'static-author_email-fontstyle' => '300 normal',
    'static-author_email-weight' => '300',
    'static-author_email-style' => 'normal',
    'static-author_email-font-size' => '15',
    'static-author_email-line-height' => '1.3',
    'static-author_email-font-color' => '#ufc0',
    'link_text' => 'Website',
    'target' =>
    array (
      0 => '_blank',
    ),
    'static-author_url-use-typography' => 'yes',
    'static-author_url-font-family' => 'Oswald',
    'static-author_url-fontstyle' => '300 normal',
    'static-author_url-weight' => '300',
    'static-author_url-style' => 'normal',
    'static-author_url-font-size' => '15',
    'static-author_url-line-height' => '1.3',
    'static-author_url-font-color' => '#ufc0',
    'static-author_bio-use-typography' => 'yes',
    'static-author_bio-font-family' => 'Open Sans',
    'static-author_bio-fontstyle' => 'regular',
    'static-author_bio-weight' => '400',
    'static-author_bio-style' => 'normal',
    'static-author_bio-font-size' => '14',
    'static-author_bio-line-height' => '1.2',
    'static-author_bio-font-color' => '#ufc7',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'theme_preset' => 'true',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 6,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457707870761-1317',
  'new_line' => true,
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 8,
      'order' => 0,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 5,
      'order' => 0,
      'top' => 0,
      'row' => 6,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1457707870756-1334',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-author',
      'view_class' => 'PostDataPartView',
      'part_type' => 'author',
      'wrapper_id' => 'wrapper-1457583900448-1955',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457583900460-1991',
      'padding_slider' => '15',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 8,
        ),
        'mobile' =>
        array (
          'col' => 5,
        ),
      ),
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 4,
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 8,
          'order' => 0,
          'row' => 6,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 5,
          'order' => 0,
          'row' => 6,
        ),
      ),
    ),
  ),
));

$post_title->add_element("PostData", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457583415709-1082',
  'id' => 'module-1457583415709-1082',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'the-day',
    'row' => 5,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1457583415707-1875',
    'top_padding_num' => '5',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'the-day',
      )),
    )),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '10',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .upostdata-part.title h1 {
    letter-spacing: -0.2px;
    text-transform: uppercase;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Oswald',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-weight' => '300',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '15',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc2',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Open Sans',
    'static-title-fontstyle' => '700 normal',
    'static-title-weight' => '700',
    'static-title-style' => 'normal',
    'static-title-font-size' => '25',
    'static-title-line-height' => '1.3',
    'static-title-font-color' => '#ufc7',
    'hidden_parts' =>
    array (
      0 => 'title',
    ),
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'theme_preset' => 'true',
    'top_padding_use' => 'yes',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457707870763-1669',
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
      'col' => 2,
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
      'col' => 4,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 0,
      'top' => 0,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'close_wrapper' => false,
  'group' => 'module-group-1457707870756-1334',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '4',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1457583415701-1948',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457583415702-1310',
      'padding_slider' => '15',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 4,
        ),
        'mobile' =>
        array (
          'col' => 2,
        ),
      ),
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 5,
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 4,
          'order' => 0,
          'row' => 4,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 2,
          'order' => 0,
          'row' => 4,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$post_title->add_element("PostData", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457585984496-1424',
  'id' => 'module-1457585984496-1424',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'the-month',
    'row' => 4,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1457585984494-1654',
    'top_padding_num' => '7',
    'bottom_padding_num' => '0',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'the-month',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '5',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .upostdata-part.title h1 {
    letter-spacing: -0.2px;
    text-transform: uppercase;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Oswald',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-weight' => '300',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '15',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc2',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Open Sans',
    'static-title-fontstyle' => '700 normal',
    'static-title-weight' => '700',
    'static-title-style' => 'normal',
    'static-title-font-size' => '25',
    'static-title-line-height' => '1.3',
    'static-title-font-color' => '#ufc7',
    'hidden_parts' =>
    array (
      0 => 'title',
    ),
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'theme_preset' => 'true',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 4,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457707870763-1669',
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 4,
      'order' => 1,
      'top' => 0,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 2,
      'order' => 1,
      'top' => 0,
      'row' => 4,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
  'group' => 'module-group-1457707870756-1334',
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '4',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-date_posted',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1457585984487-1743',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1457585984489-1037',
      'padding_slider' => '15',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 4,
        ),
        'mobile' =>
        array (
          'col' => 2,
        ),
      ),
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 4,
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 4,
          'order' => 0,
          'row' => 6,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 2,
          'order' => 0,
          'row' => 4,
          'use_padding' => 'yes',
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$post_title->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458623084632-1630 upfront-module-spacer',
  'id' => 'module-1458623084632-1630',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458623084631-1650',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458623084631-1671',
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

$regions->add($post_title);

$post_content = upfront_create_region(
			array (
  'name' => 'post-content',
  'title' => 'Post Content',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'post-content',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 140,
  'background_type' => 'color',
  'background_color' => '#ufc6',
  'version' => '1.0.0',
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
       'background_type' => 'color',
    )),
     'current_property' => 'background_type',
  )),
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
  'region_role' => 'main',
)
			);

$post_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457708814141-1183 upfront-module-spacer',
  'id' => 'module-1457708814141-1183',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457708814140-1388',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457708814139-1584',
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

$post_content->add_element("PostData", array (
  'columns' => '20',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458595452534-1938',
  'id' => 'module-1458595452534-1938',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-featured_image',
    'id_slug' => 'post-data',
    'data_type' => 'featured_image',
    'preset' => 'default',
    'row' => 66,
    'type_parts' =>
    array (
      0 => 'featured_image',
    ),
    'full_featured_image' => '0',
    'hide_featured_image' => '0',
    'fallback_image' => '{{upfront:style_url}}/images/single-post/featured-image-vertical-1.jpg',
    'fallback_color' => 'rgb(105, 168, 166)',
    'fallback_hide' => '0',
    'fallback_option' => 'hide',
    'post-part-featured_image' => '<div class="upostdata-part thumbnail" {{fallback}} data-resize="{{resize}}">
	{{thumbnail}}
</div>',
    'preset_style' => '#page .default.upost-data-object-featured_image .thumbnail:before {
    content: "";
    height: 1px;
    display: block;
    margin-bottom: 45px;
    background: /*#ufc4*/#e2ded5;
}
',
    'resize_featured' => '1',
    'theme_preset' => 'true',
    'static-featured_image-border-width' => '1',
    'static-featured_image-border-type' => 'solid',
    'static-featured_image-border-color' => '#ufc4',
    'element_id' => 'post-data-object-1458595452531-1458',
    'top_padding_num' => '0',
    'bottom_padding_num' => '30',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '30',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 29,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '20',
      )),
       'tablet' =>
      (array)(array(
         'row' => 42,
         'use_padding' => 'yes',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '20',
         'bottom_padding_num' => '34',
         'top_padding_num' => '0',
         'left_padding_num' => '15',
         'right_padding_num' => '15',
         'top_padding_use' => 'yes',
         'left_padding_use' => 'yes',
         'right_padding_use' => 'yes',
      )),
       'current_property' => 'lock_padding',
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1457586698750-1826',
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
      'row' => 42,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 29,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '20',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-featured_image',
      'view_class' => 'PostDataPartView',
      'part_type' => 'featured_image',
      'wrapper_id' => 'wrapper-1458595452528-1843',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458595452529-1411',
      'row' => 66,
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'row' => 42,
          'use_padding' => 'yes',
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'row' => 29,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$post_content->add_element("Uspacer", array (
  'columns' => '2',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1457708817057-1710 upfront-module-spacer',
  'id' => 'module-1457708817057-1710',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1457708817056-1801',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1457708817055-1190',
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

$post_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458625676431-1336 upfront-module-spacer',
  'id' => 'module-1458625676431-1336',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458625676430-1028',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458625676429-1664',
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

$post_content->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458625653475-1755',
  'id' => 'module-1458625653475-1755',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'content-only',
    'row' => 100,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'preset_style' => '#page .default.upost-data-object-post_data .upostdata-part.date_posted {
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
#page .default.upost-data-object-post_data .upostdata-part.title h1 {
    letter-spacing: -0.2px;
    text-transform: uppercase;
}
',
    'predefined_date_format' => '0',
    'static-date_posted-use-typography' => 'yes',
    'static-date_posted-font-family' => 'Oswald',
    'static-date_posted-fontstyle' => '300 normal',
    'static-date_posted-weight' => '300',
    'static-date_posted-style' => 'normal',
    'static-date_posted-font-size' => '15',
    'static-date_posted-line-height' => '1.3',
    'static-date_posted-font-color' => '#ufc2',
    'static-title-use-typography' => 'yes',
    'static-title-font-family' => 'Open Sans',
    'static-title-fontstyle' => '700 normal',
    'static-title-weight' => '700',
    'static-title-style' => 'normal',
    'static-title-font-size' => '25',
    'static-title-line-height' => '1.3',
    'static-title-font-color' => '#ufc7',
    'theme_preset' => 'true',
    'element_id' => 'post-data-object-1458625653472-1720',
    'top_padding_num' => '0',
    'bottom_padding_num' => '15',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'content-only',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'content-only-for-tablet',
      )),
    )),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '0',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 189,
         'use_padding' => 'yes',
      )),
       'tablet' =>
      (array)(array(
         'row' => 119,
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
    )),
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458625660140-1402',
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
      'edited' => true,
      'left' => 0,
      'col' => 12,
      'order' => 0,
      'row' => 119,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 189,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1458702087007-1772',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458702087009-1767',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'preset' => 'default',
      'row' => 100,
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
          'row' => 119,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
          'row' => 189,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$post_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458625680313-1273 upfront-module-spacer',
  'id' => 'module-1458625680313-1273',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458625680313-1019',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458625680312-1430',
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

$post_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458430907222-1364 upfront-module-spacer',
  'id' => 'module-1458430907222-1364',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458430907221-1193',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458430907220-1637',
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

$post_content->add_element("PostData", array (
  'columns' => '18',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458430613171-1235',
  'id' => 'module-1458430613171-1235',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-comments',
    'id_slug' => 'post-data',
    'data_type' => 'comments',
    'preset' => 'simple-comments',
    'row' => 2520,
    'type_parts' =>
    array (
      0 => 'comment_count',
      1 => 'comments',
      2 => 'comments_pagination',
      3 => 'comment_form',
    ),
    'comment_count_hide' => 0,
    'disable_showing' =>
    array (
      0 => 'trackbacks',
    ),
    'disable' =>
    array (
      0 => 'trackbacks',
      1 => 'comments',
    ),
    'order' => 'comment_date_gmt',
    'direction' => 'DESC',
    'limit' => 50,
    'paginated' => 0,
    'post-part-comment_count' => '<div class="upostdata-part comment_count">
	{{comment_count||No comments}}
</div>',
    'post-part-comments' => '<div class="upostdata-part comments">
	{{comments}}
</div>',
    'post-part-comments_pagination' => '<div class="upostdata-part comments comments_pagination">
	{{pagination}}
</div>',
    'post-part-comment_form' => '<div class="upostdata-part comment_form">
	{{comment_form}}
</div>',
    'element_id' => 'post-data-object-1458430613168-1645',
    'top_padding_num' => '30',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'lock_padding' => '',
    'padding_slider' => '15',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'anchor' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'simple-comments',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'comments-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'comments-mobile',
      )),
    )),
    'static-comment_count-use-typography' => 'yes',
    'static-comment_count-font-family' => 'Oswald',
    'static-comment_count-weight' => '400',
    'static-comment_count-fontstyle' => 'regular',
    'static-comment_count-style' => 'normal',
    'static-comment_count-font-size' => '16',
    'static-comment_count-line-height' => '2',
    'static-comment_count-font-color' => '#ufc5',
    'static-comments-use-typography' => 'yes',
    'static-comments-font-family' => 'Open Sans',
    'static-comments-weight' => '300',
    'static-comments-fontstyle' => '300 normal',
    'static-comments-style' => 'normal',
    'static-comments-font-size' => '16',
    'static-comments-line-height' => '2',
    'static-comments-font-color' => '#ufc5',
    'static-comments_pagination-use-typography' => '',
    'static-comments_pagination-font-family' => 'Open Sans',
    'static-comments_pagination-weight' => '300',
    'static-comments_pagination-fontstyle' => '300 normal',
    'static-comments_pagination-style' => 'normal',
    'static-comments_pagination-font-size' => '16',
    'static-comments_pagination-line-height' => '2',
    'static-comments_pagination-font-color' => '#ufc0',
    'static-comment_form-use-typography' => '',
    'static-comment_form-font-family' => 'Open Sans',
    'static-comment_form-weight' => '300',
    'static-comment_form-fontstyle' => '300 normal',
    'static-comment_form-style' => 'normal',
    'static-comment_form-font-size' => '16',
    'static-comment_form-line-height' => '2',
    'static-comment_form-font-color' => '#ufc5',
    'preset_style' => '#page .default.upost-data-object-comments  .upfront-comments {
    list-style: none;
    margin: 0 0 60px 0;
    padding: 0;
}
#page .default.upost-data-object-comments  .upfront-comments ol.children {
    margin-left: 45px;
}
#page .default.upost-data-object-comments li.comment {
    list-style-type: none;
    margin: 10px 0 0;
    overflow: hidden;
}
#page .default.upost-data-object-comments li.comment.depth-1:first-child {
    margin-top: 0;
}
#page .default.upost-data-object-comments article {
    overflow: hidden;
}
#page .default.upost-data-object-comments .comment-wrapper {
    background-color: #f2f2f2;
    overflow: hidden;
    padding: 30px;
    border-radius: 4px;
}
#page .default.upost-data-object-comments .comment-avatar {
    float: left;
    max-height: 75px;
    margin-right: 30px;
}
#page .default.upost-data-object-comments .comment-avatar img {
    background: /*#ufc6*/#ffffff;
    box-sizing: border-box;
    padding: 2px;
    border: 1px solid /*#ufc0*/#69a8a6;
    border-radius: 50%;
    height: 75px;
    width: 75px;
}
#page .default.upost-data-object-comments .comment-content-wrapper {
    float: left;
    width: 100%;
}
#page .default.upost-data-object-comments .depth-2 .comment-content-wrapper {
    width: 100%;
}
#page .default.upost-data-object-comments  .depth-3 .comment-content-wrapper {
    width: 100%;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-author .fn, #page .default.upost-data-object-comments  .upfront-comments .comment-author a {
    color: /*#ufc7*/#333333;
    font-size: 18px;
    font-style: normal;
    font-weight: 600;
    line-height: 25px;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-author a:hover {
    color: /*#ufc5*/#666666;
    font-weight: 600;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time {
    margin-top:-10px;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time a {
    color: /*#ufc2*/#a89084;
    font-size: 13px;
    font-weight: 300;
    line-height: 25px;
}
#page .default.upost-data-object-comments  .upfront-comments .comment-time a:hover {
    text-decoration: underline;
}
#page .default.upost-data-object-comments .comment-content p:last-child {
    margin: 0;
}
#page .default.upost-data-object-comments  .edit-link {
    margin-bottom: 0;
}
#page .default.upost-data-object-comments  .comment-edit-link {
    font-size: 13px;
    font-weight: 400;
    line-height: 25px;
}
#page .default.upost-data-object-comments  .comment-edit-link:hover {
    font-weight: 400;
}
#page .default.upost-data-object-comments .comment-meta-actions {
    margin-top: 5px;
    overflow: hidden;
}
#page .default.upost-data-object-comments  p.comment-awaiting-moderation {
    float: left;
    font-size: 14px;
    font-style: italic;
    line-height: 25px;
    margin-bottom: 0;
    max-width: 75%;
    width: 100%;
}
#page .default.upost-data-object-comments  p.comment-awaiting-moderation + .comment-reply {
    float: left;
    max-width: 25%;
}
#page .default.upost-data-object-comments .comment-reply {
    text-align: right;
    width: 100%;
    font-size: 13px;
}
#page .default.upost-data-object-comments .comment-reply a {
    line-height: 25px;
    font-weight: 400;
}
#page .default.upost-data-object-comments .comment-reply a:hover {
    font-weight: 400;
}
#page .default.upost-data-object-comments #respond {
    border-top: 1px solid /*#ufc4*/#e2ded5;
    padding-top: 30px;
}
#page .default.upost-data-object-comments h3.comment-reply-title {
    font-size: 22px;
    line-height: 30px;
    margin: 0;
    margin-bottom:5px;
}
#page .default.upost-data-object-comments h3.comment-reply-title a {
    color: /*#ufc0*/#69a8a6;
    text-transform: none;
}
#page .default.upost-data-object-comments h3.comment-reply-title small {
    display: block;
}
#page .default.upost-data-object-comments #cancel-comment-reply-link {
    color: /*#ufc2*/#a89084;
    font-size: 16px;
    line-height: 25px;
}
#page .default.upost-data-object-comments #cancel-comment-reply-link:hover {
    color: /*#ufc0*/#69a8a6;
}
#page .default.upost-data-object-comments p.logged-in-as {
    color: /*#ufc7*/#333333;
    font-size: 15px;
    line-height: 25px;
}
#page .default.upost-data-object-comments #commentform {
    margin-top: 0;
}
#page .default.upost-data-object-comments .comment-form input[type="text"], #page .default.upost-data-object-comments .comment-form textarea {
    border: 1px solid #d0d0d0;
    border-radius: 4px;
    box-sizing: border-box;
    color: #707070;
    font-family: "Open Sans", Arial, sans-serif;
    font-size: 15px;
    line-height: 30px;
    -webkit-transition: border-color .2s;
    transition: border-color .2s;
    width: 100%;
}
#page .default.upost-data-object-comments .comment-form input[type="text"] {
    padding: 5px 15px;
}
#page .default.upost-data-object-comments .comment-form textarea {
    padding: 10px 15px;
}
#page .default.upost-data-object-comments .comment-form input[type="text"]:focus, #page .default.upost-data-object-comments .comment-form textarea:focus {
    border-color: /*#ufc0*/#69a8a6;
    color: #ufc8;
}
#page .default.upost-data-object-comments .comment-form label {
    color: /*#ufc7*/#333333;
    font-size: 15px;
    font-weight: 400;
    display: block;
    line-height: 30px;
    letter-spacing: -0.5px;
    margin-bottom: 5px
}
#page .default.upost-data-object-comments .comment-form-comment label {
    display: none;
}
#page .default.upost-data-object-comments  p.comment-form-author, #page .default.upost-data-object-comments  p.comment-form-email, #page .default.upost-data-object-comments  p.comment-form-url {
    float: left;
    margin-left: 2%;
    width: 32%;
}
#page .default.upost-data-object-comments  p.comment-form-author {
    margin-left: 0;
}
#page .default.upost-data-object-comments p.comment-form-comment {
    clear: both;
}
#page .default.upost-data-object-comments  p.comment-notes {
    color: /*#ufc7*/#333333;
    font-size: 12px;
    line-height: 25px;
    margin-bottom: 15px;
}
#page .default.upost-data-object-comments p.form-submit {
    margin: 0;
    text-align: right;
}
#page .default.upost-data-object-comments input.submit {
    background: /*#ufc0*/#69a8a6;
    border-bottom: 3px solid /*#ufc1*/#548685;
    border-radius: 4px;
    color: /*#ufc6*/#ffffff;
    font-family: "Oswald", Arial, sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 1em;
    min-width: 150px;
    padding: 10px;
    text-decoration: none;
    text-transform: uppercase;
    -webkit-transition: background-color .2s;
    transition: background-color .2s;
}
#page .default.upost-data-object-comments input.submit:hover {
    background-color: /*#ufc1*/#548685;
}
',
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
    'theme_style' => '',
    'theme_preset' => 'true',
    'hidden_parts' =>
    array (
      0 => 'comments_pagination',
    ),
    'top_padding_use' => 'yes',
    'top_padding_slider' => '30',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1458430661268-1479',
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
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '18',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-comments',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comments',
      'wrapper_id' => 'wrapper-1458430613163-1255',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458430613164-1713',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '18',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-comment_form',
      'view_class' => 'PostDataPartView',
      'part_type' => 'comment_form',
      'wrapper_id' => 'wrapper-1458430613166-1850',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1458430613167-1747',
      'padding_slider' => '15',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'preset' => 'default',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => 0,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 12,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'mobile' =>
        array (
          'edited' => false,
          'left' => 0,
          'col' => 7,
          'order' => 0,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'use_padding',
        ),
      ),
    ),
  ),
));

$post_content->add_element("Uspacer", array (
  'columns' => '3',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1458430924959-1351 upfront-module-spacer',
  'id' => 'module-1458430924959-1351',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1458430924959-1473',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1458430924958-1136',
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

$regions->add($post_content);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer.php');
