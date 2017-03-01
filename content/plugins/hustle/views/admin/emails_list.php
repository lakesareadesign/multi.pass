<script id="wpoi-emails-list-modal-tpl" type="text/template">

	<div class="hustle-two">

		<div class="wpoi-complete-mask"></div>

		<div class="wpoi-complete-wrap row">

			<div class="col-xs-12">

				<section class="box">

					<div class="box-title">

						<h3>{{name}}<span class="wpoi-total-subscribers"><?php _e('Total {{total}} subscriptions', Opt_In::TEXT_DOMAIN); ?></span></h3>

						<a href="#" aria-label="Close" class="wph-icon i-close inc-opt-close-emails-list"></a>

					</div>

					<div class="box-content">

						<div class="wpoi-emails-list">

							<div class="wpoi-emails-list-header">

								<div class="wpoi-list-fname"><?php _e('First name', Opt_In::TEXT_DOMAIN); ?></div>

								<div class="wpoi-list-lname"><?php _e('Last name', Opt_In::TEXT_DOMAIN); ?></div>

								<div class="wpoi-list-email"><?php _e('Email', Opt_In::TEXT_DOMAIN); ?></div>

							</div>

							<div id="wpoi-emails-list-content"></div>

							<div class="wpoi-emails-list-footer">

								<a href="<?php echo wp_nonce_url( get_admin_url(null, 'admin-ajax.php?action=inc_optin_export_subscriptions&id=__id'  ), 'inc_optin_export_subscriptions' ) ?>" class="wph-button wph-button--small wph-button--filled wph-button--gray button-export-csv" data-id="{{id}}" target="_blank"><?php _e("Export CSV", Opt_In::TEXT_DOMAIN); ?></a>

							</div>

						</div>

					</div>

				</section>

			</div>

		</div>

	</div>

</script>

<script id="wpoi-emails-list-tpl" type="text/template">

	<# _.each( subscriptions, function( sub, i ) { #>

		<div class="wpoi-emails-list-subscriber">

			<div class="wpoi-list-fname" data-title="<?php _e('First Name', Opt_In::TEXT_DOMAIN); ?>">{{sub.f_name}}</div>

			<div class="wpoi-list-lname" data-title="<?php _e('Last Name', Opt_In::TEXT_DOMAIN); ?>">{{sub.l_name}}</div>

			<div class="wpoi-list-email" data-title="<?php _e('Email', Opt_In::TEXT_DOMAIN); ?>">{{sub.email}}</div>

		</div>

	<# }); #>

</script>