<?php
/**
 * User search template
 *
 * @package wpmu-dev-seo
 */

	$users = empty( $users ) ? array() : $users;
	$users_key = empty( $users_key ) ? '' : $users_key;
	$new_user_key = empty( $new_user_key ) ? '' : $new_user_key;
	$option_name = empty( $option_name ) ? '' : $option_name;

	$field_name = sprintf( '%s[%s][]', $option_name, $users_key );
	$select_field_name = sprintf( '%s[%s]', $option_name, $new_user_key );
?>

<?php if ( $users ) { ?>
	<div class="wds-user-search"
		 data-option-name="<?php echo esc_attr( $option_name ); ?>"
		 data-users-key="<?php echo esc_attr( $users_key ); ?>"
		 data-new-user-key="<?php echo esc_attr( $new_user_key ); ?>">

		<ul>
			<?php foreach ( $users as $user_id ) {  ?>
				<li>
					<span class="wds-user-search-avatar"><?php echo get_avatar( $user_id ); ?></span>

					<span class="wds-user-search-user"><?php echo esc_html( Smartcrawl_Model_User::get( $user_id )->get_display_name() ); ?></span>

					<?php if ( get_current_user_id() == $user_id ) {  ?>
						<span class="wds-user-search-you"><?php esc_html_e( 'You', 'wds' ); ?></span>
					<?php } ?>

					<span class="wds-user-search-remove"><a href="#remove-user"><?php esc_html_e( 'Remove', 'wds' ); ?></a></span>

					<input type="hidden"
						   name="<?php echo esc_attr( $field_name ); ?>"
						   value="<?php echo esc_attr( $user_id ); ?>"/>
				</li>
			<?php } ?>
		</ul>

		<div class="wds-user-search-field select-container select-container-no-style">
			<div>
				<select name="<?php echo esc_attr( $select_field_name ); ?>"
						style="width: 100%;">
				</select>
			</div>
			<div>
				<input type="button" value="<?php esc_html_e( 'Add', 'wds' ); ?>" class="button button-dark"/>
			</div>
		</div>
	</div>
<?php } ?>