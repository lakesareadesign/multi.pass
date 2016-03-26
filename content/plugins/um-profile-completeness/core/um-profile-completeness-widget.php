<?php

class um_profile_completeness extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_profile_completeness', 

		// Widget name will appear in UI
		__('Ultimate Member - Complete your Profile', 'um-profile-completeness'), 

		// Widget description
		array( 'description' => __( 'Display the user profile completeness widget.', 'um-profile-completeness' ), ) 
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		global $um_profile_completeness;
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title']: '' );

		if ( !is_user_logged_in() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( !$result || $result['progress'] >= 100 ) return;
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_profile_completeness]');
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		global $ultimatemember;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Complete your Profile', 'um-profile-completeness' );
		}
		
		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

class um_profile_progress_bar extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_profile_progress_bar', 

		// Widget name will appear in UI
		__('Ultimate Member - Profile Progress Bar', 'um-profile-completeness'), 

		// Widget description
		array( 'description' => __( 'Display the user profile progress bar.', 'um-profile-completeness' ), ) 
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		global $um_profile_completeness;
		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( !is_user_logged_in() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( !$result || $result['progress'] >= 100 ) return;
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_profile_progress_bar]');
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		global $ultimatemember;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Profile Progress', 'um-profile-completeness' );
		}
		
		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}