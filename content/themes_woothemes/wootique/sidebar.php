<?php 
	// Don't display sidebar if full width
	if ( wootique_get_woo_option( 'woo_layout' ) != "layout-full" ) :
?>	
<div id="sidebar" class="col-right">

	<?php if ( woo_active_sidebar( 'primary' ) ) : ?>
    <div class="primary">
		<?php woo_sidebar( 'primary' ); ?>		           
	</div>        
	<?php endif; ?>    
	
</div><!-- /#sidebar -->

<?php endif; ?>