/**
 * This script adds notice dismissal to the Parallax Pro theme.
 *
 * @package Parallax\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.parallax-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'parallax_dismiss_woocommerce_notice'
		}
	});

});