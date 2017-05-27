<?php

/**
 * Archive Title
 */
FLPageData::add_archive_property( 'title', array(
	'label'   => __( 'Archive Title', 'fl-theme-builder' ),
	'group'   => 'archives',
	'type'    => 'string',
	'getter'  => 'FLPageDataArchive::get_title',
) );

/**
 * Archive Description
 */
FLPageData::add_archive_property( 'description', array(
	'label'   => __( 'Archive Description', 'fl-theme-builder' ),
	'group'   => 'archives',
	'type'    => 'string',
	'getter'  => 'get_the_archive_description',
) );

/*
 * Archive Term Meta
 */
FLPageData::add_archive_property( 'term_meta', array(
	'label'       => __( 'Archive Term Meta', 'fl-theme-builder' ),
	'group'       => 'archives',
	'type'        => 'all',
	'getter'      => 'FLPageDataArchive::get_term_meta',
) );

FLPageData::add_archive_property_settings_fields( 'term_meta', array(
	'key' => array(
		'type'          => 'text',
		'label'         => __( 'Key', 'fl-theme-builder' ),
	),
) );
