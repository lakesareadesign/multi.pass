<script id="optin-mailchimp-args-tpl" type="text/template">

	<# if( 'undefined' !== typeof group ) { #>

		<# if( 'undefined' !== typeof group.id ) { #>

			<input type="hidden" name="mailchimp_group_id" class="mailchimp_group_id" value="{{group.id}}">

		<# } #>
		<# if ( "hidden" !== group.type ) { #>
			<# if ( 'dropdown' === group.type ) { #>

				<div class="hustle-modal-mc_groups">
					<select name="mailchimp_group_interest" class="hustle-select">
						<# _.each( interests, function( interest, key ) { #>
							<# if ( 'undefined' !== typeof interest.value  ) { #>
								<option id="wph-checkbox-id-{{interest.value}}" value="{{interest.value}}" {{ ( 'undefined' !== typeof selected ) ? _.selected( ( selected.indexOf(interest.value) !== -1 ), true ) : '' }}>{{interest.label}}</option>
							<# } else {#>
								<option id="wph-checkbox-id-blank" value hidden >&nbsp;</option>
							<# } #>
						<# }); #>
					</select>
				</div>

				<# jQuery(document).ready(function($) {
					$('.hustle-select').wpmuiSelect({
						 allowClear: false,
						 minimumResultsForSearch: Infinity,
						 containerCssClass: "hustle-select2",
						 dropdownCssClass: "hustle-select-dropdown"
					});
					$( ".hustle-option--select" ).wpmuiSelect({
						allowClear: false,
						minimumResultsForSearch: Infinity,
						containerCssClass: "hustle-option--select2",
						dropdownCssClass: "hustle-option--select2-dropdown"
					});
				}); #>

			<# } #>

			<# if( 'checkboxes' === group.type ) { #>

				<div class="hustle-modal-mc_groups">

					<# _.each( interests, function( interest, key ) { #>
						<div class="hustle-modal-mc_option">
							<div class="hustle-modal-mc_checkbox">
								<input name="mailchimp_group_interest[]" type="checkbox" id="wph-checkbox-id-{{interest.value}}" value="{{interest.value}}" {{ ( 'undefined' !== typeof selected ) ? _.checked( ( selected.indexOf(interest.value) !== -1 ), true ) : '' }} >
								<label for="wph-checkbox-id-{{interest.value}}" class="wpdui-fi wpdui-fi-check"></label>
							</div>
							<div class="hustle-modal-mc_label">
								<label for="wph-checkbox-id-{{interest.value}}">{{interest.label}}</label>
							</div>
						</div>
					<# }); #>

				</div>

			<# } #>

			<# if( 'radio' === group.type ) { #>

				<div class="hustle-modal-mc_groups">

					<# _.each( interests, function( interest, key ) { #>
						<div class="hustle-modal-mc_option">
							<div class="hustle-modal-mc_radio">
								<input name="mailchimp_group_interest" type="radio" id="wph-checkbox-id-{{interest.value}}" value="{{interest.value}}" {{ ( 'undefined' !== typeof selected ) ? _.checked( ( selected.indexOf(interest.value) !== -1 ), true ) : '' }}>
								<label for="wph-checkbox-id-{{interest.value}}" class="wpdui-fi wpdui-fi-check"></label>
							</div>
							<div class="hustle-modal-mc_label">
								<label for="wph-checkbox-id-{{interest.value}}">{{interest.label}}</label>
							</div>
						</div>
					<# }); #>

				</div>

			<# } #>
		<# } else {
			_.each( interests, function( interest, key ) {
				if( ( 'undefined' !== typeof selected ) && ( selected.indexOf(interest.value) !== -1 ) ) { #>
					<input name="mailchimp_group_interest" type="hidden" id="wph-hidden-id-{{interest.value}}" value="{{interest.value}}" />
				<# }
			});
		} #>
	<# } #>

</script>