<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	CPT Settings and Admin Functions
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@updated: February 7, 2015
*/



/*
 *	Register Testimonials Custom Post Type
 *	post edit screen.
 *	@since v1.0
*/
function bne_testimonials_post_type() {

	// Custom Post Type Labels
	$labels = array(
		'name'               => __( 'Testimonials', 'bne-testimonials' ),
		'singular_name'      => __( 'Testimonial', 'bne-testimonials' ),
		'add_new'            => __( 'Add new testimonial', 'bne-testimonials' ),
		'add_new_item'       => __( 'Add new Testimonial', 'bne-testimonials' ),
		'edit_item'          => __( 'Edit Testimonial', 'bne-testimonials' ),
		'new_item'           => __( 'New Testimonial', 'bne-testimonials' ),
		'all_items'          => __( 'All Testimonials', 'bne-testimonials' ),
		'view_item'          => __( 'View Testimonial', 'bne-testimonials' ),
		'search_items'       => __( 'Search Testimonials', 'bne-testimonials' ),
		'not_found'          => __( 'No Testimonial found', 'bne-testimonials' ),
		'not_found_in_trash' => __( 'No Testimonial found in trash', 'bne-testimonials' ),
		'parent_item_colon'  => __( 'Parent Testimonial', 'bne-testimonials' ),
		'menu_name'          => __( 'Testimonials', 'bne-testimonials' )
	);

	// Custom Post Type Supports
	$supports = array('title', 'editor', 'thumbnail');

	// Custom Post Type Arguments
	$args = apply_filters( 'bne_testimonials_cpt_args', array(
	    'labels'             	=> $labels,
	    'public'             	=> false,
	    'show_ui'            	=> true,
	    'rewrite'            	=> false,
	    'menu_icon' 			=> 'dashicons-id-alt',
	    'supports'           	=> $supports,
	) );

	register_post_type( 'bne_testimonials', $args );

}
add_action( 'init', 'bne_testimonials_post_type' );




/*
 *	CPT Update Messages when creating/editing a Testimonial on the
 *	post edit screen.
 *	@since v1.6.3
*/
function bne_testimonials_updated_messages( $messages ) {
	global $post, $post_ID;

    $screen = get_current_screen();
    if ( 'bne_testimonials' == $screen->post_type ){

		$messages["post"][1] 	= __( 'Testimonial updated!', 'bne-testimonials' );
		$messages["post"][6] 	= __( 'Testimonial published!', 'bne-testimonials' );
		$messages["post"][10] 	= __( 'Testimonial draft updated!', 'bne-testimonials' );

		return $messages;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'bne_testimonials_updated_messages' );




/*
 *	Setup Post List Columns
 *	@since v1.1
*/
if (function_exists( 'add_theme_support' )){
    add_filter( 'manage_edit-bne_testimonials_columns', 'bne_testimonials_posts_columns', 5 );
    add_action( 'manage_bne_testimonials_posts_custom_column', 'bne_testimonials_posts_custom_columns', 10, 2 );
}



/*
 *	Remove/Add Columns Post List Columns
 *	@since v1.1
*/
function bne_testimonials_posts_columns( $columns ){
    unset( $columns['date'] );

    $columns['title'] = __( 'Name', 'bne-testimonials' );
    $columns['taxonomy-bne-testimonials-taxonomy'] = __( 'Category', 'bne-testimonials' );
    $columns['bne_testimonials_message'] = __( 'Message', 'bne-testimonials' );
    $columns['bne_testimonials_post_list_thumbs'] = __( 'Image', 'bne-testimonials' );
    $columns['date'] = __( 'Date', 'bne-testimonials' );
    return $columns;
}




/*
 *	Add Content to Post List Columns
 *	@since v1.1
*/
function bne_testimonials_posts_custom_columns( $column_name, $id ) {

	if( $column_name === 'bne_testimonials_post_list_thumbs' ) {
		echo the_post_thumbnail( array( 80, 80 ) );
    }

	if( $column_name === 'bne_testimonials_message' ) {
		echo substr( get_the_excerpt(), 0, 80 ) . '...';
    }

}




/*
 *	Alter Title Placeholder Text on Post Edit Screen
 *	@since v1.1
*/
function bne_testimonials_post_title( $title ){
    $screen = get_current_screen();

    if( 'bne_testimonials' == $screen->post_type ) {
        $title = __( 'Enter the person\'s name here', 'bne-testimonials' );
    }

    return $title;
}
add_filter( 'enter_title_here', 'bne_testimonials_post_title', 'bne-testimonials' );




/*
 *	Featured Image Widget Title
 *	@since v1.1
*/
function bne_testimonials_admin_featured_image_text() {

    remove_meta_box( 'postimagediv', 'bne_testimonials', 'side', 'bne-testimonials' );

    add_meta_box( 'postimagediv', __( 'Set Testimonial Thumbnail', 'bne-testimonials' ), 'bne_testimonials_featured_image_box', 'bne_testimonials', 'side', 'default' );
}
add_action( 'do_meta_boxes', 'bne_testimonials_admin_featured_image_text' );




/*
 *	Featured Image Widget Text
 *	@since v1.1
*/
function bne_testimonials_featured_image_box( $post ) {
	$thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true );
	echo _wp_post_thumbnail_html( $thumbnail_id, $post->ID );
	echo __( 'Add an optional featured image for this testimonial.', 'bne-testimonials' );
}




