<div class="box-content <?php echo ( ! wphb_is_member() ) ? 'disabled' : ''; ?>">
	<form method="post" class="scan-frm scan-settings">
		<div class="row">
			<div class="col-third">
				<strong><?php _e( "Schedule Scans", 'wphb' ) ?></strong>
				<span class="sub">
                    <?php _e( "Configure Hummingbird to automatically and regularly test your website and email you reports.", 'wphb' ) ?>
                </span>
			</div><!-- end col-third -->
			<div class="col-two-third">
                <span class="toggle">
                    <input type="hidden" name="email-notifications" value="0"/>
                    <input type="checkbox" class="toggle-checkbox" name="email-notifications" value="1"
                           id="chk1" <?php checked( 1, $notification ); ?> <?php disabled( ! wphb_is_member() ); ?>/>
                    <label class="toggle-label" for="chk1"></label>
                </span>
				<label><?php _e( "Run regular scans & reports", 'wphb' ) ?></label>
				<div class="clear mline"></div>
				<div class="wphb-border-frame with-padding schedule-box">
					<strong><?php _e( "Schedule", 'wphb' ) ?></strong>
					<label><?php _e( "Frequency", 'wphb' ) ?></label>
					<select name="email-frequency" <?php disabled( ! wphb_is_member() ); ?>>
						<option <?php selected( 1, $frequency ) ?>
							value="1"><?php _e( "Daily", 'wphb' ) ?></option>
						<option <?php selected( 7, $frequency ) ?>
							value="7"><?php _e( "Weekly", 'wphb' ) ?></option>
						<option <?php selected( 30, $frequency ) ?>
							value="30"><?php _e( "Monthly", 'wphb' ) ?></option>
					</select>
					<div class="days-container">
						<label><?php _e( "Day of the week", 'wphb' ) ?></label>
						<select name="email-day" <?php disabled( ! wphb_is_member() ); ?>>
							<?php foreach ( wphb_get_days_of_week() as $day ): ?>
								<option <?php selected( $day, $send_day ) ?>
									value="<?php echo $day ?>"><?php echo ucfirst( $day ) ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<label><?php _e( "Time of day", 'wphb' ) ?></label>
					<select name="email-time" <?php disabled( ! wphb_is_member() ); ?>>
						<?php foreach ( wphb_get_times() as $time ): ?>
							<option <?php selected( $time, $send_time ) ?>
								value="<?php echo $time ?>"><?php echo strftime( '%I:%M %p', strtotime( $time ) ) ?></option>
						<?php endforeach;; ?>
					</select>
				</div><!-- end well -->
			</div><!-- end col-two-third -->
		</div><!-- end row -->

		<div class="row">
			<div class="col-third">
				<strong><?php _e( "Email Recipients", 'wphb' ) ?></strong>
				<span class="sub">
                    <?php _e( "Choose which of your website’s users will receive the test results in their inbox.", 'wphb' ) ?>
                </span>
			</div><!-- end col-third -->
			<div class="col-two-third">
				<div class="receipt">
					<ul>
						<?php foreach ( $recipients as $id ): ?>
                            <?php $user = get_user_by( 'id', $id ) ?>
							<?php if ( is_object( $user ) ): ?>
                                <input type="hidden" id="scan_recipient" name="email-recipients[]" value="<?php echo $id; ?>">
								<li><?php echo get_avatar( $user->ID, 30 ) ?>
									<?php if ( ! empty( $user->user_nicename ) ) {
										$display_name = $user->user_nicename;
									} else {
										$display_name = $user->user_firstname . ' ' . $user->user_lastname;
									} ?>
									<span class="name"><?php echo esc_html( $display_name ) ?></span>
									<?php if ( get_current_user_id() == $user->ID ): ?>
										<span class="wphb-tag tag-generic"><?php esc_html_e( "You", 'wphb' ) ?></span>
									<?php endif; ?>
									<a data-id="<?php echo esc_attr( $user->ID ) ?>"
									   class="remove wphb-remove-recipient float-r <?php echo ( ! wphb_is_member() ) ? 'disabled' : ''; ?>"
									   href="#"><?php esc_html_e( "Remove", 'wphb' ) ?></a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<div>
                        <span><input data-empty-msg="<?php _e( 'Empty username', 'wphb' ); ?>"
                         placeholder="<?php _e( "Enter a username", 'wphb' ); ?>" name="term"
                         id="wphb-username-search"
                         type="search" <?php disabled( ! wphb_is_member() ); ?>/></span>
						<button type="submit" disabled id="add-receipt"
						        class="button button-notice button-large <?php echo ( ! wphb_is_member() ) ? 'disabled' : ''; ?>"><?php _e( "Add", 'wphb' ) ?></button>
					</div>
				</div><!-- end receipt -->
			</div><!-- end col-two-third -->
		</div><!-- end row -->

		<?php if ( wphb_is_member() ): ?>
            <div class="clear line"></div>
            <div class="buttons alignright">
                <button class="button button-large"><?php _e( "Update Settings", 'wphb' ) ?></button>
            </div>
            <div class="clear"></div>
        <?php endif; ?>
	</form>
</div>