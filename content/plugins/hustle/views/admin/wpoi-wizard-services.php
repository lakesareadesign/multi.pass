<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-services_template" type="text/template">

	<header class="wph-toggletabs--title can-open">

		<h4><?php _e('Basic Setup', Opt_In::TEXT_DOMAIN); ?></h4>

		<span class="open"><i class="wph-icon i-arrow"></i></span>

	</header><!-- .wph-toggletabs--header -->

	<section class="wph-toggletabs--content">

		<div id="wph-optin--name" class="wph-flex wph-flex--row wph-margin--40b">

			<div class="wph-flex--side wph-flex--title">

				<h5><?php _e('Name & Service', Opt_In::TEXT_DOMAIN); ?></h5>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt wph-label--border"><?php _e('Choose a name for your opt-in.', Opt_In::TEXT_DOMAIN); ?></label>

				<input type="text" data-attribute="optin_name" id="optin_new_name" name="optin_new_name" value="{{optin_name}}" placeholder="<?php esc_attr_e("Enter opt-in name.", Opt_In::TEXT_DOMAIN) ?>">

			</div>

		</div><!-- #wph-optin--name -->

		<div id="wph-optin--mode" class="wph-flex wph-flex--row">

			<div class="wph-flex--side wph-flex--title"></div>

			<div class="wph-flex--box">

				<label class="wph-label--alt wph-label--border"><?php _e('Select your Email Service', Opt_In::TEXT_DOMAIN); ?></label>

				<div class="wph-flex">

					<div id="wph-optin--testmode" class="wph-flex--box">

						<div class="wph-label--toggle">

							<label class="wph-label--alt">

								<span><?php _e('Setup in <strong>Test Mode</strong>', Opt_In::TEXT_DOMAIN); ?></span>

								<small><?php _e('A quick and easy way to test Hustle\'s opt-ins', Opt_In::TEXT_DOMAIN); ?></small>

							</label>

							<span class="toggle">

								<input id="wpoi-test-mode-setup" class="toggle-checkbox" type="checkbox" value="1" name="test_mode" data-attribute="test_mode"  {{_.checked(test_mode, 1)}}>

								<label class="toggle-label" for="wpoi-test-mode-setup"></label>

							</span>

						</div>

					</div><!-- #wph-optin--testmode -->

					<div id="wph-optin--localemails" class="wph-flex--box">

						<div class="wph-label--toggle">

							<label class="wph-label--alt">

								<span><?php _e('Save emails to local list', Opt_In::TEXT_DOMAIN); ?></span>

								<small><?php _e('Will save submitted email addresses to exportable CSV list', Opt_In::TEXT_DOMAIN); ?></small>

							</label>

							<span class="toggle">

								<input id="wpoi-save-to-local" class="toggle-checkbox" type="checkbox" value="1" name="save_to_local" data-attribute="save_to_local"  {{_.checked(save_to_local, 1)}}>

								<label class="toggle-label" for="wpoi-save-to-local"></label>

							</span>

						</div>

					</div><!-- #wph-optin--localemails -->

				</div>

			</div>

		</div><!-- #wph-optin--mode -->

		<div id="wph-optin--service" class="wph-flex wph-flex--row">

			<div class="wph-flex--side wph-flex--title"></div>

			<div class="wph-flex--box">

				<h4 class="wph-border--top"><?php _e('Email Service', Opt_In::TEXT_DOMAIN); ?></h4>

				<div class="wph-triggers wph-tabs--wrap">

