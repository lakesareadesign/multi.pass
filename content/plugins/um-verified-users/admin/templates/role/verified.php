<div class="um-admin-metabox">

	<div class="">

		<p>
			
			<label><?php _e('Users with this role will automatically have a verified account','um-verified'); ?></label>
			
			<span><?php $this->ui_on_off( '_um_verified_by_role', 0 ); ?></span>
		
		</p><div class="um-admin-clear"></div>
		
		<p>
			
			<label><?php _e('Prevent users with this role from requesting verification?','um-verified'); ?></label>
			
			<span><?php $this->ui_on_off( '_um_verified_req_disallowed', 0 ); ?></span>
		
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>