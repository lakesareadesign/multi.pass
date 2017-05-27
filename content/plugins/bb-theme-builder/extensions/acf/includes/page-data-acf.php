<?php

/**
 * Advanced Custom Field String
 */
FLPageData::add_archive_property( 'acf', $data = array(
	'label'   => __( 'ACF Archive Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => array( 'string', 'custom_field' ),
	'getter'  => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf', $data = array(
	'label'   => __( 'ACF Post Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => array( 'string', 'custom_field' ),
	'getter'  => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf_author', $data = array(
	'label'   => __( 'ACF Post Author Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => array( 'string', 'custom_field' ),
	'getter'  => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_user', $data = array(
	'label'   => __( 'ACF User Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => array( 'string', 'custom_field' ),
	'getter'  => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_option', $data = array(
	'label'   => __( 'ACF Option Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => array( 'string', 'custom_field' ),
	'getter'  => 'FLPageDataACF::string_field',
) );

$form = array(
	'type' => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'		 		=> __( 'Text', 'fl-theme-builder' ),
			'textarea'			=> __( 'Textarea', 'fl-theme-builder' ),
			'number'	 		=> __( 'Number', 'fl-theme-builder' ),
			'email'		 		=> __( 'Email', 'fl-theme-builder' ),
			'url'		 		=> __( 'URL', 'fl-theme-builder' ),
			'password'	 		=> __( 'Password', 'fl-theme-builder' ),
			'wysiwyg'	 		=> __( 'WYSIWYG', 'fl-theme-builder' ),
			'oembed'	 		=> __( 'oEmbed', 'fl-theme-builder' ),
			'image'		 		=> __( 'Image', 'fl-theme-builder' ),
			'file'		 		=> __( 'File', 'fl-theme-builder' ),
			'select'	 		=> __( 'Select', 'fl-theme-builder' ),
			'radio'		 		=> __( 'Radio', 'fl-theme-builder' ),
			'page_link'  		=> __( 'Page Link', 'fl-theme-builder' ),
			'google_map'        => __( 'Google Map', 'fl-theme-builder' ),
			'date_picker'       => __( 'Date Picker', 'fl-theme-builder' ),
			'date_time_picker'  => __( 'Date Time Picker', 'fl-theme-builder' ),
			'time_picker'       => __( 'Time Picker', 'fl-theme-builder' ),
		),
		'toggle' => array(
			'image' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
);

FLPageData::add_archive_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf_author', $form );
FLPageData::add_site_property_settings_fields( 'acf_user', $form );
FLPageData::add_site_property_settings_fields( 'acf_option', $form );

/**
 * Advanced Custom Field URL
 */
FLPageData::add_archive_property( 'acf_url', $data = array(
	'label'   => __( 'ACF Archive Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'url',
	'getter'  => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_url', $data = array(
	'label'   => __( 'ACF Post Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'url',
	'getter'  => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_author_url', $data = array(
	'label'   => __( 'ACF Post Author Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'url',
	'getter'  => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_user_url', $data = array(
	'label'   => __( 'ACF User Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'url',
	'getter'  => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_option_url', $data = array(
	'label'   => __( 'ACF Option Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'url',
	'getter'  => 'FLPageDataACF::url_field',
) );

$form = array(
	'type' => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'		=> __( 'Text', 'fl-theme-builder' ),
			'url'		=> __( 'URL', 'fl-theme-builder' ),
			'image'		=> __( 'Image', 'fl-theme-builder' ),
			'file'		=> __( 'File', 'fl-theme-builder' ),
			'select'	=> __( 'Select', 'fl-theme-builder' ),
			'radio'		=> __( 'Radio', 'fl-theme-builder' ),
			'page_link' => __( 'Page Link', 'fl-theme-builder' ),
		),
		'toggle' => array(
			'image' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_url', $form );

/**
 * Advanced Custom Field Photo
 */
FLPageData::add_archive_property( 'acf_photo', $data = array(
	'label'   => __( 'ACF Archive Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'photo',
	'getter'  => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_photo', $data = array(
	'label'   => __( 'ACF Post Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'photo',
	'getter'  => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_author_photo', $data = array(
	'label'   => __( 'ACF Post Author Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'photo',
	'getter'  => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_user_photo', $data = array(
	'label'   => __( 'ACF User Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'photo',
	'getter'  => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_option_photo', $data = array(
	'label'   => __( 'ACF Option Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'photo',
	'getter'  => 'FLPageDataACF::photo_field',
) );

$form = array(
	'type' => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'fl-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'		=> __( 'Text', 'fl-theme-builder' ),
			'url'		=> __( 'URL', 'fl-theme-builder' ),
			'image'		=> __( 'Image', 'fl-theme-builder' ),
			'select'	=> __( 'Select', 'fl-theme-builder' ),
			'radio'		=> __( 'Radio', 'fl-theme-builder' ),
		),
		'toggle' => array(
			'image' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'fl-theme-builder' ),
	),
	'image_size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'fl-theme-builder' ),
		'default' => 'thumbnail',
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_photo', $form );

/**
 * Advanced Custom Field Multiple Photos
 */
FLPageData::add_archive_property( 'acf_gallery', $data = array(
	'label'   => __( 'ACF Archive Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'multiple-photos',
	'getter'  => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_gallery', $data = array(
	'label'   => __( 'ACF Post Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'multiple-photos',
	'getter'  => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_author_gallery', $data = array(
	'label'   => __( 'ACF Post Author Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'multiple-photos',
	'getter'  => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_user_gallery', $data = array(
	'label'   => __( 'ACF User Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'multiple-photos',
	'getter'  => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_option_gallery', $data = array(
	'label'   => __( 'ACF Option Field', 'fl-theme-builder' ),
	'group'   => 'acf',
	'type'    => 'multiple-photos',
	'getter'  => 'FLPageDataACF::multiple_photos_field',
) );

$form = array(
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Gallery Field Name', 'fl-theme-builder' ),
	),
);

FLPageData::add_archive_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_gallery', $form );
