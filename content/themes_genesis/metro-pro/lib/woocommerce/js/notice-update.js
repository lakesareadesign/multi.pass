/**
 * This script adds notice dismissal to the Metro Pro theme.
 *
 * @package Metro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.metro-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'metro_dismiss_woocommerce_notice'
		}
	});

});
