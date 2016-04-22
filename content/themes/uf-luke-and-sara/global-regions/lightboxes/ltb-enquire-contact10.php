<?php
/* START_REGION_OUTPUT */
$ltb_enquire_contact10 = upfront_create_region(
			array (
  'name' => 'ltb-enquire-contact10',
  'title' => 'Enquire Contact',
  'type' => 'lightbox',
  'scope' => 'local',
  'container' => 'lightbox',
  'sub' => 'lightbox',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'col' => '24',
  'height' => '550',
  'click_out_close' => 'yes',
  'show_close' => 'yes',
  'overlay_color' => 'rgba(248, 254, 255, 0.901961)',
  'lightbox_color' => 'rgba(197, 208, 219, 0)',
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
     'current_property' => 'background_type',
  )),
  'background_type' => '',
  'use_padding' => 0,
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => '0',
  'top_bg_padding_num' => '0',
  'bottom_bg_padding_slider' => 0,
  'bottom_bg_padding_num' => 0,
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'delete' => false,
  'version' => '1.0.0',
)
			);

$ltb_enquire_contact10->add_element("PlainTxt", array (
  'columns' => '24',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453837070734-1222',
  'id' => 'module-1453837070734-1222',
  'options' =>
  array (
    'view_class' => 'PlainTxtView',
    'id_slug' => 'plain_text',
    'content' => '<h2 style="text-align: center;">We would love to hear from you</h2>',
    'type' => 'PlainTxtModel',
    'element_id' => 'text-object-1453837070734-1672',
    'class' => 'c24 upfront-plain_txt',
    'has_settings' => 1,
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'is_edited' => true,
    'row' => 13,
    'preset' => 'default',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 11,
      )),
    )),
    'use_padding' => 'yes',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453837221218-1348',
  'new_line' => true,
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
      'row' => 11,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$ltb_enquire_contact10->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1455165777787-1449 upfront-module-spacer',
  'id' => 'module-1455165777787-1449',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1455165777786-1165',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1455165777787-1722',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
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
  ),
));

$ltb_enquire_contact10->add_element("Ucontact", array (
  'columns' => '22',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1453837070776-1749',
  'id' => 'module-1453837070776-1749',
  'options' =>
  array (
    'form_add_title' =>
    array (
    ),
    'form_title' => 'Contact form',
    'form_name_label' => 'Name:',
    'form_email_label' => 'Email:',
    'form_email_to' => '',
    'show_subject' =>
    array (
      0 => 'true',
    ),
    'show_captcha' =>
    array (
    ),
    'form_subject_label' => 'Subject:',
    'form_captcha_label' => 'CAPTCHA:',
    'form_default_subject' => 'Sent from the website',
    'form_message_label' => 'Message:',
    'form_button_text' => 'Send',
    'form_validate_when' => 'submit',
    'form_label_position' => 'over',
    'preset' => 'default',
    'type' => 'UcontactModel',
    'view_class' => 'UcontactView',
    'class' => 'c24 upfront-contact-form',
    'has_settings' => 1,
    'id_slug' => 'ucontact',
    'element_id' => 'ucontact-object-1453837070771-1088',
    'padding_slider' => '10',
    'top_padding_num' => '10',
    'bottom_padding_num' => '10',
    'usingNewAppearance' => true,
    'use_padding' => 'yes',
    'lock_padding' => '',
    'padding_number' => '10',
    'left_padding_num' => '10',
    'right_padding_num' => '10',
    'anchor' => '',
    'breakpoint' =>
    (array)(array(
       'mobile' =>
      (array)(array(
         'row' => 70,
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1453837259542-1631',
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
      'row' => 70,
    ),
    'current_property' =>
    array (
      0 => 'edited',
    ),
  ),
));

$ltb_enquire_contact10->add_element("Uspacer", array (
  'columns' => '1',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1455165780561-1478 upfront-module-spacer',
  'id' => 'module-1455165780561-1478',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1455165780560-1062',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1455165780561-1137',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'edited' => true,
      'col' => 1,
    ),
    'mobile' =>
    array (
      'col' => 1,
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
  ),
));

$regions->add($ltb_enquire_contact10);

/* END_REGION_OUTPUT */