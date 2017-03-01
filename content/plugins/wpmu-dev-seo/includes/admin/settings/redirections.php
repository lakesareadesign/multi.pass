<?php

class WDS_Settings_Redirections extends WDS_Settings_Admin {


	private static $_instance;

	public static function get_instance () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function validate ($input) {
		$urls = !empty($input['urls']) && is_array($input['urls'])
			? $input['urls']
			: array()
		;
		$bulk_action = !empty($input['bulk_action']) && in_array($input['bulk_action'], array('delete', 'redirect_301', 'redirect_302'))
			? $input['bulk_action']
			: false
		;
		$bulk = array();
		if (!empty($bulk_action)) {
			$bulk = !empty($input['bulk']) && is_array($input['bulk'])
				? $input['bulk']
				: array()
			;
		}
		$types = !empty($input['types']) && is_array($input['types'])
			? $input['types']
			: array()
		;
		$rmodel = new WDS_Model_Redirection;

		$raw = $rmodel->get_all_redirections();
		$rtypes = $rmodel->get_all_redirection_types();
		foreach ($urls as $source => $redir) {
			$source = esc_url($source);
			if ('delete' === $bulk_action) {
				if (in_array($source, $bulk)) {
					if (!empty($raw[$source])) unset($raw[$source]);
					if (!empty($type[$source])) unset($rtypes[$source]);
					continue;
				}
			}
			$raw[$source] = esc_url($redir);
		}
		$rmodel->set_all_redirections($raw);
		if ('delete' === $bulk_action) $rmodel->set_all_redirection_types($rtypes);

		if (in_array($bulk_action, array('redirect_301', 'redirect_302'))) {
			$new_status = 'redirect_301' === $bulk_action
				? WDS_Model_Redirection::TYPE_301
				: WDS_Model_Redirection::TYPE_302
			;
			$default_status = $rmodel->get_default_redirection_status_type();
			$raw = $rmodel->get_all_redirection_types();
			foreach ($urls as $source => $redir) {
				$source = esc_url($source);
				$old_status = !empty($raw[$source])
					? $raw[$source]
					: $default_status
				;
				$raw[$source] = in_array($source, $bulk)
					? $new_status
					: $rmodel->get_valid_redirection_status_type($old_status)
				;
			}

			$rmodel->set_all_redirection_types($raw);
		} else {
			$new_types = array();
			foreach ($types as $source => $redir) {
				if (!empty($bulk_action) && !empty($bulk) && in_array($source, $bulk)) continue;
				$status = $rmodel->get_valid_redirection_status_type($redir);
				if (empty($status)) continue;
				$source = esc_url($source);
				$new_types[$source] = $status;
			}
			$rmodel->set_all_redirection_types($new_types);
		}

		return $result;
	}

	public function init () {
		$this->option_name = 'wds_redirections_options';
		$this->name        = 'redirections';
		$this->slug        = WDS_Settings::TAB_REDIRECTIONS;
		$this->action_url  = admin_url( 'options.php' );
		$this->title       = __( 'Redirections', 'wds' );
		$this->page_title  = __( 'SmartCrawl Wizard: Redirections', 'wds' );

		parent::init();
	}

	public function options_page () {
		$rmodel = new WDS_Model_Redirection;
		$arguments = array(
			'redirections' => $rmodel->get_all_redirections(),
			'types' => $rmodel->get_all_redirection_types(),
		);
		wp_enqueue_script('wds-admin-redirections');
		$this->_render_page('redirections-settings', $arguments);
	}

	public function defaults () {
		if ( empty($this->options['redirections-code']) ) {
			$this->options['redirections-code'] = 301;
		}

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

}