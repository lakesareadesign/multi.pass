<?php

/**
 * Handles logic for page data post properties.
 *
 * @since 1.0
 */
final class FLPageDataPost {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_excerpt( $settings ) {
		add_filter( 'excerpt_length', __CLASS__ . '::excerpt_length_filter' );
		add_filter( 'excerpt_more', __CLASS__ . '::excerpt_more_filter' );

		$excerpt = apply_filters( 'the_excerpt', get_the_excerpt() );

		remove_filter( 'excerpt_length', __CLASS__ . '::excerpt_length_filter' );
		remove_filter( 'excerpt_more', __CLASS__ . '::excerpt_more_filter' );

		return $excerpt;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function excerpt_length_filter( $length ) {
		$settings = FLPageData::get_current_settings();

		return $settings && is_numeric( $settings->length ) ? $settings->length : 55;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function excerpt_more_filter( $more ) {
		$settings = FLPageData::get_current_settings();

		return $settings && ! empty( $settings->more ) ? $settings->more : '...';
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_content() {
		remove_filter( 'the_content', 'FLBuilder::render_content' );

		$content = apply_filters( 'the_content', get_the_content() );

		$content .= wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'fl-theme-builder' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
			'echo'        => false,
		) );

		add_filter( 'the_content', 'FLBuilder::render_content' );

		return $content;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_link( $settings ) {
		$href = get_permalink();

		if ( 'title' == $settings->text ) {
			$title = the_title_attribute( array( 'echo' => false ) );
			$text  = get_the_title();
		} else {
			$title = esc_attr( $settings->custom_text );
			$text  = $settings->custom_text;
		}

		return "<a href='{$href}' title='{$title}'>{$text}</a>";
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_date( $settings ) {
		return get_the_date( $settings->format );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_featured_image( $settings ) {
		global $post;

		if ( 'tag' == $settings->display ) {

			$class = 'default' == $settings->align ? '' : 'align' . $settings->align;
			$image = get_the_post_thumbnail( $post, $settings->size, array( 'itemprop' => 'image', 'class' => $class ) );

			if ( $image && 'yes' == $settings->linked ) {

				$href  = get_the_permalink();
				$title = the_title_attribute( array( 'echo' => false ) );

				return "<a href='{$href}' title='{$title}'>{$image}</a>";
			} else {
				return $image;
			}
		} elseif ( 'url' == $settings->display ) {
			return get_the_post_thumbnail_url( $post, $settings->size );
		} elseif ( 'alt' == $settings->display ) {
			return get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
		} else {

			$image = get_post( get_post_thumbnail_id( $post->ID ) );

			if ( 'title' == $settings->display ) {
				return $image->post_title;
			} elseif ( 'caption' == $settings->display ) {
				return $image->post_excerpt;
			} elseif ( 'description' == $settings->display ) {
				return $image->post_content;
			}
		}
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	static public function get_featured_image_url( $settings ) {
		global $post;

		$id  = '';
		$url = '';

		if ( has_post_thumbnail( $post ) ) {
			$id  = get_post_thumbnail_id( $post->ID );
			$url = get_the_post_thumbnail_url( $post, $settings->size );
		} elseif ( isset( $settings->default_img_src ) ) {
			$id  = $settings->default_img;
			$url = $settings->default_img_src;
		}

		return array(
			'id'  => $id,
			'url' => $url,
		);
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	static public function get_attached_images() {
		global $post;

		return array_keys( get_attached_media( 'image', $post->ID ) );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_terms_list( $settings ) {
		global $post;

		return get_the_term_list( $post->ID, $settings->taxonomy, '', $settings->separator, '' );
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	static public function get_taxonomy_options() {
		$taxonomies = get_taxonomies( array( 'public' => true, 'show_ui' => true ), 'objects' );
		$result     = array();

		foreach ( $taxonomies as $slug => $data ) {

			if ( stristr( $slug, 'fl-builder' ) ) {
				continue;
			}

			$result[ $slug ] = $data->label;
		}

		return $result;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_comments_number( $settings ) {
		$zero = isset( $settings->none_text ) ? $settings->none_text : null;
		$one = isset( $settings->one_text ) ? $settings->one_text : null;
		$more = isset( $settings->more_text ) ? $settings->more_text : null;

		ob_start();

		if ( $settings->link ) {
			comments_popup_link( $zero, $one, $more );
		} else {
			comments_number( $zero, $one, $more );
		}

		return ob_get_clean();
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_comments_url() {
		global $post;

		return get_comments_link( $post->ID );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_name( $settings ) {
		$name = get_the_author();

		if ( 'yes' == $settings->link ) {
			$name = '<a href="' . self::get_author_url() . '">' . $name . '</a>';
		}

		return $name;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_bio() {
		return get_the_author_meta( 'description' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_url() {
		return get_author_posts_url( get_the_author_meta( 'ID' ) );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_profile_picture( $settings ) {
		$size   = ! is_numeric( $settings->size ) ? 512 : $settings->size;
		$avatar = get_avatar( get_the_author_meta( 'ID' ), $size );

		if ( $settings->link ) {
			$avatar = '<a href="' . self::get_author_url() . '">' . $avatar . '</a>';
		}

		return $avatar;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_profile_picture_url( $settings ) {
		$size = ! is_numeric( $settings->size ) ? 512 : $settings->size;
		$url  = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => $size ));

		if ( ! $url && isset( $settings->default_img_src ) ) {
			$url = $settings->default_img_src;
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_custom_field( $settings ) {
		global $post;

		if ( empty( $settings->key ) ) {
			return '';
		}

		return get_post_meta( $post->ID, $settings->key, true );
	}
}
