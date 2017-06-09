<?php

class HubControllerTest extends WP_UnitTestCase {

	function setUp () {
		require_once(WDS_PLUGIN_DIR . 'core/class_wds_controller_hub.php');
	}

	function test_exists () {
		$this->assertTrue(
			class_exists('WDS_Controller_Hub'),
			'We have the hub controller class'
		);
	}

	function test_runs () {
		$hub = WDS_Controller_Hub::get();
		$this->assertTrue(
			$hub instanceof WDS_Controller_Hub,
			"Hub getting returns proper instance"
		);

		$status = $hub->is_running();
		if (empty($status)) {
			$status = WDS_Controller_Hub::serve();
			$this->assertTrue(
				$status,
				"Hub successfully booted"
			);
		}
		$this->assertTrue(
			$hub->is_running(),
			"Hub is running"
		);
	}

	function test_binding () {
		$hub = WDS_Controller_Hub::get();
		if (!$hub->is_running()) WDS_Controller_Hub::serve();

		$expect_empty = $hub->register_hub_actions(false);
		$this->assertFalse(
			$expect_empty,
			"Non-array hub actions aren't being processed"
		);

		$actions = $hub->register_hub_actions(array());
		$this->assertTrue(
			is_array($actions),
			"Proper argument populates actions"
		);
		$this->assertTrue(
			!empty($actions),
			"Actions are properly bound"
		);

		$compare = apply_filters('wdp_register_hub_action', array());
		$this->assertEquals(
			$actions, $compare,
			"Filtered interface works"
		);
	}

	function test_sync_purge () {
		$hub = WDS_Controller_Hub::get();

		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		$issue_ids = array_map('strtolower', range(295, 300));
		$status = $hub->sync_ignores_list(array(
			'issue_ids' => $issue_ids,
		));
		$this->assertTrue(
			$status,
			"Properly added new issues"
		);

		$ignores->load();
		$control = $ignores->get_all();
		$this->assertEquals(
			$issue_ids, $control,
			"Issues stored as they should be"
		);

		$status = $hub->purge_ignores_list();
		$this->assertTrue(
			$status,
			"Hub properly purges issues"
		);

		$ignores->load();
		$control = $ignores->get_all();
		$this->assertEmpty(
			$control,
			"Issues properly purged"
		);


	}

	function test_additional_items () {
		$hub = WDS_Controller_Hub::get();
		$extra_urls = array(
			'http://111.com',
			'http://222.com',
			'http://333.com',
			'http://444.com',
		);

		$status = $hub->sync_extras_list(array(
			'urls' => $extra_urls
		));
		$this->assertTrue(
			$status,
			"Extra URLs addition appears to be fine"
		);
		$this->assertEquals(
			$extra_urls, WDS_XML_Sitemap::get_extra_urls(),
			"Extra items addition went fine"
		);

		$status = $hub->purge_extras_list();
		$this->assertTrue(
			$status,
			"Extra URLs purgning appeared to go fine"
		);
		$this->assertEmpty(
			WDS_XML_Sitemap::get_extra_urls(),
			"Extra URLs purgning went fine"
		);
	}
}