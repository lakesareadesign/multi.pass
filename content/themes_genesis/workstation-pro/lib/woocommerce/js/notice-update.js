/**
 * This script adds notice dismissal to the Workstation Pro theme.
 *
 * @package Workstation\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.workstation-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'workstation_dismiss_woocommerce_notice'
		}
	});

});
