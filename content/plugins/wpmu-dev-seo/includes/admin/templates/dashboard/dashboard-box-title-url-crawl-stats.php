<?php
	$report = empty($report) ? null : $report;

	if (is_null($report)) {
		return;
	}

	$active_issues = $report->get_issues_count();
?>

<?php if ($active_issues > 0): ?>
    <span class="wds-issues wds-issues-warning wds-has-tooltip"
          data-content="<?php printf(__('You have %s sitemap issues', 'wds'), $active_issues); ?>">

        <?php echo $active_issues; ?>
    </span>
<?php endif; ?>