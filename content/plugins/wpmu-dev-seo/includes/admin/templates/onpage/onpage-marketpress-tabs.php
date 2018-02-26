<?php if ( class_exists( 'MarketPress_MS' ) && ( is_network_admin() || is_main_site() ) ) { ?>
	<section class="tab">
		<input type="radio" name="wds-admin-active-tab" id="tab-marketpress" value="tab-marketpress" <?php checked( $active_tab, 'tab-marketpress' ); ?>>
		<label for="tab-marketpress"><?php esc_html_e( 'MarketPress', 'wds' ); ?></label>
		<div class="content wds-content-tabs">
			<h2 class="tab-title"><?php esc_html_e( 'MarketPress', 'wds' ); ?></h2>

			<div class="wds-content-tabs-inner">

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label">
							<label for="title-mp_marketplace-base" class="wds-label"><?php esc_html_e( 'Marketplace Base Title' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<input id='title-mp_marketplace-base' name='<?php echo esc_attr( $_view['option_name'] ); ?>[title-mp_marketplace-base]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['title-mp_marketplace-base'] ); ?>'>
						</div>
					</div>
				</div>

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label label-long">
							<label for="metadesc-mp_marketplace-base" class="wds-label"><?php _e( 'Marketplace Base<br> Meta Description' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<textarea id='metadesc-mp_marketplace-base' name='<?php echo esc_attr( $_view['option_name'] ); ?>[metadesc-mp_marketplace-base]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-mp_marketplace-base'] ); ?></textarea>
						</div>
					</div>
				</div>

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label label-long">
							<label for="title-mp_marketplace-categories" class="wds-label"><?php _e( 'Marketplace Categories<br> Title' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<input id='title-mp_marketplace-categories' name='<?php echo esc_attr( $_view['option_name'] ); ?>[title-mp_marketplace-categories]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['title-mp_marketplace-categories'] ); ?>'>
						</div>
					</div>
				</div>

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label">
							<label for="metadesc-mp_marketplace-categories" class="wds-label"><?php _e( 'Marketplace Categories<br> Meta Description' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<textarea id='metadesc-mp_marketplace-categories' name='<?php echo esc_attr( $_view['option_name'] ); ?>[metadesc-mp_marketplace-categories]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-mp_marketplace-categories'] ); ?></textarea>
						</div>
					</div>
				</div>

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label label-long">
							<label for="title-mp_marketplace-tags" class="wds-label"><?php _e( 'Marketplace Tags<br> Title' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<input id='title-mp_marketplace-tags' name='<?php echo esc_attr( $_view['option_name'] ); ?>[title-mp_marketplace-tags]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['title-mp_marketplace-tags'] ); ?>'>
						</div>
					</div>
				</div>

				<div class="wds-table-fields-group">
					<div class="wds-table-fields">
						<div class="label">
							<label for="metadesc-mp_marketplace-tags" class="wds-label"><?php _e( 'Marketplace Tags<br> Meta Description' , 'wds' ); ?></label>
						</div>
						<div class="fields wds-allow-macros">
							<textarea id='metadesc-mp_marketplace-tags' name='<?php echo esc_attr( $_view['option_name'] ); ?>[metadesc-mp_marketplace-tags]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-mp_marketplace-tags'] ); ?></textarea>
						</div>
					</div>
				</div>

			</div><!-- end wds-content-tabs-inner -->
			<div class="wds-seamless-footer">
				<input name='submit' type='submit' class='button' value='<?php echo esc_attr( __( 'Save Settings' , 'wds' ) ); ?>'>
			</div>

		</div>
	</section>
<?php } ?>