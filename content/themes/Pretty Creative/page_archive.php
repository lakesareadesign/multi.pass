<?php
 
//* Template Name: Custom Archive
 
//* Remove standard post content output
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
 
add_action( 'genesis_entry_content', 'fun_page_archive_content' );
add_action( 'genesis_post_content', 'fun_page_archive_content' );
/**
 * This function outputs posts grouped by year and then by months in descending order.
 *
 */
function fun_page_archive_content() {
 
	global $post;
	echo '<ul class="archives">';
		$lastposts = get_posts('numberposts=-1');
		$year = '';
		$month = '';
		foreach($lastposts as $post) :
			setup_postdata($post);
 
			if(ucfirst(get_the_time('F')) != $month && $month != ''){
				echo '</ul></li>';
			}
			if(get_the_time('Y') != $year && $year != ''){
				echo '</ul></li>';
			}
			if(get_the_time('Y') != $year){
				$year = get_the_time('Y');
				echo '<li><h2>' . $year . '</h2><ul class="monthly-archives">';
			}
			if(ucfirst(get_the_time('F')) != $month){
				$month = ucfirst(get_the_time('F'));
				echo '<li><h3>' . $month . '</h3><ul>';
			}
		?>
			<li>
				<span class="the_date"><?php the_time('d') ?>:</span>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php
}
 
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
 
genesis();