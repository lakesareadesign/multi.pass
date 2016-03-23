<?php

/**
 * Testimonials Custom Post Type
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

/**
 * Register a testimonials post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
add_action( 'init', 'showcase_testimonials_init' );
function showcase_testimonials_init() {

    //* Create the labels (output) for the testimonials
    $labels = array(
        'name'                  => _x( 'Testimonials', 'post type general name', 'showcase' ),
        'singular_name'         => _x( 'Testimonial', 'post type singular name', 'showcase' ),
        'menu_name'             => _x( 'Testimonials', 'admin menu', 'showcase' ),
        'name_admin_bar'        => _x( 'Testimonial', 'add new on admin bar', 'showcase' ),
        'add_new'               => _x( 'Add New', 'testimonial', 'showcase' ),
        'add_new_item'          => __( 'Add New Testimonial', 'showcase' ),
        'new_item'              => __( 'New Testimonial', 'showcase' ),
        'edit_item'             => __( 'Edit Testimonial', 'showcase' ),
        'view_item'             => __( 'View Testimonial', 'showcase' ),
        'all_items'             => __( 'All Testimonials', 'showcase' ),
        'search_items'          => __( 'Search Testimonials', 'showcase' ),
        'parent_item_colon'     => __( ' ', 'showcase' ),
        'not_found'             => __( 'No testimonials found.', 'showcase' ),
        'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'showcase' )
    );

    $args = array(
        'labels'                => $labels,
        'description'           => __( 'Testimonials', 'showcase' ),
        'public'                => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'show_ui'               => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'testimonials' ),
        'capability_type'       => 'post',
        'hierarchical'          => false,
        'menu_position'         => null,
        'menu_icon'             => 'dashicons-testimonial',
        'taxonomies'            => array( 'category' ),
        'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'genesis-cpt-archives-settings' )
    );

    //* Register the post type
    register_post_type( 'testimonials', $args );
}



/**
 * Testimonial update messages
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
add_filter( 'post_updated_messages', 'showcase_testimonial_updated_messages' );
function showcase_testimonial_updated_messages($messages) {

    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['testimonials'] = array(
        0  => '', // Unused. Messages start at index 1
        1  => __( 'Testimonial updated.', 'showcase' ),
        2  => __( 'Custom field updated.', 'showcase' ),
        3  => __( 'Custom field deleted.', 'showcase' ),
        4  => __( 'Testimonial updated.', 'showcase' ),
        /* translators: %s: date and time of the revision */
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonial restored to revision from %s', 'showcase' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Testimonial published.', 'showcase' ),
        7  => __( 'Testimonial saved.', 'showcase' ),
        8  => __( 'Testimonial submitted.', 'showcase' ),
        9  => sprintf(
            __( 'Testimonial scheduled for: <strong>%1$s</strong>.', 'showcase' ),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i', 'showcase' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Testimonial draft updated.', 'showcase' )

    );

    if ( $post_type_object->publicly_queryable ) {
        $permalink = get_permalink( $post->ID );

        $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View testimonial', 'showcase' ) );

        $messages[ $post_type ][1] .= $view_link;
        $messages[ $post_type ][6] .= $view_link;
        $messages[ $post_type ][9] .= $view_link;

        $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
        $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview testimonial', 'showcase' ) );
        $messages[ $post_type ][8]  .= $preview_link;
        $messages[ $post_type ][10] .= $preview_link;
    }

    return $messages;
}

//* Testimonials Shortcode
add_shortcode( 'testimonials', 'showcase_testimonials_showcase' );
function showcase_testimonials_showcase( $atts ) {

    remove_action( 'genesis_entry_footer', 'genesis_post_meta');

    extract( shortcode_atts( array(
        'limit'     => -1,
        'category'  => '',
    ), $atts ) );

    // Setting up query to show the loop
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'testimonials',
        'category_name' => $category,
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'paged' => $paged
    );

    $loop = new WP_Query( $args );

    ob_start();

    $i = 0;

    while ( $loop->have_posts() ) {

        $loop->the_post();

        $quote = get_the_content();
        $name = get_the_title();
        $image = get_the_post_thumbnail( '', array( 100, 100) );

        ?>

            <li id="post-<?php the_ID(); ?>" <?php post_class($class) ?>>
                <blockquote><?php echo $quote; ?></blockquote>
                <div class="testimonial-source">
                    <?php if( has_post_thumbnail() ) : echo $image; endif; ?>
                    <h5><?php echo $name; ?></h5>
                </div>
            </li>

        <?php

        $i++;

    }

    $output = ob_get_clean();

    if ( $output )
        return '<ul class="testimonial-slider">' . $output . '</ul>';

    wp_reset_query();

}