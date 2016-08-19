<?php

/** @var WP_Hummingbird_Module_Cloudflare $cf_module */
$cf_module = wphb_get_module( 'cloudflare' );
$current_step = 'credentials';
$zones = array();
if ( $cf_module->is_zone_selected() && $cf_module->is_connected() ) {
	$current_step = 'final';
}
elseif ( ! $cf_module->is_zone_selected() && $cf_module->is_connected() ) {
	$current_step = 'zone';
	$zones = $cf_module->get_zones_list();
	if ( is_wp_error( $zones ) ) {
		$zones = array();
	}
}


$cloudflare_js_settings = array(
	'currentStep' => $current_step,
	'email' => wphb_get_setting( 'cloudflare-email' ),
	'apiKey' => wphb_get_setting( 'cloudflare-api-key' ),
	'zone' => wphb_get_setting( 'cloudflare-zone' ),
	'zoneName' => wphb_get_setting( 'cloudflare-zone-name' ),
	'plan' => $cf_module->get_plan(),
	'zones' => $zones
);

$cloudflare_js_settings = wp_json_encode( $cloudflare_js_settings );
?>

<script type="text/template" id="cloudflare-step-credentials">
	<div class="cloudflare-step">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-cloudflare-small.png'; ?>" alt="<?php _e('Minification', 'wphb'); ?>">

		<p><?php _e( 'Hummingbird can control your CloudFlare Browser Cache settings from here. Simply add your CloudFlare API details and configure away.', 'wphb' ); ?></p>


		<form class="wphb-block-content-grey" action="" method="post" id="cloudflare-credentials">
			<label for="cloudflare-email"><?php _e( 'CloudFlare email', 'wphb' ); ?>
				<input type="text" autocomplete="off" value="<%- email %>" name="cloudflare-email" id="cloudflare-email">
			</label>

			<label for="cloudflare-api-key"><?php _e( 'CloudFlare Global API Key', 'wphb' ); ?>
				<input type="text" autocomplete="off" value="<%- apiKey %>" name="cloudflare-api-key" id="cloudflare-api-key">
			</label>

			<p class="cloudflare-submit">
				<span class="spinner cloudflare-spinner"></span>
				<input type="submit" class="button button-app button-content-cta" value="<?php echo esc_attr( _x( 'Connect', 'Connect to CloufFlare button text', 'wphb' ) ); ?>">
			</p>
			<p id="cloudflare-how-to-title"><a href="#cloudflare-how-to"><?php _e( 'Need help getting your API Key?', 'wphb' ); ?></a></p>
			<div class="clear"></div>
			<ol id="cloudflare-how-to" class="wphb-block-content-blue">
				<li><?php printf( __( '<a target="_blank" href="%s">Log in</a> to your CloudFlare account.', 'wphb' ), 'https://www.cloudflare.com/a/login' ); ?></li>
				<li><?php _e( 'Go to My Settings.', 'wphb' ); ?></li>
				<li><?php _e( 'Scroll down to API Key.', 'wphb' ); ?></li>
				<li><?php _e( "Click 'View API Key' button and copy your API identifier.", 'wphb' ); ?></li>
			</ol>
		</form>
	</div>
</script>

<script type="text/template" id="cloudflare-step-zone">
	<div class="cloudflare-step">
		<form action="" method="post" id="cloudflare-zone">
			<p>
				<label for="cloudflare-zone"><?php _e( 'Select the domain that matches this website', 'wphb' ); ?></label>
				<select name="cloudflare-zone" id="cloudflare-zone">
					<option value=""><?php _e( 'Select domain', 'wphb' ); ?></option>
					<% for ( i in zones ) { %>
						<option value="<%- zones[i].value %>"><%= zones[i].label %></option>
					<% } %>
				</select>
			<p class="cloudflare-submit">
				<span class="spinner cloudflare-spinner"></span>
				<input type="submit" class="button button-app button-content-cta" value="<?php esc_attr_e( 'Enable CloudFlare', 'wphb' ); ?>">
			</p>
			<div class="clear"></div>
		</form>
	</div>
