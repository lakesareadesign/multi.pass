<?php

class woo_CampaignMonitorWidget extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_campaign_monitor', 'description' => 'Add a Campaign Monitor subscription form' );
		parent::__construct('campaign_monitor', 'Woo - Campaign Monitor', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 'Subscribe Now' : apply_filters('widget_title', $instance['title']);
		$action = empty($instance['action']) ? '#' : apply_filters('widget_action', $instance['action']);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);

		echo '<div id="campaignmonitor" class="widget">';
		echo '<h3>'.$title.'</h3>';
		echo '<form name="campaignmonitorform" id="campaignmonitorform" action="'.$action.'" method="post">';
		echo '<input type="text" name="cm-'.$id.'" id="'.$id.'" class="field" value="Enter your e-mail address" onfocus="if (this.value == \'Enter your e-mail address\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Enter your e-mail address\';}" />';
		echo '<input id="newsletter-submit" class="submit" type="submit" name="submit" value="Submit" />';
		echo '</form>';
		echo '</div><!-- /campaignmonitor -->';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$settings = array();
		$settings['title'] = sanitize_text_field( $new_instance['title'] );
		$settings['action'] = esc_url_raw( $new_instance['action'] );
		$settings['id'] = sanitize_text_field( strip_tags($new_instance['id'] ) );
		return $settings;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'action' => '', 'id' => '' ) );
		$title = sanitize_text_field( $instance['title'] );
		$action = esc_url_raw( $instance['action'] );
		$id = sanitize_text_field( strip_tags( $instance['id'] ) );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('action'); ?>">Form Action: <input class="widefat" id="<?php echo $this->get_field_id('action'); ?>" name="<?php echo $this->get_field_name('action'); ?>" type="text" value="<?php echo esc_attr( $action ); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('id'); ?>">Campaign Monitor ID: <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" /></label></p>
<?php
	}
}
register_widget('woo_CampaignMonitorWidget');