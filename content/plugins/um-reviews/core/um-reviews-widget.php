<?php

class um_reviews_lowest_rated extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_reviews_lowest_rated', 

		// Widget name will appear in UI
		__('Ultimate Member - Lowest Rated', 'um-reviews'), 

		// Widget description
		array( 'description' => __( 'Shows your lowest rated users in a widget', 'um-reviews' ), ) 
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$num_users = $instance['num_users'];
		$roles = $instance['roles'];
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_lowest_rated number='.$num_users.' roles='.$roles.']');
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		global $ultimatemember;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Lowest Rated Users', 'um-reviews' );
		}
		
		if ( isset( $instance[ 'num_users' ] ) ) {
			$num_users = $instance[ 'num_users' ];
		} else {
			$num_users = 5;
		}
		
		if ( isset( $instance[ 'roles' ] ) ) {
			$roles = $instance['roles'];
		} else {
			$roles = 'all';
		}
		
		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'num_users' ); ?>"><?php _e( 'Number of users:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_users' ); ?>" name="<?php echo $this->get_field_name( 'num_users' ); ?>" type="text" value="<?php echo esc_attr( $num_users ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'roles' ); ?>"><?php _e( 'Limit to community role:' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'roles' ); ?>" id="<?php echo $this->get_field_id( 'roles' ); ?>">
				<option value="all" <?php echo "all" == $roles ? "selected" : ""; ?> ><?php _e('All roles','um-reviews'); ?></option>
				<?php foreach( $ultimatemember->query->get_roles( ) as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php echo $key == $roles ? "selected" : ""; ?> ><?php echo $value; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_users'] = ( ! empty( $new_instance['num_users'] ) ) ? strip_tags( $new_instance['num_users'] ) : 5;
		$instance['roles'] = ( ! empty( $new_instance['roles'] ) ) ? strip_tags( $new_instance['roles'] ) : 'all';
		return $instance;
	}

}

class um_reviews_most_rated extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_reviews_most_rated', 

		// Widget name will appear in UI
		__('Ultimate Member - Most Rated', 'um-reviews'), 

		// Widget description
		array( 'description' => __( 'Shows your most rated users in a widget', 'um-reviews' ), ) 
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$num_users = $instance['num_users'];
		$roles = $instance['roles'];
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_most_rated number='.$num_users.' roles='.$roles.']');
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		global $ultimatemember;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Most Rated Users', 'um-reviews' );
		}
		
		if ( isset( $instance[ 'num_users' ] ) ) {
			$num_users = $instance[ 'num_users' ];
		} else {
			$num_users = 5;
		}
		
		if ( isset( $instance[ 'roles' ] ) ) {
			$roles = $instance['roles'];
		} else {
			$roles = 'all';
		}
		
		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'num_users' ); ?>"><?php _e( 'Number of users:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_users' ); ?>" name="<?php echo $this->get_field_name( 'num_users' ); ?>" type="text" value="<?php echo esc_attr( $num_users ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'roles' ); ?>"><?php _e( 'Limit to community role:' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'roles' ); ?>" id="<?php echo $this->get_field_id( 'roles' ); ?>">
				<option value="all" <?php echo "all" == $roles ? "selected" : ""; ?> ><?php _e('All roles','um-reviews'); ?></option>
				<?php foreach( $ultimatemember->query->get_roles( ) as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php echo $key == $roles ? "selected" : ""; ?> ><?php echo $value; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_users'] = ( ! empty( $new_instance['num_users'] ) ) ? strip_tags( $new_instance['num_users'] ) : 5;
		$instance['roles'] = ( ! empty( $new_instance['roles'] ) ) ? strip_tags( $new_instance['roles'] ) : 'all';
		return $instance;
	}

}

class um_reviews_top_rated extends WP_Widget {

	function __construct() {
		
		parent::__construct(
		
		// Base ID of your widget
		'um_reviews_top_rated', 

		// Widget name will appear in UI
		__('Ultimate Member - Top Rated', 'um-reviews'), 

		// Widget description
		array( 'description' => __( 'Shows your top rated users in a widget', 'um-reviews' ), ) 
		);
	
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$num_users = $instance['num_users'];
		$roles = $instance['roles'];
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// This is where you run the code and display the output
		echo do_shortcode('[ultimatemember_top_rated number='.$num_users.' roles='.$roles.']');
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		global $ultimatemember;
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Top Rated Users', 'um-reviews' );
		}
		
		if ( isset( $instance[ 'num_users' ] ) ) {
			$num_users = $instance[ 'num_users' ];
		} else {
			$num_users = 5;
		}
		
		if ( isset( $instance[ 'roles' ] ) ) {
			$roles = $instance['roles'];
		} else {
			$roles = 'all';
		}
		
		// Widget admin form
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'num_users' ); ?>"><?php _e( 'Number of users:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_users' ); ?>" name="<?php echo $this->get_field_name( 'num_users' ); ?>" type="text" value="<?php echo esc_attr( $num_users ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'roles' ); ?>"><?php _e( 'Limit to community role:' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'roles' ); ?>" id="<?php echo $this->get_field_id( 'roles' ); ?>">
				<option value="all" <?php echo ( $roles && "all" == $roles ) ? "selected" : ""; ?> ><?php _e('All roles','um-reviews'); ?></option>
				<?php foreach( $ultimatemember->query->get_roles( ) as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php echo ( $roles && $key == $roles ) ? "selected" : ""; ?> ><?php echo $value; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_users'] = ( ! empty( $new_instance['num_users'] ) ) ? strip_tags( $new_instance['num_users'] ) : 5;
		$instance['roles'] = ( ! empty( $new_instance['roles'] ) ) ? strip_tags( $new_instance['roles'] ) : 'all';
		return $instance;
	}

}