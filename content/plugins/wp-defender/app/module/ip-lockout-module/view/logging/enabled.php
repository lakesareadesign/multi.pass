<div class="dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( "LOCKOUT LOGS", wp_defender()->domain ) ?></h3>
		<div class="side float-r">
			<div>
				<span><?php esc_html_e( "Type", wp_defender()->domain ) ?></span>
				<select id="logs-filter">
					<option value=""><?php esc_html_e( "All", wp_defender()->domain ) ?></option>
					<option <?php selected( \WP_Defender\IP_Lockout\Model\Log_Model::AUTH_FAIL, WD_Utils::http_get( 'filter' ) ) ?>
						value="<?php echo \WP_Defender\IP_Lockout\Model\Log_Model::AUTH_FAIL ?>">
						<?php esc_html_e( "Failed login attempts", wp_defender()->domain ) ?></option>
					<option <?php selected( \WP_Defender\IP_Lockout\Model\Log_Model::AUTH_LOCK, WD_Utils::http_get( 'filter' ) ) ?>
						value="<?php echo \WP_Defender\IP_Lockout\Model\Log_Model::AUTH_LOCK ?>"><?php esc_html_e( "Login lockout", wp_defender()->domain ) ?></option>
					<option <?php selected( \WP_Defender\IP_Lockout\Model\Log_Model::ERROR_404, WD_Utils::http_get( 'filter' ) ) ?>
						value="<?php echo \WP_Defender\IP_Lockout\Model\Log_Model::ERROR_404 ?>"><?php esc_html_e( "404 error", wp_defender()->domain ) ?></option>
					<option <?php selected( \WP_Defender\IP_Lockout\Model\Log_Model::LOCKOUT_404, WD_Utils::http_get( 'filter' ) ) ?>
						value="<?php echo \WP_Defender\IP_Lockout\Model\Log_Model::LOCKOUT_404 ?>"><?php esc_html_e( "404 lockout", wp_defender()->domain ) ?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="box-content">
		<?php
		$table = new \WP_Defender\IP_Lockout\Component\Logs_Table();
		$table->prepare_items();
		$table->display();
		?>
	</div>
</div>