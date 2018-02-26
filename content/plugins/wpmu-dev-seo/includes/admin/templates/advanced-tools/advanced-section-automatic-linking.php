<?php
	$insert = empty( $insert ) ? array() : $insert;
	$linkto = empty( $linkto ) ? array() : $linkto;
?>

<div class="wds-automatic-linking">
	<div class="cf">
		<div class="wds-automatic-linking-insert-links">
			<?php
				$this->_render('toggle-group', array(
					'label'       => __( 'Insert Links', 'wds' ),
					'description' => __( 'Specify what post types to insert links into.', 'wds' ),
					'items'       => $insert,
				));
			?>
		</div>

		<div class="wds-automatic-linking-link-to">
			<?php
				$this->_render('toggle-group', array(
					'label'       => __( 'Link to', 'wds' ),
					'description' => __( 'Choose content you want to convert to links.', 'wds' ),
					'items'       => $linkto,
				));
			?>
		</div>
	</div>

	<div class="wds-table-fields wds-separator-top">
		<label class="wds-label"><?php _e( 'Custom keywords', 'wds' ); ?></label>
		<p class="wds-label-description"><?php _e( 'Choose additional keywords you want to auto-link and tell SmartCrawl where to link to. Add as many as you like.', 'wds' ); ?></p>
	</div>

	<div class="box-autolinks-custom-keywords-settings">
		<div class="wds-replaceable">
			<div class="group wds-group wds-group-field">
				<label for="customkey" class="wds-label"><?php esc_html_e( 'Custom Keywords' , 'wds' ); ?></label>
				<textarea id='customkey' name='<?php echo esc_attr( $_view['option_name'] ); ?>[customkey]' class='wds-textarea'><?php
					echo esc_textarea( $_view['options']['customkey'] );
				?></textarea>
			</div>
		</div>
	</div>

	<div class="wds-table-fields wds-separator-top">
		<label for="ignore" class="wds-label"><?php esc_html_e( 'Exclusions' , 'wds' ); ?></label>
		<p class="wds-label-description"><?php esc_html_e( 'Provide a comma-separated list of keywords that you would like to exclude. You can also select individual posts for exclusion.' , 'wds' ); ?></p>
		<input id='ignore' name='<?php echo esc_attr( $_view['option_name'] ); ?>[ignore]' size='' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['ignore'] ); ?>'>
	</div>
	<div class="group wds-group wds-group-field">
		<div class="wds-replaceable">
			<label for="ignorepost" class="wds-label"><?php esc_html_e( 'Exclude Posts, Pages & CPTs' , 'wds' ); ?></label>
			<input id='ignorepost' name='<?php echo esc_attr( $_view['option_name'] ); ?>[ignorepost]' size='' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['ignorepost'] ); ?>'>
			<span class="wds-field-legend"><?php esc_html_e( 'Paste in the IDs, slugs or titles for the post/pages you wish to exclude and separate them by commas' , 'wds' ); ?></span>
		</div>
	</div>
</div>