<!--					<ul class="wph-triggers--tabs wph-triggers--xsmargin wph-tabs--nav">-->
<!--						-->
<!--						<li  {{_.add_class( service_source == "existing", 'current' )}}>-->
<!--							-->
<!--							<label href="#wpoi-email-service-saved" for="wpoi-email-service_saved">-->
<!--								-->
<!--								--><?php //_e('Existing Services', Opt_In::TEXT_DOMAIN); ?>
<!--								-->
<!--								<input type="radio" name="wpoi-email-service" id="wpoi-email-service_saved" data-attribute="service_source" value="existing">-->
<!--								-->
<!--							</label>-->
<!--							-->
<!--						</li>-->
<!--						-->
<!--						<li class="current">-->
<!--							-->
<!--							<label href="#wpoi-email-service-new" for="wpoi-email-service_new">-->
<!--								-->
<!--								--><?php //_e('Setup New Service', Opt_In::TEXT_DOMAIN); ?>
<!--								-->
<!--								<input type="radio" name="wpoi-email-service" id="wpoi-email-service_new" data-attribute="service_source" value="new">-->
<!--								-->
<!--							</label>-->
<!--							-->
<!--						</li>-->
<!--						-->
<!--					</ul>-->

					<div class="wph-triggers--content wph-tabs--contents">

						<div id="wpoi-email-service-saved" class="wph-triggers--option wph-tabs--content {{_.class( service_source == 'existing', 'not_current' )}}">

							<label class="wph-label--notice {{_.class(_.isFalse(test_mode), 'hidden' )}}">

								<span><?php _e('To set-up an Email Service, please disable <strong>Test Mode</strong>.', Opt_In::TEXT_DOMAIN); ?></span>

							</label>

							<table class="wph-table wph-settings--email">

								<tbody class="wph-tbody--reset">

									<# _.each(optin_vars.services, function(service, id){ #>
										<tr>

											<td class="wph-list--radio">

												<div class="wph-input--radio">

													<input type="radio" id="{{service.provider}}-{{id}}" value="{{id}}" name="optin-existing-service" {{_.checked(service.name, optin_provider)}} data-attribute="optin_provider" {{_.disabled(test_mode, 1)}} >

													<label class="wph-icon i-check" for="{{service.provider}}-{{id}}"></label>

												</div>

											</td>

											<td class="wph-list--icon">

												<div class="wph-list--{{service.name}}"></div>

											</td>

											<td class="wph-list--info">

												<span class="wph-table--title">{{ _.toUpperCase( service.name ) }}</span>

												<span class="wph-table--subtitle">{{service.api_key}}</span>
												<# if( service.list_id ){ #>
													<span class="wph-table--subtitle">{{service.list_id}}</span>
												<# } #>
											</td>

										</tr>
									<# }); #>

								</tbody>

							</table>

						</div><!-- #wpoi-email-service-saved -->

						<div id="wpoi-email-service-new" class="wph-triggers--option wph-tabs--content current">

							<div id="wpoi-service-details">

								<label class="wph-label--notice {{_.class(_.isFalse(test_mode), 'hidden' )}}">

									<span><?php _e('To set-up an Email Service, please disable <strong>Test Mode</strong>.', Opt_In::TEXT_DOMAIN); ?></span>

								</label>

								<form action="" method="post" id="hustle_service_details_form">

									<?php wp_nonce_field( "refresh_provider_details" ); ?>

									<div class="wpoi-card-block wpoi-card-block-invisible wpoi-error-select">

										<label><?php _e("Choose email provider:", Opt_In::TEXT_DOMAIN); ?></label>

										<select data-silent="true"  data-attribute="optin_provider" name="optin_new_provider_name"  id="optin_new_provider_name" {{_.disabled( _.isTrue( test_mode ) , true )}}  class="wpmuiSelect" data-nonce="<?php echo wp_create_nonce('change_provider_name') ?>">

											<option value=""><?php _e("Select provider", Opt_In::TEXT_DOMAIN); ?></option>

											<# _.each( optin_vars.providers, function(provider, key) { #>

												<option {{ _.selected( optin_provider,  provider.id)  }} value="{{provider.id}}">{{provider.name}}</option>

											<# }); #>

										</select>

									</div><!-- End Email Provider -->

									<?php if ( $is_edit ) : ?>

										<div id="wpoi-email-provider-details-container" class="wpoi-card-block wpoi-card-block-invisible">

											<div id="optin_new_provider_account_details" class="optwiz-field_set">

												<?php
												$current_provider = empty( $selected_provider ) ? $optin->optin_provider : $selected_provider;
												$provider = Opt_In::get_provider_by_id( $current_provider );

												if( $provider ){

													$provider_instance = Opt_In::provider_instance( $provider );

													$options = $provider_instance->get_account_options( $optin->id );

													foreach( $options as $key =>  $option ){

														if( $option['type'] === 'wrapper'  ){ $option['apikey'] = $optin->api_key; }

														$option = apply_filters("wpoi_optin_filter_optin_options", $option, $optin );

														$this->render("general/option", array_merge( $option, array( "key" => $key ) ));

													}

													do_action("wpoi_optin_show_provider_account_options", $current_provider, $provider_instance );

												} ?>

											</div>

											<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_options">

												<?php if( $optin->test_mode != 1 && $optin->optin_mail_list && apply_filters("wpoi_optin_{$optin->optin_provider}_show_selected_list", true, $optin ) ): ?>

													<?php echo __('Selected list (campaign):', Opt_In::TEXT_DOMAIN ); ?>  <?php echo $optin->optin_mail_list . __(' (Press the GET LISTS button to update value)', Opt_In::TEXT_DOMAIN ); ?>

												<?php endif; ?>

												<?php do_action("wpoi_optin_show_selected_list_after", $optin);  ?>

											</div>

											<?php  if( $optin->provider_args ) : ?>

												<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_provider_args">

													<?php $this->render("admin/provider/" . $optin->optin_provider . '/args', array(
														"optin" => $optin,
														"args" => $optin->provider_args,
														"this" => $this
													)); ?>

												</div>

											<?php endif; ?>

										</div><!-- End API Key -->

									<?php else: ?>

										<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_details">

											<?php do_action("wpoi_optin_show_provider_account_options", $selected_provider, null ); ?>

										</div>

										<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_options"></div>

									<?php endif; ?>

								</form>

							</div>

						</div><!-- #wpoi-email-service-new -->

					</div>

				</div>

			</div>

		</div><!-- #wph-optin--service -->

		<div id="wpoi_loading_indicator" style="display: none;">

			<div class="wpoi-loading-wrapper">

				<div class="wpoi-loading"></div>

				<p><?php _e('Wait a bit, content is being loaded...', Opt_In::TEXT_DOMAIN); ?></p>

			</div>

		</div>

	</section><!-- .wph-toggletabs--content -->

	<footer class="wph-toggletabs--footer">

		<div class="row">

			<div class="col-half">

				<a href="#0" class="wph-button wph-button--filled wph-button--gray js-wph-optin-cancel"><?php _e('Cancel', Opt_In::TEXT_DOMAIN); ?></a>

			</div>

			<div class="col-half next-button">

				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-save wph-button--filled wph-button--blue"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></button>

				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-next wph-button--filled wph-button--gray"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></button>

			</div>

		</div>

	</footer><!-- .wph-toggletabs--footer -->

</script>
