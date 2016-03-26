<?php

	/***
	***	@view order in ajax mode
	***/
	add_action('wp_ajax_nopriv_um_woocommerce_get_order', 'um_woocommerce_get_order');
	add_action('wp_ajax_um_woocommerce_get_order', 'um_woocommerce_get_order');
	function um_woocommerce_get_order(){
		global $ultimatemember;
		
		if ( !isset( $_POST['order_id'] ) || !is_user_logged_in() ) die(0);

		$is_customer = get_post_meta( $_POST['order_id'], '_customer_user', true );
		if ( $is_customer != get_current_user_id() ) die(0);

		ob_start();
		
		$order_id = $_POST['order_id'];
		$customer_order = get_post( $_POST['order_id'] );
		$order      = wc_get_order( $_POST['order_id'] );
		$order->populate( $customer_order );
		
		um_fetch_user( get_current_user_id() );
		
		?>
		
		<div class="um-woo-order-head um-popup-header">
		
			<div class="um-woo-customer">
				<?php echo get_avatar( get_current_user_id(), 34 ); ?>
				<span><?php echo um_user('display_name'); ?></span>
			</div>
			
			<div class="um-woo-orderid">
				<?php printf(__('Order# %s','um-woocommerce'), $order_id ); ?>
				<a href="#" class="um-woo-order-hide"><i class="um-icon-close"></i></a>
			</div>
			
			<div class="um-clear"></div>
		
		</div>
		
		<div class="um-woo-order-body um-popup-autogrow2">
		
		<?php wc_print_notices(); ?>

		<p class="order-info"><?php printf( __( 'Order #<mark class="order-number">%s</mark> was placed on <mark class="order-date">%s</mark> and is currently <mark class="order-status">%s</mark>.', 'woocommerce' ), $order->get_order_number(), date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ), wc_get_order_status_name( $order->get_status() ) ); ?></p>

		<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
			
			<h2><?php _e( 'Order Updates', 'woocommerce' ); ?></h2>
			<ol class="commentlist notes">
				<?php foreach ( $notes as $note ) : ?>
				<li class="comment note">
					<div class="comment_container">
						<div class="comment-text">
							<p class="meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
							<div class="description">
								<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
				</li>
				<?php endforeach; ?>
			</ol>
		
		<?php
		endif;

		do_action( 'woocommerce_view_order', $order_id );
		
		?>
		
		</div>
		
		<div class="um-popup-footer" style="height:30px"></div>
		
		<?php

		$output = ob_get_contents();
		ob_end_clean();
		die($output);
	}