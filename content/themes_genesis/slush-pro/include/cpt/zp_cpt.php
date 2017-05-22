<?php
/**
 * Slush Pro.
 *
 * This file adds the custom meta boxes to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

function zp_custom_post_type() {

// Adds Portfolio Post Type.
	$portfolio_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions','genesis-layouts', 'genesis-seo', 'genesis-cpt-archives-settings', 'excerpt' )
	);
	
	// Registers portfolio post type.
	$portfolio = new Super_Custom_Post_Type( 'portfolio', 'Portfolio', 'Portfolio',  $portfolio_custom_default );
	$portfolio_category = new Super_Custom_Taxonomy( 'portfolio_category' , 'Portfolio Category' , 'Portfolio Categories', 'cat' );
	connect_types_and_taxes( $portfolio, array( $portfolio_category ) );

	$portfolio->add_meta_box( array(
		'context'  => 'normal',
		'id'       => 'portfolio_settings',
		'fields'   => array(
			'portfolio_link' => array(
				'data-desc'  => __( 'Select what type of link you want for this portfolio item.', 'slush-pro' ),
				'label'      => __( 'Type of Portfolio link', 'slush-pro' ),
				'options'    => array( 'lightbox', 'external_link', 'single_page' ),
				'type'       => 'select',
			),
		),
		'priority' => 'high',
	) );

	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_lightbox',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			'video_link'      => array( 'label' => __( 'Video Link', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Add video link here. Video link format: Youtube: "http://www.youtube.com/watch?v=7HKoqNJtMTQ", Vimeo: "https://vimeo.com/123123". Leave empty if you don\'t want to have a video on a lightbox.', 'slush-pro' ) ),
			'lightbox_images' => array( 'label' => __( 'Upload/Attach images to this portfolio item. Images attached in here will be shown in lightbox to form slideshow gallery.', 'slush-pro' ), 'type' => 'multiple_media', 'data-desc' => __( 'Leave empty if you don\'t want to have a galley slideshow on a lightbox.', 'slush-pro' ) ),
		)
	) );

	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_external_link',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			'zp_external_link' => array( 'label' => __( 'External Link', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Add external link for this portfolio item.', 'slush-pro' ) ),			
		)
	) );

	$portfolio->add_meta_box( array(
		'id'       => 'portfolio_single_page',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			'button_label'      => array( 'label' => __( 'Button Label', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Add button label', 'slush-pro' ) ),
			'button_link'       => array( 'label' => __( 'Button Link', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Add button link', 'slush-pro' ) ),
			'portfolio_images'  => array( 'label' => __( 'Upload/Attach an image to this portfolio item. Images attached in here will be shown in lightbox and single portfolio page.', 'slush-pro' ), 'type' => 'multiple_media', 'data-desc' => __( 'Add images to this portfolio. If this is empty, the featured image will be use.', 'slush-pro' ) ),
			//'display_type'      => array( 'label' => __( 'Portfolio Image Display Type', 'slush-pro' ), 'type' => 'select', 'options' => array( 'slider' ), 'data-desc' => __( 'Select how to display portfolio images on single portfolio page.', 'slush-pro' ) ),
			'single_video_link' => array( 'label' => __( 'Video Link', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Add video link here. Video link format: Youtube: "http://www.youtube.com/watch?v=7HKoqNJtMTQ", Vimeo: "https://vimeo.com/123123". If this is empty, the featured image will be used on lightbox.', 'slush-pro' ) )
		)
	) );

	// Manages portfolio columns.
	function zp_add_portfolio_columns( $columns ) {

		global $zp_option;
		
		return array(
			'author'             => __( 'Author', 'slush-pro' ),
			'cb'                 => '<input type="checkbox" />',
			'date'               => __( 'Date', 'slush-pro' ),
			'portfolio_category' => __( 'Portfolio Category(s)', 'slush-pro' ),
			'title'              => __( 'Title', 'slush-pro' ),
		);

	}
	
	add_filter( 'manage_portfolio_posts_columns', 'zp_add_portfolio_columns' );
	function zp_custom_portfolio_columns( $column, $post_id ) {

		global $zp_option;
		
		switch ( $column ) {
			case 'portfolio_category':
				$terms = get_the_term_list( $post_id, 'portfolio_category', '', ',', '' );
				if ( is_string( $terms ) )
					echo $terms;
				else
					_e( 'Unable to get portfolio category.', 'slush-pro' );
					break;
		}

	}

	add_action( 'manage_posts_custom_column' , 'zp_custom_portfolio_columns', 10, 2 );

	// Adds Post Custom Meta.
	$post_meta = new Super_Custom_Post_Meta( 'post' );

	$post_meta->add_meta_box( array(
		'id'       => 'audio-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'zp_audio_mp3_url' => array( 'label' => __( 'Audio .mp3 URL', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'The URL to the .mp3 audio file', 'slush-pro' ) ),
			'zp_audio_ogg_url' => array( 'label' => __( 'Audio .ogg, .oga URL', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'The URL to the .oga, .ogg audio file', 'slush-pro' ) ),
			'zp_embed_audio'   => array( 'label' => __( 'Embed Audio', 'slush-pro' ), 'type' => 'textarea', 'data-desc' => __( 'Embed audio code here.', 'slush-pro' ) ),
		)
	) );

	$post_meta->add_meta_box( array(
		'id'       => 'link-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'zp_link_format' => array( 'label' => __( 'Enter link.  E.g., http://www.yourlink.com', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Input your link. e.g., http://www.yourlink.com', 'slush-pro' ) )
		)
	) );

	$post_meta->add_meta_box( array(
		'id'       => 'video-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'zp_video_m4v_url'      => array( 'label' => __( 'Video File (.m4v)', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'The URL to the .m4v video file', 'slush-pro' ) ),
			'zp_video_ogv_url'      => array( 'label' => __( 'Video File (.ogv)', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'The URL to the .ogv video file', 'slush-pro' ) ),
			'zp_video_format_embed' => array( 'label' => __( 'Embed Video', 'slush-pro' ), 'type' => 'textarea', 'data-desc' => __( 'If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 600px with any height. This field will override the above.', 'slush-pro' ) ),
		)
	) );

	$post_meta->add_meta_box( array(
		'id'       => 'gallery-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'zp_post_gallery' => array( 'label' => __( 'Add Gallery Images. ', 'slush-pro' ), 'type' => 'multiple_media', 'data-desc' => __( 'Add images for gallery post format.', 'slush-pro' ) ),
		)
	) );

	// Adds Page Custom Meta.
	$page_meta = new Super_Custom_Post_Meta( 'page' );

	$page_meta->add_meta_box( array(
		'id'       => 'masonry-template-settings',
		'context'  => 'side',
		'priority' => 'high',
		'fields'   => array(
			'display_type'     => array( 'label' => __( 'Display Type', 'slush-pro' ), 'type' => 'select', 'options'=> array( 'blog' => 'Blog', 'portfolio' => 'Portfolio' ), 'data-desc' => __( 'Add images for gallery post format.', 'slush-pro' ) ),
			'display_category' => array( 'label' => __( 'Category', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Define category to display. Use the category slug.', 'slush-pro' ) ),
			'display_columns'  => array( 'label' => __( 'Columns', 'slush-pro' ), 'type' => 'select', 'options'=> array( '2' => '2 Columns', '3' => '3 Columns' , '4' => '4 Columns' ),  'data-desc' => __( 'Define category to display. Use the category slug.', 'slush-pro' ) ),
			'display_filter'   => array( 'label' => __( 'Enable filter?', 'slush-pro' ), 'type' => 'select', 'options'=> array( 'true' => 'Yes', 'false' => 'No' ),  'data-desc' => __( 'Select true to enable category filter.', 'slush-pro' ) ),
			'display_items'    => array( 'label' => __( 'Items', 'slush-pro' ), 'type' => 'text', 'data-desc' => __( 'Set number of items to display.', 'slush-pro' ) ),
			'display_loadmore' => array( 'label' => __( 'Enable load more button?', 'slush-pro' ), 'type' => 'select', 'options'=> array( 'true' => 'Yes', 'false' => 'No' ), 'data-desc' => __( 'Select true to enable the load more button at the bottom of the items.', 'slush-pro' ) ),
		)
	) );

}
add_action( 'after_setup_theme', 'zp_custom_post_type' );
