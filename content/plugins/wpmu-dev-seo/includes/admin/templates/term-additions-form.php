
<h2><?php _e( 'SmartCrawl Settings ' , 'wds'); ?></h2>
<table class="form-table">

	<?php

	$this->form_row( 'wds_title', __( 'SEO Title' , 'wds'), __( 'The SEO title is used on the archive page for this term.' , 'wds'), $tax_meta );
	$this->form_row( 'wds_desc', __( 'SEO Description' , 'wds'), __( 'The SEO description is used for the meta description on the archive page for this term.' , 'wds'), $tax_meta );
	$this->form_row( 'wds_canonical', __( 'Canonical' , 'wds'), __( 'The canonical link is shown on the archive page for this term.' , 'wds'), $tax_meta );

	if ( $global_noindex ) $this->form_row( 'wds_override_noindex', sprintf( __( 'Index this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' );
	else $this->form_row('wds_noindex', sprintf( __( 'Noindex this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' );

	if ( $global_nofollow ) $this->form_row( 'wds_override_nofollow', sprintf( __('Follow this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' );
	else $this->form_row( 'wds_nofollow', sprintf( __( 'Nofollow this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' );

	?>

</table>