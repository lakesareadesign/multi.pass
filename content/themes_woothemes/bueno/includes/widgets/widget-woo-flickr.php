<?php
/*---------------------------------------------------------------------------------*/
/* Flickr widget */
/*---------------------------------------------------------------------------------*/
class Woo_flickr extends WP_Widget {
	var $settings = array( 'id', 'number', 'type', 'sorting', 'size' );

	function __construct() {
		$widget_ops = array( 'description' => 'This Flickr widget populates photos from a Flickr ID.' );
		parent::__construct( false, __( 'Woo - Flickr', 'woothemes' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = $this->woo_enforce_defaults( $instance );
		extract( $instance, EXTR_SKIP );

		echo $before_widget;
		echo $before_title; ?>
		<?php _e( 'Photos on <span>flick<span>r</span></span>', 'woothemes' ); ?>
        <?php echo $after_title; ?>
        <div class="pictures fix">
            <script type="text/javascript" src="<?php echo esc_url( 'http://www.flickr.com/badge_code_v2.gne?count=' . $number . '&amp;display=' . $sorting . '&amp;layout=x&amp;source=' . $type . '&amp;' . $type . '=' . $instance['id'] . '&amp;size=' . $size ); ?>"></script>
        </div><?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$settings = $this->woo_enforce_defaults( $new_instance );
		return $settings;
	}

	function woo_enforce_defaults( $instance ) {
		$settings = array( 'id' => '', 'number' => '' );
		$defaults = $this->woo_get_settings();
		$instance = wp_parse_args( $instance, $defaults );
		$settings['id'] = sanitize_text_field( $instance['id'] );
		if ( in_array( $instance['type'], array( 'user', 'group' ) ) ) {
			$settings['type'] = $instance['type'];
		}
		if ( in_array( $instance['sorting'], array( 'latest', 'random' ) ) ) {
			$settings['sorting'] = $instance['sorting'];
		}
		if ( in_array( $instance['size'], array( 's', 'm', 't' ) ) ) {
			$settings['size'] = $instance['size'];
		}

		if ( $instance['number'] < 1 )
			$settings['number'] = 1;
		elseif ( $instance['number'] > 10 )
			$settings['number'] = 10;
		else
			$settings['number'] = absint( $instance['number'] );

		if ( $instance['limit'] < 1 )
			$settings['limit'] = 1;
		elseif ( $instance['limit'] > 10 )
			$settings['limit'] = 10;
		$settings['width'] = absint( $instance['width'] );
		if ( $instance['width'] < 1 )
			$settings['width'] = $defaults['width'];
		$settings['height'] = absint( $instance['height'] );
		if ( $instance['height'] < 1 )
			$settings['height'] = $defaults['height'];
		if ( $instance['sorting'] != 'random' )
			$settings['sorting'] = $defaults['sorting'];
		if ( !in_array( $instance['size'], array( 's', 'm', 't' ) ) )
			$settings['size'] = $defaults['size'];
		if ( $instance['type'] != 'group' )
			$settings['type'] = $defaults['type'];
		return $settings;
	}

	/**
	 * Provides an array of the settings with the setting name as the key and the default value as the value
	 * This cannot be called get_settings() or it will override WP_Widget::get_settings()
	 */
	function woo_get_settings() {
		// Set the default to a blank string
		$settings = array_fill_keys( $this->settings, '' );
		// Now set the more specific defaults
		$settings['limit']  = 10;
		$settings['number'] = 10;
		$settings['width']  = 300;
		$settings['height'] = 200;
		$settings['size'] = 's';
		$settings['sorting'] = 'latest';
		$settings['type'] = 'user';
		return $settings;
	}

	function form( $instance ) {
		$instance = $this->woo_enforce_defaults( $instance );
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];
		$size = $instance['size'];
?>
			<p>
				<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):', 'woothemes' ); ?></label>
				<input type="text" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $id ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:', 'woothemes' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'number' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php for ( $i = 1; $i <= 10; $i += 1 ) { ?>
					<option value="<?php echo $i; ?>" <?php selected( $number, $i ); ?>><?php echo $i; ?></option>
				<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:', 'woothemes' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>">
					<option value="user" <?php selected( $type, 'user' ); ?>><?php _e( 'User', 'woothemes' ); ?></option>
					<option value="group" <?php selected( $type, 'group' ); ?>><?php _e( 'Group', 'woothemes' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sorting' ); ?>"><?php _e( 'Sorting:', 'woothemes' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'sorting' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'sorting' ); ?>">
					<option value="latest" <?php selected( $sorting, 'latest' ); ?>><?php _e( 'Latest', 'woothemes' ); ?></option>
					<option value="random" <?php selected( $sorting, 'random' ); ?>><?php _e( 'Random', 'woothemes' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:', 'woothemes' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'size' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>">
					<option value="s" <?php selected( $size, 's' ); ?>><?php _e( 'Square', 'woothemes' ); ?></option>
					<option value="m" <?php selected( $size, 'm' ); ?>><?php _e( 'Medium', 'woothemes' ); ?></option>
					<option value="t" <?php selected( $size, 't' ); ?>><?php _e( 'Thumbnail', 'woothemes' ); ?></option>
				</select>
			</p>
		<?php
	}
}

register_widget( 'woo_flickr' );
