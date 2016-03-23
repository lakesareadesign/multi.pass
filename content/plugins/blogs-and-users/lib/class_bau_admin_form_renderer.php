<?php
/**
 * Renders form elements for admin settings pages.
 */
class Bau_AdminFormRenderer {

	function _get_option () {
		return get_site_option('bau');
	}

	function _create_radiobox ($name, $label, $value) {
		$opt = $this->_get_option();
		$checked = (@$opt[$name] == $value) ? true : false;
		return "<input type='radio' name='bau[{$name}]' id='{$name}-{$value}' value='{$value}' " . ($checked ? 'checked="checked" ' : '') . " /> " .
			"<label for='{$name}-{$value}'>{$label}</label>";
	}

	function create_show_add_new_users_box () {
		$options = array (
			'add_users' => __('Yes', 'bau'),
			'manage_network_options' => __('Super Admins only', 'bau'),
			'' => __('No', 'bau'),
		);
		foreach ($options as $opt => $label) {
			echo $this->_create_radiobox('show_add_new_users', $label, $opt) . '<br />';
		}
	}

	function create_show_add_existing_users_box () {
		$options = array (
			'add_users' => __('Yes', 'bau'),
			'manage_network_options' => __('Super Admins only', 'bau'),
			'' => __('No', 'bau'),
		);
		foreach ($options as $opt => $label) {
			echo $this->_create_radiobox('show_add_existing_users', $label, $opt) . '<br />';
		}
	}

	function create_show_add_blogs_box () {
		$options = array (
			'add_users' => __('Yes', 'bau'),
			'manage_network_options' => __('Super Admins only', 'bau'),
			'' => __('No', 'bau'),
		);
		foreach ($options as $opt => $label) {
			echo $this->_create_radiobox('show_add_blogs', $label, $opt) . '<br />';
		}
	}

	function create_messages_info () {
		?>
			<p><?php _e('This is where you can set up message pop-ups for certain fields in the Creator interface. You can make use of these messages to e.g. explain format restrictions to your users.', 'bau'); ?></em>
			<p><?php _e('Simply leave the message boxes empty in order not to show them.', 'bau'); ?></em>

			<h3><?php _e( 'Username message', 'bau' ); ?></h3>
		<?php
	}

	function create_username_title_popup_box () {
		$opt = $this->_get_option();
		$ttl = @$opt['username_msg_title'];

		?>
		<input type="text" class="widefat" name="bau[username_msg_title]" value="<?php echo esc_html( wp_strip_all_tags( $ttl ) ); ?>" />
		<?php
	}

	function create_username_body_popup_box () {
		$opt = $this->_get_option();
		$msg = @$opt['username_msg_body'];

		?>
		<textarea class="widefat" rows="4" name="bau[username_msg_body]"><?php echo esc_html( wp_strip_all_tags( $msg ) ); ?></textarea>
		<?php
	}

	function create_password_title_popup_box () {
		$opt = $this->_get_option();
		$ttl = @$opt['password_msg_title'];

		?>
		<input type="text" class="widefat" name="bau[password_msg_title]" value="<?php echo esc_html( wp_strip_all_tags( $ttl ) ); ?>" />
		<?php
	}

	function create_password_body_popup_box () {
		$opt = $this->_get_option();
		$msg = @$opt['password_msg_body'];

		?>
		<textarea class="widefat" rows="4" name="bau[password_msg_body]"><?php echo esc_html( wp_strip_all_tags( $msg ) ); ?></textarea>
		<?php
	}

	function create_email_title_popup_box () {
		$opt = $this->_get_option();
		$ttl = @$opt['email_msg_title'];

		?>
		<input type="text" class="widefat" name="bau[email_msg_title]" value="<?php echo esc_html( wp_strip_all_tags( $ttl ) ); ?>" />
		<?php
	}

	function create_email_body_popup_box () {
		$opt = $this->_get_option();
		$msg = @$opt['email_msg_body'];

		?>
		<textarea class="widefat" rows="4" name="bau[email_msg_body]"><?php echo esc_html( wp_strip_all_tags( $msg ) ); ?></textarea>
		<?php
	}

}