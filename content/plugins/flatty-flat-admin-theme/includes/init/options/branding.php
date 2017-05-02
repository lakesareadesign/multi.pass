<?php
///////////////SHOW SITE NAME
function flatty_display_site_name(){
	if (get_option('flatty_show_sitename') == true) {
		if (get_option('flatty_show_custom_sitename') !== '') {
			$current_site = get_option('flatty_show_custom_sitename');
		} else {
			$current_site = get_option('blogname');
		}
		if (get_option('flatty_where_sitename') === 'h-small') {
			echo '<div class="flatty-site-name small">' . $current_site . '</div>';
		} elseif(get_option('flatty_where_sitename') === 'h-big') {
			echo '<div class="flatty-site-name">' . $current_site . '</div>';
		}
	}
}
add_action('admin_head','flatty_display_site_name' );

function flatty_hide_wordpress_toolbar(){
	if (get_option('flatty_hide_worpdress_toolbar_frontend') == true) {
		add_filter('show_admin_bar', '__return_false');
		echo '<style type="text/css">tr.show-admin-bar{display:none!important}</style>';
	};
}
add_action( 'admin_head', 'flatty_hide_wordpress_toolbar' );

///////////////USE FLATTY TOPBAR
function flatty_use_flatty_topbar(){

	if (get_option('flatty_use_flatty_topbar') == true) {
		add_filter( 'admin_body_class', 'add_flatty_body_class' );
		function add_flatty_body_class( $classex ) {
			$classex .= ' ' . 'flatty_top_bar';
		    return $classex; 
		}
	}

	if (get_option('flatty_use_flatty_topbar') == true) {
		if (get_option('flatty_topbar_background_custom') == true) { 
			if (get_option('flatty_topbar_background_color') !== '') { 
				$custom_bkg_color = 'background-color:' . get_option('flatty_topbar_background_color') . ';';
			}
			if (get_option('flatty_topbar_background_image') !== '') { 
				$custom_bkg_image_url = get_option('flatty_topbar_background_image');
				$custom_bkg_image = "background-image:url(' ". $custom_bkg_image_url ." '); background-size:cover; background-repeat:no-repeat; background-position:center; background-blend-mode: overlay;";
			}
		}
	}

	if (get_option('flatty_use_flatty_topbar') == true) {
		echo '<style type="text/css">#wpadminbar{display: none;}</style>';
		echo '<div class="flatty-top-bar" style=" ' . $custom_bkg_color . $custom_bkg_image .' ">';

		///CHECK CUSTOM LOGO
		if (get_option('flatty_custom_logo') !== '' && get_option('flatty_hide_custom_logo') == false) {
			$custom_logo = get_option('flatty_custom_logo');
			echo '<div class="flatty-top-bar-logo"><img src="' . $custom_logo . '"/></div>';
		};

		///CHECK SITENAME
		if (get_option('flatty_show_sitename') == true) {
			if (get_option('flatty_where_sitename') === 'topbar') {
				if (get_option('flatty_show_custom_sitename') !== '') {
					$current_site = get_option('flatty_show_custom_sitename');
				} else {
					$current_site = get_option('blogname');
				}
				echo '<div class="flatty-site-name-topbar">' . $current_site . '</div>';
			};
		}

		///CHECK SUPPORT BOX
		if (get_option('flatty_show_customer_service_box') == true && get_option('flatty_where_customer_service_box') === 'topbar') {
			echo '<div class="flatty-topbar-box">';

				if (get_option('flatty_show_customer_service_box_name') !== '') {
					$support_name = get_option('flatty_show_customer_service_box_name');
					echo '<div class="flatty-topbar-box-name">' . $support_name . '</div>';
				}

				echo '<div class="flatty-topbar-box-wrapper">';
					if (get_option('flatty_show_customer_service_box_website') !== '') {
						$support_website = get_option('flatty_show_customer_service_box_website');
						echo '<a class="flatty-topbar-box-icon" href="' . $support_website . '" target="_blank" title="'. $support_website .'"><i class="dashicons dashicons-admin-site"></i></a>';
					}
					if (get_option('flatty_show_customer_service_box_email') !== '') {
						$support_email = get_option('flatty_show_customer_service_box_email');
						echo '<a class="flatty-topbar-box-icon" href="mailto:' . $support_email . '" title="'. $support_email .'"><i class="dashicons dashicons-email"></i></a>';
					}
					if (get_option('flatty_show_customer_service_box_phone') !== '') {
						$support_phone = get_option('flatty_show_customer_service_box_phone');
						echo '<a class="flatty-topbar-box-icon" href="tel:' . $support_phone . '"><i class="dashicons dashicons-phone"></i></a>';
					}
				echo '</div>';

			echo '</div>';
		}

		///INSERT RIGHT WRAPPER
		echo '<div class="flatty-top-bar-wrapper">';
		$pagelink = get_permalink();

		echo '
			<div class="flatty-top-bar-button" id="flatty-hide-menu"><i class="dashicons dashicons-editor-expand"></i>' . __( "Hide Sidebar", "flatty-flat-admin-theme" ) . '</div>
			<a class="flatty-top-bar-button" target="_blank" href="' . get_home_url() . '"><i class="dashicons dashicons-laptop"></i>' . __( "View Site", "flatty-flat-admin-theme" ) . '</a>';

			if ($pagelink !== false) {
				echo '<a class="flatty-top-bar-button" target="_blank" href="' . $pagelink . '"><i class="dashicons dashicons-media-document"></i>' . __( "View", "flatty-flat-admin-theme" ) . '</a>';
			}
			
		///CHECK PROFILE
		if (get_option('flatty_show_topbar_profile') == true) {
			if (is_user_logged_in()) {
				$current_user = wp_get_current_user();

				if ( !($current_user instanceof WP_User) )
   				return;

   				if (get_option('flatty_show_topbar_image') == true) {
   					$userAvatar = get_avatar($current_user->user_email, 40);

      				echo '<div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; margin-left:20px;">' .  $userAvatar . '</div>';
      				echo '<a class="flatty-top-bar-button" href="' . admin_url( 'profile.php' ) . '" style="padding-left:10px;"> ' .  $current_user->user_firstname . ' ' . $current_user->user_lastname . '</a>';
   				} else {
   					echo '<a class="flatty-top-bar-button" href="' . admin_url( 'profile.php' ) . '"><i class="dashicons dashicons-admin-users"></i> ' .  $current_user->user_firstname . ' ' . $current_user->user_lastname . '</a>';
   				}

      			

			}
		}

		echo '<a class="flatty-top-bar-button" href="' . wp_logout_url() . '"><i class="dashicons dashicons-migrate"></i>' . __( "Logout", "flatty-flat-admin-theme" ) . '</a>
			</div>
		</div>';
	}
}
add_action( 'admin_head', 'flatty_use_flatty_topbar' );

