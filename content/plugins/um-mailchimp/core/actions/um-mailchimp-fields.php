<?php

	/***
	***	@modal field settings
	***/
	add_action('um_admin_field_edit_hook_mailchimp_list', 'um_admin_field_edit_hook_mailchimp_list');
	function um_admin_field_edit_hook_mailchimp_list( $val ) {
		
		global $um_mailchimp;
		
		$metabox = new UM_Admin_Metabox();
		$lists = $um_mailchimp->api->has_lists( true );
		 
		if ( !$lists ) return;
		
		?>
		
			<p><label for="_mailchimp_list"><?php _e('Select a List','um-mailchimp'); ?> <?php $metabox->tooltip( __('You can set up lists or integrations in Ultimate Member > MailChimp','ultimatemember') ); ?></label>
				<select name="_mailchimp_list" id="_mailchimp_list" class="umaf-selectjs" style="width: 100%">
					
					<?php foreach( $lists as $post_id ) { $list = $um_mailchimp->api->fetch_list( $post_id ); ?>
					<option value="<?php echo $post_id; ?>" <?php selected( $post_id, $val ); ?>><?php echo $list['name']; ?></option>
					<?php } ?>
					
				</select>
			</p>

		<?php
		
	}