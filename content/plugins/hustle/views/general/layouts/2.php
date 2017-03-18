<script id="optin-layout-three" type="text/template">

	<div class="wpoi-hustle wpoi-layout-three">

		<div class="wpoi-success-message">

			<?php $this->render("general/layouts/success"); ?>

		</div>

		<div class="wpoi-optin">

			<div class="wpoi-container wpoi-image-{{image_location}}<# if(!optin_title && !optin_message){ #> nocontent<# } #><# if(!image_src){ #> noimage<# } #>">

				<div class="wpoi-element">

					<div class="wpoi-container wpoi-col">

						<div class="wpoi-element wpoi-image wpoi-image-fill" style="background-image: url('{{image_src}}'); background-size:{{image_style}};"></div>

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

				<div class="wpoi-element wpoi-aside-x wpoi-form">

					<form class="wpoi-container wpoi-col wpoi-fields-{{fields_style}} wpoi-{{input_icons}}<# if( has_args ){ #> hasmcg<# } #>" method="post">

						<# if( !( elements.indexOf("first_name") === -1 && elements.indexOf("last_name")  === -1 ) ){ #>

							<div class="wpoi-element" style="background-color: transparent;">

								<div class="wpoi-container">

									<# if(elements.indexOf("first_name") !== -1){ #>

										<div class="wpoi-element">

											<input type="text"  name="inc_optin_first_name" data-error="<?php esc_attr_e('Please, provide First Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-fname required">

											<label>

												<i class="wphi-font wphi-user"></i>

												<span><?php esc_attr_e('First Name', Opt_In::TEXT_DOMAIN) ?></span>

											</label>

										</div>

									<# } #>

									<# if(elements.indexOf("last_name") !== -1){ #>

										<div class="wpoi-element">

											<input type="text" name="inc_optin_last_name" data-error="<?php esc_attr_e('Please provide Last Name', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-lname required">

											<label>

												<i class="wphi-font wphi-user"></i>

												<span><?php esc_attr_e('Last Name', Opt_In::TEXT_DOMAIN) ?></span>

											</label>

										</div>

									<# } #>

								</div>

							</div>

						<# } #>

						<div class="wpoi-element">

							<input type="email" name="inc_optin_email" data-error="<?php esc_attr_e('Please, provide valid Email address', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-email required">

							<label>

								<i class="wphi-font wphi-email"></i>

								<span><?php esc_attr_e('E-mail', Opt_In::TEXT_DOMAIN) ?></span>

							</label>

						</div>

						<# if( has_args ){ #>

							<div class="wpoi-element wpoi-provider-args" style="margin-bottom: 0;"></div>

						<# } else { #>

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