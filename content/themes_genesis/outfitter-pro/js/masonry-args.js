/**
 * This script adds the masonry jquery arguments to the front page of the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

(function( $ ) {

	$( document ).ready( function() {

		// Front page WooCommerce widget.
		var $products = $( '.front-page .content .woocommerce ul.products' );
		var $grid = $products.masonry({
			columnWidth: '.product:nth-child(2)',
			horizontalOrder: true,
			percentPosition: true
		});

		// Grid layout.
		$grid.imagesLoaded().progress( function() {
			$grid.masonry( 'layout' );
		});

	});

})(jQuery);
