<?php
/**
 * Showcase Pro
 *
 * This file adds the entry grid shortcode to the Showcase Pro Theme.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */
 
// Add Entry Grid Shortcode
add_shortcode( 'entry-grid', 'showcase_entry_grid_shortcode' );
function showcase_entry_grid_shortcode( $atts ) {
    
    global $post;

    extract( shortcode_atts( array(
        'limit'          => -1,
        'category'       => '',
        'name'           => '',
        'type'           => 'page',
        'id'             => $post->ID
    ), $atts ) );

    $args = array(
        'post_type'      => $type,
        'post_parent'	 => ($type == 'post') ? '' : $id,
        'posts_per_page' => $limit,
        'category_name'  => $category,
        'order'			 => 'ASC',
        'orderby'		 => 'menu_order',
        'paged'			 => get_query_var( 'paged' )
    );

	global $wp_query;

    $loop = new WP_Query( $args );

    ob_start();

    $i = 0;

    while ( $loop->have_posts() ) {

        $loop->the_post();

        $classes = ($i % 4 == 0) ? 'one-fourth first' : ' one-fourth';
        ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class($classes) ?>>
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'showcase' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                    <div class="overlay">
                        <div class="overlay-inner">
                            <div class="overlay-details">
                                <?php the_title( '<h4>', '</h4>' );?>
                            </div>
                        </div>
                    </div>
                    <?php if(has_post_thumbnail()) : the_post_thumbnail( 'showcase_entry_grid' ); endif; ?>
                </a>
            </div>
        <?php

        $i++;

    }

    $output = ob_get_clean();

    if ( $output ) {
        return '<div class="showcase-entry-grid">' . $output . '</div>';
    }

    wp_reset_query();

}