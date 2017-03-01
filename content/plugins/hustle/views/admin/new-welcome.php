<?php
/**
 * @var $data Hustle_Dashboard_Data
 */
?>
<div id="wph-dashboard" class="hustle-two">

	<div id="container" class="container-1146">

		<header id="header">

			<h1><?php _e('DASHBOARD', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>

			<div class="row">

				<?php

					$new_welcome_notice_dismissed = (bool) get_option( "hustle_new_welcome_notice_dismissed", false );

					if ( !( (bool) $data->active_modules ) && !$new_welcome_notice_dismissed ) : ?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<?php $this->render("admin/dashboard/widget-welcome" ); ?>

					</div>

				<?php endif; ?>

				<?php if ( $data->active_modules ) : ?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<?php $this->render("admin/dashboard/widget-welcome-on", array( 'data_exists' => $data_exists, 'types' => $types, 'conversions' => $conversions, 'active_modules' => $active_modules, 'most_conversions' => $most_conversions ) ); ?>

					</div>

				<?php endif; ?>

				<?php if( count( $conversion_data ) ) : ?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<?php $this->render("admin/dashboard/widget-module-stats", array( 'conversion_data' => $conversion_data ) ); ?>

					</div>

				<?php endif; ?>

			</div>

			<div class="row">

				<?php if ( !$data->active_modules ) : ?>

					<section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<?php if ( ( count($data->optins) > 0 ) && ( count($data->custom_contents) > 0 ) ) { ?>

							<?php
							$this->render( "admin/dashboard/widget-module-edit", array(
								"total_optins" => count($data->optins),
								"optins" => $data->active_optin_modules,
								"inactive" => $data->inactive_optin_modules,
								"total_custom_contents" => count($data->custom_contents),
								"custom_contents" => $data->active_cc_modules,
								"inactive_cc" => $data->inactive_cc_modules,
							) ); ?>

						<?php } else { ?>

							<?php $this->render("admin/dashboard/widget-module-setup", array( 'has_optins' => $has_optins, 'has_custom_content' => $has_custom_content, 'has_social_sharing' => $has_social_sharing, 'has_social_rewards' => $has_social_rewards ) ); ?>

						<?php }?>

					</section>

					<section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<?php $this->render("admin/dashboard/widget-conversion-tracking"); ?>

					</section>

				<?php else : ?>

					<section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<?php
						$this->render( "admin/dashboard/widget-module-edit", array(
							"total_optins" => count($data->optins),
							"optins" => $data->active_optin_modules,
							"inactive" => $data->inactive_optin_modules,
							"total_custom_contents" => count($data->custom_contents),
							"custom_contents" => $data->active_cc_modules,
							"inactive_cc" => $data->inactive_cc_modules,
						) ); ?>

					</section>

					<!--<section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">-->

						<?php //$this->render("admin/dashboard/widget-conversion-report"); ?>

						<?php //$this->render("admin/dashboard/widget-conversion-tracking"); ?>

					<!--</section>-->

				<?php endif; ?>

			</div>

		</section>

	</div>

</div>