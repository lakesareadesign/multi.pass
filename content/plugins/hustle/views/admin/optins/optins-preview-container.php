<div class="wph-preview wph-preview--closed">

	<div class="wph-preview--mask"></div>

	<div class="wph-preview--optin wph-preview--popup">

		<div class="wph-preview--holder">

			<div id="optin-preview-wrapper"></div><?php // This div will be replaced with the actual modal ?>

		</div>

	</div>

	<div class="wph-preview--switch">

		<div class="wph-flex wph-flex--row">

			<div class="wph-flex--side_50 wph-flex--end">

				<button class="wph-preview--close wph-button"><i class="wph-icon i-close"></i></button>

			</div>

			<div class="wph-flex--box">

				<p><?php _e('Preview display type', Opt_In::TEXT_DOMAIN); ?></p>

				<select id="wph-preview-type-selector" class="wpmuiSelect">

					<option value="popup">Pop Up</option>
					<option value="slide_in">Slide In</option>
					<option value="after_content">After Content</option>

				</select>

			</div>

		</div>

	</div>

</div>