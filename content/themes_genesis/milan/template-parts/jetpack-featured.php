<?php
/**
 * The featured posts area.
 *
 * @package Milan
 */

// Get our Featured Content posts
$featured = milan_get_featured_content();
 
// If we have less than 5 posts, our work is done here
if ( count( $featured ) < 5 )
    return;

// Let's loop through our posts ?>
<div class="featured-area">
    <?php $i = 1; foreach ( $featured as $post ) : setup_postdata( $post ); ?>
        <?php if ( $i == 1 ) {
        	get_template_part( 'template-parts/jetpack-featured-primary' );
        } else {
        	if ( $i == 2 ) { echo '<div class="featured-row">'; }
        		get_template_part( 'template-parts/jetpack-featured-row' );
        	if ( $i == 5 ) { echo '</div>'; }
        } ?>
    <?php $i++; endforeach; ?>
</div><!-- .featured-area -->
<?php wp_reset_postdata(); ?>
