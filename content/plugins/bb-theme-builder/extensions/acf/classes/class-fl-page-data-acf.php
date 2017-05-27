<?php

/**
 * Handles logic for page data Advanced Custom Field properties.
 *
 * @since 1.0
 */
final class FLPageDataACF {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'acf', array(
			'label' => __( 'Advanced Custom Fields', 'fl-theme-builder' ),
		) );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function string_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
			case 'textarea':
			case 'number':
			case 'email':
			case 'url':
			case 'password':
			case 'wysiwyg':
			case 'oembed':
			case 'select':
			case 'radio':
			case 'page_link':
			case 'date_picker':
			case 'date_time_picker':
			case 'time_picker':
				$content = isset( $object['value'] ) ? $object['value'] : '';
				break;
			case 'google_map':
				$value = isset( $object['value'] ) ? $object['value'] : '';
				$height = ! empty( $object['height'] ) ? $object['height'] : '400';
				if ( ! empty( $value ) && is_array( $value ) && isset( $value['address'] ) ) {
					$address = urlencode( $value['address'] );
					$content = "<iframe src='https://www.google.com/maps/embed/v1/place?key=AIzaSyD09zQ9PNDNNy9TadMuzRV_UsPUoWKntt8&q={$address}' style='border:0;width:100%;height:{$height}px'></iframe>";
				} else {
					$content = '';
				}
				break;
			case 'image':
				$content = self::get_file_url_from_object( $object, $settings->image_size );
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );
				break;
			default:
				$content = '';
		}

		return is_string( $content ) ? $content : '';
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function url_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
			case 'page_link':
				$content = isset( $object['value'] ) ? $object['value'] : '';
				break;
			case 'image':
				$content = self::get_file_url_from_object( $object, $settings->image_size );
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );
				break;
		}

		return is_string( $content ) ? $content : '';
	}

	/**
	 * @since 1.0
	 * @return string|array
	 */
	static public function photo_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
				$content = isset( $object['value'] ) ? $object['value'] : '';
				break;
			case 'image':
				$content = array(
					'id'  => self::get_image_id_from_object( $object ),
					'url' => self::get_file_url_from_object( $object, $settings->image_size ),
				);
				break;
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	static public function multiple_photos_field( $settings, $property ) {
		$content = array();
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != 'gallery' ) {
			return $content;
		} elseif ( is_array( $object['value'] ) ) {
			foreach ( $object['value'] as $key => $value ) {
				$content[] = $value['id'];
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_object_id( $property ) {
		global $post;

		$id = false;

		if ( 'archive' == $property['object'] ) {
			$location = FLThemeBuilderRulesLocation::get_current_page_location();
			if ( ! empty( $location['object'] ) ) {
				$location = explode( ':', $location['object'] );
				$id = $location[1] . '_' . $location[2];
			}

		} elseif ( is_object( $post ) && strstr( $property['key'], 'acf_author' ) ) {
			$id = 'user_' . $post->post_author;
		} elseif ( strstr( $property['key'], 'acf_user' ) ) {
			$user = wp_get_current_user();
			if ( $user->ID > 0 ) {
				$id = 'user_' . $user->ID;
			}
		} elseif ( strstr( $property['key'], 'acf_option' ) ) {
			$id = 'option';
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_file_url_from_object( $object, $size = 'thumbnail' ) {
		$url    = '';
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format || 'object' == $format ) {

				if ( isset( $object['value']['sizes'] ) && isset( $object['value']['sizes'][ $size ] ) ) {
					$url = $object['value']['sizes'][ $size ];
				} elseif ( $object['value']['url'] ) {
					$url = $object['value']['url'];
				}
			} elseif ( 'url' == $format ) {
				$url = $object['value'];
			} elseif ( 'id' == $format ) {
				if ( 'image' == $object['type'] ) {
					$data = wp_get_attachment_image_src( $object['value'], $size );
					$url  = $data[0];
				} elseif ( 'file' == $object['type'] ) {
					$url = wp_get_attachment_url( $object['value'] );
				}
			}
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @return int
	 */
	static public function get_image_id_from_object( $object ) {
		$id     = null;
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format ) {
				$id = $object['value']['ID'];
			} elseif ( 'object' == $format ) {
				$id = $object['value']['id'];
			} elseif ( 'id' == $format ) {
				$id = $object['value'];
			}
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @return int
	 */
	static public function get_object_return_format( $object ) {
		$format = false;

		if ( isset( $object['return_format'] ) ) {
			$format = $object['return_format'];
		} elseif ( isset( $object['save_format'] ) ) {
			$format = $object['save_format'];
		}

		return $format;
	}
}

FLPageDataACF::init();
