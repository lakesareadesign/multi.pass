/**
 * This script adds notice dismissal to the Atmosphere Pro theme.
 *
 * @package Atmosphere\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.atmosphere-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'atmosphere_dismiss_woocommerce_notice'
		}
	});

});