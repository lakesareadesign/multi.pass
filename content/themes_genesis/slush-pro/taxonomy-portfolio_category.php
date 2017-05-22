<?php 
/**
 * Slush Pro.
 *
 * This file adds the Portfolio taxonomy template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Forces page to full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Removes breadcrumbs.
remove_action(  'genesis_before_content', 'genesis_do_breadcrumbs'  );

// Removes the default Genesis loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Adds custom loop.
add_action(	'genesis_loop', 'zp_portfolio_taxonomy_template' );
function zp_portfolio_taxonomy_template() {

	// Gets Portfolio Category.
	$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );

	echo '<section class="layout_section portfolio_category_layout"><div class="container">';
	echo zp_portfolio_output( -1, 3, false, $term->slug, true );
	echo '</div></section>';

}

// Runs the Genesis loop.
genesis();
