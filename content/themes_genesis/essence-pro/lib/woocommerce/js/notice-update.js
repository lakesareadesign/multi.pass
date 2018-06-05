/**
 * This script adds notice dismissal to the Base Pro theme.
 *
 * @package Essence_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.essence-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'essence_dismiss_woocommerce_notice'
		}
	});

});
