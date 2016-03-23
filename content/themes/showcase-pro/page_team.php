<?php
/**
 * This file adds the Team page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro Theme
 * @link http://my.studiopress.com/themes/showcase/
 */

/*
Template Name: Team
*/

add_action( 'genesis_after_content_sidebar_wrap', 'showcase_team_grid' );
function showcase_team_grid() {

    remove_action( 'genesis_entry_footer', 'genesis_post_meta');

    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $loop = new WP_Query( array(
        'posts_per_page' => -1,
        'post_type'      => 'team',
        'order'          => 'ASC',
        'order_by'       => 'menu_order',
        'paged'          => $paged
    ) );

    if( $loop->have_posts() ) {

        echo $before_widget;

        // Testimonials
        echo '<div class="team-grid">';
        while( $loop->have_posts() ) {

            $loop->the_post();

            $class = ($i % 4 == 0) ? ' one-fourth first' : 'one-fourth';
            ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class($class) ?>>
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'showcase' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                    <div class="overlay">
                        <div class="overlay-inner">
                            <div class="overlay-details">
                                <?php the_title( '<h4>', '</h4>' );?>
                                <span>View Profile</span>
                            </div>
                        </div>
                    </div>
                    <?php if(has_post_thumbnail()) : the_post_thumbnail( 'showcase_team_thumb' ); endif; ?>
                </a>
            </div>


            <?php

            $i++;

        }

        echo '</div>';

        echo $after_widget;

    }
    wp_reset_postdata();
}

genesis();