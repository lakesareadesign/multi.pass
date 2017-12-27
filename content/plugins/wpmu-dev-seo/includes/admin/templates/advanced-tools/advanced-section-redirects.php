<?php
	$redirections = empty($redirections) ? array() : $redirections;
	$types = empty($types) ? array() : $types;
	$option_name = empty($_view['option_name']) ? '' : $_view['option_name'];
	$plugin_settings = WDS_Settings::get_specific_options('wds_settings_options');
?>

<div class="wds-redirect-attachments wds-separator-top">
<?php
	$this->_render('toggle-group', array(
		'label'       => __('Redirect attachments', 'wds'),
		'description' => __('Redirect attachments to their parent post, preventing them from appearing in SERPs.', 'wds'),
		'items'       => array(
			'redirect-attachments' => __('Redirect attachments', 'wds'),
			'redirect-attachments-images_only'    => __('... but only if the attachment is image', 'wds'),
		)
	));
?>
</div>

<div class="wds-table-fields wds-separator-top">
    <div class="label">
        <label class="wds-label" for="wds-default-redirection-type">
			<?php esc_html_e('Default Redirection Type', 'wds'); ?>
        </label>
        <p class="wds-label-description">
			<?php esc_html_e('Select the redirection type that you would like to be used as default.', 'wds'); ?>
        </p>
    </div>
    <div class="fields">
        <select id="wds-default-redirection-type"
                name="<?php echo esc_attr($option_name); ?>[redirections-code]"
                autocomplete="off"
                class="select-container"
                style="width: 100%">
			<?php foreach (array(301 => __('Permanent (301)', 'wds'), 302 => __('Temporary (302)', 'wds')) as $redirection_type => $redirection_type_label): ?>
				<?php
                    $current_redirection_code = wds_get_array_value($plugin_settings, 'redirections-code');
                    $selected = selected($redirection_type, $current_redirection_code, false);
				?>

                <option value="<?php echo esc_attr($redirection_type); ?>" <?php echo $selected; ?>>
					<?php echo esc_html($redirection_type_label); ?>
                </option>
			<?php endforeach; ?>
        </select>
    </div>
</div>

<input type="hidden" value="1" name="<?php echo esc_attr($option_name); ?>[save_redirects]" />
<div class="wds-redirects wds-separator-top">
    <label class="wds-label"><?php esc_html_e('Redirects', 'wds'); ?></label>
    <p class="wds-small-text">
        <?php esc_html_e('Adding entries here will set up a redirect from one URL to another.', 'wds'); ?>
    </p>
    <p class="wds-small-text">
		<?php esc_html_e('Formats include relative (E.g. /cats) or absolute URLs (E.g. www.website.com/cats or https://website.com/cats).', 'wds'); ?>
    </p>
	<div class="wds-redirects-buttons-top">
		<button class="wds-bulk-update button button-small button-dark"><?php esc_html_e('Bulk Update', 'wds'); ?></button>
		<button class="wds-bulk-remove button button-small button-dark-o"><?php esc_html_e('Remove Redirects', 'wds'); ?></button>
	</div>
    <div class="wds-notice wds-notice-warning wds-redirects-unsaved-notice">
		<p><?php esc_html_e("You've made changes to your Sitemap structure. You need to save the changes to make them live.", 'wds'); ?></p>
    </div>
	<table class="wds-redirects-table wds-list-table">
		<thead>
			<tr>
				<th class="selector"><input type="checkbox" class="wds-checkbox" autocomplete="off" title=""/></th>
				<th class="source"><?php esc_html_e('Old URL', 'wds'); ?></th>
				<th class="destination"><?php esc_html_e('New URL', 'wds'); ?></th>
				<th class="type" colspan="2"><?php esc_html_e('Redirect Type', 'wds'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$redirection_index = 0;
			?>
			<?php foreach ($redirections as $source => $destination): ?>
				<?php
					$type = !empty($types[ $source ]) ? $types[ $source ] : '';

					$this->_render('advanced-tools/advanced-tools-redirect-item', array(
						'source'                   => esc_attr($source),
						'destination'              => esc_attr($destination),
						'index'                    => esc_attr($redirection_index),
						'string_permanent'         => esc_html__('Permanent (301)', 'wds'),
						'string_temporary'         => esc_html__('Temporary (302)', 'wds'),
						'string_options'           => esc_html__('Options', 'wds'),
						'string_remove'            => esc_html__('Remove', 'wds'),
						'maybe_permanent_selected' => selected($type, 301, false),
						'maybe_temporary_selected' => selected($type, 302, false)
					));
				?>
				<?php $redirection_index++; ?>
			<?php endforeach; ?>
		</tbody>
        <tfoot>
            <tr class="wds-redirects-buttons-bottom">
                <td colspan="5">
                    <button class="wds-add-redirect button button-dark"><?php esc_html_e('Add New', 'wds'); ?></button>
                </td>
            </tr>
        </tfoot>
	</table>
</div>