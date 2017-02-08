<div id="hustle-cc-listings" class="hustle-two">

	<div id="container<?php if ( count( $custom_contents ) !== 0 ) : echo ' full'; endif; ?>" class="wrap">

		<header id="header"<?php if ( ( $legacy_popups && false ) && ( count( $custom_contents ) === 0 ) ) : echo ' class="no-margin-btm"'; endif;?>>

			<h1><?php _e('CUSTOM CONTENT', Opt_In::TEXT_DOMAIN); ?><a class="wph-button wph-button--small wph-button--gray wph-button--fleft mobile-hidden" href="<?php echo esc_url( $add_new_url ); ?>"><?php _e('New Custom Content', Opt_In::TEXT_DOMAIN); ?></a></h1>

		</header>

		<section>

			<section id="wph-ccontent--modules">

				<?php if ( count( $custom_contents ) === 0 ){ ?>

					<div class="flex-row">

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<section id="wph-woop" class="box">

								<div class="box-title">

									<h3><?php _e('Welcome to Custom Contents', Opt_In::TEXT_DOMAIN); ?></h3>

								</div>

								<div class="box-content">

									<div class="flex-row">

										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

											<div class="wph-howdy"></div>

										</div>

										<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

											<div class="content-800">

												<h2><?php _e('Woop woop, let\'s create some modules!', Opt_In::TEXT_DOMAIN); ?></h2>

												<h6><?php _e('Meet Hustle\'s new custom content modules! Create slide-ins, pop-ups, and static content you display when and where you want. Get started by clicking New Custom Content above.', Opt_In::TEXT_DOMAIN); ?></h6>

											</div>

										</div>

									</div>

								</div>

							</section>

						</div>

					</div>

				<?php } ?>

				<?php if( $legacy_popups && false ): ?>

					<h4><?php _e('Custom Content Modules', Opt_In::TEXT_DOMAIN); ?></h4>

				<?php endif; ?>

				<div class="flex-row">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<?php $this->render("admin/ccontent/ccontent-listings", array(
							"custom_contents" => $custom_contents,
							'types' => $types,
							'new_cc' =>  isset( $_GET['new_id'] ) ? $_GET['new_id'] : null,
							'updated_cc' =>  isset( $_GET['updated_id'] ) ? $_GET['updated_id'] : null
						)); ?>

					</div>

				</div>

			</section>

			<?php if( $legacy_popups && false ): ?>

				<section id="wph-ccontent--migration">

					<h4><?php _e('Legacy Pop Ups', Opt_In::TEXT_DOMAIN); ?></h4>

					<?php $this->render("admin/ccontent/ccontent-migration", array("popups" => $legacy_popups)); ?>

				</section>

			<?php endif; ?>

		</section>

	</div>

</div>