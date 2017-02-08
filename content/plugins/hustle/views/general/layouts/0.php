<script id="optin-layout-one" type="text/template">

	<div class="wpoi-hustle wpoi-layout-one">

		<div class="wpoi-success-message">

			<?php $this->render("general/layouts/success"); ?>

		</div>

		<div class="wpoi-optin">

			<div class="wpoi-container wpoi-col<# if(!optin_title && !optin_message){ #> nocontent<# } #><# if(!image_src){ #> noimage<# } #>">

				<div class="wpoi-element">

					<div class="wpoi-container wpoi-image-{{image_location}}">

						<# if(elements.indexOf("image") !== -1){ #>

							<div class="wpoi-element wpoi-aside wpoi-image wpoi-image-fill" style="background-image: url('{{image_src}}'); background-size:{{image_style}};"></div>

						<# } #>

						<# if(optin_title || optin_message){ #>

							<div class="wpoi-element">

								<div class="wpoi-content">

									<# if(optin_title){ #>

										<h2 class="wpoi-title">{{optin_title}}</h2>

									<# } #>

									<# if(optin_message){ #>

										<div class="wpoi-message">{{{optin_message}}}</div>

									<# } #>

								</div>

							</div>

						<# } #>

					</div>

				</div>

				<div class="wpoi-element wpoi-form">

					<form class="wpoi-container<# if( has_args ){ #> wpoi-col<# } #> wpoi-fields-{{fields_style}} wpoi-{{input_icons}}<# if( has_args ){ #> hasmcg<# } #>" method="post">

						<# if( has_args ){ #>

							<div class="wpoi-element wpoi-mcg-common-fields">

								<div class="wpoi-container">

									<# if(elements.indexOf("first_name") !== -1){ #>

										<div class="wpoi-element">

											<input type="text"  name="inc_optin_first_name" data-error="<?php esc_attr_e('Please, provide First Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-fname required">

											<label>

												<i class="wpoi-icon i-user"></i>

												<span><?php esc_attr_e('First Name', Opt_In::TEXT_DOMAIN) ?></span>

											</label>

										</div>

									<# } #>

									<# if(elements.indexOf("last_name") !== -1){ #>

										<div class="wpoi-element">

											<input type="text" name="inc_optin_last_name" data-error="<?php esc_attr_e('Please provide Last Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-lname required">

											<label>

												<i class="wpoi-icon i-user"></i>

												<span><?php esc_attr_e('Last Name', Opt_In::TEXT_DOMAIN) ?></span>

											</label>

										</div>

									<# } #>

									<div class="wpoi-element">

										<input type="email" name="inc_optin_email" data-error="<?php esc_attr_e('Please, provide valid Email address', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-email required">

										<label>

											<i class="wpoi-icon i-email"></i>

											<span><?php esc_attr_e('E-mail', Opt_In::TEXT_DOMAIN) ?></span>

										</label>

									</div>

								</div>

							</div>

							<div class="wpoi-element wpoi-provider-args" style="margin-bottom: 0;"></div>

						<# } else { #>

							<# if(elements.indexOf("first_name") !== -1){ #>

								<div class="wpoi-element">

									<input type="text"  name="inc_optin_first_name" data-error="<?php esc_attr_e('Please, provide First Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-fname required">

									<label>

										<i class="wpoi-icon i-user"></i>

										<span><?php esc_attr_e('First Name', Opt_In::TEXT_DOMAIN) ?></span>

									</label>

								</div>

							<# } #>

							<# if(elements.indexOf("last_name") !== -1){ #>

								<div class="wpoi-element">

									<input type="text" name="inc_optin_last_name" data-error="<?php esc_attr_e('Please provide Last Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-lname required">

									<label>

										<i class="wpoi-icon i-user"></i>

										<span><?php esc_attr_e('Last Name', Opt_In::TEXT_DOMAIN) ?></span>

									</label>

								</div>

							<# } #>

							<div class="wpoi-element">

								<input type="email" name="inc_optin_email" data-error="<?php esc_attr_e('Please, provide valid Email address', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-email required">

								<label>

									<i class="wpoi-icon i-email"></i>

									<span><?php esc_attr_e('E-mail', Opt_In::TEXT_DOMAIN) ?></span>

								</label>

							</div>

							<div class="wpoi-button">

								<button type="submit" class="wpoi-subscribe-send"><?php _e("Sign Up", Opt_In::TEXT_DOMAIN) ?></button>

							</div>

						<# } #>

                    </form>

				</div>

			</div>

		</div>

	</div>

</script>