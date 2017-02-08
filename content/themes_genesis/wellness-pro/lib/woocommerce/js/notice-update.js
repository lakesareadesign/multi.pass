/**
 * This script adds notice dismissal to the Wellness Pro theme.
 *
 * @package Wellness\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.wellness-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'wellness_dismiss_woocommerce_notice'
		}
	});

});