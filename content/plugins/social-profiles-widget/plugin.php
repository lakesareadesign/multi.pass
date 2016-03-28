<?php
/*
	Plugin Name: Social Profiles Widget
	Plugin URI: http://www.studiopress.com/plugins/social-profiles-widget
	Description: This plugin/widget allows you to insert social profile icons into your sidebar via a widget.
	Author: Nathan Rice
	Author URI: http://www.nathanrice.net/

	Version: 1.2.2

	License: GNU General Public License v2.0
	License URI: http://www.opensource.org/licenses/gpl-license.php

	NOTE: This plugin is released under the GPLv2 license. The images packaged with this plugin are the property
	of their respective owners, and do not, necessarily, inherit the GPLv2 license.
*/

/**
 * Register the Widget
 */
add_action('widgets_init', 'social_profiles_widget_register');
function social_profiles_widget_register() {
	register_widget('Social_Profiles_Widget');
}

/**
 * The Widget Class
 */
if ( !class_exists('Social_Profiles_Widget') ) {
class Social_Profiles_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'social-profiles', 'description' => __('Displays Social Profile links as icons', 'spw') );
		parent::__construct( 'socialprofiles', __('Social Profiles', 'spw'), $widget_ops );
	}

	var $plugin_imgs_url;

	function spw_fields_array( $instance = array() ) {

		$this->plugins_imgs_url = plugin_dir_url(__FILE__) . 'images/';

		return array(
			'feedburner' => array(
				'title' => __('RSS/Feedburner URL', 'spw'),
				'img' => sprintf( '%s/Feed_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Feed_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('RSS', 'spw')
			),
			'twitter' => array(
				'title' => __('Twitter URL', 'spw'),
				'img' => sprintf( '%s/Twitter_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Twitter_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Twitter', 'spw')
			),
			'facebook' => array(
				'title' => __('Facebook URL', 'spw'),
				'img' => sprintf( '%s/Facebook_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Facebook_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Facebook', 'spw')
			),
			'linkedin' => array(
				'title' => __('Linkedin URL', 'spw'),
				'img' => sprintf( '%s/Linkedin_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Linkedin_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Linkedin', 'spw')
			),
			'youtube' => array(
				'title' => __('YouTube URL', 'spw'),
				'img' => sprintf( '%s/Youtube_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Youtube_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Youtube', 'spw')
			),
			'flickr' => array(
				'title' => __('Flickr URL', 'spw'),
				'img' => sprintf( '%s/Flickr_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Flickr_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Flickr', 'spw')
			),
			'delicious' => array(
				'title' => __('Delicious URL', 'spw'),
				'img' => sprintf( '%s/Delicious_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Delicious_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Delicious', 'spw')
			),
			'stumbleupon' => array(
				'title' => __('StumbleUpon URL', 'spw'),
				'img' => sprintf( '%s/Stumbleupon_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Stumbleupon_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('StumbleUpon', 'spw')
			),
			'digg' => array(
				'title' => __('Digg URL', 'spw'),
				'img' => sprintf( '%s/Digg_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Digg_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('Digg', 'spw')
			),
			'myspace' => array(
				'title' => __('MySpace URL', 'spw'),
				'img' => sprintf( '%s/Myspace_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), esc_attr( $instance['size'] ) ),
				'img_widget' => sprintf( '%s/Myspace_%s.png', $this->plugins_imgs_url . esc_attr( $instance['icon_set'] ), '48x48' ),
				'img_title' => __('MySpace', 'spw')
			),
		);
	}

	function widget($args, $instance) {

		extract($args);

		$instance = wp_parse_args($instance, array(
			'title' => '',
			'new_window' => 0,
			'icon_set' => 'default',
			'size' => '24x24'
		) );

		echo $before_widget;

			if ( ! empty( $instance['title'] ) )
				echo $before_title . $instance['title'] . $after_title;
				
			$new_window = $instance['new_window'] ? 'target="_blank"' : '';

			foreach ( $this->spw_fields_array( $instance ) as $key => $data ) {
				if ( ! empty ( $instance[$key] ) ) {
					printf( '<a href="%s" %s><img src="%s" alt="%s" /></a>', esc_url( $instance[$key] ), $new_window, esc_url( $data['img'] ), esc_attr( $data['img_title'] ) );
				}
			}

		echo $after_widget;

	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {

		$instance = wp_parse_args($instance, array(
			'title' => '',
			'new_window' => 0,
			'icon_set' => 'default',
			'size' => '24x24'
		) );
?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'spw'); ?>:</label><br />
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />
		</p>
		
		<p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'spw' ); ?></label></p>

		<p>
			<label for="<?php echo $this->get_field_id('icon_set'); ?>"><?php _e('Icon Set', 'spw'); ?>:</label>
			<select id="<?php echo $this->get_field_id('icon_set'); ?>" name="<?php echo $this->get_field_name('icon_set'); ?>">
				<option style="padding-right:10px;" value="default" <?php selected('default', $instance['icon_set']); ?>><?php _e('Default', 'spw'); ?></option>
				<option style="padding-right:10px;" value="circles" <?php selected('circles', $instance['icon_set']); ?>><?php _e('Circles', 'spw'); ?></option>
				<option style="padding-right:10px;" value="denim" <?php selected('denim', $instance['icon_set']); ?>><?php _e('Denim', 'spw'); ?></option>
				<option style="padding-right:10px;" value="inside" <?php selected('inside', $instance['icon_set']); ?>><?php _e('Inside', 'spw'); ?></option>
				<option style="padding-right:10px;" value="sketch" <?php selected('sketch', $instance['icon_set']); ?>><?php _e('Sketch', 'spw'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Icon Size', 'spw'); ?>:</label>
			<select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>">
				<option style="padding-right:10px;" value="24x24" <?php selected('24x24', $instance['size']); ?>><?php _e('Mini', 'spw'); ?> (24px)</option>
				<option style="padding-right:10px;" value="32x32" <?php selected('32x32', $instance['size']); ?>><?php _e('Small', 'spw'); ?> (32px)</option>
				<option style="padding-right:10px;" value="48x48" <?php selected('48x48', $instance['size']); ?>><?php _e('Large', 'spw'); ?> (48px)</option>
			</select>
		</p>

		<p><?php _e('Enter the URL(s) for your various social profiles below. If you leave a profile URL field blank, it will not be used.', 'spw'); ?></p>

<?php

		foreach ( $this->spw_fields_array( $instance ) as $key => $data ) {
			echo '<p>';
			printf( '<img style="float: left; margin-right: 3px;" src="%s" title="%s" />', $data['img_widget'], $data['img_title'] );
			printf( '<label for="%s"> %s:</label>', esc_attr( $this->get_field_id($key) ), esc_attr( $data['title'] ) );
			printf( '<input id="%s" name="%s" value="%s" style="%s" />', esc_attr( $this->get_field_id($key) ), esc_attr( $this->get_field_name($key) ), esc_url( $instance[$key] ), 'width:65%;' );
			echo '</p>' . "\n";
		}

	}
}}