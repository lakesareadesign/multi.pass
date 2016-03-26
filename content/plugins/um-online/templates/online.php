<div class="um-online" data-max="<?php echo $max; ?>">
	
	<?php foreach( $online as $user => $last_seen ) { $this->setup( $user ); 
		if ( $role != 'all' && $user['role'] != $role ) continue;
		if ( empty($user['name']) ) continue;
	?>
	
	<div class="um-online-user">
		<div class="um-online-pic"><a href="<?php echo $user['url']; ?>" class="um-tip-n" title="<?php echo $user['name']; ?>"><?php echo get_avatar( $user['ID'], 40 ); ?></a></div>
	</div>

	<?php } ?>

	<div class="um-clear"></div>
	
</div>