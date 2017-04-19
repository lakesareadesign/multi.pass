<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'header.php');

$contact = upfront_create_region(
			array (
  'name' => 'contact',
  'title' => 'Contact',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'contact',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'background_type' => 'image',
  'background_color' => 'rgba(126,108,93,1)',
  'nav_region' => '',
  'background_style' => 'fixed',
  'background_position_y' => '100',
  'background_position_x' => '100',
  'background_image' => '{{upfront:style_url}}/images/single-page-contact/contact-bg.png',
  'background_image_ratio' => 1.7,
  'row' => 128,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_position_y' => '100',
       'background_style' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => '100% 100%',
       'background_position_x' => '100',
       'background_type' => 'color',
       'background_color' => 'rgba(126,108,93,1)',
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
       'background_position_y' => '100',
       'background_style' => 'fixed',
       'background_repeat' => 'no-repeat',
       'background_position' => '100% 100%',
       'background_position_x' => '100',
       'background_type' => 'color',
       'background_color' => 'rgba(126,108,93,1)',
    )),
     'current_property' => 'background_color',
  )),
  'use_padding' => 0,
  'sub_regions' =>
  array (
    0 => '',
  ),
  'background_repeat' => 'no-repeat',
  'background_position' => '100% 100%',
  'version' => '1.0.0',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '105',
  'bottom_bg_padding_num' => '105',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'use_background_size_percent' => '',
  'background_size_percent' => '100',
  'background_default' => 'hide',
  'featured_fallback_background_color' => '#ffffff',
  'background_size' => 'auto',
  'region_role' => 'main',
)
			);

$contact->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776246-37887 upfront-module-spacer',
  'id' => 'module-1449776246-37887',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776246-91642',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776246-22693',
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

$contact->add_element("PlainTxt", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414585636524-1061',
  'id' => 'module-1414585636524-1061',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h1 style="text-align: center;" class=""><span class="upfront_theme_color_2">Contact Us</span></h1>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414585636524-1753',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'border_style' => 'none',
    'border_width' => 1,
    'border_color' => 'rgba(0, 0, 0, 0)',
    'bg_color' => 'rgba(0, 0, 0, 0)',
    'anchor' => '',
    'row' => 38,
    'top_padding_use' => true,
    'top_padding_num' => 115,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'top_padding_use' => 'yes',
         'top_padding_num' => '100',
         'row' => 17,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_slider' => '100',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'mobile' =>
      (array)(array(
         'row' => 16,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '65',
         'top_padding_num' => '65',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
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
  'wrapper_id' => 'wrapper-1414585910715-1906',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
      'order' => 0,
      'clear' => true,
      'edited' => true,
    ),
    'mobile' =>
    array (
      'col' => 7,
      'order' => 0,
      'clear' => true,
      'edited' => true,
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
      'row' => 17,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 16,
    ),
  ),
));

$contact->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776246-11409 upfront-module-spacer',
  'id' => 'module-1449776246-11409',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776246-12698',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776246-49129',
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

$contact->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776246-94504 upfront-module-spacer',
  'id' => 'module-1449776246-94504',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776246-85742',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776246-90072',
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

$contact->add_group(array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => '',
  'id' => 'module-group-1445818887383-1375',
  'type' => 'ModuleGroup',
  'wrapper_id' => 'wrapper-1445818355653-1883',
  'original_col' => 9,
  'row' => 67,
  'background_color' => 'rgba(75,75,75,0)',
  'background_style' => 'full',
  'background_position_y' => 50,
  'background_position_x' => 50,
  'use_padding' => 'yes',
  'background_type' => 'color',
  'anchor' => '',
  'top_padding_use' => 'yes',
  'top_padding_num' => '50',
  'version' => '1.0.0',
  'bottom_padding_num' => '15',
  'lock_padding' => '',
  'top_padding_slider' => '50',
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
      'row' => 26,
      'top' => 0,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '25',
      'top_padding_num' => '25',
      'bottom_padding_use' => 'yes',
      'bottom_padding_slider' => '15',
      'bottom_padding_num' => '15',
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'background_color' => 'rgba(75,75,75,0)',
      'top' => 0,
      'row' => 48,
      'use_padding' => 'yes',
      'lock_padding' => '',
      'top_padding_use' => 'yes',
      'top_padding_slider' => '20',
      'top_padding_num' => '20',
    ),
    'current_property' =>
    array (
      0 => 'top_padding_num',
    ),
  ),
));

