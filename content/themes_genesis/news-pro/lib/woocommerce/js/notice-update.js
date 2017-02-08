/**
 * This script adds notice dismissal to the News Pro theme.
 *
 * @package News\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.news-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'news_dismiss_woocommerce_notice'
		}
	});

});
