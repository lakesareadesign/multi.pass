/**
 * This script adds notice dismissal to the Infinity Pro theme.
 *
 * @package Infinity\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.infinity-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'infinity_dismiss_woocommerce_notice'
		}
	});

});