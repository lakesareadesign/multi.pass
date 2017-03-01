<div id="container" class="wrap wrap-wds wds-page wds-redirections-settings">

	<dialog class="dev-overlay wds-modal wds-redirect" id="wds-new-redirect" title="<?php echo esc_attr(__('Add new redirection', 'wds')); ?>">
		<div class="box-content modal">
			<p class="group wds-group">
				<label for="" class="wds-label"><?php esc_html_e('Enter old URL', 'wds'); ?></label>
				<input type="url" name="source" value="" class="wds-field">
			</p>
			<p class="group wds-group">
				<label for="" class="wds-label"><?php esc_html_e('Enter re-direct URL', 'wds'); ?></label>
				<input type="url" name="redirect" value="" class="wds-field">
			</p>
		</div>

		<div class="box-footer buttons modal">
			<?php wp_nonce_field('wds-redirect', 'wds-redirect'); ?>
			<button type="button" class="button button-cta-alt wds-submit-redirect"><?php echo esc_html_e('Save', 'wds'); ?></button>
		</div>

	</dialog>

	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<h1><?php esc_html_e('Redirections' , 'wds'); ?></h1>
	</section><!-- end header -->

	<div class="row sub-header">
		<div class="wds-block-section">
			<p class="wds-page-desc"><?php esc_html_e('Here you will find a list of active redirections on your site.' , 'wds'); ?></p>
		</div>
	</div><!-- end sub-header -->

	<form action='<?php echo $_view['action_url']; ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="row">

			<div class="wds-redirections-list">
				<section class="box-settings-redirections-list dev-box">
					<div class="box-title">
						<h3><?php esc_html_e( 'Active Redirections', 'wds' ); ?></h3>
						<div class="buttons left">
							<button type="button" class="button button-light wds-add_new">
								<?php esc_html_e('Add new', 'wds'); ?>
							</button>
						</div>
					</div>
					<div class="box-content no-padding">
					<?php if ($redirections) { ?>
						<div class="wds-redirections">
							<table class="wds-table wds-redirections-table">
								<thead>
									<tr>
										<th class="selector"><input type="checkbox" class="wds-checkbox"></th>
										<th class="source"><?php esc_html_e('Old URL', 'wds'); ?></th>
										<th class="destination"><?php esc_html_e('Redirect URL', 'wds'); ?></th>
										<th class="type"><?php esc_html_e('Type', 'wds'); ?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($redirections as $source => $redirection) { ?>
									<tr>
										<td>
											<input type="checkbox" class="wds-checkbox" name="<?php echo esc_attr($_view['option_name']); ?>[bulk][]" value="<?php echo esc_attr($source); ?>">
										</td>

										<td>
											<div class="wds-redirection_item-source">
												<a href="<?php echo esc_url($source); ?>" class="wds-label link"><?php echo esc_html($source); ?></a>
											</div>
											<div class="wds-redirection_item-separator"><i class="wdv-icon wdv-icon-fw wdv-icon-arrow-right"></i></div>
										</td>

										<td>
											<div class="wds-redirection_item-destination">
												<input id="<?php echo esc_attr($_view['option_name']); ?>" name="<?php echo esc_attr($_view['option_name']); ?>[urls][<?php echo esc_attr($source); ?>]" type="text" class="wds-field" value="<?php echo esc_attr($redirection); ?>">
											</div>
										</td>

										<td>
											<div class="wds-redirection_item-type">
												<select name="<?php echo esc_attr($_view['option_name']); ?>[types][<?php echo esc_attr($source); ?>]">
													<option <?php if (!empty($types[$source]) && 301 == $types[$source]) echo 'selected'; ?> value="301"><?php esc_html_e('Permanent (301)', 'wds'); ?></option>
													<option <?php if (!empty($types[$source]) && 302 == $types[$source]) echo 'selected'; ?> value="302"><?php esc_html_e('Temporary (302)', 'wds'); ?></option>
												</select>
											</div>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } else { ?>
						<p><?php esc_html_e('No active redirections', 'wds'); ?></p>
					<?php } ?>
					<div class="box-footer buttons">
						<div class="select-wrapper">
							<label><?php esc_html_e('Action:', 'wds'); ?></label>
							<div class="wds-redirections-actions">
								<select name="<?php echo esc_attr($_view['option_name']); ?>[bulk_action]">
									<option><?php esc_html_e('No action selected', 'wds'); ?></option>
									<option value="delete"><?php esc_html_e('Delete', 'wds'); ?></option>
									<option value="redirect_301"><?php esc_html_e('Change to 301', 'wds'); ?></option>
									<option value="redirect_302"><?php esc_html_e('Change to 302', 'wds'); ?></option>
								</select>
							</div>
						</div>
						<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Apply Action' , 'wds') ); ?>'>
					</div>
				</div>
				</section><!-- end box-sitemaps-xml-sitemap-settings -->
			</div>
		</div>

		<div class="block-section-footer buttons">
			<input name='submit' type='submit' class='button button-cta-alt' value='<?php echo esc_attr( __( 'Save Settings' , 'wds') ); ?>'>
		</div>

	</form>

</div><!-- end wds-sitemap-settings -->