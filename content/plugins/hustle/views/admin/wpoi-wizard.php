<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>

<div class="hustle-two" id="hust-optin-wizar">

	<div id="container" class="wrap">

		<header id="header">

			<h1><?php $is_edit ? _e('Opt-ins', Opt_In::TEXT_DOMAIN) : _e('Opt-ins', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section id="wpoi-wizard">

			<div class="row">

				<section class="col-full">

					<div class="dev-box content-box">

						<div class="box-title">

							<h3><?php $is_edit ? _e('Edit Your Opt-in', Opt_In::TEXT_DOMAIN) : _e('Create New Opt-in', Opt_In::TEXT_DOMAIN); ?></h3>

						</div>

						<div class="box-content">

							<div id="wpoi-wizard-services" class="wph-toggletabs <?php echo ( !isset($_GET['tab']) || empty($_GET['tab']) ) ? 'wph-toggletabs--open' : ''; ?>"></div>

							<?php $this->render("admin/wpoi-wizard-services", array(
									"is_edit" => $is_edit,
									'providers' => $providers,
									'optin' => $optin,
									'animations' => $animations,
									'selected_provider' => $selected_provider,
									"save_nonce" => $save_nonce
							)); ?>

							<div id="wpoi-wizard-design" class="wph-toggletabs <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'design' ) ? 'wph-toggletabs--open' : 'wph-toggletabs--closed'; ?>"></div>

							<?php $this->render("admin/wpoi-wizard-design", array(
									"is_edit" => $is_edit,
									'providers' => $providers,
									'optin' => $optin,
									'animations' => $animations,
									"save_nonce" => $save_nonce
							)); ?>

							<div id="wpoi-wizard-settings" class="wph-toggletabs <?php echo ( isset($_GET['tab']) && $_GET['tab'] == 'display' ) ? 'wph-toggletabs--open' : 'wph-toggletabs--closed'; ?>"></div>
							<?php $this->render("admin/wpoi-wizard-settings",  array(
									"is_edit" => $is_edit,
									'providers' => $providers,
									'optin' => $optin,
									'animations' => $animations,
									"widgets_page_url" => $widgets_page_url,
									"save_nonce" => $save_nonce
							)); ?>

						</div>

					</div>

				</section>

			</div>

		</section>

	</div>

	<?php $this->render("admin/optins/optins-preview-container"); ?>
	<?php $this->render("general/layouts"); ?>

</div>

<!-- ================================
	 ======= The Color Picker =======
	 ================================ -->

<script id="optin-color-pickers" type="text/template">

	<div class="wph-flex--box wph-margin--none">

		<h4><?php _e("Basic", Opt_In::TEXT_DOMAIN ); ?></h4>

		<div class="wph-flex wph-flex--row wph-margin--20b">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Main Background", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 16;">

					<div class="wph-pickers--color">

						<input id="optin_main_background" class="optin_color_picker" type="text"  value="{{colors.main_background}}" data-attribute="colors.main_background" />

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Title Color", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single"style="z-index: 16;">

					<div class="wph-pickers--color">

						<input id="optin_title_color" class="optin_color_picker" type="text" value="{{colors.title_color}}" data-attribute="colors.title_color">

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Content Color", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 16;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_content_color"  value="{{colors.content_color}}" data-attribute="colors.content_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

		</div>

		<div class="wph-flex wph-flex--row">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Link Color", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 15;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_link_color"  value="{{colors.link_color}}" data-attribute="colors.link_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id="optin_link_hover_color"  value="{{colors.link_hover_color}}"  data-attribute="colors.link_hover_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Form Area Background", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 15;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_form_background"  value="{{colors.form_background}}" data-attribute="colors.form_background" class="optin_color_picker"/>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">&nbsp;</div>

		</div>

	</div><!-- Basic Colors -->

	<div class="wph-flex--box wph-margin--none">

		<h4><?php _e('Opt-in Form', Opt_In::TEXT_DOMAIN); ?></h4>

		<div class="wph-flex wph-flex--row wph-margin--20b">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Input field background", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 14;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_fields_background"  value="{{colors.fields_background}}" data-attribute="colors.fields_background" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value=""  data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Submit button", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 14;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_button_background"  value="{{colors.button_background}}" data-attribute="colors.button_background" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id="optin_button_hover_background"  value="{{colors.button_hover_background}}" data-attribute="colors.button_hover_background" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Submit text", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 14;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_button_label"  value="{{colors.button_label}}" data-attribute="colors.button_label" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id="optin_button_hover_label"  value="{{colors.button_hover_label}}" data-attribute="colors.button_hover_label" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

		</div>

		<div class="wph-flex wph-flex--row wph-margin--20b">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Placeholder", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 13;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_label_color"  value="{{colors.label_color}}" data-attribute="colors.label_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Form field text", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 13;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_fields_color"  value="{{colors.fields_color}}" data-attribute="colors.fields_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Error text", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 13;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_error_color"  value="{{colors.error_color}}" data-attribute="colors.error_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

		</div>

		<div class="wph-flex wph-flex--row wph-margin--20b">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Checkbox / Radio Button", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 12;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_checkbox_background"  value="{{colors.checkbox_background}}" data-attribute="colors.checkbox_background" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Checkbox / Radio Tick", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers" style="z-index: 12;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_checkbox_checked_color"  value="{{colors.checkbox_checked_color}}" data-attribute="colors.checkbox_checked_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Mailchimp Groups Title", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 12;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_mcg_title_color"  value="{{colors.mcg_title_color}}" data-attribute="colors.mcg_title_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

		</div>

		<div class="wph-flex wph-flex--row">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Mailchimp Groups Label", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 12;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_mcg_label_color"  value="{{colors.mcg_label_color}}" data-attribute="colors.mcg_label_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

		</div>

	</div><!-- Opt-in Form Colors -->

	<div class="wph-flex--box">

		<h4><?php _e('Additional Styles', Opt_In::TEXT_DOMAIN); ?></h4>

		<div class="wph-flex wph-flex--row wph-margin--20b">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Success Message Tick", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 11;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_checkmark_color"  value="{{colors.checkmark_color}}" data-attribute="colors.checkmark_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Success Message Content", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 11;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_success_color"  value="{{colors.success_color}}"  data-attribute="colors.success_color" class="optin_color_picker"/>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Pop Up Overlay", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers wph-pickers--single" style="z-index: 11;">

					<div class="wph-pickers--color">

						<input type="text" id="optin_overlay_background"  value="{{colors.overlay_background}}" data-attribute="colors.overlay_background" class="optin_color_picker"/>

					</div>

				</div>

			</div>

		</div>

		<div class="wph-flex wph-flex--row">

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Close (x) button color", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers">

					<div class="wph-pickers--color">

						<input type="text" id="optin_close_color"  value="{{colors.close_color}}" data-attribute="colors.close_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id="optin_close_hover_color"  value="{{colors.close_hover_color}}" data-attribute="colors.close_hover_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt"><?php _e( "Never see again text", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wph-pickers">

					<div class="wph-pickers--color">

						<input type="text" id="optin_nsa_color"  value="{{colors.nsa_color}}" data-attribute="colors.nsa_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Static State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id="optin_nsa_hover_color"  value="{{colors.nsa_hover_color}}" data-attribute="colors.nsa_hover_color" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Hover State Color"></span>

					</div>

					<div class="wph-pickers--color">

						<input type="text" id=""  value="" data-attribute="" class="optin_color_picker"/>

						<span class="wph-pickers--tip" tooltip="Active State Color"></span>

					</div>

				</div>

			</div>

			<div class="wph-flex--box">&nbsp;</div>

		</div>

	</div><!-- Additional Styles -->

</script>

<script id="optin-palette-option-dropdown" type="text/template">
    <div class="optin_palette_option" id="{{id}}">
        <span class="main_background" style="background: {{main_background}}"></span>
        <span class="title_color" style="background: {{title_color}}"></span>
        <span class="link_color" style="background: {{link_color}}"></span>
        <span class="content_color" style="background: {{content_color}}"></span>
        <span class="link_hover_color" style="background: {{link_hover_color}}"></span>
        <span class="form_background" style="background: {{form_background}}"></span>
        <span class="fields_background" style="background: {{fields_background}}"></span>
        <span class="label_color" style="background: {{label_color}}"></span>
        <span class="button_background" style="background: {{button_background}}"></span>
        <span class="button_label" style="background: {{button_label}}"></span>
        <span class="fields_color" style="background: {{fields_color}}"></span>
        <span class="error_color" style="background: {{error_color}}"></span>
        <span class="button_hover_background" style="background: {{button_hover_background}}"></span>
        <span class="button_hover_label" style="background: {{button_hover_label}}"></span>
        <span class="checkmark_color" style="background: {{checkmark_color}}"></span>
        <span class="success_color" style="background: {{success_color}}"></span>
        <span class="close_color" style="background: {{close_color}}"></span>
        <span class="nsa_color" style="background: {{nsa_color}}"></span>
        <span class="overlay_background" style="background: {{overlay_background}}"></span>
        <span class="close_hover_color" style="background: {{close_hover_color}}"></span>
        <span class="nsa_hover_color" style="background: {{nsa_hover_color}}"></span>
        <span class="radio_background" style="background: {{radio_background}}"></span>
        <span class="radio_checked_background" style="background: {{radio_checked_background}}"></span>
        <span class="checkbox_background" style="background: {{checkbox_background}}"></span>
        <span class="checkbox_checked_background" style="background: {{checkbox_checked_background}}"></span>
        <span class="mcg_title_color" style="background: {{mcg_title_color}}"></span>
        <span class="mcg_label_color" style="background: {{mcg_label_color}}"></span>
        <span class="palette_name">{{text}}</span>
    </div>
</script>

<?php $this->render("admin/settings/conditions"); ?>
<?php $this->render("admin/common/media-holder"); ?>