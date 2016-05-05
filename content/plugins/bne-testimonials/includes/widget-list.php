<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Widget List Class
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@updated: 	August 19, 2015
*/


/*
 * @since v1.1
*/
class bne_testimonials_list_widget extends WP_Widget {

	// Constructor
	function bne_testimonials_list_widget() {
		parent::__construct(
			false,
			$name = __('BNE Testimonial List', 'bne-testimonials'),
			array('description' => __( 'Display your testimonials as a list.', 'bne-testimonials') ),
			$control_ops = array('width' => 350)
		);
	}



	// Widget Form Creation
	function form($instance) {

		// Check values
		if( $instance) {
			$title = esc_attr($instance['title']);
			$number_of_post = esc_attr($instance['number_of_post']);
			$order = esc_attr($instance['order']);
			$order_direction = esc_attr($instance['order_direction']);
			$category = esc_attr($instance['category']);
			$name = esc_attr($instance['name']);
			$image = esc_attr($instance['image']);
			$image_style = esc_attr($instance['image_style']);
			$lightbox_rel = esc_attr($instance['lightbox_rel']);
			$class = esc_attr($instance['class']);

		} else {
			$title = 'Testimonials';
			$number_of_post = '-1';
			$order = 'date';
			$order_direction = 'DESC';
			$category = '';	// Show All
			$name = 'true';
			$image = 'true';
			$image_style = 'square';
			$lightbox_rel = '';
			$class = '';

		}
		?>

			<!-- Widget Title -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'bne-testimonials'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

			<!-- Query Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">
				<h4 style="margin:2px 0px;"><?php echo _e('Query Options', 'bne-testimonials' ); ?></h4>

				<!-- Number of Post to Display -->
				<p>
					<label for="<?php echo $this->get_field_id('number_of_post'); ?>"><?php _e('Number of Testimonials', 'bne-testimonials'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('number_of_post'); ?>" name="<?php echo $this->get_field_name('number_of_post'); ?>" type="text" value="<?php echo $number_of_post; ?>" />
					<span style="display:block;padding:2px 0" class="description"><?php echo _e( 'A numerical value. Use "-1" to show all.', 'bne-testimonials'); ?></span>
				</p>

				<!-- Testimonial Orderby -->
				<p>
					<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Testimonial Order (orderby query)', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
						<?php
							echo '<option value="date" id="date"', $order == 'date' ? ' selected="selected"' : '', '>By Published Date</option>';
							echo '<option value="rand" id="rand"', $order == 'rand' ? ' selected="selected"' : '', '>In a Random Order</option>';
							echo '<option value="title" id="title"', $order == 'title' ? ' selected="selected"' : '', '>By Name (alphabetical order)</option>';
						?>
					</select>
				</p>

				<!-- Testimonial Order Direction -->
				<p>
					<label for="<?php echo $this->get_field_id('order_direction'); ?>"><?php _e('Order Direction', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('order_direction'); ?>" id="<?php echo $this->get_field_id('order_direction'); ?>" class="widefat">
						<?php
							echo '<option value="DESC" id="DESC"', $order_direction == 'DESC' ? ' selected="selected"' : '', '>Descending Order</option>';
							echo '<option value="ASC" id="ASC"', $order_direction == 'ASC' ? ' selected="selected"' : '', '>Ascending Order</option>';
						?>
					</select>
					<span style="display:block;padding:2px 0" class="description"><?php echo _e('Does not apply if the testimonial order is set to random.', 'bne-testimonials'); ?></span>
				</p>


				<!-- Taxonomy Options -->
				<p>
					<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Testimonial Category', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>" class="widefat">
						<?php
							// Option to show all taxonomies of this post type (returns empty)
							echo '<option value="" id="show_all"', $category == '' ? ' selected="selected"' : '', '>All Categories</option>';

							// Get the ID's of Custom Taxonomies
							$taxonomy_name = "bne-testimonials-taxonomy";
							$tax_args = array(
								'orderby' 		=> 'name',
								'hide_empty' 	=> 1,
								'hierarchical' 	=> 1
							);

							$terms = get_terms($taxonomy_name,$tax_args);

							foreach($terms as $term) {
								echo '<option value="' . $term->name . '" id="' . $term->name . '"', $category == $term->name ? ' selected="selected"' : '', '>', $term->name, '</option>';
							}
						?>
					</select>
				</p>
			</div><!-- Query Options (end) -->

			<!-- Individual Testimonial Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">
				<h4 style="margin:2px 0px;"><?php echo _e('Individual Testimonial Options', 'bne-testimonials'); ?></h4>

				<!-- Testimonial Name -->
				<p>
					<label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Show Person\'s Name (Testimonial Title)', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $name == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $name == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>

				<!-- Testimonial Featured Image -->
				<p>
					<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Show Featured Testimonial Image', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $image == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $image == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>

				<!-- Testimonial Featured Image Style -->
				<p>
					<label for="<?php echo $this->get_field_id('image_style'); ?>"><?php _e('Featured Testimonial Image Style', 'bne-testimonials'); ?>:</label>
					<select name="<?php echo $this->get_field_name('image_style'); ?>" id="<?php echo $this->get_field_id('image_style'); ?>" class="widefat">
						<?php
							echo '<option value="square" id="square"', $image_style == 'square' ? ' selected="selected"' : '', '>Square</option>';
							echo '<option value="circle" id="circle"', $image_style == 'circle' ? ' selected="selected"' : '', '>Circle</option>';
							echo '<option value="flat-square" id="flat-square"', $image_style == 'flat-square' ? ' selected="selected"' : '', '>Flat Square</option>';
							echo '<option value="flat-circle" id="flat-circle"', $image_style == 'flat-circle' ? ' selected="selected"' : '', '>Flat Circle</option>';
						?>
					</select>
				</p>

			</div><!-- Individual Options (end) -->

			<!-- Advanced Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">
				<h4 style="margin:2px 0px;"><?php echo _e('Advanced Options'); ?></h4>
				<!-- Lightbox Rel Setting -->
				<p>
					<label for="<?php echo $this->get_field_id('lightbox_rel'); ?>"><?php _e('Featured Image Lightbox', 'bne-testimonials'); ?>:  </label>
					<span>rel="</span>
					<input class="widefat" id="<?php echo $this->get_field_id('lightbox_rel'); ?>" name="<?php echo $this->get_field_name('lightbox_rel'); ?>" type="text" value="<?php echo $lightbox_rel; ?>" style="display:inline-block; width: 100px;"/>
					<span>"</span>
					<span style="display:block;padding:5px 0" class="description"><?php echo _e('Only works if a lightbox plugin is installed or your theme provides one which uses the "rel" attribute on the anchor tag. For example, prettyPhoto uses rel="prettyPhoto".', 'bne-testimonials'); ?></span>
				</p>

				<!-- Custom Class -->
				<p>
					<label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Optional CSS Class Name', 'bne-testimonials'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo $class; ?>" />
					<span style="display:block;padding:5px 0" class="description"><?php echo _e( 'Allows you to target this testimonial widget with a unique class for further css customizations.', 'bne-testimonials'); ?></span>
				</p>

			</div><!-- Advanced Options (end) -->

		<?php
	}


	// Update the Widget Settings
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number_of_post'] = strip_tags($new_instance['number_of_post']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['order_direction'] = strip_tags($new_instance['order_direction']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['image_style'] = strip_tags($new_instance['image_style']);
		$instance['lightbox_rel'] = strip_tags($new_instance['lightbox_rel']);
		$instance['class'] = strip_tags($new_instance['class']);

		return $instance;
	}

	// Display the Widget on the Frontend
	function widget($args, $instance) {

		extract( $args );
			// These are the widget options
			$title = apply_filters('widget_title', $instance['title']);
			$number_of_post = $instance['number_of_post'];
			$order = $instance['order'];
			$order_direction = $instance['order_direction'];
			$category = $instance['category'];
			$name = $instance['name'];
			$image = $instance['image'];
			$image_style = $instance['image_style'];
			$lightbox_rel = $instance['lightbox_rel'];
			$class = $instance['class'];

			// Set Post Order Direction based on Orderby Type
			//if ($order == 'date') { $order_direction = 'DESC'; } else { $order_direction = 'ASC'; }


		// Testimonial Loop Args
		$query_args = array(
			'post_type' 		=> 'bne_testimonials',
			'order'				=> $order_direction,
			'orderby' 			=> $order,
			'posts_per_page'	=> $number_of_post,
			'taxonomy' 			=> 'bne-testimonials-taxonomy',
			'term' 				=> $category
		);

		// Set Image Class from Widget Option
		$featured_image_class = 'bne-testimonial-featured-image ' . $image_style;

		// Before Widget
		echo $before_widget;

		// Display the widget
		echo '<div class="bne_testimonial_list_widget">';

		// Check if Widget title is set
		if ( $title ) {
		  echo $before_title . $title . $after_title;
		}

		// Begin the Query
		$bne_testimonials = new WP_Query( $query_args );
		if( $bne_testimonials->have_posts() ) {

			echo '<div class="bne-element-container '.$class.'">';


				// Above List Filter
				echo apply_filters('bne_testimonials_list_above', '');



				// Testimonial Wrapper
				echo '<div class="bne-testimonial-list-wrapper">';

					// The Loop
					while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();

						// Pull in Plugin Options
						$options = bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name );

						// Build Single Testimonial
						echo '<div class="single-bne-testimonial">';

							// Above Single List Filter
							echo apply_filters('bne_testimonials_list_single_above', '');

							// Single Testimonial Setup Function
							echo bne_testimonials_single_structure( $options );

							// Below Single List Filter
							echo apply_filters('bne_testimonials_list_single_below', '');

							echo '<div class="clear"></div>';

						echo '</div><!-- .single-bne-testimonial (end) -->';
						// END Single Testimonial

					endwhile;

				echo '</div><!-- .bne-testimonial-list-wrapper (end) -->';

				// Below List Filter
				echo apply_filters('bne_testimonials_list_below', '');

			echo '</div><!-- .bne-element-container (end) -->';
			echo '<div class="clear"></div>';

		// If No Testimonials, display warning message
		} else {
			echo '<div class="bne-testimonial-warning">No testimonials were found.</div>';
		}

		wp_reset_postdata();

		echo '</div><!-- .bne_testimonial_list_widget (end) -->';
		echo $after_widget;
	}

}

// Register Widget
add_action('widgets_init', create_function('', 'return register_widget("bne_testimonials_list_widget");'));