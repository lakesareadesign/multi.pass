<?php
if ( $is_edit && $module ) {
    $module_content = $module->get_content();
    $email_services = $module_content->email_services;
    $active_email_service = $module_content->active_email_service;
}
?>
<div id="wph-wizard-content-email" class="wpmudev-box-content {{ ( _.isFalse(use_email_collection) ? 'last' : '' ) }}">

	<div class="wpmudev-box-left">

		<h4><strong><?php esc_attr_e( "Email collection module", Opt_In::TEXT_DOMAIN ); ?></strong></h4>

		<label class="wpmudev-helper"><?php esc_attr_e( "Configure if you want to collect emails from visitors who see this Slide-in and how you want those emails to be stored.", Opt_In::TEXT_DOMAIN ); ?></label>

	</div>

	<div class="wpmudev-box-right">

		<div class="wpmudev-switch-labeled">

			<div class="wpmudev-switch">

				<input id="wph-slidein-email_collection" class="toggle-checkbox" type="checkbox" data-attribute="use_email_collection" {{_.checked(_.isTrue(use_email_collection), true)}}>

				<label class="wpmudev-switch-design" for="wph-slidein-email_collection" aria-hidden="true"></label>

			</div>

			<label class="wpmudev-switch-label" for="wph-slidein-email_collection"><?php esc_attr_e( "Add email collection to this Slide-in", Opt_In::TEXT_DOMAIN ); ?></label>

		</div>

        <table id="wph-wizard-content-email-options" cellspacing="0" cellpadding="0" class="wpmudev-table {{ ( _.isFalse(use_email_collection) ) ? 'wpmudev-hidden_table' : 'wpmudev-show_table' }}">

			<thead>

				<tr><th><?php esc_attr_e( "Email Collection Service", Opt_In::TEXT_DOMAIN ); ?></th></tr>

			</thead>

			<tbody>

				<tr><td>

                    <table cellspacing="0" cellpadding="0" class="wpmudev-table_inner">

                        <tbody>

                            <tr class="{{ ( _.isFalse(save_local_list) ) ? 'wpmudev-disabled' : '' }}">

                                <td>

                                    <div class="wpmudev-switch">

                                        <input id="wph-slidein-list_hustle" class="toggle-checkbox" type="checkbox" data-attribute="save_local_list" {{_.checked(_.isTrue(save_local_list), true)}} >

                                        <label class="wpmudev-switch-design" for="wph-slidein-list_hustle" aria-hidden="true"></label>

                                    </div>

                                </td>

                                <td><?php $this->render( "general/icons/icon-hustle", array() ); ?></td>

                                <td>
                                    <span class="wpmudev-table_name"><?php esc_attr_e( "Local Hustle List", Opt_In::TEXT_DOMAIN ); ?></span>
                                    <span class="wpmudev-table_desc"><?php esc_attr_e( "Will save email addresses to an exportable CSV list", Opt_In::TEXT_DOMAIN ); ?></span>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </td></tr><?php // Local Hustle List ?>

				<?php
				$active_service = "mailchimp";
				if ( $is_edit && $module && $email_services && is_array( $email_services ) ) :
					$total_email_services = count( $email_services );
					$total_email_services_count = 0;
					foreach ( $email_services as $service_key => $email_service ) :

						if ( $total_email_services > 1 ) {
							if ( $active_email_service ) {
								if ( $active_email_service !== $service_key ) {
									continue;
								}
							} else if ( $total_email_services_count > 0 ) {
								continue;
							}

						}
						$total_email_services_count++;

						$api_key = ( isset( $email_service['api_key'] ) ) ? $email_service['api_key'] : '';
						$service_name = ( isset( $providers[$service_key] ) && isset( $providers[$service_key]['name'] ) )
							? $providers[$service_key]['name']
							: '' ;
						$active_service = $service_key;
						?>

						<tr class="wph-wizard-content-email-providers"><td>

							<table cellspacing="0" cellpadding="0" class="wpmudev-table_inner">

								<tbody>

									<tr class="wpmudev-disabled">

										<td>

											<div class="wpmudev-switch">

												<input id="wph-embedded-list_<?php echo esc_attr( $service_key ); ?>" class="toggle-checkbox wph-email-service-toggle" type="checkbox" data-attribute="<?php echo esc_attr( $service_key ); ?>_service_provider" <?php checked( $active_email_service, $service_key ); ?> >

												<label class="wpmudev-switch-design" for="wph-embedded-list_<?php echo esc_attr( $service_key ); ?>" aria-hidden="true"></label>

											</div>

										</td>

										<td class="wph-email-providers-icon">
										<?php if ( 'mad_mimi' === $service_key ) : ?>

											<div class="wpmudev-icon wpmudev-i_madmimi"></div>

										<?php else : ?>

											<?php $this->render( "general/icons/icon-" .$service_key , array() ); ?>

										<?php endif; ?>

										</td>

										<td>
											<a data-id="<?php echo esc_attr( $service_key ); ?>" href="#" class="wpmudev-table_name wph-email-service-edit-link" data-nonce="<?php echo esc_attr( wp_create_nonce('change_provider_name') ); ?>" >
												<span class="wpmudev-table_name"><?php echo esc_attr( $service_name ); ?></span>
												<span class="wpmudev-table_desc"><?php echo esc_attr( $api_key ); ?></span>
												<span class="wpmudev-table_desc"><?php esc_attr_e( "Click here to edit or change your email provider", Opt_In::TEXT_DOMAIN ); ?></span>
											</a>

										</td>

									</tr>

								</tbody>

							</table>

						</td></tr>

					<?php endforeach; ?>
				<?php else: ?>
				<tr class="wph-wizard-content-email-providers"><td>

					<table cellspacing="0" cellpadding="0" class="wpmudev-table_inner">

						<tbody>

							<tr class="{{ ( _.isFalse(email_services.mailchimp.enabled) ) ? 'wpmudev-disabled' : '' }}" >

								<td>

									<div class="wpmudev-switch">

										<input id="wph-embedded-list_mailchimp" class="toggle-checkbox wph-email-service-toggle" type="checkbox" data-attribute="mailchimp_service_provider" {{_.checked(_.isTrue(email_services.mailchimp.enabled), true)}} >

										<label class="wpmudev-switch-design" for="wph-embedded-list_mailchimp" aria-hidden="true"></label>

									</div>

								</td>

								<td class="wph-email-providers-icon"><?php $this->render( "general/icons/icon-mailchimp", array() ); ?></td>

								<td><a data-id="mailchimp" href="#" class="wph-email-service-edit-link" data-nonce="<?php echo esc_attr( wp_create_nonce('change_provider_name') ); ?>">
									<span class="wpmudev-table_name"><?php esc_attr_e( "MailChimp", Opt_In::TEXT_DOMAIN ); ?></span>
									<span class="wpmudev-table_desc"><# if ( _.isEmpty ( email_services.mailchimp.api_key ) ) { #><?php esc_attr_e( "Connect to start growing your lists.", Opt_In::TEXT_DOMAIN ); ?><# } else { #>{{email_services.mailchimp.api_key}}<# } #></span>
									<span class="wpmudev-table_desc"><?php esc_attr_e( "Click here to edit or change your email provider", Opt_In::TEXT_DOMAIN ); ?></span>
								</a></td>

							</tr>

						</tbody>

					</table>

				</td></tr><?php // MailChimp ?>
				<?php endif; ?>

			</tbody>
			<tfoot>
				<tr>
					<td>
						<a href="#" class="wph-email-service-edit-link wpmudev-button wpmudev-button-blue" data-id="<?php echo esc_attr( $active_service ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce('change_provider_name') ); ?>" ><?php esc_html_e( "Add Another Service", Opt_In::TEXT_DOMAIN ); ?></a>
						<label class="wpmudev-label--notice"><span><?php esc_html_e( 'Only one integration can be used at a time...you pick!', Opt_In::TEXT_DOMAIN ); ?></span></label>
					</td>
				</tr>
			</tfoot>
		</table>

	</div>

</div><?php // #wph-wizard-content-email ?>

<?php
$this->render( "admin/slidein/wizard/boxes/box-form_elements", array(
    'module'  => $module,
    'default_form_fields' => $default_form_fields
) );
?>


<?php $this->render( "admin/slidein/wizard/boxes/box-form_submission", array() ); ?>


<?php // Opt-in provider icons template ?>
<?php foreach( $providers as $provider ) : ?>
	<script id="wpmudev-<?php echo esc_attr( $provider['id'] ); ?>-optin-provider-icon-svg" type="text/template">
        <?php if ( 'mad_mimi' === $provider['id'] ) : ?>

            <div class="wpmudev-icon wpmudev-i_madmimi"></div>

        <?php else : ?>

            <?php $this->render( "general/icons/icon-" . $provider['id'], array() ); ?>

        <?php endif; ?>
    </script>
<?php endforeach; ?>