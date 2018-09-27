/**
 * Trigger AJAX request to save state when the WooCommerce notice is dismissed.
 *
 * @version 1.0.0
 *
 * @author StudioPress
 * @license GPL-2.0+
 * @package Breakthrough_Pro
 */

jQuery(document).on( 'click', '.breakthrough-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'breakthrough_dismiss_woocommerce_notice'
		}
	});

});
