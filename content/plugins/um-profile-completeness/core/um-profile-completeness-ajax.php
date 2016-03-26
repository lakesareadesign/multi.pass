<?php

	/***
	***	@save field over popup
	***/
	add_action('wp_ajax_nopriv_um_profile_completeness_save_popup', 'um_profile_completeness_save_popup');
	add_action('wp_ajax_um_profile_completeness_save_popup', 'um_profile_completeness_save_popup');
	function um_profile_completeness_save_popup(){
		global $ultimatemember, $wpdb, $um_profile_completeness;

		if ( !isset( $_POST['key'] ) || !isset( $_POST['value'] ) || !is_user_logged_in() ) die(0);

		$user_id = get_current_user_id();
		
		if ( get_user_meta( $user_id, $_POST['key'], true ) ) die(0);
		
		$role = get_user_meta( $user_id, 'role', true );
		$post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'um_role' AND post_name = '$role'");
		
		$percent = get_post_meta( $post_id, '_um_progress_' . $_POST['key'], true );
		
		if ( strstr( $_POST['value'], ', ' ) ) {
			$_POST['value'] = explode( ', ', $_POST['value'] );
		}
		
		update_user_meta( $user_id, $_POST['key'], $_POST['value'] );
		
		delete_option( "um_cache_userdata_{$user_id}" );
		
		$result = $um_profile_completeness->shortcode->profile_progress( $user_id );
		$output['percent'] = $result['progress'];
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}

	/***
	***	@edit field over popup
	***/
	add_action('wp_ajax_nopriv_um_profile_completeness_edit_popup', 'um_profile_completeness_edit_popup');
	add_action('wp_ajax_um_profile_completeness_edit_popup', 'um_profile_completeness_edit_popup');
	function um_profile_completeness_edit_popup(){
		global $ultimatemember, $um_profile_completeness;
		
		if ( !isset( $_POST['key'] ) || !is_user_logged_in() ) die(0);

		ob_start();
		
		um_fetch_user( get_current_user_id() );
		
		if ( get_user_meta( get_current_user_id(), $_POST['key'], true ) ) die(0);
		
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		
		$data = $ultimatemember->builtin->get_a_field( $_POST['key'] );
		
		$ultimatemember->fields->disable_tooltips = true;
		
		?>
		
		<div class="um-completeness-editwrap" data-key="<?php echo $_POST['key']; ?>">
		
			<div class="um-completeness-header"><?php _e('Complete your profile','um-profile-completeness'); ?></div>
			
			<div class="um-completeness-complete"><?php printf(__('Your profile is %s complete','um-profile-completeness'), '<span style="color:#3ba1da"><strong><span class="um-completeness-jx">' . $result['progress'] . '</span>%</strong></span>' ); ?></div>
			
			<div class="um-completeness-bar-holder">
				<?php echo $result['bar']; ?>
			</div>
			
			<div class="um-completeness-field">
				<?php echo $ultimatemember->fields->edit_field( $_POST['key'], $data ); ?>
			</div>

			<div class="um-completeness-save">
				<a href="#" class="save"><?php _e('Save','um-profile-completeness'); ?></a>
				<a href="#" class="skip"><?php _e('Do this later','um-profile-completeness'); ?></a>
			</div>
		
		</div>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		die($output);
	}

	/***
	***	@ajax to remove field
	***/
	add_action('wp_ajax_nopriv_um_admin_profile_completeness_remove', 'um_admin_profile_completeness_remove');
	add_action('wp_ajax_um_admin_profile_completeness_remove', 'um_admin_profile_completeness_remove');
	function um_admin_profile_completeness_remove(){
		global $ultimatemember, $um_profile_completeness;

		if ( !isset($_POST['post_id']) || !$_POST['post_id'] ) return;
		$post_id = $_POST['post_id'];
		
		$output = '';
		$post_type = get_post_type_object( get_post_type( $post_id ) );
		if ( get_post_type( $post_id ) != 'um_role' || !current_user_can( $post_type->cap->edit_post, $post_id ) ) die();
		
		if ( !isset( $_POST['progress_value'] ) || !is_numeric( $_POST['progress_value'] ) ) die();
		if ( !isset( $_POST['progress_field'] ) || !$_POST['progress_field'] ) die();
		
		$pct = $_POST['progress_value'];
		$key = $_POST['progress_field'];
		
		$progress = get_post_meta( $post_id, '_um_allocated_progress', true );
		$allocated = get_post_meta( $post_id, '_um_progress_'. $key, true );
		$progress = $progress - $allocated;
		
		delete_post_meta( $post_id, '_um_progress_'. $key );
		update_post_meta( $post_id, '_um_allocated_progress', $progress );

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
		
	}

	/***
	***	@ajax to edit field
	***/
	add_action('wp_ajax_nopriv_um_admin_profile_completeness_update', 'um_admin_profile_completeness_update');
	add_action('wp_ajax_um_admin_profile_completeness_update', 'um_admin_profile_completeness_update');
	function um_admin_profile_completeness_update(){
		global $ultimatemember, $um_profile_completeness;

		if ( !isset($_POST['post_id']) || !$_POST['post_id'] ) return;
		$post_id = $_POST['post_id'];
		
		$output = '';
		$post_type = get_post_type_object( get_post_type( $post_id ) );
		if ( get_post_type( $post_id ) != 'um_role' || !current_user_can( $post_type->cap->edit_post, $post_id ) ) die();
		
		if ( !isset( $_POST['progress_value'] ) || !is_numeric( $_POST['progress_value'] ) ) die();
		if ( !isset( $_POST['progress_field'] ) || !$_POST['progress_field'] ) die();
		
		$pct = $_POST['progress_value'];
		$key = $_POST['progress_field'];
		
		$progress = get_post_meta( $post_id, '_um_allocated_progress', true );
		if ( !$progress ) $progress = 0;
		
		$allocated = get_post_meta( $post_id, '_um_progress_'. $key, true );
		
		$progress = $progress - $allocated;
		$progress = $progress + $pct;
		
		if ( $progress > 100 ) die();
		
		update_post_meta( $post_id, '_um_allocated_progress', $progress );
		update_post_meta( $post_id, '_um_progress_'. $key, $pct );
		
		$output['allocated'] = $allocated;
		$output['pct'] = $pct;
		
		$output['remaining'] = 100 - (int) get_post_meta( $post_id, '_um_allocated_progress', true );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
		
	}

	/***
	***	@ajax to save field
	***/
	add_action('wp_ajax_nopriv_um_admin_profile_completeness_save', 'um_admin_profile_completeness_save');
	add_action('wp_ajax_um_admin_profile_completeness_save', 'um_admin_profile_completeness_save');
	function um_admin_profile_completeness_save(){
		global $ultimatemember, $um_profile_completeness;

		if ( !isset($_POST['post_id']) || !$_POST['post_id'] ) return;
		$post_id = $_POST['post_id'];
		
		$output = '';
		$post_type = get_post_type_object( get_post_type( $post_id ) );
		if ( get_post_type( $post_id ) != 'um_role' || !current_user_can( $post_type->cap->edit_post, $post_id ) ) die();
		
		if ( !isset( $_POST['progress_value'] ) || !is_numeric( $_POST['progress_value'] ) ) die();
		if ( !isset( $_POST['progress_field'] ) || !$_POST['progress_field'] ) die();

		$pct = $_POST['progress_value'];
		$key = $_POST['progress_field'];
		
		if ( get_post_meta( $post_id, '_um_progress_'. $key ) ) die();
		
		$progress = get_post_meta( $post_id, '_um_allocated_progress', true );
		if ( !$progress ) $progress = 0;
		if ( $progress == 100 ) die();
		
		$progress = $progress + $pct;
		update_post_meta( $post_id, '_um_allocated_progress', $progress );
		update_post_meta( $post_id, '_um_progress_'. $key, $pct );
		
		$output['res'] = "<p><span class='profilec-key alignleft'>$key</span><span class='profilec-progress alignright'><strong><ins>$pct</ins>%</strong> <span class='profilec-edit'><i class='um-faicon-pencil'></i></span></span></p><div class='clear'></div>"; 
		$output['pct'] = $pct;
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
		
	}
	
	/***
	***	@ajax to add field
	***/
	add_action('wp_ajax_nopriv_um_admin_profile_completeness_add', 'um_admin_profile_completeness_add');
	add_action('wp_ajax_um_admin_profile_completeness_add', 'um_admin_profile_completeness_add');
	function um_admin_profile_completeness_add(){
		global $ultimatemember, $um_profile_completeness;

		if ( !isset($_POST['post_id']) || !$_POST['post_id'] ) return;
		$post_id = $_POST['post_id'];
		
		$output = '';
		$post_type = get_post_type_object( get_post_type( $post_id ) );
		if ( get_post_type( $post_id ) != 'um_role' || !current_user_can( $post_type->cap->edit_post, $post_id ) ) die();
		
		// show input
		$fields = $ultimatemember->builtin->all_user_fields( null, true );
		
		$output['res'] = '<p><select name="progress_field" id="progress_field" class="umaf-selectjs" style="width: 300px" data-placeholder="'. __('Select a field','um-profile-completeness'). '">';
		
		foreach( $fields as $key => $arr) {
			
			$output['res'] .= '<option value="'.$key.'">';
			if ( isset( $arr['title'] ) ) {
				$output['res'] .= $arr['title'];
			} else {
				$output['res'] .= '';
			}
			
			$output['res'] .= '</option>';
		}
		
		$output['res'] .= '</select></p>';
		
		$output['res'] .= '<p><label>' . __('How much (%) this field should attribute to profile completeness?','um-profile-completeness') . '</label><input type="text" name="progress_value" id="progress_value" value="" placeholder="'. __('Completeness value (%)','um-profile-completeness') .'" /></p>';
		
		$output['res'] .= '<p><a href="#" class="profilec-save button-primary">' . __('Save','um-profile-completeness') . '</a> <a href="#" class="profilec-cancel button">' . __('Cancel','um-profile-completeness') . '</a><span class="spinner" style="display:none;"></span></p>';
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
		
	}