<?php

/**
 * Site Title
 */
FLPageData::add_site_property( 'title', array(
	'label'   => __( 'Site Title', 'fl-theme-builder' ),
	'group'   => 'site',
	'type'    => 'string',
	'getter'  => 'FLPageDataSite::get_title',
) );

/**
 * Site Tagline
 */
FLPageData::add_site_property( 'tagline', array(
	'label'   => __( 'Site Tagline', 'fl-theme-builder' ),
	'group'   => 'site',
	'type'    => 'string',
	'getter'  => 'FLPageDataSite::get_description',
) );

/**
 * Site URL
 */
FLPageData::add_site_property( 'url', array(
	'label'   => __( 'Site URL', 'fl-theme-builder' ),
	'group'   => 'site',
	'type'    => 'url',
	'getter'  => 'FLPageDataSite::get_url',
) );
