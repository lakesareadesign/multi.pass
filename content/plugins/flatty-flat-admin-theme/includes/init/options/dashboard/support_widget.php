<?php
///////////////SHOW CUSTOMER SERVICE BOX WIDGET
add_action('wp_dashboard_setup','flatty_display_support_box_widget' );
function flatty_display_support_box_widget(){
	if (get_option('flatty_show_customer_service_box') == true && get_option('flatty_where_customer_service_box') === 'widget') {

		$customer_widget_title = get_option('flatty_show_customer_service_box_widget_title');

		wp_add_dashboard_widget(
			'customer_service',
			$customer_widget_title,
			'flatty_display_support_box_widget_display'
		);

	}

	function flatty_display_support_box_widget_display() {
		$customer_widget_name = get_option('flatty_show_customer_service_box_name');
		$customer_widget_website = get_option('flatty_show_customer_service_box_website');
		$customer_widget_email = get_option('flatty_show_customer_service_box_email');
		$customer_widget_phone = get_option('flatty_show_customer_service_box_phone');
		$customer_widget_description = get_option('flatty_show_customer_service_box_widget_description');
		echo '<div class="customer-widget-info">' . $customer_widget_name . '</div>';
		echo '<div class="customer-widget-info">' . $customer_widget_phone . '</div>';
		echo '<div class="customer-widget-info"><a href="' . $customer_widget_website . '" target="_blank">' . $customer_widget_website . '</a></div>';
		echo '<div class="customer-widget-info"><a href="mailto:' . $customer_widget_email . '" target="_blank">' . $customer_widget_email . '</a></div>';
    echo '<div class="customer-widget-description">' . $customer_widget_description . '</div>';
	}
}
?>