</script>

<script type="text/template" id="cloudflare-step-final">
	<div class="cloudflare-step">
		<div class="wphb-notice wphb-notice-success">
			<p><?php _e( 'CloudFlare is connected and being controlled by Hummingbird', 'wphb' ); ?></p>
		</div>
		<p class="cloudflare-data">
			<span><strong><?php _ex( 'Zone', 'CloudFlare Zone', 'wphb' ); ?>:</strong> <%- zoneName %></span>
			<span><strong><?php _ex( 'Plan', 'CloudFlare Plan', 'wphb' ); ?>:</strong> <%- plan %></span>
		</p>
	</div>
</script>



<script>



	jQuery(document).ready( function( $ ) {
		var CloudFlare = {
			init: function( settings ) {
				this.currentStep = settings.currentStep;
				this.data = settings;
				this.email = settings.email;
				this.apiKey = settings.apiKey;
				this.$stepsContainer = $('#cloudflare-steps');
				this.$infoBox = $('#cloudflare-info');
				this.$spinner = $( '.cloudflare-spinner' );
				this.$deactivateButton = $('#wphb-box-dashboard-cloudflare .box-title .buttons');

				this.renderStep( this.currentStep );

			},

			renderStep: function( step ) {
				var template = _.template( $('#cloudflare-step-' + step).html() );
				var content = template( this.data );
				var self = this;

				if ( content ) {
					this.currentStep = step;
					this.$stepsContainer
						.hide()
						.html( template( this.data ) )
						.fadeIn()
						.find( 'form' )
						.on( 'submit', function( e ) {
							e.preventDefault();
							self.submitStep.call( self, $(this) )
						});

					this.$spinner = this.$stepsContainer.find( '.cloudflare-spinner' );
				}

				this.bindEvents();
			},

			bindEvents: function() {
				var $howToInstructions = $('#cloudflare-how-to');

				$howToInstructions.hide();

				$('#cloudflare-how-to-title > a').click( function( e ) {
					e.preventDefault();
					$howToInstructions.toggle();
				});

				this.$stepsContainer.find( 'select' ).each( function() {
					WDP.wpmuSelect( this );
				});

				if ( 'final' === this.currentStep ) {
					this.$deactivateButton.removeClass( 'hidden' );
				}
				else {
					this.$deactivateButton.addClass( 'hidden' );
				}



			},

			emptyInfoBox: function() {
				this.$infoBox.html('');
				this.$infoBox.removeClass();
			},

			showInfoBox: function( message ) {
				this.$infoBox.addClass( 'wphb-notice' );
				this.$infoBox.addClass( 'wphb-notice-error' );
				this.$infoBox.html( message );
			},

			showSpinner: function() {
				this.$spinner.css( 'visibility', 'visible' );
			},

			hideSpinner: function() {
				this.$spinner.css( 'visibility', 'hidden' );
			},

			submitStep: function( $form ) {
				var data = {
					action: 'cloudflare_connect',
					step: this.currentStep,
					formData: $form.serialize(),
					cfData: this.data
				};

				$form.find( 'input[type=submit]' ).attr( 'disabled', 'true' );


				this.emptyInfoBox();
				this.showSpinner();

				var self = this;

				$.post( ajaxurl, data, function(response) {
					if ( response.success ) {
						self.data = response.data.newData;
						self.renderStep( response.data.nextStep );
					}
					else {
						self.showInfoBox( response.data.error );
					}
				})
					.error( function( jqXHR, textStatus, errorThrown ) {
						self.showInfoBox( textStatus + ':' + errorThrown );
					})
					.always( function() {
						$form.find( 'input[type=submit]' ).removeAttr( 'disabled' );
						self.hideSpinner();
					});
			}
		};

		CloudFlare.init( <?php echo $cloudflare_js_settings; ?> );
	});
</script>

<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<div id="cloudflare-steps"></div>
		<div id="cloudflare-info"></div>


	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->

