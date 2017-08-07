<?php
/*
 *	Register Mian Testimonials Custom Post Type
 *
 * 	@author		Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *	@since		v2.0
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


// Custom Post Type Setup
class BNE_Testimonials_CPT {


	/*
	 *	Post type name
	 *
	 *	@var string $post_type_name Holds the name of the post type.
	 *
	*/
	public $post_type_name = 'bne_testimonials';
	


	/*
	 *	Plugin Textdomain
	 *
	 *	@var constant Holds the name of the textdomain for localization.
	 *
	*/
	public $textdomain = 'bne-testimonials';

	
	
    /*
     * 	Constructor
     *
     *	@since v2.0
     *
    */
	function __construct() {

		
	    /*
	     * 	Hook into BNE_CPT and register a new custom post type.
	     *	Translation is taken care of in the BNE_CPT class.
	     *
	    */
		$cpt = new BNE_CPT( $this->post_type_name, array(
			'singular'		=> 	'Testimonial',
			'plural'		=> 	'Testimonials',
			'slug' 			=> 	'testimonials',
			'args'			=>	array(
				'labels'		=>	array(
					'menu_name' 	=> 'Testimonials',
				),
				'supports'				=>	array( 'title', 'editor', 'thumbnail' ),
				'menu_icon'				=>	'dashicons-id-alt',
			    'public'             	=> 	false,
			    'publicly_queryable' 	=> 	false,
			    'exclude_from_search'	=>	true,
			    'show_ui'            	=> 	true,
			    'show_in_menu'       	=> 	true,
			    'show_in_nav_menus'  	=> 	false,
			    'show_in_admin_bar'  	=> 	false,
			    'hierarchical'       	=> 	false,
			    'has_archive'        	=> 	false,
			),
		));
		

	    /*
	     * 	Hook into BNE_CPT's register_taxonomy function
	     *	and register a new custom taxonomy to our custom
	     *	post type.
	     *
	     *	Translation is taken care of in the BNE_CPT class.
	     *
	    */
		$cpt->register_taxonomy( 'bne-testimonials-taxonomy', array(
			'singular' 	=> 	'Category',
			'plural'	=> 	'Categories',
			'slug'		=>	'categories',
			'args'		=> 	array(
				'labels'	=>	array(
					'menu_name'		=>	'Categories',
				),
				'show_admin_column' 	=> 	true,
			    'hierarchical'       	=> 	true,
			    'public'             	=> 	false,
			    'show_ui'            	=> 	true,
			    'show_tagcloud'      	=> 	false,
			    'show_in_nav_menus'  	=> 	false,
			    'show_admin_column'  	=> 	true,
			    'rewrite'            	=>	false,
			)
		));


	    /*
	     * 	Hook into BNE_CPT's set_taxomony function
	     *	and set our translation slug.
	     *
	    */
		$cpt->set_textdomain( $this->textdomain );

	    // Post List Columns
		add_filter( "manage_edit-{$this->post_type_name}_columns", array( $this, 'columns' ), 10, 1 );
		add_action( "manage_{$this->post_type_name}_posts_custom_column",  array( $this, 'column_content' ), 10, 2 );
				
		// Post Admin
		add_filter( 'enter_title_here', array( $this, 'post_title' ) );
		add_filter( 'admin_post_thumbnail_html', array( $this, 'post_thumbnail_html' ) );
		
		// CPT CMB2 Fields
		add_action( 'cmb2_init', array( $this, 'cmb2_metabox' ) );
		add_action( 'cmb2_before_post_form_details_metabox', array( $this, 'cmb2_metabox_scripts' ), 10, 2 );
		
	}


	/*
	 *	Add/Remove Columns on Post List Admin Screen
	 *
	 *	@since 		v2.0
	 *
	*/
	function columns( $columns ) {
		
		// Remove Columns
		unset( $columns['date'] );
	
		// Add Columns
	    $columns['title'] 				= __( 'Name', 'bne-testimonials' );
	    $columns['testimonial_message'] = __( 'Message', 'bne-testimonials' );
	    $columns['testimonial_image'] 	= __( 'Image', 'bne-testimonials' );
	    $columns['date'] 				= __( 'Published', 'bne-testimonials' );

	    return $columns;
	
	}


	/*
	 *	Add Content to Columns on Post List Admin Screen
	 *
	 *	@since 		v1.1
	 * 	@updated 	v2.0
	 *
	*/
	function column_content( $column, $post_id ) {
	
		// Message
		if( $column === 'testimonial_message' ) {
			echo substr( get_the_excerpt(), 0, 60 ) . '...';
	    }
	
		// Image
		if( $column === 'testimonial_image' ) {
			echo the_post_thumbnail( array( 80, 80 ) );
	    }	
	
	}


	/*
	 *	Post Title Label
	 *
	 *	@since 		v2.0
	 *
	*/
	function post_title( $title ) {
		$screen = get_current_screen();
		
		if( $this->post_type_name == $screen->post_type ) {
			$title = bne_testimonials_get_local( 'cpt_post_title' );
		}
		
		return $title;
	}
	

	/*
	 *	Featured Image Widget Text
	 *
	 *	@since 		v2.0
	 *
	*/
	function post_thumbnail_html( $content ) {
		global $post_type;
		if( $this->post_type_name == $post_type ) {
			$content .= bne_testimonials_get_local( 'cpt_thumb_description' );
		}
	    return $content;
	}
	

	/*
	 *	Meta Box
	 *
	 *	Defines a set of meta boxes for our CPT.
	 *
	 *	@since 		v2.0
	 *
	*/
	function cmb2_metabox() {
	
		// Set field prefix
		$prefix = $this->post_type_name.'_';
	
	
		// Initiate Metabox
		$cmb = new_cmb2_box( array(
			'id'            =>	'details_metabox',
			'title'         =>  bne_testimonials_get_local( 'cpt_details_title' ),
			'object_types'  =>  array( $this->post_type_name ),
			'classes'		=>	'bne-cmb-wrapper'
		) );
	
		// Tagline
		$cmb->add_field( array(
			'name'    			=>	bne_testimonials_get_local( 'cpt_tagline_title' ),
			'desc'    			=>	bne_testimonials_get_local( 'cpt_tagline_description'),
			'id'      			=>	'tagline',
			'type'    			=>	'text',
			'sanitization_cb' 	=> 	'bne_testimonials_sanitize_text_callback',
		) );
		
		// Website URL
		$cmb->add_field( array(
			'name'    		=>	bne_testimonials_get_local( 'cpt_website_title' ),
			'desc'    		=>	bne_testimonials_get_local( 'cpt_website_description' ),
			'id'      		=>	'website-url',
			'type'    		=>	'text_url',
			'before_field'	=>	'<div class="bne-input-prepend"><span class="dashicons dashicons-admin-site"></span></div>',
			'attributes'	=>	array(
				'placeholder'	=>	'http://www.google.com/',
			),
		) );

	}
	
	

	/*
	 *	Meta Box CSS / JS
	 *
	 *	Injects needed scripts/styles for our fields
	 *
	 *	@since 	v2.0
	 *
	*/
	function cmb2_metabox_scripts( $post_id, $cmb ) {
		?>
		<!-- Admin Form JS -->
		<script type="text/javascript">
			jQuery(document).ready(function($) { 
				
				// Wraps input fields to allow append/prepend content.
				$('.bne-cmb-wrapper input[type="text"], .bne-cmb-wrapper input[type="text_url"]').wrap('<div class="bne-input-wrap"></div>');
			
			});
		</script>	
		<?php
	}
	
} // END Class

	
// Initiate the Class
$BNE_Testimonials_CPT = new BNE_Testimonials_CPT();




/*
 *	Testimonial Text field Sanitize Callback
 *
 *	Allows minor html tags within the tagline textfield.
 *
 *	@since v2.0
 *
*/
function bne_testimonials_sanitize_text_callback( $value, $field_args, $field ) {

    /*
     *  strip_tags can allow whitelisted tags
     *  http://php.net/manual/en/function.strip-tags.php
    */
    $value = strip_tags( $value, '<i><b><br><strong>' );

    return $value;
}