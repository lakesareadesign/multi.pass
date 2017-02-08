<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>

<script id="wpoi-wizard-design_template" type="text/template">

	<header class="wph-toggletabs--title can-open">

		<h4><?php _e('Content & Design', Opt_In::TEXT_DOMAIN); ?></h4>

		<span class="open"><i class="wph-icon i-arrow"></i></span>

	</header><!-- .wph-toggletabs--header -->

	<section class="wph-toggletabs--content">

		<div id="wph-optin--content" class="wph-flex wph-flex--row wph-margin--40b">

			<div class="wph-flex--side wph-flex--title">

				<h5><?php _e('Content', Opt_In::TEXT_DOMAIN); ?></h5>

				<button class="wph-preview--eye wph-button"><i class="wph-icon i-eye"></i></button>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt wph-label--border"><?php _e('Compose content for your Opt-in', Opt_In::TEXT_DOMAIN); ?></label>

				<div class="wph-flex wph-flex--row wph-sticky--base">

					<div class="wph-flex--box">

						<label class="wph-label--alt"><?php _e('Heading (Optional):', Opt_In::TEXT_DOMAIN); ?></label>

						<input  id="optin_title" value="{{optin_title}}" type="text" placeholder="<?php esc_attr_e("eg. Get 50% Early-bird Special", Opt_In::TEXT_DOMAIN); ?>" data-attribute="optin_title">

						<div class="wpoi-box-content-block">

							<div class="wpoi-wysiwyg-wrap">

								<input type="radio" id="wpoi-om" class="wysiwyg-tab" name="wysiwyg_editor" checked>
								<label for="wpoi-om"><?php _e('Opt-In Message', Opt_In::TEXT_DOMAIN); ?></label>

								<input type="radio" id="wpoi-sm" class="wysiwyg-tab" name="wysiwyg_editor" data-attribute="on_submit" value="success_message">
								<# if( on_submit === "success_message" ) {  #>
									<label for="wpoi-sm"><?php _e('Success Message', Opt_In::TEXT_DOMAIN); ?></label>
								<# } #>
								<div class="wysiwyg-tab__content">

									<?php wp_editor("{{optin_message}}", "optin_message", array(
											'textarea_name' => 'optin_message',
											'textarea_rows' => 9,
											'media_buttons' => false,
											'teeny' => true,
											'tinymce' => array(
												'height' => 250,
											),
									)); ?>

								</div>
								<# if( on_submit === "success_message" ) {  #>
									<div class="wysiwyg-tab__content">

										<?php wp_editor("{{success_message}}", "success_message", array(
												'textarea_name' => 'success_message',
												'textarea_rows' => 9,
												'media_buttons' => false,
												'teeny' => true,
												'tinymce' => array(
													'height' => 250,
												),
										)); ?>

										<p class="description"><?php printf( __('You can use %s to add optin name to the success message', Opt_In::TEXT_DOMAIN), '{name}' ); ?></p>

									</div>
								<# } #>
							</div>

						</div>

					</div>

					<div class="wph-flex--side">

						<label class="wph-label--alt"><?php _e('Opt-In Image:', Opt_In::TEXT_DOMAIN); ?></label>

						<div class="wpoi-select-media wph-media--holder"></div>

						<div id="optin_image_style">

							<div class="wph-triggers wph-triggers--options">

			                    <ul class="wph-triggers--tabs wph-triggers--nomargin">

				                    <li {{_.add_class(image_style === 'contain', 'current')}}>

			                        <label for="optin-image-style-contain">

			                            <?php _e( "Fit image", Opt_In::TEXT_DOMAIN ); ?>

			                            <input type="radio" id="optin-image-style-contain" name="optin-image-style" value="contain" data-attribute="image_style" {{_.checked(image_style, "contain")}}>

			                        </label>

			                        </li>

			                        <li {{_.add_class( image_style === 'cover', 'current' )}}>

			                        <label for="optin-image-style-cover">

			                            <?php _e( "Fill image", Opt_In::TEXT_DOMAIN ); ?>

			                            <input type="radio" id="optin-image-style-cover" name="optin-image-style" value="cover" data-attribute="image_style" {{_.checked(image_style, "cover")}}  >

			                        </label>

			                        </li>

			                    </ul>

			                </div>

						</div>

					</div>

				</div>

			</div>

		</div><!-- #wph-optin--content -->

		<div id="wph-optin--structure" class="wph-flex wph-flex--row wph-margin--40b"></div>

		<div id="wph-optin--colors" class="wph-flex wph-flex--row wph-margin--40b">

			<div class="wph-flex--side wph-flex--title">

				<h5><?php _e('Colors', Opt_In::TEXT_DOMAIN); ?></h5>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt wph-label--border"><?php _e('Pick a color palette and customize it to suit your needs', Opt_In::TEXT_DOMAIN); ?></label>

				<div class="wph-flex wph-flex--row wph-margin--20b">

					<div class="wph-flex--box">

						<select id="optin_color_palettes" class="wpmuiSelect" name="optin_color_palettes" data-attribute="colors.palette" {{_.disabled(colors.customize, true)}}>

							<# _.each( palettes, function( palette ) { #>

								<option value="{{palette._id}}" <# if(colors.palette == palette._id){ #> selected="selected" <# } #> >{{palette.label}}</option>

							<# }); #>

						</select>

					</div>

					<div class="wph-flex--box">

						<div class="wph-label--checkbox">

							<label class="wph-label--alt" for="optin_customize_color_palette"><?php _e( "Customized Colors", Opt_In::TEXT_DOMAIN ); ?></label>

							<div class="wph-input--checkbox">

								<input type="checkbox" id="optin_customize_color_palette" data-attribute="colors.customize" name="optin_customize_color_palette" {{_.checked(colors.customize, true)}} >

								<label class="wph-icon i-check" for="optin_customize_color_palette"></label>

							</div>

						</div>

					</div>

				</div>

				<div id="optwiz-custom_color" class="wph-flex wph-flex--column wph-flex--gray wph-padding--25_sides wph-padding--25_bottom wph-margin--30b {{_.class( _.isFalse( colors.customize ), 'hidden' )}}"></div>

			</div>

		</div><!-- #wph-optin--colors -->

		<div id="wph-optin--shapes" class="wph-flex wph-flex--row wph-margin--40b"></div><!-- #wph-optin--shapes -->

		<div id="wph-optin--css" class="wph-flex wph-flex--row wph-margin--40b">

			<div class="wph-flex--side wph-flex--title">

				<h5><?php _e('Custom CSS', Opt_In::TEXT_DOMAIN); ?></h5>

			</div>

			<div class="wph-flex--box">

				<label class="wph-label--alt wph-label--border"><?php _e('Use custom css for this opt-in', Opt_In::TEXT_DOMAIN); ?></label>

				<label><?php _e( "Available CSS Selectors (click to add):", Opt_In::TEXT_DOMAIN ); ?></label>

				<div class="wpoi-css-selectors wpoi-wrap cf">

					<div class="wpoi-css-selectors-wrap">

						<# _.each( stylables, function( name, stylable ) { #>
							<a href="#" class="wpoi-stylable-element" data-stylable="{{stylable}}" >{{name}}</a>
						<# }); #>

					</div>

				</div><!-- .wpoi-css-selectors -->

				<div id="optin_custom_css" name="">{{css}}</div><!-- Container: Custom CSS -->

				<div class="wpoi-css-button">

					<button class="wph-button wph-button--filled wph-button--small wph-button--gray" id="optin_apply_custom_css" data-nonce="<?php echo wp_create_nonce('inc_opt_prepare_custom_css'); ?>" ><?php _e( "Apply Custom CSS", Opt_In::TEXT_DOMAIN ); ?></button>

				</div><!-- Button: Apply Custom CSS -->

			</div>

		</div><!-- #wph-optin--css -->

	</section>

	<footer class="wph-toggletabs--footer">

		<div class="row">

			<div class="col-half previous">

				<a href="#0" class="wph-button wph-button--filled wph-button--gray js-wph-optin-back"><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></a>

			</div>

			<div class="col-half next-button">

				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-save wph-button--filled wph-button--blue"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></button>

				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-next wph-button--filled wph-button--gray"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></button>

			</div>

		</div>

	</footer><!-- .wph-toggletabs--footer -->

</script>

<?php $this->render("admin/wpoi-wizard-design-structure"); ?>
<?php $this->render("admin/wpoi-wizard-design-shapes"); ?>
<?php $this->render("admin/wpoi-wizard-design-after-submit"); ?>