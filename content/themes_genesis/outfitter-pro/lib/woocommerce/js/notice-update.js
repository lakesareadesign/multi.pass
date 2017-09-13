/**
 * This script adds notice dismissal to the Outfitter Pro theme.
 *
 * @package Outfitter_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.outfitter-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'outfitter_dismiss_woocommerce_notice'
		}
	});

});
