<?php
/**
 * A class to serve static data
 *
 * Class Opt_In_Static
 */
if ( ! class_exists( 'Opt_In_Static', false ) ) {

	class Opt_In_Static {

		/**
		 * Returns animations
		 * Returns Popup Pro animations if it's installed and active
		 *
		 *
		 * @return object
		 */
		public function get_animations() {

			$animations_in = array(
				''                                        => array(
					'' => __( 'No Animation', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Bouncing Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'bounceIn'      => __( 'Bounce In', Opt_In::TEXT_DOMAIN ),
					'bounceInUp'    => __( 'Bounce In Up', Opt_In::TEXT_DOMAIN ),
					'bounceInRight' => __( 'Bounce In Right', Opt_In::TEXT_DOMAIN ),
					'bounceInDown'  => __( 'Bounce In Down', Opt_In::TEXT_DOMAIN ),
					'bounceInLeft'  => __( 'Bounce In Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Fading Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'fadeIn'      => __( 'Fade In', Opt_In::TEXT_DOMAIN ),
					'fadeInUp'    => __( 'Fade In Up', Opt_In::TEXT_DOMAIN ),
					'fadeInRight' => __( 'Fade In Right', Opt_In::TEXT_DOMAIN ),
					'fadeInDown'  => __( 'Fade In Down', Opt_In::TEXT_DOMAIN ),
					'fadeInLeft'  => __( 'Fade In Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Falling Entrances', Opt_In::TEXT_DOMAIN )  => array(
					'fall'     => __( 'Fall In', Opt_In::TEXT_DOMAIN ), // MISSING
					'sidefall' => __( 'Fade In Side', Opt_In::TEXT_DOMAIN ), // MISSING
				),
				__( 'Rotating Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'rotateIn'          => __( 'Rotate In', Opt_In::TEXT_DOMAIN ),
					'rotateInDownLeft'  => __( 'Rotate In Down Left', Opt_In::TEXT_DOMAIN ),
					'rotateInDownRight' => __( 'Rotate In Down Right', Opt_In::TEXT_DOMAIN ),
					'rotateInUpLeft'    => __( 'Rotate In Up Left', Opt_In::TEXT_DOMAIN ),
					'rotateInUpRight'   => __( 'Rotate In Up Right', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Sliding Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'slideInUp'    => __( 'Slide In Up', Opt_In::TEXT_DOMAIN ),
					'slideInRight' => __( 'Slide In Right', Opt_In::TEXT_DOMAIN ),
					'slideInDown'  => __( 'Slide In Down', Opt_In::TEXT_DOMAIN ),
					'slideInLeft'  => __( 'Slide In Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Zoom Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'zoomIn'      => __( 'Zoom In', Opt_In::TEXT_DOMAIN ),
					'zoomInUp'    => __( 'Zoom In Up', Opt_In::TEXT_DOMAIN ),
					'zoomInRight' => __( 'Zoom In Right', Opt_In::TEXT_DOMAIN ),
					'zoomInDown'  => __( 'Zoom In Down', Opt_In::TEXT_DOMAIN ),
					'zoomInLeft'  => __( 'Zoom In Left', Opt_In::TEXT_DOMAIN ),
					'scaled'      => __( 'Super Scaled', Opt_In::TEXT_DOMAIN ), // MISSING
				),
				__( '3D Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'sign wpoi-modal'    => __( '3D Sign', Opt_In::TEXT_DOMAIN ), // MISSING
					'slit wpoi-modal'    => __( '3D Slit', Opt_In::TEXT_DOMAIN ), // MISSING
					'flipx wpoi-modal'   => __( '3D Flip (Horizontal)', Opt_In::TEXT_DOMAIN ), // MISSING
					'flipy wpoi-modal'   => __( '3D Flip (Vertical)', Opt_In::TEXT_DOMAIN ), // MISSING
					'rotatex wpoi-modal' => __( '3D Rotate (Left)', Opt_In::TEXT_DOMAIN ), // MISSING
					'rotatey wpoi-modal' => __( '3D Rotate (Bottom)', Opt_In::TEXT_DOMAIN ), // MISSING
				),
				__( 'Special Entrances', Opt_In::TEXT_DOMAIN ) => array(
					'rollIn'       => __( 'Roll In', Opt_In::TEXT_DOMAIN ),
					'lightSpeedIn' => __( 'Light Speed In', Opt_In::TEXT_DOMAIN ),
					'newspaperIn'  => __( 'Newspaper In', Opt_In::TEXT_DOMAIN ),
				),
			);

			$animations_out = array(
				''                                         => array(
					'' => __( 'No Animation', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Bouncing Exits', Opt_In::TEXT_DOMAIN ) => array(
					'bounceOut'      => __( 'Bounce Out', Opt_In::TEXT_DOMAIN ),
					'bounceOutUp'    => __( 'Bounce Out Up', Opt_In::TEXT_DOMAIN ),
					'bounceOutRight' => __( 'Bounce Out Right', Opt_In::TEXT_DOMAIN ),
					'bounceOutDown'  => __( 'Bounce Out Down', Opt_In::TEXT_DOMAIN ),
					'bounceOutLeft'  => __( 'Bounce Out Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Fading Exits', Opt_In::TEXT_DOMAIN )  => array(
					'fadeOut'      => __( 'Fade Out', Opt_In::TEXT_DOMAIN ),
					'fadeOutUp'    => __( 'Fade Out Up', Opt_In::TEXT_DOMAIN ),
					'fadeOutRight' => __( 'Fade Out Right', Opt_In::TEXT_DOMAIN ),
					'fadeOutDown'  => __( 'Fade Out Down', Opt_In::TEXT_DOMAIN ),
					'fadeOutLeft'  => __( 'Fade Out Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Rotating Exits', Opt_In::TEXT_DOMAIN ) => array(
					'rotateOut'      => __( 'Rotate In', Opt_In::TEXT_DOMAIN ),
					'rotateOutUp'    => __( 'Rotate In Up', Opt_In::TEXT_DOMAIN ),
					'rotateOutRight' => __( 'Rotate In Right', Opt_In::TEXT_DOMAIN ),
					'rotateOutDown'  => __( 'Rotate In Down', Opt_In::TEXT_DOMAIN ),
					'rotateOutLeft'  => __( 'Rotate In Left', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Sliding Exits', Opt_In::TEXT_DOMAIN ) => array(
					'slideOutUp'    => __( 'Slide Out Up', Opt_In::TEXT_DOMAIN ),
					'slideOutRight' => __( 'Slide Out Left', Opt_In::TEXT_DOMAIN ),
					'slideOutDown'  => __( 'Slide Out Down', Opt_In::TEXT_DOMAIN ),
					'slideOutLeft'  => __( 'Slide Out Right', Opt_In::TEXT_DOMAIN ),
				),
				__( 'Zoom Exits', Opt_In::TEXT_DOMAIN )    => array(
					'zoomOut'      => __( 'Zoom Out', Opt_In::TEXT_DOMAIN ),
					'zoomOutUp'    => __( 'Zoom Out Up', Opt_In::TEXT_DOMAIN ),
					'zoomOutRight' => __( 'Zoom Out Right', Opt_In::TEXT_DOMAIN ),
					'zoomOutDown'  => __( 'Slide Out Down', Opt_In::TEXT_DOMAIN ),
					'zoomOutLeft'  => __( 'Slide Out Left', Opt_In::TEXT_DOMAIN ),
					'scaled'       => __( 'Super Scaled', Opt_In::TEXT_DOMAIN ), // MISSING
				),
				__( '3D Effects', Opt_In::TEXT_DOMAIN )    => array(
					'sign wpoi-modal'    => __( '3D Sign', Opt_In::TEXT_DOMAIN ), // MISSING
					'flipx wpoi-modal'   => __( '3D Flip (Horizontal)', Opt_In::TEXT_DOMAIN ), // MISSING
					'flipy wpoi-modal'   => __( '3D Flip (Vertical)', Opt_In::TEXT_DOMAIN ), // MISSING
					'rotatex wpoi-modal' => __( '3D Rotate (Left)', Opt_In::TEXT_DOMAIN ), // MISSING
					'rotatey wpoi-modal' => __( '3D Rotate (Bottom)', Opt_In::TEXT_DOMAIN ), // MISSING
				),
				__( 'Special Exits', Opt_In::TEXT_DOMAIN ) => array(
					'rollOut'       => __( 'Roll Out', Opt_In::TEXT_DOMAIN ),
					'lightSpeedOut' => __( 'Light Speed Out', Opt_In::TEXT_DOMAIN ),
					'newspaperOut'  => __( 'Newspaper Out', Opt_In::TEXT_DOMAIN ),
				),
			);

			return (object) array(
				'in'  => $animations_in,
				'out' => $animations_out,
			);
		}

		/**
		 * Returns palete name by slug.
		 *
		 * @since 3.0.6
		 *
		 * @param string $slug Palette slug.
		 *
		 * @return string Palette name.
		 */
		protected function pallets_ref( $slug ) {
			switch( $slug ) {
			case 'gray_slate': return 'Gray Slate';
			case 'coffee': return 'Coffee';
			case 'ectoplasm': return 'Ectoplasm';
			case 'blue': return 'Blue';
			case 'sunrise': return 'Sunrise';
			case 'midnight': return 'Midnight';
			}
			return $slug;
		}

		/**
		 * Returns palettes used to color optins
		 *
		 * @return array
		 */
		public function get_palettes() {

			return array(
				'Gray Slate' => array(
					// Basic
					'main_bg_color'                      => '#38454E',
					'image_container_bg'                 => '#35414A',
					'form_area_bg'                       => '#5D7380',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#38C5B5',
					'link_hover_color'                   => '#49E2D1',
					'link_active_color'                  => '#49E2D1',
					'cta_button_static_bg'               => '#38C5B5',
					'cta_button_hover_bg'                => '#49E2D1',
					'cta_button_active_bg'               => '#49E2D1',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#38C5B5',
					'optin_submit_button_hover_bg'       => '#38C5B5',
					'optin_submit_button_active_bg'      => '#38C5B5',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#38C5B5',
					'close_button_hover_color'           => '#49E2D1',
					'close_button_active_color'          => '#49E2D1',
				),
				'Coffee'     => array(
					// Basic
					'main_bg_color'                      => '#46403B',
					'image_container_bg'                 => '#423D38',
					'form_area_bg'                       => '#59524B',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#C6A685',
					'link_hover_color'                   => '#C69767',
					'link_active_color'                  => '#C69767',
					'cta_button_static_bg'               => '#C6A685',
					'cta_button_hover_bg'                => '#C69767',
					'cta_button_active_bg'               => '#C69767',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#C6A685',
					'optin_submit_button_hover_bg'       => '#C69767',
					'optin_submit_button_active_bg'      => '#C69767',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#FDFDFD',
					'close_button_hover_color'           => '#FDFDFD',
					'close_button_active_color'          => '#FDFDFD',
				),
				'Ectoplasm'  => array(
					// Basic
					'main_bg_color'                      => '#403159',
					'image_container_bg'                 => '#3D2F54',
					'form_area_bg'                       => '#513E70',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#A4B824',
					'link_hover_color'                   => '#B9CE33',
					'link_active_color'                  => '#B9CE33',
					'cta_button_static_bg'               => '#A4B824',
					'cta_button_hover_bg'                => '#B9CE33',
					'cta_button_active_bg'               => '#B9CE33',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#A4B824',
					'optin_submit_button_hover_bg'       => '#B9CE33',
					'optin_submit_button_active_bg'      => '#B9CE33',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#FDFDFD',
					'close_button_hover_color'           => '#FDFDFD',
					'close_button_active_color'          => '#FDFDFD',
				),
				'Blue'       => array(
					// Basic
					'main_bg_color'                      => '#176387',
					'image_container_bg'                 => '#165E80',
					'form_area_bg'                       => '#78B5D1',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#78B5D1',
					'link_hover_color'                   => '#4D95B6',
					'link_active_color'                  => '#4D95B6',
					'cta_button_static_bg'               => '#4D95B6',
					'cta_button_hover_bg'                => '#78B5D1',
					'cta_button_active_bg'               => '#78B5D1',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#4D95B6',
					'optin_submit_button_hover_bg'       => '#176387',
					'optin_submit_button_active_bg'      => '#176387',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#FDFDFD',
					'close_button_hover_color'           => '#FDFDFD',
					'close_button_active_color'          => '#FDFDFD',
				),
				'Sunrise'    => array(
					// Basic
					'main_bg_color'                      => '#B03E34',
					'image_container_bg'                 => '#A73B31',
					'form_area_bg'                       => '#CB4B40',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#CBB000',
					'link_hover_color'                   => '#CCB83D',
					'link_active_color'                  => '#CCB83D',
					'cta_button_static_bg'               => '#CBB000',
					'cta_button_hover_bg'                => '#CCB83D',
					'cta_button_active_bg'               => '#CCB83D',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#CBB000',
					'optin_submit_button_hover_bg'       => '#CCB83D',
					'optin_submit_button_active_bg'      => '#CCB83D',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#FDFDFD',
					'close_button_hover_color'           => '#FDFDFD',
					'close_button_active_color'          => '#FDFDFD',
				),
				'Midnight'   => array(
					// Basic
					'main_bg_color'                      => '#25282B',
					'image_container_bg'                 => '#232629',
					'form_area_bg'                       => '#363B3F',
					'title_color'                        => '#FDFDFD',
					'subtitle_color'                     => '#FDFDFD',
					'content_color'                      => '#ADB5B7',
					'link_static_color'                  => '#DD4F3D',
					'link_hover_color'                   => '#C63D2B',
					'link_active_color'                  => '#C63D2B',
					'cta_button_static_bg'               => '#DD4F3D',
					'cta_button_hover_bg'                => '#C63D2B',
					'cta_button_active_bg'               => '#C63D2B',
					'cta_button_static_color'            => '#FFFFFF',
					'cta_button_hover_color'             => '#FFFFFF',
					'cta_button_active_color'            => '#FFFFFF',
					// GDPR Field
					'gdpr_content'                       => '#ADB5B7',
					'gdpr_chechbox_background_static'    => '#FDFDFD',
					'gdpr_checkbox_background_active'    => '#FDFDFD',
					'gdpr_checkbox_icon'                 => '#38C5B5',
					// Opt-in Form
					'optin_input_static_bg'              => '#FDFDFD',
					'optin_input_hover_bg'               => '#FDFDFD',
					'optin_input_active_bg'              => '#FDFDFD',
					'optin_input_icon'                   => '#ADB5B7',
					'optin_placeholder_color'            => '#ADB5B7',
					'optin_form_field_text_static_color' => '#363B3F',
					'optin_form_field_text_hover_color'  => '#363B3F',
					'optin_form_field_text_active_color' => '#363B3F',
					'optin_submit_button_static_bg'      => '#DD4F3D',
					'optin_submit_button_hover_bg'       => '#C63D2B',
					'optin_submit_button_active_bg'      => '#C63D2B',
					'optin_submit_button_static_color'   => '#FDFDFD',
					'optin_submit_button_hover_color'    => '#FDFDFD',
					'optin_submit_button_active_color'   => '#FDFDFD',
					'optin_error_text_color'             => '#F1F1F1',
					'optin_error_text_bg'                => '#EA6464',
					// Mailchimp Extras
					'optin_mailchimp_title_color'        => '#FDFDFD',
					'optin_mailchimp_labels_color'       => '#ADB5B7',
					'optin_check_radio_bg'               => '#FDFDFD',
					'optin_check_radio_tick_color'       => '#38C5B5',
					// Additional Settings
					'optin_success_tick_color'           => '#38C5B5',
					'optin_success_content_color'        => '#FDFDFD',
					'overlay_bg'                         => 'rgba(51,51,51,0.9)',
					'close_button_static_color'          => '#FDFDFD',
					'close_button_hover_color'           => '#FDFDFD',
					'close_button_active_color'          => '#FDFDFD',
				),
			);
		}

		/**
		 * Default form filds for a new form
		 */
		public function default_form_fields() {

			return array(
				'email'      => array(
					'required'    => true,
					'label'       => __( 'Your email', Opt_In::TEXT_DOMAIN ),
					'name'        => 'email',
					'type'        => 'email',
					'placeholder' => 'johnsmith@example.com',
					'delete'      => false,
				),
				'first_name' => array(
					'required'    => false,
					'label'       => __( 'First Name', Opt_In::TEXT_DOMAIN ),
					'name'        => 'first_name',
					'type'        => 'name',
					'placeholder' => 'John',
					'delete'      => true,
				),
				'last_name'  => array(
					'required'    => false,
					'label'       => __( 'Last Name', Opt_In::TEXT_DOMAIN ),
					'name'        => 'last_name',
					'type'        => 'name',
					'placeholder' => 'Smith',
					'delete'      => true,
				),
				'submit'     => array(
					'required'    => true,
					'label'       => __( 'Submit', Opt_In::TEXT_DOMAIN ),
					'name'        => 'submit',
					'type'        => 'submit',
					'placeholder' => 'Subscribe',
					'delete'      => false,
				),
			);
		}

		public function get_providers_with_args() {
			return array( 'mailchimp' );
		}

		public static function get_client_ip() {

			$ip_addr = lib3()->net->current_ip()->ip;

			if ( $ip_addr ) {
				$ipaddress = $ip_addr;
			} else {
				$ipaddress = 'UNKNOWN';
			}

			return $ipaddress;
		}

		/**
		 * Returns array of countries
		 *
		 * @return array|mixed|null|void
		 */
		public function get_countries() {

			return apply_filters(
				'opt_in-country-list', array(
					'AU' => esc_html__( 'Australia', Opt_In::TEXT_DOMAIN ),
					'AF' => esc_html__( 'Afghanistan', Opt_In::TEXT_DOMAIN ),
					'AL' => esc_html__( 'Albania', Opt_In::TEXT_DOMAIN ),
					'DZ' => esc_html__( 'Algeria', Opt_In::TEXT_DOMAIN ),
					'AS' => esc_html__( 'American Samoa', Opt_In::TEXT_DOMAIN ),
					'AD' => esc_html__( 'Andorra', Opt_In::TEXT_DOMAIN ),
					'AO' => esc_html__( 'Angola', Opt_In::TEXT_DOMAIN ),
					'AI' => esc_html__( 'Anguilla', Opt_In::TEXT_DOMAIN ),
					'AQ' => esc_html__( 'Antarctica', Opt_In::TEXT_DOMAIN ),
					'AG' => esc_html__( 'Antigua and Barbuda', Opt_In::TEXT_DOMAIN ),
					'AR' => esc_html__( 'Argentina', Opt_In::TEXT_DOMAIN ),
					'AM' => esc_html__( 'Armenia', Opt_In::TEXT_DOMAIN ),
					'AW' => esc_html__( 'Aruba', Opt_In::TEXT_DOMAIN ),
					'AT' => esc_html__( 'Austria', Opt_In::TEXT_DOMAIN ),
					'AZ' => esc_html__( 'Azerbaijan', Opt_In::TEXT_DOMAIN ),
					'BS' => esc_html__( 'Bahamas', Opt_In::TEXT_DOMAIN ),
					'BH' => esc_html__( 'Bahrain', Opt_In::TEXT_DOMAIN ),
					'BD' => esc_html__( 'Bangladesh', Opt_In::TEXT_DOMAIN ),
					'BB' => esc_html__( 'Barbados', Opt_In::TEXT_DOMAIN ),
					'BY' => esc_html__( 'Belarus', Opt_In::TEXT_DOMAIN ),
					'BE' => esc_html__( 'Belgium', Opt_In::TEXT_DOMAIN ),
					'BZ' => esc_html__( 'Belize', Opt_In::TEXT_DOMAIN ),
					'BJ' => esc_html__( 'Benin', Opt_In::TEXT_DOMAIN ),
					'BM' => esc_html__( 'Bermuda', Opt_In::TEXT_DOMAIN ),
					'BT' => esc_html__( 'Bhutan', Opt_In::TEXT_DOMAIN ),
					'BO' => esc_html__( 'Bolivia', Opt_In::TEXT_DOMAIN ),
					'BA' => esc_html__( 'Bosnia and Herzegovina', Opt_In::TEXT_DOMAIN ),
					'BW' => esc_html__( 'Botswana', Opt_In::TEXT_DOMAIN ),
					'BV' => esc_html__( 'Bouvet Island', Opt_In::TEXT_DOMAIN ),
					'BR' => esc_html__( 'Brazil', Opt_In::TEXT_DOMAIN ),
					'IO' => esc_html__( 'British Indian Ocean Territory', Opt_In::TEXT_DOMAIN ),
					'BN' => esc_html__( 'Brunei', Opt_In::TEXT_DOMAIN ),
					'BG' => esc_html__( 'Bulgaria', Opt_In::TEXT_DOMAIN ),
					'BF' => esc_html__( 'Burkina Faso', Opt_In::TEXT_DOMAIN ),
					'BI' => esc_html__( 'Burundi', Opt_In::TEXT_DOMAIN ),
					'KH' => esc_html__( 'Cambodia', Opt_In::TEXT_DOMAIN ),
					'CM' => esc_html__( 'Cameroon', Opt_In::TEXT_DOMAIN ),
					'CA' => esc_html__( 'Canada', Opt_In::TEXT_DOMAIN ),
					'CV' => esc_html__( 'Cape Verde', Opt_In::TEXT_DOMAIN ),
					'KY' => esc_html__( 'Cayman Islands', Opt_In::TEXT_DOMAIN ),
					'CF' => esc_html__( 'Central African Republic', Opt_In::TEXT_DOMAIN ),
					'TD' => esc_html__( 'Chad', Opt_In::TEXT_DOMAIN ),
					'CL' => esc_html__( 'Chile', Opt_In::TEXT_DOMAIN ),
					'CN' => esc_html__( 'China, People\'s Republic of', Opt_In::TEXT_DOMAIN ),
					'CX' => esc_html__( 'Christmas Island', Opt_In::TEXT_DOMAIN ),
					'CC' => esc_html__( 'Cocos Islands', Opt_In::TEXT_DOMAIN ),
					'CO' => esc_html__( 'Colombia', Opt_In::TEXT_DOMAIN ),
					'KM' => esc_html__( 'Comoros', Opt_In::TEXT_DOMAIN ),
					'CD' => esc_html__( 'Congo, Democratic Republic of the', Opt_In::TEXT_DOMAIN ),
					'CG' => esc_html__( 'Congo, Republic of the', Opt_In::TEXT_DOMAIN ),
					'CK' => esc_html__( 'Cook Islands', Opt_In::TEXT_DOMAIN ),
					'CR' => esc_html__( 'Costa Rica', Opt_In::TEXT_DOMAIN ),
					'CI' => esc_html__( 'Côte d\'Ivoire', Opt_In::TEXT_DOMAIN ),
					'HR' => esc_html__( 'Croatia', Opt_In::TEXT_DOMAIN ),
					'CU' => esc_html__( 'Cuba', Opt_In::TEXT_DOMAIN ),
					'CW' => esc_html__( 'Curaçao', Opt_In::TEXT_DOMAIN ),
					'CY' => esc_html__( 'Cyprus', Opt_In::TEXT_DOMAIN ),
					'CZ' => esc_html__( 'Czech Republic', Opt_In::TEXT_DOMAIN ),
					'DK' => esc_html__( 'Denmark', Opt_In::TEXT_DOMAIN ),
					'DJ' => esc_html__( 'Djibouti', Opt_In::TEXT_DOMAIN ),
					'DM' => esc_html__( 'Dominica', Opt_In::TEXT_DOMAIN ),
					'DO' => esc_html__( 'Dominican Republic', Opt_In::TEXT_DOMAIN ),
					'TL' => esc_html__( 'East Timor', Opt_In::TEXT_DOMAIN ),
					'EC' => esc_html__( 'Ecuador', Opt_In::TEXT_DOMAIN ),
					'EG' => esc_html__( 'Egypt', Opt_In::TEXT_DOMAIN ),
					'SV' => esc_html__( 'El Salvador', Opt_In::TEXT_DOMAIN ),
					'GQ' => esc_html__( 'Equatorial Guinea', Opt_In::TEXT_DOMAIN ),
					'ER' => esc_html__( 'Eritrea', Opt_In::TEXT_DOMAIN ),
					'EE' => esc_html__( 'Estonia', Opt_In::TEXT_DOMAIN ),
					'ET' => esc_html__( 'Ethiopia', Opt_In::TEXT_DOMAIN ),
					'FK' => esc_html__( 'Falkland Islands', Opt_In::TEXT_DOMAIN ),
					'FO' => esc_html__( 'Faroe Islands', Opt_In::TEXT_DOMAIN ),
					'FJ' => esc_html__( 'Fiji', Opt_In::TEXT_DOMAIN ),
					'FI' => esc_html__( 'Finland', Opt_In::TEXT_DOMAIN ),
					'FR' => esc_html__( 'France', Opt_In::TEXT_DOMAIN ),
					'FX' => esc_html__( 'France, Metropolitan', Opt_In::TEXT_DOMAIN ),
					'GF' => esc_html__( 'French Guiana', Opt_In::TEXT_DOMAIN ),
					'PF' => esc_html__( 'French Polynesia', Opt_In::TEXT_DOMAIN ),
					'TF' => esc_html__( 'French South Territories', Opt_In::TEXT_DOMAIN ),
					'GA' => esc_html__( 'Gabon', Opt_In::TEXT_DOMAIN ),
					'GM' => esc_html__( 'Gambia', Opt_In::TEXT_DOMAIN ),
					'GE' => esc_html__( 'Georgia', Opt_In::TEXT_DOMAIN ),
					'DE' => esc_html__( 'Germany', Opt_In::TEXT_DOMAIN ),
					'GH' => esc_html__( 'Ghana', Opt_In::TEXT_DOMAIN ),
					'GI' => esc_html__( 'Gibraltar', Opt_In::TEXT_DOMAIN ),
					'GR' => esc_html__( 'Greece', Opt_In::TEXT_DOMAIN ),
					'GL' => esc_html__( 'Greenland', Opt_In::TEXT_DOMAIN ),
					'GD' => esc_html__( 'Grenada', Opt_In::TEXT_DOMAIN ),
					'GP' => esc_html__( 'Guadeloupe', Opt_In::TEXT_DOMAIN ),
					'GU' => esc_html__( 'Guam', Opt_In::TEXT_DOMAIN ),
					'GT' => esc_html__( 'Guatemala', Opt_In::TEXT_DOMAIN ),
					'GN' => esc_html__( 'Guinea', Opt_In::TEXT_DOMAIN ),
					'GW' => esc_html__( 'Guinea-Bissau', Opt_In::TEXT_DOMAIN ),
					'GY' => esc_html__( 'Guyana', Opt_In::TEXT_DOMAIN ),
					'HT' => esc_html__( 'Haiti', Opt_In::TEXT_DOMAIN ),
					'HM' => esc_html__( 'Heard Island And Mcdonald Island', Opt_In::TEXT_DOMAIN ),
					'HN' => esc_html__( 'Honduras', Opt_In::TEXT_DOMAIN ),
					'HK' => esc_html__( 'Hong Kong', Opt_In::TEXT_DOMAIN ),
					'HU' => esc_html__( 'Hungary', Opt_In::TEXT_DOMAIN ),
					'IS' => esc_html__( 'Iceland', Opt_In::TEXT_DOMAIN ),
					'IN' => esc_html__( 'India', Opt_In::TEXT_DOMAIN ),
					'ID' => esc_html__( 'Indonesia', Opt_In::TEXT_DOMAIN ),
					'IR' => esc_html__( 'Iran', Opt_In::TEXT_DOMAIN ),
					'IQ' => esc_html__( 'Iraq', Opt_In::TEXT_DOMAIN ),
					'IE' => esc_html__( 'Ireland', Opt_In::TEXT_DOMAIN ),
					'IL' => esc_html__( 'Israel', Opt_In::TEXT_DOMAIN ),
					'IT' => esc_html__( 'Italy', Opt_In::TEXT_DOMAIN ),
					'JM' => esc_html__( 'Jamaica', Opt_In::TEXT_DOMAIN ),
					'JP' => esc_html__( 'Japan', Opt_In::TEXT_DOMAIN ),
					'JT' => esc_html__( 'Johnston Island', Opt_In::TEXT_DOMAIN ),
					'JO' => esc_html__( 'Jordan', Opt_In::TEXT_DOMAIN ),
					'KZ' => esc_html__( 'Kazakhstan', Opt_In::TEXT_DOMAIN ),
					'KE' => esc_html__( 'Kenya', Opt_In::TEXT_DOMAIN ),
					'XK' => esc_html__( 'Kosovo', Opt_In::TEXT_DOMAIN ),
					'KI' => esc_html__( 'Kiribati', Opt_In::TEXT_DOMAIN ),
					'KP' => esc_html__( 'Korea, Democratic People\'s Republic of', Opt_In::TEXT_DOMAIN ),
					'KR' => esc_html__( 'Korea, Republic of', Opt_In::TEXT_DOMAIN ),
					'KW' => esc_html__( 'Kuwait', Opt_In::TEXT_DOMAIN ),
					'KG' => esc_html__( 'Kyrgyzstan', Opt_In::TEXT_DOMAIN ),
					'LA' => esc_html__( 'Lao People\'s Democratic Republic', Opt_In::TEXT_DOMAIN ),
					'LV' => esc_html__( 'Latvia', Opt_In::TEXT_DOMAIN ),
					'LB' => esc_html__( 'Lebanon', Opt_In::TEXT_DOMAIN ),
					'LS' => esc_html__( 'Lesotho', Opt_In::TEXT_DOMAIN ),
					'LR' => esc_html__( 'Liberia', Opt_In::TEXT_DOMAIN ),
					'LY' => esc_html__( 'Libya', Opt_In::TEXT_DOMAIN ),
					'LI' => esc_html__( 'Liechtenstein', Opt_In::TEXT_DOMAIN ),
					'LT' => esc_html__( 'Lithuania', Opt_In::TEXT_DOMAIN ),
					'LU' => esc_html__( 'Luxembourg', Opt_In::TEXT_DOMAIN ),
					'MO' => esc_html__( 'Macau', Opt_In::TEXT_DOMAIN ),
					'MK' => esc_html__( 'Macedonia', Opt_In::TEXT_DOMAIN ),
					'MG' => esc_html__( 'Madagascar', Opt_In::TEXT_DOMAIN ),
					'MW' => esc_html__( 'Malawi', Opt_In::TEXT_DOMAIN ),
					'MY' => esc_html__( 'Malaysia', Opt_In::TEXT_DOMAIN ),
					'MV' => esc_html__( 'Maldives', Opt_In::TEXT_DOMAIN ),
					'ML' => esc_html__( 'Mali', Opt_In::TEXT_DOMAIN ),
					'MT' => esc_html__( 'Malta', Opt_In::TEXT_DOMAIN ),
					'MH' => esc_html__( 'Marshall Islands', Opt_In::TEXT_DOMAIN ),
					'MQ' => esc_html__( 'Martinique', Opt_In::TEXT_DOMAIN ),
					'MR' => esc_html__( 'Mauritania', Opt_In::TEXT_DOMAIN ),
					'MU' => esc_html__( 'Mauritius', Opt_In::TEXT_DOMAIN ),
					'YT' => esc_html__( 'Mayotte', Opt_In::TEXT_DOMAIN ),
					'MX' => esc_html__( 'Mexico', Opt_In::TEXT_DOMAIN ),
					'FM' => esc_html__( 'Micronesia', Opt_In::TEXT_DOMAIN ),
					'MD' => esc_html__( 'Moldova', Opt_In::TEXT_DOMAIN ),
					'MC' => esc_html__( 'Monaco', Opt_In::TEXT_DOMAIN ),
					'MN' => esc_html__( 'Mongolia', Opt_In::TEXT_DOMAIN ),
					'ME' => esc_html__( 'Montenegro', Opt_In::TEXT_DOMAIN ),
					'MS' => esc_html__( 'Montserrat', Opt_In::TEXT_DOMAIN ),
					'MA' => esc_html__( 'Morocco', Opt_In::TEXT_DOMAIN ),
					'MZ' => esc_html__( 'Mozambique', Opt_In::TEXT_DOMAIN ),
					'MM' => esc_html__( 'Myanmar', Opt_In::TEXT_DOMAIN ),
					'NA' => esc_html__( 'Namibia', Opt_In::TEXT_DOMAIN ),
					'NR' => esc_html__( 'Nauru', Opt_In::TEXT_DOMAIN ),
					'NP' => esc_html__( 'Nepal', Opt_In::TEXT_DOMAIN ),
					'NL' => esc_html__( 'Netherlands', Opt_In::TEXT_DOMAIN ),
					'AN' => esc_html__( 'Netherlands Antilles', Opt_In::TEXT_DOMAIN ),
					'NC' => esc_html__( 'New Caledonia', Opt_In::TEXT_DOMAIN ),
					'NZ' => esc_html__( 'New Zealand', Opt_In::TEXT_DOMAIN ),
					'NI' => esc_html__( 'Nicaragua', Opt_In::TEXT_DOMAIN ),
					'NE' => esc_html__( 'Niger', Opt_In::TEXT_DOMAIN ),
					'NG' => esc_html__( 'Nigeria', Opt_In::TEXT_DOMAIN ),
					'NU' => esc_html__( 'Niue', Opt_In::TEXT_DOMAIN ),
					'NF' => esc_html__( 'Norfolk Island', Opt_In::TEXT_DOMAIN ),
					'MP' => esc_html__( 'Northern Mariana Islands', Opt_In::TEXT_DOMAIN ),
					'MP' => esc_html__( 'Mariana Islands, Northern', Opt_In::TEXT_DOMAIN ),
					'NO' => esc_html__( 'Norway', Opt_In::TEXT_DOMAIN ),
					'OM' => esc_html__( 'Oman', Opt_In::TEXT_DOMAIN ),
					'PK' => esc_html__( 'Pakistan', Opt_In::TEXT_DOMAIN ),
					'PW' => esc_html__( 'Palau', Opt_In::TEXT_DOMAIN ),
					'PS' => esc_html__( 'Palestine, State of', Opt_In::TEXT_DOMAIN ),
					'PA' => esc_html__( 'Panama', Opt_In::TEXT_DOMAIN ),
					'PG' => esc_html__( 'Papua New Guinea', Opt_In::TEXT_DOMAIN ),
					'PY' => esc_html__( 'Paraguay', Opt_In::TEXT_DOMAIN ),
					'PE' => esc_html__( 'Peru', Opt_In::TEXT_DOMAIN ),
					'PH' => esc_html__( 'Philippines', Opt_In::TEXT_DOMAIN ),
					'PN' => esc_html__( 'Pitcairn Islands', Opt_In::TEXT_DOMAIN ),
					'PL' => esc_html__( 'Poland', Opt_In::TEXT_DOMAIN ),
					'PT' => esc_html__( 'Portugal', Opt_In::TEXT_DOMAIN ),
					'PR' => esc_html__( 'Puerto Rico', Opt_In::TEXT_DOMAIN ),
					'QA' => esc_html__( 'Qatar', Opt_In::TEXT_DOMAIN ),
					'RE' => esc_html__( 'Réunion', Opt_In::TEXT_DOMAIN ),
					'RO' => esc_html__( 'Romania', Opt_In::TEXT_DOMAIN ),
					'RU' => esc_html__( 'Russia', Opt_In::TEXT_DOMAIN ),
					'RW' => esc_html__( 'Rwanda', Opt_In::TEXT_DOMAIN ),
					'SH' => esc_html__( 'Saint Helena', Opt_In::TEXT_DOMAIN ),
					'KN' => esc_html__( 'Saint Kitts and Nevis', Opt_In::TEXT_DOMAIN ),
					'LC' => esc_html__( 'Saint Lucia', Opt_In::TEXT_DOMAIN ),
					'PM' => esc_html__( 'Saint Pierre and Miquelon', Opt_In::TEXT_DOMAIN ),
					'VC' => esc_html__( 'Saint Vincent and the Grenadines', Opt_In::TEXT_DOMAIN ),
					'WS' => esc_html__( 'Samoa', Opt_In::TEXT_DOMAIN ),
					'SM' => esc_html__( 'San Marino', Opt_In::TEXT_DOMAIN ),
					'ST' => esc_html__( 'Sao Tome and Principe', Opt_In::TEXT_DOMAIN ),
					'SA' => esc_html__( 'Saudi Arabia', Opt_In::TEXT_DOMAIN ),
					'SN' => esc_html__( 'Senegal', Opt_In::TEXT_DOMAIN ),
					'CS' => esc_html__( 'Serbia', Opt_In::TEXT_DOMAIN ),
					'SC' => esc_html__( 'Seychelles', Opt_In::TEXT_DOMAIN ),
					'SL' => esc_html__( 'Sierra Leone', Opt_In::TEXT_DOMAIN ),
					'SG' => esc_html__( 'Singapore', Opt_In::TEXT_DOMAIN ),
					'MF' => esc_html__( 'Sint Maarten', Opt_In::TEXT_DOMAIN ),
					'SK' => esc_html__( 'Slovakia', Opt_In::TEXT_DOMAIN ),
					'SI' => esc_html__( 'Slovenia', Opt_In::TEXT_DOMAIN ),
					'SB' => esc_html__( 'Solomon Islands', Opt_In::TEXT_DOMAIN ),
					'SO' => esc_html__( 'Somalia', Opt_In::TEXT_DOMAIN ),
					'ZA' => esc_html__( 'South Africa', Opt_In::TEXT_DOMAIN ),
					'GS' => esc_html__( 'South Georgia and the South Sandwich Islands', Opt_In::TEXT_DOMAIN ),
					'ES' => esc_html__( 'Spain', Opt_In::TEXT_DOMAIN ),
					'LK' => esc_html__( 'Sri Lanka', Opt_In::TEXT_DOMAIN ),
					'XX' => esc_html__( 'Stateless Persons', Opt_In::TEXT_DOMAIN ),
					'SD' => esc_html__( 'Sudan', Opt_In::TEXT_DOMAIN ),
					'SD' => esc_html__( 'Sudan, South', Opt_In::TEXT_DOMAIN ),
					'SR' => esc_html__( 'Suriname', Opt_In::TEXT_DOMAIN ),
					'SJ' => esc_html__( 'Svalbard and Jan Mayen', Opt_In::TEXT_DOMAIN ),
					'SZ' => esc_html__( 'Swaziland', Opt_In::TEXT_DOMAIN ),
					'SE' => esc_html__( 'Sweden', Opt_In::TEXT_DOMAIN ),
					'CH' => esc_html__( 'Switzerland', Opt_In::TEXT_DOMAIN ),
					'SY' => esc_html__( 'Syria', Opt_In::TEXT_DOMAIN ),
					'TW' => esc_html__( 'Taiwan, Republic of China', Opt_In::TEXT_DOMAIN ),
					'TJ' => esc_html__( 'Tajikistan', Opt_In::TEXT_DOMAIN ),
					'TZ' => esc_html__( 'Tanzania', Opt_In::TEXT_DOMAIN ),
					'TH' => esc_html__( 'Thailand', Opt_In::TEXT_DOMAIN ),
					'TG' => esc_html__( 'Togo', Opt_In::TEXT_DOMAIN ),
					'TK' => esc_html__( 'Tokelau', Opt_In::TEXT_DOMAIN ),
					'TO' => esc_html__( 'Tonga', Opt_In::TEXT_DOMAIN ),
					'TT' => esc_html__( 'Trinidad and Tobago', Opt_In::TEXT_DOMAIN ),
					'TN' => esc_html__( 'Tunisia', Opt_In::TEXT_DOMAIN ),
					'TR' => esc_html__( 'Turkey', Opt_In::TEXT_DOMAIN ),
					'TM' => esc_html__( 'Turkmenistan', Opt_In::TEXT_DOMAIN ),
					'TC' => esc_html__( 'Turks and Caicos Islands', Opt_In::TEXT_DOMAIN ),
					'TV' => esc_html__( 'Tuvalu', Opt_In::TEXT_DOMAIN ),
					'UG' => esc_html__( 'Uganda', Opt_In::TEXT_DOMAIN ),
					'UA' => esc_html__( 'Ukraine', Opt_In::TEXT_DOMAIN ),
					'AE' => esc_html__( 'United Arab Emirates', Opt_In::TEXT_DOMAIN ),
					'GB' => esc_html__( 'United Kingdom', Opt_In::TEXT_DOMAIN ),
					'US' => esc_html__( 'United States of America (USA)', Opt_In::TEXT_DOMAIN ),
					'UM' => esc_html__( 'US Minor Outlying Islands', Opt_In::TEXT_DOMAIN ),
					'UY' => esc_html__( 'Uruguay', Opt_In::TEXT_DOMAIN ),
					'UZ' => esc_html__( 'Uzbekistan', Opt_In::TEXT_DOMAIN ),
					'VU' => esc_html__( 'Vanuatu', Opt_In::TEXT_DOMAIN ),
					'VA' => esc_html__( 'Vatican City', Opt_In::TEXT_DOMAIN ),
					'VE' => esc_html__( 'Venezuela', Opt_In::TEXT_DOMAIN ),
					'VN' => esc_html__( 'Vietnam', Opt_In::TEXT_DOMAIN ),
					'VG' => esc_html__( 'Virgin Islands, British', Opt_In::TEXT_DOMAIN ),
					'VI' => esc_html__( 'Virgin Islands, U.S.', Opt_In::TEXT_DOMAIN ),
					'WF' => esc_html__( 'Wallis And Futuna', Opt_In::TEXT_DOMAIN ),
					'EH' => esc_html__( 'Western Sahara', Opt_In::TEXT_DOMAIN ),
					'YE' => esc_html__( 'Yemen', Opt_In::TEXT_DOMAIN ),
					'ZM' => esc_html__( 'Zambia', Opt_In::TEXT_DOMAIN ),
					'ZW' => esc_html__( 'Zimbabwe', Opt_In::TEXT_DOMAIN ),
				)
			);
		}
	}
}
