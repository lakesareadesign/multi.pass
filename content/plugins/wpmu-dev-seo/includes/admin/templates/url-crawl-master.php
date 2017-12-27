<?php
	$ready_template = empty($ready_template) ? '' : $ready_template;
	$ready_args = empty($ready_args) ? array() : $ready_args;

	$no_data_template = empty($no_data_template) ? '' : $no_data_template;
	$no_data_args = empty($no_data_args) ? array() : $no_data_args;

	$progress_template = empty($progress_template) ? '' : $progress_template;
	$progress_args = empty($progress_args) ? array() : $progress_args;

	/**
	 * @var WDS_Seo_Service $service
	 */
	$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
	$crawl_status = '';
	$percentage = -1;

	// Check the local DB for results first
	$result = $service->get_result();

	// Results are available in the DB so we can show the report
	if (!empty($result)) {

		$crawl_status = 'report-ready';

	} else {

		// Results are not available in the DB. Check status of the remote crawl.
		$status = $service->status();

		if (!empty($status['end'])) {

			// The crawl has ended but the data is not cached in the DB yet. Get it from remote.
			$result = $service->result();
			$crawl_status = 'report-ready';

		} elseif ($status && empty($status['end'])) {

			// The URL crawl was started and is in progress at the moment.
			$crawl_status = 'in-progress';
			$percentage = empty($status['percentage']) ? 0 : $status['percentage'];

		} else if (empty($status['start'])) {

			// The URL crawl was never started so there is nothing to do.
			$crawl_status = 'no-data';

		}
	}

	switch ($crawl_status) {
		case 'report-ready':
			if (!class_exists('WDS_SeoReport')) {
				require_once(WDS_PLUGIN_DIR . 'core/class_wds_seo_report.php');
			}

			$report = WDS_SeoReport::build($result);

			if ($ready_template) {
				$this->_render($ready_template, array_merge(
					array('report' => $report),
					$ready_args
				));
			}
			break;

		case 'no-data':
			if ($no_data_template) {
				$this->_render($no_data_template, $no_data_args);
			}
			break;

		case 'in-progress':
			if ($progress_template) {
				$this->_render($progress_template, array_merge(
					array('progress' => $percentage),
					$progress_args
				));
			}
			break;
	}