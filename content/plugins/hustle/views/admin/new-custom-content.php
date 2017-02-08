<div class="hustle-two wph-custom-content">

	<div id="container" class="wrap">

		<header id="header">

			<h1><?php _e('CUSTOM CONTENT', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>

			<div class="row">

				<section class="col-full">

					<div class="dev-box content-box">

						<div class="box-title">

							<h3><?php _e('Create New Custom Content Module', Opt_In::TEXT_DOMAIN); ?></h3>

						</div>

						<div class="box-content">

							<!-- Content & Design -->
							<?php $this->render("admin/ccontent/ccontent-design"); ?>

							<!-- Display Settings -->
							<?php $this->render("admin/ccontent/ccontent-settings"); ?>

						</div>

					</div><!-- .dev-box -->

				</section>

			</div>

		</section>

	</div>

	<?php $this->render("admin/ccontent/ccontent-preview-container"); ?>

</div>

<?php $this->render("admin/settings/display-triggers"); ?>

<?php $this->render("admin/settings/conditions"); ?>
<?php $this->render("general/modal"); ?>