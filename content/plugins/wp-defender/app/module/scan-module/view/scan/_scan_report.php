<?php
if ( $controller->has_flash( 'success' ) ): ?>
	<div class="wd-success">
		<?php echo $controller->get_flash( 'success' ) ?>
	</div>
<?php endif; ?>
	<div class="wd-error wd-hide">

	</div>
	<section class="dev-box scan-reports">
		<div class="box-title">
			<h3>
				<?php _e( "Reports", wp_defender()->domain ) ?>
				<a class="button button-grey button-small wd-pull-right"
				   href="<?php echo network_admin_url( 'admin.php?page=wdf-settings' ) ?>"><?php _e( "Configure", wp_defender()->domain ) ?></a>
			</h3>
		</div>
		<div class="box-content">
			<div class="scan-result">
				<div class="wd-well">
					<div class="group">
						<div class="col span_6_of_12 tl">
							<strong class="wd-issues-count"><?php echo count( $res ) ?></strong>
							<strong><?php _e( "Issues Found", wp_defender()->domain ); ?></strong>
						</div>
						<div class="col span_6_of_12 tr">
							<label for="wd_filter_by_type"><?php _e( "File Type", wp_defender()->domain ) ?></label>
							<select id="wd_filter_by_type">
								<option value="all"><?php _e( "All", wp_defender()->domain ) ?></option>
								<option value="<?php echo WD_Scan_Result_Model::TYPE_CORE ?>">
									<?php echo WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_CORE ) ?>
								</option>
								<option value="<?php echo WD_Scan_Result_Model::TYPE_PLUGIN ?>">
									<?php echo WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_PLUGIN ) ?>
								</option>
								<option value="<?php echo WD_Scan_Result_Model::TYPE_THEME ?>">
									<?php echo WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_THEME ) ?>
								</option>
								<option value="<?php echo WD_Scan_Result_Model::TYPE_FILE ?>">
									<?php echo WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_FILE ) ?>
								</option>
							</select>
						</div>
					</div>
				</div>
				<div id="wd-result-list">
					<div id="wd-result-list-inner">
						<?php
						if ( ! empty( $res ) ) {
							?>
							<br/>
							<table id="wd-scan-result-table" width="100%">
								<thead>
								<tr>
									<th>
										<?php _e( "Suspicious File", wp_defender()->domain ) ?>
									</th>
									<th class="issue-type">
										<?php _e( "Type", wp_defender()->domain ) ?>
									</th>
									<th>
										<?php _e( "Issue", wp_defender()->domain ) ?>
									</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ( $res as $item ): ?>
									<tr data-type="<?php echo esc_attr( $item->get_system_type() ) ?>">
										<td width="30%" class="file-path">
											<?php if ( ! $item->can_automate_resolve() ): ?>
												<strong><?php echo esc_html( $item->get_name() ) ?></strong>
											<?php else: ?>
												<a href="<?php echo network_admin_url( 'admin.php?page=wdf-issue-detail' ) ?>&id=<?php echo $item->id ?>"><?php echo esc_html( $item->get_name() ) ?></a>
											<?php endif; ?>
											<span><?php echo esc_html( $item->get_sub() ) ?></span>
										</td>
										<td width="15%"
										    class="issue-type"><?php echo esc_html( $item->get_type() ); ?></td>
										<td width="45%"
										    class="issue-detail"><?php echo wp_kses( $item->get_detail(), WD_Utils::allowed_html() ) ?></td>
										<td width="10%" class="wd-report-actions">
											<form method="post" class="wd-resolve-frm">
												<input type="hidden" name="action" value="wd_resolve_result">
												<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
												<input type="hidden" value="<?php esc_attr( get_class( $item ) ) ?>"
												       name="class">
												<input type="hidden" name="id"
												       value="<?php echo esc_attr( $item->id ) ?>"/>

												<div class="wd-button-group">
													<button data-type="clean"
													        tooltip="<?php esc_attr_e( "Resolve Issue", wp_defender()->domain ) ?>"
													        type="submit" class="button button-light button-small">
														<i class="wdv-icon wdv-icon-wrench"></i>
													</button>
													<?php if ( $item->can_ignore() ): ?>
														<button data-type="ignore"
														        tooltip="<?php esc_attr_e( "False alarm? Ignore it", wp_defender()->domain ) ?>"
														        data-confirm="<?php echo 'ignore_confirm_msg' ?>"
														        data-confirm-button="<?php echo 'ignore_confirm_btn' ?>"
														        type="submit" class="button button-light button-small">
															<i class="wdv-icon wdv-icon-fw wdv-icon-ban-circle"></i>
														</button>
													<?php endif; ?>
													<?php if ( $item->can_delete() ): ?>
														<?php
														$tooltip     = $item->delete_tooltip;
														$confirm_key = $item->delete_confirm_text; ?>
														<button data-type="delete"
														        data-confirm="<?php echo esc_attr( $confirm_key ) ?>"
														        data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
														        tooltip="<?php echo esc_attr( $tooltip ) ?>"
														        type="submit" class="button button-light button-small">
															<i class="wdv-icon wdv-icon-trash"></i>
														</button>
													<?php else: ?>
														<button data-type="delete"
														        tooltip="<?php esc_attr_e( "Delete", wp_defender()->domain ) ?>"
														        type="button" disabled
														        class="button button-light button-small">
															<i class="wdv-icon wdv-icon-trash"></i>
														</button>
													<?php endif; ?>
												</div>
											</form>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
							<?php
						} else {
							?>
							<br/>
							<div class="wd-success wd-left">
								<?php _e( "Congratulations! Everything is just fine.", wp_defender()->domain ) ?>
							</div>
							<table id="wd-scan-result-table" width="100%" class="wd-hide">
								<thead>
								<tr>
									<th>
										<?php _e( "Suspicious File", wp_defender()->domain ) ?>
									</th>
									<th class="issue-type">
										<?php _e( "Type", wp_defender()->domain ) ?>
									</th>
									<th>
										<?php _e( "Issue", wp_defender()->domain ) ?>
									</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<?php
						}
						?>
					</div>
				</div>
				<div class="wd-clearfix"></div>
			</div>
		</div>
	</section>
	<div id="wd-ignore-list" class="<?php echo empty( $ignore_list ) ? 'wd-hide' : '' ?>">
		<section class="dev-box scan-reports" id="wd-ignore-list-inner">
			<div class="scan-result">
				<div class="box-title">
					<h3>
						<?php _e( "Ignored Files", wp_defender()->domain ) ?>
					</h3>
				</div>
				<div class="box-content">
					<table id="wd-scan-result-table" width="100%">
						<thead>
						<tr>
							<th>
								<?php _e( "File", wp_defender()->domain ) ?>
							</th>
							<th class="issue-type">
								<?php _e( "Type", wp_defender()->domain ) ?>
							</th>
							<th>
								<?php _e( "Issue", wp_defender()->domain ) ?>
							</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ( $ignore_list as $item ): ?>
							<tr>
								<td width="30%" class="file-path">
									<strong><?php echo esc_html( $item->get_name() ) ?></strong>
									<span><?php echo esc_html( $item->get_sub() ) ?></span>
								</td>
								<td width="15%" class="issue-type"><?php echo esc_html( $item->get_type() ); ?></td>
								<td width="45%"><?php echo wp_kses( $item->get_detail(), WD_Utils::allowed_html() ) ?></td>
								<td width="10%" class="wd-report-actions">
									<form method="post" class="wd-resolve-frm">
										<input type="hidden" name="action" value="wd_resolve_result">
										<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
										<input type="hidden" value="<?php esc_attr( get_class( $item ) ) ?>"
										       name="class">
										<input type="hidden" name="id" value="<?php echo esc_attr( $item->id ) ?>"/>

										<div class="wd-button-group">
											<button data-type="undo"
											        tooltip="<?php esc_attr_e( "Undo", wp_defender()->domain ) ?>"
											        type="submit" class="button button-light button-small">
												<i class="wdv-icon wdv-icon-undo"></i>
											</button>
											<?php if ( $item->can_delete() ): ?>
												<?php
												$tooltip     = $item->delete_tooltip;
												$confirm_key = $item->delete_confirm_text; ?>
												<button data-type="delete"
												        data-confirm="<?php echo esc_attr( $confirm_key ) ?>"
												        data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
												        tooltip="<?php echo esc_attr( $tooltip ) ?>"
												        type="submit" class="button button-light button-small">
													<i class="wdv-icon wdv-icon-trash"></i>
												</button>
											<?php else: ?>
												<button data-type="delete"
												        tooltip="<?php esc_attr_e( "Delete", wp_defender()->domain ) ?>"
												        type="button" disabled
												        class="button button-light button-small">
													<i class="wdv-icon wdv-icon-trash"></i>
												</button>
											<?php endif; ?>
										</div>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
