<?php
/**
 * Slush Pro.
 *
 * This file adds the archive page template to the Slush Pro Theme.
 *
 * Template Name: Archive
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Removes the post entry content.
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Adds the custome entry content.
add_action( 'genesis_entry_content', 'zp_custom_archive_template' );
add_action( 'genesis_post_content', 'zp_custom_archive_template' );
function zp_custom_archive_template() { ?>

	<div class="class="col-md-12 col-sm-12 col-xs-12"">
		<h4><?php _e( 'Pages:', 'slush-pro' ); ?></h4>
		<ul>
			<?php wp_list_pages( 'title_li=' ); ?>
		</ul>

		<h4><?php _e( 'Categories:', 'slush-pro' ); ?></h4>
		<ul>
			<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
		</ul>
	</div>

	<div class="class="col-md-12 col-sm-12 col-xs-12"">
		<h4><?php _e( 'Authors:', 'slush-pro' ); ?></h4>
		<ul>
			<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
		</ul>

		<h4><?php _e( 'Monthly:', 'slush-pro' ); ?></h4>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>

		<h4><?php _e( 'Recent Posts:', 'slush-pro' ); ?></h4>
		<ul>
			<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
		</ul>
	</div>

<?php
}

// Runs the Genesis loop.
genesis();
