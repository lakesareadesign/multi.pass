<?php
	$post_types = empty($post_types) ? array() : $post_types;
	$taxonomies = empty($taxonomies) ? array() : $taxonomies;
	$wds_buddypress = empty($wds_buddypress) ? array() : $wds_buddypress;
	$option_name = empty($_view['option_name']) ? '' : $_view['option_name'];
	$extra_urls = empty($extra_urls) ? '' : $extra_urls;
?>


<?php if (WDS_XML_Sitemap::is_sitemap_path_writable()) { ?>
	<div class="wds-notice wds-notice-success">
		<p>
			<?php
				printf(
					__('Your sitemap is available at %s', 'wds'),
					sprintf('<a target="_blank" href="%s">/sitemap.xml</a>', esc_attr(wds_get_sitemap_url()))
				);
			?>
		</p>
	</div>
<?php } else { ?>
	<div class="wds-notice wds-notice-error">
		<p>
			<?php
				printf(
					__('Unable to write to sitemap file: <code>%s</code>', 'wds'),
					esc_html(wds_get_sitemap_path())
				);
			?>
		</p>
	</div>
<?php } ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields wds-separator-top">
		<div class="label">
			<label class="wds-label"><?php _e( 'Include' , 'wds' ); ?></label>
			<span class="wds-label-description">
				<?php _e('Choose which post types, archives and taxonomies you wish to include in your sitemap.', 'wds'); ?>
			</span>
		</div>
		<div class="fields">
			<div class="wds-sitemap-parts">
				<?php foreach ($post_types as $item => $post_type): ?>
					<?php
						$this->_render('sitemap/sitemap-part', array(
							'item'        => $item,
							'item_name'   => $post_type->name,
							'item_label'  => $post_type->label,
							'inverted'    => true,
							'option_name' => $option_name . '[exclude_post_types][]'
						));
					?>
				<?php endforeach; ?>

				<?php foreach ($taxonomies as $item => $taxonomy): ?>
					<?php
						$this->_render('sitemap/sitemap-part', array(
							'item'        => $item,
							'item_name'   => $taxonomy->name,
							'item_label'  => $taxonomy->label,
							'inverted'    => true,
							'option_name' => $option_name . '[exclude_taxonomies][]'
						));
					?>
				<?php endforeach; ?>

				<?php
					if ($wds_buddypress) {
						$this->_render('sitemap/sitemap-buddypress-settings', $wds_buddypress);
					}
				?>

			</div>
		</div>
	</div>

	<div class="wds-table-fields wds-separator-top">
		<div class="label">
			<label for="<?php echo $option_name; ?>[extra_sitemap_urls]" class="wds-label"><?php _e('Extra URLs', 'wds'); ?></label>
			<span class="wds-label-description">
				<?php esc_html_e("Enter any additional URLs that aren't part of your default pages, posts or custom post types.", 'wds'); ?>
			</span>
		</div>

		<div class="fields">
			<textarea id="<?php echo $option_name; ?>[extra_sitemap_urls]"
					  name="<?php echo $option_name; ?>[extra_sitemap_urls]"><?php echo esc_textarea($extra_urls); ?></textarea>
			<span class="wds-field-legend">
				<?php esc_html_e('Enter one URL per line', 'wds'); ?>
			</span>
		</div>
	</div>
</div>