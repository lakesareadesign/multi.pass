<?php
/**
 * Slush Pro.
 *
 * This file adds the video post format template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

$content = get_the_content(); 
$title = get_the_title();
$permalink = get_permalink();

wp_enqueue_script( 'jquery_fitvids' );

echo '<div class="media_container">';
	$embed = get_post_meta( $post->ID, 'zp_video_format_embed', true );
	if ( ! empty( $embed ) ) {
		echo stripslashes( htmlspecialchars_decode( $embed ) );
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".media_container").fitVids();
				});
			</script>
		<?php
	} else {
		echo zp_video( $post->ID, 'blog_gallery' );
	}
echo '</div>';

echo '<div class="content_container">';
	do_action( 'genesis_entry_header' );
	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		do_action( 'genesis_entry_content' );
	echo '</div>'; // Ends .entry-content.
	do_action( 'genesis_after_entry_content' );
	do_action( 'genesis_entry_footer' );
echo '</div>';
