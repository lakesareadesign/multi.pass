<?php

	/***
	***	@custom notice
	***/
	add_filter('um_custom_success_message_handler', 'um_woocommerce_custom_notice', 10, 2 );
	function um_woocommerce_custom_notice( $msg, $err_t ) {
		
		if ( $err_t == 'edit-billing' ) {
			$msg = __('Your billing address is updated.','um-woocommerce');
		}
		
		if ( $err_t == 'edit-shipping' ) {
			$msg = __('Your shipping address is updated.','um-woocommerce');
		}

		return $msg;
	}
	
	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_woocommerce_billing_tab', 100 );
	function um_woocommerce_billing_tab( $tabs ) {

		if ( um_user('woo_account_billing') ) {
			$tabs[210]['billing']['icon'] = 'um-faicon-credit-card';
			$tabs[210]['billing']['title'] = __('Billing Address','um-woocommerce');
			$tabs[210]['billing']['custom'] = true;
		}
		
		return $tabs;
	}
	
	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_woocommerce_shipping_tab', 100 );
	function um_woocommerce_shipping_tab( $tabs ) {

		if ( um_user('woo_account_shipping') ) {
			$tabs[220]['shipping']['icon'] = 'um-faicon-truck';
			$tabs[220]['shipping']['title'] = __('Shipping Address','um-woocommerce');
			$tabs[220]['shipping']['custom'] = true;
		}
		
		return $tabs;
	}
	
	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_woocommerce_orders_tab', 100 );
	function um_woocommerce_orders_tab( $tabs ) {

		if ( um_user('woo_account_orders') ) {
			$tabs[230]['orders']['icon'] = 'um-faicon-shopping-cart';
			$tabs[230]['orders']['title'] = __('My Orders','um-woocommerce');
			$tabs[230]['orders']['custom'] = true;
		}
		
		return $tabs;
	}
	
	/***
	***	@display tab
	***/
	add_action('um_account_tab__billing', 'um_account_tab__billing');
	function um_account_tab__billing( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('billing');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output; ?>
		
		<?php do_action('um_after_account_billing'); ?>

		<div class="um-col-alt um-col-alt-b">
			<div class="um-left"><input class="um-button" name="save_address" value="Save Address" type="submit"></div>
			<?php do_action('um_after_account_billing_button'); ?>
			<div class="um-clear"></div>
		</div>
		
		<?php
		
		}
	}
	
	/***
	***	@display tab
	***/
	add_action('um_account_tab__shipping', 'um_account_tab__shipping');
	function um_account_tab__shipping( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('shipping');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output; ?>
		
		<?php do_action('um_after_account_shipping'); ?>

		<div class="um-col-alt um-col-alt-b">
			<div class="um-left"><input class="um-button" name="save_address" value="Save Address" type="submit"></div>
			<?php do_action('um_after_account_shipping_button'); ?>
			<div class="um-clear"></div>
		</div>
		
		<?php
		
		}
	}

	/***
	***	@display tab
	***/
	add_action('um_account_tab__orders', 'um_account_tab__orders');
	function um_account_tab__orders( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('orders');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output;
		
		do_action('um_after_account_orders');
		
		}
	}
	
	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_orders', 'um_account_content_hook_orders');
	function um_account_content_hook_orders( $output ){
		global $ultimatemember, $um_woocommerce;

		ob_start();
		
		echo '<div class="um-woo-form um-woo-orders">';
		
		$customer_orders = get_posts( array(
			'numberposts' => 10,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() )
		) );
		
		$url = $ultimatemember->account->tab_link( 'orders' );

		if ( $customer_orders ) { ?>

		<table class="shop_table shop_table_responsive my_account_orders">

			<thead>
				<tr>
					<th class="order-date"><span class="nobr"><?php _e( 'Date', 'woocommerce' ); ?></span></th>
					<th class="order-status"><span class="nobr"><?php _e( 'Status', 'woocommerce' ); ?></span></th>
					<th class="order-total"><span class="nobr"><?php _e( 'Total', 'woocommerce' ); ?></span></th>
					<th class="order-actions">&nbsp;</th>
				</tr>
			</thead>

			<tbody><?php
				foreach ( $customer_orders as $customer_order ) {
					$order      = new WC_Order();
					$order->populate( $customer_order );
					$item_count = $order->get_item_count();

					?><tr class="order" data-order_id="<?php echo $order->get_order_number(); ?>">
						<td class="order-date" data-title="<?php _e( 'Date', 'woocommerce' ); ?>">
							<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title=""><?php echo date_i18n( 'j M y', strtotime( $order->order_date ) ); ?></time>
						</td>
						<td class="order-status" data-title="<?php _e( 'Status', 'woocommerce' ); ?>" style="text-align:left; white-space:nowrap;">
							<span class="um-woo-status <?php echo $order->get_status(); ?>"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span>
						</td>
						<td class="order-total" data-title="<?php _e( 'Total', 'woocommerce' ); ?>"><?php echo $order->get_formatted_order_total() ?></td>
						<td class="order-detail">
							<?php echo '<a href="' . $url . '#!/' . $order->get_order_number() . '" class="um-woo-view-order um-tip-n" title="'.__('View order','um-woocommerce').'"><i class="um-icon-eye"></i></a>'; ?>
						</td>
					</tr><?php
				}
			?></tbody>

		</table>

		<?php
		
		}
	
		echo '</div>';
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}
	
	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_billing', 'um_account_content_hook_billing');
	function um_account_content_hook_billing( $output ){
		global $um_woocommerce;

		ob_start();
		
		echo '<div class="um-woo-form um-woo-billing">';
		$um_woocommerce->api->edit_address('billing');
		echo '</div>';
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}
	
	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_shipping', 'um_account_content_hook_shipping');
	function um_account_content_hook_shipping( $output ){
		global $um_woocommerce;

		ob_start();
		
		echo '<div class="um-woo-form um-woo-shipping">';
		$um_woocommerce->api->edit_address('shipping');
		echo '</div>';
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}