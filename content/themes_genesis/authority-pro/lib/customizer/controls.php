<?php
/**
 * This file adds the WordPress customizer heading control for the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Authority_Customizer_Heading_Control' ) ) {

	/**
	 * Authority Class Heading Control displays a heading and description.
	 */
	class Authority_Customizer_Heading_Control extends WP_Customize_Control {

		/**
		 * Whitelist instructions parameter.
		 *
		 * @var string
		 */
		public $instructions = '';

		/**
		 * Output the heading control content.
		 *
		 * @since   1.0.0
		 */
		public function render_content() {

			switch ( $this->type ) {

				case 'heading' :

					if ( isset( $this->label ) ) {
						echo '<hr><span class="customize-control-title">' . $this->label . '</span>';
					}

					if ( isset( $this->instructions ) ) {
						echo $this->instructions;
					}

					if ( isset( $this->description ) ) {
						echo '<span class="description customize-control-description">' . $this->description . '</span><hr>';
					}

					break;

			}

		}

	}

} // End if().
