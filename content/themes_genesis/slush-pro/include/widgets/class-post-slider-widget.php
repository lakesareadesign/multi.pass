<?php
/**
 * Slush Pro.
 *
 * This file adds the Post Slider Widget to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

add_action( 'widgets_init', 'zp_load_post_slider_widget' );
function zp_load_post_slider_widget() {

	register_widget( 'ZP_Post_Slider' );

}

class ZP_Post_Slider extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'          => '',
			'posts_cat'      => '',
			'posts_num'      => 1,
			'posts_offset'   => 0,
			'orderby'        => '',
			'order'          => '',
			'duration_speed' => 500,
			'navigation'     => 0,
			'image_size'     => '',
			'show_title'     => 0,
			'show_date'      => 0,
			'show_author'    => 0,
			'show_comments'  => 0,
			'show_readmore'  => 0,
			'show_content'   => 'excerpt',
			'content_limit'  => '',
			'more_text'      => __( 'Read More...', 'slush-pro' ),
		);

		$widget_ops = array(
			'classname'   => 'zpps-post-slider',
			'description' => __( 'Displays featured posts in a slider', 'slush-pro' ),
		);

		$control_ops = array(
			'id_base' => 'zpps-post-slider',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'zpps-post-slider', __( 'ZP - Post Slider', 'slush-pro' ), $widget_ops, $control_ops );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style_js' ) );

	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query               Query object.
	 * @global array    $_genesis_displayed_ids Array of displayed post IDs.
	 * @global $integer $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query, $_genesis_displayed_ids, $post, $authordata;

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		// Set up the author bio.
		if ( ! empty( $instance['title'] ) )
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

		$query_args = array(
			'post_type' => 'post',
			'cat'       => $instance['posts_cat'],
			'showposts' => $instance['posts_num'],
			'offset'    => $instance['posts_offset'],
			'orderby'   => $instance['orderby'],
			'order'     => $instance['order'],
		);

		$instance_id = uniqid();

		$data_attr_line = 'class="zpps-post-slider-swiper swiper-container"';
		$data_attr_line .= ' data-uniq-id="swiper-slider-' . $instance_id . '"';
		$data_attr_line .= ' data-duration-speed="' . esc_attr( $instance['duration_speed'] ) . '"';
		$data_attr_line .= ' data-swiper-loop="false"';
		$data_attr_line .= ' data-free-mode="false"';
		$data_attr_line .= ' data-grab-cursor="true"';
		$data_attr_line .= ' data-mouse-wheel="false"';

		$swiper_navigation_html = ( 1 == $instance['navigation'] ) ? '<div id="swiper-slider-'. $instance_id . '-next" class="swiper-button-next button-next"><i class="dashicons dashicons-arrow-right-alt2"></i></div><div id="swiper-slider-' . $instance_id . '-prev" class="swiper-button-prev button-prev"><i class="dashicons dashicons-arrow-left-alt2"></i></div>' : '';
		
		echo '<div class="swiper-slider-container">';
			echo '<div id="swiper-slider-' . $instance_id . '" ' . $data_attr_line . '>';
				echo '<div class="swiper-wrapper">';
					$wp_query = new WP_Query( $query_args );

					if ( have_posts() ) : while ( have_posts() ) : the_post();

						echo '<article class="' . join( ' ', get_post_class( 'swiper-slide' ) ) . '">';

						$image = genesis_get_image( array(
							'format'  => 'html',
							'size'    => $instance['image_size'],
							'context' => 'zpps-post-box',
							'attr'    => array ( 'alt' => get_the_title() ),
						) );

						if( $image )
							printf( '%s', $image );

						echo '<div class="post_slider_overlay"></div>';


						echo '<div class="post_slide_content">';
						
							$authordata = is_object( $authordata ) ? $authordata : get_userdata( get_query_var( 'author' ) );
							$gravatar   = get_avatar( get_the_author_meta( 'email' ), 20 );
							
							if ( $instance['show_date']  || $instance['show_author']  || $instance['show_comments']  ){
								echo '<p class="entry-meta">';
									if( $instance['show_date'] )
										echo '<span class="entry_date_wrap">' . do_shortcode( '[post_date]' ) . '</span>';

									if( $instance['show_author'] )
										echo do_shortcode( '[post_author_posts_link before="' . __( 'By ', 'slush-pro' ) . '"]' );
								echo '</p>';
							}

						if ( $instance['show_title'] )
							echo '<header class="entry-header">';

							if ( ! empty( $instance['show_title'] ) ) {

								$title = get_the_title() ? get_the_title() : __( '(no title)', 'slush-pro' );

								$heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

								printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );

							}

						if ( $instance['show_title'] )
							echo '</header>';

						if ( ! empty( $instance['show_content'] ) ) {

							echo genesis_html5() ? '<div class="entry-content">' : '';

							if ( 'excerpt' == $instance['show_content'] ) {
								the_excerpt();
							}
							elseif ( 'content-limit' == $instance['show_content'] ) {
								the_content_limit( (int) $instance['content_limit'], '');
							}
							else {

								global $more;

								$orig_more = $more;
								$more = 0;

								the_content();

								$more = $orig_more;

							}

							echo genesis_html5() ? '</div>' : '';
						}
						// If readmore.
						if ( $instance['show_readmore'] ) {
							$morelink = ( ! empty( $instance['more_text']  ) )? $instance['more_text'] : __( 'Read More', 'slush-pro' );
							echo '<p class="entry-readmore"><a class="more-link" href="' . get_permalink() . '">' . $morelink . '</a></p>';
						}

						echo '</div>';

						echo '</article>';

					endwhile; endif;
				echo '</div>';
			echo '</div>';
			echo $swiper_navigation_html;
		echo '</div>';

		// Restore original query.
		wp_reset_query();

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		$new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'slush-pro' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>        

		<div class="genesis-widget-column">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'slush-pro' ); ?>:</label>
					<?php
					$categories_args = array(
						'name'            => $this->get_field_name( 'posts_cat' ),
						'id'              => $this->get_field_id( 'posts_cat' ),
						'selected'        => $instance['posts_cat'],
						'orderby'         => 'Name',
						'hierarchical'    => 1,
						'show_option_all' => __( 'All Categories', 'slush-pro' ),
						'hide_empty'      => '0',
					);
					wp_dropdown_categories( $categories_args ); ?>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>"><?php _e( 'Number of Posts to Show', 'slush-pro' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_num' ) ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>"><?php _e( 'Number of Posts to Offset', 'slush-pro' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_offset' ) ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By', 'slush-pro' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
						<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'slush-pro' ); ?></option>
						<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'slush-pro' ); ?></option>
						<option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'slush-pro' ); ?></option>
						<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'slush-pro' ); ?></option>
						<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'slush-pro' ); ?></option>
						<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'slush-pro' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Sort Order', 'slush-pro' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
						<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'slush-pro' ); ?></option>
						<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'slush-pro' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php _e( 'Image Size', 'slush-pro' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" class="genesis-image-size-selector" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
						<?php
						$sizes = genesis_get_image_sizes();
						foreach( (array) $sizes as $name => $size )
							printf( '<option value="%s" %s>%s (%sx%s)</option>', esc_attr( $name ), selected( $name, $instance['image_size'], false ), esc_html( $name ), esc_html( $size['width'] ), esc_html( $size['height'] ) );
						?>
					</select>
				</p>
			</div>

			<div class="genesis-widget-column-box">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'duration_speed' ) ); ?>"><?php _e( 'Duration of transition between slides (ms)', 'slush-pro' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'duration_speed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'duration_speed' ) ); ?>" value="<?php echo esc_attr( $instance['duration_speed'] ); ?>" size="2" />
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'navigation' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'navigation' ) ); ?>" value="1" <?php checked( $instance['navigation'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'navigation' ) ); ?>"><?php _e( 'Slider navigation', 'slush-pro' ); ?></label>
				</p>
			</div>
		</div>

		<div class="genesis-widget-column genesis-widget-column-right">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Post Title', 'slush-pro' ); ?></label>
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" value="1" <?php checked( $instance['show_date'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php _e( 'Show Post Date', 'slush-pro' ); ?></label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_author' ) ); ?>" value="1" <?php checked( $instance['show_author'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_author' ) ); ?>"><?php _e( 'Show Post Author', 'slush-pro' ); ?></label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_comments' ) ); ?>" value="1" <?php checked( $instance['show_comments'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_comments' ) ); ?>"><?php _e( 'Show Post Comments', 'slush-pro' ); ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Content Type', 'slush-pro' ); ?>:</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>">
						<option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php _e( 'Show Content', 'slush-pro' ); ?></option>
						<option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'slush-pro' ); ?></option>
						<option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'slush-pro' ); ?></option>
						<option value="" <?php selected( '', $instance['show_content'] ); ?>><?php _e( 'No Content', 'slush-pro' ); ?></option>
					</select>
					<br />
					<label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Limit content to', 'slush-pro' ); ?>
						<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
						<?php _e( 'characters', 'slush-pro' ); ?>
					</label>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_readmore' ) ); ?>" value="1" <?php checked( $instance['show_readmore'] ); ?>/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>"><?php _e( 'Show Read More?', 'slush-pro' ); ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'More Text', 'slush-pro' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
				</p>

			</div>
		</div>
		<?php
	}

	// Adds assets.
	function enqueue_style_js(){

		if ( is_home() || is_front_page() ) {
			wp_enqueue_style( 'jquery-swiper' );
			wp_enqueue_script( 'jquery-swiper' );       
		}

	}

}
