<?php

/**
 * Kreativ Featured Portfolio widget class.
 */
class Kreativ_Featured_Portfolio extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function __construct() {

		$this->defaults = array(
			'title'           => '',
			'posts_num'       => 3,
			'columns'         => '',
			'orderby'         => '',
			'order'           => '',
			'show_image'      => 0,
			'image_alignment' => '',
			'image_size'      => '',
			'show_title'      => 0,
			'show_content'    => 0,
			'content_limit'   => '',
			'more_text'       => '',
		);

		$widget_ops = array(
			'classname'   => 'featured-portfolio featuredportfolio',
			'description' => __( 'Displays portfolio post type with thumbnails', 'kreativ-pro' ),
		);

		$control_ops = array(
			'id_base' => 'kreativ-pro',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct( 'kreativ-pro', __( 'Genesis - Featured Portfolio', 'kreativ-pro' ), $widget_ops, $control_ops );

	}

	/**
	 * Echo the widget content.
	 */
	function widget( $args, $instance ) {

		global $wp_query;

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		// Widget Title.
		if ( ! empty( $instance['title'] ) )
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

		// Portfolio args.
		$query_args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => $instance['posts_num'],
			'orderby'        => $instance['orderby'],
			'order'          => $instance['order'],
		);

		// markup Microdata.
		$attributes  = '';
		$attributes .= 'itemtype="http://schema.org/CreativeWork" ';
		$attributes .= 'itemscope=""';

		$wp_query = new WP_Query( $query_args );

		$post_count = 0;

		if ( have_posts() ) :

			echo '<div class="featured-portfolio-content">';

			while ( have_posts() ) : the_post();

				// Post Class.
				$post_class = join( ' ', get_post_class() );

				// Add columns class.
				if ( $instance['columns'] == 'one-fourth' ) {
					$post_class .= ' one-fourth';
					if ( $post_count % 4 == 0 ) {
						$post_class .= ' first';
					}
				} elseif ( $instance['columns'] == 'one-third' ) {
					$post_class .= ' one-third';
					if ( $post_count % 3 == 0 ) {
						$post_class .= ' first';
					}
				} else {
					$post_class .= ' one-half';
					if ( $post_count % 2 == 0 ) {
						$post_class .= ' first';
					}
				}

				$class = 'class="' . $post_class . '"';

				printf( '<article %s %s>', $class, $attributes );

				echo '<div class="entry-wrap">';

				$image = genesis_get_image( array(
					'format'  => 'html',
					'size'    => $instance['image_size'],
					'context' => 'featured-portfolio-widget',
					'attr'    => genesis_parse_attr( 'entry-image-widget', array( 'alt' => get_the_title() ) ),
				) );

				if ( $instance['show_image'] && $image ) {
					$role = empty( $instance['show_title'] ) ? '' : 'aria-hidden="true"';
					printf( '<a href="%s" class="%s entry-thumbnail" %s>%s</a>', get_permalink(), esc_attr( $instance['image_alignment'] ), $role, $image );
				}

				echo '<div class="entry-inner">';
				if ( ! empty( $instance['show_title'] ) ) {

					$title = get_the_title() ? get_the_title() : __( '(no title)', 'kreativ-pro' );

					/**
					 * Filter the featured portfolio widget title.
					 */
					$title   = apply_filters( 'tsfp_title', $title, $instance, $args );
					$heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

					printf( '<header class="entry-header"><%s class="entry-title"><a href="%s">%s</a></%s></header>', $heading, get_permalink(), $title, $heading );

				}

				if ( ! empty( $instance['show_content'] ) ) {

					echo '<div class="entry-content">';

					if ( empty( $instance['content_limit'] ) ) {

						global $more;

						$orig_more = $more;
						$more      = 0;

						the_content( genesis_a11y_more_link( $instance['more_text'] ) );

						$more = $orig_more;

					} else {
						the_content_limit( (int) $instance['content_limit'], genesis_a11y_more_link( esc_html( $instance['more_text'] ) ) );
					}

					echo '</div>';

				}

				echo '</div>';

				echo '</div>';

				echo '</article>';

				$post_count++;

			endwhile; // end of one post.

			echo '</div>';

		endif; // end loop.

		// Restore original query.
		wp_reset_query();

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 */
	function form( $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'kreativ-pro' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php _e( 'Number of columns', 'kreativ-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
				<option value="one-half" <?php selected( 'one-half', $instance['columns'] ); ?>><?php _e( '2 Columns', 'kreativ-pro' ); ?></option>
				<option value="one-third" <?php selected( 'one-third', $instance['columns'] ); ?>><?php _e( '3 Columns', 'kreativ-pro' ); ?></option>
				<option value="one-fourth" <?php selected( 'one-fourth', $instance['columns'] ); ?>><?php _e( '4 Columns', 'kreativ-pro' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>"><?php _e( 'Number of posts to show', 'kreativ-pro' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_num' ) ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By', 'kreativ-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'kreativ-pro' ); ?></option>
				<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'kreativ-pro' ); ?></option>
				<option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'kreativ-pro' ); ?></option>
				<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'kreativ-pro' ); ?></option>
				<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'kreativ-pro' ); ?></option>
				<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'kreativ-pro' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Sort Order', 'kreativ-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'kreativ-pro' ); ?></option>
				<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'kreativ-pro' ); ?></option>
			</select>
		</p>

		<hr class="div" />

		<p>
			<input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" value="1"<?php checked( $instance['show_image'] ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php _e( 'Show Featured Image', 'kreativ-pro' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php _e( 'Image Size', 'kreativ-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" class="genesis-image-size-selector" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
				<option value="thumbnail">thumbnail (<?php echo absint( get_option( 'thumbnail_size_w' ) ); ?>x<?php echo absint( get_option( 'thumbnail_size_h' ) ); ?>)</option>
				<?php
				$sizes = wp_get_additional_image_sizes();
				foreach ( (array) $sizes as $name => $size )
					echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $instance['image_size'], FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . 'x' . absint( $size['height'] ) . ')</option>';
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>"><?php _e( 'Image Alignment', 'kreativ-pro' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_alignment' ) ); ?>">
				<option value="alignnone">- <?php _e( 'None', 'kreativ-pro' ); ?> -</option>
				<option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'kreativ-pro' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'kreativ-pro' ); ?></option>
				<option value="aligncenter" <?php selected( 'aligncenter', $instance['image_alignment'] ); ?>><?php _e( 'Center', 'kreativ-pro' ); ?></option>
			</select>
		</p>

		<hr class="div" />

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1"<?php checked( $instance['show_title'] ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Portfolio Title', 'kreativ-pro' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>" value="1"<?php checked( $instance['show_content'] ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Show Portfolio Content', 'kreativ-pro' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Content Character Limit', 'kreativ-pro' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( $instance['content_limit'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'More Text', 'kreativ-pro' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
		</p>
		<?php
	}

}
