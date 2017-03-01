<?php
/**
 * @var Opt_In_Admin $this
 */
?>
<div id="hustle-settings" class="hustle-two">

	<div id="container"<?php if ( count( $optins ) === 0 && count( $custom_contents ) === 0 ) : ''; else : echo ' class="container-980"'; endif; ?>>

		<header id="header">

			<h1><?php _e('SETTINGS', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>

			<?php if ( count( $optins ) === 0 && count( $custom_contents ) === 0 ) : ?>

				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div id="wph-woop" class="box">

							<div class="box-title">

								<h3><?php _e('Welcome to Settings', Opt_In::TEXT_DOMAIN); ?></h3>

							</div>

							<div class="box-content">

								<div class="row">

									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

										<div class="wph-howdy"></div>

									</div>

									<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

										<div class="content-800">

											<h2><?php _e('Woop woop, let\'s create something first!', Opt_In::TEXT_DOMAIN); ?></h2>

											<h6><?php _e('Create an email opt-in or custom content module to manage who can see it or it\'s syncing with Newsletter plugin.', Opt_In::TEXT_DOMAIN); ?></h6>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			<?php else : ?>

				<div class="row">
<!--				-->
<!--				<section class="col-xs-12 col-sm-12 col-md-12 col-lg-6">-->
<!--					-->
<!--					<div id="providers-edit-box" class="box content-box">-->
<!---->
<!--						--><?php //$this->render( "admin/settings/providers-edit", array(
//							"services" => $email_services,
//							"nonce" => wp_create_nonce("hustle_edit_providers")
//						) ); ?>
<!---->
<!--					</div>-->
<!---->
<!--					--><?php
//					$this->render("admin/settings/providers-edit-modal");
//					?>
<!---->
<!--				</section>-->

					<section class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

						<?php if ( $is_e_newsletter_active ){ ?>

							<div id="enews-sync-box" class="box content-box">

								<?php $this->render( "admin/settings/e-news-sync-front", array(
									"optins" => $optins,
									"enews_sync_state_toggle_nonce" => $enews_sync_state_toggle_nonce,
									"enews_sync_setup_nonce" => $enews_sync_setup_nonce
								) ); ?>

							</div>

							<?php $this->render("admin/settings/e-news-sync-back"); ?>

						<?php } ?>

						<div class="box content-box" id="modules-activity">

							<?php
								$this->render( "admin/settings/modules", array(
									"modules" => $modules,
									"modules_state_toggle_nonce" => $modules_state_toggle_nonce
								) );
							?>

						</div>

					</section>

				</div>

			<?php endif; ?>

		</section>

	</div>

</div>