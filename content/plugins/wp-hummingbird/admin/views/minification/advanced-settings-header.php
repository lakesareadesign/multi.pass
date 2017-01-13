<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( ! $is_member ): ?>
	<div class="buttons buttons-large">
		<span class="pro-callout"><a href="<?php echo wphb_update_membership_link(); ?>"><?php _e( 'Try Pro Features free', 'wphb' ); ?></a></span>
	</div>
<?php endif; ?>