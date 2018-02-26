<?php
	$tabs = empty( $tabs ) ? array() : $tabs;
	$first_tab = true;
?>
<div class="wds-horizontal-tab-nav">
	<?php foreach ( $tabs as $tab_id => $tab_name ) :  ?>

		<div class="wds-nav-item <?php echo $first_tab ? 'active' : ''; ?>">
			<label for="<?php echo esc_attr( $tab_id ); ?>">
				<?php echo wp_kses( $tab_name, 'post' ); ?>
			</label>
		</div>

		<?php $first_tab = false; ?>
	<?php endforeach; ?>
</div>