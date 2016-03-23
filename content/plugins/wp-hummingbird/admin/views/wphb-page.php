<div class="row">
	<?php $this->do_meta_boxes( 'main' ); ?>
</div>

<div class="row">
	<div class="col-half"><?php $this->do_meta_boxes( 'box-dashboard-left' ); ?></div>
	<div class="col-half"><?php $this->do_meta_boxes( 'box-dashboard-right' ); ?></div>
</div>

<script>
	jQuery( document).ready( function () {
		WPHB_Admin.getModule( 'dashboard' );
	});
</script>