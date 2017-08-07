<?php
///////////////SHOW SUPPORT WIDGET
add_action('admin_head','flatty_support_widget' );
function flatty_support_widget(){
	if (get_option('flatty_support_widget_show') == true && get_option('flatty_support_widget_placement') === 'panel') {

		if (get_option('flatty_fixed_topbar') == true) {
			echo '<div class="flatty-support-widget-fixed"></div>';
			if (get_option('flatty_tall_topbar') == true) {
				echo '<div class="flatty-support-widget fixed" style="top:180px;">';
			} else {
				echo '<div class="flatty-support-widget fixed" style="top:70px;">';
			}
		} else {
			echo '<div class="flatty-support-widget">';
		}

			if (get_option('flatty_support_widget_firstname') !== '') {
				$support_name = get_option('flatty_support_widget_firstname') . " " . get_option('flatty_support_widget_lastname');
				echo '<div class="flatty-support-widget-name">' . $support_name . '</div>';
			}

			echo '<div class="flatty-support-widget-wrapper">';
				if (get_option('flatty_support_widget_website') !== '') {
					$support_website = get_option('flatty_support_widget_website');
					echo '<a class="flatty-support-widget-icon" href="' . $support_website . '" target="_blank" title="'. $support_website .'"><i class="dashicons dashicons-admin-site"></i>'. $support_website .'</a>';
				}
				if (get_option('flatty_support_widget_email') !== '') {
					$support_email = get_option('flatty_support_widget_email');
					echo '<a class="flatty-support-widget-icon" href="mailto:' . $support_email . '" title="'. $support_email .'"><i class="dashicons dashicons-email"></i>'. $support_email .'</a>';
				}
				if (get_option('flatty_support_widget_phone') !== '') {
					$support_phone = get_option('flatty_support_widget_phone');
					echo '<a class="flatty-support-widget-icon" href="tel:' . $support_phone . '"><i class="dashicons dashicons-phone"></i>' . $support_phone . '</a>';
				}
			echo '</div>';

		echo '</div>';
	}
}
?>