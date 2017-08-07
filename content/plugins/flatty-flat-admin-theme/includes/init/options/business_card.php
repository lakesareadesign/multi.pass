<?php
///////////////ADD BUSINESS CARD TO DASHBOARD
if (get_option('flatty_business_card_show_dashboard') == true) {
	add_action('wp_dashboard_setup', 'business_card_widget');

	function business_card_widget() {
		global $wp_meta_boxes;
		if (get_option('flatty_business_card_widget_title') !== false) {
			$widgetTitle = get_option('flatty_business_card_widget_title');
			wp_add_dashboard_widget('flatty_business_card_widget', $widgetTitle, 'business_card_widget_html');
		} else {
			wp_add_dashboard_widget('flatty_business_card_widget', 'Business Card', 'business_card_widget_html');
		}
	}

	function business_card_widget_html() {
		$widgetPicture = "";
		$widgetCompany = "";
		$widgetName = "";
		$widgetLastname = "";
		$widgetPhone = "";
		$widgetEmail = "";
		$widgetWebsite = "";

		if (get_option('flatty_business_card_picture') !== false) {
			$widgetPicture = "<img width='150' height='150' class='card-picture' src='" . get_option('flatty_business_card_picture') . "'>";
		}
		if (get_option('flatty_business_card_company') !== false) {
			$widgetCompany = "<div class='card-company'>" . get_option('flatty_business_card_company') . "</div>";
		}
		if (get_option('flatty_business_card_firstname') !== false) {
			$widgetFirstname = "<div class='card-firstname'>" . get_option('flatty_business_card_firstname') . " " . get_option('flatty_business_card_lastname') . "</div>";
		}
		if (get_option('flatty_business_card_phone') !== false) {
			$widgetPhone = "<a class='card-icon' href='tel:" . get_option('flatty_business_card_phone') . "'><i class='dashicons dashicons-phone'></i></a>";
		}
		if (get_option('flatty_business_card_email') !== false) {
			$widgetEmail = "<a class='card-icon' href='mailto:" . get_option('flatty_business_card_email') . "'><i class='dashicons dashicons-email'></i></a>";
		}
		if (get_option('flatty_business_card_website') !== false) {
			$widgetWebsite = "<a class='card-icon' href='" . get_option('flatty_business_card_website') . "'><i class='dashicons dashicons-admin-site'></i></a>";
		}


		echo '
		<div class="business_card_widget_content">
			<div class="business_card_widget_inner">
		' . $widgetPicture . '<div class="business_card_widget_data">' . $widgetCompany . $widgetFirstname . $widgetLastname . '<div style="margin-top:10px;">' . $widgetPhone . $widgetEmail . $widgetWebsite . '</div>' .'
			</div>
			</div>
		</div>
		';
	}
}


?>
