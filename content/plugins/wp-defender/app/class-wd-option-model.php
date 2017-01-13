<?php

/**
 * Author: Hoang Ngo
 */
class WD_Option_Model extends WD_Model {
	public $id;

	public function __construct() {
		if ( WD_Utils::is_plugin_network_activated() ) {
			$data = get_network_option( 1, $this->id );
		} else {
			$data = get_option( $this->id );
		}
		$this->before_load();
		$this->import( $data );
		$this->after_load();
	}

	protected function before_load() {

	}

	protected function after_load() {

	}

	public function save() {
		$this->before_update();
		$data = $this->export();
		//no need autoload
		if ( WD_Utils::is_plugin_network_activated() ) {
			update_network_option( 1, $this->id, $data );
		} else {
			update_option( $this->id, $data, false );
		}
	}

	public function delete() {
		delete_option( $this->id );
	}
}