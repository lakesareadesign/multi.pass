/**
 * This script adds notice dismissal to the Authority Pro theme.
 *
 * @package Authority\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.authority-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'authority_dismiss_woocommerce_notice'
		}
	});

});
