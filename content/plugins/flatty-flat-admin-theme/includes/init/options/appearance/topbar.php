<?php
add_action( 'admin_head', 'flatty_use_flatty_topbar' );
function flatty_use_flatty_topbar(){

	if (get_option('flatty_use_flatty_topbar') == true) {
		add_filter( 'admin_body_class', 'add_flatty_body_class' );

		function add_flatty_body_class( $classex ) {
			if (get_option('flatty_tall_topbar') == true) {
				$classex .= ' ' . 'flatty_top_bar flatty_tall_bar';
			} else {
				$classex .= ' ' . 'flatty_top_bar';
			}
			
		    return $classex; 
		}
	}

	if (get_option('flatty_use_flatty_topbar') == true) {
		$tallbar = '';
		$custom_bkg_color = '';
		$custom_bkg_image_url = '';
		$custom_bkg_image = '';
		$custom_bkg_type = '';
		$custom_bkg_blend = '';

		echo '<style type="text/css">#wpadminbar{display: none;}</style>';

		///CHECK TALL BAR
		if (get_option('flatty_tall_topbar') == true) {
			$tallbar = "tall-bar";
		};

		///CHECK BACKGROUND CUSTOM
		if (get_option('flatty_topbar_background_custom') == true) {
			if (get_option('flatty_topbar_background_color') != '') { 
				$custom_bkg_color = 'background-color:' . get_option('flatty_topbar_background_color') . ';';
			};
			if (get_option('flatty_topbar_background_type') == 'image') { 
				$custom_bkg_type = 'background-size:cover;background-repeat:no-repeat;background-position:center;';
			} elseif (get_option('flatty_topbar_background_type') == 'pattern') {
				$custom_bkg_type = 'background-repeat:repeat;background-size: contain;';
			} else {
				$custom_bkg_type = '';
			};
			if (get_option('flatty_topbar_background_blend') != '') {
				$custom_bkg_blend = "background-blend-mode:" . get_option('flatty_topbar_background_blend');
			} else {
				$custom_bkg_blend = '';
			}
			if (get_option('flatty_topbar_background_image') != '') { 
				$custom_bkg_image_url = get_option('flatty_topbar_background_image');
				$custom_bkg_image = "background-image:url(' ". $custom_bkg_image_url ." '); " . $custom_bkg_type . $custom_bkg_blend . "";
			};
			echo '<div id="flatty-adminbar" class="flatty-top-bar ' . $tallbar . '" style=" ' . $custom_bkg_color . $custom_bkg_image .' ">';
		} else {
			echo '<div id="flatty-adminbar" class="flatty-top-bar ' . $tallbar . '">';
		}

		echo '
		<div class="flatty-top-bar-left-wrapper">
		<div class="flatty-top-bar-button" id="flatty-hide-menu"><i class="dashicons dashicons-menu"></i></div>
		';

		///CHECK CUSTOM LOGO
		if (get_option('flatty_custom_logo') != '' && get_option('flatty_hide_custom_logo') == false) {
			$custom_logo = get_option('flatty_custom_logo');
			echo '<div class="flatty-top-bar-logo"><img src="' . $custom_logo . '"/></div>';
		};

		///CHECK SITENAME
		if (get_option('flatty_show_sitename') == true) {
			if (get_option('flatty_show_custom_sitename') != '') {
				$current_site = get_option('flatty_show_custom_sitename');
			} else {
				$current_site = get_option('blogname');
			}
			echo '<div class="flatty-site-name-topbar">' . $current_site . '</div>';
		};

		echo '</div>';

		///CHECK BUSINESS CARD
		if (get_option('flatty_business_card_show_topbar') == true) {
			echo '<div class="flatty-topbar-box">';

				
				if (get_option('flatty_business_card_company_show') == true) {
					$card_company = get_option('flatty_business_card_company');
					echo '<div class="flatty-topbar-box-name">' . $card_company . '</div>';
				} elseif (get_option('flatty_business_card_firstname') !== '') {
					$card_name = get_option('flatty_business_card_firstname');
					$card_lastname = get_option('flatty_business_card_lastname');
					echo '<div class="flatty-topbar-box-name">' . $card_name . " " . $card_lastname . '</div>';
				}

				echo '<div class="flatty-topbar-box-wrapper">';
					if (get_option('flatty_business_card_website') !== '') {
						$card_website = get_option('flatty_business_card_website');
						echo '<a class="flatty-topbar-box-icon" href="' . $card_website . '" target="_blank" title="'. $card_website .'"><i class="dashicons dashicons-admin-site"></i></a>';
					}
					if (get_option('flatty_business_card_email') !== '') {
						$card_email = get_option('flatty_business_card_email');
						echo '<a class="flatty-topbar-box-icon" href="mailto:' . $card_email . '" title="'. $card_email .'"><i class="dashicons dashicons-email"></i></a>';
					}
					if (get_option('flatty_business_card_phone') !== '') {
						$card_phone = get_option('flatty_business_card_phone');
						echo '<a class="flatty-topbar-box-icon" href="tel:' . $card_phone . '"><i class="dashicons dashicons-phone"></i></a>';
					}
				echo '</div>';

			echo '</div>';
		}

		///INSERT RIGHT WRAPPER
		echo '<div class="flatty-top-bar-wrapper">';
		$pagelink = get_permalink();

		echo '
			<a class="flatty-top-bar-button" target="_blank" href="' . get_home_url() . '"><i class="dashicons dashicons-laptop"></i><span>' . __( "View Site", "flatty-flat-admin-theme" ) . '</span></a>';

			if ($pagelink !== false) {
				echo '<a class="flatty-top-bar-button" target="_blank" href="' . $pagelink . '"><i class="dashicons dashicons-media-document"></i><span>' . __( "View", "flatty-flat-admin-theme" ) . '</span></a>';
			}
			
		///CHECK PROFILE
		if (get_option('flatty_show_topbar_profile') == true) {
			if (is_user_logged_in()) {
				$current_user = wp_get_current_user();

				if ( !($current_user instanceof WP_User) )
   				return;

   				if (get_option('flatty_show_topbar_image') == true) {
   					$userAvatar = get_avatar($current_user->user_email, 40);

      				echo '<a class="flatty-top-bar-button profile-pic" href="' . admin_url( 'profile.php' ) . '" style="padding:0; width: 40px; height: 40px; border-radius: 50%; overflow: hidden;">' .  $userAvatar . '</a>';
      				echo '<a class="flatty-top-bar-button profile-name" href="' . admin_url( 'profile.php' ) . '"> ' .  $current_user->user_firstname . ' ' . $current_user->user_lastname . '</a>';
   				} else {
   					echo '<a class="flatty-top-bar-button" href="' . admin_url( 'profile.php' ) . '"><i class="dashicons dashicons-admin-users"></i> ' .  $current_user->user_firstname . ' ' . $current_user->user_lastname . '</a>';
   				}
			}
		}

		echo '<a class="flatty-top-bar-button" href="' . wp_logout_url() . '"><i class="dashicons dashicons-migrate"></i><span>' . __( "Logout", "flatty-flat-admin-theme" ) . '</span></a>
			</div>
		</div>';
	}
}

?>