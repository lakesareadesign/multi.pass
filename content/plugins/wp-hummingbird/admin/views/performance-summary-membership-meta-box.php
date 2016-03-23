<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<div class="content">
			<a id="wphb-upgrade-membership-modal-link" class="hidden" href="#wphb-upgrade-membership-modal" rel="dialog"><?php _e( 'Upgrade Membership', 'wphb') ;?></a>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->

<?php
	$user = wp_get_current_user();
	wphb_membership_modal( sprintf( __( '%s, performance is only available to people with active WPMU DEV memberships. Get access to all of our premium plugins and themes, as well as 24/7 support today. It\'s easy to join and only takes a minute!', 'wphb' ), $user->display_name ) );
?>

<script>
	jQuery( document).ready( function() {
		WPHB_Admin.utils.membershipModal.open();
	});
</script>