<div class="sui-dialog" tabindex="-1" id="<?php echo esc_attr( $dialog_id ); ?>" aria-hidden="true">
	<div class="sui-dialog-overlay sui-fade-out" data-a11y-dialog-hide="">
	</div>
	<div class="sui-dialog-content sui-bounce-out" aria-labelledby="dialogTitle" aria-describedby="dialogDescription" role="dialog">
		<div class="sui-box" role="document">
			<div class="sui-box-header sui-block-content-center">
				<h3 class="sui-box-title"><?php esc_html_e( 'Edit Color Scheme', 'ub' ); ?></h3>
				<div class="sui-actions-right">
					<button data-a11y-dialog-hide="" type="button" class="sui-dialog-close branda-color-schemes-edit-cancel" aria-label=""></button>
				</div>
			</div>
			<div class="sui-box-body">
				<div class="sui-form-field branda-border-bottom">
					<label for="branda-color-scheme-name" class="sui-settings-label"><?php esc_attr_e( 'Name', 'ub' ); ?></label>
					<span class="sui-description"><?php esc_html_e( 'Choose a name for this custom color scheme.', 'ub' ); ?></span>
					<input id="branda-color-scheme-name" type="text" name="branda[scheme_name]" class="sui-form-control" required="required" value="<?php echo esc_attr( $scheme_name ); ?>" />
					<span class="hidden"><?php esc_html_e( 'Scheme name can not be empty!', 'ub' ); ?></span>
				</div>
				<div class="sui-form-field branda-accordion-below">
					<label class="sui-settings-label"><?php esc_attr_e( 'Colors', 'ub' ); ?></label>
					<span class="sui-description"><?php esc_html_e( 'Adjust the default colour combinations as per your need.', 'ub' ); ?></span>
				</div>
				<div class="sui-accordion ">
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'General', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
                                        <label class="sui-label"><?php esc_html_e( 'Background', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $general_background,
		'name' => 'branda[general_background]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Links', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Static', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Default link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_default,
		'name' => 'branda[links_static_default]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Delete / Trash / Spam link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $links_static_delete ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_delete ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[links_static_delete]" value="<?php echo esc_attr( $links_static_delete ); ?>" data-attribute="<?php echo esc_attr( $links_static_delete ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Inactive plugin link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $links_static_inactive ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_inactive ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[links_static_inactive]" value="<?php echo esc_attr( $links_static_inactive ); ?>" data-attribute="<?php echo esc_attr( $links_static_inactive ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Default link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $links_static_default_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_default_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[links_static_default_hover]" value="<?php echo esc_attr( $links_static_default_hover ); ?>" data-attribute="<?php echo esc_attr( $links_static_default_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Delete / Trash / Spam link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $links_static_delete_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_delete_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[links_static_delete_hover]" value="<?php echo esc_attr( $links_static_delete_hover ); ?>" data-attribute="<?php echo esc_attr( $links_static_delete_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Inactive plugin link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $links_static_inactive_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_inactive_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[links_static_inactive_hover]" value="<?php echo esc_attr( $links_static_inactive_hover ); ?>" data-attribute="<?php echo esc_attr( $links_static_inactive_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Forms', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Checkbox / Radio Button￼', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $form_checkbox ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $form_checkbox ); ?>" readonly="readonly" />
													<button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[form_checkbox]" value="<?php echo esc_attr( $form_checkbox ); ?>" data-attribute="<?php echo esc_attr( $form_checkbox ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Core UI', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Static', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_background]" value="<?php echo esc_attr( $core_ui_primary_button_background ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button Text', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_color]" value="<?php echo esc_attr( $core_ui_primary_button_color ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button Text Shadow', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_shadow_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_shadow_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_shadow_color]" value="<?php echo esc_attr( $core_ui_primary_button_shadow_color ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_shadow_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Disabled Button', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_disabled_button_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_disabled_button_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_disabled_button_background]" value="<?php echo esc_attr( $core_ui_disabled_button_background ); ?>" data-attribute="<?php echo esc_attr( $core_ui_disabled_button_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Disabled Button Text', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_disabled_button_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_disabled_button_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_disabled_button_color]" value="<?php echo esc_attr( $core_ui_disabled_button_color ); ?>" data-attribute="<?php echo esc_attr( $core_ui_disabled_button_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_background_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_background_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_background_hover]" value="<?php echo esc_attr( $core_ui_primary_button_background_hover ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_background_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button Text', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_color_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_color_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_color_hover]" value="<?php echo esc_attr( $core_ui_primary_button_color_hover ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_color_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primary Button Text Shadow', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $core_ui_primary_button_shadow_color_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $core_ui_primary_button_shadow_color_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[core_ui_primary_button_shadow_color_hover]" value="<?php echo esc_attr( $core_ui_primary_button_shadow_color_hover ); ?>" data-attribute="<?php echo esc_attr( $core_ui_primary_button_shadow_color_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'List Tables', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Static', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'View Switch Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_switch_icon ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_switch_icon ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_switch_icon]" value="<?php echo esc_attr( $list_tables_switch_icon ); ?>" data-attribute="<?php echo esc_attr( $list_tables_switch_icon ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Post Comment Count', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_post_comment_count ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_post_comment_count ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_post_comment_count]" value="<?php echo esc_attr( $list_tables_post_comment_count ); ?>" data-attribute="<?php echo esc_attr( $list_tables_post_comment_count ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Alternate Row', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_alternate_row ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_alternate_row ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_alternate_row]" value="<?php echo esc_attr( $list_tables_alternate_row ); ?>" data-attribute="<?php echo esc_attr( $list_tables_alternate_row ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'View Switch Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_switch_icon_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_switch_icon_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_switch_icon_hover]" value="<?php echo esc_attr( $list_tables_switch_icon_hover ); ?>" data-attribute="<?php echo esc_attr( $list_tables_switch_icon_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Post Comment Count', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_post_comment_count_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_post_comment_count_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_post_comment_count_hover]" value="<?php echo esc_attr( $list_tables_post_comment_count_hover ); ?>" data-attribute="<?php echo esc_attr( $list_tables_post_comment_count_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Pagination / Button / Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $list_tables_pagination_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $list_tables_pagination_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[list_tables_pagination_hover]" value="<?php echo esc_attr( $list_tables_pagination_hover ); ?>" data-attribute="<?php echo esc_attr( $list_tables_pagination_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Admin Menu', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Static', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Current', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Current Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_color]" value="<?php echo esc_attr( $admin_menu_color ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_background]" value="<?php echo esc_attr( $admin_menu_background ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_icon_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_icon_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_icon_color]" value="<?php echo esc_attr( $admin_menu_icon_color ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_icon_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_submenu_link ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_submenu_link ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_submenu_link]" value="<?php echo esc_attr( $admin_menu_submenu_link ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_submenu_link ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Link Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_submenu_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_submenu_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_submenu_background]" value="<?php echo esc_attr( $admin_menu_submenu_background ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_submenu_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Bubble', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_bubble_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_bubble_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_bubble_color]" value="<?php echo esc_attr( $admin_menu_bubble_color ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_bubble_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Bubble Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_bubble_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_bubble_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_bubble_background]" value="<?php echo esc_attr( $admin_menu_bubble_background ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_bubble_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_color_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_color_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_color_hover]" value="<?php echo esc_attr( $admin_menu_color_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_color_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_background_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_background_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_background_hover]" value="<?php echo esc_attr( $admin_menu_background_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_background_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_submenu_link_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_submenu_link_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_submenu_link_hover]" value="<?php echo esc_attr( $admin_menu_submenu_link_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_submenu_link_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_color_current ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_color_current ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_color_current]" value="<?php echo esc_attr( $admin_menu_color_current ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_color_current ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_background_curent ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $links_static_default ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_background_curent]" value="<?php echo esc_attr( $links_static_default ); ?>" data-attribute="<?php echo esc_attr( $links_static_default ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_icon_color_current ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_icon_color_current ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_icon_color_current]" value="<?php echo esc_attr( $admin_menu_icon_color_current ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_icon_color_current ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_menu_color_current_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_menu_color_current_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_menu_color_current_hover]" value="<?php echo esc_attr( $admin_menu_color_current_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_menu_color_current_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Admin Bar', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Static', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Focus', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_background ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_background ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_background]" value="<?php echo esc_attr( $admin_bar_background ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Color', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_color]" value="<?php echo esc_attr( $admin_bar_color ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Icon', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_icon_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_icon_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_icon_color]" value="<?php echo esc_attr( $admin_bar_icon_color ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_icon_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Icon and Links', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_submenu_icon_color ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_submenu_icon_color ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_submenu_icon_color]" value="<?php echo esc_attr( $admin_bar_submenu_icon_color ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_submenu_icon_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Item Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_item_background_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_item_background_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_item_background_hover]" value="<?php echo esc_attr( $admin_bar_item_background_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_item_background_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Item Color', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_item_color_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_item_color_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_item_color_hover]" value="<?php echo esc_attr( $admin_bar_item_color_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_item_color_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Icon and Links', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_submenu_icon_color_hover ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_submenu_icon_color_hover ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_submenu_icon_color_hover]" value="<?php echo esc_attr( $admin_bar_submenu_icon_color_hover ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_submenu_icon_color_hover ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Item Background', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_item_background_focus ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_item_background_focus ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_item_background_focus]" value="<?php echo esc_attr( $admin_bar_item_background_focus ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_item_background_focus ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Item Color', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_item_color_focus ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_item_color_focus ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_item_color_focus]" value="<?php echo esc_attr( $admin_bar_item_color_focus ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_item_color_focus ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Submenu Icon and Links', 'ub' ); ?></label>
													<div class="sui-colorpicker-wrap">
														<div class="sui-colorpicker" aria-hidden="true">
															<div class="sui-colorpicker-value">
																<span role="button">
																	<span style="background-color: <?php echo esc_attr( $admin_bar_submenu_icon_color_focus ); ?>;"></span>
																</span>
																<input type="text" value="<?php echo esc_attr( $admin_bar_submenu_icon_color_focus ); ?>" readonly="readonly" />
																<button><i class="sui-icon-close" aria-hidden="true"></i></button>
															</div>
															<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
														</div>
														<input type="text" name="branda[admin_bar_submenu_icon_color_focus]" value="<?php echo esc_attr( $admin_bar_submenu_icon_color_focus ); ?>" data-attribute="<?php echo esc_attr( $admin_bar_submenu_icon_color_focus ); ?>" class="sui-colorpicker-input" data-alpha="true" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Media Uploader', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Progress Bar￼', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_media_progress_bar_color ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_media_progress_bar_color ); ?>" readonly="readonly" />
													<button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_media_progress_bar_color]" value="<?php echo esc_attr( $admin_media_progress_bar_color ); ?>" data-attribute="<?php echo esc_attr( $admin_media_progress_bar_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Selected Attachment￼', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_media_selected_attachment_color ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_media_selected_attachment_color ); ?>" readonly="readonly" />
													<button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_media_selected_attachment_color]" value="<?php echo esc_attr( $admin_media_selected_attachment_color ); ?>" data-attribute="<?php echo esc_attr( $admin_media_selected_attachment_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Themes', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Active Theme Background', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_themes_background ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_themes_background ); ?>" readonly="readonly" />
													<button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_themes_background]" value="<?php echo esc_attr( $admin_themes_background ); ?>" data-attribute="<?php echo esc_attr( $admin_themes_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Active Theme Actions Background', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_themes_actions_background ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_themes_actions_background ); ?>" readonly="readonly" /> <button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_themes_actions_background]" value="<?php echo esc_attr( $admin_themes_actions_background ); ?>" data-attribute="<?php echo esc_attr( $admin_themes_actions_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Theme Details Button Background', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_themes_details_background ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_themes_details_background ); ?>" readonly="readonly" /> <button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_themes_details_background]" value="<?php echo esc_attr( $admin_themes_details_background ); ?>" data-attribute="<?php echo esc_attr( $admin_themes_details_background ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Plugins', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Open item', 'ub' );?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Progress Bar￼', 'ub' ); ?></label>
										<div class="sui-colorpicker-wrap">
											<div class="sui-colorpicker" aria-hidden="true">
												<div class="sui-colorpicker-value">
													<span role="button">
														<span style="background-color: <?php echo esc_attr( $admin_plugins_border_color ); ?>;"></span>
													</span>
													<input type="text" value="<?php echo esc_attr( $admin_plugins_border_color ); ?>" readonly="readonly" /> <button><i class="sui-icon-close" aria-hidden="true"></i></button>
												</div>
												<button class="sui-button"><?php esc_html_e( 'Select', 'ub' ); ?></button>
											</div>
											<input type="text" name="branda[admin_plugins_border_color]" value="<?php echo esc_attr( $admin_plugins_border_color ); ?>" data-attribute="<?php echo esc_attr( $admin_plugins_border_color ); ?>" class="sui-colorpicker-input" data-alpha="true" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost <?php echo esc_attr( $button_reset_class ); ?>" data-nonce="<?php echo esc_attr( $button_reset_nonce ); ?>" type="button">
					<i class="sui-icon-refresh" aria-hidden="true"></i>
					<?php esc_html_e( 'Reset', 'ub' ); ?>
				</button>
				<button class="sui-button <?php echo esc_attr( $button_apply_class ); ?>" data-nonce="<?php echo esc_attr( $button_apply_nonce ); ?>" type="button">
					<i class="sui-icon-check" aria-hidden="true"></i>
					<?php esc_html_e( 'Apply', 'ub' ); ?>
				</button>
			</div>
		</div>
	</div>
</div>