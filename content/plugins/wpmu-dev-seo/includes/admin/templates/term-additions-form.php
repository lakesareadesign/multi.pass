
<h2><?php _e( 'SmartCrawl Settings ' , 'wds' ); ?></h2>
<table class="form-table">

	<?php

	$this->form_row( 'wds_title', __( 'SEO Title' , 'wds' ), __( 'The SEO title is used on the archive page for this term.' , 'wds' ), $tax_meta );
	$this->form_row( 'wds_desc', __( 'SEO Description' , 'wds' ), __( 'The SEO description is used for the meta description on the archive page for this term.' , 'wds' ), $tax_meta );
	$this->form_row( 'wds_canonical', __( 'Canonical' , 'wds' ), __( 'The canonical link is shown on the archive page for this term.' , 'wds' ), $tax_meta );

	if ( $global_noindex ) { $this->form_row( 'wds_override_noindex', sprintf( __( 'Index this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' ); } else { $this->form_row( 'wds_noindex', sprintf( __( 'Noindex this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' ); }

	if ( $global_nofollow ) { $this->form_row( 'wds_override_nofollow', sprintf( __( 'Follow this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' ); } else { $this->form_row( 'wds_nofollow', sprintf( __( 'Nofollow this %s' , 'wds' ), strtolower( $taxonomy_labels->singular_name ) ), '', $tax_meta, 'checkbox' ); }

	?>

<?php
	$options = Smartcrawl_Settings::get_options();
?>

<?php if ( ! empty( $options['og-enable'] ) ) { ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for=""><?php esc_html_e( 'OpenGraph', 'wds' ); ?></label></th>
		<td>
<div class="wpmud">
<?php
	$og = ! empty( $tax_meta['opengraph'] ) ? $tax_meta['opengraph'] : false;
if ( ! is_array( $og ) ) {
	$og = array();
}

	$og = wp_parse_args($og, array(
		'title'       => false,
		'description' => false,
		'images'      => false,
		'disabled'    => false,
	));

	if ( ! class_exists( 'Smartcrawl_OpenGraph_Printer' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/tools/class_wds_opengraph_printer.php' ); }
	$ogp = Smartcrawl_OpenGraph_Printer::Get();

	$default_title = $ogp->get_generic_og_tag_value( 'og-title', $taxonomy );
	$default_title = ! empty( $default_title ) ? $default_title : $term->name;

	$default_metadesc = $ogp->get_generic_og_tag_value( 'og-description', $taxonomy );
	$default_metadesc = ! empty( $default_metadesc ) ? $default_metadesc : $term->name;

	$og_meta_disabled = (bool) smartcrawl_get_array_value( $og, 'disabled' );
?>
			<div class="wds-table-fields">
				<div class="fields">
					<div class="wds-toggleable inverted <?php echo $og_meta_disabled ? 'inactive' : ''; ?>">
							<?php
								$this->_render('toggle-item', array(
									'inverted'   => true,
									'field_name' => 'wds-opengraph[disabled]',
									'checked'    => checked( $og_meta_disabled, true, false ),
									'item_label' => esc_html__( 'Enable OpenGraph for this term', 'wds' ),
								));
							?>
							<div class="wds-toggleable-inside wds-toggleable-inside-box wds-table-fields-group wds-opengraph-meta">

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-title" class="wds-label"><?php esc_html_e( 'Title', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<input type="text"
											   id="og-title"
											   name="wds-opengraph[title]"
											   placeholder="<?php echo $og['title'] ? '' : esc_attr( smartcrawl_replace_vars( $default_title, (array) $term ) ); ?>"
											   value="<?php echo esc_attr( $og['title'] ); ?>"/>
									</div>
								</div>

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-description" class="wds-label"><?php esc_html_e( 'Description', 'wds' ); ?></label>
									</div>
									<div class="fields">
										<textarea name="wds-opengraph[description]"
												  placeholder="<?php echo $og['description'] ? '' : esc_attr( smartcrawl_replace_vars( $default_metadesc, (array) $term ) ); ?>"
												  id="og-description"><?php echo esc_textarea( $og['description'] ); ?></textarea>
									</div>
								</div>

								<div class="wds-table-fields wds-table-fields-stacked">
									<div class="label">
										<label for="og-images" class="wds-label"><?php esc_html_e( 'Featured Images', 'wds' ); ?></label>
									</div>
									<div class="fields og-images"
										 data-name="wds-opengraph[images]">
										<div class="add-action-wrapper item">
											<a href="#add" title="<?php esc_attr_e( 'Add image', 'wds' ); ?>">
												<i class="wds-icon-plus"></i>
											</a>
										</div>
										<?php if ( ! empty( $og['images'] ) && is_array( $og['images'] ) ) :  ?>
											<?php foreach ( $og['images'] as $img ) :  ?>
												<input type="text" class="widefat"
													   name="wds-opengraph[images][]"
													   value="<?php echo esc_attr( $img ); ?>" />
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								</div>

								<p class="wds-label-description"><?php esc_html_e( 'Each of these images will be available to use as the featured image when the term page is shared.', 'wds' ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
</div>
		</td>
	<tr>
<?php } ?>


<?php if ( ! empty( $options['twitter-card-enable'] ) ) { ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for=""><?php esc_html_e( 'Twitter', 'wds' ); ?></label></th>
		<td>
<div class="wpmud">
<?php
	$twitter = ! empty( $tax_meta['twitter'] ) ? $tax_meta['twitter'] : false;
if ( ! is_array( $twitter ) ) {
	$twitter = array();
}

	$twitter = wp_parse_args($twitter, array(
		'title'       => false,
		'description' => false,
		'disabled'    => false,
	));

	$twitter_meta_disabled = (bool) smartcrawl_get_array_value( $twitter, 'disabled' );
?>
			<div class="wds-table-fields">
				<div class="fields">
					<div class="wds-toggleable inverted <?php echo $twitter_meta_disabled ? 'inactive' : ''; ?>">
						<?php
							$this->_render('toggle-item', array(
								'inverted'   => true,
								'field_name' => 'wds-twitter[disabled]',
								'checked'    => checked( $twitter_meta_disabled, true, false ),
								'item_label' => esc_html__( 'Enable Twitter Cards for this term', 'wds' ),
							));
						?>
						<div class="wds-toggleable-inside wds-toggleable-inside-box wds-table-fields-group wds-twitter-meta">
							<div class="wds-table-fields wds-table-fields-stacked">
								<div class="label">
									<label for="twitter-title" class="wds-label"><?php esc_html_e( 'Title', 'wds' ); ?></label>
								</div>
								<div class="fields">
									<input type="text"
										   id="twitter-title"
										   name="wds-twitter[title]"
										   placeholder="<?php echo $twitter['title'] ? '' : esc_attr( smartcrawl_replace_vars( $term->name ) ); ?>"
										   value="<?php echo esc_attr( $twitter['title'] ); ?>"/>
								</div>
							</div>

							<div class="wds-table-fields wds-table-fields-stacked">
								<div class="label">
									<label for="twitter-description" class="wds-label"><?php esc_html_e( 'Description', 'wds' ); ?></label>
								</div>
								<div class="fields">
									<textarea name="wds-twitter[description]"
											  placeholder="<?php echo $twitter['description'] ? '' : esc_attr( smartcrawl_replace_vars( $term->name ) ); ?>"
											  id="twitter-description"><?php echo esc_textarea( $twitter['description'] ); ?></textarea>
								</div>
							</div>

                            <div class="wds-table-fields wds-table-fields-stacked">
                                <div class="label">
                                    <label for="twitter-images" class="wds-label"><?php esc_html_e( 'Featured Image', 'wds' ); ?></label>
                                </div>
                                <div class="fields og-images"
                                     data-singular="true"
                                     data-name="wds-twitter[images]">
                                    <div class="add-action-wrapper item">
                                        <a href="#add" title="<?php esc_attr_e( 'Add image', 'wds' ); ?>">
                                            <i class="wds-icon-plus"></i>
                                        </a>
                                    </div>
	                                <?php if (!empty($twitter['images']) && is_array($twitter['images'])) : ?>
		                                <?php foreach ($twitter['images'] as $twitter_image) : ?>
                                            <input type="text" class="widefat"
                                                   name="wds-twitter[images][]"
                                                   value="<?php echo esc_attr($twitter_image); ?>"/>
		                                <?php endforeach; ?>
	                                <?php endif; ?>
                                </div>
                            </div>

                            <p class="wds-label-description"><?php esc_html_e( 'This image will be available to use as the featured image when the term page is shared.', 'wds' ); ?></p>
						</div>
				</div> <!-- fields -->
			</div> <!-- wds-table-fields -->
</div>
		</td>
	</tr>
<?php } ?>

</table>