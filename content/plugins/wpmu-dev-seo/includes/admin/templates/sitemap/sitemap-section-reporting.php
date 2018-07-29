<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SEO );
$cron = Smartcrawl_Controller_Cron::get();
$option_name = $_view['option_name'];

// This does the actual rescheduling
$cron->set_up_schedule();
$crawler_cron_enabled = $_view['options']['crawler-cron-enable'];
$toggle_field_name = $option_name . '[crawler-cron-enable]';
?>

<?php if ( ! $service->is_member() ) : ?>
	<div class="wds-obfuscate-section"></div>
<?php endif; ?>

<div class="wds-table-fields wds-toggleable">
	<div class="label">
		<label class="wds-label"
		       for="<?php echo esc_attr( $toggle_field_name ); ?>">

			<?php esc_html_e( 'Schedule Crawl', 'wds' ); ?>
		</label>
	</div>
	<div class="fields wds-toggleable <?php echo $crawler_cron_enabled ? '' : 'inactive'; ?>">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name' => $toggle_field_name,
			'field_id'   => $toggle_field_name,
			'checked'    => checked( $crawler_cron_enabled, true, false ),
			'item_label' => esc_html__( 'Run regular URL crawls', 'wds' ),
		) );
		?>
		<div class="wds-toggleable-inside wds-toggleable-inside-box">
			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="wds-crawler-frequency"
					       class="wds-label"><?php esc_html_e( 'Frequency', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<select class="select-container wds-conditional-parent"
					        id="wds-crawler-frequency"
					        name="<?php echo esc_attr( $_view['option_name'] ); ?>[crawler-frequency]"
					        style="width: 100%">

						<?php foreach ( $cron->get_frequencies() as $key => $label ) : ?>
							<option
								value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $_view['options']['crawler-frequency'] ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked wds-conditional-child"
			     data-parent="wds-crawler-frequency"
			     data-parent-val="weekly,monthly">

				<div class="label">
					<label for="wds-crawler-dow"
					       class="wds-label"><?php esc_html_e( 'Day of the week', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<select class="select-container"
					        id="wds-crawler-dow"
					        name="<?php echo esc_attr( $_view['option_name'] ); ?>[crawler-dow]"
					        style="width: 100%">

						<?php $monday = strtotime( 'this Monday' ); ?>
						<?php foreach ( range( 0, 6 ) as $dow ) : ?>
							<option value="<?php echo esc_attr( $dow ); ?>"
								<?php selected( $dow, $_view['options']['crawler-dow'] ); ?>>
								<?php echo esc_html( date_i18n( 'l', $monday + ( $dow * DAY_IN_SECONDS ) ) ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="wds-crawler-tod" class="wds-label"><?php esc_html_e( 'Time of day', 'wds' ); ?></label>
				</div>
				<div class="fields">
					<select class="select-container"
					        id="wds-crawler-tod"
					        name="<?php echo esc_attr( $_view['option_name'] ); ?>[crawler-tod]"
					        style="width: 100%">

						<?php $midnight = strtotime( 'today' ); ?>
						<?php foreach ( range( 0, 23 ) as $tod ) : ?>
							<option value="<?php echo esc_attr( $tod ); ?>"
								<?php selected( $tod, $_view['options']['crawler-tod'] ); ?>>
								<?php echo esc_html( date_i18n( get_option( 'time_format' ), $midnight + ( $tod * HOUR_IN_SECONDS ) ) ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
	</div>

</div>