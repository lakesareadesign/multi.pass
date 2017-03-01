<div class="wpoi-optin wpoi-align">
	<# if ( 'remain' === on_success ) { #>
	<!--<div class="wpoi-success-close">
		<i class="wpoi-icon i-close i-small"></i>
	</div>-->
	<# } #>
	<div class="wpoi-container wpoi-col wpoi-align-element">

		<div class="wpoi-element">

			<i class="wpoi-icon i-check"></i>

		</div>
		<div class="wpoi-element">

			<div class="wpoi-content">{{{ success_message.replace("{name}", optin_name) }}}</div>
		</div>
	</div>
</div>