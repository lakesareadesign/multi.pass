<div class="um-admin-metabox">

	<?php $list_id = get_post_meta( get_the_ID(), '_um_list', true );
	
		$merged = get_post_meta( get_the_ID(), '_um_merge', true );

		$merge_vars = $um_mailchimp->api->get_vars( $list_id );

		foreach($ultimatemember->builtin->all_user_fields() as $key => $arr) {
		
		if ( isset( $arr['title'] ) ) { ?>
	
			<p>
				<label class="um-admin-half"><?php echo $arr['title']; ?></label>
				<span class="um-admin-half">
					
					<select name="_um_merge[<?php echo $key; ?>]" id="_um_merge" class="umaf-selectjs" style="width: 300px">
						
						<option value="0"><?php _e('Ignore this field','um-mailchimp'); ?></option>

						<?php foreach( $merge_vars as $k => $var ) { ?>
							<option value="<?php echo $var['tag']; ?>" <?php if ( $merged && isset($merged[$key]) && $merged[$key] == $var['tag'] ) echo "selected"; ?>><?php echo $var['name']; ?></option>
						<?php } ?>
						
					</select>

				</span>
			</p><div class="um-admin-clear"></div>

	<?php
	
		}
	}
	
	?>	

</div>