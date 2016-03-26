<?php global $um_bbpress; ?>

<div class="um-admin-metabox">

	<div class="">

		<p>
			<label class="um-admin-half"><?php _e('Can transfer points to other members?','um-mycred'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_transfer_mycred', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can not receive points from other members?','um-mycred'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_cannot_receive_mycred', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>