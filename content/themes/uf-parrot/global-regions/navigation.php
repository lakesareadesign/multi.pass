<?php
$navigation_container = ( !empty($region_container) ? $region_container : "header" );
$navigation_sub = ( !empty($region_sub) ? $region_sub: "left" );

$navigation = upfront_create_region(
			array(
"name" => "navigation",
"title" => "navigation",
"type" => "wide",
"scope" => "global",
"container" => "$navigation_container",
"sub" => "$navigation_sub",
"position" => 1,
"allow_sidebar" => true
),
			array(
"col" => 5,
"breakpoint" => array(
	"tablet" => array(
		"edited" => false,
		"col" => 24
		),
	"mobile" => array(
		"edited" => false,
		"col" => 24
		)
	),
"background_type" => "color",
"use_padding" => 0,
"background_color" => "rgba(0,0,0,0)"
)
			);

$navigation->add_element("Button", array(
"columns" => "4",
"margin_left" => "1",
"margin_top" => "22",
"id" => "module-1432660214701-1293",
"options" => array(
	"content" => "&nbsp;",
	"href" => "",
	"align" => "center",
	"type" => "ButtonModel",
	'view_class' => 'ButtonView',
    'usingNewAppearance' => true,
	"element_id" => "button-object-1432660214701-1548",
	"class" => "c24 upfront-button",
	"has_settings" => 1,
	"id_slug" => "button",
	"currentpreset" => "parrot-icon-logo",
	"row" => 7,
	"theme_style" => "",
	"is_edited" => true
	),
"row" => 7,
"wrapper_id" => "wrapper-1432660910446-1376",
"new_line" => "true",
"wrapper_breakpoint" => array(
	"tablet" => array(
		"edited" => false,
		"col" => 8,
		"order" => 0
		),
	"mobile" => array(
		"edited" => false,
		"col" => 6,
		"order" => 0
		)
	),
"breakpoint" => array(
	"tablet" => array(
		"edited" => false,
		"left" => 4,
		"col" => 4,
		"order" => 0
		),
	"mobile" => array(
		"edited" => false,
		"left" => 1,
		"col" => 5,
		"order" => 0
		)
	)
));

$navigation->add_element("Unewnavigation", array(
"columns" => "4",
"margin_left" => "1",
"margin_right" => "0",
"margin_top" => "0",
"margin_bottom" => "0",
"id" => "module-1429557374225-1939",
"options" => array(
	"type" => "UnewnavigationModel",
	'view_class' => 'UnewnavigationView',
    'usingNewAppearance' => true,
	"class" => "c24 upfront-navigation",
	"has_settings" => 1,
	"id_slug" => "unewnavigation",
	"menu_items" => array(array(
			"menu-item-db-id" => 10,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "Home",
			"menu-item-url" => "" . get_site_url() . "",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "10",
			"menu-item-target" => "",
			"menu-item-position" => 1
			), array(
			"menu-item-db-id" => 11,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "Features",
			"menu-item-url" => "" . get_site_url() . "/features/",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "11",
			"menu-item-target" => "",
			"menu-item-position" => 2
			), array(
			"menu-item-db-id" => 12,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "Download",
			"menu-item-url" => "" . get_site_url() . "/download/",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "12",
			"menu-item-target" => "",
			"menu-item-position" => 3
			), array(
			"menu-item-db-id" => 13,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "Contact Us",
			"menu-item-url" => "" . get_site_url() . "/contact/",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "13",
			"menu-item-target" => "",
			"menu-item-position" => 4
			), array(
			"menu-item-db-id" => 14,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "About",
			"menu-item-url" => "" . get_site_url() . "/about/",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "14",
			"menu-item-target" => "",
			"menu-item-position" => 5
			), array(
			"menu-item-db-id" => 15,
			"menu-item-parent-id" => "0",
			"menu-item-type" => "custom",
			"menu-item-title" => "Blog",
			"menu-item-url" => "" . get_site_url() . "/blog/",
			"menu-item-object" => "custom",
			"menu-item-object-id" => "15",
			"menu-item-target" => "",
			"menu-item-position" => 6
			)),
	"menu_style" => "vertical",
	"menu_alignment" => "left",
	"allow_sub_nav" => array("no"),
	"allow_new_pages" => array(),
	"element_id" => "unewnavigation-object-1429557374224-1061",
	"breakpoint" => array(
		"desktop" => array(
			"burger_alignment" => "left",
			"burger_over" => "over",
			"menu_style" => "vertical",
			"menu_alignment" => "left",
			"width" => 1080
			)
		),
	"menu_id" => false,
	"menu_slug" => "parrot-main-nav",
	"row" => 43,
	"burger_menu" => array(),
	"burger_alignment" => "left",
	"burger_over" => "over",
	"is_floating" => array(),
	"anchor" => "",
	"theme_style" => ""
	),
"row" => 43,
"sticky" => false,
"wrapper_id" => "wrapper-1429558005324-1559",
"new_line" => "true",
"wrapper_breakpoint" => array(
	"tablet" => array(
		"edited" => false,
		"col" => 8,
		"order" => 0
		),
	"mobile" => array(
		"edited" => false,
		"col" => 6,
		"order" => 0
		)
	),
"breakpoint" => array(
	"tablet" => array(
		"edited" => false,
		"left" => 4,
		"col" => 4,
		"order" => 0
		),
	"mobile" => array(
		"edited" => false,
		"left" => 1,
		"col" => 5,
		"order" => 0
		)
	)
));

$regions->add($navigation);
