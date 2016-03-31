<?php

class Bueno_featured extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Populate your sidebar with posts from a tag category.' );
       parent::__construct(false, __('Woo - Featured Posts', 'woothemes'),$widget_ops);
   }


   function widget( $args, $instance ) {
    global $post;
    $posts_args = array();
    $tag_name = '';
    $title = '';

    if ( ( isset( $instance['tag_id'] ) && '' != $instance['tag_id'] ) ) {
        $tax_params = array( 'taxonomy' => 'post_tag', 'field' => 'id', 'terms' => absint( $instance['tag_id'] ) );
        $posts_args['tax_query'] = array( $tax_params );
    }

    if ( isset( $instance['num'] ) ) {
      $posts_args['posts_per_page'] = absint( $instance['num'] );
    }

    $posts_query = new WP_Query( $posts_args );

    if( $title == '' ){
      $title = __( 'Featured Posts', 'woothemes' );
    }
     ?>
     <div id="featured" class="widget">
     <h3><?php echo $title; ?></h3>
        <ul>

            <?php if ( $posts_query->have_posts() ) : $count = 0; ?>
            <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); $count++; ?>

			<li>
				<span class="thumb">
					<?php woo_get_image('image',70,70,'thumbnail',90,get_the_id(),'src',1,0,'','',true); ?>
				</span>
				<div class="right">
					<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
					<p><?php
					    if ( $instance['content'] == 'excerpt' ) {
                the_excerpt();
              } else {
                the_content();
              }
					   ?></p>
				</div>
			</li>
                <!-- Post Ends -->

          <?php
              endwhile;
              wp_reset_postdata();
            else:
            endif;
          ?>
            </ul>

            <div class="fix"></div>

            </div>

            <?php




   }

    function update( $new_instance, $old_instance ) {
      $settings = array();
      $settings['title'] = sanitize_text_field( $new_instance['title'] );
      $settings['tag_id'] = absint( $new_instance['tag_id'] );
      $settings['num'] = absint( $new_instance['num'] );
      if ( in_array( $new_instance['content'], array( 'content', 'excerpt' ) ) ) {
        $settings['content'] = sanitize_text_field( $new_instance['content'] );
      } else {
        $settings['content'] = 'excerpt';
      }
      return $settings;
    }

   function form($instance) {

      $tag_id = '';
      $num = 5;
      $title = '';
      $content = 'excerpt';

      if ( isset( $instance['tag_id'] ) ) {
        $tag_id = esc_attr( $instance['tag_id'] );
      }

      if ( isset( $instance['num'] ) ) {
        $num = esc_attr( $instance['num'] );
      }

      if ( isset( $instance['title'] ) ) {
        $title = esc_attr( $instance['title'] );
      }

      if ( isset( $instance['content'] ) ) {
        $content = esc_attr( $instance['content'] );
      }

  ?>


		<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number Of Posts:','woothemes'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="number" value="<?php echo esc_attr( absint( $num ) ); ?>" />
        </p>
        <p>
	   	   <label for="<?php echo $this->get_field_id('tag_id'); ?>"><?php _e('Media Tag:','woothemes'); ?></label>
	       <?php $tags = get_tags(); ?>
	       <select name="<?php echo $this->get_field_name('tag_id'); ?>" class="widefat" id="<?php echo $this->get_field_id('tag_id'); ?>">
           <option value="">-- Please Select --</option>
			<?php

           	foreach ($tags as $tag){
           	?><option value="<?php echo $tag->term_id; ?>" <?php if($tag_id == $tag->term_id){ echo "selected='selected'";} ?>><?php echo $tag->name . ' (' . $tag->count . ')'; ?></option><?php
           	}
           ?>
           </select>
       </p>
       <p>
          <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Show Content:','woothemes'); ?></label>
          <select name="<?php echo $this->get_field_name('content'); ?>" class="widefat" id="<?php echo $this->get_field_id('content'); ?>">
           <option value="content" <?php if($content == "content"){ echo "selected='selected'";} ?>>The Content</option>
           <option value="excerpt" <?php if($content == "excerpt"){ echo "selected='selected'";} ?>>The Excerpt</option>
           </select>
       </p>
      <?php
   }

}

register_widget('Bueno_featured');