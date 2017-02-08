/**
 * This script adds notice dismissal to the Smart Passive Income Pro theme.
 *
 * @package Smart Passive Income Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.spi-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'spi_dismiss_woocommerce_notice'
		}
	});

});