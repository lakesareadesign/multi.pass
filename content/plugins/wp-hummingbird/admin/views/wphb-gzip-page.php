<section class="row sub-header">
	<div class="wphb-block-section">
		<p><?php _e( "Gzip compresses your HTML, JavaScript, and Style Sheets before sending them over to the browser. This drastically reduces transfer time since the files are much smaller.", 'wphb' ); ?></p>
	</div>
</section><!-- end sub-header -->

<div class="row">
	<div class="col-half"><?php $this->do_meta_boxes( 'box-gzip-left' ); ?></div>
	<div class="col-half"><?php $this->do_meta_boxes( 'box-gzip-right' ); ?></div>
</div>

<script>
	jQuery(document).ready( function() {
		if ( window.WPHB_Admin ) {
			window.WPHB_Admin.getModule( 'gzip' );
		}
	});

</script>