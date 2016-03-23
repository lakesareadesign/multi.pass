<?php

/**
 * Team Widget
 *
 * @package Showcase Pro
 * @author JT Grauke
 * @since 1.0.0
 * @link http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

add_action( 'widgets_init', create_function( '', "register_widget('Showcase_Team_Widget');" ) );
class Showcase_Team_Widget extends WP_Widget {

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
            'text-before'    => '',
            'text-after'     => '',
        );

        // Widget Slug
        $widget_slug = 'showcase-team-widget';

        // widget basics
        $widget_ops = array(
            'classname'   => $widget_slug,
            'description' => 'Displays your team post type in a grid format'
        );

        // widget controls
        $control_ops = array(
            'id_base' => $widget_slug,
            'width'   => '400',
        );

        // load widget
        parent::__construct( $widget_slug, 'Showcase Team Grid', $widget_ops, $control_ops );

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
            <label for="<?php echo $this->get_field_id( 'text-before' ); ?>">Text Before:</label>
            <textarea id="<?php echo $this->get_field_id( 'text-before' ); ?>" name="<?php echo $this->get_field_name( 'text-before' ); ?>" class="widefat" rows="5"><?php echo esc_attr( $instance['text-before'] ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'text-after' ); ?>">Text After:</label>
            <textarea id="<?php echo $this->get_field_id( 'text-after' ); ?>" name="<?php echo $this->get_field_name( 'text-after' ); ?>" class="widefat" rows="5"><?php echo esc_attr( $instance['text-after'] ); ?></textarea>
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
        $new_instance['text-before']  = $new_instance['text-before'];
        $new_instance['text-after']  = $new_instance['text-after'];

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

        remove_action( 'genesis_entry_footer', 'genesis_post_meta');

        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $loop = new WP_Query( array(
            'posts_per_page' => -1,
            'post_type'      => 'team',
            'order'          => 'ASC',
            'order_by'       => 'menu_order',
            'paged'          => $paged
        ) );

        if( $loop->have_posts() ) {

            echo $before_widget;

            $title = $instance['title'];
            $text_before = $instance['text-before'];
            $text_after = $instance['text-after'];

            if ( $title ) {
                echo $before_title . $title . $after_title;
            }

            if ( $text_before ) {
                echo '<div class="before-team-widget">' . $text_before . '</div>';
            }

            // Testimonials
            echo '<div class="team-grid">';
            while( $loop->have_posts() ) {

                $loop->the_post();

                $class = ($i % 4 == 0) ? ' one-fourth first' : 'one-fourth';

                ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class($class) ?>>
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'showcase' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <div class="overlay-details">
                                    <?php the_title( '<h4>', '</h4>' );?>
                                    <span>View Profile</span>
                                </div>
                            </div>
                        </div>
                        <?php if(has_post_thumbnail()) : the_post_thumbnail( 'showcase_team_thumb' ); endif; ?>
                    </a>
                </div>

                <?php

                $i++;

            }

            echo '</div>';

            if ( $text_after ) {
                echo '<div class="after-team-widget">' . $text_after . '</div>';
            }

            echo $after_widget;

        }
        wp_reset_postdata();
    }
}