/*
 *	Check if Theme supports Post Thumbnails
 *	@since v1.5
 *	@updated v1.6.3
*/
function bne_testimonials_add_thumbnail_support() {

	// Remove default support which may limit certain
    // post-types not specified from the active theme.
	remove_theme_support( 'post-thumbnails' );

	// Re-Add support for ALL post-types to ensure that
	// post-thumbnails work correctly.
	if( !current_theme_supports( 'post-thumbnails' ) ) {
		add_theme_support( 'post-thumbnails' );
	}
}
add_action( 'after_setup_theme', 'bne_testimonials_add_thumbnail_support', 11 );




/*
 *	Registers the 'testimonial_details' metabox
 *	@since v1.0
*/
function bne_testimonials_details_metabox() {
	add_meta_box( 'testimonial_details', __( 'Optional Testimonial Details', 'bne-testimonials' ), 'bne_testimonials_details_metabox_fields', 'bne_testimonials', 'normal', 'high' );

}
add_action( 'add_meta_boxes', 'bne_testimonials_details_metabox' );


/*
 *	Creates the 'testimonial_details' metabox content
 *	@since v1.0
*/
function bne_testimonials_details_metabox_fields() {

	global $post;

	?>
	<table class="form-table" id="rc_wctg_metabox">
		<tbody>
			<tr class="form-field">
				<th scope="row" valign="top" style="width: 30%;">
					<label for="tagline"><?php echo __('Tagline or Company Name:', 'bne-testimonials');?></label>
				</th>
				<?php $tagline = ( esc_html( get_post_meta( $post->ID, 'tagline', true ) ) ) ? esc_html( get_post_meta( $post->ID, 'tagline', true ) ) : ''; ?>
				<td>
					<input type="text" id="tagline" name="rc_wctg_meta_field[tagline]" value="<?php echo $tagline; ?>">
					<span class="description" style="display:block;">
						<?php echo __( 'Enter a tagline or Company Name of this testimonial. This field is also used as the website anchor text if a url is entered below. Example: "Owner of Cat\'s Town".', 'bne-testimonials' ); ?>
					</span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top" style="width: 30%;">
					<label for="website-url"><?php echo __('Website URL:', 'bne-testimonials');?></label>
				</th>
				<?php $website_url = ( esc_url( get_post_meta( $post->ID, 'website-url', true ) ) ) ? esc_url( get_post_meta( $post->ID, 'website-url', true ) ) : ''; ?>
				<td>
					<input type="text" id="website-url" name="rc_wctg_meta_field[website-url]" value="<?php echo $website_url; ?>">
					<span class="description" style="display:block;">
						<?php echo __('Enter a URL that applies to this testimonial. Ex: http://www.google.com/', 'bne-testimonials'); ?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
}




/*
 *	Creates the 'save' function
 *	@since v1.0
*/
function bne_testimonials_save_post_meta( $post_id, $post ) {

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	$post_meta =  array();

	// place all meta fields into a single array
	if( isset($_POST['rc_wctg_meta_field'] ) ) {
		$meta_fields = $_POST['rc_wctg_meta_field'];
		foreach( $meta_fields as $meta_key => $meta_value ) {
			$post_meta[$meta_key] = $meta_value;
		}
	}

	// Add values of $post_meta as custom fields
	foreach ($post_meta as $key => $value) {
		if( $post->post_type == 'revision' ) return;
		$value = implode(',', (array)$value);
		if(get_post_meta($post->ID, $key, FALSE)) {
			update_post_meta($post->ID, $key, $value);
		} else {
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key);
	}
}
add_action('save_post', 'bne_testimonials_save_post_meta', 1, 2); // save the custom fields