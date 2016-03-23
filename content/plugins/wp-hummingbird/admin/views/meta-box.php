<section id="wphb-box-<?php echo $id; ?>" class="box-<?php echo $id; ?> <?php echo $args['box_class']; ?>">

	<?php if ( is_array( $callback_header ) && method_exists( $callback_header[0], $callback_header[1] ) ): ?>
		<div class="<?php echo $args['box_header_class']; ?>">
			<?php call_user_func( $callback_header ); ?>
		</div><!-- end box-title -->
	<?php elseif ( $this->view_exists( $id . '-meta-box-header' ) ): ?>
		<div class="<?php echo $args['box_header_class']; ?>">
			<?php $this->view( $id . '-meta-box-header', array( 'title' => $title ) ); ?>
		</div><!-- end box-title -->
	<?php else: ?>
		<div class="<?php echo $args['box_header_class']; ?>">
			<h3><?php echo esc_html( $title ); ?></h3>
		</div><!-- end box-title -->
	<?php endif; ?>

	<div class="<?php echo $args['box_content_class']; ?>">
		<?php if ( is_array( $callback ) && method_exists( $callback[0], $callback[1] ) ): ?>
			<?php call_user_func( $callback ); ?>
		<?php else: ?>
			<?php $this->view( $id . '-meta-box' ); ?>
		<?php endif; ?>
	</div><!-- end box-content -->

	<?php if ( is_array( $callback_footer ) && method_exists( $callback_footer[0], $callback_footer[1] ) ): ?>
		<div class="<?php echo $args['box_footer_class']; ?>">
			<?php call_user_func( $callback_footer ); ?>
		</div><!-- end box-footer -->
	<?php elseif ( $this->view_exists( $id . '-meta-box-footer' ) ): ?>
		<div class="<?php echo $args['box_footer_class']; ?>">
			<?php $this->view( $id . '-meta-box-footer' ); ?>
		</div><!-- end box-footer -->
	<?php endif; ?>

</section><!-- end box-<?php echo $id; ?> -->