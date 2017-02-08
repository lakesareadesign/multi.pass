<script id="hustle-cc-shortcode-tpl" type="text/template">
	<div id="wph-cc-shortcode--{{optin_id}}" class="wph-cc-shortcode wph-cc-shortcode--{{style}} wph-cc-shortcode--{{optin_id}}">
		<div class='wph-cc-shortcode--content<# if(image && style === "simple" ){ #> wph-cc-shortcode--image_{{image_position}}<# } #><# if( !optin_title && !subtitle && style !== "simple" ){ #> wph-cc-shortcode--noheader<# } #><# if( (!cta_label || !cta_url) && style === "minimal" ) { #> wph-cc-shortcode--nofooter<# } #>'>

			<# if ( image && style === "simple" ){ #>

				<figure class='wph-cc-shortcode--image{{_.class( _.isTrue( hide_image_on_mobile ), " mobile-hidden" )}}<# if( ( !cta_label || !cta_url ) && !optin_message && !optin_title && !subtitle && style === "simple" ) { #>_full<# } #>'>

					<img src="{{image}}">

				</figure>

			<# } #>

			<# if ( style === "simple" ){ #>

				<div class='wph-cc-shortcode--wrap{{_.class( !optin_title && !subtitle && !optin_message && ( !cta_label || !cta_url ) && style === "simple", " hidden" )}}'>

			<# } #>

				<# if( optin_title || subtitle ){ #>

					<header<# if ( ( !cta_label || !cta_url ) && !optin_message && style === "simple"){ #> class="wph-cc-shortcode--nocontent"<# } #>>

						<# if(optin_title){ #>

							<h2 class="wph-cc-shortcode--title">{{optin_title}}</h2>

						<# } #>

						<# if( subtitle ){ #>

							<h4 class="wph-cc-shortcode--subtitle">{{subtitle}}</h4>

						<# } #>

					</header>

				<# } #>

				<# if ( ( ( image || optin_message || ( cta_label && cta_url ) ) && style === "cabriolet" ) || ( ( image || optin_message ) && style === "minimal" ) || ( ( optin_message || ( cta_label && cta_url ) ) && style === "simple" ) ){ #>

					<section<# if(image && style !== "simple" ) { #> class="wph-cc-shortcode--image_{{image_position}}"<# } #>>

						<# if ( image && style !== "simple" ){ #>

							<figure class='wph-cc-shortcode--image{{_.class( _.isTrue( hide_image_on_mobile ), " mobile-hidden" )}}<# if ( (!optin_message && style === "minimal") ) { #>_full<# } #><# if( (!cta_label || !cta_url) && !optin_message && style === "cabriolet" ) { #>_full<# } #>'>

								<img src="{{image}}">

							</figure>

						<# } #>

						<div class='wph-cc-shortcode--message<# if ( ( !optin_message && style === "minimal" ) || ( !optin_message && ( !cta_label || !cta_url ) && style !== "minimal" ) ){ #> hidden<# } #>'>

							<# if ( optin_provider === "custom_content" ){ #>

								{{{content}}}

							<# } else { #>

								{{{optin_message}}}

							<# } #>

							<# if ( ( ( cta_label && cta_url ) ) && style !== "minimal" ){ #>

								<div class="wph-cc-shortcode--clear">

									<# if ( cta_label && cta_url ){ #>

										<a href="{{cta_url}}" target="{{cta_target}}" class="wph-cc-shortcode--cta">{{cta_label}}</a>

									<# } #>

								</div>

							<# } #>

						</div>

					</section>

				<# } #>

			<# if ( style === "simple" ){ #>

				</div>

			<# } #>

			<# if ( ( (cta_label && cta_url) ) && style === "minimal" ) { #>

				<footer>

					<# if ( cta_label && cta_url ){ #>

						<a href="{{cta_url}}" target="{{cta_target}}" class="wph-cc-shortcode--cta">{{cta_label}}</a>

					<# } #>

				</footer><?php //FOR MINIMAL STYLE ONLY || available only if user added some data to call-to-action button section  ?>

			<# } #>

		</div>
	</div>

</script>