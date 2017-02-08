/**
 * This script adds notice dismissal to the Executive Pro theme.
 *
 * @package Executive\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.executive-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'executive_dismiss_woocommerce_notice'
		}
	});

});