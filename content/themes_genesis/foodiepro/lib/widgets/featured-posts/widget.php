<?php
/**
 * Foodie Pro Featured Posts
 *
 * @package   FoodiePro\Widgets
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     3.1.0
 */

defined( 'WPINC' ) || die;

/**
 * Genesis Featured Post widget class.
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class Foodie_Pro_Featured_Posts extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->defaults = array(
			'title'                   => '',
			'posts_cat'               => '',
			'posts_num'               => 1,
			'posts_offset'            => 0,
			'orderby'                 => '',
			'order'                   => '',
			'exclude_displayed'       => 0,
			'show_image'              => 'none',
			'image_alignment'         => '',
			'image_size'              => '',
			'show_gravatar'           => 0,
			'gravatar_alignment'      => '',
			'gravatar_size'           => '',
			'simple_grid'             => 'full',
			'show_title'              => 0,
			'show_byline'             => 0,
			'post_info'               => '[post_date] ' . __( 'By', 'foodiepro' ) . ' [post_author_posts_link] [post_comments]',
			'show_content'            => 'excerpt',
			'content_limit'           => '',
			'more_text'               => __( 'Read More', 'foodiepro' ),
			'more_from_category'      => '',
			'more_from_category_text' => __( 'See More;', 'foodiepro' ),
		);

		parent::__construct(
			'featured-post',
			__( 'Foodie Pro - Featured Posts', 'foodiepro' ),
			array(
				'classname'   => 'featured-content featuredpost',
				'description' => __( 'Displays featured posts with thumbnails', 'foodiepro' ),
			),
			array(
				'id_base' => 'featured-post',
			)
		);
	}

	/**
	 * Load a widget template file.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  string $slug the slug of a template file to be included.
	 * @param  array  $data a data array to be passed to the template.
	 * @param  bool   $extract whether or not to extract the data array.
	 * @return void
	 */
	protected function get_widget_template( $slug, $data = array(), $extract = false ) {
		if ( $extract ) {
			extract( $data );
			unset( $extract );
		}

		require FOODIE_PRO_DIR . "lib/widgets/featured-posts/views/{$slug}.php";
	}

	/**
	 * Retrieve translated strings from WPML.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  array $data a data array which contains the translated string keys.
	 * @return array $data the data array with the translated strings.
	 */
	protected function wpml_translate( $data ) {
		if ( ! function_exists( 'icl_translate' ) ) {
			return $data;
		}

		$data['post_info'] = icl_translate(
			'Widgets',
			"Featured Posts - Post Info {$this->number}",
			$data['post_info']
		);
		$data['more_text'] = icl_translate(
			'Widgets',
			"Featured Posts - Read More {$this->number}",
			$data['more_text']
		);
		$data['more_from_category_text'] = icl_translate(
			'Widgets',
			"Featured Posts - More Category Text {$this->number}",
			$data['more_from_category_text']
		);

		return $data;
	}

	/**
	 * Helper for loading the correct content type on the widget front-end.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  array $data a data array with user options.
	 * @return void
	 */
	protected function the_entry_content( $data ) {
		if ( 'excerpt' == $data['show_content'] ) {
			the_excerpt();
		} elseif ( 'content-limit' == $data['show_content'] ) {
			the_content_limit( (int) $data['content_limit'], esc_html( $data['more_text'] ) );
		} else {

			global $more;

			$orig_more = $more;
			$more = 0;

			the_content( esc_html( $data['more_text'] ) );

			$more = $orig_more;
		}
	}

	protected function get_featured_image( $size, $alignment ) {
		$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => $size,
			'context' => 'featured-post-widget',
			'attr'    => genesis_parse_attr( 'entry-image-widget' ),
		) );

		if ( ! $image ) {
			return false;
		}

		return sprintf( '<a href="%s" title="%s" class="%s">%s</a>',
			get_permalink(),
			the_title_attribute( 'echo=0' ),
			esc_attr( $alignment ),
			$image
		);
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 2.0.0
	 *
	 * @global WP_Query $wp_query               Query object.
	 * @global array    $_genesis_displayed_ids Array of displayed post IDs.
	 * @global $integer $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$instance = $this->wpml_translate( $instance );

		$data = array(
			'args' => $args,
			'data' => $instance,
		);

		$this->get_widget_template( 'display', $data, true );
	}

	/**
	 * Register translated strings for WPML.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  array $data An array of data with strings to be translated.
	 * @return array $data The data array with the translated strings registered.
	 */
	protected function wpml_register( $data ) {
		if ( ! function_exists( 'icl_register_string' ) ) {
			return $data;
		}

		icl_register_string(
			'Widgets',
			"Featured Posts - Post Info {$this->number}",
			$data['post_info']
		);
		icl_register_string(
			'Widgets',
			"Featured Posts - Read More {$this->number}",
			$data['more_text']
		);
		icl_register_string(
			'Widgets',
			"Featured Posts - More Category Text {$this->number}",
			$data['more_from_category_text']
		);

		return $data;
	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 2.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {
		if ( current_user_can( 'unfiltered_html' ) ) {
			$new_instance['title'] = $new_instance['title'];
		} else {
			$new_instance['title'] = wp_kses_post( $new_instance['title'] );
		}

		$new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );
		$new_instance['more_text'] = sanitize_text_field( $new_instance['more_text'] );
		$new_instance['more_from_category_text'] = sanitize_text_field( $new_instance['more_from_category_text'] );

		// Update the legacy show_image value for consistency moving forward.
		if ( '1' === $old_instance['show_image'] ) {
			$new_instance['show_image'] = 'before_title';
		}

		$new_instance = $this->wpml_register( $new_instance );

		return $new_instance;
	}

	/**
	 * Echo a field ID.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  string $field the field from which to retrieve the ID.
	 * @return void
	 */
	protected function field_id( $field ) {
		echo $this->get_field_id( $field );
	}

	/**
	 * Echo a field name.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param  string $field the field from which to retrieve the name.
	 * @return void
	 */
	protected function field_name( $field ) {
		echo $this->get_field_name( $field );
	}

	/**
	 * Get all image sizes for the form.
	 *
	 * @since  3.2.0
	 * @access protected
	 * @return array
	 */
	protected function get_form_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();
		$core_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
		$extra_sizes = $_wp_additional_image_sizes;

		foreach ( (array) get_intermediate_image_sizes() as $size ) {
			if ( in_array( $size, $core_sizes, true ) ) {
				$sizes[ $size ]['width']  = get_option( "{$size}_size_w" );
				$sizes[ $size ]['height'] = get_option( "{$size}_size_h" );
				$sizes[ $size ]['crop']   = (bool) get_option( "{$size}_crop" );
			} elseif ( is_array( $extra_sizes ) && isset( $extra_sizes[ $size ] ) ) {
				$sizes[ $size ] = array(
					'width'  => $extra_sizes[ $size ]['width'],
					'height' => $extra_sizes[ $size ]['height'],
					'crop'   => $extra_sizes[ $size ]['crop'],
				);
			}
		}

		return $sizes;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $instance Current settings.
	 * @return void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		if ( isset( $instance['show_image'] ) && '1' === $instance['show_image'] ) {
			$instance['show_image'] = 'before_title';
		}

		$this->get_widget_template( 'form', $instance );
	}
}
