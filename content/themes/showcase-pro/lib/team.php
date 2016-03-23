<?php

/**
 * Team Custom Post Type
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

/**
 * Register a team post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
add_action( 'init', 'showcase_team_init' );
function showcase_team_init() {

    //* Create the labels (output) for the team
    $labels = array(
        'name'                  => _x( 'Team', 'post type general name', 'showcase' ),
        'singular_name'         => _x( 'Team Member', 'post type singular name', 'showcase' ),
        'menu_name'             => _x( 'Team', 'admin menu', 'showcase' ),
        'name_admin_bar'        => _x( 'Team Member', 'add new on admin bar', 'showcase' ),
        'add_new'               => _x( 'Add New', 'team', 'showcase' ),
        'add_new_item'          => __( 'Add New Team Member', 'showcase' ),
        'new_item'              => __( 'New Team Member', 'showcase' ),
        'edit_item'             => __( 'Edit Team Member', 'showcase' ),
        'view_item'             => __( 'View Team Member', 'showcase' ),
        'all_items'             => __( 'All Team Members', 'showcase' ),
        'search_items'          => __( 'Search Team Members', 'showcase' ),
        'parent_item_colon'     => __( ' ', 'showcase' ),
        'not_found'             => __( 'No team members found.', 'showcase' ),
        'not_found_in_trash'    => __( 'No team members found in Trash.', 'showcase' )
    );

    $args = array(
        'labels'                => $labels,
        'description'           => __( 'Team Members', 'showcase' ),
        'public'                => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'show_ui'               => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'team' ),
        'capability_type'       => 'post',
        'hierarchical'          => false,
        'menu_position'         => null,
        'menu_icon'             => 'dashicons-groups',
        'taxonomies'            => array( 'category' ),
        'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'genesis-cpt-archives-settings' )
    );

    //* Register the post type
    register_post_type( 'team', $args );
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
add_filter( 'post_updated_messages', 'showcase_team_updated_messages' );
function showcase_team_updated_messages($messages) {

    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['team'] = array(
        0  => '', // Unused. Messages start at index 1
        1  => __( 'Team updated.', 'showcase' ),
        2  => __( 'Custom field updated.', 'showcase' ),
        3  => __( 'Custom field deleted.', 'showcase' ),
        4  => __( 'Team updated.', 'showcase' ),
        /* translators: %s: date and time of the revision */
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Team restored to revision from %s', 'showcase' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Team Member published.', 'showcase' ),
        7  => __( 'Team Member saved.', 'showcase' ),
        8  => __( 'Team Member submitted.', 'showcase' ),
        9  => sprintf(
            __( 'Team Member scheduled for: <strong>%1$s</strong>.', 'showcase' ),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i', 'showcase' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Team Member draft updated.', 'showcase' )

    );

    if ( $post_type_object->publicly_queryable ) {
        $permalink = get_permalink( $post->ID );

        $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View team member', 'showcase' ) );

        $messages[ $post_type ][1] .= $view_link;
        $messages[ $post_type ][6] .= $view_link;
        $messages[ $post_type ][9] .= $view_link;

        $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
        $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview team member', 'showcase' ) );
        $messages[ $post_type ][8]  .= $preview_link;
        $messages[ $post_type ][10] .= $preview_link;
    }

    return $messages;
}