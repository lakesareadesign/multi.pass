/**
 * This script adds notice dismissal to the Magazine Pro theme.
 *
 * @package Magazine\JS
 * @author StudioPress
 * @license GPL-2.0-or-later
 */

jQuery(document).on( 'click', '.magazine-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'magazine_dismiss_woocommerce_notice'
		}
	});

});
