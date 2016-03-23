<?php

/**
 * Testimonials Widget
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

/**
 * Sample widget
 *
 * @since 1.0.0
 */
add_action( 'widgets_init', create_function( '', "register_widget('Showcase_Testimonial_Widget');" ) );
class Showcase_Testimonial_Widget extends WP_Widget {

    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @since 1.0.0
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    function __construct() {

        // widget defaults
        $this->defaults = array(
            'title'          => '',
            'count'          => 3,
        );

        // Widget Slug
        $widget_slug = 'showcase-testimonial-widget';

        // widget basics
        $widget_ops = array(
            'classname'   => $widget_slug,
            'description' => 'Displays a list of your testimonials in a slider'
        );

        // widget controls
        $control_ops = array(
            'id_base' => $widget_slug,
            'width'   => '200',
        );

        // load widget
        parent::__construct( $widget_slug, 'Showcase Testimonial Slider', $widget_ops, $control_ops );

    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @since 1.0.0
     * @param array $instance An array of the current settings for this widget
     */
    function form( $instance ) {

        // Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Testimonials:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>" class="" />
        </p>
        <?php
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @since 1.0.0
     * @param array $new_instance An array of new settings as submitted by the admin
     * @param array $old_instance An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {

        $new_instance['title']  = strip_tags( $new_instance['title'] );
        $new_instance['count']  = (int) esc_attr( $new_instance['count'] );

        return $new_instance;
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @since 1.0.0
     * @param array $args An array of standard parameters for widgets in this theme
     * @param array $instance An array of settings for this widget instance
     */
    function widget( $args, $instance ) {

        extract( $args );

        // Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        $loop = new WP_Query( array(
            'posts_per_page' => $instance['count'],
            'post_type'      => 'testimonials',
            'order'          => 'ASC',
            'order_by'       => 'menu_order'
        ) );

        if( $loop->have_posts() ) {

            echo $before_widget;

            // Title
            if ( !empty( $instance['title'] ) ) {
                echo $before_title . $instance['title'] . $after_title;
            }

            // Testimonials
            echo '<ul class="testimonial-slider">';
            while( $loop->have_posts() ) {

                $loop->the_post();

                $quote = get_the_content();
                $name = get_the_title();
                $image = get_the_post_thumbnail( '', array( 100, 100) );

                ?>

                    <li id="post-<?php the_ID(); ?>" <?php post_class($class) ?>>
                        <blockquote><?php echo $quote; ?></blockquote>
                        <div class="testimonial-source">
                            <?php if( has_post_thumbnail() ) : echo $image; endif; ?>
                            <h5><?php echo $name; ?></h5>
                        </div>
                    </li>

                <?php

                $i++;

            }

            echo '</ul>';

            echo $after_widget;

        }
        wp_reset_postdata();
    }

}