<?php

	$type = empty($type) ? '' : $type;
	$report = empty($report) ? null : $report;
	$issue_id = empty($issue_id) ? null : $issue_id;

	if (!$report || !$type || !$issue_id) {
		return;
	}

	$issue = $report->get_issue($issue_id);
	$url = !empty($issue['path']) ? $issue['path'] : '';
	$path = preg_replace('/' . preg_quote(home_url(), '/') . '/', '', $url);
?>

<tr data-issue-id="<?php echo esc_attr($issue_id); ?>" data-path="<?php echo esc_url($url); ?>">
	<td>
		<a href="<?php echo esc_attr($url); ?>">
			<?php echo esc_html($path); ?>
		</a>
	</td>
	<td>
		<?php
			$this->_render('links-dropdown', array(
				'label' => esc_html__('Options', 'wds'),
				'links' => array(
					'#add-to-sitemap' => esc_html__('Add to Sitemap', 'wds'),
					'#ignore'         => esc_html__('Ignore', 'wds')
				)
			));
		?>
	</td>
</tr>