$contact->add_element("PlainTxt", array (
  'columns' => '7',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414593868981-1695',
  'id' => 'module-1414593868981-1695',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<h2 class=""><span class="inline_color" style="color: rgb(255, 255, 255);" rel="color: rgb(255, 255, 255);" data-verified="redactor" data-redactor-tag="span" data-redactor-style="color: rgb(255, 255, 255);">Interested in our services? Get in touch.</span></h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1414593868980-1487',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'is_edited' => true,
    'row' => 28,
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
         'row' => 19,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 17,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '15',
    'padding_slider' => '15',
    'preset' => 'default',
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
  'wrapper_id' => 'wrapper-1445818893416-1771',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 0,
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
      'col' => 6,
      'order' => 0,
      'top' => 0,
      'row' => 19,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'row' => 17,
      'top' => 0,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1445818887383-1375',
));

$contact->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776246-46076 upfront-module-spacer',
  'id' => 'module-1449776246-46076',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776246-89424',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776246-53570',
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
  'group' => 'module-group-1445818887383-1375',
));

$contact->add_element("PlainTxt", array (
  'columns' => '8',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1445818060218-1346',
  'id' => 'module-1445818060218-1346',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'usingNewAppearance' => true,
    'content' => '<p class=""><span class="upfront_theme_color_2">p:</span> <span class="upfront_theme_color_1">+61 3 90&nbsp;300&nbsp;889 </span><br><span class="upfront_theme_color_2">​e:</span> <span class="upfront_theme_color_1">info@scribeincsub.com </span><br><span class="upfront_theme_color_2">​a: </span><span class="upfront_theme_color_1">3005 St Leonards Avenue, St Kilda</span></p>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1445818060218-1048',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'row' => 18,
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
         'row' => 22,
         'theme_style' => 'text-center',
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '20',
         'top_padding_num' => '20',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => 'text-center',
         'row' => 28,
         'use_padding' => 'yes',
         'lock_padding' => '',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '0',
         'top_padding_num' => '0',
         'bottom_padding_use' => 'yes',
         'bottom_padding_slider' => '0',
         'bottom_padding_num' => '0',
      )),
       'current_property' => 'bottom_padding_num',
    )),
    'top_padding_num' => '15',
    'bottom_padding_num' => '0',
    'padding_slider' => '15',
    'preset' => 'default',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
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
  'wrapper_id' => 'wrapper-1445818893426-1811',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 6,
      'order' => 1,
      'clear' => false,
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
      'col' => 6,
      'order' => 0,
      'top' => 0,
      'row' => 22,
    ),
    'mobile' =>
    array (
      'edited' => true,
      'left' => 0,
      'col' => 7,
      'order' => 0,
      'top' => 0,
      'row' => 28,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
  ),
  'group' => 'module-group-1445818887383-1375',
));

$contact->add_element("Ucontact", array (
  'columns' => '14',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1414585637124-1298',
  'id' => 'module-1414585637124-1298',
  'options' =>
  array (
    'form_add_title' =>
    array (
    ),
    'form_title' => 'Contact form',
    'form_name_label' => 'Your name',
    'form_email_label' => 'Email',
    'form_email_to' => '',
    'show_subject' =>
    array (
      0 => 'true',
    ),
    'show_captcha' =>
    array (
    ),
    'form_subject_label' => 'Subject',
    'form_captcha_label' => 'CAPTCHA:',
    'form_default_subject' => 'Sent from the website',
    'form_message_label' => 'Message',
    'form_button_text' => 'SEND',
    'form_validate_when' => 'submit',
    'form_label_position' => 'over',
    'preset' => 'default',
    'type' => 'UcontactModel',
    'view_class' => 'UcontactView',
    'class' => 'c24 upfront-contact-form',
    'has_settings' => 1,
    'id_slug' => 'ucontact',
    'usingNewAppearance' => true,
    'element_id' => 'ucontact-object-1414585637121-1905',
    'anchor' => '',
    'theme_style' => '',
    'row' => 21,
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'theme_style' => '',
         'use_padding' => 'yes',
         'top_padding_use' => 'yes',
         'top_padding_slider' => '25',
         'top_padding_num' => '25',
      )),
       'mobile' =>
      (array)(array(
         'theme_style' => '',
      )),
       'current_property' => 'lock_padding',
    )),
    'top_padding_use' => true,
    'top_padding_num' => 50,
    'bottom_padding_num' => '0',
    'padding_slider' => '15',
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '15',
    'left_padding_num' => '15',
    'right_padding_num' => '15',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'breakpoint_presets' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'preset' => 'mobile',
      )),
       'desktop' =>
      (array)(array(
         'preset' => 'default',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'mobile',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1445821131634-1714',
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

$contact->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1449776246-49513 upfront-module-spacer',
  'id' => 'module-1449776246-49513',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1449776246-58024',
    'usingNewAppearance' => true,
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1449776246-72465',
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

$regions->add($contact);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'footer-search.php');
