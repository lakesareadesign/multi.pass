<?php

class Snapshot_Model_Queue_Fileset extends Snapshot_Model_Queue {

	private $_current;

	public function get_type () { return 'fileset'; }

	public function get_root () {
		if (!($this->_current instanceof Snapshot_Model_Fileset)) return false;
		return $this->_current->get_site_root();
	}

	public function get_files () {
		$chunk_size = $this->get_chunk_size();
		$chunk = 0;
		$result = array();

		$src = $this->_get_next_source();
		if (empty($src)) return $result;

		$info = $this->_get_source_info($src);

		if (!empty($info['chunk'])) $chunk = (int)$info['chunk'];
		$source = Snapshot_Model_Fileset::get_source($src);

		$this->_current = $source;

		$start = $chunk * $chunk_size;
		$all_files = $source->get_files();
		$files = array_slice($all_files, $start, $chunk_size);

		$info['chunk'] = $chunk + 1;
		if ($start + $chunk_size >= count($all_files)) $info['done'] = true;
		$this->_update_source($src, $info);

		Snapshot_Helper_Log::note("Fetching [" . count($files) . "] files as chunk {$info['chunk']}", "Queue");

		return $files;
	}

	public function add_source ($src) {
		if (!Snapshot_Model_Fileset::is_source($src)) return false;
		return parent::add_source($src);
	}

	/**
	 * Gets total steps for this queue
	 *
	 * Can potentially take quite a bit of time to run
	 *
	 * @return int
	 */
	public function get_total_steps () {
		$size = 0;
		$sources = $this->get_sources();
		if (empty($sources)) return $size;

		foreach ($sources as $src) {
			$source = Snapshot_Model_Fileset::get_source($src);
			if (!$source) continue;
			$size += $source->get_items_count();
		}

		if ($size > 0) {
			$steps = $size / $this->get_chunk_size();
			$size = ($steps < (int)$steps)
				? (int)$steps + 1
				: (int)$steps
			;
		}

		return $size;
	}

	public function get_chunk_size () {
		return 250;
	}

	public function get_prefix () {
		return 'www';
	}
}