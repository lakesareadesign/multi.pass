/**
 * This script adds notice dismissal to the Daily Dish Pro theme.
 *
 * @package Daily Dish\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.daily-dish-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'daily_dish_dismiss_woocommerce_notice'
		}
	});

});
