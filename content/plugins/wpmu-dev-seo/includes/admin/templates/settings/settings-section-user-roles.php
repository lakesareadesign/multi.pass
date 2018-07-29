<?php
$seo_metabox_permission_level = empty( $seo_metabox_permission_level ) ? array() : $seo_metabox_permission_level;
$seo_metabox_301_permission_level = empty( $seo_metabox_301_permission_level ) ? array() : $seo_metabox_301_permission_level;
$urlmetrics_metabox_permission_level = empty( $urlmetrics_metabox_permission_level ) ? array() : $urlmetrics_metabox_permission_level;
$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
?>
<input type="hidden" name="<?php echo esc_attr( $option_name ); ?>[saving_user_roles]" value="1"/>
<div class="wds-table-fields">
	<div class="label">
		<label class="wds-label"><?php esc_html_e( 'Access', 'wds' ); ?></label>
	</div>
	<div class="fields">
		<div>
			<label for="seo_metabox_permission_level"
			       class="wds-label"><?php esc_html_e( 'In page SEO meta box', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Choose what user level you want to be able to edit individual post and page meta tags.', 'wds' ); ?></p>

			<select id="seo_metabox_permission_level"
			        name="<?php echo esc_attr( $option_name ); ?>[seo_metabox_permission_level][]"
			        class="select-container"
			        style="width: 100%;">
				<?php foreach ( $seo_metabox_permission_level as $item => $label ) : ?>
					<?php
					$selected = ! empty( $_view['options']['seo_metabox_permission_level'] ) && is_array( $_view['options']['seo_metabox_permission_level'] )
						? ( in_array( $item, $_view['options']['seo_metabox_permission_level'], true ) ? "selected" : '' ) // New
						: ( $_view['options']['seo_metabox_permission_level'] === $item ? "selected" : '' );
					?>
					<option
						<?php echo esc_attr( $selected ); ?>
						value="<?php echo esc_attr( $item ); ?>">
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="wds-separator-top">
			<label for="seo_metabox_301_permission_level"
			       class="wds-label"><?php esc_html_e( '301 Redirections', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Choose what user level has the ability to add 301 redirects to individual posts and pages.', 'wds' ); ?></p>

			<select id="seo_metabox_301_permission_level"
			        name="<?php echo esc_attr( $option_name ); ?>[seo_metabox_301_permission_level][]"
			        class="select-container"
			        style="width: 100%;">
				<?php foreach ( $seo_metabox_301_permission_level as $item => $label ) { ?>
					<?php
					$selected = ! empty( $_view['options']['seo_metabox_301_permission_level'] ) && is_array( $_view['options']['seo_metabox_301_permission_level'] )
						? ( in_array( $item, $_view['options']['seo_metabox_301_permission_level'], true ) ? "selected" : '' ) // New
						: ( $_view['options']['seo_metabox_301_permission_level'] === $item ? "selected" : '' );
					?>
					<option
						<?php echo esc_attr( $selected ); ?>
						value="<?php echo esc_attr( $item ); ?>">
						<?php echo esc_html( $label ); ?>
					</option>
				<?php } ?>
			</select>
		</div>

		<div class="wds-separator-top">
			<label for="urlmetrics_metabox_permission_level"
			       class="wds-label"><?php esc_html_e( 'Show Moz data to roles', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Choose what user level gets to view the Moz data.', 'wds' ); ?></p>

			<select id="urlmetrics_metabox_permission_level"
			        name="<?php echo esc_attr( $option_name ); ?>[urlmetrics_metabox_permission_level][]"
			        class="select-container"
			        style="width: 100%;">
				<?php foreach ( $urlmetrics_metabox_permission_level as $item => $label ) : ?>
					<?php
					$selected = ! empty( $_view['options']['urlmetrics_metabox_permission_level'] ) && is_array( $_view['options']['urlmetrics_metabox_permission_level'] )
						? ( in_array( $item, $_view['options']['urlmetrics_metabox_permission_level'], true ) ? "selected" : '' ) // New
						: ( $_view['options']['urlmetrics_metabox_permission_level'] === $item ? "selected" : '' );
					?>
					<option
						<?php echo esc_attr( $selected ); ?>
						value="<?php echo esc_attr( $item ); ?>">
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
</div>