///////////////SHOW CUSTOMER SERVICE BOX PANEL
function flatty_display_support_box_panel(){
	if (get_option('flatty_show_customer_service_box') == true && get_option('flatty_where_customer_service_box') === 'panel') {
		wp_register_style('flatty-addons-supportbox', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/addons/flatty-addons-supportbox.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-addons-supportbox');

		echo '<div class="flatty-support-box">';

			if (get_option('flatty_show_customer_service_box_name') !== '') {
				$support_name = get_option('flatty_show_customer_service_box_name');
				echo '<div class="flatty-support-box-name">' . $support_name . '</div>';
			}

			echo '<div class="flatty-support-box-wrapper">';
				if (get_option('flatty_show_customer_service_box_website') !== '') {
					$support_website = get_option('flatty_show_customer_service_box_website');
					echo '<a class="flatty-support-box-icon" href="' . $support_website . '" target="_blank" title="'. $support_website .'"><i class="dashicons dashicons-admin-site"></i>'. $support_website .'</a>';
				}
				if (get_option('flatty_show_customer_service_box_email') !== '') {
					$support_email = get_option('flatty_show_customer_service_box_email');
					echo '<a class="flatty-support-box-icon" href="mailto:' . $support_email . '" title="'. $support_email .'"><i class="dashicons dashicons-email"></i>'. $support_email .'</a>';
				}
				if (get_option('flatty_show_customer_service_box_phone') !== '') {
					$support_phone = get_option('flatty_show_customer_service_box_phone');
					echo '<a class="flatty-support-box-icon" href="tel:' . $support_phone . '"><i class="dashicons dashicons-phone"></i>' . $support_phone . '</a>';
				}
			echo '</div>';

		echo '</div>';
	}
}
add_action('admin_head','flatty_display_support_box_panel' );

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

///////////////SHOW CUSTOM FAVICON
function flatty_display_custom_favicon(){
	if (get_option('flatty_custom_favicon') == true) {
	  	$favicon_url = get_option('flatty_custom_favicon');
		echo '<link rel="icon" href="' . $favicon_url . '" />';
	}
}
add_action('login_head', 'flatty_display_custom_favicon');
add_action('admin_head', 'flatty_display_custom_favicon');

///////////////USE SYSTEM FONT
function flatty_use_system_font(){
	if (get_option('flatty_system_font') == false) {
		wp_enqueue_style('flatty-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700');
		echo '<style> body{font-family:"Source Sans Pro", -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif} </style>';
	}
}
add_action( 'admin_head', 'flatty_use_system_font' );

///////////////HIDE WORDPRESS TOPBAR LOGO
function flatty_hide_wp_topbar_logo(){
	if (get_option('flatty_wp_hide_topbar_logo') == true) {
		echo '<style> #wp-admin-bar-wp-logo{display: none!important;} </style>';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_topbar_logo' );

///////////////ENABLE FOLDED SIDEBAR
add_action( 'admin_head', 'flatty_enable_folded_sidebar' );
function flatty_enable_folded_sidebar(){
	if (get_option('flatty_sidebar_folded') == true) {
	echo '<script type="text/javascript">
			jQuery(document).ready( function($) {
				jQuery("body").addClass("folded");
			});
         </script>';
	}
}

///////////////FOOTER OPTIONS
if (get_option('flatty_wp_flatty_footer_show') == true) {

	function flatty_wp_flatty_remove_footer(){
		echo '<style> #wpfooter {display:none;}</style>';
	}
	add_action('admin_head', 'flatty_wp_flatty_remove_footer');

	function flatty_custom_footer() {
		echo '<div class="flatty-custom-footer">';

			if (get_option('flatty_wp_flatty_footer_custom_text') !== '') {
				$custom_text = get_option('flatty_wp_flatty_footer_custom_text');
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-info"></i>' . $custom_text . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_wordpress') == true) {
				$blogversion = get_bloginfo('version');
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-wordpress-alt"></i>' . $blogversion . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_mysql') == true) {
				$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD );
				$mysql_server = explode( '-', mysqli_get_server_info( $mysqli ) );
				$mysqli->close();
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">MYSQL</i>' . $mysql_server[0] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_php') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">PHP</i>' . phpversion() . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_protocol') == true) {
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-admin-site"></i>' . $_SERVER['SERVER_PROTOCOL'] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_address') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">IP</i>' . $_SERVER['SERVER_ADDR'] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_software') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">INFO</i>' . $_SERVER['SERVER_SOFTWARE'] . '</div>';
			}


		echo '</div>';
	}
	add_action('admin_footer', 'flatty_custom_footer');
}
?>
