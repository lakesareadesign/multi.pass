<section class="row sub-header">
	<div class="wphb-block-section">
		<p><?php _e( 'Caching stores temporary data on your visitors devices so that they don\'t have to download assets twice if they don\'t have to. This results in a much faster second time around page load speed. Enabling caching will set the recommended expiry times for your content.', 'wphb' ); ?></p>
	</div>
</section><!-- end sub-header -->

<div class="row">
	<?php $this->do_meta_boxes( 'box-caching-welcome' ); ?>
</div>

<div class="row">
	<div class="col-half"><?php $this->do_meta_boxes( 'box-caching-left' ); ?></div>
	<div class="col-half"><?php $this->do_meta_boxes( 'box-caching-right' ); ?></div>
</div>

<script>
	jQuery(document).ready( function() {
		if ( window.WPHB_Admin ) {
			window.WPHB_Admin.getModule( 'caching' );
		}
	});

</script>