<?php if ( WD_Utils::get_setting( 'scan->auto_scan', false ) == false ) : ?>
	<section class="dev-box can-close automate-scan-intro">
		<div class="box-title">
			<span class="close">X</span>

			<h3><?php _e( "Automatic Scans", wp_defender()->domain ) ?></h3>
		</div>
		<div class="box-content">
			<p><?php _e( "Did you know you can run these scans automatically? You can set them to run daily, weekly or monthly and have the reports emailed to you or your client’s inboxes.", wp_defender()->domain ) ?></p>
			<a href="<?php echo network_admin_url( 'admin.php?page=wdf-schedule-scan' ) ?>"
			   class="button wd-button"><?php _e( "Setup Automatic Scans", wp_defender()->domain ) ?></a>
		</div>
	</section>
	<script type="text/javascript">
		jQuery(function ($) {
			if (readCookie('wd-hide-automate-scan') == 1) {
				$('.automate-scan-intro').hide();
			}
			$('.automate-scan-intro .close').click(function () {
				createCookie('wd-hide-automate-scan', '1', 365);
			})
			function createCookie(name, value, days) {
				if (days) {
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					var expires = "; expires=" + date.toGMTString();
				}
				else var expires = "";
				document.cookie = name + "=" + value + expires + "; path=/";
			}

			function readCookie(name) {
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for (var i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') c = c.substring(1, c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
				}
				return null;
			}

			function eraseCookie(name) {
				createCookie(name, "", -1);
			}
		})
	</script>
<?php endif; ?>