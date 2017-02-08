<?php
/**
 * @var $data Hustle_Dashboard_Data
 */
?>
<div id="wph-dashboard" class="hustle-two">

	<div id="container" class="wrap">

		<header id="header">

			<h1><?php _e('DASHBOARD', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>

			<div class="flex-row">

				<div class="col-xs-12">

					<?php if ( !( (bool) $data->active_modules ) ) :

						$this->render("admin/dashboard/widget-welcome" );

					endif; ?>

					<?php if ( !$is_free  ) : ?>

						<?php if ( $data->active_modules ) :

							$this->render("admin/dashboard/widget-welcome-on", array( 'data_exists' => $data_exists, 'types' => $types, 'conversions' => $conversions, 'active_modules' => $active_modules, 'most_conversions' => $most_conversions ) );

						endif; ?>

						<?php if( count( $conversion_data ) ) :

							$this->render("admin/dashboard/widget-module-stats", array( 'conversion_data' => $conversion_data ) );

						endif; ?>

					<?php endif; ?>

				</div>

			</div>

			<?php if ( ( $data->active_modules ) || ( 0 !== $data->all_modules ) ) : ?>

				<div class="flex-row">

					<section class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

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

				</div>

			<?php elseif ( ( ! $data->active_modules ) || ( $is_free && 0 !== $data->all_modules ) || ( $is_free ) ) : ?>

				<div class="flex-row">

					<?php if ( ! $data->active_modules ) : ?>

						<section class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

							<?php $this->render("admin/dashboard/widget-module-setup", array( 'has_optins' => $has_optins, 'has_custom_content' => $has_custom_content, 'has_social_sharing' => $has_social_sharing, 'has_social_rewards' => $has_social_rewards ) ); ?>

						</section>

					<?php endif; ?>

					<?php if ( $is_free && 0 !== $data->all_modules ) : ?>

						<section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

							<?php $this->render("admin/dashboard/widget-conversion-report"); ?>

						</section>

					<?php endif; ?>

					<?php if ( $is_free ): ?>

						<section class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

							<?php $this->render("admin/dashboard/widget-conversion-tracking"); ?>

						</section>

					<?php endif; ?>

				</div>

			<?php endif; ?>

		</section>

	</div>

</div>