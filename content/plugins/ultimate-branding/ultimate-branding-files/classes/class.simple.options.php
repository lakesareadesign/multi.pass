<?php
/*
Class Name: Simple Options
Class URI: http://iworks.pl/
Description: Simple option class to manage options.
Version: 1.0.0
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2017 Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'simple_options' ) ) {

	class simple_options {

		private $loaded = array();

		public function __construct() {
			add_action( 'wp_ajax_simple_option', array( $this, 'ajax' ) );
		}

		public function build_options( $options, $input = array() ) {
			$content = '';
			foreach ( $options as $section_key => $option ) {
				if ( ! isset( $option['fields'] ) ) {
					continue;
				}
				if ( ! is_array( $option['fields'] ) ) {
					continue;
				}
				if ( empty( $option['fields'] ) ) {
					continue;
				}
				$content .= sprintf( '<div class="postbox" id="%s">', esc_attr( $section_key ) );
				/**
				 * add reset
				 */
				$reset = '';
				$show = true;
				if ( isset( $option['hide-reset'] ) && true === $option['hide-reset'] ) {
					$show = false;
				}
				if ( $show ) {
					$reset .= ' <span class="simple-option-reset-section">';
					$reset .= sprintf(
						'<a href="#" data-nonce="%s" data-section="%s" data-question="%s" data-network="%d">%s</a>',
						esc_attr( wp_create_nonce( 'reset-section-'.$section_key ) ),
						esc_attr( $section_key ),
						esc_attr(
							sprintf(
								__( 'Are you sure to reset "%s" section?', 'ub' ),
								$option['title']
							)
						),
						is_network_admin(),
						__( 'reset section to default', 'ub' )
					);
					$reset .= '</span>';
				}
				/**
				 * Section title
				 */
				$content .= sprintf( ' <h3 class="hndle">%s%s</h3>', $option['title'], $reset );
				if ( isset( $option['description'] ) && ! empty( $option['description'] ) ) {
					$content .= sprintf( '<p class="description">%s</p>', $option['description'] );
				}
				$content .= '<div class="inside"><table class="form-table"><tbody>';
				foreach ( $option['fields'] as $id => $data ) {
					/**
					 * field ID
					 */
					$html_id = 'simple_options_'.$section_key.'_'.$id;
					/**
					 * default type
					 */
					if ( ! isset( $data['type'] ) ) {
						$data['type'] = 'text';
					}
					/**
					 * default classes
					 */
					if ( ! isset( $data['classes'] ) ) {
						$data['classes'] = array();
					} else if ( ! is_array( $data['classes'] ) ) {
						$data['classes'] = array( $data['classes'] );
					}
					/**
					 * default class for text field
					 */
					if ( 'text' == $data['type'] && empty( $data['classes'] ) ) {
						$data['classes'][] = 'large-text';
					}
					/**
					 * begin table row
					 */
					$content .= sprintf(
						'<tr class="simple-option simple-option-%s %s">',
						esc_attr( $data['type'] ),
						isset( $data['master'] )? esc_attr( $data['master'] ):''
					);
					/**
					 * TH
					 */
					$show = true;
					if ( isset( $option['hide-th'] ) && true === $option['hide-th'] ) {
						$show = false;
					}
					if ( $show ) {

						$content .= sprintf(
							'<th scope="row"><label for="%s">%s</label></th>',
							esc_attr( $html_id ),
							isset( $data['label'] )? esc_html( $data['label'] ):'&nbsp;'
						);
					}
					$content .= '<td>';
					/**
					 * value
					 */
					$value = isset( $data['default'] )? $data['default']:'';
					if ( isset( $input[ $section_key ] ) && isset( $input[ $section_key ][ $id ] ) ) {
						$value = $input[ $section_key ][ $id ];
					}
					switch ( $data['type'] ) {
						case 'description':
							$content .= $data['value'];
						break;
						case 'media':
							if ( ! isset( $this->loaded['media'] ) ) {
								$this->loaded['media'] = true;
								wp_enqueue_media();
							}
							$image_src = wp_get_attachment_image_url( $value );
							$content .= '<div class="image-preview-wrapper">';
							$content .= sprintf(
								'<img class="image-preview" src="%s" />',
								esc_url( $image_src )
							);
							$content .= '</div>';
							$content .= sprintf(
								'<a href="#" class="image-reset %s">%s</a>',
								esc_attr( $image_src? '': 'disabled' ),
								esc_html__( 'reset', 'ub' )
							);
							$content .= sprintf(
								'<input type="button" class="button button-select-image" value="%s" />',
								esc_attr__( 'Browse', 'ub' )
							);
							$content .= sprintf(
								'<input type="hidden" name="simple_options[%s][%s]" value="%s" class="attachment-id" />',
								esc_attr( $section_key ),
								esc_attr( $id ),
								esc_attr( $value )
							);
						break;
						case 'color':
							$content .= sprintf(
								'<input type="text" name="simple_options[%s][%s]" value="%s" class="ub_color_picker %s" id="%s" />',
								esc_attr( $section_key ),
								esc_attr( $id ),
								esc_attr( $value ),
								isset( $data['class'] ) ? esc_attr( $data['class'] ) : '',
								esc_attr( $html_id )
							);
						break;
						case 'radio':
							$content .= '<ul>';
							foreach ( $data['options'] as $radio_value => $radio_label ) {
								$content .= sprintf(
									'<li><label><input type="%s" name="simple_options[%s][%s]" %s value="%s" />%s</label></li>',
									esc_attr( $data['type'] ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									checked( $value, $radio_value, false ),
									esc_attr( $radio_value ),
									esc_html( $radio_label )
								);
							}
							$content .= '</ul>';
							break;
						case 'checkbox':
							$slave = '';
							if ( isset( $data['slave-class'] ) ) {
								$slave = sprintf( 'data-slave="%s"', esc_attr( $data['slave-class'] ) );
								if ( isset( $data['classes'] ) ) {
									$data['classes'][] = 'master-field';
								} else {
									$data['classes'] = array( 'master-field' );
								}
							}
							if ( in_array( 'switch-button', $data['classes'] ) ) {
								if ( ! isset( $this->loaded['switch-button'] ) ) {
									$this->loaded['switch-button'] = true;
									wp_enqueue_script( 'custom-ligin-screen-jquery-switch-button', ub_files_url( 'js/vendor/jquery.switch_button.js' ), array( 'jquery' ), '1.12.1' );
									wp_enqueue_style( 'custom-ligin-screen-jquery-switch-button', ub_files_url( 'css/vendor/jquery.switch_button.css' ), array(), '1.12.1' );
									$i18n = array(
										'labels' => array(
											'label_on' => __( 'on', 'ub' ),
											'label_off' => __( 'off', 'ub' ),
										),
									);
									wp_localize_script( 'custom-ligin-screen-jquery-switch-button', 'switch_button', $i18n );
								}
								if ( 'on' == $value ) {
									$value = 1;
								}
								$content .= sprintf(
									'<input type="%s" id="%s" name="simple_options[%s][%s]" value="1" class="%s" id="%s" data-on="%s" data-off="%s" %s %s />',
									esc_attr( $data['type'] ),
									esc_attr( $html_id ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									esc_attr( $html_id ),
									esc_attr( $data['options']['on'] ),
									esc_attr( $data['options']['off'] ),
									checked( 1, $value, false ),
									$slave
								);
							} else {
								$content .= sprintf(
									'<label><input type="%s" id="%s" name="simple_options[%s][%s]" value="1" class="%s" id="%s" %s %s /> %s</label>',
									esc_attr( $data['type'] ),
									esc_attr( $html_id ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									esc_attr( stripslashes( $value ) ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									esc_attr( $html_id ),
									checked( 1, $value, false ),
									$slave,
									isset( $data['checkbox_label'] )? $data['checkbox_label']:''
								);
							}
							break;

						case 'textarea':
							$content .= sprintf(
								'<textarea id="%s" name="simple_options[%s][%s]" class="%s" id="%s">%s</textarea>',
								esc_attr( $html_id ),
								esc_attr( $section_key ),
								esc_attr( $id ),
								isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
								esc_attr( $html_id ),
								esc_attr( stripslashes( $value ) )
							);
							break;

						default:
							$extra = array();
							switch ( $data['type'] ) {
								case 'number':
									$data['classes'][] = 'small-text';
									if ( isset( $data['min'] ) ) {
										$extra[] = sprintf( 'min="%d"', $data['min'] );
									}
									if ( isset( $data['max'] ) ) {
										$extra[] = sprintf( 'max="%d"', $data['max'] );
									}
								break;
								case 'button':
								case 'submit':
									$data['classes'][] = 'button';
									if ( isset( $data['value'] ) ) {
										$value = $data['value'];
									}
									if ( isset( $data['disabled'] ) && $data['disabled'] ) {
										$extra[] = 'disabled="disabled"';
									}
								break;
							}
							/**
							 * html5.data
							 */
							if ( isset( $data['data'] ) ) {
								foreach ( $data['data'] as $data_key => $data_value ) {
									$extra[] = sprintf( 'data-%s="%s"', esc_html( $data_key ), esc_attr( $data_value ) );
								}
							}
							$field_name = sprintf( 'simple_options[%s][%s]', $section_key, $id );
							if ( isset( $data['name'] ) ) {
								$field_name = $data['name'];
							}
							$content .= sprintf(
								'<input type="%s" id="%s" name="%s" value="%s" class="%s" id="%s" %s />',
								esc_attr( $data['type'] ),
								esc_attr( $html_id ),
								esc_attr( $field_name ),
								esc_attr( stripslashes( $value ) ),
								isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
								esc_attr( $html_id ),
								implode( ' ', $extra )
							);
						break;
					}
					if ( in_array( 'ui-slider', $data['classes'] ) ) {
						$ui_slider_data = array(
							'data-target-id' => esc_attr( $html_id ),
						);
						foreach ( array( 'min', 'max' ) as $tmp_key ) {
							if ( isset( $data[ $tmp_key ] ) ) {
								$ui_slider_data[ 'data-'.$tmp_key ] = $data[ $tmp_key ];
							}
						}
						$ui_slider_data_string = '';
						foreach ( $ui_slider_data as $k => $v ) {
							$ui_slider_data_string .= sprintf( ' %s="%s"', $k, esc_attr( $v ) );
						}
						$content .= sprintf( '<div class="ui-slider" %s></div>', $ui_slider_data_string );
						if ( ! isset( $this->loaded['ui-slider'] ) ) {
							$this->loaded['ui-slider'] = true;
							wp_enqueue_script( 'jquery-ui-slider' );
							wp_enqueue_style( 'custom-ligin-screen-jquery-ui-slider', ub_files_url( 'css/vendor/jquery-ui-slider.css' ), array(), '1.12.1' );
						}
					}
					if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
						$content .= sprintf( '<p class="description">%s</p>', $data['description'] );
					}
					if ( isset( $data['default'] ) ) {
						$default = $data['default'];
						if ( isset( $data['options'] ) && isset( $data['options'][ $default ] ) ) {
							$default = $data['options'][ $data['default'] ];
						}
						$message = sprintf(
							__( 'Default is: <code><strong>%s</strong></code>', 'ub' ),
							$default
						);
						if ( 'color' == $data['type'] ) {
							$message = sprintf(
								__( 'Default color is: <code><strong>%s</strong></code>', 'ub' ),
								$data['default']
							);
						}
						$content .= sprintf( '<p class="description description-default">%s</p>', $message );
					}
					$content .= '</td>';
					$content .= '</tr>';
				}
				$content .= '</tbody></table></div>';
				$content .= '</div>';
			}
			return $content;
		}

		/**
		 * Handle admin AJAX requests
		 *
		 * @since 1.8.5
		 */
		public function ajax() {
			$response = array(
				'success' => false,
			);
			if ( isset( $_REQUEST['section'] ) && isset( $_REQUEST['tab'] ) && isset( $_REQUEST['nonce'] ) ) {
				if ( wp_verify_nonce( $_REQUEST['nonce'], 'reset-section-'.$_REQUEST['section'] ) ) {
					$option_name = ub_get_option_name_by_module( $_REQUEST['tab'] );
					if ( 'unknown' != $option_name ) {
						$value = ub_get_option( $option_name );
						if ( isset( $value[ $_REQUEST['section'] ] ) ) {
							unset( $value[ $_REQUEST['section'] ] );
							ub_update_option( $option_name , $value );
							$admin = isset( $_REQUEST['network'] ) && $_REQUEST['network'] ? network_admin_url( 'admin.php' ):admin_url( 'admin.php' );
							$data = array(
								'redirect' => add_query_arg(
									array(
										'msg' => 'reset-section-success',
										'page' => 'branding',
										'tab' => $_REQUEST['tab'],
									),
									$admin
								),
							);
							wp_send_json_success( $data );
						}
					}
				}
			}
			wp_send_json_error();
		}
	}
}