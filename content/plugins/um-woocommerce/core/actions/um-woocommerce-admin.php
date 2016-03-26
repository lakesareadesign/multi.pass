<?php
	
	/***
	***	@create role options
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_woocommerce_add_role_metabox');
	function um_woocommerce_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-woocommerce{" . um_woocommerce_path . "}", __('WooCommerce','um-woocommerce'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}
	
	/***
	***	@add options to WooCommerce product page
	***/
	add_action('um_admin_before_access_settings', 'um_woocommerce_add_role_options', 50, 1);
	function um_woocommerce_add_role_options( $metabox ) {
		global $ultimatemember;
		if ( get_post_type() == 'product' ) {
			
			$roles = array('' => __('None','um-woocommerce') ) + $ultimatemember->query->get_roles( );
			
			$saved_r = (string)get_post_meta( get_the_ID(), '_um_woo_product_role', true );
			$saved_r = ( $saved_r ) ? $saved_r : '';
			
			?>
			
			<h4><?php _e('When this product is bought move user to this role:','um-woocommerce'); ?></h4>
				
			<p>
				<select name="_um_woo_product_role" id="_um_woo_product_role">
				<?php foreach ( $roles as $k => $role ) { ?>
				<option value="<?php echo $k; ?>" <?php selected( $k, $saved_r ); ?>><?php echo $role; ?></option>
				<?php } ?>
				</select>
			</p>
	
			<?php
		}
	}