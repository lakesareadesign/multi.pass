<?php

	/***
	***	@save extra fields
	***/
	add_action('um_post_registration_save', 'um_social_login_save_extra_fields', 9, 2);
	function um_social_login_save_extra_fields( $user_id, $args ) {
		
		foreach( $_POST as $key => $value ) {
			
			if ( strstr( $key, '_uid_') ) {
				update_user_meta( $user_id, $key, $value );
			}
			
			if ( strstr( $key, '_save_') ) {
				$key = str_replace( '_save_', '', $key );
				update_user_meta( $user_id, $key, $value );
			}
			
		}
	}

	/***
	***	@modal field settings
	***/
	add_action('um_before_register_fields', 'um_social_login_add_buttons');
	add_action('um_before_login_fields', 'um_social_login_add_buttons');
	function um_social_login_add_buttons( $args ) {
		global $um_social_login;
		
		if ( isset( $um_social_login->profile ) ) return;
		
		$show_social = ( isset( $args['show_social'] ) ) ? $args['show_social'] : '-1';
		
		if ( !$show_social ) return;
		
		if ( $args['mode'] == 'register' && !um_get_option('register_show_social') ) return;
		
		if ( $args['mode'] == 'login' && !um_get_option('login_show_social') ) return;
		
		$networks = $um_social_login->networks;
		$networks = $um_social_login->available_networks();
		
		if ( !$networks ) return;

		$o_networks = $networks;
		
		?>
		
		<div class="um-field">
			
			<div class="um-col-alt">
		
				<?php $i = 0; foreach( $o_networks as $id => $arr ) {
					$i++;
					
					$class = 'um-left';
					
					if ( $i % 2 == 0 ) {
						$class = 'um-right';
					}

					?>
				
				<div class="<?php echo $class; ?> um-half"><a href="<?php echo $um_social_login->login_url( $id ); ?>" title="<?php echo $arr['button']; ?>" class="um-button um-alt um-button-social um-button-<?php echo $id; ?>"><i class="<?php echo $arr['icon']; ?>"></i><?php echo $arr['button']; ?></a></div>

				<?php 
				
					if ( $i % 2 == 0 && count($o_networks) != $i ) {
						echo '<div class="um-clear"></div></div><div class="um-col-alt um-col-alt-s">';
					}
				
				}
				
				?>
				
				<div class="um-clear"></div>
			
			</div>
			
		</div>
		
		<style type="text/css">
		
			.um-<?php echo $args['form_id']; ?>.um a.um-button.um-button-social {
				padding-left: 5px !important;
				padding-right: 5px !important;
			}
			
			<?php foreach( $o_networks as $id => $arr ) { ?>
			.um-<?php echo $args['form_id']; ?>.um a.um-button.um-button-<?php echo $id; ?> {background-color: <?php echo $arr['bg']; ?>!important}
			.um-<?php echo $args['form_id']; ?>.um a.um-button.um-button-<?php echo $id; ?>:hover {background-color: <?php echo $arr['bg_hover']; ?>!important}
			.um-<?php echo $args['form_id']; ?>.um a.um-button.um-button-<?php echo $id; ?> {color: <?php echo $arr['color']; ?>!important}
			<?php } ?>

		</style>
	
		<?php

	}